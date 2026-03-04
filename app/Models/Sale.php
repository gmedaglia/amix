<?php

namespace App\Models;

use App\Enums\ItemType;
use App\Exceptions\InsufficientStockException;
use App\Exceptions\ProductSellQuotaExceededException;
use App\Observers\SaleObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection as SupportCollection;

/**
 * @property-read string $id
 * @property Client $client
 * @property Collection<int, SaleItem> $items
 * @property Carbon $created_at
 * @property int $client_sale_num_for_day
 * @property float $total
 */
#[ObservedBy(SaleObserver::class)]
class Sale extends Model
{
    use HasFactory;
    
    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
        ];
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class)->withTrashed();
    }

    public function items(): HasMany
    {
        return $this->hasMany(SaleItem::class);
    }  
    
    #[Scope]
    public function forClient(Builder $query, Client $client): Builder
    {
        return $query->whereBelongsTo($client, 'client');
    }
    
    #[Scope]
    public function forToday(Builder $query): Builder
    {
        return $query->whereDate('created_at', today());
    }  
    
    #[Scope]
    public function forClientToday(Builder $query, Client $client): Builder
    {
        return $query
            ->forClient($client)
            ->forToday();
    } 

    /**
     * @param int[] $productIds
     */
    #[Scope]
    public function havingAnyProduct(Builder $query, array $productIds): Builder
    {
        return $query->whereHas('items', function (Builder $query) use ($productIds) {
            $query
                ->where('saleable_type', ItemType::Product->className())
                ->whereIn('saleable_id', $productIds);
        });
    }
    
    /**
     * @param int[] $productIds
     */    
    #[Scope]
    public function forClientTodayHavingAnyProduct(Builder $query, Client $client, array $productIds): Builder
    {
        return $query
            ->forClient($client)
            ->forToday()
            ->havingAnyProduct($productIds);
    } 
    
    #[Scope]
    public function withItems(Builder $query): Builder
    {
        return $query->with('items');
    }     
    
    public function associateClient(Client $client)
    {
        return $this->client()->associate($client);
    }

    /**
     * @param SupportCollection<int, SaleItem> $items
     */
    public function setItems(SupportCollection $items): self
    {
        $this->validateItemStocks($items);
        $this->validateItemSellQuotas($items);

        return $this->setRelation('items', $items);
    }  
    
    /**
     * @param SupportCollection<int, SaleItem> $items
     */    
    private function validateItemStocks(SupportCollection $items): void
    {
        foreach ($items as $saleItem) {
            if (
                $saleItem->quantity > $saleItem->saleable->stock 
                || 
                (
                    $saleItem->saleable->stockDependency()
                    &&
                    $saleItem->quantity > $saleItem->saleable->stockDependency()->stock
                )
            ) {
                throw new InsufficientStockException($saleItem->saleable);
            }
        }
        
        return;
    }

    /**
     * @param SupportCollection<int, SaleItem> $items
     */    
    private function validateItemSellQuotas(SupportCollection $items): void
    {
        $productIds = $items->filter(fn (SaleItem $saleItem) => $saleItem->saleable->type() === ItemType::Product)->pluck('saleable.id')->all();

        $saleItemLists = Sale::query()
            ->withItems()
            ->forClientTodayHavingAnyProduct($this->client, $productIds)
            ->get()
            ->pluck('items');

        foreach ($productIds as $productId) {
            $counter = 0;

            foreach ($saleItemLists as $saleItemList) {
                if ($saleItemList->contains(fn (SaleItem $saleItem) => $saleItem->saleable->type() === ItemType::Product && $saleItem->saleable->id === $productId)) {
                    $counter++;
                }

                if ($counter === 3) {
                    $saleItem = $saleItemList->firstWhere(fn (SaleItem $saleItem) => $saleItem->saleable->type() === ItemType::Product && $saleItem->saleable->id === $productId);
                    
                    throw new ProductSellQuotaExceededException($saleItem->saleable);
                }
            }
        }

        return;
    }    

    public function calculateTotal(): void
    {
        $this->total = $this->items->sum(fn (SaleItem $item) => $item->quantity * $item->unit_price);
    }
}
