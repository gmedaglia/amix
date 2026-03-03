<?php

namespace App\Models;

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

/**
 * @property-read string $id
 * @property Client $client
 * @property Collection<int, SaleItem> $items
 * @property Collection<int, Product> $products
 * @property Collection<int, Service> $services
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

    public function products(): HasMany
    {
        return $this->hasMany(Product::class)->withTrashed();
    }
    
    public function services(): HasMany
    {
        return $this->hasMany(Service::class)->withTrashed();
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
            ->forClient($client, 'client')
            ->forToday();
    } 
    
    public function associateClient(Client $client)
    {
        return $this->client()->associate($client);
    }

    public function calculateTotal(): float
    {
        return $this->items->sum(fn (SaleItem $item) => $item->quantity * $item->unit_price);
    }
}
