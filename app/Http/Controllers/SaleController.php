<?php

namespace App\Http\Controllers;

use App\Enums\ItemType;
use App\Events\OrderEmmited;
use App\Http\Requests\SaleRequest;
use App\Http\Resources\SaleResource;
use App\Models\Client;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Service;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    public function store(SaleRequest $request, Client $client): SaleResource
    {
        $sale = new Sale;

        $sale->associateClient($client);
        $sale->save();

        $items = collect($request->safe()->array('items'))->map(function (array $item) {
            $merged = array_merge($item, [
                'saleable_id' => $item['id'],
                'saleable_type' => ItemType::from($item['type'])->className(),
            ]);

            return Arr::except($merged, ['id', 'type']);
        })->all();  


        DB::table('sale_items')->insert($items);

        $sale->total = $sale->calculateTotal();
        $sale->saveQuietly();

        event(new OrderEmmited($sale));

        return new SaleResource($sale);
    }

    public function show(Sale $sale): SaleResource
    {
        return new SaleResource($sale);
    }
}
