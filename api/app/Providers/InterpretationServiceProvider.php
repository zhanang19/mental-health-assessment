<?php

namespace App\Providers;

use App\Service\Interpretation\BaseInterpretation;
use App\Service\Interpretation\BaseInterpretationInterface;
use Illuminate\Support\ServiceProvider;

class InterpretationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(BaseInterpretationInterface::class, BaseInterpretation::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
