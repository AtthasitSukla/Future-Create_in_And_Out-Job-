<? 
include("connect.php");
session_start();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>I-Wis HQ : Time OJT Training</title>
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
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel='stylesheet' type='text/css' href='assets/css/bootstrap.min.css' />
    <!--link rel='stylesheet' type='text/css' href='assets/css/dataTables.bootstrap.min.css' /-->
    <link rel='stylesheet' type='text/css' href='assets/css/buttons.dataTables.min.css' />
    <!--link rel="stylesheet" type="text/css" href="assets/css/multi-select.css"-->
    <script type="text/javascript" src="assets/js/jquery-1.10.2.min.js"></script>
    <style>
        td {
            font-size: 12px;
        }

        th {
            font-size: 12px;
            text-align: center;
        }

        #tr_h {
            font-size: 18px;
        }

        .ui-draggable,
        .ui-droppable {
            background-position: top;
        }
    </style>
    <script>
        var tb_job_train = "";
        $(function() {


            //show_probation();
            $("form#myform1").submit(function(event) {
                event.preventDefault(); //คำสั่งที่ใช้หยุดการเกิดเหตุการณ์ใดๆขึ้น
                if ($("#tra_group").val() == "") {
                    $("#tra_group").focus();
                    return false;
                }
                if ($("#title_name").val() == "") {
                    $("#title_name").focus();
                    return false;
                }
                if ($("#title_desc").val() == "") {
                    $("#title_desc").focus();
                    return false;
                }
                if ($("#tr_time").val() == "") {
                    $("#tr_time").focus();
                    return false;
                }
                //if(parseFloat($("#time_start").val()) >= parseFloat($("#time_end").val())){
                //			alert('กรุณาเลือกช่วงเวลาใหม่อีกครั้ง');
                //			return false;
                //		}
                var formData = new FormData($(this)[0]);
                //alert($("#title_id").val());
                //	return false;
                if ($("#title_id").val() == '0') {
                    formData.append("status", 'I');
                } else {
                    formData.append("status", 'U');
                }
                formData.append("title_name", $("#title_name").val());
                formData.append("tra_department", $("#tra_department").val());
                formData.append("positionidnumber", $("#positionidnumber").val());
                formData.append("tra_group", $("#tra_group").val());

                //	formData.append("time_end",parseFloat($("#time_end").val()));
                $.ajax({
                    url: 'position_data.php',
                    type: "POST",
                    async: false,
                    cache: false,
                    //	dataType: "json",
                    contentType: false,
                    processData: false,
                    data: formData,
                    success: function(data) {
                        alert('Save Complete.');
                    }
                });
                tb_job_train.search('').draw();
                $("#tra_group").val("");
                $("#title_name").val("");
                $("#title_desc").val("");
                $("#sl_dep").val("0");
                //$("#time_start").val("8");
                //$("#time_end").val("9");
                $("#title_id").val("0");
                $("#myModalJobTrain").modal('hide');
                $("#sl_dep").prop('disabled', false);
                $("#show_pos").show();
            });

            $('#btn_search_c').on('click', function() {
                $("#txt_search").val(0);
                tb_job_train.search('').draw();
            });

            $('#btn_search').on('click', function() {
                tb_job_train.search($("#txt_search").val()).draw();
            });

            $('#btn_cancel').on('click', function() {
                $("#title_name").val("");
                $("#title_desc").val("");
                $("#sl_dep").val("0");
                $("#time_start").val("8");
                $("#time_end").val("9");
                $("#title_id").val("0");
                $("#sl_dep").prop('disabled', false);
                $("#myModalJobTrain").modal('hide');
                $("#show_pos").show();

            });


            tb_job_train = $('#tb_job_train').DataTable({
                "ajax": {
                    url: "position_data.php",
                    type: "POST",
                    async: false,
                    dataType: "json",
                    "data": {
                        "status": "T",
                    }
                },
                "ordering": false,
                "columns": [{
                        "data": "item",
                        "sTitle": "ลำดับ",
                        "width": "3%",
                        "render": function(data, type, full, meta) {
                            return data;
                        }
                    },

                    {
                        "data": "title",
                        "sTitle": "Name Position / ชื่อตำแหน่งงาน",
                        "width": "25%",
                        "render": function(data, type, full, meta) {
                            return data;
                        }
                    }, {
                        "data": "desc",
                        "sTitle": "Group",
                        "width": "7%",
                        "render": function(data, type, full, meta) {
                            return data;
                        }
                    }, {
                        "data": "edit",
                        "sTitle": "Edit",
                        "width": "5%",
                        "render": function(data, type, full, meta) {
                            return data;
                        }
                    }
                ],

                "processing": true,
                "serverSide": true,
                "searching": true,
                "lengthChange": false,
                "scrollCollapse": true,
                "info": true,
                "paging": true,
                "dom": '<"top">tr<"clear">',

            });



        });


        function add_title(id) {
            $("#title_id").val(id);
            if (id > 0) {
                $("#show_pos").hide();
                $.ajax({
                    url: 'position_data.php',
                    type: "POST",
                    async: false,
                    dataType: "json",
                    data: {
                        status: "R",
                        type: "tbtra_title",
                        id: id,
                    },
                    success: function(data) {
                        var data = data.data;
                        //$("#tra_id").val(data['tra_id']);
                        $("#tra_group").val(data['tra_group']);
                        $("#title_name").val(data['title_name']);
                        $("#tra_department").val(data['tra_department']);
                        //$("#sl_dep").prop('disabled', true);
                        //	$("#time_start").val(data['tra_form']);
                        //$("#time_end").val(data['tra_to']);
                        $("#tra_time").val(data['tra_time']);

                    }
                });
            } else {
                $("#tra_group").val(" ");
                $("#title_name").val(" ");
                $("#tra_department").val(0);
            }

            $("#myModalJobTrain").modal('show');
        }
    </script>
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
                                    <div class="col-md-12">
                                        <p id="name"></p>
                                        <p><b>ค้นหาตำแหน่งงาน : </b>
                                            <select id="txt_search">
                                                <option value="0">- Select -</option>
                                                <?
                                                // Fetch Department
                                                $sql_position = "SELECT * FROM tbposition";
                                                $position=mssql_query($sql_position);
                                                while ($row = mssql_fetch_array($position)) {
                                                    $positionid = $row['positionid'];
                                                    $positionname = $row['positionname'];

                                                    // Option
                                                    echo "<option value='" . $positionid . "' >" . $positionname . "</option>";
                                                }
                                                ?>
                                            </select>
                                            <button type="button" class="btn btn-success" id="btn_search">ค้นหา</button>
                                            <button type="button" id="btn_search_c" class="btn btn-warning">ยกเลิก</button>
                                            <button type="button" class="btn btn-info" onclick="add_title(0)">เพิ่มตำแหน่ง</button>
                                        </p>
                                        <table id="tb_job_train" width="100%" class="table table-striped table-bordered" cellspacing="0"></table>
                                    </div>
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


    <div class="modal fade" id="myModalJobTrain" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content" style="width:100%">
                <form action="" method="post" enctype="multipart/form-data" name="myform1" id="myform1" style="margin-left:10px">

                    <TABLE style="height:250px;">
                        <TR>
                            <TD id="tr_h">Select Group : </TD>
                            <TD>
                                <select id="tra_group" class="form-control">
                                    <option value=" ">- Select -</option>
                                    <?
                                         $sql_site = "SELECT * FROM tbsite";
                                         $tblsite=mssql_query($sql_site);
                                         while ($row = mssql_fetch_array($tblsite)) {
                                             $site = $row['site'];
                                             // Option
                                             echo "<option value='" . $site . "' >" . $site . "</option>";
                                         }
                                                ?>
                                </select>
                            </TD>
                        </TR>

                        <TR>
                            <TD id="tr_h">ตำแหน่ง : </TD>
                            <TD> <input type="hidden" name="title_id" id="title_id" value=0><input type="text" name="title_name" id="title_name" size="60"></TD>
                        </TR>
                        <TR>
                            <TD id="tr_h">สาขาตำแหน่ง : </TD>
                            <TD> <select id="tra_department" class="form-control">
                                    <option value="0">- Select -</option>
                                    <?
                                         $sql_department = "SELECT * FROM tbdepartment";
                                         $tbdepartment=mssql_query($sql_department);
                                         while ($row = mssql_fetch_array($tbdepartment)) {
                                             $department = $row['department'];
                                             $departmentid = $row['departmentid'];
                                             // Option
                                             echo "<option value='" . $departmentid . "' >" . $department . "</option>";
                                         }
                                                ?>
                                </select></TD>
                        </TR>
                        <TR>
                            <TD id="tr_h"></TD>
                            <TD>
                                <?
                                         $sql_department = "SELECT Max(positionid)as positionid FROM tbposition ";
                                         $tbdepartment=mssql_query($sql_department);
                                         while ($row = mssql_fetch_array($tbdepartment)) {
                                             $positionid = $row['positionid'];
                                             $sumnumber = substr($positionid,1,4) + 1;
                                             $positionidsub  = substr( $positionid,0,2);
                                             $positionidtrue =  $positionidsub.$sumnumber;
                                             echo "<input type='hidden'   id='positionidnumber' value='" . $positionidtrue . "' >";
                                         }
                                                ?>
                            </TD>
                        </TR>
                        <TR>
                            <TD></TD>
                            <TD><br><input type="submit" class="btn btn-success" id="btn_save" value="บันทึก"> <button type="button" id="btn_cancel" class="btn btn-warning">ยกเลิก</button><br></TD>
                        </TR>
                    </TABLE>

                </form>
            </div>

        </div>
    </div>


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
    <script type='text/javascript' src='assets/js/jquery.dataTables.min.js'></script>
    <script type='text/javascript' src='assets/js/dataTables.bootstrap.min.js'></script>


</body>

</html>