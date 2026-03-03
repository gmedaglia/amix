<?php

namespace App\Http\Controllers;

use App\Events\ProductDeleted;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        //
    }

    public function store(Request $request): ProductResource
    {
        //
    }

    public function show(Product $product): ProductResource
    {
        //
    }

    public function update(Request $request, Product $product): ProductResource
    {
        //
    }

    public function destroy(Product $product)
    {
        $product->delete();

        event(new ProductDeleted($product));

        return response()->noContent();
    }
}
