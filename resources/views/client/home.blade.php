@if(\Illuminate\Support\Facades\Auth::check())

    @extends('client.master.AdminMaster')

@section('title')
    پنل کاربر-دیدفایل
@endsection

@section('header')
    <!-- css for admin panel -->
    <link rel="stylesheet" type="text/css" href="{{url('css/admin.css')}}"/>

    <link rel="stylesheet" type="text/css" href="{{url('css/Tables.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{url('css/SmallTables.css')}}"/>

@endsection

@section('MainContent')
    <div id="page-wrapper" style="margin-left: 0;">
        <!-- /.row -->
        <div class="row" style="direction: rtl;">
            <div class="col-lg-12">
                <h1 class="page-header visible-lg visible-md visible-sm" style="margin-top:0; padding-top:0;">پنل
                    کاربر</h1>
                <h2 class="page-header visible-xs">پنل کاربر
                    - {{ 'سلام ' . \Illuminate\Support\Facades\Auth::user()->name}}</h2>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

            </div>
        </div>
        <!-- /.row -->
    </div>
@endsection

@else
    <script>window.location.href = "/" </script>
@endif