@php
    $bodyAttrs = \Botble\Theme\Facades\Theme::getBodyAttributes();
    $bodyAttrs['class'] = 'min-h-screen bg-gradient-to-br from-[#0a0f1c] via-[#1a2a3a] to-[#0a0f1c] text-white flex flex-col';
    add_filter('theme_body_attributes', fn() => Html::attributes($bodyAttrs) )
@endphp

<main class="flex-1 flex items-center justify-center py-5">
    <form method="POST" action="{{route('public.member.register.post')}}" class="bg-slate-900/80 border border-cyan-400/10 shadow-xl rounded-2xl p-8 w-full max-w-md mx-auto space-y-6 backdrop-blur">
        @csrf
        <div class="mb-8 text-center">
            <h1 class="text-3xl font-bold mb-2">Crear Cuenta</h1>
            <p class="text-slate-400 text-sm">Únete a la red de creadores</p>
        </div>
        <div>
            <label class="block text-sm mb-1 font-medium" for="name">Nombre</label>
            <input class="w-full px-4 py-3 rounded-lg bg-slate-800 border border-cyan-400/10 focus:border-cyan-400 outline-none transition text-white" id="name" name="first_name" value="{{old('first_name')}}" type="text" placeholder="Tu nombre" required>
            @error('name')
            <div class="text-red-500 ms-2">{{$message}}</div>
            @enderror
        </div>
        <div>
            <label class="block text-sm mb-1 font-medium" for="lastname">Apellido</label>
            <input class="w-full px-4 py-3 rounded-lg bg-slate-800 border border-cyan-400/10 focus:border-cyan-400 outline-none transition text-white" id="lastname" name="last_name" value="{{old('last_name')}}" type="text" placeholder="Apellido" required>
            @error('lastname')
            <div class="text-red-500 ms-2">{{$message}}</div>
            @enderror
        </div>
        <div>
            <label class="block text-sm mb-1 font-medium" for="email">Correo electrónico</label>
            <input class="w-full px-4 py-3 rounded-lg bg-slate-800 border border-cyan-400/10 focus:border-cyan-400 outline-none transition text-white" id="email" type="email" name="email" value="{{old('email')}}" placeholder="ejemplo@correo.com" required>
            @error('email')
            <div class="text-red-500 ms-2">{{$message}}</div>
            @enderror
        </div>
        <div>
            <label class="block text-sm mb-1 font-medium" for="username">Nombre de usuario</label>
            <input class="w-full px-4 py-3 rounded-lg bg-slate-800 border border-cyan-400/10 focus:border-cyan-400 outline-none transition text-white" id="username" type="text" name="username" value="{{old('username')}}" placeholder="ejemplo123" required>
            @error('username')
            <div class="text-red-500 ms-2">{{$message}}</div>
            @enderror
        </div>
        <div>
            <label class="block text-sm mb-1 font-medium" for="password">Contraseña</label>
            <input class="w-full px-4 py-3 rounded-lg bg-slate-800 border border-cyan-400/10 focus:border-cyan-400 outline-none transition text-white" id="password" type="password" name="password" placeholder="Crea una contraseña" required>
            @error('password')
            <div class="text-red-500 ms-2">{{$message}}</div>
            @enderror
        </div>
        <div>
            <label class="block text-sm mb-1 font-medium" for="password2">Confirmar Contraseña</label>
            <input class="w-full px-4 py-3 rounded-lg bg-slate-800 border border-cyan-400/10 focus:border-cyan-400 outline-none transition text-white" id="password2" type="password" name="password_confirmation" placeholder="Repite la contraseña" required>
        </div>
        @if(session('ref_by'))
        <div>
            <label class="block text-sm mb-1 font-medium" for="ref_by">Referido por</label>
            <input class="w-full px-4 py-3 rounded-lg bg-slate-800 border border-cyan-400/10 focus:border-cyan-400 outline-none transition text-white" id="ref_by" type="text" name="ref_by" value="{{session('ref_by')}}" placeholder="Referido por" required>
            @error('ref_by')
            <div class="text-red-500 ms-2">{{$message}}</div>
            @enderror
        </div>
        @endif
        <button type="submit" class="w-full py-3 rounded-lg bg-gradient-to-tr from-cyan-500 to-cyan-400 font-semibold shadow hover:-translate-y-1 transition text-lg">Crear Cuenta</button>
        <div class="text-center text-slate-400 text-sm mt-4">
            ¿Ya tienes una cuenta?
            <a href="{{route('public.member.login')}}" class="text-cyan-400 font-semibold hover:underline">Iniciar sesión</a>
        </div>
    </form>
</main>
