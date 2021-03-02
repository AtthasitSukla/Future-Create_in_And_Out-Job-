<?php
session_start();
include("connect.php");
include("library.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Hrs : Traning</title>
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

</style>
<script>
var tb_job_train = "";
$(function() {
	var d = new Date();
		    var toDay = d.getDate() + '/'
        + (d.getMonth() + 1) + '/'
        + (d.getFullYear() + 543);
	
	$('#start_date').datepicker({ 
		dateFormat: 'dd/mm/yy'
		
	});
	$('#end_date').datepicker({
		dateFormat: 'dd/mm/yy' 
	});
	
	function toTimestamp(strDate){
	 var datum = Date.parse(strDate);
	 return datum/1000;
	}
	//show_probation();
	$("form#myform1").submit(function(event){
		//alert("Save");
		var course_id = $("#course_id").val();
		//alert(course_id);
		var course_title = $("#course_title").val();
		var coach = $("#coach").val();
		var institution = $("#institution").val();
		var start_date = $("#start_date").val();
		var end_date = $("#end_date").val();
		var time =  $("#time").val();
		var place =  $("#place").val();
		event.preventDefault();//คำสั่งที่ใช้หยุดการเกิดเหตุการณ์ใดๆขึ้น
		
		if(course_title == ""){
			$("#course_title").focus();
			return false;
		}
		if(coach == ""){
			$("#coach").focus();
			return false;
		}
		if(institution == ""){
			$("#institution").focus();
			return false;
		}
		if(start_date==""){
			$("#start_date").focus();
			return false;
		}else if(to_timestamp(start_date) > to_timestamp(end_date)){
			alert('กรุณาเลือกวันที่เริ่มมากกว่าสิ้นสุด');
			return false;
		}
		
		if(time == ""){
			$("#time").focus();
			return false;
		}
		if(place == ""){
			$("#place").focus();
			return false;
		}
		//var formData = new FormData($(this)[0]);
		/*if(course_id == '0'){
			var status = "insert_coures";
		}else{
			var status = "update_coures";
		}*/
		/*formData.append("time_start",parseFloat($("#time_start").val()));
		formData.append("time_end",parseFloat($("#time_end").val()));*/
		/*$.ajax({
			url: 'job_data.php',
			type: "POST",
			async: false,
			cache: false,
			dataType: "json",
			contentType: false,
			processData: false,
			data: formData,
			success: function (data) {
				
			}
		});*/
		$.post("job_data.php",{
			status : "coures_list",
			course_id :course_id,
			course_title : course_title,
			coach : coach,
			institution : institution,
			start_date : start_date,
			end_date : end_date,
			time : time,
			place : place
		}).done(function(data){			
			//alert(data);
		})
		tb_job_train.search('').draw();
		$("#course_title").val("");
		$("#coach").val("");
		$("#institution").val("");
		$("#start_date").val("");
		$("#end_date").val("");
		$("#time").val("");
		$("#place").val("");
		$("#myModalCoures").modal('hide');
		$("#course_id").val('0');
		//$("#sl_dep").prop('disabled', false);
		//$("#show_pos").show();
		 tb_job_train.ajax.reload();
	});
	
	$('#btn_search_c').on( 'click', function () {
		$("#txt_search").val("");
		tb_job_train.search('').draw();
	});
	
	$('#btn_search').on( 'click', function () {
		tb_job_train.search($("#txt_search").val()).draw();
	});
	
	$('#btn_cancel').on( 'click', function () {
		$("#course_title").val("");
		$("#coach").val("");
		$("#institution").val("");
		$("#start_date").val("");
		$("#end_date").val("");
		$("#time").val("");
		$("#place").val("");
		$("#myModalCoures").modal('hide');
		$("#course_id").val('0');
		$("#myModalCoures").modal('hide');
		$("#show_pos").show();
		
	});
	
	
	tb_job_train = $('#tb_job_train').DataTable( {
			"ajax": {
					url: "job_data.php",
					type: "POST",
					async: false,
					dataType: "json",
					"data" : {
						"status" : "show_coures",
						}
					},
			"ordering": false,
			"columns": [
						{
						  "data": "item",
						  "sTitle" : "ลำดับ",
						  "width": "3%",
						  "render": function ( data, type, full, meta ) {
						  return data;
						  }
						},
						{
						  "data": "title",
						  "sTitle" : "หัวข้อการฝึกอบรม",
						  "width": "25%",
						  "render": function ( data, type, full, meta ) {
						  return data;
						  }
						},
						/*{
						  "data": "institution",
						  "sTitle" : "สถาบัน",
						  "width": "20%",
						  "render": function ( data, type, full, meta ) {
							  return data;
						  }
						},*/
						{
						  "data": "institution",
						  "sTitle" : "สถาบัน",
						  "width": "20%",
						  "render": function ( data, type, full, meta ) {
							  return data;
						  }
						},
						{
						  "data": "date",
						  "sTitle" : "วันที่ฝึกอบรม",
						  "width": "15%",
						  "render": function ( data, type, full, meta ) {
							  return data;
						  }
						},
						{
						  "data": "time",
						  "sTitle" : "เวลา",
						  "width": "10%",
						  "render": function ( data, type, full, meta ) {
						  return data;
						  }
						},
						{
						  "data": "empno_training",
						  "sTitle" : "คนที่้เรียนทั้งหมด",
						  "width": "7%",
						  "render": function ( data, type, full, meta ) {
						  return data;
						  }
						},
						{
						  "data": "edit",
						  "sTitle" : "Edit",
						  "width": "5%",
						  "render": function ( data, type, full, meta ) {
						  return data;
						  }
						}
				   ],
         
			"processing": true,
			"serverSide": true,
			"searching": true,
			"lengthChange" : false,
			"scrollCollapse": true,
			"info":     true,
			"paging":   true,
			"dom": '<"top">tr<"clear">',
			
		});
});
function to_timestamp(myDate){
	myDate=myDate.split("/");
	var newDate=myDate[1]+"/"+myDate[0]+"/"+myDate[2];
	return new Date(newDate).getTime();
}

function add_title(id){
	$("#course_id").val(id);
	if(id > 0){
		$.post("job_data.php",{
			status:"show_modal_edit",
			course_id : id
		}).done(function(data){	
			var rec = jQuery.parseJSON(data);
			//alert(rec.coach);
			$("#course_title").val(rec.course_title);
			$("#coach").val(rec.coach);
			$("#institution").val(rec.institution);
			$("#start_date").val(rec.start_date);
			$("#end_date").val(rec.end_date);
			$("#time").val(rec.time);
			$("#place").val(rec.place);
		})
		/*$.ajax({
				url: 'job_data.php',
				type: "POST",
				async: false,
				dataType: "json",
				data   : {
						status: "R",
						type:"tbtra_title",
						id:id,
				},
				success: function(data){
					var data = data.data;
					$("#title_name").val(data['tra_title']);
					$("#title_desc").val(data['tra_desc']);
					$("#sl_dep").prop('disabled', true);
					$("#time_start").val(data['tra_form']);
					$("#time_end").val(data['tra_to']);
				}
		});*/
	}else{
		$("#course_title").val("");
		$("#coach").val("");
		$("#institution").val("");
		$("#start_date").val("");
		$("#end_date").val("");
		$("#time").val("");
		$("#place").val("");
	}
	$("#myModalCoures").modal('show');	
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
							 <div class="col-md-12" >
								<p id="name"></p>
								<p ><b>ระบบค้นหา : </b><input type="text" name="txt_search" id="txt_search"> <button type="button" class="btn btn-success" id="btn_search">ค้นหา</button> <button type="button" id="btn_search_c" class="btn btn-warning">ยกเลิก</button> <button type="button" class="btn btn-info" onclick="add_title(0)">เพิ่มหัวข้อ</button>
								</p>
								 <table id="tb_job_train" width="100%" class="table table-striped table-bordered" cellspacing="0"></table>
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


<div class="modal fade" id="myModalCoures" role="dialog">
	<div class="modal-dialog">
	
	  <!-- Modal content-->
	  <div class="modal-content" style="width:100%">
		   <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">เพิ่มการฝึกอบรม</h4>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" action="" method="post" enctype="multipart/form-data" name="myform1" id="myform1" >
				<div class="form-group">
					<input type="hidden" class="form-control" name="course_id" id="course_id" value="0" >
					<label class="control-label col-sm-3" for="course_title">หัวข้อการฝึกอบรม </label>
					<div class="col-sm-9">
						<input type="text" class="form-control" name="course_title" id="course_title" placeholder="">
					</div>
				</div>
				
				<div class="form-group">
					<label class="control-label col-sm-3" for="coach">วิทยากร </label>
					<div class="col-sm-9"> 
						<input type="text" class="form-control" name="coach" id="coach" placeholder="">
					</div>
				</div>
				
				<div class="form-group">
					<label class="control-label col-sm-3" for="institution">สถาบัน </label>
					<div class="col-sm-9"> 
						<input type="text" class="form-control" name="institution" id="institution" placeholder="">
						
					</div>
				</div>
				
				<div class="form-group">
					<label class="control-label col-sm-3" for="start_date">วันที่เริ่มอบรม </label>
					<div class="col-sm-3"> 
						<input type="text" class="form-control" name="start_date" id="start_date" placeholder="">
					</div>
					<label class="control-label col-sm-2" for="end_date">วันที่สิ้นสุด </label>
					<div class="col-sm-3"> 
						<input type="text" class="form-control" name="end_date" id="end_date" placeholder="">
					</div>
				</div>
				
				<div class="form-group">
					<label class="control-label col-sm-3" for="time">เวลาที่อบรม </label>
					<div class="col-sm-9"> 
						<input type="text" class="form-control" name="time" id="time" placeholder="8.00 - 17.00">
						<span class="help-block">ตัวอย่าง : 8.00 - 17.00 </span>
					</div>
				</div>
				
				<div class="form-group">
					<label class="control-label col-sm-3" for="place">สถานที่ฝึกอบรม </label>
					<div class="col-sm-9"> 
						<input type="text" class="form-control" name="place" id="place" placeholder="">
					</div>
				</div>
				
				<div class="form-group"> 
					<div class="col-sm-offset-2 col-sm-10">
						<button type="submit" class="btn btn-success">Submit</button>
					</div>
				</div>
			</form>
		  </div>
		 
		
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