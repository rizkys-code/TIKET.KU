<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemesanan extends Model
{
    use HasFactory;

    protected $table = 'pemesanan';
    protected $primaryKey = 'id_pemesanan';
    protected $fillable = [
        'id_kelas',
        'id_user',
        'waktu_pemesanan',
        'status',
        'total_harga',
        'nama_penumpang',
        'nomor_identitas',
        'tanggal_lahir',
        'jenis_kelamin'
    ];

    public function kelas()
    {
        return $this->belongsTo(KelasPenerbangan::class, 'id_kelas');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class, 'id_pemesanan');
    }

    public function detail()
    {
        return $this->hasOne(DetailPemesanan::class, 'id_pemesanan');
    }
}
