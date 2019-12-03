@extends('layouts.app')

@section('header')
{{ __('View task') }}
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
<div class="card-group col-sm">
    <div class="col">
        <div class="card">
            <div class="card-header bg-secondary text-white text-center big-text">
                {{ __('Task') }}
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <p>{{ __('Name') }}</p>
                    </div>
                    <div class="col">
                        <p>{{ $task->name }}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <p>{{ __('Description') }}</p>
                    </div>
                    <div class="col">
                        <p>{{ $task->description ?? '--' }}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <p>{{ __('Status') }}</p>
                    </div>
                    <div class="col {{ $task->status_id == 4 ? 'text-success' : '' }}">
                        <p>{{ $task->status->name }}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <p>{{ __('Creator') }}</p>
                    </div>
                    <div class="col">
                        <p>
                            <a href="{{ $task->creator->trashed() ? '' : route('users.show', $task->creator) }}">
                                {{ $task->creator->name }}
                            </a>
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <p>{{ __('Executor') }}</p>
                    </div>
                    <div class="col">
                        <p>
                            @if($task->assignedTo)
                                <a href="{{ $task->assignedTo->trashed() ? '' : route('users.show', $task->assignedTo) }}">
                                    {{ $task->assignedTo->name }}
                                </a>
                                @if($currentUser == $task->assignedTo)
                                    <div class="btn btn-secondary">
                                        <a href="{{ route('tasks.abandon_task', $task) }}" data-method="PATCH" class="text-white">
                                            {{ __('Abandon task') }}
                                        </a>
                                    </div>
                                @endif
                            @else
                                {{ __('not assigned') }}
                                @auth
                                    <div class="btn btn-secondary">
                                        <a href="{{ route('tasks.get_task', $task) }}" data-method="PATCH" class="text-white">
                                            {{ __('Get task') }}
                                        </a>
                                    </div>
                                @endauth
                            @endif
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <p>{{ __('Tags') }}</p>
                    </div>
                    <div class="col">
                        @foreach($tags as $tag)
                            <a href="{{ route('tasks.index', ['tag' => $tag->id]) }}">{{ $tag->name }}</a>
                        @endforeach
                    </div>
                </div>
                @if($currentUser == $task->creator || $currentUser == $task->assignedTo)
                    <div class="btn btn-secondary">
                        <a href="{{ route('tasks.edit', $task) }}" class="text-white">
                            {{ __('Chenge task') }}
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="col">
        @if(sizeof($task->comments) > 0)
        <div class="card border-light">
            <div class="card-header bg-secondary text-white text-center big-text">
                {{ __('Comments') }}
            </div>
            <div class="card-body p-0">
                @foreach($task->comments()->orderBy('created_at')->get() as $comment)
                <div class="card my-2">
                    <div class="card-body">
                        <div>
                            {{ __('Date') }}:
                            {{ $comment->created_at }}
                        </div>
                        <div>
                            {{ __('Author') }}
                            <a href="{{ $comment->creator->trashed() ? '' : route('users.show', $comment->creator) }}">
                                {{ $comment->creator->name }}
                            </a>
                        </div>
                        <div>
                            {{ $comment->body }}
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
        @auth
        <div class="card border-light">
            <div class="card-header bg-secondary text-white text-center big-text">
                {{ __('Add new comment') }}
            </div>
            <div class="card-body">
                {{ Form::model($comment, [
                    'url' => route('users.comments.store', $currentUser),
                    'method' => 'POST']) }}
                @csrf
                    <div class="form-group row">
                            <textarea id="body" class="form-control" name="body" rows="3">{{ old('body') }}</textarea>
                    </div>
                    <input type="hidden" name="task_id" id="task_id" value="{{ $task->id }}">
                    <div class="form-group row">
                        <button type="submit" class="btn btn-secondary col-sm-3">
                            {{ __('Save') }}
                        </button>
                    </div>
                {{ Form::close()}}
            </div>
        </div>
        @endauth
    </div>
</div>
@endsection