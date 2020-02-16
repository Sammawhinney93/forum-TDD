<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    protected $guarded = [];
    /**
     * One to many inverse, a reply belongs to a owner(user)
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
