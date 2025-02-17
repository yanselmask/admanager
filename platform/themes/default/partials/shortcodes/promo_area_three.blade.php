<section class="promo_area_three sec_padding">
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="promo_content col-xl-8 text-center">
                <h2 class="wow fadeInUp" data-wow-delay="0.2s">{!! $shortcode->title !!}
                </h2>
                <p class="wow fadeInUp" data-wow-delay="0.3s">{!! $shortcode->description !!}</p>
                @if($text = $shortcode->button_text)
                <a href="{{$shortcode->button_link ?? '#'}}" class="saas_btn">
                    <div class="btn_text"><span>{{$text}}</span><span>{{$text}}</span>
                    </div>
                </a>
                @endif
            </div>
        </div>
    </div>
</section>
