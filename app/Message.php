<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = ['from_id', 'to_id', 'content'];

    public function fromUser()
    {
        return $this->belongsTo('App\User', 'from_id', 'id');
    }

    public function toUser()
    {
        return $this->belongsTo('App\User', 'to_id', 'id');
    }
}
