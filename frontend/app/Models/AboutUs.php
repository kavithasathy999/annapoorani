<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutUs extends Model
{
    use HasFactory;

    protected $table = 'about_us';

    protected $fillable = [
        'eyebrow',
        'heading',
        'description',
        'main_image',
        'badge1_text',
        'badge2_text',
        'badge3_text',
        'banner_image',
        'hero_eyebrow',
        'hero_title',
        'hero_subtitle',
        'products_count',
        'customers_count',
        'success_percentage',
        'action_text',
        'action_description',
        'action_button_text',
        'action_button_link',
        'purpose_eyebrow',
        'purpose_heading',
        'p1_icon',
        'p1_title',
        'p1_text',
        'p2_icon',
        'p2_title',
        'p2_text',
        'p3_icon',
        'p3_title',
        'p3_text',
        'p4_icon',
        'p4_title',
        'p4_text'
    ];
}
