<?php
use Illuminate\Support\Facades\Input;
use App\category;
$category = \App\category::paginate(15);

if (isset($SearchCategory)) {
    $category = $SearchCategory;
}

$i = 0;
?>

@if(\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->admin == '1')

@extends('admin.master.AdminMaster')

@section('title')
    ویرایش دسته
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
                <h1 class="page-header visible-lg visible-md visible-sm" style="margin-top:0; padding-top:0;">ویرایش
                    دسته</h1>
                <h2 class="page-header visible-xs">ویرایش دسته - {{ 'سلام ' . \Illuminate\Support\Facades\Auth::user()->name}}</h2>
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
                                    $error = str_replace('search category', 'جستجو', $error);
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
                            {{'دسته با موفقیت حذف گردید!'}}
                        </div>
                    @else
                        <div class="alert alert-danger" style="direction: rtl;">
                            {{'در هنگام حذف دسته خطایی رخ داد؛ دوباره تلاش کنید!'}}
                        </div>
                    @endif
                @endif
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pull-right"
                     style="padding-right: 0;padding-left: 0;">
                    <div>
                        <form action="{{url('admin/searchCategory')}}" method="post">
                            {{csrf_field()}}

                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 pull-right" style="padding-right: 0;">
                                <div class="form-group" style="max-width: 300px;">
                                    <div class="input-group" style="direction: ltr;">
                                        <input type="text" class="form-control" name="search_category"
                                               required placeholder="جستجو..." value="{{Input::get('search_category')}}"
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
                                    <option value="categoryName">نام دسته</option>
                                </select>
                            </div>

                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 pull-right" style="direction: rtl;">
                                <input type="submit" class="btn btn-primary" value="جستجو" style="display: inline;"/>
                            </div>

                            <div class="col-lg-3" style="direction: ltr;padding: 0;">
                                <?php
                                if (!isset($SearchCategory)) {
                                    echo $category->links();
                                }
                                ?>
                            </div>

                        </form>
                    </div>
                </div>


            </div>


            @foreach($category as $temp)

                <?php
                $i++;
                ?>
                <div class="visible-xs SmallTable">
                    <div class="row">
                        <div class="col-xs-4 pull-right SmallTitle">ردیف</div>
                        <div class="col-xs-8 pull-right SmallContent">
                            {{ $i }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-4 pull-right SmallTitle">نام دسته</div>
                        <div class="col-xs-8 pull-right SmallContent">
                            {{$temp->categoryName}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-4 pull-right SmallTitle">زیردسته</div>
                        <div class="col-xs-8 pull-right SmallContent">
                            <?php

                            if ($temp->sid == 0) {
                                echo 'دسته مادر';
                            } elseif ($temp->sid != 0) {
                                $category_Sub = \App\category::find($temp->sid);

                                echo 'زیر دسته ی ' . $category_Sub->categoryName;
                            }
                            ?>
                        </div>
                    </div>
                    <div class="row" style="text-align: center;">
                        <div class="col-xs-4 pull-right" style="background: #fff;padding: 0;">
                            <a href="{{url('admin/editCategory-sub' . $temp->id )}}"
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
                    </div>
                </div>
            @endforeach

            <div class="hidden-xs">
                <div class="row tableTitle">
                    <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 pull-right">ردیف</div>
                    <div class="col-lg-2 col-md-2 col-sm-3 col-xs-3 pull-right">نام دسته</div>
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 pull-right">زیردسته</div>
                </div>

                <?php
                $i = 0;
                ?>

                @foreach($category as $temp)

                    <?php
                    $i++;
                    ?>

                    @if($temp->sid == 0)
                        <div class="row tableContent mainCategory">
                            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 pull-right">
                                {{$i}}
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-3 col-xs-3 pull-right">
                                {{$temp->categoryName}}
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 pull-right">
                                <?php

                                if ($temp->sid == 0) {
                                    echo 'دسته مادر';
                                } elseif ($temp->sid != 0) {
                                    $category_Sub = \App\category::find($temp->sid);

                                    echo 'زیر دسته ی ' . $category_Sub->categoryName;
                                }
                                ?>
                            </div>

                            <br/>

                            <div class="col-lg-12 col-md-12 col-sm-12" style="padding: 0;">
                                <a href="{{url('admin/editCategory-sub' . $temp->id )}}">ویرایش</a>
                                <a href="#" onclick="getId({{$temp->id}})" data-toggle="modal"
                                   data-target="#exampleModalCenter">حذف</a>
                            </div>
                        </div>


                        <?php
                        $categorySubShow = category::where('sid', $temp->id)->get();
                        ?>
                        @foreach($categorySubShow as $showSubCat)
                            <?php
                            $i++;
                            ?>
                            <div class="row tableContent subCategory">
                                <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 pull-right">
                                    {{$i}}
                                </div>
                                <div class="col-lg-2 col-md-3 col-sm-3 col-xs-3 pull-right">
                                    {{$showSubCat->categoryName}}
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 pull-right">
                                    <?php
                                    echo 'زیر دسته ی ' . $temp->categoryName;
                                    ?>
                                </div>

                                <br/>

                                <div class="col-lg-12 col-md-12 col-sm-12" style="padding: 0;">
                                    <a href="{{url('admin/editCategory-sub' . $showSubCat->id )}}">ویرایش</a>
                                    <a href="#" onclick="getId({{$showSubCat->id}})" data-toggle="modal"
                                       data-target="#exampleModalCenter">حذف</a>
                                </div>
                            </div>
                        @endforeach

                    @endif

                @endforeach
            </div>
        </div>


        <div style="direction: ltr;text-align: left;margin-top: 50px;">
            <?php
            if (!isset($SearchCategory)) {
                echo $category->links();
            }
            ?>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">حذف دسته</h5>
                    </div>
                    <div class="modal-body">
                        <span>
                            {{'آیا از حذف این دسته اطمینان دارید؟'}}
                        </span>

                        <br/>

                        <span style="color: red;font-weight: bold;">{{'توجه داشته باشید که با حذف دسته، تمام محصولات مرتبط به این دسته حذف خواهد شد!'}}</span>

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

        var CategoryId = 0;

        function getId(id) {
            CategoryId = id;
        }

        function deleteCategory(confirmId) {
            if (confirmId == '1') {
                window.location.href = 'deleteCategory' + CategoryId;
            }
        }

    </script>

@endsection

@else
    <script>window.location.href = "/" </script>
@endif