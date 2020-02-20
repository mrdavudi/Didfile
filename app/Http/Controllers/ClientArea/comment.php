<?php

namespace App\Http\Controllers\ClientArea;

use App\User;
use Hekmatinasser\Verta\Facades\Verta;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class comment extends Controller
{
    public function insert(Request $request)
    {

        $request->validate([
            'text' => 'required'
        ]);

        $date = Verta();

        if (Auth::check()) {
            $user = User::where('email', Auth::user()->email)->get();

            if(! $user->isEmpty()){
                $userExist = null;
                foreach ($user as $temp){
                    $userExist = $temp;
                }

                $newComment = new \App\comment();
                $newComment->text = $request->text;
                $newComment->productId = $request->productId;
                $newComment->userId = Auth::user()->id;
                $newComment->commentDate = $date->year . '-' . $date->month . '-' . $date->day;

                $newComment->save();

                return redirect()->back()->with('message', 'true');
            }
        } else {
            return redirect()->back()->with('message', 'false');
        }
    }
}
