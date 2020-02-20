@extends('client.master.masterClientarea')


@section('title')
    درباره ما
@endsection

@section('header')
    <link rel="stylesheet" type="text/css" href="{{url('css/clientarea.css')}}"/>
@endsection

@section('content')
    <br/>
    <br/>
    <br/>
    <br/>
    <br/>
    <br/>
    <div class="container"
         style="padding: 15px;margin-bottom: 30px;margin-top: 20px;background: #eee;-webkit-border-radius: 5px;-moz-border-radius: 5px;border-radius: 5px;">
        <div class="row" style="text-align: justify;direction: rtl;padding: 15px;">
            <h2 style="margin-top: 0;padding-top: 0;margin-bottom: 40px;">درباره ما</h2>

            <?php
            $aboutUs = \App\general::find(1);
            ?>

            <div class="aa"></div>
            <div style="text-align: justify;direction: rtl;">{!! $aboutUs->text !!}</div>
        </div>
    </div>


@endsection