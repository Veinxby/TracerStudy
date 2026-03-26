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
        Schema::create('jurusan', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique();
            // ASE, AIS, OAA, DBM, PAA D2
            // SI, AK, BA S1

            $table->string('nama');

            $table->enum('degree', ['D2', 'D3', 'S1']);
            // DEGREE AKHIR JURUSAN

            $table->integer('lama_studi');
            // 2, 3, 4 (tahun normal)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jurusan');
    }
};
