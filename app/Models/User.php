<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // отношение многие ко многим, список друзей пользователя
    public function friendsOfMine()
    {
        return $this->belongsToMany('App\Models\User', 'friends','user_id','friend_id');
    }

    // установление отношения многие ко многим уже у друга
    public function friendOf() {
        return $this->belongsToMany('App\Models\User', 'friends','friend_id','user_id');
    }

    // получить список друзей
    public function friends()
    {
        return $this->friendsOfMine()->wherePivot('accepted',true)->get()
            ->merge( $this->friendOf()->wherePivot('accepted',true)->get() );
    }

    // запросы в друзья
    public function friendRequests()
    {
        return $this->friendsOfMine()->wherePivot('accepted',false)->get();
    }

    // запрос на ожидения заявки в друзья
    public function friendRequestsPending()
    {
        return $this->friendOf()->wherePivot('accepted', false)->get();
    }

    // наличие запроса на добавление в друзья
    public function hasFriendRequestPending(User $user)
    {
        return (bool) $this->friendRequestsPending()->where('id', $user->id)->count();
    }

    // получение запроса в друзья
    public function hasFriendRequestReceived(User $user)
    {
        return (bool) $this->friendRequests()->where('id', $user->id)->count();
    }

    // добавление друга
    public function addFriend(User $user)
    {
        $this->friendOf()->attach($user->id);
    }

    // принятие запроса дружбы
    public function acceptFriendRequest(User $user)
    {
        $this->friendRequests()->where('id', $user->id)->first()->pivot->update([
            'accepted' => true
        ]);
    }

    public function denyFriendRequest(User $user)
    {
        $this->friendRequests()->where('id', $user->id)->first()->pivot->update([
            'accepted' => false
        ]);
    }

    // пользователь уже в друзьях
    public function isFriendWith(User $user) {
        return (bool) $this->friends()->where('id', $user->id)->count();
    }
}
