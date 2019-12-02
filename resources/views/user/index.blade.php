@extends('layouts.app')

@section('header')
{{ __('users.index.header') }}
@endsection

@section('content')
    <table class="table table-hover table-bordered">
        <tr class="bg-secondary text-center text-white">
            <th>№</th>
            <th>{{ __('users.index.nicname') }}</th>
            <th>{{ __('users.index.first_name') }}</th>
            <th>{{ __('users.index.last_name') }}</th>
            <th>{{ __('users.index.registration_date') }}</th>
        </tr>
        @foreach($users as $user)
        <tr>
            <td>{{$user->id}}</a></td>
            <td><a href="{{ route('users.show', $user) }}">{{$user->name}}</a></td>
            <td>{{ $user->firstname ?? '--' }}</td>
            <td>{{ $user->lastname ?? '--'}}</td>
            <td>{{ $user->created_at }}</td>
        <tr>
        @endforeach
    </table>

    {{ $users->links() }}
    
@endsection