<? 
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>I-Wis HQ : Leave Form</title>
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
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script type="text/javascript" src="assets/js/jquery-1.10.2.min.js"></script>
<script type='text/javascript' src='assets/js/jqueryui-1.10.3.min.js'></script> 

<script>
var st = "";
var remain_annual;
var req_annual = 0;
var over_annual = "";
var re_holiday_s = '';
var re_holiday_e = '';
var total_leave;
var re_holiday;
var s_h = 0;
var e_h = 0;
var name_le = "";
$(function() {
	var empno = <?php echo $_SESSION['admin_userid'];?>;
	var site = '<?echo $_SESSION['site']?>';
	var d = new Date();
	var month = d.getMonth()+1;
	var day = d.getDate();
	var current_date =(month<10 ? '0' : '') + month + '-' +(day<10 ? '0' : '') + day;

	$.ajax({
			url: 'leave_data.php',
			type: "POST",
			async: false,
			dataType: "json",
			cache: false,
			data   : {empno:empno,status:'R'},
			success: function(data) {
				$("#name").text(data.info['name']);
				name_le = data.info['name'];
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
	//---------------------------------------------------------------------------------------------
	$('#s_leave').datepicker({ dateFormat: 'dd/mm/yy' }).val();
	$('#e_leave').datepicker({ dateFormat: 'dd/mm/yy' }).val();
	
	$("form#myform1").submit(function(event){
		event.preventDefault();//คำสั่งที่ใช้หยุดการเกิดเหตุการณ์ใดๆขึ้น
		
	//$("#save").click(function(event){
		var re_over_annual = '';
		if($("#s_leave").val() == ""){
			$("#s_leave").focus();return false;
		}
		if($("#e_leave").val() == ""){
			$("#e_leave").focus();return false;
		}
		if($("#e_leave").val() == ""){
			$("#e_leave").focus();return false;
		}
		if($("#reasons").val() == ""){
			$("#reasons").focus();return false;
		}
		
		var s_leave = $("#s_leave").val().split("/");
		var e_leave = $("#e_leave").val().split("/");
		req_annual = 0;
		s_h = 0;
		e_h = 0;
		re_over_annual = over_annual.split("/");
		s_leave = new Date($.datepicker.formatDate( "yy-mm-dd", new Date( s_leave[2], s_leave[1] - 1, s_leave[0] ) ));
		e_leave = new Date($.datepicker.formatDate( "yy-mm-dd", new Date( e_leave[2], e_leave[1] - 1, e_leave[0] ) ));
		re_over_annual = new Date($.datepicker.formatDate( "yy-mm-dd", new Date( re_over_annual[2], re_over_annual[1] - 1, re_over_annual[0] ) ));
		if(s_leave > e_leave){
			alert('วันที่เริ่ม - สิ้นสุด ไม่ถูกต้อง กรุณาเลือกวันที่ใหม่อีกครั้ง');
			$("#s_leave").focus();return false;
		}
		
		$.ajax({
			url: 'leave_data.php',
			type: "POST",
			async: false,
			dataType: "json",
			cache: false,
			data   : {s_leave:$("#s_leave").val(),e_leave:$("#e_leave").val(),status:'C',site:site},
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
		if(re_holiday_s != $("#s_leave").val()){
			s_h = parseFloat($("#sl_s_leave").val());
		}
		if(re_holiday_e != $("#e_leave").val()){
			e_h = parseFloat($("#sl_e_leave").val());
		}
		
		req_annual = ((e_leave - s_leave)/(1000*60*60*24))+1;
		total_leave = req_annual - re_holiday - s_h - e_h;
		if(total_leave == 0){
			alert('จำนวนวันลาไม่ถูกต้อง กรุณาเลือกวันที่ใหม่อีกครั้ง')
			$("#e_leave").focus();return false;
		}
		//ตรวจสอบสิทธิพักร้อนเท่านั้น
		if($("#type_leave").val() == "L0003"){
			var date = new Date();
			//ตรวจสอบการลาล่วงหน้า 
			var c_s_leave = $("#s_leave").val().split("/");
			if(total_leave <= 2){
				date.setDate(date.getDate() + 1);//ต้องลาล่วงหน้า 1 วัน
				var month = date.getMonth()+1;
				var futDate=date.getFullYear() + "-" + (month<10 ? '0' : '') + month  + "-" + (date.getDate()<10 ? '0' : '')+ date.getDate();
				if($.datepicker.formatDate( "yy-mm-dd", new Date( c_s_leave[2], c_s_leave[1] - 1, c_s_leave[0] ) ) < futDate){
					alert('ต้องลาล่วงหน้าอย่างน้อย 1 วัน กรุณาเลือกวันที่ใหม่อีกครั้ง')
					$("#s_leave").focus();return false;
				}
				
			}
			if(total_leave >= 3){
				date.setDate(date.getDate() + 7);//ต้องลาล่วงหน้า 7 วัน
				var month = date.getMonth()+1;
				var futDate=date.getFullYear() + "-" + (month<10 ? '0' : '') + month  + "-" + (date.getDate()<10 ? '0' : '')+ date.getDate();
				if($.datepicker.formatDate( "yy-mm-dd", new Date( c_s_leave[2], c_s_leave[1] - 1, c_s_leave[0] ) ) < futDate){
					alert('ต้องลาล่วงหน้าอย่างน้อย 7 วัน กรุณาเลือกวันที่ใหม่อีกครั้ง')
					$("#s_leave").focus();return false;
				}
				
			}
			if(remain_annual < total_leave){
				alert('จำนวนวันพักร้อนไม่พอ กรุณาเลือกวันที่ใหม่อีกครั้ง')
				$("#e_leave").focus();return false;
			}
		}
		//console.log("จำนวนวันลา "+total_leave);
		$("#myModal").modal({backdrop: "static"});
		
		var formData = new FormData($(this)[0]);
		formData.append("empno",empno);
		formData.append("status",'I');
		formData.append("site",site);
		formData.append("total_leave",total_leave);
		formData.append("sl_s_leave",$("#sl_s_leave").val());
		formData.append("sl_e_leave",$("#sl_e_leave").val());
		formData.append("name_le",name_le);
		
		$.ajax({
			 url: 'leave_data.php',
			  data: formData,
			  processData: false,
			  contentType: false,
			  type: 'POST',
			  success: function(data){
				  var aa =data;
				  var bb = aa.split("###",150);
				  
				
				 
				 sendmail(bb[0],bb[1],bb[2],bb[3],bb[4],bb[5],bb[6]);
				
			  }
			});
		//$.ajax({
//				url: 'leave_data.php',
//				type: "POST",
//				async: false,
//				cache: false,
//				dataType: "json",
//				contentType: false,
//				processData: false,
//				data   : formData,
//				success: function(data) {
//		
//		
//		//alert('บันทึกข้อมูลสำเร็จ กรุณาตรวจสอบข้อมูลอีกครั้ง');
//		//window.location = "list_leave.php";
//		//$("#file_att").val("");	
//					
//				}
//		});
		//return false;
		
		
	});
	
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
		 $("#myModal").modal("hide");
				alert('บันทึกข้อมูลสำเร็จ กรุณาตรวจสอบข้อมูลอีกครั้ง');
				 window.location = "list_leave.php";
		});
	}

function sendmail_approve(mailtype,empno,type_leave,s_leave,e_leave,reasons,empno_edit){
	$.post( "getajax_sendmail.php", { 	
	status: "send_mail", 
	empno: empno,
	type_leave: type_leave,
	s_leave: s_leave,
	e_leave: e_leave,
	reasons: reasons,
	mailtype:mailtype,
	empno_edit: empno_edit,
	sid: Math.random() 
	})
	.done(function( data ) {
		 $("#myModal").modal("hide");
				alert('บันทึกข้อมูลสำเร็จ กรุณาตรวจสอบข้อมูลอีกครั้ง');
				 window.location = "list_leave.php";
		});
	}

</script>
<style>
#tr_h{
    font-size: 18px;
}
.ui-draggable, .ui-droppable {
	background-position: top;
}
</style>
</head>

<body class=" ">

<!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
         
          <h4 class="modal-title"></h4>
        </div>
        <div class="modal-body">
          <p>Loading Please wait...</p>
        </div>
        <div class="modal-footer">
         
        </div>
      </div>
      
    </div>
  </div>
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
        <ul class="nav navbar-nav pull-right toolbar"></ul>
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
		<div id="page-heading"></div>
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-primary">
						
						<div class="panel-body">
							<form action="" method="post" enctype="multipart/form-data" name="myform1" id="myform1">
								<TABLE style="height:450px;">
									<TR >
										<TD id="tr_h">วันที่ : </TD><TD style="margin:5"><?php echo date("d/m/Y");?></TD>
									</TR>
									<TR>
										<TD id="tr_h">ข้อมูลเบื้องต้น : </TD><TD> <b>ชื่อผู้ลา : </b><span id='name'></span>&nbsp;&nbsp;&nbsp;<b>ตำแหน่ง : </b><span id='position'></span>&nbsp;&nbsp;&nbsp;<b>วันที่เข้าทำงาน : </b><span id='startdate'></span></TD>
									</TR>
									<TR>
										<TD id="tr_h">จำนวนสิทธิ์พักร้อน : </TD><TD> <b>จำนวน : </b><span id='total_annual'></span> วัน &nbsp;&nbsp;&nbsp;&nbsp;<b>คงเหลือ : </b><span id='remain_annual'></span> วัน &nbsp;&nbsp;&nbsp;&nbsp;<b>ใช้ไป : </b><span id='use_annual'></span> วัน</TD>
									</TR>
									<TR>
										<TD id="tr_h">ประเภทการลา : </TD><TD> <select id="type_leave" name="type_leave">
																<option value="L0001">ลาป่วย</option>
																<option value="L0002">ลากิจ</option>
																<option value="L0003">ลาพักร้อน</option>
																<option value="L0004">ลาบวช</option>
																<option value="L0005">ลาคลอด</option>
																<option value="L0006">ขาดงาน</option>
															  </select>
															  &nbsp;&nbsp;&nbsp;<b>กะ : </b><select id="shift" name="shift">
																							<option value="Day">Day</option>
																							<option value="Night">Night</option>
																						  </select>
															</TD>
									</TR>
									<TR>
										<TD id="tr_h">ช่วงวันหยุด : </TD><TD>  เริ่ม <input type="text" id="s_leave" name="s_leave"><select id="sl_s_leave">
																<option value="0">เต็มวัน</option>
																<option value="0.5">ครึงวัน</option>
															  </select>
															ถึง <input type="text" id="e_leave" name="e_leave"><select id="sl_e_leave">
																<option value="0">เต็มวัน</option>
																<option value="0.5">ครึงวัน</option>
															  </select>
														</TD>
									</TR>
									<TR>
										<TD id="tr_h">สาเหตุ : </TD><TD><textarea rows="4" cols="80" id="reasons" name="reasons"></textarea></TD>
									</TR>
									<TR>
										<TD id="tr_h">เอกสารแนบ : </TD><TD><input type="file" id="file_att" name="file_att"></TD>
									</TR>
									<TR>
										<TD></TD><TD><br><input type="submit" value="บันทึก" id="save"> <input type="reset" value="ยกเลิก"></TD>
									</TR>
								</TABLE>
								
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


</body>
</html>