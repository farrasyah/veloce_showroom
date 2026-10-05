<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TestimonialController extends Controller
{
    /**
     * Daftar semua testimoni yang diisi admin.
     */
    public function index(): View
    {
        $testimonials = Testimonial::latest()->paginate(10);

        return view('admin.testimonials.index', compact('testimonials'));
    }

    /**
     * Form tambah testimoni baru.
     */
    public function create(): View
    {
        return view('admin.testimonials.create');
    }

    /**
     * Simpan testimoni baru.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateTestimonial($request);

        Testimonial::create($validated);

        return redirect()->route('admin.testimonials.index')->with('status', 'Testimoni berhasil ditambahkan.');
    }

    /**
     * Form edit testimoni.
     */
    public function edit(Testimonial $testimonial): View
    {
        return view('admin.testimonials.edit', compact('testimonial'));
    }

    /**
     * Perbarui testimoni.
     */
    public function update(Request $request, Testimonial $testimonial): RedirectResponse
    {
        $validated = $this->validateTestimonial($request);

        $testimonial->update($validated);

        return redirect()->route('admin.testimonials.index')->with('status', 'Testimoni berhasil diperbarui.');
    }

    /**
     * Hapus testimoni.
     */
    public function destroy(Testimonial $testimonial): RedirectResponse
    {
        $testimonial->delete();

        return redirect()->route('admin.testimonials.index')->with('status', 'Testimoni berhasil dihapus.');
    }

    private function validateTestimonial(Request $request): array
    {
        return $request->validate([
            'name'  => 'required|string|max:255',
            'unit'  => 'required|string|max:255',
            'quote' => 'required|string|max:1000',
        ]);
    }
}
