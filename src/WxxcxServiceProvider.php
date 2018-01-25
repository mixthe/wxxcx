<?php
namespace Mixthe\Wxxcx;

use Illuminate\Support\ServiceProvider;
use Mixthe\Wxxcx\Console\PublishConfigCommand;
use Laravel\Lumen\Application as LumenApplication;
use Illuminate\Foundation\Application as LaravelApplication;

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
        if($this->app instanceof LaravelApplication && $this->app->runningInConsole()){
            $this->publishes([
                $config_file => config_path('wxxcx.php')
            ], 'wxxcx');
        }elseif ($this->app instanceof LumenApplication) {
            $this->app->configure('wxxcx');
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
