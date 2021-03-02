<?php 
session_start();
include("connect.php");
include("library.php");

$number = $_GET['number'];
$group_id= $_GET['group_id'];

$rec_group = get_rec_tbtra_group($group_id);
$empno = $rec_group['empno'];
$tra_date = $rec_group['tra_date'];
$tra_time1 = $rec_group['tra_time1'];
$tra_time2 = $rec_group['tra_time2'];
$coach = $rec_group['coach'];
$recommend = lang_thai_from_database($rec_group['recommend']);
$result1 = $rec_group['result1']==1?"checked":"";
$result2 = $rec_group['result2']==1?"checked":"";
$result3 = $rec_group['result3']==1?"checked":"";

//echo $group_id;

$arr_date = explode("-",$tra_date);
$tra_date_format = date_format_thai_from_databese($tra_date); //วันที่ อบรม


$row_empno = get_rec_empno($empno);
$firstname = lang_thai_from_database($row_empno['firstname']);
$lastname = lang_thai_from_database($row_empno['lastname']);
$nickname = lang_thai_from_database($row_empno['nickname']);


$row_coach = get_rec_empno($coach);
$firstname_coach = lang_thai_from_database($row_coach['firstname']);
$lastname_coach = lang_thai_from_database($row_coach['lastname']);
$nickname_coach = lang_thai_from_database($row_coach['nickname']);



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
	
	$('#train_date').datepicker({ changeMonth: true, changeYear: true,dateFormat: 'dd/mm/yy', isBuddhist: true, defaultDate: toDay,dayNames: ['อาทิตย์','จันทร์','อังคาร','พุธ','พฤหัสบดี','ศุกร์','เสาร์'],
	  dayNamesMin: ['อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'],
	  monthNames: ['มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'],
	  monthNamesShort: ['ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.'],
	  yearRange: "2450:2561",
		onSelect: function(dateText, inst) {
			var empno = $("#empno").val();	
			var train_date = $("#train_date").val();
			/*$.post("job_data.php",{
				status  : "select_train_date",
				train_date : train_date
			},function(data){
				var rec = jQuery.parseJSON(data);
				$("#job_add").html(data);
			});*/
			$.post("job_data.php",{
				status  : "select_train_date",
				empno : empno,
				train_date : train_date
			}).done(function(data){
				var str=data.split("###");
				$("#job_add").html(str[0]);
				//alert(str[1]);
				$("#trainer option[value="+str[1]+"]").attr('selected','selected');
			})
			//alert(train_date);
		}
		});
	
});
function save_evaluation(){
	var group_id = $("#group_id").val();
	var recommend = $("#recommend").val();
	var result1 =  $("#result1:checked").val();
	var result2 =  $("#result2:checked").val();
	var result3 =  $("#result3:checked").val();
	result1 = result1==1?1:0;
	result2 = result2==1?1:0;
	result3 = result3==1?1:0;
	//alert(result3);
	
	var res_id =[];
	var tra_res = [];
	var remark = [];
	
	
	$('input[name^="res_id"]').each(function(i){
	//tra_checkbox[i] = $(this).val();
		res_id[i] =  $(this).val();
		//alert($(this).val());
		var tra_res_arr = $("#tra_res_"+res_id[i]+":checked").val();
		if(tra_res_arr==null){
			tra_res[i] = 0;
		}else{
			tra_res[i] = tra_res_arr;
		}
	});
	/*$('input[name^="remark"]').each(function(i){
		//tra_checkbox[i] = $(this).val();
		remark[i] =  $(this).val();
		//alert($(this).val());
	});*/
	
	
	$.post("job_data.php",{
		status:"save_evaluation",
		res_id : res_id,
		tra_res : tra_res,
		remark : remark,
		group_id : group_id,
		recommend : recommend ,
		result1 : result1,
		result2 : result2,
		result3 : result3
	}).done(function(data){			
		//alert(data);
		alert("บันทึกสำเร็จ");
	});
	//alert(res_id+" "+tra_res);
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
				<div class="col-md-12" >
					<div class="panel panel-primary">
						
						<div class="panel-body">
							<div class='row'>
								<?php 
								
								?>
								<div class='col-sm-12'><h4>ครั้งที่ <?=$number?></h4></div>
								<div class='col-sm-12'>ชื่อ <?=$firstname." ".$lastname." ( ".$nickname." ) ";?> </div>
								<div class='col-sm-12'>วันที่ <?=$tra_date_format?></div>
								<div class='col-sm-12'>ผู้สอน <?=$firstname_coach." ".$lastname_coach?></div>
							</div>
							<br>
							
							<div class='row'>
								<div class="col-md-12" id='job_training' >
									<p><b>เลือกหัวข้อที่จะอบรม</b></p>
									<table class="table table-striped table-bordered" width="100%">
										<thead style="height:50px;">
											<th>ลำดับ</th>
											<th>OJT Title / หัวข้อที่สอน</th>
											<th>Description / ลักษณะงาน</th>
											<th>Form / จาก</th>
											<th>To / ถึง</th>
											<th>ชั่วโมง</th>
											<th>Pass / ผ่าน</th>
											<th>Fail / ไม่ผ่าน</th>
											<!--<th>Remark / หมายเหตุ</th>-->
										</thead>
									
									<?php
										$i = 1;
										$sql_result = "SELECT * from tbtra_result  
										WHERE  group_id = '$group_id'";
										$res_reult=mssql_query($sql_result);
										while($row_result = mssql_fetch_array($res_reult)){
											$res_id = $row_result['res_id'];
											$tra_id = $row_result['tra_id'];
											$tra_res = $row_result['tra_res'];
											$remark = $row_result['remark'];
											switch($tra_res){
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
											$sql_train = "select * from tbtra_title where tra_id='$tra_id'";
											$res_train=mssql_query($sql_train);
											while($row_train = mssql_fetch_array($res_train)){
												$tra_title = iconv("tis-620", "utf-8",$row_train['tra_title']);
												$tra_desc = iconv("tis-620", "utf-8",$row_train['tra_desc']);
												
											$sqlg = "select * from tbtra_group where group_id='$group_id'";
                                            $reg = mssql_query($sqlg);
											$numg = mssql_num_rows($reg);
											
                                           	$rowg = mssql_fetch_array($reg);
												
											//$tra_form = $row_train['tra_form'].".00";
											//$tra_to = $row_train['tra_to'].".00";
											$tra_form = $rowg['tra_time1'];
											$tra_to = $rowg['tra_time2'];
												$hours = TimeDiff($tra_form,$tra_to); 
												//$hours  = $row_train['tra_time'];
											?>
											
												<tr id="<?=$res_id?>">
													
													<td><center><?=$i?></center></td>
													<td><?=$tra_title ?></td>
													<td><?=$tra_desc ?></td>
													<td><center><?=$tra_time1 ?></center></td>
													<td><center><?=$tra_time2 ?></center></td>
													<td><center><?=$hours?></center></td>
													<td><center><input type="radio" name="tra_res_<?=$res_id?>" id="tra_res_<?=$res_id?>" value="1" <?=$check_pass?>></center></td>
													<td><center><input type="radio" name="tra_res_<?=$res_id?>" id="tra_res_<?=$res_id?>" value="2" <?=$check_fail?>></center>
														<input type="hidden" name="res_id[]" id="res_id[]" value="<?=$res_id?>" ></td>
													<!--<td><input type="text" name="remark[]" id="remark[]" value="<?=$remark?>" class="form-control" >
														</td>-->
												</tr>
										
									<?php
											}
											$i++;
										}
									?>
									</table>
								</div>
								<div class='col-sm-12'>
									<input type='hidden' name='group_id' id='group_id' value='<?=$group_id?>'>
									<div class='col-sm-6 form-horizontal'>
										<div class="form-group">
											<label class="control-label col-sm-3" for="recommend">Recommend / ข้อคิดเห็น  :</label>
											<div class="col-sm-9">
						<input type="text" class="form-control" id="recommend" name="recommend" value="<?=$recommend?>" placeholder="">
											</div>
										</div>
									</div>
									<div class='col-sm-6 form-inline'>
										<div class="form-group">
										  <label for="recommend">วิธีประเมินผลการฝึกอบรม : </label>
										  <label><input type="checkbox" class="form-control" id="result1" value='1' name="result1" <?=$result1?>>  ทำข้อสอบ</label>
										  <label><input type="checkbox" class="form-control" id="result2" value='1' name="result2" <?=$result2?>> ถามตอบ</label>
										  <label><input type="checkbox" class="form-control" id="result3" value='1' name="result3" <?=$result3?>> ดูจากการทำงานจริง</label>
										</div>
									</div>
								</div>
							</div>
							<div class='row'>
								<div class='col-sm-12'>
									<div class='pull-right'>
										<button class='btn btn-success' onclick='save_evaluation()'>Save</button>
										<a href='job_table_print.php?number=<?=$number?>&group_id=<?=$group_id?>' class='btn btn-info' target="<?=$group_id?>">Print</a>
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