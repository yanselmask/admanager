@php
    $bodyAttrs = Theme::getBodyAttributes();
    $bodyAttrs['class'] = trim(($bodyAttrs['class'] ?? '') . ' moreno-page min-h-screen flex flex-col');
    add_filter('theme_body_attributes', fn() => Html::attributes($bodyAttrs));
@endphp

{!! Theme::partial('header') !!}

{!! Theme::content() !!}

{!! Theme::partial('footer') !!}
