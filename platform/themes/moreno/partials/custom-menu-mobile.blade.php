<ul {!! $options !!}>
    @foreach ($menu_nodes as $key => $row)
        <li>
            <a href="{{ $row->url }}" target="{{ $row->target }}" class="hover:text-cyan-400 transition">{{ $row->title }}</a>
        </li>
    @endforeach
</ul>
