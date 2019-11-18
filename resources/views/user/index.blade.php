@extends('layouts.app')

@section('header', 'Список пользователей')

@section('content')
    <table class="table table-hover table-bordered">
        <tr class="bg-secondary text-center text-white">
            <th>№</th>
            <th>Псевдоним</th>
            <th>Имя</th>
            <th>Фамилия</th>
            <th>Дата регистрации</th>
        </tr>
        @foreach($users as $user)
        <tr>
            <td>{{$user->id}}</a></td>
            <td><a href="{{ route('users.show', $user) }}">{{$user->name}}</a></td>
            <td>{{$user->first_name}}</td>
            <td>{{$user->last_name}}</td>
            <td>{{$user->created_at}}</td>
        <tr>
        @endforeach
    </table>
@endsection