<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CMS\DashboardController;
use App\Http\Controllers\CMS\GrupController;
use App\Http\Controllers\CMS\MemberGrupController;
use App\Http\Controllers\CMS\SubmissionsController;
use App\Http\Controllers\CMS\UserController;
use App\Http\Controllers\CMS\ProsedurController;

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
    return view('Web.Home');
});

// Route api authentication
Route::middleware('guest')->group(function () {
    // ui login
    Route::get('/login', function () {
        return view('Auth.Login');
    })->name('login');
    // api login
});
Route::post('auth/login', [AuthController::class, 'login']);

Route::middleware(['web', 'auth'])->group(function () {

    Route::get('/dashboard', function () {
        return view('Admin.Dashboard');
    })->middleware('checkRole:super admin');
    Route::get('/prosedur', function () {
        return view('Admin.Prosedur');
    })->middleware('checkRole:super admin');
    Route::get('/submissions', function () {
        return view('Admin.Submissions');
    })->middleware('checkRole:super admin');
    Route::get('/group', function () {
        return view('Admin.Group');
    })->middleware('checkRole:super admin');
    Route::get('/member-group', function () {
        return view('Admin.MemberGroup');
    })->middleware('checkRole:super admin');
    Route::get('/user', function () {
        return view('Admin.User');
    })->middleware('checkRole:super admin');

    Route::get('/disposision', function () {
        return view('Admin.Disposisi');
    })->middleware('checkRole:admin');
    // route  api user //
    Route::get('/dashboard/submissions-count', [DashboardController::class, 'getSubmissionCount']);
    Route::get('/dashboard/members-count', [DashboardController::class, 'getMemberCount']);
    Route::prefix('v1/user')->controller(UserController::class)->group(function () {
        Route::get('/', 'getAllData');
        Route::post('/create', 'createData');
        Route::get('/get/{id}', 'getDataById');
        Route::post('/update/{id}', 'updateDataById');
        Route::delete('/delete/{id}', 'deleteData');
    });

    // route  api  //
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
    Route::post('auth/logout', [AuthController::class, 'logout']);
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

// route produk hukum //
Route::prefix('v1/prosedur')->controller(ProsedurController::class)->group(function () {
    Route::get('/', 'getAllData');
    Route::post('/create', 'createData');
    Route::get('/get/{id}', 'getDataById');
    Route::post('/update/{id}', 'updateDataById');
    Route::delete('/delete/{id}', 'deleteData');
});
