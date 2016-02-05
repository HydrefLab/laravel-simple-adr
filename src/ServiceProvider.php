<?php

namespace DeSmart\Adr\Providers;

use League\Fractal\Manager;
use DeSmart\Adr\Fractal\Transformer;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * @return void
     */
    public function boot()
    {
        $configPath = __DIR__ . '/../config/adr.php';;

        $this->publishes([$configPath => config_path('adr.php'), 'adr']);
        $this->mergeConfigFrom($configPath, 'adr');
    }

    /**
     * @return void
     */
    public function register()
    {
        $this->app->bind(Transformer::class, function () {
            $manager = $this->app->make(Manager::class);
            if (isset($_GET['include'])) {
                $manager->parseIncludes($_GET['include']);
            }

            return new Transformer(
                $manager,
                $this->app,
                $this->app['config']['adr']['transformers']
            );
        });
    }
}
