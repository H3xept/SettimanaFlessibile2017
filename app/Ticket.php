<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
        'title', 'desc', 'addr','username'
    ];
}
