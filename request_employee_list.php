<?php  
session_start();
include("connect.php");
include("library.php"); 
//$status = $_GET["status"];
$status = $_GET['status'];
$admin_userid = $_SESSION['admin_userid'];
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Hrs : Request Employee</title>
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

<style>
td {
    padding: 5px;
}
</style>
<script>
$(document).ready(function() {
    $('#example').DataTable({
        "order": [[ 0, "asc" ]]
    });

     $("#target_date_one,#target_date_two,#target_date_three").datepicker({
        dateFormat: 'dd/mm/yy'
    });

});
function click_status(status){
    //alert(status);
    var job_id = $("#job_id").val();
    var comment = $("#comment").val();
    $.post("getajax_request_employee.php",{
        status:"save_status",
        job_id : job_id,
        comment : comment,
        status_save : status
    }).done(function(data){			
        alert("Success");
        window.location.href="request_employee_list.php";
    })
}
function save_comment(){
    var job_id = $("#job_id").val();
    var comment = $("#comment").val();
    $.post("getajax_request_employee.php",{
        status:"save_comment",
        job_id : job_id,
        comment : comment
    }).done(function(data){			
        alert("success");
    })
}
</script>
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
        <!-- END RIGHTBAR -->
<div id="page-content">
	<div id='wrap'>
		<div id="page-heading">
			

		
			
		</div>
		<div class="container">

<?php if($status=="") { ?>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading">รายการขออัตรากำลังคน</div>
            <div class="panel-body">
                <div class="pull-right">
                    <a href="request_employee.php" class="btn btn-success">Create Requset Employee</a>
                </div><br><br>
                <table id="example" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>ลำดับ</th>
                            <th width='120px'>วันที่สร้าง</th>
                            <th >ฝ่าย/แผนก/หน่วยงาน</th>
                            <th>1.ตำแหน่งงาน</th>
                            <th>2.ตำแหน่งงาน</th>
                            <th>ผู้ขอ</th>
                            <th>สถานะ</th>
                            <th>Print</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                <?php
                $no= 1;
                $sql = "select convert(varchar, create_date, 103)as create_date_date,
                convert(varchar, create_date, 108)as create_date_time,
                * 
                from tbrequest_employee order by create_date desc";
                $res = mssql_query($sql);
                while($row=mssql_fetch_array($res)){
                    $job_id = $row["job_id"];
                    $department = get_departmentname($row["departmentid"]);
                    $positionid_one = get_positionname($row["positionid_one"]);
                    $positionid_two = get_positionname($row["positionid_two"]);
                    $reason = lang_thai_from_database($row["reason"]);
                    $male = $row["male"];
                    $female = $row["female"];
                    //$target_date = ($row["target_date_date"]);
                    $cause = lang_thai_from_database($row["cause"]);
                    $create_date = $row["create_date_date"]." ".$row["create_date_time"];
                    $full_name = get_full_name($row["create_empno"]);
                    $comment = $row["comment"];
                    $status_save = $row["status"];
                    if($status_save=="" || $status_save==" "){
                        $btn_status = "<a href='request_employee_list.php?status=view&job_id=$job_id' class='btn btn-warning'>Pending</a>";
                    }else if($status_save=="Approve"){
                        $btn_status = "<a href='request_employee_list.php?status=view&job_id=$job_id' class='btn btn-success'>$status_save</a>";
                    }else if($status_save=="Reject"){
                        $btn_status = "<a href='request_employee_list.php?status=view&job_id=$job_id' class='btn btn-danger'>$status_save</a>";
                    }
                    ?>
                    <tr>
                        <td><?=$no?></td>
                        <td><?=$create_date?></td>
                        <td><?=$department?></td>
                        <td><?=$positionid_one?></td>
                        <td><?=$positionid_two?></td>
                        <td><?=$full_name?></td>
                        <td><?=$btn_status?></td>
                        <td align="center"><a href="pop_request_employee.php?job_id=<?=$job_id?>" class="btn btn-info" target="92">Print</a></td>
                    </tr>
                    <?
                    $no++;
                }

                ?>
                    </tbody>
                </table>
               
            </div>
        </div>
    </div>
</div>


<?php } ?>
			
