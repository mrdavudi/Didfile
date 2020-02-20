<?php

namespace App\Http\Controllers\Email\PasswordReset;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;

class ForgotPassword extends Controller
{

    protected function SendLink()
    {

        $email = Input::post('email');

        $Users = User::where('email', $email)->get();

        $UserIfo = "";

        if (!$Users->isEmpty()) {

            foreach ($Users as $User) {
                $UserIfo = $User;
            }

            $UserId = User::find($UserIfo->id);

            $UserId->remember_password = str_random(40);
            $UserId->save();

            Mail::to($email)->send(new SendResetEmail($UserId->id, $UserId->remember_password));

            return 'true';

        } else {
            return 'false';
        }
    }
}
