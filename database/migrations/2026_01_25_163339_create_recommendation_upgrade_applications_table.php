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
        Schema::create('recommendation_upgrade_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('recommendation_id')->constrained()->onDelete('cascade');

            // Explicitly name the foreign key to avoid length issues
            $table->foreignId('recommendation_upgrade_package_id');
            $table->foreign('recommendation_upgrade_package_id', 'rec_upg_app_pkg_id_fk')
                  ->references('id')
                  ->on('recommendation_upgrade_packages')
                  ->onDelete('cascade');
            
            $table->string('status')->default('pending'); // e.g., pending, approved, rejected, awaiting_payment, payment_pending, completed
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
        Schema::dropIfExists('recommendation_upgrade_applications');
    }
};