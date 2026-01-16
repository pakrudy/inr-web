<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First, update existing values to 'Belum diterima' to avoid data truncation errors.
        // We assume any existing state that is not 'Diterima' should become 'Belum diterima'.
        DB::table('prestasi')
            ->whereNotIn('status_rekomendasi', ['Diterima', 'Belum diterima'])
            ->update(['status_rekomendasi' => 'Belum diterima']);

        Schema::table('prestasi', function (Blueprint $table) {
            // Change column to ENUM with new values and default
            DB::statement("ALTER TABLE prestasi CHANGE status_rekomendasi status_rekomendasi ENUM('Diterima','Belum diterima') NOT NULL DEFAULT 'Belum diterima'");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('prestasi', function (Blueprint $table) {
            // Revert back to string. We'll lose the ENUM constraints.
            // A simple default is set for the reverted column.
            DB::statement("ALTER TABLE prestasi CHANGE status_rekomendasi status_rekomendasi VARCHAR(255) NOT NULL DEFAULT 'tidak diajukan'");
        });
    }
};
