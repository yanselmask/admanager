<ul class="navbar-nav flex-column mb-3" id="navbarVerticalNav">
    @foreach (DashboardMenu::getAll('member') as $item)
        @continue(! $item['name'])
        <li class="nav-item">
            <a
                href="{{ $item['url']  }}"
                @class([
                    'nav-link' => true,
                    'active' => $item['active'],
                    ])
            >
                <div class="d-flex align-items-center">
                    <span class="nav-link-icon"><x-core::icon :name="$item['icon']" /></span>
                    <span class="nav-link-text ps-1">{{ __($item['name']) }}</span>
                </div>
            </a>
        </li>
    @endforeach
</ul>
