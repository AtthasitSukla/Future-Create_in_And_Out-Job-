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
    <title>I-Wis : Purchase</title>
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

            // cost_accumulated();
            cost_accumulated_customer();
            cost_accumulated_supplier();
            po_summary_customer();
            po_summary_customer_percent();
            po_summary_supplier();
            po_summary_supplier_percent();
            chart_qty_ng();
            // supplier_pay_type();
            // sab_order_type_packaging();
            // topre_order_type_county();
            // topre_order_type_packaging();
            compare_three_years();

            google.charts.load('current', {'packages':['corechart']});
            google.charts.setOnLoadCallback(supplier_pay_type);
            google.charts.setOnLoadCallback(chart_qty_ng_supplier);

           
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
        
        function cost_accumulated() {

            var ctx = document.getElementById('cost_accumulated').getContext('2d');
            var chart = new Chart(ctx, {
                // The type of chart we want to create
                
                type: 'bar',
                // The data for our dataset
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    datasets: [
                        {
                            
                            label: 'Cost',
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
                        text: 'Cost <?=$arr_month[$mmonth]?> <?=$yyear?>'
                    }
                    
                }
            });

            $.post("getajax_dashbord_purchase.php", {
                status: "cost_accumulated",
                mmonth : "<?=$mmonth?>",
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

            })

        }
        function cost_accumulated_supplier() {

            var ctx = document.getElementById('cost_accumulated_supplier').getContext('2d');
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
                                
                        $select_wk = "SELECT po_to,sum(total_grand) as total_grand from View_summary_po_approve_date 
                        WHERE  YEAR(approve_date)=$yyear
                        AND Month(approve_date)<=$mmonth
                        group by po_to
                        order by total_grand desc ";
                        $re_wk = mssql_query($select_wk);
                        while($row_wk = mssql_fetch_array($re_wk)){
                            echo "'".lang_thai_from_database($row_wk['po_to'])."'";
                            echo ",";
                        }
                        ?>
                    ],
                    datasets: [
                        {
                            
                            label: 'Cost',
                            backgroundColor: 'rgb(22, 142, 0)',
                            borderColor: 'rgb(22, 142, 0)',
                            fill: false,
                            data: [
                                <?
                            
                                $select_wk = "SELECT po_to,sum(total_grand) as total_grand 
                                from View_summary_po_approve_date 
                                WHERE  YEAR(approve_date)=$yyear
                                AND Month(approve_date)<=$mmonth
                                group by po_to
                                order by total_grand desc ";
                                $re_wk = mssql_query($select_wk);
                                while($row_wk = mssql_fetch_array($re_wk)){
                                    echo number_format($row_wk['total_grand']/1000000,2);
                                    echo ", ";
                                }
                                
                                
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
                        text: 'Cost by supplier Jan <?=$yyear?> - <?=$arr_month[$mmonth]?> <?=$yyear?>'
                    }
                    
                }
            });


        }
        function cost_accumulated_customer() {

            var ctx = document.getElementById('cost_accumulated_customer').getContext('2d');
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
                                
                        $select_wk = "SELECT customer,sum(total_grand) as total_grand from View_summary_po_approve_date 
                        WHERE  YEAR(approve_date)=$yyear
                        AND Month(approve_date)<=$mmonth
                        group by customer
                        order by total_grand desc ";
                        $re_wk = mssql_query($select_wk);
                        while($row_wk = mssql_fetch_array($re_wk)){
                            echo "'".lang_thai_from_database($row_wk['customer'])."'";
                            echo ",";
                        }
                        ?>
                    ],
                    datasets: [
                        {
                            
                            label: 'Cost',
                            backgroundColor: 'rgb(22, 142, 0)',
                            borderColor: 'rgb(22, 142, 0)',
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
                        text: 'Cost by customer Jan <?=$yyear?> - <?=$arr_month[$mmonth]?> <?=$yyear?>'
                    }
                    
                }
            });

            $.post("getajax_dashbord_purchase.php", {
                status: "cost_accumulated_customer",
                mmonth : "<?=$mmonth?>",
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

            })

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
                        $previous_years = (int)$yyear-2;
                        $i_color=0;
                        for($i_years=$previous_years;$i_years<=$yyear;$i_years++){
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
                        text: 'Cost compare 3 years'
                    }
                    
                }
            });

            $.post("getajax_dashbord_purchase.php", {
                status: "compare_three_years",
                mmonth : "<?=$mmonth?>",
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
        function po_summary_customer(){
            /// po sum dashboard
            var ctx = document.getElementById('po_summary_customer').getContext('2d');
            var chart = new Chart(ctx, {
                // The type of chart we want to create
                
                type: 'bar',
                
                // The data for our dataset
                data: {
                    
                    labels: [<?
                                $db="dinvb";
                                $sql=mssql_connect($host,$username,$password) or die("Cannot connect");
                                mssql_select_db($db);
                                
                        $select_wk = "SELECT customer,sum(total_grand) as total_grand from View_summary_po_approve_date
                         WHERE  MONTH(approve_date) = $mmonth 
                         and YEAR(approve_date)=$yyear
                        group by customer
                        order by total_grand desc ";
                        $re_wk = mssql_query($select_wk);
                        while($row_wk = mssql_fetch_array($re_wk)){
                            echo "'".$row_wk['customer']."'";
                            echo ",";
                        }
                            // echo "'Total'";
                    
                    ?>],
                    datasets: [{
                            label: 'PO',
                            backgroundColor: 'rgb(255, 153, 51)',
                            borderColor: 'rgb(255, 153, 51)',
                            data:[ <?
                            
                            $select_wk = "SELECT customer,sum(total_grand) as total_grand from View_summary_po_approve_date 
                            WHERE  MONTH(approve_date) = $mmonth and YEAR(approve_date)=$yyear
                            group by customer
                            order by total_grand desc ";
                            $re_wk = mssql_query($select_wk);
                            while($row_wk = mssql_fetch_array($re_wk)){
                                echo number_format($row_wk['total_grand']/1000000,2);
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
                                    data = data.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");                   
                                    ctx.fillText(data, bar._model.x, bar._model.y - 5);
                                });
                            });
                        }
                    },
                    title: {
                    display: true,
                    text: 'PO by customer <?=$arr_month[$mmonth]?> <?=$yyear?> (Bath)'
                }
                }
            });
            /// po sum dashboard
        }
        function po_summary_customer_percent(){
            /// po sum dashboard
            var ctx = document.getElementById('po_summary_customer_percent').getContext('2d');
            var chart = new Chart(ctx, {
                // The type of chart we want to create
                
                type: 'bar',
                
                // The data for our dataset
                data: {
                    
                    labels: [<?
                                $db="dinvb";
                                $sql=mssql_connect($host,$username,$password) or die("Cannot connect");
                                mssql_select_db($db);
                                
                    $select_wk = "SELECT customer,sum(total_grand) as total_grand from View_summary_po_approve_date 
                    WHERE  MONTH(approve_date) = $mmonth and YEAR(approve_date)=$yyear
                        group by customer
                        order by total_grand desc ";
                        $re_wk = mssql_query($select_wk);
                        while($row_wk = mssql_fetch_array($re_wk)){
                            echo "'".$row_wk['customer']."'";
                            echo ",";
                        }
                    
                    ?>],
                    datasets: [{
                            label: 'PO %',
                            backgroundColor: 'rgb(255, 153, 51)',
                            borderColor: 'rgb(255, 153, 51)',
                            data:[ <?
                            
                        $select_wk = "SELECT customer,
                        (sum(total_grand)* 100 / (Select sum(total_grand) From View_summary_po_approve_date WHERE  MONTH(approve_date) = $mmonth and YEAR(approve_date)=$yyear)) as total_grand
                        from View_summary_po_approve_date WHERE  MONTH(approve_date) = $mmonth and YEAR(approve_date)=$yyear
                        group by customer
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
                    text: 'PO by customer <?=$arr_month[$mmonth]?> <?=$yyear?> (Percent)'
                }
                }
            });
            /// po sum dashboard
        }       
        function po_summary_supplier(){
            /// po sum dashboard
            var ctx = document.getElementById('po_summary_supplier').getContext('2d');
            var chart = new Chart(ctx, {
                // The type of chart we want to create
                
                type: 'bar',
                
                // The data for our dataset
                data: {
                    
                    labels: [<?
                                $db="dinvb";
                                $sql=mssql_connect($host,$username,$password) or die("Cannot connect");
                                mssql_select_db($db);
                                
                        $select_wk = "SELECT po_to,sum(total_grand) as total_grand from View_summary_po_approve_date
                         WHERE  MONTH(approve_date) = $mmonth 
                         and YEAR(approve_date)=$yyear
                        group by po_to
                        order by total_grand desc ";
                        $re_wk = mssql_query($select_wk);
                        while($row_wk = mssql_fetch_array($re_wk)){
                            echo "'".$row_wk['po_to']."'";
                            echo ",";
                        }
                            // echo "'Total'";
                    
                    ?>],
                    datasets: [{
                            label: 'PO',
                            backgroundColor: 'rgb(255, 153, 51)',
                            borderColor: 'rgb(255, 153, 51)',
                            data:[ <?
                            
                            $select_wk = "SELECT po_to,sum(total_grand) as total_grand from View_summary_po_approve_date 
                            WHERE  MONTH(approve_date) = $mmonth and YEAR(approve_date)=$yyear
                            group by po_to
                            order by total_grand desc ";
                            $re_wk = mssql_query($select_wk);
                            while($row_wk = mssql_fetch_array($re_wk)){
                                echo number_format($row_wk['total_grand']/1000000,2);
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
                                    data = data.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");                   
                                    ctx.fillText(data, bar._model.x, bar._model.y - 5);
                                });
                            });
                        }
                    },
                    title: {
                        display: true,
                        text: 'PO by supplier <?=$arr_month[$mmonth]?> <?=$yyear?> (Bath)'
                    }
                }
            });
            /// po sum dashboard
        }
        function po_summary_supplier_percent(){
            /// po sum dashboard
            var ctx = document.getElementById('po_summary_supplier_percent').getContext('2d');
            var chart = new Chart(ctx, {
                // The type of chart we want to create
                
                type: 'bar',
                
                // The data for our dataset
                data: {
                    
                    labels: [<?
                                $db="dinvb";
                                $sql=mssql_connect($host,$username,$password) or die("Cannot connect");
                                mssql_select_db($db);
                                
                    $select_wk = "SELECT po_to,sum(total_grand) as total_grand from View_summary_po_approve_date 
                    WHERE  MONTH(approve_date) = $mmonth and YEAR(approve_date)=$yyear
                        group by po_to
                        order by total_grand desc ";
                        $re_wk = mssql_query($select_wk);
                        while($row_wk = mssql_fetch_array($re_wk)){
                            echo "'".$row_wk['po_to']."'";
                            echo ",";
                        }
                    
                    ?>],
                    datasets: [{
                            label: 'PO %',
                            backgroundColor: 'rgb(255, 153, 51)',
                            borderColor: 'rgb(255, 153, 51)',
                            data:[ <?
                            
                        $select_wk = "SELECT po_to,
                        (sum(total_grand)* 100 / (Select sum(total_grand) From View_summary_po_approve_date WHERE  MONTH(approve_date) = $mmonth and YEAR(approve_date)=$yyear)) as total_grand
                        from View_summary_po_approve_date WHERE  MONTH(approve_date) = $mmonth and YEAR(approve_date)=$yyear
                        group by po_to
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
                    text: 'PO by supplier <?=$arr_month[$mmonth]?> <?=$yyear?> (Percent)'
                }
                }
            });
            /// po sum dashboard
        }       
        function supplier_pay_type(){
            var data = google.visualization.arrayToDataTable([
                ['Task', 'Qty'],
                <?php
                include "connect_inv.php";
                $bg_color = "";
                $data_price = "";
                $sql_pay_type = "SELECT  count(*) - count(pay_type) as count_pay_type_null, count(pay_type) as count_pay_type,pay_type 
                FROM m_sup 
                Group by pay_type
                ORDER by pay_type";
                $res_pay_type = mssql_query($sql_pay_type);
                while($row_pay_type = mssql_fetch_array($res_pay_type)){
                    $pay_type = lang_thai_from_database($row_pay_type["pay_type"]);
                    $count_pay_type_null = ($row_pay_type["count_pay_type_null"]);
                    $count_pay_type = ($row_pay_type["count_pay_type"]);
                    
                    if($pay_type==""){

                        echo "['ค่าว่าง',  ".$count_pay_type_null."],";
                    }else{

                        echo "['$pay_type',  ".$count_pay_type."],";
                    }

                }
                ?>
                
            ]);

            var options = {
            
                pieSliceText: 'none',
                title: 'รูปแบบการชำระเงินของ Supplier (Qty)',
                sliceVisibilityThreshold:0,
                
            };

            var chart = new google.visualization.PieChart(document.getElementById('supplier_pay_type'));
            chart.draw(data, options);
        }
        function chart_qty_ng() {
            /* Chart */
            var ctx = document.getElementById('chart_qty_ng').getContext('2d');
            var chart = new Chart(ctx, {
                // The type of chart we want to create
                type: 'bar',

                // The data for our dataset
                data: {
                    labels: ['JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN', 'JULY', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC'],
                    datasets: [{
                        label: 'Qty',
                        backgroundColor: 'rgb(243, 65, 0)',
                        borderColor: 'rgb(243, 65, 0)',
                        data: []
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
                        text: 'Material NG Jan <?=$yyear?> - <?=$arr_month[$mmonth]?> <?=$yyear?> (Qty)'
                    }
                }
            });
            /* Chart */

            $.post("getajax_dashbord_purchase.php", {
                status: "chart_qty_ng",
                mmonth : '<?=$mmonth?>',
                yyear : '<?=$yyear?>',
            }).done(function(datas) {
                var res = datas.split("#");
                res.forEach(function(entry) {
                    chart.data.datasets[0].data.push(entry);
                    chart.update();
                })
            })


        }
        function chart_qty_ng_supplier() {
            var data = google.visualization.arrayToDataTable([
                ['Task', 'Qty'],
                <?php
                include "connect_inv.php";
                $bg_color = "";
                $data_price = "";
                $sql_sup_name_en = "SELECT  sum(qty) as sum_qty,sup_name_en 
                FROM View_material_ng_supplier 
                where MONTH(create_date)='$mmonth'
                AND YEAR(create_date)='$yyear'
                Group by sup_name_en
                ORDER by sup_name_en";
                $res_sup_name_en = mssql_query($sql_sup_name_en);
                while($row_sup_name_en = mssql_fetch_array($res_sup_name_en)){
                    $sup_name_en = lang_thai_from_database($row_sup_name_en["sup_name_en"]);
                    $sum_qty = ($row_sup_name_en["sum_qty"]);
                    
                    echo "['$sup_name_en',  ".$sum_qty."],";
                    

                }
                ?>
                
            ]);

            var options = {
            
                pieSliceText: 'none',
                title: 'Material NG supplier (Qty)',
                sliceVisibilityThreshold:0,
                
            };

            var chart = new google.visualization.PieChart(document.getElementById('chart_qty_ng_supplier'));
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
                            $sql_sup = "SELECT count(id) as total_sup FROM m_sup";
                            $res_sup = mssql_query($sql_sup);
                            $row_sup = mssql_fetch_array($res_sup);
                            $total_sup = $row_sup["total_sup"];

                            $sql_sup_new = "SELECT count(id) as total_sup_new FROM m_sup WHERE MONTH(create_date)='$mmonth' AND YEAR(create_date)='$yyear'";
                            $res_sup_new = mssql_query($sql_sup_new);
                            $row_sup_new = mssql_fetch_array($res_sup_new);
                            $total_sup_new = $row_sup_new["total_sup_new"];

                            $sql_po = "SELECT count(id) as total_po FROM tbpo WHERE MONTH(approve_date)='$mmonth' AND YEAR(approve_date)='$yyear'";
                            $res_po = mssql_query($sql_po);
                            $row_po = mssql_fetch_array($res_po);
                            $total_po = $row_po["total_po"];

                            ?>
                            <div class="row">
                                <div class="col-md-3 col-xs-12 col-sm-6">
                                    <a class="info-tiles tiles-warning" target='_blank' href="http://ipack-iwis.com/inv/mat_sup.php">
                                        <div class="tiles-heading">Supplier</div>
                                        <div class="tiles-body-alt">
                                            <i class="fa fa-shopping-cart"></i>
                                            <div class="text-center"><?=$total_sup?></div>
                                            <small>Total Supplier</small>
                                        </div>
                                        <div class="tiles-footer">See More </div>
                                    </a>
                                </div>
                                <div class="col-md-3 col-xs-12 col-sm-6">
                                    <a class="info-tiles tiles-success" target='_blank'  href="http://ipack-iwis.com/inv/mat_sup.php">
                                        <div class="tiles-heading">New Supplier</div>
                                        <div class="tiles-body-alt">
                                            
                                            <div class="text-center"><?=$total_sup_new?></div>
                                            <small>Month <?=$arr_month[$mmonth]?></small>
                                        </div>
                                        <div class="tiles-footer">See more</div>
                                    </a>
                                </div>
                                <div class="col-md-3 col-xs-12 col-sm-6">
                                    <a class="info-tiles tiles-orange" target='_blank'  href="http://ipack-iwis.com/inv/view_pr.php">
                                        <div class="tiles-heading">PO</div>
                                        <div class="tiles-body-alt">
                                            <i class="fa fa-file-text"></i>
                                            <div class="text-center"><?=$total_po?></div>
                                            <small>Month <?=$arr_month[$mmonth]?></small>
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
                                <button type="submit" class="btn btn-info" onclick="location='dashboard_purchase.php?mmonth='+document.getElementById('mmonth').value+'&yyear='+document.getElementById('yyear').value+''">Search</button>
                            </div>
                        </div>
                    </div>
                    <br>

                    <!-- Row cost Compare 3 years -->
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
                    <!-- Row cost Compare 3 years -->

                    <!-- Row cost month-->
                    <!-- <div class="row">
                        <div class="col-md-offset-2 col-md-8">
                            <div class="panel panel-info">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-12 clearfix">
                                        </div>
                                        <div class="col-md-12">
                                            <canvas id="cost_accumulated"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div> -->
                    <!-- Row cost month-->

                    <!-- Row cost -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="panel panel-info">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-12 clearfix">
                                            <!-- <h4 class="pull-left" style="margin: 0 0 20px;">Cost And Accumulated <?=$yyear?></h4>
                                            <div class="btn-group pull-right">
                                            </div> -->
                                        </div>
                                        <div class="col-md-12">
                                            <canvas id="cost_accumulated_customer"></canvas>
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
                                            <!-- <h4 class="pull-left" style="margin: 0 0 20px;">Cost And Accumulated <?=$yyear?></h4>
                                            <div class="btn-group pull-right">
                                            </div> -->
                                        </div>
                                        <div class="col-md-12">
                                            <canvas id="cost_accumulated_supplier"></canvas>
                                            <font color='red'>*ตัวเลขดูไม่รู้เรื่องอาจจะเปลี่ยนแสดงเฉพาะ top 10 หรือแสดงเฉพาะราคาเกินกี่บาทขึ้นไป</font>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Row cost -->

                    <!-- Row po customer -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="panel panel-info">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-12 clearfix">
                                        </div>
                                        <div class="col-md-12">
                                            <canvas id="po_summary_customer"></canvas>
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
                                        </div>
                                        <div class="col-md-12">
                                            <canvas id="po_summary_customer_percent"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Row po customer -->

                    <!-- Row po supplier -->
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
                                            <canvas id="po_summary_supplier"></canvas>
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
                                            <canvas id="po_summary_supplier_percent"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Row po supplier -->

                    <!-- Row Material NG -->
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
                                            <canvas id="chart_qty_ng"></canvas>
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
                                            <div id="chart_qty_ng_supplier" style="width: 100%; height: 350px;"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Row Material NG -->

                    
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
                                            <div id="supplier_pay_type" style="width: 100%; height: 400px;"></div>
                                            <!-- <canvas id="supplier_pay_type"></canvas> -->
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
                                            <div id="sab_order_type_packaging" style="width: 100%; height: 400px;"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                    </div>
                    <!-- Row sab order type -->
                    

                    

                  

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