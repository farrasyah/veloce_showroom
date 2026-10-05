<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tabel testimoni yang diisi admin (bukan komentar bebas dari user),
     * ditampilkan di section "Testimoni" pada homepage.
     */
    public function up(): void
    {
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('unit');
            $table->text('quote');
            $table->timestamps();
        });

        // Isi awal dari testimoni yang sebelumnya hardcode di home.blade.php,
        // supaya homepage tidak kosong setelah migrasi.
        DB::table('testimonials')->insert([
            [
                'name' => 'Kamin',
                'unit' => 'Mitsubishi Pajero',
                'quote' => 'Prosesnya cepat dan laporan inspeksinya jelas banget, jadi saya nggak ragu ambil keputusan hari itu juga.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Chiko',
                'unit' => 'Hyundai Palisade',
                'quote' => 'Tim sales-nya nggak maksa, malah bantu bandingin unit mana yang paling cocok sama kebutuhan keluarga saya.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Fadhel',
                'unit' => 'Mazda CX-80',
                'quote' => 'Trade-in mobil lama saya dihitung transparan, dan garansinya bikin tenang buat pemakaian harian.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('testimonials');
    }
};
