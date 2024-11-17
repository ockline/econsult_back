<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Leave\SickController;
use App\Http\Controllers\Leave\AnnualController;
use App\Http\Controllers\Leave\MaternityController;
use App\Http\Controllers\Leave\PaternityController;
use App\Http\Controllers\Employer\EmployerController;
use App\Http\Controllers\Leave\CompassionateController;
use App\Http\Controllers\Attendance\AttendanceController;
// api for Employer

// Route::middleware(['auth'])->group(function () {

Route::prefix('employers')->group(function () {
    Route::get('show_employer', [EmployerController::class, 'employer'])->middleware('Api');
    Route::get('home_employer', [EmployerController::class, 'getEmployer'])->middleware('Api');
    Route::post('/add_employer', [EmployerController::class, 'store'])->middleware('Api');
    Route::get('/edit_employer/{id}', [EmployerController::class, 'edit'])->middleware('Api');
    Route::put('/update_employer/{id}', [EmployerController::class, 'update'])->middleware('Api');
    Route::delete('delete_employer/{id}', [EmployerController::class, 'destroy'])->middleware('Api');
});

Route::prefix('leaves')->group(function () {
    //annual
    Route::get('/retrieve_employee_detail/{id}', [AnnualController::class, 'getEmployee']);
    Route::post('/create_annual_leave', [AnnualController::class, 'createAnnualLeave']);
    Route::get('/retrieve_annual_leave', [AnnualController::class, 'retrieveAnnualLeaveDetails']);

 //sick
    Route::post('/create_sick_leave', [SickController::class, 'createSickLeave']);
    Route::get('/retrieve_sick_detail/{leaveId}', [SickController::class, 'getSickLeaveDetail']);
    Route::post('/update_sick_leave/{id}', [SickController::class, 'updateSickLeave']);
    Route::get('/retrieve_sick_leave', [SickController::class, 'retrieveSickLeaveDetails']);

 //partenity
    Route::post('/create_paternity_leave', [PaternityController::class, 'createPaternityLeave']);
    Route::post('/update_paternity_leave/{id}', [PaternityController::class, 'updatePaternityLeave']);
    Route::get('/retrieve_paternity_detail/{leaveId}', [PaternityController::class, 'getPaternityLeaveDetail']);
    Route::get('/retrieve_paternity_leave', [PaternityController::class, 'retrievePaternityLeaveDetails']);

 //Maternity
    Route::post('/create_maternity_leave', [MaternityController::class, 'createMaternityLeave']);
    Route::post('/update_maternity_leave/{id}', [MaternityController::class, 'updateMaternityLeave']);
    Route::get('/retrieve_maternity_leave', [MaternityController::class, 'retrieveMaternityLeaveDetails']);

//compassionate
    Route::post('/create_compassionate_leave', [CompassionateController::class, 'createCompassionateLeave']);
 Route::post('/update_compassionate_leave/{id}', [CompassionateController::class, 'updateCompassionateLeave']);
Route::get('/retrieve_compassionate_detail/{leaveId}', [CompassionateController::class,'getCompassionateDetail']);
    Route::get('/retrieve_compassionate_leave', [CompassionateController::class, 'retrieveCompassionateLeaveDetails']);
});


//Attendance and overtime  block
Route::prefix('attendances')->group(function () {
   Route::post('/create_attendance', [AttendanceController::class, 'createAttendanceRecord']);
Route::post('/create_overtime_upload', [AttendanceController::class, 'createOvertimeRecordUploaded']);
Route::post('/create_overtime_request', [AttendanceController::class, 'createOvertimeRecord']);
Route::get('/retrieve_monthly_attendance',[AttendanceController::class, 'getMonthlyAttendanceDetails']);
Route::get('/retrieve_monthly_overtime',[AttendanceController::class, 'retrieveAllOverTimeDetails']);
Route::get('/generate_monthly_attendance', [AttendanceController::class, 'generateMonthlyAttendance']);


});
