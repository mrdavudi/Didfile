<?php
use Illuminate\Support\Facades\Input;
use App\category;
$Users = \App\User::paginate(15);

if (isset($SearchUser)) {
    $Users = $SearchUser;
}
?>

@if(\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->admin == '1')

@extends('admin.master.AdminMaster')

@section('title')
    لیست کاربران
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
                    کاربران</h1>
                <h2 class="page-header visible-xs">لیست کاربران - {{ 'سلام ' . \Illuminate\Support\Facades\Auth::user()->name}}</h2>
            </div>
        </div>


        <div class="Table">

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($error->all() as $error)
                            <li>
                                <?php
                                $error = str_replace('search user', 'فیلد جستجو', $error);
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
                        <form action="{{url('admin/searchUser')}}" method="post">
                            {{csrf_field()}}

                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 pull-right" style="padding-right: 0;">
                                <div class="form-group" style="max-width: 300px;">
                                    <div class="input-group" style="direction: ltr;">
                                        <input type="text" class="form-control" name="search_user"
                                               required placeholder="جستجو..." value="{{Input::get('search_user')}}"
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
                                        <?php if (Input::get('search_with') == 'name') echo 'selected' ?> value="name">
                                        نام
                                    </option>
                                    <option
                                        <?php if (Input::get('search_with') == 'family') echo 'selected' ?> value="family">
                                        نام خانوادگی
                                    </option>

                                    <option
                                        <?php if (Input::get('search_with') == 'phone') echo 'selected' ?> value="phone">
                                        موبایل
                                    </option>

                                    <option
                                        <?php if (Input::get('search_with') == 'email') echo 'selected' ?> value="email">
                                        ایمیل
                                    </option>
                                </select>
                            </div>

                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 pull-right" style="direction: rtl;">
                                <input type="submit" class="btn btn-primary" value="جستجو" style="display: inline;"/>
                            </div>

                            <div class="col-lg-3" style="direction: ltr;padding: 0;">
                                <?php
                                if (!isset($SearchUser)) {
                                    echo $Users->links();
                                }
                                ?>
                            </div>

                        </form>
                    </div>
                </div>


            </div>


            @foreach($Users as $temp)

                <div class="visible-xs SmallTable">
                    <div class="row">
                        <div class="col-xs-4 pull-right SmallTitle">نام و نام خانوادگی</div>
                        <div class="col-xs-8 pull-right SmallContent">
                            {{ $temp->name . ' ' . $temp->family }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-4 pull-right SmallTitle">موبایل</div>
                        <div class="col-xs-8 pull-right SmallContent">
                            {{ $temp->phone }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-4 pull-right SmallTitle">ایمیل</div>
                        <div class="col-xs-8 pull-right SmallContent">
                            {{ $temp->email }}
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="hidden-xs">
                <div class="row tableTitle">
                    <div class="col-lg-3 col-md-3 col-sm-3 pull-right">نام و نام خانوادگی</div>
                    <div class="col-lg-3 co3-md-3 col-sm-3 pull-right">موبایل</div>
                    <div class="col-lg-3 co3-md-3 col-sm-3 pull-right">ایمیل</div>
                </div>

                @foreach($Users as $temp)

                    <div class="row tableContent mainCategory">
                        <div class="col-lg-3 col-md-3 col-sm-3 pull-right">
                            {{$temp->name . ' ' . $temp->family}}
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 pull-right">
                            {{$temp->phone}}
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 pull-right">
                            {{$temp->email}}
                        </div>
                    </div>


                @endforeach
            </div>
        </div>


        <div style="direction: ltr;text-align: left;margin-top: 50px;">
            <?php
            if (!isset($SearchUser)) {
                echo $Users->links();
            }
            ?>
        </div>

    </div>

@endsection

@else
    <script>window.location.href = "/" </script>
@endif