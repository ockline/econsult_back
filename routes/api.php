<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\DistrictController;
use App\Http\Controllers\Employer\EmployerController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::prefix('users')->group(function (){

        Route::post('/login',[UserController::class, 'login']);
        Route::post('/add_user', [UserController::class, 'store']);
        Route::get('/edit_user/{id}',[UserController::class, 'edit']);
        Route::put('update_user/{id}',[UserController::class,'update']);
        Route::delete('delete_user/{id}', [UserController::class, 'destroy']);
        Route::get('/admin_panel', [UserController::class, 'admin']);
        Route::get('/get_users', [UserController::class, 'getUsers']);
});
// api for department
Route::prefix('departments')->group(function () {
        Route::get('show_department', [DepartmentController::class, 'department']);
        Route::get('home_department', [DepartmentController::class, 'getDepartment']);
        Route::post('/add_department',[DepartmentController::class, 'store']);
        Route::get('/edit_department/{id}', [DepartmentController::class,'edit']);
        Route::put('/update_department/{id}',[DepartmentController::class, 'update']);
        Route::delete('delete_department/{id}',[DepartmentController::class, 'destroy']);

});
// api for unit or section
Route::prefix('sections')->group(function () {
        Route::get('show_section', [UnitController::class, 'unit']);
        Route::get('home_section', [UnitController::class, 'getUnit']);
        Route::post('/add_section',[UnitController::class, 'store']);
        Route::get('/edit_section/{id}', [UnitController::class,'edit']);
        Route::put('/update_section/{id}',[UnitController::class, 'update']);
        Route::delete('delete_section/{id}',[UnitController::class, 'destroy']);

});
// api for designation
Route::prefix('designations')->group(function () {
        Route::get('show_designation', [DesignationController::class, 'designation']);
        Route::get('home_designation', [DesignationController::class, 'getDesignation']);
        Route::post('/add_designation',[DesignationController::class, 'store']);
        Route::get('/edit_designation/{id}', [DesignationController::class,'edit']);
        Route::put('/update_designation/{id}',[DesignationController::class, 'update']);
        Route::delete('delete_designation/{id}',[DesignationController::class, 'destroy']);

});
// api for Regions
Route::prefix('regions')->group(function () {
        Route::get('show_region', [RegionController::class, 'region']);
        Route::get('home_region', [RegionController::class, 'getRegions']);
});
// api for district
Route::prefix('districts')->group(function () {
        Route::get('show_district', [DistrictController::class, 'district']);
        Route::get('home_district', [DistrictController::class, 'getDistrict']);
    });

// api for Employer
Route::prefix('employers')->group(function () {
        Route::get('show_employer', [EmployerController::class, 'employer']);
        Route::get('home_employer', [EmployerController::class, 'getEmployer']);
        Route::post('/add_employer',[EmployerController::class, 'store']);
        Route::get('/edit_employer/{id}', [EmployerController::class,'edit']);
        Route::put('/update_employer/{id}',[EmployerController::class, 'update']);
        Route::delete('delete_employer/{id}',[EmployerController::class, 'destroy']);

});
