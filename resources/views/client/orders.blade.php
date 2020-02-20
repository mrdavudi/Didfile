<?php
use Illuminate\Support\Facades\Input;
use App\category;

$Orders = \App\order::join('products', 'products.id', '=', 'orders.productId')
    ->select(
        'orders.FactorNum',
        'orders.orderDate',
        'orders.price',
        'products.AttachFileProduct',
        'products.title'
    )
    ->where('orders.userId', \Illuminate\Support\Facades\Auth::user()->id)
    ->orderBy('orderDate', 'Desc')
    ->paginate(15);
?>

@if(\Illuminate\Support\Facades\Auth::check())

    @extends('client.master.AdminMaster')

@section('title')
    سفارشات
@endsection

@section('header')
    <!-- =css for admin panel -->
    <link rel="stylesheet" type="text/css" href="{{url('css/admin.css')}}"/>

    <link rel="stylesheet" type="text/css" href="{{url('css/Tables.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{url('css/SmallTables.css')}}"/>

    <link rel="stylesheet" type="text/css" href="{{url('css/category.css')}}"/>
@endsection


@section('MainContent')

    <div class="editcategoryContent" style="direction: rtl;">

        <div class="row" style="direction: rtl;">
            <div class="col-lg-12 col-md-12 col-sm-12 pull-right">
                <h1 class="page-header visible-lg visible-md visible-sm" style="margin-top:0; padding-top:0;">
                    سفارشات</h1>
                <h2 class="page-header visible-xs">سفارشات
                    - {{ 'سلام ' . \Illuminate\Support\Facades\Auth::user()->name}}</h2>
            </div>
        </div>


        <div class="Table">
            @foreach($Orders as $temp)

                <div class="visible-xs SmallTable">
                    <div class="row">
                        <div class="col-xs-4 pull-right SmallTitle">نام محصول</div>
                        <div class="col-xs-8 pull-right SmallContent">
                            {{ $temp->title }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-4 pull-right SmallTitle">شماره سفارش</div>
                        <div class="col-xs-8 pull-right SmallContent">
                            {{ $temp->FactorNum }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-4 pull-right SmallTitle">تاریخ</div>
                        <div class="col-xs-8 pull-right SmallContent">
                            {{$temp->orderDate}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-4 pull-right SmallTitle">قیمت</div>
                        <div class="col-xs-8 pull-right SmallContent">
                            {{number_format($temp->price,0,'.',',')}}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-4 pull-right SmallTitle">لینک دانلود</div>
                        <div class="col-xs-8 pull-right SmallContent">
                            <a href="{{$temp->AttachFileProduct}}">دانلود</a>
                        </div>
                    </div>

                </div>
            @endforeach

            <div class="hidden-xs">
                <div class="row tableTitle">
                    <div class="col-lg-4 col-md-4 col-sm-4 pull-right">نام محصول</div>
                    <div class="col-lg-2 col-md-2 col-sm-2 pull-right">شماره فاکتور</div>
                    <div class="col-lg-2 col-md-2 col-sm-2 pull-right">تاریخ</div>
                    <div class="col-lg-2 col-md-2 col-sm-2 pull-right">قیمت</div>
                </div>


                @foreach($Orders as $temp)

                    <div class="row tableContent mainCategory">
                        <div class="col-lg-4 col-md-4 col-sm-4 pull-right">
                            {{$temp->title}}
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2 pull-right">
                            {{$temp->FactorNum}}
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2 pull-right">
                            {{$temp->orderDate}}
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2 pull-right">
                            {{number_format($temp->price,0,'.',',')}}
                        </div>

                        <br/>

                        <div class="col-lg-12 col-md-12 col-sm-12" style="padding: 0;">
                            <a href="{{$temp->AttachFileProduct}}">دانلود</a>
                        </div>
                    </div>

                @endforeach
            </div>

        </div>


        <div style="direction: ltr;text-align: left;margin-top: 50px;">
            {{ $Orders->links()}}
        </div>

    </div>

@endsection

@else
    <script>window.location.href = "/" </script>
@endif