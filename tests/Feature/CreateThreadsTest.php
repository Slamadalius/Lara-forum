<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CreateThreadsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function an_authenticated_user_can_create_new_forum_threads()
    {
        //Sets the currently logged user for the application (helper function in testCase)
        $this->signIn();

        //When we hit the endpoint to create a new thread
        $thread = make('App\Thread'); 

        $response = $this->post('/threads', $thread->toArray()); //have to call toArray because it expects an array

        //Then we visit the thread page
        $this->get($response->headers->get('Location')) //this gives us /threads/some-channel/id
            //We should see new thread  
            ->assertSee($thread->title)
            ->assertSee($thread->body);            
    }

    /** @test */
    public function a_thread_requires_a_title()
	{
        $this->publishThread(['title'=>null])
            ->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_thread_requires_a_body()
	{
        $this->publishThread(['body'=>null])
            ->assertSessionHasErrors('body');
    }

    /** @test */
    public function a_thread_requires_a_valid_channel()
	{
        factory('App\Channel', 2)->create();

        $this->publishThread(['channel_id'=>null])
            ->assertSessionHasErrors('channel_id');

        //checking if channel_id exist
        $this->publishThread(['channel_id'=>999])
            ->assertSessionHasErrors('channel_id');
    }

    /** @test */
    public function guests_cannot_see_create_threads()
	{
        //as in TestCase setUp function it is without exception handling you have to call with Exception handling
		$this->withExceptionHandling();
        
        $this->get('/threads/create')
            ->assertRedirect('/login');

        $this->post('/threads')
            ->assertRedirect('/login');
    }
    

    public function publishThread($overrides)
    {
        $this->withExceptionHandling()->signIn();
        
        //creating a thread instance with title set to null
        $thread = make('App\Thread', $overrides);

        //post that thread and expect to get an error (validation)
        return $this->post('/threads', $thread->toArray());
    }
}
