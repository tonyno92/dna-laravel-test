<?php

namespace App\Jobs;

use App\Models\FloatValue;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class JobB implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $path;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($csvPath)
    {
        $this->path = $csvPath;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        
        $fullPath = Storage::disk('csv')->path($this->path);
        //$fullPath = storage_path('csv'). DIRECTORY_SEPARATOR. $this->path;

        $pairs = array_map('str_getcsv', file($fullPath));

        array_walk($pairs, function (&$val) use ($pairs) {
            $val = array_combine($pairs[0], $val);
        });
        array_shift($pairs);

        FloatValue::factory()->createMany($pairs);
        
        Storage::disk('csv')->delete($this->path);
    }
}
