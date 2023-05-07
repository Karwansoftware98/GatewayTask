<?php

namespace App\Console\Commands;

use App\Models\Employee;
use Illuminate\Console\Command;

class ExportEmployeesJson extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'export:employees:json';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $employees = Employee::all();

        $json = json_encode($employees, JSON_PRETTY_PRINT);

        file_put_contents(storage_path('app/exports/employees.json'), $json);

        $this->info('Employees exported to ' . storage_path('app/exports/employees.json'));
    }
}
