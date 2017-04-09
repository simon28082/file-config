<?php
namespace CrCms\FileConfig;

use CrCms\Repository\Console\Commands\Magic;
use CrCms\Repository\Console\Commands\Repository;
use Illuminate\Support\ServiceProvider;

class ConfigServiceProvider extends ServiceProvider
{

    /**
     * @var bool
     */
    protected $defer = false;

    /**
     * @var string
     */
    protected $namespaceName = 'file_config';

    /**
     * @var string
     */
    protected $packagePath = __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR;


    /**
     *
     */
    public function boot()
    {
        //move config path
        $this->publishes([
            $this->packagePath.'config' => config_path(),
        ]);
    }


    /**
     *
     */
    public function register()
    {
        //merge config
        $configFile = $this->packagePath."config/{$this->namespaceName}.php";
        if (file_exists($configFile)) {
            $this->mergeConfigFrom($configFile, $this->namespaceName);
        }

        $this->app->singleton('file.config',function($app){
            return Config::instance($app['config']['file_config']);
        });
    }


    public function provides()
    {
        return [
            'file.config'
        ];
    }

}