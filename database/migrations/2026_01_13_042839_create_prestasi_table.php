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
        Schema::create('prestasi', function (Blueprint $table) {
            $table->id('prestasi_id');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('judul_prestasi');
            $table->enum('status_prestasi', ['aktif', 'tidak aktif'])->default('aktif');
            $table->enum('validitas', ['valid', 'belum valid'])->default('belum valid');
            $table->string('nomor_sertifikat_prestasi')->nullable();
            $table->boolean('rekomendasi')->default(false);
            $table->boolean('badge')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prestasi');
    }
};