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
            <td>
                @if ($task->assignedTo)
                    <a href="{{ route('users.show', $task->assignedTo) }}">{{ $task->assignedTo->name }}</a>
                @else 
                    не назначен
                @endif
            </td>
            @if($task->status->id == 1)
                <td class="text-warning">
                    {{ $task->status->name }}
                </td>
            @elseif($task->status->id == 4)
                <td class="text-success">
                    {{ $task->status->name }}
                </td>
            @else
                <td>
                    {{ $task->status->name }}
                </td>
            @endif
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