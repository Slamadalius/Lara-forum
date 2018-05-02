<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ChannelTest extends TestCase
{
    //using Database Migrations because for testing we are using sqlite 
    use DatabaseMigrations;

    /** @test */
    public function it_has_many_threads()
    {
        //Creating a channel
        $channel = create('App\Channel');

        //Creating a new Thread and associating with created channel
        $thread = create('App\Thread', ['channel_id'=>$channel->id]);

        //Assert that a channel contains a thread we just created
        $this->assertTrue($channel->threads->contains($thread));
    }
}
