<?php

namespace App\Console\Commands;

use App\Consultations;
use Illuminate\Console\Command;

class HourlyUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hour:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Handle Consultations';

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
     * @return mixed
     */
    public function handle()
    {
        //
        $check = Consultations::where('completed',null)->get();
        foreach ($check as $key) {
            # code...
            $diff = (strtotime(now()) - strtotime($key['created_at']))/60;
            if($diff > 15)
            {
                $key->update(['completed'=>1]);
            }
        }
    }
}
