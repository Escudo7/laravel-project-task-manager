@extends('layouts.app')

@section('header')
{{ __('Changing task status') }}
@endsection

@section('content')
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-secondary text-white text-center pt-3 pb-1">
                    <h5>
                        {{ __('Enter new name') }}
                    </h5>
                </div>

                <div class="card-body">
                    {{ Form::model($taskStatus, [
                        'url' => route('task_statuses.update', $taskStatus),
                        'method' => 'PATCH']) }}
                    @csrf
                    <div class="form-group row">
                        <div class="col">
                            <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required>
                        </div>
                        <button type="submit" class="btn btn-primary text-white col-md-3">
                            {{ __('Save') }}
                        </button>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection