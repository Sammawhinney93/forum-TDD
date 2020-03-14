<?php

namespace Tests\Unit;

use App\Channel;
use App\Thread;
use App\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use function Tests\utilities\create;
use function Tests\utilities\make;

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
        $this->thread = create(Thread::class);
    }

    /**
     * @test
     */
    public function a_thread_can_make_a_string_path()
    {
        $thread = create(Thread::class);

        $this->assertEquals(
            "/threads/{$thread->channel->slug}/{$thread->id}", $thread->path()
        );
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

    /**
     * @test
     */
    public function a_thread_belongs_to_a_channel()
    {
        $thread = create(Thread::class);

        $this->assertInstanceOf(Channel::class, $thread->channel);
    }
}
