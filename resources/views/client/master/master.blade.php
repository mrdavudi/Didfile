<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

?>

        <!DOCTYPE html>
<html>
<head>
    <title>@yield('title')</title>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport'/>

    <link rel="stylesheet" type="text/css" href="{{url('css/font/font-awesome/font-awesome.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{url('css/bootstrap/bootstrap.min.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{url('css/main.css')}}"/>

@yield('header') <!-- For customise style and script -->

</head>
<body>
<!-- Start Side Nav -->
<div id="mySidenav" class="sidenav" style="text-align: right;">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>

    <div class="parentcat0 visible-xs" onclick='ToggleSideNav("parentcat0","cat0")'>
        <a class="btn btn-info">دسترسی سریع</a>

        <ul class="cat0 collapse">
            <li><a href="/">خانه</a></li>
            <li><a href="supportWays">پشتیبانی</a></li>

            @if(Auth::check() || Cookie::get('rememberUser') !== null)
                @if(\Illuminate\Support\Facades\Auth::user()->admin == '0')
                    <li><a href="{{url('user/main')}}">ورود به پنل</a></li>
                @else
                    <li><a href="{{url('admin/main')}}">ورود به پنل</a></li>
                @endif
            @else
                <li><a href="register">ثبت نام</a></li>
                <li><a href="login">ورود</a></li>
            @endif

        </ul>
    </div>

    <?php
    $category = \App\category::where('sid', '0')->get();


    foreach ($category as $category_detail){

    if(!(\App\category::where('sid', $category_detail['id'])->get()->isEmpty())){

    ?>
    <div class="{{'parentcat' . $category_detail['id']}}"
         onclick='ToggleSideNav("{{'parentcat' . $category_detail['id']}}","{{'cat' . $category_detail['id']}}")'>
        <!-- parentcatX and CatX -->

        <a class="btn btn-info">{{$category_detail['categoryName']}}</a>

        <?php
        $ChildCategory = \App\category::where('sid', $category_detail['id'])->get();

        foreach ($ChildCategory as $child_detail){
        ?>
        <ul class="{{'cat' . $category_detail['id'] . ' collapse' }}">
            <li><a href="{{'Categories' . $child_detail['id']}}">{{$child_detail['categoryName']}}</a></li>
        </ul>
        <?php
        }
        ?>
    </div>

    <?php
    }else{
    ?>
    <div class="{{'parentcat' . $category_detail['id']}}"
         onclick='ToggleSideNav("{{'parentcat' . $category_detail['id']}}","{{'cat' . $category_detail['id']}}")'>

        <a href="{{'Categories' . $category_detail['id']}}"
           class="btn btn-info">{{$category_detail['categoryName']}}</a>

    </div>
    <?php
    }
    }
    ?>
</div>
<!-- End Side Nave -->

<!-- Start navBar in ***Mobile*** mode -->
<nav class="navbar navbar-inverse visible-xs" style="margin: 0;">
    <div class="container" style="padding-top: 10px;">

        <!-- Start Cart in small mode -->
        <div class="visible-xs visible-sm pull-left">
            <a href="{{url('cart')}}" class="btn" style="padding: 0;position: relative; line-height: 20px;">
                <span class="fa fa-shopping-cart" style="font-size: 30px; color: #fff;"></span>
                <i class="badge" id="ShoppingCartCounterSmall" style="position: absolute; top: 0; right: -7px;
                    background: #4CAF50;width: 17px;direction:rtl;height: 15px;font-size: 10px;">
                    @php
                        if(isset($_COOKIE["ShoopingCart"])){
                            $ShoppingCartCounter = explode(',', $_COOKIE["ShoopingCart"]);
                            echo count($ShoppingCartCounter);
                        }
                        else
                            echo '0';
                    @endphp
                </i>
            </a>
        </div>
        <!-- End Cart in small mode -->

        <div class="pull-right" style="margin-left: 20px;">
            <ul class="nav navbar-nav">
                <li>
                    <a style="cursor:pointer" onclick="openNav()">
                        <span class="	glyphicon glyphicon-menu-hamburger"
                              style="font-size: 25px;line-height:5px;"></span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- start logo in Small mode -->
        <div class="pull-right navbar-brand" style="padding: 0;">
            <a href="/">
                <img src="{{url('img/logo.png')}}" width="95px" class="logo"/>
            </a>
        </div>
        <!-- End logo in Small mode -->
    </div>
</nav>
<!-- End navBar in ***Mobile*** mode -->

<!-- Start navBar in ***Computer*** mode -->
<nav class="navbar navbar-inverse navbar-fixed-top visible-lg visible-md visible-sm" style="background: transparent;">
    <div class="container" style="padding: 15px;">
        <ul class="nav navbar-nav">
            <li>
                <a style="cursor:pointer" onclick="openNav()">دسته ها
                    <span class="fa fa-bars"></span>
                </a>
            </li>
            <li><a href="{{url('/')}}">خانه</a></li>
            <li><a href="supportWays">پشتیبانی </a></li>

            @if(Auth::check() || Cookie::get('getRecallerName') !== null)
                <li style="direction: rtl;">
                    @if(\Illuminate\Support\Facades\Auth::user()->admin == '0'
                    && \Illuminate\Support\Facades\Auth::user()->seller == '0')
                        <a href="{{url('user/main')}}">
                            <span>سلام</span>
                            &nbsp;
                            <span>
                            {{\Illuminate\Support\Facades\Auth::user()->name}}
                        </span>
                        </a>
                    @elseif(\Illuminate\Support\Facades\Auth::user()->admin == '1')
                        <a href="{{url('admin/main')}}">
                            <span>سلام</span>
                            &nbsp;
                            <span>
                            {{\Illuminate\Support\Facades\Auth::user()->name}}
                        </span>
                        </a>
                    @elseif(\Illuminate\Support\Facades\Auth::user()->seller == '1')
                        <a href="{{url('seller/main')}}">
                            <span>سلام</span>
                            &nbsp;
                            <span>
                            {{\Illuminate\Support\Facades\Auth::user()->name}}
                        </span>
                        </a>
                    @endif
                </li>
            @else

                <li>
                    <a href="{{url('register')}}">
                        <span>ثبت نام</span>
                        &nbsp;
                        <span class="glyphicon glyphicon-user pull-right"></span>
                    </a>
                </li>

                <li>
                    <a href="{{url('login')}}">
                        <span>ورود</span>
                        &nbsp;
                        <span class="glyphicon glyphicon-log-in pull-right"></span>
                    </a>
                </li>
        @endif


        <!-- Start Cart in big mode-->
            <li class="cart visible-lg visible-md">
                <a href="{{url('cart')}}" class="btn" style="padding: 0;">
                    <i class="fa fa-shopping-cart" style="position: relative;"></i>
                    <i class="badge" id="ShoppingCartCounterBig" style="position: absolute; left: 40px; top: 10px;">
                        @php
                            if(isset($_COOKIE["ShoopingCart"])){
                                $ShoppingCartCounter = explode(',', $_COOKIE["ShoopingCart"]);
                                echo count($ShoppingCartCounter);
                            }
                            else
                                echo '0';
                        @endphp
                    </i>
                </a>

            </li>
            <!-- End Cart in big mode-->
        </ul>
        <!-- start logo in Big mode -->
        <div class="pull-left visible-lg visible-md navbar-brand" style="padding: 0;">
            <a href="/">
                <img src="{{url('img/logo.png')}}" width="120px" class="logo"/>
            </a>
        </div>
        <!-- End logo in Big mode -->
    </div>


</nav>
<!-- End navBar in ***Computer*** mode -->


