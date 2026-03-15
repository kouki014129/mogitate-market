<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Season;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->keyword;
        $sort = $request->sort;

        $products = Product::query()
            ->keyword($keyword)
            ->sortPrice($sort)
            ->paginate(6)
            ->withQueryString();

        return view('product.index', compact('products', 'keyword', 'sort'));
    }


    public function create()
    {
        $seasons = Season::query()->orderBy('id')->get();

        return view('product.create', compact('seasons'));
    }

    public function store(StoreProductRequest $request)
    {
        $path = $request->file('image')->store('products', 'public');

        $product = Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'image' => $path,
            'description' => $request->description,
        ]);

        $product->seasons()->sync($request->seasons);

        return redirect()->route('products.index');
    }

    public function show($productId)
    {
        $product = Product::with('seasons')->findOrFail($productId);
        $seasons = Season::query()->orderBy('id')->get();
        $selectedSeasonIds = old('seasons', $product->seasons->pluck('id')->all());

        return view('product.show', compact('product', 'seasons', 'selectedSeasonIds'));
    }


    public function edit($id)
    {
        //
    }


    public function update(UpdateProductRequest $request, $productId)
    {
        $product = Product::findOrFail($productId);

        $product->update([
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $product->update(['image' => $path]);
        }

        $product->seasons()->sync($request->seasons);

        return redirect()->route('products.index');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // 画像削除（storage 保存分）
        if ($product->image && Str::startsWith($product->image, 'products/') && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        // 旧パス（public/images/fruits-img）への後方互換削除
        if ($product->image && !Str::startsWith($product->image, 'products/')) {
            $legacyPath = public_path('images/fruits-img/' . $product->image);
            if (is_file($legacyPath)) {
                @unlink($legacyPath);
            }
        }

        $product->seasons()->detach();
        $product->delete();

        return redirect()->route('products.index');
    }
}
