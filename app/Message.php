<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = ['from_id', 'to_id', 'content'];

    /**
     * From User instance
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function fromUser()
    {
        return $this->belongsTo('App\User', 'from_id', 'id');
    }

    /**
     * To User instance
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function toUser()
    {
        return $this->belongsTo('App\User', 'to_id', 'id');
    }
}
