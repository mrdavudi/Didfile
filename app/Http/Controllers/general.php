<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class general extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'aboutUs' => 'required'
        ]);


        $abouteUs = \App\general::find(1);

        $abouteUs->text = $request->aboutUs;
        $abouteUs->save();

        if (isset($abouteUs->id)) {
            return redirect('admin/addAboutUs')->with('sucess', 'تغییرات باموفقیت انجام شد.');
        } else {
            return redirect('admin/addAboutUs')->with('error', 'دوباره تلاش کنید');
        }
    }
}
