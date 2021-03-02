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
var tb_pro_list = "";
$(function() {
	show_probation();
	$('#search_by').on('change', function(){
		searchstr = "";
		if($('#search_by').val() == '2'){
			searchstr = " AND status_pro = 1 ";
		}
		tb_pro_list.search(searchstr).draw();
	});
});
function show_probation(type){
	tb_pro_list = $('#tb_pro_list').DataTable( {
			"ajax": {
					url: "probotion_data.php",
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
						  "width": "3%",
						  "render": function ( data, type, full, meta ) {
						  return data;
						  }
						},
						{
						  "data": "empno",
						  "sTitle" : "รหัส",
						  "width": "5%",
						  "render": function ( data, type, full, meta ) {
						  return data;
						  }
						},
						{
						  "data": "fullname",
						  "sTitle" : "ชื่อ - สกุล",
						  "width": "14%",
						  "render": function ( data, type, full, meta ) {
							  return data;
						  }
						},
						{
						  "data": "position",
						  "sTitle" : "ตำแหน่ง",
						  "width": "10%",
						  "render": function ( data, type, full, meta ) {
							  return data;
						  }
						},
						{
						  "data": "startdate",
						  "sTitle" : "วันที่เริ่มงาน",
						  "width": "8%",
						  "render": function ( data, type, full, meta ) {
						  return data;
						  }
						},
						{
						  "data": "pro_date",
						  "sTitle" : "วันครบทดลองงาน",
						  "width": "8%",
						  "render": function ( data, type, full, meta ) {
						  return data;
						  }
						},
						{
						  "data": "action",
						  "sTitle" : "Action",
						  "width": "5%",
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
									<select id="search_by" style="width: 180px;">
										<option value="1">พนักงานรอการประเมินผล</option>
										<option value="2">พนักงานผ่านการประเมินผล</option>
									</select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								</p>
								 <table id="tb_pro_list" width="100%" class="table table-striped table-bordered" cellspacing="0"></table>
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
					<TD id="tr_h">ข้อมูลเบื้องต้น : </TD><TD> <b>ชื่อผู้ลา : </b><span id='model_name'></span><input type="hidden" name="empno_name" id="empno_name"><input type="hidden" name="empno_edit" id="empno_edit"></TD>
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