<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recommendation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'recommendation_category_id',
        'place_name',
        'address',
        'map_embed_code',
        'description',
        'photo',
        'photo_2',
        'photo_3',
        'status',
        'is_indexed',
        'published_at',
        'expires_at',
        'indexed_at',
        'indexed_expires_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'expires_at' => 'datetime',
        'published_at' => 'datetime',
        'indexed_at' => 'datetime',
        'indexed_expires_at' => 'datetime',
    ];

    /**
     * Get the user that owns the recommendation.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the category that the recommendation belongs to.
     */
    public function recommendationCategory()
    {
        return $this->belongsTo(RecommendationCategory::class);
    }

    /**
     * Get all of the recommendation's transactions.
     */
    public function transactions()
    {
        return $this->morphMany(Transaction::class, 'transactionable');
    }

    /**
     * Get all of the recommendation's upgrade applications.
     */
    public function upgradeApplications()
    {
        return $this->hasMany(RecommendationUpgradeApplication::class);
    }
}
