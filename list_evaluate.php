<? 
session_start();
include("connect.php");
include("library.php");

$ddate = date('m/d/Y');
$mmonth = $_REQUEST['mmonth'];
$yyear = $_REQUEST['yyear'];
$arr_month = array('','Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');
if($yyear==''){
$yyear = date('Y');
}
if($mmonth==''){
$mmonth = date('n');//'9';//
}
function check_edit($emp_level,$zone){
	$edit = 0;
	if($zone=='company'){
	if($emp_level=='8'){
	$edit = 1;
	}
if($emp_level=='7' || $emp_level=='6' || $emp_level=='5'){
	$edit = 0;
	}
if($emp_level=='4'){
	$edit = 0;
	}
if($emp_level=='3' || $emp_level=='2'){
	$edit = 0;
	}
if($emp_level=='1'){
	$edit = 0;
	}
	}
	if($zone=='manager'){
	if($emp_level=='8'){
	$edit = 1;
	}
if($emp_level=='7' || $emp_level=='6' || $emp_level=='5'){
	$edit = 1;
	}
if($emp_level=='4'){
	$edit = 0;
	}
if($emp_level=='3' || $emp_level=='2'){
	$edit = 0;
	}
if($emp_level=='1'){
	$edit = 0;
	}
	}
	if($zone=='assist'){
	if($emp_level=='8'){
	$edit = 1;
	}
if($emp_level=='7' || $emp_level=='6' || $emp_level=='5'){
	$edit = 1;
	}
if($emp_level=='4'){
	$edit = 1;
	}
if($emp_level=='3' || $emp_level=='2'){
	$edit = 0;
	}
if($emp_level=='1'){
	$edit = 0;
	}
	}
	if($zone=='sup'){
	if($emp_level=='8'){
	$edit = 1;
	}
if($emp_level=='7' || $emp_level=='6' || $emp_level=='5'){
	$edit = 1;
	}
if($emp_level=='4'){
	$edit = 1;
	}
if($emp_level=='3' || $emp_level=='2'){
	$edit = 0;
	}
if($emp_level=='1'){
	$edit = 0;
	}
	}
	if($zone=='staff'){
	if($emp_level=='8'){
	$edit = 0;
	}
if($emp_level=='7' || $emp_level=='6' || $emp_level=='5'){
	$edit = 1;
	}
if($emp_level=='4'){
	$edit = 1;
	}
if($emp_level=='3' || $emp_level=='2'){
	$edit = 1;
	}
if($emp_level=='1'){
	$edit = 0;
	}
	}
	
	
	return $edit;
	
}
function check_view($emp_level,$zone){
	$edit = 0;
	if($zone=='company'){
	if($emp_level=='8'){
	$edit = 1;
	}
if($emp_level=='7' || $emp_level=='6' || $emp_level=='5'){
	$edit = 1;
	}
if($emp_level=='4'){
	$edit = 1;
	}
if($emp_level=='3' || $emp_level=='2'){
	$edit = 1;
	}
if($emp_level=='1'){
	$edit = 1;
	}
	}
	if($zone=='manager'){
	if($emp_level=='8'){
	$edit = 1;
	}
if($emp_level=='7' || $emp_level=='6' || $emp_level=='5'){
	$edit = 1;
	}
if($emp_level=='4'){
	$edit = 1;
	}
if($emp_level=='3' || $emp_level=='2'){
	$edit = 1;
	}
if($emp_level=='1'){
	$edit = 1;
	}
	}
	if($zone=='assist'){
	if($emp_level=='8'){
	$edit = 1;
	}
if($emp_level=='7' || $emp_level=='6' || $emp_level=='5'){
	$edit = 1;
	}
if($emp_level=='4'){
	$edit = 1;
	}
if($emp_level=='3' || $emp_level=='2'){
	$edit = 1;
	}
if($emp_level=='1'){
	$edit = 1;
	}
	}
	if($zone=='sup'){
	if($emp_level=='8'){
	$edit = 1;
	}
if($emp_level=='7' || $emp_level=='6' || $emp_level=='5'){
	$edit = 1;
	}
if($emp_level=='4'){
	$edit = 1;
	}
if($emp_level=='3' || $emp_level=='2'){
	$edit = 1;
	}
if($emp_level=='1'){
	$edit = 1;
	}
	}
	if($zone=='staff'){
	if($emp_level=='8'){
	$edit = 1;
	}
if($emp_level=='7' || $emp_level=='6' || $emp_level=='5'){
	$edit = 1;
	}
if($emp_level=='4'){
	$edit = 1;
	}
if($emp_level=='3' || $emp_level=='2'){
	$edit = 1;
	}
if($emp_level=='1'){
	$edit = 1;
	}
	}
	
	
	return $edit;
	
}
function check_evaluate($emp_level,$zone){
	$edit = 0;
	if($zone=='company'){
	if($emp_level=='8'){
	$edit = 1;
	}
if($emp_level=='7' || $emp_level=='6' || $emp_level=='5'){
	$edit = 0;
	}
if($emp_level=='4'){
	$edit = 0;
	}
if($emp_level=='3' || $emp_level=='2'){
	$edit = 0;
	}
if($emp_level=='1'){
	$edit = 0;
	}
	}
	if($zone=='manager'){
	if($emp_level=='8'){
	$edit = 1;
	}
if($emp_level=='7' || $emp_level=='6' || $emp_level=='5'){
	$edit = 1;
	}
if($emp_level=='4'){
	$edit = 0;
	}
if($emp_level=='3' || $emp_level=='2'){
	$edit = 0;
	}
if($emp_level=='1'){
	$edit = 0;
	}
	}
	if($zone=='assist'){
	if($emp_level=='8'){
	$edit = 1;
	}
if($emp_level=='7' || $emp_level=='6' || $emp_level=='5'){
	$edit = 1;
	}
if($emp_level=='4'){
	$edit = 1;
	}
if($emp_level=='3' || $emp_level=='2'){
	$edit = 0;
	}
if($emp_level=='1'){
	$edit = 0;
	}
	}
	if($zone=='sup'){
	if($emp_level=='8'){
	$edit = 1;
	}
if($emp_level=='7' || $emp_level=='6' || $emp_level=='5'){
	$edit = 1;
	}
if($emp_level=='4'){
	$edit = 1;
	}
if($emp_level=='3' || $emp_level=='2'){
	$edit = 0;
	}
if($emp_level=='1'){
	$edit = 0;
	}
	}
	if($zone=='staff'){
	if($emp_level=='8'){
	$edit = 0;
	}
if($emp_level=='7' || $emp_level=='6' || $emp_level=='5'){
	$edit = 1;
	}
if($emp_level=='4'){
	$edit = 1;
	}
if($emp_level=='3' || $emp_level=='2'){
	$edit = 0;
	}
if($emp_level=='1'){
	$edit = 0;
	}
	}
	
	
	return $edit;
	
}

	





