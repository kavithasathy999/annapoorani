<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = [
        'category_name',
        'category_image',
        'sort_order',
        'status',
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }
}
