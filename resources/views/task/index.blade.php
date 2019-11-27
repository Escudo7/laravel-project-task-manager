@extends('layouts.app')

@section('header', 'список задач')

@section('content')
    <table class="table table-hover table-bordered">
        <tr class="bg-secondary text-center text-white">
            <th>№</th>
            <th>Имя</th>
            <th>Создатель</th>
            <th>Ответственный</th>
            <th>Статус</th>
            <th>Дата создания</th>
        </tr>
        @foreach($tasks as $task)
        <tr>
            <td>{{$task->id}}</a></td>
            <td><a href="{{ route('tasks.show', $task) }}">{{$task->name}}</a></td>
            <td><a href="{{ route('users.show', $task->creator) }}">{{ $task->creator->name }}</a></td>
            <td>{{ $task->assignedTo ? $task->assignedTo->name : 'не назначен' }}</td>
            <td>{{ $task->status->name }}</td>
            <td>{{ $task->created_at }}</td>
        <tr>
        @endforeach
    </table>
    <div class="ml-3 mt-4">
    {{ $tasks->links() }}
    </div>
    @if(Auth::check())
        <div class="btn btn-secondary ml-3 mt-3">
            <a href="{{ route('tasks.create') }}" class="text-white">Создать новую задачу</a>
        </div>
    @endif
@endsection