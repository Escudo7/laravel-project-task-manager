@extends('layouts.app')

@section('header')
{{ __('Tasks list') }}
@endsection

@section('content')
<div class='col'>
<div class="card mb-2">
<div class="card-body">
@auth
{{ Form::open([
    'url' => route('tasks.index'),
    'method' => 'get'
    ]) }}
    {{ Form::hidden('filter[myTasks]', true) }}
    <div class="form-group col-md-3 pl-3 my-2">
            <button type="submit" class="btn text-white btn-primary btn-block">
                {{ __('My tasks') }}
            </button>
    </div>
{{ Form::close() }}
@endauth

{{ Form::open([
    'url' => route('tasks.index'),
    'method' => 'get'
    ]) }}

    <div class="form-row">
        <div class="form-group col-md-3 pl-4 pr-2 my-2">
            <label for="creator">{{ __('Creator') }}</label>
            <select class="form-control" id="creator" name="creator">
                <option value="">{{ __('not selected') }}</option>
                @foreach($users as $user)
                    @if (isset($_GET['creator']) && $_GET['creator'] == $user->id)
                        <option selected value="{{ $user->id }}">{{ $user->name }}</option>
                    @else
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endif
                @endforeach
            </select>
        </div>

        <div class="form-group col-md-3 my-2">
            <label for="executor">{{ __('Executor') }}</label>
            <select class="form-control" id="executor" name="executor">
                <option value="">{{ __('not selected') }}</option>
                @foreach($users as $user)
                    @if (isset($_GET['executor']) && $_GET['executor'] == $user->id)
                        <option selected value="{{ $user->id }} ">{{ $user->name }}</option>
                    @else
                        <option value="{{ $user->id }} ">{{ $user->name }}</option>
                    @endif
                @endforeach
            </select>
        </div>

        <div class="form-group col-md-3 my-2">
            <label for="status">{{ __('Status') }}</label>
            <select class="form-control" id="status" name="status">
                <option value="">{{ __('not selected') }}</option>
                @foreach($statuses as $status)
                    @if (isset($_GET['status']) && $_GET['status'] == $status->id)
                        <option selected value="{{ $status->id }} ">{{ $status->name }}</option>
                    @else
                        <option value="{{ $status->id }} ">{{ $status->name }}</option>
                    @endif
                @endforeach
            </select>
        </div>

        <div class="form-group col-md-3 pr-4 my-2">
            <label for="tag">{{ __('Tag') }}</label>
            <select class="form-control" id="tag" name="tag">
                <option value="">{{ __('not selected') }}</option>
                @foreach($tags as $tag)
                    @if (isset($_GET['tag']) && $_GET['tag'] == $tag->id)
                        <option selected value="{{ $tag->id }} ">{{ $tag->name }}</option>
                    @else
                        <option value="{{ $tag->id }} ">{{ $tag->name }}</option>
                    @endif
                @endforeach
            </select>
        </div>
    </div>
    
    <div class="form-row mr-3">
        <div class="form-group col-md-3 pl-4 my-2">
            <button type="submit" class="btn btn-primary text-white btn-block">
                {{ __('Apply filter')}}
            </button>
        </div>

        <div class="btn btn-primary text-white m-2 col-md-3 pb-1">
            <a href="{{ route('tasks.index') }}" class="text-white">{{ __('Remove all filters')}}</a>
        </div>
    </div>

{{ Form::close() }}
</div>
</div>
</div>
    <table class="table table-hover table-bordered">
        <tr class="bg-secondary text-center text-white">
            <th>№</th>
            <th>{{ __('Name') }}</th>
            <th>{{ __('Creator') }}</th>
            <th>{{ __('Executor') }}</th>
            <th>{{ __('Status') }}</th>
            <th>{{ __('Creation date')}}</th>
        </tr>
        @foreach($tasks as $task)
        <tr>
            <td>{{$task->id}}</td>
            <td><a href="{{ route('tasks.show', $task) }}">{{$task->name}}</a></td>
            <td>
                <a href="{{ $task->creator->trashed() ? '' : route('users.show', $task->creator) }}">
                    {{ $task->creator->name }}
                </a>
            </td>
            <td>
                @if ($task->executor)
                    <a href="{{ $task->executor->trashed() ? '' : route('users.show', $task->executor) }}">
                        {{ $task->executor->name }}
                    </a>
                @else 
                     {{ __('not assigned') }}
                @endif
            </td>
            <td class="{{ $task->status->id == 4 ? 'text-success' : '' }}">
                {{ $task->status->name }}
            </td>
            <td>{{ $task->created_at }}</td>
        <tr>
        @endforeach
    </table>
    <div class="ml-3 mt-4">
    {{ $tasks->links() }}
    </div>
    @if(Auth::check())
        <div class="btn btn-secondary ml-3 mt-3">
            <a href="{{ route('tasks.create') }}" class="text-white">{{ __('Create new task') }}</a>
        </div>
        <div class="btn btn-secondary ml-3 mt-3">
            <a href="{{ route('task_statuses.index') }}" class="text-white">{{ __('List of task statuses') }}</a>
        </div>
    @endif
@endsection