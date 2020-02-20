<?php
use Illuminate\Support\Facades\Input;
use App\category;
$EmailInfo = \App\emailnews::paginate(15);

if (isset($SearchEmailInfo)) {
    $EmailInfo = $SearchEmailInfo;
}

?>


@if(\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->admin == '1')
@extends('admin.master.AdminMaster')

@section('title')
    لیست کاربران عضو خبرنامه
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
                    کاربران عضو خبرنامه</h1>
                <h2 class="page-header visible-xs">لیست کاربران عضو خبرنامه - {{ 'سلام ' . \Illuminate\Support\Facades\Auth::user()->name}}</h2>
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
                                    $error = str_replace('search email', 'جستجو', $error);
                                    echo $error;
                                    ?>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if(\Illuminate\Support\Facades\Session::has('message'))
                    @if(\Illuminate\Support\Facades\Session::get('message') == 'true')
                        <div class="alert alert-success" style="direction: rtl;">
                            {{'کاربر با موفقیت از خبرنامه حذف گردید!'}}
                        </div>
                    @else
                        <div class="alert alert-danger" style="direction: rtl;">
                            {{'در هنگام حذف کاربر از خبرنامه خطایی رخ داد؛ دوباره تلاش کنید!'}}
                        </div>
                    @endif
                @endif
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pull-right"
                     style="padding-right: 0;padding-left: 0;">
                    <div>
                        <form action="{{url('admin/searchUserEmail')}}" method="post">
                            {{csrf_field()}}

                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 pull-right" style="padding-right: 0;">
                                <div class="form-group" style="max-width: 300px;">
                                    <div class="input-group" style="direction: ltr;">
                                        <input type="text" class="form-control" name="search_email"
                                               required placeholder="جستجو..." value="{{Input::get('search_email')}}"
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
                                    <option <?php if(Input::get('search_with') == 'name') echo 'selected' ?> value="name">نام</option>
                                    <option <?php if(Input::get('search_with') == 'family') echo 'selected' ?> value="family">نام خانوادگی</option>
                                    <option <?php if(Input::get('search_with') == 'phone') echo 'selected' ?> value="phone">موبایل</option>
                                    <option <?php if(Input::get('search_with') == 'email') echo 'selected' ?> value="email">ایمیل</option>
                                </select>
                            </div>

                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 pull-right" style="direction: rtl;">
                                <input type="submit" class="btn btn-primary" value="جستجو" style="display: inline;"/>
                            </div>

                            <div class="col-lg-3" style="direction: ltr;padding: 0;">
                                <?php
                                if (!isset($SearchEmailInfo)) {
                                    echo $EmailInfo->links();
                                }
                                ?>
                            </div>

                        </form>
                    </div>
                </div>


            </div>


            @foreach($EmailInfo as $temp)

                <div class="visible-xs SmallTable">
                    <div class="row">
                        <div class="col-xs-4 pull-right SmallTitle">نام و نام خانوادگی</div>
                        <div class="col-xs-8 pull-right SmallContent">
                            {{ $temp->user->name . ' ' . $temp->user->family }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-4 pull-right SmallTitle">موبایل</div>
                        <div class="col-xs-8 pull-right SmallContent">
                            {{ $temp->user->phone }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-4 pull-right SmallTitle">ایمیل</div>
                        <div class="col-xs-8 pull-right SmallContent">
                            {{ $temp->user->email }}
                        </div>
                    </div>

                    <div class="row" style="text-align: center;">
                        <div class="col-xs-12 pull-right" style="background: #fff;padding: 0;">
                            <a href="#" onclick="getId({{$temp->userId}})" data-toggle="modal"
                               data-target="#exampleModalCenter"
                               style=" background: #FFDBDB;color: #E95256 ;display: block;padding: 10px;text-decoration: none;">
                                <i class="fa fa-trash"></i>
                                {{'حذف کاربر از لیست'}}
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="hidden-xs">
                <div class="row tableTitle">
                    <div class="col-lg-3 col-md-3 col-sm-3 pull-right">نام و نام خانوداگی</div>
                    <div class="col-lg-3 col-md-3 col-sm-3 pull-right">موبایل</div>
                    <div class="col-lg-3 col-md-3 col-sm-3 pull-right">ایمیل</div>
                </div>


                @foreach($EmailInfo as $temp)

                    <div class="row tableContent mainCategory">
                        <div class="col-lg-3 col-md-3 col-sm-3 pull-right">
                            {{ $temp->user->name . ' ' . $temp->user->family }}
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 pull-right">
                            {{ $temp->user->phone }}
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 pull-right">
                            {{ $temp->user->email }}
                        </div>

                        <br/>

                        <div class="col-lg-12 col-md-12 col-sm-12" style="padding: 0;">
                            <a href="#" onclick="getId({{$temp->userId}})" data-toggle="modal"
                               data-target="#exampleModalCenter"
                               style="text-decoration: none;">
                                {{'حذف کاربر از لیست'}}
                            </a>
                        </div>
                    </div>

                @endforeach
            </div>
        </div>


        <div style="direction: ltr;text-align: left;margin-top: 50px;">
            <?php
            if (!isset($SearchEmailInfo)) {
                echo $EmailInfo->links();
            }
            ?>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">حذف کاربر از خبرنامه</h5>
                    </div>
                    <div class="modal-body">
                        <span>
                            {{'آیا از حذف کاربر از خبرنامه اطمینان دارید؟'}}
                        </span>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" data-dismiss="modal" style="width: 80px;">خیر
                        </button>
                        <button type="button" class="btn btn-danger" style="width: 80px;"
                                onclick="deleteCategory({{'1'}})">بله
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script>

        var UserEmailId = 0;

        function getId(id) {
            UserEmailId = id;
        }

        function deleteCategory(confirmId) {
            if (confirmId == '1') {
                window.location.href = 'deleteUserEmail' + UserEmailId;
            }
        }

    </script>

@endsection

@else
    <script>window.location.href = "/" </script>
@endif