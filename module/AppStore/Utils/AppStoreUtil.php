<?php
/****************************************
 * Created by PhpStorm.
 * Author: 刘奇.
 * QQ: 921491025
 * Date: 2023/5/25.
 * Time: 16:49.
 *****************************************/

namespace Module\AppStore\Utils;

use Chumper\Zipper\Zipper;
use Illuminate\Support\Facades\Log;
use Zealov\Exception\ThrowException;
use Zealov\Kernel\Utils\CurlUtil;
use Zealov\Kernel\Utils\FileUtil;
use Zealov\ModuleManage;

class AppStoreUtil
{
    const REMOTE_BASE = 'https://www.zealov.com';

    public static function moduleData()
    {
        $app = 'blog';
        $ret = CurlUtil::getJSONData(self::REMOTE_BASE . '/api/store/module', [
            'app' => $app,
        ]);
        return $ret;
    }

    public static function all()
    {
        $result = self::moduleData();

        $modules = [];
        if (!empty($result['data']['modules'])) {
            foreach ($result['data']['modules'] as $remote) {
                $remote['_isLocal'] = false;
                $remote['_isInstalled'] = false;
                $remote['_isEnabled'] = false;
                $remote['_localVersion'] = null;
                $remote['_isSystem'] = false;
                $remote['_hasConfig'] = false;
                $modules[$remote['name']] = $remote;
            }
        }
        foreach(ModuleManage::listModules() as $m => $config){
            $info = ModuleManage::getModuleBasic($m);
            if (isset($modules[$m])) {
                $modules[$m]['_isInstalled'] = $config['isInstalled'];
                $modules[$m]['_isEnabled'] = $config['enable'];
                $modules[$m]['_isSystem'] = $config['isSystem'];
                $modules[$m]['_localVersion'] = $info['version'];
            }
        }



        return ['modules' => array_values($modules)];
    }

    public static function removeModule($module, $version)
    {
        $moduleDir = base_path('module/' . $module);
        ThrowException::throwsIf('模块目录不存在 ', !file_exists($moduleDir));
        ThrowException::throwsIf('模块目录 module/' . $module . ' 不正常，请手动删除', !is_dir($moduleDir));
        $moduleBackup = '_delete_.' . date('Ymd_His') . '.' . $module;
        $moduleBackupDir = base_path("module/$moduleBackup");
        try {
            rename($moduleDir, $moduleBackupDir);
        } catch (\Exception $e) {
            ThrowException::throws("移除模块 $module 到 $moduleBackup 失败，请确保模块 $module 中没有文件正在被使用");
        }
        ThrowException::throwsIf('模块目录备份失败', !file_exists($moduleBackupDir));
        return [
            'code' => 0,
            'msg'  => 'ok',
            'data' => [

            ]

        ];
    }
    private static function baseRequest($api, $data, $token)
    {
        return CurlUtil::postJSONBody(self::REMOTE_BASE . $api, $data, [
            'header' => [
                'token'        => $token,
                'X-Requested-With' => 'XMLHttpRequest',
            ]
        ]);
    }

    public static function downloadPackage($token, $module, $version)
    {
        $res = self::baseRequest('/api/store/module_package', [
            'module' => $module,
            'version' => $version,
        ], $token);
        ThrowException::throwsIfResponseError($res);
        $package = $res['data']['package'] ;
        $packageMd5 = $res['data']['packageMd5'];
        $licenseKey = $res['data']['licenseKey'];
        $data = CurlUtil::getRaw($package);
        $zipTemp = FileUtil::generateLocalTempPath('zip');
        file_put_contents($zipTemp, $data);
        ThrowException::throwsIf('文件MD5校验失败', md5_file($zipTemp) != $packageMd5);
        return [
            'code' => 0,
            'msg'  => 'ok',
            'data' => [
                'package'     => $zipTemp,
                'licenseKey'  => $licenseKey,
                'packageSize' => filesize($zipTemp),
            ]

        ];
    }

    public static function unpackModule($module, $package, $licenseKey)
    {
        $results = [];
        ThrowException::throwsIf('文件不存在 ' . $package, empty($package) || !file_exists($package));
        $moduleDir = base_path('module/' . $module);
        if (file_exists($moduleDir)) {
            $moduleBackup = '_delete_.' . date('Ymd_His') . '.' . $module;
            ThrowException::throwsIf('模块目录 module/' . $module . ' 不正常，请手动删除', !is_dir($moduleDir));
            $moduleBackupDir = base_path("module/$moduleBackup");
            try {
                rename($moduleDir, $moduleBackupDir);
            } catch (\Exception $e) {
                ThrowException::throws("备份模块 $module 到 $moduleBackup 失败（确保模块中所有文件和目录已关闭）");
            }
            ThrowException::throwsIf('备份模块旧文件失败', !file_exists($moduleBackupDir));
            $results[] = "备份模块 $module 到 $moduleBackup";
        }
        ThrowException::throwsIf('模块目录 module/' . $module . ' 不正常，请手动删除', file_exists($moduleDir));
        $zipper = new Zipper();
        $zipper->make($package);
        if ($zipper->contains($module . '/config.json')) {
            $zipper->folder($module . '');
        }
        $zipper->extractTo($moduleDir);
        $zipper->close();
        ThrowException::throwsIf('解压失败', !file_exists($moduleDir . '/config.json'));
        file_put_contents($moduleDir . '/license.json', json_encode([
            'licenseKey' => $licenseKey,
        ]));
        self::cleanDownloadedPackage($package);
        return [
            'code' => 0,
            'msg'  => 'ok',
            'data' => $results
        ];
    }

    public static function cleanDownloadedPackage($package)
    {
        FileUtil::safeCleanLocalTemp($package);
    }

    public static function checkPackage($token, $module, $version)
    {
        $res = self::baseRequest('/api/store/module_info', [
            'module' => $module,
            'version' => $version,
        ], $token);
        ThrowException::throwsIfResponseError($res);
        Log::info($res);
        $config = $res['data']['config'];
        $packageSize = $res['data']['packageSize'];

        return [
            'code' => 0,
            'msg'  => 'ok',
            'data' => [
                'requires'=>[],
                'errorCount'=>0,
                'packageSize'=>$packageSize
            ]
        ];
    }
}
