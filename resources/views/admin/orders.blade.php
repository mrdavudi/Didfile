<?php
use Illuminate\Support\Facades\Input;
use App\category;
$Order = \App\order::paginate(15);

if (isset($SearchOrder)) {
    $Order = $SearchOrder;
}
?>

@if(\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->admin == '1')
    @extends('admin.master.AdminMaster')

@section('title')
    لیست سفارشات
@endsection

@section('header')
    <!-- =css for admin panel -->
    <link rel="stylesheet" type="text/css" href="{{url('css/admin.css')}}"/>

    <link rel="stylesheet" type="text/css" href="{{url('css/Tables.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{url('css/SmallTables.css')}}"/>

    <link rel="stylesheet" type="text/css" href="{{url('css/category.css')}}"/>
@endsection


@section('MainContent')

    <div class="editcategoryContent">

        <div class="row" style="direction: rtl;">
            <div class="col-lg-12 col-md-12 col-sm-12 pull-right">
                <h1 class="page-header visible-lg visible-md visible-sm" style="margin-top:0; padding-top:0;">لیست
                    سفارشات</h1>
                <h2 class="page-header visible-xs">لیست سفارشات - {{ 'سلام ' . \Illuminate\Support\Facades\Auth::user()->name}}</h2>
            </div>
        </div>


        <div class="Table">

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($error->all() as $error)
                            <li>
                                <?php
                                $error = str_replace('search order', 'فیلد جستجو', $error);
                                echo $error;
                                ?>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="row" style="background: transparent;padding-right: 0;">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pull-right"
                     style="padding-right: 0;padding-left: 0;">
                    <div>
                        <form action="{{url('admin/searchOrder')}}" method="post">
                            {{csrf_field()}}

                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 pull-right" style="padding-right: 0;">
                                <div class="form-group" style="max-width: 300px;">
                                    <div class="input-group" style="direction: ltr;">
                                        <input type="text" class="form-control" name="search_order"
                                               required placeholder="جستجو..." value="{{Input::get('search_order')}}"
                                               style="direction: rtl;"/>

                                        <div class="input-group-addon">
                                            <i class="fa fa-search"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 pull-right" style="margin-bottom: 10px;">
                                <select class="form-control" name="search_with"
                                        style="display: inline;padding: 0;padding-right: 5px;max-width: 200px;">
                                    <option value="0" disabled selected>جستجو براساس</option>
                                    <option
                                        <?php if (Input::get('search_with') == 'price') echo 'selected' ?> value="price">
                                        قیمت
                                    </option>
                                    <option
                                        <?php if (Input::get('search_with') == 'orderDate') echo 'selected' ?> value="orderDate">
                                        تاریخ
                                    </option>
                                </select>
                            </div>

                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 pull-right" style="direction: rtl;">
                                <input type="submit" class="btn btn-primary" value="جستجو" style="display: inline;"/>
                            </div>

                            <div class="col-lg-3" style="direction: ltr;padding: 0;">
                                <?php
                                if (!isset($SearchOrder)) {
                                    echo $Order->links();
                                }
                                ?>
                            </div>

                        </form>
                    </div>
                </div>


            </div>


            @foreach($Order as $temp)

                <div class="visible-xs SmallTable">

                    <div class="row">
                        <div class="col-xs-4 pull-right SmallTitle">شماره فاکتور</div>
                        <div class="col-xs-8 pull-right SmallContent">
                            {{ $temp->FactorNum }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-4 pull-right SmallTitle">محصول</div>
                        <div class="col-xs-8 pull-right SmallContent">
                            {{ $temp->product->title }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-4 pull-right SmallTitle">مشتری</div>
                        <div class="col-xs-8 pull-right SmallContent">
                            {{ $temp->user->name . ' ' . $temp->user->family }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-4 pull-right SmallTitle">فروشنده</div>
                        <div class="col-xs-8 pull-right SmallContent">
                            {{ $temp->seller->name . ' ' . $temp->seller->family }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-4 pull-right SmallTitle">درگاه پرداخت</div>
                        <div class="col-xs-8 pull-right SmallContent">
                            {{ $temp->bank->name }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-4 pull-right SmallTitle">تاریخ</div>
                        <div class="col-xs-8 pull-right SmallContent">
                            {{ $temp->orderDate }}
                        </div>
                    </div>

                    <div class="row" style="text-align: center;">
                        <div class="col-xs-12 pull-right" style="background: #fff;padding: 0;">
                            <a href="#" onclick="OrderDetail({{$temp->id}})"
                               data-toggle="modal"
                               data-target="#exampleModalCenter"
                               style="display: block;background: #B6D1EF; color: #4B98F3; padding: 10px;text-decoration: none">
                                {{'مشاهده جزئیات بیشتر'}}
                            </a>

                        </div>
                    </div>

                </div>
            @endforeach

            <div class="hidden-xs">
                <div class="row tableTitle">
                    <div class="col-lg-2 co2-md-2 col-sm-2 pull-right">شماره فاکتور</div>
                    <div class="col-lg-2 co2-md-2 col-sm-2 pull-right">محصول</div>
                    <div class="col-lg-2 col-md-2 col-sm-2 pull-right">مشتری</div>
                    <div class="col-lg-2 col-md-2 col-sm-2 pull-right">فروشنده</div>
                    <div class="col-lg-1 col-md-1 col-sm-1 pull-right">درگاه پرداخت</div>
                    <div class="col-lg-2 col-md-2 col-sm-2 pull-right">تاریخ</div>
                </div>

                @foreach($Order as $temp)

                    <div class="row tableContent mainCategory">
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-1 pull-right">
                            {{$temp->FactorNum}}
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-1 pull-right">
                            {{$temp->product->title}}
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-3 pull-right">
                            {{$temp->user->name . ' ' . $temp->user->family}}
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 pull-right">
                            {{$temp->seller->name . ' ' . $temp->seller->family}}
                        </div>
                        <div class="col-lg-1 col-md-1 col-sm-1 pull-right">
                            {{$temp->bank->name}}
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2 pull-right">
                            {{$temp->orderDate}}
                        </div>

                        <br/>

                        <div class="col-lg-12 col-md-12 col-sm-12" style="padding: 0;">
                            <a href="#" onclick="OrderDetail({{$temp->id}})"
                               data-toggle="modal"
                               data-target="#exampleModalCenter">
                                {{'مشاهده جزئیات بیشتر'}}
                            </a>
                        </div>

                    </div>


                @endforeach
            </div>

            <!-- Modal -->
            <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
                 aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">مشاهده جزئیات سفارش</h5>
                        </div>
                        <div class="modal-body">
                            <div class="SmallTable">
                                <div class="row">
                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 pull-right SamllTitle">موبایل مشتری
                                    </div>
                                    <div id="UserMobile"
                                         class="col-lg-9 col-md-9 col-sm-9 col-xs-9 pull-right SmallContent">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 pull-right SamllTitle">ایمیل مشتری
                                    </div>
                                    <div id="UserEmail"
                                         class="col-lg-9 col-md-9 col-sm-9 col-xs-9 pull-right SmallContent">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 pull-right SamllTitle">موبایل
                                        فروشنده
                                    </div>
                                    <div id="SellerMobile"
                                         class="col-lg-9 col-md-9 col-sm-9 col-xs-9 pull-right SmallContent">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 pull-right SamllTitle">ایمیل
                                        فروشنده
                                    </div>
                                    <div id="SellerEmail"
                                         class="col-lg-9 col-md-9 col-sm-9 col-xs-9 pull-right SmallContent">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 pull-right SamllTitle">
                                        {{'قیمت واحد'}}
                                    </div>
                                    <div id="price"
                                         class="col-lg-9 col-md-9 col-sm-9 col-xs-9 pull-right SmallContent">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 pull-right SamllTitle">
                                        {{'تخفیف'}}
                                    </div>
                                    <div id="coupon"
                                         class="col-lg-9 col-md-9 col-sm-9 col-xs-9 pull-right SmallContent">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 pull-right SamllTitle">
                                        {{'قیمت کل'}}
                                    </div>
                                    <div id="totalPrice"
                                         class="col-lg-9 col-md-9 col-sm-9 col-xs-9 pull-right SmallContent">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal" style="width: 80px;">بستن
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>


        <div style="direction: ltr;text-align: left;margin-top: 50px;">
            <?php
            if (!isset($SearchOrder)) {
                echo $Order->links();
            }
            ?>
        </div>

    </div>

    <script src="{{url('js/jquery-1.10.2.min.js')}}"></script>

    <script>
        function OrderDetail(id) {

            $.ajax({
                type: "POST",
                url: '/admin/orderDetail',
                data: {id: id, _token: "{{ csrf_token() }}"},
                success: function (msg) {
                    var Orders = msg.split(',');

                    //customer Info
                    $('#UserMobile').html(Orders[1]);
                    $('#UserEmail').html(Orders[0]);

                    //Seller Info
                    $('#SellerMobile').html(Orders[3]);
                    $('#SellerEmail').html(Orders[2]);

                    //price
                    $('#price').html(Orders[4]);

                    //totalPrice
                    $('#totalPrice').html(Orders[5]);

                    //Coupon
                    $('#coupon').html(Orders[6]);

                }
            });
        }


    </script>

@endsection


@else
    <script>window.location.href = "/" </script>
@endif