<?php

namespace App\Http\Controllers\admin;


use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;


class LoginController extends Controller
{
    protected function show()
    {
        if (Cookie::get('rememberUser') !== null) {
            return view('admin.admin');
        } else {
            return view('admin.login');
        }
    }


    protected function login(Request $request)
    {
        $request->validate([
            'email' => 'required|max:100',
            'password' => 'required|max:255',
        ]);

        $info = [
            'email' => $request->email,
            'password' => $request->password,
            'admin' => '1'
        ];

        $UserInfo = User::where('email', $request->email)->get();

        $UserDetail = [];
        foreach ($UserInfo as $temp) {
            $UserDetail = $temp;
        }

        if (!$UserInfo->isEmpty()) {
            if ($UserDetail->Confirmation == 1) {
                if (Auth::attempt($info)) {

                    return redirect('admin/main');
                } else {
                    $error = 'نام کاربری یا رمز عبور نادرست است!';
                    return view('admin.login', compact('error'));
                }
            } else {
                $error = 'نام کاربری یا رمز عبور نادرست است!';
                return view('admin.login', compact('error'));
            }
        } else {
            $error = 'نام کاربری یا رمز عبور نادرست است!';
            return view('admin.login', compact('error'));
        }


    }


    protected function logout()
    {
        Cookie::queue(Cookie::forget(Auth::getRecallerName()));
        Auth::logout();
        return redirect('/');
    }


}
