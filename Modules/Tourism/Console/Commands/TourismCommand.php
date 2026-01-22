<?php

namespace Modules\Tourism\Console\Commands;

use Illuminate\Console\Command;

class TourismCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:TourismCommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Tourism Command description';

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
