<?
session_start();
include("connect.php");
include("library.php");

$status = $_REQUEST['status'];
//echo $_SESSION['admin_userid'];
$arr_month = array('', 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'July', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');

$yyear_period = date("Y", strtotime("- 3 years"));
$mmonth = $_GET['mmonth'];

$current_year = date("Y");
if ($mmonth == '') {
    $mmonth = date("n");
    $yyear = date("Y");
    // echo $yyear_period;
}else{
    $mmonth = $_GET['mmonth'];
    $yyear = $_GET['yyear'];
}
// echo $mmonth;

$master_color = array(
    'TR' => "rgb(255,246,143)",
    'HH' => "rgb(255,188,143)",
    'QH' => "rgb(148,214,149)",
    'SS' => "rgb(253,135,135)",
    '6H' => "rgb(187,253,135)",
    'MM' => "rgb(135,161,253)",
    'AH' => "rgb(128,223,158)",
    'SP' => "rgb(255,74,146)",
    'UH' => "rgb(222,255,247)",
    'DH' => "rgb(208,251,131)",
    'CA' => "rgb(251,167,131)",
    'CC' => "rgb(28,154,249)",
    'QQ' => "rgb(28,249,199)",
    'CH' => "rgb(206,176,160)",
    'RH' => "rgb(124,104,176)",
    'JP' => "rgb(231,121,84)",
    'XH' => "rgb(231,176,84)",
    'MH' => "rgb(251,121,199)",
);
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

    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.0/Chart.bundle.min.js"></script> -->
    <!-- <script type="text/javascript" src="assets/js/less.js"></script> -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script>
        $(document).ready(function() {
			revenue_accumulated_customer();
            revenue_target();
//            estimate_revenue_from_order();
//            invoice_summary();
//            invoice_summary_percent();
//            compare_three_years();
//            google.charts.load('current', {'packages':['corechart']});
//            google.charts.setOnLoadCallback(type_of_business);
//            google.charts.setOnLoadCallback(sab_order_type_county);
//            google.charts.setOnLoadCallback(sab_order_type_packaging);
//            google.charts.setOnLoadCallback(topre_order_type_county);
//            google.charts.setOnLoadCallback(topre_order_type_packaging);
			

            // revenue_accumulated();
            
            // type_of_business();
            // type_of_business_percent();
            // sab_order_type_county();
            // sab_order_type_packaging();
            // topre_order_type_county();
            // topre_order_type_packaging();
			
			

            // Chart.pluginService.register({
            //     beforeRender: function (chart) {
            //         if (chart.config.options.showAllTooltips) {
            //             // create an array of tooltips
            //             // we can't use the chart tooltip because there is only one tooltip per chart
            //             chart.pluginTooltips = [];
            //             chart.config.data.datasets.forEach(function (dataset, i) {
            //                 chart.getDatasetMeta(i).data.forEach(function (sector, j) {
            //                     chart.pluginTooltips.push(new Chart.Tooltip({
            //                         _chart: chart.chart,
            //                         _chartInstance: chart,
            //                         _data: chart.data,
            //                         _options: chart.options,
            //                         _active: [sector]
            //                     }, chart));
            //                 });
            //             });

            //             // turn off normal tooltips
            //             chart.options.tooltips.enabled = false;
            //         }
            //     },
            //     afterDraw: function (chart, easing) {
            //         if (chart.config.options.showAllTooltips) {
            //             // we don't want the permanent tooltips to animate, so don't do anything till the animation runs atleast once
            //             if (!chart.allTooltipsOnce) {
            //                 if (easing !== 1)
            //                     return;
            //                 chart.allTooltipsOnce = true;
            //             }

            //             // turn on tooltips
            //             chart.options.tooltips.enabled = true;
            //             Chart.helpers.each(chart.pluginTooltips, function (tooltip) {
            //                 tooltip.initialize();
            //                 tooltip.update();
            //                 // we don't actually need this since we are not animating tooltips
            //                 tooltip.pivot();
            //                 tooltip.transition(easing).draw();
            //             });
            //             chart.options.tooltips.enabled = false;
            //         }
            //     }
            // });

        });
         function revenue_accumulated_customer() {

            var ctx = document.getElementById('revenue_accumulated_customer').getContext('2d');
            var chart = new Chart(ctx, {
                // The type of chart we want to create
                
                type: 'bar',
                // The data for our dataset
                data: {
                    labels: [
                        <?php
                        $db="dinvb";
                        $sql=mssql_connect($host,$username,$password) or die("Cannot connect");
                        mssql_select_db($db);
                                
                        $select_wk = "SELECT nickname,sum(total_grand) as total_grand from View_summary_invoice_cn_create_date 
                        WHERE  YEAR(create_date)=$yyear
                        AND Month(create_date)<=$mmonth
                        group by nickname
                        order by total_grand desc ";
                        $re_wk = mssql_query($select_wk);
                        while($row_wk = mssql_fetch_array($re_wk)){
                            echo "'".$row_wk['nickname']."'";
                            echo ",";
                        }
                        ?>
                    ],
                    datasets: [
                        {
                            
                            label: 'Revenue',
                            backgroundColor: 'rgb(22, 142, 0)',
                            borderColor: 'rgb(22, 142, 0)',
                            fill: false,
                            data: [
                                <?
                            
                                $select_wk = "SELECT nickname,sum(total_grand) as total_grand 
                                from View_summary_invoice_cn_create_date 
                                WHERE  YEAR(create_date)=$yyear
                                AND Month(create_date)<=$mmonth
                                group by nickname
                                order by total_grand desc ";
                                $re_wk = mssql_query($select_wk);
                                while($row_wk = mssql_fetch_array($re_wk)){
                                //    echo number_format($row_wk['total_grand']/1000000,2);
									 echo $row_wk['total_grand'];
                                    echo ", ";
                                }
                                // $select_wk = "SELECT sum(total_grand) as total_grand from View_summary_invoice_cn_create_date WHERE  MONTH(create_date) = $mmonth and YEAR(create_date)=$yyear";
                                // $re_wk = mssql_query($select_wk);
                                // $row_wk = mssql_fetch_array($re_wk);
                                
                                //     echo number_format($row_wk['total_grand']/1000000,2);
                                //     echo ", ";
                                
                                
                                
                            ?>
                            ],
                            
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
                        enabled: false,
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
                                    ctx.fillStyle = 'rgb(22, 142, 0)';
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
                        text: 'Revenue by customer Jan <?=$yyear?> - <?=$arr_month[$mmonth]?> <?=$yyear?>'
                    }
                    
                }
            });

            // $.post("getajax_dashbord_sale.php", {
            //     status: "revenue_accumulated",
            //     yyear : "<?=$yyear?>",
            // }).done(function(datas) {
            //     // alert(datas);
            //     var bb = datas.split("###", 150);
            //     var res_1 = bb[0].split("#");
            //     // var res_2 = bb[1].split("#");
            //     res_1.forEach(function(entry) {
            //         chart.data.datasets[0].data.push(entry);
            //         chart.update();
            //     })
            //     // res_2.forEach(function(entry) {
            //     //     // alert(entry);
            //     //     // var news = addCommas(entry);
            //     //     // alert(news);
            //     //     chart.data.datasets[0].data.push(entry);
            //     //     chart.update();
            //     // })

            // })

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
                            include "connect_inv.php";
                            $sql = "SELECT        SUM(total_grand) AS total_sales
                            FROM            View_summary_invoice_cn_create_date
                            WHERE  YEAR(create_date) ='$yyear'
                            AND Month(create_date) <='$mmonth'";
                            $res = mssql_query($sql);
                            $row = mssql_fetch_array($res);
                            $total_sales = $row["total_sales"];
                        
                            $percent_sales = round(($total_sales*100)/$data_display_target,2);
                            $percent_target = round(100-$percent_sales,2);
                            echo "$percent_target,$percent_sales";
                            ?>
                        ],
                        
                    }]
                },
                // Configuration options go here
                options: {
                    // showAllTooltips: true,
                    title: {
                        display: true,
                        text: 'Sales Target <?=$arr_month[$mmonth]?> <?=$yyear?>'
                    },
                    tooltips: {
                        callbacks: {
                            // i = 0;
                            label: function(tooltipItem, data) {
                                var label = data.datasets[tooltipItem.datasetIndex].label || '';

                                // console.log(data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index]);
                                return data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index]+' %';
                            }
                        },
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
                            
                            $sql_customer_new = "SELECT count(id) as total_customer_new FROM tbpo_inv_cus WHERE MONTH(create_date)='$mmonth' AND YEAR(create_date)='$yyear'";
                            $res_customer_new = mssql_query($sql_customer_new);
                            $row_customer_new = mssql_fetch_array($res_customer_new);
                            $total_customer_new = $row_customer_new["total_customer_new"];
                            
                            $sql_sup = "SELECT count(id) as total_sup FROM m_sup";
                            $res_sup = mssql_query($sql_sup);
                            $row_sup = mssql_fetch_array($res_sup);
                            $total_sup = $row_sup["total_sup"];

                            $sql_sup_new = "SELECT count(id) as total_sup_new FROM m_sup WHERE MONTH(create_date)='$mmonth' AND YEAR(create_date)='$yyear'";
                            $res_sup_new = mssql_query($sql_sup_new);
                            $row_sup_new = mssql_fetch_array($res_sup_new);
                            $total_sup_new = $row_sup_new["total_sup_new"];

                            ?>
                            <div class="row">
                                <div class="col-md-3 col-xs-12 col-sm-6">
                                    <a class="info-tiles tiles-warning" target='_blank' href="http://ipack-iwis.com/inv/view_customer.php">
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
                                    <a class="info-tiles tiles-success" target='_blank'  href="http://ipack-iwis.com/inv/view_customer.php">
                                        <div class="tiles-heading">New Customer</div>
                                        <div class="tiles-body-alt">
                                            
                                            <div class="text-center"><?=$total_customer_new?></div>
                                            <small>Month <?=$arr_month[$mmonth]?></small>
                                        </div>
                                        <div class="tiles-footer">See more</div>
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
                                    <a class="info-tiles tiles-danger" target='_blank'   href="http://ipack-iwis.com/inv/mat_sup.php">
                                        <div class="tiles-heading">New Supplier</div>
                                        <div class="tiles-body-alt">
                                            
                                            <div class="text-center"><?=$total_sup_new?></div>
                                            <small>Month <?=$arr_month[$mmonth]?></small>
                                        </div>
                                        <div class="tiles-footer">See more</div>
                                    </a>
                                </div>
                               
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <?
                            
                            ?>
                            <div class="form-inline">
                                <div class="form-group">
                                    <label for="mmonth">Month:</label>
                                    <select id="mmonth" class="form-control" >
                                        <?
                                        for ($i = 1; $i < sizeof($arr_month); $i++) {
                                        ?>
                                            <option value="<?= $i ?>" 
                                            <?
                                            if ($mmonth == $i) {
                                            ?> selected<?
                                                    }
                                                ?>><?= $arr_month[$i] ?></option>
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

                    <!-- Row revenue Compare 3 years -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-info">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-12 clearfix">
                                            <!-- <h4 class="pull-left" style="margin: 0 0 20px;"></h4>
                                            <div class="btn-group pull-right">
                                            </div> -->
                                        </div>
                                        <div class="col-md-12">
                                            <canvas id="compare_three_years"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <!-- Row revenue Compare 3 years -->

                    <!-- Row revenue -->
                    <div class="row">
                        <div class="col-md-6">
                            <!-- <div class="panel panel-info">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-12 clearfix">
                                        </div>
                                        <div class="col-md-12">
                                            <canvas id="revenue_accumulated"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                            <div class="panel panel-info">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-12 clearfix">
                                            <!-- <h4 class="pull-left" style="margin: 0 0 20px;">Revenue And Accumulated <?=$yyear?></h4>
                                            <div class="btn-group pull-right">
                                            </div> -->
                                        </div>
                                        <div class="col-md-12">
                                            <canvas id="revenue_accumulated_customer"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <!-- <br>  <br>  <br>   -->
                            <div class="panel panel-info">
                                <div class="panel-body" >
                                    <!-- style="height:600px"  mt-5 -->
                                    <div class="row">
                                        <div class="col-md-12 clearfix">
                                            <!--<h4 class="pull-left" style="margin: 0 0 20px;"></h4>
                                             <div class="btn-group pull-right">
                                            </div>  -->
                                        </div>
                                        <div class="col-md-12">
                                            <canvas id="revenue_target"></canvas>
                                        </div>
                                    </div>
                                    <br><br>
                                    Target <?=$yyear?> : <?=number_format($data_display_target,2)?> Bath<br>
                                    Sales <?=$arr_month[$mmonth]?> <?=$yyear?> : <?=number_format($total_sales,2)?> Bath

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Row revenue -->

                    <!-- Row invoice-->
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
                            <div class="panel panel-info">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-12 clearfix">
                                            <!-- <h4 class="pull-left" style="margin: 0 0 20px;"></h4>
                                            <div class="btn-group pull-right">
                                            </div> -->
                                        </div>
                                        <div class="col-md-12">
                                            <canvas id="invoice_summary_percent"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Row invoice-->

                    <!-- Row type of business -->
                    <div class="row">
                        <div class="col-md-offset-2 col-md-8">
                            <div class="panel panel-info">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-12 clearfix">
                                            <!-- <h4 class="pull-left" style="margin: 0 0 20px;"></h4>
                                            <div class="btn-group pull-right">
                                            </div> -->
                                        </div>
                                        <div class="col-md-12">
                                            <!-- <canvas id="type_of_business"></canvas> -->
                                            <div id="type_of_business" style="width: 100%; height: 400px;"></div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                        <!-- <div class="col-md-6">
                            <div class="panel panel-info">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-12 clearfix">
                                        </div>
                                        <div class="col-md-12">
                                            <canvas id="type_of_business_percent"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                    </div>
                    <!-- Row type of business -->
                    
                    <!-- Row sab order type -->
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
                                            <div id="sab_order_type_county" style="width: 100%; height: 400px;"></div>
                                            <!-- <canvas id="sab_order_type_county"></canvas> -->
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
                                            <div id="sab_order_type_packaging" style="width: 100%; height: 400px;"></div>
                                            <!-- <canvas id="sab_order_type_packaging"></canvas> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Row sab order type -->
                    <!-- Row topre sab order type -->
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
                                            <div id="topre_order_type_county" style="width: 100%; height: 400px;"></div>
                                            <!-- <canvas id="topre_order_type_county"></canvas> -->
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
                                            <div id="topre_order_type_packaging" style="width: 100%; height: 400px;"></div>
                                            <!-- <canvas id="topre_order_type_packaging"></canvas> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Row topre sab order type -->

                    <!-- Row estimate_revenue_from_order -->
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

                                        $sql_sab_kd = "SELECT top 1 convert(varchar, DeliveryOrderDate, 103)as DeliveryOrderDate_date
                                            FROM tbsaborder_kd
                                            order by DeliveryOrderDate desc";
                                        $res_sab_kd = mssql_query($sql_sab_kd);
                                        $row_sab_kd = mssql_fetch_array($res_sab_kd);
                                        $DeliveryOrderDate_date_sab_kd = $row_sab_kd["DeliveryOrderDate_date"];

                                        include "connect_topre.php";
                                        $sql_topre = "SELECT top 1 convert(varchar, DeliveryOrderDate, 103)as DeliveryOrderDate_date
                                            FROM tbsaborder
                                            order by DeliveryOrderDate desc";
                                        $res_topre = mssql_query($sql_topre);
                                        $row_topre = mssql_fetch_array($res_topre);
                                        $DeliveryOrderDate_date_topre = $row_topre["DeliveryOrderDate_date"];
                                    ?>
                                    Last order SAB IPO: <?= $DeliveryOrderDate_date_sab ?>
                                    <br>
                                    Last order SAB KD : <?= $DeliveryOrderDate_date_sab_kd ?>
                                    <br>
                                    Last order Topre : <?= $DeliveryOrderDate_date_topre ?>

                                </div>
                            </div>
                        </div>
                        <!-- <div class="col-md-6">
                            <div class="panel panel-info">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-12 clearfix">
                                        </div>
                                        <div class="col-md-12">
                                            <div id="type_of_business_ver2" style="width: 100%; height: 300px;"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                    </div>
                    <!-- Row estimate_revenue_from_order -->

                  

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