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
        Schema::create('proyek', function (Blueprint $table) {
            $table->id();
            $table->string('thumbnail_proyek', '255');
            $table->string('judul_proyek', '255');
            $table->string('jenis_proyek', '255');
            $table->string('teknologi', '255'); //bisa lebih dari 1 seperti ada teknologi 3 dan saya pilih 1, selain itu bisa di tambah selain 3 dengan nama teknoogi baru
            $table->string('detail_proyek', '255');
            $table->string('gambar_proyek', '255'); //bisa lebih dari 1
            $table->enum('status', ['Aktif', 'Nonaktif'])->default('Aktif');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proyek');
    }
};