<?php

namespace App\Http\Controllers\ClientArea;

use App\order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class user extends Controller
{
    public function Search(Request $request)
    {
        $request->validate([
            'search_user' => 'required'
        ]);

        if ($request->search_with == null) {
            $SearchUser = \App\User::where('name', 'like', '%' . $request->search_user . '%')->get();
        } else {
            $SearchUser = \App\User::where($request->search_with, 'like', '%' . $request->search_user . '%')->get();
        }

        return view('admin/customers', compact('SearchUser'));
    }


    public function SearchSeller(Request $request)
    {
        $request->validate([
            'search_user' => 'required'
        ]);

        if ($request->search_with == null) {
            $SearchSeller = \App\User::where('name', 'like', '%' . $request->search_user . '%')->get();
        } else {
            $SearchSeller = \App\User::where($request->search_with, 'like', '%' . $request->search_user . '%')->get();
        }

        return view('admin/sellerRequest', compact('SearchSeller'));
    }

    public function SearchSellerList(Request $request)
    {
        $request->validate([
            'search_user' => 'required'
        ]);

        if ($request->search_with == null) {
            $SearchSeller = \App\User::where('name', 'like', '%' . $request->search_user . '%')->get();
        } else {
            $SearchSeller = \App\User::where($request->search_with, 'like', '%' . $request->search_user . '%')->get();
        }

        return view('admin/sellerList', compact('SearchSeller'));
    }

    public function ConfirmSellerRequest($id)
    {
        $Seller = \App\User::find($id);

        if (isset($Seller->id)) {
            $Seller->sellerRequest = 0;
            $Seller->seller = 1;
            $Seller->save();

            return redirect('admin/sellerRequest')->with('message', 'true');
        } else {
            return redirect('admin/sellerRequest')->with('message', 'false');
        }
    }

    public function DenySeller($id)
    {
        $Seller = \App\User::find($id);

        if (isset($Seller->id)) {
            $Seller->sellerRequest = 0;
            $Seller->seller = 0;
            $Seller->save();

            return redirect('admin/sellerList')->with('message', 'true');
        } else {
            return redirect('admin/sellerList')->with('message', 'false');
        }
    }

    public function EditProfile(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'family' => 'required',
            'email' => 'required',
            'phone' => 'required',
        ]);

        $User = \App\User::where('email', $request->email)->get();
        $FindUser = \App\User::find(Auth::user()->id);
        $UserDetail = null;

        foreach ($User as $temp) {
            $UserDetail = $temp;
        }


        if ($UserDetail == null
            || $UserDetail->email == $request->email
            && Auth::user()->id == $request->id
        ) {

            $FindUser->name = $request->name;
            $FindUser->family = $request->family;
            $FindUser->email = $request->email;
            $FindUser->phone = $request->phone;

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $image->move('profile', $image->getClientOriginalName());
                $FindUser->profile = url('/') . '/profile/' . $image->getClientOriginalName();
            }

            if($request->seller != null){
                $FindUser->sellerRequest = '1';
            }

            $FindUser->save();

            return redirect('user/profile')->with('message', 'true');

        }
    }
}
