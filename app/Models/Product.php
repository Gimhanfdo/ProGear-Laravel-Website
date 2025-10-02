<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //Specifies which fields to enter into DB
    protected $fillable = ['name', 'brand', 'category', 'price', 'productimage', 'description', 'discountpercentage', 'quantityavailable'];

    // Scope for discounted products
    public function scopeDiscounted($query)
    {
        return $query->where('discountpercentage', '>', 0);
    }

    // Scope for filtering by category
    public function scopeByCategory($query, $category)
    {
        return $query->whereRaw('LOWER(category) = ?', [strtolower($category)]);
    }
}
