@if ($paginator->hasPages())
    <nav class="motels-pagination-inner" role="navigation" aria-label="Pagination">
        <div class="motels-pagination-summary">
            Showing {{ $paginator->firstItem() }} to {{ $paginator->lastItem() }} of {{ $paginator->total() }} results
        </div>

        <ul class="motels-pagination-list">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <span class="motels-page-btn motels-page-btn--disabled" aria-hidden="true">‹</span>
                </li>
            @else
                <li>
                    <a class="motels-page-btn" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">‹</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li aria-disabled="true">
                        <span class="motels-page-btn motels-page-btn--disabled">{{ $element }}</span>
                    </li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li aria-current="page">
                                <span class="motels-page-btn motels-page-btn--active">{{ $page }}</span>
                            </li>
                        @else
                            <li>
                                <a class="motels-page-btn" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a class="motels-page-btn" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">›</a>
                </li>
            @else
                <li aria-disabled="true" aria-label="@lang('pagination.next')">
                    <span class="motels-page-btn motels-page-btn--disabled" aria-hidden="true">›</span>
                </li>
            @endif
        </ul>
    </nav>
@endif

