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
        Schema::create('kerja', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('perusahaan_id')
                ->constrained('perusahaan');

            $table->string('posisi')->nullable();
            $table->enum('tipe_kontrak', ['kontrak', 'tetap', 'phk']);
            $table->date('mulai');
            $table->date('selesai')->nullable();
            $table->enum('status', ['aktif', 'selesai']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kerja');
    }
};
