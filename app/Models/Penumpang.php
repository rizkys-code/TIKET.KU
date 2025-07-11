<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penumpang extends Model
{
    use HasFactory;

    // Daftarkan kolom-kolom tabel 'penumpangs' yang boleh diisi
    protected $fillable = [
        'pemesanan_id',
        'nama',
        'nomor_identitas',
        'tanggal_lahir',
        'jenis_kelamin'
    ];

    /**
     * Definisikan relasi bahwa Penumpang ini milik satu Pemesanan.
     */
    public function pemesanan()
    {
        return $this->belongsTo(Pemesanan::class);
    }
}