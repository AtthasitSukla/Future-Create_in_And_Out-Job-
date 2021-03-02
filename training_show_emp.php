<? 
session_start();
include("connect.php");
include("library.php");

$empno = $_GET['empno'];
//echo $empno;
$row_empno = get_rec_empno($empno);
$firstname = lang_thai_from_database($row_empno['firstname']);
$lastname = lang_thai_from_database($row_empno['lastname']);
$nickname = lang_thai_from_database($row_empno['nickname']);
$positionid = $row_empno['positionid'];
$positionname = get_positionname($positionid);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>HRS : JOB TRAINING</title>
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


</style>
<script>
function save_result_training(){
	var result_id = [];
	var remark =[];
	var result = [];
	
	$('input[name^="result_id"]').each(function(i){
	//tra_checkbox[i] = $(this).val();
		result_id[i] =  $(this).val();
		//alert($(this).val());
		var result_arr = $("#result_"+result_id[i]+":checked").val();
		if(result_arr==null){
			result[i] = 0;
		}else{
			result[i] = result_arr;
		}
	});
	$('input[name^="remark"]').each(function(i){
	//tra_checkbox[i] = $(this).val();
		remark[i] =  $(this).val();
		
	});
	
	$.post("job_data.php",{
		status:"save_result_training",
		result_id : result_id,
		result : result,
		remark : remark
	}).done(function(data){			
		alert("บันทึกสำเร็จ");
	})
	//alert(remark);
	
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



			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-primary">
						
						<div class="panel-body">
							<div class='row'>
								<div class="col-md-12" id='emp_detail'>
									<div class="form-horizontal" >
										<div class="form-group">
											<label class="control-label col-sm-2" for="emp_name">ชื่อพนักงาน : </label>
											<div class="col-sm-10">
												<input type='hidden' name='empno' id='empno' value='<?=$empno?>'>
												<h4> <?php echo $firstname." ".$lastname." ( ".$nickname." )"; ?> </h4>
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-sm-2" for="trainer">ตำแหน่ง : </label>
											<div class="col-sm-3">
												<?=$positionname?>
											</div>
										</div>
											
							
									</div>
								</div>
							</div>
							<br>
							<div class='row'>
								<div class='col-sm-12' id='taining_coures'>
									<table class="table table-striped table-bordered" width="100%">
										<?php //$empno2 = $_GET['empno']; ?>
										<thead>
											<th>ลำดับ </th>
											<th>หัวข้อการฝึกอบรม</th>
											<th>สถาบัน</th>
											<th>วันที่ฝึกอบรม</th>
											<th>เวลา</th>
											<th>ผ่าน</th>
											<th>ไม่ผ่าน</th>
											<th>หมายเหตุ</th>
										</thead>
								<?php
									$i = 1;
									$sql = "select * from tbcourse_result where empno='$empno'";
									$res = mssql_query($sql);
									while($row = mssql_fetch_array($res)){
										$result_id = $row['result_id'];
										$course_id = $row['course_id'];
										$result = $row['result'];
										$remark = $row['remark'];
										switch($result){
											case 0 : 
												$pass = "";
												$fail = "";
												break;
											case 1 :
												$pass = "checked";
												$fail = "";
												break;
											case 2 :
												$pass = "";
												$fail = "checked";
												break;
										}
										
										$sql_coures = "select * from tbcourse_list where course_id='$course_id'";
										$res_coures = mssql_query($sql_coures);
										$row_coures = mssql_fetch_array($res_coures);
										$course_title= lang_thai_from_database($row_coures['course_title']);
										$institution = lang_thai_from_database($row_coures['institution']);
										$start_date = date_format_thai_from_databese($row_coures['start_date']);
										$end_date = date_format_thai_from_databese($row_coures['end_date']);
										$time = $row_coures['time'];
										
										?>
										<tr>
											<td><?=$i?></td>
											<td><?=$course_title?></td>
											<td><?=$institution?></td>
											<td><?=$start_date." - ".$end_date ?></td>
											<td><?=$time?></td>
											<td align='center'><input type="radio" id='result_<?=$result_id?>' name='result_<?=$result_id?>' value='1' <?=$pass?>></td>
											<td align='center'><input type="radio" id='result_<?=$result_id?>' name='result_<?=$result_id?>' value='2' <?=$fail?>></td>
											<td><input type='text' id='remark[]' name="remark[]" class="form-control" value="<?=$remark?>">
												<input type='hidden' id='result_id[]' name='result_id[]' value='<?=$result_id?>'></td>
										</tr>
							<?php	} ?>
									</table>
									
								</div>
							</div>
							<div class='row'>
								<div class='col-sm-12'>
									<div class='pull-right'>
										<button class='btn btn-success' onclick='save_result_training()'>SAVE</button>
									</div>
								</div>
							</div>
					  </div>
					</div>
				</div>
			</div>
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