<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * One to Many relation
     */
    public function threads()
    {
        return $this->hasMany(Thread::class);
    }
}
