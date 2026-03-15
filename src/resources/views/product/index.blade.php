@extends('layouts.app')

@section('title', '商品一覧')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/product-index.css') }}">
@endsection

@section('content')
    @php
        use Illuminate\Support\Str;
        use Illuminate\Support\Facades\Storage;
        $pageTitle = filled($keyword ?? null) ? '“' . $keyword . '”の商品一覧' : '商品一覧';
        $sortLabels = [
            'high' => '高い順に表示',
            'low' => '低い順に表示',
        ];
    @endphp

    <section class="product-index">
        <div class="product-index__header">
            <h1 class="product-index__title">{{ $pageTitle }}</h1>
            <a class="product-index__add-button" href="{{ route('products.create') }}">+ 商品を追加</a>
        </div>

        <div class="product-index__content">
            <aside class="product-index__sidebar">
                <form class="product-search" action="" method="get">
                    <input
                        class="product-search__input"
                        type="text"
                        name="keyword"
                        placeholder="商品名で検索"
                        value="{{ $keyword ?? '' }}"
                    >
                    <input type="hidden" name="sort" value="{{ $sort ?? '' }}">
                    <button class="product-search__button" type="submit">検索</button>
                </form>

                <form class="product-sort" action="" method="get">
                    <h2 class="product-sort__title">価格順で表示</h2>
                    <input type="hidden" name="keyword" value="{{ $keyword ?? '' }}">
                    <select class="product-sort__select" name="sort" onchange="this.form.submit()">
                        <option value="">価格で並べ替え</option>
                        <option value="high" @selected(($sort ?? '') === 'high')>高い順に表示</option>
                        <option value="low" @selected(($sort ?? '') === 'low')>低い順に表示</option>
                    </select>
                    @if (!empty($sortLabels[$sort ?? '']))
                        <a class="product-sort__current" href="{{ url('/?keyword=' . urlencode($keyword ?? '')) }}">
                            {{ $sortLabels[$sort] }}
                            <span>×</span>
                        </a>
                    @endif
                </form>
            </aside>

            <div class="product-index__main">
                <div class="product-grid">
                    @foreach ($products as $product)
                        <a class="product-card__link" href="{{ route('products.show', $product) }}">
                            <article class="product-card">
                                <div class="product-card__image-wrap">
                                    <img
                                        class="product-card__image"
                                        src="{{ Str::startsWith($product->image, 'products/') ? Storage::url($product->image) : asset('images/fruits-img/' . $product->image) }}"
                                        alt="{{ $product->name }}"
                                    >
                                </div>
                                <div class="product-card__body">
                                    <p class="product-card__name">{{ $product->name }}</p>
                                    <p class="product-card__price">¥{{ number_format($product->price) }}</p>
                                </div>
                            </article>
                        </a>
                    @endforeach
                </div>

                {{ $products->links('vendor.pagination.product') }}
            </div>
        </div>
    </section>
@endsection
