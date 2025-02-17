<div class="col-lg-2 col-sm-6">
    <div class="f_widget f_link_widget wow fadeInUp" data-wow-delay="0.3s">
        <h3 class="f_title">{{$config['name']}}</h3>
        @isset($config['menu_id'])
            {!!
            Menu::renderMenuLocation('main-menu', [
                    'options' => ['class' => 'list-unstyled link_widget'],
                    'view'   => 'footer-menu'
                ])
            !!}
        @endisset
    </div>
</div>
