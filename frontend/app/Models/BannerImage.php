<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BannerImage extends Model
{
    use HasFactory;

    protected $table = 'banner_images';

    protected $fillable = [
        'name',
        'banner_image',
        'banner_position',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
