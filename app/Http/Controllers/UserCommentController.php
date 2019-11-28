<?php

namespace App\Http\Controllers;

use App\Comment;
use App\User;
use Illuminate\Http\Request;

class UserCommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        $request->validate([
            'body' => ['required', 'string', 'max:255'],
            'task_id' => ['required', 'exists:tasks,id']
        ]);
        $comment = $user->comments()->make();
        $comment->fill($request->all());
        $comment->save();
        return redirect()->route('tasks.show', $request['task_id']);
    }
}
