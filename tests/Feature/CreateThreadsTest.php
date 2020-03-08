<?php

namespace Tests\Feature;

use App\Thread;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use function Tests\utilities\make;

class CreateThreadsTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function an_authenticated_user_can_create_form_threads()
    {
        // given we have a signed in user
        $this->signIn();

        // when we hit the endpoint to create a new thread
        $thread = make(Thread::class);

        $this->post('/threads', $thread->toArray());

        // Then when we visit the thread page.
        $this->get($thread->path())
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }

    /**
     * @test
     */
    public function guests_may_not_make_threads()
    {
        // asserts exception for unauthentication
        $this->expectException(AuthenticationException::class);

        // creates a thread
        $thread = make(Thread::class);

        // posts thread
        $this->post('/threads', $thread->toArray());
    }
}
