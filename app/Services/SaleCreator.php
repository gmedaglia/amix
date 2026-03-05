<?php

namespace App\Services;

use App\Exceptions\InsufficientStockException;
use App\Exceptions\ProductSellQuotaExceededException;
use App\Models\Client;
use App\Models\Sale;
use Illuminate\Support\Collection;

class SaleCreator
{
    public function __construct(private SaleItemsBuilder $saleItemsBuilder)
    {
    }

    /**
     * @param Collection<int, array{id: string, type: string, quantity: integer}>> $items
     * 
     * @throws InsufficientStockException
     * @throws ProductSellQuotaExceededException
     */
    public function create(Client $client, array $items): Sale
    {
        $sale = new Sale;

        $sale->associateClient($client);

        $saleItems = $this->saleItemsBuilder->build($items);

        $sale->setItems($saleItems);
        $sale->calculateTotal();

        $sale->save();
        $sale->saveItems($saleItems);

        return $sale;
    }
}