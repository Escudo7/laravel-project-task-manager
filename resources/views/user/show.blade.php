@extends('layouts.app')

@section('header')
    Профиль пользователя {{ $user->name }}
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-8">
                <div class="card">
                    <div class="card-header bg-secondary text-white text-center big-text">
                        Регистрационная информация
                    </div>
                    <div class="card-body">
                        <div class="row big-text">
                            <div class="col-sm-4">
                                <p>Псевдоним</p>
                            </div>
                            <div class="col-sm-4">
                                <p>{{ $user->name }}</p>
                            </div>
                        </div>
                        <div class="row big-text">
                            <div class="col-sm-4">
                                <p>Имя</p>
                            </div>
                            <div class="col-sm-4">
                                <p>{{ $user->firstname }}</p>
                            </div>
                        </div>
                        <div class="row big-text">
                            <div class="col-sm-4">
                                <p>Фамилия</p>
                            </div>
                            <div class="col-sm-4">
                                <p>{{ $user->lastname }}</p>
                            </div>
                        </div>
                        <div class="row big-text">
                            <div class="col-sm-4">
                                <p>E-mail</p>
                            </div>
                            <div class="col-sm-8">
                                <p>{{ $user->email }}</p>
                            </div>
                        </div>
                        <div class="row big-text">
                            <div class="col-sm-4">
                                <p>Пол</p>
                            </div>
                            <div class="col-sm-8">
                                <p>{{ $user->sex }}</p>
                            </div>
                        </div>
                        <div class="row big-text">
                            <div class="col-sm-4">
                                <p>День рождения</p>
                            </div>
                            <div class="col-sm-8">
                                <p>
                                    @if ($user->birth_day && $user->birth_month && $user->birth_year)
                                        {{ $user->birth_day }} - {{ $user->birth_month }} - {{ $user->birth_year }}
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="row big-text">
                            <div class="col-sm-4">
                                <p>Страна</p>
                            </div>
                            <div class="col-sm-8">
                                <p>{{ $user->country }}</p>
                            </div>
                        </div>
                        <div class="row big-text">
                            <div class="col-sm-4">
                                <p>Город</p>
                            </div>
                            <div class="col-sm-8">
                                <p>{{ $user->city }}</p>
                            </div>
                        </div>
                        <div class="row big-text">
                            <div class="col-sm-4">
                                <p>Дата регистрации</p>
                            </div>
                            <div class="col-sm-8">
                                <p>{{ $user->created_at }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection