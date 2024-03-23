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
        Schema::create('riwayat_pekerjaan', function (Blueprint $table) {
            $table->uuid('idRiwayatPekerjaan')->primary();
            $table->string('namaAum');
            $table->string('nomerAum');
            $table->string('namaPenandatangan');
            $table->string('jabatanPenandaTangan');
            $table->string('nomerSK');
            $table->integer('masaKerjaDalamBulan')->default(1);
            $table->date('tanggalSK');
            $table->string('buktiSK');
            $table->uuid('idUser');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_pekerjaan');
    }
};
