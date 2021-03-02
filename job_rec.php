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
var tb_name_emp = "";
$(function() {

	
	$('#btn_search_c').on( 'click', function () {
		$("#txt_search").val("");
		tb_name_emp.search('').draw();
	});
	
	$('#btn_search').on( 'click', function () {
		tb_name_emp.search($("#txt_search").val()).draw();
	});
	
	$('#btn_cancel').on( 'click', function () {
		$("#title_name").val("");
		$("#title_desc").val("");
		$("#sl_dep").val("0");
		$("#time_start").val("8");
		$("#time_end").val("9");
		$("#title_id").val("0");
		$("#sl_dep").prop('disabled', false);
		$("#myModalJobTrain").modal('hide');
		$("#show_pos").show();
		
	});
	
	
	tb_name_emp = $('#tb_name_emp').DataTable( {
			"ajax": {
					url: "job_data.php",
					type: "POST",
					async: false,
					dataType: "json",
					"data" : {
						"status" : "B",
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
						  "sTitle" : "รหัสพนักงาน",
						  "width": "6%",
						  "render": function ( data, type, full, meta ) {
						  return data;
						  }
						},
						{
						  "data": "name",
						  "sTitle" : "ชื่อ - สกุล",
						  "width": "25%",
						  "render": function ( data, type, full, meta ) {
							  return data;
						  }
						},
						{
						  "data": "positionname",
						  "sTitle" : "ตำแหน่ง",
						  "width": "10%",
						  "render": function ( data, type, full, meta ) {
							  return data;
						  }
						},
						{
						  "data": "ojttraining",
						  "sTitle" : "OJT Training",
						  "width": "10%",
						  "render": function ( data, type, full, meta ) {
							  return data;
						  }
						},
						{
						  "data": "add",
						  "sTitle" : "สร้างวันอบรม",
						  "width": "10%",
						  "render": function ( data, type, full, meta ) {
						  return data;
						  }
						},
						{
						  "data": "html",
						  "sTitle" : "รายละเอีนด",
						  "width": "10%",
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
								<p ><b>ระบบค้นหา : </b><input type="text" name="txt_search" id="txt_search"> <button type="button" class="btn btn-success" id="btn_search">ค้นหา</button> <button type="button" id="btn_search_c" class="btn btn-warning">ยกเลิก</button>
								</p>
								 <table id="tb_name_emp" width="100%" class="table table-striped table-bordered" cellspacing="0"></table>
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