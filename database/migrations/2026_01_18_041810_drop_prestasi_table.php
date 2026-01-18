<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::dropIfExists('prestasi');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('prestasi', function (Blueprint $table) {
            $table->id('prestasi_id');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('judul_prestasi');
            $table->string('foto_sertifikat')->nullable();
            $table->string('pemberi_rekomendasi')->nullable();
            $table->enum('status_prestasi', ['aktif', 'tidak aktif', 'expired'])->default('aktif');
            $table->enum('validitas', ['valid', 'belum valid'])->default('belum valid');
            $table->string('nomor_sertifikat_prestasi')->nullable();
            $table->boolean('rekomendasi')->default(false);
            $table->boolean('badge')->default(false);
            $table->enum('status_rekomendasi', ['Diterima', 'Belum diterima'])->default('Belum diterima');
            $table->enum('payment_status', ['pending', 'paid', 'failed', 'expired'])->default('pending');
            $table->timestamp('expired_at')->nullable();
            $table->timestamps();
        });
    }
};
