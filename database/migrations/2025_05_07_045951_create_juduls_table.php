<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('judul', function (Blueprint $table) {
            $table->id();
            $table->string('judul', '255');
            $table->string('kemampuan', '255');
            $table->enum('status', ['Aktif', 'Nonaktif'])->default('Aktif');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('judul');
    }
};