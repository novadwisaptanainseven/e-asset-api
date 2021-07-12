<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
        // URL API E-Pekerja
        $url_api_epekerja = "https://disperkim.samarindakota.go.id/e-pekerja-api/api/";
        config(["url_api_epekerja" => $url_api_epekerja]);
    }
}
