<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
  	public function course()
  	{
    	return $this->belongsTo('App\Course');
  	}
  	
    public function users()
    {
        return $this->belongsToMany('App\User');
    }

    protected $fillable = [
        'course_id','f1', 'f2', 'f3','f4','f5','f6','f7','f8','f9'
    ];
	public $timestamps = false;
}