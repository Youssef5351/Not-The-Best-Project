<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;
use Illuminate\Http\Request;
use Illuminate\Session\TokenMismatchException;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        'register',
        'login',
        'api/*',
        // Add other routes that should be excluded from CSRF verification
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     *
     * @throws \Illuminate\Session\TokenMismatchException
     */
    protected function handle($request, \Closure $next)
    {
        if ($this->isReading($request) ||
            $this->runningUnitTests() ||
            $this->inExceptArray($request) ||
            $this->tokensMatch($request)) {

            return $this->addCookieToResponse($request, $next($request));
        }

        \Log::error('CSRF token mismatch', [
            'url' => $request->url(),
            'method' => $request->method(),
            'input' => $request->except(['password', 'password_confirmation']), // Don't log passwords
            'token' => $request->input('_token'),
            'headers' => $request->headers->all(),
        ]);

        throw new TokenMismatchException('CSRF token mismatch.');
    }
}