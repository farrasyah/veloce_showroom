<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TestDriveRequest extends Model
{
    use HasFactory;

    /**
     * Daftar status yang tersedia beserta labelnya.
     */
    public const STATUSES = [
        'pending'   => 'Menunggu',
        'dihubungi' => 'Sudah Dihubungi',
        'selesai'   => 'Selesai',
        'batal'     => 'Dibatalkan',
    ];

    protected $fillable = [
        'user_id',
        'car_id',
        'name',
        'phone',
        'car_interest',
        'preferred_date',
        'status',
    ];

    protected $casts = [
        'preferred_date' => 'date',
    ];

    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return self::STATUSES[$this->status] ?? $this->status;
    }
}
