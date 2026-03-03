<?php

namespace Tests\Feature\Clients;

use App\Models\Client;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class DeleteClientTest extends TestCase
{
    #[Test]
    public function it_deletes_client(): void
    {
        $client = Client::factory()->create();

        $response = $this->deleteJson("/api/clients/$client->id");

        $response->assertNoContent();

        $this->assertSoftDeleted(Client::class, [
            'id' => $client->id,
        ]);
    }    
}
