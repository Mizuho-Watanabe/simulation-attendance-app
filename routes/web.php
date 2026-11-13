<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminLoginController;

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
    Route::get('/attendance', fn() => '出勤登録（準備中）');
    Route::get('/attendance/list', fn() => '勤怠一覧（準備中）');
    Route::get('/attendance/detail', fn() => '勤怠詳細（準備中）');
    Route::get('/stamp-correction-request/list', fn() => '申請一覧（準備中）');
});

//管理者ユーザー：以下のルートとAdminLoginControllerを使用してログイン
Route::get('/admin/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminLoginController::class, 'login']);
