<?php

namespace Funkywaddle\LaravelServices\Providers;

use Illuminate\Support\ServiceProvider;
use Funkywaddle\LaravelServices\Console\Commands\ServiceMakeCommand;
use Funkywaddle\LaravelServices\Console\Commands\ServiceProviderMakeCommand;

class LaravelServicesServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->createAppDirectory('Services');
        $this->createAppDirectory('ServiceProviders');

        $this->registerCustomServiceProviders();
    }

    public function boot()
    {
        $this->addCommands();
    }

    protected function registerCustomServiceProviders() {
        $dir = app_path() . '/ServiceProviders';
        $sps = [];

        if(is_dir($dir)){
            $sps = array_diff(scandir($dir), ['.','..']);    
        }
        
        foreach($sps as $file) {
            $class = explode('.', $file);

            if($class[1] == 'php'){
                $this->app->register('\\App\\ServiceProviders\\' . $class[0]);
            }
        }
    }

    protected function createAppDirectory($dir) {
        if ($this->app->runningInConsole()) {
            if(! is_dir(app_path().'/'.$dir)) {
                mkdir(app_path().'/'.$dir);
            }
        }
    }

    protected function addCommands() {
        if ($this->app->runningInConsole()) {
            $this->commands([
                ServiceMakeCommand::class,
                ServiceProviderMakeCommand::class,
            ]);
        }
    }
}
