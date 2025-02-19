<?php

namespace Botble\Member\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfNotKyc
{
    public function handle(Request $request, Closure $next, string $guard = 'member')
    {
        if (Auth::guard($guard)->check() && ( setting('member_kyc_is_required', false) && !Auth::guard($guard)->user()->kyc_verified ) ) {
            return redirect(route('public.member.kyc'));
        }

        return $next($request);
    }
}
