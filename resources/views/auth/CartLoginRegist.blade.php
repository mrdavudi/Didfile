@extends('client.master.masterClientarea')

@section('title')
    'ورود یا ثبت نام'
@endsection

@section('header')
    <link rel="stylesheet" type="text/css" href="{{url('css/clientarea.css')}}"/>
@endsection

@section('content')
    <br/>
    <br/>
    <br/>
    <div class="container page_content_Cart"
         style="background: #fff;padding: 30px; max-width: 900px; -webkit-border-radius: 5px;-moz-border-radius: 5px;border-radius: 5px;">

        <!-- Start form for computer -->
        <div class="row visible-md visible-lg" style="text-align: center">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 pull-right" style="border-left: 1px solid #ccc;">
                <span class="glyphicon glyphicon-lock" style="font-size: 50px;color: #848D97;"></span>
                <h4 style="margin-bottom: 15px;color:#4D4D4D; ">عضو دیدفایل هستید؟</h4>
                <h5 style="margin-bottom: 40px;color:#777777">برای تکمیل فرایند خرید خود وارد شوید</h5>
                <button class="btn btn-success" data-toggle="modal" data-target="#exampleModalCenter">ورود به دیدفایل
                </button>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 pull-right">
                <span class="glyphicon glyphicon-user" style="font-size: 50px;color: #848D97;"></span>
                <h4 style="margin-bottom: 15px;color:#4D4D4D;">تازه وارد هستید؟</h4>
                <h5 style="margin-bottom: 40px;color:#777777">برای تکمیل فرایند خرید خود ثبت نام کنید</h5>
                <a href="register" class="btn btn-primary">ثبت نام در دیدفایل</a>
            </div>
        </div>
        <!-- End form for computer -->

        <!-- Start form for phone -->
        <div class="row visible-sm visible-xs" style="text-align: center">
            <h4 style="margin-bottom: 15px;color:#4D4D4D;">برای ادامه روند سفارش باید حساب کاربری دیدفایل داشته
                باشید</h4>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 pull-right">
                <h4 style="margin-bottom: 15px;color:#4D4D4D; ">قبلا حساب کاربری ساخته اید؟</h4>
                <button class="btn btn-success" data-toggle="modal" data-target="#exampleModalCenter">ورود به دیدفایل
                </button>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 pull-right" style="margin-top: 40px;">
                <h4 style="margin-bottom: 15px;color:#4D4D4D;">حساب کاربری ندارید؟</h4>
                <a href="register" class="btn btn-primary">ثبت نام در دیدفایل</a>
            </div>
        </div>
        <!-- End form for phone -->


        <!-- Start modal for login -->
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle" style="direction: rtl;">ورود به دیدفایل</h5>
                    </div>
                    <div class="modal-body">

                        <div class="alert alert-danger" id="error" hidden  style="direction: rtl;"></div>

                        <div class="form-group">
                            <div class="input-group">
                                <input type="email" id="email" name="email" class="form-control" style="direction: rtl;"
                                 autofocus  value="{{old('email')}}" placeholder="ایمیل را وارد نمایید..."/>

                                <div class="input-group-addon">
                                    <i class="fa fa-envelope"></i>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group">
                                <input type="password" id="password" name="password" class="form-control"
                                       style="direction: rtl;"
                                       value="{{old('password')}}" placeholder="رمز عبور را وارد نمایید..."/>

                                <div class="input-group-addon">
                                    <i class="glyphicon glyphicon-lock"></i>
                                </div>
                            </div>
                        </div>

                        <button class="btn btn-success" type="button" onclick="Login()" style="min-width: 100px;">ورود
                        </button>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">بستن</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- End modal for login -->

    </div>

    <script src="{{url('js/jquery-1.10.2.min.js')}}"></script>
    <script>
        function Login() {
            var email = $('#email').val();
            var password = $('#password').val();

            $.ajax({
                type: "POST",
                url: 'login',
                data: {email: email, password: password, _token: "{{ csrf_token() }}"},
                success: function (msg) {
                    if (msg != 'true') {
                        $('#error').slideDown();
                        $('#error').text(msg);
                    }
                    else {
                        window.location.href = 'checkout';
                    }

                }
            });
        }

    </script>
@endsection