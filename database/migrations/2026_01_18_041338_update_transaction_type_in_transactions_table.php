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
        // Truncate the table to avoid data type conflicts with existing data
        DB::table('transactions')->truncate();

        Schema::table('transactions', function (Blueprint $table) {
            $table->renameColumn('type', 'transaction_type');
            $table->enum('transaction_type', ['initial', 'upgrade', 'renewal'])->default('initial')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->renameColumn('transaction_type', 'type');
            // Revert to original string type, assuming no enum was explicitly set before
            $table->string('type')->change();
        });
    }
};
