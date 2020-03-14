<?php
declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    protected $guarded = [];

    /**
     * Fetch the path to the current thread.
     *
     * @return string
     */
    public function path(): string
    {
        return "/threads/{$this->channel->slug}/{$this->id}";
    }
    /**
     * One to many, a Thread has many replies
     */
    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    /**
     *  One to many (inverse) threads can belong to a creator(User)
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * One to many (inverse) threads can belong to a channel
     */
    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    /**
     * Used to create a reply relation
     */
    public function addReply($reply)
    {
        $this->replies()->create($reply);
    }
}
