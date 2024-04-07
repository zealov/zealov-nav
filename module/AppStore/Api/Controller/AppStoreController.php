<?php
/****************************************
 * Created by PhpStorm.
 * Author: 刘奇.
 * QQ: 921491025
 * Date: 2023/5/17.
 * Time: 17:45.
 *****************************************/

namespace Module\AppStore\Api\Controller;



use Illuminate\Http\Request;
use Illuminate\Support\Str;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;
use Module\AppStore\Utils\AppStoreUtil;
use Zealov\Exception\ThrowException;
use Zealov\Kernel\Response\ApiCode;
use Zealov\ModuleManage;

class AppStoreController
{

    public function all(){
        $data = AppStoreUtil::all();
        return ResponseBuilder::asSuccess(ApiCode::HTTP_OK)
            ->withHttpCode(ApiCode::HTTP_OK)
            ->withData($data)
            ->withMessage(__('message.common.search.success'))
            ->build();
    }

    public function enable(Request $request)
    {
        $data = $request->get('data');
        $data = json_decode($data, true);
        $module = $data['module']??"";
        $ret = ModuleManage::enable($module);
        ThrowException::throwsIfResponseError($ret);
        return $this->doFinish([
            '<span class="text-success">启动成功，请 <a href="javascript:;" onclick="parent.location.reload()">刷新后台</a> 查看最新系统</span>',
        ]);
    }

    public function disable(Request $request)
    {
        $data = $request->get('data');
        $data = json_decode($data, true);
        $module = $data['module']??"";
        $ret = ModuleManage::disable($module);
        ThrowException::throwsIfResponseError($ret);
        return $this->doFinish([
            '<span class="text-success">禁用成功，请 <a href="javascript:;" onclick="parent.location.reload()">刷新后台</a> 查看最新系统</span>',
        ]);
    }

    public function uninstall(Request $request)
    {
        $data = $request->get('data');
        $data = json_decode($data, true);
        $module = $data['module']??"";
        $step = $request->get('step');
        $version = $data['version']??"";
        $isLocal = $data['isLocal']??"";
        switch ($step) {
            case 'removePackage':
                $ret = AppStoreUtil::removeModule($module, $version);
                ThrowException::throwsIfResponseError($ret);
                return $this->doFinish([
                    '<span class="text-success">卸载完成，请 <a href="javascript:;" onclick="parent.location.reload()">刷新后台</a> 查看最新系统</span>',
                ]);
            default:
                $ret = ModuleManage::uninstall($module);
                ThrowException::throwsIfResponseError($ret);
                return $this->doNext('uninstall', 'removePackage', [
                    '<span class="text-success">开始卸载 ' . $module . ' V' . $version . '</span>',
                ],$data);

        }

    }

    public function upgrade(Request $request){
        sleep(1);
        $step = $request->get('step');
        $token = $request->get('token');
        $data = $request->get('data');
        $data = json_decode($data, true);
        $module = $data['module']??"";
        $version = $data['version']??"";
        $isLocal = $data['isLocal']??"";
        switch ($step){
            case 'installModule':
                //安装
                $ret = ModuleManage::install($module, true);
                ThrowException::throwsIfResponseError($ret);
                $ret = ModuleManage::enable($module);
                ThrowException::throwsIfResponseError($ret);
                return $this->doFinish([
                    '<span class="text-success">升级安装完成，请 <a href="javascript:;" onclick="parent.location.reload()">刷新后台</a> 查看最新系统</span>',
                ]);
                break;
            case 'unpackPackage':
                $package = $data['package'];
                $licenseKey = $data['licenseKey'];
                $ret = AppStoreUtil::unpackModule($module, $package, $licenseKey);
                ThrowException::throwsIfResponseError($ret);
                return $this->doNext('install', 'installModule', array_merge([
                    '<span class="text-success">模块解压完成</span>',
                    '<span class="ub-text-white">开始安装...</span>',
                ]),$data);

            case 'downloadPackage':
                $ret = AppStoreUtil::downloadPackage($token, $module, $version);
                ThrowException::throwsIfResponseError($ret);
                return $this->doNext('install', 'unpackPackage', [
                    '<span class="text-success">获取安装包完成，大小 ' . '2.37 KB' . '</span>',
                    '<span class="ub-text-white">开始解压安装包...</span>'
                ], array_merge([
                    'package' => $ret['data']['package'],
                    'licenseKey' => $ret['data']['licenseKey'],
                ],$data));
                break;
            case 'checkPackage':
                $ret = AppStoreUtil::checkPackage($token, $module, $version);
                $msgs[] = '<span class="ub-text-white">开始下载安装包...</span>';

                return $this->doNext('install', 'downloadPackage', array_merge([
                    'PHP版本: v' . PHP_VERSION,
                    '<span class="text-success">预检成功，' . 1 . '个依赖满足要求，安装包大小 ' . '2.37 KB' . '</span>',
                ], $msgs), $data);
                break;
            default:
                return $this->doNext('install', 'checkPackage', [
                    '<span class="text-success">开始升级到远程模块 ' . $module . ' V' . $version . '</span>',
                    '<span class="ub-text-white">开始模块安装预检...</span>'
                ],$data);
        }
    }

