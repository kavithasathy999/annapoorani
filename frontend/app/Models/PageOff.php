<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageOff extends Model
{
    protected $table    = 'page_off';
    protected $fillable = ['image', 'status'];
}
