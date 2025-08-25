<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Attempt;
use App\Policies\AttemptPolicy;

class AppServiceProvider extends ServiceProvider
{
    protected $policies = [
        Attempt::class => AttemptPolicy::class,
    ];

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
        //
    }
}
