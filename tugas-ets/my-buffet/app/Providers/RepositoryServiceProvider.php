<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(\App\Repositories\UserRepository::class, \App\Repositories\UserRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\RestaurantRepository::class, \App\Repositories\RestaurantRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\MenuRestaurantRepository::class, \App\Repositories\MenuRestaurantRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\OrderRepository::class, \App\Repositories\OrderRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\OrderDetailRepository::class, \App\Repositories\OrderDetailRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\RecentTransferRepository::class, \App\Repositories\RecentTransferRepositoryEloquent::class);
        //:end-bindings:
    }
}
