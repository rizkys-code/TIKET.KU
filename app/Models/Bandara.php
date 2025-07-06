<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bandara extends Model
{
    use HasFactory;

    protected $table = 'bandara';
    
    
    protected $fillable = ['kode_bandara', 'nama_bandara', 'kota', 'negara'];

    public function penerbanganAsal()
    {
        
        return $this->hasMany(Penerbangan::class, 'bandara_asal_id');
    }

    public function penerbanganTujuan()
    {
        
        return $this->hasMany(Penerbangan::class, 'bandara_tujuan_id');
    }
}
