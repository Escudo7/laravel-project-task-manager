<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{
    use SoftDeletes;
    
    public function tasks()
    {
        return $this->belongsToMany('App\Task');
    }


}