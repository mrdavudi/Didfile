@extends('client.master.master')


@section('title')
    DidFile.ir
@endsection

@section('content')
    <div class="container" style="margin-top: 30px;margin-bottom: 30px;">


    <?php
    $checkIfSerachHasResult = '';

    $product = \App\product::where('categoryId',$category)->paginate(4);

    if(!empty($product)){

    ?>


    <!-- Start Product Box-->
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
                <!-- End Product Box -->
                @php $checkIfSerachHasResult = $temp->title @endphp
            @endforeach

            <?php
            }

            if($checkIfSerachHasResult == ""){
            ?>
            <div class="alert alert-danger" style="direction: rtl; margin-top: 30px; margin-bottom: 30px;">
                {{'موردی یافت نشد...'}}
            </div>

            <?php
            }
            ?>

            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                {{ $product->links() }}
            </div>
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


