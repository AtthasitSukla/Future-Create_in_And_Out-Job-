<? 
ob_start();
include("connect.php");  ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>I-Wis</title>
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


	
	
	

	function checkenter(event){
		 var keycode = (event.keyCode ? event.keyCode : event.which);
    if(keycode == '13') {
       // alert('You pressed a enter key in somewhere'); 
		// window.location='stock_mng.php?status=barcode&boxcode='+document.getElementById('hdboxcode').value+'&txtsearch='+document.getElementById('barcode_search').value;   
		$.post( "getajax.php", { 
	
	status: "showbarcode", 
	codebox_ipack: $("#hdboxcode").val(),
		txtsearch:$("#barcode_search").val(),
	
	sid: Math.random() 
	
	})
  .done(function( data ) {
	  $("#ans2").html(data);
	  
    
  });
    }
		}
		
			
</script>
</head>

<body class=" ">


   <?
	
	

$Username = $_REQUEST['Username'];
$Password = $_REQUEST['Password'];
$checkc = $_REQUEST['checkc'];

$sql_select="select * from tbemployee where empno='$Username' and password='$Password' and delstatus = 0";
//echo $sql_select;
$result=mssql_query($sql_select);
$num=mssql_num_rows($result);
$row=mssql_fetch_array($result);

if($num!=0){
	
	if ($check == true) //ถ้าเช็คบ๊อคเข้ามา
	{
		setcookie('admin_userid', $row['empno'],time()+3600*24*356);//เซ็ตคุกกี้ 1ปี
		$_SESSION['admin_userid'] = $row['empno'];
		/// MAIN USER FOR SSO
		if($row['sso']=='yes'){
			setcookie('main_userid', $row['empno'],time()+3600*24*356,'/');//เซ็ตคุกกี้ 1ปี
		}
		/// MAIN USER FOR SSO
		setcookie('site', $row['site'],time()+3600*24*356);//เซ็ตคุกกี้ 1ปี
		$_SESSION['site'] = $row['site'];
		setcookie('permission', $row['permission'],time()+3600*24*356);//เซ็ตคุกกี้ 1ปี
		$_SESSION['permission'] = $row['permission'];
		setcookie('emp_level', $row['emp_level'],time()+3600*24*356);//เซ็ตคุกกี้ 1ปี
		$_SESSION['emp_level'] = $row['emp_level'];
		setcookie('departmentid', $row['departmentid'],time()+3600*24*356);//เซ็ตคุกกี้ 1ปี
		$_SESSION['departmentid'] = $row['departmentid'];
		setcookie('positionid', $row['positionid'],time()+3600*24*356);//เซ็ตคุกกี้ 1ปี
		$_SESSION['positionid'] = $row['positionid'];
	}
	else
	{
		/// MAIN USER FOR SSO
		if($row['sso']=='yes'){
			setcookie('main_userid', $row['empno'],time()+3600*24*356,'/');//เซ็ตคุกกี้ 1ปี
		}
		/// MAIN USER FOR SSO
		setcookie('admin_userid', $row['empno']);
		$_SESSION['admin_userid'] = $row['empno'];
		setcookie('site', $row['site']);
		$_SESSION['site'] = $row['site'];
		setcookie('permission', $row['permission']);
		$_SESSION['permission'] = $row['permission'];
		setcookie('emp_level', $row['emp_level']);
		$_SESSION['emp_level'] = $row['emp_level'];
		setcookie('departmentid', $row['departmentid']);
		$_SESSION['departmentid'] = $row['departmentid'];
		setcookie('positionid', $row['positionid']);
		$_SESSION['positionid'] = $row['positionid'];
		
		
	}
	$ref = @$_POST['ref'];
	$empno = array();
	$sql = "SELECT * FROM  tbleave_control WHERE emp_control = '".$_SESSION['admin_userid']."'";
	$re=mssql_query($sql);
	$num=mssql_num_rows($re);
	while($row=mssql_fetch_array($re)){
		array_push($empno,$row['emp_under']);
	}
	
	$check_ojt = 0;
	$check_pro = 0;

	//echo $ref;
	if($ref=="create_dar"){
		header("Location: http://ipack-iwis.com/hrs/create_dar.php?status=reviewer");
	}else if($ref=="create_ot"){
		header("Location: http://ipack-iwis.com/hrs/create_ot.php");
	}else if($ref == '1'){
		$empno = join("','",$empno);
		
		$sql_empno = "SELECT empno,startdate FROM  tbemployee WHERE empno in ('$empno')";
		$res_empno = mssql_query($sql_empno);
		while($row_empno = mssql_fetch_array($res_empno)){
			$empno_emp = $row_empno["empno"];
			$startdate = $row_empno["startdate"];
			$sql_ojt = "SELECT tbtra_result.tra_res FROM tbtra_group INNER JOIN
				tbtra_result ON tbtra_group.group_id = tbtra_result.group_id
				WHERE  (tbtra_group.empno ='$empno_emp') and tbtra_result.tra_res='1'";
			//echo $sql_ojt;
			$res_ojt = mssql_query($sql_ojt);
			$num_ojt = mssql_num_rows($res_ojt);
			$count = (strtotime(date("Y-m-d")) - strtotime($startdate))/( 60 * 60 * 24 );
			if($count > 60 && $check_ojt == 0 && $num_ojt==0){
				$text =  '<center><u><b><font size="3" color="red">แจ้งเตือน !</font></b></u><br/><br/>';
				$text .=  '<div style="font-size:15px;">มีพนักงานในสังกัดยังไม่ได้อบรม OJT <a href="job_rec.php" >คลิกที่นี่</a> เพื่ออบรม<br/><br/>';
				$check_ojt=1;
			}
		}

	
		
		$sql = "SELECT empno,firstname,lastname,nickname,positionname,startdate FROM  tbemployee JOIN tbposition ON tbemployee.positionid = tbposition.positionid WHERE empno IN ('$empno') AND status_pro = 0 ";
		$re=mssql_query($sql);
		while($row=mssql_fetch_array($re)){
			$count = (strtotime(date("Y-m-d")) - strtotime($row['startdate']))/( 60 * 60 * 24 );
			if($count > 89 && $check_pro==0){
				$text =  '<center><u><b><font size="3" color="red">แจ้งเตือน !</font></b></u><br/><br/>';
				$text .=  '<div style="font-size:15px;">มีพนักงานในสังกัดรอการประเมินผลการปฏิบัติงานระหว่างทดลองงาน <a href="view_probation.php" >คลิกที่นี่</a> เพื่อประเมิน<br/><br/>';
				$text .= ' <a href="http://www.ipack-iwis.com/hrs/list_leave.php?ref=1" >คลิกที่นี่</a> เพื่ออนุมัติการลา</div>';
				$text .=  '</center>';
				echo $text;
				$check_pro = 1;
				//return false;
			}
		}
		//if()
		header("Location: http://www.ipack-iwis.com/hrs/list_leave.php?ref=1");
	}else{
		$url = 'import_text.php';
		if($_SESSION['emp_level']<=3 || $_SESSION['admin_userid']!='56038'){
			$url = 'leave_form.php';
		}
		
		$empno = join("','",$empno);

		$sql_empno = "SELECT empno,startdate FROM  tbemployee WHERE empno in ('$empno')";
		$res_empno = mssql_query($sql_empno);
		while($row_empno = mssql_fetch_array($res_empno)){
			$empno_emp = $row_empno["empno"];
			$startdate = $row_empno["startdate"];
			$sql_ojt = "SELECT tbtra_result.tra_res FROM tbtra_group INNER JOIN
				tbtra_result ON tbtra_group.group_id = tbtra_result.group_id
				WHERE  (tbtra_group.empno ='$empno_emp') and tbtra_result.tra_res='1'";
			//echo $sql_ojt;
			$res_ojt = mssql_query($sql_ojt);
			$num_ojt = mssql_num_rows($res_ojt);
			$count = (strtotime(date("Y-m-d")) - strtotime($startdate))/( 60 * 60 * 24 );
			if($count > 60 && $check_ojt == 0 && $num_ojt==0){
				$text =  '<center><u><b><font size="3" color="red">แจ้งเตือน !</font></b></u><br/><br/>';
				$text .=  '<div style="font-size:15px;">มีพนักงานในสังกัดยังไม่ได้อบรม OJT <a href="job_rec.php" >คลิกที่นี่</a> เพื่ออบรม<br/><br/>';
				$check_ojt=1;
			}
		}
		

		$sql = "SELECT empno,firstname,lastname,nickname,positionname,startdate FROM  tbemployee JOIN tbposition ON tbemployee.positionid = tbposition.positionid WHERE empno IN ('$empno') AND status_pro = 0 ";
		$re=mssql_query($sql);
		while($row=mssql_fetch_array($re)){
			$count = (strtotime(date("Y-m-d")) - strtotime($row['startdate']))/( 60 * 60 * 24 );
			if($count > 89 && $check_pro==0){
				if($check_ojt==0){
					$text .=  '<center><u><b><font size="3" color="red">แจ้งเตือน !</font></b></u><br/><br/>';
				}
				$text .=  '<div style="font-size:15px;">มีพนักงานในสังกัดรอการประเมินผลการปฏิบัติงานระหว่างทดลองงาน <a href="view_probation.php" >คลิกที่นี่</a> เพื่อประเมิน<br/><br/>';
				$text .= ' <a href="'.$url.'" >คลิกที่นี่</a> เมื่อยังไม่ต้องการทำใดใด</div>';
				$text .=  '</center>';
				
				$check_pro = 1;
			}
		}
	}

	if($check_ojt==1 || $check_pro==1){
		echo $text;
		return false;
	}
	echo $_SESSION["admin_userid"];
	?>
   						 <div class="panel-heading" style="width:400px">
							
						</div>
                        <div class="panel-body">
							<div class="alert alert-dismissable alert-success">
								 Successfully login please wait a sec to redirect.
							
							</div>
						</div>
  		<?php if($_SESSION['emp_level']<=3 || $_SESSION['admin_userid']!='56038'){?>
			<meta http-equiv='refresh' CONTENT='1;URL=leave_form.php'>
		<?php }else{ ?>					 
			<meta http-equiv='refresh' CONTENT='1;URL=import_text.php'>
        <?php } ?>
	<?
}else{
		header("Location: login.php");
		?>
       
        
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