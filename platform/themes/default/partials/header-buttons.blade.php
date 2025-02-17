@if (is_plugin_active('member') && setting('member_enabled_login', true))
<div class="nav_right">
    @if (auth('member')->check())
    <a href="{{ route('public.member.dashboard') }}" class="login_btn">
        <div class="btn_text"><span>{{__('Dashboard')}}</span><span>{{__('Dashboard')}}</span></div>
    </a>
    @else
        <a href="{{ route('public.member.login') }}" class="login_btn">
            <div class="btn_text"><span>{{__('Login')}}</span><span>{{__('Login')}}</span></div>
        </a>
        <a href="{{ route('public.member.register') }}" class="signup_btn hover_effect">
            <div class="btn_text"><span>{{__('Create Account')}}</span><span>{{__('Create Account')}}</span></div>
        </a>
    @endif
</div>
@endif
