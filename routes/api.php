<?php

use App\Http\Controllers\Api\EmployeeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/employee/{id}',[EmployeeController::class, 'findEmployee']);
Route::get('/employees',[EmployeeController::class, 'allEmployee']);
Route::post('/store/employee',[EmployeeController::class, 'storeEmployee']);
Route::post('/delete/{id}/employee',[EmployeeController::class, 'deleteEmployee']);

Route::get('/employees/{id}/managers',[EmployeeController::class, 'findEmployeeManagers']);
Route::get('/employees/{id}/managers-salary',[EmployeeController::class, 'managersSalary']);
Route::post('/employees/import', [EmployeeController::class, 'importEmployee']);
Route::get('/exportemployee',[EmployeeController::class,'exportEmployee']);
Route::get('search/{name}',[EmployeeController::class,'search']);
Route::get('/removelogfile',[EmployeeController::class,'removeLog']);

