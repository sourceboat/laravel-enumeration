<?php

namespace Sourceboat\Enumeration;

use Illuminate\Support\ServiceProvider;
use Sourceboat\Enumeration\Commands\MakeEnumerationCommand;

class EnumerationServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     */
    public function boot(): void
    {
        $this->bootCommands();
    }

    /**
     * Boot the custom commands
     *
     * @return void
     */
    private function bootCommands(): void
    {
        if (!$this->app->runningInConsole()) {
            return;
        }

        $this->commands([
            MakeEnumerationCommand::class,
        ]);
    }
}
