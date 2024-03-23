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
        Schema::create('pedidikan_formal', function (Blueprint $table) {
            $table->uuid('idPendidikanFormal')->primary();
            $table->string('lembagaPendidikan');
            $table->string('fakultas')->default('-');
            $table->string('jurusanProgStud')->default('-');
            $table->year('tahunLulus');
            $table->string('ijazah');
            $table->uuid('idUser');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedidikan_formal');
    }
};
