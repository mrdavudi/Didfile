<?php

namespace App\Http\Controllers\ClientArea;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Email\AccountConfirm\ConfirmationMail;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function show()
    {
        return view('auth.register');
    }

    public function Register(Request $request)
    {
        $request->validate([
            'name' => 'required|max:50',
            'email' => 'required|max:100',
            'password' => 'required|confirmed|max:255',
        ]);


        $users = User::where('email', $request->email)->get();
        $isset_User = "";
        foreach ($users as $user) {
            $isset_User = $user->email;
        }

        if ($isset_User != $request->email) {

            $confirmationCodeForEmail = Str::random (30);

            $newUser = new User();
            $newUser->name = $request->name;
            $newUser->email = $request->email;
            $newUser->password = bcrypt($request->password);
            $newUser->lastUrl = $request->lastUrl;
            $newUser->ConfirmationCode = $confirmationCodeForEmail;
            $newUser->save();

            $id = $newUser->id;
            if (isset($id)) {

                Mail::to($request->email)->send(new ConfirmationMail($confirmationCodeForEmail, $newUser->id));
                return redirect('login')->with(['RegisterStatus' => 'true']);
            }

        } else {
            $error = 'ایمیل وارد شده قبلا ثبت شده است!';
            return view('auth.register', compact('error'));
        }
    }

}
