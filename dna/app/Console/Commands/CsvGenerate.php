<?php

namespace App\Console\Commands;

use App\Jobs\JobA;
use App\Models\FloatValue;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use \Carbon\Carbon;
use Illuminate\Support\Str;

class CsvGenerate extends Command
{
    private const MIN = 1;
    private const MAX = 100;

    private $columns = array('value1', 'value2');

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'csv:generate {path=pairs}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate from 1 to 100 CSV files and for each one from 1 to 100 pair of value 1 and value 2';

    private $faker;
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->faker = \Faker\Factory::create();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $rPath = $this->argument('path');
        $disk = Storage::disk('csv');

        if (!$disk->exists($rPath)) {
            $disk->makeDirectory($rPath);
        }

        $numsFile = rand(CsvGenerate::MIN, CsvGenerate::MAX);

        for ($i = CsvGenerate::MIN; $i <= $numsFile; $i++) {

            $filename = $rPath . DIRECTORY_SEPARATOR . Carbon::now()->timestamp . "-pair{$i}.csv";
            $path = $disk->path($filename);
            $numsPair = rand(CsvGenerate::MIN, CsvGenerate::MAX);

            $file = fopen($path, 'w');
            fputcsv($file, $this->columns);

            for ($j = 1; $j <= $numsPair; $j++) {
                fputcsv($file, array(
                    $this->faker->randomFloat(null, CsvGenerate::MIN, CsvGenerate::MAX),
                    $this->faker->randomFloat(null, CsvGenerate::MIN, CsvGenerate::MAX)
                ));
            }

            /*$pairs = FloatValue::factory()->count($numsPair)->make();

            foreach ($pairs as $pair) {
                fputcsv($file, array($pair->value1, $pair->value2));
            }*/

            fclose($file);
        }

        dispatch((new JobA($rPath))->onQueue('default'));
        //JobA::dispatch($rPath)->onQueue('writer');

        return 0;
    }
}
