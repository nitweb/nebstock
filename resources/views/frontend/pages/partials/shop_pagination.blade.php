@if($products->hasPages())
    <nav aria-label="Page navigation" id="shopPagination">
        <ul class="pagination common-pagination">
            @if($products->onFirstPage())
                <li class="page-item disabled"><span class="page-link">Prev</span></li>
            @else
                <li class="page-item"><a class="page-link" href="{{ $products->previousPageUrl() }}" data-page="{{ $products->currentPage() - 1 }}">Prev</a></li>
            @endif

            @foreach($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                <li class="page-item {{ $page == $products->currentPage() ? 'active' : '' }}">
                    <a class="page-link" href="{{ $url }}" data-page="{{ $page }}">{{ $page }}</a>
                </li>
            @endforeach

            @if($products->hasMorePages())
                <li class="page-item">
                    <a class="page-link flx-align gap-2 flex-nowrap" href="{{ $products->nextPageUrl() }}" data-page="{{ $products->currentPage() + 1 }}">Next
                        <span class="icon line-height-1 font-20"><i class="las la-arrow-right"></i></span>
                    </a>
                </li>
            @else
                <li class="page-item disabled"><span class="page-link">Next</span></li>
            @endif
        </ul>
    </nav>
@endif
