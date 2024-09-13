<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use App\Services\SalaryCalculator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(SalaryCalculator::class, function ($app) {
            return new SalaryCalculator(
                $app->make('App\Services\LessonSalaryService'),
                $app->make('App\Services\GroupLessonSalaryService'),
                $app->make('App\Services\TrialLessonSalaryService')
            );
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::defaultView('vendor.pagination.bootstrap-4');
    }
}
