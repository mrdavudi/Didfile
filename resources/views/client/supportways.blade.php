@extends('client.master.master')

@section('title')
    پشتیبانی
@endsection

@section('header')
    <link rel="stylesheet" type="text/css" href="{{url('css/supportWays.css')}}"/>

    <style>
        .support {
            background: #fff;
            margin-top: 20px;
            margin-bottom: 20px;
            direction: rtl;
            text-align: right;
            padding: 15px;
        }
    </style>
@endsection

@section('content')
    <div class="container support">
        <h3>ارتباط با واحد پشتیبانی :</h3>

        <p>
           برای ارتباط با واحد پشتیبانی می توانید از طریق ارسال ایمیل اقدام نمایید.
        </p>

        <br/>

        <div style="margin-top: 40px;">
            <i class="fa fa-envelope pull-right"
               style="color: #fff; font-size: 40px;background: #00BCD4;padding: 10px;border-radius: 100px;"></i>
            <h3>پشتیبانی از طریق ایمیل</h3>
            <p> می توانید به آدرس didacticfile@gmail.com درخواست خود را میل کنید !</p>
        </div>

    </div>
@endsection