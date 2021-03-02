<?
session_start();
include("connect.php");
include("library.php");

$status = $_REQUEST['status'];
//echo $_SESSION['admin_userid'];
$yyear_period = date("Y", strtotime("- 3 years"));
$mmonth = $_GET['mmonth'];
if ($mmonth == '') {
    $mmonth = date("m");
    $yyear = date("Y");
    // echo $yyear_period;
}else{
    $mmonth = $_GET['mmonth'];
    $yyear = $_GET['yyear'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>I-Wis : Sale</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="I-Wis">
    <meta name="author" content="The Red Team">

    <!-- <link href="assets/less/styles.less" rel="stylesheet/less" media="all">  -->
    <link rel="stylesheet" href="assets/css/styles.css?=140">
    <!-- <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600' rel='stylesheet' type='text/css'>-->


    <link href='assets/demo/variations/default.css' rel='stylesheet' type='text/css' media='all' id='styleswitcher'>
    <link href='assets/demo/variations/default.css' rel='stylesheet' type='text/css' media='all' id='headerswitcher'>


    <link rel='stylesheet' type='text/css' href='assets/plugins/jqueryui-timepicker/jquery.ui.timepicker.css' />
    <link rel='stylesheet' type='text/css' href='assets/plugins/form-daterangepicker/daterangepicker-bs3.css' />
    <link rel='stylesheet' type='text/css' href='assets/js/jqueryui.css' />
    <link rel='stylesheet' type='text/css' href='assets/plugins/codeprettifier/prettify.css' />
    <link rel='stylesheet' type='text/css' href='assets/plugins/form-toggle/toggles.css' />

    <link rel='stylesheet' type='text/css' href='assets/css/bootstrap.min.css' />
    <!-- <link rel='stylesheet' type='text/css' href='assets/css/multiple-select.css' /> -->
    <script type="text/javascript" src="assets/js/jquery-1.10.2.min.js"></script>


    <script type='text/javascript' src='assets/js/jqueryui-1.10.3.min.js'></script>
    <script type='text/javascript' src='assets/js/bootstrap.min.js'></script>
    <script type='text/javascript' src='assets/js/enquire.js'></script>
    <script type='text/javascript' src='assets/js/jquery.cookie.js'></script>
    <script type='text/javascript' src='assets/js/jquery.nicescroll.min.js'></script>
    <script type='text/javascript' src='assets/plugins/codeprettifier/prettify.js'></script>
    <script type='text/javascript' src='assets/plugins/easypiechart/jquery.easypiechart.min.js'></script>
    <script type='text/javascript' src='assets/plugins/form-multiselect/js/jquery.multi-select.min.js'></script>
    <script type='text/javascript' src='assets/plugins/sparklines/jquery.sparklines.min.js'></script>
    <script type='text/javascript' src='assets/plugins/form-toggle/toggle.min.js'></script>
    <script type='text/javascript' src='assets/js/placeholdr.js'></script>
    <script type='text/javascript' src='assets/js/application.js'></script>
    <script type='text/javascript' src='assets/plugins/bootbox/bootbox.min.js'></script>
    <script type='text/javascript' src='jquery-ui-timepicker-0.3.3/jquery.ui.timepicker.js'></script>
    <script type='text/javascript' src='assets/plugins/form-daterangepicker/daterangepicker.min.js'></script>
    <script type='text/javascript' src='assets/plugins/bootbox/bootbox.min.js'></script>
    <script type='text/javascript' src='assets/plugins/form-datepicker/js/bootstrap-datepicker.js'></script>
    <script type='text/javascript' src='assets/plugins/form-typeahead/typeahead.min.js'></script>


    <script type='text/javascript' src='assets/js/jquery.dataTables.min.js'></script>
    <script type='text/javascript' src='assets/js/dataTables.bootstrap.min.js'></script>
    <script type='text/javascript' src='assets/js/dataTables.buttons.min.js'></script>

    <!-- <script type='text/javascript' src='assets/js/multiple-select.js'></script> -->

    <!-- <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.0/Chart.bundle.min.js"></script>
    <!-- <script type="text/javascript" src="assets/js/less.js"></script> -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>
    <script>
        $(document).ready(function() {

            revenue_accumulated();
            revenue_target();
            estimate_revenue_from_order();
            invoice_summary();

            Chart.pluginService.register({
                beforeRender: function (chart) {
                    if (chart.config.options.showAllTooltips) {
                        // create an array of tooltips
                        // we can't use the chart tooltip because there is only one tooltip per chart
                        chart.pluginTooltips = [];
                        chart.config.data.datasets.forEach(function (dataset, i) {
                            chart.getDatasetMeta(i).data.forEach(function (sector, j) {
                                chart.pluginTooltips.push(new Chart.Tooltip({
                                    _chart: chart.chart,
                                    _chartInstance: chart,
                                    _data: chart.data,
                                    _options: chart.options,
                                    _active: [sector]
                                }, chart));
                            });
                        });

                        // turn off normal tooltips
                        chart.options.tooltips.enabled = false;
                    }
                },
                afterDraw: function (chart, easing) {
                    if (chart.config.options.showAllTooltips) {
                        // we don't want the permanent tooltips to animate, so don't do anything till the animation runs atleast once
                        if (!chart.allTooltipsOnce) {
                            if (easing !== 1)
                                return;
                            chart.allTooltipsOnce = true;
                        }

                        // turn on tooltips
                        chart.options.tooltips.enabled = true;
                        Chart.helpers.each(chart.pluginTooltips, function (tooltip) {
                            tooltip.initialize();
                            tooltip.update();
                            // we don't actually need this since we are not animating tooltips
                            tooltip.pivot();
                            tooltip.transition(easing).draw();
                        });
                        chart.options.tooltips.enabled = false;
                    }
                }
            });

        });
        function addCommas(nStr)
        {
            nStr += '';
            x = nStr.split('.');
            x1 = x[0];
            x2 = x.length > 1 ? '.' + x[1] : '';
            var rgx = /(\d+)(\d{3})/;
            while (rgx.test(x1)) {
                x1 = x1.replace(rgx, '$1' + ',' + '$2');
            }
            return x1 + x2;
        }
        function estimate_revenue_from_order() {

            var ctx = document.getElementById('estimate_revenue_from_order').getContext('2d');
            var chart = new Chart(ctx, {
                // The type of chart we want to create
                type: 'line',

                // The data for our dataset
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    datasets: [{
                            label: 'SAB',
                            backgroundColor: 'rgb(246, 0, 65)',
                            borderColor: 'rgb(246, 0, 65)',
                            fill: false,
                            data: []
                        },
                        {
                            label: 'Topre',
                            backgroundColor: 'rgb(83, 95, 246)',
                            borderColor: 'rgb(83, 95, 246)',
                            fill: false,
                            data: []
                        }
                    ]
                },
                // Configuration options go here
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true,
                            }
                        }]
                    },
                    tooltips: {
                        mode: 'index',
                        intersect: false,
                        callbacks: {
                            label: function(tooltipItem, data) {
                                return tooltipItem.yLabel.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","); 
                            }, 
                        },
        
                    },
                    // hover: {
                    //     mode: 'nearest',
                    //     intersect: true
                    // },
                    // tooltips: {
                    //     enabled: false
                    // },
                    hover: {
                        animationDuration: 0
                    },
                    animation: {
                        duration: 1,
                        onComplete: function() {
                            var chartInstance = this.chart,
                                ctx = chartInstance.ctx;

                            ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
                            ctx.textAlign = 'center';
                            ctx.textBaseline = 'bottom';

                            this.data.datasets.forEach(function(dataset, i) {
                                var meta = chartInstance.controller.getDatasetMeta(i);
                                //alert(i);
                                // if (i == 1) {
                                //     ctx.fillStyle = 'rgb(83, 95, 246)';
                                // }
                                meta.data.forEach(function(bar, index) {
                                    
                                    var data = addCommas(dataset.data[index]);
                                    ctx.fillText(data, bar._model.x, bar._model.y - 5);
                                });
                            });
                        }
                    },
                    title: {
                        display: true,
                        text: 'Estimate SAB and Topre revenue from Nissan order <?=$yyear?>'
                    }
                }
            });

            $.post("getajax_dashbord_sale.php", {
                status: "estimate_revenue_from_order",
                yyear : "<?=$yyear?>",
            }).done(function(datas) {
                // alert(datas);
                var bb = datas.split("###", 150);
                var res_sab = bb[0].split("#");
                var res_topre = bb[1].split("#");
                res_sab.forEach(function(entry) {
                    chart.data.datasets[0].data.push(entry);
                    chart.update();
                })
                res_topre.forEach(function(entry) {
                    // alert(entry);
                    // var news = addCommas(entry);
                    // alert(news);
                    chart.data.datasets[1].data.push(entry);
                    chart.update();
                })

            })

        }
        function revenue_target() {

            var ctx = document.getElementById('revenue_target').getContext('2d');
            var chart = new Chart(ctx, {
                // The type of chart we want to create
                type: 'doughnut',

                // The data for our dataset
                data: {
                    labels: ['Target', 'Current'],
                    datasets: [{
                        label: 'Target',
                        backgroundColor: ['rgb(255, 181, 0)','rgb(20, 165, 0)'] ,
                        // borderColor: ['rgb(255, 181, 0)','rgb(20, 165, 0)'],
                        fill: false,
                        data: [ 
                            <?php

                            include "connect.php";
                            $sql_target = "SELECT data_display FROM tbdashboard_sale_revenue_target WHERE year='$yyear' ";
                            $res_target = mssql_query($sql_target);
                            $row_target = mssql_fetch_array($res_target);
                            $data_display_target = $row_target["data_display"];
                        
                        
                            $total_sales = 0;
                            for($i=1;$i<=12;$i++){
                        
                                include "connect.php";
                                $sql_db = "SELECT * FROM tbdashboard_sale_revenue where year='$yyear' AND month='$i' ";
                                $res_db = mssql_query($sql_db);
                                $num_db = mssql_num_rows($res_db);
                                if($num_db > 0 ){
                                    $row_db = mssql_fetch_array($res_db);
                                    $data_display = $row_db["data_display"];
                                    $total_sales = $total_sales+$data_display;
                                    
                        
                                }else{
                                    include "connect_inv.php";
                                    $sql = "SELECT        receipt.receipt_no, receipt.receipt_date, detail.inv_no
                                    FROM            tbpo_inv_receipt AS receipt INNER JOIN
                                                            tbpo_inv_receipt_detail AS detail ON receipt.receipt_no = detail.receipt_no
                                    WHERE        (MONTH(receipt.receipt_date) = '$i') AND (YEAR(receipt.receipt_date) = '$yyear')
                                    ";
                                    $res = mssql_query($sql);
                                    while($row = mssql_fetch_array($res)){
                                        $inv_no = $row["inv_no"];
                            
                                        $sql_inv = "SELECT sum(amount) as sum_amount FROM tbpo_invoice_detial WHERE doc_no='$inv_no' ";
                                        $res_inv = mssql_query($sql_inv);
                                        $row_inv = mssql_fetch_array($res_inv);
                                        $sum_amount = $row_inv["sum_amount"];
                            
                                        $total_sales = $total_sales+$sum_amount;
                                    }
                                    
                                }
                            }
                        
                            $percent_sales = round(($total_sales*100)/$data_display_target,2);
                            $percent_target = round(100-$percent_sales,2);
                            echo "$percent_target,$percent_sales";
                            ?>
                        ],
                        
                    }]
                },
                // Configuration options go here
                options: {
                    showAllTooltips: true,
                    title: {
                        display: true,
                        text: 'Sales Target <?=$yyear?>'
                    }
                }
            });

            // $.post("getajax_dashbord_sale.php", {
            //     status: "revenue_target",
            //     yyear : "<?=$yyear?>",
            // }).done(function(datas) {
            //     var bb = datas.split("###", 150);
            //     // alert(bb[0]);
            //     bb.forEach(function(entry) {
                    
            //         chart.data.datasets[0].data.push(entry);
            //         chart.update();
            //     });

            // });

        }
        function revenue_accumulated() {

            var ctx = document.getElementById('revenue_accumulated').getContext('2d');
            var chart = new Chart(ctx, {
                // The type of chart we want to create
                
                type: 'bar',
                // The data for our dataset
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    datasets: [
                        // {
                        //     label: 'Accumulated',
                        //     backgroundColor: 'rgb(246, 0, 65)',
                        //     borderColor: 'rgb(246, 0, 65)',
                        //     yAxisID: 'Accumulated',
                        //     fill: false,
                        //     data: [],
                        //     type: 'line'
                        // },
                        {
                            
                            label: 'Revenue',
                            backgroundColor: 'rgb(83, 95, 246)',
                            borderColor: 'rgb(83, 95, 246)',
                            fill: false,
                            data: [],
                            
                        },
                    ]
                },
                // Configuration options go here
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true,
                                // callback: function (value) {
                                //     return numeral(value).format('0,0')
                                // }
                            }
                        }]
                        // yAxes: [{
                        //     id: 'Revenue',
                        //     position: 'left',
                        // }, {
                        //     id: 'Accumulated',
                        //     position: 'right',
                        //     ticks: {
                        //         max: 100,
                        //         min: 0
                        //     },
                        //     gridLines: {
                        //         display: false
                        //     }
                        // }]
                    },
                    
                    tooltips: {
                        mode: 'index',
                        intersect: false,
                        enabled: true,
                        callbacks: {
                            label: function(tooltipItem, data) {
                                return tooltipItem.yLabel.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","); 
                            }, 
                        },
        
                    },
                    // hover: {
                    //     mode: 'nearest',
                    //     intersect: true
                    // },
                    // tooltips: {
                    //     enabled: false
                    // },
                    hover: {
                        animationDuration: 1
                    },
                    animation: {
                        duration: 1,
                        onComplete: function() {
                            var chartInstance = this.chart,
                                ctx = chartInstance.ctx;

                            ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
                            ctx.textAlign = 'center';
                            ctx.textBaseline = 'bottom';

                            this.data.datasets.forEach(function(dataset, i) {
                                var meta = chartInstance.controller.getDatasetMeta(i);
                                //alert(i);
                                if (i == 1) {
                                    ctx.fillStyle = 'rgb(83, 95, 246)';
                                }

                                meta.data.forEach(function(bar, index) {
                                    var data = addCommas(dataset.data[index]);
                                    ctx.fillText(data, bar._model.x, bar._model.y - 5);
                                });
                            });
                        }
                    },
                    title: {
                        display: true,
                        text: 'Revenue <?=$yyear?>'
                    }
                    
                }
            });

            $.post("getajax_dashbord_sale.php", {
                status: "revenue_accumulated",
                yyear : "<?=$yyear?>",
            }).done(function(datas) {
                // alert(datas);
                var bb = datas.split("###", 150);
                var res_1 = bb[0].split("#");
                // var res_2 = bb[1].split("#");
                res_1.forEach(function(entry) {
                    chart.data.datasets[0].data.push(entry);
                    chart.update();
                })
                // res_2.forEach(function(entry) {
                //     // alert(entry);
                //     // var news = addCommas(entry);
                //     // alert(news);
                //     chart.data.datasets[0].data.push(entry);
                //     chart.update();
                // })

            })

        }

        function invoice_summary(){
            /// invoice sum dashboard
            var ctx = document.getElementById('invoice_summary').getContext('2d');
            var chart = new Chart(ctx, {
                // The type of chart we want to create
                
                type: 'bar',
                
                // The data for our dataset
                data: {
                    
                    labels: [<?
                                $db="dinvb";
                                $sql=mssql_connect($host,$username,$password) or die("Cannot connect");
                                mssql_select_db($db);
                                
                    $select_wk = "SELECT nickname,sum(total_grand) as total_grand from View_summary_invoice WHERE  MONTH(create_date) = $mmonth and YEAR(create_date)=$yyear
        group by nickname
        order by total_grand desc ";
                        $re_wk = mssql_query($select_wk);
                        while($row_wk = mssql_fetch_array($re_wk)){
                            echo "'".$row_wk['nickname']."'";
                            echo ",";
                            }
                            echo "'Total'";
                    
                    ?>],
                    datasets: [{
                            label: 'Invoice',
                            backgroundColor: 'rgb(255, 153, 51)',
                            borderColor: 'rgb(255, 153, 51)',
                            data:[ <?
                            
                        $select_wk = "SELECT nickname,sum(total_grand) as total_grand from View_summary_invoice WHERE  MONTH(create_date) = $mmonth and YEAR(create_date)=$yyear
        group by nickname
        order by total_grand desc ";
                        $re_wk = mssql_query($select_wk);
                        while($row_wk = mssql_fetch_array($re_wk)){
                            echo $row_wk['total_grand'];
                            echo ", ";
                        }
                        $select_wk = "SELECT sum(total_grand) as total_grand from View_summary_invoice WHERE  MONTH(create_date) = $mmonth and YEAR(create_date)=$yyear";
                        $re_wk = mssql_query($select_wk);
                        $row_wk = mssql_fetch_array($re_wk);
                        
                            echo $row_wk['total_grand'];
                            echo ", ";
                        
                        
                        
                    ?>]
                    }]  
                        
                
                },

                // Configuration options go here
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true,
                                callback: function(value, index, values) {
                                return value.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
                                }
                            }
                        }]
                    },
                    tooltips: {
                        enabled: false
                    },
                    hover: {
                        animationDuration: 0
                    },
                    animation: {
                        duration: 1,
                        onComplete: function () {
                            var chartInstance = this.chart,
                            ctx = chartInstance.ctx;

                            ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
                            ctx.textAlign = 'center';
                            ctx.textBaseline = 'bottom';

                            this.data.datasets.forEach(function (dataset, i) {
                                var meta = chartInstance.controller.getDatasetMeta(i);
                                //alert(i);
                                if(i==1){
                                    ctx.fillStyle = '#000';
                                }
                                meta.data.forEach(function (bar, index) {
                                    var data = dataset.data[index];             
                                    data = data.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");                   
                                    ctx.fillText(data, bar._model.x, bar._model.y - 5);
                                });
                            });
                        }
                    },
                    title: {
                    display: true,
                    text: 'Invoice <?=$arr_month[$mmonth]?> <?=$yyear?>'
                }
                }
            });
            /// invoice sum dashboard
        }
    </script>
