<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Logos;

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
    // public function boot() {}

    public function boot(): void
    {
        require_once app_path('helpers.php');


        // Partager le logo avec toutes les vues
        View::composer('*', function ($view) {
            $logo = Logos::latest()->first();
            $view->with('globalLogo', $logo);
        });
    }
}
