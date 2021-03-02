<?php
session_start();
include("connect_inv.php");

$status = $_REQUEST['status'];
$date=date("d/m/Y");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>I-Wis</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="I-Wis">
    <meta name="author" content="The Red Team">

    <!-- <link href="assets/less/styles.less" rel="stylesheet/less" media="all">  -->
    <link rel="stylesheet" href="assets/css/styles.css?=140">
    <!-- <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600' rel='stylesheet' type='text/css'>-->

    <link href='assets/demo/variations/default.css' rel='stylesheet' type='text/css' media='all' id='styleswitcher'>
    <link href='assets/demo/variations/default.css' rel='stylesheet' type='text/css' media='all' id='headerswitcher'>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries. Placeholdr.js enables the placeholder attribute -->
    <!--[if lt IE 9]>
        <link rel="stylesheet" href="assets/css/ie8.css">
		<script type="text/javascript" src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/respond.js/1.1.0/respond.min.js"></script>
        <script type="text/javascript" src="assets/plugins/charts-flot/excanvas.min.js"></script>
	<![endif]-->

    <!-- The following CSS are included as plugins and can be removed if unused-->

    <link rel='stylesheet' type='text/css' href='assets/plugins/jqueryui-timepicker/jquery.ui.timepicker.css' /> 
<link rel='stylesheet' type='text/css' href='assets/plugins/form-daterangepicker/daterangepicker-bs3.css' /> 
<link rel='stylesheet' type='text/css' href='assets/js/jqueryui.css' /> 
<link rel='stylesheet' type='text/css' href='assets/plugins/codeprettifier/prettify.css' /> 
<link rel='stylesheet' type='text/css' href='assets/plugins/form-toggle/toggles.css' /> 
<script type="text/javascript" src="assets/js/jquery-1.10.2.min.js"></script>
<style>
.demo{
    font-family:'Conv_free3of9',Sans-Serif;
}
.timeline-centered {
    position: relative;
    margin-bottom: 30px;
}
.image-upload>input {
    display: none;
}

