<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfNotInstalled
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $isInstalled = config('system.installer_completed');

        // Allow install routes, assets, livewire calls, and tailwind/vite assets
        $isInstallRoute = $request->is('install') || $request->is('install/*') || $request->is('livewire/*') || $request->is('_debugbar/*');

        if (! $isInstalled && ! $isInstallRoute) {
            return redirect()->route('install.welcome');
        }

        if ($isInstalled && ($request->is('install') || $request->is('install/*'))) {
            return redirect('/');
        }

        return $next($request);
    }
}
