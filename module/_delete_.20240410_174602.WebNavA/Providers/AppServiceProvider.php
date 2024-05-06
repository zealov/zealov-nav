<?php

namespace Module\WebNavA\Providers;

use Illuminate\Events\Dispatcher;
use Illuminate\Support\ServiceProvider;
use Zealov\Kernel\Provider\SiteTemplate\SiteTemplateProvider;

class AppServiceProvider extends ServiceProvider
{

    public function boot(Dispatcher $events)
    {
        SiteTemplateProvider::register(BlogSiteTemplateProvider::class);
    }


    public function register()
    {

    }
}
