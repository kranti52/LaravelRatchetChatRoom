<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChatOnlineUser extends Model
{
    //
    public $timestamps = false;
    protected $dates   = ['logged_in_at'];
    protected $fillable=[
        'username',
        'name',
        'logged_in_at',
        'connection_resource_id',
        ];
        
    protected $hidden=[
        
        ];
}
