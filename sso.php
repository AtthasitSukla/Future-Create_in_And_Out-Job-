<?php  
include("connect.php"); 
include("library.php"); 
//$job_id = $_GET["job_id"];
$status = $_GET['status'];

 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>I-Wis</title>
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
<style>
td {
    padding: 5px;
}
</style>

<script type="text/javascript">
	function fileSelected(id,step) {
		 
             var count = document.getElementById(step+id).files.length;
              for (var index = 0; index < count; index ++)
              {
                    var file = document.getElementById(step+id).files[index];
 					uploadFile(id,step);
              }
      }
 
      function uploadFile(id,step) {
        var fd = new FormData();
 
              var count = document.getElementById(step+id).files.length;
 
              for (var index = 0; index < count; index ++)
 
              {
                     var file = document.getElementById(step+id).files[index];
                     fd.append(step, file);
              }
			 //  var partnumber = document.getElementById("partnumber"+id).value;
			   fd.append('status','uploadFile' );
			   fd.append('id',id );
			 //  fd.append('partnumber',partnumber );
 
        var xhr = new XMLHttpRequest();
 
        xhr.upload.addEventListener("progress", uploadProgress, false);
 
        xhr.addEventListener("load", uploadComplete, false);
 
        xhr.addEventListener("error", uploadFailed, false);
 
        xhr.addEventListener("abort", uploadCanceled, false);
 
        xhr.open("POST", "getajax_add_manual_iwis.php");
 
        xhr.send(fd);
 
      }
 
      function uploadProgress(evt) {
 
        if (evt.lengthComputable) {
			
 		 var idselect = $("#idselect").val();
          var percentComplete = Math.round(evt.loaded * 100 / evt.total);
 
          document.getElementById('progress'+idselect).innerHTML = percentComplete.toString() + '%';
 
        }
 
        else {
 
          document.getElementById('progress'+id).innerHTML = 'unable to compute';
 
        }
 
      }
 
      function uploadComplete(evt) {
 	//alert(evt.target.responseText);
	alert("upload complete.");
      
      }
 
      function uploadFailed(evt) {
 
        alert("There was an error attempting to upload the file.");
 
      }
 
      function uploadCanceled(evt) {
 
        alert("The upload has been canceled by the user or the browser dropped the connection.");
 
      }
</script>

