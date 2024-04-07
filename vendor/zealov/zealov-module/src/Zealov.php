<?php

namespace Zealov;

use Illuminate\Support\Facades\Log;

class Zealov{


    public static $script = [];
    public static $style = [];
    public static $css = [];
    public static $js = [];

    /**
     * CSS载入
     **/
    public static function css($css = null)
    {
        if (!is_null($css)) {
            self::$css = array_merge(self::$css, (array)$css);
            return;
        }
        return view('zealov::extract.css', ['css' => array_unique(static::$css)]);
    }

    /**
     * JS 载入
     */
    public static function js($js = null)
    {
        if (!is_null($js)) {
            self::$js = array_merge(self::$js, (array)$js);
            return;
        }
        return view('zealov::extract.js', ['js' => array_unique(static::$js)]);
    }

    /**
     * CSS 样式代码
     */
    public static function style($style = '')
    {
        $style = trim($style);
        if (!empty($style)) {
            self::$style = array_merge(self::$style, (array)$style);
            return;
        }
        return view('zealov::extract.style', ['style' => array_unique(self::$style)]);
    }

    /**
     * JS 脚本代码
     */
    public static function script($script = '')
    {
        $script = trim($script);
        if (!empty($script)) {
            self::$script = array_merge(self::$script, (array)$script);
            return;
        }
        return view('zealov::extract.script', ['script' => array_unique(self::$script)]);
    }

}
