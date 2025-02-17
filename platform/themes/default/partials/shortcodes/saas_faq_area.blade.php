@php
    $id = uniqid();
@endphp
@if($shortcode->style == 'style1')
<section class="saas_faq_area_two sec_padding">
    <div class="container">
        <div class="section_title text-center">
            <h2>{{$shortcode->title}}</h2>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="accordion faq_inner faq_inner_two ps-4" id="{{$id}}">
                    @foreach($faqs as $faq)
                    <div class="accordion-item wow fadeInLeft" data-wow-delay="{{0.5 + ($loop->index * 0.2)}}s">
                        <h2 class="accordion-header" id="headingSeven">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse-{{str($id)->append('-')->append($loop->index)}}" aria-expanded="{{$faq['opened']}}"
                                    aria-controls="collapse-{{str($id)->append('-')->append($loop->index)}}">
                                {{$faq['title']}}
                            </button>
                        </h2>
                        <div id="collapse-{{str($id)->append('-')->append($loop->index)}}" class="accordion-collapse collapse {{$faq['opened'] ? 'show' : ''}}"
                             aria-labelledby="headingSeven" data-bs-parent="#{{$id}}">
                            <div class="accordion-body">
                                <p>{!! $faq['description'] !!}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@else
<section class="saas_faq_area sec_padding" data-bg-color="{{$shortcode->color ?? '#F8F9FC'}}">
    <div class="container">
        <div class="row">
            <div class="col-lg-5">
                <div class="section_title pe-5">
                    <h2>{{$shortcode->title}}</h2>
                    <p>{{$shortcode->description}}</p>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="accordion faq_inner ps-4" id="{{$id}}">
                    @foreach($faqs as $faq)
                        <div class="accordion-item wow fadeInLeft" data-wow-delay="{{0.5 + ($loop->index * 0.2)}}s">
                            <h2 class="accordion-header" id="headingSeven">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapse-{{str($id)->append('-')->append($loop->index)}}" aria-expanded="{{$faq['opened']}}"
                                        aria-controls="collapse-{{str($id)->append('-')->append($loop->index)}}">
                                    {{$faq['title']}}
                                </button>
                            </h2>
                            <div id="collapse-{{str($id)->append('-')->append($loop->index)}}" class="accordion-collapse collapse {{$faq['opened'] ? 'show' : ''}}"
                                 aria-labelledby="headingSeven" data-bs-parent="#{{$id}}">
                                <div class="accordion-body">
                                    <p>{!! $faq['description'] !!}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@endif
