@if(\Illuminate\Support\Facades\Auth::check())
    @extends('admin.master.AdminMaster')

@section('title')
    درباره ما
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
                <div class="alert alert-danger" style="direction: rtl;text-align: right;">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{$error}}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(\Illuminate\Support\Facades\Session::has('error'))
                <div class="alert alert-danger">
                    {{\Illuminate\Support\Facades\Session::get('error')}}
                </div>
            @endif

            @if(\Illuminate\Support\Facades\Session::has('sucess'))
                <div class="alert alert-success">
                    {{\Illuminate\Support\Facades\Session::get('sucess')}}
                </div>
            @endif

            <div class="row" style="direction: rtl;">
                <div class="col-lg-12 col-md-12 col-sm-12 pull-right">
                    <h1 class="page-header visible-lg visible-md visible-sm" style="margin-top:0; padding-top:0;">درباره
                        ما</h1>
                    <h2 class="page-header visible-xs">درباره ما
                        - {{ 'سلام ' . \Illuminate\Support\Facades\Auth::user()->name}}</h2>
                </div>
            </div>
        </div>

        <form action="{{url('admin/addAboutUs')}}" method="post" name="form1" id="form1">

            {{csrf_field()}}

            <?php
            $aboutUs = \App\general::find(1);
            ?>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pull-right">
                    <h3>متن درباره ما: </h3>
                    <textarea required class="form-control description" name="aboutUs" id="description">
                        {{$aboutUs->text}}
                    </textarea>
                </div>
            </div>


            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    <input type="submit" class="btn btn-primary pull-left" value="اعمال تغییرات"/>
                </div>
            </div>
        </form>

    </div>



    <script src="{{url('js/jquery-1.10.2.min.js')}}"></script>

    <script src="{{url('js/ckeditor/ckeditor.js')}}"></script>



    <!-- start description text -->
    <script>
        CKEDITOR.replace('description',
            {
                fullPage: true,
            });
        CKEDITOR.config.maxWidth = 1000;
        CKEDITOR.config.contentsLangDirection = 'rtl';
    </script>
    <!-- End description text -->



@endsection

@else
    <script> window.location.href = '/' </script>
@endif