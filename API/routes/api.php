<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\StudentController;

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


//GET /api/v1/students -> Return all events from the database
Route::get('v1/students', [StudentController::class, 'index']);
//GET /api/v1/students/{id} -> Get one event
Route::get('v1/students/{id}', [StudentController::class, 'show']);
//DELETE /api/v1/students/{id} -> Soft delete an event
Route::delete('v1/students/{id}', [StudentController::class, 'destroy']);
//POST /api/v1/students -> Create an event
Route::post('v1/students/', [StudentController::class, 'store']);
//PATCH /api/v1/students/{id} -> Partially update event
Route::patch('v1/students/{id}', [StudentController::class, 'update']);


Route::get('/v1/takeAttendance/{fingerprintId}', [StudentController::class, 'updateStatusByFingerprintId']);

Route::get('/v1/takeAttendanceBySid/{studentId}', [StudentController::class, 'updateStatusByStudentId']);

Route::get('/v1/fingerPrintRegistration/{studentId}', [StudentController::class, 'fingerPrintRegistration']);

Route::post('/v1/sendSidForFingerPrintRegistration', [StudentController::class, 'fingerPrintRegistration']);

//GET /api/v1/exams -> Return all events from the database
Route::get('v1/exams', [ExamController::class, 'index']);
//GET /api/v1/exams/{id} -> Get one event
Route::get('v1/exams/{id}', [ExamController::class, 'show']);
//DELETE /api/v1/exams/{id} -> Soft delete an event
Route::delete('v1/exams/{id}', [ExamController::class, 'destroy']);
//POST /api/v1/exams -> Create an event
Route::post('v1/exams/', [ExamController::class, 'store']);
//PATCH /api/v1/exams/{id} -> Partially update event
Route::patch('v1/exams/{id}', [ExamController::class, 'update']);
