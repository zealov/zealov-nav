<?php

namespace Zealov\Command;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Event;
use Zealov\Exception\ThrowException;
use Zealov\ModuleManage;

class ModuleInstallCommand extends Command
{
    protected $signature = 'zealov:module-install {module} {--force}';

    public function handle()
    {
        $module = $this->argument('module');
        ThrowException::throwsIf('Module Invalid', !ModuleManage::isExists($module));
        $installeds = ModuleManage::listAllInstalledModules();

        $output = null;

        $this->publishAsset($module);

        if (!isset($installeds[$module])) {
            $installeds[$module] = [
                'isSystem' =>false,
                'enable' => false,
                'config' => []
            ];
            //存储模块
            ModuleManage::saveUserInstalledModules($installeds);
        }

        $this->info('Module Install Success');
    }





    private function publishAsset($module)
    {
        $force = $this->option('force');
        $fs = $this->laravel['files'];
        $from = ModuleManage::path($module, 'public') . '/'.$module;
        if (!file_exists($from)) {
            return;
        }
        $to = public_path("module/$module/");
        if (file_exists($to) && !$force) {
            $this->info("Module Asset Publish : Ignore");
            return;
        }
        $fs->deleteDirectory($to);
        $fs->copyDirectory($from, $to);
        $this->info("Module Asset Publish : $from -> $to");
    }

}
