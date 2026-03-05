<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Product;
use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Client::factory()->count(20)->create();

        Product::factory()->count(20)->create();
        Product::factory()->withoutStock()->count(5)->create();

        Service::factory()->count(20)->create();
    }
}
