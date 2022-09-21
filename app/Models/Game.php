<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
    	'level'=>'object',
    	'probable_win'=>'object',
    ];
}
