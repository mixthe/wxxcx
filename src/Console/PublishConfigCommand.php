<?php

namespace Mixthe\Wxxcx\Console;

use Illuminate\Console\Command;
use Mixthe\Wxxcx\Console\Helpers\Publisher;

class PublishConfigCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'wxxcx:publish-config';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '微信小程序 config';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->info('Publish wxxcx config files success');

        (new Publisher($this))->publishFile(
            realpath(__DIR__.'/../../config/').'/config.php',
            base_path('config'),
            'wxxcx.php'
        );
    }
}
