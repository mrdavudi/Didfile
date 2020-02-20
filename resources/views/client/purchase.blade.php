<?php
use Illuminate\Support\Facades\Cookie;
use Hekmatinasser\Verta\Facades\Verta;
?>


@if(Cookie::get('bank') !== null && isset($_COOKIE['ShoopingCart']) && \Illuminate\Support\Facades\Auth::check())

    @extends('client.master.masterClientarea')

@section('title')
    تسویه حساب
@endsection

@section('header')
    <link rel="stylesheet" type="text/css" href="{{url('css/clientarea.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{url('css/purchase.css')}}"/>
@endsection

@section('content')
    <br/>
    <div class="container purchase page_content_Cart">

        <div class="row slider" style="text-align: center">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 pull-right" style="margin-bottom: 10px;">
                <a href="cart">سبد خرید</a>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 pull-right" style="margin-bottom: 10px;">
                <a href="checkout">ثبت سفارش</a>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 pull-right" style="margin-bottom: 10px;">
                <a href="purchase" class="btn active">پرداخت</a>
            </div>
        </div>

        <div class="row">
            <?php
            date_default_timezone_set('Asia/tehran');
            ?>

            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pull-right" style="direction: rtl;">تاریخ و زمان</div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">{{\Hekmatinasser\Verta\Facades\Verta::now()}}</div>
        </div>

        <div class="row">
            <?php
            $price = 0;
            if (isset($_COOKIE['ShoopingCart'])) {
                $product_price_cookie = explode(',', $_COOKIE['ShoopingCart']);

                foreach ($product_price_cookie as $temp) {
                    $productDetail = \App\product::find($temp);

                    $price += $productDetail['price'];
                }

                if (Cookie::get('Coupon_id') !== null) {
                    $couponPrice = \App\coupon::find(Cookie::get('Coupon_id'));
                    $price = $price - $couponPrice->price;
                }
            }

            ?>

            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pull-right"> قیمت نهایی</div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" style="direction: rtl;">
                {{ number_format($price,0,',','.') . ' تومان'}}
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pull-right"> روش پرداخت</div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">{{ \App\bank::find(Cookie::get('bank'))->name }}</div>
        </div>

        <div class="row">
            <form action="{{url('purchase')}}" method="post">
                {{csrf_field()}}

                <button class="btn btn-success pull-left"><i class="fa fa-angle-double-left"></i>
                    &nbsp;{{'پرداخت'}}
                </button>
            </form>
        </div>
    </div>
@endsection

@else
    <script> window.location.href = 'checkout' </script>
@endif