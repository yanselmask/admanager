@if ($posts->isNotEmpty())
    @foreach ($posts as $post)
        <div class="blog_item">
            <a href="{{ $post->url }}" class="blog_img"  title="{{ $post->name }}">
                {{ RvMedia::image($post->image, $post->name, 'medium') }}
            </a>
            <div class="blog_content">
                <div class="blog_meta">
                    <a href="#">March 21, 2024</a>
                    <a href="#">Fintech</a>
                </div>
                <a href="{{ $post->url }}">
                    <h2>{{ $post->name }}</h2>
                </a>
                <p>{{ $post->description }}</p>
                <a href="{{ $post->url }}" class="read_more_btn">{{__('Read More')}}</a>
            </div>
        </div>
    @endforeach
    <div class="page-pagination text-right">
        {!! $posts->withQueryString()->links() !!}
    </div>
@endif

<style>
    .section.pt-50.pb-100 {
        background-color: #ecf0f1;
    }
</style>
