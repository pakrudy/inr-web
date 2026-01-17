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
        Schema::table('prestasi', function (Blueprint $table) {
            // Add 'expired' to the 'status_prestasi' enum
            $table->enum('status_prestasi', ['aktif', 'tidak aktif', 'expired'])->default('aktif')->change();
            
            // Add 'expired' to the 'payment_status' enum
            $table->enum('payment_status', ['pending', 'paid', 'failed', 'expired'])->default('pending')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('prestasi', function (Blueprint $table) {
            // Revert 'status_prestasi' enum
            $table->enum('status_prestasi', ['aktif', 'tidak aktif'])->default('aktif')->change();

            // Revert 'payment_status' enum
            $table->enum('payment_status', ['pending', 'paid', 'failed'])->default('pending')->change();
        });
    }
};