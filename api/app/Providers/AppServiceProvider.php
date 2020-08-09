<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Relations\Relation;
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
        // Relation::morphMap([
        //     'family' => 'App\Family',
        //     'employee' => 'App\Employee',
        //     'daycare' => 'App\DaycareFacility',
        //     'parent' => 'App\Guardian',
        // ]);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
