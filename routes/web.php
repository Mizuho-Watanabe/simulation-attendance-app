<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AdminController;

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

Route::get('/welcome', function () {return view('welcome'); });

//一般ユーザー：Laravel/Fortifyを使用した認証・AttendanceContorollerで機能実装
Route::middleware('auth')->group(function () {
    Route::get('/attendance', [AttendanceController::class, 'clock_in']);
    Route::post('/attendance', [AttendanceController::class, 'store']);
    Route::get('/attendance/list', [AttendanceController::class, 'index']);
    Route::get('/attendance/detail/{attendance_record}', [AttendanceController::class, 'show'])->name('show');
    Route::post('/attendance/detail/{attendance_record}', [AttendanceController::class, 'applicate']);
    Route::get('/stamp_correction_request/list', [AttendanceController::class, 'applicationList']);
});

//管理者ユーザー：以下のルートとAdminLoginControllerを使用してログイン
Route::get('/admin/login', [AdminLoginController::class, 'showLoginForm']);
Route::post('/admin/login', [AdminLoginController::class, 'login']);

//管理者ユーザー：CheckAdminMiddlewareにて管理者チェックおよびAdminControllerで機能実装
Route::middleware('check.admin')->group(function () {
    Route::get('/admin/attendance/list', [AdminController::class, 'index']);
    Route::get('/admin/attendance/{attendance_record}', [AdminController::class, 'show']);
    Route::post('/attendance/{attendance_record}', [AdminController::class, 'update']);
    Route::get('/admin/staff/list', fn() => '管理者用スタッフ一覧画面(準備中)');
    Route::get('/admin/attendance/stahh/{user}', fn() => '管理者用スタッフ別一覧画面(準備中)');
    Route::get('/stamp_correction_request/list', fn() => '管理者用申請一覧画面(準備中)');
    Route::get('/stamp_correction_request/approve/{application}', fn() => '管理者用修正申請承認画面(準備中)');
    Route::post('/stamp_correction_request/approve/{application}', fn() => '管理者用修正申請承認画面(準備中)');
    Route::post('/admin/logout', [AdminLoginController::class, 'logout']);
});
