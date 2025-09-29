<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model as Eloquent;

class MongoReview extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'reviews';

    protected $fillable = [
        'user_id',
        'product_id',
        'review_text',
        'review_date',
        'review_rating',
        'user_name',
        'mysql_id'
    ];
}
