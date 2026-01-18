<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        if(Auth::check() && Auth::user()->locale){   
            $locale = Auth::user()->locale;
        } else{
            $locale = session('locale', config('app.locale')); 
        }

        App::setLocale($locale);

        return $next($request);
    }
}
