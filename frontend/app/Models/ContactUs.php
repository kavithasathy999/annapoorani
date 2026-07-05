<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactUs extends Model
{
    use HasFactory;

    protected $table = 'contact_us';

    protected $fillable = [
        'page_title',
        'hero_eyebrow',
        'hero_title',
        'hero_subtitle',
        'heading',
        'subheading',
        'address',
        'phone',
        'phone_2',
        'email',
        'form_bg_image',
        'map_iframe',
        'step1_title',
        'step1_text',
        'step2_title',
        'step2_text',
        'step3_title',
        'step3_text',
        'step4_title',
        'step4_text',
    ];
}
