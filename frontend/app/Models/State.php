<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $table    = 'state_list';
    public    $timestamps = false;
    protected $fillable = ['state'];
}
