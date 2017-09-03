<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    public function sessions()
    {
        return $this->belongsToMany('App\Session');
    }
    public function tickets()
    {
        return $this->hasMany('App\Ticket');
    }
    public function roles()
    {
        return $this->belongsToMany('App\Role');
    }
    public function hasEqualOrGreaterPermissionLevel($perm)
    {
        if(count($this->roles()->where('level','>=',$perm)->get()->toArray())==0){return false;}
        return true;
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','surname', 'username', 'password','class','f1','f2','f3','f4','f5','f6','f7','f8','f9'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
