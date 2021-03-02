<? include("connect.php");  ?>
<? include("library.php");  ?>
<?
	 
	$status = $_REQUEST['status'];
	//$status = $_REQUEST['status'];
	//$yyear = $_REQUEST['yyear'];
	//$mmonth = $_REQUEST['mmonth'];

$txtyear = date('Y');
$empno = $_REQUEST['empno'];
		
	
	
	 
	



	 
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>I-Wis HRS : Time Attendance Report</title>
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

<link rel='stylesheet' type='text/css' href='assets/plugins/codeprettifier/prettify.css' /> 
<link rel='stylesheet' type='text/css' href='assets/plugins/form-multiselect/css/multi-select.css' /> 
<link rel='stylesheet' type='text/css' href='assets/plugins/form-toggle/toggles.css' /> 
<script type="text/javascript" src="assets/js/jquery-1.10.2.min.js"></script>
<!--<script type="text/javascript" src="assets/js/less.js"></script>-->

<script>

	



	
	
</script>
</head>

<body class=" " bgcolor="#FFFFFF">
<?
if($status==''){
?>

<table cellspacing="0" cellpadding="0" border="1" width="500" align="center">
                      
                        <tr>
                        <td align="center" bgcolor="#CCCCCC"><strong>No.</strong></td>
                        <td align="center" bgcolor="#CCCCCC"><strong>Site</strong></td>
                       	  <td align="center" bgcolor="#CCCCCC"><strong>Empno</strong></td>
                             <td align="center" bgcolor="#CCCCCC"><strong>Name</strong></td>
                          <td align="center" bgcolor="#CCCCCC"  ><strong>Date</strong></td>
                          <td align="center" bgcolor="#CCCCCC"  ><strong>Day Name</strong></td>
                          <td align="center" bgcolor="#CCCCCC"  ><strong>Shift</strong></td>
                          <td align="center" bgcolor="#CCCCCC"  ><strong>Scan in</strong></td>
                        
                          <td align="center" bgcolor="#CCCCCC"  ><strong>Paycode</strong></td>
                        
                        </tr>
                        

<?
$i =1;
	
	$select_latey = "select convert(varchar, iattDateTime1, 108)as  iattDateTimes,(select site from tbemployee where empno=tbatt_approve.empno) as tsite,* from tbatt_approve where paycode in (SELECT paycode from tbpaycode WHERE paycodeyear='$txtyear') and ishift='Day' and cast(iattDateTime1 as time)>'08:01:00' and status_approve=1
			and empno='".$empno."' and cast(iattDateTime1 as date) not in(select leavestartdate from tbleave_transaction where empno='".$empno."')
			";
                                            $re_latey = mssql_query($select_latey);
											$num_latey = mssql_num_rows($re_latey);
											if($num_latey>0){
												
                                          while($row_latey = mssql_fetch_array($re_latey)){
											 ?> <tr>
      <td align="center" bgcolor="#FFFFFF"><?=$i?>.</td>
      <td align="center" bgcolor="#FFFFFF"><?=$row_latey['tsite']?></td>
                        	 <td align="center" bgcolor="#FFFFFF"><?=$row_latey['empno']?></td>
                             <td align="center" bgcolor="#FFFFFF"><?=get_full_name($row_latey['empno'])?></td>
                          <td align="center" bgcolor="#FFFFFF"  ><?=$row_latey['iworkdate']?></td>
                          <td align="center" bgcolor="#FFFFFF"  ><?=$row_latey['idayname_en']?></td>
                          <td align="center" bgcolor="#FFFFFF"  ><?=$row_latey['iShift']?></td>
                          <td align="center" bgcolor="#FFFFFF"  ><?=$row_latey['iattDateTimes']?></td>
                          <td align="center" bgcolor="#FFFFFF"  ><?=$row_latey['paycode']?></td>
                        
                        </tr><? 	
						$i++;
											  }
										//  $total_late_day =  $row_latey['total_late'];
												}
											$select_latey = "select convert(varchar, iattDateTime1, 108)as  iattDateTimes,(select site from tbemployee where empno=tbatt_approve.empno) as tsite,* from tbatt_approve where paycode in (SELECT paycode from tbpaycode WHERE paycodeyear='$txtyear') and ishift='Night' and cast(iattDateTime1 as time)>'20:21:00' and status_approve=1
			and empno='".$empno."'  and cast(iattDateTime1 as date) not in(select leavestartdate from tbleave_transaction where empno='".$empno."')
			";
                                            $re_latey = mssql_query($select_latey);
											$num_latey = mssql_num_rows($re_latey);
											if($num_latey>0){
                                          while($row_latey = mssql_fetch_array($re_latey)){
										  ?>
										  <tr>
                                           <td align="center" bgcolor="#FFFFFF"><?=$i?>.</td>
                                           <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
                        	 <td align="center" bgcolor="#FFFFFF"><?=$row_latey['empno']?></td>
                             <td align="center" bgcolor="#FFFFFF"><?=get_full_name($row_latey['empno'])?></td>
                          <td align="center" bgcolor="#FFFFFF"  ><?=$row_latey['iworkdate']?></td>
                          <td align="center" bgcolor="#FFFFFF"  ><?=$row_latey['idayname_en']?></td>
                          <td align="center" bgcolor="#FFFFFF"  ><?=$row_latey['iShift']?></td>
                          <td align="center" bgcolor="#FFFFFF"  ><?=$row_latey['iattDateTimes']?></td>
                          <td align="center" bgcolor="#FFFFFF"  ><?=$row_latey['paycode']?></td>
                        
                        </tr>
										  <?
									//	  $total_late_night =  $row_latey['total_late'];
										   $i++;}
										 
												}
	
	
?>

</table>

<?
}
?>
	<?
