<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LegacyUpgradeApplication extends Model
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
        return $this->belongsTo(UpgradePackage::class, 'upgrade_package_id');
    }

    /**
     * Get the user that the upgrade application belongs to.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the legacy that the upgrade application belongs to.
     */
    public function legacy()
    {
        return $this->belongsTo(Legacy::class);
    }
}
