<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\RecommendationCategory;
use App\Models\Recommendation;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $defaultCategory = RecommendationCategory::first();
        if ($defaultCategory) {
            Recommendation::whereNull('recommendation_category_id')->update(['recommendation_category_id' => $defaultCategory->id]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};