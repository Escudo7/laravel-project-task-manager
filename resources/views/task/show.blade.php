@extends('layouts.app')

@section('header', 'просмотр задачи')

@section('content')
<div class="container">
        <div class="row justify-content-center">
            <div class="card-group col-sm-12">
            <div class="col-sm-8">
                <div class="card">
                    <div class="card-header bg-secondary text-white text-center big-text">
                        Задача
                    </div>
                    <div class="card-body">
                        <div class="row big-text">
                            <div class="col-sm-4">
                                <p>Название</p>
                            </div>
                            <div class="col-sm-4">
                                <p>{{ $task->name }}</p>
                            </div>
                        </div>
                        <div class="row big-text">
                            <div class="col-sm-4">
                                <p>Описание</p>
                            </div>
                            <div class="col-sm-4">
                                <p>{{ $task->description ?? '--' }}</p>
                            </div>
                        </div>
                        <div class="row big-text">
                            <div class="col-sm-4">
                                <p>Статус</p>
                            </div>
                            <div class="col-sm-4">
                                <p>{{ $task->status->name }}</p>
                            </div>
                        </div>
                        <div class="row big-text">
                            <div class="col-sm-4">
                                <p>Создатель</p>
                            </div>
                            <div class="col-sm-4">
                                <p>
                                    <a href="{{ route('users.show', $task->creator) }}">
                                        {{ $task->creator->name }}
                                    </a>
                                </p>
                            </div>
                        </div>
                        <div class="row big-text">
                            <div class="col-sm-4">
                                <p>Ответственный</p>
                            </div>
                            <div class="col-sm-8">
                                <p>
                                    @if($task->assignedTo)
                                        <a href="{{ route('users.show', $task->assignedTo) }}">
                                            {{ $task->assignedTo->name }}
                                        </a>
                                    @else
                                        не назначен
                                        <div class="btn btn-secondary">
                                            <a href="{{ route('tasks.get_task', $task) }}" data-method="PATCH" class="text-white">
                                                Забрать задачу
                                            </a>
                                        </div>
                                    @endif

                                </p>
                            </div>
                        </div>
                        <div class="row big-text">
                            <div class="col-sm-4">
                                <p>Теги</p>
                            </div>
                            <div class="col-sm-8">
                                <p>
                                    @foreach($tags as $tag)
                                        <space>   {{ $tag->name }}</space>
                                    @endforeach
                                </p>
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
                <div class="col-sm-4">
                    <p>Здесь будут комментарии</p>
                </div>
            </div>
        </div>
    </div>
@endsection