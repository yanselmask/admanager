<nav {!! $options !!}>
    @foreach ($menu_nodes as $key => $row)
        <a href="{{ $row->url }}" target="{{ $row->target }}" class="hover:text-cyan-400 transition">{{ $row->title }}</a>
    @endforeach
</nav>
