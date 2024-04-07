<?php

namespace Module\WebNav\Providers;

use Illuminate\Events\Dispatcher;
use Illuminate\Support\ServiceProvider;
use Zealov\ModuleClassLoader;

class AppServiceProvider extends ServiceProvider
{

    public function boot(Dispatcher $events)
    {
        ModuleClassLoader::addClass('ZealovNav', __DIR__ . '/ZealovNav.php');
    }


    public function register()
    {

    }
}
