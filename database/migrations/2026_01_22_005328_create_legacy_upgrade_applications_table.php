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
        Schema::create('legacy_upgrade_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('legacy_id')->constrained()->onDelete('cascade');
            $table->foreignId('upgrade_package_id')->constrained()->onDelete('cascade');
            $table->string('status')->default('pending'); // e.g., pending, approved, rejected, awaiting_payment
            $table->json('form_data')->nullable();
            $table->text('admin_notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('legacy_upgrade_applications');
    }
};
