<?php  
session_start();
include("connect.php");
include("library.php"); 
$status = $_REQUEST["status"];
$date_time=date("d/m/Y");
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Hrs : Software Development</title>
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

    <link rel='stylesheet' type='text/css' href='assets/css/bootstrap.min.css' /> 
    <link rel='stylesheet' type='text/css' href='assets/css/buttons.dataTables.min.css' />
    <link rel='stylesheet' type='text/css' href='assets/css/dataTables.bootstrap.min.css' /> 

    <script type="text/javascript" src="assets/js/jquery-1.10.2.min.js"></script>
    
<link rel='stylesheet' type='text/css' href='assets/plugins/jqueryui-timepicker/jquery.ui.timepicker.css' /> 
<link rel='stylesheet' type='text/css' href='assets/plugins/form-daterangepicker/daterangepicker-bs3.css' /> 
<link rel='stylesheet' type='text/css' href='assets/js/jqueryui.css' /> 
<script>
$(document).ready(function() {
    $("#create_date,#target_date").datepicker({
        dateFormat: 'dd/mm/yy'
    });
});
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

<?php if($status=="") {  ?>

			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-primary">
						<div class="panel-heading">Software Development Request</div>
						<div class="panel-body">
                            <form class="form-horizontal" action="it_program_upload.php" method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="create_date">วันที่ขอ :</label>
                                    <div class="col-sm-3">          
                                        <input type="text" name="create_date" id="create_date" class="form-control" value="<?=$date_time?>" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="purpose">มีความประสงค์จะขอให้ :</label>
                                    <div class="col-sm-3">
                                        <select name="purpose" id="purpose" class="form-control" required>
                                            <option value="">กรุณาเลือก</option>
                                            <option value="ต่อยอด">ต่อยอด</option>
                                            <option value="ปรับปรุง/แก้ไข">ปรับปรุง/แก้ไข</option>
                                            <option value="พัฒนาระบบใหม่">พัฒนาระบบใหม่</option>
                                            <option value="Other">Other</option>
                                            
                                        </select>
                                        
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="system_name">ระบบที่ต้องการ :</label>
                                    <div class="col-sm-8">          
                                        <input type="text" name="system_name" id="system_name" class="form-control" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="importance">ความสำคัญ :</label>
                                    <div class="col-sm-8">          
                                        <label class="checkbox-inline"><input type="checkbox" name="importance_arr[]" value="นโยบาย">นโยบาย</label>
                                        <label class="checkbox-inline"><input type="checkbox" name="importance_arr[]" value="KPI">KPI</label>
                                        <label class="checkbox-inline"><input type="checkbox" name="importance_arr[]" value="ลดการใช้งบประมาณ">ลดการใช้งบประมาณ</label>
                                        <label class="checkbox-inline"><input type="checkbox" name="importance_arr[]" value="เพิ่มประสิทธิภาพ">เพิ่มประสิทธิภาพ</label>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="reason">เหตุผล / ความจำเป็น :</label>
                                    <div class="col-sm-8">          
                                        <textarea name="reason" id="reason" cols="30" rows="10"  class="form-control" required></textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="target_date">วันที่ต้องการใช้งาน :</label>
                                    <div class="col-sm-3">          
                                        <input type="text" name="target_date" id="target_date" class="form-control" value="" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="program_file">ไฟล์ :</label>
                                    <div class="col-sm-10">          
                                        <input type="file" name="program_file[]" id="program_file" multiple="multiple">
                                        <font color='red'>แนบได้หลายไฟล์</font>
                                    </div>
                                </div>
                                <div class="form-group">        
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <?php if($_SESSION['admin_userid']==""){?>
                                            <font color='red'>*กรุณาล็อคอินก่อน</font>
                                        <?php }else{?>
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        <?php }?>
                                    </div>
                                </div>
                            </form>

					    </div>
					</div>
				</div>
			</div>


<?php } ?>
			



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

<!--
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>

<script>!window.jQuery && document.write(unescape('%3Cscript src="assets/js/jquery-1.10.2.min.js"%3E%3C/script%3E'))</script>
<script type="text/javascript">!window.jQuery.ui && document.write(unescape('%3Cscript src="assets/js/jqueryui-1.10.3.min.js'))</script>
-->

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
<script type="text/javascript" src="assets/js/jquery.multi-select.js"></script>
<script type="text/javascript" src="assets/js/jquery.quicksearch.js"></script>

<script type='text/javascript' src='assets/js/jquery.dataTables.min.js'></script> 
<script type='text/javascript' src='assets/js/dataTables.bootstrap.min.js'></script> 


</body>
</html>