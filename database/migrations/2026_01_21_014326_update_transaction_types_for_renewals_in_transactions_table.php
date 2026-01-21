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
        // Use a raw statement to modify the ENUM column
        DB::statement("ALTER TABLE transactions CHANGE COLUMN transaction_type transaction_type ENUM('initial', 'upgrade', 'renewal', 'renewal_r1', 'renewal_r2') NOT NULL DEFAULT 'initial'");
        
        // Update existing 'renewal' values to 'renewal_r1' for consistency
        DB::table('transactions')
            ->where('transaction_type', 'renewal')
            ->update(['transaction_type' => 'renewal_r1']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Update values back to 'renewal' before changing column definition
        DB::table('transactions')
            ->whereIn('transaction_type', ['renewal_r1', 'renewal_r2'])
            ->update(['transaction_type' => 'renewal']);

        // Revert the column to the old ENUM definition
        DB::statement("ALTER TABLE transactions CHANGE COLUMN transaction_type transaction_type ENUM('initial', 'upgrade', 'renewal') NOT NULL DEFAULT 'initial'");
    }
};
