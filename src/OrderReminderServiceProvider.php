<?php

namespace Rapidez\OrderReminder;

use Illuminate\Support\ServiceProvider;

class OrderReminderServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/rapidez-order-reminder.php', 'rapidez-order-reminder');
    }

    public function boot()
    {
        $this
            ->bootRoutes()
            ->bootViews()
            ->bootPublishables()
            ->bootFilters();
    }

    public function bootRoutes() : self
    {
        $this->loadRoutesFrom(__DIR__.'/../routes/api.php');
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');

        return $this;
    }

    public function bootViews() : self
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'rapidez-order-reminder');

        return $this;
    }

    public function bootPublishables() : self
    {
        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/rapidez-order-reminder'),
        ], 'rapidez-order-reminder-views');

        $this->publishes([
            __DIR__.'/../config/rapidez-order-reminder.php' => config_path('rapidez-order-reminder.php'),
        ], 'rapidez-order-reminder-config');

        return $this;
    }

    public function bootFilters() : self
    {
        Eventy::addFilter('index.product.data', function ($data) {
            // Manipulate the data
            return $data;
        });

        Eventy::addFilter('index.product.mapping', fn ($mapping) => array_merge_recursive($mapping ?: [], [
            'properties' => [
                // Additional mappings
            ],
        ]));
    }
}
