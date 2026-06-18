<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table      = 'city_list';
    public    $timestamps = false;
    protected $fillable   = ['city_name', 'city_code', 'state_code'];
}
