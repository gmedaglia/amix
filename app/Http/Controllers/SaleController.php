<?php

namespace App\Http\Controllers;

use App\Events\OrderEmmited;
use App\Exceptions\SaleCreationException;
use App\Http\Requests\SaleRequest;
use App\Http\Resources\SaleResource;
use App\Models\Client;
use App\Models\Sale;
use App\Services\SaleCreator;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class SaleController extends Controller
{
    public function store(SaleRequest $request, Client $client, SaleCreator $saleCreator): SaleResource
    {
        try {
            $sale = $saleCreator->create($client, $request->safe()->array('items'));

            event(new OrderEmmited($sale));

            return new SaleResource($sale);
        } catch (SaleCreationException $e) {
            throw new AccessDeniedHttpException(message: $e->getMessage(), code: $e->getCode());
        }
    }

    public function show(Sale $sale): SaleResource
    {
        return new SaleResource($sale);
    }
}
