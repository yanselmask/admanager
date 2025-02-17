{!! Theme::partial('header',['fixed' => true]) !!}
@if (Theme::get('section-name'))
    {!! Theme::partial('breadcrumbs') !!}
@endif
{!! Theme::content() !!}
{!! Theme::partial('footer') !!}
