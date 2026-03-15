<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class StoreProductRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|between:0,10000',
            'image' => 'required|file|mimes:png,jpeg',
            'seasons' => 'required|array|min:1',
            'seasons.*' => 'integer|exists:seasons,id|distinct',
            'description' => 'required|string|max:120',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '商品名を入力してください',

            'price.required' => '値段を入力してください',
            'price.numeric' => '数値で入力してください',
            'price.between' => '0∼10000円以内で入力してください',

            'image.required' => '画像を登録してください',
            'image.mimes' => '「.png」または「.jpeg」形式でアップロードしてください',

            'seasons.required' => '季節を選択してください',
            'seasons.array' => '季節を選択してください',
            'seasons.min' => '季節を選択してください',

            'description.required' => '商品説明を入力してください',
            'description.max' => '120文字以内で入力してください',
        ];
    }

    public function withValidator(Validator $validator)
    {
        $validator->after(function (Validator $validator) {
            $price = $this->input('price');
            if ($price === null || $price === '') {
                $validator->errors()->add('price', '数値で入力してください');
                $validator->errors()->add('price', '0∼10000円以内で入力してください');
            }

            $description = (string) $this->input('description', '');
            if ($description === '') {
                $validator->errors()->add('description', '120文字以内で入力してください');
            }

            if (!$this->hasFile('image')) {
                // 空の場合も拡張子メッセージを出す
                $validator->errors()->add('image', '「.png」または「.jpeg」形式でアップロードしてください');
            }
        });
    }
}
