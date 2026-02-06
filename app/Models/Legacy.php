<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Legacy extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'description',
        'photo',
        'status',
        'is_indexed',
        'published_at',
        'indexed_at',
        'indexed_expires_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'published_at' => 'datetime',
        'indexed_at' => 'datetime',
        'indexed_expires_at' => 'datetime',
    ];

    /**
     * Get the user that owns the legacy.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the category that the legacy belongs to.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get all of the legacy's transactions.
     */
    public function transactions()
    {
        return $this->morphMany(Transaction::class, 'transactionable');
    }

    /**
     * Get all of the legacy's upgrade applications.
     */
    public function upgradeApplications()
    {
        return $this->hasMany(LegacyUpgradeApplication::class);
    }
}
