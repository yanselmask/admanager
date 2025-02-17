<section class="saas_features_area">
    <div class="container">
        <div class="section_title text-center">
            <h2 class="title-animation">{!! $shortcode->title !!}</h2>
            <p class="wow fadeInUp" data-wow-delay="0.4s">{!! $shortcode->subtitle !!}</p>
        </div>

        @foreach($tabs as $feature)
        <div class="row @if($feature['direction'] == 'left') flex-row-reverse @endif saas_features_item one">
            @if($img = $feature['image'])
            <div class="col-lg-6">
                <div class="saas_features_img" data-bg-color="{{$feature['color'] ?? '#E6D8F5'}}">
                    <img src="{{RvMedia::getImageUrl($img, 'small')}}" alt="">
                </div>
            </div>
            @endif
            <div class="col-lg-6">
                <div class="saas_features_content wow fadeInLeft" data-wow-delay="0.2s">
                    <h6>{{$feature['subtitle']}}</h6>
                    <h2>{!! $feature['title'] !!}</h2>
                    <p>{!! $feature['description'] !!}</p>
                    @if(!empty($feature['features']))
                    <ul style="list-style: none" class="list-unstyled saas_list">
                        @php
                            $list = explode(',', $feature['features'])
                        @endphp
                        @foreach($list as $f)
                        <li>
                            <div class="icon"><img src="assets/img/home-one/check.png" alt=""></div>
                            {{$f}}
                        </li>
                        @endforeach
                    </ul>
                    @endif
                    @if($text = $feature['button_text'])
                    <a href="{{$feature['button_link'] ?? '#'}}" class="saas_btn">
                        <div class="btn_text"><span>{{$text}}</span><span>{{$text}}</span></div>
                    </a>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>
