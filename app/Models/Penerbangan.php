<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penerbangan extends Model
{
    use HasFactory;

    protected $table = 'penerbangan';




    public function maskapai()
    {

        return $this->belongsTo(Maskapai::class, 'maskapai_id');
    }

    public function bandaraAsal()
    {

        return $this->belongsTo(Bandara::class, 'bandara_asal_id');
    }

    public function bandaraTujuan()
    {

        return $this->belongsTo(Bandara::class, 'bandara_tujuan_id');
    }

    public function kelas()
    {

        return $this->hasMany(KelasPenerbangan::class, 'penerbangan_id');
    }
}
