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
        Schema::create('aum', function (Blueprint $table) {
            $table->uuid('idAum')->primary();
            $table->string('namaAum');
            $table->string('npsm')->unique(true);
            $table->text('lokasi');
            $table->boolean('izinTambahPegawai')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aum');
    }
};
