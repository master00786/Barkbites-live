<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Category;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Safe category sharing (no error if table not ready)
        if (Schema::hasTable('categories')) {
            $categories = Category::all();
            view()->share('categories', $categories);
        } else {
            view()->share('categories', collect());
        }
    }
}
