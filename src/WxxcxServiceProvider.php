<?php
namespace Mixthe\Wxxcx;

use Illuminate\Support\ServiceProvider;
use Mixthe\Wxxcx\Console\PublishConfigCommand;

class WxxcxServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $config_file = __DIR__ . '/../config/config.php';

        $this->mergeConfigFrom($config_file, 'wxxcx');
        if(function_exists('config_path')){
            $this->publishes([
                $config_file => config_path('wxxcx.php')
            ], 'wxxcx');
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('command.wxxcx.publish-config', function () {
            return new PublishConfigCommand();
        });

        $this->app->bind('wxxcx', function ()
        {
            return new Wxxcx();
        });

        $this->app->alias('wxxcx', Wxxcx::class);

        $this->commands(
            'command.wxxcx.publish-config'
        );
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['wxxcx', Wxxcx::class];
    }
}