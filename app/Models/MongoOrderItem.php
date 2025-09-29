<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model as Eloquent;

class MongoOrderItem extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'order_items';

    protected $fillable = [
        'order_id',   
        'product_id',
        'quantity',
    ];
}