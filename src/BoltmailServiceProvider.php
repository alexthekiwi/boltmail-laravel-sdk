<?php

namespace AlexClark\Boltmail;

use Illuminate\Support\ServiceProvider;

class BoltmailServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->singleton(Boltmail::class, function () {
            return new Boltmail(config('boltmail.public_key'));
        });

        $this->app->alias(Boltmail::class, 'boltmail');

        $this->publishes([
            __DIR__.'/config.php' => config_path('boltmail.php'),
        ]);
    }
}
