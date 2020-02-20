<?php

namespace App\Http\Controllers\ClientArea;

use App\bank;
use App\coupon;
use App\product;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class cart extends Controller
{
    public function coupon(Request $request)
    {
        $request->validate([
            'coupon_txt' => 'required'
        ]);

        $couponDetail = "";
        $coupon = coupon::where('code', $request["coupon_txt"])->get();
        if (!($coupon->isEmpty())) {
            $ShoppingCartCookie = explode(',', $_COOKIE['ShoopingCart']);

            foreach ($coupon as $coupons) {
                $couponDetail = $coupons;
            }

            for ($i = 0; $i < count($ShoppingCartCookie); $i++) {
                $productDetail = product::find($ShoppingCartCookie[$i]);
                if ($couponDetail["productId"] == $productDetail["id"]) {
                    $coupon_price = $couponDetail["price"];
                    Cookie::queue(Cookie::make('Coupon_id', $couponDetail["id"]), 60 * 24 * 10);
                    return redirect('cart');
                }
            }

            return redirect('cart')->with('NoCoupon', 'کوپن وارد شده نامعتبر است!');

        } else {
            return redirect('cart')->with('NoCoupon', 'کوپن وارد شده نامعتبر است!');
        }
    }

    public function deleteCoupon()
    {
        Cookie::queue(Cookie::forget('Coupon_id'));
        return redirect('cart');
    }


    protected function RegisterOrder(Request $request)
    {

        if (Auth::check()) {

            $request->validate([
                'name' => 'required|max:50',
                'family' => 'required|max:30',
                'phone' => 'required|max:11|regex:/(09)[0-9]{9}/',
                'email' => 'required|max:100',
                'radio' => 'required',
            ]);


            $users = User::where('email', $request->email)->get();
            $isset_User = "";
            foreach ($users as $user) {
                $isset_User = $user->email;
            }

            if ($isset_User != null && $isset_User != Auth::user()->email) {
                $error = 'ایمیل وارد شده قبلا ثبت شده است!';
                return view('client.checkout', compact('error'));

            } elseif ($isset_User != null
                && $isset_User == Auth::user()->email
                || $isset_User == null
            ) {

                $bankId = $request->radio;
                $bankName = bank::find($bankId);
                $bankName = $bankName->name;

                Cookie::queue(Cookie::make('bank', $bankId, 60 * 2));
                return redirect('purchase');
            }

        } else {
            return redirect('LoginOrRegister');
        }
    }

    protected function deleteCart($id)
    {
        $couponCookie = "";

        if (Cookie::get('Coupon_id') !== null) {

            $couponCookie = Cookie::get('Coupon_id');
            $CouponModel = coupon::find($couponCookie);

            if ($id == $CouponModel->productId) {
                Cookie::queue(Cookie::forget('Coupon_id'));
            }
        }


        $productCookie = explode(',', $_COOKIE['ShoopingCart']);

        $temp = [];

        for ($i = 0; $i < count($productCookie); $i++) {
            if ($productCookie[$i] != $id) {
                $temp[$i] = $productCookie[$i];
            }
        }

        $temp = implode(',', $temp);
        setcookie('ShoopingCart', $temp, time() + (86400 * 10), '/');

        if (isset($_COOKIE['ShoopingCart'])) {
            return 'true';
        }
    }

}
