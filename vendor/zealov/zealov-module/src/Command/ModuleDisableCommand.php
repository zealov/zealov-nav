<?php

namespace Zealov\Command;

use Illuminate\Console\Command;
use Zealov\Exception\ThrowException;
use Zealov\ModuleManage;

class ModuleDisableCommand extends Command
{
    protected $signature = 'zealov:module-disable {module}';

    public function handle()
    {
        $module = $this->argument('module');
        ThrowException::throwsIf('Module Invalid', !ModuleManage::isExists($module));
        $installeds = ModuleManage::listAllInstalledModules();

        $installeds[$module]['enable'] = false;
        ModuleManage::saveUserInstalledModules($installeds);

        $this->info('Module Enable Success');
    }

}
