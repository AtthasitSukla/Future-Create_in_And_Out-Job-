<? 
session_start();
	
include("connect_inv.php"); 

include("library.php"); 
	$date_num=date("m/d/Y");
	$yyear=date("Y");
	$times=date("H:i:s",time());
	$date_time=date("m/d/Y H:i:s");
 ?>
<?

	 
	 function check_date_is_within_range($start_date, $end_date, $todays_date)
		{
		
		  $start_timestamp = strtotime($start_date);
		  $end_timestamp = strtotime($end_date);
		  $today_timestamp = strtotime($todays_date);
		
		  return (($today_timestamp >= $start_timestamp) && ($today_timestamp <= $end_timestamp));
		
		}
	
	$status = $_REQUEST['status'];
	$asset_no = $_REQUEST['asset_no'];
	$location = $_REQUEST['location'];
	$asset_group = $_REQUEST['asset_group'];
	$device_type = $_REQUEST['device_type'];
	$asset_status = $_REQUEST['asset_status'];
	
	
	
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>I-Wis HQ : Asset List</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="I-Wis">
	<meta name="author" content="The Red Team">

    <!-- <link href="assets/less/styles.less" rel="stylesheet/less" media="all">  -->
    <link rel="stylesheet" href="assets/css/styles.css?=140">
   <!-- <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600' rel='stylesheet' type='text/css'>-->

    <link href='assets/demo/variations/default.css' rel='stylesheet' type='text/css' media='all' id='styleswitcher'> 
    <link href='assets/demo/variations/default.css' rel='stylesheet' type='text/css' media='all' id='headerswitcher'> 
     
	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries. Placeholdr.js enables the placeholder attribute -->
	<!--[if lt IE 9]>
        <link rel="stylesheet" href="assets/css/ie8.css">
		<script type="text/javascript" src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/respond.js/1.1.0/respond.min.js"></script>
        <script type="text/javascript" src="assets/plugins/charts-flot/excanvas.min.js"></script>
	<![endif]-->

	<!-- The following CSS are included as plugins and can be removed if unused-->
<link rel='stylesheet' type='text/css' href='jquery-ui-timepicker-0.3.3/jquery.ui.timepicker.css' /> 
<link rel='stylesheet' type='text/css' href='assets/plugins/form-daterangepicker/daterangepicker-bs3.css' /> 
<link rel='stylesheet' type='text/css' href='assets/js/jqueryui.css' /> 
<link rel='stylesheet' type='text/css' href='assets/plugins/codeprettifier/prettify.css' /> 
<link rel='stylesheet' type='text/css' href='assets/plugins/form-toggle/toggles.css' /> 
<script type="text/javascript" src="assets/js/jquery-1.10.2.min.js"></script>





<!-- <script type="text/javascript" src="assets/js/less.js"></script> -->

<script>


function deldls(deliveryID){
				bootbox.confirm('ต้องการยกเลิก '+deliveryID+' ต้องการดำเนินการต่อหรือไม่', function(result) {
				if(result==true){
					$.post("getajax_delivery.php",{
					status:"deldls",
					deliveryID:deliveryID,
					
					sid:Math.random()}).done(function(data){
					
						window.location='viewdls.php';
							
						
						})
					}
				 }); 
	}


function confirm_createpo(pr_no){
	bootbox.confirm('ยืนยัน Open PO ต้องการบันทึกหรือไม่?', function(result) {
				if(result==true){
					
					$.post( "getajax_po.php", { 
						status: "openpo", 
						pr_no:pr_no,
						sid: Math.random() 
						})
					  .done(function( data ) {
					alert('Save Complete.');
					
					alert(data);
					window.location='create_po.php?pr_no='+pr_no+'&po_no='+data;
					
					  });
					}
				 }); 
	}
	
	
function print_all_location(location){
	
	
}
function print_asset_no(asset_no){
	window.open('popbarcode_asset_small.php?asset_no='+asset_no,'pop','width=800,height=700');
}
function export_data_asset(){
	var asset_group = $("#asset_group").val();
	var asset_status = $("#asset_status").val();
	var location = $("#location").val();
	window.open('export_asset.php?status=asset_list&asset_group='+asset_group+'&asset_status='+asset_status+'&location='+location);
}
</script>
</head>

