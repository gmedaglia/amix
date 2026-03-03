<?php

namespace Tests\Feature\Sales;

use App\Models\Client;
use App\Models\Sale;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CreateSaleTest extends TestCase
{
    #[Test]
    public function it_creates_sale(): void
    {
        $client = Client::factory()->create();

        $response = $this->postJson("/api/clients/$client->id/sales", [
        ]);

        $response->assertCreated()->assertJson([
            'data' => [
                'client' => [
                    'id' => $client->id,
                    'name' => $client->name,
                    'email' => $client->email,
                ]
            ]
        ]);;

        $this->assertDatabaseHas(Sale::class, [
            'client_id' => $client->id,
            'client_sale_num_for_day' => 1,
        ]);
    }

    #[Test]
    public function it_creates_sale2(): void
    {
        $this->freezeTime();

        $client = Client::factory()->create();

        Sale::factory()->forClient($client)->count(2)->create();

        $this->postJson("/api/clients/$client->id/sales", [
        ]);

        $this->assertDatabaseHas(Sale::class, [
            'client_id' => $client->id,
            'client_sale_num_for_day' => 3,
        ]);
    }    
}
