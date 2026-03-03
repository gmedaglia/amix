<?php

namespace Tests\Feature\Products;

use App\Models\Product;
use App\Models\Service;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class DeleteProductTest extends TestCase
{
    #[Test]
    public function after_deleting_product_it_also_deletes_depending_services(): void
    {
        $product = Product::factory()->create();

        $productDependantServices = Service::factory()->dependingOnProduct($product)->count(3)->create();
        $nonProductDependantServices = Service::factory()->count(2)->create();

        $response = $this->deleteJson("/api/products/$product->id");

        $response->assertNoContent();

        $this->assertSoftDeleted(Product::class, [
            'id' => $product->id,
        ]);

        $this->assertSoftDeleted(Service::class, [
            'id' => $productDependantServices->get(0)->id,
        ]);  
        
        $this->assertSoftDeleted(Service::class, [
            'id' => $productDependantServices->get(1)->id,
        ]);  
        
        $this->assertSoftDeleted(Service::class, [
            'id' => $productDependantServices->get(2)->id,
        ]);
        
        $this->assertDatabaseHas(Service::class, [
            'id' => $nonProductDependantServices->get(0)->id,
        ]); 
        
        $this->assertDatabaseHas(Service::class, [
            'id' => $nonProductDependantServices->get(1)->id,
        ]);         
    }
}
