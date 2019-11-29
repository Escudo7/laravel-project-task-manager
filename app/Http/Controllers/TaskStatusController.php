<?php

namespace App\Http\Controllers;

use App\TaskStatus;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TaskStatusController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $message = [
            'success' => session('success'),
            'warning' => session('warning'),
            'error' => session('error')
        ];
        $statuses = TaskStatus::all();
        return view('taskStatus.index', compact('statuses', 'message'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('taskStatus.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', Rule::unique('task_statuses')]
        ]);
        $taskStatus = new TaskStatus();
        $taskStatus->fill($request->all());
        $taskStatus->save();
        session()->flash('success','Статус успешно добавлен!');
        return redirect()->route('task_statuses.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TaskStatus  $taskStatus
     * @return \Illuminate\Http\Response
     */
    public function edit(TaskStatus $taskStatus)
    {
        return view('taskStatus.edit', compact('taskStatus'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TaskStatus  $taskStatus
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TaskStatus $taskStatus)
    {
        $request->validate([
            'name' => ['required', Rule::unique('task_statuses')]
        ]);
        $taskStatus->fill($request->all());
        $taskStatus->save();
        session()->flash('success', 'Статус был успешно изменен!');
        return redirect()->route('task_statuses.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TaskStatus  $taskStatus
     * @return \Illuminate\Http\Response
     */
    public function destroy(TaskStatus $taskStatus)
    {
        if (sizeof($taskStatus->tasks) > 0) {
            session()->flash('error', 'Нельзя удалить статус, который присвоен существующим задачам');
            return redirect()->route('task_statuses.index');
        }
        $taskStatus->delete();
        session()->flash('warning', 'Статус был удален');
        return redirect()->route('task_statuses.index');
    }
}
