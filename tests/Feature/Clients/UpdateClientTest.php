<?php

namespace Tests\Feature\Clients;

use App\Models\Client;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UpdateClientTest extends TestCase
{
    #[Test]
    public function it_updates_client(): void
    {
        $client = Client::factory()->create();

        $response = $this->putJson("/api/clients/$client->id", [
            'name' => 'Edinson',
            'email' => 'edi@gmail.com',
        ]);

        $response->assertOk();

        $this->assertDatabaseHas(Client::class, [
            'id' => $client->id,
            'name' => 'Edinson',
            'email' => 'edi@gmail.com',            
        ]);
    }     
}
