<?php

namespace App\Http\Controllers\Email\AccountConfirm;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ActiveEmail extends Controller
{
    public function index($ConfirmationCode, $id)
    {

        $user = User::find($id);

        if ($user->ConfirmationCode == $ConfirmationCode) {
            $user->ConfirmationCode = null;
            $user->Confirmation = 1;
            $user->save();


            $lastUrl = $user->lastUrl;

            if (Auth::loginUsingId($id) && $user->Confirmation == 1) {
                if ($lastUrl == 'LoginOrRegister') {
                    return redirect('checkout');
                } else {
                    return redirect('user/main');
                }
            } else {
                return redirect('login');
            }
        }
        else{
            return redirect('/');
        }

    }
}
