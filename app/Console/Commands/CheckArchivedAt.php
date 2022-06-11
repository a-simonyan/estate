<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Property;
use Carbon\Carbon;

class CheckArchivedAt extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'archived:at';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check if the archived at year 90 days ago';

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
        $date = Carbon::now()->subYear()->format('Y-m-d');
        Property::whereNull('deleted_at')
                ->whereNotNull('archived_at')
                ->whereDate('archived_at', '<', $date)
                ->update(['deleted_at' => Carbon::now()]);
    }
}
