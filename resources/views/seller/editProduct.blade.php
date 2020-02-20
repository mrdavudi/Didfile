<?php
use Illuminate\Support\Facades\Input;
?>

@if(\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->seller == '1')

    <?php
    $Product = \App\product::where('userId',\Illuminate\Support\Facades\Auth::user()->id)->paginate(15);

    if (isset($SearchProduct)) {
        $Product = $SearchProduct;
    }

    ?>

    @extends('seller.master.AdminMaster')

@section('title')
    ویرایش محصول
@endsection

@section('header')
    <!-- =css for admin panel -->
    <link rel="stylesheet" type="text/css" href="{{url('css/admin.css')}}"/>

    <link rel="stylesheet" type="text/css" href="{{url('css/addProduct.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{url('css/Tables.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{url('css/SmallTables.css')}}"/>


@endsection


@section('MainContent')

    <div class="editProductContent">

        <div class="row" style="direction: rtl;">
            <div class="col-lg-12 col-md-12 col-sm-12 pull-right">
                <h1 class="page-header visible-lg visible-md visible-sm" style="margin-top:0; padding-top:0;">ویرایش
                    محصول</h1>
                <h2 class="page-header visible-xs">ویرایش محصول
                    - {{ 'سلام ' . \Illuminate\Support\Facades\Auth::user()->name}}</h2>
            </div>
        </div>


        <div class="Table">

            <div class="row" style="background: transparent;padding-right: 0;">

                @if($errors->any())
                    <div class="alert alert-danger" style="direction: rtl;">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>
                                    <?php
                                    $error = str_replace('search product', 'جستجو', $error);
                                    echo $error;
                                    ?>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if(\Illuminate\Support\Facades\Session::has('error'))
                    <div class="alert alert-danger" style="direction: rtl;">
                        {{\Illuminate\Support\Facades\Session::get('error')}}
                    </div>
                @endif

                @if(\Illuminate\Support\Facades\Session::has('deleteStatus'))
                    @if(\Illuminate\Support\Facades\Session::get('deleteStatus') == 'true')
                        <div class="alert alert-success" style="direction: rtl;">
                            {{'محصول با موفقیت حذف گردید!'}}
                        </div>
                    @else
                        <div class="alert alert-danger" style="direction: rtl;">
                            {{'در هنگام حذف محصول خطایی رخ داد؛ دوباره تلاش کنید!'}}
                        </div>
                    @endif
                @endif
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pull-right"
                     style="padding-right: 0;padding-left: 0;">
                    <div>
                        <form action="{{url('seller/searchProduct')}}" method="post">
                            {{csrf_field()}}

                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 pull-right" style="padding-right: 0;">
                                <div class="form-group" style="max-width: 300px;">
                                    <div class="input-group" style="direction: ltr;">
                                        <input type="text" class="form-control" name="search_product"
                                               required placeholder="جستجو..." value="{{Input::get('search_product')}}"
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
                                    <option value="title" <?php if (Input::get('search_with') == 'title') echo ' selected ' ?> >
                                        نام محصول
                                    </option>
                                    <option value="price" <?php if (Input::get('search_with') == 'price') echo ' selected ' ?> >
                                        قیمت
                                    </option>
                                </select>
                            </div>

                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 pull-right" style="direction: rtl;">
                                <input type="submit" class="btn btn-primary" value="جستجو" style="display: inline;"/>
                            </div>

                            <div class="col-lg-3" style="direction: ltr;padding: 0;">
                                <?php
                                if (!isset($SearchProduct)) {
                                    echo $Product->links();
                                }
                                ?>
                            </div>

                        </form>
                    </div>
                </div>


            </div>


            @foreach($Product as $temp)
                <div class="visible-xs SmallTable">
                    <div class="row">
                        <div class="col-xs-4 pull-right SmallTitle">عنوان</div>
                        <div class="col-xs-8 pull-right SmallContent">
                            {{$temp->title}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-4 pull-right SmallTitle">فروشنده</div>
                        <div class="col-xs-8 pull-right SmallContent">
                            {{$temp->user->name . ' ' . $temp->user->family}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-4 pull-right SmallTitle">دسته ها</div>
                        <div class="col-xs-8 pull-right SmallContent">
                            {{$temp->category->categoryName}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-4 pull-right SmallTitle">سطح</div>
                        <div class="col-xs-8 pull-right SmallContent">
                            {{$temp->level}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-4 pull-right SmallTitle">قیمت</div>
                        <div class="col-xs-8 pull-right SmallContent">
                            {{$temp->price}}
                        </div>
                    </div>
                    <div class="row" style="text-align: center;">
                        <div class="col-xs-4 pull-right" style="background: #fff;padding: 0;">
                            <a href="{{url('seller/editProduct-sub' . $temp->id )}}"
                               style="display: block;background: #B6D1EF; color: #4B98F3; padding: 10px;">
                                <i class="fa fa-edit"></i>
                            </a>
                        </div>
                        <div class="col-xs-4 pull-right" style="background: #fff;padding: 0;">
                            <a href="#" onclick="getId({{$temp->id}})" data-toggle="modal"
                               data-target="#exampleModalCenter"
                               style=" background: #FFDBDB;color: #E95256 ;display: block;padding: 10px;">
                                <i class="fa fa-trash"></i>
                            </a>
                        </div>
                        <div class="col-xs-4 pull-right" style="background: #fff;padding: 0;">
                            <a href="{{url('productDetail' . $temp->id )}}"
                               style="background: #F7FFF7; color: #4CAF82; display: block;padding: 10px;">
                                <i class="fa fa-eye"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach


            <div class="hidden-xs">
                <div class="row tableTitle">
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 pull-right">نام محصول</div>
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 pull-right">فروشنده</div>
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 pull-right">دسته ها</div>
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 pull-right">سطح</div>
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 pull-right">قیمت</div>
                </div>

                @foreach($Product as $temp)
                    <div class="row tableContent">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 pull-right">
                            {{$temp->title}}
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 pull-right">
                            {{$temp->user->name . ' ' . $temp->user->family}}
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 pull-right">
                            {{$temp->category->categoryName}}
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 pull-right">
                            {{$temp->level}}
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 pull-right">
                            {{$temp->price}}
                        </div>

                        <br/>

                        <div class="col-lg-12 col-md-12 col-sm-12" style="padding: 0;">
                            <a href="{{url('seller/editProduct-sub' . $temp->id )}}">ویرایش</a>
                            <a href="#" onclick="getId({{$temp->id}})" data-toggle="modal"
                               data-target="#exampleModalCenter">حذف</a>
                            <a href="{{url('productDetail' . $temp->id )}}">مشاهده</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div style="direction: ltr;text-align: left;margin-top: 50px;">
            <?php
            if (!isset($SearchProduct)) {
                echo $Product->links();
            }
            ?>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">حذف محصول</h5>
                    </div>
                    <div class="modal-body">
                        {{'آیا از حذف این محصول اطمینان دارید؟'}}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" data-dismiss="modal" style="width: 80px;">خیر
                        </button>
                        <button type="button" class="btn btn-danger" style="width: 80px;"
                                onclick="deleteProduct({{'1'}})">بله
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script>

        var ProductId = 0;

        function getId(id) {
            ProductId = id;
        }

        function deleteProduct(confirmId) {
            if (confirmId == '1') {
                window.location.href = 'deleteProduct' + ProductId;
            }
        }

    </script>

@endsection

@else
    <script>window.location.href = "/" </script>
@endif