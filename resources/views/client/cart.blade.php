<?php
use Illuminate\Support\Facades\Cookie;
?>

@extends('client.master.masterClientarea')

@section('title')
    سبد خرید
@endsection

@section('header')
    <link rel="stylesheet" type="text/css" href="{{url('css/cart.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{url('css/clientarea.css')}}"/>
@endsection

@section('content')
    <div class="container page_content">

        <div class="big-mode">

            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        @php
                            $error = str_replace('coupon txt','کوپن تخفیف',$error)
                        @endphp
                        {{$error}}
                    @endforeach
                </div>
            @endif

            @if(\Illuminate\Support\Facades\Session::has('NoCoupon'))
                <div class="alert alert-danger">
                    {{\Illuminate\Support\Facades\Session::get('NoCoupon')}}
                </div>
            @endif

            <div class="row" style="border: none;">
                <h3>
                    <span class="fa fa-angle-double-left" style="color: #2196F3"></span>
                    سبد خرید شما
                </h3>
                <p style="color: #FF6A52;">افزودن محصول به سبد خرید به معنی رزرو محصول برای شما نیست. برای ثبت سفارش
                    باید مراحل بعدی خرید را
                    تکمیل
                    نمایید.</p>

            </div>

            <br/>

            <?php
            if(isset($_COOKIE["ShoopingCart"])){
            $cookie = explode(',', $_COOKIE["ShoopingCart"]);
            $totalPrice = 0;

            foreach ($cookie as $temp){
            $product_detail = \App\product::find($temp);

            $totalPrice += $product_detail['price'];

            ?>
            <div id="{{'MobileModeCart' . $product_detail['id']}}">
                <!-- Start Cart in Small mode -->
                <div class="row visible-xs">
                    <div class="col-xs-6 pull-right">محصول</div>
                    <div class="col-xs-6"><p><a href="#">{{$product_detail['title']}}</a></p></div>
                </div>
                <div class="row visible-xs">
                    <div class="col-xs-6 pull-right">قیمت واحد</div>
                    <div class="col-xs-6"><p
                                style="text-align: right">{{number_format($product_detail['price'],0,',','.') . ' تومان'}}</p>
                    </div>
                </div>
                <div class="row visible-xs" style="margin-bottom: 20px;">
                    <div class="col-xs-12 delete">
                        <a href="#" onclick='deleteCart({{"$product_detail[id]"}})'><i class="fa fa-trash"></i></a>
                    </div>
                </div>
                <!-- End Cart in Small mode -->
            </div>
            <?php } ?>

        <!-- Start Title in Big mode -->
            <div class="row title visible-lg visible-md visible-sm">
                <div class="col-lg-8 col-md-8 col-sm-8 pull-right">
                    <p>محصول</p>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 pull-right">
                    <p>قیمت واحد</p>
                </div>
                <div class="col-lg-1 col-md-1 col-sm-1 pull-right" style="border: none">عملیات</div>
            </div>
            <!-- End Title in Big mode -->


            <!-- Start value in Big mode -->
            <div class="row value visible-lg visible-md visible-sm">
                <?php
                $cookie = explode(',', $_COOKIE["ShoopingCart"]);
                $totalPrice = 0;

                foreach ($cookie as $temp){
                $product_detail = \App\product::find($temp);

                $totalPrice += $product_detail['price'];
                ?>
                <div id="{{'ComputerModeCart' . $product_detail['id']}}" class="col-lg-8 col-md-8 col-sm-8 pull-right">
                    <p><a href="{{url('productDetail') . $product_detail['id']}}">{{$product_detail['title']}}</a></p>
                </div>
                <div id="{{'ComputerModeCart' . $product_detail['id']}}" class="col-lg-3 col-md-3 col-sm-3 pull-right">
                    <p style="text-align: center">{{number_format($product_detail['price'],0,',','.') . ' تومان'}}</p>
                </div>
                <div id="{{'ComputerModeCart' . $product_detail['id']}}"
                     class="col-lg-1 col-md-1 col-sm-1 pull-right delete">
                    <a href="#" onclick='deleteCart({{"$product_detail[id]"}})'><i class="fa fa-trash"></i></a>
                </div>

            <?php
            }
            ?>

            <!-- End value in Big mode -->
            </div>

            <br/>

            <!-- Start Copun in Big mode -->
            <div class="row" style="border: none;text-align: left">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 pull-right"
                     style="border: none;padding: 0;margin-bottom: 20px;">
                    <form action="{{url('cart/add/coupon')}}" method="post">
                        {{csrf_field()}}

                        <input type="text" name="coupon_txt" class="form-control pull-right"
                               name="coupon" style="max-width: 320px;margin-left: 10px;"
                               placeholder="کوپن تخفیف را وارد نمایید..."
                               required/>
                        <input type="submit" class="btn btn-primary pull-right" value="اعمال کوپن"/>
                    </form>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 pull-left" style="border:none;padding: 0;">
                    <div class="total-price">
                        <span>جمع کل خرید شما</span>
                        <span>:</span>
                        <span>{{ number_format($totalPrice,0,',','.') . ' تومان'  }}</span>
                    </div>

                    @if (Cookie::get('Coupon_id') !== null)
                        <div class="total-price" style="color: red;">
                        <span><a href="cart/delete/coupon"
                                 style="text-decoration: none;color: red; font-size: 30px;display: inline-block">&times;</a></span>
                            <span>&nbsp;&nbsp;</span>
                            <span>کوپن تخفیف</span>
                            <span>:</span>

                            <?php
                                $CouponIdCookie = Cookie::get('Coupon_id');
                                $CouponPrice = \App\coupon::find($CouponIdCookie);
                            ?>

                            <span>{{ number_format($CouponPrice->price, 0, ',', '.') . ' تومان' }}</span>
                        </div>
                    @endif

                    <div class="purchase-price">
                        <span>مبلغ قابل پرداخت</span>
                        <span>:</span>
                        @if (Cookie::get('Coupon_id') !== null)
                            <span>{{ number_format($totalPrice - $CouponPrice->price,0,',','.') . ' تومان'  }}</span>
                        @else
                            <span>{{ number_format($totalPrice,0,',','.') . ' تومان'  }}</span>
                        @endif
                    </div>

                </div>
            </div>
            <!-- End Copun in Big mode -->

            <br/>

            <!-- Start Back button in Big mode -->
            <div class="row" style="text-align: left;border: none;">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 pull-right" style="border: none;padding: 0;">
                    <a href="/" class="btn back-to-main pull-right">بازگشت به صفحه اصلی
                        &nbsp;
                        <span class="fa fa-angle-double-right"></span>
                    </a>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 pull-left" style="text-align: left;padding: 0; ">
                    @if(isset(\Illuminate\Support\Facades\Auth::user()->name))
                        <a href="checkout" class="btn btn-success pull-left">
                            <span class="fa fa-angle-double-left"></span>
                            &nbsp;
                            مرحله بعد
                        </a>
                    @else
                        <a href="LoginOrRegister" class="btn btn-success pull-left">
                            <span class="fa fa-angle-double-left"></span>
                            &nbsp;
                            مرحله بعد
                        </a>
                    @endif
                </div>
            </div>
            <!-- End Back button in Big mode -->


            <?php
            }
            else{
            ?>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"
                     style="font-size: 17px; color: gray;text-align: center;padding: 15px;">سبد خرید خالی می باشد.
                </div>
            </div>

            <?php
            }
            ?>
        </div>


        <script src="{{url('js/jquery-1.10.2.min.js')}}"></script>
        <script src="{{url('js/jquery.cookie.js')}}"></script>
        <script src="{{url('js/bootstrap/bootstrap.min.js')}}"></script>


        <!-- Start Deleteing Cart -->
        <script>
            function deleteCart(id) {
                $.ajax({
                    type: "POST",
                    url: 'cart/delete/product/' + id,
                    data: {id: id, _token: "{{ csrf_token() }}"},
                    success: function (msg) {
                        if(msg == 'true')
                        {
                            window.location.href = 'cart';
                        }
                    }
                });
            }
        </script>
        <!-- End Deleteing Cart -->

    </div>



@endsection