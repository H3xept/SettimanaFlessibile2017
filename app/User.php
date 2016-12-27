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
        'name', 'username', 'password','class'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

 public function getRememberToken()
 {
   return null; // not supported
 }

 public function setRememberToken($value)
 {
   // not supported
 }

 public function getRememberTokenName()
 {
   return null; // not supported
 }

 /**
  * Overrides the method to ignore the remember token.
  */
 public function setAttribute($key, $value)
 {
   $isRememberTokenAttribute = $key == $this->getRememberTokenName();
   if (!$isRememberTokenAttribute)
   {
     parent::setAttribute($key, $value);
   }
 }
}
