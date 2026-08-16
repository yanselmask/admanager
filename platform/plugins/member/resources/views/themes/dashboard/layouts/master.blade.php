<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="format-detection" content="telephone=no">
        <meta name="apple-mobile-web-app-capable" content="yes">
        @if (theme_option('favicon'))
            <link href="{{ RvMedia::getImageUrl(theme_option('favicon')) }}" rel="shortcut icon">
        @endif

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ PageTitle::getTitle(false) }}</title>

        @include('plugins/member::themes.dashboard.layouts.header')

        @stack('header')

    </head>

    <body theme="dark">
        @yield('body', view('plugins/member::themes.dashboard.layouts.body'))
{{--        {!! Assets::renderFooter() !!}--}}
        @stack('scripts-libs')
        @stack('footer')
        @if (Session::has('success_msg') || Session::has('error_msg') || (isset($errors) && $errors->any()) || isset($error_msg))
        <script type="text/javascript">
            $(function() {
                @if (Session::has('success_msg'))
                Botble.showSuccess('{{ session('success_msg') }}');
                @endif
                @if (Session::has('error_msg'))
                Botble.showError('{{ session('error_msg') }}');
                @endif
                @if (isset($error_msg))
                Botble.showError('{{ $error_msg }}');
                @endif
                @if (isset($errors))
                @foreach ($errors->all() as $error)
                Botble.showError('{{ $error }}');
                @endforeach
                @endif
            });
        </script>
       @endif

{{--        {!! apply_filters(THEME_FRONT_FOOTER, null) !!}--}}
        @include('plugins/member::themes.dashboard.layouts.footer')
        @stack('scripts')
    </body>
</html>
