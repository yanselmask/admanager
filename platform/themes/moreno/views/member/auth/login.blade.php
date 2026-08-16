@php
    $bodyAttrs = \Botble\Theme\Facades\Theme::getBodyAttributes();
    $bodyAttrs['class'] = 'moreno-auth-page min-h-screen text-white flex flex-col';
    add_filter('theme_body_attributes', fn() => Html::attributes($bodyAttrs) )
@endphp
<!-- Login Form -->
 <main class="flex-1 flex items-center justify-center py-5">
    <form method="POST" action="{{route('public.member.login.post')}}" class="bg-slate-900/80 border border-cyan-400/10 shadow-xl rounded-2xl p-8 w-full max-w-md mx-auto space-y-6 backdrop-blur">
        @csrf
        <div class="mb-8 text-center">
            <h1 class="text-3xl font-bold mb-2">Iniciar Sesión</h1>
            <p class="text-slate-400 text-sm">Accede a tu panel de creador</p>
        </div>
        <div>
            <label class="block text-sm mb-1 font-medium" for="email">Correo electrónico</label>
            <input class="w-full px-4 py-3 rounded-lg bg-slate-800 border border-cyan-400/10 focus:border-cyan-400 outline-none transition text-white" id="email" type="text" name="email" value="{{old('email')}}" placeholder="ejemplo@correo.com" required>

            @error('email')
                <div class="text-red-500 ms-2">{{$message}}</div>
            @enderror
        </div>

        <div>
            <label class="block text-sm mb-1 font-medium" for="password">Contraseña</label>
            <input class="w-full px-4 py-3 rounded-lg bg-slate-800 border border-cyan-400/10 focus:border-cyan-400 outline-none transition text-white" id="password" type="password" name="password" placeholder="Tu contraseña" required>
            @error('password')
            <div class="text-red-500 ms-2">{{$message}}</div>
            @enderror
        </div>
        <div class="flex items-center justify-between">
            <label class="inline-flex items-center text-sm text-slate-400">
                <input type="checkbox" name="remember" class="accent-cyan-500 rounded mr-2">
                Recuérdame
            </label>
            <a href="{{route('public.member.password.request')}}" class="text-cyan-400 text-sm hover:underline">¿Olvidaste tu contraseña?</a>
        </div>
        <button type="submit" class="moreno-cta w-full py-3 rounded-lg bg-[#004AAD] font-semibold shadow hover:-translate-y-1 transition text-lg">Entrar</button>
        <div class="text-center text-slate-400 text-sm mt-4">
            ¿No tienes cuenta?
            <a href="{{route('public.member.register')}}" class="text-cyan-400 font-semibold hover:underline">Regístrate</a>
        </div>
    </form>
</main>
