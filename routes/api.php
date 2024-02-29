<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Operation\DepartmentController;
use App\Http\Controllers\Operation\DesignationController;
use App\Http\Controllers\Operation\UnitController;
use App\Http\Controllers\Operation\RegionController;
use App\Http\Controllers\Operation\DistrictController;
use App\Http\Controllers\Employer\EmployerController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Operation\AllowanceController;
use App\Http\Controllers\Operation\BankController;
use App\Http\Controllers\Operation\BankBranchController;
use App\Http\Controllers\Operation\LocationController;
use App\Http\Controllers\Operation\WardController;
use App\Http\Controllers\Operation\EducationController;
use App\Http\Controllers\Operation\CountryController;
use App\Http\Controllers\Operation\ShiftController;
use App\Http\Controllers\Operation\JobTitleController;
use App\Http\Controllers\Operation\PackageController;
use App\Http\Controllers\Operation\RankingCriterialController;
use App\Http\Controllers\Operation\VacancyTypeController;
use App\Http\Controllers\Hiring\JobApplicationController;
use App\Http\Controllers\Hiring\HrInterviewController;
use App\Http\Controllers\Hiring\TechnicalInterviewController;
use App\Http\Controllers\Employee\EmployeeController;




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
        Route::get('/', [LoginController::class, 'showLoginForm']);
        Route::post('/login', [LoginController::class, 'authenticate']);
        // Route::get('/testmail', 'testMail');
    });
    // });
});

