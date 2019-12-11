<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use App\TaskStatus;
use App\Task;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::orderBy('id')->paginate(10);
        return view('user.index', compact('users'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, User $user)
    {
        $message = [
            'success' => session('success'),
            'warning' => session('warning'),
            'error' => session('error')
        ];
        $currentUser = $request->user();
        $tasks = Task::all();
        return view('user.show', compact('user', 'message', 'currentUser', 'tasks'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, User $user)
    {
        if ($request->user() != $user) {
            session()->flash('error', __('You do not have enough authority to perform these actions'));
            return redirect()->route('home.index');
        }

        $typeEditing = $request['type'];
        switch ($typeEditing) {
            case 'editProfile':
                return view('user.edit_profile', compact('user'));

            case 'editPassword':
                return view('user.edit_password', compact('user'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, User $user)
    {
        if ($request->user() != $user) {
            session()->flash('error', __('You do not have enough authority to perform these actions'));
            return redirect()->route('home.index');
        }
        
        $typeUpdate = $request['type'];
        switch ($typeUpdate) {
            case 'updatePassword':
                $request->validate([
                    'password' => ['required', 'string', 'min:8', 'confirmed'],
                ]);
                $user->password = Hash::make($request['password']);
                $user->save();
                session()->flash('success', __('Your password has been successfully changed'));
                break;
            
            case 'updateProfile':
                $request->validate([
                    'name' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
                    'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
                    'sex' => [Rule::in(['male', 'female']), 'nullable'],
                    'birth_day' => ['integer', 'min:1', 'max:31', 'nullable'],
                    'birth_month' => ['integer', 'min:1', 'max:12', 'nullable'],
                    'birth_year' => ['integer', 'min:1930', 'max:2015', 'nullable'],
                    'country' => ['string', 'max:255', 'nullable'],
                    'city' => ['string', 'max:255', 'nullable'],
                ]);
                $user->fill($request->except('type'));
                $user->save();
                session()->flash('success', __('Your profile has been successfully modified!'));
                break;
        }
        return redirect()->route('users.show', $user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, User $user)
    {
        if ($request->user() != $user) {
            session()->flash('error', __('You do not have enough authority to perform these actions'));
            return redirect()->route('home.index');
        }

        foreach ($user->assignedTasks as $task) {
            $task->executor()->dissociate();
            $statusTerminatedTask = TaskStatus::find(4);
            if ($task->status != $statusTerminatedTask) {
                $statusNotWorkingTask = TaskStatus::find(1);
                $task->status()->associate($statusNotWorkingTask);
            }
            $task->save();
        }

        $user->delete();

        session()->flash('warning', __('Your profile has been deleted'));
        return redirect()->route('home.index');
    }
}
