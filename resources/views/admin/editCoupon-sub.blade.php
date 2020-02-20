<?php
$Coupon = \App\coupon::find($id);
?>


@if(\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->admin == '1')
@extends('admin.master.AdminMaster')

@section('title')
    ویرایش کوپن تخفیف
@endsection

@section('header')
    <!-- =css for admin panel -->
    <link rel="stylesheet" type="text/css" href="{{url('css/admin.css')}}"/>

    <link rel="stylesheet" href="{{url('css/select2/css/select2.min.css')}}"/>
@endsection


@section('MainContent')

    <div style="margin: 20px 20px 0 0;">

        <div class="row" style="direction: rtl;">
            <div class="col-lg-12 col-md-12 col-sm-12 pull-right">
                <h1 class="page-header visible-lg visible-md visible-sm" style="margin-top:0; padding-top:0;">ویرایش
                    کوپن تخفیف</h1>
                <h2 class="page-header visible-xs">ویرایش کوپن تخفیف - {{ 'سلام ' . \Illuminate\Support\Facades\Auth::user()->name}}</h2>
            </div>
        </div>

        <div class="row" style="direction: rtl;">

            @if($errors->any())
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pull-right" style="max-width: 600px;">
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>
                                    <?php
                                    $error = str_replace('products', 'محصول', $error);
                                    $error = str_replace('coupon code', 'کد کوپن', $error);
                                    $error = str_replace('coupon price', 'مبلغ تخفیف', $error);
                                    echo $error;
                                    ?>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pull-right" style="max-width: 600px;">
                @if(\Illuminate\Support\Facades\Session::has('editStatus'))
                    @if(\Illuminate\Support\Facades\Session::get('editStatus') == 'true')
                        <div class="alert alert-success">
                            {{'ویرایش کوپن تخفیف با موفقیت ثبت شد.'}}
                        </div>

                    @else
                        <div class="alert alert-danger">
                            {{'کوپن وارد شده قبلا ثبت شده است!'}}
                        </div>
                    @endif
                @endif
            </div>
        </div>


        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 pull-right" style="direction: rtl;text-align: right">
                <form action="{{url('admin/editCoupon-sub')}}" method="post"
                      style="text-align: right;max-width: 300px;">
                    {{csrf_field()}}

                    <input type="hidden" value="{{$Coupon->id}}" name="id"/>

                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group" style="direction: ltr">
                            <div class="input-group">
                                <input type="text" class="form-control" name="couponCode"
                                       required placeholder="کوپن..." value="{{$Coupon->code}}"
                                       style="direction: rtl;"/>

                                <div class="input-group-addon">
                                    <i class="fa fa-tags"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group" style="direction: ltr">
                            <div class="input-group">
                                <input type="text" class="form-control" name="couponPrice"
                                       required placeholder="مبلغ تخفیف (تومان)" value="{{$Coupon->price}}"
                                       style="direction: rtl;"/>

                                <div class="input-group-addon">
                                    <i class="fa fa-money"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <select class="js-example-basic-multiple pull-right form-control" name="products[]"
                                multiple="multiple"
                                required
                                style="direction: rtl;">

                            <?php
                            $ProductId = explode(',', $Coupon->productId);

                            $Products = \App\product::all();
                            ?>

                            @foreach($Products as $temp)

                                <option <?php
                                        foreach ($ProductId as $ProductsId) {
                                            if ($temp->id == $ProductsId) echo 'selected';
                                        }
                                        ?> value="{{$temp->id}}">{{$temp->title}}</option>

                            @endforeach
                        </select>
                    </div>


                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top: 20px;">
                        <input type="submit" class="btn btn-success" value="افزودن دسته"/>
                        <a href="{{url('admin/editCoupon')}}" class="btn btn-danger">برگشت</a>
                    </div>

                </form>
            </div>
        </div>
    </div>


    <script src="{{url('js/jquery-1.10.2.min.js')}}"></script>
    <script src="{{url('js/select2/js/select2.min.js')}}"></script>

    <script>
        $(".js-example-basic-multiple").select2({
            placeholder: "کالا (ها) را انتخاب کنید...",
            dir: "rtl"
        });


    </script>

@endsection

@else
    <script>window.location.href = "/" </script>
@endif