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
        Schema::create('pedidikan_non_formal', function (Blueprint $table) {
            $table->uuid('idPendidikanNonFormal')->primary();
            $table->string('lembagaPenyelenggara');
            $table->string('jenisDiklat');
            $table->string('tingkat');
            $table->year('tahunLulus');
            $table->string('sertifikat');
            $table->uuid('idUser');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedidikan_non_formal');
    }
};