?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<title>I-Wis HRS : Evaluate List</title>
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

		#tr_h {
			font-size: 18px;
		}

		.ui-draggable,
		.ui-droppable {
			background-position: top;
		}
	</style>
	<script>
		$(function() {

			var table = $('#tb_eva_list').DataTable({
				"order": [
					[0, "asc"]
				],
				"pageLength": 100
			});
		});

		function myTrim(x) {
			return x.replace(/^\s+|\s+$/gm, '')
		}

		function create_new(eva_period, empno) {

			$.post("getajax_evaluate.php", {
				status: "create_new",
				eva_period: eva_period,
				empno: empno,
				sid: Math.random()
			}).done(function(data) {
				var aa = myTrim(data);
				window.location = 'form_evaluate.php?eva_period=' + eva_period + '&eva_id=' + aa + '&empno=' + empno;
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


							Year <select id="yyear">
								<?
            for($i=2020;$i<=2020;$i++){
				?>
								<option value="<?= $i ?>" <? if($yyear==$i){ ?> selected
									<?
					}
				?>><?= $i ?>
								</option>
								<?
				}
			?>
							</select>&nbsp;<input type="button" value="Submit" onClick="location='truck_transaction_form.php?mmonth='+document.getElementById('mmonth').value+'&yyear='+document.getElementById('yyear').value+''">




							<HR>
							<?
		$edit = check_edit($_SESSION['emp_level'],'company');
		$view = check_view($_SESSION['emp_level'],'company');
		$evaluate = check_evaluate($_SESSION['emp_level'],'company');

?>

							<table align="center" width="100%" border="0" cellspacing="2" cellpadding="0" class="table table-striped table-bordered datatables" id="example">
								<tr>
									<td width="9%" height="25" align="center">
										<h4><strong>Company</strong></h4>
									</td>
									<td width="12%" align="center">&nbsp;</td>
									<td width="17%" align="center">&nbsp;</td>
									<td width="13%" align="center">&nbsp;</td>
									<td width="30%" align="center">&nbsp;</td>
									<td width="19%" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td height="25" align="center" bgcolor="#CCCCCC"><strong>No.</strong></td>
									<td align="center" bgcolor="#CCCCCC"><strong>Department</strong></td>
									<td align="center" bgcolor="#CCCCCC"><strong>Position</strong></td>
									<td align="center" bgcolor="#CCCCCC"><strong>Name</strong></td>
									<td align="center" bgcolor="#CCCCCC"><strong>Quarter</strong></td>
									<td width="19%" align="center" bgcolor="#CCCCCC"><strong>Score</strong></td>
								</tr>
								<?
 					
					
					if($edit==1){	
				$select = "select * from tbemployee where delstatus='0' and empno='56002' and departmentid in(select control_dept from tbposition_dept where positionid='".$_SESSION['positionid']."') order by emp_level desc";
					}else{
						$select = "select * from tbemployee where delstatus='0' and empno='56002' and positionid in(select positionid from tbposition_dept where control_dept='".$_SESSION['departmentid']."') order by emp_level desc";
						}
				//echo $select;
					
					
					$re = mssql_query($select);
					$num=mssql_num_rows($re);
					if($num>0){
						$i=0;
					 while($row = mssql_fetch_array($re)){
						 $i++;
						 
						 
							?>
								<tr>
									<td height="25" align="center" bgcolor="#FFFFFF"><?= $i ?>.</td>
									<td height="25" align="center" bgcolor="#FFFFFF">
										<?
    echo get_departmentname($row['departmentid']);
	?>
									</td>
									<td height="25" align="center" bgcolor="#FFFFFF">
										<?
     echo get_positionname($row['positionid']);
	 ?>
									</td>
									<td height="25" align="center" bgcolor="#FFFFFF">
										<?
     echo get_full_name($row['empno']);
	 ?>
									</td>
									<td align="center" bgcolor="#FFFFFF">
										<?
	if($yyear!=date('Y')){
    				$select2 = "select * from  tbevaluate_period  where eva_year = '$yyear'";
		}else{
			    	//$select2 = "select * from  tbevaluate_period  where  (GETDATE() BETWEEN eva_startdate AND eva_enddate) and eva_year = '$yyear'";
					$select2 = "select * from  tbevaluate_period  where eva_year = '$yyear'";

	 }
					$re2 = mssql_query($select2);
					$num2=mssql_num_rows($re2);
					if($num2>0){
						$eva_total_score = 0;
						$iscore=0;
						 while($row2 = mssql_fetch_array($re2)){
					
					
					$eva_id='';
					$selecte = "select * from tbevaluate where empno='".$row['empno']."' and eva_period='".$row2['eva_period']."' and eva_total_score > 0 ";
					$ree = mssql_query($selecte);
					$nume=mssql_num_rows($ree);
					if($nume<=0){
						$bg = "#FFC";
						}else{
							
							$bg = "#66FF66";
							$iscore++;
							}
							
							
					$selecte2 = "select * from tbevaluate where empno='".$row['empno']."' and eva_period='".$row2['eva_period']."' ";
					$ree2 = mssql_query($selecte2);
					$nume2=mssql_num_rows($ree2);
					if($nume2<=0){
						$bg = "#ffffff";
						}else{
							$rowe2 = mssql_fetch_array($ree2);
							$eva_id = $rowe2['eva_id'];
							}
							 //#FFC yellow
							 //#6FC green
							 
						?>
										<table width="20%" style="float:left; background-color:<?= $bg ?>" border="1" cellspacing="0" cellpadding="0">
											<tr>
												<td align="center">
													<?
    if($eva_id==''){
		?><?= $row2['eva_period'] ?>
													<?
			}else{
		?><a target="_blank" href="form_evaluate.php?status=preview&eva_period=<?= $row2['eva_period'] ?>&eva_id=<?= $eva_id ?>&empno=<?= $row['empno'] ?>"><?= $row2['eva_period'] ?></a>
													<?
		}
	?>
												</td>
											</tr>
											<tr>
												<td align="center">
													<?
    
	$selecte = "select * from tbevaluate where empno='".$row['empno']."' and eva_period='".$row2['eva_period']."'";
					$ree = mssql_query($selecte);
					$nume=mssql_num_rows($ree);
					if($nume<=0){
						if($edit==1){
					?><input type="button" style="width:80px" value="Create" onClick="create_new('<?= $row2['eva_period'] ?>','<?= $row['empno'] ?>');">
													<?			
						}
					}else{
						$rowe = mssql_fetch_array($ree);
					
					if($edit==1){
					?><input type="button" style="width:80px" value="Edit" onClick="location='form_evaluate.php?eva_period=<?= $row2['eva_period'] ?>&eva_id=<?= $rowe['eva_id'] ?>&empno=<?= $row['empno'] ?>'">
													<?
					}
					if($evaluate==1){
					
					?><BR><input type="button" style="width:80px" value="Evaluate" onClick="location='form_evaluate.php?status=evaluate&eva_period=<?= $row2['eva_period'] ?>&eva_id=<?= $rowe['eva_id'] ?>&empno=<?= $row['empno'] ?>'">
													<?
					}
					?><BR>
													<?
                    echo $rowe['eva_total_score']."%";
					$eva_total_score = $eva_total_score + $rowe['eva_total_score'];
					
					?>
													<?		
					}
	
	
	?>
												</td>
											</tr>
										</table>



										<?
						 
						 
					 }
					}
	?>
									</td>
									<td align="center" bgcolor="#FFFFFF">
										<?
    if($iscore>0){
	?>
										<font size="4">
											<?
	
    echo $eva_total_score/$iscore;
	
	?>%
										</font>
										<?
    }
	?>
									</td>
								</tr>
								<?
					 	}
					}
 ?>
							</table>
							<BR>
							<?
		$edit = check_edit($_SESSION['emp_level'],'manager');
		$view = check_view($_SESSION['emp_level'],'manager');
		$evaluate = check_evaluate($_SESSION['emp_level'],'manager');
?>

							<table align="center" width="100%" border="0" cellspacing="2" cellpadding="0" class="table table-striped table-bordered datatables" id="example">
								<tr>
									<td width="9%" height="25" align="center">
										<h4><strong>Manager</strong></h4>
									</td>
									<td width="12%" align="center">&nbsp;</td>
									<td width="17%" align="center">&nbsp;</td>
									<td width="13%" align="center">&nbsp;</td>
									<td width="30%" align="center">&nbsp;</td>
									<td width="19%" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td height="25" align="center" bgcolor="#CCCCCC"><strong>No.</strong></td>
									<td align="center" bgcolor="#CCCCCC"><strong>Department</strong></td>
									<td align="center" bgcolor="#CCCCCC"><strong>Position</strong></td>
									<td align="center" bgcolor="#CCCCCC"><strong>Name</strong></td>
									<td align="center" bgcolor="#CCCCCC"><strong>Quarter</strong></td>
									<td width="19%" align="center" bgcolor="#CCCCCC"><strong>Score</strong></td>
								</tr>
								<?
 					
					//if($_SESSION['emp_level']=='8'){
//						$select = "select * from tbemployee where delstatus='0' and emp_level in('5','6','7') order by emp_level desc";
//							}else{
//								if($edit==1){
//									$select = "select * from tbemployee where delstatus='0' and emp_level in('5','6','7') and empno='".$_SESSION['admin_userid']."' order by emp_level desc";
//									}else{
//										$select = "select * from tbemployee where delstatus='0' and emp_level in('5','6','7') and departmentid='".$_SESSION['departmentid']."' order by emp_level desc";
//										}
//						
//						}
					if($edit==1){	
				$select = "select * from tbemployee where delstatus='0' and emp_level in('5','6','7') and departmentid in(select control_dept from tbposition_dept where positionid='".$_SESSION['positionid']."') order by site,emp_level desc";
					}else{
						$select = "select * from tbemployee where delstatus='0' and emp_level in('5','6','7') and positionid in(select positionid from tbposition_dept where control_dept='".$_SESSION['departmentid']."') order by site,emp_level desc";
						}
				//echo $select;
					
					
					$re = mssql_query($select);
					$num=mssql_num_rows($re);
					if($num>0){
						$i=0;
					 while($row = mssql_fetch_array($re)){
						 $i++;
						 
						 
							?>
								<tr>
									<td height="25" align="center" bgcolor="#FFFFFF"><?= $i ?>.</td>
									<td height="25" align="center" bgcolor="#FFFFFF">
										<?
    echo get_departmentname($row['departmentid']);
	?>
									</td>
									<td height="25" align="center" bgcolor="#FFFFFF">
										<?
     echo get_positionname($row['positionid']);
	 ?>
									</td>
									<td height="25" align="center" bgcolor="#FFFFFF">
										<?
     echo get_full_name($row['empno']);
	 ?>
									</td>
									<td align="center" bgcolor="#FFFFFF">
										<?
	if($yyear!=date('Y')){
    				$select2 = "select * from  tbevaluate_period  where eva_year = '$yyear'";
		}else{
			    	//$select2 = "select * from  tbevaluate_period  where  (GETDATE() BETWEEN eva_startdate AND eva_enddate) and eva_year = '$yyear'";
					$select2 = "select * from  tbevaluate_period  where eva_year = '$yyear'";

	 }
					$re2 = mssql_query($select2);
					$num2=mssql_num_rows($re2);
					if($num2>0){
						$eva_total_score = 0;
						$iscore=0;
						 while($row2 = mssql_fetch_array($re2)){
					
					$eva_id='';	 
					$selecte = "select * from tbevaluate where empno='".$row['empno']."' and eva_period='".$row2['eva_period']."' and eva_total_score > 0 ";
					$ree = mssql_query($selecte);
					$nume=mssql_num_rows($ree);
					if($nume<=0){
						$bg = "#FFC";
						}else{
							
							$bg = "#66FF66";
							$iscore++;
							}
					
					$selecte2 = "select * from tbevaluate where empno='".$row['empno']."' and eva_period='".$row2['eva_period']."' ";
					$ree2 = mssql_query($selecte2);
					$nume2=mssql_num_rows($ree2);
					if($nume2<=0){
						$bg = "#ffffff";
						}else{
							$rowe2 = mssql_fetch_array($ree2);
							$eva_id = $rowe2['eva_id'];
							}
							 //#FFC yellow
							 //#6FC green
							 
						?>
										<table width="20%" style="float:left; background-color:<?= $bg ?>" border="1" cellspacing="0" cellpadding="0">
											<tr>
												<td align="center">
													<?
    if($eva_id==''){
		?><?= $row2['eva_period'] ?>
													<?
			}else{
		?><a target="_blank" href="form_evaluate.php?status=preview&eva_period=<?= $row2['eva_period'] ?>&eva_id=<?= $eva_id ?>&empno=<?= $row['empno'] ?>"><?= $row2['eva_period'] ?></a>
													<?
		}
	?>
												</td>
											</tr>
											<tr>
												<td align="center">
													<?
    
	$selecte = "select * from tbevaluate where empno='".$row['empno']."' and eva_period='".$row2['eva_period']."'";
					$ree = mssql_query($selecte);
					$nume=mssql_num_rows($ree);
					if($nume<=0){
						if($edit==1){
					?><input type="button" style="width:80px" value="Create" onClick="create_new('<?= $row2['eva_period'] ?>','<?= $row['empno'] ?>');">
													<?			
						}
					}else{
						$rowe = mssql_fetch_array($ree);
					
					if($edit==1){
					?><input type="button" style="width:80px" value="Edit" onClick="location='form_evaluate.php?eva_period=<?= $row2['eva_period'] ?>&eva_id=<?= $rowe['eva_id'] ?>&empno=<?= $row['empno'] ?>'">
													<?
					}
					
					?><BR>
													<?
                    if($evaluate==1){
						if(DateDiff($ddate,$row2['eva_deadline'])<0){
							?>
													<font color="red">Overdue</font>
													<?
							}else{
							?><input type="button" style="width:80px" value="Evaluate" onClick="location='form_evaluate.php?status=evaluate&eva_period=<?= $row2['eva_period'] ?>&eva_id=<?= $rowe['eva_id'] ?>&empno=<?= $row['empno'] ?>'">
													<?
							}
					
					}
					?><BR>
													<?
                    echo $rowe['eva_total_score']."%";
					$eva_total_score = $eva_total_score + $rowe['eva_total_score'];
					?>
													<?		
					}
	
	
	?>
												</td>
											</tr>
										</table>

										<?
					
						 
						 
						 ?>

										<?
						 
						 
					 }
					}
	?>
									</td>
									<td align="center" bgcolor="#FFFFFF">
										<?
    if($iscore>0){
	?>
										<font size="4">
											<?
	
    echo $eva_total_score/$iscore;
	
	?>%
										</font>
										<?
    }
	?>
									</td>
								</tr>
								<?
					 	}
					}
 ?>
							</table>
							<BR>
							<?
		$edit = check_edit($_SESSION['emp_level'],'assist');
		$view = check_view($_SESSION['emp_level'],'assist');
		$evaluate = check_evaluate($_SESSION['emp_level'],'assist');

?>

							<table align="center" width="100%" border="0" cellspacing="2" cellpadding="0" class="table table-striped table-bordered datatables" id="example">
								<tr>
									<td width="9%" height="25" align="center">
										<h4><strong>Assist Manager</strong></h4>
									</td>
									<td width="12%" align="center">&nbsp;</td>
									<td width="17%" align="center">&nbsp;</td>
									<td width="13%" align="center">&nbsp;</td>
									<td width="30%" align="center">&nbsp;</td>
									<td width="19%" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td height="25" align="center" bgcolor="#CCCCCC"><strong>No.</strong></td>
									<td align="center" bgcolor="#CCCCCC"><strong>Department</strong></td>
									<td align="center" bgcolor="#CCCCCC"><strong>Position</strong></td>
									<td align="center" bgcolor="#CCCCCC"><strong>Name</strong></td>
									<td align="center" bgcolor="#CCCCCC"><strong>Quarter</strong></td>
									<td width="19%" align="center" bgcolor="#CCCCCC"><strong>Score</strong></td>
								</tr>
								<?
  
  //if($_SESSION['emp_level']=='8'){
//						$select = "select * from tbemployee where delstatus='0' and emp_level in('4') order by emp_level desc";
//							}else{
//								if($edit==1){
//									$select = "select * from tbemployee where delstatus='0' and emp_level in('4') and departmentid='".$_SESSION['departmentid']."' order by emp_level desc";
//									}else{
//										$select = "select * from tbemployee where delstatus='0' and emp_level in('4') and departmentid='".$_SESSION['departmentid']."' order by emp_level desc";
//										}
//						
//						}

			if($edit==1){	
				$select = "select * from tbemployee where delstatus='0' and emp_level in('4') and departmentid in(select control_dept from tbposition_dept where positionid='".$_SESSION['positionid']."') order by site,emp_level desc";
					}else{
						$select = "select * from tbemployee where delstatus='0' and emp_level in('4') and positionid in(select positionid from tbposition_dept where control_dept='".$_SESSION['departmentid']."') order by site,emp_level desc";
						}
					
					//	echo $select;
 					
					$re = mssql_query($select);
					$num=mssql_num_rows($re);
					if($num>0){
						$i=0;
					 while($row = mssql_fetch_array($re)){
						 $i++;
						 
						 
							?>
								<tr>
									<td height="25" align="center" bgcolor="#FFFFFF"><?= $i ?>.</td>
									<td height="25" align="center" bgcolor="#FFFFFF">
										<?
    echo get_departmentname($row['departmentid']);
	?>
									</td>
									<td height="25" align="center" bgcolor="#FFFFFF">
										<?
     echo get_positionname($row['positionid']);
	 ?>
									</td>
									<td height="25" align="center" bgcolor="#FFFFFF">
										<?
     echo get_full_name($row['empno']);
	 ?>
									</td>
									<td align="center" bgcolor="#FFFFFF">
										<?
	if($yyear!=date('Y')){
    				$select2 = "select * from  tbevaluate_period  where eva_year = '$yyear'";
		}else{
			    	//$select2 = "select * from  tbevaluate_period  where  (GETDATE() BETWEEN eva_startdate AND eva_enddate) and eva_year = '$yyear'";
					$select2 = "select * from  tbevaluate_period  where eva_year = '$yyear'";

	 }
					$re2 = mssql_query($select2);
					$num2=mssql_num_rows($re2);
					if($num2>0){
						$eva_total_score = 0;
						$iscore=0;
						 while($row2 = mssql_fetch_array($re2)){
					
					$eva_id='';		 
					$selecte = "select * from tbevaluate where empno='".$row['empno']."' and eva_period='".$row2['eva_period']."' and eva_total_score > 0  ";
					$ree = mssql_query($selecte);
					$nume=mssql_num_rows($ree);
					if($nume<=0){
						$bg = "#FFC";
						}else{
							
							$bg = "#66FF66";
							$iscore++;
							}
					
					$selecte2 = "select * from tbevaluate where empno='".$row['empno']."' and eva_period='".$row2['eva_period']."' ";
					$ree2 = mssql_query($selecte2);
					$nume2=mssql_num_rows($ree2);
					if($nume2<=0){
						$bg = "#ffffff";
						}else{
							$rowe2 = mssql_fetch_array($ree2);
							$eva_id = $rowe2['eva_id'];
							}
							 //#FFC yellow
							 //#6FC green
							 
						?>
										<table width="20%" style="float:left; background-color:<?= $bg ?>" border="1" cellspacing="0" cellpadding="0">
											<tr>
												<td align="center">
													<?
    if($eva_id==''){
		?><?= $row2['eva_period'] ?>
													<?
			}else{
		?><a target="_blank" href="form_evaluate.php?status=preview&eva_period=<?= $row2['eva_period'] ?>&eva_id=<?= $eva_id ?>&empno=<?= $row['empno'] ?>"><?= $row2['eva_period'] ?></a>
													<?
		}
	?>
												</td>
											</tr>
											<tr>
												<td align="center">
													<?
    
	$selecte = "select * from tbevaluate where empno='".$row['empno']."' and eva_period='".$row2['eva_period']."'";
					$ree = mssql_query($selecte);
					$nume=mssql_num_rows($ree);
					if($nume<=0){
						if($edit==1){
					?><input type="button" style="width:80px" value="Create" onClick="create_new('<?= $row2['eva_period'] ?>','<?= $row['empno'] ?>');">
													<?			
						}
					}else{
						$rowe = mssql_fetch_array($ree);
					
					if($edit==1){
					?><input type="button" style="width:80px" value="Edit" onClick="location='form_evaluate.php?eva_period=<?= $row2['eva_period'] ?>&eva_id=<?= $rowe['eva_id'] ?>&empno=<?= $row['empno'] ?>'">
													<?
					}
					?><BR>
													<?
					if($evaluate==1){
						if(DateDiff($ddate,$row2['eva_deadline'])<0){
							?>
													<font color="red">Overdue</font>
													<?
							}else{
							?><input type="button" style="width:80px" value="Evaluate" onClick="location='form_evaluate.php?status=evaluate&eva_period=<?= $row2['eva_period'] ?>&eva_id=<?= $rowe['eva_id'] ?>&empno=<?= $row['empno'] ?>'">
													<?
							}
					
					}
					?><BR>
													<?
                    echo $rowe['eva_total_score']."%";
					$eva_total_score = $eva_total_score + $rowe['eva_total_score'];
					?>
													<?		
					}
	
	
	?>
												</td>
											</tr>
										</table>

										<?
					
						 
						 
						 ?>

										<?
						 
						 
					 }
					}
	?>
									</td>
									<td align="center" bgcolor="#FFFFFF">
										<?
    if($iscore>0){
	?>
										<font size="4">
											<?
	
    echo $eva_total_score/$iscore;
	
	?>%
										</font>
										<?
    }
	?>
									</td>
								</tr>
								<?
					 	}
					}
 ?>
							</table>
							<BR>
							<?
		$edit = check_edit($_SESSION['emp_level'],'sup');
		$view = check_view($_SESSION['emp_level'],'sup');
		$evaluate = check_evaluate($_SESSION['emp_level'],'sup');

?>
							<table align="center" width="100%" border="0" cellspacing="2" cellpadding="0" class="table table-striped table-bordered datatables" id="example">
								<tr>
									<td width="11%" height="25" align="center">
										<h4><strong>Supervisor, Leader</strong></h4>
									</td>
									<td width="12%" align="center">&nbsp;</td>
									<td width="16%" align="center">&nbsp;</td>
									<td width="13%" align="center">&nbsp;</td>
									<td width="29%" align="center">&nbsp;</td>
									<td width="19%" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td height="25" align="center" bgcolor="#CCCCCC"><strong>No.</strong></td>
									<td align="center" bgcolor="#CCCCCC"><strong>Department</strong></td>
									<td align="center" bgcolor="#CCCCCC"><strong>Position</strong></td>
									<td align="center" bgcolor="#CCCCCC"><strong>Name</strong></td>
									<td align="center" bgcolor="#CCCCCC"><strong>Quarter</strong></td>
									<td width="19%" align="center" bgcolor="#CCCCCC"><strong>Score</strong></td>
								</tr>
								<?
 				//	$select = "select * from tbemployee where delstatus='0' and emp_level in('2','3') order by emp_level desc";
				
				if($edit==1){	
				$select = "select * from tbemployee where delstatus='0' and emp_level in('2','3') and departmentid in(select control_dept from tbposition_dept where positionid='".$_SESSION['positionid']."') order by site,emp_level desc";
					}else{
						$select = "select * from tbemployee where delstatus='0' and emp_level in('2','3') and positionid in(select positionid from tbposition_dept where control_dept='".$_SESSION['departmentid']."') order by site,emp_level desc";
						}
					$re = mssql_query($select);
					$num=mssql_num_rows($re);
					if($num>0){
						$i=0;
					 while($row = mssql_fetch_array($re)){
						 $i++;
						 
						 
							?>
								<tr>
									<td height="25" align="center" bgcolor="#FFFFFF"><?= $i ?>.</td>
									<td height="25" align="center" bgcolor="#FFFFFF">
										<?
    echo get_departmentname($row['departmentid']);
	?>
									</td>
									<td height="25" align="center" bgcolor="#FFFFFF">
										<?
     echo get_positionname($row['positionid']);
	 ?>
									</td>
									<td height="25" align="center" bgcolor="#FFFFFF">
										<?
     echo get_full_name($row['empno']);
	 ?>
									</td>

									<td align="center" bgcolor="#FFFFFF">
										<?
	if($yyear!=date('Y')){
    				$select2 = "select * from  tbevaluate_period  where eva_year = '$yyear'";
		}else{
			    	//$select2 = "select * from  tbevaluate_period  where  (GETDATE() BETWEEN eva_startdate AND eva_enddate) and eva_year = '$yyear'";
					$select2 = "select * from  tbevaluate_period  where eva_year = '$yyear'";

	 }
					$re2 = mssql_query($select2);
					$num2=mssql_num_rows($re2);
					if($num2>0){
						$eva_total_score = 0;
						$iscore=0;
						 while($row2 = mssql_fetch_array($re2)){
					
					$eva_id='';		 
					$selecte = "select * from tbevaluate where empno='".$row['empno']."' and eva_period='".$row2['eva_period']."' and eva_total_score >0 ";
					$ree = mssql_query($selecte);
					$nume=mssql_num_rows($ree);
					if($nume<=0){
						$bg = "#FFC";
						}else{
							
							$bg = "#66FF66";
							$iscore++;
							}
					
					$selecte2 = "select * from tbevaluate where empno='".$row['empno']."' and eva_period='".$row2['eva_period']."' ";
					$ree2 = mssql_query($selecte2);
					$nume2=mssql_num_rows($ree2);
					if($nume2<=0){
						$bg = "#ffffff";
						}else{
							$rowe2 = mssql_fetch_array($ree2);
							$eva_id = $rowe2['eva_id'];
							}
							 //#FFC yellow
							 //#6FC green
							 
						?>
										<table width="20%" style="float:left; background-color:<?= $bg ?>" border="1" cellspacing="0" cellpadding="0">
											<tr>
												<td align="center">
													<?
    if($eva_id==''){
		?><?= $row2['eva_period'] ?>
													<?
			}else{
		?><a target="_blank" href="form_evaluate.php?status=preview&eva_period=<?= $row2['eva_period'] ?>&eva_id=<?= $eva_id ?>&empno=<?= $row['empno'] ?>"><?= $row2['eva_period'] ?></a>
													<?
		}
	?>
												</td>
											</tr>
											<tr>
												<td align="center">
													<?
    
	$selecte = "select * from tbevaluate where empno='".$row['empno']."' and eva_period='".$row2['eva_period']."'";
					$ree = mssql_query($selecte);
					$nume=mssql_num_rows($ree);
					if($nume<=0){
						if($edit==1){
					?><input type="button" style="width:80px" value="Create" onClick="create_new('<?= $row2['eva_period'] ?>','<?= $row['empno'] ?>');">
													<?			
						}
					}else{
						$rowe = mssql_fetch_array($ree);
					
					if($edit==1){
					?><input type="button" style="width:80px" value="Edit" onClick="location='form_evaluate.php?eva_period=<?= $row2['eva_period'] ?>&eva_id=<?= $rowe['eva_id'] ?>&empno=<?= $row['empno'] ?>'">
													<?
					}
					?><BR>
													<?
					if($evaluate==1){
						if(DateDiff($ddate,$row2['eva_deadline'])<0){
							?>
													<font color="red">Overdue</font>
													<?
							}else{
							?><input type="button" style="width:80px" value="Evaluate" onClick="location='form_evaluate.php?status=evaluate&eva_period=<?= $row2['eva_period'] ?>&eva_id=<?= $rowe['eva_id'] ?>&empno=<?= $row['empno'] ?>'">
													<?
							}
					
					}
					?><BR>
													<?
                    echo $rowe['eva_total_score']."%";
					$eva_total_score = $eva_total_score + $rowe['eva_total_score'];
					?>
													<?		
					}
	
	
	?>
												</td>
											</tr>
										</table>

										<?
					
						 
						 
						 ?>

										<?
						 
						 
					 }
					}
	?>
									</td>
									<td align="center" bgcolor="#FFFFFF">
										<?
    if($iscore>0){
	?>
										<font size="4">
											<?
	
    echo $eva_total_score/$iscore;
	
	?>%
										</font>
										<?
    }
	?>
									</td>
								</tr>
								<?
					 	}
					}
 ?>
							</table>
							<BR>
							<?
		$edit = check_edit($_SESSION['emp_level'],'staff');
		$view = check_view($_SESSION['emp_level'],'staff');
		$evaluate = check_evaluate($_SESSION['emp_level'],'staff');

?>
							<table align="center" width="100%" border="0" cellspacing="2" cellpadding="0" class="table table-striped table-bordered datatables" id="example">
								<tr>
									<td width="9%" height="25" align="center">
										<h4><strong>Staff</strong></h4>
									</td>
									<td width="14%" align="center">&nbsp;</td>
									<td width="15%" align="center">&nbsp;</td>
									<td width="13%" align="center">&nbsp;</td>
									<td width="30%" align="center">&nbsp;</td>
									<td width="19%" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td height="25" align="center" bgcolor="#CCCCCC"><strong>No.</strong></td>
									<td align="center" bgcolor="#CCCCCC"><strong>Department</strong></td>
									<td align="center" bgcolor="#CCCCCC"><strong>Position</strong></td>
									<td align="center" bgcolor="#CCCCCC"><strong>Name</strong></td>
									<td align="center" bgcolor="#CCCCCC"><strong>Quarter</strong></td>
									<td width="19%" align="center" bgcolor="#CCCCCC"><strong>Score</strong></td>
								</tr>
								<?
 					
					
					if($edit==1){	
				$select = "select * from tbemployee where delstatus='0' and emp_level in('1') and departmentid in(select control_dept from tbposition_dept where positionid='".$_SESSION['positionid']."') order by site,emp_level desc";
					}else{
						$select = "select * from tbemployee where delstatus='0' and emp_level in('1') and positionid in(select positionid from tbposition_dept where control_dept='".$_SESSION['departmentid']."') order by site,emp_level desc";
						}
					$re = mssql_query($select);
					$num=mssql_num_rows($re);
					if($num>0){
						$i=0;
					 while($row = mssql_fetch_array($re)){
						 $i++;
						 
						 
							?>
								<tr>
									<td height="25" align="center" bgcolor="#FFFFFF"><?= $i ?>.</td>
									<td height="25" align="center" bgcolor="#FFFFFF">
										<?
    echo get_departmentname($row['departmentid']);
	?>
									</td>
									<td height="25" align="center" bgcolor="#FFFFFF">
										<?
     echo get_positionname($row['positionid']);
	 ?>
									</td>
									<td height="25" align="center" bgcolor="#FFFFFF">
										<?
     echo get_full_name($row['empno']);
	 ?>
									</td>

									<td align="center" bgcolor="#FFFFFF">
										<?
	if($yyear!=date('Y')){
    				$select2 = "select * from  tbevaluate_period  where eva_year = '$yyear'";
		}else{
			    	//$select2 = "select * from  tbevaluate_period  where  (GETDATE() BETWEEN eva_startdate AND eva_enddate) and eva_year = '$yyear'";
					$select2 = "select * from  tbevaluate_period  where eva_year = '$yyear'";

	 }
					$re2 = mssql_query($select2);
					$num2=mssql_num_rows($re2);
					if($num2>0){
						$eva_total_score = 0;
						$iscore=0;
						 while($row2 = mssql_fetch_array($re2)){
					
					$eva_id='';		 
					$selecte = "select * from tbevaluate where empno='".$row['empno']."' and eva_period='".$row2['eva_period']."' and eva_total_score >0";
					$ree = mssql_query($selecte);
					$nume=mssql_num_rows($ree);
					if($nume<=0){
						$bg = "#FFC";
						}else{
							
							$bg = "#66FF66";
							$iscore++;
							}
					
					$selecte2 = "select * from tbevaluate where empno='".$row['empno']."' and eva_period='".$row2['eva_period']."' ";
					$ree2 = mssql_query($selecte2);
					$nume2=mssql_num_rows($ree2);
					if($nume2<=0){
						$bg = "#ffffff";
						}else{
							$rowe2 = mssql_fetch_array($ree2);
							$eva_id = $rowe2['eva_id'];
							}
							 //#FFC yellow
							 //#6FC green
							 
						?>
										<table width="20%" style="float:left; background-color:<?= $bg ?>" border="1" cellspacing="0" cellpadding="0">
											<tr>
												<td align="center">
													<?
    if($eva_id==''){
		?><?= $row2['eva_period'] ?>
													<?
			}else{
		?><a target="_blank" href="form_evaluate.php?status=preview&eva_period=<?= $row2['eva_period'] ?>&eva_id=<?= $eva_id ?>&empno=<?= $row['empno'] ?>"><?= $row2['eva_period'] ?></a>
													<?
		}
	?>
												</td>
											</tr>
											<tr>
												<td align="center">
													<?
    
	$selecte = "select * from tbevaluate where empno='".$row['empno']."' and eva_period='".$row2['eva_period']."'";
					$ree = mssql_query($selecte);
					$nume=mssql_num_rows($ree);
					if($nume<=0){
						if($edit==1){
					?><input type="button" style="width:80px" value="Create" onClick="create_new('<?= $row2['eva_period'] ?>','<?= $row['empno'] ?>');">
													<?			
						}
					}else{
						$rowe = mssql_fetch_array($ree);
					
					if($edit==1){
					?><input type="button" style="width:80px" value="Edit" onClick="location='form_evaluate.php?eva_period=<?= $row2['eva_period'] ?>&eva_id=<?= $rowe['eva_id'] ?>&empno=<?= $row['empno'] ?>'">
													<?
					}
					?><BR>
													<?
					if($evaluate==1){
						if(DateDiff($ddate,$row2['eva_deadline'])<0){
							?>
													<font color="red">Overdue</font>
													<?
							}else{
							?><input type="button" style="width:80px" value="Evaluate" onClick="location='form_evaluate.php?status=evaluate&eva_period=<?= $row2['eva_period'] ?>&eva_id=<?= $rowe['eva_id'] ?>&empno=<?= $row['empno'] ?>'">
													<?
							}
					
					}
					?><BR>
													<?
                   echo $rowe['eva_total_score']."%";
					$eva_total_score = $eva_total_score + $rowe['eva_total_score'];
					?>
													<?		
					}
	
	
	?>
												</td>
											</tr>
										</table>

										<?
					
						 
						 
						 ?>

										<?
						 
						 
					 }
					}
	?>
									</td>
									<td align="center" bgcolor="#FFFFFF">
										<?
    if($iscore>0){
	?>
										<font size="4">
											<?
	
    echo $eva_total_score/$iscore;
	
	?>%
										</font>
										<?
    }
	?>
									</td>
								</tr>
								<?
					 	}
					}
 ?>
							</table>




						</div>
					</div>
				</div> <!-- container -->
			</div>
			<!--wrap -->
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
		<div class="modal-dialog" style="width:700px">

			<!-- Modal content-->


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