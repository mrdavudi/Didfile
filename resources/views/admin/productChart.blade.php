@if(\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->admin == '1')

    @extends('admin.master.AdminMaster')

@section('title')
    نمودار ها
@endsection

@section('header')
    <link rel="stylesheet" type="text/css" href="{{url('css/admin.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{url('css/addProduct.css')}}"/>
@endsection

@section('MainContent')

    <div class="editProductContent">
        <div class="row" style="direction: rtl;">
            <div class="col-lg-12 col-md-12 col-sm-12 pull-right">
                <h1 class="page-header visible-lg visible-md visible-sm" style="margin-top:0; padding-top:0;">
                    نمودار ها</h1>
                <h2 class="page-header visible-xs">نمودار ها
                    - {{ 'سلام ' . \Illuminate\Support\Facades\Auth::user()->name}}</h2>
            </div>
        </div>


        <div class="row" style="padding: 15px;">
            <div class="col-lg-8 col-lg-offset-2 col-md-12 col-sm-12 col-xs-12" style="margin-top: 20px;">
                <canvas id="monthProduct" class="chart" style="font-size: 20px;" width="1600"
                        height="900"></canvas>
            </div>
        </div>

        <div class="row" style="padding: 15px;">
            <div class="col-lg-8 col-lg-offset-2 col-md-12 col-sm-12 col-xs-12"
                 style="margin-top: 20px;margin-bottom: 20px;">
                <canvas id="yearProduct" class="chart" style="font-size: 20px;" width="1600"
                        height="900"></canvas>
            </div>
        </div>

    </div>

    <script type="text/javascript" src="{{url('js/chart.min.js')}}"></script>

    <?php

    $Orders = \App\order::all();

    $one = 0;
    $two = 0;
    $three = 0;
    $four = 0;
    $five = 0;
    $six = 0;
    $seven = 0;
    $eight = 0;
    $nine = 0;
    $ten = 0;
    $eleven = 0;
    $twelve = 0;

    $y93 = 0;
    $y94 = 0;
    $y95 = 0;
    $y96 = 0;
    $y97 = 0;
    $y98 = 0;
    $y99 = 0;


    foreach ($Orders as $temp) {
        $date = \Hekmatinasser\Verta\Facades\Verta::parse($temp->orderDate);

        //month
        switch ($date->month) {
            case 1:
                $one++;
                break;
            case 2:
                $two++;
                break;
            case 3:
                $three++;
                break;
            case 4:
                $four++;
                break;
            case 5:
                $five++;
                break;
            case 6:
                $six++;
                break;
            case 7:
                $seven++;
                break;
            case 8:
                $eight++;
                break;
            case 9:
                $nine++;
                break;
            case 10:
                $ten++;
                break;
            case 11:
                $eleven++;
                break;
            case 12:
                $twelve++;
                break;
        }


        //year
        switch ($date->year) {
            case 1393:
                $y93++;
                break;
            case 1394:
                $y94++;
                break;
            case 1395:
                $y95++;
                break;
            case 1396:
                $y96++;
                break;
            case 1397:
                $y97++;
                break;
            case 1398:
                $y98++;
                break;
            case 1399:
                $y99++;
                break;
        }
    }

    $MostOrder = \App\order::select('products.*', DB::raw('count(orders.productId) as MostCount'))
        ->join('products', 'products.id', '=', 'orders.productId')
        ->groupBy('orders.productId')
        ->orderBy('MostCount', 'desc')
        ->take(12)
        ->get();

    $Products = [];
    $CountProducts = [];

    for ($i = 0; $i < count($MostOrder); $i++) {
        $Products[$i] = $MostOrder[$i]->title;
        $CountProducts[$i] = $MostOrder[$i]->MostCount;
    }


    $f = implode(',', $Products);
    $g = implode(',', $CountProducts);

    //chart for month
    echo "
            <script>
                var month = ['فروردین', 'اردیبهشت', 'خرداد', 'تیر', 'مرداد', 'شهریور', 'مهر', 'آبان', 'آذر', 'دی', 'بهمن', 'اسفند'];

                var countMonth = [$one, $two, $three, $four,$five, $six, $seven, $eight, $nine, $ten, $eleven, $twelve];
            </script>
        ";

    //chart for year
    echo "
            <script>
                var year = ['1393', '1394', '1395', '1396', '1397', '1398', '1399'];

                var countYear = [$y93, $y94, $y95, $y96, $y97, $y98, $y99];
            </script>
        ";

    ?>

    <script type="text/javascript" src="{{url('js/productChart.js')}}"></script>
@endsection


@else
    <script>window.location.href = "/" </script>
@endif