Route::prefix('users')->group(function () {
    Route::post('/add_user', [UserController::class, 'store'])->middleware('api');
    Route::get('/edit_user/{id}', [UserController::class, 'edit'])->middleware('api');
    Route::put('update_user/{id}', [UserController::class, 'update'])->middleware('api');
    Route::delete('delete_user/{id}', [UserController::class, 'destroy'])->middleware('api');
    Route::get('/admin_panel', [UserController::class, 'admin'])->middleware('api');
    Route::get('/get_users', [UserController::class, 'getUsers'])->middleware('api');
});
// api for department
Route::prefix('departments')->group(function () {
    Route::get('show_department', [DepartmentController::class, 'department'])->middleware('api');
    Route::get('home_department', [DepartmentController::class, 'getDepartment'])->middleware('api');
    Route::post('/add_department', [DepartmentController::class, 'store'])->middleware('api');
    Route::get('/edit_department/{id}', [DepartmentController::class, 'edit'])->middleware('api');
    Route::put('/update_department/{id}', [DepartmentController::class, 'update'])->middleware('api');
    Route::delete('delete_department/{id}', [DepartmentController::class, 'destroy'])->middleware('api');
});
// api for unit or section
Route::prefix('sections')->group(function () {
    Route::get('show_section', [UnitController::class, 'unit'])->middleware('api');
    Route::get('home_section', [UnitController::class, 'getUnit'])->middleware('api');
    Route::post('/add_section', [UnitController::class, 'store'])->middleware('api');
    Route::get('/edit_section/{id}', [UnitController::class, 'edit'])->middleware('api');
    Route::put('/update_section/{id}', [UnitController::class, 'update'])->middleware('api');
    Route::delete('delete_section/{id}', [UnitController::class, 'destroy'])->middleware('api');
});
// api for designation
Route::prefix('designations')->group(function () {
    Route::get('show_designation', [DesignationController::class, 'designation'])->middleware('api');
    Route::get('home_designation', [DesignationController::class, 'getDesignation'])->middleware('api');
    Route::post('/add_designation', [DesignationController::class, 'store'])->middleware('api');
    Route::get('/edit_designation/{id}', [DesignationController::class, 'edit'])->middleware('api');
    Route::put('/update_designation/{id}', [DesignationController::class, 'update'])->middleware('api');
    Route::delete('delete_designation/{id}', [DesignationController::class, 'destroy'])->middleware('api');
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
    Route::get('show_all_employer', [EmployerController::class, 'employer'])->middleware('api');
    Route::get('show_employer/{id}', [EmployerController::class, 'show'])->middleware('api');
    Route::post('/add_employer', [EmployerController::class, 'store'])->middleware('api');
    Route::get('/edit_employer/{id}', [EmployerController::class, 'edit'])->middleware('api');
    Route::put('/update_employer/{id}', [EmployerController::class, 'update'])->middleware('api');
    Route::get('/get_employer_document/{id}', [EmployerController::class, 'getDocument'])->middleware('api');
    Route::delete('/delete_employer/{id}', [EmployerController::class, 'destroy'])->middleware('api');
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
//api for Education Histories
Route::prefix('education')->group(function () {
    Route::get('show_educations', [EducationController::class, 'getEducationLevel'])->middleware('api');
});

// api for Allowances
Route::prefix('allowances')->group(function () {
    Route::get('show_allowance', [AllowanceController::class, 'getAllowance'])->middleware('api');
});

//api for Shifts
Route::prefix('shifts')->group(function () {
    Route::get('show_shift', [ShiftController::class, 'getShift'])->middleware('api');
});

//api for Vacancies Type
Route::prefix('vacancies')->group(function () {
    Route::get('show_vacancies', [VacancyTypeController::class, 'getVacancies'])->middleware('api');
});
//api for Shifts
Route::prefix('job_titles')->group(function () {
    Route::get('/show_job_titles', [JobTitleController::class, 'getJobTitle'])->middleware('api');
});
//  api for Packeges or /Cost Centers
Route::prefix('packages')->group(function () {
    Route::get('/show_packages', [PackageController::class, 'getPackage'])->middleware('api');
});
//  api for Ranking Criterial
Route::prefix('ranking_criterial')->group(function () {
    Route::get('/show_ranking', [RankingCriterialController::class, 'getRanking'])->middleware('api');
});

//api for Countries and nationality
Route::prefix('countries')->group(function () {
    Route::get('show_countries', [CountryController::class, 'getCountry'])->middleware('api');
});

// ******** Hiring Block  (Both Job Application and Interviews)  *****
// api for Job Application (Vacancies)
Route::prefix('hiring')->group(function () {
    //Job Application
    Route::get('job/show_jobs', [JobApplicationController::class, 'vacancy'])->middleware('api');
    Route::get('job/home_job/{id}', [JobApplicationController::class, 'show'])->middleware('api');
    Route::post('job/add_job', [JobApplicationController::class, 'store'])->middleware('api');
    Route::get('job/edit_job/{id}', [JobApplicationController::class, 'edit'])->middleware('api');
    Route::post('job/update_job/{id}', [JobApplicationController::class, 'updateJob'])->middleware('api');
    Route::put('job/update_job_description/{id}', [JobApplicationController::class, 'updateDescription'])->middleware('api');
    Route::delete('job/delete_job/{id}', [JobApplicationController::class, 'destroy'])->middleware('api');
    Route::post('job/job_description', [JobApplicationController::class, 'saveJobDescription'])->middleware('api');
    Route::get('job/get_job_document/{id}', [JobApplicationController::class, 'jobDocument'])->middleware('api');
    Route::get('job/download_job/{id}', [JobApplicationController::class, 'downloadJob'])->middleware('api');

    // HR Interview
    Route::get('/hr_interview/show_candidate', [HrInterviewController::class, 'assessedCandidate'])->middleware('api');
    Route::get('/hr_interview/show_assessment/{id}', [HrInterviewController::class, 'show'])->middleware('api');
    Route::post('/hr_interview/add_assessment', [HrInterviewController::class, 'store'])->middleware('api');
    Route::get('/hr_interview/edit_assessment/{id}', [HrInterviewController::class, 'editAssessedCandidate'])->middleware('api');
    Route::post('/hr_interview/update_assessment/{id}', [HrInterviewController::class, 'updateAssessment'])->middleware('api');
    Route::delete('/hr_interview/delete_assessment/{id}', [HrInterviewController::class, 'destroy'])->middleware('api');
    Route::get('hr_interview/get_assessed_document/{id}', [HrInterviewController::class, 'assessedDocument'])->middleware('api');

    // Technical Interview
    Route::get('technical_interview/show_candidate', [TechnicalInterviewController::class, 'candidate'])->middleware('api');
    Route::get('technical_interview/home_candidate', [TechnicalInterviewController::class, 'getCandidate'])->middleware('api');
    Route::get('/technical_interview/show_candidate/{id}', [TechnicalInterviewController::class, 'showCandidate'])->middleware('api');
    Route::post('technical_interview/add_candidate', [TechnicalInterviewController::class, 'store'])->middleware('api');
    Route::post('technical_interview/practical_test', [TechnicalInterviewController::class, 'savePractical'])->middleware('api');
    Route::get('technical_interview/practical_candidate/{id}', [TechnicalInterviewController::class, 'editPracticalCandidate'])->middleware('api');
    Route::put('technical_interview/update_practical_candidate/{id}', [TechnicalInterviewController::class, 'updatePracticalCandidate'])->middleware('api');
    Route::get('technical_interview/last_candidate/', [TechnicalInterviewController::class, 'lastCandidate'])->middleware('api');
    Route::get('technical_interview/edit_candidate/{id}', [TechnicalInterviewController::class, 'editCandidate'])->middleware('api');
    //instead of using PUT method on update  candidate  we use post in order to allow amplication/pdf
    Route::post('technical_interview/update_candidate/{id}', [TechnicalInterviewController::class, 'updateCandidate'])->middleware('api');
    Route::delete('technical_interview/delete_candidate/{id}', [TechnicalInterviewController::class, 'destroy'])->middleware('api');
    Route::get('technical_interview/get_candidate_document/{id}', [TechnicalInterviewController::class, 'candidateDocument'])->middleware('api');
});


// ******** Employees Block  (Both personal, documents, social record, induction and personal Application)  *****
// api for
Route::prefix('employees')->group(function () {
    /** api for Personal Details   */
    Route::get('show_all_employee', [EmployeeController::class, 'personDetails'])->middleware('api');
    Route::get('show_employee/{id}', [EmployeeController::class, 'show'])->middleware('api');
    Route::post('/add_employee', [EmployeeController::class, 'store'])->middleware('api');
    Route::post('/education_employee', [EmployeeController::class, 'saveEducation'])->middleware('api');
    Route::post('/employment_employee', [EmployeeController::class, 'saveEmployment'])->middleware('api');
    Route::post('/reference_check_employee', [EmployeeController::class, 'saveReferenceCheck'])->middleware('api');
    //update
    Route::get('/edit_employee/{id}', [EmployeeController::class, 'edit'])->middleware('api');
    Route::post('/update_employee/{id}', [EmployeeController::class, 'updateEmployee'])->middleware('api');
    Route::get('/education_history/{id}', [EmployeeController::class, 'editEducationHistory'])->middleware('api');
    Route::post('/update_education_employee/{id}', [EmployeeController::class, 'updateEducation'])->middleware('api');
    Route::get('/edit_employment_employee/{id}', [EmployeeController::class, 'editEmployment'])->middleware('api');
    Route::post('/update_employment_employee/{id}', [EmployeeController::class, 'updateEmployment'])->middleware('api');
    Route::get('/edit_reference_employee/{id}', [EmployeeController::class, 'editReferenceCheckt'])->middleware('api');
    Route::post('/update_reference_employee/{id}', [EmployeeController::class, 'updateReferenceCheck'])->middleware('api');
    Route::get('/get_employee_document/{id}', [EmployeeController::class, 'getEmployeeDocument'])->middleware('api');
    Route::delete('/delete_employee/{id}', [EmployeeController::class, 'destroy'])->middleware('api');
});
