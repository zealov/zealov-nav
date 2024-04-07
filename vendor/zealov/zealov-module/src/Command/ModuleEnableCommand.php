<?php

namespace Zealov\Command;

use Illuminate\Console\Command;
use Zealov\Exception\ThrowException;
use Zealov\ModuleManage;

class ModuleEnableCommand extends Command
{
    protected $signature = 'zealov:module-enable {module}';

    public function handle()
    {
        $module = $this->argument('module');
        ThrowException::throwsIf('Module Invalid', !ModuleManage::isExists($module));
        $installeds = ModuleManage::listAllInstalledModules();

        $installeds[$module]['enable'] = true;
        ModuleManage::saveUserInstalledModules($installeds);

        $this->info('Module Enable Success');
    }

}
