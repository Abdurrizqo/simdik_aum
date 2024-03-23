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
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('idUser')->primary();
            $table->string('nickname', 100)->unique(true);
            $table->string('username', 100)->unique(true);
            $table->string('password');
            $table->boolean('isProfileDone')->default(false);
            $table->enum('role', ['admin', 'user', 'adminaum']);
            $table->enum('status', [
                'Pegawai Tetap Yayasan',
                'Guru Tetap Yayasan',
                'Pegawai Kontrak Yayasan',
                'Guru Kontrak Yayasan',
                'Guru Honor Sekolah',
                'Tenaga Honor Sekolah', 'Guru Tamu'
            ])->default('Pegawai Tetap Yayasan');
            $table->uuid('idAum')->nullable(true);
            $table->uuid('idProfile')->nullable(true);
            $table->uuid('idTugasPokok')->nullable(true);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
