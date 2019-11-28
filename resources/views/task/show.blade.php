@extends('layouts.app')

@section('header', 'просмотр задачи')

@section('content')
<div class="card-group col-sm">
    <div class="col">
        <div class="card">
            <div class="card-header bg-secondary text-white text-center big-text">
                Задача
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <p>Название</p>
                    </div>
                    <div class="col">
                        <p>{{ $task->name }}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <p>Описание</p>
                    </div>
                    <div class="col">
                        <p>{{ $task->description ?? '--' }}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <p>Статус</p>
                    </div>
                    <div class="col {{ $task->status_id == 4 ? 'text-success' : '' }}">
                        <p>{{ $task->status->name }}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <p>Создатель</p>
                    </div>
                    <div class="col">
                        <p>
                            <a href="{{ route('users.show', $task->creator) }}">
                                {{ $task->creator->name }}
                            </a>
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <p>Ответственный</p>
                    </div>
                    <div class="col">
                        <p>
                            @if($task->assignedTo)
                                <a href="{{ route('users.show', $task->assignedTo) }}">
                                    {{ $task->assignedTo->name }}
                                </a>
                                @if($currentUser == $task->assignedTo)
                                    <div class="btn btn-secondary">
                                        <a href="{{ route('tasks.deny_task', $task) }}" data-method="PATCH" class="text-white">
                                            Отказаться от задачи
                                        </a>
                                    </div>
                                @endif
                            @else
                                не назначен
                                @if(Auth::check())
                                    <div class="btn btn-secondary">
                                        <a href="{{ route('tasks.get_task', $task) }}" data-method="PATCH" class="text-white">
                                            Забрать задачу
                                        </a>
                                    </div>
                                @endif
                            @endif
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <p>Теги</p>
                    </div>
                    <div class="col">
                        @foreach($tags as $tag)
                            {{ $tag->name }}
                        @endforeach
                    </div>
                </div>
                @if($currentUser == $task->creator || $currentUser == $task->assignedTo)
                    <div class="btn btn-secondary">
                        <a href="{{ route('tasks.edit', $task) }}" class="text-white">
                            Изменить задачу
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
                Комментарии
            </div>
            <div class="card-body">
                @foreach($task->comments as $comment)
                    {{ $comment->body }}
                @endforeach
            </div>
        </div>
        @endif
        <div class="card border-light">
            <div class="card-header bg-secondary text-white text-center big-text">
                Добавить новый комментарий
            </div>
            <div class="card-body">
                {{ Form::model($comment, [
                    'url' => route('users.comments.store', [$currentUser, $comment]),
                    'method' => 'POST']) }}
                @csrf
                    <div class="form-group row">
                            <textarea id="newComment" class="form-control" name="newComment" rows="3">{{ old('newComment') }}</textarea>
                    </div>
                    <div class="form-group row">
                        <button type="submit" class="btn btn-secondary">
                            Сохранить
                        </button>
                    </div>
                {{ Form::close()}}
            </div>
        </div>
    </div>
</div>
@endsection