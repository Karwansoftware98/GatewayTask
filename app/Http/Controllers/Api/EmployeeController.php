<?php

namespace App\Http\Controllers\Api;

use App\Exports\EmployeeExport;
use App\Http\Controllers\Controller;
use App\Jobs\ImportEmployee;
use App\Models\Employee;
use Illuminate\Http\Request;
use Excel;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Bus;

class EmployeeController extends Controller
{

public function allEmployee(){
    return response()->json([
        Employee::all()
    ]);
}

    public function storeEmployee(Request $request){
        $request->validate([
            'name' => 'required|string',
            'age' => 'required|integer',
            'gender' => 'required',
            'salary' => 'required|decimal',
            'hired_date' => 'required|date',
            'job_title' => 'required',
            'manager_id' => 'integer'
        ]);


            return response()->json(Employee::create($request));
    }

    public function delete($id){
        Employee::find($id)->delete();

        return response()->json([
            'employee deleted'
        ]);

    }
    public function findEmployeeManagers($id){

        return response()->json([
            Employee::with('parent.parent.parent')->find($id)
        ]);
    }
    public function findEmployee($id){

        return response()->json([
            Employee::find($id)
        ]);
    }
    public function exportEmployee (){
        return Excel::download(new EmployeeExport,'employeelist.csv');
    }

    public function managersSalary ($id){

        return response()->json([
            Employee::with('parent.parent.parent')->find($id)->get(['name','salary'])
        ]);
    }

    public function importEmployee()
    {
        if (request()->has('mycsv')) {
            $data   =   file(request()->mycsv);

            $chunks = array_chunk($data, 100);

            $header = [];
            $batch  = Bus::batch([])->dispatch();

            foreach ($chunks as $key => $chunk) {
                $data = array_map('str_getcsv', $chunk);

                if ($key === 0) {
                    $header = $data[0];
                    unset($data[0]);
                }

                $batch->add(new ImportEmployee($data, $header));
            }

            return $batch;
        }

        return response()->json('please upload a file');
    }

    public function search($search){
        return response()->json(Employee::where('name', 'LIKE', '%'.$search . '%')->get());
    }
    public function removeLog(){
        Artisan::command('logs:clear', function() {
            array_map('unlink', array_filter((array) glob(storage_path('logs/*.log'))));
            $this->comment('Logs have been cleared!');
         })->describe('Clear log files');
    }
}
