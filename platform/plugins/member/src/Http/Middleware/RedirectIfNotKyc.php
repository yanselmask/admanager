<?php

namespace Botble\Member\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfNotKyc
{
    public function handle(Request $request, Closure $next, string $guard = 'member')
    {
        if (setting('member_kyc_is_required', false) && ( Auth::guard($guard)->check() && Auth::guard($guard)->user()->kyc?->status->getValue() != 'published' ) && $request->isMethod('GET')  ) {
            return redirect(route('public.member.kyc'));
        }

        return $next($request);
    }
}
