<?php

namespace Tests\Unit;

use App\Thread;
use App\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ThreadTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @var Thread
     */
    protected $thread;

    public function setUp(): void
    {
        parent::setUp();

        // add thread creation to setup to reduce repeated code within test
        $this->thread = factory(Thread::class)->create();
    }

    /**
     * @test
     */
    public function a_thread_has_replies()
    {
        // inserts that a thread collection contains replies
        $this->assertInstanceOf(Collection::class, $this->thread->replies);
    }

    /**
     * @test
     */
    public function a_thread_has_a_creator()
    {
        // inserts that a thread is owned by a user
        $this->assertInstanceOf(User::class, $this->thread->creator);
    }

    /**
     * @test
     */
    public function a_thread_can_add_a_reply()
    {
        // creates a reply with the given array of data
        $this->thread->addReply([
            'body' => 'Foobar',
            'user_id' => 1
        ]);

        // asserts that a thread contains 1 reply
        $this->assertCount(1, $this->thread->replies);
    }
}
