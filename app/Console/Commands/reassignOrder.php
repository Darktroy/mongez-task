<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class reassignOrder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reassign:order';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 're-send order after a while';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        return 0;
    }
}
