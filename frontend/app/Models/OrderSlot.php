<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderSlot extends Model
{
    use HasFactory;

    protected $table = 'product_slots';

    protected $fillable = [
        'order_id',
        'user_id',
        'product_id',
        'product_name',
        'product_total',
        'qty',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
