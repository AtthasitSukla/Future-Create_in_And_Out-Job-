<?php
session_start();
include("connect.php");
include("library.php");

$course_id = $_GET['course_id'];
$sql = "select * from tbcourse_list where course_id='$course_id'";
$res = mssql_query($sql);
$row = mssql_fetch_array($res);
$course_title = lang_thai_from_database($row['course_title']);
$coach = lang_thai_from_database($row['coach']);
$institution = lang_thai_from_database($row['institution']);
$start_date = date_format_thai_from_databese($row['start_date']);
$end_date = date_format_thai_from_databese($row['end_date']);
$place = lang_thai_from_database($row['place']);
$time = $row['time'];
$result1 = $row['result1']==1?"checked":"";
$result2 = $row['result2']==1?"checked":"";
$result3 = $row['result3']==1?"checked":"";
$result4 = $row['result4']==1?"checked":"";


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
td {
    font-size: 12px;
}
th {
    font-size: 12px;
	text-align: center;
}

#tr_h{
    font-size: 18px;
}
.ui-draggable, .ui-droppable {
	background-position: top;
}
#bookmark{
	border-top: 1px solid #8c8b8b;
	border-width:2px;
}
</style>
<script>

$(function() {
	var d = new Date();
		    var toDay = d.getDate() + '/'
        + (d.getMonth() + 1) + '/'
        + (d.getFullYear() + 543);
	
	
	
});
function save_evaluation_course(){
	var course_id = $("#course_id").val();
	var result1 =  $("#result1:checked").val();
	var result2 =  $("#result2:checked").val();
	var result3 =  $("#result3:checked").val();
	var result4 =  $("#result4:checked").val();
	result1 = result1==1?1:0;
	result2 = result2==1?1:0;
	result3 = result3==1?1:0;
	result4 = result4==1?1:0;
	//alert(result3);
	
	//alert(course_id+result1+result2+result3+result4);
	
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
	
		remark[i] =  $(this).val();
		
	});
	
	//alert(result_id+" "+result+" "+remark);
	$.post("job_data.php",{
		status:"save_evaluation_course",
		course_id : course_id,
		result_id : result_id,
		remark : remark,
		result : result,
		result1 : result1,
		result2 : result2,
		result3 : result3,
		result4 : result4
	}).done(function(data){			
		//alert(data);
		alert("บันทึกสำเร็จ");
	});
	//alert(res_id+" "+tra_res);
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
				<div class="col-md-12" >
					<div class="panel panel-primary">
						
						<div class="panel-body">
							<div class='row'>
								<div class='col-sm-12'><h4>หัวข้อหัวข้อการฝึกอบรม  : <?=$course_title?> </h4></div>
								<div class='col-sm-12'>วิทยากร : <?=$coach?></div>
								<div class='col-sm-12'>สถาบัน : <?=$institution?></div>
								<div class='col-sm-12'>วันที่ฝึกอบรม : <?=$start_date." - ".$end_date?></div>
								<div class='col-sm-12'>สถานที่ : <?=$place?></div>
								<div class='col-sm-12'>เวลา : <?=$time?></div>
							</div>
							<br>
							
							<div class='row'>
								<div class="col-md-12" id='job_training' >
		
									<p><b></b></p>
									<table class="table table-striped table-bordered" width="100%">
										<thead>
											<tr >
												<th rowspan="2">ลำดับ</th>
												<th rowspan="2">หน่วยงาน</th>
												<th rowspan="2">ชื่อ - สกุล</th>
												<th colspan="2">ผลการประเมิน</th>
												<th rowspan="2">หมายเหตุ</th>
											</tr>
											<tr >
												
												<th>ผ่าน</th>
												<th>ไม่ผ่าน</th>
												
											</tr>
										</thead>
									<?php
										$i = 1;
										$sql_result = "SELECT * from tbcourse_result  
										WHERE  course_id = '$course_id'";
										$res_reult=mssql_query($sql_result);
										while($row_result = mssql_fetch_array($res_reult)){
											$result_id  = $row_result['result_id'];
											$empno = $row_result['empno'];
											$result = $row_result['result'];
											$remark = $row_result['remark'];
											
											$row_empno = get_rec_empno($empno);
											$firstname = lang_thai_from_database($row_empno['firstname']);
											$lastname = lang_thai_from_database($row_empno['lastname']);
											$site = $row_empno['site'];
											
											switch($result){
												case 0 : 
													$check_pass ="";
													$check_fail="";
													break;
												case 1 : 
													$check_pass="checked";
													$check_fail="";
													break;
												case 2 : 
													$check_pass ="";
													$check_fail="checked";
													break;
											}
										
											?>
											
												<tr id="<?=$result_id?>">
													
													<td><center><?=$i?></center></td>
													<td><center><?=$site ?></center></td>
													<td><?=$firstname." ".$lastname ?></td>
													<td><center><input type="radio" name="result_<?=$result_id?>" id="result_<?=$result_id?>" value="1" <?=$check_pass?>></center></td>
													<td><center><input type="radio" name="result_<?=$result_id?>" id="result_<?=$result_id?>" value="2" <?=$check_fail?>></center>
														<input type="hidden" name="result_id[]" id="result_id[]" value="<?=$result_id?>" ></td>
													<td><input type="text" name="remark[]" id="remark[]" value="<?=$remark?>" class="form-control" ></td>
												</tr>
										
									<?php
											
											$i++;
										}
									?>
									</table>
								</div>
								<div class='col-sm-12'>
									<input type='hidden' name='course_id' id='course_id' value='<?=$course_id?>'>
									
									<div class='col-sm-12 form-inline'>
										<div class="form-group">
										  <label for="recommend">วิธีการประเมิน  : </label>
										  <label><input type="checkbox" class="form-control" id="result1" value='1' name="result1" <?=$result1?>>  ทำแบบทดสอบ</label>
										  <label><input type="checkbox" class="form-control" id="result2" value='1' name="result2" <?=$result2?>> การซัก - ถามจากวิทยากร</label>
										  <label><input type="checkbox" class="form-control" id="result3" value='1' name="result3" <?=$result3?>> เขียนรายงานอบรม</label>
										  <label><input type="checkbox" class="form-control" id="result4" value='1' name="result4" <?=$result4?>> ระยะเวลาเข้าฝึกอบรม</label>
										</div>
									</div>
								</div>
							</div>
							<div class='row'>
								<div class='col-sm-12'>
									<div class='pull-right'>
										<button class='btn btn-success' onclick='save_evaluation_course()'>Save</button>
										<a href='training_course_print.php?course_id=<?=$course_id?>' target='_blank' class='btn btn-info' target="<?=$group_id?>">Print</a>
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