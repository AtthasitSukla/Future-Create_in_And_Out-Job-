<?php  
session_start();
include("connect.php");
include("library.php"); 
$job_id = $_GET["job_id"];
$status = $_GET['status'];

 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Hrs : Software Development</title>
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
        "order": [[ 0, "desc" ]]
    });

     $("#appointment_date").datepicker({
        dateFormat: 'dd/mm/yy'
    });

});
function save_message(){
    var job_id = $("#job_id").val();
    var message = $("#message").val();
    var job_status = $("#job_status").val();
    //var 

    if(job_status==null){
        job_status="user";
    }
    if(message==""){
        alert("กรุณาใส่ข้อความก่อน save");
    }else{
        $.post("getajax_it_service.php",{
            status:"save_message_program",
            job_id : job_id,
            message :  message,
            job_status : job_status
        }).done(function(data){	
            location.reload();		
            
        });
    }
   
   // alert(message+job_status);
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

<?php if($job_id=="") { ?>

			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-primary">
						<div class="panel-heading">Software Development List</div>
						<div class="panel-body">

                        <table id="example" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th width="135">JOB ID</th>
                                <th width='136'>CREATE DATE</th>
                                <th width='118'>JOB STATUS</th>
                                <th width="248">SYSTEM NAME</th>
                                <th width="200">PURPOSE</th>
                                <th width="166">FULL NAME</th>
                              
                            </tr>
                        </thead>
                        <tbody>

                        <?php 
                        $empno = $_SESSION['admin_userid'];
                        if(access_it_service()){ //function is library.php
                            $sql = "select convert(varchar, create_date, 103)as create_date_date,
                            convert(varchar, create_date, 108)as create_date_time,
                            empno,job_id,purpose,system_name,job_status
                            from tbitprogram_list ";
                        }else{
                            $sql = "select convert(varchar, create_date, 103)as create_date_date,
                            convert(varchar, create_date, 108)as create_date_time,
                            empno,job_id,purpose,system_name,job_status
                            from tbitprogram_list where empno='$empno'"; 
                        }
                        $res = mssql_query($sql);
                        while ($row = mssql_fetch_array($res)) {
                            $job_id = $row['job_id'];
                            $empno = $row['empno'];
                            $full_name = get_full_name($empno);
                            $purpose = lang_thai_from_database($row['purpose']);
                            $job_status = $row['job_status'];
                            $system_name = lang_thai_from_database($row['system_name']);
                            $create_date = $row['create_date_date']." ".$row['create_date_time'];

                            if($job_status=="New"){
                                $job_status_show = "<span class='label label-danger'>$job_status</span>";
                            }else if($job_status=="In progress"){
                                $job_status_show = "<span class='label label-warning'>$job_status</span>";
                            }else if($job_status=="Close"){
                                $job_status_show = "<span class='label label-success'>$job_status</span>";
                            }
                            ?>

                            <tr>
                                <td><a href="it_program_list.php?job_id=<?=$job_id?>&status=view" target='_blank'><?=$job_id?></a></td>
                                <td><?=$create_date?></td>
                                <td><center><?=$job_status_show?> | <a href="pop_it_program.php?job_id=<?=$row['job_id']?>" target="_blank">Print</a></center></td>
                                <td><?=$system_name?></td>
                                <td><?=$purpose?></td>
                                <td><?=$full_name?></td>
                            </tr>

                        <?php

                        }
                         
                        ?>  
                           
                            
                        </tbody>
                       <!-- <tfoot>
                            <tr>
                                <th>JOB ID</th>
                                <th>CREATE DATE</th>
                                <th>JOB STATUS</th>
                                <th>TOPIC</th>
                                <th>TYPE</th>
                                <th>FULL NAME</th>
                              
                            </tr>
                        </tfoot>-->
                    </table>
					     </div>
					</div>
				</div>
			</div>


<?php } ?>
			
<?php if($status =="view"){ ?>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">JOB ID #<?=$job_id?></div>
                <div class="panel-body">
                    <?php 
                    $sql ="select convert(varchar, create_date, 103)as create_date_date,
                    convert(varchar, create_date, 108)as create_date_time,
                    convert(varchar, target_date, 103)as target_date_date,
                    convert(varchar, appointment_date, 103)as appointment_date_date,* 
                     from tbitprogram_list where job_id='$job_id'";
                    $res = mssql_query($sql);
                    $num = mssql_num_rows($res);
                    //echo $num;
                    $row = mssql_fetch_array($res);
                    $job_id = $row['job_id'];
                    $empno = $row['empno'];
                    $full_name = get_full_name($empno);
                    $purpose = lang_thai_from_database($row['purpose']);
                    $reason = lang_thai_from_database($row['reason']);
                    $job_status = $row['job_status'];
                    $system_name = lang_thai_from_database($row['system_name']);
                    $create_date = $row['create_date_date']." ".$row['create_date_time'];
                    $importance = lang_thai_from_database($row['importance']);
                    $target_date = $row['target_date_date'];
                    $appointment_date = $row['appointment_date_date'];

                    $sql_file = "select * from tbitprogram_file where job_id='$job_id'";
                    $res_file = mssql_query($sql_file);
                    $num_file = mssql_num_rows($res_file);
                    if($num_file > 0){
                       // echo "sss";
                        while($row_file = mssql_fetch_array($res_file)){
                            $file_name = $row_file['file_name'];
                            $problem_file_show .= "<a href='program_pic/$file_name' target='$file_name'>$file_name</a><br>";
                        }

                    }

                    
                    if($job_status=="New"){
                        $job_status_show = "<span class='label label-danger'>$job_status</span>";
                    }else if($job_status=="In progress"){
                        $job_status_show = "<span class='label label-warning'>$job_status</span>";
                    }else if($job_status=="Close"){
                        $job_status_show = "<span class='label label-success'>$job_status</span>";
                    }
                    
                    ?>
                    <table cellpadding="10" cellspacing="10" width="100%">
                        <tr>
                            <td align="right"><strong>สถานะ : </strong></td>
                            <td><?=$job_status_show?></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td align="right"><strong>ชื่อ :</strong></td>
                            <td><?=$full_name?></td>
                            <td align="right"><strong>วันที่ขอ : </strong></td>
                            <td><?=$create_date?></td>
                        </tr>
                        <tr>
                            <td align="right"><strong>มีความประสงค์จะขอให้ : </strong></td>
                            <td><?=$purpose?></td>
                            <td align="right"><strong>วันที่ต้องการใช้งาน : </strong></td>
                            <td><?=$target_date?></td>
                        </tr>
                        <tr>
                            <td align="right"><strong>ความสำคัญ : </strong></td>
                            <td><?=$importance?></td>
                            <td align="right"><strong>วันที่ตกลง : </strong></td>
                            <td><?php
                                if(access_it_service()){
                                    ?><input type="text" name='appointment_date' id='appointment_date' value='<?=$appointment_date?>'><?
                                }else{
                                    echo $appointment_date;
                                }
                                ?></td>
                        </tr>
                        <tr>
                            <td align="right"><strong>ระบบที่ต้องการ : </strong></td>
                            <td><?=$system_name?></td>
                            <td align="right"><strong>ไฟล์แนบ : </strong></td>
                            <td><?=$problem_file_show?></td>
                        </tr>
                    </table>
                    <br>
                    <div class="panel panel-info ">
                        <div class="panel-heading"><?=$create_date?></div>
                        <div class="panel-body">
                            <?=$reason?>
                        </div>
                    </div>
                    <?php 
                    $sql_chat = "select convert(varchar, create_date, 103)as create_date_date,
                    convert(varchar, create_date, 108)as create_date_time,*
                     from tbitprogram_chat where job_id='$job_id'";
                    $res_chat = mssql_query($sql_chat);
                    $num_chat = mssql_num_rows($res_chat);
                    if($num_chat>0){
                        while($row_chat =mssql_fetch_array($res_chat)){
                            $empno_chat = $row_chat['empno'];
                            $message = lang_thai_from_database($row_chat['message']);
                            $create_date_chat = $row_chat['create_date_date']." ".$row_chat['create_date_time'];
                            if($empno_chat == "61001" || $empno_chat=="59011"){
                                $panel_color="success";
                            }else{
                                $panel_color="info";
                            }
                            ?>
                            <div class="panel panel-<?=$panel_color?> ">
                                <div class="panel-heading"><?=$create_date_chat?></div>
                                <div class="panel-body">
                                    <?=$message?>
                                </div>
                            </div>   
                            <?php
                        }
                    }
                    
                    ?>
            <?php 
             if($job_status != "Close"){
                $empno_user_id = $_SESSION["admin_userid"];
                if($empno==$empno_user_id || access_it_service()){
               ?>  <b>message :</b>
                    <input type="hidden" id="job_id" name="job_id" value="<?=$job_id?>">
                    <div class='row'>
                        <div class='col-sm-12'>
                            <textarea name="message" id="message" cols="30" rows="10" class="form-control" autofocus></textarea>
                        </div>
                    </div>
                        <br>
               
                
                    <div class='row'>
                        <div class='col-sm-12'>
                            <div class="col-sm-10"> 
                            <? 
                           
                                if(access_it_service()){
                                $selected_new = $job_status=="New" ? "selected" : "";
                                $selected_progress = $job_status=="In progress" ? "selected" : "";
                                $selected_close = $job_status=="Close" ? "selected" : "";   
                                ?>
                                    
                                    <div class="pull-right">
                                        <select name="job_status" id="job_status" class="form-control"> 
                                            <option value="New" <?=$selected_new?>>New</option>
                                            <option value="In progress" <?=$selected_progress?>>In progress</option>
                                            <option value="Close" <?=$selected_close?>>Close</option>
                                        </select>
                                    </div>
                                    
                                    
                                <? } ?>
                                </div> 
                                <div class="col-sm-1"> 
                                    <div class="pull-right">
                                        <button id="btn_svae" name="btn_save" class="btn btn-success" onclick="save_message()">Save</button>
                                    </div>
                                </div>  
                           
                        </div>

                    </div>
            <?php }
             } ?>

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