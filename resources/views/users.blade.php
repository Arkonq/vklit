@extends('layouts.app')

@section('title-block', 'Users')

@section('content')
    <h1>Users</h1>
    @if($users->count() < 1)
        Nobody is Registered except You
    @endif

    @foreach($users as $user)
            @include('users.partial.userblock')
            <a href="{{ route('friends.add', ['name' => $user->name])  }}" class="btn btn-primary mb-2">Add friend</a>
    @endforeach
@endsection
