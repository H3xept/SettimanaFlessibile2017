<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    public function sessions()
    {
        return $this->hasMany('App\Session');
    }

    protected $fillable = [
        'name', 'desc', 'ref','pRef','ext','progr','f1','f2','f3','f4','f5','f6','f7','f8','f9'
    ];
}
