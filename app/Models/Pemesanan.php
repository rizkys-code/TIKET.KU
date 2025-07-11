<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Pastikan semua model yang direlasikan di-import di sini
use App\Models\User;
use App\Models\Penerbangan;
use App\Models\Penumpang;
use App\Models\Pembayaran;

class Pemesanan extends Model
{
    use HasFactory;

    protected $table = 'pemesanan';

    /**
     * Kolom yang diizinkan untuk diisi secara massal (mass assignable).
     */
    protected $fillable = [
        'user_id',
        'penerbangan_id',
        'kode_booking',
        'total_harga',
        'status_pembayaran',
    ];

    /**
     * Mendefinisikan relasi "belongsTo" ke model User.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Mendefinisikan relasi "belongsTo" ke model Penerbangan.
     */
    public function penerbangan()
    {
        return $this->belongsTo(Penerbangan::class);
    }

    /**
     * Mendefinisikan relasi "hasMany" ke model Penumpang.
     * Ini adalah perbaikannya: "penumpangs()" bukan "penumpan :".
     */
    public function penumpangs()
    {
        return $this->hasMany(Penumpang::class);
    }

    /**
     * Mendefinisikan relasi "hasOne" ke model Pembayaran.
     */
    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class);
    }
}