<?php
use Illuminate\Support\Facades\Auth;
$Product = \App\product::find($id);
?>

@extends('client.master.master')

@section('header')
    <link rel="stylesheet" type="text/css" href="{{url('css/ProductDetail.css')}}"/>
@endsection

@section('title')
    جزئیات آموزش
@endsection

@section('content')
    <div class="container">
        <div class="right-side col-lg-8 col-md-8 col-sm-12 col-xs-12 pull-right" style="direction: rtl;">

            {!! $Product->description !!}

            <br/>
            <div class="feature">
                <ul>
                    <li>
                        <p>
                            <span>
                                {{'نوع فایل: '}}
                            </span>
                            <span>
                                {{ $Product->category->categoryName }}
                            </span>
                        </p>
                    </li>
                    <li>
                        <p>
                            <span>
                                {{'سطح آموزش: '}}
                            </span>
                            <span>
                                {{$Product->level }}
                            </span>
                        </p>
                    </li>
                    <li>
                        <p>
                            <span>
                                {{'توضیحات: '}}
                            </span>
                            <span>
                                {!! $Product->detail_description !!}
                            </span>
                        </p>
                    </li>
                </ul>

                <br/>
            </div>

            <h2>سرفصل ها:</h2>
            <p class="head">
                {!! $Product->headings !!}
            </p>

        </div>
        <div class="left-side col-lg-4 col-md-4 col-sm-12 col-xs-12" style="max-width: 350px;">

            <p style="text-align: center;">
                <span>
                    {{'قیمت آموزش: '}}
                </span>
                <span>
                    {{ number_format($Product->price,0,',','.') }}
                </span>

                <span>
                    {{' تومان'}}
                </span>
            </p>
            <h3 style="text-align: center;border-bottom: 1px solid #ccc;padding-bottom: 10px;">مشخصات آموزش</h3>
            <div>
                <div style="margin-top: 30px;">
                    <i class="fa fa-file pull-right" style="font-size: 60px;color: #00BCD4;"></i>
                    <div>
                        <h4>حجم آموزش</h4>
                        <p>{{ $Product->size }}</p>
                    </div>
                </div>

                <div style="margin-top: 40px;">
                    <i class="fa fa-clock-o pull-right" style="font-size: 60px;color: #00BCD4;"></i>
                    <div>
                        <h4>مدت آموزش</h4>
                        <p>{{ $Product->time }}</p>
                    </div>
                </div>

                <div style="margin-top: 40px;margin-bottom: 50px;">
                    <i class="fa fa-th-large pull-right" style="font-size: 60px; color: #00BCD4;"></i>
                    <div>
                        <h4>دسته بندی</h4>
                        <p>{{ $Product->category->categoryName }}</p>
                    </div>
                </div>
            </div>

            <div style="text-align: center;">
                <button title="افزودن به سبد خرید" type="button" data-toggle="modal" data-target="#myModal"
                        onclick="SetShoppingCart({{$Product['id']}})" class="btn btn-primary">
                    {{'افزودن به سبد خرید'}}
                </button>
            </div>

        </div>

        <?php
        $Comment = \App\comment::where('productId', $id)->paginate(5);
        $CountComment = \App\comment::where('productId', $id)->count();
        ?>

        <div class="comment col-lg-8  col-md-8 col-sm-12 col-xs-12 col-lg-offset-4" style="direction: rtl;">

            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h4 style="text-align: center;margin-top: 0;padding-top: 0;">تا کنون {{ $CountComment }} دیدگاه ثبت شده
                    است</h4>

                @foreach($Comment as $temp)
                    <div class="row">
                        <div class="col-sm-12">
                            <h3></h3>
                        </div><!-- /col-sm-12 -->
                    </div><!-- /row -->
                    <div class="row">
                        <div class="col-lg-2 col-md-2 col-sm-2 hidden-xs pull-right">
                            <div class="thumbnail">
                                <img class=" user-photo"
                                     src="https://ssl.gstatic.com/accounts/ui/avatar_2x.png">
                            </div><!-- /thumbnail -->
                        </div><!-- /col-sm-1 -->

                        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 pull-right">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <strong>{{ '(' . $temp->user->name . ' ' . $temp->user->family . ')'  }}</strong>
                                    <span class="text-muted">{{ $temp->commentDate }}</span>
                                </div>
                                <div class="panel-body">
                                    {{ $temp->text }}
                                </div><!-- /panel-body -->
                            </div><!-- /panel panel-default -->
                        </div><!-- /col-sm-5 -->
                    </div><!-- /row -->
                @endforeach

                <div style="direction: ltr">
                    {{ $Comment->links() }}
                </div>
            </div>

            @if(\Illuminate\Support\Facades\Auth::check())
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <form action="{{url('addComment')}}" method="post" name="form1" id="form1">

                        {{csrf_field()}}

                        <input type="hidden" value="{{$Product->id}}" name="productId"/>

                        @if($errors->any())
                            <div class="row">
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif

                        @if(\Illuminate\Support\Facades\Session::has('message'))
                            <div class="row">
                                @if(\Illuminate\Support\Facades\Session::get('message') == 'true')
                                    <div class="alert alert-success">
                                        {{'دیدگاه با موفقیت ثبت شد.'}}
                                    </div>

                                @else
                                    <div class="alert alert-danger">
                                        {{'در هنگام ثبت دیدگاه مشکلی رخ داد؛ دوباره تلاش کنید!'}}
                                    </div>
                                @endif
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pull-right"
                                 style="margin-bottom: 10px;">
                                <input type="text" name="name" class="form-control" placeholder="نام کامل (الزامی)"
                                       <?php if (Auth::check()) echo 'disabled' ?>
                                       value="<?php if (Auth::check()) echo Auth::user()->name . ' ' . Auth::user()->family; ?>"/>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pull-right"
                                 style="margin-bottom: 10px;">
                                <input type="email" name="email" class="form-control" placeholder="ایمیل (اختیاری)"
                                       <?php if (Auth::check()) echo 'disabled' ?>
                                       value="<?php if (Auth::check()) echo Auth::user()->email; ?>"/>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pull-right"
                                 style="margin-bottom: 10px;">
                            <textarea required class="form-control" name="text" id="text"
                                      placeholder="متن دیدگاه (الزامی)"
                                      style="max-width: 690px;min-height: 200px;"></textarea>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                <input type="submit" class="btn btn-primary pull-left" value="ثبت دیدگاه"/>
                            </div>
                        </div>
                    </form>
                </div>
            @else
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="text-align: center">
                    <p>{{'برای ثبت دیدگاه وارد شوید.'}}</p>
                </div>
            @endif
        </div>
    </div>


    <script src="{{url('js/jquery-1.10.2.min.js')}}"></script>
    <script src="{{url('js/jquery.cookie.js')}}"></script>
    <script src="{{url('js/bootstrap/bootstrap.min.js')}}"></script>

    <script>
        //Start CRUD Cookie
        var $NoConflict = jQuery.noConflict();
        var temp = "";
        var cookieIsExist = "";
        function SetShoppingCart(id) {
            if (typeof($NoConflict.cookie("ShoopingCart")) !== "undefined") {
                cookieIsExist = $NoConflict.cookie("ShoopingCart").split(',');
                if (cookieIsExist.indexOf(id.toString()) > -1) {
                    alert('قبلا به سبد خرید اضافه شده است!');
                }
                else {
                    temp = $NoConflict.cookie("ShoopingCart") + ',' + id;
                    $NoConflict.cookie("ShoopingCart", temp, {expires: 10});
                }
            }
            else {
                temp = id;
                $NoConflict.cookie("ShoopingCart", temp, {expires: 10, path: '/'});
            }


            //Update Conter of shopping cart
            var counter = $NoConflict.cookie("ShoopingCart").split(',');
            var ShoppingCartCounter = parseInt(counter.length - 1) + 1;
            $("#ShoppingCartCounterSmall").text(ShoppingCartCounter);
            $("#ShoppingCartCounterBig").text(ShoppingCartCounter);
        }

        function GetShoppingCart() {
            alert($NoConflict.cookie("ShoopingCart"));
        }

        //End CRUD Cookie
    </script>

@endsection