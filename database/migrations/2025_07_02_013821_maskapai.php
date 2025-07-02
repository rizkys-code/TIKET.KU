<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('maskapai', function (Blueprint $table) {
            $table->id('id_maskapai');
            $table->string('nama_maskapai', 100);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('maskapai');
    }
};
