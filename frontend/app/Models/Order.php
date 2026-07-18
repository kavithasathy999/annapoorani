<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'order_no',
        'customer_id',
        'sub_total',
        'shipping',
        'discount',
        'total',
        'additional_charge_type',
        'additional_charge_amount',
        'order_type',
        'status',
        'payment_status',
        'notes',
        'is_gst_applied',
        'total_gst',
        'order_date',
    ];
}
