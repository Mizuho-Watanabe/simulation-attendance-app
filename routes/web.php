<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\AttendanceController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
| Route::get('/', function () {
    return view('welcome');
});
*/

//一般ユーザー：Laravel/Fortifyを使用した認証
Route::middleware('auth')->group(function () {
    Route::get('/attendance', [AttendanceController::class, 'clock_in']);
    Route::post('/attendance', [AttendanceController::class, 'store']);
    Route::get('/attendance/list', [AttendanceController::class, 'index']);
    Route::get('/attendance/detail/{attendance_record}', [AttendanceController::class, 'show'])->name('show');
    Route::post('/attendance/detail/{attendance_record}', [AttendanceController::class, 'applicate']);
    Route::get('/stamp_correction_request/list', [AttendanceController::class, 'applicationList']);
});

//管理者ユーザー：以下のルートとAdminLoginControllerを使用してログイン
Route::get('/admin/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminLoginController::class, 'login']);
