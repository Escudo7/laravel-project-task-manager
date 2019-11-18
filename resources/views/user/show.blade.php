@extends('layouts.app')

@section('header')
    Профиль пользователя {{ $user->name }}
@endsection

@section('content')
    <h3>Регистрационная информация</h3>
    <div class='container'>
    <table class="table table-sm table-bor">
        <tr>
            <td>Псевдоним<td>
            <td>{{ $user->name }}<td>
        </tr>
        <tr>
            <td>Имя<td>
            <td>{{ $user->firstname }}<td>
        </tr>
        <tr>
            <td>Фамилия<td>
            <td>{{ $user->lastname }}<td>
        </tr>
        <tr>
            <td>E-mail<td>
            <td>{{ $user->email }}<td>
        </tr>
        <tr>
            <td>Пол<td>
            <td>{{ $user->sex }}<td>
        </tr>
        <tr>
            <td>День рождения<td>
            <td>
                @if ($user->birth_day && $user->birth_month && $user->birth_year)
                    {{ $user->birth_day }} - {{ $user->birth_month }} - {{ $user->birth_year }}
                @endif
            <td>
        </tr>
        <tr>
            <td>Страна<td>
            <td>{{ $user->country }}<td>
        </tr>
        <tr>
            <td>Город<td>
            <td>{{ $user->city }}<td>
        </tr>
        <tr>
            <td>Дата регистрации<td>
            <td>{{ $user->created_at }}<td>
        </tr>
    </table>
    </div>
@endsection