<script>
$(document).ready(function() {
    $('#example').DataTable({
        "order": [[ 0, "desc" ]]
    });
    $("#start_date,#end_date").datepicker({
        format:'dd/mm/yyyy'
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
			
            <div class="table-responsive">  
           
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-striped table-bordered datatables">
<thead>
<tr bgcolor="#CCCCCC">
      <td width="48"  align="center"><strong>Item</strong></td>
  <td width="96"  height="30" align="center"><strong>Section</strong></td>
  <td width="191"  align="center"><strong>Emp No</strong></td>
    <td width="191"  align="center"><strong>Emp Name</strong></td>
    <td width="149"  align="center"><strong>      Password</strong></td>
    <td width="76"  align="center"><strong>Status</strong></td>
    <td width="76"  align="center"><strong>HQ Packing</strong></td>
    <td width="59"  align="center"><strong>Topre</strong></td>
    <td width="77"  align="center"><strong>NHK Packing</strong></td>
    <td width="84"  align="center"><strong>Material Stock</strong></td>
    <td width="80"  align="center"><strong>Invoice / PRPO</strong></td>
    <td width="45"  align="center"><strong>TSC</strong></td>
     <td width="74"  align="center"><strong>Autoliv</strong></td>
    </tr>
  </thead>
  <tbody>
  <?
  											$sql = "select * from tbemployee where delstatus = 0 and emp_level >1 order by site desc";
                                            $re = mssql_query($sql);
											$num = mssql_num_rows($re);
											if($num>0){
												$i=0;
                                            while($row = mssql_fetch_array($re)){
												$i++;
													?>
													<tr bgcolor="#FFFFFF">
   <td  align="center"><?=$i?>.</td>
  <td  align="center"><?=$row['site']?></td>
  <td  align="center" ><?=$row['empno']?></td>
    <td  align="center" ><?=lang_thai_from_database($row['firstname'])?><br><?=$row['firstname_en']?></td>
    <td  align="center">&nbsp;</td>
    <td  align="center"><?
    if($row['sso']=='yes'){
			echo "on";
		}else{
			echo "off";
			}
	?></td>
    <td  align="center"><?
    	$db="dbnissandb";
		$sql=mssql_connect($host,$username,$password) or die("Cannot connect");
		mssql_select_db($db);
		$sql_sso="select * from tbadmin where empno='".$row['empno']."'";
		$result_sso=mssql_query($sql_sso);
		$num_sso = mssql_num_rows($result_sso);
		if($num_sso>0){
				?><a href="http://www.ipack-iwis.com/hq/viewtransaction.php" target="_blank">Yes</a><?
			}
		
	?></td>
    <td  align="center"><?
    	$db="dbtopredb";
		$sql=mssql_connect($host,$username,$password) or die("Cannot connect");
		mssql_select_db($db);
		$sql_sso="select * from tbadmin where empno='".$row['empno']."'";
		$result_sso=mssql_query($sql_sso);
		$num_sso = mssql_num_rows($result_sso);
		if($num_sso>0){
				?><a href="http://www.ipack-iwis.com/topre/importexcel.php" target="_blank">Yes</a><?
			}
		
	?></td>
    <td  align="center"><?
    	$db="dbnhkdb";
		$sql=mssql_connect($host,$username,$password) or die("Cannot connect");
		mssql_select_db($db);
		$sql_sso="select * from tbadmin where empno='".$row['empno']."'";
		$result_sso=mssql_query($sql_sso);
		$num_sso = mssql_num_rows($result_sso);
		if($num_sso>0){
				?><a href="http://www.ipack-iwis.com/nhk/receive_nhk.php" target="_blank">Yes</a><?
			}
		
	?></td>
    <td  align="center"><?
    	$db="dinvb";
		$sql=mssql_connect($host,$username,$password) or die("Cannot connect");
		mssql_select_db($db);
		$sql_sso="select * from tbadmin where empno='".$row['empno']."'";
		$result_sso=mssql_query($sql_sso);
		$num_sso = mssql_num_rows($result_sso);
		if($num_sso>0){
					?><a href="http://www.ipack-iwis.com/inv/c_invoice.php" target="_blank">Yes</a><?
			}
		
	?></td>
    <td  align="center"><?
		$sql_sso="select * from tbadmin where empno='".$row['empno']."'";
		$result_sso=mssql_query($sql_sso);
		$num_sso = mssql_num_rows($result_sso);
		if($num_sso>0){
				?><a href="http://www.ipack-iwis.com/store/mat_stock.php" target="_blank">Yes</a><?
			}
		
	?></td>
    <td  align="center"><?
    	$db="diwishb";
		$sql=mssql_connect($host,$username,$password) or die("Cannot connect");
		mssql_select_db($db);
		$sql_sso="select * from tbadmin where empno='".$row['empno']."'";
		$result_sso=mssql_query($sql_sso);
		$num_sso = mssql_num_rows($result_sso);
		if($num_sso>0){
				?><a href="http://www.ipack-iwis.com/tsc/stock_mng2.php" target="_blank">Yes</a><?
			}
		
	?></td>
     <td  align="center"><?
    	$db="dbautolivdb";
		$sql=mssql_connect($host,$username,$password) or die("Cannot connect");
		mssql_select_db($db);
		$sql_sso="select * from tbadmin where empno='".$row['empno']."'";
		$result_sso=mssql_query($sql_sso);
		$num_sso = mssql_num_rows($result_sso);
		if($num_sso>0){
				?><a href="http://www.ipack-iwis.com/autoliv/view_pallet.php" target="_blank">Yes</a><?
			}
		
	?></td>
    </tr>
													<?
												}
												}
  ?>
  	
  </tbody>
  </table>
            


</div> 
            <!-- container -->
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
<script type='text/javascript' src='assets/plugins/form-daterangepicker/daterangepicker.min.js'></script> 
<script type='text/javascript' src='assets/plugins/form-datepicker/js/bootstrap-datepicker.js'></script> 
<script type='text/javascript' src='assets/plugins/form-daterangepicker/moment.min.js'></script> 

<script type='text/javascript' src='assets/demo/demo.js'></script> 

<script type='text/javascript' src='assets/js/jquery.dataTables.min.js'></script> 
<script type='text/javascript' src='assets/js/dataTables.bootstrap.min.js'></script> 


</body>
</html>