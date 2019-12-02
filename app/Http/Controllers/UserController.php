<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = \App\User::paginate(10);
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
        $tasks = \App\Task::all();
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
            session()->flash('error', 'У Вас недостаточно полномочий для выполнения этих действий');
            return redirect()->route('start');
        }
        return view('user.edit', compact('user'));
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
            session()->flash('error', 'У Вас недостаточно полномочий для выполнения этих действий');
            return redirect()->route('start');
        }
        $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'sex' => [Rule::in(['мужской', 'женский']), 'nullable'],
            'birth_day' => ['integer', 'min:1', 'max:31', 'nullable'],
            'birth_month' => ['integer', 'min:1', 'max:12', 'nullable'],
            'birth_year' => ['integer', 'min:1930', 'max:2015', 'nullable'],
            'country' => ['string', 'max:255', 'nullable'],
            'city' => ['string', 'max:255', 'nullable'],
        ]);
        $user->fill($request->all());
        $user->save();
        session()->flash('success','Ваш профиль был успешно изменен!');
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
            session()->flash('error', 'У Вас недостаточно полномочий для выполнения этих действий');
            return redirect()->route('start');
        }
        foreach ($user->assignedTasks as $task) {
            $task->assignedTo()->dissociate();
            $task->save();
        }
        $user->delete();
        session()->flash('warning','Ваш профиль был удален');
        return redirect()->route('start');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit_password(Request $request, User $user)
    {
        if ($request->user() != $user) {
            session()->flash('error', 'У Вас недостаточно полномочий для выполнения этих действий');
            return redirect()->route('start');
        }
        return view('user.edit_password', compact('user'));
    }

    /**
     * Update_update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update_password(Request $request, User $user)
    {
        if ($request->user() != $user) {
            session()->flash('error', 'У Вас недостаточно полномочий для выполнения этих действий');
            return redirect()->route('start');
        }
        $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        $user->password = Hash::make($request['password']);
        $user->save();
        session()->flash('success','Ваш пароль был успешно изменен');
        return redirect()->route('users.show', $user);
    }
}
