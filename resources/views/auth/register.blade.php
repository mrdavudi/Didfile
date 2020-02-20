<?php
$url = explode('/', url()->previous());

?>

@extends('client.master.masterClientarea')

@section('title')
    ثبت نام کاربر
@endsection

@section('header')
    <link rel="stylesheet" type="text/css" href="{{url('css/clientarea.css')}}"/>
@endsection

@section('content')
    <div class="container page_content">
        <br/>
        <br/>

        <!-- Start Register From -->
        <div class="user_register col-lg-12 col-lg-offset-3 col-md-12 col-md-offset-3 col-sm-12 col-sm-offset-2 col-xs-12">

            <div class="subject_form_register">
                <h3>عضویت</h3>
            </div>

            <form method="POST" action="{{ url('register') }}">
                {{csrf_field()}}

                @if(isset($error))
                    <div class="alert alert-danger" style="direction: rtl;">{{$error}}</div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger" style="direction: rtl;text-align: right;">
                        <ul>
                            @foreach ($errors->all() as $error)
                                @php
                                    $error = str_replace('email','ایمیل',$error);
                                    $error = str_replace('password','رمز عبور',$error);
                                    $error = str_replace('name','نام',$error);
                                @endphp
                                <li>{{$error}}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <?php
                $lastUrl = explode('/', url()->previous());
                ?>
                <input type="hidden" name="lastUrl" value="{{$lastUrl[3]}}"/>

                <div class="form-group">
                    <div class="input-group">
                        <input id="name" type="text"
                               class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                               name="name" value="{{ old('name') }}" placeholder="نام..." required/>
                        <div class="input-group-addon">
                            <i class="fa fa-user">&nbsp;</i>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-group">
                        <input id="email" type="email"
                               class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                               name="email" value="{{ old('email') }}" placeholder="ایمیل..." required/>
                        <div class="input-group-addon">
                            <i class="fa fa-envelope"></i>
                        </div>
                    </div>
                </div>


                <div class="form-group">
                    <div class="input-group">
                        <input id="password" type="password"
                               class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                               name="password" placeholder="رمز عبور..." required/>
                        <div class="input-group-addon">
                            <i class="glyphicon glyphicon-lock"></i>
                        </div>
                    </div>
                </div>


                <div class="form-group">
                    <div class="input-group">
                        <input id="password-confirm" type="password"
                               class="form-control" name="password_confirmation" placeholder="تکرار رمز عبور..."
                               required/>
                        <div class="input-group-addon">
                            <i class="glyphicon glyphicon-lock"></i>
                        </div>
                    </div>
                </div>

                <div class="RegisterButton" style="text-align: left;">
                    <button type="submit" onclick="disable(1)" class="btn btn-primary">
                        {{ __('ثبت نام') }}
                    </button>
                </div>
            </form>
        </div>
        <!-- End Register Form -->
    </div>


@endsection
