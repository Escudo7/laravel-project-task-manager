<?php

namespace App\Http\Controllers;

use App\Task;
use App\User;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = Task::paginate(10);
        return view('task.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (\App\TaskStatus::first() === null) {
            $newStatus = new \App\TaskStatus(['name' => 'new task']);
            $newStatus->save();
            $workStatus = new \App\TaskStatus(['name' => 'working']);
            $workStatus->save();
            $testStatus = new \App\TaskStatus(['name' => 'testing']);
            $testStatus->save();
            $terminateStatus = new \App\TaskStatus(['name' => 'terminated']);
            $terminateStatus->save();
        }
        $task = new Task();
        $users = \App\User::all();
        return view('task.create', compact('task', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!\Auth::check()) {
            session()->flash('error', 'У Вас недостаточно полномочий для выполнения этих действий');
            return redirect()->route('start');
        }
        $request->validate([
            'name' => ['required', 'string', 'max:255']
        ]);
        $task = new Task();
        $task->fill($request->all());
        $task->creator()->associate($request->user());
        $task->status_id = 1;
        $task->save();
        session()->flash('success','Задача успешно создана');
        return redirect()->route('tasks.show', $task);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Task $task)
    {
        $message = [
            'success' => session('success'),
            'warning' => session('warning'),
            'error' => session('error')
        ];
        $currentUser = $request->user();
        $tags = $task->tags()->get();
        return view('task.show', compact('task', 'message', 'currentUser', 'tags'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Task $task)
    {
        if ($request->user() != $task->creator && $request->user() != $task->assignedTo) {
            session()->flash('error','У Вас недостаточно полномочий для выполнения этих действий');
            return redirect()->route('tasks.show', $task);
        }
        $users = \App\User::all();
        $statuses = \App\TaskStatus::all();
        $tags = \App\Tag::all();
        return view('task.edit', compact('task', 'users', 'statuses', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        if ($request->user() != $task->creator && $request->user() != $task->assignedTo) {
            session()->flash('error','У Вас недостаточно полномочий для выполнения этих действий');
            return redirect()->route('tasks.show', $task);
        }
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'status_id' => ['required', 'exists:task_statuses,id'],
            'assignedTo_id' => ['exists:users,id', 'nullable'],
            'tags' => ['exists:tags,id', 'nullable']
        ]);
        $date = array_filter($request->all(), function ($key) {
            $key !== 'tags' && $key !== 'newTag';
        });
        
        //print_r($request->all());
        $task->fill($date);
        if ($request['tags']) {
            $task->tags()->sync($request['tags']);
        }
        $task->save();
        session()->flash('success','Задача была изменена');
        return redirect()->route('tasks.show', $task);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function get_task(Request $request, Task $task)
    {
        if (!\Auth::check()) {
            session()->flash('error', 'У Вас недостаточно полномочий для выполнения этих действий');
            return redirect()->route('start');
        }
        $task->assignedTo()->associate($request->user());
        $task->save();
        session()->flash('success','Вы успешно взяли задачу!');
        return redirect()->route('tasks.show', $task);
    }
}
