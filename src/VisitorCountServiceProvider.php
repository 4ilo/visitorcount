<?php

namespace Ovde\Visitorcount;

use Carbon\Carbon;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Ovde\Visitorcount\Middleware\CountVisit;

class VisitorCountServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @param Router $router
     * @return void
     */
    public function boot(Router $router)
    {
        $this->loadMigrationsFrom(__DIR__."/migrations");
        $this->loadViewsFrom(__DIR__."/views", "visitorcount");
        $this->loadRoutesFrom(__DIR__."/routes.php");
        
        // Publish javascript
        $this->publishes([
            __DIR__."/assets" => public_path("vendor/visitorcount"),
        ], "public");
        
        // Publish config
        $this->publishes([
            __DIR__."/../config/visitorcount.php" => config_path("visitorcount.php"),
        ]);
        
        // Register the countVisit middleware
        $router->aliasMiddleware("countVisit", CountVisit::class);
        
        // Add data to the views
        view()->composer("visitorcount::stats", function($view) {
            $view->with("dezeMaand", Visit::aantalDezeMaand());
    
            $datum = new Carbon('last month');
            $maand = $datum->month;
            $jaar = $datum->year;
            $vorigeMaand = Visit::aantalInMaand($maand, $jaar);
            $view->with("vorigeMaand", $vorigeMaand);
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__."/../config/visitorcount.php", "visitorcount");
    }
}
