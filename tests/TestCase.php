<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, CreatesUsers;

    public function setUp()
    {
        parent::setUp();
        $this->artisan('db:seed');
    }
}
