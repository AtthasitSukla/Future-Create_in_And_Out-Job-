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
    'XH' => "rgb(231,121,84)",
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

            revenue_accumulated();
            revenue_accumulated_customer();
            revenue_target();
            estimate_revenue_from_order();
            invoice_summary();
            invoice_summary_percent();
            // type_of_business();
            // type_of_business_percent();
            // sab_order_type_county();
            // sab_order_type_packaging();
            // topre_order_type_county();
            // topre_order_type_packaging();
            compare_three_years();

            google.charts.load('current', {'packages':['corechart']});
            google.charts.setOnLoadCallback(type_of_business);
            google.charts.setOnLoadCallback(sab_order_type_county);
            google.charts.setOnLoadCallback(sab_order_type_packaging);
            google.charts.setOnLoadCallback(topre_order_type_county);
            google.charts.setOnLoadCallback(topre_order_type_packaging);

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
                            FROM            View_summary_invoice_create_date
                            WHERE  YEAR(create_date) ='$yyear'";
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
                        text: 'Sales Target <?=$yyear?>'
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
                                
                        $select_wk = "SELECT nickname,sum(total_grand) as total_grand from View_summary_invoice_create_date WHERE  YEAR(create_date)=$yyear
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
                            backgroundColor: 'rgb(83, 95, 246)',
                            borderColor: 'rgb(83, 95, 246)',
                            fill: false,
                            data: [
                                <?
                            
                                $select_wk = "SELECT nickname,sum(total_grand) as total_grand from View_summary_invoice_create_date WHERE  YEAR(create_date)=$yyear
                                group by nickname
                                order by total_grand desc ";
                                $re_wk = mssql_query($select_wk);
                                while($row_wk = mssql_fetch_array($re_wk)){
                                    echo number_format($row_wk['total_grand']/1000000,2);
                                    echo ", ";
                                }
                                // $select_wk = "SELECT sum(total_grand) as total_grand from View_summary_invoice_create_date WHERE  MONTH(create_date) = $mmonth and YEAR(create_date)=$yyear";
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
                        text: 'Revenue by customer <?=$yyear?>'
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
        function compare_three_years() {

            var ctx = document.getElementById('compare_three_years').getContext('2d');
            var chart = new Chart(ctx, {
                // The type of chart we want to create
                
                type: 'bar',
                // The data for our dataset
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec', 'AVG'],
                    datasets: [
                        <?php
                        $master_color_compare = array("rgb(83, 95, 246)","rgb(246, 0, 65)","rgb(22, 142, 0)");
                        $previous_years = (int)$current_year-2;
                        $i_color=0;
                        for($i_years=$previous_years;$i_years<=$current_year;$i_years++){
                            // echo $master_color_compare[$i_color]."  $i_color"; 
                            ?>
                            {
                            
                                label: '<?=$i_years?>',
                                backgroundColor: '<?=$master_color_compare[$i_color]?>',
                                borderColor: '<?=$master_color_compare[$i_color]?>',
                                fill: false,
                                data: [],
                            },
                            <?
                            $i_color++;
                        }
                        ?>
                        
                        // {
                        //     label: '2019',
                        //     backgroundColor: 'rgb(246, 0, 65)',
                        //     borderColor: 'rgb(246, 0, 65)',
                        //     fill: false,
                        //     data: [],
                        // },
                        // {
                        //     label: '2020',
                        //     backgroundColor: 'rgb(22, 142, 0)',
                        //     borderColor: 'rgb(22, 142, 0)',
                        //     fill: false,
                        //     data: [],
                            
                        // },
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
                        text: 'Compare 3 Years'
                    }
                    
                }
            });

            $.post("getajax_dashbord_sale.php", {
                status: "compare_three_years",
                yyear : "<?=$yyear?>",
            }).done(function(datas) {
                // alert(datas);
                var bb = datas.split("###", 150);
                var res_1 = bb[0].split("#");
                var res_2 = bb[1].split("#");
                var res_3 = bb[2].split("#");
                res_1.forEach(function(entry) {
                    chart.data.datasets[0].data.push(entry);
                    chart.update();
                })
                res_2.forEach(function(entry) {
                    chart.data.datasets[1].data.push(entry);
                    chart.update();
                })
                res_3.forEach(function(entry) {
                    chart.data.datasets[2].data.push(entry);
                    chart.update();
                })

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
                                
                        $select_wk = "SELECT nickname,sum(total_grand) as total_grand from View_summary_invoice_create_date WHERE  MONTH(create_date) = $mmonth and YEAR(create_date)=$yyear
                        group by nickname
                        order by total_grand desc ";
                        $re_wk = mssql_query($select_wk);
                        while($row_wk = mssql_fetch_array($re_wk)){
                            echo "'".$row_wk['nickname']."'";
                            echo ",";
                            }
                            // echo "'Total'";
                    
                    ?>],
                    datasets: [{
                            label: 'Invoice',
                            backgroundColor: 'rgb(255, 153, 51)',
                            borderColor: 'rgb(255, 153, 51)',
                            data:[ <?
                            
                        $select_wk = "SELECT nickname,sum(total_grand) as total_grand from View_summary_invoice_create_date WHERE  MONTH(create_date) = $mmonth and YEAR(create_date)=$yyear
                        group by nickname
                        order by total_grand desc ";
                        $re_wk = mssql_query($select_wk);
                        while($row_wk = mssql_fetch_array($re_wk)){
                            echo number_format($row_wk['total_grand']/1000000,2);
                            echo ", ";
                        }
                        // $select_wk = "SELECT sum(total_grand) as total_grand from View_summary_invoice_create_date WHERE  MONTH(create_date) = $mmonth and YEAR(create_date)=$yyear";
                        // $re_wk = mssql_query($select_wk);
                        // $row_wk = mssql_fetch_array($re_wk);
                        
                        //     echo number_format($row_wk['total_grand']/1000000,2);
                        //     echo ", ";
                        
                        
                        
                    ?>]
                    }]  
                        
                
                },

                // Configuration options go here
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true,
                                // callback: function(value, index, values) {
                                // return value.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
                                // }
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
                    text: 'Invoice <?=$arr_month[$mmonth]?> <?=$yyear?> (Bath)'
                }
                }
            });
            /// invoice sum dashboard
        }
        function invoice_summary_percent(){
            /// invoice sum dashboard
            var ctx = document.getElementById('invoice_summary_percent').getContext('2d');
            var chart = new Chart(ctx, {
                // The type of chart we want to create
                
                type: 'bar',
                
                // The data for our dataset
                data: {
                    
                    labels: [<?
                                $db="dinvb";
                                $sql=mssql_connect($host,$username,$password) or die("Cannot connect");
                                mssql_select_db($db);
                                
                    $select_wk = "SELECT nickname,sum(total_grand) as total_grand from View_summary_invoice_create_date WHERE  MONTH(create_date) = $mmonth and YEAR(create_date)=$yyear
                        group by nickname
                        order by total_grand desc ";
                        $re_wk = mssql_query($select_wk);
                        while($row_wk = mssql_fetch_array($re_wk)){
                            echo "'".$row_wk['nickname']."'";
                            echo ",";
                        }
                    
                    ?>],
                    datasets: [{
                            label: 'Invoice %',
                            backgroundColor: 'rgb(255, 153, 51)',
                            borderColor: 'rgb(255, 153, 51)',
                            data:[ <?
                            
                        $select_wk = "SELECT nickname,
                        (sum(total_grand)* 100 / (Select sum(total_grand) From View_summary_invoice_create_date WHERE  MONTH(create_date) = $mmonth and YEAR(create_date)=$yyear)) as total_grand
                        from View_summary_invoice_create_date WHERE  MONTH(create_date) = $mmonth and YEAR(create_date)=$yyear
                        group by nickname
                        order by total_grand desc ";
                        $re_wk = mssql_query($select_wk);
                        while($row_wk = mssql_fetch_array($re_wk)){
                            echo number_format($row_wk['total_grand'],2);
                            echo ", ";
                        }
                       
                        
                        
                        
                    ?>]
                    }]  
                        
                
                },

                // Configuration options go here
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true,
                                // callback: function(value, index, values) {
                                // return value.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
                                // }
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
                                    data = data.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")+' %';                   
                                    ctx.fillText(data, bar._model.x, bar._model.y - 5);
                                });
                            });
                        }
                    },
                    title: {
                    display: true,
                    text: 'Invoice <?=$arr_month[$mmonth]?> <?=$yyear?> (Percent)'
                }
                }
            });
            /// invoice sum dashboard
        }
        function type_of_business(){
            <?php
            $total_type_of_business = 0;
            $sql_packing = "SELECT sum(amount) as total_packing FROM View_summary_type_of_business
            WHERE  MONTH(create_date) = $mmonth and YEAR(create_date)=$yyear
            AND (issue_no!='' OR type_of_business='Packing')";
            $res_packing = mssql_query($sql_packing);
            $row_packing = mssql_fetch_array($res_packing);
            $total_packing = $row_packing["total_packing"]==""?0:$row_packing["total_packing"];
            // echo number_format($total_packing/1000000,2);
            // echo ",";

            $sql_trading = "SELECT sum(amount) as total_trading FROM View_summary_type_of_business
            WHERE  MONTH(create_date) = $mmonth and YEAR(create_date)=$yyear
            AND (type_of_business='Trading')";
            $res_trading = mssql_query($sql_trading);
            $row_trading = mssql_fetch_array($res_trading);
            $total_trading = $row_trading["total_trading"]==""?0:$row_trading["total_trading"];
            // echo number_format($total_trading/1000000,2);
            // echo ",";

            $sql_Consult = "SELECT sum(amount) as total_Consult FROM View_summary_type_of_business
            WHERE  MONTH(create_date) = $mmonth and YEAR(create_date)=$yyear
            AND (type_of_business='Consult')";
            $res_Consult = mssql_query($sql_Consult);
            $row_Consult = mssql_fetch_array($res_Consult);
            $total_Consult = $row_Consult["total_Consult"]==""?0:$row_Consult["total_Consult"];
            // echo number_format($total_Consult/1000000,2);
            // echo ",";

            $sql_trans = "SELECT sum(amount) as total_trans FROM View_summary_type_of_business
            WHERE  MONTH(create_date) = $mmonth and YEAR(create_date)=$yyear
            AND (type_of_business='Transportation Service')";
            $res_trans = mssql_query($sql_trans);
            $row_trans = mssql_fetch_array($res_trans);
            $total_trans = $row_trans["total_trans"]==""?0:$row_trans["total_trans"];
            // echo number_format($total_trans/1000000,2);
            // echo ",";

            $sql_packaging = "SELECT sum(amount) as total_packaging FROM View_summary_type_of_business
            WHERE  MONTH(create_date) = $mmonth and YEAR(create_date)=$yyear
            AND (type_of_business='Packaging Management')";
            $res_packaging = mssql_query($sql_packaging);
            $row_packaging = mssql_fetch_array($res_packaging);
            $total_packaging = $row_packaging["total_packaging"]==""?0:$row_packaging["total_packaging"];
            // echo number_format($total_packaging/1000000,2);
            // echo ",";

            $sql_onsite = "SELECT sum(amount) as total_onsite FROM View_summary_type_of_business
            WHERE  MONTH(create_date) = $mmonth and YEAR(create_date)=$yyear
            AND (type_of_business='Onsite Packing')";
            $res_onsite = mssql_query($sql_onsite);
            $row_onsite = mssql_fetch_array($res_onsite);
            $total_onsite = $row_onsite["total_onsite"]==""?0:$row_onsite["total_onsite"];
            // echo number_format($total_onsite/1000000,2);
            // echo ",";
            
            $sql_agreement = "SELECT sum(amount) as total_agreement FROM View_summary_type_of_business
            WHERE  MONTH(create_date) = $mmonth and YEAR(create_date)=$yyear
            AND (type_of_business='Agreement charge')";
            $res_agreement = mssql_query($sql_agreement);
            $row_agreement = mssql_fetch_array($res_agreement);
            $total_agreement = $row_agreement["total_agreement"]==""?0:$row_agreement["total_agreement"];
            // echo number_format($total_agreement/1000000,2);
            // echo ",";
            
            $sql_it = "SELECT sum(amount) as total_it FROM View_summary_type_of_business
            WHERE  MONTH(create_date) = $mmonth and YEAR(create_date)=$yyear
            AND (type_of_business='IT')";
            $res_it = mssql_query($sql_it);
            $row_it = mssql_fetch_array($res_it);
            $total_it = $row_it["total_it"]==""?0:$row_it["total_it"];;
            // echo number_format($total_it/1000000,2);
            $total_type_of_business = $total_packing+$total_trading+$total_Consult+$total_trans+$total_packaging+$total_onsite+$total_agreement+$total_it;
            ?>
            var data = google.visualization.arrayToDataTable([
                ['Task', 'Bath'],
                ['Packing',  <?=round($total_packing,2)?>],
                ['Trading',  <?=round($total_trading,2)?>],
                ['Consult',  <?=round($total_Consult,2)?>],
                ['Transportation Service', <?=round($total_trans,2)?>],
                ['Packaging Management',    <?=round($total_packaging,2)?>],
                ['Onsite Packing',    <?=round($total_onsite,2)?>],
                ['Agreement charge',    <?=round($total_agreement,2)?>],
                ['IT',    <?=round($total_it,2)?>],
            ]);

            var options = {
            
                pieSliceText: 'none',
                title: 'Type of business <?=$arr_month[$mmonth]?> <?=$yyear?> (Bath)',
                sliceVisibilityThreshold:0,
                
            };

            var chart = new google.visualization.PieChart(document.getElementById('type_of_business'));
            // google.visualization.events.addListener(chart, 'ready', function(e) {
            
            // });

            chart.draw(data, options);
            // var ctx = document.getElementById('type_of_business').getContext('2d');
            // var chart = new Chart(ctx, {
            //     // The type of chart we want to create
            //     type: 'pie',

            //     // The data for our dataset
            //     data: {
            //         labels: ['Packing', 'Trading','Consult','Transportation Service','Packaging Management','Onsite Packing','Agreement charge','IT'],
            //         datasets: [{
            //             backgroundColor: ['rgb(51, 102, 255)','rgb(194, 0, 0)','rgb(255, 181, 0)','rgb(229,228,219)','rgb(0, 138, 0)','rgb(166, 0, 144)','rgb(166, 210, 254)','rgb(255, 102, 0)'] ,
            //             // borderColor: ['rgb(255, 181, 0)','rgb(20, 165, 0)'],
            //             fill: false,
            //             data: [ 
            //                 <?php
            //                 $total_type_of_business = 0;
            //                 $sql_packing = "SELECT sum(amount) as total_packing FROM View_summary_type_of_business
            //                 WHERE  MONTH(create_date) = $mmonth and YEAR(create_date)=$yyear
            //                 AND (issue_no!='' OR type_of_business='Packing')";
            //                 $res_packing = mssql_query($sql_packing);
            //                 $row_packing = mssql_fetch_array($res_packing);
            //                 $total_packing = $row_packing["total_packing"];
            //                 echo number_format($total_packing/1000000,2);
            //                 echo ",";

            //                 $sql_trading = "SELECT sum(amount) as total_trading FROM View_summary_type_of_business
            //                 WHERE  MONTH(create_date) = $mmonth and YEAR(create_date)=$yyear
            //                 AND (type_of_business='Trading')";
            //                 $res_trading = mssql_query($sql_trading);
            //                 $row_trading = mssql_fetch_array($res_trading);
            //                 $total_trading = $row_trading["total_trading"];
            //                 echo number_format($total_trading/1000000,2);
            //                 echo ",";

            //                 $sql_Consult = "SELECT sum(amount) as total_Consult FROM View_summary_type_of_business
            //                 WHERE  MONTH(create_date) = $mmonth and YEAR(create_date)=$yyear
            //                 AND (type_of_business='Consult')";
            //                 $res_Consult = mssql_query($sql_Consult);
            //                 $row_Consult = mssql_fetch_array($res_Consult);
            //                 $total_Consult = $row_Consult["total_Consult"];
            //                 echo number_format($total_Consult/1000000,2);
            //                 echo ",";

            //                 $sql_trans = "SELECT sum(amount) as total_trans FROM View_summary_type_of_business
            //                 WHERE  MONTH(create_date) = $mmonth and YEAR(create_date)=$yyear
            //                 AND (type_of_business='Transportation Service')";
            //                 $res_trans = mssql_query($sql_trans);
            //                 $row_trans = mssql_fetch_array($res_trans);
            //                 $total_trans = $row_trans["total_trans"];
            //                 echo number_format($total_trans/1000000,2);
            //                 echo ",";

            //                 $sql_packaging = "SELECT sum(amount) as total_packaging FROM View_summary_type_of_business
            //                 WHERE  MONTH(create_date) = $mmonth and YEAR(create_date)=$yyear
            //                 AND (type_of_business='Packaging Management')";
            //                 $res_packaging = mssql_query($sql_packaging);
            //                 $row_packaging = mssql_fetch_array($res_packaging);
            //                 $total_packaging = $row_packaging["total_packaging"];
            //                 echo number_format($total_packaging/1000000,2);
            //                 echo ",";

            //                 $sql_onsite = "SELECT sum(amount) as total_onsite FROM View_summary_type_of_business
            //                 WHERE  MONTH(create_date) = $mmonth and YEAR(create_date)=$yyear
            //                 AND (type_of_business='Onsite Packing')";
            //                 $res_onsite = mssql_query($sql_onsite);
            //                 $row_onsite = mssql_fetch_array($res_onsite);
            //                 $total_onsite = $row_onsite["total_onsite"];
            //                 echo number_format($total_onsite/1000000,2);
            //                 echo ",";
                            
            //                 $sql_agreement = "SELECT sum(amount) as total_agreement FROM View_summary_type_of_business
            //                 WHERE  MONTH(create_date) = $mmonth and YEAR(create_date)=$yyear
            //                 AND (type_of_business='Agreement charge')";
            //                 $res_agreement = mssql_query($sql_agreement);
            //                 $row_agreement = mssql_fetch_array($res_agreement);
            //                 $total_agreement = $row_agreement["total_agreement"];
            //                 echo number_format($total_agreement/1000000,2);
            //                 echo ",";
                            
            //                 $sql_it = "SELECT sum(amount) as total_it FROM View_summary_type_of_business
            //                 WHERE  MONTH(create_date) = $mmonth and YEAR(create_date)=$yyear
            //                 AND (type_of_business='IT')";
            //                 $res_it = mssql_query($sql_it);
            //                 $row_it = mssql_fetch_array($res_it);
            //                 $total_it = $row_it["total_it"];
            //                 echo number_format($total_it/1000000,2);
            //                 $total_type_of_business = $total_packing+$total_trading+$total_Consult+$total_trans+$total_packaging+$total_onsite+$total_agreement+$total_it;
            //                 ?>
            //             ],
                        
            //         }]
            //     },
            //     // Configuration options go here
            //     options: {
            //         // showAllTooltips: true,
            //         title: {
            //             display: true,
            //             text: 'Type of business <?=$arr_month[$mmonth]?> <?=$yyear?> (Bath)'
            //         },
            //         tooltips: {
            //             callbacks: {
            //                 // i = 0;
            //                 // label: function(tooltipItem, data) {
            //                 //     var label = data.datasets[tooltipItem.datasetIndex].label || '';

            //                 //     // console.log(data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index]);
            //                 //     return data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
            //                 // }
            //             }
            //         }
            //     }
            // });
        }
        function type_of_business_percent(){
            var ctx = document.getElementById('type_of_business_percent').getContext('2d');
            var chart = new Chart(ctx, {
                // The type of chart we want to create
                type: 'pie',

                // The data for our dataset
                data: {
                    labels: ['Packing', 'Trading','Consult','Transportation Service','Packaging Management','Onsite Packing','Agreement charge','IT'],
                    datasets: [{
                        backgroundColor: ['rgb(51, 102, 255)','rgb(194, 0, 0)','rgb(255, 181, 0)','rgb(229,228,219)','rgb(0, 138, 0)','rgb(166, 0, 144)','rgb(166, 210, 254)','rgb(255, 102, 0)'] ,
                        // borderColor: ['rgb(255, 181, 0)','rgb(20, 165, 0)'],
                        fill: false,
                        data: [ 
                            <?php
                            echo number_format($total_packing*100/$total_type_of_business,2);
                            echo ",";
                            echo number_format($total_trading*100/$total_type_of_business,2);
                            echo ",";
                            echo number_format($total_Consult*100/$total_type_of_business,2);
                            echo ",";
                            echo number_format($total_trans*100/$total_type_of_business,2);
                            echo ",";
                            echo number_format($total_packaging*100/$total_type_of_business,2);
                            echo ",";
                            echo number_format($total_onsite*100/$total_type_of_business,2);
                            echo ",";
                            echo number_format($total_agreement*100/$total_type_of_business,2);
                            echo ",";
                            echo number_format($total_it*100/$total_type_of_business,2);
                            ?>
                        ],
                        
                    }]
                },
                // Configuration options go here
                options: {
                    // showAllTooltips: true,
                    title: {
                        display: true,
                        text: 'Type of business <?=$arr_month[$mmonth]?> <?=$yyear?> (Percent)'
                    },
                    tooltips: {
                        callbacks: {
                            // // i = 0;
                            label: function(tooltipItem, data) {
                                var label = data.datasets[tooltipItem.datasetIndex].label || '';

                                // console.log(data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index]);
                                return data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index]+' %';
                            }
                        }
                    }
                }
            });
        }
        function sab_order_type_county(){
            var data = google.visualization.arrayToDataTable([
                ['Task', 'Bath'],
                <?php
                include "connect_hq.php";
                $bg_color = "";
                $data_price = "";
                $sql_sab_county = "SELECT distinct Production_Controller 
                FROM tbsaborder 
                WHERE Delivery_order_date_Month='$mmonth' 
                AND Delivery_order_date_year='$yyear' 
                ORDER by Production_Controller";
                $res_sab_county = mssql_query($sql_sab_county);
                while($row_sab_county = mssql_fetch_array($res_sab_county)){
                    $Production_Controller = $row_sab_county["Production_Controller"];
                    $bg_color .= "'$master_color[$Production_Controller]'".",";
                    

                    $total_price_sab_county = 0;
                    $sql_issue = "SELECT  COUNT(Part_No) AS count_Part_No, Part_No,SNEP 
                    FROM tbsaborder 
                    WHERE Production_Controller='$Production_Controller' 
                    AND Delivery_order_date_Month='$mmonth' 
                    AND Delivery_order_date_year='$yyear'
                    GROUP BY Part_No,SNEP";
                    $res_issue = mssql_query($sql_issue);
                    while($row_issue = mssql_fetch_array($res_issue)){
                        $count_Part_No = $row_issue["count_Part_No"];
                        $Part_No = $row_issue["Part_No"];
                        $SNEP = $row_issue["SNEP"];

                        include "connect_inv.php";
                        // $sql_price = "SELECT UNIT_PRICE,issue_no,scheduled_qty,UNIT_PRICE*scheduled_qty as amount 
                        // FROM tbpo_import as po 
                        // INNER JOIN tbpo_confirm as con 
                        //     on po.PONO = con.purch_doc
                        //     and po.part_no=con.PART_NO
                        // WHERE issue_no='$Issue_No'";
                        $sql_price = "SELECT UNIT_PRICE 
                        FROM tbpo_import
                        WHERE REPLACE(PART_NO,' ','')='$Part_No'
                        order by id desc";
                        $res_price = mssql_query($sql_price);
                        $num_price = mssql_num_rows($res_price);
                        if($num_price>0){
                            $row_price = mssql_fetch_array($res_price);
                            $amount = ($row_price["UNIT_PRICE"]*$SNEP)*$count_Part_No;
                        }else{
                            $amount = 0;
                        }
                        $total_price_sab_county = $total_price_sab_county+($amount);
                        include "connect_hq.php";
                    }
                    
                    // $data_price .= round($total_price_sab_county/1000000,2);
                    
                    echo "['$Production_Controller',  ".round($total_price_sab_county,2)."],";
                }
                ?>
                
            ]);

            var options = {
            
                pieSliceText: 'none',
                title: 'SAB order County <?=$arr_month[$mmonth]?> <?=$yyear?> (Bath)',
                sliceVisibilityThreshold:0,
                colors:[ <?=$bg_color?> ]
                
            };

            var chart = new google.visualization.PieChart(document.getElementById('sab_order_type_county'));
            chart.draw(data, options);
        }
        function sab_order_type_packaging(){
            <?php
            include "connect_hq.php";
            $total_rackbox_price = 0;
            $total_module_price = 0;
            $sql_sab_rackbox = "SELECT COUNT(Part_No) AS count_Part_No, Part_No,SNEP 
            FROM tbsaborder 
            WHERE Number_of_Boxes=1
            AND Delivery_order_date_Month='$mmonth' 
            AND Delivery_order_date_year='$yyear' 
            GROUP BY Part_No,SNEP";
            $res_sab_rackbox = mssql_query($sql_sab_rackbox);
            while($row_sab_rackbox = mssql_fetch_array($res_sab_rackbox)){
                $count_Part_No = $row_sab_rackbox["count_Part_No"];
                $Part_No = $row_sab_rackbox["Part_No"];
                $SNEP = $row_sab_rackbox["SNEP"];


                include "connect_inv.php";
                $sql_price = "SELECT top 1 UNIT_PRICE 
                FROM tbpo_import
                WHERE REPLACE(PART_NO,' ','')='$Part_No'
                order by id desc";
                $res_price = mssql_query($sql_price);
                $num_price = mssql_num_rows($res_price);
                if($num_price>0){
                    $row_price = mssql_fetch_array($res_price);
                    $amount = ($row_price["UNIT_PRICE"]*$SNEP)*$count_Part_No;
                }else{
                    $amount = 0;
                }
                $total_rackbox_price = $total_rackbox_price+($amount);
                include "connect_hq.php";
                
                
            }
            $sql_sab_module = "SELECT COUNT(Part_No) AS count_Part_No, Part_No,SNEP
            FROM tbsaborder 
            WHERE Number_of_Boxes>1
            AND Delivery_order_date_Month='$mmonth' 
            AND Delivery_order_date_year='$yyear' 
            GROUP BY Part_No,SNEP";
            $res_sab_module = mssql_query($sql_sab_module);
            while($row_sab_module = mssql_fetch_array($res_sab_module)){
                $count_Part_No = $row_sab_module["count_Part_No"];
                $Part_No = $row_sab_module["Part_No"];
                $SNEP = $row_sab_module["SNEP"];

                include "connect_inv.php";
                $sql_price = "SELECT top 1 UNIT_PRICE 
                FROM tbpo_import
                WHERE REPLACE(PART_NO,' ','')='$Part_No'
                order by id desc";
                $res_price = mssql_query($sql_price);
                $num_price = mssql_num_rows($res_price);
                if($num_price>0){
                    $row_price = mssql_fetch_array($res_price);
                    $amount = ($row_price["UNIT_PRICE"]*$SNEP)*$count_Part_No;
                }else{
                    $amount = 0;
                }
                $total_module_price = $total_module_price+($amount);
                include "connect_hq.php";
                
                
                // $data_price .= number_format($total_rackbox_price/1000000,2).",";
            }


            
            ?>
            var data = google.visualization.arrayToDataTable([
                ['Task', 'Bath'],
                ['Rack/Box', <?=round($total_rackbox_price,2)?>],
                ['Module', <?=round($total_module_price,2)?>],
                
                
            ]);

            var options = {
            
                pieSliceText: 'none',
                title: 'SAB order Packaging <?=$arr_month[$mmonth]?> <?=$yyear?> (Bath)',
                sliceVisibilityThreshold:0,
                
                
            };

            var chart = new google.visualization.PieChart(document.getElementById('sab_order_type_packaging'));
            chart.draw(data, options);
        }
        function topre_order_type_county(){
            var data = google.visualization.arrayToDataTable([
                ['Task', 'Bath'],
                <?php
                include "connect_topre.php";
                $bg_color = "";
                $data_price = "";
                $sql_topre_county = "SELECT distinct Production_Controller FROM tbsaborder WHERE Delivery_order_date_Month='$mmonth' AND Delivery_order_date_year='$yyear' ORDER by Production_Controller";
                $res_topre_county = mssql_query($sql_topre_county);
                while($row_topre_county = mssql_fetch_array($res_topre_county)){
                    $Production_Controller = $row_topre_county["Production_Controller"];
                    $bg_color .= "'$master_color[$Production_Controller]'".",";

                    $total_price_topre_county = 0;
                    $sql_issue = "SELECT COUNT(Part_No) AS count_Part_No, Part_No
                    FROM tbsaborder 
                    WHERE Production_Controller='$Production_Controller'
                    AND Delivery_order_date_Month='$mmonth' 
                    AND Delivery_order_date_year='$yyear'
                    GROUP BY Part_No
                        ";
                    $res_issue = mssql_query($sql_issue);
                    while($row_issue = mssql_fetch_array($res_issue)){
                        $count_Part_No = $row_issue["count_Part_No"];
                        $Part_No = $row_issue["Part_No"];

                        include "connect_inv.php";
                        $sql_price = "SELECT top 1 amount 
                        FROM tbpo_confirm_topre
                        WHERE Part_No='$Part_No' order by id desc";
                        $res_price = mssql_query($sql_price);
                        $num_price = mssql_num_rows($res_price);
                        if($num_price > 0){

                            $row_price = mssql_fetch_array($res_price);
                            $amount = $row_price["amount"]*$count_Part_No;
                        }else{
                            $amount = 0;
                        }
                        $total_price_topre_county = $total_price_topre_county+($amount);
                        include "connect_topre.php";
                    }
                    
                    // $data_price .= round($total_price_sab_county/1000000,2);
                    
                    echo "['$Production_Controller',  ".round($total_price_topre_county,2)."],";
                }
                ?>
                
            ]);

            var options = {
            
                pieSliceText: 'none',
                title: 'Topre order County <?=$arr_month[$mmonth]?> <?=$yyear?> (Bath)',
                sliceVisibilityThreshold:0,
                colors:[ <?=$bg_color?> ]
                
            };

            var chart = new google.visualization.PieChart(document.getElementById('topre_order_type_county'));
            chart.draw(data, options); 
        }
        function topre_order_type_packaging(){
            <?php
            include "connect_topre.php";
            $total_rackbox_price = 0;
            $total_module_price = 0;
            $sql_topre_rackbox = "SELECT COUNT(Part_No) AS count_Part_No, Part_No
                FROM tbsaborder 
            WHERE Number_of_Boxes=1
            AND Delivery_order_date_Month='$mmonth' 
            AND Delivery_order_date_year='$yyear' 
            GROUP BY Part_No";
            $res_topre_rackbox = mssql_query($sql_topre_rackbox);
            while($row_topre_rackbox = mssql_fetch_array($res_topre_rackbox)){
                $count_Part_No = $row_topre_rackbox["count_Part_No"];
                $Part_No = $row_topre_rackbox["Part_No"];

                include "connect_inv.php";
                $sql_price = "SELECT top 1 amount 
                FROM tbpo_confirm_topre
                WHERE Part_No='$Part_No' order by id desc";
                $res_price = mssql_query($sql_price);
                $num_price = mssql_num_rows($res_price);
                if($num_price > 0){

                    $row_price = mssql_fetch_array($res_price);
                    $amount = $row_price["amount"]*$count_Part_No;
                }else{
                    $amount = 0;
                }
                $total_rackbox_price = $total_rackbox_price+($amount);
                include "connect_topre.php";
                
                
                // $data_price .= number_format($total_rackbox_price/1000000,2).",";
            }

            $sql_topre_module = "SELECT COUNT(Part_No) AS count_Part_No, Part_No
            FROM tbsaborder 
            WHERE Number_of_Boxes > 1
            AND Delivery_order_date_Month='$mmonth' 
            AND Delivery_order_date_year='$yyear' 
            GROUP BY Part_No";
            $res_topre_module = mssql_query($sql_topre_module);
            while($row_topre_module = mssql_fetch_array($res_topre_module)){
                $Issue_No = $row_topre_module["Issue_No"];

                $count_Part_No = $row_topre_rackbox["count_Part_No"];
                $Part_No = $row_topre_rackbox["Part_No"];

                include "connect_inv.php";
                $sql_price = "SELECT top 1 amount 
                FROM tbpo_confirm_topre
                WHERE Part_No='$Part_No' order by id desc";
                $res_price = mssql_query($sql_price);
                $num_price = mssql_num_rows($res_price);
                if($num_price > 0){

                    $row_price = mssql_fetch_array($res_price);
                    $amount = $row_price["amount"]*$count_Part_No;
                }else{
                    $amount = 0;
                }
                $total_module_price = $total_module_price+($amount);
                include "connect_topre.php";
                
                
                // $data_price .= number_format($total_rackbox_price/1000000,2).",";
            }

            // echo round($total_rackbox_price/1000000,2).",".round($total_module_price/1000000,2);
            


            
            ?>
            var data = google.visualization.arrayToDataTable([
                ['Task', 'Bath'],
                ['Rack/Box', <?=round($total_rackbox_price,2)?>],
                ['Module', <?=round($total_module_price,2)?>],
                
                
            ]);

            var options = {
            
                pieSliceText: 'none',
                title: 'Topre order Packaging <?=$arr_month[$mmonth]?> <?=$yyear?> (Bath)',
                sliceVisibilityThreshold:0,
                
                
            };

            var chart = new google.visualization.PieChart(document.getElementById('topre_order_type_packaging'));
            chart.draw(data, options);
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
                            <div class="panel panel-info">
                                <div class="panel-body" style="height:500px">
                                    <!-- style="height:600px" -->
                                    <div class="row">
                                        <div class="col-md-12 clearfix">
                                            <h4 class="pull-left" style="margin: 0 0 20px;"></h4>
                                            <!-- <div class="btn-group pull-right">
                                            </div>  -->
                                        </div>
                                        <div class="col-md-12">
                                            <canvas id="revenue_target"></canvas>
                                        </div>
                                    </div>
                                    <br><br>
                                    Target : <?=number_format($data_display_target,2)?> Bath<br>
                                    Current Sales : <?=number_format($total_sales,2)?> Bath

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
                                            <div id="type_of_business" style="width: 100%; height: 300px;"></div>
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
                                            <div id="sab_order_type_county" style="width: 100%; height: 300px;"></div>
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
                                            <div id="sab_order_type_packaging" style="width: 100%; height: 300px;"></div>
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
                                            <div id="topre_order_type_county" style="width: 100%; height: 300px;"></div>
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
                                            <div id="topre_order_type_packaging" style="width: 100%; height: 300px;"></div>
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