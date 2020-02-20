<?php

namespace App\Http\Controllers\seller;

use App\product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class comment extends Controller
{
    public function delete($id)
    {
        $Comment = \App\comment::find($id)->delete();

        $check = \App\comment::find($id);

        if (!isset($check->id)) {
            return redirect('seller/comments')->with('message', 'true');
        } else {
            return redirect('seller/comments')->with('message', 'false');
        }
    }

    public function Show($id)
    {
        return view('client.ProductDetail', compact('id'));
    }
}
