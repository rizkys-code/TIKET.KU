<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('bandara', function (Blueprint $table) {
            $table->id();
            $table->string('kode_bandara', 100);
            $table->string('nama_bandara', 100);
            $table->string('kota', 100);
            $table->string('negara', 100);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('bandara');
    }
};
