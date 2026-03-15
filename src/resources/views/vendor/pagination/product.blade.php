@if ($paginator->hasPages())
    <nav class="product-pagination" aria-label="商品一覧ページネーション">
        @if ($paginator->onFirstPage())
            <span class="product-pagination__button is-disabled" aria-disabled="true" aria-label="前のページ">&lt;</span>
        @else
            <a class="product-pagination__button" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="前のページ">&lt;</a>
        @endif

        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="product-pagination__button is-disabled" aria-disabled="true">{{ $element }}</span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="product-pagination__button is-active" aria-current="page">{{ $page }}</span>
                    @else
                        <a class="product-pagination__button" href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        @if ($paginator->hasMorePages())
            <a class="product-pagination__button" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="次のページ">&gt;</a>
        @else
            <span class="product-pagination__button is-disabled" aria-disabled="true" aria-label="次のページ">&gt;</span>
        @endif
    </nav>
@endif
