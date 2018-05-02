<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function signIn($user=null)
    {
        //if user is passed create a user
        $user = $user ? : create('App\User');

        //and sign him in
        $this->be($user);
        
        return $this;
    }

    protected function setUp()
    {
        parent::setUp();
        //Creating a setUp for testing that every test is handled without Exception
        $this->withoutExceptionHandling();
    }
}
