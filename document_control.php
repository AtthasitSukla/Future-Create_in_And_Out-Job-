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
    <title>Hrs : E-Document</title>
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
        .progressbar {
            margin: 0;
            padding: 0;
            counter-reset: step;
        }

        .progressbar li {
            list-style-type: none;
            width: 25%;
            float: left;
            font-size: 12px;
            position: relative;
            text-align: center;
            text-transform: uppercase;
            color: #7d7d7d;
        }

        .progressbar li:before {
            width: 30px;
            height: 30px;
            content: counter(step);
            counter-increment: step;
            line-height: 30px;
            border: 2px solid #7d7d7d;
            display: block;
            text-align: center;
            margin: 0 auto 10px auto;
            border-radius: 50%;
            background-color: white;
        }

        .progressbar li:after {
            width: 100%;
            height: 2px;
            content: '';
            position: absolute;
            background-color: #7d7d7d;
            top: 15px;
            left: -50%;
            z-index: -1;
        }

        .progressbar li:first-child:after {
            content: none;
        }

        .progressbar li {
            color: rgb(0, 0, 0);
        }

        .progressbar li.active:before {
            border-color: #55b776;
            background-color: #55b776;
        }

        .progressbar li.notActive:before {
            border-color: #b75855;
            background-color: #b75855;
        }

        .progressbar li.active+li:after {
            background-color: #55b776;
        }
    </style>
    <script>
        $(document).ready(function() {
            
            $("#table_document").dataTable({});
        });

        function submit_loading() {
            $("#myModal_loading").modal({
                backdrop: "static"
            });
        }

        function open_amendment_record(doc_code) {
            $.post("getajax_e_document.php", {
                status: "open_amendment_record",
                doc_code: doc_code
            }).done(function(data) {
                $("#myModal_open_amendment_record").modal();
                $("#open_amendment_record").html(data);
            })
        }
        function select_doc_type(doc_type){
            var id_click = $("#"+doc_type);
            var id_icon_click = $("#"+doc_type+"_icon");

            $(".classDoc_type").removeClass("active btn-success");
            $(".classDoc_type").addClass("btn-warning");
            $(".icon_type").removeClass("fa-folder-open-o");
            $(".icon_type").addClass("fa-folder-o");

            
            $("#"+doc_type).removeClass("btn-warning");
            $("#"+doc_type).addClass("active btn-success");
            $("#"+doc_type+"_icon").removeClass("fa-folder-o");
            $("#"+doc_type+"_icon").addClass("fa-folder-open-o");

            $("#show_all_department").html("loading...");
            $("#show_document_approve").html("");

            $.post("getajax_e_document.php", {
                status: "show_all_department",
                doc_type: doc_type
            }).done(function(data) {
                $("#show_all_department").html(data);
                $("#show_document_approve").html("");
            })
            // $.post("getajax_e_document.php", {
            //     status: "show_document_approve",
            //     doc_type: doc_type
            // }).done(function(data) {
            //     $("#show_document_approve").html(data);
            //     $("#table_document").dataTable({});
            // })

        }
        function select_department(departmentid_select,doc_type){
            $(".classDepartment").removeClass("active btn-success");
            $(".classDepartment").addClass("btn-warning");
            $(".icon_type_department").removeClass("fa-folder-open-o");
            $(".icon_type_department").addClass("fa-folder-o");

            
            $("#"+departmentid_select).removeClass("btn-warning");
            $("#"+departmentid_select).addClass("active btn-success");
            $("#"+departmentid_select+"_icon").removeClass("fa-folder-o");
            $("#"+departmentid_select+"_icon").addClass("fa-folder-open-o");

            $.post("getajax_e_document.php", {
                status: "show_document_approve",
                departmentid_select: departmentid_select,
                doc_type: doc_type
            }).done(function(data) {
                $("#show_document_approve").html(data);
                $("#table_document").dataTable({});
            })
        }
        function select_doc_type_obsolete(doc_type){
            var id_click = $("#"+doc_type);
            var id_icon_click = $("#"+doc_type+"_icon");

            $(".classDoc_type").removeClass("active btn-success");
            $(".classDoc_type").addClass("btn-warning");
            $(".icon_type").removeClass("fa-folder-open-o");
            $(".icon_type").addClass("fa-folder-o");

            
            $("#"+doc_type).removeClass("btn-warning");
            $("#"+doc_type).addClass("active btn-success");
            $("#"+doc_type+"_icon").removeClass("fa-folder-o");
            $("#"+doc_type+"_icon").addClass("fa-folder-open-o");

            $("#show_all_department").html("loading...");
            $("#show_document_obsolete").html("");

            $.post("getajax_e_document.php", {
                status: "show_all_department_obsolete",
                doc_type: doc_type
            }).done(function(data) {
                $("#show_all_department_obsolete").html(data);
                $("#show_document_obsolete").html("");
            })

        }
        function select_department_obsolete(departmentid_select,doc_type){
            $(".classDepartment").removeClass("active btn-success");
            $(".classDepartment").addClass("btn-warning");
            $(".icon_type_department").removeClass("fa-folder-open-o");
            $(".icon_type_department").addClass("fa-folder-o");

            
            $("#"+departmentid_select).removeClass("btn-warning");
            $("#"+departmentid_select).addClass("active btn-success");
            $("#"+departmentid_select+"_icon").removeClass("fa-folder-o");
            $("#"+departmentid_select+"_icon").addClass("fa-folder-open-o");

            $.post("getajax_e_document.php", {
                status: "show_document_obsolete",
                departmentid_select: departmentid_select,
                doc_type: doc_type
            }).done(function(data) {
                $("#show_document_obsolete").html(data);
                $("#table_document").dataTable({});
            })
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
    <!-- Modal -->
    <div class="modal fade" id="myModal_open_amendment_record" role="dialog">
        <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">

                    <h4 class="modal-title">บันทึกการแก้ไข ( Amendment Record )</h4>
                </div>
                <div class="modal-body" id="open_amendment_record">
                    <p>Loading Please wait...</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
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

                    <?php  if ($status == "") {
                        $departmentid = $_SESSION['departmentid'];
                        // echo $departmentid;
                        $empno = array();
                        array_push($empno, $_SESSION['admin_userid']);
                        //array_push($empno,"60111");
                        $sql = "SELECT * FROM  tbleave_control WHERE emp_control = '" . $_SESSION['admin_userid'] . "'";
                        $re = mssql_query($sql);
                        $num = mssql_num_rows($re);
                        while ($row = mssql_fetch_array($re)) {
                            array_push($empno, $row['emp_under']);
                        }
                        $empno = join("','", $empno);
                        //echo $empno;
                        ?>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">Document Control</div>
                                    <div class="panel-body">
                                        <div class='row'>

                                            <div class="col-lg-3 col-md-6 col-sm-4">
                                                <?php
                                                $sql_type = "SELECT * FROM tbe_document_doc_type where status_show='1' order by sort_id";
                                                $res_type = mssql_query($sql_type);
                                                while($row_type = mssql_fetch_array($res_type)){
                                                    $doc_type = $row_type["doc_type"];
                                                    $doc_type_show = lang_thai_from_database($row_type["doc_type_show"]);
                                                    ?>
                                                    <div class="form-group">
                                                        <button class="classDoc_type btn btn-warning btn-label" onclick="select_doc_type('<?=$doc_type?>')" id="<?=$doc_type?>"><i class="fa fa-folder-o icon_type"  id="<?=$doc_type?>_icon"></i><?=$doc_type_show?></button>
                                                    </div>
                                                    <?
                                                }
                                                ?>
                                                
                                            </div> 
                                            <div class='col-lg-9 col-md-6 col-sm-8' id="show_all_department" >

                                            </div>
                                        </div>

                                    
                                    

                                
                                       
                                        <hr>
                                        <div id="show_document_approve">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    <?

                    } else if($status=="obsolete"){
                        $departmentid = $_SESSION['departmentid'];
                        // echo $departmentid;
                        $empno = array();
                        array_push($empno, $_SESSION['admin_userid']);
                        //array_push($empno,"60111");
                        $sql = "SELECT * FROM  tbleave_control WHERE emp_control = '" . $_SESSION['admin_userid'] . "'";
                        $re = mssql_query($sql);
                        $num = mssql_num_rows($re);
                        while ($row = mssql_fetch_array($re)) {
                            array_push($empno, $row['emp_under']);
                        }
                        $empno = join("','", $empno);
                        //echo $empno;
                        ?>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel panel-inverse">
                                    <div class="panel-heading">Document Obsolete</div>
                                    <div class="panel-body">
                                        <div class='row'>

                                            <div class="col-lg-3 col-md-6 col-sm-4">
                                                <?php
                                                $sql_type = "SELECT * FROM tbe_document_doc_type where status_show='1' order by sort_id";
                                                $res_type = mssql_query($sql_type);
                                                while($row_type = mssql_fetch_array($res_type)){
                                                    $doc_type = $row_type["doc_type"];
                                                    $doc_type_show = lang_thai_from_database($row_type["doc_type_show"]);
                                                    ?>
                                                    <div class="form-group">
                                                        <button class="classDoc_type btn btn-warning btn-label" onclick="select_doc_type_obsolete('<?=$doc_type?>')" id="<?=$doc_type?>"><i class="fa fa-folder-o icon_type"  id="<?=$doc_type?>_icon"></i><?=$doc_type_show?></button>
                                                    </div>
                                                    <?
                                                }
                                                ?>
                                                <!-- <div class="form-group">
                                                    <button class="classDoc_type btn btn-warning btn-label" onclick="select_doc_type_obsolete('QM')" id="QM"><i class="fa fa-folder-o icon_type"  id="QM_icon"></i>คู่มือคุณภาพ (QM)</button>
                                                </div>
                                                <div class="form-group">
                                                    <button class="classDoc_type btn btn-warning btn-label" onclick="select_doc_type_obsolete('QP')" id="QP" ><i class="fa fa-folder-o icon_type" id="QP_icon"></i>ระเบียบการปฏิบัติงาน (QP)</button>
                                                </div>
                                                <div class="form-group">
                                                    <button class="classDoc_type btn btn-warning btn-label" onclick="select_doc_type_obsolete('WI')" id="WI"><i class="fa fa-folder-o icon_type" id="WI_icon"></i>วิธีปฏิบัติงาน (WI)</button>
                                                </div>
                                                <div class="form-group">
                                                    <button class="classDoc_type btn btn-warning btn-label" onclick="select_doc_type_obsolete('FM')" id="FM"><i class="fa fa-folder-o icon_type" id="FM_icon"></i>แบบฟอร์ม (FM)</button>
                                                </div>
                                                <div class="form-group">
                                                    <button class="classDoc_type btn btn-warning btn-label" onclick="select_doc_type_obsolete('Other')" id="Other"><i class="fa fa-folder-o icon_type" id="Other_icon"></i>อื่นๆ</button>
                                                </div> -->
                                            </div> 
                                            <div class='col-lg-9 col-md-6 col-sm-8' id="show_all_department_obsolete" >

                                            </div>
                                        </div>

                                       
                                        <hr>
                                        <div id="show_document_obsolete">

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
    <script type="text/javascript" src="assets/js/jquery.multi-select.js"></script>
    <script type="text/javascript" src="assets/js/jquery.quicksearch.js"></script>

    <script type='text/javascript' src='assets/js/jquery.dataTables.min.js'></script>
    <script type='text/javascript' src='assets/js/dataTables.bootstrap.min.js'></script>


</body>

</html>