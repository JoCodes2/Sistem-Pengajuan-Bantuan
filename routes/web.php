<?php

use App\Http\Controllers\CMS\GrupController;
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

Route::get('/', function () {
    return view('Admin.Dashboard');
});
Route::get('/submissions', function () {
    return view('Admin.Submissions');
});
Route::get('/group', function () {
    return view('Admin.Group');
});
Route::get('/member-group', function () {
    return view('Admin.MemberGroup');
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

// route  api submissions //
Route::prefix('v1/submissions')->controller(SubmissionsController::class)->group(function () {
    Route::get('/', 'getAllData');
    Route::post('/create', 'createData');
    Route::get('/get/{id}', 'getDataById');
    Route::post('/update/{id}', 'updateDataById');
    Route::delete('/delete/{id}', 'deleteData');
});
