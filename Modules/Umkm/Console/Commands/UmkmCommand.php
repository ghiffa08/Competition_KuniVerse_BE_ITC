<?php

namespace Modules\Umkm\Console\Commands;

use Illuminate\Console\Command;

class UmkmCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:UmkmCommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Umkm Command description';

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