<?php if($status=="view") { ?>
<?php $job_id_get = $_GET["job_id"]; ?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading">รายการขออัตรากำลังคน</div>
            <div class="panel-body">
                <table width='100%' cellpadding="10" >
                <?php
                
                $sql = "select convert(varchar, create_date, 103)as create_date_date,
                convert(varchar, create_date, 108)as create_date_time,
                convert(varchar, target_date_one, 103)as target_date_one_date,
                convert(varchar, target_date_two, 103)as target_date_two_date,
                convert(varchar, target_date_three, 103)as target_date_three_date,
                convert(varchar, comment_date, 103)as comment_date_date,
                convert(varchar, comment_date, 108)as comment_date_time,* 
                from tbrequest_employee 
                where job_id='$job_id_get'";
                $res = mssql_query($sql);
                $row=mssql_fetch_array($res);
                $job_id = $row["job_id"];
                $department = get_departmentname($row["departmentid"]);
                $positionid_one = get_positionname($row["positionid_one"]);
                $positionid_two = get_positionname($row["positionid_two"]);
                $reason = lang_thai_from_database($row["reason"]);
                $male_one = $row["male_one"];
                $female_one = $row["female_one"];
                $target_date_one = ($row["target_date_one_date"]);
                $cause_one = lang_thai_from_database($row["cause_one"]);
                $male_two = $row["male_two"];
                $female_two = $row["female_two"];
                $target_date_two = ($row["target_date_two_date"]);
                $cause_two = lang_thai_from_database($row["cause_two"]);
                $male_three = $row["male_three"];
                $female_three = $row["female_three"];
                $target_date_three = ($row["target_date_three_date"]);
                $cause_three = lang_thai_from_database($row["cause_three"]);
                $create_date = $row["create_date_date"]." ".$row["create_date_time"];
                $full_name = get_full_name($row["create_empno"]);
                $comment = lang_thai_from_database($row["comment"]);
                $comment_date = $row["comment_date_date"]." ".$row["comment_date_time"];
                $comment_empno = get_full_name($row["comment_empno"]);
                $status_save = $row["status"];
                if($admin_userid=="56002"){
                    if($status_save=="Approve"){
                        $dis_app = "disabled";
                        $dis_re = "";
                    }else if($status_save=="Reject"){
                        $dis_app = "";
                        $dis_re = "disabled";
                    }
                    $btn_click_status ="<button class='btn btn-success' onclick='click_status(&quot;Approve&quot;)' $dis_app>Approve</button> <button class='btn btn-danger' onclick='click_status(&quot;Reject&quot;)'$dis_re>Reject</button>";
                }else{
                    if($status_save=="" || $status_save==" "){
                        $btn_click_status = "<label class='label label-warning'>Pending</label>";
                    }else if($status_save=="Approve"){
                        $btn_click_status = "<label class='label label-success'>$status_save</label>";
                    }else if($status_save=="Reject"){
                        $btn_click_status = "<label class='label label-danger'>$status_save</label>";
                    }
                }
                ?>
                    <tr>
                        <td  colspan="3">ฝ่าย/แผนก/หน่วยงาน : <?=$department?></td>
                        <td>วันที่ <?=$create_date?></td>
                    </tr>

                    <tr>
                        <td  colspan="4">1.ตำแหน่งงาน : <?=$positionid_one?></td>
                    </tr>

                    <tr>
                        <td  colspan="4">2.ตำแหน่งงาน : <?=$positionid_two?></td>
                    </tr>

                    <tr>
                        <td >ขอทดแทนพนักงานเดิม <br> (ที่ลาออกไป)</td>
                        <td>ชาย <?=$male_one?> อัตรา <br>หญิง <?=$female_one?> อัตรา </td>
                        <td>วันที่ต้องการ : <?=$target_date_one?></td>
                        <td><?=$cause_one?></td>
                    </tr>
                    <tr>
                        <td >ขอเพิ่มอัตราพนักงาน <br> (รองรับงานที่เพิ่มขึ้น)</td>
                        <td>ชาย <?=$male_two?> อัตรา <br>หญิง <?=$female_two?> อัตรา </td>
                        <td>วันที่ต้องการ : <?=$target_date_two?></td>
                        <td><?=$cause_two?></td>
                    </tr>
                    <tr>
                        <td >ขอทดแทนพนักงาน <br> (ที่โอนย้ายไปหน่วยอื่น)</td>
                        <td>ชาย <?=$male_three?> อัตรา <br>หญิง <?=$female_three?> อัตรา </td>
                        <td>วันที่ต้องการ : <?=$target_date_three?></td>
                        <td><?=$cause_three?></td>
                    </tr>
                    <tr>
                        <td  colspan="4">ผู้ขอ : <?=$full_name?></td>
                    </tr>

                    <tr>
                        <td colspan="4">ความคิดเห็นและข้อเสนอของผู้จัดการแผนก / GM</td>
                    </tr>

                    <tr>
                        <input type="hidden" id="job_id" name="job_id" value="<?=$job_id?>">
                        <td colspan="4"><textarea name="comment" id="comment" class="form-control" cols="30" rows="10" autofocus><?=$comment?></textarea></td>
                    </tr>

                    <tr>
                        <td colspan="4" align="right"><?=$btn_click_status?></td>
                    </tr>
                    <!--
                    <tr>
                        <td colspan="4" align="right"><button class="btn btn-success" onclick='save_comment()'>Save</button></td>
                    </tr>
                    -->
                </table>
               
            </div>
        </div>
    </div>
</div>

<?php } ?>


		</div> <!-- container -->
	</div> <!--wrap -->
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