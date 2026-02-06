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
        Schema::table('legacies', function (Blueprint $table) {
            $table->timestamp('indexed_at')->nullable()->after('published_at');
            $table->timestamp('indexed_expires_at')->nullable()->after('indexed_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('legacies', function (Blueprint $table) {
            $table->dropColumn(['indexed_at', 'indexed_expires_at']);
        });
    }
};