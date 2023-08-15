<?php

namespace Brighty\BAuth\Tests\Feature;

use Brighty\BAuth\Facades\BAuth;
use Anik\Testbench\TestCase;

class BAuthTest extends TestCase
{

    /** @test */
    public function it_can_validate_token()
    {
        $token = '';

        $response = BAuth::set($token)->validate();
        $this->assertEquals('200', $response->getStatusCode());
    }

    /** @test */
    public function it_can_get_user()
    {
        $token = '';

        $response = BAuth::set($token)->user();
        $this->assertEquals('200', $response->getStatusCode());
    }
}
