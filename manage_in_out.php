<?php
session_start();
include("connect.php");
include("library.php");
$status = $_REQUEST["status"];
$date_time = date("d/m/Y");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Hrs : Dar</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="I-Wis">
    <meta name="author" content="The Red Team">
    !--
    <link href="assets/less/styles.less" rel="stylesheet/less" media="all"> -->
    <link rel="stylesheet" href="assets/css/styles.css?=140">
    <!-- <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600' rel='stylesheet' type='text/css'>-->

    <link href='assets/demo/variations/default.css' rel='stylesheet' type='text/css' media='all' id='styleswitcher'>
    <link href='assets/demo/variations/default.css' rel='stylesheet' type='text/css' media='all' id='headerswitcher'>


    <link rel='stylesheet' type='text/css' href='jquery-ui-timepicker-0.3.3/jquery.ui.timepicker.css' />
    <link rel='stylesheet' type='text/css' href='assets/plugins/form-daterangepicker/daterangepicker-bs3.css' />
    <link rel='stylesheet' type='text/css' href='assets/js/jqueryui.css' />
    <link rel='stylesheet' type='text/css' href='assets/plugins/codeprettifier/prettify.css' />
    <link rel='stylesheet' type='text/css' href='assets/plugins/form-toggle/toggles.css' />
    <link rel="stylesheet" href="fonts.css" type="text/css" charset="utf-8" />
    <script type="text/javascript" src="DatePicker/js/jquery-1.4.4.min.js"></script>
    <!--<script type="text/javascript" src="assets/js/less.js"></script>-->
    <script type="text/javascript" src="DatePicker/js/jquery-ui-1.8.10.offset.datepicker.min.js"></script>
    <script>
        $(function() {
            var d = new Date();
            var toDay = d.getDate() + '/' +
                (d.getMonth() + 1) + '/' +
                (d.getFullYear() + 543);
            // $("#datetime").datepicker_thai({
            //     format: 'DD-MM-YYYY HH:mm:ss',
            //     changeMonth: false,
            //     changeYear: true,
            //     langTh: true,
            //     yearTh: true,
            //     yearRange: "2016:2022"

            // });
            $('#timeinout').timepicker({
                showPeriodLabels: false
            });
            $("form#myform1").submit(function(event) {
                event.preventDefault(); //คำสั่งที่ใช้หยุดการเกิดเหตุการณ์ใดๆขึ้น
                //alert("ddd");
                if ($("#tsite").val() == "") {
                    $("#tsite").focus();
                    return false;
                }
                if ($("#employee").val() == "") {
                    alert("กรุณาพนักงาน");
                    $("#employee").focus();
                    return false;
                }
                if ($("#datetime").val() == "") {
                    alert("กรุณาใส่วันที่");
                    $("#datetime").focus();
                    return false;
                }
                if ($("#timeinout").val() == "") {
                    alert("กรุณาใส่ เวลา");
                    $("#timeinout").focus();
                    return false;
                }
                if ($("#shift").val() == "") {
                    alert("กรุณาเลือก กะ");
                    $("#shift").focus();
                    return false;
                }
                if ($("#attstatus").val() == "") {
                    alert("กรุณาเลือก Status เข้า/ออก");
                    $("#attstatus").focus();
                    return false;
                }
                var formData = new FormData($(this)[0]);
                formData.append("status", "I");
                $.ajax({
                    url: 'getajax_data_in_out.php',
                    type: "POST",
                    async: false,
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: formData,
                    success: function(data) {
                        if (data == 1) {
                            $('.alert').alert();
                            alert("บันทึกข้อมูลสำเร็จ");
                            setTimeout(function() {
                                location.reload()
                            }, 2500);
                        } else {
                            alert("บันทึกไม่สำเร็จ โปรดตรวจสอบข้อมลูให้ถูกต้อง!!");
                        }
                        // alert(data);
                        // alert("บันทึกข้อมูลสำเร็จ");
                        // window.location = 'view_employee.php?status=viewdetail&empno=' + $("#id_emp").val();
                        return false;
                    }
                });
                return false;
            });
        });
    </script>
    <style>

    </style>
</head>

