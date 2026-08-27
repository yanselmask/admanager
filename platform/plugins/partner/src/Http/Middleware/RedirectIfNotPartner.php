<?php

namespace Botble\Partner\Http\Middleware;

use Botble\Partner\Supports\PartnerHelper;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Protege el panel del partner. Un creador autenticado no recibe un error: se le
 * devuelve a su propio panel.
 */
class RedirectIfNotPartner
{
    public function handle(Request $request, Closure $next, string $guard = 'member')
    {
        if (! Auth::guard($guard)->check()) {
            return redirect()->guest(route('public.member.login'));
        }

        if (! PartnerHelper::isPartner(Auth::guard($guard)->user())) {
            return redirect()->route('public.member.dashboard');
        }

        return $next($request);
    }
}
