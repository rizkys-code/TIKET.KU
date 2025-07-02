<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('kelas_penerbangan', function (Blueprint $table) {
            $table->engine = 'InnoDB'; // pastikan FK support
            $table->id(); // PK: id
            
            // $table->foreignId('penerbangan_id')
            //       ->constrained('penerbangan')
            //       ->onDelete('cascade');
            $table->unsignedBigInteger('penerbangan_id');
            $table->foreign('penerbangan_id')
            ->references('id_penerbangan')
            ->on('penerbangan')
            ->onDelete('cascade');
            
            $table->string('jenis_kelas', 100);
            $table->decimal('harga', 12, 2);
            $table->integer('kuota_kursi');
            
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('kelas_penerbangan');
    }
};
