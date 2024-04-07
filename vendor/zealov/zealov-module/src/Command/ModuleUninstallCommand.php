<?php

namespace Zealov\Command;

use Illuminate\Console\Command;
use Zealov\Kernel\Utils\FileUtil;
use Zealov\ModuleManage;

class ModuleUninstallCommand extends Command
{
    protected $signature = 'zealov:module-uninstall {module}';

    public function handle()
    {
        $module = $this->argument('module');

        $installeds = ModuleManage::listAllInstalledModules();

        unset($installeds[$module]);
        $this->unPublishAsset($module);
        $this->unPublishRoot($module);

        ModuleManage::saveUserInstalledModules($installeds);
        $this->info('Module UnInstall Success');

    }

    private function unPublishAsset($module)
    {
        $fs = $this->laravel['files'];
        $from = ModuleManage::path($module, 'public') . '/'.$module;
        if (!file_exists($from)) {
            return;
        }
        $to = public_path("module/$module/");
        if (!file_exists($to)) {
            return;
        }
        $fs->deleteDirectory($to);
        $this->info("Module Asset UnPublish : $to");
    }

    private function unPublishRoot($module)
    {
        $root = ModuleManage::path($module, 'ROOT');
        if (!file_exists($root)) {
            return;
        }
        $files = FileUtil::listAllFiles($root);
        $files = array_filter($files, function ($file) {
            return $file['isFile'];
        });
        $publishFiles = 0;
        foreach ($files as $file) {
            $relativePath = $file['filename'];
            $relativePathBackup = $relativePath . '._delete_.' . $module;
            $currentFile = base_path($relativePath);
            $currentFileBackup = $currentFile . '._delete_.' . $module;
            if (!file_exists($currentFile)) {
                continue;
            }
            if (
                (!file_exists($currentFileBackup) && md5_file($currentFile) == md5_file($file['pathname']))
                ||
                (file_exists($currentFileBackup))
            ) {
                unlink($currentFile);
                if (file_exists($currentFileBackup)) {
                    $content = trim(file_get_contents($currentFileBackup));
                    if ('__MODSTART_EMPTY_FILE__' == $content) {
                        unlink($currentFileBackup);
                        $this->info("Module Root Publish : $relativePath");
                    } else {
                        rename($currentFileBackup, $currentFile);
                        $this->info("Module Root Publish : $relativePath <- $relativePathBackup");
                    }
                }
                $publishFiles++;
            }
        }
        $this->info("Module Root UnPublish : $publishFiles item(s)");
    }

}
