<?php

namespace Modules\Culinary\Console\Commands;

use Illuminate\Console\Command;

class CulinaryCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:CulinaryCommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Culinary Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        return Command::SUCCESS;
    }
}
