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
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $message = [
            'success' => session('success'),
            'warning' => session('warning')
        ];
        return view('user.show', compact('user', 'message'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
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
        $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'sex' => [Rule::in(['мужской', 'женский'])],
            'birth_day' => ['integer', 'min:1', 'max:31', 'nullable'],
            'birth_month' => ['integer', 'min:1', 'max:12', 'nullable'],
            'birth_year' => ['integer', 'min:1930', 'max:2015', 'nullable'],
            'country' => ['string', 'max:255', 'nullable'],
            'city' => ['string', 'max:255', 'nullable'],
        ]);
        $user->fill($request->all());
        $user->save();
        \Session::flash('success','Ваш профиль был успешно изменен!');
        return redirect()->route('users.show', $user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        \Session::flash('warning','Ваш профиль был удален');
        return redirect()->route('start');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit_password(User $user)
    {
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
        $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        $user->password = Hash::make($request['password']);
        $user->save();
        session()->flash('success','Ваш пароль был успешно изменен');
        return redirect()->route('users.show', $user);
    }
}
