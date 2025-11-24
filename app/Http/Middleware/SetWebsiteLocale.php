<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SetWebsiteLocale
{
    /**
     * @var array<string>
     */
    protected array $availableLocales = ['en', 'sw'];

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $locale = $request->session()->get('website_locale', config('app.locale'));

        if (! in_array($locale, $this->availableLocales, true)) {
            $locale = config('app.locale');
        }

        App::setLocale($locale);

        return $next($request);
    }
}

