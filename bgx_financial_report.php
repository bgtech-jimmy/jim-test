<?php
require_once('initialize.php');
date_default_timezone_set('Asia/Dubai');

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://qtpe6e5x97.execute-api.eu-west-1.amazonaws.com/prod/get_salons_list");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

$headers = array();
$headers[] = "x-api-key: 3drPHUiIAS4j3b9p86ZNq7dcdkTWqSbs8u04W4st";
$headers[] = "Accept-Language: en_US";
$headers[] = "Content-Type: application/json";
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$salon_list = curl_exec($ch);
if(curl_errno($ch)){
    echo "Error: " . curl_error($ch);
}
curl_close($ch);
$salon_list = json_decode($salon_list);

$data = array("salon_id" => "all");
$data_string = json_encode($data);

$ch2 = curl_init();
curl_setopt($ch2, CURLOPT_URL, "https://qtpe6e5x97.execute-api.eu-west-1.amazonaws.com/prod/bgx_get_salon_stylists");
curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch2, CURLOPT_POSTFIELDS, $data_string);

$headers2 = array();
$headers2[] = "x-api-key: 3drPHUiIAS4j3b9p86ZNq7dcdkTWqSbs8u04W4st";
$headers2[] = "Accept-Language: en_US";
$headers2[] = "Content-Type: application/json";
curl_setopt($ch2, CURLOPT_HTTPHEADER, $headers2);

$stylist_list = json_decode(curl_exec($ch2));
if(curl_errno($ch2)){
    echo "Error: " . curl_error($ch2);
}
curl_close($ch2);

?>

<!DOCTYPE HTML>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>BloNet | EOD Financial Report</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="css/plugins/dataTables/datatables.min.css" rel="stylesheet">

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/plugins/datapicker/datepicker3.css" rel="stylesheet">
    <!-- Sweet Alert -->
    <link href="css/plugins/sweetalert/sweetalert.css" rel="stylesheet">

    <!-- Ladda style -->
    <link href="css/plugins/ladda/ladda-themeless.min.css" rel="stylesheet">

    <!-- bootstrap-chosen -->
    <link href="css/plugins/chosen/bootstrap-chosen.css" rel="stylesheet">

    <link href="css/plugins/daterangepicker/daterangepicker-bs3.css" rel="stylesheet">
</head>

