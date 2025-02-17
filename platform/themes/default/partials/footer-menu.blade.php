<ul {!! BaseHelper::clean($options) !!}>
    @foreach ($menu_nodes as $key => $row)
    <li><a href="{{$row->url}}" target="{{ $row->target }}">{{ $row->title }}</a></li>
    @endforeach
</ul>
