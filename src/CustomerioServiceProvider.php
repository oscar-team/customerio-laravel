<?php

namespace Oscar\CustomerioLaravel;

use Illuminate\Support\ServiceProvider;

class CustomerioServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes(
                [__DIR__ . '/../config/customerio.php' => config_path('customerio.php')],
                'customerio-config'
            );
        }
    }

    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/customerio.php', 'customerio');

        // The workspace manager is used to resolve various connections, since multiple
        // connections might be managed. It also implements the connection resolver
        // interface which may be used by other components requiring connections.
        $this->app->singleton('customerio', function ($app) {
            return new CustomerIoManager($app);
        });
    }
}
