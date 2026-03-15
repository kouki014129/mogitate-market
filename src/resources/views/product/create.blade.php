@extends('layouts.app')

@section('title', '商品登録')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/product-create.css') }}">
@endsection

@section('content')
    <section class="product-create">
        <div class="product-create__inner">
            <h1 class="product-create__title">商品登録</h1>

            <form class="product-create__form" action="{{ route('products.store') }}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="product-create__field">
                    <div class="product-create__label-row">
                        <label for="name">商品名</label>
                        <span class="badge-required">必須</span>
                    </div>
                    <input class="product-create__input" id="name" type="text" name="name" value="{{ old('name') }}" placeholder="商品名を入力">
                    @foreach ($errors->get('name') as $message)
                        <p class="product-create__error">{{ $message }}</p>
                    @endforeach
                </div>

                <div class="product-create__field">
                    <div class="product-create__label-row">
                        <label for="price">値段</label>
                        <span class="badge-required">必須</span>
                    </div>
                    <input class="product-create__input" id="price" type="text" name="price" value="{{ old('price') }}" placeholder="値段を入力">
                    @foreach ($errors->get('price') as $message)
                        <p class="product-create__error">{{ $message }}</p>
                    @endforeach
                </div>

                <div class="product-create__field">
                    <div class="product-create__label-row">
                        <label for="image">商品画像</label>
                        <span class="badge-required">必須</span>
                    </div>
                    <div class="product-create__file-row">
                        <label class="product-create__file-button" for="image">ファイルを選択</label>
                        <input id="image" class="product-create__file-input" type="file" name="image" accept=".png,.jpeg">
                        <span class="product-create__file-name">アップロードしてください</span>
                    </div>
                    <img id="preview" class="product-create__preview" alt="preview">
                    @foreach ($errors->get('image') as $message)
                        <p class="product-create__error">{{ $message }}</p>
                    @endforeach
                </div>

                <div class="product-create__field">
                    <div class="product-create__label-row">
                        <span>季節</span>
                        <span class="badge-required">必須</span>
                    </div>
                    <div class="product-create__seasons">
                        @foreach ($seasons as $season)
                            <label class="product-create__season">
                                <input
                                    class="product-create__radio"
                                    type="checkbox"
                                    name="seasons[]"
                                    value="{{ $season->id }}"
                                    {{ in_array((string) $season->id, old('seasons', []), true) ? 'checked' : '' }}
                                >
                                <span>{{ $season->name }}</span>
                            </label>
                        @endforeach
                    </div>
                    @foreach ($errors->get('seasons') as $message)
                        <p class="product-create__error">{{ $message }}</p>
                    @endforeach
                </div>

                <div class="product-create__field">
                    <div class="product-create__label-row">
                        <label for="description">商品説明</label>
                        <span class="badge-required">必須</span>
                    </div>
                    <textarea class="product-create__textarea" id="description" name="description" placeholder="商品の説明を入力">{{ old('description') }}</textarea>
                    @foreach ($errors->get('description') as $message)
                        <p class="product-create__error">{{ $message }}</p>
                    @endforeach
                </div>

                <div class="product-create__actions">
                    <a class="product-create__button product-create__button--back" href="{{ route('products.index') }}">戻る</a>
                    <button class="product-create__button product-create__button--submit" type="submit">登録</button>
                </div>
            </form>
        </div>
    </section>

    <script>
        const fileInput = document.getElementById('image');
        const fileName = document.querySelector('.product-create__file-name');
        const preview = document.getElementById('preview');

        if (fileInput) {
            fileInput.addEventListener('change', (e) => {
                const file = e.target.files?.[0];
                if (!file) {
                    preview.style.display = 'none';
                    preview.src = '';
                    if (fileName) fileName.textContent = 'アップロードしてください';
                    return;
                }

                if (fileName) fileName.textContent = file.name;

                const reader = new FileReader();
                reader.onload = (ev) => {
                    const result = ev.target?.result;
                    if (typeof result === 'string') {
                        preview.src = result;
                        preview.style.display = 'block';
                    }
                };
                reader.readAsDataURL(file);
            });
        }
    </script>
@endsection