<body class=" ">
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
        <?
        if($status==''){
            $sql_tbsite = "SELECT * FROM tbsite ";
            $res_tbsite= mssql_query($sql_tbsite);	
        ?>
        <!-- END RIGHTBAR -->
        <div id="page-content">
            <div id='wrap'>
                <div id="page-heading">
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-primary">
                                <div class="panel-heading">Create In And Out (Job)</div>
                                <div class="panel-body">
                                    <form class="form-horizontal row-border" action="#" name="myform1" id="myform1" method="post" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <div class="col-sm-1" style="text-align:center">
                                                <strong> Site</strong>
                                            </div>
                                            <div class="col-sm-2" style="width:19%">
                                                <select class="form-control" name="tsite" id="tsite">
                                                    <?
                                                echo "<option value='' >" . '' . "</option>";
                                                while($row_tbsite=mssql_fetch_array($res_tbsite)){
                                                $site = $row_tbsite["site"];
                                                echo "<option value='" . $site . "' >" . $site . "</option>";
                                                }
                                                ?>
                                                </select>
                                                <script>
                                                    $("#tsite").change(function() {
                                                        let tsite = document.getElementById('tsite').value;
                                                        $.post("getajax_data_in_out.php", {
                                                            status: "checkempsite",
                                                            tsite: tsite
                                                        }).done(function(data) {
                                                            // var data = JSON.parse(data);
                                                            //var aa =data;
                                                            //var bb = aa.split("###",150);
                                                            // var person = data;
                                                            //   console.log(data);
                                                            $('#employee').html(data);
                                                        });
                                                    });
                                                </script>
                                            </div>
                                            <div class="col-sm-2" style="text-align:center">
                                                <strong>Employee</strong>
                                            </div>
                                            <div class="col-sm-1" style="width:19%">
                                                <select class="form-control" name="employee" id="employee">
                                                </select>
                                            </div>
                                            <input type="hidden" style="width:19%" class="form-control" id="empname" name="empname" value="" />
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-1" style="text-align:center">
                                                <strong>Shift</strong>
                                            </div>
                                            <div class="col-sm-2" style="width:19%">
                                                <select class="form-control" name="shift" id="shift">
                                                    <option value="" selected>- Shift -</option>
                                                    <option value="Day">Day</option>
                                                    <option value="Night">Night</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-2" style="text-align:center">
                                                <strong>Status</strong>
                                            </div>
                                            <div class="col-sm-1" style="width:19%">
                                                <select class="form-control" name="attstatus" id="attstatus">
                                                    <option value="" selected>- Status -</option>
                                                    <option value="in">in</option>
                                                    <option value="out">out</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-1" style="text-align:center">
                                                <strong> DateTime </strong>
                                            </div>
                                            <div class="col-sm-1" style="width:12%">
                                                <input type="date" class="form-control" id="datetime" name="datetime" value="">
                                            </div>
                                            <div class="col-sm-1" style="width:7%">
                                                <input type="text" class="form-control" id="timeinout" name="timeinout" maxlength="8" value="" readonly>
                                            </div>
                                            <div class="col-sm-2" style="text-align:center">
                                                <strong> Paycode </strong>
                                            </div>
                                            <div class="col-sm-1" style="width:19%">
                                                <input type="text" class="form-control" id="paycode" name="paycode" value="" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-1" style="text-align:center">
                                                <strong> Remark </strong>
                                            </div>
                                            <div class="col-sm-2" style="width:19%">
                                                <textarea class="form-control" id="remark"></textarea>
                                            </div>
                                        </div>
                                        <script>
                                            $("#datetime").change(function() {
                                                let datetime = document.getElementById('datetime').value;
                                                $.post("getajax_data_in_out.php", {
                                                    status: "set_paycode",
                                                    datetime: datetime
                                                }).done(function(data) {
                                                    document.getElementById('paycode').value = data;
                                                    // $('#empname').html(data);
                                                });
                                            });
                                            $("#employee").change(function() {
                                                let employee = document.getElementById('employee').value;
                                                $.post("getajax_data_in_out.php", {
                                                    status: "checkemp",
                                                    employee: employee
                                                }).done(function(data) {
                                                    // console.log(data);
                                                    document.getElementById('empname').value = data;
                                                    // $('#empname').html(data);
                                                });
                                            });
                                        </script>
                                        <div style="text-align:center; margin-right: 250px;">
                                            <button type="submit" id="btt1" class="btn btn-success">Submit</button>
                                        </div>
                                        <div style="text-align:center; height:10px"></div>
                                        <div style="text-align:center">

                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
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
    <? } ?>
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
    <!--<script type='text/javascript' src='assets/plugins/form-daterangepicker/daterangepicker.min.js'></script> -->
    <script type='text/javascript' src='assets/plugins/bootbox/bootbox.min.js'></script>
    <!--<script type='text/javascript' src='assets/plugins/form-datepicker/js/bootstrap-datepicker.js'></script> -->
    <script type='text/javascript' src='assets/plugins/form-typeahead/typeahead.min.js'></script>

    <script type='text/javascript' src='assets/js/jqueryui_datepicker_thai_min.js'></script>
</body>

</html>