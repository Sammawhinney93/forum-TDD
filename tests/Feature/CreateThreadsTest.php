<?php

namespace Tests\Feature;

use App\Thread;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use function Tests\utilities\create;
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
        $thread = create(Thread::class);

        $this->post('/threads', $thread->toArray());

        // Then when we visit the thread page.
        $this->get($thread->path())
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }

    /**
     * @test
     */
    public function guests_may_not_create_threads()
    {
        $this->withExceptionHandling();

        $this->get('/threads/create')
            ->assertRedirect('/login');

        $this->post('/threads')
            ->assertRedirect('/login');
    }
}
