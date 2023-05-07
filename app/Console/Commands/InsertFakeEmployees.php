<?php

namespace App\Console\Commands;
use Carbon\Carbon;
use App\Models\Employee;
use Illuminate\Console\Command;
use Faker\Factory as FakerFactory;
class InsertFakeEmployees extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'insert:fake-employees';


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
        $faker = FakerFactory::create();

        $employees = [];
        // $manager = Employee::find(1);
        for ($i = 0; $i < 1000; $i++) {
            $name = $faker->name;
            $age = $faker->numberBetween(18, 65);
            $hiredDate = $faker->dateTimeThisDecade();
            $jobTitle = $faker->jobTitle;
            $salary = $faker->numberBetween(30000, 100000);
            $managerId = $faker->numberBetween(1);
            $genderId = $faker->numberBetween(1, 2);

            $employees[] = [
                'name' => $name,
                'age' => $age,
                'hired_date' => $hiredDate,
                'job_title' => $jobTitle,
                'salary' => $salary,
                'manager_id' => 1,
                'gender_id' => $genderId,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];

            if (($i + 1) % 100 === 0) {
                Employee::insert($employees);
                $employees = [];
            }
        }

        if (count($employees) > 0) {
            Employee::insert($employees);
        }

        $this->info('1000 employees inserted successfully.');}
}
