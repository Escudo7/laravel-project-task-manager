@extends('layouts.app')

@section('header')
{{ __('users.index.header') }}
@endsection

@section('content')
    <table class="table table-hover table-bordered">
        <tr class="bg-secondary text-center text-white">
            <th>№</th>
            <th>{{ __('NicName') }}</th>
            <th>{{ __('First name') }}</th>
            <th>{{ __('Last name') }}</th>
            <th>{{ __('Registration date') }}</th>
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