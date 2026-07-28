@if ($products->lastPage() > 1)
    <div class="pagination__area mt-30">
        <nav class="pagination justify-content-center">
            <ul class="pagination__wrapper d-flex align-items-center justify-content-center">

                {{-- Prev --}}
                <li class="pagination__list">
                    @if ($products->onFirstPage())
                        <span class="pagination__item--arrow link disabled" style="opacity:.4;pointer-events:none;">
                        @else
                            <a href="#" class="pagination__item--arrow link ajax-page" data-page="{{ $products->currentPage() - 1 }}">
                    @endif
                    <svg xmlns="http://www.w3.org/2000/svg" width="22.51" height="20.443" viewBox="0 0 512 512">
                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="48" d="M244 400L100 256l144-144M120 256h292" />
                    </svg>
                    @if ($products->onFirstPage())
                        </span>
                    @else
                        </a>
                    @endif
                </li>

                {{-- Pages --}}
                @foreach ($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                    <li class="pagination__list">
                        @if ($page == $products->currentPage())
                            <span class="pagination__item pagination__item--current">{{ $page }}</span>
                        @else
                            <a href="#" class="pagination__item link ajax-page" data-page="{{ $page }}">{{ $page }}</a>
                        @endif
                    </li>
                @endforeach

                {{-- Next --}}
                <li class="pagination__list">
                    @if ($products->hasMorePages())
                        <a href="#" class="pagination__item--arrow link ajax-page" data-page="{{ $products->currentPage() + 1 }}">
                        @else
                            <span class="pagination__item--arrow link disabled" style="opacity:.4;pointer-events:none;">
                    @endif
                    <svg xmlns="http://www.w3.org/2000/svg" width="22.51" height="20.443" viewBox="0 0 512 512">
                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="48" d="M268 112l144 144-144 144M392 256H100" />
                    </svg>
                    @if ($products->hasMorePages())
                        </a>
                    @else
                        </span>
                    @endif
                </li>

            </ul>
        </nav>
    </div>
@endif
