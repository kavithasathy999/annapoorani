<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'category_id',
        'product_name',
        'product_mrp_price',
        'product_regular_price',
        'product_image',
        'sort_order',
        'product_content',
        'product_stock',
        'show_mrp_in_pdf',
        'show_discount_in_pdf',
        'is_product_gst_active',
        'product_gst',
    ];

    protected $casts = [
        'sort_order' => 'integer',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
