<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UpgradePackage extends Model
{
    /** @use HasFactory<\Database\Factories\UpgradePackageFactory> */
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'price' => 'decimal:2',
        'features' => 'array',
    ];
}
