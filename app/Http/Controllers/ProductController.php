<?php

namespace App\Http\Controllers;

use App\Events\ProductDeleted;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProductController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $productPaginator = Product::query()->paginate();

        return ProductResource::collection($productPaginator);
    }

    public function store(ProductRequest $request): ProductResource
    {
        $product = new Product;
        $product->fill($request->validated());
        $product->save();

        return new ProductResource($product);
    }

    public function show(Product $product): ProductResource
    {
        return new ProductResource($product);
    }

    public function update(ProductRequest $request, Product $product): ProductResource
    {
        $product->fill($request->validated());
        $product->save();

        return new ProductResource($product);
    }

    public function destroy(Product $product)
    {
        $product->delete();

        event(new ProductDeleted($product));

        return response()->noContent();
    }
}
