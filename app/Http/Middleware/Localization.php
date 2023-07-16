<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;

class Localization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $language = $request->input('language') ?? $request->header('Accept-Language');

        if ($language) {
            session()->put('language', $language);
        }

        if (session()->has('language')) {
            App::setLocale(session()->get('language'));
        }

        return $next($request);
    }
}
