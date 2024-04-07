<?php


namespace Zealov\Command;

use Illuminate\Console\Command;

class AssertPublishCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'zealov:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run the commands necessary to prepare Zealov for use';

    /**
     * Execute the console command.
     *
     * @author moell<moel91@foxmail.com>
     * @return mixed
     */
    public function handle(){
        $this->call('vendor:publish', ['--provider' => 'Zealov\ZealovServiceProvider']);
    }
}
