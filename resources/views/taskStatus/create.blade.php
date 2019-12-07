@extends('layouts.app')

@section('header')
{{ __('Creating new task status') }}
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
                        {{ __('Enter new status') }}
                    </h5>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('task_statuses.store') }}">
                        @csrf
                        <div class="form-group row">
                            <div class="col">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required>
                            </div>
                            <button type="submit" class="btn btn-primary text-white col-md-3">
                                {{ __('Create') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection