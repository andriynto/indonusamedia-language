<?php namespace Indonusamedia\Language;

/*
 * This file is part of the Andriyanto Indonusa Britax
 *
 * (c) Andriyanto <andriynto.dev@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Unicodeveloper\Identify\IdentifyServiceProvider;

class Provider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @param Router $router
     *
     * @return void
     */
    public function boot(Router $router)
    {
        if (!$this->app->routesAreCached()) {
            require __DIR__.'/Routes/web.php';
        }

        $this->publishes([
            __DIR__.'/Config/language.php'                                  => config_path('language.php'),
            __DIR__.'/Migrations/2020_01_01_000000_add_locale_column.php'   => database_path('migrations/2020_01_01_000000_add_locale_column.php'),
            __DIR__.'/Resources/views/flag.blade.php'                       => resource_path('views/vendor/language/flag.blade.php'),
            __DIR__.'/Resources/views/flags.blade.php'                      => resource_path('views/vendor/language/flags.blade.php'),
        ], 'language');
        
        $router->aliasMiddleware('language', config('language.middleware'));

        $this->app->register(IdentifyServiceProvider::class);

        $this->app->singleton('language', function ($app) {
            return new Language($app);
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/Config/language.php', 'language');
    }
}
