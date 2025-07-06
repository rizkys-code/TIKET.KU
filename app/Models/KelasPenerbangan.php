<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KelasPenerbangan extends Model
{
    use HasFactory;

    protected $table = 'kelas_penerbangan';
    protected $fillable = [
        'penerbangan_id',
        'jenis_kelas',
        'harga',
        'kuota_kursi'
    ];

    public function penerbangan()
    {
        
        return $this->belongsTo(Penerbangan::class, 'penerbangan_id');
    }

    public function pemesanan()
    {
        
        return $this->hasMany(Pemesanan::class, 'kelas_penerbangan_id');
    }
}
