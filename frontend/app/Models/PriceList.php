<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PriceList extends Model
{
    protected $table    = 'price_lists';
    protected $fillable = ['price_data', 'status'];
}
