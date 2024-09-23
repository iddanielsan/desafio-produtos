<?php

namespace App\Providers;

use App\Contracts\NotificationServiceContract;
use App\Contracts\OrderServiceContract;
use App\Contracts\ProductServiceContract;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Models\Order;
use App\Models\Product;
use App\Services\NotificationService;
use App\Services\OrderService;
use App\Services\ProductService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->when(ProductController::class)
            ->needs(ProductServiceContract::class)
            ->give(ProductService::class);

        $this->app->when(ProductService::class)
            ->needs(Model::class)
            ->give(Product::class);

        $this->app->when(OrderController::class)
            ->needs(OrderServiceContract::class)
            ->give(OrderService::class);

        $this->app->when(OrderService::class)
            ->needs(Model::class)
            ->give(Order::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
