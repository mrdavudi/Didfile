<?php
$Products = \App\product::all();
$Category = \App\category::where('sid', 0)->get();
?>


@if(\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->admin == '1')
    @extends('admin.master.AdminMaster')

@section('title')
    دسته بندی
@endsection

@section('header')
    <!-- =css for admin panel -->
    <link rel="stylesheet" type="text/css" href="{{url('css/admin.css')}}"/>

@endsection


@section('MainContent')

    <div style="margin: 20px 20px 0 0;">

        <div class="row" style="direction: rtl;">
            <div class="col-lg-12 col-md-12 col-sm-12 pull-right">
                <h1 class="page-header visible-lg visible-md visible-sm" style="margin-top:0; padding-top:0;">افزودن
                    دسته</h1>
                <h2 class="page-header visible-xs">افزودن دسته - {{ 'سلام ' . \Illuminate\Support\Facades\Auth::user()->name}}</h2>
            </div>
        </div>

        @if($errors->any())
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pull-right">
                    <div class="alert alert-danger" style="direction: rtl;">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>
                                    <?php
                                    $error = str_replace('category name', 'نام دسته', $error);
                                    $error = str_replace('sub category', 'زیر دسته', $error);
                                    echo $error;
                                    ?>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                </div>
            </div>
        @endif

        @if(\Illuminate\Support\Facades\Session::has('insertSuccess'))
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pull-right">
                    @if(\Illuminate\Support\Facades\Session::get('insertSuccess') == 'true')
                        <div class="alert alert-success" style="direction: rtl;">
                            {{'دسته بندی به درستی ثبت شد.'}}
                        </div>
                    @else
                        <div class="alert alert-danger" style="direction: rtl;">
                            {{'در هنگام ثبت دسته بندی مشکلی رخ داد؛ دوباره تلاش کنید.'}}
                        </div>
                    @endif

                </div>
            </div>
        @endif

        @if(\Illuminate\Support\Facades\Session::has('categoryExist'))
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pull-right">
                    <div class="alert alert-danger" style="direction: rtl;">
                        {{\Illuminate\Support\Facades\Session::get('categoryExist')}}
                    </div>

                </div>
            </div>
        @endif


        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 pull-right">
                <form action="{{url('admin/addCategory')}}" method="post" style="text-align: right">
                    {{csrf_field()}}

                    <div class="form-group">
                        <div class="input-group">
                            <input type="text" class="form-control" name="categoryName"
                                   required placeholder="نام دسته..." style="direction: rtl;"/>

                            <div class="input-group-addon">
                                <i class="fa fa-folder"></i>
                            </div>
                        </div>
                    </div>

                    <select class="form-control" name="subCategory" required
                            style="padding:0; direction:rtl; padding-right: 5px;text-align: right;">
                        <option selected disabled>دسته را مشخص کنید</option>
                        <option value="0">دسته مادر</option>
                        @foreach($Category as $temp)
                            <option value="{{$temp->id}}">{{$temp->categoryName}}</option>
                        @endforeach
                    </select>

                    <br/>

                    <input type="submit" class="btn btn-success" value="افزودن دسته"/>
                </form>
            </div>
        </div>
    </div>

@endsection

@else
    <script>window.location.href = "/" </script>
@endif