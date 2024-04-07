<?php
/****************************************
 * Created by PhpStorm.
 * Author: 刘奇.
 * QQ: 921491025
 * Date: 2023/3/29.
 * Time: 9:30.
 *****************************************/

namespace Zealov\Kernel\Utils;

use Zealov\Kernel\Traits\ModuleTrait;

class Menu
{
    use ModuleTrait;
    /**
     * 获取菜单
     * @return array
     */
    public static function getMenuList()
    {
        $modules = self::moduleScandir();
        $menu_list = [];
        foreach ($modules as $module) {
            if (starts_with($module, '_delete_.')) {
                continue;
            }
            $file = self::path($module, 'config/adminMenu.php');
            if (file_exists($file)) {
                $menu = require $file;
                $menu_list = array_merge($menu_list, $menu);
            }
        }
        return $menu_list;
    }

}
