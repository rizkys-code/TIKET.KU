<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Pemesanan extends Model
{
    use HasFactory;

    protected $table = 'pemesanan';
    

    protected $fillable = [
        'kelas_penerbangan_id',
        'user_id',
        'waktu_pemesanan',
        'status',
        'total_harga',
        'nama_penumpang',
        'nomor_identitas',
        'tanggal_lahir',
        'jenis_kelamin'
    ];

    public function kelasPenerbangan()
    {

        return $this->belongsTo(KelasPenerbangan::class, 'kelas_penerbangan_id');
    }

    public function user()
    {

        return $this->belongsTo(User::class, 'user_id');
    }

    public function pembayaran()
    {

        return $this->hasOne(Pembayaran::class, 'pemesanan_id');
    }

    public function detailPemesanan()
    {

        return $this->hasOne(DetailPemesanan::class, 'pemesanan_id');
    }
}
