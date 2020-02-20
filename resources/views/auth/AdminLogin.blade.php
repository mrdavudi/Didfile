@extends('client.master.master')

@section('title')
    ورود مدیران
@endsection

@section('content')
    <div class="container" style="max-width: 500px; background: #fff;padding: 0; margin-top: 20px; margin-bottom: 20px;">

        <div>
            <h3 style="background: #aaa;padding: 15px;margin-top: 0;">
                ورود مدیران
            </h3>

        </div>

        <form method="POST" action="{{ url('/admin') }}" style="padding: 20px;">
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
                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                           style="direction: rtl;" name="email" value="{{ old('email') }}" placeholder="ایمیل را وارد نمایید..." required>

                    <div class="input-group-addon">
                        <i class="fa fa-envelope"></i>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="input-group">
                    <input id="password" type="password"
                           style="direction: rtl;" class="form-control"
                           name="password" placeholder="رمز عبور را وارد نمایید..." required>

                    <div class="input-group-addon">
                        <i class="glyphicon glyphicon-lock"></i>
                    </div>
                </div>
            </div>


            <div style="direction: rtl;">
                <div class="LoginButton">
                    <button type="submit" class="btn btn-success">
                        {{ __('ورود') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
