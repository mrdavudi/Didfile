<?php
$Coupon = \App\coupon::paginate(15);
if (isset($CouponSearch)) {
    $Coupon = $CouponSearch;
}
$Product = "";
?>


@if(\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->admin == '1')
    @extends('admin.master.AdminMaster')

@section('title')
    ویرایش کوپن
@endsection

@section('header')
    <link rel="stylesheet" type="text/css" href="{{url('css/admin.css')}}"/>

    <link rel="stylesheet" type="text/css" href="{{url('css/Tables.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{url('css/SmallTables.css')}}"/>

    <link rel="stylesheet" type="text/css" href="{{url('css/category.css')}}"/>

@endsection


@section('MainContent')

    <div class="editcategoryContent">

        <div class="row" style="direction: rtl;">
            <div class="col-lg-12 col-md-12 col-sm-12 pull-right">
                <h1 class="page-header visible-lg visible-md visible-sm" style="margin-top:0; padding-top:0;">ویرایش
                    کوپن</h1>
                <h2 class="page-header visible-xs">ویرایش کوپن - {{ 'سلام ' . \Illuminate\Support\Facades\Auth::user()->name}}</h2>
            </div>
        </div>


        <div class="Table">

            @if(\Illuminate\Support\Facades\Session::has('deleteStatus'))
                @if(\Illuminate\Support\Facades\Session::get('deleteStatus') == 'true')
                    <div class="alert alert-success" style="direction: rtl;">
                        {{'کوپن تخفیف به درستی حذف شد.'}}
                    </div>
                @else
                    <div class="alert alert-danger" style="direction: rtl;">
                        {{'در هنگام حذف موپن تخفیف خطایی رخ داد؛ دوباره تلاش کنید!'}}
                    </div>
                @endif
            @endif

            <div class="row" style="background: transparent;padding-right: 0;padding-left: 0;">


                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pull-right"
                     style="padding-right: 0;padding-left: 0;">
                    <div>
                        <form action="{{url('admin/searchCoupon')}}" method="post">
                            {{csrf_field()}}

                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 pull-right" style="padding-right: 0;">
                                <div class="form-group" style="max-width: 300px;">
                                    <div class="input-group" style="direction: ltr;">
                                        <input type="text" class="form-control" name="search_Coupon"
                                               required placeholder="جستجو..."
                                               value="{{\Illuminate\Support\Facades\Input::get('search_Coupon')}}"
                                               style="direction: rtl;"/>

                                        <div class="input-group-addon">
                                            <i class="fa fa-search"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 pull-right"
                                 style="margin-bottom: 10px;">
                                <select class="form-control" name="search_with"
                                        style="display: inline;padding: 0;padding-right: 5px;max-width: 200px;">
                                    <option value="0" disabled selected>جستجو براساس</option>
                                    <option value="categoryName">کد کوپن</option>
                                </select>
                            </div>

                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 pull-right" style="direction: rtl;">
                                <input type="submit" class="btn btn-primary" value="جستجو"
                                       style="display: inline;"/>
                            </div>

                            <div class="col-lg-3" style="direction: ltr;padding: 0;">
                                <?php
                                if (!isset($CouponSearch)) {
                                    echo $Coupon->links();
                                }
                                ?>
                            </div>

                        </form>
                    </div>
                </div>

            </div>


            @foreach($Coupon as $temp)
                <div class="visible-xs SmallTable">
                    <div class="row">
                        <div class="col-xs-4 pull-right SmallTitle">کد کوپن</div>
                        <div class="col-xs-8 pull-right SmallContent">
                            {{$temp->code}}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-4 pull-right SmallTitle">محصول (ها)</div>
                        <div class="col-xs-8 pull-right SmallContent">
                            <?php
                            $ProductId = explode(',', $temp->productId);

                            foreach ($ProductId as $products) {
                                $Product = $Product . \App\product::find($products)->title . ' ، ' . '<br/>';
                            }


                            echo $Product;
                            $Product = "";
                            ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-4 pull-right SmallTitle">قیمت تخفیف</div>
                        <div class="col-xs-8 pull-right SmallContent">
                            {{$temp->price}}
                        </div>
                    </div>
                    <div class="row" style="text-align: center;">
                        <div class="col-xs-6 pull-right" style="background: #fff;padding: 0;">
                            <a href="{{url('admin/editCoupon-sub' . $temp->id )}}"
                               style="display: block;background: #B6D1EF; color: #4B98F3; padding: 10px;">
                                <i class="fa fa-edit"></i>
                            </a>
                        </div>
                        <div class="col-xs-6 pull-right" style="background: #fff;padding: 0;">
                            <a href="#" onclick="getId({{$temp->id}})" data-toggle="modal"
                               data-target="#exampleModalCenter"
                               style=" background: #FFDBDB;color: #E95256 ;display: block;padding: 10px;">
                                <i class="fa fa-trash"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach


            <div class="hidden-xs">
                <div class="row tableTitle">
                    <div class="col-lg-4 col-md-4 col-sm-4 pull-right">کد کوپن</div>
                    <div class="col-lg-5 col-md-5 col-sm-5 pull-right">محصول (ها)</div>
                    <div class="col-lg-3 col-md-3 col-sm-3 pull-right">مبلغ تخفیف</div>
                </div>

                @foreach($Coupon as $temp)

                    <div class="row tableContent mainCategory">
                        <div class="col-lg-4 col-md-4 col-sm-4 pull-right">
                            {{$temp->code}}
                        </div>
                        <div class="col-lg-5 col-md-5 col-sm-5 pull-right">
                            <?php
                            $ProductId = explode(',', $temp->productId);

                            foreach ($ProductId as $products) {
                                $Product = $Product . \App\product::find($products)->title . ' ، ' . '<br/>';
                            }


                            echo $Product;
                            $Product = "";
                            ?>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 pull-right">
                            {{number_format($temp->price,0,',','.') . ' تومان'}}
                        </div>

                        <br/>

                        <div class="col-lg-12 col-md-12 col-sm-12" style="padding: 0;">
                            <a href="{{url('admin/editCoupon-sub' . $temp->id )}}">ویرایش</a>
                            <a href="#" onclick="getId({{$temp->id}})" data-toggle="modal"
                               data-target="#exampleModalCenter">حذف</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div style="direction: ltr;text-align: left;margin-top: 50px;">
            <?php
            if (!isset($CouponSearch)) {
                echo $Coupon->links();
            }
            ?>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalCenterTitle" aria-hidden="true" style="direction: rtl;">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">حذف کوپن</h5>
                    </div>
                    <div class="modal-body">
                        <span>
                            {{'آیا از حذف این کوپن اطمینان دارید؟'}}
                        </span>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" data-dismiss="modal" style="width: 80px;">خیر
                        </button>
                        <button type="button" class="btn btn-danger" style="width: 80px;"
                                onclick="deleteCoupon({{'1'}})">بله
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script>

        var CouponId = 0;

        function getId(id) {
            CouponId = id;
        }

        function deleteCoupon(confirmId) {
            if (confirmId == '1') {
                window.location.href = 'deleteCoupon' + CouponId;
            }
        }

    </script>

@endsection

@else
    <script>window.location.href = "/" </script>
@endif