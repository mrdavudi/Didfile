@if(\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->seller == '1')

@extends('seller.master.AdminMaster')

@section('title')
    ویرایش محصول
@endsection

@section('header')
    <!-- =css for admin panel -->
    <link rel="stylesheet" type="text/css" href="{{url('css/admin.css')}}"/>

    <link rel="stylesheet" type="text/css" href="{{url('css/addProduct.css')}}"/>

@endsection


@section('MainContent')
    <div class="addProductContent">

        <div class="row">
            @if($errors->any())
                <div class="alert alert-danger" style="direction: rtl;">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{$error}}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(\Illuminate\Support\Facades\Session::has('updateStatus'))
                <div class="alert alert-success" style="direction: rtl;">
                    {{'ویرایش به درستی انجام شد'}}
                </div>
            @endif
        </div>

        <div class="row" style="direction: rtl;">
            <div class="col-lg-12 col-md-12 col-sm-12 pull-right">
                <h1 class="page-header visible-lg visible-md visible-sm" style="margin-top:0; padding-top:0;">ویرایش
                    محصول</h1>
                <h2 class="page-header visible-xs">ویرایش محصول - {{ 'سلام ' . \Illuminate\Support\Facades\Auth::user()->name}}</h2>
            </div>
        </div>

        <?php
        $Product = \App\product::find($id);
        ?>

        <form action="{{url('seller/editProduct-sub')}}" method="post" enctype="multipart/form-data">
            {{csrf_field()}}

            <input type="hidden" name="id" value="{{$Product->id}}"/>

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pull-right">
                    <input type="text" name="title" class="form-control" value="{{ $Product->title }}"
                           placeholder="عنوان را وارد نمایید..." required/>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pull-right">
                    <h3>توضیحات کلی:</h3>
                    <textarea required class="form-control description" name="description" id="description">
                        {!! $Product->description !!}
                    </textarea>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pull-right">
                    <h3>سرفصل ها:</h3>
                    <textarea required class="form-control headings" name="headings" id="headings">
                        {!! $Product->headings !!}
                    </textarea>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pull-right">
                <textarea type="text" name="detail_description" class="form-control detail_description" required
                          placeholder="توضیحات روش دانلود...">{!! $Product->detail_description !!}</textarea>
                </div>
            </div>

            <div class="row">

                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 pull-right" style="margin-bottom: 15px;">
                    <input type="text" name="price" class="form-control" value="{{ $Product->price }}"
                           placeholder="قیمت (تومان)" required/>
                </div>

                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 pull-right" style="margin-bottom: 15px;">
                    <input type="text" name="size" class="form-control" value="{{ $Product->size }}"
                           placeholder="حجم..." required/>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 pull-right" style="margin-bottom: 15px;">
                    <input type="text" name="time" class="form-control" value="{{ $Product->time }}"
                           placeholder="مدت زمان..." required/>
                </div>

                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 pull-right" style="margin-bottom: 15px;">
                    <select name="level" class="form-control" required style="padding: 0;padding-right: 10px;">
                        <option value="0" selected="" disabled="">سطح آموزش</option>
                        <option
                            <?php if ($Product->level == 'مبتدی') echo 'selected' ?> value="مبتدی" <?php if ($Product->level == 'مبتدی') echo 'selected'  ?> >
                            مبتدی
                        </option>
                        <option
                            <?php if ($Product->level == 'پیشرفته') echo 'selected' ?>  value="پیشرفته" <?php if ($Product->level == 'پیشرفته') echo 'selected'  ?> >
                            پیشرفته
                        </option>
                        <option
                            <?php if ($Product->level == 'مبتدی تا پیشرفته') echo 'selected'  ?>  value="مبتدی تا پیشرفته">
                            مبتدی تا پیشرفته
                        </option>
                    </select>
                </div>

            </div>


            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 pull-right" style="margin-bottom: 15px;">
                    <select name="category" class="form-control" required style="padding: 0;padding-right: 10px;">
                        <option value="0" selected="" disabled="">نام دسته</option>

                        <?php
                        $CategoryShow = \App\category::all();
                        ?>

                        @foreach($CategoryShow as $tempShow)
                            <option
                                <?php if ($Product->categoryId == $tempShow->id) echo 'selected' ?> value="{{$tempShow->id}}">{{$tempShow->categoryName}}</option>
                        @endforeach
                    </select>
                </div>
            </div>


            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 pull-right">
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 pull-right" style="padding: 0;">
                            <label>آپلود تصویر محصول:</label>
                        </div>

                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8 pull-right" style="padding: 0;">
                            <input type="file" name="image1"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8 pull-right">
                            <img src="{{url('/') . '/ProductImage/'. $Product->ProductImage}}"
                                 class="img-responsive productImage"/>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 pull-right">
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 pull-right" style="padding: 0;">
                            <label>آپلود فایل پیوست:</label>
                        </div>

                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8 pull-right" style="padding: 0;">
                            <input type="file" name="image2"/>
                        </div>
                    </div>
                </div>
            </div>

            <br/>
            <br/>

            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pull-left">
                    <input type="submit" class="btn btn-success pull-left" value="ثبت ویرایش"/>
                </div>
            </div>
        </form>

    </div>




    <script src="{{url('js/jquery-1.10.2.min.js')}}"></script>
    <script src="{{url('js/NumericTXT.js')}}"></script>

    <script src="{{url('js/ckeditor/ckeditor.js')}}"></script>

    <!-- start description text -->
    <script>
        CKEDITOR.replace('description',
            {
                fullPage: true
            });
        CKEDITOR.config.maxWidth = 1000;
        CKEDITOR.config.contentsLangDirection = 'rtl';
    </script>
    <!-- End description text -->

    <!-- start headings text -->
    <script>
        CKEDITOR.replace('headings',
            {
                fullPage: true
            });
        CKEDITOR.config.maxWidth = 1000;
        CKEDITOR.config.contentsLangDirection = 'rtl';
    </script>
    <!-- End headings text -->



@endsection

@else
    <script>window.location.href = "/" </script>
@endif