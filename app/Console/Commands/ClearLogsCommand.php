<?php

namespace App\Console\Commands;

use Illuminate\Support\Facades\File;
use Illuminate\Console\Command;

class ClearLogsCommand extends Command
{
  /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'logs:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear all Laravel log files.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $path = storage_path('logs');

        $files = glob($path . '/*.log');

        foreach ($files as $file) {
            File::delete($file);
        }

        $this->info('All log files have been deleted.');

        return 0;
    }
}
