<?php

namespace App\Providers;

use Illuminate\Database\Schema\Builder;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        require_once app_path('helpers.php');
    }

    /**
     * Bootstrap any application services.
     *
     * Fix pour MySQL < 5.7.7 (XAMPP) :
     * "La clé est trop longue. Longueur maximale: 1000"
     */
    public function boot(): void
    {
        // Limite la longueur des chaînes de caractères pour les index MySQL
        Builder::defaultStringLength(191);
    }
}
