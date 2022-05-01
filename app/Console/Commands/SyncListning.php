<?php

namespace App\Console\Commands;

use App\Http\Controllers\UserController;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;

class SyncListning extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:listning';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync Listning from Spotify';

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
        // $sync = new UserController();
        // $sync->apiSpotify();
        \Log::info("Cron is working fine!");
    }
}
