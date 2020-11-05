<?php

namespace App\Jobs;

use App\Models\FloatValue;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use \Illuminate\Queue\Middleware\WithoutOverlapping;

class JobA implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $path = null;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($path)
    {
        $this->path = $path;
    }
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $disk = Storage::disk('csv');


        if ($disk->exists($this->path)) {
            $files = $disk->files($this->path);

            foreach ($files as $csv) {
                dispatch((new JobB($csv))->onQueue('csv'));
                //JobB::dispatch($csv);
            }
        }
    }

}
