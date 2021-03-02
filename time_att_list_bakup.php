<? include("connect.php");  ?>
<?
	 
	//echo cal_days_in_month(CAL_GREGORIAN, 11, 2009); 
	$status = $_REQUEST['status'];
	
$paycode = $_REQUEST['paycode'];
$empno = $_REQUEST['empno'];


		//$empno='59014';
		
		if($empno!=''){
				$select="select empno,site,skill_reward,basic_wage,basic_salary,emptype from  tbemployee where empno = '$empno' ";
				$re=mssql_query($select);
				
					$row=mssql_fetch_array($re);
					$site = $row['site'];
					$skill_reward= $row['skill_reward'];
					if($skill_reward==''){
						$skill_reward = 0;
						}
					$att_reward = $row['att_reward'];
					if($att_reward==''){
						$att_reward = 0;
						}
					$basic_wage =  $row['basic_wage'];
					$basic_salary =  $row['basic_salary'];
					$car_rice = 75;
					$emptype  =  $row['emptype'];
					
					if($site=='TSC'){
							$start_ot = "17:20:00";
							$start_ot_night = "05:40:00";
							
						}else{
							$start_ot = "17:30:00";
							$start_ot_night = "05:40:00";
							}
		}
		
		if($paycode!=''){
			
			$select="select paycode,convert(varchar, startdate, 101)as  startdate,
	convert(varchar, enddate, 101)as  enddate from  tbpaycode where paycode = '$paycode' ";
				$re=mssql_query($select);
				$num=mssql_num_rows($re);
				
					$row=mssql_fetch_array($re);
					$startdate = $row['startdate'];
					$enddate = $row['enddate'];
				
			}
	
	function DateDiff($strDate1,$strDate2)
	 {
				return (strtotime($strDate2) - strtotime($strDate1))/  ( 60 * 60 * 24 );  // 1 day = 60*60*24
	 }
	 function TimeDiff($strTime1,$strTime2)
	 {
				return (strtotime($strTime2) - strtotime($strTime1))/  ( 60 * 60 ); // 1 Hour =  60*60
	 }
	 function DateTimeDiff($strDateTime1,$strDateTime2)
	 {
				return (strtotime($strDateTime2) - strtotime($strDateTime1))/  ( 60 * 60  ); // 1 min =  60*60
	 }
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

$(function() {

	
	});
	

	
	
	
function showpaycode(){
	var paycode = $("#paycode").val();
	var empno = $("#empno").val();
	window.location = 'time_att_list.php?paycode='+paycode+'&empno='+empno;
	}

