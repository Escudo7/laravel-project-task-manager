@extends('layouts.app')
@section('header', 'Task Manager')

@section('content')
    <div class="jumbotron">
        <h3 class="text-center">{{ __('home.title') }}</h3>
        <p class="lead text-center">{!! __('home.about_project') !!}</p>
        <hr class="my-4">
        <p>{!! __('home.p1') !!}</p>
        <p>{!! __('home.p2') !!}</p>
        <p>{!! __('home.p3') !!}</p>
        <p>{!! __('home.p4') !!}</p>
        <p>{!! __('home.p5') !!}</p>
        <p>{!! __('home.p6') !!}</p>
    </div>
@endsection