.image-upload img {
    width: 80px;
    cursor: pointer;
}
</style>
    <!--<script type="text/javascript" src="assets/js/less.js"></script>-->

    <script>
        $(function() {

            $('#empno').focus();
            select_date_report_tsc();
            show_key_activity();
            //show_box_vmi();
            //document.getElementById('AIS-selection').style.display='';
            $("#report_date").datepicker({
                dateFormat:'dd/mm/yy'
            });
        });
        function select_date_report_tsc(){
            $("#show_form_daily_report").html("loading...");
            $("#key_activity").html("loading.");
            $("#morning_meeting").html("loading.");
            var report_date = $("#report_date").val();
            $.post( "getajax_daily_report.php", { 
                status: "select_date_report_tsc",
                report_date : report_date
            })
            .done(function( data ) { 
                
                $("#show_form_daily_report").html(data);
                safety_cal();

                $("#key_activity").html("loading..");
                show_key_activity();

                $("#morning_meeting").html("loading..");
            });
        }
        function time_att_cal(){
            /*var att_asst_mgr = parseInt($("#att_asst_mgr").val());
            var att_supervisor = parseInt($("#att_supervisor").val());
            var att_leader = parseInt($("#att_leader").val());
            var att_operator = parseInt($("#att_operator").val());
            var att_late = parseInt($("#att_late").val());
            var att_plan = parseInt($("#att_plan").val());
            var att_total = parseInt($("#att_total").val());
            var att_total_percent = parseInt($("#att_total_percent").val());
            var att_achieve =$("#att_achieve").val();
            var att_total = (att_asst_mgr+att_supervisor+att_leader+att_operator)-att_late;
            var att_total_percent = Math.round((att_total/att_plan)*100);
            $("#att_total").val(att_total);
            //alert(att_plan);
            if(att_total_percent>100){
                att_total_percent=100
            }
            $("#att_total_percent").val(att_total_percent);
            if(att_total_percent>87){
                att_achieve="On";
            }else{
                att_achieve="No";
            }
            $("#att_achieve").val(att_achieve);*/
        }
        function safety_cal(){
            var safety_human = $("#safety_human").val();
            var safety_part = $("#safety_part").val();
            var safety_nearmiss = $("#safety_nearmiss").val();
            var safety_target = $("#safety_target").val();
            if(safety_human>0 || safety_part>0 || safety_nearmiss>0){
                $("#safety_target").val(0);
            }else{
                $("#safety_target").val(100);
            }
            
        }
        function save_daily_report_tsc(){
            var report_date = $("#report_date").val();
            var safety_human = $("#safety_human").val();
            var safety_part = $("#safety_part").val();
            var safety_nearmiss = $("#safety_nearmiss").val();
            var safety_target = $("#safety_target").val();
            var ss_daily = $("#ss_daily").val();
            var ss_daily_day = $("#ss_daily_day").val();
            var ss_daily_night = $("#ss_daily_night").val();
            var att_asst_mgr = $("#att_asst_mgr").val();
            var att_supervisor = $("#att_supervisor").val();
            var att_leader = $("#att_leader").val();
            var att_operator = $("#att_operator").val();
            var att_late = $("#att_late").val();
            var att_forklift_day = $("#att_forklift_day").val();
            var att_forklift_night = $("#att_forklift_night").val();
            var ss_daily_percent = $("#ss_daily_percent").val();
            var att_plan = $("#att_plan").val();
            var att_total = $("#att_total").val();
            var att_total_percent = $("#att_total_percent").val();
            var att_achieve = $("#att_achieve").val();
            var ot_asst_mgr_prs = $("#ot_asst_mgr_prs").val();
            var ot_asst_mgr_hrs = $("#ot_asst_mgr_hrs").val();
            var ot_supervisor_prs = $("#ot_supervisor_prs").val();
            var ot_supervisor_hrs = $("#ot_supervisor_hrs").val();
            var ot_leader_prs = $("#ot_leader_prs").val();
            var ot_leader_hrs = $("#ot_leader_hrs").val();
            var ot_operator_prs = $("#ot_operator_prs").val();
            var ot_operator_hrs = $("#ot_operator_hrs").val();
            var ot_target = $("#ot_target").val();
            var ot_actual = $("#ot_actual").val();
            var ot_achieve = $("#ot_achieve").val();
            var ot_remark = $("#ot_remark").val();
            var per_receive_box = $("#per_receive_box").val();
            var per_hold_box = $("#per_hold_box").val();
            var per_damage_box = $("#per_damage_box").val();
            
            var issue_order_order = $("#issue_order_order").val();
            var issue_order_box = $("#issue_order_box").val();
            var issue_order_incomplete_order = $("#issue_order_incomplete_order").val();
            var issue_order_incomplete_box = $("#issue_order_incomplete_box").val();
            var issue_order_complete_order = $("#issue_order_complete_order").val();
            var issue_order_complete_box = $("#issue_order_complete_box").val();
            var issue_performance_order = $("#issue_performance_order").val();
            var issue_performance_box = $("#issue_performance_box").val();

            var qa_partinbox_cus = $("#qa_partinbox_cus").val();
            var qa_partinbox_ipack = $("#qa_partinbox_ipack").val();
            var qa_westbox_ipack = $("#qa_westbox_ipack").val();
            var qa_result = $("#qa_result").val();

            var per_receive_box_vmi = $("#per_receive_box_vmi").val();
            var per_hold_box_vmi = $("#per_hold_box_vmi").val();
            var per_damage_box_vmi = $("#per_damage_box_vmi").val();
            
            var issue_order_order_vmi = $("#issue_order_order_vmi").val();
            var issue_order_box_vmi = $("#issue_order_box_vmi").val();
            var issue_order_incomplete_order_vmi = $("#issue_order_incomplete_order_vmi").val();
            var issue_order_incomplete_box_vmi = $("#issue_order_incomplete_box_vmi").val();
            var issue_order_complete_order_vmi = $("#issue_order_complete_order_vmi").val();
            var issue_order_complete_box_vmi = $("#issue_order_complete_box_vmi").val();
            var issue_performance_order_vmi = $("#issue_performance_order_vmi").val();
            var issue_performance_box_vmi = $("#issue_performance_box_vmi").val();

            $.post( "getajax_daily_report.php", { 
                status: "save_daily_report_tsc",
                report_date : report_date,
                safety_human : safety_human,
                safety_part : safety_part,
                safety_nearmiss : safety_nearmiss,
                safety_target : safety_target,
                ss_daily : ss_daily,
                ss_daily_day : ss_daily_day,
                ss_daily_night : ss_daily_night,
                ss_daily_percent : ss_daily_percent,
                att_asst_mgr : att_asst_mgr,
                att_supervisor : att_supervisor,
                att_leader : att_leader,
                att_operator : att_operator,
                att_late : att_late,
                att_forklift_day : att_forklift_day,
                att_forklift_night : att_forklift_night,
                att_plan : att_plan,
                att_total : att_total,
                att_total_percent : att_total_percent,
                att_achieve : att_achieve,
                ot_asst_mgr_prs : ot_asst_mgr_prs,
                ot_asst_mgr_hrs : ot_asst_mgr_hrs,
                ot_supervisor_prs : ot_supervisor_prs,
                ot_supervisor_hrs : ot_supervisor_hrs,
                ot_leader_prs : ot_leader_prs,
                ot_leader_hrs : ot_leader_hrs,
                ot_operator_prs : ot_operator_prs,
                ot_operator_hrs : ot_operator_hrs,
                ot_target : ot_target,
                ot_actual : ot_actual,
                ot_achieve : ot_achieve,
                ot_remark : ot_remark,
                per_receive_box : per_receive_box,
                per_hold_box : per_hold_box,
                per_damage_box : per_damage_box,
                
                issue_order_order : issue_order_order,
                issue_order_box : issue_order_box,
                issue_order_incomplete_order : issue_order_incomplete_order,
                issue_order_incomplete_box : issue_order_incomplete_box,
                issue_order_complete_order : issue_order_complete_order,
                issue_order_complete_box : issue_order_complete_box,
                issue_performance_order : issue_performance_order,
                issue_performance_box : issue_performance_box,

                qa_partinbox_cus : qa_partinbox_cus,
                qa_partinbox_ipack : qa_partinbox_ipack,
                qa_westbox_ipack : qa_westbox_ipack,
                qa_result : qa_result,

                per_receive_box_vmi : per_receive_box_vmi,
                per_hold_box_vmi : per_hold_box_vmi,
                per_damage_box_vmi : per_damage_box_vmi,
                
                issue_order_order_vmi : issue_order_order_vmi,
                issue_order_box_vmi : issue_order_box_vmi,
                issue_order_incomplete_order_vmi : issue_order_incomplete_order_vmi,
                issue_order_incomplete_box_vmi : issue_order_incomplete_box_vmi,
                issue_order_complete_order_vmi : issue_order_complete_order_vmi,
                issue_order_complete_box_vmi : issue_order_complete_box_vmi,
                issue_performance_order_vmi : issue_performance_order_vmi,
                issue_performance_box_vmi : issue_performance_box_vmi
            })
            .done(function( data ) { 
                //alert(data);
                select_date_report_tsc();
            });
        }
        function show_key_activity(){
            $("#key_activity").html("loading...");
            var report_date = $("#report_date").val();
            $.post( "getajax_daily_report.php", { 
                status: "show_key_activity",
                report_date : report_date
            })
            .done(function( data ) { 
                //alert(data);
                $("#key_activity").html(data);
            });
        }
        function showmodal2(id) {
            var img = $("#fn" + id).val();
            $("#myModal2").modal({
                backdrop: "static"
            });
            $("#img1").html('<img src=' + img + ' width=550>');
        }
    </script>
