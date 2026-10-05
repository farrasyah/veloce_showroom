<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Testimonial;
use App\Models\TestDriveRequest;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Tampilkan landing page showroom.
     *
     * Data mobil diambil langsung dari database (tabel cars), jadi begitu
     * admin menambah/mengedit/menghapus mobil lewat "Kelola Mobil",
     * perubahannya langsung tampil di sini juga — untuk semua orang yang
     * membuka halaman ini (admin, user biasa, maupun yang belum login).
     */
    public function index()
    {
        $cars = Car::latest()->take(6)->get();
        $testimonials = Testimonial::latest()->take(3)->get();

        return view('home', compact('cars', 'testimonials'));
    }

    /**
     * Simpan permintaan jadwal test drive dari form kontak ke database.
     * Permintaan ini nantinya dikelola admin lewat halaman
     * "Permintaan Test Drive" (bukan lagi daftar mobil test drive statis).
     */
    public function storeTestDrive(Request $request)
    {
        $validated = $request->validate([
            'name'           => 'required|string|max:255',
            'phone'          => 'required|string|max:30',
            'car_interest'   => 'nullable|string|max:255',
            'preferred_date' => 'nullable|date',
        ]);

        TestDriveRequest::create([
            'user_id'        => optional($request->user())->id,
            'name'           => $validated['name'],
            'phone'          => $validated['phone'],
            'car_interest'   => $validated['car_interest'] ?? null,
            'preferred_date' => $validated['preferred_date'] ?? null,
            'status'         => 'pending',
        ]);

        return back()->with('status', 'Terima kasih! Tim kami akan menghubungi Anda dalam 1x24 jam.');
    }
}
