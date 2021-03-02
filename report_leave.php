<? 
session_start();
include "connect.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>I-Wis HQ : Time Attendance List</title>
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
}

#tr_h{
    font-size: 18px;
}
.ui-draggable, .ui-droppable {
	background-position: top;
}

</style>
<script>

var tb_leave_list = "";
var empno = <?php echo $_SESSION['admin_userid'];?>;
var site = '<?echo $_SESSION['site']?>';
var searchstr = "";
var name_ls = "";
var name_app = "";
var emp_control = [];
var statusapprove = "";
var emp_hr = [];
var id_app = "";
var leaveid = "";
var file_att = "";
var over_annual = "";
var req_annual = 0;
var total_leave;
var re_holiday;
var s_h = 0;
var e_h = 0;
var re_holiday_s = '';
var re_holiday_e = '';
var ref = "1";
var cond;
$(function() {

	var d = new Date();
	var month = d.getMonth()+1;
	var day = d.getDate();
	var current_date =(month<10 ? '0' : '') + month + '-' +(day<10 ? '0' : '') + day;
	
	$('#s_leave').datepicker({ dateFormat: 'dd/mm/yy' }).val();
	$('#e_leave').datepicker({ dateFormat: 'dd/mm/yy' }).val();
	$('#ss_leave').datepicker({ dateFormat: 'dd/mm/yy' }).val();
	$('#ee_leave').datepicker({ dateFormat: 'dd/mm/yy' }).val();

	if(empno == '56038'){
		$.ajax({
				url: 'leave_data.php',
				type: "POST",
				async: false,
				dataType: "json",
				cache: false,
				data   : {status:'M'},
				success: function(data) {
					$("#sl_control_list").append('<option value="">พนักงานในสังกัดทั้งหมด</option>');
					if(data.length > 0){
						for(i=0;i<data.length;i++){
							emp_control.push(data[i]['empno']);
							$("#sl_control_list").append('<option value='+data[i]['empno']+'>'+data[i]['name']+'</option>');
						}
					}else{
						emp_control.push(0);
					}
					
				}
		});
	}else{
		$.ajax({
				url: 'leave_data.php',
				type: "POST",
				async: false,
				dataType: "json",
				cache: false,
				data   : {empno:empno,status:'L'},
				success: function(data) {
					var data = data['data'];
					$("#sl_control_list").append('<option value="">พนักงานในสังกัดทั้งหมด</option>');
					if(data.length > 0){
						for(i=0;i<data.length;i++){
							emp_control.push(data[i]['empno']);
							$("#sl_control_list").append('<option value='+data[i]['empno']+'>'+data[i]['name']+'</option>');
						}
					}else{
						emp_control.push(0);
					}
				}
		});
	}
	

	$.ajax({
			url: 'leave_data.php',
			type: "POST",
			async: false,
			dataType: "json",
			cache: false,
			data   : {empno:empno,status:'R'},
			success: function(data) {
				
				if(data.info['emp_level'] >= 3 || empno == '56038'){
					$("#name_ls").text(data.info['name']);
					$("#sl_control").show();
				}
				name_app = data.info['name'];
				$("#name").html("<b>ข้อมูลผู้เข้าใช้ระบบ : </b>"+data.info['name']+" <b>วันที่เข้าทำงาน : </b>"+data.info['startdate']);
			}
	});
	
	tb_leave_list = $('#tb_leave_list').DataTable( {
			"ajax": {
					url: "leave_data.php",
					type: "POST",
					async: false,
					dataType: "json",
					"data" : {
						"status" : "T",
						}
					},
			"ordering": false,
			"columns": [
						{
						  "data": "item",
						  "sTitle" : "ลำดับ",
						  "width": "2%",
						  "render": function ( data, type, full, meta ) {
						  return data;
						  }
						},
						{
						  "data": "leave_name",
						  "sTitle" : "ชื่อ - สกุล",
						  "width": "14%",
						  "render": function ( data, type, full, meta ) {
							  return data;
						  }
						},
						{
						  "data": "leave_type",
						  "sTitle" : "ประเภท",
						  "width": "4%",
						  "render": function ( data, type, full, meta ) {
							  return data;
						  }
						},
						{
						  "data": "shift",
						  "sTitle" : "กะ",
						  "width": "3%",
						  "render": function ( data, type, full, meta ) {
						  return data;
						  }
						},
						{
						  "data": "leave_create",
						  "sTitle" : "วันที่ทำรายการ",
						  "width": "9%",
						  "render": function ( data, type, full, meta ) {
						  return data;
						  }
						},
						{
						  "data": "leave_date",
						  "sTitle" : "ช่วงวันหยุด (วัน)",
						  "width": "17%",
						  "render": function ( data, type, full, meta ) {
						  return data;
						  }
						},
						{
						  "data": "reasons",
						  "sTitle" : "สาเหตุการลา",
						  "width": "25%",
						  "render": function ( data, type, full, meta ) {
						  return data;
						  }
						},
						{
						  "data": "att",
						  "sTitle" : "เอกสาร",
						  "width": "2%",
						  "render": function ( data, type, full, meta ) {
							//return '<i class="fa fa-pencil-square-o fa-2x" aria-hidden="true" onclick="edit_mat(\'' + data + '\');" style="cursor: pointer;"></i>';
							return data;
						  }
						},
						{
						  "data": "leave_status",
						  "sTitle" : "สถานะ",
						  "width": "8%",
						  "render": function ( data, type, full, meta ) {
							//return '<i class="fa fa-trash-o fa-2x" aria-hidden="true" onclick="del_mat(\'' + data + '\');" style="cursor: pointer;"></i>';
							return data;
						  }
						},
						{
						  "data": "hr",
						  "sTitle" : "ฝ่ายบุคคล",
						  "width": "8%",
						  "render": function ( data, type, full, meta ) {
							//return '<i class="fa fa-trash-o fa-2x" aria-hidden="true" onclick="del_mat(\'' + data + '\');" style="cursor: pointer;"></i>';
							return data;
						  }
						}
				   ],
			/*buttons": [
						{
							text: 'Export',
							action: function ( e, dt, node, config ) {
								//export_data();
								window.location = "export_material.php";
								//http://www.ipack-iwis.com/inv/export_material.php
							}
						}
					],    */          
			"processing": true,
			"serverSide": true,
			"searching": true,
			//"bLengthChange": false,
			"lengthChange" : false,
			//"scrollY": "1300px",
			//"lengthMenu": [25, 50, 75,100],
			//"pageLength": 5,
			"scrollCollapse": true,
			"info":     true,
			"paging":   true,
			"dom": '<"top">tr<"clear">',
			
		});
	cond = "tbleave_transaction.empno = '"+empno+"'";
	tb_leave_list.search("tbleave_transaction.empno = '"+empno+"'").draw();
	//-------------------------

	
	$('#clearData').on( 'click', function () {
		searchstr = "";
		if($("#sl_control").val() == 1){
			searchstr = "tbleave_transaction.empno = '"+empno+"'";
		}else{
			emp_control = emp_control;
			$("#sl_control_list").val("");
			searchstr = "tbleave_transaction.empno IN ("+emp_control+")";
		}
		$("#s_leave").val("");
		$("#e_leave").val("");
		$("#sl_shift").val("");
		$("#sl_typeleave").val("");
		$("#sl_status").val("");
		$("#sl_control_list").val("");
		$("#sl_hr").val("");
		cond = searchstr;
		tb_leave_list.search(searchstr).draw();
	});
	
	$('#sl_control').on('change', function(){
		if($('#sl_control').val() == 1){
			$("#sl_control_list").hide();
		}else{
			$("#sl_control_list").show();
		}
		
		searchstr = "";
		$("#s_leave").val("");
		$("#e_leave").val("");
		$("#sl_shift").val("");
		$("#sl_typeleave").val("");
		$("#sl_status").val("");
		$("#sl_hr").val("");
		
		searchstr = "";
		if($("#sl_control").val() == 1){
			searchstr = "tbleave_transaction.empno = '"+empno+"'";
			
		}else{
			var tt = "";
			
			if($("#sl_control_list").val() == ""){
				tt = emp_control;
			}else{
				tt = $("#sl_control_list").val();
			}
			
			searchstr = "tbleave_transaction.empno IN ("+tt+")";
		}
		cond = searchstr;
		tb_leave_list.search(searchstr).draw();
	});
	
});

