@if(\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->admin == '1')

@extends('admin.master.AdminMaster')

@section('title')
    افزودن محصول جدید
@endsection



@section('header')
    <!-- =css for admin panel -->
    <link rel="stylesheet" type="text/css" href="{{url('css/admin.css')}}"/>

    <link rel="stylesheet" type="text/css" href="{{url('css/addProduct.css')}}"/>

@endsection


@section('MainContent')
    <div class="addProductContent">

        <div class="row" style="direction: rtl;">
            <div class="col-lg-12 col-md-12 col-sm-12 pull-right">
                <h1 class="page-header visible-lg visible-md visible-sm" style="margin-top:0; padding-top:0;">افزودن
                    محصول</h1>
                <h2 class="page-header visible-xs">افزودن محصول - {{ 'سلام ' . \Illuminate\Support\Facades\Auth::user()->name}}</h2>
            </div>
        </div>

        <form action="{{url('admin/addProduct')}}" method="post" enctype="multipart/form-data">

        {{csrf_field()}}

        <!-- Start Error area -->
            <div class="row">
                @if (Illuminate\Support\Facades\Session::has('sucuss'))
                    @if(Illuminate\Support\Facades\Session::get('sucuss') != 0)
                        <div class="alert alert-success" style="direction: rtl;text-align: right">
                            {{'کالا به درستی ثبت شد!'}}
                        </div>
                    @else
                        <div class="alert alert-danger" style="direction: rtl;text-align: right">
                            {{'در هنگام ثبت کالا مشکلی رخ داد؛ دوباره تلاش کنید!'}}
                        </div>
                    @endif
                @endif
            </div>

            <div class="row">
                @if($errors->any())
                    <div class="alert alert-danger" style="direction: rtl;text-align: right">
                        <ul>
                            @foreach($errors->all() as $temp)
                                <li>{{$temp}}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
            <!-- End Error area -->

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pull-right">
                    <input type="text" name="title" class="form-control" value="{{old('title')}}"
                           placeholder="عنوان را وارد نمایید..." required/>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pull-right">
                    <h3>توضیحات کلی:</h3>
                    <textarea required class="form-control description" name="description" id="description">
                        {{\Illuminate\Support\Facades\Input::old('description')}}
                    </textarea>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pull-right">
                    <h3>سرفصل ها:</h3>
                    <textarea required class="form-control headings" name="headings" id="headings">
                        {{\Illuminate\Support\Facades\Input::old('headings')}}
                    </textarea>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pull-right">
                <textarea type="text" name="detail_description" class="form-control detail_description" required
                          placeholder="توضیحات روش دانلود...">کاربر عزیز میتوانید این دوره را از طریق بخش مربوطه، به صورت دانلودی دریافت کنید .</textarea>
                </div>
            </div>

            <div class="row">

                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 pull-right" style="margin-bottom: 15px;">
                    <input type="text" name="price" class="form-control" value="{{old('price')}}"
                           placeholder="قیمت (تومان)" required/>
                </div>

                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 pull-right" style="margin-bottom: 15px;">
                    <input type="text" name="size" class="form-control" value="{{old('size')}}"
                           placeholder="حجم..." required/>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 pull-right" style="margin-bottom: 15px;">
                    <input type="text" name="time" class="form-control" value="{{old('time')}}"
                           placeholder="مدت زمان..." required/>
                </div>

                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 pull-right" style="margin-bottom: 15px;">
                    <select name="level" class="form-control" required style="padding: 0;padding-right: 10px;">
                        <option value="0" selected="" disabled="">سطح آموزش</option>
                        <option value="مبتدی">مبتدی</option>
                        <option value="پیشرفته">پیشرفته</option>
                        <option value="مبتدی تا پیشرفته">مبتدی تا پیشرفته</option>
                    </select>
                </div>

            </div>


            <div class="row">

                <?php
                $category = \App\category::all();
                ?>

                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 pull-right" style="margin-bottom: 15px;">
                    <select name="category" class="form-control" required style="padding: 0;padding-right: 10px;">
                        <option value="0" selected="" disabled="">نام دسته</option>

                        @foreach($category as $temp)
                            <option value="{{$temp->id}}">{{$temp->categoryName}}</option>
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

                        <?php
                        $ProductImage = "";
                        if (Illuminate\Support\Facades\Session::has('sucuss') && Illuminate\Support\Facades\Session::get('sucuss') != 0) {
                            $ProductImage = \App\product::find(Illuminate\Support\Facades\Session::get('sucuss'));
                        }
                        ?>
                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8 pull-right">
                            @if (Illuminate\Support\Facades\Session::has('sucuss'))
                                <img src="{{url('/') . '/ProductImage/' . $ProductImage->ProductImage}}"
                                     class="img-responsive productImage"/>
                            @else
                                <img src="{{url('/') . '/img/didfile.jpg'}}"
                                     class="img-responsive productImage"/>
                            @endif
                        </div>
                    </div>

                </div>

                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 pull-right">
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 pull-right" style="padding: 0;">
                            <label>آپلود فایل پیوست:</label>
                        </div>

                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8 pull-right" style="padding: 0;">
                            <input type="file" name="image2" required/>
                        </div>
                    </div>
                </div>
            </div>

            <br/>
            <br/>

            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pull-left" style="direction: ltr">
                    <a href="{{url('admin/editProduct')}}" class="btn btn-danger">انصراف</a>
                    <input type="submit" class="btn btn-success" value="ثبت محصول"/>
                </div>
            </div>
        </form>

    </div>


    </div>

    <script src="{{url('js/jquery-1.10.2.min.js')}}"></script>
    <script src="{{url('js/NumericTXT.js')}}"></script>

    <script src="{{url('js/ckeditor/ckeditor.js')}}"></script>

    <!-- start description text -->
    <script>
        CKEDITOR.replace('description');
        CKEDITOR.config.maxWidth = 1000;
        CKEDITOR.config.contentsLangDirection = 'rtl';
    </script>
    <!-- End description text -->

    <!-- start headings text -->
    <script>
        CKEDITOR.replace('headings');
        CKEDITOR.config.maxWidth = 1000;
        CKEDITOR.config.contentsLangDirection = 'rtl';
    </script>
    <!-- End headings text -->



@endsection


@else
    <script>window.location.href = "/" </script>
@endif