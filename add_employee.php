<? include("connect.php");  ?>
<html>

<head>
    <meta charset="utf-8">
    <title>I-Wis HQ : Employee</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="I-Wis">
    <meta name="author" content="The Red Team">

    <!-- <link href="assets/less/styles.less" rel="stylesheet/less" media="all">  -->
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
            // Datepicker

            $("#birthdate").datepicker_thai({
                dateFormat: 'dd/mm/yy',
                changeMonth: false,
                changeYear: true,
                langTh: true,
                yearTh: true,
                yearRange: "1900:2020"
            });
            $("#startdate").datepicker_thai({
                dateFormat: 'dd/mm/yy',
                changeMonth: false,
                changeYear: true,
                langTh: true,
                yearTh: true,
                yearRange: "1900:2020"
            });
            $("#probationdate").datepicker_thai({
                dateFormat: 'dd/mm/yy',
                changeMonth: false,
                changeYear: true,
                langTh: true,
                yearTh: true,
                yearRange: "1900:2020"
            });
            $("#father_birthdate").datepicker_thai({
                dateFormat: 'dd/mm/yy',
                changeMonth: false,
                changeYear: true,
                langTh: true,
                yearTh: true,
                yearRange: "1900:2020"
            });
            $("#mother_birthdate").datepicker_thai({
                dateFormat: 'dd/mm/yy',
                changeMonth: false,
                changeYear: true,
                langTh: true,
                yearTh: true,
                yearRange: "1900:2020"
            });

            /* $("#birthdate").datepicker({ changeMonth: true, changeYear: true,dateFormat: 'dd/mm/yy', isBuddhist: true, defaultDate: toDay,dayNames: ['อาทิตย์','จันทร์','อังคาร','พุธ','พฤหัสบดี','ศุกร์','เสาร์'],
	  dayNamesMin: ['อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'],
	  monthNames: ['มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'],
	  monthNamesShort: ['ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.'],
	  yearRange: "2450:2560"
	  
	  });
	//  $("#datepicker-en").datepicker({ dateFormat: 'dd/mm/yy'});
	//  $("#inline").datepicker({ dateFormat: 'dd/mm/yy', inline: true });
	  
	  $("#startdate").datepicker({ changeMonth: true, changeYear: true,dateFormat: 'dd/mm/yy', isBuddhist: true, defaultDate: toDay,dayNames: ['อาทิตย์','จันทร์','อังคาร','พุธ','พฤหัสบดี','ศุกร์','เสาร์'],
	  dayNamesMin: ['อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'],
	  monthNames: ['มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'],
	  monthNamesShort: ['ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.']});
      $("#probationdate").datepicker({ changeMonth: true, changeYear: true,dateFormat: 'dd/mm/yy', isBuddhist: true, defaultDate: toDay,dayNames: ['อาทิตย์','จันทร์','อังคาร','พุธ','พฤหัสบดี','ศุกร์','เสาร์'],
	  dayNamesMin: ['อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'],
	  monthNames: ['มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'],
	  monthNamesShort: ['ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.']});
	  
		$("#father_birthdate").datepicker({ changeMonth: true, changeYear: true,dateFormat: 'dd/mm/yy', isBuddhist: true, defaultDate: toDay,dayNames: ['อาทิตย์','จันทร์','อังคาร','พุธ','พฤหัสบดี','ศุกร์','เสาร์'],
	  dayNamesMin: ['อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'],
	  monthNames: ['มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'],
	  monthNamesShort: ['ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.'],yearRange: "2450:2560"});
	  
	   $("#mother_birthdate").datepicker({ changeMonth: true, changeYear: true,dateFormat: 'dd/mm/yy', isBuddhist: true, defaultDate: toDay,dayNames: ['อาทิตย์','จันทร์','อังคาร','พุธ','พฤหัสบดี','ศุกร์','เสาร์'],
	  dayNamesMin: ['อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'],
	  monthNames: ['มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'],
	  monthNamesShort: ['ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.'],yearRange: "2450:2560"});
      */
            //;
            $('#positionid').on('change', function() {
                $("#position_th").text($("#positionid option:selected").text());
            })


            $(".allownumeric").on("keypress keyup blur", function(event) {
                $(this).val($(this).val().replace(/[^\d].+/, ""));
                if ((event.which < 48 || event.which > 57)) {
                    event.preventDefault();
                }
            });

            $("form#myform1").submit(function(event) {
                event.preventDefault(); //คำสั่งที่ใช้หยุดการเกิดเหตุการณ์ใดๆขึ้น
                //alert("ddd");
                if ($("#id_emp").val() == "") {
                    $("#id_emp").focus();
                    return false;
                }
                if ($("#startdate").val() == "") {
                    alert("กรุณาใส่วันเริ่มงาน");
                    $("#startdate").focus();
                    return false;
                }
                if ($("#emp_type").val() == "") {
                    alert("กรุณาเลือก Employee type");
                    $("#emp_type").focus();
                    return false;
                }
                /*if($("#firstname").val() == ""){
                	$("#firstname").focus();
                	return false;
                }
                if($("#lastname").val() == ""){
                	$("#lastname").focus();
                	return false;
                }*/
                //if($("#birthdate").val() == ""){
                //			$("#birthdate").focus();
                //			return false;
                //		}
                //		if($("#father_birthdate").val() == ""){
                //			$("#father_birthdate").focus();
                //			return false;
                //		}
                //		if($("#mother_birthdate").val() == ""){
                //			$("#mother_birthdate").focus();
                //			return false;
                //		}
                //		if($("#startdate").val() == ""){
                //			$("#startdate").focus();
                //			return false;
                //		}
                /*	if($("#personalid").val() == ""){
                		$("#personalid").focus();
                		return false;
                	}
                	if($("#address").val() == ""){
                		$("#address").focus();
                		return false;
                	}*/
                var formData = new FormData($(this)[0]);
                formData.append("status", "I");
                /* $.post("getajax_emp.php",{
                     data:formData
                 }).done(function(data){			
                     alert(data);
                 })*/

                $.ajax({
                    url: 'getajax_emp.php',
                    type: "POST",
                    async: false,
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: formData,
                    success: function(data) {
                        // alert(data);
                        alert("บันทึกข้อมูลสำเร็จ");
                        window.location = 'view_employee.php?status=viewdetail&empno=' + $("#id_emp").val();
                        return false;
                    }
                });
                return false;
            });
        });

        function create_emp() {
            //alert("sss");
            $.post("getajax_emp.php", {
                    status: "checknewemp",
                    empno: $("#id_emp").val(),
                    sid: Math.random()
                })
                .done(function(data) {
                    // alert(data);
                    //var aa =data;
                    //var bb = aa.split("###",150);
                    if (data == 'dupplicate') {
                        alert('รหัสพนักงานซ้ำ');
                        $("#id_emp").select();
                        $("#btt1").hide();
                        //	return false;
                    } else {
                        $("#id_emp_show").text("ID : " + $("#id_emp").val());
                        $("#code_emp").text("*" + $("#id_emp").val() + "*");
                        $("#btt1").show();
                    }
                });

                


        }

        function create_name() {
            $("#name_th").text($("#firstname").val() + " " + $("#lastname").val());
            $("#code_emp").text("*" + $("#id_emp").val() + "*");
        }

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#img_emp_show')
                        .attr('src', e.target.result)
                        .width(101)
                        .height(108);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }

        function set_probationdate() {
            var startdate = $("#startdate").val();
            // alert("sss");
            $.post("getajax_emp.php", {
                status: "set_probationdate",
                startdate: startdate
            }).done(function(data) {
                $("#probationdate").val(data);
            })
        }
    </script>

    <style type="text/css">
        .demo {
            font-family: 'Conv_free3of9', Sans-Serif;
            -webkit-transform: rotate(-90deg);
            -moz-transform: rotate(-90deg);
            color: #4F290F;
        }

        .demo2 {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 9px;
            color: #4F290F;
            font-weight: bold
        }

        .demo3 {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 9px;
            color: #eeeeee;
            font-weight: bold
        }

        .demo4 {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 3px;
            color: #eeeeee;

        }

        div.p {
            page-break-after: always;
        }

        div.last {}

        hr {
            border-top: 1px dashed #8c8b8b;
        }

        .emp {
            display: none
        }
    </style>
