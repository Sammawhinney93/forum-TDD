<?php

namespace Tests\Feature;

use App\Reply;
use App\Thread;
use App\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use function Tests\utilities\create;
use function Tests\utilities\make;

class ParticipateForumTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function an_authenticated_user_may_participate_in_forum_threads()
    {
        // given we have a authenticated user
        $this->signIn();

        // And an existing record
        $thread = create(Thread::class);

        // when the user adds a reply to the thread
        $reply = make(Reply::class);
        $this->post($thread->path().'/replies', $reply->toArray());

        // Then their reply should be visible on the page
        $this->get($thread->path())
            ->assertSee($reply->body);
    }

    /**
     * @test
     */
    public function unauthentiated_users_may_not_participate()
    {
        // throw an exception if user isnt logged in
        $this->expectException(AuthenticationException::class);

        // post request for replies
        $this->post('/threads/1/replies', []);
    }
}
