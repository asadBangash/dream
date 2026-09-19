<?php

namespace App\Http\Middleware;

use Illuminate\Routing\Middleware\ThrottleRequests;
use Illuminate\Http\Exceptions\ThrottleRequestsException;

class CustomThrottleRequests extends ThrottleRequests
{
    protected function buildException($request, $key, $maxAttempts, $retryAfter = null, array $headers = [])
    {
       
        $retryAfter = $retryAfter ?? $this->getTimeUntilNextRetry($key);


        return response()->view('errors.throttle', ['retryAfter' => $retryAfter], 429)
                         ->withHeaders($headers);
    }
}
