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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>I-Wis : Hr</title>
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

            chart_absenteeism();
            chart_leave();
            chart_late();
            chart_ot();
            chart_training();
            chart_turnover_rate();
            chart_hbd();

            

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
        
        function chart_absenteeism() {

            var ctx = document.getElementById('chart_absenteeism').getContext('2d');
            var chart = new Chart(ctx, {
                // The type of chart we want to create
                type: 'line',

                // The data for our dataset
                data: {
                    labels: [
                        <?php
                        $last_day = cal_days_in_month(CAL_GREGORIAN, $mmonth, $yyear);
                        for($i=1;$i<=$last_day;$i++){
                            echo "'$i',";
                        }
                        ?>
                        
                        ],
                    datasets: [{
                            label: 'HQ',
                            backgroundColor: 'rgb(153, 208, 99)',
                            borderColor: 'rgb(153, 208, 99)',
                            fill: false,
                            data: []
                        },
                        {
                            label: 'TSC',
                            backgroundColor: 'rgb(239, 161, 49)',
                            borderColor: 'rgb(239, 161, 49)',
                            fill: false,
                            data: []
                        },
                        {
                            label: 'OSW',
                            backgroundColor: 'rgb(79, 199, 229)',
                            borderColor: 'rgb(79, 199, 229)',
                            fill: false,
                            data: []
                        },
                    ]
                },
                // Configuration options go here
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true,
                                userCallback: function(label, index, labels) {
                                    // when the floored value is the same as the value we have a whole number
                                    if (Math.floor(label) === label) {
                                        return label;
                                    }

                                },
                            }
                        }]
                    },
                    /*tooltips: {
                        mode: 'index',
                        intersect: false,
                    },
                    hover: {
                        mode: 'nearest',
                        intersect: true
                    },*/
                    tooltips: {
                        mode: 'index',
                        intersect: false,
                        
                    },
                    hover: {
                        animationDuration: 0,
                        mode: 'nearest',
                        intersect: true
                    },
                    // animation: {
                    //     duration: 1,
                    //     onComplete: function() {
                    //         var chartInstance = this.chart,
                    //             ctx = chartInstance.ctx;

                    //         ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
                    //         ctx.textAlign = 'center';
                    //         ctx.textBaseline = 'bottom';

                    //         this.data.datasets.forEach(function(dataset, i) {
                    //             var meta = chartInstance.controller.getDatasetMeta(i);
                    //             //alert(i);
                    //             if (i == 1) {
                    //                 ctx.fillStyle = 'rgb(239, 161, 49)';
                    //             }else if (i == 2) {
                    //                 ctx.fillStyle = 'rgb(79, 199, 229)';
                    //             }

                    //             meta.data.forEach(function(bar, index) {
                    //                 var data = addCommas(dataset.data[index]);
                    //                 ctx.fillText(data, bar._model.x, bar._model.y - 5);
                    //             });
                    //         });
                    //     }
                    // },
                    title: {
                        display: true,
                        text: 'Absenteeism (Person) <?=$arr_month[$mmonth]?> <?=$yyear?>'
                    }
                }
            });

            $.post("getajax_dashbord_hr.php", {
                status: "chart_absenteeism",
                mmonth : "<?=$mmonth?>",
                yyear : "<?=$yyear?>",
            }).done(function(datas) {
                // alert(datas);
                var bb = datas.split("###", 150);
                var res_0 = bb[0].split("#");
                var res_1 = bb[1].split("#");
                var res_2 = bb[2].split("#");
                res_0.forEach(function(entry) {
                    chart.data.datasets[0].data.push(entry);
                    chart.update();
                })
                res_1.forEach(function(entry) {
                    chart.data.datasets[1].data.push(entry);
                    chart.update();
                })
                res_2.forEach(function(entry) {
                    chart.data.datasets[2].data.push(entry);
                    chart.update();
                })

            })

        }
        function chart_leave() {

            var ctx = document.getElementById('chart_leave').getContext('2d');
            var chart = new Chart(ctx, {
                // The type of chart we want to create
                type: 'line',

                // The data for our dataset
                data: {
                    labels: [
                        <?php
                        $last_day = cal_days_in_month(CAL_GREGORIAN, $mmonth, $yyear);
                        for($i=1;$i<=$last_day;$i++){
                            echo "'$i',";
                        }
                        ?>
                        
                        ],
                    datasets: [{
                            label: 'HQ',
                            backgroundColor: 'rgb(153, 208, 99)',
                            borderColor: 'rgb(153, 208, 99)',
                            fill: false,
                            data: []
                        },
                        {
                            label: 'TSC',
                            backgroundColor: 'rgb(239, 161, 49)',
                            borderColor: 'rgb(239, 161, 49)',
                            fill: false,
                            data: []
                        },
                        {
                            label: 'OSW',
                            backgroundColor: 'rgb(79, 199, 229)',
                            borderColor: 'rgb(79, 199, 229)',
                            fill: false,
                            data: []
                        },
                    ]
                },
                // Configuration options go here
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true,
                                userCallback: function(label, index, labels) {
                                    // when the floored value is the same as the value we have a whole number
                                    if (Math.floor(label) === label) {
                                        return label;
                                    }

                                },
                            }
                        }]
                    },
                    /*tooltips: {
                        mode: 'index',
                        intersect: false,
                    },
                    hover: {
                        mode: 'nearest',
                        intersect: true
                    },*/
                    tooltips: {
                        mode: 'index',
                        intersect: false,
                        
                    },
                    hover: {
                        animationDuration: 0,
                        mode: 'nearest',
                        intersect: true
                    },
                    // animation: {
                    //     duration: 1,
                    //     onComplete: function() {
                    //         var chartInstance = this.chart,
                    //             ctx = chartInstance.ctx;

                    //         ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
                    //         ctx.textAlign = 'center';
                    //         ctx.textBaseline = 'bottom';

                    //         this.data.datasets.forEach(function(dataset, i) {
                    //             var meta = chartInstance.controller.getDatasetMeta(i);
                    //             //alert(i);
                    //             if (i == 1) {
                    //                 ctx.fillStyle = 'rgb(239, 161, 49)';
                    //             }else if (i == 2) {
                    //                 ctx.fillStyle = 'rgb(79, 199, 229)';
                    //             }

                    //             meta.data.forEach(function(bar, index) {
                    //                 var data = addCommas(dataset.data[index]);
                    //                 ctx.fillText(data, bar._model.x, bar._model.y - 5);
                    //             });
                    //         });
                    //     }
                    // },
                    title: {
                        display: true,
                        text: 'Leave (Person) <?=$arr_month[$mmonth]?> <?=$yyear?>'
                    }
                }
            });

            $.post("getajax_dashbord_hr.php", {
                status: "chart_leave",
                mmonth : "<?=$mmonth?>",
                yyear : "<?=$yyear?>",
            }).done(function(datas) {
                // alert(datas);
                var bb = datas.split("###", 150);
                var res_0 = bb[0].split("#");
                var res_1 = bb[1].split("#");
                var res_2 = bb[2].split("#");
                res_0.forEach(function(entry) {
                    chart.data.datasets[0].data.push(entry);
                    chart.update();
                })
                res_1.forEach(function(entry) {
                    chart.data.datasets[1].data.push(entry);
                    chart.update();
                })
                res_2.forEach(function(entry) {
                    chart.data.datasets[2].data.push(entry);
                    chart.update();
                })

            })

        }
        function chart_late() {

            var ctx = document.getElementById('chart_late').getContext('2d');
            var chart = new Chart(ctx, {
                // The type of chart we want to create
                type: 'line',

                // The data for our dataset
                data: {
                    labels: [
                        <?php
                        $last_day = cal_days_in_month(CAL_GREGORIAN, $mmonth, $yyear);
                        for($i=1;$i<=$last_day;$i++){
                            echo "'$i',";
                        }
                        ?>
                        
                        ],
                    datasets: [{
                            label: 'HQ',
                            backgroundColor: 'rgb(153, 208, 99)',
                            borderColor: 'rgb(153, 208, 99)',
                            fill: false,
                            data: []
                        },
                        {
                            label: 'TSC',
                            backgroundColor: 'rgb(239, 161, 49)',
                            borderColor: 'rgb(239, 161, 49)',
                            fill: false,
                            data: []
                        },
                        {
                            label: 'OSW',
                            backgroundColor: 'rgb(79, 199, 229)',
                            borderColor: 'rgb(79, 199, 229)',
                            fill: false,
                            data: []
                        },
                    ]
                },
                // Configuration options go here
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true,
                                userCallback: function(label, index, labels) {
                                    // when the floored value is the same as the value we have a whole number
                                    if (Math.floor(label) === label) {
                                        return label;
                                    }

                                },
                            }
                        }]
                    },
                    /*tooltips: {
                        mode: 'index',
                        intersect: false,
                    },
                    hover: {
                        mode: 'nearest',
                        intersect: true
                    },*/
                    tooltips: {
                        mode: 'index',
                        intersect: false,
                        
                    },
                    hover: {
                        animationDuration: 0,
                        mode: 'nearest',
                        intersect: true
                    },
                    // animation: {
                    //     duration: 1,
                    //     onComplete: function() {
                    //         var chartInstance = this.chart,
                    //             ctx = chartInstance.ctx;

                    //         ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
                    //         ctx.textAlign = 'center';
                    //         ctx.textBaseline = 'bottom';

                    //         this.data.datasets.forEach(function(dataset, i) {
                    //             var meta = chartInstance.controller.getDatasetMeta(i);
                    //             //alert(i);
                    //             if (i == 1) {
                    //                 ctx.fillStyle = 'rgb(239, 161, 49)';
                    //             }else if (i == 2) {
                    //                 ctx.fillStyle = 'rgb(79, 199, 229)';
                    //             }

                    //             meta.data.forEach(function(bar, index) {
                    //                 var data = addCommas(dataset.data[index]);
                    //                 ctx.fillText(data, bar._model.x, bar._model.y - 5);
                    //             });
                    //         });
                    //     }
                    // },
                    title: {
                        display: true,
                        text: 'Late (Person) <?=$arr_month[$mmonth]?> <?=$yyear?>'
                    }
                }
            });

            $.post("getajax_dashbord_hr.php", {
                status: "chart_late",
                mmonth : "<?=$mmonth?>",
                yyear : "<?=$yyear?>",
            }).done(function(datas) {
                // alert(datas);
                var bb = datas.split("###", 150);
                var res_0 = bb[0].split("#");
                var res_1 = bb[1].split("#");
                var res_2 = bb[2].split("#");
                res_0.forEach(function(entry) {
                    chart.data.datasets[0].data.push(entry);
                    chart.update();
                })
                res_1.forEach(function(entry) {
                    chart.data.datasets[1].data.push(entry);
                    chart.update();
                })
                res_2.forEach(function(entry) {
                    chart.data.datasets[2].data.push(entry);
                    chart.update();
                })

            })

        }
        function chart_ot() {

            var ctx = document.getElementById('chart_ot').getContext('2d');
            var chart = new Chart(ctx, {
                // The type of chart we want to create
                type: 'line',

                // The data for our dataset
                data: {
                    labels: [
                        <?php
                        $last_day = cal_days_in_month(CAL_GREGORIAN, $mmonth, $yyear);
                        for($i=1;$i<=$last_day;$i++){
                            echo "'$i',";
                        }
                        ?>
                        
                        ],
                    datasets: [{
                            label: 'HQ',
                            backgroundColor: 'rgb(153, 208, 99)',
                            borderColor: 'rgb(153, 208, 99)',
                            fill: false,
                            data: []
                        },
                        {
                            label: 'TSC',
                            backgroundColor: 'rgb(239, 161, 49)',
                            borderColor: 'rgb(239, 161, 49)',
                            fill: false,
                            data: []
                        },
                        {
                            label: 'OSW',
                            backgroundColor: 'rgb(79, 199, 229)',
                            borderColor: 'rgb(79, 199, 229)',
                            fill: false,
                            data: []
                        },
                    ]
                },
                // Configuration options go here
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true,
                                // userCallback: function(label, index, labels) {
                                //     // when the floored value is the same as the value we have a whole number
                                //     if (Math.floor(label) === label) {
                                //         return label;
                                //     }

                                // },
                            }
                        }]
                    },
                    /*tooltips: {
                        mode: 'index',
                        intersect: false,
                    },
                    hover: {
                        mode: 'nearest',
                        intersect: true
                    },*/
                    tooltips: {
                        mode: 'index',
                        intersect: false,
                        
                    },
                    hover: {
                        animationDuration: 0,
                        mode: 'nearest',
                        intersect: true
                    },
                    // animation: {
                    //     duration: 1,
                    //     onComplete: function() {
                    //         var chartInstance = this.chart,
                    //             ctx = chartInstance.ctx;

                    //         ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
                    //         ctx.textAlign = 'center';
                    //         ctx.textBaseline = 'bottom';

                    //         this.data.datasets.forEach(function(dataset, i) {
                    //             var meta = chartInstance.controller.getDatasetMeta(i);
                    //             //alert(i);
                    //             if (i == 1) {
                    //                 ctx.fillStyle = 'rgb(239, 161, 49)';
                    //             }else if (i == 2) {
                    //                 ctx.fillStyle = 'rgb(79, 199, 229)';
                    //             }

                    //             meta.data.forEach(function(bar, index) {
                    //                 var data = addCommas(dataset.data[index]);
                    //                 ctx.fillText(data, bar._model.x, bar._model.y - 5);
                    //             });
                    //         });
                    //     }
                    // },
                    title: {
                        display: true,
                        text: 'O.T. (Hrs.) <?=$arr_month[$mmonth]?> <?=$yyear?>'
                    }
                }
            });

            $.post("getajax_dashbord_hr.php", {
                status: "chart_ot",
                mmonth : "<?=$mmonth?>",
                yyear : "<?=$yyear?>",
            }).done(function(datas) {
                // alert(datas);
                var bb = datas.split("###", 150);
                var res_0 = bb[0].split("#");
                var res_1 = bb[1].split("#");
                var res_2 = bb[2].split("#");
                res_0.forEach(function(entry) {
                    chart.data.datasets[0].data.push(entry);
                    chart.update();
                })
                res_1.forEach(function(entry) {
                    chart.data.datasets[1].data.push(entry);
                    chart.update();
                })
                res_2.forEach(function(entry) {
                    chart.data.datasets[2].data.push(entry);
                    chart.update();
                })

            })

        }
        function chart_training() {

            var ctx = document.getElementById('chart_training').getContext('2d');
            var chart = new Chart(ctx, {
                // The type of chart we want to create
                type: 'bar',

                // The data for our dataset
                data: {
                    labels: [
                        'HQ','TSC','OSW'                        
                    ],
                    datasets: [
                        {
                            label: 'Target',
                            backgroundColor: 'rgb(239, 161, 49)',
                            borderColor: 'rgb(239, 161, 49)',
                            fill: false,
                            data: []
                        },
                        {
                            label: 'Achieve',
                            backgroundColor: 'rgb(153, 208, 99)',
                            borderColor: 'rgb(153, 208, 99)',
                            fill: false,
                            data: []
                        },
                    ]
                },
                // Configuration options go here
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true,
                                // userCallback: function(label, index, labels) {
                                //     // when the floored value is the same as the value we have a whole number
                                //     if (Math.floor(label) === label) {
                                //         return label;
                                //     }

                                // },
                            }
                        }]
                    },
                    /*tooltips: {
                        mode: 'index',
                        intersect: false,
                    },
                    hover: {
                        mode: 'nearest',
                        intersect: true
                    },*/
                    tooltips: {
                        mode: 'index',
                        intersect: false,
                        
                    },
                    hover: {
                        animationDuration: 0,
                        mode: 'nearest',
                        intersect: true
                    },
                    // animation: {
                    //     duration: 1,
                    //     onComplete: function() {
                    //         var chartInstance = this.chart,
                    //             ctx = chartInstance.ctx;

                    //         ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
                    //         ctx.textAlign = 'center';
                    //         ctx.textBaseline = 'bottom';

                    //         this.data.datasets.forEach(function(dataset, i) {
                    //             var meta = chartInstance.controller.getDatasetMeta(i);
                    //             //alert(i);
                    //             if (i == 1) {
                    //                 ctx.fillStyle = 'rgb(239, 161, 49)';
                    //             }else if (i == 2) {
                    //                 ctx.fillStyle = 'rgb(79, 199, 229)';
                    //             }

                    //             meta.data.forEach(function(bar, index) {
                    //                 var data = addCommas(dataset.data[index]);
                    //                 ctx.fillText(data, bar._model.x, bar._model.y - 5);
                    //             });
                    //         });
                    //     }
                    // },
                    title: {
                        display: true,
                        text: 'OJT training '
                    }
                }
            });

            $.post("getajax_dashbord_hr.php", {
                status: "chart_training",
            }).done(function(datas) {
                // alert(datas);
                var bb = datas.split("###", 150);
                var res_0 = bb[0].split("#");
                var res_1 = bb[1].split("#");
                // alert(res_0);
                res_0.forEach(function(entry) {
                    chart.data.datasets[0].data.push(entry);
                    chart.update();
                })
                res_1.forEach(function(entry) {
                    chart.data.datasets[1].data.push(entry);
                    chart.update();
                })

            })

        }

        function chart_turnover_rate() {

            var ctx = document.getElementById('chart_turnover_rate').getContext('2d');
            var chart = new Chart(ctx, {
                // The type of chart we want to create
                type: 'bar',

                // The data for our dataset
                data: {
                    labels: [
                        'HQ','TSC','OSW'                        
                    ],
                    datasets: [
                        {
                            label: 'IN',
                            backgroundColor: 'rgb(153, 208, 99)',
                            borderColor: 'rgb(153, 208, 99)',
                            fill: false,
                            data: []
                        },
                        {
                            label: 'OUT',
                            backgroundColor: 'rgb(217,83,79)',
                            borderColor: 'rgb(217,83,79)',
                            fill: false,
                            data: []
                        },
                    ]
                },
                // Configuration options go here
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true,
                                userCallback: function(label, index, labels) {
                                    // when the floored value is the same as the value we have a whole number
                                    if (Math.floor(label) === label) {
                                        return label;
                                    }

                                },
                                // max:5
                            }
                        }]
                    },
                    tooltips: {
                        mode: 'index',
                        intersect: false,
                        
                    },
                    hover: {
                        animationDuration: 0,
                        mode: 'nearest',
                        intersect: true
                    },
                    title: {
                        display: true,
                        text: 'Turnover rate <?=$arr_month[$mmonth]?> <?=$yyear?>'
                    }
                }
            });

            $.post("getajax_dashbord_hr.php", {
                status: "chart_turnover_rate",
                mmonth : "<?=$mmonth?>",
                yyear : "<?=$yyear?>",
            }).done(function(datas) {
                // alert(datas);
                var bb = datas.split("###", 150);
                var res_0 = bb[0].split("#");
                var res_1 = bb[1].split("#");
                // alert(res_0);
                res_0.forEach(function(entry) {
                    chart.data.datasets[0].data.push(entry);
                    chart.update();
                })
                res_1.forEach(function(entry) {
                    chart.data.datasets[1].data.push(entry);
                    chart.update();
                })

            })

        }

        function chart_hbd() {

            var ctx = document.getElementById('chart_hbd').getContext('2d');
            var chart = new Chart(ctx, {
                // The type of chart we want to create
                type: 'bar',

                // The data for our dataset
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    datasets: [
                        {
                            label: 'Birthday',
                            backgroundColor: 'rgb(255, 99, 132)',
                            borderColor: 'rgb(255, 99, 132)',
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
                        text: 'Birthday'
                    }
                }
            });

            $.post("getajax_dashbord_hr.php", {
                status: "chart_hbd"
            }).done(function(datas) {
                var res = datas.split("#");
                res.forEach(function(entry) {
                    chart.data.datasets[0].data.push(entry);
                    chart.update();
                })
            })

        }

        
    </script>
