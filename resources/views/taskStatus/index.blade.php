@extends('layouts.app')

@section('header')
{{ __('List of task statuses') }}
@endsection

@section('content')
<div class="row justify-content-center">
<table class="table table-hover table-bordered col-sm-8">
    <tr class="bg-secondary text-center text-white">
        <th>№</th>
        <th>{{ __('Name') }}</th>
        <th colspan="2">{{ __('Status management') }}</th>
    </tr>
    @foreach($statuses as $status)
        <tr>
            <td>{{ $status->id }}</td>
            <td class="{{ $status->id == 4 ? 'text-success' : '' }}">{{ $status->name }}</td>
            <td>
                <div class="btn btn-primary">
                    <a href="{{ route('task_statuses.edit', $status) }}" class="text-white">{{ __('Change name') }}</a>
                </div>
            </td>
            <td>
                <div class="btn btn-primary">
                    <a href="{{ route('task_statuses.destroy', $status) }}" data-confirm="{{ __('Are you sure?') }}" data-method="delete" class="text-white">{{ __('Delete status') }}</a>
                </div>
            </td>
        <tr>
    @endforeach
    <tr>
        <td colspan="4">
            <div class="btn btn-secondary ml-3">
                <a href="{{ route('task_statuses.create') }}" class="text-white">{{ __('Create new status') }}</a>
            </div>
        </td>
    </tr>
</table>
</div>

@endsection