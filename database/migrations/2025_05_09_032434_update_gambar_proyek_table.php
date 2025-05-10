<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateGambarProyekTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('gambar_proyek', function (Blueprint $table) {
            // Drop the foreign key constraint
            $table->dropForeign(['proyek_id']); // Make sure to reference the correct foreign key name if it's not 'proyek_id'

            // Change the 'proyek_id' column to a string
            $table->string('proyek_id')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('gambar_proyek', function (Blueprint $table) {
            // Add the foreign key constraint back (in case we need to rollback)
            $table->dropColumn('proyek_id');
            $table->foreignId('proyek_id')->constrained('proyek')->onDelete('cascade');
        });
    }
}