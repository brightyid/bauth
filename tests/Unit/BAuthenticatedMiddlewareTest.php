<?php

namespace Brighty\BAuth\Tests\Feature;

use Brighty\BAuth\Facades\BAuth;
use Brighty\BAuth\Http\Middleware\BAuthenticated;
use Brighty\BAuth\Tests\TestCase;
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
