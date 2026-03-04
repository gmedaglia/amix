<?php

namespace App\Http\Controllers;

use App\Events\OrderEmmited;
use App\Exceptions\InsufficientStockException;
use App\Exceptions\ProductSellQuotaExceededException;
use App\Http\Requests\SaleRequest;
use App\Http\Resources\SaleResource;
use App\Models\Client;
use App\Models\Sale;
use App\Services\SaleItemsBuilder;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class SaleController extends Controller
{
    public function store(SaleRequest $request, Client $client, SaleItemsBuilder $saleItemsBuilder): SaleResource
    {
        try {
            $sale = new Sale;

            $sale->associateClient($client);

            $saleItems = $saleItemsBuilder->build($request->safe()->array('items'));

            $sale->setItems($saleItems);
            $sale->calculateTotal();

            $sale->save();
            $sale->items()->saveMany($saleItems);

            event(new OrderEmmited($sale));

            return new SaleResource($sale);
        } catch (InsufficientStockException | ProductSellQuotaExceededException $e) {
            throw new AccessDeniedHttpException($e->getMessage());
        }
    }

    public function show(Sale $sale): SaleResource
    {
        return new SaleResource($sale);
    }
}
