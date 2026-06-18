<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeSetting extends Model
{
    use HasFactory;

    protected $table = 'home_settings';

    protected $fillable = [
        'hero_eyebrow',
        'welcome_heading',
        'welcome_text',
        'welcome_image',
        'badge1_text',
        'badge2_text',
        'badge3_text',
        'welcome_button_text',
        'welcome_button_link',
        'products_eyebrow',
        'products_heading',
        'featured_product_ids',
        'why_heading_data',
        'why_pillars',
        'why_dials',
        'why_stats',
    ];

    protected $casts = [
        'featured_product_ids' => 'array',
        'why_heading_data' => 'array',
        'why_pillars' => 'array',
        'why_dials' => 'array',
        'why_stats' => 'array',
    ];
}
