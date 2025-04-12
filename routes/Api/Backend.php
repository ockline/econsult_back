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
use App\Models\IndustrialRelationship\Misconduct\Misconduct;
use App\Http\Controllers\IndustrialRelationship\MisconductController;
use App\Http\Controllers\IndustrialRelationship\PerfomanceReviewController;
use App\Http\Controllers\IndustrialRelationship\PerfomanceCapacityController;
use App\Http\Controllers\IndustrialRelationship\PerformanceAssessmentController;

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
    Route::post('/update_annual_leave/{id}', [AnnualController::class, 'updateAnnualLeave']);
    Route::get('/retrieve_annual_leave', [AnnualController::class, 'retrieveAnnualLeaveDetails']);
    Route::get('/retrieve_emergency_leave', [AnnualController::class, 'getEmergencyLeave']);
    Route::post('/update_emergency_leave/{id}', [AnnualController::class, 'updateEmergencyLeave']);
    Route::get('/retrieve_annual_emergency_leave/{id}', [AnnualController::class, 'retrieveAnnualEmergencyLeave']);




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
    Route::get('/retrieve_compassionate_detail/{leaveId}', [CompassionateController::class, 'getCompassionateDetail']);
    Route::get('/retrieve_compassionate_leave', [CompassionateController::class, 'retrieveCompassionateLeaveDetails']);
});


//Attendance and overtime  block
Route::prefix('attendances')->group(function () {
    Route::post('/create_attendance', [AttendanceController::class, 'createAttendanceRecord']);
    Route::post('/update_attendance/{id}', [AttendanceController::class, 'updateAttendance']);
    Route::post('/create_overtime_upload', [AttendanceController::class, 'createOvertimeRecordUploaded']);
    Route::post('/create_overtime_request', [AttendanceController::class, 'createOvertimeRecord']);
    Route::get('/retrieve_attendance_detail/{id}', [AttendanceController::class, 'getAttendanceDetails']);
    Route::get('/retrieve_monthly_attendance', [AttendanceController::class, 'getMonthlyAttendanceDetails']);
    Route::get('/retrieve_monthly_overtime', [AttendanceController::class, 'retrieveAllOverTimeDetails']);
    Route::get('/generate_monthly_attendance', [AttendanceController::class, 'generateMonthlyAttendance']);
});


//Industrial Relationship

Route::prefix('industrial_relationship')->group(function () {
    Route::post('/create_misconduct', [MisconductController::class, 'createMisconduct']);
    Route::post('/update_misconduct/{id}', [MisconductController::class, 'updateMisconduct']);
    Route::get('/retrieve_misconduct_type', [MisconductController::class, 'getMisconductType']);
    Route::get('/retrieve_all_misconduct', [MisconductController::class, 'retrieveAllMisconduct']);
    Route::get('/show_misconduct/{id}', [MisconductController::class, 'retrieveMisconductDetails']);
    // Route::get('/generate_monthly_attendance', [MisconductController::class, 'generateMonthlyAttendance']);



    //Perfomance Review
    Route::get('/retrieve_perfomance_review', [PerfomanceReviewController::class, 'retrieveAllPerfomanceReview']);
    Route::post('/create_perfomance_review', [PerfomanceReviewController::class, 'createPerfomanceReview']);
    Route::post('/update_perfomance_review/{id}', [PerfomanceReviewController::class, 'updatePerfomanceReview']);
    Route::get('/retrieve_perfomance_criterials', [PerfomanceReviewController::class, 'getPerfomanceCriterial']);
    Route::get('/retrieve_employee_details/{id}', [PerfomanceReviewController::class, 'retrieveEmployeeDetail']);
    Route::get('show_perfomance_review/{id}', [PerfomanceReviewController::class, 'retrievePerfomaneReviewDetail']);
    Route::get('retrieve_perfomance_review_report/{id}', [PerfomanceReviewController::class, 'retrievePerfomaneReviewReport']);

    //performance capacity
    Route::get('/retrieve_performance_capacity', [PerfomanceCapacityController::class, 'retrieveAllPerformanceCapacity']);
    Route::post('/create_perfomance_capacity', [PerfomanceCapacityController::class, 'createPerfomanceCapacity']);
    Route::get('show_performance_capacity/{id}', [PerfomanceCapacityController::class, 'retrievePerformanceCapacityDetail']);
    Route::post('/update_performance_capacity/{id}', [PerfomanceCapacityController::class, 'updatePerformanceCapacity']);
    //ASSESSMENT
    Route::get('/retrieve_employee_capacity_details/{id}', [PerformanceAssessmentController::class, 'retrieveEmployeeCapacityDetail']);
    Route::post('/create_perfomance_assessment', [PerformanceAssessmentController::class, 'createPerfomanceAssessment']);
    Route::get('show_performance_assessment/{id}', [PerformanceAssessmentController::class, 'retrievePerformanceAssessmentDetail']);
    Route::post('/update_performance_/{id}', [PerformanceAssessmentController::class, 'updatePerformanceAssessment']);
});
