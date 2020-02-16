<?php

namespace Tests\Unit;

use App\Reply;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ReplyTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_has_an_owner()
    {
        // creates a reply
        $reply = factory(Reply::class)->create();

        // inserts that the reply belongs to an owner
        $this->assertInstanceOf(User::class, $reply->owner);
    }
}