function getParameterByName(name) {
	name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
	var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
		results = regex.exec(location.search);
	return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}

function search_tb(){
	searchstr = "";
	if($("#sl_control").val() == 1){
		searchstr = "tbleave_transaction.empno = '"+empno+"'";
		if($("#sl_typeleave").val() != ""){
			searchstr += " AND tbleave_transaction.leavetypeid = '"+$("#sl_typeleave").val()+"'";
		}
		if($("#sl_shift").val() != ""){
			searchstr += " AND tbleave_transaction.shift = '"+$("#sl_shift").val()+"'";
		}
		if($("#sl_status").val() != ""){
			searchstr += " AND tbleave_transaction.statusapprove = '"+$("#sl_status").val()+"'";
		}
		if($("#sl_hr").val() != ""){
			searchstr += " AND tbleave_transaction.hr = '"+$("#sl_hr").val()+"'";
		}
		
	}else{
		var tt = "";
		if($("#sl_control_list").val() == ""){
				tt = emp_control;
		}else{
			tt = $("#sl_control_list").val();
		}
		searchstr = "tbleave_transaction.empno IN ("+tt+")";
		
		if($("#sl_typeleave").val() != ""){
			searchstr += " AND tbleave_transaction.leavetypeid = '"+$("#sl_typeleave").val()+"'";
		}
		if($("#sl_shift").val() != ""){
			searchstr += " AND tbleave_transaction.shift = '"+$("#sl_shift").val()+"'";
		}
		if($("#sl_status").val() != ""){
			searchstr += " AND tbleave_transaction.statusapprove = '"+$("#sl_status").val()+"'";
		}
		if($("#sl_hr").val() != ""){
			searchstr += " AND tbleave_transaction.hr = '"+$("#sl_hr").val()+"'";
		}
	}
	var s_leave = $("#s_leave").val().split("/");
		s_leave = s_leave[2]+"/"+s_leave[1]+"/"+s_leave[0];
	var e_leave = $("#e_leave").val().split("/");
		e_leave = e_leave[2]+"/"+e_leave[1]+"/"+e_leave[0];
	if($("#s_leave").val() != "" && $("#e_leave").val() == ""){
		searchstr += " AND tbleave_transaction.leavestartdate >= '"+s_leave+"'";
	}
	if($("#s_leave").val() == "" && $("#e_leave").val() != ""){
		searchstr += " AND tbleave_transaction.leavestartdate <= '"+e_leave+"'";
	}
	if($("#s_leave").val() != "" && $("#e_leave").val() != ""){
		searchstr += " AND tbleave_transaction.leavestartdate >= '"+s_leave+"' AND tbleave_transaction.leavestartdate <= '"+e_leave+"'";
	}
	//console.log(searchstr);
	cond = searchstr;
	tb_leave_list.search(searchstr).draw();
}

