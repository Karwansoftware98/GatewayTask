<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\EmployeeController;
use App\Models\Employee;
use App\Models\User;
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
Route::post('/auth/register', [AuthController::class, 'createUser']);
Route::post('/auth/login', [AuthController::class, 'loginUser']);
Route::get('/employees/search',[EmployeeController::class,'search']);


Route::get('/employees/{id}/managers',[EmployeeController::class, 'findEmployeeManagers']);
Route::get('/employees/{id}/managers-salary',[EmployeeController::class, 'managersSalary']);
Route::post('/employees/import', [EmployeeController::class, 'importEmployee']);
Route::get('/employees/export',[EmployeeController::class,'export']);
Route::get('/employees/{id}',[EmployeeController::class, 'findEmployee']);
Route::get('/employees',[EmployeeController::class, 'allEmployee']);

Route::post('/store/employee',[EmployeeController::class, 'storeEmployee']);
Route::post('/delete/{id}/employee',[EmployeeController::class, 'delete']);

Route::get('/exportemployee',[EmployeeController::class,'exportEmployee']);



Route::get('/user/{name?}', function (string $name = "john"){
    return $name;
});


Route::get('/removelogfile',[EmployeeController::class,'removeLog']);
