<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
    $this->app->bind(AccountRepositoryInterface::class, EloquentAccountRepository::class);
    $this->app->bind(TransactionRepositoryInterface::class, EloquentTransactionRepository::class);

    $this->app->bind(TransactionService::class, fn ($app) => new TransactionService([
        TransactionType::Transfer->value => $app->make(TransferHandler::class),
        TransactionType::TopUp->value    => $app->make(TopUpHandler::class),
        TransactionType::Bill->value     => $app->make(BillHandler::class),
        ]));
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
