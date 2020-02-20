<?php
$CategoryOneItem = \App\category::find($id);
$Category = \App\category::all();
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
                <h1 class="page-header visible-lg visible-md visible-sm" style="margin-top:0; padding-top:0;">ویرایش
                    دسته</h1>
                <h2 class="page-header visible-xs">ویرایش دسته - {{ 'سلام ' . \Illuminate\Support\Facades\Auth::user()->name}}</h2>
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

        @if(\Illuminate\Support\Facades\Session::has('EditStatus'))
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pull-right">
                    <div class="alert alert-success" style="direction: rtl;">
                        {{'دسته بندی به درستی ویرایش شد.'}}
                    </div>
                </div>
            </div>
        @endif

        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 pull-right">
                <form action="{{url('admin/editCategory-sub')}}" method="post" style="text-align: right">
                    {{csrf_field()}}

                    <input type="hidden" name="id" value="{{$CategoryOneItem->id}}"/>

                    <div class="form-group">
                        <div class="input-group">
                            <input type="text" class="form-control" name="categoryName"
                                   required placeholder="نام دسته..." value="{{$CategoryOneItem->categoryName}}"
                                   style="direction: rtl;"/>

                            <div class="input-group-addon">
                                <i class="fa fa-folder"></i>
                            </div>
                        </div>
                    </div>

                    <select class="form-control" name="subCategory" required
                            style="padding:0; direction:rtl; padding-right: 5px;text-align: right;">
                        <option disabled>دسته را مشخص کنید</option>


                        <option <?php if ($CategoryOneItem->sid == 0) echo 'selected' ?> value="0">دسته مادر</option>

                        <?php
                        if ($CategoryOneItem->sid != 0)
                            $findSid = \App\category::find($CategoryOneItem->sid);
                        ?>
                        @foreach($Category as $temp)
                            @if($temp->id == $id)
                                @continue
                            @endif

                            @if($temp->sid == 0)
                                <option
                                    <?php if (isset($findSid) && ($temp->id == $findSid->id)) echo 'selected' ?> value="{{$temp->id}}">{{$temp->categoryName}}</option>
                            @endif
                        @endforeach
                    </select>

                    <br/>

                    <a href="{{url('admin/editcategory')}}" class="btn btn-danger">برگشت</a>
                    <input type="submit" class="btn btn-success" value="ویرایش دسته"/>
                </form>
            </div>
        </div>
    </div>

@endsection

@else
    <script>window.location.href = "/" </script>
@endif