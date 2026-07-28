<?php

namespace App\Providers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\View;
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
        // Pass active categories to the header view automatically
        View::composer('frontend.layout.header', function ($view) {
            $categories = ProductCategory::where('product_category_status', 'active')->latest()->take(3)->get();
            $view->with('categories', $categories);
        });

        // Share with ALL views globally
        View::composer('*', function ($view) {
            $top_sell_product = Product::topSelling(5)->get();
            $view->with('top_sell_product', $top_sell_product);
        });
    }
}
