<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CarController extends Controller
{
    /**
     * Landing page: hero + mobil unggulan + brand.
     */
    public function home()
    {
        $featuredCars = Car::where('is_featured', true)->latest()->take(6)->get();
        $latestCars = Car::latest()->take(8)->get();
        $brands = Car::select('brand')->distinct()->orderBy('brand')->pluck('brand');

        return view('welcome', compact('featuredCars', 'latestCars', 'brands'));
    }

    /**
     * Daftar semua mobil, dengan filter brand, kategori, dan pencarian.
     */
    public function index(Request $request)
    {
        $query = Car::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('brand')) {
            $query->where('brand', $request->brand);
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $sort = $request->get('sort', 'terbaru');
        match ($sort) {
            'harga_asc' => $query->orderBy('price', 'asc'),
            'harga_desc' => $query->orderBy('price', 'desc'),
            'rating' => $query->orderByDesc('rating'),
            default => $query->latest(),
        };

        $cars = $query->paginate(9)->withQueryString();
        $brands = Car::select('brand')->distinct()->orderBy('brand')->pluck('brand');
        $categories = Car::select('category')->distinct()->orderBy('category')->pluck('category');

        return view('cars.index', compact('cars', 'brands', 'categories'));
    }

    /**
     * Detail mobil: spesifikasi, harga, dan review.
     */
    public function show(Car $car)
    {
        $car->load(['comments.user']);

        $relatedCars = Car::where('category', $car->category)
            ->where('id', '!=', $car->id)
            ->take(3)
            ->get();

        return view('cars.show', compact('car', 'relatedCars'));
    }

    /**
     * Form tambah mobil baru.
     */
    public function create()
    {
        return view('cars.create');
    }

    /**
     * Simpan mobil baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $this->validateCar($request);

        $validated['slug'] = $this->uniqueSlug($validated['name']);
        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['pros'] = $this->linesToArray($request->input('pros'));
        $validated['cons'] = $this->linesToArray($request->input('cons'));

        if ($request->hasFile('image')) {
            $validated['image'] = $this->storeImage($request);
        }

        $car = Car::create($validated);

        return redirect()->route('cars.show', $car)->with('status', 'Mobil "' . $car->name . '" berhasil ditambahkan.');
    }

    /**
     * Form edit mobil.
     */
    public function edit(Car $car)
    {
        return view('cars.edit', compact('car'));
    }

    /**
     * Perbarui data mobil.
     */
    public function update(Request $request, Car $car)
    {
        $validated = $this->validateCar($request, $car->id);

        if ($validated['name'] !== $car->name) {
            $validated['slug'] = $this->uniqueSlug($validated['name'], $car->id);
        }

        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['pros'] = $this->linesToArray($request->input('pros'));
        $validated['cons'] = $this->linesToArray($request->input('cons'));

        if ($request->hasFile('image')) {
            $validated['image'] = $this->storeImage($request);
        }

        $car->update($validated);

        return redirect()->route('cars.show', $car)->with('status', 'Data "' . $car->name . '" berhasil diperbarui.');
    }

    /**
     * Hapus mobil.
     */
    public function destroy(Car $car)
    {
        $name = $car->name;
        $car->delete();

        return redirect()->route('cars.index')->with('status', 'Mobil "' . $name . '" telah dihapus.');
    }

    /**
     * Validasi field form tambah/edit mobil.
     */
    private function validateCar(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'required|string|max:100',
            'category' => 'required|string|max:100',
            'year' => 'required|integer|min:1980|max:' . (date('Y') + 1),
            'price' => 'required|numeric|min:0',
            'transmission' => 'required|string|max:50',
            'fuel_type' => 'required|string|max:50',
            'engine_cc' => 'nullable|integer|min:0',
            'seat_capacity' => 'nullable|integer|min:1|max:20',
            'fuel_consumption_kmpl' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
            'rating' => 'nullable|numeric|min:0|max:5',
            'review' => 'nullable|string',
            'image' => 'nullable|image|max:4096',
        ]);
    }

    /**
     * Buat slug unik dari nama mobil.
     */
    private function uniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $base = Str::slug($name);
        $slug = $base;
        $i = 1;

        while (Car::where('slug', $slug)->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $slug = $base . '-' . (++$i);
        }

        return $slug;
    }

    /**
     * Simpan file gambar yang diupload ke public/images/cars.
     */
    private function storeImage(Request $request): string
    {
        $file = $request->file('image');
        $filename = Str::random(12) . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('images/cars'), $filename);

        return $filename;
    }

    /**
     * Ubah textarea (satu baris = satu item) menjadi array untuk kolom JSON.
     */
    private function linesToArray(?string $text): array
    {
        if (blank($text)) {
            return [];
        }

        return collect(explode("\n", $text))
            ->map(fn ($line) => trim($line))
            ->filter()
            ->values()
            ->all();
    }
}
