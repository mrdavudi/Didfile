@extends('client.master.master')


@section('title')
    DidFile.ir
@endsection

@section('content')

    <div style="padding: 50px;direction: rtl;">
        <!-- Start Product Box newest -->
        <div class="row text-header">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"
                 style="padding: 0;text-align: center;">
                <h2 style="margin-top: 20px;">
                    {{'جدید ترین ها'}}
                </h2>
            </div>
        </div>

        <?php
        $product = \App\product::orderBy('price')->take(8)->get();
        ?>


        <div class="row">
            @foreach($product as $temp)
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 product_box_Column">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding: 0;">
                        <img src="{{$temp->path_image}}" class="img-responsive"/>
                    </div>

                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding: 0;height: 70px;">
                        <h5 style="text-align: right;padding: 5px;">{{$temp['title']}}</h5>
                    </div>

                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <p style="color: #9db969;">{{  number_format($temp["price"], 0 , ',' , '.') . ' تومان'}}</p>

                        <button title="افزودن به سبد خرید" type="button" data-toggle="modal" data-target="#myModal"
                                onclick="SetShoppingCart({{$temp['id']}})" class="btn btn-info">

                            <i class="fa fa-shopping-cart"></i>
                        </button>

                        <a href="{{url('productDetail') . $temp->id}}" title="مشاهده جزئیات" class="btn btn-default">
                            <i class="fa fa-eye"></i>
                        </a>
                    </div>
                </div>
            @endforeach
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pull-left" style="text-align: left">
                <a href="{{url('moreProduct0')}}" class="btn btn-default">
                    <i class="fa fa-arrow-left"></i>
                    {{'ادامه...'}}
                </a>
            </div>
        </div>
        <!-- End Product Box newest -->


        <!-- Start Product Box more order -->

        <div class="row text-header">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"
                 style="padding: 0;">
                <h2>
                    {{'پرفروش ترین ها'}}
                </h2>
            </div>
        </div>

    <?php
    $product = \App\order::select('products.*', DB::raw('count(orders.productId) as MostCount'))
        ->join('products', 'products.id', '=', 'orders.productId')
        ->groupBy('orders.productId')
        ->orderBy('MostCount', 'desc')
        ->take(8)
        ->get();

    $producsId = [];
    for ($i = 0; $i < count($product); $i++) {
        $producsId[$i] = $product[$i]->id;
    }

    ?>

    <!-- Start Product Box -->
        <div class="row">
            @foreach($product as $temp)
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 product_box_Column">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding: 0;">
                        <img src="{{$temp->path_image}}" class="img-responsive"/>
                    </div>

                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding: 0;height: 70px;">
                        <h5 style="text-align: right;padding: 5px;">{{$temp['title']}}</h5>
                    </div>

                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <p style="color: #9db969;">{{  number_format($temp["price"], 0 , ',' , '.') . ' تومان'}}</p>

                        <button title="افزودن به سبد خرید" type="button" data-toggle="modal" data-target="#myModal"
                                onclick="SetShoppingCart({{$temp['id']}})" class="btn btn-info">

                            <i class="fa fa-shopping-cart"></i>
                        </button>

                        <a href="{{url('productDetail' . $temp->id)}}" title="مشاهده جزئیات" class="btn btn-default">
                            <i class="fa fa-eye"></i>
                        </a>
                    </div>
                </div>
            @endforeach
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pull-left" style="text-align: left">
                <a href="{{url('moreProduct1')}}" class="btn btn-default">
                    <i class="fa fa-arrow-left"></i>
                    {{'ادامه...'}}
                </a>
            </div>
        </div>
    </div>
    <!-- Start Product Box more order -->


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


