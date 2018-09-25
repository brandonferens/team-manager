<?php

namespace App\Providers;

use App\Models\Team;
use App\Observers\TeamObserver;
use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        Resource::withoutWrapping();

        Team::observe(TeamObserver::class);
    }

    /**
     * Register any application services.
     */
    public function register()
    {
        //
    }
}
