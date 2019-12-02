@extends('layouts.app')

@section('header')
{{ __('Creating new task') }}
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
                <div class="card-header bg-secondary text-white text-center big-text">{{ __('Please fill in the following form') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('tasks.store') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required>
                                <small id="nameHelpBlock" class="form-text text-muted">
                                    {{ __('Requred field') }}
                                </small>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('Description') }}</label>

                            <div class="col-md-6">
                                <textarea id="description" class="form-control" name="description" value="{{ old('description') }}" rows="3"></textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="assignedTo_id" class="col-md-4 col-form-label text-md-right">{{ __('Executor') }}</label>
                            <div class="col-md-6">
                                <select class="form-control" id="assignedTo_id" name="assignedTo_id">
                                <option value="">{{ __('assign later') }}</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id}} ">{{ $user->name }}</option>
                                @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="tags" class="col-md-4 col-form-label text-md-right">{{ __('Select tags')}}</label>
                            <div class="col-md-6">
                                <select multiple class="form-control" id="tags[]" name="tags[]">
                                @foreach($tags as $tag)
                                    <option value="{{ $tag->id }} ">{{ $tag->name }}</option>
                                @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="newTag" class="col-md-4 col-form-label text-md-right">{{ __('New tag') }}</label>
                            <div class="col-md-6">
                                <input id="newTag" type="text" class="form-control" name="newTag" value="{{ old('newTag') }}">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-secondary">
                                    {{ __('Create new task') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection