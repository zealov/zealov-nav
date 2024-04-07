<?php

namespace Zealov;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Zealov\Kernel\Traits\ModuleTrait;

class ZealovServiceProvider extends ServiceProvider
{
    use ModuleTrait;

    protected $commands = [
        \Zealov\Command\AssertPublishCommand::class,
        \Zealov\Command\ModuleInstallCommand::class,
        \Zealov\Command\ModuleEnableCommand::class,
        \Zealov\Command\ModuleDisableCommand::class,
        \Zealov\Command\ModuleUninstallCommand::class,
    ];

    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../views', 'zealov');
        $this->loadViewsFrom(base_path('module'), 'module');

        $this->publishes([__DIR__ . '/../asset' => public_path('asset')], 'zealov');

        $this->registerModuleRoutes();
        $this->registerDefaultRoutes();

    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/zealov.php', 'zealov');
        $this->loadAdminAuthConfig();
        $this->registerModuleMiddlewares();
        $this->registerAppServiceProviders();
        $this->commands($this->commands);
        $this->app->singleton('SystemConfig', config('zealov.config.systemConfig'));

        $this->registerBladeDirectives();
    }

    private function registerBladeDirectives()
    {
        $this->app->singleton('assetPathDriver', config('zealov.asset.driver'));

        Blade::directive('asset', function ($expression = '') use (&$assetBase) {
            if (empty($expression)) {
                return '';
            }
            if (PHP_VERSION_ID > 80000) {
                $regx = '/(.+)/i';
            } else {
                $regx = '/\\((.+)\\)/i';
            }
            if (preg_match($regx, $expression, $mat)) {
                $file = trim($mat[1], '\'" "');
                $driver = app('assetPathDriver');
                return $driver->getCDN($file) . $driver->getPathWithHash($file);
            } else {
                return '';
            }
        });
    }

    protected function loadAdminAuthConfig()
    {
        config(Arr::dot(config('zealov.auth', []), 'auth.'));
    }


    /**
     * 注册模块中间件
     * @return void
     */
    public function registerModuleMiddlewares()
    {
        $modules = self::moduleScandir();

        $router = app('router');

        foreach ($modules as $module) {

            $file = self::path($module, 'config/config.php');

            if (!file_exists($file)) {
                continue;
            }

            $config = require $file;

            if (!isset($config['middlewares'])) {
                continue;
            }
            if (!is_array($config['middlewares'])) {
                continue;
            }
            foreach ($config['middlewares'] as $key => $middleware) {
                if (method_exists($router, 'aliasMiddleware')) {
                    $router->aliasMiddleware($module . '.' . $key, $middleware);
                }
                $router->middleware($module . '.' . $key, $middleware);
            }
        }
    }

    public function registerAppServiceProviders(){

        $providers = [];
        $modules = self::moduleScandir();

        foreach($modules as $module){
            $provider = "\\Module\\$module\\Providers\\AppServiceProvider";
            if (class_exists($provider)) {
                $providers[] = $provider;
            }
        }

        foreach ($providers as $provider) {
            if (class_exists($provider)) {
                $this->app->register($provider);
            }
        }
    }


    public function registerDefaultRoutes()
    {
        Route::prefix(config('zealov.admin.prefix'))->group(__DIR__ . '/../routes/admin.php');
        Route::prefix(config('zealov.api.prefix'))->group(__DIR__ . '/../routes/api.php');
    }

    /**
     * 注册模块路由
     * @return void
     */
    public function registerModuleRoutes()
    {
        $modules = self::moduleScandir();

        $routes = config('zealov.routes');

        foreach ($modules as $module) {
            foreach ($routes as $key => $route) {
                $file = self::path($module, $route);
                if (file_exists($file)) {
                    Route::prefix($this->prefix($module, $key))->group($file);
                }
            }
        }
    }

    /**
     * 获取配置前缀
     * @param $module
     * @param $key
     * @return mixed
     */

    public function prefix($module, $key)
    {
        $config = config('zealov');

        $prefix = $config[$key]['prefix'];

        $file = self::path($module, 'config/config.php');

        if (!file_exists($file)) {
            return $prefix;
        }

        $config = require $file;

        if (!isset($config[$key]['prefix'])) {
            return $prefix;
        }
        return $config[$key]['prefix'];
    }


}
