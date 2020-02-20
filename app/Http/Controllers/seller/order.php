<?php

namespace App\Http\Controllers\seller;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class order extends Controller
{
    public function search(Request $request)
    {
        $request->validate([
            'search_order' => 'required'
        ]);

        if ($request->search_with == null) {
            $SearchOrder = \App\order::where('price', 'like', '%' . $request->search_order . '%')->get();
        } else {
            $SearchOrder = \App\order::where($request->search_with, 'like', '%' . $request->search_order . '%')->get();
        }

        return view('admin/orders', compact('SearchOrder'));
    }

    public function orderDetail(Request $request)
    {
        $Coupon = [];
        $Orders = \App\order::find($request->id);

        $detail = [
            $Orders->user->email,
            $Orders->user->phone,
            $Orders->seller->email,
            $Orders->seller->phone,
            $Orders->price,
            $Orders->totalPrice,
        ];

        if ($Orders->couponId == null) {
            $Coupon = ['ندارد'];
        } else {
            $Coupon = [$Orders->coupon->price];
        }

        $detail = array_merge($detail, $Coupon);

        return implode(',', $detail);
    }
}