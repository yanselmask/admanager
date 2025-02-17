<div class="col-lg-4 col-sm-6">
    <div class="f_widget f_about_widget wow fadeInUp" data-wow-delay="0.2s">
{{--        @dd($config)--}}
        <a href="{{ BaseHelper::getHomepageUrl() }}" class="f_logo">
            <img src="{{RvMedia::getImageUrl($config['logo'])}}" alt="{{__('Logo')}}">
        </a>

        <p>{{$config['content']}}</p>
{{--        <ul class="list-unstyled f_social_icon">--}}
{{--            <li><a href="#"><i class="ti-facebook"></i></a></li>--}}
{{--            <li><a href="#"><i class="ti-twitter-alt"></i></a></li>--}}
{{--            <li><a href="#"><i class="ti-vimeo-alt"></i></a></li>--}}
{{--            <li><a href="#"><i class="ti-linkedin"></i></a></li>--}}
{{--        </ul>--}}
    </div>
</div>
