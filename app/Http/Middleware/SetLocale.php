<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        $locale = $request->get('lang', config('app.locale'));

        // Check if the locale is valid
        if (in_array($locale, ['en', 'ar'])) { // Add supported languages here
            App::setLocale($locale);
        }

        return $next($request);
    }
}
