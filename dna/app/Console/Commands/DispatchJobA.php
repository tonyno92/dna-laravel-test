<?php

namespace App\Console\Commands;

use App\Jobs\JobA;
use Illuminate\Console\Command;
use Illuminate\Queue\Jobs\Job;
use Illuminate\Support\Facades\Storage;

class DispatchJobA extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'csv:start {path=pairs}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start consuming csv file';

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
        JobA::dispatch($this->argument('path'));
    }
}
