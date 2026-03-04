<?php

namespace Tests\Feature\Sales;

use App\Models\Client;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Service;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CreateSaleTest extends TestCase
{
    #[Test]
    public function it_creates_sale(): void
    {
        $client = Client::factory()->create();

        $products = Product::factory()->count(2)->create(['price' => 2000]);
        $services = Service::factory()->count(2)->create(['price' => 5000]);

        $response = $this->postJson("/api/clients/$client->id/sales", [
            'items' => [
                ['id' => $products->get(0)->id, 'type' => 'PRODUCT', 'quantity' => 1],
                ['id' => $services->get(0)->id, 'type' => 'SERVICE', 'quantity' => 1],
                ['id' => $products->get(1)->id, 'type' => 'PRODUCT', 'quantity' => 1],
                ['id' => $services->get(1)->id, 'type' => 'SERVICE', 'quantity' => 1],
            ]
        ]);

        $response->assertCreated()->assertJson([
            'data' => [
                'client' => [
                    'id' => $client->id,
                    'name' => $client->name,
                    'email' => $client->email,
                ]
            ]
        ]);

        $saleId = $response->json('data.id');

        $this->assertDatabaseHas(Sale::class, [
            'client_id' => $client->id,
            'client_sale_num_for_day' => 1,
            'total' => 14000
        ]);

        $this->assertDatabaseHas(SaleItem::class, [
            'sale_id' => $saleId,
            'saleable_id' => $products->get(0)->id,
            'saleable_type' => Product::class,
            'quantity' => 1,
        ]); 
        
        $this->assertDatabaseHas(SaleItem::class, [
            'sale_id' => $saleId,
            'saleable_id' => $products->get(1)->id,
            'saleable_type' => Product::class,
            'quantity' => 1,
        ]); 

        $this->assertDatabaseHas(SaleItem::class, [
            'sale_id' => $saleId,
            'saleable_id' => $services->get(0)->id,
            'saleable_type' => Service::class,
            'quantity' => 1,
        ]); 
        
        $this->assertDatabaseHas(SaleItem::class, [
            'sale_id' => $saleId,
            'saleable_id' => $services->get(1)->id,
            'saleable_type' => Service::class,
            'quantity' => 1,
        ]);         
    }

    #[Test]
    public function it_sets_client_sale_num_for_day_properly(): void
    {
        $this->freezeTime();

        $client = Client::factory()->create();

        Sale::factory()->forClient($client)->count(2)->create();

        $product = Product::factory()->create();

        $this->postJson("/api/clients/$client->id/sales", [
            'items' => [
                ['id' => $product->id, 'type' => 'PRODUCT', 'quantity' => 1],
            ]            
        ]);

        $this->assertDatabaseHas(Sale::class, [
            'client_id' => $client->id,
            'client_sale_num_for_day' => 3,
        ]);
    }
    
    #[Test]
    public function it_fails_to_creates_sale_when_one_of_the_products_has_insufficient_stock(): void
    {
        $client = Client::factory()->create();

        $products = Product::factory()->count(2)->create(['stock' => 3]);

        $response = $this->postJson("/api/clients/$client->id/sales", [
            'items' => [
                ['id' => $products->get(0)->id, 'type' => 'PRODUCT', 'quantity' => 5],
                ['id' => $products->get(1)->id, 'type' => 'PRODUCT', 'quantity' => 2],
            ]
        ]);

        $response->assertForbidden();        
    }    
}
