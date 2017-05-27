@if($paginator->hasPages())
    <?php
        $start = $paginator->currentPage() - 2;
        $end = $paginator->currentPage() + 2;
        if($start < 1) $start = 1;
        if($end >= $paginator->lastPage() ) $end = $paginator->lastPage(); // reset end to last page
    ?>
    <div class="pagination-container clearfix">
        <ul class="pagination">
            {{-- previous page --}}
            @if($paginator->currentPage() == 1)
                <li><a class="btn btn-default btn-xs disabled" href="{{ $paginator->previousPageUrl() }}"><i class="fa fa-angle-left"></i></a></li>
            @else
                <li><a class="btn btn-default btn-xs" href="{{ $paginator->previousPageUrl() }}"><i class="fa fa-angle-left"></i></a></li>
            @endif
            {{-- first page --}}
            @if($start > 1)
                <li><a class="btn btn-default btn-xs page-first" href="{{ $paginator->url(1) }}">{{ 1 }}</a></li>
            @endif
            {{-- pages --}}
            @for ($i = $start; $i <= $end; $i++)
                @if($paginator->currentPage() == $i)
                    <li><a class="btn btn-default btn-xs active" href="{{ $paginator->url($i) }}">{{ $i }}</a></li>
                @else
                    <li><a class="btn btn-default btn-xs" href="{{ $paginator->url($i) }}">{{ $i }}</a></li>
                @endif
            @endfor
            {{-- last page --}}
            @if($end < $paginator->lastPage())
                <li><a class="btn btn-default btn-xs page-last" href="{{ $paginator->url($paginator->lastPage()) }}">{{ $paginator->lastPage() }}</a></li>
            @endif
            {{-- next page --}}
            @if($paginator->currentPage() == $paginator->lastPage())
                <li><a class="btn btn-default btn-xs disabled" href="{{ $paginator->nextPageUrl() }}"><i class="fa fa-angle-right"></i></a></li>
            @else
                <li><a class="btn btn-default btn-xs" href="{{ $paginator->nextPageUrl() }}"><i class="fa fa-angle-right"></i></a></li>
            @endif
        </ul>
    </div>
@endif