</head>

<body>
    <!-- Modal -->
    <div class="modal fade" id="myModal_loading" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">

                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <p>Loading Please wait...</p>
                </div>
                <div class="modal-footer">

                </div>
            </div>

        </div>
    </div>
    <!-- Modal -->
    
<div class="modal fade" id="myModal2" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title">Picture</h4>
            </div>
            <div class="modal-body">
                <div class="form-group" id="img1" style="text-align:center">


                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
    <!-- Modal -->
    <audio id="audio" src="Sound/alert.mp3" autostart="false"></audio>



    <div id="headerbar">
        <div class="container">
            <div class="row">


            </div>
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

                <div class="container">

                    <?
                    if ($status == 'TSC') {
                        ?>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <h4>Daily Report <?=$status?></h4>
                                    </div>
                                    
                                    <div class="panel-body">
                                        <div class='row'>
                                            <div class="form-horizontal">
                                                <div class="form-group">
                                                    <label class="control-label col-sm-1" for="report_date">Date</label>
                                                    <div class="col-sm-2">
                                                        <input type="text" class="form-control" id="report_date" name="report_date" autocomplete="off" value="<?=$date?>" onchange="select_date_report_tsc();">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class='row'>
                                            <div class='col-sm-12'>
                                                <ul class="nav nav-tabs" style='margin-bottom: 20px;'>
                                                    <li class="active"><a data-toggle="tab" href="#show_form_daily_report">Main Daily</a></li>
                                                    <li><a data-toggle="tab" href="#key_activity">Key activity</a></li>
                                                    <li><a data-toggle="tab" href="#morning_meeting">Morning meeting</a></li>
                                                </ul>

                                                <div class="tab-content">
                                                    <div id="show_form_daily_report" class="tab-pane fade in active" >
                                                        
                                                
                                                    </div>
                                                    <div id="key_activity" class="tab-pane fade">
                                                        
                                                    </div>
                                                    <div id="morning_meeting" class="tab-pane fade">
                                                        
                                                    </div>
                                                </div>
                                                
                                            </div>
                                        </div>
                         
                                        

                                    </div>
                                </div>
                            </div>
                        </div>


                    <?
                    }
                    ?>



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

    <!--
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>

<script>!window.jQuery && document.write(unescape('%3Cscript src="assets/js/jquery-1.10.2.min.js"%3E%3C/script%3E'))</script>
<script type="text/javascript">!window.jQuery.ui && document.write(unescape('%3Cscript src="assets/js/jqueryui-1.10.3.min.js'))</script>
-->

    <script type='text/javascript' src='assets/js/jquery-1.10.2.min.js'></script>
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
    <script type='text/javascript' src='assets/demo/demo.js'></script>

</body>

</html>