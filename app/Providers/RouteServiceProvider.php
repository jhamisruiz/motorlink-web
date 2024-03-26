<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */

    public function register(): void
    {
        //
    }



    /**
     * Definir la ruta de redireccionamiento después del inicio de sesión.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->booted(function () {
            $this->defineRedirectAfterLogin();
        });
    }

    /**
     * Define la redirección después del inicio de sesión.
     *
     * @return void
     */
    protected function defineRedirectAfterLogin()
    {
        Route::redirect('/inicio', '/inicio');
    }
}
