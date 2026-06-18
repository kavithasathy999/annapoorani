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
        'heading',
        'subheading',
        'address',
        'phone',
        'email',
        'form_bg_image',
        'map_iframe',
    ];
}
