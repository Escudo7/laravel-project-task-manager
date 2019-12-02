@extends('layouts.app')

@section('header')
{{ __('Chenging task') }}
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
                    {{ Form::model($task, [
                            'url' => route('tasks.update', $task),
                            'method' => 'PATCH']) }}
                    @csrf
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') ?? $task->name }}" required>
                                <small id="nameHelpBlock" class="form-text text-muted">
                                    {{ __('Required field') }}
                                </small>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('Description') }}</label>

                            <div class="col-md-6">
                                <textarea id="description" class="form-control" name="description" rows="3">{{ old('description') ?? $task->description }}</textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="assignedTo_id" class="col-md-4 col-form-label text-md-right">{{ __('Executor') }}</label>
                            <div class="col-md-6">
                                <select class="form-control" id="assignedTo_id" name="assignedTo_id">
                                @if($task->assignedTo)
                                    <option value="{{ old('assignedTo_id') ?? $task->assignedTo->id }}">{{ $task->assignedTo->name }}</option>
                                @else
                                    <option value="{{ old('assignedTo_id') ?? '' }}">{{ __('assign later') }}</option>
                                @endif
                                @foreach($users as $user)
                                    <option value="{{ $user->id}} ">{{ $user->name }}</option>
                                @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="status_id" class="col-md-4 col-form-label text-md-right">{{ __('Task status') }}</label>
                            <div class="col-md-6">
                                <select class="form-control" id="status_id" name="status_id" value="{{ old('status_id') ?? $task->status_id }}">
                                <option value="{{ old('status_id') ?? $task->status->id }}">{{ $task->status->name }}</option>
                                @foreach($statuses as $status)
                                    <option value="{{ $status->id}} ">{{ $status->name }}</option>
                                @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 text-md-right">
                                <p>{{ __('Attached tags') }}</p>
                            </div>
                            <div class="col">
                                @foreach($task->tags as $tag)
                                    <a href="{{ route('tasks.index', ['tag' => $tag->id]) }}">{{ $tag->name }}</a>
                                @endforeach
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-4 form-check-label text-md-right" for="dropTags">{{ __('Remove tags') }}</label>
                            <div class="form-check col-md-6 ml-3">
                                <input type="checkbox" class="form-check-input" name="dropTags" id="dropTags">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="tags" class="col-md-4 col-form-label text-md-right">{{ __('Chenge tags') }}</label>
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
                                    {{ __('Save chenge') }}
                                </button>
                            </div>
                        </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection