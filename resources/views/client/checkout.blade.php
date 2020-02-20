<?php
use Illuminate\Support\Facades\Auth;
?>

@if(Auth::check() && isset($_COOKIE['ShoopingCart']))

@extends('client.master.masterClientarea')

@section('title')
    ثبت مشخصات
@endsection

@section('header')
    <link rel="stylesheet" type="text/css" href="{{url('css/clientarea.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{url('css/checkout.css')}}"/>

@endsection

@section('content')
    <br/>
    <div class="container checkout page_content_Cart" style="text-align: center;">
        <div class="row slider">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 pull-right" style="margin-bottom: 10px;">
                <a href="cart">سبد خرید</a>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 pull-right" style="margin-bottom: 10px;">
                <a href="checkout" class="btn active">ثبت سفارش</a>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 pull-right" style="margin-bottom: 10px;">
                <a>پرداخت</a>
            </div>
        </div>

        <div class="row">
            <p>❖ همه موارد خواسته شده اجباری هستند ❖</p>
        </div>

        <form action="{{ url('checkout') }}" method="post" style="margin-top:  30px;" name="form" id="form">
            {{csrf_field()}}

            @if ($errors->any() || isset($error))
                <div class="alert alert-danger" style="direction: rtl;text-align: right;">
                    <ul>
                        @if ($errors->any())
                            @foreach ($errors->all() as $error_validation)
                                @php
                                    $error_validation = str_replace('email','ایمیل',$error_validation);
                                    $error_validation = str_replace('password','رمز عبور',$error_validation);
                                    $error_validation = str_replace('name','نام',$error_validation);
                                    $error_validation = str_replace('family','نام خانوادگی',$error_validation);
                                    $error_validation = str_replace('phone','شماره موبایل',$error_validation);
                                    $error_validation = str_replace('radio','درگاه بانک',$error_validation);
                                @endphp
                                <li>{{$error_validation}}</li>
                            @endforeach
                        @endif
                        @if(isset($error))
                            <li>{{$error}}</li>
                        @endif
                    </ul>
                </div>
            @endif

            <div class="row">
                <!-- Start name input -->
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 pull-right">
                    <div class="form-group">
                        <div class="input-group">
                            <input type="text" name="name" class="form-control" placeholder="نام را وارد نمایید..."
                                   required value="<?php if (isset(Auth::user()->name)) echo Auth::user()->name ?>"/>

                            <div class="input-group-addon">
                                <i class="fa fa-user"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End name input -->

                <!-- Start family input -->
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 pull-right">
                    <div class="form-group">
                        <div class="input-group">
                            <input type="text" name="family" class="form-control"
                                   required value="<?php if (isset(Auth::user()->family)) {echo Auth::user()->family;} else echo old('family'); ?>"
                                   placeholder="نام خانوادگی را وارد نمایید..."/>

                            <div class="input-group-addon">
                                <i class="fa fa-user"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End family input -->
            </div>
            <div class="row">
                <!-- Start phone number input -->
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 pull-right">
                    <div class="form-group">
                        <div class="input-group">
                            <input type="text" name="phone" class="form-control"
                                   required value="<?php if (isset(Auth::user()->phone)) {echo Auth::user()->phone;} else {echo old('phone');} ?>"
                                   placeholder="شماره موبایل را وارد نمایید..."/>

                            <div class="input-group-addon">
                                <i class="fa fa-phone"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End phone number input -->

                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 pull-right">
                </div>
            </div>

            <div class="row">
                <!-- Start ٍEmail input -->
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 pull-right">
                    <div class="form-group">
                        <div class="input-group">
                            <input type="text" name="email" class="form-control"
                                   required value="<?php if (isset(Auth::user()->email)) echo Auth::user()->email; ?>"
                                   placeholder="ایمیل را وارد نمایید..."/>

                            <div class="input-group-addon">
                                <i class="fa fa-envelope"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Email input -->

            </div>

            <div class="row" style="margin-top: 40px;text-align: right">
                <h4 style="margin-bottom: 20px;padding-right: 10px;">انتخاب درگاه پرداخت اینترنتی</h4>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php
                        $bank = \App\bank::all();

                        foreach ($bank as $banks){
                    ?>
                    <div>
                        <h5 style="display: inline;">{{ 'درگاه پرداخت ' . $banks->name }}</h5>
                        &nbsp;
                        <input type="radio" name="radio" value="{{$banks->id}}" required/>
                    </div>

                    <?php
                        }
                    ?>
                </div>
            </div>

            <!-- Start next step buttn -->
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 pull-left" style="text-align: left;">
                    <button class="btn btn-success" onclick="form.submit()">مرحله بعد
                        &nbsp;
                        <i class="fa fa-angle-double-left"></i>
                    </button>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"></div>
            </div>
            <!-- End next step buttn -->
        </form>
    </div>
@endsection

@else
    <script> window.location.href = 'cart'; </script>
@endif
