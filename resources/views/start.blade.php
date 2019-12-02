@extends('layouts.app')
@section('header', 'Task Manadger')

@section('content')
    <div class="jumbotron">
        <h1 class="text-center" style="font-size: 1.6rem;">{{ __('start.title') }}</h1>
        <p class="lead text-center">{!! trans('start.about_project') !!}</p>
        <hr class="my-4">
        <p>Для участия в проекте перейдите на страницу регистрации.</p>
    </div>
@endsection