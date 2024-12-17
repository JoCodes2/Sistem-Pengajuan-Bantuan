<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CMS\DashboardController;
use App\Http\Controllers\CMS\GrupController;
use App\Http\Controllers\CMS\MemberGrupController;
use App\Http\Controllers\CMS\SubmissionsController;
use App\Http\Controllers\CMS\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/dashboard', function () {
    return view('Admin.Dashboard');
});
Route::get('/dashboard/submissions-count', [DashboardController::class, 'getSubmissionCount']);
Route::get('/dashboard/members-count', [DashboardController::class, 'getMemberCount']);


Route::get('/', function () {
    return view('Web.Home');
});
Route::get('/submissions', function () {
    return view('Admin.Submissions');
});
Route::get('/submissions/create', function () {
    return view('Admin.SampleCreatePengajuan');
});
Route::get('/group', function () {
    return view('Admin.Group');
});
Route::get('/member-group', function () {
    return view('Admin.MemberGroup');
});
Route::get('/user', function () {
    return view('Admin.User');
});

Route::get('/disposision', function () {
    return view('Admin.Disposisi');
});
// route  api user //
Route::prefix('v1/user')->controller(UserController::class)->group(function () {
    Route::get('/', 'getAllData');
    Route::post('/create', 'createData');
    Route::get('/get/{id}', 'getDataById');
    Route::post('/update/{id}', 'updateDataById');
    Route::delete('/delete/{id}', 'deleteData');
});

// route  api user //
Route::prefix('v1/grup')->controller(GrupController::class)->group(function () {
    Route::get('/', 'getAllData');
    Route::post('/create', 'createData');
    Route::get('/get/{id}', 'getDataById');
    Route::post('/update/{id}', 'updateDataById');
    Route::delete('/delete/{id}', 'deleteData');
});

// route  api membergrup //
Route::prefix('v1/membergrup')->controller(MemberGrupController::class)->group(function () {
    Route::get('/', 'getAllData');
    Route::post('/create', 'createData');
    Route::get('/get/{id}', 'getDataById');
    Route::post('/update/{id}', 'updateDataById');
    Route::delete('/delete/{id}', 'deleteData');
});

Route::prefix('v1/membergrup')->controller(MemberGrupController::class)->group(function () {
    Route::get('/', 'getAllData');
    Route::post('/create', 'createData');
    Route::get('/{id}', 'getDataById');  // Perbaikan di sini
    Route::post('/update/{id}', 'updateDataById');
    Route::delete('/delete/{id}', 'deleteData');
});


// route  api submissions //
Route::prefix('v1/submissions')->controller(SubmissionsController::class)->group(function () {
    Route::get('/', 'getAllData');
    Route::post('/create', 'createData');
    Route::get('/get/{id}', 'getDataById');
    Route::post('/update/{id}', 'updateDataById');
    Route::delete('/delete/{id}', 'deleteData');
    Route::post('/approve-reject/{id}', 'approveReject');
});

// Route api authentication
Route::get('/login', function () {
    return view('Auth.Login');
});
Route::post('auth/login', [AuthController::class, 'login']);
Route::post('auth/logout', [AuthController::class, 'logout']);
