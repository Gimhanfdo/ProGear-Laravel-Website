<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model as Eloquent;

class MongoOrder extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'orders';

    protected $fillable = [
        'user_id',
        'orderdate',
        'total',
        'shippingaddress',
        'orderstatus',
    ];
}
