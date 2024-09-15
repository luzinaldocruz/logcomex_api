<?php

namespace App\Providers;

// use Illuminate\Support\ServiceProvider;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

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
        parent::boot();

        // Carregue o arquivo de rotas personalizado
        Route::middleware('api')
             ->prefix('api')
             ->group(base_path('routes/api.php'));
    }
}
