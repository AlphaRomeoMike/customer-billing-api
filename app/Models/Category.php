<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, Bool>
     */
    protected $fillable = [
        'name',
        'status',
    ];

    /**
     * Get all of the subCategories for the Category
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subCategories(): HasMany
    {
        return $this->hasMany(SubCategory::class);
    }
}
