@php
    $start = $paginator->currentPage() - 2;
    $end = $paginator->currentPage() + 2;
    if ($start < 1) $start = 1;
    if ($end >= $paginator->lastPage()) $end = $paginator->lastPage(); // reset end to last page

    $pageMax = $paginator->currentPage() * $paginator->perPage();
    $pageMin = $pageMax - $paginator->perPage();
    if ($paginator->currentPage() == 1) $pageMin += 1;
    $fromToOf = $pageMin . ' - ' . $pageMax . ' of ' . $paginator->total();
@endphp

<nav class="pagination is-small is-right">
    <div class="pagination-count">
        <span>{{ $fromToOf }}</span>
    </div>

    <widget-pagination-size
        default-size-prop="{{ session('page-size') }}"
        route="{{ $paginator->url($paginator->currentPage()) }}"
    >
    </widget-pagination-size>

    @if($paginator->hasPages())
        <ul class="pagination-list">
            {{-- previous page --}}
            @if($paginator->currentPage() == 1)
                <li><a class="pagination-previous" disabled><i class="fa fa-angle-left"></i></a></li>
            @else
                <li><a class="pagination-previous" href="{{ $paginator->previousPageUrl() }}"><i class="fa fa-angle-left"></i></a></li>
            @endif
            {{-- first page --}}
            @if($start > 1)
                <li><a class="pagination-link page-first" href="{{ $paginator->url(1) }}">{{ 1 }}</a></li>
                <li>
                    <span class="pagination-ellipsis">&hellip;</span>
                </li>
            @endif
            {{-- pages --}}
            @for($i = $start; $i <= $end; $i++)
                @if($paginator->currentPage() == $i)
                    <li><a class="pagination-link is-current" href="{{ $paginator->url($i) }}">{{ $i }}</a></li>
                @else
                    <li><a class="pagination-link" href="{{ $paginator->url($i) }}">{{ $i }}</a></li>
                @endif
            @endfor
            {{-- last page --}}
            @if($end < $paginator->lastPage())
                <li>
                    <span class="pagination-ellipsis">&hellip;</span>
                </li>
                <li><a class="pagination-link page-last" href="{{ $paginator->url($paginator->lastPage()) }}">{{ $paginator->lastPage() }}</a></li>
            @endif
            {{-- next page --}}
            @if($paginator->currentPage() == $paginator->lastPage())
                <li><a class="pagination-next" disabled><i class="fa fa-angle-right"></i></a></li>
            @else
                <li><a class="pagination-next" href="{{ $paginator->nextPageUrl() }}"><i class="fa fa-angle-right"></i></a></li>
            @endif
        </ul>
    @endif
</nav>