<body class=" ">


    <div id="headerbar">
        <div class="container">
            
        </div>
    </div>

    <header class="navbar navbar-inverse navbar-fixed-top" role="banner">
        <a id="leftmenu-trigger" class="tooltips" data-toggle="tooltip" data-placement="right" title="Toggle Sidebar"></a>
       

        <div class="navbar-header pull-left">
           
        </div>

        
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
                        





<?
if($status==''){
	
	?>
    <table align="center" width="100%" border="0" cellspacing="2" cellpadding="0">
	 
       <tr>
	   <td width="8%" height="30" align="right"><strong>Search Asset No</strong></td>
      
	   <td width="16%" style="padding-left:5px"><input type="text" class="form-control" value="<?=$asset_no?>"   maxlength="50" id="asset_no" style="width:150px;"></td>
	   <td width="13%"><select id="asset_group"  class="form-control " >
					<option value="">Select Group</option>
					<?
						$select="select * from tbasset_group where asset_group='Warehouse Equipment' order by id asc";
						$re=mssql_query($select);
						$num=mssql_num_rows($re);
						if($num>0){
							while($row=mssql_fetch_array($re)){  
							?> <option value="<?=$row['asset_group']?>" <?
								if($asset_group==$row['asset_group']){
									?> selected<?
								}
								?>><?=$row['asset_group']?></option><?
							}
						}
						?></select></td>
                        <td width="13%"><select id="device_type"  class="form-control " >
                            <option value="">Select Type</option> <?
						$select="select distinct device_type from tbasset where asset_group ='Warehouse Equipment' order by device_type asc";
						$re=mssql_query($select);
						$num=mssql_num_rows($re);
						if($num>0){
							while($row=mssql_fetch_array($re)){  
							?> <option value="<?=$row['device_type']?>" <?
								if($device_type==$row['device_type']){
									?> selected<?
								}
								?>><?=$row['device_type']?></option><?
							}
						}
						?></select></td>
                        <td width="20%"><select id="asset_status" class="form-control " >
                    <option value="">Select Condition</option>
                    <option value="normal_use" <?
                    if($asset_status=='normal_use'){
						?> selected<?
						}
					?>>ปกติ ยังใช้งานอยู่</option>
                    
                    <option value="normal_nouse" <?
                    if($asset_status=='normal_nouse'){
						?> selected<?
						}
					?>>ปกติ ไม่ใช้งาน</option>
                    
                     <option value="abnormal" <?
                    if($asset_status=='abnormal'){
						?> selected<?
						}
					?>>ผิดปกติ ใช้งานไม่ได้ เสีย</option>
                    
                    <option value="disappear" <?
                    if($asset_status=='disappear'){
						?> selected<?
						}
					?>>สูญหาย</option>
                    
                    </select></td>
	   <td width="11%"><select id="location"  class="form-control " >
    <option value="">All Location</option>
    <?
	
	//where location<>'OSW'
     	$select="select distinct location from tbasset order by location asc";
	$re=mssql_query($select);
	$num=mssql_num_rows($re);
	if($num>0){
	while($row=mssql_fetch_array($re)){  
	?> <option value="<?=$row['location']?>" <?
    if($location==$row['location']){
		?> selected<?
		}
	?>><?=$row['location']?></option><?
	 }
	}
	?>
     
    </select></td>
       <td width="5%" ><button class="btn-primary btn" onClick="location='view_asset_wh.php?asset_no='+document.getElementById('asset_no').value+'&asset_group='+document.getElementById('asset_group').value+'&device_type='+document.getElementById('device_type').value+'&location='+document.getElementById('location').value+'&asset_status='+document.getElementById('asset_status').value+''">ค้นหา</button></td>
       <td width="22%" >
		<?php
		if(!empty($location)){
			?>
			<a href="popbarcode_asset_small.php?location=<?=$location?>" target='_blank' id="print_all_location" class='btn btn-warning'  >Print ALL <?=$location?></a>
			<?php
		}
			?><button class="btn-primary btn" onClick="location='asset_pm.php'">PM Plan</button>
	   </td>
        <td width="5%" ><a href="asset_form_wh.php" target='_blank'  class='btn btn-warning'  >ทะเบียนรายการเครื่องจักรอุปกรณ์<?=$location?></a></td>
	   <td width="5%" ><button class="btn-success btn" onclick="export_data_asset()">Export</button></td>
	   <td width="5%" ><button class="btn-primary btn" onClick="location='asset_viewer_wh.php?status=add'">Add New</button></td>
       </tr>
	</table>
   <BR>
 <div class="table-responsive">    
	<table align="center" width="100%" border="0" cellspacing="2" cellpadding="0" class="table table-striped table-bordered datatables" id="example">
  <tr >
    <td width="6%" height="40" align="center"><strong>Item(รายการ)</strong></td>
    <td width="12%" align="center"><strong>Asset No.</strong></td>
     <td width="12%" align="center"><strong>Asset Name</strong></td>
     <td width="12%" align="center"><strong>Owner</strong></td>
     <td width="12%" align="center"><strong>Serial</strong></td>
    <td width="12%" align="center"><strong>Location</strong></td>
   
    <td width="12%" align="center"><strong>Asset Group</strong></td>
    <td width="9%" align="center"><strong>Type</strong></td>
    <td width="9%" align="center"><strong>PM</strong></td>
    <!--<td width="9%" align="center"><strong>Pic</strong></td>-->
    <td width="9%" align="center"><strong>View</strong></td>
   
    </tr>
    <?
	
		
			if($asset_no!=''){
				
				$select3="select  * from  tbasset   
				where asset_no like '%".$asset_no."%'  ";
				if($location!=''){
					$select3 = $select3."  and location='$location' ";
					
					}	
				if($asset_group!=''){
					$select3 = $select3."  and asset_group='$asset_group' ";
					
					}
				if($device_type!=''){
					$select3 = $select3."  and device_type='$device_type' ";
					
					}
					
				if($asset_status!=''){
					$select3 = $select3."  and asset_status='$asset_status' ";
					
					}
				
				}else{
					//and  location<>'OSW'
					$select3="select * from  tbasset where 1=1   ";
					if($location!=''){
					$select3 = $select3."  and location='$location'  ";
					
					}	
					if($asset_group!=''){
					$select3 = $select3."  and asset_group='$asset_group' ";
					
					}
					if($device_type!=''){
					$select3 = $select3."  and device_type='$device_type' ";
					
					}
					if($asset_status!=''){
					$select3 = $select3."  and asset_status='$asset_status' ";
					
					}
					}
					
				
					$select3 = $select3."  and asset_group ='Warehouse Equipment' order by asset_no asc ";
    	//echo $select3;
		$re3=mssql_query($select3);
		$i=0;
		while($row3=mssql_fetch_array($re3)){
			$i++;
		
			?>
			<tr >
    <td width="6%" height="40" align="center"><?=$i?>.</strong></td>
    
     <td width="12%" align="center"><?=$row3['asset_no'];?><br>
			<button class="btn btn-warning" id="print_asset_no" onclick="print_asset_no('<?=$row3['asset_no'];?>')">Print</button>
			</td>
      <td width="12%" align="center"><?=iconv("tis-620", "utf-8", $row3['asset_name'] );?><BR><?
      if($row3['asset_status']=='normal_use'){
		 ?><span style="background-color:#B3FFB3">ปกติ ยังใช้งานอยู่</span><?
		  }
		 if($row3['asset_status']=='normal_nouse'){
		 ?><span style="background-color:#FFFF95">ปกติ ไม่ใช้งาน</span><?
		  }
		  if($row3['asset_status']=='abnormal'){
		 ?><span style="background-color:#FFA87D">ผิดปกติ ใช้งานไม่ได้ เสีย</span><BR><span style="background-color:#FFC"><?=lang_thai_from_database($row3['asset_action']);?></span><?
		  }
		   if($row3['asset_status']=='disappear'){
		 ?><span style="background-color:#B1B1B1">สูยหาย</span><?
		  }
	  ?></td>
      <td width="12%" align="center"><?
      
	 			//$host2="WIN-GRCB1K9LF1N";
				//$username2="sloxixa";
				//$password2="eaotft139@%";
				$empno1 = $row3['empno'];
				if($empno1!=''){
					$db2="dhrdb";
				$sql2=mssql_connect($host,$username,$password) or die("Cannot connect");
				mssql_select_db($db2);
				
	  $sqlemp = "select empno,site,firstname,lastname,nickname from tbemployee where empno='".$empno1."'";
 //   echo   $sqlemp;
	$resemp = mssql_query($sqlemp);
    $rowemp = mssql_fetch_array($resemp);
        $empno_query = $rowemp["empno"];
        $site = $rowemp["site"];
        $firstname = lang_thai_from_database($rowemp["firstname"]);
        $lastname = lang_thai_from_database($rowemp["lastname"]);
        $nickname = lang_thai_from_database($rowemp["nickname"]);
        $full_name_nickname = "$firstname $lastname ($nickname)";
		
		echo $full_name_nickname;
	  			
				//$sql2=mssql_connect($host,$username,$password) or die("Cannot connect");
				mssql_select_db($db);
					}
				
	  
	  
	  
	  ?></td>
     <td width="12%" align="center"><?=iconv("tis-620", "utf-8", $row3['serialnumber'] );?></td>
    <td width="12%" align="center"><?=$row3['location'];?></td>
      <td width="12%" align="center"><?=iconv("tis-620", "utf-8", $row3['asset_group'] );?></td>
      <td width="9%" align="center"><?=$row3['device_type'];?></td>
      <td width="9%" align="center"><?
      
	 $selectp="select distinct month,datepm from tbasset_pm_result where asset_no = '".$row3['asset_no']."' and year ='$yyear' order by datepm asc ";
				$rep=mssql_query($selectp);
				$nump=mssql_num_rows($rep);
				if($nump>0){
					
					while($rowp=mssql_fetch_array($rep)){
						
						?><span style="background-color:#80FF80"><?=$rowp['month'];?> | </span><?
						}
					
						
					
					}
	  
	 
						?></td>
     <!-- <td width="9%" align="center">--><?
     // $select1="select * from  tbasset_picture where asset_no='".$row3['asset_no']."'  and pos = '1' ";
//	$re1=mssql_query($select1);
//	$num1 =mssql_num_rows($re1);
//	if($num1>0){
//		$row1=mssql_fetch_array($re1);
//			$picpic = "asset_picture/".$row3['asset_no']."_1.jpg";
//			$picpic = "showpicture_asset.php?filename=".$picpic;
//			$picpic = $picpic."&id=".$row1['id'];
//		}else{
//			$picpic = "images/cam.png";
//			}
	  ?>  <!--<img  src="<?//=$picpic;?>" width="50"/></td>-->
      <td width="9%" align="center"><input type="button" value="View" onClick="location='asset_viewer_wh.php?asset_no=<?=$row3['asset_no']?>'"></td>
    
    </tr>
			<?
			}
	?>
    </table>
</div>

	<?
	
	}
?>	


		


			


	  

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
<script type='text/javascript' src='assets/plugins/sparklines/jquery.sparklines.min.js'></script> 
<script type='text/javascript' src='assets/plugins/form-toggle/toggle.min.js'></script> 
<script type='text/javascript' src='assets/js/placeholdr.js'></script> 
<script type='text/javascript' src='assets/js/application.js'></script> 
<script type='text/javascript' src='assets/plugins/bootbox/bootbox.min.js'></script> 
<script type='text/javascript' src='jquery-ui-timepicker-0.3.3/jquery.ui.timepicker.js'></script> 
<script type='text/javascript' src='assets/plugins/form-daterangepicker/daterangepicker.min.js'></script> 
<script type='text/javascript' src='assets/plugins/bootbox/bootbox.min.js'></script>
<script type='text/javascript' src='assets/plugins/form-datepicker/js/bootstrap-datepicker.js'></script> 
<script type='text/javascript' src='assets/plugins/form-typeahead/typeahead.min.js'></script> 








</body>
</html>