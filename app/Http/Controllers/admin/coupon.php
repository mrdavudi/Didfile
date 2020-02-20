<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class coupon extends Controller
{
    public function insert(Request $request)
    {

        $request->validate([
            'products' => 'required|max:100',
            'couponCode' => 'required|max:30',
            'couponPrice' => 'required|numeric|max:1000000'
        ]);

        $CouponCheck = \App\coupon::where('code', $request->couponCode)->get();

        $Check = null;
        foreach ($CouponCheck as $temp) {
            $Check = $temp->id;
        }

        if (!isset($Check)) {
            $newCoupon = new \App\coupon();
            $newCoupon->price = $request->couponPrice;
            $newCoupon->productId = implode(',', $request->products);
            $newCoupon->code = $request->couponCode;

            $newCoupon->save();

            if (isset($newCoupon->id)) {
                return redirect('admin/addCoupon')->with('CouponStatus', 'true');
            }

        } else {
            return redirect('admin/addCoupon')->with('CouponStatus', 'false');
        }
    }

    public function Delete($id)
    {
        $Coupon = \App\coupon::find($id);

        $Coupon->delete();

        $check = \App\coupon::find($id);

        if ($check == null) {
            return redirect('admin/editCoupon')->with('deleteStatus', 'true');
        } else {
            return redirect('admin/editCoupon')->with('deleteStatus', 'false');
        }
    }

    public function Edit(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'couponCode' => 'required|max:30',
            'couponPrice' => 'required|numeric|max:1000000',
            'products' => 'required'
        ]);

        $Coupon = \App\coupon::find($request->id);

        $CouponCheck = \App\coupon::where('code', $request->couponCode)->get();
        $CouponChecks = null;

        foreach ($CouponCheck as $temp) {
            $CouponChecks = $temp->id;
        }

        if (!(isset($CouponChecks)) || $request->id == $CouponChecks) {
            $Coupon->code = $request->couponCode;
            $Coupon->price = $request->couponPrice;
            $Coupon->productId = implode(',', $request->products);

            $Coupon->save();

            return redirect('admin/editCoupon-sub' . $request->id)->with('editStatus', 'true');
        } else {
            return redirect('admin/editCoupon-sub' . $request->id)->with('editStatus', 'false');
        }
    }

    public function Search(Request $request)
    {
        $CouponSearch = \App\coupon::where('code', 'like', '%' . $request->search_Coupon . '%')->get();

        return view('admin.editCoupon', compact('CouponSearch'));
    }


}
