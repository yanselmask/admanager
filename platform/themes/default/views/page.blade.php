@if($page->template !== 'homepage' && theme_option('theme_breadcrumb_enabled', true))
    {!! Theme::partial('breadcrumb',['page' => $page]) !!}
@endif
{!! apply_filters(PAGE_FILTER_FRONT_PAGE_CONTENT, Html::tag('div', BaseHelper::clean($page->content), ['class' => 'ck-content'])->toHtml(), $page) !!}
