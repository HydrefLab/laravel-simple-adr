<?php

namespace DeSmart\Adr;

use Illuminate\Http\Request;
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

        $this->publishes([$configPath => config_path('adr.php')]);
        $this->mergeConfigFrom($configPath, 'adr');
    }

    /**
     * @return void
     */
    public function register()
    {
        $this->app->bind(Transformer::class, function () {
            $request = $this->app->make(Request::class);

            $manager = $this->app->make(Manager::class);
            if (null !== $request->get('include')) {
                $manager->parseIncludes($request->get('include'));
            }

            return new Transformer(
                $manager,
                $this->app,
                $this->app['config']['adr']['transformers']
            );
        });
    }
}
