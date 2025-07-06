<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bandara extends Model
{
    use HasFactory;

    protected $table = 'bandara';
    protected $primaryKey = 'id_bandara';
    protected $fillable = ['kode_bandara', 'nama_bandara', 'kota', 'negara'];

    public function penerbanganAsal()
    {
        return $this->hasMany(Penerbangan::class, 'id_bandara_asal');
    }

    public function penerbanganTujuan()
    {
        return $this->hasMany(Penerbangan::class, 'id_bandara_tujuan');
    }
}
