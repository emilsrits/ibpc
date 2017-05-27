<?php

namespace App\Providers;

use App\Category;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $parentCategories = Category::where('parent', 1)->where('status', 1)->get();
        $childCategories = Category::where('parent', 0)->where('status', 1)->get();

        View::share([
            'parentCategories' => $parentCategories,
            'childCategories' => $childCategories,
            'errors' => null
        ]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() == 'local') {
            $this->app->register('Laracasts\Generators\GeneratorsServiceProvider');
        }
    }
}