if($status=='all'){
?>

<table cellspacing="0" cellpadding="0" border="1" width="500" align="center">
                      
                        <tr>
                        <td align="center" bgcolor="#CCCCCC"><strong>No.</strong></td>
                        <td align="center" bgcolor="#CCCCCC"><strong>Site</strong></td>
                       	  <td align="center" bgcolor="#CCCCCC"><strong>Empno</strong></td>
                             <td align="center" bgcolor="#CCCCCC"><strong>Name</strong></td>
                          <td align="center" bgcolor="#CCCCCC"  ><strong>Date</strong></td>
                          <td align="center" bgcolor="#CCCCCC"  ><strong>Day Name</strong></td>
                          <td align="center" bgcolor="#CCCCCC"  ><strong>Shift</strong></td>
                          <td align="center" bgcolor="#CCCCCC"  ><strong>Scan in</strong></td>
                        
                          <td align="center" bgcolor="#CCCCCC"  ><strong>Paycode</strong></td>
                        
                        </tr>
                        

<?
$i =1;
											$select = "select * from tbemployee where delstatus='0'";
                                            $re = mssql_query($select);
											$num = mssql_num_rows($re);
											if($num>0){
                                            while($row = mssql_fetch_array($re)){
												
												
	
	$select_latey = "select convert(varchar, iattDateTime1, 108)as  iattDateTimes,(select site from tbemployee where empno=tbatt_approve.empno) as tsite,* from tbatt_approve where paycode in (SELECT paycode from tbpaycode WHERE paycodeyear='$txtyear') and ishift='Day' and cast(iattDateTime1 as time)>'08:01:00' and status_approve=1
			and empno='".$row['empno']."' and cast(iattDateTime1 as date) not in(select leavestartdate from tbleave_transaction where empno='".$row['empno']."')
			";
                                            $re_latey = mssql_query($select_latey);
											$num_latey = mssql_num_rows($re_latey);
											if($num_latey>0){
												
                                          while($row_latey = mssql_fetch_array($re_latey)){
											 ?> <tr>
      <td align="center" bgcolor="#FFFFFF"><?=$i?>.</td>
      <td align="center" bgcolor="#FFFFFF"><?=$row_latey['tsite']?></td>
                        	 <td align="center" bgcolor="#FFFFFF"><?=$row_latey['empno']?></td>
                             <td align="center" bgcolor="#FFFFFF"><?=get_full_name($row_latey['empno'])?></td>
                          <td align="center" bgcolor="#FFFFFF"  ><?=$row_latey['iworkdate']?></td>
                          <td align="center" bgcolor="#FFFFFF"  ><?=$row_latey['idayname_en']?></td>
                          <td align="center" bgcolor="#FFFFFF"  ><?=$row_latey['iShift']?></td>
                          <td align="center" bgcolor="#FFFFFF"  ><?=$row_latey['iattDateTimes']?></td>
                          <td align="center" bgcolor="#FFFFFF"  ><?=$row_latey['paycode']?></td>
                        
                        </tr><? 	
						$i++;
											  }
										//  $total_late_day =  $row_latey['total_late'];
												}
											$select_latey = "select convert(varchar, iattDateTime1, 108)as  iattDateTimes,(select site from tbemployee where empno=tbatt_approve.empno) as tsite,* from tbatt_approve where paycode in (SELECT paycode from tbpaycode WHERE paycodeyear='$txtyear') and ishift='Night' and cast(iattDateTime1 as time)>'20:21:00' and status_approve=1
			and empno='".$row['empno']."'  and cast(iattDateTime1 as date) not in(select leavestartdate from tbleave_transaction where empno='".$row['empno']."')
			";
                                            $re_latey = mssql_query($select_latey);
											$num_latey = mssql_num_rows($re_latey);
											if($num_latey>0){
                                          while($row_latey = mssql_fetch_array($re_latey)){
										  ?>
										  <tr>
                                           <td align="center" bgcolor="#FFFFFF"><?=$i?>.</td>
                                           <td align="center" bgcolor="#FFFFFF"><?=$row_latey['tsite']?></td>
                        	 <td align="center" bgcolor="#FFFFFF"><?=$row_latey['empno']?></td>
                             <td align="center" bgcolor="#FFFFFF"><?=get_full_name($row_latey['empno'])?></td>
                          <td align="center" bgcolor="#FFFFFF"  ><?=$row_latey['iworkdate']?></td>
                          <td align="center" bgcolor="#FFFFFF"  ><?=$row_latey['idayname_en']?></td>
                          <td align="center" bgcolor="#FFFFFF"  ><?=$row_latey['iShift']?></td>
                          <td align="center" bgcolor="#FFFFFF"  ><?=$row_latey['iattDateTimes']?></td>
                          <td align="center" bgcolor="#FFFFFF"  ><?=$row_latey['paycode']?></td>
                        
                        </tr>
										  <?
									//	  $total_late_night =  $row_latey['total_late'];
										   $i++;}
										 
												}
												
												
												
												}
												}
	
	
?>

</table>

<?
}
?>  


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


</body>
</html>