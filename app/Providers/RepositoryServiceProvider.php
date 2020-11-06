<?php

namespace App\Providers;

use App\Interfaces\BaseRepositoryInterface;
use App\Interfaces\BudgetRepositoryInterface;
use App\Repositories\BaseRepository;
use App\Repositories\BudgetRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(BaseRepositoryInterface::class, BaseRepository::class);
        $this->app->bind(BudgetRepositoryInterface::class, BudgetRepository::class);
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
