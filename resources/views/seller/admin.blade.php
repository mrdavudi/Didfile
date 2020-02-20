@if(\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->seller == '1')

    <?php
    $Orders = \App\order::count();
    $Comments = \App\comment::count();
    $Products = \App\product::where('userId', \Illuminate\Support\Facades\Auth::user()->id)->count();
    ?>

    @extends('seller.master.AdminMaster')

@section('title')
    پنل فروشنده-دیدفایل
@endsection

@section('header')
    <!-- css for admin panel -->
    <link rel="stylesheet" type="text/css" href="{{url('css/admin.css')}}"/>

    <link rel="stylesheet" type="text/css" href="{{url('css/Tables.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{url('css/SmallTables.css')}}"/>

@endsection

@section('MainContent')
    <div id="page-wrapper" style="margin-left: 0;">
        <!-- /.row -->
        <div class="row" style="direction: rtl;">
            <div class="col-lg-12">
                <h1 class="page-header visible-lg visible-md visible-sm" style="margin-top:0; padding-top:0;">پنل
                    فروشنده</h1>
                <h2 class="page-header visible-xs">پنل فروشنده
                    - {{ 'سلام ' . \Illuminate\Support\Facades\Auth::user()->name}}</h2>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="panel panel-primary" style="max-width: 650px;">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-comments fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge">{{$Comments}}</div>
                                <div style="direction: rtl;">دیدگاه ها!</div>
                            </div>
                        </div>
                    </div>
                    <a href="{{url('seller/comments')}}">
                        <div class="panel-footer">
                            <span class="pull-right">نمایش جزئیات</span>
                            <span class="pull-left"><i class="fa fa-arrow-circle-left"></i></span>

                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="panel panel-green">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-user fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge">{{$Products}}</div>
                                <div style="direction: rtl;">محصولات</div>
                            </div>
                        </div>
                    </div>
                    <a href="{{url('seller/editProduct')}}">
                        <div class="panel-footer">
                            <span class="pull-right">نمایش جزئیات</span>
                            <span class="pull-left"><i class="fa fa-arrow-circle-left"></i></span>

                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="panel panel-yellow">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-shopping-cart fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge">{{$Orders}}</div>
                                <div style="direction: rtl;">سفارش ها!</div>
                            </div>
                        </div>
                    </div>
                    <a href="{{url('seller/orders')}}">
                        <div class="panel-footer">
                            <span class="pull-right">نمایش جزئیات</span>
                            <span class="pull-left"><i class="fa fa-arrow-circle-left"></i></span>

                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="panel panel-red">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-bar-chart fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge">2</div>
                                <div style="direction: rtl;">نمودار ها!</div>
                            </div>
                        </div>
                    </div>
                    <a href="{{url('seller/productChart')}}">
                        <div class="panel-footer">
                            <span class="pull-right">نمایش جزئیات</span>
                            <span class="pull-left"><i class="fa fa-arrow-circle-left"></i></span>

                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <!-- /.row -->

        <?php
        $TotalPrice = \App\order::where('sellerId', \Illuminate\Support\Facades\Auth::user()->id)->sum('price');
        $MyPrice = \App\order::where('sellerId', \Illuminate\Support\Facades\Auth::user()->id)->count();
        ?>

        <div class="row" style="direction: rtl;margin-top: 50px;margin-right: 50px; ">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 col-lg-offset-3 col-md-offset-1 col-sm-offset-1 col-xs-offset-1 SmallTable"
                 style="max-width: 700px;direction: rtl;">

                <div class="row">
                    <div class="col-xs-4 pull-right SmallTitle" style="font-size: 17px;">فروخته شده توسط من</div>
                    <div class="col-xs-8 pull-right SmallContent" style="font-size: 20px;">
                        {{$MyPrice . ' عدد'}}
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-4 pull-right SmallTitle" style="font-size: 17px;">سود کل</div>
                    <div class="col-xs-8 pull-right SmallContent" style="font-size: 20px;">
                        {{number_format($TotalPrice,0,',','.') . ' تومان'}}
                    </div>
                </div>

            </div>

        </div>


    </div>


@endsection

@else
    <script>window.location.href = "/" </script>
@endif