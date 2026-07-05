<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeoHeading extends Model
{
    protected $table = 'seo_heading';
    
    public function seoDatas()
    {
        return $this->hasMany(SeoData::class, 'seo_headingId');
    }
}
