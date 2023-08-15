<?php

namespace Brighty\BAuth\Tests\Feature;

use Brighty\BAuth\Http\Middleware\BAuthenticated;
use Anik\Testbench\TestCase;
use Illuminate\Http\Request;

class BAuthenticatedMiddlewareTest extends TestCase
{

    /** @test */
    public function it_check_is_authenticated()
    {
        $token = '';

        $request = new Request();
        $request->headers->set('Authorization', 'Bearer ' . $token);

        (new BAuthenticated())->handle($request, function ($request) {
            $this->assertEquals('success', $request->user['status']);
        });
    }

    
}
