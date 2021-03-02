<? 
session_start();
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

th {
	text-align: center;
}
.center {
	text-align: center;
}
.ui-draggable, .ui-droppable {
	background-position: top;
}

</style>
<script>
var type = getParameterByName('type');
var empno = getParameterByName('empno');
var new_saraly;
var old_saraly;
$(function() {
	$.ajax({
			url: 'probotion_data.php',
			type: "POST",
			async: false,
			dataType: "json",
			data   : {type:type,empno:empno,status:'R'},
			success: function(data) {
				var data = data.data;
				if(type == 2){
					new_saraly = data['new_saraly'].replace(" บาท", "").replace(",", "");
				}
				old_saraly = data['old_saraly'].replace(" บาท", "").replace(",", "");
				$("#full_name").text(': '+data['fullname']);
				$("#age").text(data['age']+' ปี');
				//$("#education").text(': '+data['education']);
				$("#position").text(': '+data['position']);
				$("#startdate").text(': '+data['startdate']);
				$("#pro_date").text(': '+data['pro_date']);
				$("#txt_pro_date").val(data['pro_date']);
				$("#salary").text(': '+data['old_saraly']);
				$("#txt_old_salary").val(old_saraly);
				$("#old_salary").html('<u>'+data['old_saraly']+'</u>');
				$("#txt_private").val(data['private']);
				$("#txt_sick").val(data['sick']);
				$("#txt_absence").val(data['absence']);
				if(type == 1){
					$("#leave").html('<b> สาย</b> <input type="text" name="late" id="late" size="2" value=0>วัน&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>ลากิจ</b> '+data['private']+' วัน&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>ลาป่วย </b>'+data['sick']+' วัน&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>ขาดงาน</b> '+data['absence']+' วัน');
				}else{
					$("#leave").html('<b> สาย</b> '+data['late']+' วัน&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>ลากิจ</b> '+data['private']+' วัน&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>ลาป่วย </b>'+data['sick']+' วัน&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>ขาดงาน</b> '+data['absence']+' วัน');
				}
				
			}
	});
	$("#btn_print").html('');
	if(type == 2){
		$.ajax({
			url: 'probotion_data.php',
			type: "POST",
			async: false,
			dataType: "json",
			data   : {empno:empno,status:'C'},
			success: function(data) {
				var data = data.data;
				 $('input[name=title1][value="' + data['title1'] + '"]').prop('checked', true);
				 $("#note1").val(data['note1']);
				 $('input[name=title2][value="' + data['title2'] + '"]').prop('checked', true);
				 $("#note2").val(data['note2']);
				 $('input[name=title3][value="' + data['title3'] + '"]').prop('checked', true);
				 $("#note3").val(data['note3']);
				 $('input[name=title4][value="' + data['title4'] + '"]').prop('checked', true);
				 $("#note4").val(data['note4']);
				 $('input[name=title5][value="' + data['title5'] + '"]').prop('checked', true);
				 $("#note5").val(data['note5']);
				 $('input[name=title6][value="' + data['title6'] + '"]').prop('checked', true);
				 $("#note6").val(data['note6']);
				 $('input[name=title7][value="' + data['title7'] + '"]').prop('checked', true);
				 $("#note7").val(data['note7']);
				 $('input[name=title8][value="' + data['title8'] + '"]').prop('checked', true);
				 $("#note8").val(data['note8']);
				 $('input[name=title9][value="' + data['title9'] + '"]').prop('checked', true);
				 $("#note9").val(data['note9']);
				 $('input[name=title10][value="' + data['title10'] + '"]').prop('checked', true);
				 $("#note10").val(data['note10']);
				 $('input[name=title11][value="' + data['result'] + '"]').prop('checked', true);
				 if(data['result'] == "3"){
					 $("#new_salary").val(data['new_saraly']);
				 }
				 $("#comment").val(data['recomend']);
				 
			}
		});
		$("#btn_print").html("<a target='_blank' href='print_probation.php?type=2&empno="+empno+"' ><i class='fa fa-print fa-2x' aria-hidden='true'></i></a>");
	}
	
	$("form#myform1").submit(function(event){
		event.preventDefault();//คำสั่งที่ใช้หยุดการเกิดเหตุการณ์ใดๆขึ้น
		
		var title1 = $('input[name=title1]').is(':checked');
		if (!title1) {
			alert('กรุณาประเมิน ข้อ 1. การตรงต่อเวลา ...');
			return false;
		} 
		var title2 = $('input[name=title2]').is(':checked');
		if (!title2) {
			alert('กรุณาประเมิน ข้อ 2. ความรู้เกี่ยวกับงาน ...');
			return false;
		}
		var title3 = $('input[name=title3]').is(':checked');
		if (!title3) {
			alert('กรุณาประเมิน ข้อ 3. ความคิดริเริ่ม ...');
			return false;
		} 
		var title4 = $('input[name=title4]').is(':checked');
		if (!title4) {
			alert('กรุณาประเมิน ข้อ 4. ความสามารถในการทำงานรวมกับผู้อื่น ...');
			return false;
		}
		var title5 = $('input[name=title5]').is(':checked');
		if (!title5) {
			alert('กรุณาประเมิน ข้อ 5. การปฏิบัติตามคำสั่งของผู้บังคับบัญชา ...');
			return false;
		}
		var title6 = $('input[name=title6]').is(':checked');
		if (!title6) {
			alert('กรุณาประเมิน ข้อ 6. ความสามารถในการเรียนรู้ การรับมอบงาน ...');
			return false;
		}
		var title7 = $('input[name=title7]').is(':checked');
		if (!title7) {
			alert('กรุณาประเมิน ข้อ 7. คุณภาพของงานที่ทำได้ ...');
			return false;
		}
		var title8 = $('input[name=title8]').is(':checked');
		if (!title8) {
			alert('กรุณาประเมิน ข้อ 8. ความรับผิดชอบ ...');
			return false;
		}
		var title9 = $('input[name=title9]').is(':checked');
		if (!title9) {
			alert('กรุณาประเมิน ข้อ 9. การแก้ปญหา และการตัดสินใจ ...');
			return false;
		}
		var title10 = $('input[name=title10]').is(':checked');
		if (!title10) {
			alert('กรุณาประเมิน ข้อ 10. ทัศนคติต่อการทำงาน ต่อเพื่อนร่วมงาน ต่อบริษัท ...');
			return false;
		}
		var title11 = $('input[name=title11]').is(':checked');
		if (!title11) {
			alert('กรุณาประเมิน สรุปผลการประเมิน ...');
			return false;
		}
		if ($('input[name=title11]:checked', '#myform1').val() == 3 &&  $('#new_salary').val() == "") {
			$("#new_salary").focus();
			return false;
		}
		var formData = new FormData($(this)[0]);
		if(type == '1'){
			formData.append("status",'I');
		}else{
			formData.append("status",'U');
		}
		formData.append("empno",empno);
		$.ajax({
				url: 'probotion_data.php',
				type: "POST",
				async: false,
				cache: false,
				dataType: "json",
				contentType: false,
				processData: false,
				data   : formData,
				success: function(data) {
					alert("บันทึกข้อมูลเรียบร้อยแล้ว");
					window.location = "form_probation.php?type=2&empno="+empno;
					return false;
				}
		});
		return false;
	});
});

