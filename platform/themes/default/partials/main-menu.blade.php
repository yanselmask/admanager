<ul {!! BaseHelper::clean($options) !!}>
    @foreach ($menu_nodes as $key => $row)
        <li class="nav-item @if ($row->has_child) dropdown submenu @endif {{ $row->css_class }} @if ($row->active) active @endif">
            <a class="nav-link" href="{{ $row->has_child ? '#' : $row->url }}" @if($row->has_child) role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" @endif target="{{ $row->target }}">
                {!! $row->icon_html !!}
                <span class="menu-title">{{ $row->title }}</span>

                @if ($row->has_child) <span class="toggle-icon">
                    {!! BaseHelper::renderIcon('ti ti-chevron-down') !!}
                </span>@endif
            </a>
            @if ($row->has_child)
                {!!
                    Menu::generateMenu([
                        'menu' => $menu,
                        'menu_nodes' => $row->child,
                        'view' => 'main-menu',
                        'options' => ['class' => 'dropdown-menu'],
                    ])
                !!}
            @endif
        </li>
    @endforeach
</ul>
