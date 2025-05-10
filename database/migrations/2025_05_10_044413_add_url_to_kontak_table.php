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
        Schema::table('kontak', function (Blueprint $table) {
            // Add 'url' column to the 'kontak' table
            $table->string('url', 255)->nullable(); // You can set 'nullable' to allow empty URLs
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kontak', function (Blueprint $table) {
            // Drop 'url' column if the migration is rolled back
            $table->dropColumn('url');
        });
    }
};