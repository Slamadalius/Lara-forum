<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ReplyTest extends TestCase
{
    //using Database Migrations because for testing we are using sqlite 
    use DatabaseMigrations;

    /** @test */
    public function it_has_an_owner()
    {
        //creating a reply
        $reply = create('App\Reply');


        $this->assertInstanceOf('App\User', $reply->owner);
    }
}
