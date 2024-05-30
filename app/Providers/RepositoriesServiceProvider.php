<?php

namespace App\Providers;

use App\Models\Discount;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Repositories\DiscountRepositories\DiscountRepository;
use App\Repositories\DiscountRepositories\DiscountRepositoryInterface;
use App\Repositories\OrderRepositories\OrderRepository;
use App\Repositories\OrderRepositories\OrderRepositoryInterface;
use App\Repositories\ProductRepositories\ProductRepository;
use App\Repositories\ProductRepositories\ProductRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoriesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->app->bind(ProductRepositoryInterface::class, function ($app){ return new ProductRepository(new Product()); });
        $this->app->bind(OrderRepositoryInterface::class, function ($app){ return new OrderRepository(new Order()); });
        $this->app->bind(DiscountRepositoryInterface::class, function ($app){ return new DiscountRepository(new Discount()); });
    }
}
