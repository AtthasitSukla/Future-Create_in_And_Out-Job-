<? include("connect.php");  ?>
<?
	 
	//echo cal_days_in_month(CAL_GREGORIAN, 11, 2009); 
	$status = $_REQUEST['status'];
	
$paycode = $_REQUEST['paycode'];
$empno = $_REQUEST['empno'];


		//$empno='59014';
		
		if($empno!=''){
				$select="select firstname,lastname,empno,site,skill_reward,basic_wage,basic_salary,emptype from  tbemployee where empno = '$empno' ";
				$re=mssql_query($select);
				
					$row=mssql_fetch_array($re);
					$site = $row['site'];
					$skill_reward= $row['skill_reward'];
					//$empname = $row['firstname']." ".$row['lastname'];
					$empname = iconv("tis-620", "utf-8", $row['firstname']." ".$row['lastname'] );
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
	 
	
function get_minutes ( $start, $end ) {  

   while ( strtotime($start) <= strtotime($end) ) {  
       $minutes[] = date("H:i:s", strtotime( "$start" ) );  
       $start = date("H:i:s", strtotime( "$start + 30 mins")) ;      
   }  
   return $minutes;  
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
	alert('save complete');
	window.location='view_att_list.php?empno=<?=$empno?>&paycode=<?=$paycode?>';

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
    
     <table width="100%"  cellspacing="2" cellpadding="0">
    	<tr><td><h4>Emp No : <?=$empno?> Name : <?=$empname?> </h4> <?
        	
		$selectp="select paycode from  tbatt_approve where  empno='$empno' and paycode='$paycode' ";
				$rep=mssql_query($selectp);
				$nump=mssql_num_rows($rep);
				if($nump>0){
					?> <a href="popatt.php?empno=<?=$empno?>&paycode=<?=$paycode?>" target="_blank">Print ATT</a><?
					}
			
		?></td></tr>
     </table>
     <form name="form" method="post" action="view_att_list.php?status=save">
     <input type="hidden" name="hdempno" value="<?=$empno?>">
     <input type="hidden" name="hdpaycode" value="<?=$paycode?>">
    <table width="100%"  cellspacing="2" cellpadding="0" class="table table-striped table-bordered datatables" id="example">
     
      <tr >
        <td width="67"  rowspan="2" align="center" bgcolor="#CCCCCC"><strong>Date</strong></td>
        <td width="67"  rowspan="2" align="center" bgcolor="#CCCCCC"><strong>Day Name</strong></td>
        <td width="76" rowspan="2" align="center" bgcolor="#CCCCCC"><strong>Shift</strong></td>
        <td width="76" rowspan="2" align="center" bgcolor="#CCCCCC"><strong>เวลา เข้างาน</strong></td>
        <td width="94" rowspan="2" align="center" bgcolor="#CCCCCC"><strong>เวลา ออกงาน</strong></td>
        <td width="106" rowspan="2" align="center" bgcolor="#CCCCCC"><strong>ชั่วโมงทำงาน</strong></td>
        <td width="49" rowspan="2" align="center" bgcolor="#CCCCCC"><strong>OT In</strong></td>
        <td width="49" rowspan="2" align="center" bgcolor="#CCCCCC"><strong>OT Out</strong></td>
        <td width="68" align="center" bgcolor="#CCCCCC"><strong>Normal</strong></td>
        <td colspan="4" align="center" bgcolor="#CCCCCC"><strong>OT</strong></td>
        <td width="127" rowspan="2" align="center" bgcolor="#CCCCCC"><strong>FL</strong></td>
        <td width="127" rowspan="2" align="center" bgcolor="#CCCCCC"><strong>Shift</strong></td>
        <td width="127" rowspan="2" align="center" bgcolor="#CCCCCC"><strong>Remark</strong></td>
      </tr>
     
      <tr>
        <td align="center" bgcolor="#CCCCCC"><strong>1</strong></td>
        <td width="84" align="center" bgcolor="#CCCCCC"><strong>1</strong></td>
        <td width="88" align="center" bgcolor="#CCCCCC"><strong>1.5</strong></td>
        <td width="60" align="center" bgcolor="#CCCCCC"><strong>2</strong></td>
        <td width="156" align="center" bgcolor="#CCCCCC"><strong>3</strong></td>
        </tr>
       <?
	   $selects="select convert(varchar, startotday, 108)as startotday ,convert(varchar, startotnight, 108)as startotnight from  tbsite where site='$site' ";
				$res=mssql_query($selects);
				$rows=mssql_fetch_array($res);
				$startotday=$rows['startotday'];
				$startotnight=$rows['startotnight'];
		
		//// UPDATE tbatt ///////
		$update = "update tbatt set paycode='$paycode' where attDateTime between '".$startdate."' and '".$enddate."' ";
		mssql_query($update);
		//// UPDATE tbatt ///////
					
	   
      	$select0="SELECT *,
		convert(varchar, workdate, 101)as  workdate2,
		convert(varchar, workdate, 103)as  workdate3
		
FROM    tbot_parameter where workdate between '".$startdate."' and '".$enddate."' and site='$site'  order by workdate asc ";
	$re0=mssql_query($select0);
	$num0 = mssql_num_rows($re0);
	if($num0>0){
		
	while($row0=mssql_fetch_array($re0)){
		
		$otin = "";
		$otout = "";
		$attDateTime1 = "";
		$attDate1 = "";
		$attDate2="";
		$attTime1 = "";
		$attTime2 = "";
		$total_ot="";
		$haveot="";
		$workhours = "";
				$workhours_wo_ot = "";
				$remark = "";
				$nocalot = "";
			  
		
		$select4="select *, 
	convert(varchar, attDateTime, 101)as attDate1, 
	convert(varchar, attDateTime, 108)as attTime1 , 
	
	convert(varchar, attDateTime2, 101)as attDate2, 
	convert(varchar, attDateTime2, 108)as attTime2 , 
	
	convert(varchar, attDateTime, 103)as attDate3, 
	convert(varchar, attDateTime, 108)as attTime3 
	
from tbatt where empno='".$empno."' 
and CAST(attDateTime AS DATE)='".$row0['workdate']."' and (CAST(attDateTime AS TIME) > '05:00' and CAST(attDateTime AS TIME) < '17:00') ";
	
	$re4=mssql_query($select4);
				
				$row4=mssql_fetch_array($re4);
				
$selectot="select id,shift,ot,fl,remark from tbatt where empno='".$empno."' and CAST(attDateTime AS DATE)='".$row0['workdate']."' order by id desc  ";
//$selectot="select id,shift,ot,fl,remark from tbot_mng where empno='".$empno."' and CAST(workdate AS DATE)='".$row0['workdate']."' order by id desc  ";
	$reot=mssql_query($selectot);
	$numot = mssql_num_rows($reot);
	if($numot>0){
		$rowot=mssql_fetch_array($reot);
		$sShift = $rowot['shift'];
		$sOT = $rowot['ot'];
		$sFL = $rowot['fl'];
		$id = $rowot['id'];
		$remark = iconv("tis-620", "utf-8", $rowot['remark']);
		
		
		}else{
			$sFL = "";
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
					$leavename = $row_ln['leavename'];
					
					}else{
						$leavetypeid = "";
						$leavename ="";
						}
		 
		
		
	  ?>
      <tr>
      
       <td align="center"><?=$row0['workdate3']?><input type="hidden" name="iworkdate[]" value="<?=$row0['workdate2']?>" class="form-control"></td>
        <td align="center"><?=$row0['dayname_en']?><input type="hidden" name="idayname_en[]" value="<?=$row0['dayname_en']?>" class="form-control"></td>
        <td align="center"><?
      //  echo $selectot;
		//echo $sShift; 
		?><select style="width:50px" id="shift_time<?=$rowot['id']?>" class="form-control" onChange="updateshift('<?=$rowot['id']?>');"  >
     <option value="Day" <?
     if($sShift=='Day'){
		 ?> selected<?
		 }
	 ?>>D</option>
     <option value="Night"  <?
     if($sShift=='Night'){
		 ?> selected<?
		 }
	 ?>>N</option>
     </select><input type="hidden" class="form-control" name="iShift[]" value="<?=$sShift?>"></td>
        <td align="center"><?
		
		
		
		if($sShift=='Night'){
			$select5="select *, 
			convert(varchar, attDateTime, 101)as attDateTime1, 
convert(varchar, attDateTime, 108)as attDateTime2 , 
convert(varchar, attDateTime, 103)as attDateTime3 from tbatt where empno='".$empno."' 
and CAST(attDateTime AS DATE)='".$row0['workdate']."' and (CAST(attDateTime AS TIME) >= '12:00') ";
	$re5=mssql_query($select5);
	$num5 = mssql_num_rows($re5);
	
	$row5=mssql_fetch_array($re5);
		  $attDateTime1 = $row5['attDateTime1']." ".$row5['attDateTime2'];	
		  $attDate1= $row5['attDateTime1'];
		   $attTime1 = $row5['attDateTime2'];	 
		  echo  $row5['attDateTime3']." ".$row5['attDateTime2'];
			}else{
				
			 if($row4['attDate1']!=''){
				      $attDateTime1 = $row4['attDate1']." ".$row4['attTime1'];	
					  $attDate1 = $row4['attDate1'];	
					   $attTime1 = $row4['attTime1'];	
					   echo  $row4['attDate3']." ".$row4['attTime3'];  
					
				}else{
					//$attDateTime1 = $row0['workdate2']." 08:00:00";
					//  $attDate1 = $row0['workdate2'];	 
					//  $attTime1 = "08:00:00";
				//cho  $attDateTime1;
				}
			
				}
		
		
         if($sShift=='Night'){
			//$select5="select *, convert(varchar, attDateTime, 101)as attDateTime1, 
//convert(varchar, attDateTime, 108)as attDateTime2 , 
//convert(varchar, attDateTime, 101)as attDateTime3 from tbatt where empno='".$empno."' 
//and CAST(attDateTime AS DATE)='".$row0['workdate']."' and (CAST(attDateTime AS TIME) >= '12:00') ";
//	$re5=mssql_query($select5);
//	$num5 = mssql_num_rows($re5);
//	
//	$row5=mssql_fetch_array($re5);
//		  $attDateTime1 = $row5['attDateTime1']." ".$row5['attDateTime2'];	
//		  $attDate1= $row5['attDateTime1'];
//		   $attTime1 = $row5['attDateTime2'];	 
//		  echo  $attDateTime1;
			 }else{
				 
				// if($num5>0){
//				      $attDateTime1 = $row4['attDate1']." ".$row4['attTime1'];	
//					  $attDate1 = $row4['attDate1'];	
//					   $attTime1 = $row4['attTime1'];	  
//					 echo  $attDateTime1;
//				}else{
//					$attDateTime1 = $row0['workdate2']." 08:00:00";
//					  $attDate1 = $row0['workdate2'];	 
//					  $attTime1 = "08:00:00";
//					 echo  $attDateTime1;
//				}
			
			 } ?>
             <input type="hidden" class="form-control" name="iattDateTime1[]" value="<?=$attDateTime1?>">
		</td>
         <td align="center"><?
         if($sShift=='Night'){
		
			 $select6="select *, convert(varchar, attDateTime, 101)as attDateTime1, 
convert(varchar, attDateTime, 108)as attDateTime2 , 
convert(varchar, attDateTime, 103)as attDateTime3 from tbatt where empno='".$empno."' 
and CAST(attDateTime AS DATE)= DATEADD(day, +1, '".$row0['workdate']."') and (CAST(attDateTime AS TIME) < '08:00') ";
	//DATEADD(day, +1, '2016-11-22')
	$re6=mssql_query($select6);
	$num6 = mssql_num_rows($re6);
	if($num6>0){
				$row6=mssql_fetch_array($re6);
				 $attDateTime2 = $row6['attDateTime1']." ".$row6['attDateTime2'];
				  $attDate2  = $row6['attDateTime1'];
				  $attTime2  = $row6['attDateTime2'];
				  echo $row6['attDateTime3']." ".$row6['attDateTime2'];
	}else{
		 $attDateTime2 = "";
		 
		}
				  
			
			 	}else{
					$select5="select *, convert(varchar, attDateTime, 101)as attDateTime1, 
convert(varchar, attDateTime, 108)as attDateTime2 , 
convert(varchar, attDateTime, 103)as attDateTime3 from tbatt where empno='".$empno."' 
and CAST(attDateTime AS DATE)='".$row0['workdate']."' and (CAST(attDateTime AS TIME) >= '12:00') order by id desc ";
	$re5=mssql_query($select5);
	$num5 = mssql_num_rows($re5);
	if($num5>0){
	$row5=mssql_fetch_array($re5);
		  $attDateTime2 = $row5['attDateTime1']." ".$row5['attDateTime2'];	
		  $attDate2  = $row5['attDateTime1'];
		  $attTime2  = $row5['attDateTime2'];
		  echo $row5['attDateTime3']." ".$row5['attDateTime2'];
	}else{
		$attDateTime2 = "";
		}
		  // echo $attDateTime2;
			if($attDateTime2=='' && $row0['work_type']=='Normal working'){
				//echo "no data";
				?>
				<select style="width:130px; color:#00F" id="leavetypeid<?=$rowot['id']?>" class="form-control" >
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
    
     
     </select>
				<?
				
				 if($leavetypeid==''){
					 
					 ?><input type="button" value="Create Leave" onClick="createleave('<?=$rowot['id']?>','<?=$empno?>','<?=$row0['workdate2']?>');"><?
					 }else{
						 echo iconv("tis-620", "utf-8", $leavename );
						 }
				
				}
			 }
		 ?><input type="hidden"  class="form-control" name="iattDateTime2[]" value="<?=$attDateTime2?>"></td>
          <td align="center"><?
		  
		  if($attDateTime2!="" && $attDateTime1!="" ){
			  if($sShift=='Night'){
				   $workhours =  DateTimeDiff($attDate1." 20:00:00",$attDateTime2)-1;
				  	}else{
						if($emptype=='temp'){
							// echo DateTimeDiff($attDateTime1,$attDate1." 08:00:00");
							 //ถ้า temp มาหลัง 8 โมง
							 if(DateTimeDiff($attDateTime1,$attDate1." 08:00:00")<0){
								 $nocalot='yes';
								  //ถ้า temp มาหลังเที่ยง
								 if(DateTimeDiff($attDateTime1,$attDate1." 12:00:00")<0){
									  $workhours =  DateTimeDiff($attDateTime1,$attDateTime2);
									 }else{
										  $workhours =  DateTimeDiff($attDateTime1,$attDateTime2)-1;
										 }
								 }else{
									  $workhours =  DateTimeDiff($attDate1." 08:00:00",$attDateTime2)-1;
									 }
							
							// echo ">>workhours=$workhours<<";
							}else{
								 $workhours =  DateTimeDiff($attDate1." 08:00:00",$attDateTime2)-1;
								}
				  
				  }
         
		  	
		   if($workhours>0){
			  if($row0['work_type']=='H Sat , Sun' || $row0['work_type']=='H' || $row0['work_type']=='H Sat'){
				 	
					$otin = "08:00:00";
					$datecheck = $attDate1." ".$otin;
					$xx=0;
					$yy=0;
					$otout = "";
					$otout2 = "";
					$haveot = DateTimeDiff($datecheck,$attDateTime2);
					
					$otin = $datecheck;
					
				  }else{ 
				  //echo "sShift=".$sShift;
			if($sShift=='Night'){
				
					$otin = $startotnight;
					$datecheck = $attDate2." ".$otin;
					$otin = $datecheck;
					$xx=0;
					$yy=0;
					$otout = "";
					$otout2 = "";
					$haveot = DateTimeDiff($datecheck,$attDateTime2);
				//	echo $haveot;
					if($haveot>0){
					//	echo "haveot";
							for($ii=0;$ii<=50;$ii++){
						$time = strtotime(date($datecheck));
						$datecheck = date("m/d/Y H:i:s",strtotime("+15 minutes", $time));
						//echo $datecheck."=";
					//	echo DateTimeDiff($datecheck,$attDateTime2);
						
					//	echo "<BR>";
						
						if(DateTimeDiff($datecheck,$attDateTime2)<0){
							
							if($xx==0){
								if(DateTimeDiff($datecheck,$attDateTime2)>-0.2){
										//echo $datecheck;
										$otout =  $datecheck;
										$xx=1;
									}else{
										$otout = $datecheck2;
										$xx=1;
										}
								
								}
							}else{
								$datecheck2 = $datecheck;
								}
						}
					
					}
					
				}else{
					
					
					$otin = $startotday;
					
					$datecheck = $attDate1." ".$otin;
					//$datecheck = $attDate1." 17:00:00";
					$datecheck2 = '';
					$otin = $datecheck;
					$xx=0;
					$yy=0;
					$otout = "";
					$otout2 = "";
					$haveot = DateTimeDiff($datecheck,$attDateTime2);
					
					if($haveot>0.15){
						//echo $haveot;
					//	echo "haveot";
						
						
						for($ii=0;$ii<=50;$ii++){
	$time = strtotime(date($datecheck));	

//echo $time;

	$datecheck = date("m/d/Y H:i:s",strtotime("+15 minutes", $time ));
	
	//echo $datecheck."=";
	//echo DateTimeDiff($datecheck,$attDateTime2);
				 
				 
	//echo $datecheck;
	//echo "<BR>";
	
	if(DateTimeDiff($datecheck,$attDateTime2)<0){
							
							if($xx==0){
								if(DateTimeDiff($datecheck,$attDateTime2)>-0.2){
									
									//echo ">>".$datecheck."<<<br>";
										
									$otout =  $datecheck;
										$xx=1;
									}else{
										$otout = $datecheck2;
										$xx=1;
										}
								
								}
							}else{
								$datecheck2 = $datecheck;
								}

	
}
					
					}

					
					}
				} 	
			}
			
			
			
		
		  if($haveot>0.15){
			//  echo "workhours=".$workhours;
			// echo $otout;
		  	$total_ot = DateTimeDiff($otin,$otout);
			//echo "total ot =".$total_ot;
			//echo $workhours;
			$workhours_wo_ot = $workhours - $total_ot;
			
			//echo (int)$workhours_wo_ot;
		//	echo $total_ot+8;
			//echo $workhours - $total_ot;
		  }else{
			  $workhours_wo_ot = $workhours;
			   $total_ot= "";
			   $otout = "";
			   $otin = "";
			  }
		  }
		    if($row0['work_type']=='H Sat , Sun' || $row0['work_type']=='H' || $row0['work_type']=='H Sat'){
					
			  	$otin =$attDate1." ".$attTime1;
				$otout = $attDate2." ".$attTime2;
				$total_ot =(int)$workhours;
				$workhours_wo_ot = 0;
				echo $total_ot;
				?>
				<input type="hidden" class="form-control" name="iworkhours[]" value="<?=$total_ot?>">
				<?
			  //	echo (int)$workhours_wo_ot+$total_ot;
			  }else{
				  echo (int)$workhours_wo_ot+$total_ot;
				  ?>
				  <input type="hidden" class="form-control" name="iworkhours[]" value="<?=(int)$workhours_wo_ot+$total_ot?>">
				  <?
				  }
		
		  
		  ?></td>
        <td align="center"><?
      			echo $otin;
		?> <input type="hidden" name="iotin[]" class="form-control" value="<?=$otin?>"></td>
        <td align="center"><?
        	echo $otout;
		?><input type="hidden" name="iotout[]" class="form-control" value="<?=$otout?>"></td>
        <td align="center"><?
        echo (int)$workhours_wo_ot;
		?><input type="hidden" name="inormal[]" class="form-control" value="<?=(int)$workhours_wo_ot?>"></td>
        <td width="84" align="center"><?
        if($haveot>0 ){
			
	if($row0['work_type']=='H Sat , Sun' || $row0['work_type']=='H' || $row0['work_type']=='H Sat'){
				 
	
	    $calc_rate = $attDate2." ".$otout;
		//echo $calc_rate.">>".$attDate2." 08:00:00";
		//echo $row0['work_type']. $calc_rate;
		//echo "//".DateTimeDiff($calc_rate,$attDate2." 08:00:00")."//";
	   
	    if(DateTimeDiff($calc_rate,$attDate2." 08:00:00")<0){
			$rate = $row0['rate1'];
			
			
			}else if(DateTimeDiff($attDate2." 08:00:00",$calc_rate<0)){
				 $rate = $row0['rate2'];
				}else if(DateTimeDiff($attDate2." 00:00:00",$calc_rate)){
				
				 $rate = $row0['rate3'];
				}else if(DateTimeDiff($attDate2." 05:00:00",$calc_rate)){
				
				 $rate = $row0['rate4'];
				}
			if($row0['work_type']=='H'){	
			if($emptype=='temp'){
					$rate = 2;
				}else{
					$rate = 2;
					}
			}
					
			if($row0['work_type']=='H Sat , Sun'){
					if($emptype=='temp'){
						$rate = 2;
						}else{
							$rate = 1;
							}
				}
				
			//	echo "rate =".$rate;
	
	  
					
		
				 }else{
				 
	 
	    $calc_rate = $attDate2." ".$otout;
	//	echo $calc_rate;
	//	echo "-";
		//echo $attDate2." ".$startotday;
	//	echo ">>".DateTimeDiff($calc_rate,$attDate2." ".$startotday)."<<";
	    if(DateTimeDiff($calc_rate,$attDate2." ".$startotday)<0){
			$rate = $row0['rate1'];
			} if(DateTimeDiff($attDate2." ".$startotday,$calc_rate<0)){
				 $rate = $row0['rate2'];
				} if(DateTimeDiff($attDate2." 00:00:00",$calc_rate)){
				
				 $rate = $row0['rate3'];
				} if(DateTimeDiff($attDate2." 05:00:00",$calc_rate)){
				
				 $rate = $row0['rate4'];
				}
				
			
				
				//echo $rate;
	
	  
					
		
				 }
			
		if($nocalot=="yes"){
			
			$rate='1';
			}
		
		}else{
			$rate = "";
			}
					if($rate=='1'){
						echo $total_ot;
						
						}
		
		?><input type="hidden" name="irate1[]" class="form-control" value="<?
		if($rate=='1'){
						echo $total_ot;
						
						}
		?>"></td>
        <td width="88" align="center"><?
        if($rate=='1.5'){
						echo $total_ot;
						}
		?><input type="hidden" name="irate1_5[]" class="form-control" value="<?
		if($rate=='1.5'){
						echo $total_ot;
						
						}
		?>"></td>
        <td width="60" align="center"><?
        if($rate=='2'){
						echo $total_ot;
						}
		?><input type="hidden" name="irate2[]" class="form-control" value="<?
		if($rate=='2'){
						echo $total_ot;
						
						}
		?>"></td>
        <td width="156" align="center"><?
        if($rate=='3'){
						echo $total_ot;
						}
		?><input type="hidden" name="irate3[]" class="form-control" value="<?
		if($rate=='3'){
						echo $total_ot;
						
						}
		?>"></td>
        <td align="center"><?
         if($workhours>0){
			 echo $sFL;
			 }else{
			 $sFL = "";
			 }
		?><input type="hidden" name="ifl[]" class="form-control" value="<?=$sFL?>"></td>
        <td align="center"><?
        if($sShift=='Night'){
		echo "yes";
		?><input type="hidden" name="ishiftval[]" class="form-control" value="yes"><?
			}else{
					?><input type="hidden" name="ishiftval[]" class="form-control" value=""><?
				}
		?></td>
        <td align="center"><?=$remark?><input type="hidden" name="iremark[]" class="form-control" value="<?=$remark?>"></td>
      </tr>
      <?
	}
	}
	  ?>
    </table>
    <?
    	
	?>
    <input type="submit" value="Submit">
    <?
		
	?>
    </form>
    <HR>
  

		<?
        }
		
		
		if($status=='save'){
			$empno = $_REQUEST['hdempno'];
			$paycode = $_REQUEST['hdpaycode'];
			$iworkdate = $_REQUEST['iworkdate'];
			$idayname_en= $_REQUEST['idayname_en'];
			$iShift= $_REQUEST['iShift'];
			$iattDateTime1= $_REQUEST['iattDateTime1'];
			$iattDateTime2= $_REQUEST['iattDateTime2'];
			$iworkhours= $_REQUEST['iworkhours'];
			$iotin= $_REQUEST['iotin'];
			$iotout= $_REQUEST['iotout'];
			$inormal= $_REQUEST['inormal'];
			$ishiftval = $_REQUEST['ishiftval'];
			
			$irate1= $_REQUEST['irate1'];
			$irate1_5= $_REQUEST['irate1_5'];
			$irate2= $_REQUEST['irate2'];
			$irate3= $_REQUEST['irate3'];
			$iremark=  $_REQUEST['iremark'];
			
			$ifl= $_REQUEST['ifl'];
			
			//clear approve
			$del = "delete from tbatt_approve where empno='$empno' and paycode='$paycode'";
			mssql_query($del);
			
			for($i=0;$i<count($iworkdate);$i++) {
				//echo $iworkdate[$i].">>";
		//	echo $idayname_en[$i].">>";
//				echo $iShift[$i].">>";
//				echo $iattDateTime1[$i].">>";
//				echo $iattDateTime2[$i].">>";
//				echo $iworkhours[$i].">>";
//				echo $iotin[$i].">>";
//				echo $iotout[$i].">>";
//				echo $inormal[$i].">>";
//				echo $irate1[$i].">>";
//				echo $irate1_5[$i].">>";
//				echo $irate2[$i].">>";
//				echo $irate3[$i].">>";
//				echo $iremark[$i].">>";
//			    echo $ifl[$i]."<BR>";
//echo "<BR>";
				
				//SELECT        TOP (200) id, iworkdate, idayname_en, iShift, iattDateTime1, iattDateTime2, iworkhours, iotin, iotout, inormal, irate1, irate1_5, irate2, irate3, iremark, ifl, paycode, empno FROM            tbatt_approve
				
				$select="select iworkdate from  tbatt_approve where iworkdate = '".$iworkdate[$i]."' and empno='$empno' and paycode='$paycode' ";
				$re=mssql_query($select);
				$num=mssql_num_rows($re);
				if($num<=0){
					if($inormal[$i]==''){$inormal[$i]=0;}
					if($irate1[$i]==''){$irate1[$i]=0;}
					if($irate1_5[$i]==''){$irate1_5[$i]=0;}
					if($irate2[$i]==''){$irate2[$i]=0;}
					if($irate3[$i]==''){$irate3[$i]=0;}
					
					
					$iremark[$i]= iconv("utf-8", "tis-620", $iremark[$i]);
					
							$insert = "insert into tbatt_approve (iworkdate, idayname_en, iShift, iattDateTime1, iattDateTime2, iworkhours, iotin, iotout, inormal, irate1, irate1_5, irate2, irate3, iremark, ifl, paycode,empno,status_approve,ishiftval) values('".$iworkdate[$i]."', '".$idayname_en[$i]."', '".$iShift[$i]."', '".$iattDateTime1[$i]."', '".$iattDateTime2[$i]."', ".$iworkhours[$i].", '".$iotin[$i]."', '".$iotout[$i]."', ".$inormal[$i].", ".$irate1[$i].", ".$irate1_5[$i].", ".$irate2[$i].", ".$irate3[$i].", '".$iremark[$i]."', '".$ifl[$i]."', '".$paycode."','".$empno."','1','".$ishiftval[$i]."')";
							//echo $insert;
							//echo "<BR>";
							//echo "<BR>";
							mssql_query($insert);
					}
								
				}
				
				echo "Approve Complete.";
				?><input type="button" value="Back" onClick="location='view_att_list.php?empno=<?=$empno?>&paycode=<?=$paycode?>'"><?
			
			
			
			
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