function export_data(){
	search_tb()
	//alert(cond);6
	window.location = "export_data.php?data="+cond;
	//window.location = "export_data.php?data='33'";
}
function export_data_all(){
	var leave_year = $("#leave_year").val();
	//alert(cond);6
	window.location = "export_data_all.php?leave_year="+leave_year;
	//window.location = "export_data.php?data='33'";
}
function export_data_all2(){
	var ss_leave = $("#ss_leave").val();
	var ee_leave = $("#ee_leave").val();
	if(ss_leave==''){
		alert('Please Select Start Date');
		return false;
		}else if(ee_leave==''){
		alert('Please Select End Date');
		return false;
		}else{
			
			var arr_startdate = ss_leave.split("/");
			var arr_enddate = ee_leave.split("/");
			var ss_date = arr_startdate[1]+'/'+arr_startdate[0]+'/'+arr_startdate[2];
			var ee_date = arr_enddate[1]+'/'+arr_enddate[0]+'/'+arr_enddate[2];
			//alert(ss_date);
			//alert(ee_date);
			window.location = "export_data_all.php?ss_date="+ss_date+"&ee_date="+ee_date;
			}
	//alert(cond);6
	
	//window.location = "export_data.php?data='33'";
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

			<?php
			if($_SESSION['admin_userid']=='61001' || $_SESSION['admin_userid']=='56002' || $_SESSION['admin_userid']=='59011'){

			

			?>
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-primary">
						<div class="panel-body">
							<div class="col-md-12" >
								<h5><b>Export Data Attendance พนักงานทั้งหมด (ตามวันที่ Cut-off ของบริษัท)</b></h5>
								เลือกปี : 
								<select name="leave_year" id="leave_year">
									<?php 
									$lyear = date("Y");
									$sql_year = "SELECT * FROM tbleave_work";
									$res_year = mssql_query($sql_year);
									while($row_year = mssql_fetch_array($res_year)){
										$year = $row_year["l_years"];
										if($year==$lyear){
											?><option value="<?=$year?>" selected><?=$year?></option><?
										}else{
											?><option value="<?=$year?>" ><?=$year?></option><?
										}
										?><option value="<?=$year?>" ><?=$year?></option><?
									}
									?>
								</select>
								<button type="button" class="btn btn-info btn-sm"  onclick="export_data_all()">Export All Emp</button>
                                
						 	</div>
						</div>
					</div>
				</div>
                <div class="col-md-12">
					<div class="panel panel-primary">
						<div class="panel-body">
							<div class="col-md-12" >
								<h5><b>Export Data Attendance พนักงานทั้งหมด (ตามช่วงวันที่เลือก)</b></h5>
								เลือกช่วงวันที่ : 
								<input type="text" id="ss_leave" name="ss_leave" placeholder="วันที่(เริ่ม)"  size="15"  >
									<input type="text" id="ee_leave" name="ee_leave" placeholder="วันที่(สิ้นสุด)" size="15">&nbsp;<button type="button" class="btn btn-info btn-sm"  onclick="export_data_all2()">Export All Emp(ตามช่วงวันที่เลือก)</button>
                                
						 	</div>
						</div>
					</div>
				</div>
			</div>
            
			<?php
			}
						
			?>
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-primary">
						
						<div class="panel-body">
							 <div class="col-md-12" >
								<p id="name"></p>
								<p ><b>ระบบค้นหา : </b>
									<select id="sl_control"  class="admin" style="width: 150px;display:none;">
										<option value="1" id="name_ls"></option>
										<option value="2">พนักงานในสังกัด</option>
									</select>&nbsp;&nbsp;
									<select id="sl_control_list"  class="admin" style="width: 220px;display:none;"></select>
									<select id="sl_typeleave"  style="width: 100px;">
										<option value="">ประเภท</option>
										<option value="L0001">ลาป่วย</option>
										<option value="L0002">ลากิจ</option>
										<option value="L0003">ลาพักร้อน</option>
										<option value="L0004">ลาบวช</option>
										<option value="L0005">ลาคลอด</option>
										<option value="L0006">ขาดงาน</option>
									</select>
									<select id="sl_shift"  style="width: 50px;">
										<option value="">กะ</option>
										<option value="Day">Day</option>
										<option value="Night">Night</option>
									</select>
									<select id="sl_status"  style="width: 70px;">
										<option value="">สถานะ</option>
										<option value="New">New</option>
										<option value="approve">Approve</option>
										<option value="reject">Reject</option>
										<option value="cancel">Cancel</option>
									</select>
									<select id="sl_hr"  style="width: 90px;">
										<option value="">ฝ่ายบุคคล</option>
										<option value="New">New</option>
										<option value="approve">Approve</option>
									</select>
									<input type="text" id="s_leave" name="s_leave" placeholder="วันที่ลา(เริ่ม)"  size="15"  >
									<input type="text" id="e_leave" name="e_leave" placeholder="วันที่ลา(สิ้นสุด)" size="15"><br/>
									<button type="button" class="btn btn-success btn-sm" id="searchFired" onclick="search_tb()">ค้นหา</button>
									<button type="button" class="btn btn-warning btn-sm" id="clearData" >ยกเลิก</button>
									<button type="button" class="btn btn-info btn-sm"  onclick="export_data()">Export</button>
								</p>
								 <table id="tb_leave_list" width="100%" class="table table-striped table-bordered" cellspacing="0"></table>
							 </div>
							 <hr>
							 <div class="col-md-12" id="under" style="display:none;">
								<b id="header">รายการลาของพนักงานในสังกัด</b>
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


<div class="modal fade" id="myModalLeave" role="dialog">
	<div class="modal-dialog">
	
	  <!-- Modal content-->
	  <div class="modal-content" style="width:100%">
		<form action="" method="post" enctype="multipart/form-data" name="myform1" id="myform1" style="margin-left:10px">
			<TABLE style="height:400px;">
				<TR>
					<TD id="tr_h">ข้อมูลเบื้องต้น : </TD><TD> <b>ชื่อผู้ลา : </b><span id='model_name'></span></TD>
				</TR>
				<TR>
					<TD id="tr_h">ประเภทการลา : </TD><TD> <select id="model_type_leave" name="model_type_leave">
											<option value="L0001">ลาป่วย</option>
											<option value="L0002">ลากิจ</option>
											<option value="L0003">ลาพักร้อน</option>
											<option value="L0004">ลาบวช</option>
											<option value="L0005">ลาคลอด</option>
											<option value="L0006">ขาดงาน</option>
										  </select>
										  &nbsp;&nbsp;&nbsp;<b>กะ : </b><select id="model_shift" name="model_shift">
																		<option value="Day">Day</option>
																		<option value="Night">Night</option>
																	  </select>
										</TD>
				</TR>
				<TR>
					<TD id="tr_h">ช่วงวันหยุด : </TD><TD>  เริ่ม <input type="text" id="model_s_leave" name="model_s_leave"><select id="model_sl_s_leave">
											<option value="0">เต็มวัน</option>
											<option value="0.5">ครึงวัน</option>
										  </select>
										ถึง <input type="text" id="model_e_leave" name="model_e_leave"><select id="model_sl_e_leave">
											<option value="0">เต็มวัน</option>
											<option value="0.5">ครึงวัน</option>
										  </select>
									</TD>
				</TR>
				<TR>
					<TD id="tr_h">สาเหตุ : </TD><TD><textarea rows="4" cols="60" id="model_reasons" name="model_reasons"></textarea></TD>
				</TR>
				<TR>
					<TD id="tr_h">เอกสารแนบ : </TD><TD><input type="file" id="model_file_att" name="model_file_att"></TD>
				</TR>
				<TR>
					<TD></TD><TD><br><div id="btn_mng"></div></TD>
				</TR>
			</TABLE>
			
		</form>
	  </div>
	  
	</div>
  </div>


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