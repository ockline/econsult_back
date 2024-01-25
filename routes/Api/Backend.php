<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Employer\EmployerController;
use App\Http\Controllers\Auth\LoginController;
// api for Employer


Route::prefix('employers')->group(function () {
        Route::get('show_employer', [EmployerController::class, 'employer'])->middleware('Api');
        Route::get('home_employer', [EmployerController::class, 'getEmployer'])->middleware('Api');
        Route::post('/add_employer',[EmployerController::class, 'store'])->middleware('Api');
        Route::get('/edit_employer/{id}', [EmployerController::class,'edit'])->middleware('Api');
        Route::put('/update_employer/{id}',[EmployerController::class, 'update'])->middleware('Api');
        Route::delete('delete_employer/{id}',[EmployerController::class, 'destroy'])->middleware('Api');

});

// Route::prefix('users')->group(function (){
//     Route::get('/edit_user/{id}', [UserController::class, 'edit'])->middleware('checkUserId');
//     // Other routes...
// });
