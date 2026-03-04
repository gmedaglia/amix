<?php

namespace App\Providers;

use App\Models\Sale;
use App\Policies\SalePolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Route::bind('sale', function (string $value) {
            return Sale::query()
                ->with('client')
                ->with('items')
                ->where('id', $value)
                ->firstOrFail();
        });

        Gate::define('create-sale', [SalePolicy::class, 'create']);        
    }
}
