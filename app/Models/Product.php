<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //Specifies which fields to enter into DB
    protected $fillable = ['name', 'brand', 'category', 'price', 'productimage', 'description', 'discountpercentage', 'quantityavailable'];
}
