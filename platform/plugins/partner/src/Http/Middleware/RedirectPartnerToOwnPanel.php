<?php

namespace Botble\Partner\Http\Middleware;

use Botble\Partner\Supports\PartnerHelper;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Devuelve al partner a su panel cuando aterriza en el de creadores.
 *
 * Se registra sobre el grupo `web` en lugar de tocar el `LoginController` del plugin
 * `member`, que termina en `redirect()->intended('/account/dashboard')`. Un único
 * mecanismo cubre así los dos casos: la redirección posterior al login y el acceso
 * directo por URL.
 */
class RedirectPartnerToOwnPanel
{
    /**
     * Rutas del panel de creadores de las que hay que rescatar al partner. El resto
     * de rutas `public.member.*` (perfil, KYC, logout) le siguen sirviendo tal cual.
     */
    protected const CREATOR_ROUTES = [
        'public.member.dashboard',
        'public.member.referrals',
        'public.member.invoices',
    ];

    public function handle(Request $request, Closure $next)
    {
        // Salida temprana: la inmensa mayoría de peticiones web no tienen sesión de
        // miembro, y este middleware corre en todas ellas.
        if (! Auth::guard('member')->check()) {
            return $next($request);
        }

        $routeName = $request->route()?->getName();

        if ($routeName === null || ! in_array($routeName, self::CREATOR_ROUTES, true)) {
            return $next($request);
        }

        if (! PartnerHelper::isPartner(Auth::guard('member')->user())) {
            return $next($request);
        }

        return redirect()->route('partner.dashboard');
    }
}
