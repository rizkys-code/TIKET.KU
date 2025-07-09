<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pemesanan_id')->constrained('pemesanan')->onDelete('cascade');
            $table->string('metode', 255);
            $table->boolean('status_pembayaran')->default(false)->comment('false: belum dibayar, true: sudah dibayar');
            $table->datetime('waktu_pembayaran'); // Diubah ke datetime
            $table->decimal('total_bayar', 12, 2);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('pembayaran');
    }
};
