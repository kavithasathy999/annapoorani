<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'product_orders';

    protected $fillable = [
        'oeder_id',
        'user_id',
        'sub_total',
        'discount',
        'shipping',
        'total',
        'status',
        'name',
        'address',
        'state',
        'city',
        'area',
        'pincode',
        'order_source',
    ];
}
