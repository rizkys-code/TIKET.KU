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
    Schema::create('penumpangs', function (Blueprint $table) {
        $table->id();
        // Foreign key yang menyambung ke tabel 'pemesanan'
        $table->foreignId('pemesanan_id')->constrained('pemesanan')->onDelete('cascade');
        $table->string('nama');
        $table->string('nomor_identitas');
        $table->date('tanggal_lahir');
        $table->string('jenis_kelamin');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penumpangs');
    }
};