</head>

<body class=" ">


    <div id="headerbar">
        <div class="container">

        </div>
    </div>

    <header class="navbar navbar-inverse navbar-fixed-top" role="banner">
        <a id="leftmenu-trigger" class="tooltips" data-toggle="tooltip" data-placement="right" title="Toggle Sidebar"></a>


        <div class="navbar-header pull-left">

        </div>

        <ul class="nav navbar-nav pull-right toolbar">
        </ul>
    </header>

    <div id="page-container">
        <!-- BEGIN SIDEBAR -->
        <nav id="page-leftbar" role="navigation">
            <!-- BEGIN SIDEBAR MENU -->
            <? include("menu.php");  ?>

            <!-- END SIDEBAR MENU -->
        </nav>

        <!-- BEGIN RIGHTBAR -->
        <div id="page-rightbar">
        </div>
        <!-- END RIGHTBAR -->

        <div id="page-content">
            <div id='wrap'>
                <div id="page-heading">
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <?php
                            include "connect_inv.php";
                            $sql_customer = "SELECT count(id) as total_customer FROM tbpo_inv_cus";
                            $res_customer = mssql_query($sql_customer);
                            $row_customer = mssql_fetch_array($res_customer);
                            $total_customer = $row_customer["total_customer"];
                            
                            $sql_sup = "SELECT count(id) as total_sup FROM m_sup";
                            $res_sup = mssql_query($sql_sup);
                            $row_sup = mssql_fetch_array($res_sup);
                            $total_sup = $row_sup["total_sup"];

                            ?>
                            <div class="row">
                                <div class="col-md-3 col-xs-12 col-sm-6">
                                    <a class="info-tiles tiles-success" target='_blank' href="http://ipack-iwis.com/inv/view_customer.php">
                                        <div class="tiles-heading">Customer</div>
                                        <div class="tiles-body-alt">
                                            <i class="fa fa-group"></i>
                                            <div class="text-center"><?=$total_customer?></div>
                                            <small>Total Customer</small>
                                        </div>
                                        <div class="tiles-footer">See More </div>
                                    </a>
                                </div>
                                <div class="col-md-3 col-xs-12 col-sm-6">
                                    <a class="info-tiles tiles-orange" target='_blank'  href="http://ipack-iwis.com/inv/mat_sup.php">
                                        <div class="tiles-heading">Supplier</div>
                                        <div class="tiles-body-alt">
                                            <i class="fa fa-shopping-cart"></i>
                                            <div class="text-center"><?=$total_sup?></div>
                                            <small>Total supplier</small>
                                        </div>
                                        <div class="tiles-footer">See more</div>
                                    </a>
                                </div>
                                <div class="col-md-3 col-xs-12 col-sm-6">
                                    <a class="info-tiles tiles-warning" target='_blank'  href="#">
                                        <div class="tiles-heading">X</div>
                                        <div class="tiles-body-alt">
                                            
                                            <div class="text-center">x</div>
                                            <small>Total X</small>
                                        </div>
                                        <div class="tiles-footer">See more</div>
                                    </a>
                                </div>
                                <div class="col-md-3 col-xs-12 col-sm-6">
                                    <a class="info-tiles tiles-danger" target='_blank'  href="#">
                                        <div class="tiles-heading">X</div>
                                        <div class="tiles-body-alt">
                                            
                                            <div class="text-center">x</div>
                                            <small>Total X</small>
                                        </div>
                                        <div class="tiles-footer">See more</div>
                                    </a>
                                </div>
                               
                            </div>
                        </div>
                    </div>
                    <!-- Row 1 -->
                    <div class="row">
                        <div class="col-sm-12">
                            <?$arrmonth = array('', 'JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN', 'JULY', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC');?>
                            <div class="form-inline">
                                <div class="form-group">
                                    <label for="mmonth">Month:</label>
                                    <select id="mmonth" class="form-control" >
                                        <?
                                        for ($i = 1; $i < sizeof($arrmonth); $i++) {
                                        ?>
                                            <option value="<?= $i ?>" 
                                            <?
                                            if ($mmonth == $i) {
                                            ?> selected<?
                                                    }
                                                ?>><?= $arrmonth[$i] ?></option>
                                        <?
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="yyear">Years:</label>
                                    <select id="yyear" class="form-control" >
                                        <option value="">Year</option>
                                        <?

                                        for ($i = $yyear_period; $i < $yyear_period + 5; $i++) {
                                        ?>
                                            <option value="<?= $i ?>" 
                                                <? if ($yyear == $i) { ?> selected<? }  ?>
                                                ><?= $i ?>
                                            </option>
                                        <?
                                        }
                                        ?>



                                    </select>
                                </div>
                                <button type="submit" class="btn btn-info" onclick="location='dashboard_sale.php?mmonth='+document.getElementById('mmonth').value+'&yyear='+document.getElementById('yyear').value+''">Search</button>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="panel panel-info">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-12 clearfix">
                                            <!-- <h4 class="pull-left" style="margin: 0 0 20px;">Revenue And Accumulated <?=$yyear?></h4>
                                            <div class="btn-group pull-right">
                                            </div> -->
                                        </div>
                                        <div class="col-md-12">
                                            <canvas id="revenue_accumulated"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="panel panel-info">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-12 clearfix">
                                            <!-- <h4 class="pull-left" style="margin: 0 0 20px;"></h4>
                                            <div class="btn-group pull-right">
                                            </div> -->
                                        </div>
                                        <div class="col-md-12">
                                            <canvas id="revenue_target"></canvas>
                                        </div>
                                    </div>
                                    <?
                                    // $total_sales = 0;
                                    // for($i=1;$i<=12;$i++){

                                    //     include "connect.php";
                                    //     $sql_db = "SELECT * FROM tbdashboard_sale_revenue where year='$yyear' AND month='$i' ";
                                    //     $res_db = mssql_query($sql_db);
                                    //     $num_db = mssql_num_rows($res_db);
                                    //     if($num_db > 0 ){
                                    //         $row_db = mssql_fetch_array($res_db);
                                    //         $data_display = $row_db["data_display"];
                                    //         $total_sales = $total_sales+$data_display;
                                            
    
                                    //     }else{
                                    //         include "connect_inv.php";
                                    //         $sql = "SELECT        receipt.receipt_no, receipt.receipt_date, detail.inv_no
                                    //         FROM            tbpo_inv_receipt AS receipt INNER JOIN
                                    //                                 tbpo_inv_receipt_detail AS detail ON receipt.receipt_no = detail.receipt_no
                                    //         WHERE        (MONTH(receipt.receipt_date) = '$i') AND (YEAR(receipt.receipt_date) = '$yyear')
                                    //         ";
                                    //         $res = mssql_query($sql);
                                    //         while($row = mssql_fetch_array($res)){
                                    //             $inv_no = $row["inv_no"];
                                    
                                    //             $sql_inv = "SELECT sum(amount) as sum_amount FROM tbpo_invoice_detial WHERE doc_no='$inv_no' ";
                                    //             $res_inv = mssql_query($sql_inv);
                                    //             $row_inv = mssql_fetch_array($res_inv);
                                    //             $sum_amount = $row_inv["sum_amount"];
                                    
                                    //             $total_sales = $total_sales+$sum_amount;
                                    //         }
                                            
                                    //     }
                                    // }

                                    // include "connect.php";
                                    // $sql_target = "SELECT data_display FROM tbdashboard_sale_revenue_target WHERE year='$yyear' ";
                                    // $res_target = mssql_query($sql_target);
                                    // $row_target = mssql_fetch_array($res_target);
                                    // $data_display = $row_target["data_display"];
                                        ?>
                                    <br>
                                    Target : <?=number_format($data_display_target,2)?> Bath<br>
                                    Current Sales : <?=number_format($total_sales,2)?> Bath

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Row 2 -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="panel panel-info">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-12 clearfix">
                                            <!-- <h4 class="pull-left" style="margin: 0 0 20px;"></h4>
                                            <div class="btn-group pull-right">
                                            </div> -->
                                        </div>
                                        <div class="col-md-12">
                                            <canvas id="estimate_revenue_from_order"></canvas>
                                        </div>
                                    </div>
                                    <?php
                                        include "connect_hq.php";
                                        $sql_sab = "SELECT top 1 convert(varchar, DeliveryOrderDate, 103)as DeliveryOrderDate_date
                                            FROM tbsaborder
                                            order by DeliveryOrderDate desc";
                                        $res_sab = mssql_query($sql_sab);
                                        $row_sab = mssql_fetch_array($res_sab);
                                        $DeliveryOrderDate_date_sab = $row_sab["DeliveryOrderDate_date"];

                                        include "connect_topre.php";
                                        $sql_topre = "SELECT top 1 convert(varchar, DeliveryOrderDate, 103)as DeliveryOrderDate_date
                                            FROM tbsaborder
                                            order by DeliveryOrderDate desc";
                                        $res_topre = mssql_query($sql_topre);
                                        $row_topre = mssql_fetch_array($res_topre);
                                        $DeliveryOrderDate_date_topre = $row_topre["DeliveryOrderDate_date"];
                                    ?>
                                    Last order SAB : <?= $DeliveryOrderDate_date_sab ?>
                                    <br>
                                    Last order Topre : <?= $DeliveryOrderDate_date_topre ?>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="panel panel-grape">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-12 clearfix">
                                            <h4 class="pull-left" style="margin: 0 0 20px;"></h4>
                                            <div class="btn-group pull-right">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <canvas id="county"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Row 3 -->
                    <!-- Row 2 -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="panel panel-info">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-12 clearfix">
                                            <!-- <h4 class="pull-left" style="margin: 0 0 20px;"></h4>
                                            <div class="btn-group pull-right">
                                            </div> -->
                                        </div>
                                        <div class="col-md-12">
                                            <canvas id="invoice_summary"></canvas>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="panel panel-grape">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-12 clearfix">
                                            <h4 class="pull-left" style="margin: 0 0 20px;"></h4>
                                            <div class="btn-group pull-right">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <canvas id="county"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Row 3 -->



                </div> <!-- container -->
            </div>
            <!--wrap -->
        </div> <!-- page-content -->

        <footer role="contentinfo">
            <div class="clearfix">
                <ul class="list-unstyled list-inline">
                    <li>I-Wis</li>
                    <button class="pull-right btn btn-inverse-alt btn-xs hidden-print" id="back-to-top"><i class="fa fa-arrow-up"></i></button>
                </ul>
            </div>
        </footer>

    </div> <!-- page-container -->

</body>

</html>