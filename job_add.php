<?php 
session_start();
include("connect.php");
include("library.php");

$empno = $_GET['empno'];
$positionid = $_GET['positionid'];
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
	$( "#train_date" ).change(function() {
		console.log("train_date change");
	});
	var d = new Date();
		    var toDay = d.getDate() + '/'
        + (d.getMonth() + 1) + '/'
        + (d.getFullYear() + 543);
	
	$('#train_date').datepicker({
    dateFormat: 'dd/mm/yy',
    
    
		});

	
	
});
function move_select_checkbox(tra_id){
	//var checkbox_move = $("#checkbox_move").val();
	$("#job_add").append($("#num_"+tra_id));
	var remove_checkbox = "<center><input type='checkbox' onclick='remove_select_checkbox("+tra_id+")' id='checkbox_move[]' name='checkbox_move[]' value='"+tra_id+"' checked></center>";
	$("#checkbox_"+tra_id).html(remove_checkbox);
	//<center><input type="checkbox" onclick="remove_select_checkbox(<?=$tra_id?>)" id="checkbox_move[]" name="checkbox_move[]" value="<?=$tra_id?>" ></center>
	// id="checkbox_<?=$tra_id?>" $("#checkbox_"+tra_id).html();
	//alert(tra_id);
}
function remove_select_checkbox(tra_id){
	//alert(tra_id);
	$("#row_"+tra_id).append($("#num_"+tra_id));
	//alert(s);
	var move_checkbox = "<center><input type='checkbox' onclick='move_select_checkbox("+tra_id+")' id='checkbox_move[]' name='checkbox_move[]' value='"+tra_id+"' ></center>";
	$("#checkbox_"+tra_id).html(move_checkbox);
}
function save_train(){
	var empno = $("#empno").val();
	var trainer = $("#trainer").val();
	var train_date = $("#train_date").val();
	var tra_time1 = $("#tra_time1").val();
	var tra_time2 = $("#tra_time2").val();
	/*var tra_res = $('input[name="tra_res[]"]').serialize();
	alert(tra_res);*/
	/*var tra_res = [];
    $(':radio:checked').each(function(i){
        tra_res[i] = $(this).val();
    });
	alert(tra_res);*/
	
	var tra_checkbox = [];
	var tra_res = 0;
    $(':checkbox:checked').each(function(i){
        tra_checkbox[i] = $(this).val();
		//alert(tra_checkbox[i]);
		/*var tra_res_arr = $("#tra_res_"+tra_checkbox[i]+":checked").val();
		if(tra_res_arr==null){
			tra_res[i] = 0;
		}else{
			tra_res[i] = tra_res_arr;
		}*/
		//alert(tra_res);
		
    });
	//alert(tra_checkbox+" "+tra_res);
	if(trainer==""){
		alert("กรุณาเลือกผู้สอน");
	}else if(train_date==""){
		alert("กรุณาเลือกวันที่");
	}else if(tra_checkbox==""){
		alert("กรุณาเลือกหัวข้อที่จะอบรมอย่างน้อย 1 หัวข้อ");
	}else if(tra_time1==""){
		alert("กรุณาเลือกเวลาเริ่มอบรม");
	}else if(tra_time2==""){
		alert("กรุณาเลือกเวลาอบรบเสร็จสิ้น");
	}else{
		//alert(empno+" ผู้สอน"+trainer+" วันที่"+train_date+" อบรม"+tra_checkbox);
		$.post("job_data.php",{
			status : "add_train_each_empno",
			empno : empno,
			trainer : trainer,
			train_date : train_date,
			tra_checkbox : tra_checkbox,
			tra_res : tra_res,
			tra_time1:tra_time1,
			tra_time2:tra_time2
		},function(data){
			var rec = jQuery.parseJSON(data);
			//alert(data);
			alert("บันทึกสำเร็จ");
			window.location='job_rec.php';
		});
	}
	
	//alert(trainer);
}
function select_train_date(){
	
}
function show_training(){
	var empno = $("#empno").val();	
	var train_date = $("#train_date").val();
	// alert("test");
	if(train_date==""){
		alert("กรุณาเลือกวันที่ก่อน");
	}else{
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
	}
	
}
function test_function(){
	console.log("ddd");
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
								<div class="col-md-12" id="form_detail">
									<?php 
										$row1 = get_rec_empno($empno); 
										$firstname = iconv("tis-620", "utf-8", $row1['firstname']);
										$lastname = iconv("tis-620", "utf-8", $row1['lastname']);
										$nickname = iconv("tis-620", "utf-8", $row1['nickname']);
										?>
									<div class="form-horizontal" >
										<div class="form-group">
											<label class="control-label col-sm-2" for="emp_name">ชื่อพนักงาน : </label>
											<div class="col-sm-10">
												<input type='hidden' name='empno' id='empno' value='<?=$empno?>'>
												<h4> <?php echo $firstname." ".$lastname." ( ".$nickname." )"; ?> </h4>
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-sm-2" for="trainer">ผู้สอน : </label>
											<div class="col-sm-3">
												<select  name="trainer" id="trainer" class="form-control" >
													<option value="">เลือกผู้สอน</option>
													  <?php $sql2="select * from tbemployee where emp_level > 1 and delstatus='0'"; 
														  $res2=mssql_query($sql2);
															while($row2=mssql_fetch_array($res2)){
																$empno2 = $row2['empno'];
																$firstname2 = iconv("tis-620", "utf-8", $row2['firstname']);
																$lastname2 = iconv("tis-620", "utf-8", $row2['lastname']);
																?><option value="<?=$empno2 ?>"><?=$firstname2." ".$lastname2?></option>
													<?php	} ?>
												</select>
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-sm-2" for="train_date">วันที่อบรม : </label>
											<div class="col-sm-3">
												<input type="text" id="train_date" name="train_date" class="form-control" onchange="show_training()" readonly>
											</div>
											<div class="col-sm-2">
												<!-- <button class='btn btn-link' onclick='show_training()'>คลิกดูประวัติเก่า</button> -->
											</div>
										</div>
                                        <div class="form-group">
											<label class="control-label col-sm-2" for="train_date">เวลา เริ่มอบรม : </label>
											<div class="col-sm-3">
												<input type="time" id="tra_time1" name="tra_time1" class="form-control">
											</div>
                                            
										</div>
                                         <div class="form-group">
											<label class="control-label col-sm-2" for="train_date">เวลา เสร็จสิ้นการอบรม : </label>
											<div class="col-sm-3">
												<input type="time" id="tra_time2" name="tra_time2" class="form-control">
											</div>
                                            
										</div>
						
									</div>
								</div>
							</div>
							
							<br>
							
							
							<div class='row'>
								
								<div class="col-md-12" id='job_add'>
									<p><b>หัวข้อที่อบรม</b></p><br>
									<div class='row'>
										<b>
										<div class='col-sm-1'>
											<center>เลือก</center>
										</div>
										
										<div class='col-sm-4'>
											OJT Title / หัวข้อที่สอน
										</div>
										<div class='col-sm-6'>
											Description / ลักษณะงาน
										</div>
										
										<div class='col-sm-1'>
											ชั่วโมง
										</div>
										
										</b>
									</div>
									<hr>
								</div>
								
								<div class='col-sm-12 '>
									<br>
									<div class='pull-right'>
										<button class='btn btn-success' id='save_input' onclick='save_train()'>SAVE</button>
									</div>
								</div>
							</div>
							
							<hr id="bookmark">
							
							<div class='row'>
								
								<div class="col-md-12" id='job_standby' >
									<p><b>เลือกหัวข้อที่จะอบรม</b></p><br>
									<div class='row'>
											<b>
											<div class='col-sm-1'>
												<center>เลือก</center>
											</div>
											
											<div class='col-sm-4'>
												OJT Title / หัวข้อที่สอน
											</div>
											<div class='col-sm-6'>
												Description / ลักษณะงาน
											</div>
											
											<div class='col-sm-1'>
												ชั่วโมง
											</div>
										
											</b>
										</div>
										<hr>
									
									<?php
										$i = 1;
										$sql_job_standby = "SELECT title.tra_id as title_tra_id,title.tra_title,title.tra_desc,title.tra_form,title.tra_to ,title.tra_time 
										FROM  tbtra_match match JOIN tbtra_title title ON match.tra_id = title.tra_id  
										WHERE  match.positionid = '$positionid'";
										$res_standby=mssql_query($sql_job_standby);
										while($row_standby = mssql_fetch_array($res_standby)){
							
											$tra_id = $row_standby['title_tra_id'];
											$sql_connition = "select * from tbtra_result LEFT JOIN tbtra_group
																ON tbtra_result.group_id = tbtra_group.group_id
														where empno='$empno' and tra_id='$tra_id' and (tra_res ='1' or tra_res ='0')";//เช็คว่าเลือกไปหรือยัง
											$res_con = mssql_query($sql_connition);
											$found_con = mssql_num_rows($res_con);
											if($found_con ==0){
												$tra_title = iconv("tis-620", "utf-8",$row_standby['tra_title']);
												$tra_desc = iconv("tis-620", "utf-8",$row_standby['tra_desc']);
												$tra_form = $row_standby['tra_form'].".00";
												$tra_to = $row_standby['tra_to'].".00";
												$tra_time = $row_standby['tra_time'];
												//$hours = $tra_to-$tra_form; 
										?>
											<div class='row' id="row_<?=$tra_id?>">
												<div id="num_<?=$tra_id?>">
													<div class='col-sm-1 ' id="checkbox_<?=$tra_id?>">
														<center><input type="checkbox" onclick="move_select_checkbox(<?=$tra_id?>)" id="checkbox_move[]" name="checkbox_move[]" value="<?=$tra_id?>" ></center>
														
													</div>
													
													<div class='col-sm-4'>
														<?=$tra_title ?>
													</div>
													<div class='col-sm-6'>
														<?=$tra_desc ?>
													</div>
													
													<div class='col-sm-1'>
														<?=$tra_time?>
													</div>
													
													<br><br>
													<hr>
												</div>
												
											</div>
											
											
											
										<?php
												$i++;
											}else{
												?>
												<div class='row' id="row_<?=$tra_id?>"> <!-- สร้างรอเอาไว้กดกลับมา -->
												</div>
												<?php
											}
										}
									?>
									
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


<script type='text/javascript' src='assets/js/jqueryui_datepicker_thai_min.js'></script> 


</body>
</html>