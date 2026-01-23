<?php

namespace Modules\UMKM\Console\Commands;

use Illuminate\Console\Command;

class UMKMCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:UMKMCommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'UMKM Command description';

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
