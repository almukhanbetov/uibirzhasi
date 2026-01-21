<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureOfferAccepted
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        $currentVersion = config('offer.current_version');

        if (
            !$user ||
            !$user->accepted_offer ||
            $user->accepted_offer_version !== $currentVersion
        ) {
            return redirect()->route('offer.accept');
        }

        return $next($request);
    }
}
