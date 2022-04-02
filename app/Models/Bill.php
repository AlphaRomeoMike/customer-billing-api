<?php

namespace App\Models;

use App\Models\User;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bill extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'category_id', 'subcategory_id', 'user_id', 'amount', 'paid', 'due_date'];

    /**
     * Get the subCategory that owns the Bill
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class, 'subcategory_id');
    }

    /**
     * Get the category that owns the Bill
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    /**
     * Get the user that owns the Bill
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