</head>

<body class=" ">


    <div id="headerbar">
        <div class="container">
            <div class="row">
                <div class="col-xs-6 col-sm-2">
                    <a href="#" class="shortcut-tiles tiles-brown">
                        <div class="tiles-body">
                            <div class="pull-left"><i class="fa fa-pencil"></i></div>
                        </div>
                        <div class="tiles-footer">
                            Create Post
                        </div>
                    </a>
                </div>
                <div class="col-xs-6 col-sm-2">
                    <a href="#" class="shortcut-tiles tiles-grape">
                        <div class="tiles-body">
                            <div class="pull-left"><i class="fa fa-group"></i></div>
                            <div class="pull-right"><span class="badge">2</span></div>
                        </div>
                        <div class="tiles-footer">
                            Contacts
                        </div>
                    </a>
                </div>
                <div class="col-xs-6 col-sm-2">
                    <a href="#" class="shortcut-tiles tiles-primary">
                        <div class="tiles-body">
                            <div class="pull-left"><i class="fa fa-envelope-o"></i></div>
                            <div class="pull-right"><span class="badge">10</span></div>
                        </div>
                        <div class="tiles-footer">
                            Messages
                        </div>
                    </a>
                </div>
                <div class="col-xs-6 col-sm-2">
                    <a href="#" class="shortcut-tiles tiles-inverse">
                        <div class="tiles-body">
                            <div class="pull-left"><i class="fa fa-camera"></i></div>
                            <div class="pull-right"><span class="badge">3</span></div>
                        </div>
                        <div class="tiles-footer">
                            Gallery
                        </div>
                    </a>
                </div>

                <div class="col-xs-6 col-sm-2">
                    <a href="#" class="shortcut-tiles tiles-midnightblue">
                        <div class="tiles-body">
                            <div class="pull-left"><i class="fa fa-cog"></i></div>
                        </div>
                        <div class="tiles-footer">
                            Settings
                        </div>
                    </a>
                </div>
                <div class="col-xs-6 col-sm-2">
                    <a href="#" class="shortcut-tiles tiles-orange">
                        <div class="tiles-body">
                            <div class="pull-left"><i class="fa fa-wrench"></i></div>
                        </div>
                        <div class="tiles-footer">
                            Plugins
                        </div>
                    </a>
                </div>

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
                <div id="page-heading">




                </div>
                <div class="container">



                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-primary">

                                <div class="panel-body">
                                    <?
                                if($status==''){
                                    $sql_tbsite = "SELECT * FROM tbsite ";
                                    $res_tbsite= mssql_query($sql_tbsite);	
                                    ?>
                                    <div class="panel">
                                        <div class="panel-heading">
                                            <h4>ข้อมูลส่วนตัว</h4>

                                        </div>
                                        <div class="panel-body collapse in">
                                            <form class="form-horizontal row-border" action="#" name="myform1" id="myform1" method="post" enctype="multipart/form-data">

                                                <div class="col-sm-8">
                                                    <div class="panel panel-primary">


                                                        <div class="form-group">
                                                            <div class="col-sm-3" style="text-align:center">
                                                                <strong> รหัสพนักงาน Employee Number </strong>
                                                            </div>
                                                            <div class="col-sm-2" style="width:12.455%">
                                                                <input type="text" disabled="disabled" id="id_empShow" name="id_empShow" value="" onChange="create_emp()">
                                                                <input type="text" id="id_emp" name="id_emp" value="" onChange="create_emp()" class="emp">
                                                            </div>
                                                            <div class="col-sm-3" style="text-align:center">
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
                                                            </div>
                                                            </div>
                                                            <div class="form-group">
                                                            <div class="col-sm-3" style="text-align:center">
                                                                <strong>สาขา Department</strong>
                                                            </div>
                                                            <div class="col-sm-2" style="width:19%">
                                                                <select class="form-control" name="department" id="department">
                                                                </select>
                                                            </div>
                                                            <div class="col-sm-3" style="text-align:center">
                                                                <strong>ตำแหน่ง Position</strong>
                                                            </div>
                                                            <div class="col-sm-2" style="width:19%">
                                                                <select class="form-control" name="positionid" id="positionid">
                                                                </select>
                                                            </div>
                                                            </div>
                                                        <script>
                                                            $("#tsite").change(function() {
                                                                let tsite = document.getElementById('tsite').value;
                                                                $.post("getajax_emp.php", {
                                                                    status: "checknsite",
                                                                    tsite: tsite
                                                                }).done(function(data) {
                                                                    var data = JSON.parse(data);
                                                                    //var aa =data;
                                                                    //var bb = aa.split("###",150);
                                                                    // var person = data;
                                                                    //   console.log(data);
                                                                    if (data != null) {
                                                                        if (data.site == 'JWD LCB') {
                                                                            document.getElementById('id_empShow').disabled = false;
                                                                        } else {
                                                                            document.getElementById('id_empShow').disabled = true;
                                                                        }
                                                                        document.getElementById('id_emp').value = data.empno;
                                                                        document.getElementById('id_empShow').value = data.empno;
                                                                        get_department();
                                                                        //	return false;
                                                                    } else {
                                                                        alert('Error not data !!');
                                                                        document.getElementById('id_emp').value = '';
                                                                        document.getElementById('id_empShow').value = '';
                                                                    }
                                                                });
                                                            });

                                                            function get_department() {
                                                                let tsite = document.getElementById('tsite').value;
                                                                $.post("getajax_emp.php", {
                                                                    status: "getdepartment",
                                                                    tsite: tsite
                                                                }).done(function(data) {
                                                                    //var aa =data;
                                                                    //var bb = aa.split("###",150);
                                                                    // var person = data;
                                                                    //   console.log(data);
                                                                    $('#department').html(data);
                                                                });
                                                            }
                                                            $("#department").change(function() {
                                                                let department = document.getElementById('department').value;
                                                                $.post("getajax_emp.php", {
                                                                    status: "getposition",
                                                                    department: department
                                                                }).done(function(data) {
                                                                    //var aa =data;
                                                                    //var bb = aa.split("###",150);
                                                                    // var person = data;
                                                                    //   console.log(data);
                                                                    $('#positionid').html(data);
                                                                });
                                                            });
                                                        </script>
                                                        <div class="form-group">
                                                            <div class="col-sm-3" style="text-align:center">
                                                                <strong> ชื่อ - นามสกุล</strong>
                                                            </div>
                                                            <div class="col-sm-2" style="width:12.455%">
                                                                <input type="text" class="form-control" id="firstname" name="firstname" value="">
                                                            </div>
                                                            <div class="col-sm-2" style="width:12.455%">
                                                                <input type="text" class="form-control" id="lastname" name="lastname" value="" onChange="create_name()">
                                                            </div>

                                                            <div class="col-sm-3" style="text-align:center">
                                                                <strong> FirstName - LastName</strong>
                                                            </div>

                                                            <div class="col-sm-2" style="width:12.455%">
                                                                <input type="text" class="form-control" id="firstname_en" name="firstname_en" value="">
                                                            </div>
                                                            <div class="col-sm-2" style="width:12.455%">
                                                                <input type="text" class="form-control" id="lastname_en" name="lastname_en" value="">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">

                                                            <div class="col-sm-3" style="text-align:center">
                                                                <strong> ชื่อเล่น NickName</strong>
                                                            </div>
                                                            <div class="col-sm-3">
                                                                <input type="text" class="form-control" id="nickname" name="nickname" value="">
                                                            </div>
                                                            <div class="col-sm-3" style="text-align:center">
                                                                <strong> วันเกิด BirthDate</strong>
                                                            </div>
                                                            <div class="col-sm-3">
                                                                <input type="text" class="form-control" id="birthdate" name="birthdate" value="" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="col-sm-3" style="text-align:center">
                                                                <strong> สถานะสมรส Marital Status</strong>
                                                            </div>
                                                            <div class="col-sm-3">
                                                                <select class="form-control" name="mstatus" id="mstatus">
                                                                    <option value="">Select</option>
                                                                    <option value="Single" <? if($mstatus=='Single' ){ ?> selected
                                                                        <?}
                                                                    ?>>โสด Single
                                                                    </option>
                                                                    <option value="Single2" <? if($mstatus=='Single2' ){ ?> selected
                                                                        <?
                                        }
                                    ?>>แต่งงานไม่จดทะเบียน
                                                                    </option>

                                                                    <option value="Married" <? if($mstatus=='Married' ){ ?> selected
                                                                        <?
                                        }
                                    ?>>แต่งงาน Married
                                                                    </option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="col-sm-3" style="text-align:center">
                                                                <strong> เบอร์โทร Mobile Number</strong>
                                                            </div>
                                                            <div class="col-sm-3">
                                                                <input type="text" class="form-control  allownumeric" id="mobile" name="mobile" value="">
                                                            </div>
                                                            <div class="col-sm-3" style="text-align:center">
                                                                <strong> อีเมล Email</strong>
                                                            </div>
                                                            <div class="col-sm-3">
                                                                <input type="text" class="form-control" id="email" name="email" value="">
                                                            </div>
                                                        </div>



                                                        <div class="form-group">

                                                            <div class="col-sm-3" style="text-align:center">
                                                                <strong> วันเริ่มงาน Start Date</strong>
                                                            </div>
                                                            <div class="col-sm-3">
                                                                <input type="text" class="form-control" id="startdate" name="startdate" value="" onChange="set_probationdate()" readonly>
                                                            </div>
                                                            <div class="col-sm-3" style="text-align:center">
                                                                <strong> วันที่ผ่านโปร </strong>
                                                            </div>
                                                            <div class="col-sm-3">
                                                                <input type="text" class="form-control" id="probationdate" name="probationdate" value="" readonly>
                                                            </div>
                                                        </div>


                                                        <!--<div class="form-group">
                              <div class="col-sm-3" style="text-align:center">
                      <strong>  สถานะสมรส Marital Status</strong>
                            </div>
                             <div class="col-sm-3">
                           <select class="form-control" name="mstatus" id="mstatus">
                          <option value="">Select</option>
                           <option value="Single" <?
                           if($mstatus=='Single'){
							   ?> selected<?
							   }
						   ?>>โสด Single</option>
                           <option value="Single2" <?
                           if($mstatus=='Single2'){
							   ?> selected<?
							   }
						   ?>>แต่งงานไม่จดทะเบียน</option>
                         
                            <option value="Married" <?
                           if($mstatus=='Married'){
							   ?> selected<?
							   }
						   ?>>แต่งงาน Married</option>
                          </select>
                            </div>
                           </div>
                           -->


                                                        <div class="form-group">

                                                            <div class="col-sm-3" style="text-align:center">
                                                                <strong> รหัสบัตรประชาชน ID Card</strong>
                                                            </div>
                                                            <div class="col-sm-3">
                                                                <input type="text" class="form-control  allownumeric" id="personalid" name="personalid" value="">
                                                            </div>
                                                            <div class="col-sm-3" style="text-align:center">
                                                                <strong> เลขที่บัญชี Account ID</strong>
                                                            </div>
                                                            <div class="col-sm-3">
                                                                <input type="text" class="form-control  allownumeric" id="accountid" name="accountid" value="">
                                                            </div>
                                                        </div>


                                                        <div class="form-group">
                                                            <div class="col-sm-3" style="text-align:center">
                                                                <strong> ชื่อบิดา Father Name</strong>
                                                            </div>
                                                            <div class="col-sm-3">
                                                                <input type="text" class="form-control" id="father_name" name="father_name" value="">
                                                            </div>
                                                            <div class="col-sm-3" style="text-align:center">
                                                                <strong> วันเกิดบิดา Father BirthDate</strong>
                                                            </div>
                                                            <div class="col-sm-3">
                                                                <input type="text" class="form-control" id="father_birthdate" name="father_birthdate" value="" readonly>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="col-sm-3" style="text-align:center">
                                                                <strong> ชื่อมารดา Mother Name</strong>
                                                            </div>
                                                            <div class="col-sm-3">
                                                                <input type="text" class="form-control" id="mother_name" name="mother_name" value="">
                                                            </div>
                                                            <div class="col-sm-3" style="text-align:center">
                                                                <strong> วันเกิดมารดา Mother BirthDate</strong>
                                                            </div>
                                                            <div class="col-sm-3">
                                                                <input type="text" class="form-control" id="mother_birthdate" name="mother_birthdate" value="" readonly>
                                                            </div>
                                                        </div>



                                                        <div class="form-group">

                                                            <div class="col-sm-3" style="text-align:center">
                                                                <strong> ที่อยู่ตามทะเบียนบ้าน Address</strong>
                                                            </div>
                                                            <div class="col-sm-9">
                                                                <input type="text" class="form-control" id="address" name="address" value="">
                                                            </div>

                                                        </div>

                                                        <div class="form-group">


                                                            <div class="col-sm-3" style="text-align:center">
                                                                <strong>ที่อยู่ปัจจุบัน Present Address</strong>
                                                            </div>
                                                            <div class="col-sm-9">
                                                                <input type="text" class="form-control" id="real_address" name="real_address" value="">
                                                            </div>
                                                        </div>


                                                        <div class="form-group">
                                                            <div class="col-sm-3" style="text-align:center">
                                                                <strong>Employee type</strong>
                                                            </div>
                                                            <div class="col-sm-2">
                                                                <select id="emp_type" name="emp_type" class="form-control" style="width:100px">
                                                                    <option value="">เลือก</option>
                                                                    <option value="employee">employee</option>
                                                                    <option value="temp">temp</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-sm-2" style="width:12.455%">
                                                            </div>
                                                            <div class="col-sm-3" style="text-align:center">
                                                                <strong> Employee level</strong>
                                                            </div>

                                                            <div class="col-sm-2" style="width:20%">
                                                                <select class="form-control" name="emp_level" id="emp_level">
                                                                    <option value="1">1 (Operative)</option>
                                                                    <option value="2">2 (Leader)</option>
                                                                    <option value="3">3 (Supervisor)</option>
                                                                    <option value="4">4 (Ass.Manager)</option>
                                                                    <option value="5">5 (Manager)</option>
                                                                    <option value="6">6 (Senior.Manager)</option>
                                                                    <option value="7">7</option>
                                                                    <option value="8">8</option>
                                                                </select>
                                                                <!-- <option value="1">Operative</option><option value="2">Leader</option><option value="3">Supervisor</option><option value="4">Ass.Manager</option><option value="5">Manager</option><option value="6">Senior.Manager</option><option value="7">.........</option><option value="8">.........</option>-->
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="col-sm-3" style="text-align:center">
                                                                <strong>สถานะการทำงาน</strong>
                                                            </div>
                                                            <div class="col-sm-2">
                                                                <select id="delstatus" name="delstatus" class="form-control" style="width:100px">
                                                                    <option value="0">ทำงาน</option>
                                                                    <option value="1">ลาออก</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-sm-2" style="width:12.455%">
                                                            </div>
                                                            <!--
                            <div class="col-sm-3" style="text-align:center">
                          <strong> permission</strong>
                            </div>
                           
                            <div class="col-sm-2" style="width:12.455%">
                                <select class="form-control" name="tpermission" id="tpermission"><option value="user">user</option><option value="admin">admin</option><option value="management">management</option></select>
                            </div>
                                 
                             -->
                                                        </div>
                                                        <div class="form-group">

                                                            <div class="col-sm-3" style="text-align:center">
                                                                <strong> ไซต์เสื้อ </strong>
                                                            </div>
                                                            <div class="col-sm-3">

                                                                <select name="shirt_size" id="shirt_size" class="form-control">
                                                                    <option value="">Select Shirt Size </option>
                                                                    <option value="S(ผู้ชาย)">S (ผู้ชาย)</option>
                                                                    <option value="M(ผู้ชาย)">M (ผู้ชาย)</option>
                                                                    <option value="L(ผู้ชาย)">L (ผู้ชาย)</option>
                                                                    <option value="XL(ผู้ชาย)">XL (ผู้ชาย)</option>
                                                                    <option value="2XL(ผู้ชาย)">2XL (ผู้ชาย)</option>
                                                                    <option value="3XL(ผู้ชาย)">3XL (ผู้ชาย)</option>
                                                                    <option value="4XL(ผู้ชาย)">4XL (ผู้ชาย)</option>
                                                                    <option value="S(ผู้หญิง)">S (ผู้หญิง)</option>
                                                                    <option value="M(ผู้หญิง)">M (ผู้หญิง)</option>
                                                                    <option value="L(ผู้หญิง)">L (ผู้หญิง)</option>
                                                                    <option value="XL(ผู้หญิง)">XL (ผู้หญิง)</option>
                                                                    <option value="2XL(ผู้หญิง)">2XL (ผู้หญิง)</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-sm-3" style="text-align:center">
                                                                <strong> ไซต์รองเท้า </strong>
                                                            </div>
                                                            <div class="col-sm-3">
                                                                <input type="number" class="form-control" id="shoe_size" name="shoe_size" value="">
                                                            </div>
                                                        </div>



                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group" style="text-align:center">

                                                        <table width="212" align="center" border="0" cellspacing="0" cellpadding="0">
                                                            <tr>
                                                                <td align="right" style="padding-right:18px"><input type="file" name="img_emp" accept="image/jpeg" onChange="readURL(this);"></td>
                                                            </tr>
                                                        </table>


                                                        <table width="212" align="center" height="330" border="0" cellspacing="0" cellpadding="0" background="images/empcard.png">
                                                            <tr>
                                                                <td height="30" align="right" style="padding-right:18px"><span class="demo2" id='id_emp_show'>ID : xxxxx</span></td>
                                                            </tr>
                                                            <tr>
                                                                <td height="90" align="center"><img src="images/ipack_logo_big.png"></td>
                                                            </tr>
                                                            <tr>
                                                                <td height="120" align="center">
                                                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                        <tr>
                                                                            <td width="70%" align="right"><img id="img_emp_show" src="emppic/blank.jpg"></td>
                                                                            <td width="30%" align="center">
                                                                                <div class="demo" style="font-size:25px" id="code_emp">*12345*</div>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td height="60" align="center">
                                                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                        <tr>
                                                                            <td height="20" align="center"><span class="demo3"></span></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td height="20" align="center"><span class="demo3" id="name_th">ชื่อ-นามสกุล</span></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td height="20" align="center"><span class="demo3" id="position_th">ตำแหน่ง</span></td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td height="30" align="center"><span class="demo4">บริษัท ไอแพ็ค โลจิสติกส์ จำกัด</span></td>
                                                            </tr>
                                                        </table>



                                                    </div>
                                                    <div style="text-align:center">

                                                        <button type="submit" id="btt1" class="btn btn-success btn-label" style="width:270px"><i class="fa fa-download"></i> CONFIRM SAVE (บันทึกรายการ)</button>

                                                    </div>
                                                    <div style="text-align:center; height:10px"></div>
                                                    <div style="text-align:center">

                                                    </div>
                                                </div>



                                            </form>
                                        </div>
                                    </div>
                                    <?
	}
?>





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

    <!--<script type='text/javascript' src='jquery-ui-timepicker-0.3.3/jquery.ui.timepicker.js'></script> -->

    <!--<script type='text/javascript' src='assets/plugins/form-daterangepicker/daterangepicker.min.js'></script> -->
    <script type='text/javascript' src='assets/plugins/bootbox/bootbox.min.js'></script>
    <!--<script type='text/javascript' src='assets/plugins/form-datepicker/js/bootstrap-datepicker.js'></script> -->
    <script type='text/javascript' src='assets/plugins/form-typeahead/typeahead.min.js'></script>

    <script type='text/javascript' src='assets/js/jqueryui_datepicker_thai_min.js'></script>
</body>

</html>