<!-- Start Overlay picture (bottom of menu) -->
<div class="container-fluid" style="padding: 0;position: relative;">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"
         style="padding: 0; height: 400px; border-bottom: 3px solid #aaa;">

        <!-- Start Image header -->
        <img src="{{url('img/header2.jpg')}}" class="img-responsive"
             style="width: 100%; height: 100%;filter:brightness(0.3);"/>
        <!-- End Image header -->

        <!-- Start Text and textBox header -->
        <div class="container">
            <div class="row">

                <!-- Start text on header -->
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="carousel-caption" style="margin-top: 0;margin-bottom: 30px;">
                        <!-- in big mode -->
                        <h1 style="text-align: center; font-weight: bold;color: #fff;margin-top: 0;"
                            class="visible-lg visible-md">
                            <i style="color: #C02932;">امروز</i>
                            <i>، مهارت های خودت رو افزایش بده</i>
                        </h1>
                        <!-- in big mode -->

                        <!-- in Small mode -->
                        <h3 style="text-align: center; font-weight: bold;color: #fff;margin-top: 0;"
                            class="visible-sm visible-xs">
                            دارای 25 دوره آموزشی در قلب دیدفایل
                        </h3>
                        <!-- in Small mode -->

                        <p style="text-align: center;color: #fff;font-size: 20px;margin-bottom: 30px;">
                            چه دوره ای را می خواهید یاد بگیرید؟
                        </p>
                        <!-- End text on header -->

                        <!-- Start Header Serach Box -->
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div id="custom-search-input">
                                <div class="input-group col-md-12">
                                        <span class="input-group-btn">
                                            <button class="btn btn-info btn-lg" type="button" id="SearchButton">
                                                <i class="glyphicon glyphicon-search"></i>
                                            </button>
                                        </span>
                                    <input type="text" class="form-control input-lg" required
                                           id='SearchBox' placeholder="جستجو کنید..." name="SearchBox"
                                           style="text-align: right;direction: rtl;"
                                           value="<?php if (isset($value)) echo $value; ?>"/>
                                </div>
                            </div>
                        </div>
                        <!-- End Header Serach Box -->

                    </div>
                </div>
            </div>
        </div>
        <!-- End Text and textBox header -->

    </div>
</div>


</div>
<!-- End Overlay picture (bottom of menu) -->

<div style="clear: both"></div>

<!-- Start Content -->
<div class="container-fluid" style="text-align: center;">
    @yield('content')
</div>
<!-- End Content -->

<div style="clear: both"></div>

