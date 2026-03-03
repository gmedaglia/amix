<?php

namespace Tests\Feature\Clients;

use App\Models\Client;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class GetClientTest extends TestCase
{
    #[Test]
    public function it_retrieves_client(): void
    {
        $client = Client::factory()->create();

        $response = $this->getJson("/api/clients/$client->id");

        $response->assertOk()->assertExactJson([
            'data' => [
                'id' => $client->id,
                'name' => $client->name,
                'email' => $client->email,
            ]
        ]);
    }      
}
