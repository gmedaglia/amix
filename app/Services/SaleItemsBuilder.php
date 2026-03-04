<?php

namespace App\Services;

use App\Enums\ItemType;
use App\Models\Product;
use App\Models\Saleable;
use App\Models\SaleItem;
use App\Models\Service;
use Illuminate\Support\Collection;

class SaleItemsBuilder
{
    /**
     * @param Collection<int, array{id: string, type: string, quantity: integer}>> $items
     * 
     * @return Collection<int, SaleItem>;
     */
    public function build(array $items): Collection
    {
        $saleItems = collect();
        
        $itemCollection = collect($items);
        $itemIds = $itemCollection->pluck('id')->all();

        $groupedItemsByType = $itemCollection->groupBy('type');

        $productIds = collect($groupedItemsByType[ItemType::Product->value] ?? [])->pluck('id')->all();
        $serviceIds = collect($groupedItemsByType[ItemType::Service->value] ?? [])->pluck('id')->all();

        $products = Product::query()->whereIn('id', $productIds)->get();
        $services = Service::query()->whereIn('id', $serviceIds)->get();

        foreach ($products->concat($services) as $saleable) {
            /** @var Saleable $saleable */

            $item = $groupedItemsByType
                ->get($saleable->type()->value)
                ->firstWhere(fn (array $item) => $item['id'] === $saleable->id);

            $saleItem = new SaleItem;
            $saleItem->quantity = $item['quantity'];
            $saleItem->unit_price = $saleable->price;
            $saleItem->saleable()->associate($saleable);

            $saleItems->push($saleItem);
        }

        $itemOrderMap = array_flip($itemIds);

        return $saleItems
            ->sortBy(fn (SaleItem $saleItem) => $itemOrderMap[$saleItem->saleable->id]);
    }
}