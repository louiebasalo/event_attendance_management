<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\event;

class ExampleTest extends TestCase
{

	use DatabaseTransactions;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {

    	$this->seeInDatabase('users', ['email' => 'louiebasalo7@gmail.com']);
        // $this->assertTrue(true);
    }
}
