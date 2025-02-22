<?php

namespace Botble\Member\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfKyc
{
    public function handle(Request $request, Closure $next, string $guard = 'member')
    {
        if(!setting('member_kyc_is_required', false)) return redirect(route('public.member.dashboard'));

       if(Auth::guard($guard)->check() && Auth::guard($guard)->user()->kyc?->status->getValue() == 'published'  )
       {
           return redirect(route('public.member.dashboard'));
       }

        return $next($request);
    }
}