function getParameterByName(name) {
	name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
	var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
		results = regex.exec(location.search);
	return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
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
							 <form action="" method="post" enctype="multipart/form-data" name="myform1" id="myform1">
							 <b><h2>แบบฟอร์มประเมินผลการปฏิบัติงานระยะทดลองงาน</h2></b>
							 <br/>
								<table width="80%" border=0 >
									<tr>
										<th style="text-align: left;">ชื่อ - สกุล</th>
										<td id="full_name" style="text-align: left;"></td>
										<th style="text-align: left;">วุฒิการศึกษา</th>
										<td style="text-align: left;"><span id="education">........................</span> <b> อายุ : </b><span id="age"></span></td>
									</tr>
									<tr>
										<th style="text-align: left;">ตำแหน่ง</th>
										<td id="position" style="text-align: left;"></td>
										<th style="text-align: left;">สังกัดแผนก/ฝ่าย</th>
										<td style="text-align: left;">..............................</td>
									</tr>
									<tr>
										<th style="text-align: left;">วันที่เริ่มงาน</th>
										<td id="startdate" style="text-align: left;"></td>
										<th style="text-align: left;">อัตราเงินเดือน</th>
										<td id="salary" style="text-align: left;"></td>
									</tr>
									<tr>
										<th style="text-align: left;">ระยะเวลาทดลองงาน</th>
										<td style="text-align: left;">.....120 วัน.....</td>
										<th style="text-align: left;">วันครบทดลองงาน</th>
										<td id="pro_date" style="text-align: left;"></td>
									</tr>
									<tr>
										<th style="text-align: left;">การมาทำงาน </th>
										<td colspan="3" id='leave'style="text-align: left;"></td>

									</tr>
								</table  >
								<input type="hidden" name='txt_pro_date' id="txt_pro_date" >	
								<input type="hidden" name='txt_private' id="txt_private" >	
								<input type="hidden" name='txt_sick' id="txt_sick" >	
								<input type="hidden" name='txt_absence' id="txt_absence" >	
								<br/>
								<table width="80%" border=1>
								<tr>
										<th width="30%">หัวข้อพิจารณา</th>
										<th width="6%">ดีมาก<br>5</th>
										<th width="6%">ดี<br>4</th>
										<th width="6%">พอใช้<br>3</th>
										<th width="9%">ต้องปรับปรุง<br>2</th>
										<th width="9%">ไม่ผ่านเกณฑ์<br>1</th>
										<th width="14%">หมายเหตุ</th>
									</tr>
									<tr>
										<td>&nbsp;&nbsp;&nbsp;1. การตรงต่อเวลา</td>
										<td class="center"><input type="radio" name="title1" value="5"></td>
										<td class="center"><input type="radio" name="title1" value="4"></td>
										<td class="center"><input type="radio" name="title1" value="3"></td>
										<td class="center"><input type="radio" name="title1" value="2"></td>
										<td class="center"><input type="radio" name="title1" value="1"></td>
										<td class="center"><input type="text" name="note1" id="note1" value="" size="25"></td>
									</tr>
									<tr>
										<td>&nbsp;&nbsp;&nbsp;2. ความรู้เกี่ยวกับงาน</td>
										<td class="center"><input type="radio" name="title2" value="5"></td>
										<td class="center"><input type="radio" name="title2" value="4"></td>
										<td class="center"><input type="radio" name="title2" value="3"></td>
										<td class="center"><input type="radio" name="title2" value="2"></td>
										<td class="center"><input type="radio" name="title2" value="1"></td>
										<td class="center"><input type="text" name="note2" id="note2" value="" size="25"></td>
									</tr>
									<tr>
										<td>&nbsp;&nbsp;&nbsp;3. ความคิดริเริ่ม</td>
										<td class="center"><input type="radio" name="title3" value="5"></td>
										<td class="center"><input type="radio" name="title3" value="4"></td>
										<td class="center"><input type="radio" name="title3" value="3"></td>
										<td class="center"><input type="radio" name="title3" value="2"></td>
										<td class="center"><input type="radio" name="title3" value="1"></td>
										<td class="center"><input type="text" name="note3" id="note3" value="" size="25"></td>
									</tr>
									<tr>
										<td>&nbsp;&nbsp;&nbsp;4. ความสามารถในการทำงานรวมกับผู้อื่น</td>
										<td class="center"><input type="radio" name="title4" value="5"></td>
										<td class="center"><input type="radio" name="title4" value="4"></td>
										<td class="center"><input type="radio" name="title4" value="3"></td>
										<td class="center"><input type="radio" name="title4" value="2"></td>
										<td class="center"><input type="radio" name="title4" value="1"></td>
										<td class="center"><input type="text" name="note4" id="note4" value="" size="25"></td>
									</tr>
									<tr>
										<td>&nbsp;&nbsp;&nbsp;5. การปฏิบัติตามคำสั่งของผู้บังคับบัญชา</td>
										<td class="center"><input type="radio" name="title5" value="5"></td>
										<td class="center"><input type="radio" name="title5" value="4"></td>
										<td class="center"><input type="radio" name="title5" value="3"></td>
										<td class="center"><input type="radio" name="title5" value="2"></td>
										<td class="center"><input type="radio" name="title5" value="1"></td>
										<td class="center"><input type="text" name="note5" id="note5" value="" size="25"></td>
									</tr>
									<tr>
										<td>&nbsp;&nbsp;&nbsp;6. ความสามารถในการเรียนรู้ การรับมอบงาน</td>
										<td class="center"><input type="radio" name="title6" value="5"></td>
										<td class="center"><input type="radio" name="title6" value="4"></td>
										<td class="center"><input type="radio" name="title6" value="3"></td>
										<td class="center"><input type="radio" name="title6" value="2"></td>
										<td class="center"><input type="radio" name="title6" value="1"></td>
										<td class="center"><input type="text" name="note6" id="note6" value="" size="25"></td>
									</tr>
									<tr>
										<td>&nbsp;&nbsp;&nbsp;7. คุณภาพของงานที่ทำได้</td>
										<td class="center"><input type="radio" name="title7" value="5"></td>
										<td class="center"><input type="radio" name="title7" value="4"></td>
										<td class="center"><input type="radio" name="title7" value="3"></td>
										<td class="center"><input type="radio" name="title7" value="2"></td>
										<td class="center"><input type="radio" name="title7" value="1"></td>
										<td class="center"><input type="text" name="note7" id="note7" value="" size="25"></td>
									</tr>
									<tr>
										<td>&nbsp;&nbsp;&nbsp;8. ความรับผิดชอบ</td>
										<td class="center"><input type="radio" name="title8" value="5"></td>
										<td class="center"><input type="radio" name="title8" value="4"></td>
										<td class="center"><input type="radio" name="title8" value="3"></td>
										<td class="center"><input type="radio" name="title8" value="2"></td>
										<td class="center"><input type="radio" name="title8" value="1"></td>
										<td class="center"><input type="text" name="note8" id="note8" value="" size="25"></td>
									</tr>
									<tr>
										<td>&nbsp;&nbsp;&nbsp;9. การแก้ปัญหา และการตัดสินใจ</td>
										<td class="center"><input type="radio" name="title9" value="5"></td>
										<td class="center"><input type="radio" name="title9" value="4"></td>
										<td class="center"><input type="radio" name="title9" value="3"></td>
										<td class="center"><input type="radio" name="title9" value="2"></td>
										<td class="center"><input type="radio" name="title9" value="1"></td>
										<td class="center"><input type="text" name="note9" id="note9" value="" size="25"></td>
									</tr>
									<tr>
										<td>&nbsp;&nbsp;&nbsp;10. ทัศนคติต่อการทำงาน ต่อเพื่อนร่วมงาน ต่อบริษัท</td>
										<td class="center"><input type="radio" name="title10" value="5"></td>
										<td class="center"><input type="radio" name="title10" value="4"></td>
										<td class="center"><input type="radio" name="title10" value="3"></td>
										<td class="center"><input type="radio" name="title10" value="2"></td>
										<td class="center"><input type="radio" name="title10" value="1"></td>
										<td class="center"><input type="text" name="note10" id="note10" value="" size="25"></td>
									</tr>
								</table>
								<br/>
								<b>ความคิดเห็นเพิ่มเติมของผู้ประเมิน</b> <input type="text" name="comment" id="comment" value="" size="105">
								<br/><br/>
								<b>สรุปผลการประเมิน</b> <input type="radio" name="title11" value="0"> ไม่ผ่านการทดลองงาน &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="title11" value="1"> ผ่านการทดลองงาน<br/>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="title11" value="3"> เสนอพิจารณาปรับเงินเดือนจาก <span id="old_salary"></span> เป็น <input type="hidden" name='txt_old_salary' id="txt_old_salary" ><input type="text" name='new_salary' id="new_salary" size="8"><br/>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="title11" value="2"> ยังไม่ควรปรับ
								<br><br>
								<input type="submit" class="btn btn-success" value="Save">&nbsp;&nbsp;<span id='btn_print'></span>
							 </form>
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