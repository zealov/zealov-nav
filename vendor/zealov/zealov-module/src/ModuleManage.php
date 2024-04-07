<?php
/****************************************
 * Created by PhpStorm.
 * Author: 刘奇.
 * QQ: 921491025
 * Date: 2023/6/5.
 * Time: 16:00.
 *****************************************/

namespace Zealov;

use Illuminate\Support\Facades\Artisan;
use Zealov\Exception\ThrowException;
use Zealov\Kernel\Utils\FileUtil;
use Zealov\Models\SystemConfig;

class ModuleManage
{
    /**
     * 已安装模块配置保存KEY
     */
    const MODULE_ENABLE_LIST = 'ModuleList';

    /**
     * 列出本地所有的模块
     * @return array
     */
    public static function listModules()
    {
        $files = FileUtil::listFiles(base_path('module'));

        $modules = [];
        foreach ($files as $v) {
            if (!$v['isDir']) {
                continue;
            }
            if (starts_with($v['filename'], '_delete_.') || starts_with($v['filename'], '_')
                || !file_exists($v['pathname'] . '/config.json')) {
                continue;
            }
            $modules[$v['filename']] = [
                'enable' => false,
                'isSystem' => false,
                'isInstalled' => false,
                'config' => [],
            ];
        }

        foreach (self::listUserInstalledModules() as $m => $config) {
            if (isset($modules[$m])) {
                $modules[$m]['isInstalled'] = true;
                $modules[$m]['enable'] = !empty($config['enable']);
            }
        }
        foreach (self::listSystemInstalledModules() as $m => $config) {
            if (isset($modules[$m])) {
                $modules[$m]['isInstalled'] = true;
                $modules[$m]['isSystem'] = true;
                $modules[$m]['enable'] = !empty($config['enable']);
            }
        }
        return $modules;
    }

    /**
     * 获取模块的基本信息
     * @param $name
     * @return array|null
     */
    public static function getModuleBasic($name)
    {
        static $basic = [];
        if (array_key_exists($name, $basic)) {
            return $basic[$name];
        }

        if (file_exists($path = self::path($name, 'config.json'))) {
            $config = json_decode(file_get_contents($path), true);
            if (empty($config)) {
                ThrowException::throws('模块配置文件错误 - ' . $name);
            }
            $basic[$name] = array_merge([
                'name' => 'None',
                'title' => 'None',
                'version' => '1.0.0',
                'env' => [
                    'laravel5'
                ],
                'types' => [],
                'tags' => [],
                'require' => [
                    // 'Xxx:*'
                    // 'Xxx:>=*'
                    // 'Xxx:==*'
                    // 'Xxx:<=*'
                    // 'Xxx:>*'
                    // 'Xxx:<*'
                ],
                'suggest' => [
                    // 'Xxx:*'
                    // 'Xxx:>=*'
                    // 'Xxx:==*'
                    // 'Xxx:<=*'
                    // 'Xxx:>*'
                    // 'Xxx:<*'
                ],
                // 已知冲突模块
                'conflicts' => [
                    // 'Xxx:*'
                    // 'Xxx:>=*'
                    // 'Xxx:==*'
                    // 'Xxx:<=*'
                    // 'Xxx:>*'
                    // 'Xxx:<*'
                ],
                'author' => 'Author',
                'description' => 'Description',
                'config' => [],
                'providers' => [],
            ], $config);
        } else {
            $basic[$name] = null;
        }
        return $basic[$name];
    }

    public static  function listSystemInstalledModules(){
        return config('module.system');
    }
    private static function callCommand($command, $param = [])
    {
        try {
            $exitCode = Artisan::call($command, $param);
            $output = trim(Artisan::output());
            if (0 !== $exitCode) {
                return [
                    'code' => -1,
                    'msg'  => "ERROR:$exitCode",
                    'data' => ['output' => $output]
                ];
            }
            return [
                'code' => 0,
                'msg'  => "ok",
                'data' => ['output' => $output]
            ];
        } catch (ThrowException $e) {
            return [
                'code' => -1,
                'msg'  => $e->getMessage()
            ];
        }
    }

    /**
     * 模块安装
     *
     * @param $module
     * @return array
     */
    public static function install($module, $force = false)
    {
        $param = ['module' => $module];
        if ($force) {
            $param['--force'] = true;
        }
        return self::callCommand('zealov:module-install', $param);
    }

    /**
     * 模块启用
     * @param $module
     * @return array
     */
    public static function enable($module)
    {
        return self::callCommand('zealov:module-enable', ['module' => $module]);
    }


    /**
     * 模块禁用
     * @param $module
     * @return array
     */
    public static function disable($module)
    {
        return self::callCommand('zealov:module-disable', ['module' => $module]);
    }

    /**
     * 模块卸载
     * @param $module
     * @return array
     */
    public static function uninstall($module)
    {
        return self::callCommand('zealov:module-uninstall', ['module' => $module]);
    }

    /**
     * 检查模块是否存在
     * @param $name
     * @return bool
     */
    public static function isExists($name)
    {
        return file_exists(self::path($name, 'config.json'));
    }

    /**
     * 模块绝对路径
     * @param $module
     * @param string $path
     * @return string
     */
    public static function path($module, $path = '')
    {
        return base_path(self::relativePath($module, $path));
    }

    /**
     * 模块相对路径
     * @param $module
     * @param string $path
     * @return string
     */
    public static function relativePath($module, $path = '')
    {
        return "module/$module" . ($path ? "/" . trim($path, '/') : '');
    }

    /**
     * 列出所有模块，包括系统和用户安装
     * @param $forceReload boolean
     * @return array|mixed
     */
    public static function listAllInstalledModules($forceReload = false)
    {
        static $modules = null;
        if ($forceReload) {
            $modules = null;
        }
        if (null !== $modules) {
            return $modules;
        }
        $modules = array_merge(self::listUserInstalledModules());
        return $modules;
    }
    /**
     * 列出所有已安装用户模块
     * @return array|mixed
     */
    public static function listUserInstalledModules()
    {
        try {
            $value = SystemConfig::query()->where('key',self::MODULE_ENABLE_LIST)->value('value');

            return collect(json_decode($value,true))->map(function($item){
                $item['isSystem'] = false;
                if (!isset($item['enable'])) {
                    $item['enable'] = false;
                }
                return $item;
            })->toArray();

        } catch (\Exception $e) {
            return [];
        }
    }

    public static function saveUserInstalledModules($installeds){
        SystemConfig::query()->where('key',self::MODULE_ENABLE_LIST)->update(['value' =>json_encode($installeds)]);
    }


}
