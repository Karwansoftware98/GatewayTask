<?php

namespace App\Exports;

use App\Models\Employee;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class EmployeeExport implements FromCollection,WithHeadings
{
    public function headings():array{
        return [
            'Id',
            'Name',
            'Age',
            'Salary',
            'Gender',
            'Hired Date',
            'Job Title',
            'Managers'
            ];
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return collect(Employee::get(['id','name','age','salary','gender','hired_date','job_title','manager_id']));
    }
}
