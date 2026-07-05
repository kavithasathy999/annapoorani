<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeoData extends Model
{
    protected $table = 'seo_datas';
    
    public function heading()
    {
        return $this->belongsTo(SeoHeading::class, 'seo_headingId');
    }
}
