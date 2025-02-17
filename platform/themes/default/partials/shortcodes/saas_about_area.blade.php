<section class="saas_about_area sec_padding">
    <div class="container">
        <div class="row align-items-center">
            @if($img = $shortcode->image)
            <div class="col-lg-6 wow fadeInLeft" data-wow-delay="0.2s">
                <img data-parallax='{"x": 0, "y": 20, "from-scroll": 50, "distance": 0}' class="about_img"
                     src="{{RvMedia::getImageUrl($img)}}" alt="{{__('Image')}}">
            </div>
            @endif
            <div class="col-lg-6">
                <div class="saas_about_content wow fadeInRight" data-wow-delay="0.3s">
                    <h2>{!! $shortcode->title !!}</h2>
                    <p>{!! $shortcode->description !!}</p>
                    @if($text = $shortcode->button_text)
                    <a href="{{$shortcode->button_link ?? '#'}}" class="saas_btn">
                        <div class="btn_text"><span>{{$text}}</span><span>{{$text}}</span>
                        </div>
                    </a>
                        @endif
                </div>
            </div>
        </div>
        @if(count($skills))
        <div class="fact_inner">
            @foreach($skills as $skill)
            <div class="skill_fact_item wow fadeInUp" data-wow-delay="0.2s">
                <div class="number">{!! $skill['title'] !!}</div>
                <p>{!! $skill['subtitle'] !!}</p>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</section>
