<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pemesanan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kelas_penerbangan_id')->constrained('kelas_penerbangan')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->datetime('waktu_pemesanan');
            $table->boolean('status')->default(false)->comment('false: belum dibayar, true: sudah dibayar');
            $table->decimal('total_harga', 12, 2);
            $table->string('nama_penumpang', 100);
            $table->string('nomor_identitas', 100);
            $table->date('tanggal_lahir');
            $table->string('jenis_kelamin', 50);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pemesanan');
    }
};
