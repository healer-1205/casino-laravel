<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameLog extends Model
{
    protected $guarded = ['id'];

    public function game(){
    	return $this->belongsTo(Game::class);
    }

     public function user()
    {
        return $this->belongsTo(User::class);
    }
}
