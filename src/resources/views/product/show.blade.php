@extends('layouts.app')

@section('title', '商品詳細')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/product-show.css') }}">
@endsection

@section('content')
    @php
        use Illuminate\Support\Str;
        use Illuminate\Support\Facades\Storage;
        $selectedSeasonIds = collect($selectedSeasonIds ?? [])->map(fn($id) => (string) $id)->all();
    @endphp

    <section class="product-edit">
        <div class="product-edit__inner">
            <nav class="product-edit__breadcrumb" aria-label="パンくず">
                <a href="{{ route('products.index') }}">商品一覧</a>
                <span>&gt;</span>
                <span>{{ $product->name }}</span>
            </nav>

            <form class="product-edit__form" action="{{ route('products.update', ['productId' => $product->id]) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <input type="hidden" name="current_image" value="{{ $product->image }}">
                <div class="product-edit__top">
                    <div class="product-edit__image-area">
                        <div class="product-edit__image-wrap">
                            <img
                                class="product-edit__image"
                                src="{{ Str::startsWith($product->image, 'products/') ? Storage::url($product->image) : asset('images/fruits-img/' . $product->image) }}"
                                alt="{{ $product->name }}"
                            >
                        </div>

                        <div class="product-edit__file-row">
                            <label class="product-edit__file-button" for="image">ファイルを選択</label>
                            <input id="image" class="product-edit__file-input" type="file" name="image" accept=".png,.jpeg">
                            <span class="product-edit__file-name">{{ $product->image }}</span>
                        </div>
                        @foreach ($errors->get('image') as $message)
                            <p class="product-edit__error">{{ $message }}</p>
                        @endforeach
                    </div>

                    <div class="product-edit__fields">
                        <div class="product-edit__field">
                            <label class="product-edit__label" for="name">商品名</label>
                            <input class="product-edit__input" id="name" type="text" name="name" value="{{ old('name', $product->name) }}" placeholder="商品名を入力">
                            @foreach ($errors->get('name') as $message)
                                <p class="product-edit__error">{{ $message }}</p>
                            @endforeach
                        </div>

                        <div class="product-edit__field">
                            <label class="product-edit__label" for="price">値段</label>
                            <input class="product-edit__input" id="price" type="text" name="price" value="{{ old('price', $product->price) }}" placeholder="値段を入力">
                            @foreach ($errors->get('price') as $message)
                                <p class="product-edit__error">{{ $message }}</p>
                            @endforeach
                        </div>

                        <div class="product-edit__field">
                            <span class="product-edit__label">季節</span>
                            <div class="product-edit__seasons">
                                @foreach ($seasons as $season)
                                    <label class="product-edit__season">
                                        <input
                                            class="product-edit__radio"
                                            type="checkbox"
                                            name="seasons[]"
                                            value="{{ $season->id }}"
                                            {{ in_array((string) $season->id, $selectedSeasonIds, true) ? 'checked' : '' }}
                                        >
                                        <span>{{ $season->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                            @foreach ($errors->get('seasons') as $message)
                                <p class="product-edit__error">{{ $message }}</p>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="product-edit__field product-edit__field--textarea">
                    <label class="product-edit__label" for="description">商品説明</label>
                    <textarea class="product-edit__textarea" id="description" name="description" placeholder="商品の説明を入力">{{ old('description', $product->description) }}</textarea>
                    @foreach ($errors->get('description') as $message)
                        <p class="product-edit__error">{{ $message }}</p>
                    @endforeach
                </div>

                <div class="product-edit__actions">
                    <a class="product-edit__button product-edit__button--back" href="{{ url('/') }}">戻る</a>
                    <button class="product-edit__button product-edit__button--save" type="submit">変更を保存</button>
                    <button class="product-edit__delete" type="submit" form="product-delete-form" aria-label="商品を削除" onclick="return confirm('削除してよろしいですか？');">
                        <svg viewBox="0 0 24 24" width="18" height="18" aria-hidden="true">
                            <path d="M9 3h6l1 2h4v2H4V5h4l1-2zm1 7h2v8h-2v-8zm4 0h2v8h-2v-8zM7 10h2v8H7v-8zm1 11h8a2 2 0 0 0 2-2V8H6v11a2 2 0 0 0 2 2z" />
                        </svg>
                    </button>
                </div>
            </form>
            <form id="product-delete-form" action="{{ route('products.destroy', ['productId' => $product->id]) }}" method="post" style="display:none;">
                @csrf
                @method('DELETE')
            </form>
        </div>
    </section>

    <script>
        const fileInput = document.getElementById('image');
        const previewImage = document.querySelector('.product-edit__image');
        const fileNameLabel = document.querySelector('.product-edit__file-name');

        if (fileInput && previewImage) {
            fileInput.addEventListener('change', (event) => {
                const file = event.target.files?.[0];
                if (!file) return;

                const reader = new FileReader();
                reader.onload = (e) => {
                    const result = e.target?.result;
                    if (typeof result === 'string') {
                        previewImage.src = result;
                    }
                };
                reader.readAsDataURL(file);

                if (fileNameLabel) {
                    fileNameLabel.textContent = file.name;
                }
            });
        }
    </script>
@endsection
