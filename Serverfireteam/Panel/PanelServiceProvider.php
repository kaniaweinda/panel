<?php namespace Serverfireteam\Panel;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\Route;
use Serverfireteam\Panel\libs;

class PanelServiceProvider extends ServiceProvider
{
    protected $defer = false;
        
    public function register()
    {
        $this->app->register('Zofe\Rapyd\RapydServiceProvider');
        
        include __DIR__."/commands/ServerfireteamCommand.php";
        $this->app['panel::install'] = $this->app->share(function($app)
        {
            return new \Serverfireteam\Panel\Commands\panelCommand();
        });

        $this->commands('panel::install');
        
    }
        
    public function boot()
    {
        $this->package('serverfireteam/panel');

        $base_path  = base_path();
        $base_path .= "/vendor/serverfireteam/panel/src/views";

        \View::addLocation($base_path);
        \View::addNamespace('panelViews', $base_path);  
        $testModel = new Admin();
        include __DIR__."/../../routes.php";


        AliasLoader::getInstance()->alias('Serverfireteam', 'Serverfireteam\Panel\Serverfireteam');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array();
    }
    
    
}