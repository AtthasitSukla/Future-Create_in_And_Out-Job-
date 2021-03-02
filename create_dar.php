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
            if ($status == "") {
                ?>
                $("#date_announcement").datepicker({
                    dateFormat: 'dd/mm/yy'
                });
                CKEDITOR.replace('doc_detail');
                select_doc_use_or_type();
                select_department();
            <?
            } else if ($status == "reviewer") {
                ?>
                search_log_sheet();
                
                $("#create_date_log_sheet_start,#create_date_log_sheet_end").datepicker({
                    dateFormat: 'dd/mm/yy'
                });
            <?
            } ?>
        });

        function myTrim(x) {
            return x.replace(/^\s+|\s+$/gm, '')
        }

        function submit_loading() {
            var doc_use = $("#doc_use").val();
            var doc_type = $("#doc_type").val();
            var doc_copy_type = $("#doc_copy_type").val();
            var doc_name = $("#doc_name").val();
            var doc_code = $("#doc_code").val();
            var doc_revision = $("#doc_revision").val();
            var date_announcement = $("#date_announcement").val();
            if(doc_use==""||doc_type==""||doc_copy_type==""||doc_name==""||doc_code==""||doc_revision==""||date_announcement==""){
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

        function select_doc_use_or_type() {
            var doc_use = $("#doc_use").val();
            var doc_type = $("#doc_type").val();
            var departmentid = $("#departmentid").val();
            var doc_use_remark = $("#doc_use_remark").val();
            $.post("getajax_e_document.php", {
                status: "select_doc_use_or_type",
                doc_use: doc_use,
                doc_type: doc_type,
                departmentid: departmentid,
                doc_use_remark: doc_use_remark

            }).done(function(data) {
                var aa = myTrim(data);
                var bb = aa.split("###", 150);
                $("#show_doc_use_remark").html(bb[0]);
                $("#show_form").html(bb[1]);
                $("#show_doc_type_remark").html(bb[2]);
            })
        }

        function select_doc_name() {
            var doc_use = $("#doc_use").val();
            var doc_type = $("#doc_type").val();
            var doc_name = $("#doc_name").val();

            $.post("getajax_e_document.php", {
                status: "select_doc_name",
                doc_use: doc_use,
                doc_type: doc_type,
                doc_name: doc_name
            }).done(function(data) {
                var aa = myTrim(data);
                var bb = aa.split("###", 150);
                $("#doc_code").val(bb[0]);
                $("#doc_revision").val(bb[1]);
                select_department();
            })
        }

        function select_department() {
            var departmentid = $("#departmentid").val();
            var doc_code = $("#doc_code").val();
            // alert(departmentid);
            $.post("getajax_e_document.php", {
                status: "show_department_to_see",
                departmentid: departmentid,
                doc_code: doc_code
            }).done(function(data) {
                $("#show_department_to_see").html(data);
            })
        }

        function pop_review(doc_id, doc_name) {
            // alert(doc_id);
            $("#doc_id_review").val(doc_id);
            $("#topic_review").html("Review " + doc_name);
            CKEDITOR.replace('reviewer_remark');
            CKEDITOR.instances['reviewer_remark'].setData('');
            $("#myModal_pop_review").modal();
        }

        function event_review(doc_status) {
            $("#myModal_loading").modal({
                backdrop: "static"
            });
            var doc_id = $("#doc_id_review").val();

            var reviewer_remark = CKEDITOR.instances['reviewer_remark'].getData();
            //alert(reviewer_remark)
            $.post("getajax_e_document.php", {
                status: "event_review",
                doc_id: doc_id,
                doc_status: doc_status,
                reviewer_remark: reviewer_remark
            }).done(function(data) {
                //alert(data);
                if (data == "Not_permission") {
                    alert("คุณไม่มีสิทธิ์ในการ Review");
                    $("#myModal_loading").modal('hide');
                } else {
                    $("#myModal_loading").modal('hide');
                    $("#myModal_pop_review").modal('hide');

                    $("#btn_reivew"+doc_id).removeClass("btn-defualt");
                    $("#btn_reivew"+doc_id).removeClass("btn-warning");
                    $("#btn_reivew"+doc_id).removeClass("btn-danger");
                    $("#btn_reivew"+doc_id).removeClass("btn-success");
                    $("#btn_reivew"+doc_id).removeClass("btn-label");
                    $("#btn_reivew"+doc_id).addClass("btn-label");

                    if(doc_status=="Reviewer Approve"){
                        $("#btn_reivew"+doc_id).addClass("btn-success");
                        $("#btn_reivew"+doc_id).html("<i class='fa fa-check'></i>Review");
                    }else{
                        $("#btn_reivew"+doc_id).addClass("btn-danger");
                        $("#btn_reivew"+doc_id).html("<i class='fa fa-times'></i>Review");

                    }
                }
            })
        }

        function pop_dcc_action(doc_id, doc_name) {
            // alert(doc_id);
            $("#doc_id_dcc_action").val(doc_id);
            $("#topic_dcc_action").html("DCC " + doc_name);

            CKEDITOR.replace('dcc_remark');
            CKEDITOR.instances['dcc_remark'].setData('');

            $.post("getajax_e_document.php", {
                status: "show_data_dcc_action",
                doc_id: doc_id
            }).done(function(data) {
                //alert(data);
                $("#show_department_checkbox_dcc_action").html(data);
                $("#myModal_pop_dcc_action").modal();
            })
        }

        function event_dcc_action(doc_status) {
            $("#myModal_loading").modal({
                backdrop: "static"
            });

            var doc_id = $("#doc_id_dcc_action").val();
            var departmentid = $("input[name='departmentid_checkbox_dcc_action[]']:checked").map(function(_, el) {
                return $(el).val();
            }).get();
            // var departmentid = $("input[name='departmentid_checkbox_dcc_action[]']:checked").map(function(_, el) {
            //     return $(el).val();
            // }).get();

            var dcc_remark = CKEDITOR.instances['dcc_remark'].getData();
            
            // $.post("getajax_e_document.php", {
            //     status: "event_dcc_action",
            //     doc_id: doc_id,
            //     doc_status: doc_status,
            //     departmentid: departmentid,
            //     dcc_remark: dcc_remark
            // }).done(function(data) {
            //     // alert(data);
            //     if (data == "Not_permission") {
            //         alert("คุณไม่มีสิทธิ์ในการ Approve");
            //         $("#myModal_loading").modal('hide');
            //     } else {
            //         $("#myModal_loading").modal('hide');
            //         $("#myModal_pop_dcc_action").modal('hide');

            //         $("#btn_dcc"+doc_id).removeClass("btn-defualt");
            //         $("#btn_dcc"+doc_id).removeClass("btn-warning");
            //         $("#btn_dcc"+doc_id).removeClass("btn-danger");
            //         $("#btn_dcc"+doc_id).removeClass("btn-success");
            //         $("#btn_dcc"+doc_id).removeClass("btn-label");
            //         $("#btn_dcc"+doc_id).addClass("btn-label");

            //         if(doc_status=="DCC Approve"){
            //             $("#btn_dcc"+doc_id).addClass("btn-success");
            //             $("#btn_dcc"+doc_id).html("<i class='fa fa-check'></i>DCC");
            //         }else{
            //             $("#btn_dcc"+doc_id).addClass("btn-danger");
            //             $("#btn_dcc"+doc_id).html("<i class='fa fa-times'></i>DCC");

            //         }
            //     }
            // })

            /*UPLOAD FILE */
            // alert(departmentid);
            var fd = new FormData();
            var files = $('#file_name_edit')[0].files[0];
            fd.append('file', files);
            fd.append('doc_id', doc_id);
            fd.append('departmentid', departmentid);
            fd.append('doc_status', doc_status);
            fd.append('status', "event_dcc_action");


            $.ajax({
                url: 'getajax_e_document.php',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                success: function(data) {
                    if (data == "Not_permission") {
                        alert("คุณไม่มีสิทธิ์ในการ Approve");
                        $("#myModal_loading").modal('hide');
                    } else {
                        $("#myModal_loading").modal('hide');
                        $("#myModal_pop_dcc_action").modal('hide');

                        $("#btn_dcc"+doc_id).removeClass("btn-defualt");
                        $("#btn_dcc"+doc_id).removeClass("btn-warning");
                        $("#btn_dcc"+doc_id).removeClass("btn-danger");
                        $("#btn_dcc"+doc_id).removeClass("btn-success");
                        $("#btn_dcc"+doc_id).removeClass("btn-label");
                        $("#btn_dcc"+doc_id).addClass("btn-label");

                        if(doc_status=="DCC Approve"){
                            $("#btn_dcc"+doc_id).addClass("btn-success");
                            $("#btn_dcc"+doc_id).html("<i class='fa fa-check'></i>DCC");
                        }else{
                            $("#btn_dcc"+doc_id).addClass("btn-danger");
                            $("#btn_dcc"+doc_id).html("<i class='fa fa-times'></i>DCC");

                        }
                        // alert(data);
                        if(data!=""){
                            $("#td_doc"+doc_id).html(data);
                        }
                    }
                },
            });
            /*UPLOAD FILE */

        }
        
        function pop_upload_document(doc_id, doc_name) {
            // alert(doc_id);
            $("#doc_id_upload_document").val(doc_id);
            $("#topic_upload_document").html("เปลี่ยนเอกสาร " + doc_name);

            $("#myModal_pop_upload_document").modal();
            
        }

        function event_upload_document() {
            $("#myModal_loading").modal({
                backdrop: "static"
            });

            var doc_id = $("#doc_id_upload_document").val();
            
            

            /*UPLOAD FILE */
            // alert(departmentid);
            var fd = new FormData();
            var files = $('#file_name_edit_upload_document')[0].files[0];
            fd.append('file', files);
            fd.append('doc_id', doc_id);
            fd.append('status', "event_upload_document");


            $.ajax({
                url: 'getajax_e_document.php',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                success: function(data) {
                    if (data == "Not_permission") {
                        alert("คุณไม่มีสิทธิ์ในการ Approve");
                        $("#myModal_loading").modal('hide');
                    } else {
                        $("#myModal_loading").modal('hide');
                        $("#myModal_pop_upload_document").modal('hide');
                        // alert(data);
                        if(data!=""){
                            $("#td_doc"+doc_id).html(data);
                        }
                    }
                },
            });
            /*UPLOAD FILE */

        }

        function pop_approve(doc_id, doc_name) {
            // alert(doc_id);
            $("#doc_id_approve").val(doc_id);
            $("#topic_approve").html("Approve " + doc_name);

            CKEDITOR.replace('approve_remark');
            CKEDITOR.instances['approve_remark'].setData('');

            $.post("getajax_e_document.php", {
                status: "show_data_approve",
                doc_id: doc_id
            }).done(function(data) {
                $("#show_department_checkbox").html(data);
                $("#myModal_pop_approve").modal();
            })
        }

        function event_approve(doc_status) {
            $("#myModal_loading").modal({
                backdrop: "static"
            });

            var doc_id = $("#doc_id_approve").val();
            var departmentid = $("input[name='departmentid_checkbox[]']:checked").map(function(_, el) {
                return $(el).val();
            }).get();

            var approve_remark = CKEDITOR.instances['approve_remark'].getData();

            $.post("getajax_e_document.php", {
                status: "event_approve",
                doc_id: doc_id,
                doc_status: doc_status,
                departmentid: departmentid,
                approve_remark: approve_remark
            }).done(function(data) {
                // alert(data);
                if (data == "Not_permission") {
                    alert("คุณไม่มีสิทธิ์ในการ Approve");
                    $("#myModal_loading").modal('hide');
                } else {
                    $("#myModal_loading").modal('hide');
                    $("#myModal_pop_approve").modal('hide');

                    if(data!=""){
                        $("#show_dar_no"+doc_id).html(data);
                    }

                    $("#btn_approve"+doc_id).removeClass("btn-defualt");
                    $("#btn_approve"+doc_id).removeClass("btn-warning");
                    $("#btn_approve"+doc_id).removeClass("btn-danger");
                    $("#btn_approve"+doc_id).removeClass("btn-success");
                    $("#btn_approve"+doc_id).removeClass("btn-label");
                    $("#btn_approve"+doc_id).addClass("btn-label");

                    if(doc_status=="Approver Approve"){
                        $("#btn_approve"+doc_id).addClass("btn-success");
                        $("#btn_approve"+doc_id).html("<i class='fa fa-check'></i>Approve");
                    }else{
                        $("#btn_approve"+doc_id).addClass("btn-danger");
                        $("#btn_approve"+doc_id).html("<i class='fa fa-times'></i>Approve");

                    }
                    //location.reload();
                }
            })

        }
        function search_log_sheet(){
            var  doc_use_log_sheet = $("#doc_use_log_sheet").val();
            var  doc_type_log_sheet = $("#doc_type_log_sheet").val();
            var  doc_status_log_sheet = $("#doc_status_log_sheet").val();
            var  create_date_log_sheet_start = $("#create_date_log_sheet_start").val();
            var  create_date_log_sheet_end = $("#create_date_log_sheet_end").val();
            $("#show_table_document_log_sheet").html("loading...");
            $.post("getajax_e_document.php", {
                status: "search_log_sheet",
                doc_use_log_sheet: doc_use_log_sheet,
                doc_type_log_sheet: doc_type_log_sheet,
                doc_status_log_sheet: doc_status_log_sheet,
                create_date_log_sheet_start: create_date_log_sheet_start,
                create_date_log_sheet_end: create_date_log_sheet_end
            }).done(function(data) {
                // alert(data);
                $("#show_table_document_log_sheet").html(data);
                $("#table_document_log_sheet").dataTable({
                    pageLength:50
                });
                    
            })
        }
        function print_log_sheet(){
            var  doc_use_log_sheet = $("#doc_use_log_sheet").val();
            var  doc_type_log_sheet = $("#doc_type_log_sheet").val();
            var  create_date_log_sheet_start = $("#create_date_log_sheet_start").val();
            var  create_date_log_sheet_end = $("#create_date_log_sheet_end").val();
            if(create_date_log_sheet_start=="" || create_date_log_sheet_end==""){
                alert("กรุณาเลือกวันที่");
            }else{

                window.open("pop_dar_log_sheet.php?doc_use_log_sheet="+doc_use_log_sheet+"&doc_type_log_sheet="+doc_type_log_sheet+"&create_date_log_sheet_start="+create_date_log_sheet_start+"&create_date_log_sheet_end="+create_date_log_sheet_end);
            }

        }

        function edit_document(doc_id){

            $.post("getajax_e_document.php", {
                status: "edit_document",
                doc_id: doc_id

            }).done(function(data) {
                // alert(data);
                $("#myModal_edit_document").modal();
                $("#show_form_edit").html(data);

                CKEDITOR.replace('doc_detail_edit');
                $("#date_announcement_edit").datepicker({
                    dateFormat: 'dd/mm/yy'
                });
                    
            })

        }

        function update_doc(){
            var doc_id = $("#doc_id_edit").val();
            var doc_use = $("#doc_use_edit").val();
            var doc_type = $("#doc_type_edit").val();
            var doc_name = $("#doc_name_edit").val();
            var doc_code = $("#doc_code_edit").val();
            var date_announcement = $("#date_announcement_edit").val();
            var doc_detail = CKEDITOR.instances['doc_detail_edit'].getData();
            var pages = $("#pages_edit").val();

            $("#myModal_loading").modal({
                backdrop: "static"
            });

            $.post("getajax_e_document.php", {
                status: "update_doc",
                doc_id: doc_id,
                doc_use: doc_use,
                doc_type: doc_type,
                doc_name: doc_name,
                doc_code: doc_code,
                date_announcement: date_announcement,
                doc_detail: doc_detail,
                pages: pages,

            }).done(function(data) {
                $("#myModal_loading").modal('hide');
                $("#myModal_edit_document").modal('hide');
                search_log_sheet();
            })
            
        }

        function delete_document(doc_id){

            if(confirm('คุณต้องการลบใช่หรือไม่')){

                $("#myModal_loading").modal({
                    backdrop: "static"
                });

                $.post("getajax_e_document.php", {
                    status: "delete_document",
                    doc_id: doc_id,

                }).done(function(data) {
                    alert("ลบสำเร็จ"+data);
                    $("#tr"+doc_id).remove();
                    $("#myModal_loading").modal('hide');
                })
            }

        }
    </script>
</head>

<body class=" ">
    <!-- Modal -->
    <div class="modal fade" id="myModal_pop_review" role="dialog">
        <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">

                    <h4 class="modal-title" id="topic_review"></h4>
                </div>
                <div class="modal-body ">
                    <div class="form-horizontal">
                        <input type="hidden" id="doc_id_review" value=""><br>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="reviewer_remark">Remark:</label>
                            <div class="col-sm-10">
                                <textarea name="reviewer_remark" id="reviewer_remark" cols="30" rows="10"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button class="btn btn-success" onclick="event_review('Reviewer Approve')">Approve</button>
                                <button class="btn btn-danger" onclick="event_review('Reviewer Reject')">Reject</button>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>
    <!-- Modal -->
    <!-- Modal -->
    <div class="modal fade" id="myModal_pop_dcc_action" role="dialog">
        <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">

                    <h4 class="modal-title" id="topic_dcc_action"></h4>
                </div>
                <div class="modal-body ">
                    <div class="form-horizontal">
                        <input type="hidden" id="doc_id_dcc_action" value="">
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="Department">แผนกที่ต้องการให้เห็น</label>
                            <div class=" col-sm-4 ">
                                <div class="checkbox" id="show_department_checkbox_dcc_action">

                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="dcc_remark">Remark:</label>
                            <div class="col-sm-10">
                                <textarea name="dcc_remark" id="dcc_remark" cols="30" rows="10"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="file_name_edit">ไฟล์ใหม่ </label>
                            <div class=" col-sm-4 ">
                                <input type="file" name="file_name_edit" id="file_name_edit">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button class="btn btn-success" onclick="event_dcc_action('DCC Approve')">Approve</button>
                                <button class="btn btn-danger" onclick="event_dcc_action('DCC Reject')">Reject</button>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>
    <!-- Modal -->
    <!-- Modal -->
    <div class="modal fade" id="myModal_pop_upload_document" role="dialog">
        <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">

                    <h4 class="modal-title" id="topic_upload_document"></h4>
                </div>
                <div class="modal-body ">
                    <div class="form-horizontal">
                        <input type="hidden" id="doc_id_upload_document" value="">
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="file_name_edit_upload_document">ไฟล์ใหม่ </label>
                            <div class=" col-sm-4 ">
                                <input type="file" name="file_name_edit_upload_document" id="file_name_edit_upload_document">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button class="btn btn-success" onclick="event_upload_document()">Save</button>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>
    <!-- Modal -->
    <!-- Modal -->
    <div class="modal fade" id="myModal_pop_approve" role="dialog">
        <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">

                    <h4 class="modal-title" id="topic_approve"></h4>
                </div>
                <div class="modal-body ">
                    <div class="form-horizontal">
                        <input type="hidden" id="doc_id_approve" value="">
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="Department">แผนกที่ต้องการให้เห็น</label>
                            <div class=" col-sm-4 ">
                                <div class="checkbox" id="show_department_checkbox">

                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="approve_remark">Remark:</label>
                            <div class="col-sm-10">
                                <textarea name="approve_remark" id="approve_remark" cols="30" rows="10"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">

                                <button class="btn btn-success" onclick="event_approve('Approver Approve')">Approve</button>
                                <button class="btn btn-danger" onclick="event_approve('Approver Reject')">Reject</button>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>
    <!-- Modal -->
    <!-- Modal -->
    <div class="modal fade" id="myModal_edit_document" role="dialog">
        <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">

                    <h4 class="modal-title" id="topic_approve">Edit Document</h4>
                </div>
                <div class="modal-body " id="show_form_edit">
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" onclick="update_doc()">Update</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>
            </div>

        </div>
    </div>
    <!-- Modal -->
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
                                    <div class="panel-heading">Create DAR</div>
                                    <div class="panel-body">
                                        <form class="form-horizontal" action="create_dar_upload.php" method="post" enctype="multipart/form-data">
                                            <div class="form-group">
                                                <label class="control-label col-sm-2" for="department">แผนก :</label>
                                                <div class="col-sm-2">
                                                    <select class="form-control" name="departmentid" id="departmentid" class="form-control" onchange="select_department()">
                                                        <?php
                                                            if ($_SESSION["admin_userid"] == "56002" || $_SESSION["admin_userid"] == "56038") {

                                                                $sql_department = "SELECT * FROM tbdepartment order by department";
                                                            } else {
                                                                $sql_department = "SELECT * FROM tbdepartment where departmentid='$departmentid_user' order by department";
                                                            }
                                                            $res_department = mssql_query($sql_department);
                                                            while ($row_department = mssql_fetch_array($res_department)) {
                                                                $departmentid_select = $row_department["departmentid"];
                                                                $department = $row_department["department"];
                                                                ?>
                                                                <option value="<?= $departmentid_select ?>" 
                                                                    <? if ($departmentid_select == $departmentid_user) {
                                                                        echo "selected";
                                                                    }
                                                                    ?>
                                                                ><?= $department ?></option>
                                                            <?

                                                            }
                                                            ?>
                                                    </select>

                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="control-label col-sm-2" for="doc_use">ยื่นคำร้องเพื่อ :</label>
                                                <div class="col-sm-3">
                                                    <select name="doc_use" id="doc_use" class="form-control" onchange="select_doc_use_or_type()" required>
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
                                                <label class="control-label col-sm-2" for="doc_detail">รายละเอียดการแก้ไข :</label>
                                                <div class="col-sm-10">
                                                    <textarea name="doc_detail" id="doc_detail" cols="30" rows="10" class="form-control"></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-sm-2" for="file_name">เอกสารที่แนบมาด้วย :</label>
                                                <div class="col-sm-10">
                                                    <input type="file" name="file_name" id="file_name">
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
                                                            while ($row_department = mssql_fetch_array($res_department)) {
                                                                $departmentid_check = $row_department["departmentid"];
                                                                $department = $row_department["department"];

                                                                $sql_permission = "SELECT * FROM tbe_document_permission WHERE doc_code='$doc_code_doc' AND departmentid='$departmentid'";
                                                                $res_permission = mssql_query($sql_permission);
                                                                $num_permission = mssql_num_rows($res_permission);

                                                                if ($departmentid_check == $departmentid_user) {
                                                                    $checked_depart = "checked onclick='return false;'";
                                                                } else if ($num_permission > 0) { //Check old revision 
                                                                    $checked_depart = "checked";
                                                                } else {
                                                                    $checked_depart = "";
                                                                }

                                                                ?><label><input type="checkbox" name="departmentid_checkbox[]" value='<?= $departmentid_check ?>' <?= $checked_depart ?>> <?= $department ?>&nbsp;&nbsp;</label><?
                                                                                                                                                                                                                                    }
                                                                                                                                                                                                                                    ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-sm-offset-2 col-sm-10">
                                                    <?php 
                                                    include("connect.php");
                                                    $sql_emp  = "SELECT * FROM tbemployee WHERE empno='".$_SESSION['admin_userid']."'";
                                                    // echo $sql_emp;
                                                    $res_emp = mssql_query($sql_emp);
                                                    $num_emp = mssql_num_rows($res_emp);
                                                    if ($_SESSION['departmentid'] == "" || $_SESSION["admin_userid"]=="" || $num_emp==0) { ?>
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


                    <?php } else if ($status == "reviewer") {

                        $departmentid = $_SESSION['departmentid'];
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

                        if ($_SESSION["admin_userid"] == "56002" || $_SESSION["admin_userid"] == "56038" || $_SESSION["admin_userid"] == "61001") {
                            $sql_all_doc = "SELECT count(id) as all_doc
                            FROM tbe_document  
                            where doc_status='Create'";
                            $res_all_doc = mssql_query($sql_all_doc);
                            $row_all_doc = mssql_fetch_array($res_all_doc);
                            $all_doc = $row_all_doc["all_doc"];

                            $sql_wait_review = "SELECT count(id) as wait_review
                            FROM tbe_document  
                            where doc_status='Create'";
                            $res_wait_review = mssql_query($sql_wait_review);
                            $row_wait_review = mssql_fetch_array($res_wait_review);
                            $wait_review = $row_wait_review["wait_review"];
                            
                            $sql_wait_dcc = "SELECT count(id) as wait_dcc
                            FROM tbe_document  
                            where doc_status='Reviewer Approve'";
                            $res_wait_dcc = mssql_query($sql_wait_dcc);
                            $row_wait_dcc = mssql_fetch_array($res_wait_dcc);
                            $wait_dcc = $row_wait_dcc["wait_dcc"];
                            
                            $sql_reject_by_review = "SELECT count(id) as reject_by_review
                            FROM tbe_document  
                            where doc_status='Reviewer Reject'";
                            $res_reject_by_review = mssql_query($sql_reject_by_review);
                            $row_reject_by_review = mssql_fetch_array($res_reject_by_review);
                            $reject_by_review = $row_reject_by_review["reject_by_review"];
                            
                            $sql_wait_approve = "SELECT count(id) as wait_approve
                            FROM tbe_document  
                            where doc_status='DCC Approve'";
                            $res_wait_approve = mssql_query($sql_wait_approve);
                            $row_wait_approve = mssql_fetch_array($res_wait_approve);
                            $wait_approve = $row_wait_approve["wait_approve"];
                        } else {
                            $sql_all_doc = "SELECT count(id) as all_doc
                            FROM tbe_document 
                            WHERE  doc_status='Create'
                            AND (doc_creator in ('$empno') 
                            or departmentid ='".$_SESSION['departmentid']."' )";
                            $res_all_doc = mssql_query($sql_all_doc);
                            $row_all_doc = mssql_fetch_array($res_all_doc);
                            $all_doc = $row_all_doc["all_doc"];

                            $sql_wait_review = "SELECT count(id) as wait_review
                            FROM tbe_document 
                            WHERE  doc_status='Create'
                            AND (doc_creator in ('$empno') 
                            or departmentid ='".$_SESSION['departmentid']."' )";
                            $res_wait_review = mssql_query($sql_wait_review);
                            $row_wait_review = mssql_fetch_array($res_wait_review);
                            $wait_review = $row_wait_review["wait_review"];
                            
                            $sql_wait_dcc = "SELECT count(id) as wait_dcc
                            FROM tbe_document 
                            WHERE  doc_status='Reviewer Approve'
                            AND (doc_creator in ('$empno') 
                            or departmentid ='".$_SESSION['departmentid']."' )";
                            $res_wait_dcc = mssql_query($sql_wait_dcc);
                            $row_wait_dcc = mssql_fetch_array($res_wait_dcc);
                            $wait_dcc = $row_wait_dcc["wait_dcc"];

                            $sql_reject_by_review = "SELECT count(id) as reject_by_review
                            FROM tbe_document 
                            WHERE  doc_status='Reviewer Reject'
                            AND (doc_creator in ('$empno') 
                            or departmentid ='".$_SESSION['departmentid']."' )";
                            $res_reject_by_review = mssql_query($sql_reject_by_review);
                            $row_reject_by_review = mssql_fetch_array($res_reject_by_review);
                            $reject_by_review = $row_reject_by_review["reject_by_review"];
                            
                            $sql_wait_approve = "SELECT count(id) as wait_approve
                            FROM tbe_document 
                            WHERE  doc_status='DCC Approve'
                            AND (doc_creator in ('$empno') 
                            or departmentid ='".$_SESSION['departmentid']."' )";
                            $res_wait_approve = mssql_query($sql_wait_approve);
                            $row_wait_approve = mssql_fetch_array($res_wait_approve);
                            $wait_approve = $row_wait_approve["wait_approve"];
                        }
                        ?>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">DAR log sheet</div>
                                    <div class="panel-body">
                                        <div class='row'>
                                            <div class="col-sm-6">
                                                <div class="form-horizontal">
                                                    <div class="form-group">
                                                        <label class="control-label col-sm-4" for="doc_use_log_sheet">ยื่นคำร้องเพื่อ :</label>
                                                        <div class="col-sm-5">
                                                            <select name="doc_use_log_sheet" id="doc_use_log_sheet" class="form-control">
                                                                <option value="">ทั้งหมด</option>
                                                                <option value="ขอจัดทำเอกสารใหม่">ขอจัดทำเอกสารใหม่</option>
                                                                <option value="ขอเปลี่ยนแปลงแก้ไข">ขอเปลี่ยนแปลงแก้ไข</option>
                                                                <option value="ขอยกเลิกเอกสาร">ขอยกเลิกเอกสาร</option>
                                                                <option value="ขอสำเนาควบคุม">ขอสำเนาควบคุม</option>
                                                                <option value="ขอสำเนาไม่ควบคุม">ขอสำเนาไม่ควบคุม</option>
                                                                <option value="อื่นๆ">อื่นๆ</option>
                                                            </select>

                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-sm-4" for="doc_type_log_sheet">ประเภทของเอกสาร :</label>
                                                        <div class="col-sm-5">
                                                            <select name="doc_type_log_sheet" id="doc_type_log_sheet" class="form-control" onchange="select_doc_use_or_type()">
                                                                <option value="">ทั้งหมด</option>
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
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-sm-4" for="doc_status_log_sheet">สถานะ :</label>
                                                        <div class="col-sm-4" id="show_doc_status_log_sheet">
                                                            <select name="doc_status_log_sheet" id="doc_status_log_sheet" class="form-control" >
                                                                <option value="">ทั้งหมด</option>
                                                                <option value="Create">รอ Review ( <?=$wait_review?> ) </option>
                                                                <option value="Reviewer Approve">รอ DCC ( <?=$wait_dcc?> ) </option>
                                                                <option value="DCC Approve">รอ Approve ( <?=$wait_approve?> ) </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-sm-4" for="doc_type_log_sheet">วันที่สร้าง :</label>
                                                        <div class="col-sm-3">
                                                            <input type="text" class='form-control' id="create_date_log_sheet_start" autocomplete="off" placeholder="ทั้งหมด">
                                                        </div>
                                                        <div class='col-sm-1 text-center' >
                                                            <p class="form-control-static"><strong>ถึง</strong></p>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <input type="text" class='form-control' id="create_date_log_sheet_end" autocomplete="off" placeholder="ทั้งหมด">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-sm-offset-4 col-sm-8">
                                                            <button  class="btn btn-primary" onclick="search_log_sheet()"><i class="fa fa-search"></i> Search</button>
                                                            <button  class="btn btn-info" onclick="print_log_sheet()"><i class="fa fa-print"></i> Print</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class='col-sm-6'>
                                                <!-- <strong><u>Summary</u></strong> 
                                                <ul>
                                                    <li>ขึ้นทะเบียนทั้งหมด : <?=$all_doc?></li>
                                                    <li>รออนุมัติโดยผู้ทบทวน : <?=$wait_review?></li>
                                                    <li>ไม่อนุมัติโดยผู้ทบทวน : <?=$reject_by_review?></li>
                                                    <li>รออนุมัติโดย DCC : <?=$wait_dcc?></li>
                                                    <li>ไม่อนุมัติโดย DCC : </li>
                                                    <li>รออนุมัติโดยผู้อนุมัติ : <?=$wait_approve?></li>
                                                    <li>อนุมัติโดยผู้อนุมัติ : </li>
                                                    <li>ไม่อนุมัติโดยผู้อนุมัติ  : </li>
                                                </ul> -->
                                            </div>
                                        </div>
                                        <hr>
                                        <div class='row'>
                                            <div class='col-sm-12'>
                                                <div class='table-responsive' id="show_table_document_log_sheet">

                                                    
                                                </div>
                                            </div>
                                        </div>
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