function updateshift(id){
	var shift_time = $("#shift_time"+id).val();
		$.post( "getajax_att.php", { 	
	status: "updateshift", 
	shift_time : shift_time,
	id: id,
	sid: Math.random() 
	})
	.done(function( data ) {
	//alert(data);

 });
	}
	
	function updatefl(id){
	var fl = $("#fl"+id).val();
		$.post( "getajax_att.php", { 	
	status: "updatefl", 
	fl : fl,
	id: id,
	sid: Math.random() 
	})
	.done(function( data ) {
	//alert(data);

 });
	}
	function updateDate(id){
	var attDateTime = $("#attDateTime"+id).val();
	var attDateTime2 = $("#attDateTime2"+id).val();
	var attDateTime3 = $("#attDateTime3"+id).val();
		$.post( "getajax_att.php", { 	
	status: "updateDate", 
	attDateTime : attDateTime,
	attDateTime2 : attDateTime2,
	attDateTime3 : attDateTime3,
	id: id,
	sid: Math.random() 
	})
	.done(function( data ) {
	alert('save complete.');

 });
	}
	
	function createleave(id,empno,leavedate){
		
		var leavetypeid = $("#leavetypeid"+id).val();
		if(leavetypeid==''){
			alert('Please Select Leave');
			return false;
			}else{
				
				$.post( "getajax_att.php", { 	
					status: "createleave", 
					leavedate : leavedate,
					leavetypeid:leavetypeid,
					empno : empno,
					id : id,
					sid: Math.random() 
					})
					.done(function( data ) {
					alert('save complete.');
				
				 });
 
 
				}
		
		}
	
	
	
	function printslip(empno,paycode){
		window.open('popslip.php?empno='+empno+'&paycode='+paycode+'','popup','width=800,height=400,scrollbars=yes');
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
                        



<?
if($status==''){
	
	?>
    <table align="center" width="100%" border="0" cellspacing="2" cellpadding="0" >
  <tr >
  <td width="6%" height="40" align="right"><strong>PayCode</strong></td>
  <td width="19%"><select id="paycode" class="form-control"  name="paycode"   style="width:200px;">
     <option value="">Select</option>
    <?
    	$select0="SELECT paycode from tbpaycode order by startdate asc ";
	$re0=mssql_query($select0);
	while($row0=mssql_fetch_array($re0)){
		?>
		 <option value="<?=$row0['paycode']?>" <?
         if($paycode==$row0['paycode']){
			 ?> selected<?
			 }
		 ?>><?=$row0['paycode']?></option>
		<?
		}
	?>
     </select></td>
    <td width="13%" height="40" align="right"><strong>Employee Number</strong></td>
   <td width="30%"><select id="empno" class="form-control"  name="empno"   style="width:280px;">
     <option value="">Select</option>
    <?
	
	$selectt="SELECT distinct site from tbemployee order by site asc ";
	$ret=mssql_query($selectt);
	while($rowt=mssql_fetch_array($ret)){
    $select0="SELECT empno,firstname,lastname from tbemployee where site='".$rowt['site']."' and emp_level in('1','2') order by empno asc ";
	$re0=mssql_query($select0);
	while($row0=mssql_fetch_array($re0)){
		?>
		 <option value="<?=$row0['empno']?>" <?
         if($empno==$row0['empno']){
			 ?> selected<?
			 }
		 ?>><?=$rowt['site']?> <?=iconv("tis-620", "utf-8", $row0['firstname'] )?> <?=iconv("tis-620", "utf-8", $row0['lastname'] )?> <?
    if($paycode!=''){
		$selects="SELECT total_salary from tbsalary where empno='".$row0['empno']."' and paycode='$paycode'";
		$res=mssql_query($selects);
		$rows=mssql_fetch_array($res);
		echo "(".$rows['total_salary'].")";
		}
	
		
		
		 ?></option>
		<?
		}
		}
	?>
     </select></td>
     <td width="24%"><input type="button" value="Select" onClick="showpaycode();"></td>
     <td width="8%" align="right"><input type="button" value="Update" onClick="window.location.reload();" ></td>
    </tr></table>
    
	<table align="center" width="100%" border="0" cellspacing="2" cellpadding="0" class="table table-striped table-bordered datatables" id="example">
  <tr >
    <td width="6%" align="center"><strong>Shift</strong></td>
    <td width="6%" height="40" align="center"><strong>Employee Number</strong></td>
    <td width="12%" align="center"><strong>Employee Name</strong></td>
    <td width="12%" align="center"><strong>Date</strong></td>
      <td width="9%" align="center"><strong>Day Name</strong></td>
    <td width="9%" align="center"><strong>Work Type</strong></td>
    <td width="12%" align="center"><strong>Time1</strong></td>
    <td width="9%" align="center"><strong>Time2</strong></td>
      <td width="9%" align="center"><strong>Time3</strong></td>
    <td width="9%" align="center"><strong>OT </strong></td>
    <td width="9%" align="center"><strong>Rate</strong></td>
    <td width="9%" align="center"><strong>เงินค่า OT</strong></td>
    <td width="9%" align="center"><strong>ข้าว+รถ</strong></td>
     <td width="9%" align="center"><strong>FL</strong></td>
    <td width="9%" align="center"><strong>ค่ากะ</strong></td>
   <td width="9%" align="center"><strong>รวม</strong></td>
    
    </tr>
    
    <?
	
		
		
		if($empno!=''){
		/////////////////////////////////////////////////////////////////////////////////////////////
		
		$select0="SELECT *,convert(varchar, workdate, 101)as  workdate2,convert(varchar, workdate, 103)as  workdate3
FROM    tbot_parameter where workdate between '".$startdate."' and '".$enddate."' and site='$site'  order by workdate asc ";
	$re0=mssql_query($select0);
	$total_day = 0;
	$total_normal_day = 0;
	
	$total_ot1 = 0;
	$total_ot1_5 = 0;
	$total_ot2 = 0;
	$total_ot3 = 0;
	
	$total_ot = 0;
	$total_car_rice = 0;
	$total_fl = 0;
	$total_shift_val = 0;
	$total_total = 0;
	$leaveday = 0;
	$shift = "";
	while($row0=mssql_fetch_array($re0)){
		
		
		$select="SELECT  CAST(attDateTime AS DATE) DATE_ONLY, empno
FROM    tbatt where empno='".$empno."' 
GROUP   BY  CAST(attDateTime AS DATE), empno 
order by CAST(attDateTime AS DATE) asc ";
		$re=mssql_query($select);
		$row=mssql_fetch_array($re);
		
		
	//check shift from shift&otfile
	$selectot="select shift,ot,fl from tbot where empno='".$empno."' and dateadd(dd,-1,CAST(attdate AS DATE))='".$row0['workdate']."'  ";
	$reot=mssql_query($selectot);
	$numot = mssql_num_rows($reot);
	if($numot>0){
		$rowot=mssql_fetch_array($reot);
		$sShift = $rowot['shift'];
		$sOT = $rowot['ot'];
		$sFL = $rowot['fl'];
		
		}	
	
	//check leave date
		$select_le = "select * from  tbleave where CAST(leavestartdate AS DATE)='".$row0['workdate']."' and empno='$empno'  ";
				$re_le=mssql_query($select_le);
				$num_le=mssql_num_rows($re_le);
				if($num_le>0){
					$row_le=mssql_fetch_array($re_le);
					$leavetypeid = $row_le['leavetypeid'];
					
				
					
					$select_ln = "select leavename from tbleavetype where   leavetypeid='$leavetypeid'  ";
					
					$re_ln=mssql_query($select_ln);
					$row_ln=mssql_fetch_array($re_ln);
					$leavename = iconv("tis-620", "utf-8", $row_ln['leavename'] );
					
					
					}else{
						$leavetypeid = "";
						$leavename ="";
						}
	
		$select2="select *,
			convert(varchar, attDateTime, 101)as  attDateTime1,
			convert(varchar, attDateTime, 108)as  attDateTime2 ,
			convert(varchar, attDateTime, 101)as  attDateTime3 
	from tbatt where empno='".$empno."' and CAST(attDateTime AS DATE)='".$row0['workdate']."' order by attDateTime asc ";
	//echo $select2;
	$re2=mssql_query($select2);
	$num2 = mssql_num_rows($re2);
	
	$row2=mssql_fetch_array($re2);
	$Shift = $row2['shift'];
	
	
		
	//	echo $Shift;
	
	
	
	$select3="select * from tbot_parameter where workdate='".$row2['attDateTime3']."' and site='$site' ";
				
	$re3=mssql_query($select3);
				
				$row3=mssql_fetch_array($re3);
		?>
		<tr >
		  <td width="6%" align="center"><?
           if($row2['empno']!=''){
			  
			   ?><?=$sShift?><select style="width:50px" id="shift_time<?=$row2['id']?>" class="form-control" onChange="updateshift('<?=$row2['id']?>');"  >
     <option value="Day" <?
     if($Shift=='Day'){
		 ?> selected<?
		 }
	 ?>>D</option>
     <option value="Night"  <?
     if($Shift=='Night'){
		 ?> selected<?
		 }
	 ?>>N</option>
     </select><?
			   }
		  ?></td>
    <td width="6%" height="40" align="center"><?=$row2['empno']?></td>
    <td width="12%" align="center"><?=iconv("tis-620", "utf-8", $row2['Name'] );?></td>
    <td width="12%" align="center"><?=$row0['workdate2']?></td>
      <td width="9%" align="center"><?=$row0['dayname_en']?></td>
    <td width="9%" align="center"><?
	
	echo $row0['work_type'];
	if($row0['work_type']=='Normal working'){
		$total_normal_day = $total_normal_day+1;
		}
	
	?></td>
    <td width="12%" align="center"><?
	$select4="select *, 
	convert(varchar, attDateTime, 101)as attDate1, 
	convert(varchar, attDateTime, 108)as attTime1 , 
	
	convert(varchar, attDateTime2, 101)as attDate2, 
	convert(varchar, attDateTime2, 108)as attTime2 , 
	
	convert(varchar, attDateTime3, 101)as attDate3, 
	convert(varchar, attDateTime3, 108)as attTime3 
	
from tbatt where empno='".$empno."' 
and CAST(attDateTime AS DATE)='".$row0['workdate']."' and (CAST(attDateTime AS TIME) > '05:00' and CAST(attDateTime AS TIME) < '17:00') ";
	
	$re4=mssql_query($select4);
				
				$row4=mssql_fetch_array($re4);
				if($row2['empno']!=''){
					?><input type="text" style="width:130px;<?
                    if($row4['attDate1']==''){
						?> color:#F00<?
						}
					?>" class="form-control" onChange="updateDate('<?=$row2['id']?>');" id="attDateTime<?=$row2['id']?>" value="<?
	if($row4['attDate1']==''){
		 echo $row0['workdate2']." 08:00:00";
		}else{
		 echo $row4['attDate1']." ".$row4['attTime1'];
		}	
   
	?>"><?
					}else{
						
				  if($row0['work_type']=='Normal working'){
					 
		?><select style="width:130px; color:#00F" id="leavetypeid<?=$row2['id']?>" class="form-control" >
        <option value="">Select Leave</option>
                      <?
                  $selectl="select * from   tbleavetype order by leavetypeid asc ";
				  $rel=mssql_query($selectl);
					while($rowl=mssql_fetch_array($rel)){
							
							?>
			 <option value="<?=$rowl['leavetypeid']?>" <?
     if($leavetypeid==$rowl['leavetypeid']){
		 ?> selected<?
		 }
	 ?>><?=iconv("tis-620", "utf-8", $rowl['leavename'] )?></option>
							<?
							
					}
					  ?>
    
     
     </select><?
					  } 
				   
				   
				   }
	?></td>
    <td width="9%" align="center"><?
	
	if($row2['empno']!=''){
		 
		if($row4['attDate2']!=''){
			
		  $attDateTime2 =  $row4['attDate2']." ".$row4['attTime2'];
		  
		}else{
		
		$select5="select *, convert(varchar, attDateTime, 101)as attDateTime1, 
convert(varchar, attDateTime, 108)as attDateTime2 , 
convert(varchar, attDateTime, 101)as attDateTime3 from tbatt where empno='".$empno."' 
and CAST(attDateTime AS DATE)='".$row0['workdate']."' and (CAST(attDateTime AS TIME) >= '12:00') ";
	$re5=mssql_query($select5);
	$row5=mssql_fetch_array($re5);
		  $attDateTime2 = $row5['attDateTime1']." ".$row5['attDateTime2'];		
		}
		
		
		
		?>
		<input type="text" style="width:130px"  class="form-control" onChange="updateDate('<?=$row2['id']?>');"  id="attDateTime2<?=$row2['id']?>" value="<?
	echo $attDateTime2;
 
	?>">
		<?
		
		
			
			}else{
				 if($row0['work_type']=='Normal working'){
					 
					 if($leavetypeid==''){
					 
					 ?><input type="button" value="Create Leave" onClick="createleave('<?=$row2['id']?>','<?=$empno?>','<?=$row0['workdate2']?>');"><?
					 }else{
						 echo $leavename;
						 }
					 
					 
					 }
				}
	
	
				
	?></td>
    <td><?
	if($row2['empno']!=''){
	if($row4['attDate3']!=''){
		
		  $attDateTime3 =  $row4['attDate3']." ".$row4['attTime3'];
		}else{
			 $select6="select *, convert(varchar, attDateTime, 101)as attDateTime1, 
convert(varchar, attDateTime, 108)as attDateTime2 , 
convert(varchar, attDateTime, 101)as attDateTime3 from tbatt where empno='".$empno."' 
and CAST(attDateTime AS DATE)= DATEADD(day, +1, '".$row0['workdate']."') and (CAST(attDateTime AS TIME) < '08:00') ";
	//DATEADD(day, +1, '2016-11-22')
	$re6=mssql_query($select6);
				$row6=mssql_fetch_array($re6);
				 $attDateTime3 = $row6['attDateTime1']." ".$row6['attDateTime2'];
			}
   ?><input type="text" style="width:130px"  class="form-control" onChange="updateDate('<?=$row2['id']?>');" id="attDateTime3<?=$row2['id']?>" value="<?
  echo $attDateTime3;
	?>"><?
	}
	?></td>
    <td width="9%" align="center"><?
    	//echo ($row5['attDateTime2']-"17:20:00")/3600;
		if($row2['empno']!=''){
		if($row0['work_type']=='H Sat , Sun' || $row0['work_type']=='H' || $row0['work_type']=='H Sat'){
			
		//	$start_ot = "08:00:00";
			//$start_ot_night = "08:00:00";
		if($Shift=='Day'){
		if($row5['attDateTime2']!=''){
			if(TimeDiff("08:00:00",$row5['attDateTime2'])>0){
				$ot_time =  TimeDiff("08:00:00",$row5['attDateTime2']);
				$ot_time = number_format($ot_time, 2, '.', '');
				$ot_time = $ot_time - 1;
				echo $ot_time;
				}
		}}
		
		if($Shift=='Night'){
			
			if(DateTimeDiff($row5['attDateTime3']." 20:00:00",$row6['attDateTime3']." ".$row6['attDateTime2'])>0){
				$ot_time =  DateTimeDiff($row5['attDateTime3']." 20:00:00",$row6['attDateTime3']." ".$row6['attDateTime2']);
				$ot_time = number_format($ot_time, 2, '.', '');
				$ot_time = $ot_time - 1;
				echo $ot_time;
				}
			}
		
		
			
			}else{
				
				if($Shift=='Day'){
		if($row5['attDateTime2']!=''){
			if(TimeDiff($start_ot,$row5['attDateTime2'])>0){
				$ot_time =  TimeDiff($start_ot,$row5['attDateTime2']);
				$ot_time = number_format($ot_time, 2, '.', '');
				echo $ot_time;
				}
		
		}}
				if($Shift=='Night'){
		if($row6['attDateTime2']!=''){
			if(TimeDiff($start_ot_night,$row6['attDateTime2'])>0){
				$ot_time =  TimeDiff($start_ot_night,$row6['attDateTime2']);
				$ot_time = number_format($ot_time, 2, '.', '');
				echo $ot_time;
				}
		
		}}
				
				}
			}	
		
	?></td>
      <td width="9%" align="center"><?
	 $rate = 0;
	 if($row2['empno']!=''){
	if($attDateTime2!=' '){	 
	
	if($row0['work_type']=='H Sat , Sun' || $row0['work_type']=='H' || $row0['work_type']=='H Sat'){
		 if(TimeDiff("20:00:00",$row5['attDateTime2'])>0.1){
			
				$rate = $row3['rate3'];
			}else if(TimeDiff($start_ot,$row5['attDateTime2'])>0.1){
			
				$rate = $row3['rate2'];
			}else{
				$rate = $row3['rate1'];
				}
		}else{
			 if($Shift=='Day'){
	 if(TimeDiff("20:00:00",$row5['attDateTime2'])>0.1){
			//	echo $row3['rate3'];
				$rate = $row3['rate3'];
			}else if(TimeDiff($start_ot,$row5['attDateTime2'])>0.1){
			//	echo $row3['rate2'];
				$rate = $row3['rate2'];
			}
			
	 }else{
		// echo $row6['attDateTime2'];
		// echo TimeDiff("05:40:00",$row6['attDateTime2']);
		  if(TimeDiff("05:40:00",$row6['attDateTime2'])>0.1){
		 $rate = $row3['rate2'];
		  }
		 }
			}
	
		  
		  
		  echo $rate;
	
	
	
	 
	}
	 }
		
		
	 ?></td>
    <td width="9%" align="center"><?
	$ot_val = 0;
	if($row2['empno']!=''){
	if($row0['work_type']=='H Sat , Sun' || $row0['work_type']=='H' || $row0['work_type']=='H Sat'){
		if($Shift=='Day'){
	if(TimeDiff("08:00:00",$row5['attDateTime2'])>0){
    	$ot_val = ($ot_time*($basic_wage+75))/8;
		$ot_val = number_format($ot_val, 2, '.', '');
		//echo $ot_val;
		$ot_val = $ot_val*$rate;
		$ot_val = number_format($ot_val, 2, '.', '');
		//echo "(x rate = ".$ot_val.")";
	}
		}
		if($Shift=='Night'){
			//echo $row5['attDateTime3']." 20:00:00";
//			echo ">>";
//			echo $row6['attDateTime3']." ".$row6['attDateTime2'];
//			echo ">>";
//			echo DateTimeDiff($row5['attDateTime3']." 20:00:00",$row6['attDateTime3']." ".$row6['attDateTime2']);
		if(DateTimeDiff($row5['attDateTime3']." 20:00:00",$row6['attDateTime3']." ".$row6['attDateTime2'])>0){
    	$ot_val = ($ot_time*($basic_wage+75))/8;
		$ot_val = number_format($ot_val, 2, '.', '');
		//echo $ot_val;
		$ot_val = $ot_val*$rate;
		$ot_val = number_format($ot_val, 2, '.', '');
		//echo "(x rate = ".$ot_val.")";
	}
			}
		
		}else{
			if($Shift=='Day'){
	if(TimeDiff($start_ot,$row5['attDateTime2'])>0){
    	$ot_val = ($ot_time*($basic_wage+75))/8;
		$ot_val = number_format($ot_val, 2, '.', '');
		//echo $ot_val;
		$ot_val = $ot_val*$rate;
		$ot_val = number_format($ot_val, 2, '.', '');
		//echo "(x rate = ".$ot_val.")";
	}}
			if($Shift=='Night'){
		
		if(TimeDiff($start_ot_night,$row6['attDateTime2'])>0){
    	$ot_val = ($ot_time*($basic_wage+75))/8;
		$ot_val = number_format($ot_val, 2, '.', '');
		//echo $ot_val;
		$ot_val = $ot_val*$rate;
		$ot_val = number_format($ot_val, 2, '.', '');
		//echo "(x rate = ".$ot_val.")";
	}
		}
			}
			?><input type="text" class="form-control" style="width:60px"  id="ot_val<?=$row2['id']?>" value="<?=$ot_val?>"><?
	
	}
	
	?></td>
    <td align="center"><?
	if($row2['empno']!=''){
    
	?><input type="text" class="form-control" style="width:50px"  id="car_rice<?=$row2['id']?>" value="<?=$car_rice?>"><?
	
	
	}
	
	?></td>
    <td align="center"><?
	if($row2['empno']!=''){	
	if($row2['fl']!=''){
		 $fl = 50;
		}else{
			 $fl = 0;
			}
			?><?=$sFL;?><select id="fl<?=$row2['id']?>" style="width:50px" class="form-control" onChange="updatefl('<?=$row2['id']?>');"  >
     <option value="0" <?
     if($row2['fl']=='0'){
		 ?> selected<?
		 }
	 ?>>0</option>
     <option value="50"  <?
     if($row2['fl']=='50'){
		 ?> selected<?
		 }
	 ?>>50</option>
     </select><?
     $fl = $row2['fl'];
	
	
	 ?><?
   }
	?></td>
     <td align="center"><?
	 if($row2['empno']!=''){
	 if($Shift=='Night'){
     $shift_val = 100;
	 }else{
		  $shift_val = 0;
		 }
		 ?><input type="text" class="form-control" style="width:50px"  id="shift_val<?=$row2['id']?>" value="<?=$shift_val?>"><?
		 
		
	
		 }
	 ?></td>
   <td align="center"><?
    if($leavetypeid!=''){
		
			
			$leaveday = $leaveday+1;
			$car_rice = 0;
			$ot_time = 0;
			switch ($rate) {
				case 1:
				   $total_ot1 = $total_ot1+$ot_time;
					break;
				case 1.5:
					$total_ot1_5 = $total_ot1_5+$ot_time;
					break;
				case 2:
				   $total_ot2 = $total_ot2+$ot_time;
					break;
				 case 3:
					$total_ot3 = $total_ot3+$ot_time;
					break;
				}
			 $total_ot = $total_ot+$ot_val;
	 		 $total_shift_val =$total_shift_val+ $shift_val;
			 $total_fl = $total_fl+$fl;
			 $total_car_rice = $total_car_rice+$car_rice;
			 
		
		echo "basic_wage = ".$basic_wage." <BR>";
		echo "car_rice = ".$car_rice." <BR>";
		echo "ot_time = ".$ot_time." <BR>";
		echo "fl = ".$fl." <BR>";
		echo "shift_val = ".$shift_val." <BR>";
		
		echo "total_ot1 = ".$total_ot1." <BR>";
		echo "total_ot1_5 = ".$total_ot1_5." <BR>";
		echo "total_ot2 = ".$total_ot2." <BR>";
		echo "total_ot3 = ".$total_ot3." <BR>";
		
		echo "ot_val = ".$ot_val." <BR>";
		echo "(".$total_ot.")<BR>";
		
		
		$total = 0;
   		echo $basic_wage+$car_rice+$ot_val+$fl+$shift_val;
		$total=$basic_wage+$car_rice+$ot_val+$fl+$shift_val;
		$total_total = $total_total+($basic_wage+$car_rice+$ot_val+$fl+$shift_val);
		
		
		echo "(".$total_total.")";
		
		}
    if($row2['empno']!=''){
		if($attDateTime2!=' '){
			
			$total_day = $total_day+1;
			
			switch ($rate) {
				case 1:
				   $total_ot1 = $total_ot1+$ot_time;
					break;
				case 1.5:
					$total_ot1_5 = $total_ot1_5+$ot_time;
					break;
				case 2:
				   $total_ot2 = $total_ot2+$ot_time;
					break;
				 case 3:
					$total_ot3 = $total_ot3+$ot_time;
					break;
				}
			 $total_ot = $total_ot+$ot_val;
	 		 $total_shift_val =$total_shift_val+ $shift_val;
			 $total_fl = $total_fl+$fl;
			 $total_car_rice = $total_car_rice+$car_rice;
			 
		
		echo "basic_wage = ".$basic_wage." <BR>";
		echo "car_rice = ".$car_rice." <BR>";
		echo "ot_time = ".$ot_time." <BR>";
		echo "fl = ".$fl." <BR>";
		echo "shift_val = ".$shift_val." <BR>";
		
		echo "total_ot1 = ".$total_ot1." <BR>";
		echo "total_ot1_5 = ".$total_ot1_5." <BR>";
		echo "total_ot2 = ".$total_ot2." <BR>";
		echo "total_ot3 = ".$total_ot3." <BR>";
		
		echo "ot_val = ".$ot_val." <BR>";
		echo "(".$total_ot.")<BR>";
		
		
		$total = 0;
   		echo $basic_wage+$car_rice+$ot_val+$fl+$shift_val;
		$total=$basic_wage+$car_rice+$ot_val+$fl+$shift_val;
		$total_total = $total_total+($basic_wage+$car_rice+$ot_val+$fl+$shift_val);
		
		
		echo "(".$total_total.")";
		/// UPDATE Line
		$update = "update tbatt set fl=$fl, ot_val=$ot_val, car_rice=$car_rice, shift_val=$shift_val, total=$total 
  where id=".$row2['id']."";
		mssql_query($update);
		//echo $update;
		}
	}
   ?></td>
   
    </tr>
		<?
	}
	
	
		}
		
					
	?>
    
    </table>
    
   <HR>
   <?
   if($paycode!=''){
   ?>
    <table align="center" width="60%" border="1" cellspacing="0" cellpadding="0" >
      
      <tr>
        <td width="169" bgcolor="#CCCCCC">&nbsp;</td>
        <td width="104" align="center" bgcolor="#CCCCCC">&nbsp;</td>
        <td colspan="2" align="center" bgcolor="#CCCCCC">&nbsp;</td>
        <td width="108" bgcolor="#CCCCCC">&nbsp;</td>
        <td width="114" align="center" bgcolor="#CCCCCC"><input type="button" value="Print Slip" onClick="printslip('<?=$empno?>','<?=$paycode?>');"></td>
      </tr>
      <tr>
        <td>มาทำงาน</td>
        <td align="center"><?=$total_day?> </td>
        <td colspan="2" align="center">วัน</td>
        <td></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>ลาหยุด</td>
        <td align="center"><?=$leaveday?> </td>
        <td colspan="2" align="center">วัน</td>
        <td></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td align="left">ค่าข้าว</td>
        <td align="center">50.00 </td>
        <td colspan="2" align="center">บาทต่อวัน</td>
        <td align="center"></td>
        <td align="center"></td>
      </tr>
      <tr>
        <td align="left">ค่ารถ</td>
        <td align="center">25.00 </td>
        <td colspan="2" align="center">บาทต่อวัน</td>
        <td align="center"></td>
        <td align="center"></td>
      </tr>
      <tr>
        <td align="left">รวมค่าข้าว ค่ารถ</td>
        <td align="center"><font color="#0000FF"><?=$total_car_rice?></font> </td>
        <td colspan="2" align="center">บาท</td>
        <td></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td align="left">รวมค่า FL</td>
        <td align="center"><font color="#0000FF"><?=$total_fl?></font> </td>
        <td colspan="2" align="center">บาท</td>
        <td></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td></td>
        <td align="center"></td>
        <td colspan="2" align="center"></td>
        <td></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td align="left">มาทำงาน    วันทำงานปกติ</td>
        <td align="center"><?=$total_day?></td>
        <td colspan="2" align="center">วัน</td>
        <td></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td align="left">ค่าแรง</td>
        <td align="center">300.00 </td>
        <td colspan="2" align="center">บาท ต่อวัน</td>
        <td></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td align="left">รวมค่าแรง</td>
        <td align="center"><font color="#0000FF"><?
		$total_wage = $basic_wage*$total_day;
        echo $total_wage;
		?> </font></td>
        <td colspan="2" align="center">บาท</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td></td>
        <td align="center"></td>
        <td colspan="2" align="center"></td>
        <td></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td align="left">โอที</td>
        <td align="center">37.50 </td>
        <td colspan="2" align="center">บาท ต่อ    ชั่วโมง</td>
        <td align="center">8</td>
        <td align="center">ชั่วโมง ต่อ วัน</td>
      </tr>
      <tr>
        <td align="center" bgcolor="#CCCCCC"></td>
        <td align="center" bgcolor="#CCCCCC">ชั่วโมงทำงาน</td>
        <td width="74" align="center" bgcolor="#CCCCCC"></td>
        <td width="48" align="center" bgcolor="#CCCCCC"></td>
        <td align="center" bgcolor="#CCCCCC">ชั่วโมงทำงาน คูณ OT</td>
        <td align="center" bgcolor="#CCCCCC">&nbsp;</td>
      </tr>
      <tr>
        <td align="left">OT 1</td>
        <td align="center"><?=$total_ot1?></td>
        <td align="center">ชั่วโมง</td>
        <td align="right">คิดเป็น</td>
        <td align="center"><?=$total_ot1*1?></td>
        <td align="center">ชั่วโมง</td>
      </tr>
      <tr>
        <td align="left">OT 1.5</td>
        <td align="center"><?=$total_ot1_5?></td>
        <td align="center">ชั่วโมง</td>
        <td align="right">คิดเป็น</td>
        <td align="center"><?=$total_ot1_5*1.5?></td>
        <td align="center">ชั่วโมง</td>
      </tr>
      <tr>
        <td align="left">OT 2</td>
        <td align="center"><?=$total_ot2?></td>
        <td align="center">ชั่วโมง</td>
        <td align="right">คิดเป็น</td>
        <td align="center"><?=$total_ot2*2?></td>
        <td align="center">ชั่วโมง</td>
      </tr>
      <tr>
        <td align="left">OT 3</td>
        <td align="center"><?=$total_ot3?></td>
        <td align="center"></td>
        <td align="right">คิดเป็น</td>
        <td align="center"><?=$total_ot3*3?></td>
        <td align="center">ชั่วโมง</td>
      </tr>
      <tr>
        <td align="left">เงินค่า OT</td>
        <td align="center"><font color="#0000FF"><?=$total_ot?></font></td>
        <td align="center">บาท</td>
        <td align="right">รวม</td>
        <td align="center"><?
        echo ($total_ot1*1)+($total_ot1_5*1.5)+($total_ot2*2)+($total_ot3*3);
		?></td>
        <td align="center">&nbsp;</td>
      </tr>
      <tr>
        <td align="left">ค่ากะ</td>
        <td align="center"><font color="#0000FF"><?=$total_shift_val?></font></td>
        <td align="center">บาท</td>
        <td></td>
        <td></td>
        <td align="center">&nbsp;</td>
      </tr>
      <tr>
        <td align="left">เบี้ยขยัน</td>
        <td align="center"><font color="#0000FF"><?=$att_reward?></font></td>
        <td align="center">บาท</td>
        <td></td>
        <td></td>
        <td align="center">&nbsp;</td>
      </tr>
      <tr>
        <td width="169"></td>
        <td align="center"></td>
        <td align="center"></td>
        <td></td>
        <td></td>
        <td align="center">&nbsp;</td>
      </tr>
      <tr>
        <td align="left">รวมเงินเดือน</td>
        <td align="center"><?=$total_total?> </td>
        <td align="center">บาท</td>
        <td></td>
        <td></td>
        <td align="center">&nbsp;</td>
      </tr>
      <tr>
        <td align="left">หักประกันสังคม</td>
        <td align="center"><?
		if($emptype=='employee'){
				 $social_in = ($basic_salary*.05);
			}else{
				 $social_in =($total_day*$basic_wage)*.05;
				
			}
       
		?>(<?=$social_in?>)</td>
        <td align="center">บาท</td>
        <td></td>
        <td></td>
        <td align="center">&nbsp;</td>
      </tr>
      <tr>
        <td align="left">ค่าทักษะ,เงินหัก,จ่ายวันหยุด</td>
        <td align="center"><?=$skill_reward?></td>
        <td align="center">บาท</td>
        <td></td>
        <td>เงินได้สะสม</td>
        <td align="center">&nbsp;</td>
      </tr>
      <tr>
        <td align="left">คงเหลือเงินเดือน</td>
        <td align="center">     <?
		
		$total_salary=($total_total+$skill_reward)-$social_in;
		echo $total_salary;
		?> </td>
        <td align="center">บาท</td>
        <td>&nbsp;</td>
        <td>ประกันสังคมสะสม</td>
        <td align="center">&nbsp;</td>
      </tr>
    </table>
<?



$att_reward=0;

	// insert & update salary table
	$selects="select empno from tbsalary where empno='$empno' and paycode='$paycode' ";
				$res=mssql_query($selects);
				$nums=mssql_num_rows($res);
				if($nums>0){
					
					$sqlupdate= "update  tbsalary set total_day=$total_day, total_car_rice=$total_car_rice, total_normal_day=$total_normal_day, total_wage=$total_wage, total_ot1=$total_ot1, total_ot1_5=$total_ot1_5, total_ot2=$total_ot2, total_ot3=$total_ot3,total_ot=$total_ot, att_reward=$att_reward, social_in=$social_in, skill_reward=$skill_reward,total_shift_val=$total_shift_val, total_salary=$total_salary,total_fl=$total_fl,subtotal_salary=$total_total where empno='$empno' and paycode='$paycode' ";
				//	echo $sqlupdate;
					mssql_query($sqlupdate);
					}else{
						
						$sqlinsert = "insert into tbsalary(empno, paycode, total_day, total_car_rice, total_normal_day, total_wage, total_ot1, total_ot1_5, total_ot2, total_ot3,total_ot, att_reward, social_in, skill_reward,total_shift_val, total_salary,total_fl,subtotal_salary) values('$empno', '$paycode', $total_day, $total_car_rice, $total_normal_day, $total_wage, $total_ot1, $total_ot1_5, $total_ot2, $total_ot3,$total_ot, $att_reward, $social_in, $skill_reward, $total_shift_val,$total_salary,$total_fl,$total_total)";
						//echo $sqlinsert;
						mssql_query($sqlinsert);
						
						}
	
   }
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
<script type='text/javascript' src='assets/plugins/form-multiselect/js/jquery.multi-select.min.js'></script> 
<script type='text/javascript' src='assets/plugins/sparklines/jquery.sparklines.min.js'></script> 
<script type='text/javascript' src='assets/plugins/form-toggle/toggle.min.js'></script> 
<script type='text/javascript' src='assets/js/placeholdr.js'></script> 
<script type='text/javascript' src='assets/js/application.js'></script> 
<script type='text/javascript' src='assets/plugins/bootbox/bootbox.min.js'></script> 

<script type='text/javascript' src='assets/demo/demo.js'></script> 


</body>
</html>