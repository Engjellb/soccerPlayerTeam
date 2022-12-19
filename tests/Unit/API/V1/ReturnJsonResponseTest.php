<?php

namespace Tests\Unit\API\V1;

use App\Http\Middleware\ReturnJsonResponseMiddleware;

use Illuminate\Http\Request;
use PHPUnit\Framework\TestCase;

class ReturnJsonResponseTest extends TestCase
{
    public function test_accept_header_application_json_is_set()
    {
        $request = new Request();
        $next = function (Request $request) use (&$called) {
            $called = true;
        };

        $middleware = new ReturnJsonResponseMiddleware();
        $middleware->handle($request, $next);

        $this->assertEquals('application/json', $request->header('Accept')) ;
    }
}
