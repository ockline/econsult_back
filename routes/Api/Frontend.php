<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\DistrictController;




Route::group(['namespace' => 'Auth'], function () {

    Route::controller(LoginController::class)->group(function () {
        /*
     * These routes require the user to be logged in
     */
        Route::group(['middleware' => 'auth'], function () {
            Route::get('logout', 'logout')->name('logout');
        });

        /*
            * These routes require no user to be logged in
            */
        Route::group(['middleware' => 'guest'], function () {
            // Authentication Routes
            Route::get('/', 'showLoginForm')->name('login');
            Route::post('/login', 'attemptLogin');
            Route::get('/testmail', 'testMail');
        });
    });
});

// Route::prefix('users')->group(function (){
//     Route::get('/edit_user/{id}', [UserController::class, 'edit'])->middleware('Api');
//     // Other routes...
// });



Route::prefix('users')->group(function (){
        Route::post('/add_user', [UserController::class, 'store'])->middleware('api');
        Route::get('/edit_user/{id}',[UserController::class, 'edit'])->middleware('Api');
        Route::put('update_user/{id}',[UserController::class,'update'])->middleware('Api');
        Route::delete('delete_user/{id}', [UserController::class, 'destroy'])->middleware('Api');
        Route::get('/admin_panel', [UserController::class, 'admin'])->middleware('Api');
        Route::get('/get_users', [UserController::class, 'getUsers'])->middleware('Api');
});
// api for department
Route::prefix('departments')->group(function () {
        Route::get('show_department', [DepartmentController::class, 'department'])->middleware('Api');
        Route::get('home_department', [DepartmentController::class, 'getDepartment'])->middleware('Api');
        Route::post('/add_department',[DepartmentController::class, 'store'])->middleware('Api');
        Route::get('/edit_department/{id}', [DepartmentController::class,'edit'])->middleware('Api');
        Route::put('/update_department/{id}',[DepartmentController::class, 'update'])->middleware('Api');
        Route::delete('delete_department/{id}',[DepartmentController::class, 'destroy'])->middleware('Api');

});
// api for unit or section
Route::prefix('sections')->group(function () {
        Route::get('show_section', [UnitController::class, 'unit'])->middleware('Api');
        Route::get('home_section', [UnitController::class, 'getUnit'])->middleware('Api');
        Route::post('/add_section',[UnitController::class, 'store'])->middleware('Api');
        Route::get('/edit_section/{id}', [UnitController::class,'edit'])->middleware('Api');
        Route::put('/update_section/{id}',[UnitController::class, 'update'])->middleware('Api');
        Route::delete('delete_section/{id}',[UnitController::class, 'destroy'])->middleware('Api');

});
// api for designation
Route::prefix('designations')->group(function () {
        Route::get('show_designation', [DesignationController::class, 'designation'])->middleware('Api');
        Route::get('home_designation', [DesignationController::class, 'getDesignation'])->middleware('Api');
        Route::post('/add_designation',[DesignationController::class, 'store'])->middleware('Api');
        Route::get('/edit_designation/{id}', [DesignationController::class,'edit'])->middleware('Api');
        Route::put('/update_designation/{id}',[DesignationController::class, 'update'])->middleware('Api');
        Route::delete('delete_designation/{id}',[DesignationController::class, 'destroy'])->middleware('Api');

});
// api for Regions
Route::prefix('regions')->group(function () {
        Route::get('show_region', [RegionController::class, 'region'])->middleware('Api');
        Route::get('home_region', [RegionController::class, 'getRegions'])->middleware('Api');
});
// api for district
Route::prefix('districts')->group(function () {
        Route::get('show_district', [DistrictController::class, 'district'])->middleware('Api');
        Route::get('home_district', [DistrictController::class, 'getDistrict'])->middleware('Api');
    });






/**
 * Frontend Access Controllers
 * All route names are prefixed with 'frontend.auth'.
 */
Route::group(['as' => 'frontend.'], function () {


});
