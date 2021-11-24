<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable =[
        'order_id',
        'product_name',
        'payment_date',
    ];
    protected $connection = 'test_db';
    protected $table = 'order';
}
