<?php
    use Illuminate\Support\Facades\Auth;
?>

@if(\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->seller == '1')

@extends('seller.master.AdminMaster')

@section('title')
    پروفایل
@endsection

@section('header')
    <!-- =css for admin panel -->
    <link rel="stylesheet" type="text/css" href="{{url('css/admin.css')}}"/>

    <link rel="stylesheet" type="text/css" href="{{url('css/addProduct.css')}}"/>

@endsection


@section('MainContent')
    <div class="addProductContent">

        <div class="row" style="direction: rtl;">
            <div class="col-lg-12 col-md-12 col-sm-12 pull-right">
                <h1 class="page-header visible-lg visible-md visible-sm" style="margin-top:0; padding-top:0;">
                    پروفایل</h1>
                <h2 class="page-header visible-xs">پروفایل - {{ 'سلام ' . \Illuminate\Support\Facades\Auth::user()->name}}</h2>
            </div>
        </div>

        <form action="{{url('seller/profile')}}" method="post" enctype="multipart/form-data">

        {{csrf_field()}}

            <input type="hidden" name="id" value="{{\Illuminate\Support\Facades\Auth::user()->id}}"/>

        <!-- Start Error area -->
            <div class="row">
                @if (Illuminate\Support\Facades\Session::has('sucuss'))
                    @if(Illuminate\Support\Facades\Session::get('sucuss') != 0)
                        <div class="alert alert-success" style="direction: rtl;text-align: right">
                            {{'پروفایل به درستی ویرایش شد!'}}
                        </div>
                    @else
                        <div class="alert alert-danger" style="direction: rtl;text-align: right">
                            {{'در هنگام ویرایش پروفایل مشکلی رخ داد؛ دوباره تلاش کنید!'}}
                        </div>
                    @endif
                @endif
            </div>

            <div class="row">
                @if($errors->any())
                    <div class="alert alert-danger" style="direction: rtl;text-align: right">
                        <ul>
                            @foreach($errors->all() as $temp)
                                <li>{{$temp}}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
            <!-- End Error area -->

            <div class="row">

                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 pull-right" style="direction: ltr;">
                    <div class="form-group">
                        <div class="input-group">
                            <input type="text" name="name" class="form-control" value="{{Auth::user()->name}}"
                                   placeholder="نام را وارد نمایید..." required style="direction: rtl;"/>

                            <div class="input-group-addon">
                                <i class="fa fa-user"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 pull-right" style="direction: ltr;">
                    <div class="form-group">
                        <div class="input-group">
                            <input type="text" name="family" class="form-control" value="{{Auth::user()->family}}"
                                   placeholder="نام خانوداگی را وارد نمایید..." required style="direction: rtl;"/>

                            <div class="input-group-addon">
                                <i class="fa fa-user"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">

                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 pull-right" style="direction: ltr;">
                    <div class="form-group">
                        <div class="input-group">
                            <input type="text" name="email" class="form-control" value="{{Auth::user()->email}}"
                                   placeholder="ایمیل را وارد نمایید..." required style="direction: rtl;"/>

                            <div class="input-group-addon">
                                <i class="fa fa-envelope"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 pull-right" style="direction: ltr;">
                    <div class="form-group">
                        <div class="input-group">
                            <input type="text" name="phone" class="form-control" value="{{Auth::user()->phone}}"
                                   placeholder="شماره موبایل را وارد نمایید..." required style="direction: rtl;"/>

                            <div class="input-group-addon">
                                <i class="fa fa-phone"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 pull-right">
                    <input type="file" name="image" />
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pull-left" style="direction: ltr">
                    <a href="{{url('seller/main')}}" class="btn btn-danger">برگشت</a>
                    <input type="submit" class="btn btn-success" value="ثبت تغییرات"/>
                </div>
            </div>
        </form>

    </div>

@endsection


@else
    <script>window.location.href = "/" </script>
@endif