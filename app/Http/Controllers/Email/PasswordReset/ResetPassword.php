<?php

namespace App\Http\Controllers\Email\PasswordReset;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;

class ResetPassword extends Controller
{
    public function ResetEmail($token, $id)
    {
        $UserInfo = User::find($id);

        $newpassword = str_random(8);

        if ($token == $UserInfo->remember_password) {

            $UserInfo->remember_password = '';
            $UserInfo->password = bcrypt($newpassword);
            $UserInfo->save();

            Mail::to($UserInfo->email)->send(new SendNewPassword($newpassword));
            return redirect('login')->with(['PasswordSendStatus' => 'true']);

        } else {
            return redirect('/');
        }
    }
}
