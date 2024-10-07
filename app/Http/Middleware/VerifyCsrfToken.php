<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * Indicates whether the XSRF-TOKEN cookie should be set on the response.
     *
     * @var bool
     */
    protected $addHttpCookie = true;

    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'ar/return-trip-booking',
        'ur/return-trip-booking',
        '/return-trip-booking',
        'ar/return-order',
        'ur/return-order',
        '/return-order',
        'ar/return-ship-booking',
        'ur/return-ship-booking',
        '/return-ship-booking',
        '/check-in-submit',
        '/ship-check-in-submit',
        '/check-out-submit',
        '/ship-check-out-submit',
    ];
}
