<?php

namespace Tests\Feature;

use App\Reply;
use App\Thread;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use function Tests\utilities\create;
use function Tests\utilities\make;

class ParticipateInThreadsTest extends TestCase
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
        $this->post($thread->path() . '/replies', $reply->toArray());

        // Then their reply should be visible on the page
        $this->get($thread->path())
            ->assertSee($reply->body);
    }

    /**
     * @test
     */
    public function unauthentiated_users_may_not_participate()
    {
        // post request for replies
        $this->withExceptionHandling()
            ->post('/threads/some-channel/1/replies', [])
            ->assertRedirect('/login');
    }

    /**
     * @test
     */
    public function a_reply_requires_a_body()
    {
        $this->withExceptionHandling()->signIn();

        $thread = create(Thread::class);

        $reply = make(Reply::class, ['body' => null]);

        $this->post($thread->path() . '/replies', $reply->toArray())
            ->assertSessionHasErrors('body');
    }

    /**
     * @test
     */
    function unauthorized_users_cannot_delete_replies()
    {
        $this->withExceptionHandling();

        $reply = create('App\Reply');

        $this->delete("/replies/{$reply->id}")
            ->assertRedirect('login');

        $this->signIn()
            ->delete("/replies/{$reply->id}")
            ->assertStatus(403);
    }

    /**
     * @test
     */
    function authorized_users_can_delete_replies()
    {
        $this->signIn();
        $reply = create('App\Reply', ['user_id' => auth()->id()]);

        $this->delete("/replies/{$reply->id}")->assertStatus(302);

        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
    }

    /**
     * @test
     */
    function unauthorized_users_cannot_update_replies()
    {
        $this->withExceptionHandling();

        $reply = create('App\Reply');

        $this->patch("/replies/{$reply->id}")
            ->assertRedirect('login');

        $this->signIn()
            ->patch("/replies/{$reply->id}")
            ->assertStatus(403);
    }

    /**
     * @test
     */
    function authorized_users_can_update_replies()
    {
        $this->signIn();

        $reply = create('App\Reply', ['user_id' => auth()->id()]);

        $updatedReply = 'You been changed, fool.';
        $this->patch("/replies/{$reply->id}", ['body' => $updatedReply]);

        $this->assertDatabaseHas('replies', ['id' => $reply->id, 'body' => $updatedReply]);
    }
}
