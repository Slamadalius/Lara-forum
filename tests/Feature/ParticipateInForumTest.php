<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ParticipateInForum extends TestCase
{
    //using Database Migrations because for testing we are using sqlite 
    use DatabaseMigrations;

    /** @test */
    public function unauthenticated_users_may_not_add_replies()
    {
        $this->withExceptionHandling()
            ->post('/threads/some-channel/1/replies', [])
            ->assertRedirect('/login');
    }

    /** @test */
    public function an_authenticated_user_may_participate_in_forum_threads()
    {
        //Sets the currently logged user for the application (helper function in testCase)
        $this->signIn(); // creating user


        //Creating a thread
        $thread = factory('App\Thread')->create();

        $reply = factory('App\Reply')->make();

        //When reply is added to a thread.
        $this->post($thread->path() . '/replies', $reply->toArray());

        //Then reply should be visible on a page
        $this->get($thread->path())
            ->assertSee($reply->body);
    }

    /** @test */
    public function a_reply_requires_a_body()
    {
        $this->withExceptionHandling()->signIn();

        $thread = create('App\Thread');
        $reply = make('App\Reply', ['body'=>null]);

        $this->post($thread->path() . '/replies', $reply->toArray())
            ->assertSessionHasErrors('body');
    }
}
