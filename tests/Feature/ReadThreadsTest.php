<?php

namespace Tests\Feature;

use App\Thread;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ThreadsTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        //because we are extending TestCase 
        parent::setUp();

        //Creating a thread (helper function from functions.php)
        $this->thread = create('App\Thread');
    }
    
    /** @test */
    public function a_user_can_browse_all_threads()
    {
        //getting threads
        $this->get('/threads')
            ->assertSee($this->thread->title); //asserting to see threads title
    }

    /** @test */
    public function a_user_can_read_single_thread()
    { 
        //getting one thread by its id
        $this->get($this->thread->path())
            ->assertSee($this->thread->title); //asserting to see threads title
    }

    /** @test */
    public function a_user_can_read_replies_that_are_associated_with_a_thread()
    {
        //Add a reply to a thread
        $reply = create('App\Reply', ['thread_id'=>$this->thread->id]);

        //getting one thread by its id
        $this->get($this->thread->path())
            ->assertSee($reply->body); //asserting to see reply body
    }

    /** @test */
    public function a_user_can_filter_threads_according_to_a_tag()
    {
        //Creating a channel
        $channel = create('App\Channel');

        //Creating a new Thread and associating with created channel
        $threadInChannel = create('App\Thread', ['channel_id'=>$channel->id]);

        //Creating a new Thread without associating with created channel
        $threadNotInChannel = create('App\Thread');

        $this->get('/threads/'. $channel->slug)
            ->assertSee($threadInChannel->title)
            ->assertDontSee($threadNotInChannel->title);
    }

    /** @test */
    public function a_user_can_filter_threads_by_any_username()
    {
        $this->signIn(create('App\User', ['name' => 'JohnDoe']));

        $threadByJohn = create('App\Thread', ['user_id' => auth()->id()]);
        $threadNotByJohn = create('App\Thread');

        $this->get('threads?by=JohnDoe')
            ->assertSee($threadByJohn->title)
            ->assertDontSee($threadNotByJohn->title);
    }

    /** @test */
    public function a_user_can_filter_threads_by_popularity()
    {
        //Given that we have 3 threads with different number of replies
        $threadWithTwoReplies = create('App\Thread');
        create('App\Reply', ['thread_id'=>$threadWithTwoReplies->id], 2);
        
        $threadWithThreeReplies = create('App\Thread');
        create('App\Reply',['thread_id'=>$threadWithThreeReplies->id], 3);

        $threadWithZeroReplies = $this->thread;

        //filtering all threads by popularity, and getting json to check the order]
        $response = $this->getJson('threads?popular=1')->json();

        //threads should be returned from most replies to least
        $this->assertEquals([3,2,0], array_column($response, 'replies_count'));
    }
}
