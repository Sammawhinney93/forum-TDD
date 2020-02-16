<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    // function used for the authenticated user to be re-used throughout testing for readability
    public function signIn($user)
    {
        $this->be($user);
    }
}
