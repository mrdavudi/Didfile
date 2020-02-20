<?php

namespace App\Http\Controllers;

use App\bank;
use App\category;
use App\coupon;
use App\general;
use App\order;
use App\product;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Hekmatinasser\Verta\Facades\Verta;

class Api extends Controller
{
    protected function LoginApi($email, $password)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

            $UserloginData = User::where('email', $email)->get();

            $User = "";
            foreach ($UserloginData as $temp) {
                $User = $temp;
            }

            if (Auth::attempt(['email' => $email, 'password' => $password, 'Confirmation' => 1])) {

                $getData = User::where('email', $email)->get();
                $UserData = null;
                foreach ($getData as $temp) {
                    $UserData = $temp;
                }

                Auth::logout();

                return response()->json([
                    'status' => 'true',
                    'id' => $UserData->id,
                    'name' => $UserData->name,
                    'family' => $UserData->family,
                    'email' => $UserData->email,
                    'phone' => $UserData->phone
                ], 200, ['Content-type' => 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);


            } else {
                $temp = ['status' => 'false', 'error' => 'نام کاربری یا رمز عبور نادرست است.'];
                return response()->json($temp, 200, ['Content-type' => 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);

            }
        } else {
            $temp = ['status' => 'false', 'error' => 'فرمت ایمیل نادرست است.'];
            return response()->json($temp, 200, ['Content-type' => 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);
        }
    }


    public function RegisterApi($name, $email, $password)
    {
        if ($name != null && $email != null && $password != null) {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

                $users = User::where('email', $email)->get();
                $isset_User = "";
                foreach ($users as $user) {
                    $isset_User = $user->email;
                }

                if ($isset_User != $email) {

                    $getData = User::where('email', $email)->get();
                    $UserData = "";
                    foreach ($getData as $temp) {
                        $UserData = $temp;
                    }


                    $newUser = new User();

                    $newUser->name = $name;
                    $newUser->email = $email;
                    $newUser->password = bcrypt($password);
                    $newUser->ConfirmationCode = null;
                    $newUser->Confirmation = 1;
                    $newUser->save();

                    $id = $newUser->id;
                    if (isset($id)) {

                        return response()->json([
                            'status' => 'true',
                            'message' => 'ثبت نام به درستی انجام شد.',
                        ], 200, ['Content-type' => 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);

                    } else {

                        return response()->json([
                            'status' => 'false',
                            'message' => 'در هنگام ثبت نام مشکلی رخ داد؛ دوباره تلاش کنید!',
                        ], 200, ['Content-type' => 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);

                    }


                } else {

                    return response()->json([
                        'status' => 'false', 'message' => 'ایمیل وارد شده قبلا ثبت شده است!'
                    ], 200, ['Content-type' => 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);

                }
            } else {
                $temp = ['status' => 'false', 'message' => 'فرمت ایمیل نادرست است'];
                return response()->json($temp, 200, ['Content-type' => 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);

            }
        } else {
            $temp = ['status' => 'false', 'message' => 'مشخصات خواسته شده را تکمیل کنید.'];
            return response()->json($temp, 200, ['Content-type' => 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);

        }
    }


    public function ChangePassword($id, $lastPassword, $newPassword, $reNewPassword)
    {
        $User = User::find($id);

        if (isset($User->id)) {

            if (Hash::check($lastPassword, $User->password)) {
                if ($newPassword == $reNewPassword) {

                    $User->password = bcrypt($newPassword);
                    $User->save();

                    return response()->json([
                        'status' => 'true',
                        'message' => 'رمز عبور به درستی ویرایش شد.'
                    ], 200, ['Content-type' => 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);

                } else {
                    return response()->json([
                        'status' => 'false',
                        'message' => 'رمز عبور با تکرار ان برابر نیست.'
                    ], 200, ['Content-type' => 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);
                }

            } else {
                return response()->json([
                    'status' => 'false',
                    'message' => 'رمز عبور نادرست است.'
                ], 200, ['Content-type' => 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);
            }
        }
    }

    public function EditUser($id, $email, $name, $family, $phone)
    {
        $User = User::find($id);

        if (isset($User->id)) {

            foreach ($User as $temp) {
                $UserInfo = $temp;
            }

            if ($name != null)
                $User->name = $name;
            if ($family != null)
                $User->family = $family;
            if ($phone != null)
                $User->phone = $phone;
            if ($email != null && filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $User->email = $email;
            } else {
                return response()->json([
                    'status' => 'false',
                    'message' => 'فرمت ایمیل وارد شده نادرست است.'
                ], 200, ['Content-type' => 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);
            }


            $User->save();

            return response()->json([
                'status' => 'true',
                'message' => 'اطلاعات شما به درستی ویرایش شد.'
            ], 200, ['Content-type' => 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);

        } else {
            return response()->json([
                'status' => 'false',
                'message' => 'کاربر با این مشخصات یافت نشد.'
            ], 200, ['Content-type' => 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);
        }
    }

    public function ShowCategory()
    {
        $Category = category::all();

        return response()->json(['category' => $Category], 200, ['Content-type' => 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);
    }

    public function ShowProductInCategory($name)
    {
        $category = category::where('categoryName', $name)->get();
        $categoryId = "";
        foreach ($category as $temp) {
            $categoryId = $temp->id;
        }

        $productInCategory = product::where('categoryId', $categoryId)->get();

        return response()->json(['productInCategory' => $productInCategory], 200, ['Content-type' => 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);
    }

    public function ShowProduct()
    {
        $Product = product::all();

        return response()->json(['product' => $Product], 200, ['Content-type' => 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);
    }

    public function Cheaper()
    {
        $Cheaper = product::orderBy('price', 'asc')->get();

        return response()->json(['cheaper' => $Cheaper], 200, ['Content-type' => 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);

    }

    public function Expensive()
    {
        $Expensive = product::orderBy('price', 'desc')->get();

        return response()->json(['expensive' => $Expensive], 200, ['Content-type' => 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);
    }

    public function MostOrder()
    {
        $MostOrder = order::select('products.*', DB::raw('count(orders.productId) as MostCount'))
            ->join('products', 'products.id', '=', 'orders.productId')
            ->groupBy('orders.productId')
            ->orderBy('MostCount', 'desc')
            ->get();

        return response()->json(['mostOrder' => $MostOrder], 200, ['Content-type' => 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);
    }

    public function ShowBank()
    {
        $banks = bank::all();

        return response()->json(['bank' => $banks], 200, ['Content-type' => 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);
    }

    public function ShowAboutUs()
    {
        $aboutUs = general::find(1);

        return response()->json(['aboutUs' => $aboutUs], 200, ['Content-type' => 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);
    }


    public function Search($title)
    {
        $search = product::where('title', 'like', '%' . $title . '%')->get();

        return response()->json(['search' => $search], 200, ['Content-type' => 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);

    }

    public function showProductDetail($id)
    {
        $Product = product::find($id);

        return response()->json(['productDetail' => $Product], 200, ['Content-type' => 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);
    }

    public function CheckCoupon($couponCode, $productId)
    {
        $Coupon = coupon::where('code', $couponCode)->get();

        $CouponDetail = null;
        foreach ($Coupon as $temp) {
            $CouponDetail = $temp;
        }

        if (!$Coupon->isEmpty()) {
            $CouponDetailProductId = explode(',', $CouponDetail->productId);

            $ProductsId = explode(',', $productId);

            foreach ($ProductsId as $temp) {
                foreach ($CouponDetailProductId as $temp2) {
                    if ($temp == $temp2) {
                        $price = $CouponDetail->price;

                        return response()->json([
                            'status' => 'true',
                            'message' => 'کوپن تخفیف به درستی اعمال شد.',
                            'price' => $price
                        ], 200, ['Content-type' => 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);

                    }
                }
            }

            return response()->json([
                'status' => 'false',
                'message' => 'کوپن تخفیف نامعتبر است!',
                'price' => '0'
            ], 200, ['Content-type' => 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);


        } else {

            return response()->json([
                'status' => 'false',
                'message' => 'کوپن تخفیف نامعتبر است!',
                'price' => '0'
            ], 200, ['Content-type' => 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);
        }

    }


    public function ShowOrders($id)
    {
        $Orders = order::join('products', 'products.id', '=', 'orders.productId')
            ->select(
                'orders.id',
                'orders.FactorNum',
                'orders.orderDate',
                'orders.price',
                'products.path_image',
                'products.title'
            )
            ->where('orders.userId', $id)
            ->orderBy('orderDate', 'Desc')
            ->get();


        return response()->json(
            ['showOrders' => $Orders]
            , 200, ['Content-type' => 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE
        );
    }

    public function ShowDownloadLink($id)
    {
        $Orders = order::join('products', 'products.id', '=', 'orders.productId')
            ->select(
                'orders.id',
                'products.title',
                'products.description',
                'products.path_image',
                'products.AttachFileProduct',
                'orders.FactorNum',
                'orders.orderDate',
                'orders.price'
            )
            ->where('orders.id', $id)
            ->orderBy('orderDate', 'Desc')
            ->get();

        $id = null;
        $title = null;
        $description = null;
        $pathImage = null;
        $AttachFileProduct = null;
        $FactorNum = null;
        $orderDate = null;
        $price = null;

        foreach ($Orders as $temp) {
            $id = $temp->id;
            $title = $temp->title;
            $description = $temp->description;
            $pathImage = $temp->path_image;
            $AttachFileProduct = $temp->AttachFileProduct;
            $FactorNum = $temp->FactorNum;
            $orderDate = $temp->orderDate;
            $price = $temp->price;
        }

        return response()->json(
            [
                'id' => $id,
                'title' => $title,
                'description' => $description,
                'path_image' => $pathImage,
                'AttachFileProduct' => $AttachFileProduct,
                'FactorNum' => $FactorNum,
                'orderDate' => $orderDate,
                'price' => $price
            ]
            , 200, ['Content-type' => 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE
        );
    }


    public function AddOrder($userId, $ProductId, $ReceiverCode)
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


        $product_price = explode(',', $ProductId);

        foreach ($product_price as $temp) {
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


        //get Bank ID
        $Bank = \App\bank::where('ReceiverCode', $ReceiverCode)->get();

        $BankId = null;

        foreach ($Bank as $temp2) {
            $BankId = $temp2->id;
        }


        //get OrderDate
        $OrderDate = Verta::now();


        //get User ID
        $UserId = $userId;

        $InsertArray = [];

        $FactorNum = 'didfile' . str_random(5) . $userId;


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
                'couponId' => null,
            ];
        }

        \App\order::insert(
            $InsertArray
        );


        $ordersCheck = order::where('FactorNum', $FactorNum)->get();

        if (!$ordersCheck->isEmpty()) {

            return response()->json(
                [
                    'status' => 'true',
                    'message' => 'سفارش شما به درستی ثبت شد.'
                ]
                , 200, ['Content-type' => 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE
            );
        } else {
            return response()->json(
                [
                    'status' => 'false',
                    'message' => 'در هنگام ثبت سفارش خطایی رخ داد، دوباره تلاش کنید!'
                ]
                , 200, ['Content-type' => 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE
            );

        }


    }

}
