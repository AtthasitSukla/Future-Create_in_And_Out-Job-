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
       
    </style>
    <script>
        $(document).ready(function() {
            <?
            if($status==""){
            ?>
                $("#date_announcement").datepicker({
                    dateFormat: 'dd/mm/yy'
                });
                CKEDITOR.replace('doc_detail');
                select_doc_use_or_type_admin();
                select_department();
            <?
            }else if($status=="reviewer"){
                ?>
                $("#table_document").dataTable({});
                <?
            }?>
        });
        function myTrim(x){return x.replace(/^\s+|\s+$/gm,'')}

        function submit_loading() {
            var doc_use = $("#doc_use").val();
            var doc_type = $("#doc_type").val();
            var doc_copy_type = $("#doc_copy_type").val();
            var doc_name = $("#doc_name").val();
            var doc_code = $("#doc_code").val();
            var doc_revision = $("#doc_revision").val();
            var date_announcement = $("#date_announcement").val();
            var dar_no = $("#dar_no").val();
            var file_name = $("#file_name").val();
            if(doc_use==""||doc_type==""||doc_copy_type==""||doc_name==""||doc_code==""||doc_revision==""||date_announcement==""||dar_no==""||file_name==""){
                alert("กรุณาใส่ข้อมูลให้ครบ");
            }else{
                $("#myModal_loading").modal({
                    backdrop: "static"
                });
            }
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
        
        function select_doc_use_or_type_admin(){
            var doc_use = $("#doc_use").val();
            var doc_type = $("#doc_type").val();
            var departmentid = $("#departmentid").val();
            var doc_use_remark = $("#doc_use_remark").val();
            $.post("getajax_e_document.php", {
                status: "select_doc_use_or_type_admin",
                doc_use: doc_use,
                doc_type:doc_type,
                departmentid: departmentid,
                doc_use_remark:doc_use_remark
            }).done(function(data) {
                var aa=myTrim(data);					
	            var bb = aa.split("###",150);
                $("#show_doc_use_remark").html(bb[0]);
                $("#show_form").html(bb[1]);
                $("#show_doc_type_remark").html(bb[2]);
            })
        }

        function select_doc_name(){
            var doc_use = $("#doc_use").val();
            var doc_type = $("#doc_type").val();
            var doc_name = $("#doc_name").val();

            $.post("getajax_e_document.php", {
                status: "select_doc_name",
                doc_use: doc_use,
                doc_type:doc_type,
                doc_name:doc_name
            }).done(function(data) {
                var aa=myTrim(data);					
	            var bb = aa.split("###",150);
                $("#doc_code").val(bb[0]);
                $("#doc_revision").val(bb[1]);
                select_department();
            })
        }
        function select_department(){
            var departmentid = $("#departmentid").val();
            var doc_code = $("#doc_code").val();
            // alert(departmentid);
            $.post("getajax_e_document.php",{
                status: "show_department_to_see",
                departmentid : departmentid,
                doc_code : doc_code
            }).done(function(data){
                $("#show_department_to_see").html(data);
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

                    <?php if ($status == "") {
                        $departmentid_user = $_SESSION["departmentid"];
                        // echo $departmentid_user;
                        // $sql_department = "SELECT department FROM tbdepartment WHERE departmentid='$departmentid'";
                        // $res_department = mssql_query($sql_department);
                        // $row_department = mssql_fetch_array($res_department);
                        // $department = $row_department["department"];
                        ?>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">Create DAR ADMIN</div>
                                    <div class="panel-body">
                                        <form class="form-horizontal" action="create_dar_upload_admin.php" method="post" enctype="multipart/form-data">
                                            <div class="form-group">
                                                <label class="control-label col-sm-2" for="department">แผนก :</label>
                                                <div class="col-sm-2">
                                                    <select class="form-control" name="departmentid" id="departmentid" class="form-control" onchange="select_department()">
                                                        <?php
                                                            if ($_SESSION["admin_userid"] == "56002" || $_SESSION["admin_userid"] == "56038") {

                                                                $sql_department = "SELECT * FROM tbdepartment order by department";
                                                            }else{
                                                                $sql_department = "SELECT * FROM tbdepartment where departmentid='$departmentid_user' order by department";

                                                            }
                                                            $res_department = mssql_query($sql_department);
                                                            while($row_department = mssql_fetch_array($res_department)){
                                                                $departmentid_select = $row_department["departmentid"];
                                                                $department = $row_department["department"];
                                                                ?>
                                                                <option value="<?=$departmentid_select?>"
                                                                    <? if($departmentid_select==$departmentid_user){
                                                                        echo "selected";
                                                                    }
                                                                    ?>
                                                                ><?=$department?></option>
                                                                <?

                                                            }
                                                        ?>
                                                    </select>
                                                    
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-sm-2" for="doc_use">ยื่นคำร้องเพื่อ :</label>
                                                <div class="col-sm-3">
                                                    <select name="doc_use" id="doc_use" class="form-control" onchange="select_doc_use_or_type_admin()" required>
                                                        <option value="">Select</option>
                                                        <option value="ขอจัดทำเอกสารใหม่">ขอจัดทำเอกสารใหม่</option>
                                                        <option value="ขอเปลี่ยนแปลงแก้ไข">ขอเปลี่ยนแปลงแก้ไข</option>
                                                        <option value="ขอยกเลิกเอกสาร">ขอยกเลิกเอกสาร</option>
                                                        <option value="ขอสำเนาควบคุม">ขอสำเนาควบคุม</option>
                                                        <option value="ขอสำเนาไม่ควบคุม">ขอสำเนาไม่ควบคุม</option>
                                                        <option value="อื่นๆ">อื่นๆ</option>
                                                    </select>

                                                </div>
                                                
                                                <div class="col-sm-4" id="show_doc_use_remark">

                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-sm-2" for="doc_type">ประเภทของเอกสาร :</label>
                                                <div class="col-sm-3">
                                                    <select name="doc_type" id="doc_type" class="form-control" onchange="select_doc_use_or_type()" required>
                                                        <option value="">Select</option>
                                                        <?php
                                                        $sql_type = "SELECT * FROM tbe_document_doc_type where status_show='1' order by sort_id";
                                                        $res_type = mssql_query($sql_type);
                                                        while($row_type = mssql_fetch_array($res_type)){
                                                            $doc_type = $row_type["doc_type"];
                                                            $doc_type_show = lang_thai_from_database($row_type["doc_type_show"]);
                                                            ?><option value="<?=$doc_type?>"><?=$doc_type_show?></option><?
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="col-sm-4" id="show_doc_type_remark">

                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-sm-2" for="doc_copy_type">สำเนากระดาษ :</label>
                                                <div class="col-sm-3">
                                                    <select name="doc_copy_type" id="doc_copy_type" class="form-control"  required>
                                                        <option value="">Select</option>
                                                        <option value="ขอสำเนาควบคุม">ขอสำเนาควบคุม</option>
                                                        <option value="ไม่ขอสำเนาควบคุม">ไม่ขอสำเนาควบคุม</option>
                                                    </select>

                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-sm-2" for="doc_copy_qty">สำเนาจำนวน :</label>
                                                <div class="col-sm-3">
                                                    <select name="doc_copy_qty" id="doc_copy_qty" class="form-control"  >
                                                        <?Php 
                                                        for($i=0;$i<100;$i++){
                                                            ?><option value="<?=$i?>"><?=$i?></option><?
                                                        }
                                                        ?>
                                                    </select>

                                                </div>
                                            </div>
                                            <div id="show_form">
                                                
                                                
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-sm-2" for="date_announcement">วันที่เริ่มใช้ :</label>
                                                <div class="col-sm-2">
                                                    <input type="text" name="date_announcement" id="date_announcement" class="form-control" autocomplete="off" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-sm-2" for="dar_no">Dar No. :</label>
                                                <div class="col-sm-2">
                                                    <input type="text" name="dar_no" id="dar_no" class="form-control" autocomplete="off" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-sm-2" for="doc_detail">รายละเอียดการแก้ไข :</label>
                                                <div class="col-sm-10">
                                                    <textarea name="doc_detail" id="doc_detail" cols="30" rows="10" class="form-control"></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-sm-2" for="file_name">เอกสารที่แนบมาด้วย :</label>
                                                <div class="col-sm-10">
                                                    <input type="file" name="file_name" id="file_name" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-sm-2" for="pages">หน้าที่ :</label>
                                                <div class="col-sm-2">
                                                    <input type="text" name="pages" id="pages" class="form-control" placeholder="1-3" autocomplete="off">
                                                    <span class="help-inline">ตัวอย่าง : 1-3</span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-sm-2" for="pages">แผนกที่ต้องการให้เห็น :</label>
                                                <div class="col-sm-4" id="show_department_to_see">
                                                    <div class="checkbox">
                                                    <?
                                                    $sql_department = "SELECT * FROM tbdepartment order by department";
                                                    $res_department = mssql_query($sql_department);
                                                    while($row_department = mssql_fetch_array($res_department)){
                                                        $departmentid_check = $row_department["departmentid"];
                                                        $department = $row_department["department"];

                                                        $sql_permission = "SELECT * FROM tbe_document_permission WHERE doc_code='$doc_code_doc' AND departmentid='$departmentid'";
                                                        $res_permission = mssql_query($sql_permission);
                                                        $num_permission = mssql_num_rows($res_permission);

                                                        if($departmentid_check==$departmentid_user){
                                                            $checked_depart = "checked onclick='return false;'";
                                                        }else if($num_permission>0){ //Check old revision 
                                                            $checked_depart = "checked";
                                                        }else{
                                                            $checked_depart = "";
                                                        }

                                                        ?><label><input type="checkbox" name="departmentid_checkbox[]" value='<?=$departmentid_check?>' <?=$checked_depart?>> <?=$department?>&nbsp;&nbsp;</label><?
                                                    }
                                                    ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-sm-offset-2 col-sm-10">
                                                    <?php if ($_SESSION['departmentid'] == "" || $_SESSION["admin_userid"]=="") { ?>
                                                        <font color='red'>*กรุณาล็อคอินก่อน</font>
                                                    <?php } else { ?>
                                                        <button type="submit" class="btn btn-primary" onclick='submit_loading()'>Submit</button>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>


                    <?php } 
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