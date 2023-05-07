<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\Gender;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $gender = Gender::create([
            'name' => 'Male'
        ]);
        $gender1 = Gender::create([
            'name' => 'Female'
        ]);
      $employee =   Employee::create([
            'name' => 'Ali',
            'manager_id' => null,
            'gender_id' => $gender->id,
            'salary' => 2000,
            'job_title' => 'Founder',
            'hired_date' => Carbon::parse('2019-01-01'),
            'age' => 35

        ]);
       $employee1 =  Employee::create([
            'name' => 'Asaad',
            'manager_id' => $employee->id,
            'gender_id' => $gender->id,
            'salary' => 1500,
            'job_title' => 'Founder',
            'hired_date' => Carbon::parse('2019-01-01'),

            'age' => 35

        ]);
      $employee2 =  Employee::create([
            'name' => 'Ismail',
            'manager_id' => $employee1->id,
            'gender_id' => $gender->id,
            'salary' => $gender->id,
            'job_title' => 'Founder',
            'hired_date' => Carbon::parse('2019-01-01'),

            'age' => 35

        ]);
        Employee::create([
            'name' => 'Ahmad',
            'manager_id' => $employee2->id,
            'gender_id' => $gender->id,
            'salary' => $gender->id,
            'job_title' => 'Founder',
            'hired_date' => Carbon::parse('2019-01-01'),

            'age' => 35

        ]);

    }
}
