@extends('layouts.app')

@section('title-block', 'Friends')

@section('content')
    <div class="row">
        <div class="col-lg-6">
            <h1>Your Friends</h1>

            @if(!$friends->count())
                <p>You don't have any friends :C</p>
            @else
                @foreach($friends as $user)
                    @include('users.partial.userblock')
                @endforeach
            @endif
        </div>
        <div class="col-lg-6">
            <h1>Sent Requests</h1>
            @foreach($users as $user)
                @if( Auth::user()->hasFriendRequestPending($user) )
                    <p>Waiting {{ $user->name }}
                        to accept friend request. </p>
                @endif
            @endforeach
            <h1>Friend Requests</h1>

            @if(!$requests->count())
                <p>You don't have any friend request</p>
            @else
                @foreach($users as $user)
                    @if ( Auth::user()->hasFriendRequestReceived($user) )
                        @include('users.partial.userblock')
                        <a href="{{ route('friends.accept', ['name' => $user->name])  }}" class="btn btn-primary mb-2">Accept friend request</a>
                        <a href="{{ route('friends.deny', ['name' => $user->name])  }}" class="btn btn-danger mb-2">Deny friend request</a>
                    @endif
                @endforeach
            @endif
        </div>
    </div>
@endsection
