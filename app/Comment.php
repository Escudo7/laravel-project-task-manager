<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $guarded = [
        'id',
    ];
    
    public function creator()
    {
        return $this->belongsTo('App\User')->withTrashed();
    }

    public function task()
    {
        return $this->belongsTo('App\Task');
    }
}
