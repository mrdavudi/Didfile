@extends('client.master.master')

@section('title')
    ثبت نام/ ورود
@endsection

@section('header')
    <link rel="stylesheet" type="text/css" href="{{url('css/clientarea.css')}}"/>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="container page_content">
            <!-- Start Login form -->
            <div class="user_login col-lg-6 col-md-12 col-sm-12 col-xs-12 pull-right">

                <div class="subject_form_login">
                    <h3 class="">ورود</h3>
                </div>

                <form method="POST" action="{{ url('clientarea') }}">
                    {{csrf_field()}}

                    @if ($errors->has('email'))
                        <div class="alert alert-danger" style="direction: rtl;">
                    <span class="invalid-feedback">
                    {{ $errors->first('email') }}
                </span>

                        </div>
                    @endif

                    <div class="form-group">
                        <div class="input-group">
                            <input id="email" type="email"
                                   class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                   name="email" value="{{ old('email') }}" placeholder="ایمیل را وارد نمایید..."
                                   required>

                            <div class="input-group-addon">
                                <i class="fa fa-envelope"></i>
                            </div>
                        </div>
                    </div>


                    <div style="text-align: left;">
                        <a class="btn" id="RememberPassword" href="{{ route('password.request') }}">
                            {{ __('رمز عبور خود را فراموش کرده اید؟') }}
                        </a>
                    </div>


                    <div class="form-group">
                        <div class="input-group">
                            <input id="password" type="password"
                                   class="form-control"
                                   name="password" placeholder="رمز عبور را وارد نمایید..." required>

                            <div class="input-group-addon">
                                <i class="glyphicon glyphicon-lock"></i>
                            </div>
                        </div>
                    </div>


                    <div style="direction: rtl;">
                        <label style="font-size: 15px;margin-bottom: 20px;">
                            <input type="checkbox"
                                   name="remember" {{ old('remember') ? 'checked' : '' }}> {{ __(' من را بخاطر بسپار') }}
                        </label>


                        <div class="LoginButton" style="text-align: left;">
                            <button type="submit" class="btn btn-success">
                                {{ __('ورود') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- End Login form -->

            <!-- Start Register From -->
            <div class="user_register col-lg-6 col-md-12 col-sm-12 col-xs-12 pull-right">

                <div class="subject_form_register">
                    <h3>عضویت</h3>
                </div>

                <form method="POST" action="{{ url('registerUser') }}">
                    {{csrf_field()}}

                    <div class="form-group">
                        <div class="input-group">
                            <input id="name" type="text"
                                   class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                   name="name" value="{{ old('name') }}" placeholder="نام..." required/>
                            <div class="input-group-addon">
                                <i class="fa fa-user"></i>
                            </div>
                        </div>


                        <div style="direction: rtl; font-size: 15px;color: red;">
                            @if ($errors->has('name'))
                                <span class="invalid-feedback">
                            {{ $errors->first('name') }}
                        </span>
                            @endif
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


                        <div style="direction: rtl; font-size: 15px;color: red;">
                            @if ($errors->has('email'))
                                <span class="invalid-feedback">
                        {{ $errors->first('email') }}
                    </span>
                            @endif
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

                        <div style="direction: rtl; font-size: 15px;color: red;">
                            @if ($errors->has('password'))
                                <span class="invalid-feedback">
                        {{ $errors->first('password') }}
                    </span>
                            @endif
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
                        <button type="submit" class="btn btn-primary">
                            {{ __('ثبت نام') }}
                        </button>
                    </div>
                </form>
            </div>
            <!-- End Register Form -->

        </div>
    </div>
@endsection