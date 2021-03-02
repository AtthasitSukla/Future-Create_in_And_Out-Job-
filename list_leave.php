<? 
session_start();
include("connect.php");
include("library.php");
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
<!--<script type="text/javascript" src="assets/js/jquery-1.10.2.min.js"></script>-->
<script src="https://code.jquery.com/jquery-2.2.0.min.js"></script> 
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
//var tb_leave_count = "";
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
$(function() {
	
	

	var d = new Date();
	var month = d.getMonth()+1;
	var day = d.getDate();
	var current_date =(month<10 ? '0' : '') + month + '-' +(day<10 ? '0' : '') + day;
	
	$('#s_leave').datepicker({ dateFormat: 'dd/mm/yy' }).val();
	$('#model_s_leave').datepicker({ dateFormat: 'dd/mm/yy' }).val();
	$('#model_e_leave').datepicker({ dateFormat: 'dd/mm/yy' }).val();
	if(empno == '56038'){
		$.ajax({
				url: 'leave_data.php',
				type: "POST",
				async: false,
				dataType: "json",
				cache: false,
				data   : {status:'K'},
				success: function(data) {
					emp_hr = data;
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
				$("#name").text(data.info['name']);
				$("#startdate").text(data.info['startdate']);
				$("#position").text(data.info['position']);
				if(data.info['count'] < 365){
					$("#total_annual").text('0.00');
					$("#remain_annual").text('0.00');
					$("#use_annual").text('0.00');
					$("#type_leave option[value='L0003']").attr("disabled", "disabled"); 
					$("#type_leave option[value='L0004']").attr("disabled", "disabled"); 
				}
				if(data.info['count'] >= 365){
					remain_annual = data.data[1];
					$("#total_annual").text(data.data[0]);
					$("#remain_annual").text(data.data[1]);
					$("#use_annual").text(data.data[2]);
					over_annual = data.data[3];
				}
				if(current_date >= '12/21' && current_date <= '12/31'){
					$("#type_leave option[value='L0003']").attr("disabled", "disabled"); 
				}
			}
	});
	
	
	$.ajax({
			url: 'leave_data.php',
			type: "POST",
			async: false,
			dataType: "json",
			cache: false,
			data   : {empno:empno,status:'R'},
			success: function(data) {
				console.log(data.info['emp_level']);
				//if(data.info['emp_level'] >= 3 || empno == '56038' || empno == '57001'){
				if(data.info['emp_level'] >= 3 || empno == '56038' ){
					$("#name_ls").text(data.info['name']);
					$("#sl_control").show();
				}
				name_app = data.info['name'];
				$("#name").html("<b>ข้อมูลผู้เข้าใช้ระบบ : </b>"+data.info['name']+" <b>วันที่เข้าทำงาน : </b>"+data.info['startdate']);
			}
	});
	
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
				if(data.length > 0 ){
					for(i=0;i<data.length;i++){
						emp_control.push(data[i]['empno']);
						$("#sl_control_list").append('<option value='+data[i]['empno']+'>'+data[i]['name']+'</option>');
					}
				}else{
					emp_control.push(0);
				}
				
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
						},
						{
						  "data": "leave_action",
						  "sTitle" : "Action",
						  "width": "2%",
						  "render": function ( data, type, full, meta ) {
							return '<i class="fa fa-pencil-square-o fa-2x" aria-hidden="true" onclick="mng_leave(\'' + data + '\');" style="cursor: pointer;"></i>';
							//return data;
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
	tb_leave_list.search("tbleave_transaction.empno = '"+empno+"' and tbleave_transaction.leavestartdate between "+$("#sl_year").val()+"").draw();
	
	//-------------------------
	//show_data();
	$('#searchFired').on( 'click', function () {
		/*searchstr = "";
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
			if($("#s_leave").val() != ""){
				var s_leave = $("#s_leave").val().split("/");
				s_leave = s_leave[2]+"/"+s_leave[1]+"/"+s_leave[0];
				searchstr += " AND tbleave_transaction.createdate = '"+s_leave+"'";
			}
		}else{
			var tt = "";
			if($("#sl_control_list").val() == ""){
				if(empno == '56038'){
					tt = emp_hr;
				}else{
					tt = emp_control;
				}
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
			if($("#s_leave").val() != ""){
				var s_leave = $("#s_leave").val().split("/");
				s_leave = s_leave[2]+"/"+s_leave[1]+"/"+s_leave[0];
				searchstr += " AND tbleave_transaction.createdate = '"+s_leave+"'";
			}
			
		}
		//console.log(searchstr);
		
		tb_leave_list.search(searchstr).draw();
		*/
	});
	
	
	
	
	
	$('#clearData').on( 'click', function () {
		searchstr = "";
		if($("#sl_control").val() == 1){
			searchstr = "tbleave_transaction.empno = '"+empno+"'";
		}else{
			if(empno == '56038'){
				emp_control = emp_hr;
			}else{
				emp_control = emp_control;
			}
			$("#sl_control_list").val("");
			searchstr = "tbleave_transaction.empno IN ("+emp_control+")";
		}
		$("#s_leave").val("");
		$("#sl_shift").val("");
		$("#sl_typeleave").val("");
		$("#sl_status").val("");
		$("#sl_control_list").val("");
		$("#sl_hr").val("");
		//$("#sl_control_list").hide();
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
		$("#sl_shift").val("");
		$("#sl_typeleave").val("");
		$("#sl_status").val("");
		$("#sl_hr").val("");
		
		searchstr = "";
		if($("#sl_control").val() == 1){
			searchstr = "tbleave_transaction.empno = '"+empno+"' and tbleave_transaction.leavestartdate between "+$("#sl_year").val()+"";
			
		}else{
			var tt = "";
			
			if($("#sl_control_list").val() == ""){
				if(empno == '56038'){
					tt = emp_hr;
				}else{
					tt = emp_control;
				}
			}else{
				tt = $("#sl_control_list").val();
			}
			
			searchstr = "tbleave_transaction.empno IN ("+tt+") and tbleave_transaction.leavestartdate between "+$("#sl_year").val()+"";
		}
		
		tb_leave_list.search(searchstr).draw();
	});
	
	$("form#myform1").submit(function(event){
		
		if($("#sl_control").val() == 1){
			searchstr = "tbleave_transaction.empno = '"+empno+"'  and tbleave_transaction.leavestartdate between "+$("#sl_year").val()+"";
			
		}else{
			var tt = "";
			
			if($("#sl_control_list").val() == ""){
				if(empno == '56038'){
					tt = emp_hr;
				}else{
					tt = emp_control;
				}
			}else{
				tt = $("#sl_control_list").val();
			}
			
			searchstr = "tbleave_transaction.empno IN ("+tt+")";
		}
		$("#myModalLeave").modal('hide');
		event.preventDefault();//คำสั่งที่ใช้หยุดการเกิดเหตุการณ์ใดๆขึ้น
		//alert("บันทึกข้สอมูลสำเร็จ");
		
		if($("#sl_control").val() == '1'){
			//แก้ไขตนเอง
			//--------------------------------------------------------------------------------
			
			var re_over_annual = '';
			if($("#model_s_leave").val() == ""){
				$("#model_s_leave").focus();return false;
			}
			if($("#model_e_leave").val() == ""){
				$("#model_e_leave").focus();return false;
			}

			if($("#reasons").val() == ""){
				$("#reasons").focus();return false;
			}
			
			var model_s_leave = $("#model_s_leave").val().split("/");
			var model_e_leave = $("#model_e_leave").val().split("/");
			req_annual = 0;
			s_h = 0;
			e_h = 0;
			re_over_annual = over_annual.split("/");
			model_s_leave = new Date($.datepicker.formatDate( "yy-mm-dd", new Date( model_s_leave[2], model_s_leave[1] - 1, model_s_leave[0] ) ));
			model_e_leave = new Date($.datepicker.formatDate( "yy-mm-dd", new Date( model_e_leave[2], model_e_leave[1] - 1, model_e_leave[0] ) ));
			re_over_annual = new Date($.datepicker.formatDate( "yy-mm-dd", new Date( re_over_annual[2], re_over_annual[1] - 1, re_over_annual[0] ) ));
			if(model_s_leave > model_e_leave){
				alert('วันที่เริ่ม - สิ้นสุด ไม่ถูกต้อง กรุณาเลือกวันที่ใหม่อีกครั้ง');
				$("#model_s_leave").focus();return false;
			}
			
			$.ajax({
				url: 'leave_data.php',
				type: "POST",
				async: false,
				dataType: "json",
				cache: false,
				data   : {s_leave:$("#model_s_leave").val(),e_leave:$("#model_e_leave").val(),status:'C',site:site},
				success: function(data) {
					re_holiday_s = '';
					re_holiday_e = '';
					re_holiday = data[0];
					if(data[1] != 0){
						var data_s = data[1].split("-");
						re_holiday_s = data_s[2]+"/"+data_s[1]+"/"+data_s[0];
					}
					if(data[2] != 0){
						var data_e = data[2].split("-");
						re_holiday_e = data_e[2]+"/"+data_e[1]+"/"+data_e[0];
					}
				}
						
			});
			if(re_holiday_s != $("#model_s_leave").val()){
				s_h = parseFloat($("#model_sl_s_leave").val());
			}
			if(re_holiday_e != $("#model_e_leave").val()){
				e_h = parseFloat($("#model_sl_e_leave").val());
			}
			
			req_annual = ((model_e_leave - model_s_leave)/(1000*60*60*24))+1;
			console.log(req_annual+"--"+re_holiday+"--"+s_h+"--"+e_h);
			total_leave = req_annual - re_holiday - s_h - e_h;
			if(total_leave == 0){
				alert('จำนวนวันลาไม่ถูกต้อง กรุณาเลือกวันที่ใหม่อีกครั้ง')
				$("#model_e_leave").focus();return false;
			}
			//ตรวจสอบสิทธิพักร้อนเท่านั้น
			if($("#type_leave").val() == "L0003"){
				if(remain_annual < total_leave){
					alert('จำนวนวันพักร้อนไม่พอ กรุณาเลือกวันที่ใหม่อีกครั้ง')
					$("#model_e_leave").focus();return false;
				}
			}
			
			//alert($("#empno_edit").val());
			var formData = new FormData($(this)[0]);
			formData.append("status",'U');
			formData.append("id", id_app);
			formData.append("leaveid", leaveid);
			formData.append("empno_edit", $("#empno_edit").val());
			formData.append("file_att", file_att);
			formData.append("total_leave",total_leave);
			formData.append("model_sl_s_leave",$("#model_sl_s_leave").val());
			formData.append("model_sl_e_leave",$("#model_sl_e_leave").val());
			$.ajax({
					url: 'leave_data.php',
					type: "POST",
					async: false,
					cache: false,
					contentType: false,
					processData: false,
					data   : formData,
					success: function(data) {
					//alert(data);	
						//return false;
				var aa =data;
				 var bb = aa.split("###",150);
				 sendmail(bb[0],bb[1],bb[2],bb[3],bb[4],bb[5],bb[6]);
					}
			});
			
			//--------------------------------------------------------------------------------
		}else{
			if(empno != "56038"){
				//approve---------------------------
				$.ajax({
						url: 'leave_data.php',
						type: "POST",
						async: false,
						dataType: "json",
						cache: false,
						data   : {id:id_app,status:'J',type:"Approve",name_app:name_app},
						success: function(data) {
						}
				});
			}
			if (empno == "56038"){
				//hr----------------------------------
				var formData = new FormData($(this)[0]);
				formData.append("status", "H");
				formData.append("id", id_app);
				formData.append("leaveid", leaveid);
				formData.append("file_att", file_att);
				$.ajax({
							url: 'leave_data.php',
							type: 'POST',
							data: formData,
							async: false,
							cache: false,
							contentType: false,
							processData: false,
							success: function (returndata) {
								
						}
				});
				id_app = "";
				leaveid = "";
				file_att = "";
				$("#model_file_att").val('');
			}

		}
		//tb_leave_list.search(searchstr).draw();
		search_tb();
	});
	ref = getParameterByName('ref');
	if(ref == '1'){
		$("#sl_control_list").show();
		if(empno == '56038'){
			$('#sl_hr option[value="New"]').prop("selected", "selected");
		}else{
			$('#sl_status option[value="New"]').prop("selected", "selected");
		}
		$('#sl_control option[value="2"]').prop("selected", "selected");
		search_tb();
	}
	
	
	
	
	show_leavecount();
	
});



function sendmail(mailtype,empno,type_leave,s_leave,e_leave,reasons,empno_edit){
	$.post( "getajax_sendmail.php", { 	
	status: "send_mail", 
	empno: empno,
	type_leave: type_leave,
	s_leave: s_leave,
	e_leave: e_leave,
	reasons: reasons,
	empno_edit: empno_edit,
	mailtype:mailtype,
	sid: Math.random() 
	})
	.done(function( data ) {
		 $("#myModalLeave").modal('hide');
				alert('บันทึกข้อมูลสำเร็จ กรุณาตรวจสอบข้อมูลอีกครั้ง');
				 window.location = "list_leave.php";
		});
	}


function uploadfile_leave(leaveid){
	
	var formData = new FormData();
formData.append('file', $('#model_file_att')[0].files[0]);
formData.append('leaveid', leaveid);
formData.append('status', 'uploadfile_leave');
$.ajax({
       url : 'leave_data.php',
       type : 'POST',
       data : formData,
       processData: false,  // tell jQuery not to process the data
       contentType: false,  // tell jQuery not to set contentType
       success : function(data) {
           console.log(data);
           alert('upload complete');
		   $("#myModalLeave").modal('hide');
       }
});
	}

function show_leavecount(){
	//alert($("#sl_year").val());
	var sl_year2= $("#sl_year option:selected").text();
	//$(this).find('option:selected').attr("name");
	$("#tb_leave_count").html("");
	$.post( "leave_data.php", { 	
	status: "show_leavecount", 
	sl_control: $("#sl_control").val(),
	sl_control_list:$("#sl_control_list").val(),
	sl_year: $("#sl_year").val(),
	sl_year2:sl_year2,
	sid: Math.random() 
	})
	.done(function( data ) {
			$("#tb_leave_count").html(data);
		});
}



function getParameterByName(name) {
	name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
	var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
		results = regex.exec(location.search);
	return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}

function search_tb(){
	show_leavecount();
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
		if($("#s_leave").val() != ""){
			var s_leave = $("#s_leave").val().split("/");
			s_leave = s_leave[2]+"/"+s_leave[1]+"/"+s_leave[0];
			searchstr += " AND tbleave_transaction.leavestartdate = '"+s_leave+"'";
		}
		if($("#sl_year").val() != ""){
			searchstr += " AND tbleave_transaction.leavestartdate between "+$("#sl_year").val()+" ";
		}
	}else{
		var tt = "";
		if($("#sl_control_list").val() == ""){
			if(empno == '56038'){
				tt = emp_hr;
			}else{
				tt = emp_control;
			}
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
		if($("#s_leave").val() != ""){
			var s_leave = $("#s_leave").val().split("/");
			s_leave = s_leave[2]+"/"+s_leave[1]+"/"+s_leave[0];
			searchstr += " AND tbleave_transaction.leavestartdate = '"+s_leave+"'";
		}
		if($("#sl_year").val() != ""){
			searchstr += " AND tbleave_transaction.leavestartdate between "+$("#sl_year").val()+" ";
		}
		
	}
	
	tb_leave_list.search(searchstr).draw();
}

function close_leave(){
	$("#myModalLeave").modal('hide');
}
function status_leave(type,id){
	var status = 'Cancel';
	if(type == '2'){
		status = 'Reject';
	}
	var reasons_reject = $("#model_reasons_reject").val();
	
	$.ajax({
			url: 'leave_data.php',
			type: "POST",
			data   : {id:id,status:'J',type:status,name_app:name_app,reasons_reject:reasons_reject},
			success: function(data) {
				alert("บันทึกข้อมูลสำเร็จ");
				$("#myModalLeave").modal('hide');
			}
	});
	/*if($("#sl_control").val() == 1){
		searchstr = "tbleave_transaction.empno = '"+empno+"'";
		
	}else{
		var tt = "";
		
		if($("#sl_control_list").val() == ""){
			if(empno == '56038'){
				tt = emp_hr;
			}else{
				tt = emp_control;
			}
		}else{
			tt = $("#sl_control_list").val();
		}
		
		searchstr = "tbleave_transaction.empno IN ("+tt+")";
	}*/
	
	//tb_leave_list.search(searchstr).draw();
	search_tb();
}
function mng_leave(data){
	$("#myModalLeave").modal('show');
	$("#model_type_leave").removeProp("selected");
	$("#model_shift").removeProp("selected");
	$("#model_sl_s_leave").removeProp("selected");
	$("#model_sl_e_leave").removeProp("selected");
	$("#model_file_att").val("");
	var btn_mng = "";
	var data = data.split(",");
	$.ajax({
			url: 'leave_data.php',
			type: "POST",
			async: false,
			dataType: "json",
			cache: false,
			data   : {id:data[0],status:'Q'},
			success: function(data) {
				var data = data['data'];
				console.log(data);
				statusapprove = data['statusapprove'];
				leaveid = data['leaveid'];
				
				file_att = data['att'];
				$("#model_name").text(data['leave_name']);
				$("#empno_name").val(data['leave_name']);
				//$('#model_type_leave option[value='+ data['leave_type'] +']').attr("selected",true);
				$('#model_type_leave option[value='+ data['leave_type'] +']').prop("selected", "selected");
			
				$('#model_shift option[value='+ data['shift'] +']').prop("selected", "selected");
				$("#model_s_leave").val(data['leavestartdate']);
				$('#model_sl_s_leave option[value="'+ data['leavestarttime'] +'"]').prop("selected", "selected");
				$("#model_e_leave").val(data['leaveenddate']);
				$('#model_sl_e_leave option[value="'+ data['leaveendtime'] +'"]').prop("selected", "selected");
				$("#model_reasons").val(data['reasons']);
				$("#model_reasons_reject").val(data['reasons_reject']);

				if(data['leave_type']=="L0009"){
					var start_time = "<input type='time' id='start_time' name='start_time' value="+data['start_time']+" required>";
					var end_time = "<input type='time' id='end_time' name='end_time' value="+data['end_time']+" required>";
					$("#model_start_time").html(start_time);
					$("#model_end_time").html(end_time);
					//alert("ss");
				}else{
					var start_time = "<select id='model_sl_s_leave'><option value='0'>เต็มวัน</option><option value='0.5'>ครึงวัน</option></select>";
					var end_time = "<select id='model_sl_e_leave'><option value='0'>เต็มวัน</option><option value='0.5'>ครึงวัน</option></select>";
					$("#model_start_time").html(start_time);
					$("#model_end_time").html(end_time);
					$('#model_sl_s_leave option[value="'+ data['leavestarttime'] +'"]').prop("selected", "selected");
					$('#model_sl_e_leave option[value="'+ data['leaveendtime'] +'"]').prop("selected", "selected");
					//alert("DD");
				}

				$("#empno_edit").val(data['empno']);
				id_app = data['id'];
				if($("#sl_control").val() == '1'){
					if((empno == data['empno_leave']) && (data['statusapprove'] == "New")){
						$("#model_type_leave").prop('disabled', false);
						$("#model_shift").prop('disabled', false);
						$("#model_sl_s_leave").prop('disabled', false);
						$("#model_sl_e_leave").prop('disabled', false);
						$("#start_time").prop('disabled', false);
						$("#end_time").prop('disabled', false);
						$("#model_s_leave").prop('disabled', false);
						$("#model_e_leave").prop('disabled', false);
						$("#model_reasons").prop('disabled', false);
						btn_mng = '<input type="submit" class="btn btn-primary" value="บันทึกการแก้ไข">    <input type="button" class="btn btn-warning" id= "cancel_modal" onclick="status_leave(1,'+data['id']+')" value="ยกเลิกการลา"> <input type="button" class="btn btn-danger" id= "close_modal" onclick="close_leave()" value="ปิด">';
					}
					if((empno == data['empno_leave']) && (data['statusapprove'] != "New")){
						$("#model_type_leave").prop('disabled', true);
						$("#model_shift").prop('disabled', true);
						$("#model_sl_s_leave").prop('disabled', true);
						$("#model_sl_e_leave").prop('disabled', true);
						$("#start_time").prop('disabled', true);
						$("#end_time").prop('disabled', true);
						$("#model_s_leave").prop('disabled', true);
						$("#model_e_leave").prop('disabled', true);
						$("#model_reasons").prop('disabled', true);
						//btn_mng = '<input type="button" class="btn btn-primary" value="บันทึกอัพโหลดไฟล์" onclick="uploadfile_leave("'+leaveid+'");">    <input type="button" class="btn btn-danger" id= "close_modal" onclick="close_leave()" value="ปิด">';
						btn_mng = "<input type='button' class='btn btn-primary' value='บันทึกอัพโหลดไฟล์' onclick=uploadfile_leave('"+leaveid+"');>    <input type='button' class='btn btn-danger' id= 'close_modal' onclick='close_leave()' value='ปิด'>";
					}
				}else{
					if((empno != "56038") && (data['statusapprove'] == "New")){
						$("#model_type_leave").prop('disabled', true);
						$("#model_shift").prop('disabled', true);
						$("#model_sl_s_leave").prop('disabled', true);
						$("#model_sl_e_leave").prop('disabled', true);
						$("#start_time").prop('disabled', true);
						$("#end_time").prop('disabled', true);
						$("#model_s_leave").prop('disabled', true);
						$("#model_e_leave").prop('disabled', true);
						$("#model_reasons").prop('disabled', true);
						$("#model_reasons_reject").prop('disabled', true);
						btn_mng = '<input type="submit" class="btn btn-primary" value="Approve"> <input type="button" class="btn btn-warning" id= "reject_modal" onclick="status_leave(2,'+data['id']+')" value="Reject">  <input type="button" class="btn btn-danger" id= "close_modal" onclick="close_leave()" value="ปิด">';
					}
					if((empno != "56038") && (data['statusapprove'] != "New")){
						$("#model_type_leave").prop('disabled', true);
						$("#model_shift").prop('disabled', true);
						$("#model_sl_s_leave").prop('disabled', true);
						$("#model_sl_e_leave").prop('disabled', true);
						$("#start_time").prop('disabled', true);
						$("#end_time").prop('disabled', true);
						$("#model_s_leave").prop('disabled', true);
						$("#model_e_leave").prop('disabled', true);
						$("#model_reasons").prop('disabled', true);
						$("#model_reasons_reject").prop('disabled', false);
						btn_mng = '<input type="button" class="btn btn-warning" id= "reject_modal" onclick="status_leave(2,'+data['id']+')" value="Reject"> <input type="button" class="btn btn-danger" id= "close_modal" onclick="close_leave()" value="ปิด">';
					}
					if (empno == "56038"){
						$("#model_type_leave").prop('disabled', true);
						$("#model_shift").prop('disabled', true);
						$("#model_sl_s_leave").prop('disabled', true);
						$("#model_sl_e_leave").prop('disabled', true);
						$("#start_time").prop('disabled', true);
						$("#end_time").prop('disabled', true);
						$("#model_s_leave").prop('disabled', true);
						$("#model_e_leave").prop('disabled', true);
						$("#model_reasons").prop('disabled', true);
						btn_mng = '<input type="submit" class="btn btn-primary" value="รับทราบ/บันทึกไฟล์">  <input type="button" class="btn btn-danger" id= "close_modal" onclick="close_leave()" value="ปิด">';
					}
		
				}
			}
	});
	$("#btn_mng").html(btn_mng);
}
function type_leave_change(){
	var type_leave = $("#type_leave").val();
	
		$.post( "leave_data.php", { 	
			status: "type_leave_change",
			type_leave : type_leave
			})
		.done(function( data ) {
			var aa =data;
			var bb = aa.split("###",150);
			$("#model_start_time").html(bb[0]);
			$("#model_end_time").html(bb[1]);
		});
	
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
				<div class="col-md-12">
					<div class="panel panel-primary">
						
						<div class="panel-body">
							 <div class="col-md-12" >
								<p id="name"></p>
								<p ><b>ระบบค้นหา : </b>
									<select id="sl_control"  class="admin" style="width: 150px;display:none;" onChange="show_leavecount();">
										<option value="1" id="name_ls"></option>
										<option value="2">พนักงานในสังกัด</option>
									</select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<select id="sl_control_list"  class="admin" style="width: 220px;display:none;" ></select>
									<select id="sl_typeleave"  style="width: 100px;">
										<option value="">ประเภท</option>
										<?php
										$sql ="select * from tbleavetype";
										$res= mssql_query($sql);
										while($row = mssql_fetch_array($res)){
											$leavetypeid = $row['leavetypeid'];
											$leavename =lang_thai_from_database($row['leavename']);
											?>
											<option value="<?=$leavetypeid?>"><?=$leavename?></option>
											
											<?php
											
										}
										?>
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
									<input type="text" id="s_leave" name="s_leave" placeholder="วันที่ลา">
                                    <select id="sl_year"  style="width: 90px;">
										<option value="">เลือกปี</option>
                                        <?
                            $now_date = date("Y-m-d");
							$select_y="select TOP(1) * from tbleave_work where e_date >= '$now_date' ";
							$re_y=mssql_query($select_y);
							$row_y=mssql_fetch_array($re_y);
							$l_year = $row_y['l_years'];
							
							$select_yy="select  l_years,convert(varchar, s_date, 101)as  s_date,convert(varchar, e_date, 101)as  e_date from tbleave_work order by l_years ";
							$re_yy=mssql_query($select_yy);
							while($row_yy=mssql_fetch_array($re_yy)){
								?>
									<option value="'<?=$row_yy['s_date']?>' and '<?=$row_yy['e_date']?>'" <?
                                    if($l_year==$row_yy['l_years']){
										?> selected<?
										}
									?>><?=$row_yy['l_years']?></option>
								<?
								}
										?>
										
									
									</select>
									<button type="button" class="btn btn-success btn-sm" id="searchFired" onclick="search_tb()">ค้นหา</button>
									<button type="button" class="btn btn-warning btn-sm" id="clearData" >ยกเลิก</button>
								</p>
                                <div id="tb_leave_count"></div>
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


<div class="modal fade" id="myModalLeave" role="dialog" >
	<div class="modal-dialog" style="width:700px">
	
	  <!-- Modal content-->
	  <div class="modal-content" style="width:100%">
		<form action="" method="post" enctype="multipart/form-data" name="myform1" id="myform1" style="margin-left:10px">
			<TABLE style="height:400px;">
				<TR>
					<TD id="tr_h">ข้อมูลเบื้องต้น : </TD><TD> <b>ชื่อผู้ลา : </b><span id='model_name'></span><input type="hidden" name="empno_name" id="empno_name"><input type="hidden" name="empno_edit" id="empno_edit"></TD>
				</TR>
				<TR>
					<TD id="tr_h">ประเภทการลา : </TD><TD> 
											<select id="model_type_leave" name="model_type_leave" onchange="type_leave_change()">
										<?php
										$sql ="select * from tbleavetype";
										$res= mssql_query($sql);
										while($row = mssql_fetch_array($res)){
											$leavetypeid = $row['leavetypeid'];
											$leavename =lang_thai_from_database($row['leavename']);
											?>
											<option value="<?=$leavetypeid?>"><?=$leavename?></option>
											
											<?php
											
										}
										?>
										  </select>
										  &nbsp;&nbsp;&nbsp;<b>กะ : </b><select id="model_shift" name="model_shift">
																		<option value="Day">Day</option>
																		<option value="Night">Night</option>
																	  </select>
										</TD>
				</TR>
				<TR>
					<TD id="tr_h">ช่วงวันหยุด : </TD><TD>  เริ่ม <input type="text" id="model_s_leave" name="model_s_leave">
										<span id="model_start_time">
											<select id="model_sl_s_leave">
												<option value="0">เต็มวัน</option>
												<option value="0.5">ครึงวัน</option>
											</select>
										</span>
										ถึง <input type="text" id="model_e_leave" name="model_e_leave">
										<span id="model_end_time">
											<select id="model_sl_e_leave">
												<option value="0">เต็มวัน</option>
												<option value="0.5">ครึงวัน</option>
											</select>
										</span>
									</TD>
				</TR>
				<TR>
					<TD id="tr_h">สาเหตุ : </TD><TD><textarea rows="4" cols="60" id="model_reasons" name="model_reasons"></textarea></TD>
				</TR>
               
				<TR>
					<TD id="tr_h">เอกสารแนบ : </TD><TD><input type="file" id="model_file_att" name="model_file_att"></TD>
				</TR>
                 <TR>
					<TD id="tr_h">เหตุผลการยกเลิก<BR>(สำหรับหัวหน้างาน) : </TD><TD><textarea rows="4" cols="60" id="model_reasons_reject" name="model_reasons_reject"></textarea></TD>
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