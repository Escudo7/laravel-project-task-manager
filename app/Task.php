<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class Task extends Model
{
    use SoftDeletes;

    protected $guarded = [
        'id',
    ];
    
    public function tags()
    {
        return $this->belongsToMany('App\Tag');
    }

    public function creator()
    {
        return $this->belongsTo('App\User')->withTrashed();
    }

    public function assignedTo()
    {
        return $this->belongsTo('App\User', 'assignedTo_id')->withTrashed();
    }

    public function status()
    {
        return $this->belongsTo('App\TaskStatus');
    }

    public function comments()
    {
        return $this->hasMany('App\Comment');
    }
    
    public function scopeMyTasks($query, $id)
    {
        return $query->where('creator_id', '=', $id)
            ->orWhere('assignedTo_id', '=', $id);
    }

    public function scopeCreator($query, $id)
    {
        return $query->where('creator_id', '=', $id);
    }

    public function scopeExecutor($query, $id)
    {
        return $query->where('assignedTo_id', '=', $id);
    }

    public function scopeStatus($query, $id)
    {
        return $query->where('status_id', '=', $id);
    }

    public function scopeTag($query, $id)
    {
        return $query->whereHas('tags', function(Builder $query) use($id) {
            $query->where('tag_id', '=', $id);
        });
    }
}