<body>
<div id="wrapper">
    <?php include('nav.php'); ?>
    <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
            <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header">
                    <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
                    <form role="search" class="navbar-form-custom" action="search_results.html">
                        <div class="form-group">
                            <input type="text" placeholder="Search for something..." class="form-control" name="top-search" id="top-search">
                        </div>
                    </form>
                </div>
                <ul class="nav navbar-top-links navbar-right">
                    <li>
                        <span class="m-r-sm text-muted welcome-message">Welcome <?php echo $user->first_name; ?></span>
                    </li>
                    <li>
                        <a href="destroy.php">
                            <i class="fa fa-sign-out"></i> Log out
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-12">
                <h2>BGX Financial Report</h2>
                <ol class="breadcrumb">
                    <li>
                        <a href="index.html">Home</a>
                    </li>
                    <li>
                        <strong>BGX Financial Report</strong>
                    </li>
                </ol>
            </div>
        </div>
        <div class="wrapper wrapper-content  animated fadeInRight">
            <div class="row">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#tab-1"> <i class="fa fa-laptop"></i>All</a></li>
                        <li class=""><a data-toggle="tab" href="#tab-2"><i class="fa fa-desktop"></i>Specific Salon</a></li>
                    </ul>
                    <div class="tab-content">
                        <div id="tab-1" class="tab-pane active">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="ibox float-e-margins">
                                        <h1 class="text-center">
                                            <i class="fa fa-user"></i> BGX Financial Report

                                        </h1>
                                        <div class="row">
                                            <div class="col-lg-12 form-group" id="data_5" >
                                                <div class="col-lg-12  input-daterange input-group" id="datepicker">
                                                    <input type="text" class="input-sm form-control" name="from_date" id="from_date" value="<?php echo date('Y-m-d'); ?>"/>
                                                    <span class="input-group-addon">to</span>
                                                    <input type="text" class="input-sm form-control" name="to_date" id="to_date" value="<?php echo date('Y-m-d'); ?>"/>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 form-group">
                                                <div class="col-lg-4 text-center">
                                                    <select style="width: 100%; text-align-last:center;" id="country_id">
                                                        <option value="248">United Arab Emirates</option>
                                                        <option value="london">London</option>
                                                    </select>
                                                </div>
                                                <div class="col-lg-4 text-center">
                                                    <select style="width: 100%; text-align-last:center;" id="salon_id">
                                                        <?php
                                                        foreach($salon_list->result as $key=>$value){
                                                            echo "<option value='".$value->user_id."'>".$value->name."</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="col-lg-4 text-center">
                                                    <select style="width: 100%; text-align-last:center;" id="stylist_id">
                                                        <option value="all">All Stylist</option>
                                                        <?php
                                                            foreach($stylist_list->salon->salon_stylist as $key=>$value){
                                                                echo "<option value='".$value->stylist_id."'>".$value->stylist_name."</option>";
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" style="margin-bottom: 10px;">
                                            <div class="col-lg-12 text-center">
                                                <button class="navy-bg" style="width:100%; height: 40px; border-radius: 10px; font-size: 16px;" type="button" id="generate_report">GENERATE REPORT</button>
                                            </div>
                                        </div>
                                        <div class="panel-group" id="accordion">
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <h5 class="panel-title text-center">
                                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne"><h3>BGX Bookings Report</h3></a>
                                                    </h5>
                                                </div>
                                                <div id="collapseOne" class="panel-collapse collapse in">
                                                    <div class="panel-body">
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="widget style1 navy-bg">
                                                                    <div class="row">
                                                                        <div class="col-xs-2">
                                                                            <i class="fa fa-money fa-5x"></i>
                                                                        </div>
                                                                        <div class="col-xs-10 text-right">
                                                                            <span> Total Revenue </span>
                                                                            <h2 class="font-bold" id="data_revenue">0</h2>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="widget style1 lazur-bg">
                                                                    <div class="row">
                                                                        <div class="col-xs-4">
                                                                            <i class="fa fa-money fa-5x"></i>
                                                                        </div>
                                                                        <div class="col-xs-8 text-right">
                                                                            <span> Total Commission </span>
                                                                            <h2 class="font-bold" id="data_commission">0</h2>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-3"></div>
                                                            <div class="col-lg-6">
                                                                <div class="widget style1 yellow-bg">
                                                                    <div class="row">
                                                                        <div class="col-xs-4">
                                                                            <i class="fa fa-book fa-5x"></i>
                                                                        </div>
                                                                        <div class="col-xs-8 text-right">
                                                                            <span> Total Bookings (Completed) </span>
                                                                            <h2 class="font-bold" id="data_bookings">0</h2>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3"></div>
                                                        </div>

                                                        <div class="row" style="display:none;">
                                                            <div class="col-lg-4">
                                                                <div class="widget style1 red-bg">
                                                                    <div class="row">
                                                                        <div class="col-xs-4">
                                                                            <i class="fa fa-money fa-5x"></i>
                                                                        </div>
                                                                        <div class="col-xs-8 text-right">
                                                                            <span> Unavailable Bookings </span>
                                                                            <h2 class="font-bold" id="data_unavailable">0</h2>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="widget style1 gray-bg">
                                                                    <div class="row">
                                                                        <div class="col-xs-2">
                                                                            <i class="fa fa-money fa-5x"></i>
                                                                        </div>
                                                                        <div class="col-xs-10 text-right">
                                                                            <span> Cancelled Bookings </span>
                                                                            <h2 class="font-bold" id="data_cancelled">0</h2>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="widget style1 blue-bg">
                                                                    <div class="row">
                                                                        <div class="col-xs-4">
                                                                            <i class="fa fa-money fa-5x"></i>
                                                                        </div>
                                                                        <div class="col-xs-8 text-right">
                                                                            <span> Pending Bookings </span>
                                                                            <h2 class="font-bold" id="data_pending">0</h2>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <h4 class="panel-title text-center">
                                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo"><h3>List of Bookings</h3></a>
                                                    </h4>
                                                </div>
                                                <div id="collapseTwo" class="panel-collapse collapse in">
                                                    <div class="panel-body" id="list-of-bookings">
                                                        <table class="table table-striped table-bordered table-hover dataTables-stylists" id="stylist_table">
                                                            <thead>
                                                            <tr>
                                                                <th>Stylists</th>
                                                                <th>No. of bookings completed</th>
                                                                <th>Total Revenue</th>
                                                            </tr>
                                                            </thead>
                                                            <tfoot>
                                                            <tr>
                                                                <th>Stylists</th>
                                                                <th>No. of bookings completed</th>
                                                                <th>Total Revenue</th>
                                                            </tr>
                                                            </tfoot>
                                                        </table>

                                                        <div class="col-lg-12" id="panel-bookings" style="display:none;">
                                                            <div class="panel panel-default">

                                                                <div class="panel-heading text-center">
                                                                    <b>Stylist Bookings</b>
                                                                </div>
                                                                <div class="panel-body">

                                                                    <table class="table table-striped table-bordered table-hover dataTables-bookings" id="bookings_table">
                                                                        <thead>
                                                                        <tr>
                                                                            <th>Booking ID</th>
                                                                            <th>Customer Name</th>
                                                                            <th>Time</th>
                                                                            <th>Status</th>
                                                                        </tr>
                                                                        </thead>
                                                                        <tfoot>
                                                                        <tr>
                                                                            <th>Booking ID</th>
                                                                            <th>Customer Name</th>
                                                                            <th>Time</th>
                                                                            <th>Status</th>
                                                                        </tr>
                                                                        </tfoot>
                                                                    </table>

                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal inmodal" id="invoiceModal" tabindex="-1" role="dialog"  aria-hidden="true"></div>
        <div class="footer">
            <?php include("footer.php"); ?>
        </div>

    </div>
</div>
<!-- Mainly scripts -->
<script src="js/jquery-2.1.1.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

<!-- Data tables plugin script -->
<script src="js/plugins/dataTables/datatables.min.js"></script>

<!-- Custom and plugin javascript -->
<script src="js/inspinia.js"></script>
<script src="js/plugins/pace/pace.min.js"></script>
<!-- Data picker -->
<script src="js/plugins/datapicker/bootstrap-datepicker.js"></script>
<!-- Date range use moment.js same as full calendar plugin -->
<script src="js/plugins/fullcalendar/moment.min.js"></script>
<!-- Date range picker -->
<script src="js/plugins/daterangepicker/daterangepicker.js"></script>
<!-- Sweet alert -->
<script src="js/plugins/sweetalert/sweetalert.min.js"></script>
<!-- ladda -->
<script src="js/plugins/ladda/spin.min.js"></script>
<script src="js/plugins/ladda/ladda.min.js"></script>
<script src="js/plugins/ladda/ladda.jquery.min.js"></script>
<!-- Flot -->
<script src="js/plugins/flot/jquery.flot.js"></script>
<script src="js/plugins/flot/jquery.flot.tooltip.min.js"></script>
<script src="js/plugins/flot/jquery.flot.resize.js"></script>

<!-- Chosen -->
<script src="js/plugins/chosen/chosen.jquery.js"></script>

<!-- Page-Level Scripts -->
<script>
    var table_stylists="";
    var table_bookings="";
    $(document).ready(function() {
        var d1 = [[1262304000000, 6], [1264982400000, 3057], [1267401600000, 20434], [1270080000000, 31982], [1272672000000, 26602], [1275350400000, 27826], [1277942400000, 24302], [1280620800000, 24237], [1283299200000, 21004], [1285891200000, 12144], [1288569600000, 10577], [1291161600000, 10295]];
        var d2 = [[1262304000000, 5], [1264982400000, 200], [1267401600000, 1605], [1270080000000, 6129], [1272672000000, 11643], [1275350400000, 19055], [1277942400000, 30062], [1280620800000, 39197], [1283299200000, 37000], [1285891200000, 27000], [1288569600000, 21000], [1291161600000, 17000]];
        var data1 = [
            { label: "Data 1", data: d1, color: '#17a084'},
            { label: "Data 2", data: d2, color: '#127e68' }
        ];
        $('#data_5 .input-daterange').datepicker({
            keyboardNavigation: false,
            forceParse: false,
            autoclose: true,
            format: "yyyy-mm-dd"
        });

        table_stylists = $('.dataTables-stylists').DataTable({
            pageLength: 20,
            //responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            buttons: [
                { extend: 'copy'},
                {extend: 'csv'},
                {extend: 'excel', title: 'ExampleFile'},
                {extend: 'pdf', title: 'ExampleFile'},

                {extend: 'print',
                    customize: function (win){
                        $(win.document.body).addClass('white-bg');
                        $(win.document.body).css('font-size', '10px');

                        $(win.document.body).find('table')
                            .addClass('compact')
                            .css('font-size', 'inherit');
                    }
                }
            ]
        });

        table_bookings = $('.dataTables-bookings').DataTable({
            pageLength: 20,
            //responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            buttons: [
                { extend: 'copy'},
                {extend: 'csv'},
                {extend: 'excel', title: 'ExampleFile'},
                {extend: 'pdf', title: 'ExampleFile'},

                {extend: 'print',
                    customize: function (win){
                        $(win.document.body).addClass('white-bg');
                        $(win.document.body).css('font-size', '10px');

                        $(win.document.body).find('table')
                            .addClass('compact')
                            .css('font-size', 'inherit');
                    }
                }
            ]
        });
    });

    $('#generate_report').on('click', function(){
        $('#panel-bookings').hide();
        table_bookings.clear();

        var from_date   = $('#from_date').val();
        var to_date     = $('#to_date').val();
        var country_id  = $('#country_id').val();
        var salon_id    = $('#salon_id').val();
        var stylist_id  = $('#stylist_id').val();
        var sum_bookings = 0;
        var sum_revenues  = 0;
        $.get("functions/bgx/bgx-financial-report.php?from_date=" + from_date + "&to_date=" + to_date +  "&country_id=" + country_id + "&salon_id=" + salon_id + "&stylist_id=" + stylist_id, function(result){

            var json = JSON.parse(result);
            console.log(json);
            table_stylists.clear();

            if(json.status == "ok"){

                var table_rows = [];
                $.each(json.salon.salon_stylist, function(index, value){

                    var total_bookings = 0;
                    var total_revenue  = 0;

                    $.each(value.stylist_bookings, function(k,v){
                        total_revenue += v.total_revenue;
                        total_bookings++;
                    });

                    table_rows.push({
                        "DT_RowId" : value.stylist_id,
                        0:value.stylist_name,
                        1:total_bookings,
                        2:total_revenue
                    });

                    sum_bookings += total_bookings;
                    sum_revenues += total_revenue;

                });
                table_stylists.rows.add(table_rows).draw();
                $('#data_bookings').html(sum_bookings);
                $('#data_revenue').html(sum_revenues);

            }else{
                table_stylists.rows.draw();
            }

        });
    });

    $('#salon_id').on('change', function(){
        $.get('functions/bgx/bgx-salon-stylists.php?salon_id=' + $('#salon_id').val(), function(result){

            var data = JSON.parse(result);
            var options = "<option value='all'>All Stylist</option>";

            $.each(data.salon.salon_stylist, function(k,v){

                options += "<option value='" + v.stylist_id + "'>" + v.stylist_name + "</option>";

            });
            $('#stylist_id').html(options);

        });
    });

    $('#stylist_table').on('dblclick', 'tr', function () {

        $('#panel-bookings').show();
        table_bookings.clear();

        var stylist_id = table_stylists .row( this ).id();
        var from_date   = $('#from_date').val();
        var to_date     = $('#to_date').val();
        var country_id  = $('#country_id').val();
        var salon_id    = $('#salon_id').val();
        var stylist_id  = stylist_id;

        $.get("functions/bgx/bgx-financial-report.php?from_date=" + from_date + "&to_date=" + to_date +  "&country_id=" + country_id + "&salon_id=" + salon_id + "&stylist_id=" + stylist_id, function(result){

            var json = JSON.parse(result);
            if(json.status == "ok"){

                var table_rows = [];
                $.each(json.salon.salon_stylist, function(index, value){

                    $.each(value.stylist_bookings, function(k,v){
                        table_rows.push({
                            "DT_RowId" : v.booking_id,
                            0:v.booking_id,
                            1:v.customer_name,
                            2:v.booking_start,
                            3:v.booking_status
                        });
                    });

                });
                table_bookings.rows.add(table_rows).draw();

            }else{
                table_bookings.rows.draw();
            }

        });

    });
</script>
</body>
</html>
