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
        // Add the new 'pending_renewal' status to the ENUM list
        DB::statement("ALTER TABLE recommendations MODIFY COLUMN status ENUM('pending', 'active', 'expired', 'pending_renewal') NOT NULL DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert the ENUM list to its original state
        // This assumes no recommendations are currently in the 'pending_renewal' state.
        // A safer down migration would first update any 'pending_renewal' records to 'expired'.
        DB::statement("UPDATE recommendations SET status = 'expired' WHERE status = 'pending_renewal'");
        DB::statement("ALTER TABLE recommendations MODIFY COLUMN status ENUM('pending', 'active', 'expired') NOT NULL DEFAULT 'pending'");
    }
};