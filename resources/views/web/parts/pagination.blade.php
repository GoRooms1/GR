@if(count($elements) > 1)
    <div class="pagination">
        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="page">{{ $element }}</span>
            @endif
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <a href="#" class="page active">{{ $page }}</a>
                    @else
                        <a href="{{ $url }}" class="page">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach
    </div>
@endif