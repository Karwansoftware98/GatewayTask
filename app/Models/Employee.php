<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
  
        public function gender(){
            return $this->belongsTo(Gender::class);
        }


     public function manager()
     {
         return $this->belongsTo(Employee::class, 'manager_id');
     }

     public function  allManagers()
     {
         $managers = collect();
         $employee = $this;

         while ($employee->manager) {
             $managers->push(['name'=>$employee->manager->name ]);
             $employee = $employee->manager;
         }

         return $managers->pluck('name')->reverse()->values();
     }
     public function  allManagersalary()
     {
         $managers = collect();
         $employee = $this;

         while ($employee->manager) {
             $managers->push(['name'=>$employee->manager->name, 'salary'=> (int)($employee->manager->salary).'$']);
             $employee = $employee->manager;
         }

         return $managers->reverse()->values();
     }
}
