<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('penerbangan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('maskapai_id')->constrained('maskapai')->onDelete('cascade');
            $table->foreignId('bandara_asal_id')->constrained('bandara')->onDelete('cascade');
            $table->foreignId('bandara_tujuan_id')->constrained('bandara')->onDelete('cascade');
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
