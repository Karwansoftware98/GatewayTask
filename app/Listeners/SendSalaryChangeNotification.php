<?php

namespace App\Listeners;

use App\Events\EmployeeSalaryChanged;
use App\Mail\SalaryChangedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
    class SendSalaryChangeNotification implements ShouldQueue
    {
        use InteractsWithQueue;

        public function handle(EmployeeSalaryChanged $event)
        {
            $employee = $event->employee;
            $oldSalary = $event->oldSalary;
            $newSalary = $event->newSalary;

            Mail::to($employee->email)
                ->send(new SalaryChangedNotification($employee, $oldSalary, $newSalary));
        }
    }

