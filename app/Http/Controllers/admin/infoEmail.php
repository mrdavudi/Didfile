<?php

namespace App\Http\Controllers\admin;

use App\emailnews;
use App\Http\Controllers\admin\Email\SendNews;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class infoEmail extends Controller
{
    public function insert(Request $request)
    {
        $User = User::where('email', $request->emailInfo)->get();

        $UserId = null;

        if (!$User->isEmpty()) {

            foreach ($User as $temp) {
                $UserId = $temp->id;
            }

            $CheckExistUser = emailnews::where('userId', $UserId)->get();

            if ($CheckExistUser->isEmpty()) {
                $newEmailInfo = new emailnews();
                $newEmailInfo->userId = $UserId;
                $newEmailInfo->save();

                if (isset($newEmailInfo->id)) {
                    return redirect('/')->with('message', 'true');
                }

            } else {
                return redirect('/')->with('message', 'Exist');
            }


        } else {
            return redirect('/')->with('message', 'false');
        }
    }

    public function delete($id)
    {
        $UserEmail = emailnews::where('userId', $id)->delete();

        $CheckUserEmail = emailnews::where('userId', $id)->get();

        if ($CheckUserEmail->isEmpty()) {
            return redirect('admin/infoEmailList')->with('message', 'true');
        } else {
            return redirect('admin/infoEmailList')->with('message', 'false');
        }
    }

    public function search(Request $request)
    {
        $request->validate([
            'search_email' => 'required'
        ]);

        if ($request->search_with == null) {
            $SearchEmailInfo = emailnews::join('users', 'Users.id', '=', 'emailnews.userId')
                ->where('name', 'like', '%' . $request->search_email . '%')
                ->get();

            return view('admin.infoEmailList', compact('SearchEmailInfo'));
        } else {
            $SearchEmailInfo = emailnews::join('users', 'Users.id', '=', 'emailnews.userId')
                ->where($request->search_with, 'like', '%' . $request->search_email . '%')
                ->get();

            return view('admin.infoEmailList', compact('SearchEmailInfo'));
        }

    }

    public function SendEmail(Request $request)
    {

        $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        $UsersInNews = emailnews::join('users', 'Users.id', '=', 'emailnews.userId')->get();

        $Emails = [];
        for ($i = 0; $i < count($UsersInNews); $i++) {
            $Emails[$i] = $UsersInNews[$i]->email;
        }

        $title = $request->title;
        $text = $request->description;

        if ($request->hasFile('image')) {
            $UploadImage = $request->file('image');
            $UploadImage->move('EmailNewsImage', $UploadImage->getClientOriginalName());
            $image = 'http://www.didfile.ir' . '/ProductImage/' . $request->file('image')->getClientOriginalName();
            Mail::to($Emails)->send(new SendNews($title, $text, $image));

        } else {
            Mail::to($Emails)->send(new SendNews($title, $text));
        }


        if (Mail::failures()) {
            return redirect('admin/sendInfoEmail')->with('message', 'false');
        }

        return redirect('admin/sendInfoEmail')->with('message', 'true');
    }
}
