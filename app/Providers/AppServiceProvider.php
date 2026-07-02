<?php

namespace App\Providers;

use App\Livewire\Hooks\CatchAdminErrors;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class AppServiceProvider extends ServiceProvider
{
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
        if ($this->app->environment('local') && ! filter_var(env('MAIL_ALLOW_SMTP', false), FILTER_VALIDATE_BOOL)) {
            config(['mail.default' => 'log']);
        }

        Livewire::componentHook(CatchAdminErrors::class);
    }
}
