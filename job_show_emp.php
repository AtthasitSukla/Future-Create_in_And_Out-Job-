<?php 
session_start();
include("connect.php");
include("library.php");

$empno = $_GET['empno'];
$positionid = $_GET['positionid'];

$row1 = get_rec_empno($empno); 
$firstname = lang_thai_from_database($row1['firstname']);
$lastname = lang_thai_from_database($row1['lastname']);
$nickname = lang_thai_from_database($row1['nickname']);
$positionid = $row1['positionid'];
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
	var table = $('#train_list').DataTable({
        "order": [[ 0, "asc" ]],
        "pageLength": 100
    });
	var table = $('#not_train_list').DataTable({
        "order": [[ 0, "asc" ]],
        "pageLength": 100
    });
	
	
	
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
									<?php  ?>
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
								
								<div class="col-md-12" id='job_pass'>
									<div class="panel panel-success">
										<div class="panel-heading">หัวข้อที่อบรมไปแล้ว</div>
										<div class="panel-body">
											<table class="table table-striped table-bordered" id="train_list" width="100%">
												<thead style="height:50px;">
                                               		 <th>ลำดับ</th>
													<th>ครั้งที่</th>
													<th>OJT Title / หัวข้อที่สอน</th>
													<th>Description / ลักษณะงาน</th>
													<th>วันที่</th>
													<th>Form / จาก</th>
													<th>To / ถึง</th>
													<th>ชั่วโมง</th>
												</thead>
												<?php 
												$i=1;
												$igroup=0;
												$old_group_id = '';
												$sql_re = "select * from tbtra_result  INNER JOIN tbtra_group 
																ON tbtra_result.group_id = tbtra_group.group_id
														where empno='$empno' and tra_res='1' order by tra_date";
												$res_re = mssql_query($sql_re);
												while($row_re = mssql_fetch_array($res_re)){
													
													$group_id = $row_re['group_id'];
													if($old_group_id==''){
														$old_group_id = $group_id;
														$igroup++;
														}else{
															if($row_re['group_id']!=$old_group_id){
																	$old_group_id = $group_id;
																	$igroup++;
																}
																
															}
													
													$sql_g = "select * from tbtra_group where group_id='$group_id'";
													$res_g = mssql_query($sql_g);
													$row_g = mssql_fetch_array($res_g);
													$tra_form = $row_g['tra_time1'];
													$tra_to = $row_g['tra_time2'];
													
													
													$tra_id = $row_re['tra_id'];
													$tra_date = date_format_thai_from_databese($row_re['tra_date']);
													
													$sql_title = "select * from tbtra_title where tra_id='$tra_id'";
													$res_title = mssql_query($sql_title);
													$row_title = mssql_fetch_array($res_title);
													$tra_title = lang_thai_from_database($row_title['tra_title']);
													$tra_desc = lang_thai_from_database($row_title['tra_desc']);
													
													$hours = TimeDiff($tra_form,$tra_to); 
													//$hours = $hours-1;
												//$hours = $row_title['tra_time'];
													?>
													<tr>
														<td align='center'><?=$i?></td>
                                                        <td><?
                   echo "<a href='job_table.php?number=$igroup&group_id=$group_id' target='_blank'> No.$igroup </a>";
														?></td>
														<td><?=$tra_title?></td>
														<td><?=$tra_desc?></td>
														<td align='center'><?=$tra_date?></td>
														<td align='center'><?=$tra_form?></td>
														<td align='center'><?=$tra_to?></td>
														<td align='center'><?=$hours?></td>
													</tr>
												<?php
													$i++;
												}
												
												
												
												?>
											</table>
										</div>
									</div>
									
								
								</div>
								
								
							</div>
							
							<hr id="bookmark">
							
							<div class='row'>
								
								<div class="col-md-12" id='job_fail' >
									<div class="panel panel-danger">
										<div class="panel-heading">หัวข้อที่ยังไม่อบรม</div>
										<div class="panel-body">
											<table class="table table-striped table-bordered" id="not_train_list" width="100%">
												<thead>
													<th>ลำดับ</th>
													<th>OJT Title / หัวข้อที่สอน</th>
													<th>Description / ลักษณะงาน</th>
													
													<th>ชั่วโมง</th>
												</thead>
												<?php 
												$i=1;
												$sql_ojt = "SELECT title.tra_id as title_tra_id,title.tra_title,title.tra_time,title.tra_desc,title.tra_form,title.tra_to 
													FROM  tbtra_match match JOIN tbtra_title title ON match.tra_id = title.tra_id  
													WHERE  match.positionid = '$positionid'";
												$res_ojt = mssql_query($sql_ojt);
												while($row_ojt = mssql_fetch_array($res_ojt)){
													$tra_id = $row_ojt['title_tra_id'];
													
													$sql_connition = "select * from tbtra_result LEFT JOIN tbtra_group
																ON tbtra_result.group_id = tbtra_group.group_id
														where empno='$empno' and tra_id='$tra_id' and (tra_res ='1')";//เช็คว่าผ่านการอบรมหรือยัง
													$res_con = mssql_query($sql_connition);
													$found_con = mssql_num_rows($res_con);
													if($found_con ==0){
														$tra_title = lang_thai_from_database($row_ojt['tra_title']);
														$tra_desc = lang_thai_from_database($row_ojt['tra_desc']);
														$tra_form = $row_ojt['tra_form'].".00";
														$tra_to = $row_ojt['tra_to'].".00";
														//$hours = $tra_to-$tra_form; 
														$hours = $row_ojt['tra_time'];
														
												?>
													<tr>
														<td align='center'><?=$i?></td>
														<td><?=$tra_title?></td>
														<td><?=$tra_desc?></td>
														<!--<td align='center'>$tra_date</td>-->
														<!--<td align='center'><?//=$tra_form?></td>
														<td align='center'><?//=$tra_to?></td>-->
														<td align='center'><?=$hours?></td>
													</tr>
												<?php
													$i++;
													}
												}
												
												
												
												?>
											</table>
										</div>
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