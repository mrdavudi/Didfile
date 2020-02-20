<?php

namespace App\Http\Controllers\ClientArea;

use Hekmatinasser\Verta\Facades\Verta;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class order extends Controller
{
    public function insert()
    {
        $price = [];
        $TotalPrice = 0;
        $Products = [];
        $SellerId = [];
        $BankId = null;
        $CouponId = null;
        $OrderDate = null;
        $UserId = null;
        $i = 0;

        if (isset($_COOKIE['ShoopingCart'])) {
            $product_price_cookie = explode(',', $_COOKIE['ShoopingCart']);

            foreach ($product_price_cookie as $temp) {
                $productDetail = \App\product::find($temp);

                //get Price of products
                $price[$i] = $productDetail->price;

                //get products ID
                $Products[$i] = $temp;

                //get Seller ID
                $SellerId[$i] = $productDetail->userId;

                $TotalPrice += $productDetail['price'];

                $i++;
            }

            if (Cookie::get('Coupon_id') !== null) {
                $couponPrice = \App\coupon::find(Cookie::get('Coupon_id'));
                $TotalPrice = $TotalPrice - $couponPrice->price;

                //get Coupon ID
                $CouponId = $couponPrice->id;
            }
        }

        //get Bank ID
        $BankId = \App\bank::find(Cookie::get('bank'))->id;


        //get OrderDate
        $OrderDate = Verta::now();



        //get User ID
        $UserId = Auth::user()->id;

        $InsertArray = [];

        $FactorNum = 'didfile' . str_random(5) . Auth::user()->id;


        for ($i = 0; $i < count($Products); $i++) {
            $InsertArray[$i] = [
                'FactorNum' => $FactorNum,
                'orderDate' => $OrderDate,
                'price' => $price[$i],
                'totalPrice' => $TotalPrice,
                'productId' => $Products[$i],
                'userId' => $UserId,
                'sellerId' => $SellerId[$i],
                'bankId' => $BankId,
                'couponId' => $CouponId,
            ];
        }

        \App\order::insert(
            $InsertArray
        );


        setcookie('ShoopingCart', "", time() - 3600);
        Cookie::queue(Cookie::forget('bank'));

        if (Cookie::get('Coupon_id') !== null)
            Cookie::queue(Cookie::forget('Coupon_id'));


        return redirect('user/showOrders');


    }

}
