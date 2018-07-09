<?php

namespace Ovde\Visitorcount\Middleware;

use Closure;
use Carbon\Carbon;
use Ovde\Visitorcount\Visit;
use Illuminate\Support\Facades\Request;

class CountVisit
{
    /**
     * Handle an incoming request.
     * We gaan elk uniek bezoek per dag loggen in de database
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $client = parse_user_agent();
        
        Visit::firstOrCreate([
            "datum" => Carbon::now()->toDateString(),
            "ipAdres" => Request::ip(),
            "platform" => $client["platform"] ?: "Bot",
            "browser" => $client["browser"],
        ]);
        return $next($request);
    }
}
