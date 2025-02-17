<footer class="footer_area_two footer_area_three footer_shap" data-bg-color="#12141D">
    <div class="container">
        <div class="row">
            {!! dynamic_sidebar('footer_widgets') !!}
        </div>
        <div class="footer_bottom text-center">
            <div class="row">
                <div class="col-lg-12">
                    <p class="mb-0 wow fadeInUp" data-wow-delay="0.3s">{!! Theme::getSiteCopyright() !!}</p>
                </div>
            </div>
        </div>
    </div>
</footer>
</div>
        {!! Theme::footer() !!}
    </body>
</html>
