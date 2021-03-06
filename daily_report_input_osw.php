<?php
session_start();
include("connect_inv.php");

$status = $_REQUEST['status'];
$date=$_GET["date"]==""? date("d/m/Y"):$_GET["date"];
$shift=$_GET["shift"]==""? "Day":$_GET["shift"];



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
    .panel-yellow .panel-heading{
        background-color: #f1c40f;
        border-color: #f1c40f;
    }
    .panel-pink .panel-heading{
        background-color: #c53459;
        border-color: #c53459;
    }
    .panel-green .panel-heading{
        background-color: #257b50;
        border-color: #257b50;
    }
    .panel-organge .panel-heading{
        background-color: #ff9600;
        border-color: #ff9600;
    }
    .panel-blue .panel-heading{
        background-color: #219fa7;
        border-color: #219fa7;
    }
    .panel-purple .panel-heading{
        background-color: #562b69;
        border-color: #562b69;
    }
</style>
    <!--<script type="text/javascript" src="assets/js/less.js"></script>-->

    <script>
        $(function() {

            $('#empno').focus();
            select_date_report_osw();
            //show_key_activity();
            //show_box_vmi();
            //document.getElementById('AIS-selection').style.display='';
            $("#report_date").datepicker({
                dateFormat:'dd/mm/yy'
            });
        });

        
        function fileSelected(id,step) {
            document.getElementById('idselect').value=id;

            var count = document.getElementById('fileToUpload'+id).files.length;

            for (var index = 0; index < count; index ++){

                var file = document.getElementById('fileToUpload'+id).files[index];

                var fileSize = 0;

                if (file.size > 1024 * 1024){

                    fileSize = (Math.round(file.size * 100 / (1024 * 1024)) / 100).toString() + 'MB';

                }else{

                    fileSize = (Math.round(file.size * 100 / 1024) / 100).toString() + 'KB';
                }

                uploadFile(id,step);
            }
        
        }
        function uploadFile(id,step) {
            
            document.getElementById("cam"+id).src = 'images/cam_load.png';
            var fd = new FormData();

            var count = document.getElementById('fileToUpload'+id).files.length;

            for (var index = 0; index < count; index ++){
    
                var file = document.getElementById('fileToUpload'+id).files[index];

                fd.append('myFile', file);

            }
            var job_id_problem = $("#job_id_problem").val();
            
            fd.append('job_id_problem',job_id_problem);
            fd.append('pos',id);
            fd.append('step',step);
        
            var url = '';
            var xhr = new XMLHttpRequest();
    
            xhr.upload.addEventListener("progress", uploadProgress, false);
    
            xhr.addEventListener("load", uploadComplete, false);
    
            xhr.addEventListener("error", uploadFailed, false);
    
            xhr.addEventListener("abort", uploadCanceled, false);
            
            url ="daily_report_cam_activity_external_problem.php";
            
            xhr.open("POST", url);
    
            xhr.send(fd);

        }
        function uploadProgress(evt) {
    
            if (evt.lengthComputable) {
    
            var percentComplete = Math.round(evt.loaded * 100 / evt.total);
    
            document.getElementById('progress').innerHTML = percentComplete.toString() + '%';
    
            }
    
            else {
    
            document.getElementById('progress'+id).innerHTML = 'unable to compute';
    
            }
    
        }
        function uploadComplete(evt) {
            var sid = Math.random();
            /* This event is raised when the server send back a response */
            var idselect =  document.getElementById('idselect').value;
            
            //var master_issue=$("#master_issue").val();
            
            //alert(evt.target.responseText);
            document.getElementById("cam"+idselect).src = 'daily_problem/'+evt.target.responseText+'?T='+sid;
            //$("#status_show"+idselect).html("Finish");
            document.getElementById("fn"+idselect).value = 'daily_problem/'+evt.target.responseText+'?T='+sid;
            //$("#show_delivery_picture"+idselect).html("<a href='delivery_picture/"+idselect+"_1.jpg?T"+sid+"'  target='_blank'>Photo</a>");
            //alert(idselect);
        
        
        }

        function uploadFailed(evt) {

            alert("There was an error attempting to upload the file.");

        }
        function uploadCanceled(evt) {

            alert("The upload has been canceled by the user or the browser dropped the connection.");

        }
        
        function fileSelected_improve(id,step) {
            document.getElementById('idselect_improve').value=id;

            var count = document.getElementById('fileToUpload_improve'+id).files.length;

            for (var index = 0; index < count; index ++){

                var file = document.getElementById('fileToUpload_improve'+id).files[index];

                var fileSize = 0;

                if (file.size > 1024 * 1024){

                    fileSize = (Math.round(file.size * 100 / (1024 * 1024)) / 100).toString() + 'MB';

                }else{

                    fileSize = (Math.round(file.size * 100 / 1024) / 100).toString() + 'KB';
                }

                uploadFile_improve(id,step);
            }
        
        }
        function uploadFile_improve(id,step) {
            
            document.getElementById("cam_improve"+id).src = 'images/cam_load.png';
            var fd = new FormData();

            var count = document.getElementById('fileToUpload_improve'+id).files.length;

            for (var index = 0; index < count; index ++){
    
                var file = document.getElementById('fileToUpload_improve'+id).files[index];

                fd.append('myFile', file);

            }
            var job_id_improve = $("#job_id_improve").val();
            
            fd.append('job_id_improve',job_id_improve);
            fd.append('pos',id);
            fd.append('step',step);
        
            var url = '';
            var xhr = new XMLHttpRequest();
    
            xhr.upload.addEventListener("progress", uploadProgress_improve, false);
    
            xhr.addEventListener("load", uploadComplete_improve, false);
    
            xhr.addEventListener("error", uploadFailed_improve, false);
    
            xhr.addEventListener("abort", uploadCanceled_improve, false);
            
            url ="daily_report_cam_activity_improvement.php";
            
            xhr.open("POST", url);
    
            xhr.send(fd);

        }
        function uploadProgress_improve(evt) {
    
            if (evt.lengthComputable) {
    
            var percentComplete = Math.round(evt.loaded * 100 / evt.total);
    
            document.getElementById('progress_improve').innerHTML = percentComplete.toString() + '%';
    
            }
    
            else {
    
            document.getElementById('progress_improve'+id).innerHTML = 'unable to compute';
    
            }
    
        }
        function uploadComplete_improve(evt) {
            var sid = Math.random();
            /* This event is raised when the server send back a response */
            var idselect_improve =  document.getElementById('idselect_improve').value;
            
            //var master_issue=$("#master_issue").val();
            
            //alert(evt.target.responseText);
            document.getElementById("cam_improve"+idselect_improve).src = 'daily_improve/'+evt.target.responseText+'?T='+sid;
            //$("#status_show"+idselect_improve).html("Finish");
            document.getElementById("fn_improve"+idselect_improve).value = 'daily_improve/'+evt.target.responseText+'?T='+sid;
            //$("#show_delivery_picture"+idselect_improve).html("<a href='delivery_picture/"+idselect_improve+"_1.jpg?T"+sid+"'  target='_blank'>Photo</a>");
            //alert(idselect_improve);
        
        
        }

        function uploadFailed_improve(evt) {

            alert("There was an error attempting to upload the file.");

        }
        function uploadCanceled_improve(evt) {

            alert("The upload has been canceled by the user or the browser dropped the connection.");

        }


        function select_date_report_osw(){
            $("#show_form_daily_report").html("loading...");
            $("#show_key_activity_proplem").html("loading.");
            $("#show_key_activity_inventory").html("loading.");
            $("#show_key_activity_5s_audit").html("loading.");
            $("#show_key_activity_improvement").html("loading.");
            $("#show_morning_meeting").html("loading.");
            var report_date = $("#report_date").val();
            var shift = $("#shift").val();
            $.post( "getajax_daily_report_osw.php", { 
                status: "select_date_report_osw",
                report_date : report_date,
                shift : shift,
            })
            .done(function( data ) { 
                $("#shift").val(shift);
                $("#show_form_daily_report").html(data);
                safety_cal();
                time_att_cal();
                qa_result_cal();
                issue_delay_cal();
                $("#show_key_activity_proplem").html("loading..");
                $("#show_key_activity_inventory").html("loading..");
                $("#show_key_activity_5s_audit").html("loading..");
                $("#show_key_activity_improvement").html("loading..");
                show_key_activity();

                $("#show_morning_meeting").html("loading..");
                show_morning_meeting();
            });
        }
        function time_att_cal(){
            var att_asst_mgr = parseInt($("#att_asst_mgr").val());
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
                att_achieve="Not";
            }
            $("#att_achieve").val(att_achieve);
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
        function qa_result_cal(){
            var qa_partinbox_cus = $("#qa_partinbox_cus").val();
            var qa_partinbox_ipack = $("#qa_partinbox_ipack").val();
            var qa_westbox_ipack = $("#qa_westbox_ipack").val();
            if(qa_partinbox_ipack>0 || qa_westbox_ipack>0){
                $("#qa_result").val("NG");
            }else{
                $("#qa_result").val("OK");
            }
            
        }
        function issue_delay_cal(){
            var issue_on_time_target = parseInt($("#issue_on_time_target").val());
            var issue_on_time_actual = parseInt($("#issue_on_time_actual").val());
            var issue_on_time_delay = issue_on_time_target-issue_on_time_actual;
            $("#issue_on_time_delay").val(issue_on_time_delay);
        }
        function ot_achieve_cal(){
            var ot_target = parseInt($("#ot_target").val());
            var ot_actual = parseInt($("#ot_actual").val());

            if(ot_target>=ot_actual){
                $("#ot_achieve").val("On");
            }else{
                $("#ot_achieve").val("Not");
            }
            
        }
        function save_daily_report_osw(){
            var report_date = $("#report_date").val();
            var shift = $("#shift").val();
            var safety_human = $("#safety_human").val();
            var safety_part = $("#safety_part").val();
            var safety_nearmiss = $("#safety_nearmiss").val();
            var safety_target = $("#safety_target").val();
            var ss_daily = $("#ss_daily").val();
            var ss_daily_status = $("#ss_daily_status").val();
            var ss_daily_night = $("#ss_daily_night").val();
            var att_asst_mgr = $("#att_asst_mgr").val();
            var att_supervisor = $("#att_supervisor").val();
            var att_leader = $("#att_leader").val();
            var att_operator = $("#att_operator").val();
            var att_late = $("#att_late").val();
            var att_forklift_name = $("#att_forklift_name").val();
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
            var per_cleaning_box = $("#per_cleaning_box").val();
            var per_hold_box = $("#per_hold_box").val();
            var per_damage_box = $("#per_damage_box").val();
            
            var issue_on_time_target = $("#issue_on_time_target").val();
            var issue_on_time_actual = $("#issue_on_time_actual").val();
            var issue_on_time_delay = $("#issue_on_time_delay").val();
            var issue_order_order = $("#issue_order_order").val();
            var issue_order_box = $("#issue_order_box").val();
            var issue_order_incomplete_order = $("#issue_order_incomplete_order").val();
            var issue_order_incomplete_box = $("#issue_order_incomplete_box").val();
            var issue_order_complete_order = $("#issue_order_complete_order").val();
            var issue_order_complete_box = $("#issue_order_complete_box").val();
            var issue_performance_order = $("#issue_performance_order").val();
            var issue_performance_box = $("#issue_performance_box").val();
            var issue_remark = $("#issue_remark").val();

            var qa_partinbox_cus = $("#qa_partinbox_cus").val();
            var qa_partinbox_ipack = $("#qa_partinbox_ipack").val();
            var qa_westbox_ipack = $("#qa_westbox_ipack").val();
            var qa_result = $("#qa_result").val();

        

            $("#myModal_loading").modal({backdrop: "static"});
            if(ot_target==""){
                alert("กรุณาใส่ Overtime Target");
                $("#myModal_loading").modal('hide');
            }else if(att_plan==""){
                alert("กรุณาใส่ Plan TIME ATTENDANCE.");
                $("#myModal_loading").modal('hide');
            }else{

                $.post( "getajax_daily_report_osw.php", { 
                    status: "save_daily_report_osw",
                    report_date : report_date,
                    shift : shift,
                    safety_human : safety_human,
                    safety_part : safety_part,
                    safety_nearmiss : safety_nearmiss,
                    safety_target : safety_target,
                    ss_daily : ss_daily,
                    ss_daily_status : ss_daily_status,
                    ss_daily_percent : ss_daily_percent,
                    att_asst_mgr : att_asst_mgr,
                    att_supervisor : att_supervisor,
                    att_leader : att_leader,
                    att_operator : att_operator,
                    att_late : att_late,
                    att_forklift_name : att_forklift_name,
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
                    per_cleaning_box : per_cleaning_box,
                    per_hold_box : per_hold_box,
                    per_damage_box : per_damage_box,
                    
                    issue_on_time_target : issue_on_time_target,
                    issue_on_time_actual : issue_on_time_actual,
                    issue_on_time_delay : issue_on_time_delay,
                    issue_order_order : issue_order_order,
                    issue_order_box : issue_order_box,
                    issue_order_incomplete_order : issue_order_incomplete_order,
                    issue_order_incomplete_box : issue_order_incomplete_box,
                    issue_order_complete_order : issue_order_complete_order,
                    issue_order_complete_box : issue_order_complete_box,
                    issue_performance_order : issue_performance_order,
                    issue_performance_box : issue_performance_box,
                    issue_remark : issue_remark,

                    qa_partinbox_cus : qa_partinbox_cus,
                    qa_partinbox_ipack : qa_partinbox_ipack,
                    qa_westbox_ipack : qa_westbox_ipack,
                    qa_result : qa_result,

                })
                .done(function( data ) { 
                    // alert(data);
                    $("#myModal_loading").modal('hide');
                    select_date_report_osw();
                    // $(".form-horizontal").html(data);
                });
            }
        }
        function approve_daily_report_osw(){
            var report_date = $("#report_date").val();
            var shift = $("#shift").val();
            var safety_human = $("#safety_human").val();
            var safety_part = $("#safety_part").val();
            var safety_nearmiss = $("#safety_nearmiss").val();
            var safety_target = $("#safety_target").val();
            var ss_daily = $("#ss_daily").val();
            var ss_daily_status = $("#ss_daily_status").val();
            var ss_daily_night = $("#ss_daily_night").val();
            var att_asst_mgr = $("#att_asst_mgr").val();
            var att_supervisor = $("#att_supervisor").val();
            var att_leader = $("#att_leader").val();
            var att_operator = $("#att_operator").val();
            var att_late = $("#att_late").val();
            var att_forklift_name = $("#att_forklift_name").val();
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
            var per_cleaning_box = $("#per_cleaning_box").val();
            var per_hold_box = $("#per_hold_box").val();
            var per_damage_box = $("#per_damage_box").val();
            
            var issue_on_time_target = $("#issue_on_time_target").val();
            var issue_on_time_actual = $("#issue_on_time_actual").val();
            var issue_on_time_delay = $("#issue_on_time_delay").val();
            var issue_order_order = $("#issue_order_order").val();
            var issue_order_box = $("#issue_order_box").val();
            var issue_order_incomplete_order = $("#issue_order_incomplete_order").val();
            var issue_order_incomplete_box = $("#issue_order_incomplete_box").val();
            var issue_order_complete_order = $("#issue_order_complete_order").val();
            var issue_order_complete_box = $("#issue_order_complete_box").val();
            var issue_performance_order = $("#issue_performance_order").val();
            var issue_performance_box = $("#issue_performance_box").val();
            var issue_remark = $("#issue_remark").val();

            var qa_partinbox_cus = $("#qa_partinbox_cus").val();
            var qa_partinbox_ipack = $("#qa_partinbox_ipack").val();
            var qa_westbox_ipack = $("#qa_westbox_ipack").val();
            var qa_result = $("#qa_result").val();

        

            $("#myModal_loading").modal({backdrop: "static"});
            if(ot_target==""){
                alert("กรุณาใส่ Overtime Target");
                $("#myModal_loading").modal('hide');
            }else{

                $.post( "getajax_daily_report_osw.php", { 
                    status: "approve_daily_report_osw",
                    report_date : report_date,
                    shift : shift,
                    safety_human : safety_human,
                    safety_part : safety_part,
                    safety_nearmiss : safety_nearmiss,
                    safety_target : safety_target,
                    ss_daily : ss_daily,
                    ss_daily_status : ss_daily_status,
                    ss_daily_percent : ss_daily_percent,
                    att_asst_mgr : att_asst_mgr,
                    att_supervisor : att_supervisor,
                    att_leader : att_leader,
                    att_operator : att_operator,
                    att_late : att_late,
                    att_forklift_name : att_forklift_name,
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
                    per_cleaning_box : per_cleaning_box,
                    per_hold_box : per_hold_box,
                    per_damage_box : per_damage_box,
                    
                    issue_on_time_target : issue_on_time_target,
                    issue_on_time_actual : issue_on_time_actual,
                    issue_on_time_delay : issue_on_time_delay,
                    issue_order_order : issue_order_order,
                    issue_order_box : issue_order_box,
                    issue_order_incomplete_order : issue_order_incomplete_order,
                    issue_order_incomplete_box : issue_order_incomplete_box,
                    issue_order_complete_order : issue_order_complete_order,
                    issue_order_complete_box : issue_order_complete_box,
                    issue_performance_order : issue_performance_order,
                    issue_performance_box : issue_performance_box,
                    issue_remark : issue_remark,

                    qa_partinbox_cus : qa_partinbox_cus,
                    qa_partinbox_ipack : qa_partinbox_ipack,
                    qa_westbox_ipack : qa_westbox_ipack,
                    qa_result : qa_result,

                })
                .done(function( data ) { 
                    //alert(data);
                    $("#myModal_loading").modal('hide');
                    select_date_report_osw();
                    // $(".form-horizontal").html(data);
                });
            }
        }
        function show_att(){
            $("#show_detail_head").html("TIME ATTENDANCE.");
            $("#show_detail_body").html("Loading....");
            $("#myModal_show_detail").modal();
            var report_date = $("#report_date").val();

            $.post( "getajax_daily_report_osw.php", { 
                status: "show_att",
                report_date : report_date
            })
            .done(function( data ) { 
                $("#show_detail_body").html(data);
            });
            
        }
        function show_ot(){
            $("#show_detail_head").html("OVERTIME Work.");
            $("#show_detail_body").html("Loading....");
            $("#myModal_show_detail").modal();
            var report_date = $("#report_date").val();

            $.post( "getajax_daily_report_osw.php", { 
                status: "show_ot",
                report_date : report_date
            })
            .done(function( data ) { 
                $("#show_detail_body").html(data);
            });
            
        }
        function show_receive_box(shift){
            $("#show_detail_head").html("Receive peformance");
            $("#show_detail_body").html("Loading....");
            $("#myModal_show_detail").modal();
            var report_date = $("#report_date").val();

            $.post( "getajax_daily_report_osw.php", { 
                status: "show_receive_box",
                report_date : report_date,
                shift : shift,
            })
            .done(function( data ) { 
                $("#show_detail_body").html(data);
            });
            
        }
        function show_cleaning_box(shift){
            $("#show_detail_head").html("Cleaning peformance");
            $("#show_detail_body").html("Loading....");
            $("#myModal_show_detail").modal();
            var report_date = $("#report_date").val();

            $.post( "getajax_daily_report_osw.php", { 
                status: "show_cleaning_box",
                report_date : report_date,
                shift : shift,
            })
            .done(function( data ) { 
                $("#show_detail_body").html(data);
            });
            
        }
        function show_hold_box(){
            $("#show_detail_head").html("Hold Box");
            $("#show_detail_body").html("Loading....");
            $("#myModal_show_detail").modal();
            var report_date = $("#report_date").val();

            $.post( "getajax_daily_report_osw.php", { 
                status: "show_hold_box",
                report_date : report_date
            })
            .done(function( data ) { 
                $("#show_detail_body").html(data);
            });
            
        }
        function show_damage_box(){
            $("#show_detail_head").html("Damage Box");
            $("#show_detail_body").html("Loading....");
            $("#myModal_show_detail").modal();
            var report_date = $("#report_date").val();

            $.post( "getajax_daily_report_osw.php", { 
                status: "show_damage_box",
                report_date : report_date
            })
            .done(function( data ) { 
                $("#show_detail_body").html(data);
            });
            
        }
        function show_issue_on_time(shift){
            $("#show_detail_head").html("Target Issue order on time");
            $("#show_detail_body").html("Loading....");
            $("#myModal_show_detail").modal();
            var report_date = $("#report_date").val();

            $.post( "getajax_daily_report_osw.php", { 
                status: "show_issue_on_time",
                report_date : report_date,
                shift : shift,
            })
            .done(function( data ) { 
                $("#show_detail_body").html(data);
            });
            
        }
        function show_issue_order(shift){
            $("#show_detail_head").html("Issue performance ");
            $("#show_detail_body").html("Loading....");
            $("#myModal_show_detail").modal();
            var report_date = $("#report_date").val();

            $.post( "getajax_daily_report_osw.php", { 
                status: "show_issue_order",
                report_date : report_date,
                shift : shift,
            })
            .done(function( data ) { 
                $("#show_detail_body").html(data);
            });
            
        }
        function show_partinbox_cus(){
            $("#show_detail_head").html("Part in box from customer");
            $("#show_detail_body").html("Loading....");
            $("#myModal_show_detail").modal();
            var report_date = $("#report_date").val();

            $.post( "getajax_daily_report_osw.php", { 
                status: "show_partinbox_cus",
                report_date : report_date
            })
            .done(function( data ) { 
                $("#show_detail_body").html(data);
            });
            
        }
        function show_key_activity(){
            
            show_key_activity_proplem();
            show_key_activity_inventory();
            show_key_activity_5s_audit();
            show_key_activity_improvement();
        }
        function show_key_activity_proplem(){
            //alert("sdasd");
            $("#show_key_activity_proplem").html("loading...");
            var report_date = $("#report_date").val();
            var site = "OSW";
            $.post( "getajax_daily_report_key_activity.php", { 
                status: "show_key_activity_proplem",
                report_date : report_date,
                site : site
            })
            .done(function( data ) { 
                //alert(data);
                $("#show_key_activity_proplem").html(data);

                $("#due_problem").datepicker({
                    dateFormat:'dd/mm/yy'
                });
            });
        }
        function showmodal2(id) {
            var img = $("#fn" + id).val();
            $("#myModal2").modal({
                backdrop: "static"
            });
            $("#img1").html('<img src=' + img + ' width=550>');
        }
        function gen_job_id_problem(){
            var filename = "images/cam.png";

            document.getElementById("cam1").src = filename;
            document.getElementById("fn1").value = filename;

            $("#pic_problem_action").show();
            var job_id_problem = $("#job_id_problem").val();
            if(job_id_problem!=""){
                if(confirm("มีเลข Job : "+job_id_problem+" ที่ยังไม่ปิด ต้องการ New Job ใหม่หรือไม่ ?")){
                    $.post( "getajax_daily_report_key_activity.php", { 
                        status: "gen_job_id_problem"
                    })
                    .done(function( data ) {
                        //alert(data);
                        $("#job_id_problem").val(data);
                    });
                }
            }else{
                $.post( "getajax_daily_report_key_activity.php", { 
                    status: "gen_job_id_problem"
                })
                .done(function( data ) {
                    //alert(data);
                    $("#job_id_problem").val(data);
                });
            }
        }
        function save_problem(){
            var report_date = $("#report_date").val();
            var job_id_problem = $("#job_id_problem").val();
            var topic_problem = $("#topic_problem").val();
            var customer_problem = $("#customer_problem").val();
            var pic_problem = $("#pic_problem").val();
            var due_problem = $("#due_problem").val();
            var site = "OSW";

            $("#myModal_loading").modal({backdrop: "static"});

            var txt = "";
            if(topic_problem==""){
                txt += " - กรุณาใส่ Problem\n";
            }
            if(customer_problem==""){
                txt += " - กรุณาใส่ Customer\n";
            }
            if(due_problem==""){
                txt += " - กรุณาใส่วันที่ Due Date \n";
            }
            
            if(txt !=""){
                alert('กรุณาเช็คข้อมูลเหล่านี้ \n'+txt);
                $("#myModal_loading").modal('hide');
            }else{
                $.post( "getajax_daily_report_key_activity.php", { 
                    status: "save_problem",
                    report_date : report_date,
                    job_id_problem : job_id_problem,
                    topic_problem : topic_problem,
                    customer_problem : customer_problem,
                    pic_problem : pic_problem,
                    due_problem : due_problem,
                    site : site,
                })
                .done(function( data ) {
                // alert(data);
                    $("#myModal_loading").modal('hide');
                    show_key_activity_proplem();
                });
            }
        }
        function delete_problem(id){
            if(confirm("ต้องการลบข้อมูลหรือไม่")){
                // alert("y");
                $("#myModal_loading").modal({backdrop: "static"});
                $.post( "getajax_daily_report_key_activity.php", { 
                    status: "delete_problem",
                    id : id
                })
                .done(function( data ) {
                    // alert(data);
                    $("#myModal_loading").modal('hide');
                    show_key_activity_proplem();
                });
            }else{
                // alert("n")
            }
        }
        
        function show_key_activity_inventory(){
            $("#show_key_activity_inventory").html("loading...");
            var report_date = $("#report_date").val();
            $.post( "getajax_daily_report_key_activity.php", { 
                status: "show_key_activity_inventory_osw",
                report_date : report_date
            })
            .done(function( data ) { 
                //alert(data);
                $("#show_key_activity_inventory").html(data);

                $("#plan_count_date,#actual_date").datepicker({
                    dateFormat:'dd/mm/yy'
                });
            });
        }

        function inventory_cal_pallet(){
            var system_pallet = $("#system_pallet").val();
            var actual_pallet = $("#actual_pallet").val();
            var diff_pallet = system_pallet-actual_pallet;
            $("#diff_pallet").val(diff_pallet);
            if(system_pallet>0){
                var accuracy_pallet = (actual_pallet*100)/system_pallet;
                // if(accuracy_pallet > 100){
                //     accuracy_pallet = accuracy_pallet-100;
                // }
                $("#accuracy_pallet").val(accuracy_pallet);
            }else{
                $("#accuracy_pallet").val("0");

            }
        }
        function inventory_cal_box(){
            var system_box = $("#system_box").val();
            var actual_box = $("#actual_box").val();
            var diff_box = system_box-actual_box;
            $("#diff_box").val(diff_box);
            if(system_box>0){
                var accuracy_box = (actual_box*100)/system_box;
                // if(accuracy_box > 100){
                //     accuracy_box = accuracy_box-100;
                // }
                $("#accuracy_box").val(accuracy_box);
            }else{
                $("#accuracy_box").val("0");

            }
        }

        function save_inventory(){
            var report_date = $("#report_date").val();
            var plan_count_date = $("#plan_count_date").val();
            var system_pallet = $("#system_pallet").val();
            var actual_pallet = $("#actual_pallet").val();
            var diff_pallet = $("#diff_pallet").val();
            var accuracy_pallet = $("#accuracy_pallet").val();
            var system_box = $("#system_box").val();
            var actual_box = $("#actual_box").val();
            var diff_box = $("#diff_box").val();
            var accuracy_box = $("#accuracy_box").val();
            // alert(plan_count_date);

            $.post( "getajax_daily_report_key_activity.php", { 
                status: "save_inventory_osw",
                report_date : report_date,
                plan_count_date : plan_count_date,
                system_pallet : system_pallet,
                actual_pallet : actual_pallet,
                diff_pallet : diff_pallet,
                accuracy_pallet : accuracy_pallet,
                system_box : system_box,
                actual_box : actual_box,
                diff_box : diff_box,
                accuracy_box : accuracy_box,
            })
            .done(function( data ) { 
                // alert(data);
                show_key_activity_inventory();
            });
        }
        function update_inventory_osw(id){
            var status_inventory_edit = $("#status_inventory_edit"+id).val();
            $("#myModal_loading").modal({backdrop: "static"});
            $.post( "getajax_daily_report_key_activity.php", { 
                status: "update_inventory_osw",
                id : id,
                status_inventory_edit : status_inventory_edit,
            })
            .done(function( data ) {
                // alert(data);
                $("#myModal_loading").modal('hide');
                show_key_activity_inventory();
            });

        }
        function delete_inventory_osw(id){
            if(confirm("ต้องการลบข้อมูลหรือไม่")){
                // alert("y");
                $("#myModal_loading").modal({backdrop: "static"});
                $.post( "getajax_daily_report_key_activity.php", { 
                    status: "delete_inventory_osw",
                    id : id
                })
                .done(function( data ) {
                    // alert(data);
                    $("#myModal_loading").modal('hide');
                    show_key_activity_inventory();
                });
            }else{
                // alert("n")
            }
        }
        function show_key_activity_5s_audit(){
            //alert("sdasd");
            $("#show_key_activity_5s_audit").html("loading...");
            var report_date = $("#report_date").val();
            var site = "OSW";
            $.post( "getajax_daily_report_key_activity.php", { 
                status: "show_key_activity_5s_audit",
                report_date : report_date,
                site : site
            })
            .done(function( data ) { 
                //alert(data);
                $("#show_key_activity_5s_audit").html(data);
                $("#date_audit").datepicker({
                    dateFormat:'dd/mm/yy'
                });

            });
        }
        function save_audit(){
            // var month_improve = $("#report_date").val();
            var date_audit = $("#date_audit").val();
            var team_audit = $("#team_audit").val();
            var score_audit = $("#score_audit").val();
            var comment_audit =$("input[name='comment_audit[]']").map(function(){return $(this).val();}).get();
            var site = "OSW";

            // alert(comment_audit);

            $("#myModal_loading").modal({backdrop: "static"});

            var txt = "";
            if(date_audit==""){
                txt += " - กรุณาใส่ Audit Date\n";
            }
            if(score_audit==""){
                txt += " - กรุณาใส่ Score\n";
            }
            
            if(txt !=""){
                alert('กรุณาเช็คข้อมูลเหล่านี้ \n'+txt);
                $("#myModal_loading").modal('hide');
            }else{

                $.post( "getajax_daily_report_key_activity.php", { 
                    status: "save_audit",
                    date_audit : date_audit,
                    team_audit : team_audit,
                    score_audit : score_audit,
                    comment_audit : comment_audit,
                    site : site,
                })
                .done(function( data ) {
                    // alert(data);
                    $("#myModal_loading").modal('hide');
                    show_key_activity_5s_audit();
                });
            }
        }
        function delete_audit(id){
            if(confirm("ต้องการลบข้อมูลหรือไม่")){
                // alert("y");
                $("#myModal_loading").modal({backdrop: "static"});
                $.post( "getajax_daily_report_key_activity.php", { 
                    status: "delete_audit",
                    id : id
                })
                .done(function( data ) {
                    // alert(data);
                    $("#myModal_loading").modal('hide');
                    show_key_activity_5s_audit();
                });
            }else{
                // alert("n")
            }
        }
        function show_key_activity_improvement(){
            //alert("sdasd");
            $("#show_key_activity_improvement").html("loading...");
            var report_date = $("#report_date").val();
            var site = "OSW";
            $.post( "getajax_daily_report_key_activity.php", { 
                status: "show_key_activity_improvement",
                report_date : report_date,
                site : site
            })
            .done(function( data ) { 
                //alert(data);
                $("#show_key_activity_improvement").html(data);

                $("#due_improve").datepicker({
                    dateFormat:'dd/mm/yy'
                });
            });
        }
        function gen_job_id_improve(){
            var filename = "images/cam.png";

            document.getElementById("cam_improve1").src = filename;
            document.getElementById("fn_improve1").value = filename;

            $("#pic_improve_action").show();
            var job_id_improve = $("#job_id_improve").val();
            if(job_id_improve!=""){
                if(confirm("มีเลข Job : "+job_id_improve+" ที่ยังไม่ปิด ต้องการ New Job ใหม่หรือไม่ ?")){
                    $.post( "getajax_daily_report_key_activity.php", { 
                        status: "gen_job_id_improve"
                    })
                    .done(function( data ) {
                        //alert(data);
                        $("#job_id_improve").val(data);
                    });
                }
            }else{
                $.post( "getajax_daily_report_key_activity.php", { 
                    status: "gen_job_id_improve"
                })
                .done(function( data ) {
                    //alert(data);
                    $("#job_id_improve").val(data);
                });
            }
        }
        function showmodal_improve(id) {
            var img = $("#fn_improve" + id).val();
            $("#myModal2").modal({
                backdrop: "static"
            });
            $("#img1").html('<img src=' + img + ' width=550>');
        }
        function save_improve(){
            var month_improve = $("#report_date").val();
            var job_id_improve = $("#job_id_improve").val();
            var topic_improve = $("#topic_improve").val();
            var status_improve = $("#status_improve").val();
            var pic_improve = $("#pic_improve").val();
            var due_improve = $("#due_improve").val();
            var site = "OSW";
            
            $("#myModal_loading").modal({backdrop: "static"});

            var txt = "";
            if(topic_improve==""){
                txt += " - กรุณาใส่ Topic\n";
            }
            
            if(txt !=""){
                alert('กรุณาเช็คข้อมูลเหล่านี้ \n'+txt);
                $("#myModal_loading").modal('hide');
            }else{
                $.post( "getajax_daily_report_key_activity.php", { 
                    status: "save_improve",
                    month_improve : month_improve,
                    job_id_improve : job_id_improve,
                    topic_improve : topic_improve,
                    status_improve : status_improve,
                    pic_improve : pic_improve,
                    due_improve : due_improve,
                    site : site,
                })
                .done(function( data ) {
                    // alert(data);
                    $("#myModal_loading").modal('hide');
                    show_key_activity_improvement();
                });
            }
        }
        function update_improve(id){
            var status_improve_edit = $("#status_improve_edit"+id).val();
            $("#myModal_loading").modal({backdrop: "static"});
            $.post( "getajax_daily_report_key_activity.php", { 
                status: "update_improve",
                id : id,
                status_improve_edit : status_improve_edit,
            })
            .done(function( data ) {
                // alert(data);
                $("#myModal_loading").modal('hide');
                show_key_activity_improve();
            });

        }
        function delete_improve(id){
            if(confirm("ต้องการลบข้อมูลหรือไม่")){
                // alert("y");
                $("#myModal_loading").modal({backdrop: "static"});
                $.post( "getajax_daily_report_key_activity.php", { 
                    status: "delete_improve",
                    id : id
                })
                .done(function( data ) {
                    // alert(data);
                    $("#myModal_loading").modal('hide');
                    show_key_activity_improvement();
                });
            }else{
                // alert("n")
            }
        }
        function add_comment(){
            
            $("#show_form_comment").append("<br><input type='text' class='form-control' id='comment_audit[]' name='comment_audit[]' autocomplete='off'  >");
        }

        function show_morning_meeting(){
            $("#show_morning_meeting").html("loading...");

            var report_date = $("#report_date").val();
            var site = "OSW";
            $.post( "getajax_daily_morning_meeting.php", { 
                status: "show_morning_meeting",
                report_date : report_date,
                site : site
            })
            .done(function( data ) { 
                //alert(data);
                $("#show_morning_meeting").html(data);

                
            });
        }
        function save_morning_meeting(){
            var report_date = $("#report_date").val();
            var type_meeting = $("#type_meeting").val();
            var detail_meeting = $("#detail_meeting").val();
            var status_meeting = $("#status_meeting").val();
            var site = "OSW";

            $("#myModal_loading").modal({backdrop: "static"});

            var txt = "";
            if(type_meeting==""){
                txt += " - กรุณาเลือก Type\n";
            }
            if(detail_meeting==""){
                txt += " - กรุณาใส่ Detail\n";
            }
            if(status_meeting==""){
                txt += " - กรุณาใส่ Status\n";
            }
            
            if(txt !=""){
                alert('กรุณาเช็คข้อมูลเหล่านี้ \n'+txt);
                $("#myModal_loading").modal('hide');
            }else{
                $.post( "getajax_daily_morning_meeting.php", { 
                    status: "save_morning_meeting",
                    report_date : report_date,
                    type_meeting : type_meeting,
                    detail_meeting : detail_meeting,
                    status_meeting : status_meeting,
                    site : site
                })
                .done(function( data ) { 
                    // alert(data);
                    show_morning_meeting();
                    $("#myModal_loading").modal('hide');

                });
            }

        }
        function update_morning_meeting(id){
            var status_meeting_edit = $("#status_meeting_edit"+id).val();
            $("#myModal_loading").modal({backdrop: "static"});
            $.post( "getajax_daily_morning_meeting.php", { 
                status: "update_morning_meeting",
                id : id,
                status_meeting_edit : status_meeting_edit,
            })
            .done(function( data ) {
                // alert(data);
                $("#myModal_loading").modal('hide');
                show_morning_meeting();
            });
        }
        function delete_morning_meeting(id){
            if(confirm("ต้องการลบข้อมูลหรือไม่")){
                // alert("y");
                $("#myModal_loading").modal({backdrop: "static"});
                $.post( "getajax_daily_morning_meeting.php", { 
                    status: "delete_morning_meeting",
                    id : id
                })
                .done(function( data ) {
                    // alert(data);
                    $("#myModal_loading").modal('hide');
                    show_morning_meeting();
                });
            }else{
                // alert("n")
            }
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
        
    <div class="modal fade" id="myModal_show_detail" role="dialog">
        <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="show_detail_head">Header</h4>
                </div>
                <div class="modal-body" id="show_detail_body">
                    BODY
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>
    <!-- Modal -->

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
                    if ($status == '') {
                        ?>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <h4>Daily Report OSW</h4>
                                    </div>
                                    
                                    <div class="panel-body">
                                        <div class='row'>
                                            <div class="col-sm-12">
                                                <div class="form-inline">
                                                    <div class="form-group">
                                                        <label  for="report_date">Date</label>
                                                        <input type="text" class="form-control" id="report_date" name="report_date" autocomplete="off" value="<?=$date?>" onchange="select_date_report_osw();">
                                                    </div>
                                                    <div class="form-group">
                                                        <label  for="shift">Shift</label>
                                                        <select name="shift" id="shift" class='form-control' onchange="select_date_report_osw();">
                                                            <option value="Day" <?php if($shift=="Day"){ echo "selected";} ?> >Day</option>
                                                            <option value="Night" <?php if($shift=="Night"){ echo "selected";} ?> >Night</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class='row'>
                                            <div class='col-sm-12'>
                                                <ul class="nav nav-tabs" style='margin-bottom: 20px;'>
                                                    <li class="active"><a data-toggle="tab" href="#show_form_daily_report">Main Daily</a></li>
                                                    <li><a data-toggle="tab" href="#key_activity">Key activity</a></li>
                                                    <li><a data-toggle="tab" href="#show_morning_meeting">Morning meeting</a></li>
                                                </ul>

                                                <div class="tab-content">
                                                    <div id="show_form_daily_report" class="tab-pane fade in active" >
                                                        
                                                
                                                    </div>
                                                    <div id="key_activity" class="tab-pane fade">
                                                        <div class='' id="show_key_activity_proplem">
                                                        </div>
                                                        <div class='' id="show_key_activity_inventory">
                                                        </div>
                                                        <div class='' id="show_key_activity_5s_audit">
                                                        </div>
                                                        <div class='' id="show_key_activity_improvement">
                                                        </div>
                                                    </div>
                                                    <div id="show_morning_meeting" class="tab-pane fade">
                                                        
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