<!-- Start Footer -->
<div class="container-fluid footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 pull-right">
                <div>
                    <h3>شبکه های اجتماعی</h3>
                    <!-- Start social network link and text -->
                    <div class="social_network" style="text-align: right;padding: 10px; ">
                        <a href="#"><i class="fa fa-instagram pull-right"></i></a>
                        <a href="#"><i class="fa fa-telegram pull-right"></i></a>
                        <a href="#"><i class="fa fa-twitter pull-right"></i></a>
                        <a href="#"><i class="fa fa-facebook pull-right"></i></a>
                    </div>
                    <div style="padding: 20px; padding-right: 0;margin-top: 20px;">
                        <p>از تخفیف‌ها و جدیدترین‌های دیدفایل باخبر شوید!</p>
                        <form action="{{url('InfoEmailList')}}" method="post">
                            {{csrf_field()}}

                            <div class="form-group" style="direction: ltr;">

                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pull-right" style="padding: 0;">
                                    <div class="input-group">
                                        <input type="email" name="emailInfo" id="emailInfo"
                                               required placeholder="ایمیل خود را وارد نمایید..." class="form-control"
                                               style="direction: rtl;text-align: right;color: #aaa;"/>

                                        <div class="input-group-addon">
                                            <i class="fa fa-envelope"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pull-right"
                                     style="padding: 0;margin-top: 10px;">

                                    @if(\Illuminate\Support\Facades\Session::has('message'))
                                        @if(\Illuminate\Support\Facades\Session::get('message') == 'true')
                                            <div class="alert alert-success"
                                                 style="line-height: 20px;padding: 5px;direction: rtl;">
                                                {{'با موفقیت ثبت شد.'}}
                                            </div>
                                        @elseif(\Illuminate\Support\Facades\Session::get('message') == 'false')
                                            <div class="alert alert-danger"
                                                 style="line-height: 20px;padding: 5px;direction: rtl;">
                                                {{'این ایمیل وجود ندارد، دوباره تلاش کنید!'}}
                                            </div>
                                        @elseif(\Illuminate\Support\Facades\Session::get('message') == 'Exist')
                                            <div class="alert alert-danger"
                                                 style="line-height: 20px;padding: 5px;direction: rtl;">
                                                {{'این ایمیل قبلا ثبت شده است!'}}
                                            </div>
                                        @endif
                                    @endif
                                </div>


                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pull-right"
                                     style="padding: 0;margin-top: 10px;">
                                    <input type="submit" class="btn btn-success" value="تایید ایمیل"/>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- End social network link and text -->

            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 pull-right">
                <div>
                    <h3 style="padding-right: 20px;">لینک های مفید</h3>
                    <!-- Start links -->
                    <div style="padding-right: 50px; ">
                        <a href="{{url('aboutUs')}}">درباره ما</a>
                        <a href="{{url('supportWays')}}">پشتیبانی</a>
                    </div>
                    <!-- End links -->
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 pull-right">
                <div>
                    <h3>جواز های ما</h3>
                    <!-- Start License (enamad and samandehi) -->

                    <div>
                        <a href="#" class="pull-right">
                            <img src="{{url('img/enamad.png')}}" class="img-responsive"/>
                        </a>
                        <a href="#" class="pull-right">
                            <img src="{{url('img/samandehi.png')}}" class="img-responsive"/>
                        </a>
                    </div>
                    <!-- End License (enamad and samandehi) -->
                </div>
            </div>
        </div>

        <div style="clear: both"></div>
        <br/>

        <!-- Start Count of user, Count of product and etc... -->
        <div class="row" style="background: #222932;min-height: 80px;padding: 20px;">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 pull-right" style="padding: 10px;">
                <div>
                    <i class="fa fa-users pull-right" style="font-size: 40px;"></i>
                    <p class="pull-right">
                        تعداد کاربران
                        <br/>
                        <span>{{\App\User::count() . ' عدد'}}</span>
                    </p>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 pull-right">
                <div>
                    <i class="fa fa-desktop pull-right" style="font-size: 40px;"></i>
                    <p class="pull-right">
                        تعداد آموزش ها
                        <br/>
                        <span>{{\App\product::count() . ' عدد'}}</span>
                    </p>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 pull-right">
                <div>
                    <i class="fa fa-calendar pull-right" style="font-size: 40px;"></i>
                    <p class="pull-right">
                        هر روز آموزش های جدید
                        <br/>
                        با ما همراه باشید
                    </p>
                </div>
            </div>
        </div>
        <!-- End Count of user, Count of product and etc... -->
    </div>
</div>

<!-- End Footer -->

<script src="{{url('js/jquery-1.10.2.min.js')}}"></script>
<script src="{{url('js/bootstrap/bootstrap.min.js')}}"></script>

<!-- Start Change background and color of navbar on scroll down -->
<script>
    $(function () {
        $(document).scroll(function () {
            var $nav = $(".navbar-fixed-top");
            $nav.toggleClass('scrolled', $(this).scrollTop() > $nav.height());
        });
    });
</script>
<!-- End Change background and color of navbar on scroll down -->

<!-- Start Script for Side Nav -->
<script>
    function openNav() {
        document.getElementById("mySidenav").style.width = "250px";
    }

    function closeNav() {
        document.getElementById("mySidenav").style.width = "0";
    }

    //for toggle menu in side nav
    function ToggleSideNav(parentCat, childCat) {
        $("." + parentCat + " ." + childCat).slideToggle();
    }

</script>
<!-- End Script For Side Nav -->

<!-- Start Create arrow before <a> in side nav -->
<script>
    $(".sidenav ul li a").append("&nbsp;&nbsp;<span class='fa fa-angle-left'></span>");
</script>
<!-- End arrow before <a> in side nav -->

<!-- Start Script for search box -->

<script>
    $('#SearchButton').click(function () {
        var value = $('#SearchBox').val();

        window.location.href = value;
    });
</script>

<!-- End Script for search box -->

</body>
</html>