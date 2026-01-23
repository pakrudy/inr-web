<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug'];

    /**
     * Get the legacies for the category.
     */
    public function legacies()
    {
        return $this->hasMany(Legacy::class);
    }
}
