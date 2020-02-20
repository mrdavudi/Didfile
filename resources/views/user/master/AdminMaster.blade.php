@if(\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->seller == '1')

        <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title> @yield('title') </title>

    <!-- Bootstrap Core CSS -->
    <link href="{{url('css/bootstrap/bootstrap.min.css')}}" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{url('css/startmin.css')}}" rel="stylesheet">


    <!-- Custom Fonts -->
    <link href="{{url('css/font/font-awesome/font-awesome.css')}}" rel="stylesheet" type="text/css">

    @yield('header')

</head>
<body>

<div id="wrapper">

    <!-- Start Top Navbar -->
    <nav class="navbar navbar-inverse" style="margin: 0;border-radius: 0;">

        <div class="container-fluid">


            <div class="navbar-header pull-right">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>

            <div class="pull-left navbar-nav side-menu hidden-lg hidden-md hidden-sm" style="padding-left: 15px;">
                <a href="#" style="color: #fff;font-size: 30px;"><i class="fa fa-sign-out fa-fw pull-right"></i></a>
            </div>

            <br class="hidden-lg hidden-md hidden-sm"/>
            <br class="hidden-lg hidden-md hidden-sm"/>

            <div class="collapse navbar-collapse" id="myNavbar">
                <ul class="nav navbar-nav pull-right side-menu" style="text-align: right;">

                    <li>
                        <a href="http://127.0.0.1:8000"><i class="fa fa-home fa-fw pull-right"></i> نمایش وبسایت</a>
                    </li>
                    <li>
                        <a href="{{url('seller/main')}}">
                            <i class="fa fa-dashboard fa-fw pull-right"></i>پنل مدیریت</a>

                    </li>
                    <li>
                        <a href="{{url('seller/profile')}}"><i class="fa fa-user fa-fw pull-right"></i> پروفایل</a>
                    </li>

                    <li class="hidden-md hidden-lg hidden-sm">
                        <a href="{{url('seller/productChart')}}"><i class="fa fa-bar-chart-o fa-fw pull-right"></i>
                            نمودار ها</a>
                    </li>


                    <li class="hidden-md hidden-lg hidden-sm">
                        <a href="#"><i class="fa fa-database fa-fw pull-right"></i> محصولات<span
                                    class="fa fa-angle-down pull-left"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="{{url('seller/addProduct')}}">افزودن</a>
                            </li>
                            <li>
                                <a href="{{url('seller/editProduct')}}">لیست محصولات</a>
                            </li>
                        </ul>
                        <!-- /.nav-second-level -->
                    </li>

                    <li class="hidden-md hidden-lg hidden-sm">
                        <a href="{{url('seller/orders')}}"><i class="fa fa-first-order fa-fw pull-right"></i> سفارشات</a>
                    </li>

                    <li class="hidden-xs">
                        <a href="{{url('seller/logout')}}"><i class="fa fa-sign-out fa-fw pull-right"></i> خروج</a>
                    </li>

                    <li class="hidden-md hidden-lg hidden-sm">
                        <a href="{{url('seller/comments')}}"><i class="fa fa-comments fa-fw pull-right"></i> دیدگاه
                            ها</a>
                    </li>
                </ul>


            </div>

        </div>
    </nav>
    <!-- End Top Navbar -->


    <!-- Start all Content -->
    <div class="row">

        <!-- Start Menu Sidebar -->
        <div class="col-lg-2 col-md-3 col-sm-3 sidebar pull-right hidden-xs"
             style="padding: 0;margin: 0;padding-right: 15px;border-top: 1px solid #fff;">


            <div class="row" style="padding: 15px;direction:  rtl;padding-right: 20px;background: #eee;margin: 0;">

                @if(\Illuminate\Support\Facades\Auth::user()->profile == null)
                    <div class="pull-right">
                        <img src="{{url('profile/profile.png')}}" class="img-logo-menu img-circle"/>
                    </div>
                @else
                    <div class="pull-right">
                        <img src="{{\Illuminate\Support\Facades\Auth::user()->profile}}"
                             class="img-logo-menu img-circle"/>
                    </div>
                @endif

                <div class="pull-right">
                    <h4 href="#" style="padding-right: 10px;">
                        @if(\Illuminate\Support\Facades\Auth::check())
                            <span style="direction: rtl;"> {{ 'سلام ' . \Illuminate\Support\Facades\Auth::user()->name}}</span>
                        @endif
                    </h4>
                    <h5 style="padding-right: 10px;">
                        <i style="color: green;font-size: 10px;" class="fa fa-circle"></i>

                        &nbsp;

                        <span>آنلاین</span>
                    </h5>
                </div>
            </div>

            <div>
                <ul class="nav side-menu" style="text-align: right;">
                    <li>
                        <a href="{{url('seller/main')}}" style="background: #ccc;"><i
                                    class="fa fa-dashboard fa-fw pull-right"></i>
                            پنل
                            مدیریت</a>
                    </li>
                    <li>
                        <a href="{{url('seller/productChart')}}"><i class="fa fa-bar-chart-o fa-fw pull-right"></i>
                            نمودار ها</a>
                    </li>

                    <li>
                        <a href="#"><i class="fa fa-database fa-fw pull-right"></i> محصولات<span
                                    class="fa arrow pull-left"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="{{url('seller/addProduct')}}">افزودن</a>
                            </li>
                            <li>
                                <a href="{{url('seller/editProduct')}}">لیست محصولات</a>
                            </li>
                        </ul>
                        <!-- /.nav-second-level -->
                    </li>


                    <li>
                        <a href="{{url('seller/orders')}}"><i class="fa fa-first-order fa-fw pull-right"></i> سفارشات</a>
                    </li>

                    <li>
                        <a href="{{url('seller/comments')}}"><i class="fa fa-comments fa-fw pull-right"></i> دیدگاه
                            ها</a>
                    </li>

                </ul>
            </div>
        </div>
        <!-- End Menu Sidebar -->


        <!-- Start Main Content -->
        <div class="col-lg-10 col-md-9 col-sm-9 col-xs-12" style="padding: 0;margin: 0;">
            @yield('MainContent')
        </div>
        <!-- End Main Content -->

    </div>
    <!-- End all Content -->


</div>


<!-- jQuery -->
<script src="{{url('js/jquery-1.10.2.min.js')}}"></script>

<!-- Bootstrap Core JavaScript -->
<script src="{{url('js/bootstrap/bootstrap.min.js')}}"></script>

<!-- Metis Menu Plugin JavaScript -->
<script src="{{url('js/metisMenu.min.js')}}"></script>

<!-- Custom Theme JavaScript -->
<script src="{{url('js/startmin.js')}}"></script>

</body>
</html>

@else
    <script>window.location.href = "/" </script>
@endif