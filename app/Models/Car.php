<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Car extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'brand',
        'category',
        'year',
        'price',
        'transmission',
        'fuel_type',
        'engine_cc',
        'seat_capacity',
        'fuel_consumption_kmpl',
        'image',
        'description',
        'rating',
        'review',
        'pros',
        'cons',
        'is_featured',
    ];

    protected $casts = [
        'pros' => 'array',
        'cons' => 'array',
        'is_featured' => 'boolean',
        'price' => 'decimal:2',
        'rating' => 'decimal:1',
    ];

    /**
     * Format harga ke format Rupiah, misal Rp 250.000.000
     */
    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format((float) $this->price, 0, ',', '.');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Komentar-komentar user untuk mobil ini, terbaru lebih dulu.
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class)->latest();
    }

    /**
     * Permintaan test drive yang menyebut mobil ini.
     */
    public function testDriveRequests(): HasMany
    {
        return $this->hasMany(TestDriveRequest::class);
    }
}
