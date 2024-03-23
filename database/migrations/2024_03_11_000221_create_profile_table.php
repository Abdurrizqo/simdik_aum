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
        Schema::create('profile', function (Blueprint $table) {
            $table->uuid('idProfile')->primary();
            $table->string('namaLengkap');
            $table->string('noKTAM')->default('-');
            $table->string('tempatLahir');
            $table->date('tanggalLahir');
            $table->boolean('isMarried');
            $table->string('nipy')->default('-');
            $table->text('alamat');
            $table->uuid('idAum');
            $table->string('fotoProfile');
            $table->uuid('idUser');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profile');
    }
};
