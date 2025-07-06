<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penerbangan extends Model
{
    use HasFactory;

    protected $table = 'penerbangan';
    protected $primaryKey = 'id_penerbangan';

    public function maskapai()
    {
        return $this->belongsTo(Maskapai::class, 'id_maskapai');
    }

    public function bandaraAsal()
    {
        return $this->belongsTo(Bandara::class, 'id_bandara_asal');
    }

    public function bandaraTujuan()
    {
        return $this->belongsTo(Bandara::class, 'id_bandara_tujuan');
    }

    public function kelas()
    {
        return $this->hasMany(KelasPenerbangan::class, 'penerbangan_id');
    }
}
