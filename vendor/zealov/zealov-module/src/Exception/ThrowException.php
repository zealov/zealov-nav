<?php
/****************************************
 * Created by PhpStorm.
 * Author: 刘奇.
 * QQ: 921491025
 * Date: 2023/5/25.
 * Time: 17:17.
 *****************************************/

namespace Zealov\Exception;

class ThrowException extends \Exception
{
    public static function throws($msg)
    {
        throw new ThrowException($msg);
    }

    public static function throwsIf($msg, $condition)
    {
        if ($condition) {
            throw new ThrowException($msg);
        }
    }

    public static function throwsIfResponseError($response, $prefix = '')
    {
        if ($prefix) {
            $prefix = $prefix . ':';
        }
        if (empty($response)) {
            throw new ThrowException($prefix . 'Response Empty');
        }
        if ($response['code'] != 200 && $response['code'] != 0) {

            if (isset($response['message'])) {

                $response['msg'] = $response['message'];

            }


            throw new ThrowException($prefix . $response['msg']);
        }
    }

    public static function throwsIfEmpty($msg, $object)
    {
        if (empty($object)) {
            throw new ThrowException($msg);
        }
    }

    public static function throwsIfNotEmpty($msg, $object)
    {
        if (!empty($object)) {
            throw new ThrowException($msg);
        }
    }
}
