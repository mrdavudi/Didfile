@extends('client.master.masterClientarea')

@section('title')
    ریست رمز عبور
@endsection

@section('header')
    <link rel="stylesheet" type="text/css" href="{{url('css/clientarea.css')}}"/>
@endsection

@section('content')

    <br/>
    <br/>
    <br/>

    <div class="container page_content" style="max-width: 400px;">
        <div class="row user_login">
            <div class="subject_form_login">
                <h3>ریست رمز عبور</h3>
            </div>

            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ url('password/email') }}">
                {{csrf_field()}}

                <div class="form-group">
                    <div class="form-group">
                        <div class="input-group">
                            <input id="email" type="email"
                                   style="direction: rtl;" class="form-control"
                                   name="email" value="{{ old('email') }}" placeholder="ایمیل را وارد نمایید..."
                                   required>
                            <div class="input-group-addon">
                                <i class="fa fa-envelope"></i>
                            </div>
                        </div>
                    </div>

                    <div style="direction: rtl;font-size: 15px; text-align: right; color: red;">
                        @if ($errors->has('email'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>


                <div class="form-group  mb-0" style="text-align: center;">
                    <button type="submit" class="btn btn-success" id="ResetLink">
                        {{ __('ارسال لینک ریست رمز عبور') }}
                    </button>
                </div>
            </form>
        </div>
    </div>

@endsection