</head>
<style>
    /* Draw the lines */
    .line {
        height: 60px
        /* width: 1px; */
    }
    .line-short {
        height: 20px;
        /* width: 1px; */
    }

    .down {
        background-color: black;	
        margin: 0px auto;
        width: 1px;
    }

    .top {
        border-top: 1px solid black;
    }

    .left {
        /* border-right: 1px solid white; */
    }

    .right {
        border-left: 1px solid black;
    }
    .btn-ipack{
        border-radius: 8px!important;
        color: #ffffff;
        background-color: #896144;
        border-color: #896144;
        font-size: 10px;
        width:170px;
        height:52px;
    }
    .info-tiles.tiles-ipack .tiles-heading {
        background: #94745d;
        color: #ffffff;
    }
    .info-tiles.tiles-ipack .tiles-body-alt {
        background: #896144;
        color: #ffffff;
    }
    .info-tiles.tiles-ipack .tiles-footer {
        background: #73533c;
        /* color: #ffffff; */
    }
</style>
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
                            include "connect.php";
                            $sql_customer = "SELECT count(id) as total_employee FROM tbemployee Where display_att=1";
                            $res_customer = mssql_query($sql_customer);
                            $row_customer = mssql_fetch_array($res_customer);
                            $total_employee = $row_customer["total_employee"];
                            
                            $sql_customer_hq = "SELECT count(id) as total_employee_hq FROM tbemployee WHERE display_att=1 AND site='HQ'";
                            $res_customer_hq = mssql_query($sql_customer_hq);
                            $row_customer_hq = mssql_fetch_array($res_customer_hq);
                            $total_employee_hq = $row_customer_hq["total_employee_hq"];
                            
                            $sql_customer_tsc = "SELECT count(id) as total_employee_tsc FROM tbemployee WHERE display_att=1 AND site='TSC'";
                            $res_customer_tsc = mssql_query($sql_customer_tsc);
                            $row_customer_tsc = mssql_fetch_array($res_customer_tsc);
                            $total_employee_tsc = $row_customer_tsc["total_employee_tsc"];
                            
                            $sql_customer_osw = "SELECT count(id) as total_employee_osw FROM tbemployee WHERE display_att=1 AND site='OSW'";
                            $res_customer_osw = mssql_query($sql_customer_osw);
                            $row_customer_osw = mssql_fetch_array($res_customer_osw);
                            $total_employee_osw = $row_customer_osw["total_employee_osw"];
                            

                            ?>
                            <div class="row">
                                <div class="col-md-3 col-xs-12 col-sm-6">
                                    <a class="info-tiles tiles-ipack" target='_blank' href="http://ipack-iwis.com/hrs">
                                        <div class="tiles-heading">Employee</div>
                                        <div class="tiles-body-alt">
                                            <i class="fa fa-group"></i>
                                            <div class="text-center"><?=$total_employee?></div>
                                            <small>Total Employee</small>
                                        </div>
                                        <div class="tiles-footer">See More </div>
                                    </a>
                                </div>
                                <div class="col-md-3 col-xs-12 col-sm-6">
                                    <a class="info-tiles tiles-success" target='_blank'  href="http://ipack-iwis.com/hrs">
                                        <div class="tiles-heading">Employee</div>
                                        <div class="tiles-body-alt">
                                            <i class="fa fa-user"></i>
                                            <div class="text-center"><?=$total_employee_hq?></div>
                                            <small>Total HQ</small>
                                        </div>
                                        <div class="tiles-footer">See more</div>
                                    </a>
                                </div>
                                <div class="col-md-3 col-xs-12 col-sm-6">
                                    <a class="info-tiles tiles-orange" target='_blank'  href="http://ipack-iwis.com/hrs">
                                        <div class="tiles-heading">Employee</div>
                                        <div class="tiles-body-alt">
                                            <i class="fa fa-user"></i>
                                            <div class="text-center"><?=$total_employee_tsc?></div>
                                            <small>Total TSC</small>
                                        </div>
                                        <div class="tiles-footer">See more</div>
                                    </a>
                                </div>
                                
                                <div class="col-md-3 col-xs-12 col-sm-6">
                                    <a class="info-tiles tiles-info" target='_blank'   href="http://ipack-iwis.com/hrs">
                                        <div class="tiles-heading">Employee</div>
                                        <div class="tiles-body-alt">
                                            <i class="fa fa-user"></i>
                                            <div class="text-center"><?=$total_employee_osw?></div>
                                            <small>Total OSW</small>
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
                                <button type="submit" class="btn btn-info" onclick="location='dashboard_hr.php?mmonth='+document.getElementById('mmonth').value+'&yyear='+document.getElementById('yyear').value+''">Search</button>
                            </div>
                        </div>
                    </div>
                    <br>

                    <!-- Row organization chart -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-info">
                                <div class="panel-body">
                                    <h4 class="" style="margin: 0 0 20px;">Organization</h4>
                                    <br>
                                    <div class="table-responsive">
                                        <table border='0' width='100%'>
                                            <tr>
                                                <td colspan='7' align='center'>
                                                    <button class="btn-ipack">
                                                        Managet Director<br>(Supattra Srinorakut)
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="7">
                                                    <div class="line-short down"></div>
                                                </td>
                                            </tr>
                                           
                                            <tr>
                                                <td colspan='7' align='center'>
                                                    <button class="btn-ipack">
                                                        <table>
                                                            <tr>
                                                                <td><img src='emppic/56002.jpg' width='45px'></td>
                                                                <td> General Manager<br>(Pongthorn Wiriyasakulsuk)</td>
                                                            </tr>
                                                        </table>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="7">
                                                    <div class="line-short down"></div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width='200px'>
                                                    <table border=0 width='100%'>
                                                        <tr>
                                                            <td width='50%' class="line-short left">&nbsp;</td>
                                                            <td width='50%' class="line-short right top">&nbsp;</td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td width='200px'>
                                                    <table border=0 width='100%'>
                                                        <tr>
                                                            <td width='50%' class="line-short left top">&nbsp;</td>
                                                            <td width='50%' class="line-short right top">&nbsp;</td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td width='200px'>
                                                    <table border=0 width='100%'>
                                                        <tr>
                                                            <td width='50%' class="line-short left top">&nbsp;</td>
                                                            <td width='50%' class="line-short left top">&nbsp;</td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td width='200px'>
                                                    <table border=0 width='100%'>
                                                        <tr>
                                                            <td width='50%' class="line-short left top">&nbsp;</td>
                                                            <td width='50%' class="line-short right top">&nbsp;</td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td width='200px'>
                                                    <table border=0 width='100%'>
                                                        <tr>
                                                            <td width='50%' class="line-short left top">&nbsp;</td>
                                                            <td width='50%' class="line-short left top">&nbsp;</td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td width='200px'>
                                                    <table border=0 width='100%'>
                                                        <tr>
                                                            <td width='50%' class="line-short left top">&nbsp;</td>
                                                            <td width='50%' class="line-short right top">&nbsp;</td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td width='200px'>
                                                    <table border=0 width='100%'>
                                                        <tr>
                                                            <td width='50%' class="line-short left top">&nbsp;</td>
                                                            <td width='50%' class="line-short right ">&nbsp;</td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr id="senior_manager">
                                                <td align='center'>
                                                    <table border=0 width='100%'>
                                                        <tr>
                                                            <td width='50%' class="line left">&nbsp;</td>
                                                            <td width='50%' class="line right ">&nbsp;</td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td align='center'>
                                                    <table border=0 width='100%'>
                                                        <tr>
                                                            <td width='50%' class="line left">&nbsp;</td>
                                                            <td width='50%' class="line right ">&nbsp;</td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td align='center'>
                                                    
                                                </td>
                                                <td align='center'>
                                                    <button class="btn-ipack">
                                                        <?php
                                                        $sql = "SELECT empno,firstname_en,lastname_en FROM tbemployee WHERE positionid = 'P012' AND display_att='1'";
                                                        $res = mssql_query($sql);
                                                        $row = mssql_fetch_array($res);
                                                        $empno = $row["empno"];
                                                        $firstname_en = $row["firstname_en"];
                                                        $lastname_en = $row["lastname_en"];
                                                        ?>
                                                        <table width='100%'>
                                                            <tr>
                                                                <td><img src='emppic/<?=$empno?>.jpg' width='45px'></td>
                                                                <td> Senior WH Manager<br>(<?=$firstname_en?> <?=$lastname_en?>)</td>
                                                            </tr>
                                                        </table>
                                                    </button>
                                                </td>
                                                <td align='center'>
                                                    
                                                </td>
                                                <td align='center'>
                                                    <table border=0 width='100%'>
                                                        <tr>
                                                            <td width='50%' class="line left">&nbsp;</td>
                                                            <td width='50%' class="line right ">&nbsp;</td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td align='center'>
                                                    <table border=0 width='100%'>
                                                        <tr>
                                                            <td width='50%' class="line left">&nbsp;</td>
                                                            <td width='50%' class="line right ">&nbsp;</td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr id="manager">
                                                <td align='center'>
                                                    <button class="btn-ipack">
                                                        <?php
                                                        $sql = "SELECT empno,firstname_en,lastname_en FROM tbemployee WHERE positionid = 'P013' AND display_att='1'";
                                                        $res = mssql_query($sql);
                                                        $row = mssql_fetch_array($res);
                                                        $empno = $row["empno"];
                                                        $firstname_en = $row["firstname_en"];
                                                        $lastname_en = $row["lastname_en"];
                                                        ?>
                                                        <table width='100%'>
                                                            <tr>
                                                                <td><img src='emppic/<?=$empno?>.jpg' width='45px'></td>
                                                                <td> Engineer Manager<br>(<?=$firstname_en?> <?=$lastname_en?>)</td>
                                                            </tr>
                                                        </table>
                                                    </button>
                                                </td>
                                                <td align='center'>
                                                    <table border=0 width='100%'>
                                                        <tr>
                                                            <td width='50%' class="line left">&nbsp;</td>
                                                            <td width='50%' class="line right ">&nbsp;</td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td align='center'>
                                                    <table border=0 width='100%'>
                                                        <tr>
                                                            <td width='50%' class="line left">&nbsp;</td>
                                                            <td width='50%' class="line right top">&nbsp;</td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td align='center'>
                                                    <table border=0 width='100%'>
                                                        <tr>
                                                            <td width='50%' class="line left top">&nbsp;</td>
                                                            <td width='50%' class="line right top">&nbsp;</td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td align='center'>
                                                    <table border=0 width='100%'>
                                                        <tr>
                                                            <td width='50%' class="line left top">&nbsp;</td>
                                                            <td width='50%' class="line right ">&nbsp;</td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td align='center'>
                                                    <button class="btn-ipack">
                                                        <?php
                                                        $sql = "SELECT empno,firstname_en,lastname_en FROM tbemployee WHERE positionid = 'P010' AND display_att='1'";
                                                        $res = mssql_query($sql);
                                                        $row = mssql_fetch_array($res);
                                                        $empno = $row["empno"];
                                                        $firstname_en = $row["firstname_en"];
                                                        $lastname_en = $row["lastname_en"];
                                                        ?>
                                                        <table width='100%'>
                                                            <tr>
                                                                <td><img src='emppic/<?=$empno?>.jpg' width='45px'></td>
                                                                <td> IT Manager<br>(<?=$firstname_en?> <?=$lastname_en?>)</td>
                                                            </tr>
                                                        </table>
                                                    </button>
                                                </td>
                                                <td align='center'>
                                                    <table border=0 width='100%'>
                                                        <tr>
                                                            <td width='50%' class="line left">&nbsp;</td>
                                                            <td width='50%' class="line right ">&nbsp;</td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr id="assist">
                                                <td align='center'>
                                                    <table border=0 width='100%'>
                                                        <tr>
                                                            <td width='50%' class="line left">&nbsp;</td>
                                                            <td width='50%' class="line right ">&nbsp;</td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td align='center'>
                                                    <button class="btn-ipack">
                                                        <?php
                                                        $sql = "SELECT empno,firstname_en,lastname_en FROM tbemployee WHERE positionid = 'P028' AND departmentid = 'D004' AND display_att='1'";
                                                        $res = mssql_query($sql);
                                                        $row = mssql_fetch_array($res);
                                                        $empno = $row["empno"];
                                                        $firstname_en = $row["firstname_en"];
                                                        $lastname_en = $row["lastname_en"];
                                                        ?>
                                                        <table width='100%'>
                                                            <tr>
                                                                <td><img src='emppic/<?=$empno?>.jpg' width='45px'></td>
                                                                <td> Assistant Logistics Manager<br>(<?=$firstname_en?> <?=$lastname_en?>)</td>
                                                            </tr>
                                                        </table>
                                                    </button>
                                                </td>
                                                <td align='center'>
                                                    <button class="btn-ipack">
                                                        <?php
                                                        $sql = "SELECT empno,firstname_en,lastname_en FROM tbemployee WHERE positionid = 'P011' AND departmentid = 'D005' AND display_att='1'";
                                                        $res = mssql_query($sql);
                                                        $row = mssql_fetch_array($res);
                                                        $empno = $row["empno"];
                                                        $firstname_en = $row["firstname_en"];
                                                        $lastname_en = $row["lastname_en"];
                                                        ?>
                                                        <table width='100%'>
                                                            <tr>
                                                                <td><img src='emppic/<?=$empno?>.jpg' width='45px'></td>
                                                                <td> Assistant WH Manager HQ<br>(<?=$firstname_en?> <?=$lastname_en?>)</td>
                                                            </tr>
                                                        </table>
                                                    </button>
                                                </td>
                                                <td align='center'>
                                                    <button class="btn-ipack">
                                                        <?php
                                                        $sql = "SELECT empno,firstname_en,lastname_en FROM tbemployee WHERE positionid = 'P025' AND display_att='1'";
                                                        $res = mssql_query($sql);
                                                        $row = mssql_fetch_array($res);
                                                        $empno = $row["empno"];
                                                        $firstname_en = $row["firstname_en"];
                                                        $lastname_en = $row["lastname_en"];
                                                        ?>
                                                        <table width='100%'>
                                                            <tr>
                                                                <td><img src='emppic/<?=$empno?>.jpg' width='45px'></td>
                                                                <td>Assistant WH Manager TSC<br>(<?=$firstname_en?> <?=$lastname_en?>)</td>
                                                            </tr>
                                                        </table>
                                                    </button>
                                                </td>
                                                <td align='center'>
                                                    <button class="btn-ipack">
                                                        <?php
                                                        $sql = "SELECT empno,firstname_en,lastname_en FROM tbemployee WHERE positionid = 'P027' AND display_att='1'";
                                                        $res = mssql_query($sql);
                                                        $row = mssql_fetch_array($res);
                                                        $empno = $row["empno"];
                                                        $firstname_en = $row["firstname_en"];
                                                        $lastname_en = $row["lastname_en"];
                                                        ?>
                                                        <table width='100%'>
                                                            <tr>
                                                                <td><img src='emppic/<?=$empno?>.jpg' width='45px'></td>
                                                                <td>Assistant WH Manager OSW<br>(<?=$firstname_en?> <?=$lastname_en?>)</td>
                                                            </tr>
                                                        </table>
                                                    </button>
                                                </td>
                                                <td align='center'>
                                                    <table border=0 width='100%'>
                                                        <tr>
                                                            <td width='50%' class="line left">&nbsp;</td>
                                                            <td width='50%' class="line right ">&nbsp;</td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td align='center'>
                                                    <table border=0 width='100%'>
                                                        <tr>
                                                            <td width='50%' class="line left">&nbsp;</td>
                                                            <td width='50%' class="line right ">&nbsp;</td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr> 
                                                <td width="200px">
                                                    <table border="0" width="100%">
                                                        <tr>
                                                            <td width="50%" class="line-short left">&nbsp;</td>
                                                            <td width="50%" class="line-short right ">&nbsp;</td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td width="200px">
                                                    <table border="0" width="100%">
                                                        <tr>
                                                            <td width="50%" class="line-short left ">&nbsp;</td>
                                                            <td width="50%" class="line-short right ">&nbsp;</td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td width="200px">
                                                    <table border="0" width="100%">
                                                        <tr>
                                                            <td width="50%" class="line-short left ">&nbsp;</td>
                                                            <td width="50%" class="line-short right ">&nbsp;</td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td width="200px">
                                                    <table border="0" width="100%">
                                                        <tr>
                                                            <td width="50%" class="line-short left ">&nbsp;</td>
                                                            <td width="50%" class="line-short right ">&nbsp;</td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td width="200px">
                                                    <table border="0" width="100%">
                                                        <tr>
                                                            <td width="50%" class="line-short left ">&nbsp;</td>
                                                            <td width="50%" class="line-short right ">&nbsp;</td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td width="200px">
                                                    <table border="0" width="100%">
                                                        <tr>
                                                            <td width="50%" class="line-short left ">&nbsp;</td>
                                                            <td width="50%" class="line-short right ">&nbsp;</td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td width="200px">
                                                    <table border="0" width="100%">
                                                        <tr>
                                                            <td width="50%" class="line-short left ">&nbsp;</td>
                                                            <td width="50%" class="line-short right ">&nbsp;</td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr id="superisor">
                                                <td align='center'>
                                                    <?php
                                                    $sql = "SELECT count(empno) as count_emp FROM tbemployee WHERE positionid = 'P014' AND display_att='1'";
                                                    $res = mssql_query($sql);
                                                    $row = mssql_fetch_array($res);
                                                    $count_emp = $row["count_emp"];
                                                    ?>
                                                    <button class="btn-ipack">Engineer<br> <?=$count_emp?> person</button>
                                                </td>
                                                <td align='center'>
                                                    <table border=0 width='100%'>
                                                        <tr>
                                                            <td width='50%' class="line left">&nbsp;</td>
                                                            <td width='50%' class="line right ">&nbsp;</td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td align='center'>
                                                    <?php
                                                    $sql = "SELECT count(empno) as count_emp FROM tbemployee WHERE positionid = 'P004' AND display_att='1'";
                                                    $res = mssql_query($sql);
                                                    $row = mssql_fetch_array($res);
                                                    $count_emp = $row["count_emp"];
                                                    ?>
                                                    <button class="btn-ipack">Supervisor<br> <?=$count_emp?> person</button>
                                                </td>
                                                <td align='center'>
                                                    <table border=0 width='100%'>
                                                        <tr>
                                                            <td width='50%' class="line left">&nbsp;</td>
                                                            <td width='50%' class="line right ">&nbsp;</td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td align='center'>
                                                    <table border=0 width='100%'>
                                                        <tr>
                                                            <td width='50%' class="line left">&nbsp;</td>
                                                            <td width='50%' class="line right ">&nbsp;</td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td align='center'>
                                                    <?php
                                                    $sql = "SELECT count(empno) as count_emp FROM tbemployee WHERE positionid = 'P015' AND display_att='1'";
                                                    $res = mssql_query($sql);
                                                    $row = mssql_fetch_array($res);
                                                    $count_emp = $row["count_emp"];
                                                    ?>
                                                    <button class="btn-ipack">Programmer<br> <?=$count_emp?> person</button>
                                                </td>
                                                <td align='center'>
                                                    <table border=0 width='100%'>
                                                        <tr>
                                                            <td width='50%' class="line left">&nbsp;</td>
                                                            <td width='50%' class="line right ">&nbsp;</td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr> 
                                                <td width="200px">
                                                    
                                                </td>
                                                <td width="200px">
                                                    <table border="0" width="100%">
                                                        <tr>
                                                            <td width="50%" class="line-short left ">&nbsp;</td>
                                                            <td width="50%" class="line-short right ">&nbsp;</td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td width="200px">
                                                    <table border="0" width="100%">
                                                        <tr>
                                                            <td width="50%" class="line-short left ">&nbsp;</td>
                                                            <td width="50%" class="line-short right ">&nbsp;</td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td width="200px">
                                                    <table border="0" width="100%">
                                                        <tr>
                                                            <td width="50%" class="line-short left ">&nbsp;</td>
                                                            <td width="50%" class="line-short right ">&nbsp;</td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td width="200px">
                                                    <table border="0" width="100%">
                                                        <tr>
                                                            <td width="50%" class="line-short left ">&nbsp;</td>
                                                            <td width="50%" class="line-short right ">&nbsp;</td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td width="200px">
                                                </td>
                                                <td width="200px">
                                                    <table border="0" width="100%">
                                                        <tr>
                                                            <td width="50%" class="line-short left ">&nbsp;</td>
                                                            <td width="50%" class="line-short right ">&nbsp;</td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr id="leader">
                                                <td align='center'>
                                                </td>
                                                <td align='center'>
                                                    <?php
                                                    $sql = "SELECT count(empno) as count_emp FROM tbemployee WHERE positionid = 'P006' AND display_att='1'";
                                                    $res = mssql_query($sql);
                                                    $row = mssql_fetch_array($res);
                                                    $count_emp = $row["count_emp"];
                                                    ?>
                                                    <button class="btn-ipack">Logistice Staff<br> <?=$count_emp?> person</button>
                                                </td>
                                                <td align='center'>
                                                    <?php
                                                    $sql = "SELECT count(empno) as count_emp FROM tbemployee WHERE positionid = 'P005' AND display_att='1'";
                                                    $res = mssql_query($sql);
                                                    $row = mssql_fetch_array($res);
                                                    $count_emp = $row["count_emp"];
                                                    ?>
                                                    <button class="btn-ipack">Leader<br> <?=$count_emp?> person</button>
                                                </td>
                                                <td align='center'>
                                                <?php
                                                    $sql = "SELECT count(empno) as count_emp FROM tbemployee WHERE positionid = 'P020' AND display_att='1'";
                                                    $res = mssql_query($sql);
                                                    $row = mssql_fetch_array($res);
                                                    $count_emp = $row["count_emp"];
                                                    ?>
                                                    <button class="btn-ipack">Leader<br> <?=$count_emp?> person</button>
                                                </td>
                                                <td align='center'>
                                                    <?
                                                    $sql = "SELECT count(empno) as count_emp FROM tbemployee WHERE positionid = 'P021' AND display_att='1'";
                                                    $res = mssql_query($sql);
                                                    $row = mssql_fetch_array($res);
                                                    $count_emp = $row["count_emp"];
                                                    ?>
                                                    <button class="btn-ipack">Leader<br> <?=$count_emp?> person</button>
                                                </td>
                                                <td align='center'>
                                                </td>
                                                <td align='center'>
                                                    <button class="btn-ipack">
                                                        <?php
                                                        $sql = "SELECT empno,firstname_en,lastname_en FROM tbemployee WHERE positionid = 'P007' AND display_att='1'";
                                                        $res = mssql_query($sql);
                                                        $row = mssql_fetch_array($res);
                                                        $empno = $row["empno"];
                                                        $firstname_en = $row["firstname_en"];
                                                        $lastname_en = $row["lastname_en"];
                                                        ?>
                                                        <table width='100%' >
                                                            <tr>
                                                                <td><img src='emppic/<?=$empno?>.jpg' width='45px'></td>
                                                                <td >Admin<br>(<?=$firstname_en?> <?=$lastname_en?>)</td>
                                                            </tr>
                                                        </table>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr> 
                                                <td width="200px">
                                                </td>
                                                <td width="200px">
                                                </td>
                                                <td width="200px">
                                                    <table border="0" width="100%">
                                                        <tr>
                                                            <td width="50%" class="line-short left ">&nbsp;</td>
                                                            <td width="50%" class="line-short right ">&nbsp;</td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td width="200px">
                                                    <table border="0" width="100%">
                                                        <tr>
                                                            <td width="50%" class="line-short left ">&nbsp;</td>
                                                            <td width="50%" class="line-short right ">&nbsp;</td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td width="200px">
                                                    <table border="0" width="100%">
                                                        <tr>
                                                            <td width="50%" class="line-short left ">&nbsp;</td>
                                                            <td width="50%" class="line-short right ">&nbsp;</td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td width="200px">
                                                </td>
                                                <td width="200px">
                                                </td>
                                            </tr>
                                            <tr id="operation">
                                                <td align='center'>
                                                </td>
                                                <td align='center'>
                                                    
                                                </td>
                                                <td align='center'>
                                                    <?
                                                    $sql = "SELECT count(empno) as count_emp FROM tbemployee WHERE (positionid = 'P009' or positionid = 'P008') AND display_att='1'";
                                                    $res = mssql_query($sql);
                                                    $row = mssql_fetch_array($res);
                                                    $count_emp = $row["count_emp"];
                                                    ?>
                                                    <button class="btn-ipack">Operator<br> <?=$count_emp?> person</button>
                                                </td>
                                                <td align='center'>
                                                    <?
                                                    $sql = "SELECT count(empno) as count_emp FROM tbemployee WHERE positionid = 'P018' AND display_att='1'";
                                                    $res = mssql_query($sql);
                                                    $row = mssql_fetch_array($res);
                                                    $count_emp = $row["count_emp"];
                                                    ?>
                                                    <button class="btn-ipack">Operator<br> <?=$count_emp?> person</button>
                                                </td>
                                                <td align='center'>
                                                    <?
                                                    $sql = "SELECT count(empno) as count_emp FROM tbemployee WHERE positionid = 'P019' AND display_att='1'";
                                                    $res = mssql_query($sql);
                                                    $row = mssql_fetch_array($res);
                                                    $count_emp = $row["count_emp"];
                                                    ?>
                                                    <button class="btn-ipack">Operator<br> <?=$count_emp?> person</button>
                                                </td>
                                                <td align='center'>
                                                </td>
                                                <td align='center'>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="row">
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <!-- Row organization chart -->

                    <!-- Row Absenteeism and Leave   -->
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
                                            <canvas id="chart_absenteeism"></canvas>
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
                                            <canvas id="chart_leave"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Row Absenteeism and Leave -->

                    <!-- Row late-->
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
                                            <canvas id="chart_late"></canvas>
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
                                            <canvas id="chart_ot"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Row late-->

                    <!-- Row training And turnover rate-->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="panel panel-info">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-12 clearfix">
                                        </div>
                                        <div class="col-md-12">
                                            <canvas id="chart_training"></canvas>
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
                                            <canvas id="chart_turnover_rate"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Row training And turnover rate-->

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
                                            <canvas id="chart_hbd"></canvas>
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
                                            <canvas id="xxx"></canvas>
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