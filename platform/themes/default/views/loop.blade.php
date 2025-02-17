<div class="blog_area sec_padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                @include(Theme::getThemeNamespace() . '::views.templates.posts', compact('posts'))
            </div>
            <div class="col-lg-4">
                <div class="blog_sidebar">
                    <div class="sidebar_widget widget_search">
                        <h3 class="widget_title">{{__('Search')}}</h3>
                        <form action="#" class="search-form input-group">
                            <input type="search" class="form-control widget_input" placeholder="Search">
                            <button type="submit"><i class="ti-search"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
