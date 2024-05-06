<?php


namespace Zealov\Kernel\Provider\SiteTemplate;



use Illuminate\Support\Facades\Log;

class SiteTemplateProvider
{

    private static $instances = [
        DefaultSiteTemplateProvider::class,
    ];

    public static function register($provider)
    {
        self::$instances[] = $provider;

    }


    public static function all()
    {
        Log::info(self::$instances);
        foreach (self::$instances as $k => $v) {
            if ($v instanceof \Closure) {
                self::$instances[$k] = call_user_func($v);
            } else if (is_string($v)) {
                self::$instances[$k] = app($v);
            }
        }
        return self::$instances;
    }


    public static function get($name)
    {
        foreach (self::all() as $provider) {
            if ($provider->name() == $name) {
                return $provider;
            }
        }
        return null;
    }

}
