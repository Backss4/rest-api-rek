<?php

namespace App\Providers;

use App\Services\Petstore\Petstore;
use Illuminate\Support\ServiceProvider;

class PetstoreServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(Petstore::class, function ($app) {
            return new Petstore(
                config('petstore.url'),
                config('petstore.connect_timeout'),
                config('petstore.timeout'),
                config('petstore.retries'),
                config('petstore.retry_delay')
            );
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }

    public function provides(): array
    {
        return [Petstore::class];
    }
}
