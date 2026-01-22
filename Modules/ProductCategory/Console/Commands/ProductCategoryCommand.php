<?php

namespace Modules\ProductCategory\Console\Commands;

use Illuminate\Console\Command;

class ProductCategoryCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:ProductCategoryCommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'ProductCategory Command description';

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
