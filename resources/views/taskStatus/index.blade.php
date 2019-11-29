@extends('layouts.app')

@section('header', 'список статусов задач')

@section('content')
<div class="row justify-content-center">
<table class="table table-hover table-bordered col-sm-8">
    <tr class="bg-secondary text-center text-white">
        <th>№</th>
        <th>Название</th>
        <th colspan="2">Управление статусом</th>
    </tr>
    @foreach($statuses as $status)
        <tr>
            <td>{{ $status->id }}</td>
            <td class="{{ $status->id == 4 ? 'text-success' : '' }}">{{ $status->name }}</td>
            <td>
                <div class="btn botton-color">
                    <a href="{{ route('task_statuses.edit', $status) }}" class="text-white">Изменить название</a>
                </div>
            </td>
            <td>
                <div class="btn botton-color">
                    <a href="{{ route('task_statuses.destroy', $status) }}" data-confirm="Вы уверены?" data-method="delete" class="text-white">Удалить статус</a>
                </div>
            </td>
        <tr>
    @endforeach
    <tr>
        <td colspan="4">
            <div class="btn btn-secondary ml-3">
                <a href="{{ route('task_statuses.create') }}" class="text-white">Создать новый статус</a>
            </div>
        </td>
    </tr>
</table>
</div>

@endsection