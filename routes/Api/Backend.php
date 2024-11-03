<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Leave\AnnualController;
use App\Http\Controllers\Employer\EmployerController;
// api for Employer


Route::prefix('employers')->group(function () {
        Route::get('show_employer', [EmployerController::class, 'employer'])->middleware('Api');
        Route::get('home_employer', [EmployerController::class, 'getEmployer'])->middleware('Api');
        Route::post('/add_employer',[EmployerController::class, 'store'])->middleware('Api');
        Route::get('/edit_employer/{id}', [EmployerController::class,'edit'])->middleware('Api');
        Route::put('/update_employer/{id}',[EmployerController::class, 'update'])->middleware('Api');
        Route::delete('delete_employer/{id}',[EmployerController::class, 'destroy'])->middleware('Api');

});

Route::prefix('leaves')->group(function (){
    Route::get('/retrieve_employee_detail/{id}', [AnnualController::class, 'getEmployee']);
    Route::post('/create_annual_leave', [AnnualController::class, 'createAnnualLeave']);
Route::get('/retrieve_annual_leave', [AnnualController::class, 'retrieveAnnualLeaveDetails']);
});
