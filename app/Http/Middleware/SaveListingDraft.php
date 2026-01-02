<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class SaveListingDraft
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Только при POST добавления и только для гостей
        // if ($request->is('listing/store') && !Auth::check()) {
        //     session()->put('draft_listing', $request->except('photos'));
        //     return redirect()->route('login');
        // }

        return $next($request);
    }
}
