<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('penerbangan', function (Blueprint $table) {
            $table->id('id_penerbangan');
            $table->foreignId('id_maskapai')->constrained('maskapai', 'id_maskapai')->onDelete('cascade');
            $table->foreignId('id_bandara_asal')->constrained('bandara', 'id_bandara')->onDelete('cascade');
            $table->foreignId('id_bandara_tujuan')->constrained('bandara', 'id_bandara')->onDelete('cascade');
            $table->date('tanggal_berangkat');
            $table->time('waktu_berangkat');
            $table->time('waktu_tiba');
            $table->integer('durasi');
            $table->timestamps();

        });

    }

    public function down(): void
    {
        Schema::dropIfExists('penerbangan');
    }
};
