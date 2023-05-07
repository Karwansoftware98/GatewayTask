<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
class ExportDatabaseCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:export {--file= : The name of the export file.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export the Laravel database to a SQL file using mysqldump.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        // Get the name of the export file from the command line argument
        $filename = $this->option('file');

        // If no filename was specified, use a default value
        if (!$filename) {
            $filename = 'export_' . date('Y-m-d_H-i-s') . '.sql';
        }

        // Get the database configuration from the Laravel config file
        $database = Config::get('database.connections.mysql.database');
        $username = Config::get('database.connections.mysql.username');
        $password = Config::get('database.connections.mysql.password');

        // Set the path to the export file
        $path = storage_path('app/exports/' . $filename);

        // Build the mysqldump command
        $command = sprintf(
            'mysqldump -u%s -p%s %s > %s',
            escapeshellarg($username),
            escapeshellarg($password),
            escapeshellarg($database),
            escapeshellarg($path)
        );

        // Execute the mysqldump command
        exec($command);

        // Store the export file in the Laravel storage directory
        Storage::disk('local')->put('exports/' . $filename, file_get_contents($path));

        // Display a success message to the user
        $this->info(sprintf('The database has been exported to %s.', $filename));
    }
}
