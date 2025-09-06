<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Repositories\Contracts\OrderInterface::class,
            \App\Repositories\Eloquent\OrderRepository::class
        );

        $this->app->bind(
            \App\Repositories\Contracts\PaymentGatewayInterface::class,
            \App\Repositories\Eloquent\PaymentGatewayRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
