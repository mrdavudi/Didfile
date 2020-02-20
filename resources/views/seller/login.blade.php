@extends('client.master.masterClientarea')


@section('title')
    ورود مدیر
@endsection

@section('header')
    <link rel="stylesheet" type="text/css" href="{{url('css/clientarea.css')}}"/>
@endsection

@section('content')
    <div class="container page_content">
        <br/>
        <br/>
        <br/>
        <!-- Start Login form -->
        <div class="user_login col-lg-12 col-lg-offset-3 col-md-12 col-md-offset-3 col-sm-12 col-sm-offset-2 col-xs-12">

            <div class="subject_form_login">
                <h3 class="">ورود</h3>
            </div>

            <form method="POST" action="{{ url('seller/login') }}">
                {{csrf_field()}}

                @if ($errors->has('email') || isset($error))
                    <div class="alert alert-danger" style="direction: rtl;">
                        <li>{{'نام کاربری یا رمز عبور نادرست است.'}}</li>
                    </div>
                @endif

                @if(isset($error_Activation))
                    <div class="alert alert-danger" style="direction: rtl;">
                        <li>{{'حساب کاربری شما هنوز فعال نشده یک ایمیل حاوی لینک فعال سازی برای شما ارسال شد.'}}</li>
                    </div>
                @endif

                @if(session('RegisterStatus'))
                    <div class="alert alert-success" style="direction: rtl;">
                        <li>{{'ثبت نام انجام شد، یک ایمیل حاوی لینک فعال سازی برای شما ارسال شد.'}}</li>
                    </div>
                @endif


                <div class="alert alert-success ResetPasswordTrue" hidden style="direction: rtl;">
                    <li>{{'ایمیلی حاوی لینک ریست رمز عبور برای شما ارسال شد.'}}</li>
                </div><!-- for reset password status(true) -->

                <div class="alert alert-danger ResetPasswordFalse" hidden style="direction: rtl;">
                    <li>{{'دوباره سعی کنید'}}</li>
                </div><!-- for reset password status(false) -->


                @if(\Illuminate\Support\Facades\Session::has('PasswordSendStatus'))
                <!-- Start Password Send Status -->
                    <div class="alert alert-success" style="direction: rtl;">
                        <li>{{'رمز عبور جدیدی به ایمیل شما ارسال شد'}}</li>
                    </div>
                    <!-- End Password Send Status -->
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
                    <a class="btn" id="RememberPassword" data-toggle="modal"
                       data-target="#resetPasswordModal">

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


        <!-- Modal -->
        <div class="modal fade" id="resetPasswordModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="exampleModalLabel" style="direction: rtl;">ریست رمز عبور</h4>
                    </div>
                    <div class="modal-body">

                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif

                        <div class="alert alert-success ResetPasswordTrue" hidden style="direction: rtl;">
                            <li>{{'ایمیلی حاوی لینک ریست رمز عبور برای شما ارسال شد.'}}</li>
                        </div><!-- for reset password status(true) -->

                        <div class="alert alert-danger ResetPasswordFalse" hidden style="direction: rtl;">
                            <li>{{'دوباره سعی کنید'}}</li>
                        </div><!-- for reset password status(false) -->

                        <div class="form-group">
                            <div class="input-group">
                                <input id="emailForReset" type="email"
                                       style="direction: rtl;" class="form-control"
                                       name="emailForReset" value="{{ old('emailForReset') }}"
                                       placeholder="ایمیل را وارد نمایید..." required>

                                <div class="input-group-addon">
                                    <i class="fa fa-envelope"></i>
                                </div>
                            </div>

                            <div style="direction: rtl;" id="loading" hidden>
                                <img src="{{url('img/loading.gif')}}" style="width: 70px; height: 70px;"/>
                                <p style="display: inline; padding-right: 0;margin: 0;">لطفا کمی صبر کنید</p>
                            </div>
                        </div>

                        <div style="direction: rtl;font-size: 15px; text-align: right; color: red;">
                            @if ($errors->has('email'))
                                <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <div class="form-group  mb-0" style="text-align: center;">
                            <button type="button" class="btn btn-success sendButton" onclick="PasswordReset()"
                                    id="ResetLink">
                                {{ __('ارسال لینک ریست رمز عبور') }}
                            </button>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">بستن</button>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <script src="{{url('js/jquery-1.10.2.min.js')}}"></script>

    <script>
        function PasswordReset() {
            var email = $('#emailForReset').val();

            $('.sendButton').prop("disabled", true);

            $('#loading').show();

            $.ajax({
                type: "POST",
                url: 'password/reset',
                data: {email: email, _token: "{{ csrf_token() }}"},
                success: function (msg) {
                    $('#loading').hide();
                    if (msg == 'true') {
                        $('.ResetPasswordTrue').show();
                    }
                    else {
                        $('.ResetPasswordFalse').show();
                        $('.sendButton').prop("disabled", false);
                    }
                }
            });
        }


    </script>
@endsection
