<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('pemesanan', function (Blueprint $table) {
            $table->id('id_pemesanan');
            $table->foreignId('id_kelas')->constrained('kelas_penerbangan')->onDelete('cascade');
            $table->foreignId('id_user')->constrained('users')->onDelete('cascade');
            $table->date('waktu_pemesanan');
            $table->string('status', 20);
            $table->decimal('total_harga', 12, 2);
            $table->string('nama_penumpang', 100);
            $table->string('nomor_identitas', 100);
            $table->date('tanggal_lahir');
            $table->string('jenis_kelamin', 50);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('pemesanan');
    }
};
