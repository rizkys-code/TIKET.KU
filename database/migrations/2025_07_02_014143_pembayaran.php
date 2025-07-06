<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id('id_pembayaran');
            // $table->foreignId('id_pemesanan')->constrained('pemesanan')->onDelete('cascade');

            $table->unsignedBigInteger('id_pemesanan');
            $table->foreign('id_pemesanan')
            ->references('id_pemesanan')
            ->on('pemesanan')
            ->onDelete('cascade');
            
            $table->string('metode', 255);
            $table->string('status_pembayaran', 20);
            $table->date('waktu_pembayaran');
            $table->decimal('total_bayar', 12, 2);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('pembayaran');
    }
};
