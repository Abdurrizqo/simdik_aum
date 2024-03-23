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
        Schema::create('tugas_mapel', function (Blueprint $table) {
            $table->uuid('idTugasMapel')->primary();
            $table->string('mapelDiampu');
            $table->integer('totalJamSeminggu');
            $table->uuid('idUser');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tugas_mapel');
    }
};
