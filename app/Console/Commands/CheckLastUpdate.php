<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Property;
use Carbon\Carbon;

class CheckLastUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'last:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check if the Last Update passed 90 days ago';

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
        $date = Carbon::now()->subDays(90)->format('Y-m-d');
        Property::whereNull('deleted_at')
                ->whereNotNull('last_update')
                ->whereNull('archived_at')
                ->whereNull('saved_at')
                ->whereDate('last_update', '<', $date)
                ->update(['archived_at' => Carbon::now()]);
    }
}
