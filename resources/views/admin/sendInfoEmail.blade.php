@if(\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->admin == '1')

    @extends('admin.master.AdminMaster')

@section('title')
    ارسال ایمیل اطلاع رسانی
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
                <h1 class="page-header visible-lg visible-md visible-sm" style="margin-top:0; padding-top:0;">ارسال
                    ایمیل اطلاع رسانی</h1>
                <h2 class="page-header visible-xs">ارسال ایمیل اطلاع رسانی - {{ 'سلام ' . \Illuminate\Support\Facades\Auth::user()->name}}</h2>
            </div>
        </div>

        <form action="{{url('admin/SendEmailNews')}}" method="post" enctype="multipart/form-data" id="form" class="form"
              name="form">
            {{csrf_field()}}


            @if($errors->any())
                <div class="row">
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>
                                    <?php
                                    $error = str_replace('title', 'عنوان', $error);
                                    $error = str_replace('description', 'متن ایمیل', $error);
                                    echo $error;
                                    ?>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <div class="row">
                <div id="loading" class="alert alert-info" style="direction: rtl;">
                    <img src="{{url('img/loading.gif')}}" style="width: 70px; height: 70px;"/>
                    <p style="display: inline-block;">لطفا کمی صبر کنید؛ درحال ارسال ایمیل.</p>
                </div>
            </div>

            @if(\Illuminate\Support\Facades\Session::has('message'))
                @if(\Illuminate\Support\Facades\Session::get('message') == 'true')
                    <div class="row">
                        <div class="alert alert-success" style="direction: rtl;">
                            {{'ایمیل به درستی ارسال شد.'}}
                        </div>
                    </div>
                @else
                    <div class="row">
                        <div class="alert alert-danger" style="direction: rtl;">
                            {{'در هنگام ارسال ایمیل خطایی رخ داد؛ دوباره تلاش کنید!'}}
                        </div>
                    </div>
                @endif
            @endif

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pull-right">
                    <input type="text" name="title" id="title" class="form-control" value="{{old('title')}}"
                           placeholder="عنوان را وارد نمایید..." required/>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pull-right">
                    <h3>متن ایمیل: </h3>
                    <textarea required class="form-control description" name="description" id="description">
                        {{\Illuminate\Support\Facades\Input::get('description')}}
                    </textarea>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pull-right">
                    <div id="fileUpload">
                        <p style="display: inline-block;">آپلود تصویر: &nbsp;&nbsp;&nbsp;&nbsp;</p>
                        <input type="file" id="image" name="image" style="display: inline-block"/>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    <input type="button" onclick="Sendemail()" id="sendEmailBtn" class="btn btn-primary pull-left"
                           value="ارسال ایمیل"/>
                </div>
            </div>
        </form>

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


    <script>
        $('#loading').hide();
        $('#succuss').hide();

        function Sendemail() {
            $('#sendEmailBtn').prop("disabled", true);
            $('#loading').show();

            form.submit();
        }
    </script>

@endsection

@else
    <script>window.location.href = "/" </script>
@endif