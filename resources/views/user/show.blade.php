@extends('layouts.app')

@section('header')
    {{ __('users.show.header', ['name' => $user->name]) }}
@endsection

@section('content')
    @guest
    <div class="row justify-content-center">
        <div class="col-sm-8">
            <div class="card border-danger">
                <div class="card-body">
                    <p>
                        {!! trans('users.show.no_auth', ['name' => $user->name]) !!}
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
                <div class="card-header bg-secondary text-white text-center pt-3 pb-1">
                    <h5>
                        {{ __('Registration information') }}
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <p>{{ __('NicName') }}</p>
                        </div>
                        <div class="col">
                            <p>{{ $user->name }}</p>
                        </div>
                    </div>
                    @if($user->firstname)
                        <div class="row">
                            <div class="col">
                                <p>{{ __('First name') }}</p>
                            </div>
                            <div class="col">
                                <p>{{ $user->firstname }}</p>
                            </div>
                        </div>
                    @endif
                    @if($user->lastname)
                        <div class="row">
                            <div class="col">
                                <p>{{ __('Last name') }}</p>
                            </div>
                            <div class="col">
                                <p>{{ $user->lastname }}</p>
                            </div>
                        </div>
                    @endif
                    @if($isUser)
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
                                <p>{{ __('Sex') }}</p>
                            </div>
                            <div class="col">
                                <p>{{ $user->sex == 'male' ? __('male') : __('female') }}</p>
                            </div>
                        </div>
                    @endif
                    @if ($user->birth_day && $user->birth_month && $user->birth_year)
                        <div class="row">
                            <div class="col">
                                <p>{{ __('Birthday') }}</p>
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
                                <p>{{ __('Country') }}</p>
                            </div>
                            <div class="col">
                                <p>{{ $user->country }}</p>
                            </div>
                        </div>
                    @endif
                    @if($user->city)
                        <div class="row">
                            <div class="col">
                                <p>{{ __('City') }}</p>
                            </div>
                            <div class="col">
                                <p>{{ $user->city }}</p>
                            </div>
                        </div>
                    @endif
                    <div class="row">
                        <div class="col">
                            <p>{{ __('Registration date') }}</p>
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
                <div class="card-header bg-secondary text-white text-center pt-3 pb-1">
                    <h5>
                        {{__('Created tasks') }}
                    </h5>
                </div>
                <div class="card-body p-1">
                    @foreach($user->createdTasks as $task)
                        @include('user.cardTaskInProfile')
                    @endforeach
                    @if(sizeof($user->createdTasks) == 0)
                        <p class="m-2">{{ __('No tasks') }}</p>
                    @endif
                </div>
            </div>
            <div class="card border-light">
                <div class="card-header bg-secondary text-white text-center pt-3 pb-1">
                    <h5>
                        {{ __('Assigned tasks') }}
                    </h5>
                </div>
                <div class="card-body p-1">
                    @foreach($user->assignedTasks as $task)
                        @include('user.cardTaskInProfile')
                    @endforeach
                    @if(sizeof($user->assignedTasks) == 0)
                        <p class="m-2">{{ __('No tasks') }}</p>
                    @endif
                </div>
            </div>
        </div>
        @if($isUser)
            <div class="col-sm-3">
                <div class="card">
                    <div class="card-header bg-secondary text-white text-center pt-3 pb-1">
                        <h5>
                            {{ __('Function') }}
                        </h5>
                    </div>
                    <div class="card-body pl-5">
                        <div class="row">
                            <a href="{{ route('tasks.create') }}" class='text-dark'>
                                {{ __('Create new task') }}
                            </a>
                        </div>
                        <div class="row">
                            <a href="{{ route('users.edit', ['user' => $user, 'type' => 'editPassword']) }}" class='text-dark' data-params="type=editPassword">
                                {{ __('Chenge password') }}
                            </a>
                        </div>
                        <div class="row">
                            <a href="{{ route('users.edit', ['user' => $user, 'type' => 'editProfile']) }}" class='text-dark'>
                                {{ __('Edit profile') }}
                            </a>
                        </div>
                        <div class="row">
                            <a href="{{ route('users.destroy', $user) }}" data-confirm="{{ __('Are you sure?') }}" data-method="delete" class='text-dark'>
                                {{ __('Delete profile') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
    @endauth
@endsection