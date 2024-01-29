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
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AllowanceController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\BankBranchController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\WardController;
use App\Http\Controllers\ShiftController;



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


Route::group(['namespace' => 'web'], function () {

    // Route::controller(LoginController::class)->group(function () {
        /*
     * These routes require the user to be logged in
     */
        // Route::group(['middleware' => 'auth'], function () {
        //     Route::get('logout', 'logout')->name('logout');
        // });

        /*
            * These routes require no user to be logged in
            */
        Route::group(['middleware' => 'guest'], function () {
            // Authentication Routes
            Route::get('/', [LoginController::class,'showLoginForm']);
            Route::post('/login', [LoginController::class,'authenticate']);
            // Route::get('/testmail', 'testMail');
        });
    // });
});

Route::prefix('users')->group(function (){
        Route::post('/add_user', [UserController::class, 'store'])->middleware('api');
        Route::get('/edit_user/{id}',[UserController::class, 'edit'])->middleware('api');
        Route::put('update_user/{id}',[UserController::class,'update'])->middleware('api');
        Route::delete('delete_user/{id}', [UserController::class, 'destroy'])->middleware('api');
        Route::get('/admin_panel', [UserController::class, 'admin'])->middleware('api');
        Route::get('/get_users', [UserController::class, 'getUsers'])->middleware('api');
});
// api for department
Route::prefix('departments')->group(function () {
        Route::get('show_department', [DepartmentController::class, 'department'])->middleware('api');
        Route::get('home_department', [DepartmentController::class, 'getDepartment'])->middleware('api');
        Route::post('/add_department',[DepartmentController::class, 'store'])->middleware('api');
        Route::get('/edit_department/{id}', [DepartmentController::class,'edit'])->middleware('api');
        Route::put('/update_department/{id}',[DepartmentController::class, 'update'])->middleware('api');
        Route::delete('delete_department/{id}',[DepartmentController::class, 'destroy'])->middleware('api');

});
// api for unit or section
Route::prefix('sections')->group(function () {
        Route::get('show_section', [UnitController::class, 'unit'])->middleware('api');
        Route::get('home_section', [UnitController::class, 'getUnit'])->middleware('api');
        Route::post('/add_section',[UnitController::class, 'store'])->middleware('api');
        Route::get('/edit_section/{id}', [UnitController::class,'edit'])->middleware('api');
        Route::put('/update_section/{id}',[UnitController::class, 'update'])->middleware('api');
        Route::delete('delete_section/{id}',[UnitController::class, 'destroy'])->middleware('api');

});
// api for designation
Route::prefix('designations')->group(function () {
        Route::get('show_designation', [DesignationController::class, 'designation'])->middleware('api');
        Route::get('home_designation', [DesignationController::class, 'getDesignation'])->middleware('api');
        Route::post('/add_designation',[DesignationController::class, 'store'])->middleware('api');
        Route::get('/edit_designation/{id}', [DesignationController::class,'edit'])->middleware('api');
        Route::put('/update_designation/{id}',[DesignationController::class, 'update'])->middleware('api');
        Route::delete('delete_designation/{id}',[DesignationController::class, 'destroy'])->middleware('api');

});
// api for Regions
Route::prefix('regions')->group(function () {
        Route::get('show_region', [RegionController::class, 'region'])->middleware('api');
        Route::get('home_region', [RegionController::class, 'getRegions'])->middleware('api');
});
// api for district
Route::prefix('districts')->group(function () {
        Route::get('show_district', [DistrictController::class, 'district'])->middleware('api');
        Route::get('home_district', [DistrictController::class, 'getDistrict'])->middleware('api');
    });

// api for Employer
Route::prefix('employers')->group(function () {
        Route::get('show_employer', [EmployerController::class, 'employer'])->middleware('api');
        Route::get('home_employer', [EmployerController::class, 'getEmployer'])->middleware('api');
        Route::post('/add_employer',[EmployerController::class, 'store'])->middleware('api');
        Route::get('/edit_employer/{id}', [EmployerController::class,'edit'])->middleware('api');
        Route::put('/update_employer/{id}',[EmployerController::class, 'update'])->middleware('api');
        Route::delete('/delete_employer/{id}',[EmployerController::class, 'destroy'])->middleware('api');

});

//api for banks
Route::prefix('banks')->group(function () {
        Route::get('show_bank', [BankController::class, 'getBank'])->middleware('api');
});

//api for bank branches
Route::prefix('branches')->group(function () {
        Route::get('show_bank_branch', [BankBranchController::class, 'bankBranch'])->middleware('api');
});

// api for Locations type
Route::prefix('locations')->group(function () {
        Route::get('show_location', [LocationController::class, 'locationType'])->middleware('api');
});

//api for Wards and postcodes
Route::prefix('wards')->group(function () {
        Route::get('show_ward', [WardController::class, 'getWard'])->middleware('api');
});

// api for Allowances
Route::prefix('allowances')->group(function () {
        Route::get('show_allowance', [AllowanceController::class, 'getAllowance'])->middleware('api');
});

//api for Shifts
Route::prefix('shifts')->group(function () {
        Route::get('show_shift', [ShiftController::class, 'getShift'])->middleware('api');
});

