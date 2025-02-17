<section class="saas_breadcrumb_area" data-bg-color="#F7F6FE">
    <img class="b_shap" src="{{Theme::asset()->url('img/breadcrumb_shap.png')}}" alt="{{__('Breadcrumb')}}">
    <div class="container">
        <div class="saas_breadcrumb_text">
            <h1 class="wow fadeInUp" data-wow-delay="0.2s">{{$page->name}}</h1>
            @if($desc = $page->description)
            <p class="wow fadeInUp" data-wow-delay="0.3s">{{$desc}}</p>
            @endif
            <ul class="nav list-unstyled breadcrumb justify-content-center wow fadeInUp" data-wow-delay="0.4s">
                @foreach (Theme::breadcrumb()->getCrumbs() as $i => $crumb)
                    @if ($i != (count(Theme::breadcrumb()->getCrumbs()) - 1))
                        <li><a href="{{ $crumb['url'] }}">{!! $crumb['label'] !!}</a><span class="divider"></span></li>
                    @else
                        <li class="active">{!! $crumb['label'] !!}</li>
                    @endif
                @endforeach
            </ul>
        </div>
    </div>
</section>