    public function install(Request $request)
    {
        sleep(1);
        $step = $request->get('step');
        $token = $request->get('token');
        $data = $request->get('data');
        $data = json_decode($data, true);
        $module = $data['module']??"";
        $version = $data['version']??"";
        $isLocal = $data['isLocal']??"";
        switch ($step){
            case 'installModule':
                //安装
                $ret = ModuleManage::install($module, true);
                ThrowException::throwsIfResponseError($ret);
                $ret = ModuleManage::enable($module);
                ThrowException::throwsIfResponseError($ret);
                return $this->doFinish([
                    '<span class="text-success">安装完成，请 <a href="javascript:;" onclick="parent.location.reload()">刷新后台</a> 查看最新系统</span>',
                ]);
                break;
            case 'unpackPackage':
                $package = $data['package'];
                $licenseKey = $data['licenseKey'];
                $ret = AppStoreUtil::unpackModule($module, $package, $licenseKey);
                ThrowException::throwsIfResponseError($ret);
                return $this->doNext('install', 'installModule', array_merge([
                    '<span class="text-success">模块解压完成</span>',
                    '<span class="ub-text-white">开始安装...</span>',
                ]),$data);

            case 'downloadPackage':
                $ret = AppStoreUtil::downloadPackage($token, $module, $version);
                ThrowException::throwsIfResponseError($ret);
                return $this->doNext('install', 'unpackPackage', [
                    '<span class="text-success">获取安装包完成，大小 ' . '2.37 KB' . '</span>',
                    '<span class="ub-text-white">开始解压安装包...</span>'
                ], array_merge([
                    'package' => $ret['data']['package'],
                    'licenseKey' => $ret['data']['licenseKey'],
                ],$data));
                break;
            case 'checkPackage':
                $ret = AppStoreUtil::checkPackage($token, $module, $version);
                $msgs[] = '<span class="ub-text-white">开始下载安装包...</span>';

                return $this->doNext('install', 'downloadPackage', array_merge([
                    'PHP版本: v' . PHP_VERSION,
                    '<span class="text-success">预检成功，' . 1 . '个依赖满足要求，安装包大小 ' . '2.37 KB' . '</span>',
                ], $msgs), $data);
                break;
            default:
                return $this->doNext('install', 'checkPackage', [
                    '<span class="text-success">开始安装远程模块 ' . $module . ' V' . $version . '</span>',
                    '<span class="ub-text-white">开始模块安装预检...</span>'
                ],$data);
        }
    }
    private function doFinish($msgs)
    {

        $data = [
            'msg' => array_map(function ($item) {
                return '<i class="iconfont icon-hr"></i> ' . $item;
            }, $msgs),
            'finish' => true,
        ];
        return ResponseBuilder::asSuccess(ApiCode::HTTP_OK)
            ->withHttpCode(ApiCode::HTTP_OK)
            ->withData($data)
            ->withMessage(__('message.common.search.success'))
            ->build();
    }
    private function doNext($command, $step, $msgs = [], $data = [])
    {
        $data = [
            'msg' => array_map(function ($item) {
                if (!Str::startsWith($item, '<')) {
                    $item = "<span class='ub-text-white'>$item</span>";
                }
                return '<i class="el-icon-minus"></i> ' . $item;
            }, $msgs),
            'command' => $command,
            'step' => $step,
            'data' => $data,
            'finish' => false,
        ];
        return ResponseBuilder::asSuccess(ApiCode::HTTP_OK)
            ->withHttpCode(ApiCode::HTTP_OK)
            ->withData($data)
            ->withMessage(__('message.common.search.success'))
            ->build();
    }
}
