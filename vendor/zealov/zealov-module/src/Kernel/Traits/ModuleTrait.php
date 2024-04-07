<?php
/****************************************
 * Created by PhpStorm.
 * Author: 刘奇.
 * QQ: 921491025
 * Date: 2023/3/29.
 * Time: 9:47.
 *****************************************/

namespace Zealov\Kernel\Traits;
trait ModuleTrait
{
    /**
     * 获取所有模块
     * @return array
     */
    private static function moduleScandir()
    {

        $dir = [];

        $modules = scandir(base_path('module'));

        if (!$modules) {
            return $dir;
        }

        foreach ($modules as $module) {
            if ($module != '.' && $module != '..') {
                $dir [] = $module;
            }
        }

        return $dir;
    }

    /**
     * 模块绝对路径
     * @param        $module
     * @param string $path
     * @return string
     */
    public static function path($module, $path = '')
    {
        return base_path(self::relativePath($module, $path));
    }

    /**
     * 模块相对路径
     * @param        $module
     * @param string $path
     * @return string
     */
    public static function relativePath($module, $path = '')
    {
        return "module/$module" . ($path ? "/" . trim($path, '/') : '');
    }
}
