<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GlobalSetting extends Model
{
    use HasFactory;

    protected $table = 'global_settings';

    protected $fillable = [
        'meta_title',
        'favicon',
        'logo',
        'company_name',
        'whatsapp_number',
        'phone_number',
        'footer_content',
        'address',
        'header_codes',
        'top_offer_text',
        'facebook_link',
        'instagram_link',
        'twitter_link',
        'linkedin_link',
        'youtube_link',
    ];
}
