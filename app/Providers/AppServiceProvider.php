<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

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
        Blade::if(
            'admin',
            fn ($value = true) => !!$value && auth()->check() and auth()->user()->isAdmin()
        );

        Blade::if(
            'flash',
            fn ($value = '') => $value !== '' && session($value)
        );
    }
}
