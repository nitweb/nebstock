@if($paginator->hasPages())
    <nav aria-label="Page navigation">
        <ul class="pagination common-pagination">
            @if($paginator->onFirstPage())
                <li class="page-item disabled"><span class="page-link">Prev</span></li>
            @else
                <li class="page-item"><a class="page-link" href="{{ $paginator->previousPageUrl() }}">Prev</a></li>
            @endif

            @foreach($paginator->getUrlRange(1, $paginator->lastPage()) as $page => $url)
                <li class="page-item {{ $page == $paginator->currentPage() ? 'active' : '' }}">
                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                </li>
            @endforeach

            @if($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link flx-align gap-2 flex-nowrap" href="{{ $paginator->nextPageUrl() }}">Next
                        <span class="icon line-height-1 font-20"><i class="las la-arrow-right"></i></span>
                    </a>
                </li>
            @else
                <li class="page-item disabled"><span class="page-link">Next</span></li>
            @endif
        </ul>
    </nav>
@endif