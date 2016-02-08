<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    //
    public $timestamps = false;
    protected $dates=['sent_at'];
    protected $fillable=[
        'username',
        'name',
        'message_contents',
        'sent_at',
        ];
        
    protected $hidden=[
        
        ];
}
