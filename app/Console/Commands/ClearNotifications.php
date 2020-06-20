<?php

namespace App\Console\Commands;

use App\Notification;
use Illuminate\Console\Command;

class ClearNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notifications:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clearing all notifications';

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
        try {
            Notification::truncate();
            $this->info('Operation finished successfully');
        } catch (\Exception $error) {
            $this->error('Something went wrong:'. $error->getMessage());
        }
    }
}
