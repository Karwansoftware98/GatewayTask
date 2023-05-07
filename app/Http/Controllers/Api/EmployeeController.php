<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\ImportEmployee;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Bus;
use League\Csv\Writer;

class EmployeeController extends Controller
{
    public function allEmployee()
    {
        return response()->json([
            Employee::all()
        ]);
    }

    public function storeEmployee(Request $request)
    {
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

    public function delete($id)
    {
        Employee::find($id)->delete();

        return response()->json([
            'employee deleted'
        ]);
    }
    public function findEmployeeManagers($id)
    {
        $e = Employee::find($id);
        $c = $e->allManagers();
        return response()->json([
            $c
        ]);
    }
    public function findEmployee($id)
    {

        return response()->json([
            Employee::find($id)
        ]);
    }
    public function exportEmployee()
    {
        // return Excel::download(new EmployeeExport,'employeelist.csv');
    }
    public function export()
    {
        $employees = Employee::all();

        $header = ['ID', 'Name', 'Salary', 'Gender'];

        $writer = Writer::createFromString('');

        $writer->insertOne($header);

        foreach ($employees as $employee) {
            $writer->insertOne([$employee->id, $employee->name, $employee->email, $employee->phone]);
        }

        $filename = 'employees.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        return response($writer->toString(), 200, $headers);
    }
    public function managersSalary($id)
    {

        $e = Employee::find($id);
        $c = $e->allManagersalary();
        return response()->json([
            $c
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

    public function search(Request $request)
    {
        $query = $request->input('q');
        if (!$query) {
            return response()->json(['error' => 'Query parameter missing or empty'], 400);
        }
        $employees = Employee::where('name', 'like', "%$query%")->get();
        return response()->json($employees);
    }
    public function removeLog()
    {
        Artisan::command('logs:clear', function () {
            array_map('unlink', array_filter((array) glob(storage_path('logs/*.log'))));
            $this->comment('Logs have been cleared!');
        })->describe('Clear log files');
    }
}
