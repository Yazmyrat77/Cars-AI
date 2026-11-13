<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Supported locales.
     *
     * @var list<string>
     */
    protected array $supportedLocales = ['en', 'ru', 'tk'];

    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $locale = session('locale', config('app.locale', 'en'));

        if (! in_array($locale, $this->supportedLocales, true)) {
            $locale = 'en';
        }

        App::setLocale($locale);

        return $next($request);
    }
}
