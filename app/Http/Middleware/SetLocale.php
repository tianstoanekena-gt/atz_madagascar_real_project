<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;



class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->segment(1);

        $supportedLocales = ['mg', 'fr', 'en'];

        if (in_array($locale, $supportedLocales)) {
            App::setLocale($locale);
        } else {
            // Si la locale n'est pas dans l'URL, utiliser 'fr' par défaut
            App::setLocale('fr');
        }

        return $next($request);
    }
}
