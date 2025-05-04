<?php

namespace App\Providers;

use App\Interfaces\TravelRequestRepositoryInterface;
use App\Repositories\TravelRequestRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Interfaces\TravelRequestRepositoryInterface::class,
            \App\Repositories\TravelRequestRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
