<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class FavoritesTest extends TestCase
{
    //using Database Migrations because for testing we are using sqlite 
    use DatabaseMigrations;

    /** @test */
    public function unauthenticated_user_cant_favorite_anyting()
    {
        //post to a favorites route when "button" is clicked
        $this->withExceptionHandling()
            ->post('replies/1/favorites')
            ->assertRedirect('/login');
    }

    /** @test */
    public function an_authenticated_user_can_favorite_any_raply()
    {
        //Sets the currently logged user for the application (helper function in testCase)
        $this->signIn(); // creating user

        $reply = create('App\Reply');

        //post to a favorites route when "button" is clicked
        $this->post('replies/'. $reply->id . '/favorites');

        //assert to see 1 record in favorites relationship
        $this->assertCount(1, $reply->favorites);
    }

    /** @test */
    public function an_authenticated_user_can_favorite_any_raply_only_once()
    {
        //Sets the currently logged user for the application (helper function in testCase)
        $this->signIn(); // creating user

        $reply = create('App\Reply');

        //post to a favorites route when "button" is clicked
        try {
            $this->post('replies/'. $reply->id . '/favorites');
            $this->post('replies/'. $reply->id . '/favorites');
        }catch(\Exception $e){
            $this->fail('Did not expect to add 2 same favorites');
        }

        //assert to see 1 record in favorites relationship
        $this->assertCount(1, $reply->favorites);
    }

    /** @test */
    public function an_authenticated_user_can_unfavorite_reply()
    {
        //Sets the currently logged user for the application (helper function in testCase)
        $this->signIn(); // creating user

        $reply = create('App\Reply');

        //
        $this->post('replies/'. $reply->id . '/favorites');
        $this->post('replies/'. $reply->id . '/unfavorite');

        //assert to see 1 record in favorites relationship
        $this->assertCount(0, $reply->favorites);
    }
}
