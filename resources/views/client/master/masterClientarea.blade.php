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
                    || \Illuminate\Support\Facades\Auth::user()->seller == '0')
                        <a href="{{url('user/main')}}">
                            <span>سلام</span>
                            &nbsp;
                            <span>
                            {{\Illuminate\Support\Facades\Auth::user()->name}}
                        </span>
                        </a>
                    @elseif(\Illuminate\Support\Facades\Auth::user()->admin == '0')
                        <a href="{{url('admin/main')}}">
                            <span>سلام</span>
                            &nbsp;
                            <span>
                            {{\Illuminate\Support\Facades\Auth::user()->name}}
                        </span>
                        </a>
                    @elseif(\Illuminate\Support\Facades\Auth::user()->seller == '0')
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
<div class="container-fluid">
    @yield('content')
</div>


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
</body>
</html>