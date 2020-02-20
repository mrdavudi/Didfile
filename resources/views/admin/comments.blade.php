<?php
use Illuminate\Support\Facades\Input;
use App\category;
$comment = \App\comment::paginate(15);

if (isset($SearchComment)) {
    $comment = $SearchComment;
}

$i = 0;
?>


@if(\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->admin == '1')
    @extends('admin.master.AdminMaster')

@section('title')
    دیدگاه ها
@endsection

@section('header')
    <!-- =css for admin panel -->
    <link rel="stylesheet" type="text/css" href="{{url('css/admin.css')}}"/>

    <link rel="stylesheet" type="text/css" href="{{url('css/Tables.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{url('css/SmallTables.css')}}"/>

    <link rel="stylesheet" type="text/css" href="{{url('css/category.css')}}"/>
@endsection


@section('MainContent')

    <div class="editcategoryContent">

        <div class="row" style="direction: rtl;">
            <div class="col-lg-12 col-md-12 col-sm-12 pull-right">
                <h1 class="page-header visible-lg visible-md visible-sm" style="margin-top:0; padding-top:0;">دیدگاه
                    ها</h1>
                <h2 class="page-header visible-xs">دیدگاه ها - {{ 'سلام ' . \Illuminate\Support\Facades\Auth::user()->name}}</h2>
            </div>
        </div>


        <div class="Table">

            <div class="row" style="background: transparent;padding-right: 0;">

                @if(\Illuminate\Support\Facades\Session::has('message'))
                    @if(\Illuminate\Support\Facades\Session::get('message') == 'true')
                        <div class="alert alert-success" style="direction: rtl;">
                            {{'دیدگاه با موفقیت حذف گردید!'}}
                        </div>
                    @else
                        <div class="alert alert-danger" style="direction: rtl;">
                            {{'در هنگام حذف دیدگاه خطایی رخ داد؛ دوباره تلاش کنید!'}}
                        </div>
                    @endif
                @endif
            </div>


            @foreach($comment as $temp)

                <?php
                $i++;
                ?>
                <div class="visible-xs SmallTable">
                    <div class="row">
                        <div class="col-xs-4 pull-right SmallTitle">نام محصول</div>
                        <div class="col-xs-8 pull-right SmallContent">
                            {{$temp->product->title}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-4 pull-right SmallTitle">نام فرستنده</div>
                        <div class="col-xs-8 pull-right SmallContent">
                            {{$temp->user->name . ' ' . $temp->user->family}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-4 pull-right SmallTitle">ایمیل فرستنده</div>
                        <div class="col-xs-8 pull-right SmallContent">
                            {{$temp->user->email}}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-4 pull-right SmallTitle">متن</div>
                        <div class="col-xs-8 pull-right SmallContent">
                            {{$temp->text}}
                        </div>
                    </div>
                    <div class="row" style="text-align: center;">
                        <div class="col-xs-4 pull-right" style="background: #fff;padding: 0;">
                            <a href="#" onclick="getId({{$temp->id}})" data-toggle="modal"
                               data-target="#exampleModalCenter"
                               style=" background: #FFDBDB;color: #E95256 ;display: block;padding: 10px;">
                                <i class="fa fa-trash"></i>
                            </a>
                        </div>
                        <div class="col-xs-4 pull-right" style="background: #fff;padding: 0;">
                            <a href="{{url('admin/showComment' . $temp->productId )}}"
                               style="background: #F7FFF7; color: #4CAF82; display: block;padding: 10px;">
                                <i class="fa fa-eye"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="hidden-xs">
                <div class="row tableTitle">
                    <div class="col-lg-3 col-md-3 col-sm-3 pull-right">نام محصول</div>
                    <div class="col-lg-2 col-md-2 col-sm-2 pull-right">نام فرستنده</div>
                    <div class="col-lg-2 col-md-2 col-sm-2 pull-right">ایمیل فرستنده</div>
                    <div class="col-lg-5 col-md-5 col-sm-5 pull-right">متن</div>
                </div>

                <?php
                $i = 0;
                ?>

                @foreach($comment as $temp)

                    <?php
                    $i++;
                    ?>
                    <div class="row tableContent mainCategory">
                        <div class="col-lg-3 col-md-3 col-sm-3 pull-right">
                            {{$temp->product->title}}
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2 pull-right">
                            {{$temp->user->name . ' ' . $temp->user->family}}
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2 pull-right">
                            {{$temp->user->email}}
                        </div>
                        <div style="text-align: justify" class="col-lg-5 col-md-5 col-sm-5 pull-right">
                            {{$temp->text}}
                        </div>

                        <br/>

                        <div class="col-lg-12 col-md-12 col-sm-12" style="padding: 0;">
                            <a href="#" onclick="getId({{$temp->id}})" data-toggle="modal"
                               data-target="#exampleModalCenter">حذف</a>
                            <a href="{{url('admin/showComment' . $temp->productId )}}">مشاهده</a>
                        </div>
                    </div>


                @endforeach
            </div>
        </div>


        <div style="direction: ltr;text-align: left;margin-top: 50px;">
            <?php
            if (!isset($SearchComment)) {
                echo $comment->links();
            }
            ?>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">حذف دیدگاه</h5>
                    </div>
                    <div class="modal-body">
                        <span>
                            {{'آیا از حذف این دیدگاه اطمینان دارید؟'}}
                        </span>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" data-dismiss="modal" style="width: 80px;">خیر
                        </button>
                        <button type="button" class="btn btn-danger" style="width: 80px;"
                                onclick="deleteCategory({{'1'}})">بله
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script>

        var CommentId = 0;

        function getId(id) {
            CommentId = id;
        }

        function deleteCategory(confirmId) {
            if (confirmId == '1') {
                window.location.href = 'deleteComment' + CommentId;
            }
        }

    </script>

@endsection


@else
    <script>window.location.href = "/" </script>
@endif