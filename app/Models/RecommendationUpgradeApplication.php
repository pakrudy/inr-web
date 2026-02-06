<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecommendationUpgradeApplication extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'form_data' => 'array',
    ];

    /**
     * Get the package that the upgrade application belongs to.
     */
    public function package()
    {
        return $this->belongsTo(RecommendationUpgradePackage::class, 'recommendation_upgrade_package_id');
    }

    /**
     * Get the user that the upgrade application belongs to.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the recommendation that the upgrade application belongs to.
     */
    public function recommendation()
    {
        return $this->belongsTo(Recommendation::class);
    }
}
