<?php

namespace App\Http\Controllers\ClientArea;

use App\Http\Controllers\Email\AccountConfirm\ActiveEmail;
use App\Http\Controllers\Email\AccountConfirm\ConfirmationMail;
use App\User;
use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Mail;


class LoginController extends Controller
{
    protected function show()
    {
        if (Cookie::get('rememberUser') !== null) {
            return view('home');
        } else {
            return view('auth.login');
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
        ];

        $UserInfo = User::where('email', $request->email)->get();

        $UserDetail = [];
        foreach ($UserInfo as $temp) {
            $UserDetail = $temp;
        }

        if (!$UserInfo->isEmpty()) {

            if ($UserDetail->Confirmation == 1) {
                if (Auth::attempt($info)) {

                    if ($request->ajax()) {
                        return 'true';
                    } else {
                        return redirect('user/main');
                    }

                } else {

                    if ($request->ajax()) {
                        return 'نام کاربری یا رمز عبور نادرست است!';
                    } else {
                        $error = 'نام کاربری یا رمز عبور نادرست است!';
                        return view('auth.login', compact('error'));
                    }
                }
            } else {
                $UserDetail->ConfirmationCode = str_random(30);
                $UserDetail->save();

                Mail::to($UserDetail->email)->send(new ConfirmationMail($UserDetail->ConfirmationCode, $UserDetail->id));

                if ($request->ajax()) {
                    return 'ConfirmFalse';
                } else {
                    $error_Activation = 'حساب کاربری شما فعال نشده است!';
                    return view('auth.login', compact('error_Activation'));
                }
            }
        }
        else{
            $error = 'نام کاربری یا رمز عبور نادرست است!';
            return view('auth.login', compact('error'));
        }


    }


    protected function logout()
    {
        Cookie::queue(Cookie::forget(Auth::getRecallerName()));
        Auth::logout();
        return redirect('/');
    }


}
