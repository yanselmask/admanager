@if(count($services))
<section class="service_category_area sec_padding">
    <div class="container">
        <div class="row">
            @foreach($services as $service)
            <div class="col-lg-4 col-md-6">
                <div class="service_item">
                    @if($icon = $service['icon'])
                    <div class="icon">
                        <img src="{{RvMedia::getImageUrl($icon)}}" alt="{{__('Icon')}}">
                    </div>
                    @endif
                    <h4>{{$service['title']}}</h4>
                    <p>{!! $service['description'] !!}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif
