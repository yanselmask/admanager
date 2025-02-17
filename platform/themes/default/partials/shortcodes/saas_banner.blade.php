<section class="saas_banner_area" data-bg-color="#F7F8FA">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-5">
                <div class="saas_banner_content">
                    <h1 class="wow fadeInLeft">{!! $shortcode->title !!}</h1>
                    <p class="wow fadeInLeft">{!! $shortcode->description !!}</p>
                    @if($text = $shortcode->button_text)
                    <a href="{{$shortcode->button_link ?? '#'}}" class="saas_btn wow fadeInUp" data-wow-delay="0.2s">
                        <div class="btn_text"><span>{{$text}}</span><span>{{$text}}</span>
                        </div>
                    </a>
                        @endif
                </div>
            </div>
            @if($link = $shortcode->youtube_link)
            <div class="col-lg-7">
                <div class="saas_banner_img wow fadeInRight" data-wow-delay="0.2s">
                    @if($img = $shortcode->youtube_image)
                    <img src="{{RvMedia::getImageUrl($img)}}" alt="">
                    @endif
                    <a href="{{$link}}"
                       class="video_popup popup-youtube">
                        <i class="fa fa-play"></i>
                    </a>
                </div>
            </div>
                @endif
        </div>
    </div>
    @if($desc = $shortcode->description_footer)
    <div class="saas_client_logo_area">
        <h2 class="client_title text-center title-animation">{!! $desc !!}</h2>
        @if($brands)
        <div class="min_client_area">
            @foreach($brands as $brand)
                    <a href="{{$brand->link}}" target="_blank" class="item wow fadeInLeft" data-wow-delay="{{ 0.3 + ($loop->index * 0.2) }}s">
                        @if($img = $brand->image_url)
                            <img src="{{RvMedia::getImageUrl($img)}}" alt="{{__('Logo')}}">
                        @endif
                    </a>
            @endforeach
        </div>
        @endif
    </div>
        @endif
</section>
