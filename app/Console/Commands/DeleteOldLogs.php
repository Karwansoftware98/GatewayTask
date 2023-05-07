<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class DeleteOldLogs extends Command
{
    protected $signature = 'logs:delete';
    protected $description = 'Deletes logs older than one month';

    public function handle()
    {
        $cutoff = Carbon::now()->subMonth();
        $files = Storage::files('logs');

        foreach ($files as $file) {
            if (Storage::lastModified($file) < $cutoff) {
                Storage::delete($file);
            }
        }
    }
}
