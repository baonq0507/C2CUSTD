<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
class AuthController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function register()
    {
        return view('register');
    }

    public function postRegister(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'referral_code' => 'required|exists:users,referral_code',
            'password_confirm' => 'required|same:password',
        ], [
            'email.required' => 'Email không được để trống',
            'email.email' => 'Email không đúng định dạng',
            'email.unique' => 'Email đã tồn tại',
            'password.required' => 'Mật khẩu không được để trống',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự',
            'referral_code.exists' => 'Mã giới thiệu không tồn tại',
            'password_confirm.required' => 'Mật khẩu không được để trống',
            'password_confirm.same' => 'Mật khẩu không khớp',
            'referral_code.required' => 'Mã giới thiệu không được để trống',
            'referral_code.exists' => 'Mã giới thiệu không tồn tại',
        ]);
        $referral_code = Str::random(6);
        $referral_by = null;
        if ($request->referral_code) {
            $referral_by = User::where('referral_code', $request->referral_code)->first()->id;
        }
        User::create([
            'name' => $request->email,
            'username' => $request->email,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'referral_code' => $referral_code,
            'referral_by' => $referral_by,
        ]);
        return redirect()->route('login')->with('success', 'Đăng ký thành công, mã giới thiệu của bạn là: ' . $referral_code);
    }

    public function postLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ], [
            'email.required' => 'Email không được để trống',
            'email.email' => 'Email không đúng định dạng',
            'password.required' => 'Mật khẩu không được để trống',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự',
        ]);

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->route('home');
        }
        return redirect()->route('login')->with('error', 'Email hoặc mật khẩu không đúng')->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
