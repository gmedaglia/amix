<?php

namespace Tests\Feature\Clients;

use App\Models\Client;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AddClientTest extends TestCase
{
    #[Test]
    public function it_adds_client(): void
    {
        $response = $this->postJson('/api/clients', [
            'name' => 'Lio Messi',
            'email' => 'lio@gmail.com',
        ]);

        $response->assertCreated()->assertJson([
            'data' => [
                'name' => 'Lio Messi',
                'email' => 'lio@gmail.com',
            ]
        ]);;

        $this->assertDatabaseHas(Client::class, [
            'name' => 'Lio Messi',
            'email' => 'lio@gmail.com',
        ]);
    }
}
