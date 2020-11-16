<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\User;
use Illuminate\Http\Request;


class FriendsController extends Controller
{
    public function getIndex(){
        $friends = Auth::user()->friends();
        $requests = Auth::user()->friendRequests();
        $users = User::all()->where('id', '!=', auth()->user()->id);

        return view('friends.index', [
            'friends' => $friends,
            'requests' => $requests,
            'users' => $users
        ]);
    }

    public function getAdd($name)
    {
        $user = User::where('name', $name)->first();

        if( !$user ) {
            return redirect()
                ->route('users')
                ->with('error', 'User is not found');
        }

        if( Auth::user()->hasFriendRequestPending($user)
            || $user->hasFriendRequestPending(Auth::user()) ) {
            return redirect()
                ->route('friends.index')
                ->with('success', 'Friend Request is sent already');
        }

        if ( Auth::user()->isFriendWith($user)) {
            return redirect()
                ->route('friends.index')
                ->with('success', 'You are friends already');
        }
        Auth::user()->addFriend($user);
        return redirect()
            ->route('friends.index')
            ->with('success', 'Friend Request is sent');
    }

    public function getAccept($name){
        $user = User::where('name', $name)->first();

        if( !$user ) {
            return redirect()
                ->route('users')
                ->with('error', 'User is not found');
        }

        if ( !Auth::user()->hasFriendRequestReceived($user)) {
            return redirect()
                ->route('friends');
        }

        Auth::user()->acceptFriendRequest($user);
        return redirect()
            ->route('friends.index')
            ->with('success', 'Friend is added successfully!');
    }
}
