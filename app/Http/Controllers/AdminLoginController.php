<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    //管理者用ログインページの表示
    public function showLoginForm(){
        return view('admin.admin-login');
        }

    //管理者用ログインページのログイン機能
    public function login(Request $request)
    {
        //認証
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            if (Auth::user()->admin_status === '管理者') {
                $request->session()->regenerate();
                return redirect('/admin/attendance/list');
            }

            return back()->withErrors([
                'email' => '管理者権限がありません',
            ]);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        // セッションの再生成なども行うとより安全です
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // ログアウト後の行き先を指定してリダイレクトする
        return redirect('/admin/login');
    }
}
