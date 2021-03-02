<?php

session_start();
include("connect.php");
include("library.php");
$status = $_REQUEST["status"];
$date_today = date("d/m/Y");

$admin_userid = $_SESSION['admin_userid'];
//echo date("w", strtotime('2019-09-22'));

$sql = "SELECT * FROM tbemployee where departmentid is null";
$res = mssql_query($sql);
while($row = mssql_fetch_array($res)){
    $id = $row["id"];
    $positionid = $row["positionid"];

    $sql_position = "SELECT departmentid FROM  tbposition WHERE positionid='$positionid'";
    $res_position =  mssql_query($sql_position);
    $row_position = mssql_fetch_array($res_position);
    $departmentid = $row_position["departmentid"];

    $update = "UPDATE tbemployee set departmentid='$departmentid' WHERE id='$id'";
    mssql_query($update);
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Hrs : OT</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="I-Wis">
    <meta name="author" content="The Red Team">

    <link rel="stylesheet" href="assets/css/styles.css?=140">

    <link href='assets/demo/variations/default.css' rel='stylesheet' type='text/css' media='all' id='styleswitcher'>
    <link href='assets/demo/variations/default.css' rel='stylesheet' type='text/css' media='all' id='headerswitcher'>


    <link rel='stylesheet' type='text/css' href='assets/plugins/codeprettifier/prettify.css' />
    <link rel='stylesheet' type='text/css' href='assets/plugins/form-multiselect/css/multi-select.css' />
    <link rel='stylesheet' type='text/css' href='assets/plugins/form-toggle/toggles.css' />
    <link rel="stylesheet" type="text/css" href="assets/css/multi-select.css">

    <link rel='stylesheet' type='text/css' href='assets/css/bootstrap.min.css' />
    <link rel='stylesheet' type='text/css' href='assets/css/buttons.dataTables.min.css' />
    <link rel='stylesheet' type='text/css' href='assets/css/dataTables.bootstrap.min.css' />

    <script type="text/javascript" src="assets/js/jquery-1.10.2.min.js"></script>

    <link rel='stylesheet' type='text/css' href='assets/plugins/jqueryui-timepicker/jquery.ui.timepicker.css' />
    <link rel='stylesheet' type='text/css' href='assets/plugins/form-daterangepicker/daterangepicker-bs3.css' />
    <link rel='stylesheet' type='text/css' href='assets/js/jqueryui.css' />
    
    <script src="//cdn.ckeditor.com/4.12.1/basic/ckeditor.js"></script>
    <style>
         
        .form-control[readonly]{
            background-color: #fff;
            cursor: pointer;
        }
    </style>
    <script>
        $(document).ready(function() {
            <?
            if ($status==""){
                ?>
                var month_start = $("#month").val();
                if(month_start==""){
                    show_ot_paycode();
                }else{

                    show_ot_month();
                }
            <?
            }else if($status=="create_ot"){
                ?>
                $("#date_ot").datepicker({
                    format: 'dd/mm/yyyy'
                });
                show_data_ot();
                $('.start_time,#all_start_time').timepicker({
                    showPeriodLabels: false
                });
                $('.end_time,#all_end_time').timepicker({
                    showPeriodLabels: false
                });
                <?
            }else if($status=="confirm_ot" || $status=="approve_ot"){
                ?>
                CKEDITOR.replace( 'remark' );

                $('.start_time,#all_start_time').timepicker({
                    showPeriodLabels: false
                });
                $('.end_time,#all_end_time').timepicker({
                    showPeriodLabels: false
                });
                
                <?
            }
            
            ?>
            
        });

        function submit_loading() {
            $("#myModal_loading").modal({
                backdrop: "static"
            });
        }
        function show_data_ot(){
            var date_ot = $("#date_ot").val();
            var shift = $("#shift").val();
            var departmentid = $("#departmentid").val();
            $("#show_data_ot").html("loading...");
            $.post("getajax_create_ot.php",{
                status:"show_data_ot",
                date_ot:date_ot,
                shift:shift,
                departmentid:departmentid
            }).done(function(data){	
               // alert(data);
                $("#show_data_ot").html(data);
                CKEDITOR.replace( 'remark' );
                $('.start_time,#all_start_time').timepicker({
                    showPeriodLabels: false
                });
                $('.end_time,#all_end_time').timepicker({
                    showPeriodLabels: false
                });
            })
        }
        function all_start_time(){
            var all_start_time = $("#all_start_time").val();
            $(".start_time").val(all_start_time);
            
        }
        function all_end_time(){
            var all_end_time = $("#all_end_time").val();
            $(".end_time").val(all_end_time);
            
        }
        function all_status_ot(){
            var all_status_ot = $("#all_status_ot").val();
            $(".status_ot").val(all_status_ot);
            
        }
        function save_request_ot(){
            var date_ot = $("#date_ot").val();
            var shift = $("#shift").val();
            var departmentid = $("#departmentid").val();
            var empno = $("input[name='empno[]']").map(function(){return $(this).val();}).get();
            var fl_status = $("select[name='fl_status[]']").map(function(){return $(this).val();}).get();
            //var status_ot = $("select[name='status_ot[]']").map(function(){return $(this).val();}).get();
            var start_time = $("input[name='start_time[]']").map(function(){return $(this).val();}).get();
            var end_time = $("input[name='end_time[]']").map(function(){return $(this).val();}).get();
            var remark_person = $("input[name='remark_person[]']").map(function(){return $(this).val();}).get();
            var remark = CKEDITOR.instances.remark.getData();
            var qty_male = $("#qty_male").val();
            var qty_female = $("#qty_female").val();

            var status_ot_check = 0;
            var status_ot= [];
            $('select[name^="status_ot"]').each(function(){
                status_ot.push($(this).val());
                if($(this).val()==""){
                    status_ot_check++;
                }
                //alert($(this).val());
            });

            if(status_ot_check > 0 ){
                alert("กรุณาเลือกสถานะให้ครบทุกคน");
            }else{
                $("#myModal_loading").modal({
                    backdrop: "static"
                });
                // alert("OK");
                $.post("getajax_create_ot.php",{
                    status:"save_request_ot",
                    date_ot:date_ot,
                    shift:shift,
                    departmentid:departmentid,
                    empno:empno,
                    fl_status:fl_status,
                    status_ot:status_ot,
                    start_time:start_time,
                    end_time:end_time,
                    remark_person:remark_person,
                    remark:remark,
                    qty_male:qty_male,
                    qty_female:qty_female
                }).done(function(data){	
                   // alert(data)
                    if(data=="Approve_before"){
                        alert("กรุณา Confirm วันก่อนหน้านี้ ก่อนที่จะ Request ใหม่");
                        $("#myModal_loading").modal('hide');
                    }else{
                        if(data!=" "){
                            line_noti_ot(data);
                        }else{
                            alert("บันทึกสำเร็จ");
                            window.location.href="create_ot.php";
                            $("#myModal_loading").modal('hide');
                        }
                    }
                        
                })
            }
            
        }
        function line_noti_ot(job_ot_id){
            $.post("getajax_linenotify.php",{
                status:"line_noti_ot",
                job_ot_id:job_ot_id
            }).done(function(data){
                //alert(data);
                alert("บันทึกสำเร็จ");
                window.location.href="create_ot.php";
                $("#myModal_loading").modal('hide');   
            })
        }
        function select_ot_status(empno){
            var status_ot = $("#status_ot"+empno).val();
            if(status_ot=="X" || status_ot=="-" || status_ot=="#" ){

                $("#start_time"+empno).val('');
                $("#end_time"+empno).val('');
            }
        }
        function clear_time_ot(empno){

            $("#start_time"+empno).val('');
            $("#end_time"+empno).val('');
            
        }
        function show_ot_paycode(){
            var paycode = $("#paycode").val();
            $("#month").val('');
            $("#show_ot_list").html('Loading...');

            $.post("getajax_create_ot.php",{
                status:"show_ot_list",
                paycode:paycode
            }).done(function(data){	
                $("#show_ot_list").html(data);
            })
            // alert(paycode);
        }
        function show_ot_month(){
            var month = $("#month").val();
            $("#paycode").val('');
            $("#show_ot_list").html('Loading...');

            // alert(month);
            $.post("getajax_create_ot.php",{
                status:"show_ot_list",
                month:month
            }).done(function(data){	
                $("#show_ot_list").html(data);
            })
        }
        function save_approve_ot(){
            var date_ot = $("#date_ot").val();
            var shift = $("#shift").val();
            var departmentid = $("#departmentid").val();
            var empno = $("input[name='empno[]']").map(function(){return $(this).val();}).get();
            var fl_status = $("select[name='fl_status[]']").map(function(){return $(this).val();}).get();
            //var status_ot = $("select[name='status_ot[]']").map(function(){return $(this).val();}).get();
            var start_time = $("input[name='start_time[]']").map(function(){return $(this).val();}).get();
            var end_time = $("input[name='end_time[]']").map(function(){return $(this).val();}).get();
            var remark_person = $("input[name='remark_person[]']").map(function(){return $(this).val();}).get();
            var remark = CKEDITOR.instances.remark.getData();
            var qty_male = $("#qty_male").val();
            var qty_female = $("#qty_female").val();

            var status_ot_check = 0;
            var status_ot= [];
            $('select[name^="status_ot"]').each(function(){
                status_ot.push($(this).val());
                if($(this).val()==""){
                    status_ot_check++;
                }
                //alert($(this).val());
            });
            //alert(fl_status);
            if(status_ot_check > 0 ){
                alert("กรุณาเลือกสถานะให้ครบทุกคน");
            }else{
                $("#myModal_loading").modal({
                    backdrop: "static"
                });
                // alert("OK");
                $.post("getajax_create_ot.php",{
                    status:"save_approve_ot",
                    date_ot:date_ot,
                    shift:shift,
                    departmentid:departmentid,
                    empno:empno,
                    fl_status:fl_status,
                    status_ot:status_ot,
                    start_time:start_time,
                    end_time:end_time,
                    remark_person:remark_person,
                    remark:remark,
                    qty_male:qty_male,
                    qty_female:qty_female
                }).done(function(data){	
                    // alert(data);
                    if(data=="Level_not_reached"){
                        alert("ระดับ Supervisor ขึ้นไปเท่านั้นจึงจะ Approve ได้");
                        $("#myModal_loading").modal('hide');
                    }else{
                        alert("บันทึกสำเร็จ");
                        window.location.href="create_ot.php";
                        $("#myModal_loading").modal('hide');
                    }
                        
                })
            }
            
        }
        function save_confirm_ot(){
            var date_ot = $("#date_ot").val();
            var shift = $("#shift").val();
            var departmentid = $("#departmentid").val();
            var empno = $("input[name='empno[]']").map(function(){return $(this).val();}).get();
            var fl_status = $("select[name='fl_status[]']").map(function(){return $(this).val();}).get();
            //var status_ot = $("select[name='status_ot[]']").map(function(){return $(this).val();}).get();
            var start_time = $("input[name='start_time[]']").map(function(){return $(this).val();}).get();
            var end_time = $("input[name='end_time[]']").map(function(){return $(this).val();}).get();
            var remark_person = $("input[name='remark_person[]']").map(function(){return $(this).val();}).get();
            var remark = CKEDITOR.instances.remark.getData();
            var qty_male = $("#qty_male").val();
            var qty_female = $("#qty_female").val();

            var status_ot_check = 0;
            var status_ot= [];
            $('select[name^="status_ot"]').each(function(){
                status_ot.push($(this).val());
                if($(this).val()==""){
                    status_ot_check++;
                }
                //alert($(this).val());
            });
            //alert(fl_status);
            if(status_ot_check > 0 ){
                alert("กรุณาเลือกสถานะให้ครบทุกคน");
            }else{
                $("#myModal_loading").modal({
                    backdrop: "static"
                });
                // alert("OK");
                $.post("getajax_create_ot_ver2.php",{
                    status:"save_confirm_ot",
                    date_ot:date_ot,
                    shift:shift,
                    departmentid:departmentid,
                    empno:empno,
                    fl_status:fl_status,
                    status_ot:status_ot,
                    start_time:start_time,
                    end_time:end_time,
                    remark_person:remark_person,
                    remark:remark,
                    qty_male:qty_male,
                    qty_female:qty_female
                }).done(function(data){	
                    //  alert(data);
                     $(".table-responsive").html(data);
                     $("#myModal_loading").modal('hide');
                    // if(data=="Level_not_reached"){
                    //     alert("ระดับ Supervisor ขึ้นไปเท่านั้นจึงจะ Approve ได้");
                    //     $("#myModal_loading").modal('hide');
                    // }else if(data=="Not_Today"){
                    //     alert("ห้าม Confirm ในวัน, กรุณา Confirm วันถัดไป");
                    //     $("#myModal_loading").modal('hide');
                    // }else{
                    //     alert("บันทึกสำเร็จ");
                    //    window.location.href="create_ot.php";
                    //     $("#myModal_loading").modal('hide');
                    // }
                        
                })
            }
            
        }
    </script>
</head>

<body class=" ">
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

                    <?php if ($status == "") {  
                        $yyear = date('Y');
                        $year_mounth = date('Y-m');
                        $paycode = $_GET["paycode"];

                        $sql_emp = "SELECT departmentid FROM tbemployee WHERE empno='$admin_userid'";
                        $res_emp = mssql_query($sql_emp);
                        $row_emp = mssql_fetch_array($res_emp);
                        $departmentid = $row_emp["departmentid"];
                        if($departmentid=="D006" || $departmentid=="D004"){
                            $condition_departmentid = "departmentid='D006' OR departmentid='D004'";
                        }else{
                            $condition_departmentid = $departmentid;
                        }
                        ?>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">OT LIST</div>
                                    <div class="panel-body">
                                        <div class='row'>

                                            <div class="form-horizontal">
                                                <div class="form-group">
                                                    <label class="control-label col-sm-2" for="paycode">PayCode :</label>
                                                    <div class="col-sm-3">
                                                        <select id="paycode" class="form-control"  name="paycode"   >
                                                            <option value="">-------</option>
                                                            <?
                
                                                            $select_paycode="SELECT paycode from tbpaycode WHERE paycodeyear='$yyear' order by startdate asc ";
                                                            $re_paycode=mssql_query($select_paycode);
                                                            while($row_paycode=mssql_fetch_array($re_paycode)){
                                                                ?>
                                                                <option value="<?=$row_paycode['paycode']?>" <?
                                                                if($paycode==$row_paycode['paycode']){
                                                                    ?> selected<?
                                                                    }
                                                                ?>><?=$row_paycode['paycode']?></option>
                                                                <?
                                                                }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class='col-sm-2'>
                                                        <button type="submit" class="btn btn-info" onclick="show_ot_paycode()">ค้นหา</button>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-sm-2" for="month">Month :</label>
                                                    <div class="col-sm-3">
                                                        <input type="month" name="month" id="month" class="form-control" value="<?=$year_mounth?>">
                                                    </div>
                                                    <div class='col-sm-2'>
                                                        <button type="submit" class="btn btn-info" onclick="show_ot_month()">ค้นหา</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class='pull-right'>
                                                <a href="create_ot.php?status=create_ot" class='btn btn-warning'>Request OT</a>
                                            </div>
                                        </div>
                                        <div class='row'>
                                            <div class='col-sm-12'>
                                                <div  id="show_ot_list">
                                                        
                                                </div>

                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>



                        <?php 

                    }else if($status=="create_ot"){
                        $date_ot  = $_GET["date_ot"]=="" ? $date_today : $_GET["date_ot"];
                        $shift  = $_GET["shift"]=="" ? "Day" : $_GET["shift"];


                        if($_GET["departmentid"]==""){
                            $sql_emp = "SELECT departmentid FROM tbemployee WHERE empno='$admin_userid'";
                            $res_emp = mssql_query($sql_emp);
                            $row_emp = mssql_fetch_array($res_emp);
                            $departmentid = $row_emp["departmentid"];
                        }else{
                            $departmentid = $_GET["departmentid"];
                        }
                        
                        $sql_department = "SELECT department FROM tbdepartment WHERE departmentid='$departmentid'";
                        $res_department = mssql_query($sql_department);
                        $row_department = mssql_fetch_array($res_department);
                        $department = $row_department["department"];
                        if($departmentid=="D006" || $departmentid=="D004"){
                            $department = "Planning & Admin";
                        }
                        ?>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel panel-warning">
                                    <div class="panel-heading">Request OT</div>
                                    <div class="panel-body">
                                        <div class="form-horizontal">
                                            <div class="form-group">
                                                <label class="control-label col-sm-2" for="date_ot">วันที่ :</label>
                                                <div class="col-sm-3">
                                                    <input type="text" name="date_ot" id="date_ot" class="form-control" value="<?= $date_ot ?>" onchange="show_data_ot()">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-sm-2" for="shift">Shift :</label>
                                                <div class="col-sm-2">
                                                    <select name="shift" id="shift" class="form-control" onchange="show_data_ot()">
                                                        <option value="Day" <?php if($shift=="Day"){ echo "selected";} ?> >Day</option>
                                                        <option value="Night" <?php if($shift=="Night"){ echo "selected";} ?>>Night</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-sm-2" for="departmentid">Department :</label>
                                                <div class="col-sm-2">
                                                    <select name="departmentid" id="departmentid" class="form-control" onchange="show_data_ot()">
                                                        <option value="<?=$departmentid?>"><?=$department?></option>
                                                        
                                                    </select>
                                                </div>
                                            </div>
                                            
                                        </div>
                                        <hr>
                                        <div id='show_data_ot'>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?
                    }else if($status=="approve_ot"){
                        $date_ot = $_GET["date_ot"];
                        $date_ot_uk = date_format_uk_into_database($date_ot);
                        $shift = $_GET["shift"];
                        $departmentid = $_GET["departmentid"];
                        ?>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel panel-info">
                                    <div class="panel-heading"> Approve OT </div>
                                    <div class="panel-body">
                                        <?
                                        $number_of_day = date("w", strtotime($date_ot_uk));//6 = Saturday,0 = Sunday

                                            
                                        $sql_department = "SELECT department FROM tbdepartment WHERE departmentid='$departmentid'";
                                        $res_department = mssql_query($sql_department);
                                        $row_department = mssql_fetch_array($res_department);
                                        $department = $row_department["department"];
                                        if($departmentid=="D006" || $departmentid=="D004"){
                                            $codition_department = "(tbposition.departmentid='D006' or tbposition.departmentid='D004')";
                                            $codition_department_request = "(tbot_request.departmentid='D006' or tbot_request.departmentid='D004')";
                                            $department = "Planning & Admin";
                                        }else{
                                            $codition_department = "tbposition.departmentid='$departmentid' ";
                                            $codition_department_request = "tbot_request.departmentid='$departmentid' ";
                                            $department = $department;
                                        }
                                        ?>
                                        <p>วันที่ : <?=$date_ot?></p><input type="hidden" id="date_ot" name="date_ot" value="<?=$date_ot?>">
                                        <p>Shift : <?=$shift?></p><input type="hidden" id="shift" name="shift" value="<?=$shift?>">
                                        <p>Department  : <?=$department?></p><input type="hidden" id="departmentid" name="departmentid" value="<?=$departmentid?>">
                                        <div class="table-responsive">
                                            <table class='table table-striped table-bordered'>
                                                <tr>
                                                    <td colspan="5" align="right"></td>
                                                    <td width='100px'>
                                                        <select name="all_status_ot" id="all_status_ot" class='form-control' onchange="all_status_ot()">
                                                            <option value="">สถานะ OT</option>
                                                            <option value="O">O</option>
                                                            <option value="X">X</option>
                                                            <option value="-">-</option>
                                                            <option value="#">#</option>
                                                        </select>
                                                    </td>
                                                    <td colspan="2" align="right"></td>
                                                    <td width='180px'><input type="text" class='form-control' id="all_start_time" onchange="all_start_time()" readonly></td>
                                                    <td width='180px'><input type="text" class='form-control' id="all_end_time" onchange="all_end_time()" readonly></td>
                                                </tr>
                                                <tr>
                                                    <th>ลำดับ</th>
                                                    <th>ชื่อ</th>
                                                    <th>นามสกุล</th>
                                                    <th>ตำแหน่ง</th>
                                                    <th>FL</th>
                                                    <th>สถานะ OT</th>
                                                    <th>หมายเหตุ</th>
                                                    <th>เริ่ม - สิ้นสุด (Request)</th>
                                                    <th>เริ่ม (Edit)</th>
                                                    <th>สิ้นสุด (Edit)</th>
                                                    <th>กดเพื่อลบเวลาของคน ๆ นั้น</th>
                                                </tr>
                                                <?php
                                            
                                                    $sql = "SELECT 
                                                        tbemployee.empno
                                                    , tbemployee.firstname
                                                    , tbemployee.lastname
                                                    , tbemployee.firstname_en
                                                    , tbemployee.lastname_en
                                                    , tbemployee.nickname
                                                    , tbemployee.site
                                                    , tbemployee.delstatus
                                                    , tbemployee.emp_level
                                                    , tbemployee.departmentid
                                                    , tbemployee.positionid
                                                    , tbposition.positionname
                                                    , tbot_request.fl_status
                                                    , tbot_request.status_ot
                                                    , tbot_request.start_time_request
                                                    , tbot_request.end_time_request
                                                    , tbot_request.start_time_approve
                                                    , tbot_request.end_time_approve
                                                    , tbot_request.remark_person
                                                    , tbot_request.qty_male
                                                    , tbot_request.qty_female
                                                    , tbot_request.remark
                                                    FROM  tbot_request INNER JOIN  tbemployee
                                                    on tbot_request.empno = tbemployee.empno
                                                    INNER JOIN tbposition 
                                                    ON tbemployee.positionid = tbposition.positionid 
                                                    where $codition_department
                                                    AND date_ot='$date_ot_uk'  AND shift='$shift'
                                                    ORDER BY tbposition.sort_id,tbposition.positionid ,tbemployee.empno";
                                                

                                                $res = mssql_query($sql);
                                                $no=0;
                                                while($row = mssql_fetch_array($res)){
                                                    $no++;
                                                    $empno = ($row["empno"]);
                                                    $firstname = lang_thai_from_database($row["firstname"]);
                                                    $lastname = lang_thai_from_database($row["lastname"]);
                                                    $positionname = lang_thai_from_database($row["positionname"]);
                                                    $fl_status = ($row["fl_status"]);
                                                    $status_ot = ($row["status_ot"]);
                                                    $start_time_request = ($row["start_time_request"]);
                                                    $end_time_request = ($row["end_time_request"]);
                                                    $start_time_approve = ($row["start_time_approve"]);
                                                    $end_time_approve = ($row["end_time_approve"]);
                                                    $remark_person = lang_thai_from_database($row["remark_person"]);
                                                    
                                                    
                                                   
                                                    // $sql_att_in = "SELECT * FROM tbatt WHERE empno='$empno' AND att_real_date='$date_ot_uk' AND shift='$shift' AND att_status='in'";
                                                    // $res_att_in = mssql_query($sql_att_in);
                                                    // $num_att_in = mssql_num_rows($res_att_in);
                                                    // if($num_att_in>0){

                                                    //     $row_att_in = mssql_fetch_array($res_att_in);
                                                    //     $attDateTime_in = date("H:i", strtotime($row_att_in["attDateTime"]));
                                                    // }else{
                                                    //     $attDateTime_in = "";
                                                    // }
                                                    
                                                    // $sql_att_out = "SELECT * FROM tbatt WHERE empno='$empno' AND att_real_date='$date_ot_uk' AND shift='$shift' AND att_status='out'";
                                                    // $res_att_out = mssql_query($sql_att_out);
                                                    // $num_att_out = mssql_num_rows($res_att_out);
                                                    // if($num_att_out>0){

                                                    //     $row_att_out = mssql_fetch_array($res_att_out);
                                                    //     $attDateTime_out = date("H:i", strtotime($row_att_out["attDateTime"]));
                                                    // }else{
                                                    //     $attDateTime_out = "";
                                                    // }


                                                    
                                                    
                                                    ?>
                                                    <tr>
                                                        <td><?=$no?></td>
                                                        <td><?=$firstname?></td>
                                                        <td><?=$lastname?></td>
                                                        <td><?=$positionname?></td>
                                                        <td>
                                                            <select name="fl_status[]" id="fl_status<?=$empno?>" class='form-control' >
                                                                <option value="no" <?if($fl_status=="no"){echo "selected";}?> >No</option>
                                                                <option value="yes" <?if($fl_status=="yes"){echo "selected";}?> >Yes</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input type="hidden"  name="empno[]" id="empno<?=$empno?>" value="<?=$empno?>">
                                                            <select name="status_ot[]" id="status_ot<?=$empno?>" class='form-control status_ot' onchange="select_ot_status('<?=$empno?>')"  >
                                                                <option value="">สถานะ OT</option>
                                                                <option value="O" <?if($status_ot=="O"){echo "selected";}?> >O</option>
                                                                <option value="X" <?if($status_ot=="X"){echo "selected";}?> >X</option>
                                                                <option value="-" <?if($status_ot=="-" || $disabled_lock_ot=="disabled"){echo "selected";}?> >-</option>
                                                                <option value="#" <?if($status_ot=="#"){echo "selected";}?> >#</option>
                                                            </select>
                                                        </td>
                                                        <td><input type="text" name="remark_person[]" id="remark_person<?=$empno?>" class='form-control' value="<?=$remark_person?>"></td>
                                                        <td><?=$start_time_request?> - <?=$end_time_request?></td>
                                                        
                                                        <td><input type="text" name="start_time[]" id="start_time<?=$empno?>" class='form-control start_time' value="<?=$start_time_approve?>" readonly ></td>
                                                        <td><input type="text" name="end_time[]" id="end_time<?=$empno?>" class='form-control end_time' value="<?=$end_time_approve?>" readonly ></td>
                                                        <td><button class="btn btn-warning" onclick="clear_time_ot('<?=$empno?>')">ลบเวลา</button></td>
                                                    </tr>
                                                    <?
                                                    
                                                }
                                                ?>
                                            </table>
                                        </div>
                                        <?
                                        $sql_ot = "SELECT * FROM tbot_request WHERE date_ot='$date_ot_uk' AND $codition_department_request AND shift='$shift' ";
                                        $res_ot = mssql_query($sql_ot);
                                        $num_ot = mssql_num_rows($res_ot);
                                        $row_ot = mssql_fetch_array($res_ot);
                                        $remark = lang_thai_from_database($row_ot["remark"]);
                                        $qty_male = ($row_ot["qty_male"]);
                                        $qty_female = ($row_ot["qty_female"]);

                                        ?><b>รายละเอียดที่ขอทำงานล่วงเวลา (OT) :</b><textarea name="remark" id="remark" cols="30" rows="10" class="form-control"><?=$remark?></textarea>
                                        <br>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-horizontal" >
                                                    <div class="form-group">
                                                        <label class="control-label col-sm-3" for="qty_male">ชาย</label>
                                                        <div class="col-sm-2">
                                                            <input type="number" id="qty_male" class="form-control" value='<?=$qty_male?>'>
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <p class='form-control-static'>คน</p>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-sm-3" for="qty_female">หญิง</label>
                                                        <div class="col-sm-2">
                                                            <input type="number" id="qty_female" class="form-control" value='<?=$qty_female?>'>
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <p class='form-control-static'>คน</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class='col-sm-6 text-center' >
                                                <table>
                                                    <tr>
                                                        <td colspan="2" align="center">สถานะคนที่ทำงานล่วงเวลา OT</td>    
                                                    </tr>
                                                    <tr>
                                                        <td align="center">O</td>
                                                        <td align="center">ทำโอที</td>
                                                    </tr>
                                                    <tr>
                                                        <td align="center">X</td>
                                                        <td align="center">ไม่ทำโอที</td>
                                                    </tr>
                                                    <tr>
                                                        <td align="center">-</td>
                                                        <td align="center">ไม่มาทำงาน</td>
                                                    </tr>
                                                    <tr>
                                                        <td align="center">#</td>
                                                        <td align="center">งดโอที</td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                        <br>
                                        <center>
                                            <button class='btn btn-info' onclick='save_approve_ot()'>Approve</button>
                                        </center>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?
                    }else if($status=="confirm_ot"){
                        $date_ot = $_GET["date_ot"];
                        $date_ot_uk = date_format_uk_into_database($date_ot);
                        $shift = $_GET["shift"];
                        $departmentid = $_GET["departmentid"];
                        ?>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel panel-success">
                                    <div class="panel-heading"> Confirm OT </div>
                                    <div class="panel-body">
                                        <?
                                        $number_of_day = date("w", strtotime($date_ot_uk));//6 = Saturday,0 = Sunday

                                            
                                        $sql_department = "SELECT department FROM tbdepartment WHERE departmentid='$departmentid'";
                                        $res_department = mssql_query($sql_department);
                                        $row_department = mssql_fetch_array($res_department);
                                        $department = $row_department["department"];
                                        if($departmentid=="D006" || $departmentid=="D004"){
                                            $codition_department = "(tbposition.departmentid='D006' or tbposition.departmentid='D004')";
                                            $codition_department_request = "(tbot_request.departmentid='D006' or tbot_request.departmentid='D004')";
                                            $department = "Planning & Admin";
                                        }else{
                                            $codition_department = "tbposition.departmentid='$departmentid' ";
                                            $codition_department_request = "tbot_request.departmentid='$departmentid' ";
                                            $department = $department;
                                        }
                                        ?>
                                        <p>วันที่ : <?=$date_ot?></p><input type="hidden" id="date_ot" name="date_ot" value="<?=$date_ot?>">
                                        <p>Shift : <?=$shift?></p><input type="hidden" id="shift" name="shift" value="<?=$shift?>">
                                        <p>Department  : <?=$department?></p><input type="hidden" id="departmentid" name="departmentid" value="<?=$departmentid?>">
                                        <div class="table-responsive">
                                            <table class='table table-striped table-bordered'>
                                                <tr>
                                                    <td colspan="5" align="right"></td>
                                                    <td width='100px'>
                                                        <select name="all_status_ot" id="all_status_ot" class='form-control' onchange="all_status_ot()">
                                                            <option value="">สถานะ OT</option>
                                                            <option value="O">O</option>
                                                            <option value="X">X</option>
                                                            <option value="-">-</option>
                                                            <option value="#">#</option>
                                                        </select>
                                                    </td>
                                                    <td colspan="3" align="right"></td>
                                                    <td width='180px'><input type="text" class='form-control' id="all_start_time" onchange="all_start_time()" readonly></td>
                                                    <td width='180px'><input type="text" class='form-control' id="all_end_time" onchange="all_end_time()" readonly></td>
                                                </tr>
                                                <tr>
                                                    <th>ลำดับ</th>
                                                    <th>ชื่อ</th>
                                                    <th>นามสกุล</th>
                                                    <th>ตำแหน่ง</th>
                                                    <th>FL</th>
                                                    <th>สถานะ OT</th>
                                                    <th>หมายเหตุ</th>
                                                    <th>เริ่ม - สิ้นสุด (Approve)</th>
                                                    <th>เข้างาน - ออกงาน (Scan)</th>
                                                    <th>เริ่ม (Edit)</th>
                                                    <th>สิ้นสุด (Edit)</th>
                                                    <th>กดเพื่อลบเวลาของคน ๆ นั้น</th>
                                                </tr>
                                                <?php
                                            
                                                    $sql = "SELECT 
                                                        tbemployee.empno
                                                    , tbemployee.firstname
                                                    , tbemployee.lastname
                                                    , tbemployee.firstname_en
                                                    , tbemployee.lastname_en
                                                    , tbemployee.nickname
                                                    , tbemployee.site
                                                    , tbemployee.delstatus
                                                    , tbemployee.emp_level
                                                    , tbemployee.departmentid
                                                    , tbemployee.positionid
                                                    , tbposition.positionname
                                                    , tbot_request.fl_status
                                                    , tbot_request.status_ot
                                                    , tbot_request.start_time_request
                                                    , tbot_request.end_time_request
                                                    , tbot_request.start_time_approve
                                                    , tbot_request.end_time_approve
                                                    , tbot_request.remark_person
                                                    , tbot_request.qty_male
                                                    , tbot_request.qty_female
                                                    , tbot_request.remark
                                                    FROM  tbot_request INNER JOIN  tbemployee
                                                    on tbot_request.empno = tbemployee.empno
                                                    INNER JOIN tbposition 
                                                    ON tbemployee.positionid = tbposition.positionid 
                                                    where $codition_department
                                                    AND date_ot='$date_ot_uk'  AND shift='$shift'
                                                    ORDER BY tbposition.sort_id,tbposition.positionid ,tbemployee.empno";
                                                

                                                $res = mssql_query($sql);
                                                $no=0;
                                                while($row = mssql_fetch_array($res)){
                                                    $no++;
                                                    $empno = ($row["empno"]);
                                                    $firstname = lang_thai_from_database($row["firstname"]);
                                                    $lastname = lang_thai_from_database($row["lastname"]);
                                                    $positionname = lang_thai_from_database($row["positionname"]);
                                                    $fl_status = ($row["fl_status"]);
                                                    $status_ot = ($row["status_ot"]);
                                                    $start_time_request = ($row["start_time_request"]);
                                                    $end_time_request = ($row["end_time_request"]);
                                                    $start_time_approve = ($row["start_time_approve"]);
                                                    $end_time_approve = ($row["end_time_approve"]);
                                                    $remark_person = lang_thai_from_database($row["remark_person"]);
                                                    
                                                    
                                                   
                                                    $sql_att_in = "SELECT * FROM tbatt WHERE empno='$empno' AND att_real_date='$date_ot_uk' AND shift='$shift' AND att_status='in'";
                                                    $res_att_in = mssql_query($sql_att_in);
                                                    $num_att_in = mssql_num_rows($res_att_in);
                                                    if($num_att_in>0){

                                                        $row_att_in = mssql_fetch_array($res_att_in);
                                                        $attDateTime_in = date("H:i", strtotime($row_att_in["attDateTime"]));
                                                    }else{
                                                        $attDateTime_in = "";
                                                    }
                                                    
                                                    $sql_att_out = "SELECT * FROM tbatt WHERE empno='$empno' AND att_real_date='$date_ot_uk' AND shift='$shift' AND att_status='out'";
                                                    $res_att_out = mssql_query($sql_att_out);
                                                    $num_att_out = mssql_num_rows($res_att_out);
                                                    if($num_att_out>0){

                                                        $row_att_out = mssql_fetch_array($res_att_out);
                                                        $attDateTime_out = date("H:i", strtotime($row_att_out["attDateTime"]));
                                                    }else{
                                                        $attDateTime_out = "";
                                                    }


                                                    
                                                    
                                                    ?>
                                                    <tr>
                                                        <td><?=$no?></td>
                                                        <td><?=$firstname?></td>
                                                        <td><?=$lastname?></td>
                                                        <td><?=$positionname?></td>
                                                        <td>
                                                            <select name="fl_status[]" id="fl_status<?=$empno?>" class='form-control' >
                                                                <option value="no" <?if($fl_status=="no"){echo "selected";}?> >No</option>
                                                                <option value="yes" <?if($fl_status=="yes"){echo "selected";}?> >Yes</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input type="hidden"  name="empno[]" id="empno<?=$empno?>" value="<?=$empno?>">
                                                            <select name="status_ot[]" id="status_ot<?=$empno?>" class='form-control status_ot' onchange="select_ot_status('<?=$empno?>')"  >
                                                                <option value="">สถานะ OT</option>
                                                                <option value="O" <?if($status_ot=="O"){echo "selected";}?> >O</option>
                                                                <option value="X" <?if($status_ot=="X"){echo "selected";}?> >X</option>
                                                                <option value="-" <?if($status_ot=="-" || $disabled_lock_ot=="disabled"){echo "selected";}?> >-</option>
                                                                <option value="#" <?if($status_ot=="#"){echo "selected";}?> >#</option>
                                                            </select>
                                                        </td>
                                                        <td><input type="text" name="remark_person[]" id="remark_person<?=$empno?>" class='form-control' value="<?=$remark_person?>"></td>
                                                        <td><?=$start_time_request?> - <?=$end_time_request?></td>
                                                        <td><?=$attDateTime_in?> - <?=$attDateTime_out?>
                                                            <?
                                                            
                                                            ?>
                                                        </td>
                                                        <td><input type="text" name="start_time[]" id="start_time<?=$empno?>" class='form-control start_time' value="<?=$start_time_approve?>"  readonly></td>
                                                        <td><input type="text" name="end_time[]" id="end_time<?=$empno?>" class='form-control end_time' value="<?=$end_time_approve?>"  readonly></td>
                                                        <td><button class="btn btn-warning" onclick="clear_time_ot('<?=$empno?>')">ลบเวลา</button></td>
                                                    </tr>
                                                    <?
                                                    
                                                }
                                                ?>
                                            </table>
                                        </div>
                                        <?
                                        $sql_ot = "SELECT * FROM tbot_request WHERE date_ot='$date_ot_uk' AND $codition_department_request AND shift='$shift' ";
                                        $res_ot = mssql_query($sql_ot);
                                        $num_ot = mssql_num_rows($res_ot);
                                        $row_ot = mssql_fetch_array($res_ot);
                                        $remark = lang_thai_from_database($row_ot["remark"]);
                                        $qty_male = ($row_ot["qty_male"]);
                                        $qty_female = ($row_ot["qty_female"]);

                                        ?><b>รายละเอียดที่ขอทำงานล่วงเวลา (OT) :</b><textarea name="remark" id="remark" cols="30" rows="10" class="form-control"><?=$remark?></textarea>
                                        <br>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-horizontal" >
                                                    <div class="form-group">
                                                        <label class="control-label col-sm-3" for="qty_male">ชาย</label>
                                                        <div class="col-sm-2">
                                                            <input type="number" id="qty_male" class="form-control" value='<?=$qty_male?>'>
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <p class='form-control-static'>คน</p>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-sm-3" for="qty_female">หญิง</label>
                                                        <div class="col-sm-2">
                                                            <input type="number" id="qty_female" class="form-control" value='<?=$qty_female?>'>
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <p class='form-control-static'>คน</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class='col-sm-6 text-center' >
                                                <table>
                                                    <tr>
                                                        <td colspan="2" align="center">สถานะคนที่ทำงานล่วงเวลา OT</td>    
                                                    </tr>
                                                    <tr>
                                                        <td align="center">O</td>
                                                        <td align="center">ทำโอที</td>
                                                    </tr>
                                                    <tr>
                                                        <td align="center">X</td>
                                                        <td align="center">ไม่ทำโอที</td>
                                                    </tr>
                                                    <tr>
                                                        <td align="center">-</td>
                                                        <td align="center">ไม่มาทำงาน</td>
                                                    </tr>
                                                    <tr>
                                                        <td align="center">#</td>
                                                        <td align="center">งดโอที</td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                        <br>
                                        <center>
                                            <button class='btn btn-success' onclick='save_confirm_ot()'>Confirm</button>
                                        </center>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?
                    } ?>




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


</body>

</html>