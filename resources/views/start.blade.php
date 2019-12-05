@extends('layouts.app')
@section('header', 'Task Manager')

@section('content')
    <div class="jumbotron">
        <h1 class="text-center" style="font-size: 1.6rem;">{{ __('start.title') }}</h1>
        <p class="lead text-center">{!! __('start.about_project') !!}</p>
        <hr class="my-4">
        <p>{!! __('start.p1') !!}</p>
        <p>{!! __('start.p2') !!}</p>
        <p>{!! __('start.p3') !!}</p>
        <p>{!! __('start.p4') !!}</p>
        <p>{!! __('start.p5') !!}</p>
        <p>{!! __('start.p6') !!}</p>
    </div>
@endsection