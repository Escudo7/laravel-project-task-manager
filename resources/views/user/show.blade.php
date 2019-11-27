@extends('layouts.app')

@section('header')
    Профиль пользователя {{ $user->name }}
@endsection

@section('content')
    @guest
    <div class="row justify-content-center">
        <div class="col-sm-8">
            <div class="card border-danger">
                <div class="card-body">
                    <p>
                        Для простмотра профиля {{ $user->name }}, пожалуйста, пройдите процедуру 
                        <a href="{{ route('register') }}">регистрации</a>
                        или 
                        <a href="{{ route('login') }}">войдите</a>
                        в свой профиль
                    </p>
                </div>
            </div>
        </div>
    </div>
    @endguest
    @auth
    <div class="card-group col-sm">
        <div class="col">
            <div class="card">
                <div class="card-header bg-secondary text-white text-center big-text">
                    Регистрационная информация
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <p>Псевдоним</p>
                        </div>
                        <div class="col">
                            <p>{{ $user->name }}</p>
                        </div>
                    </div>
                    @if($user->firstname)
                        <div class="row">
                            <div class="col">
                                <p>Имя</p>
                            </div>
                            <div class="col">
                                <p>{{ $user->firstname }}</p>
                            </div>
                        </div>
                    @endif
                    @if($user->lastname)
                        <div class="row">
                            <div class="col">
                                <p>Фамилия</p>
                            </div>
                            <div class="col">
                                <p>{{ $user->lastname }}</p>
                            </div>
                        </div>
                    @endif
                    @if($currentUser == $user)
                        <div class="row">
                            <div class="col">
                                <p>E-mail</p>
                            </div>
                            <div class="col">
                                <p>{{ $user->email }}</p>
                            </div>
                        </div>
                    @endif
                    @if($user->sex)
                        <div class="row">
                            <div class="col">
                                <p>Пол</p>
                            </div>
                            <div class="col">
                                <p>{{ $user->sex }}</p>
                            </div>
                        </div>
                    @endif
                    @if ($user->birth_day && $user->birth_month && $user->birth_year)
                        <div class="row">
                            <div class="col">
                                <p>Дата рождения</p>
                            </div>
                            <div class="col">
                                <p>
                                    {{ $user->birth_day }} - {{ $user->birth_month }} - {{ $user->birth_year }}
                                </p>
                            </div>
                        </div>
                    @endif
                    @if($user->country)
                        <div class="row">
                            <div class="col">
                                <p>Страна</p>
                            </div>
                            <div class="col">
                                <p>{{ $user->country }}</p>
                            </div>
                        </div>
                    @endif
                    @if($user->city)
                        <div class="row">
                            <div class="col">
                                <p>Город</p>
                            </div>
                            <div class="col">
                                <p>{{ $user->city }}</p>
                            </div>
                        </div>
                    @endif
                    <div class="row">
                        <div class="col">
                            <p>Дата регистрации</p>
                        </div>
                        <div class="col">
                            <p>{{ $user->created_at }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card border-light">
                <div class="card-header bg-secondary text-white text-center big-text">
                    Созданные задачи
                </div>
                <div class="card-body p-1">
                    @foreach($user->createdTasks as $task)
                        @include('user.cardTaskInProfile')
                    @endforeach
                    @if(sizeof($user->createdTasks) == 0)
                        <p class="m-2">Задачи не создавались</p>
                    @endif
                </div>
            </div>
            <div class="card border-light">
                <div class="card-header bg-secondary text-white text-center big-text">
                    Задачи на выполнении
                </div>
                <div class="card-body p-1">
                    @foreach($user->assignedTasks as $task)
                        @include('user.cardTaskInProfile')
                    @endforeach
                    @if(sizeof($user->assignedTasks) == 0)
                        <p class="m-2">Отсутствуют</p>
                    @endif
                </div>
            </div>
        </div>
        @if($user->id == $currentUser->id)
            <div class="col-sm-3">
                <div class="card">
                    <div class="card-header bg-secondary text-white text-center big-text">
                        Функции
                    </div>
                    <div class="card-body pl-5">
                        <div class="row">
                            <a href="{{ route('tasks.create') }}" class='text-dark'>Создать задачу</a>
                        </div>
                        <div class="row">
                            <a href="{{ route('users.edit_password', $user) }}" class='text-dark'>Изменить пароль</a>
                        </div>
                        <div class="row">
                            <a href="{{ route('users.edit', $user) }}" class='text-dark'>Редактировать профиль</a>
                        </div>
                        <div class="row">
                            <a href="{{ route('users.destroy', $user) }}" data-confirm="Вы уверены?" data-method="delete" class='text-dark'>Удалить профиль</a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
    @endauth
@endsection