<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up(): void
{
    Schema::table('pemesanan', function (Blueprint $table) {
        // Hapus kolom-kolom lama yang sudah tidak dipakai
        if (Schema::hasColumn('pemesanan', 'kelas_penerbangan_id')) {
            $table->dropForeign(['kelas_penerbangan_id']);
            $table->dropColumn('kelas_penerbangan_id');
        }
        $table->dropColumn([
            'waktu_pemesanan',
            'status',
            'nama_penumpang',
            'nomor_identitas',
            'tanggal_lahir',
            'jenis_kelamin'
        ]);

        // Tambahkan kolom-kolom baru yang dibutuhkan oleh controller
        $table->foreignId('penerbangan_id')->after('user_id')->constrained('penerbangan');
        $table->string('kode_booking')->unique()->after('penerbangan_id');
        $table->string('status_pembayaran')->default('Belum Dibayar')->after('total_harga');
    });
}

    /**
     * Reverse the migrations.
     */
    /**
 * Reverse the migrations.
 */
public function down(): void
{
    Schema::table('pemesanan', function (Blueprint $table) {
        // Hapus kolom baru
        $table->dropForeign(['penerbangan_id']);
        $table->dropColumn(['penerbangan_id', 'kode_booking', 'status_pembayaran']);

        // Tambahkan lagi kolom-kolom lama (jika ingin bisa revert)
        $table->foreignId('kelas_penerbangan_id')->constrained('kelas_penerbangan');
        $table->dateTime('waktu_pemesanan');
        $table->boolean('status');
        $table->string('nama_penumpang');
        $table->string('nomor_identitas');
        $table->date('tanggal_lahir');
        $table->string('jenis_kelamin');
    });
}
};
