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
        Schema::create('tugas_pokok', function (Blueprint $table) {
            $table->uuid('idTugasPokok')->primary();
            $table->string('tugasPokok');
            $table->string('namaAUm');
            $table->string('nomerAum');
            $table->string('namaPenandatangan');
            $table->string('jabatanPenandatangan');
            $table->string('nomerSK');
            $table->date('tanggalSK');
            $table->string('buktisk');
            $table->uuid('idUser');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tugas_pokok');
    }
};
