<? include("connect.php");  ?>
<?
	 
	//echo cal_days_in_month(CAL_GREGORIAN, 11, 2009); 
	$status = $_REQUEST['status'];
	$paycode = $_REQUEST['paycode'];
	$empno = $_REQUEST['empno'];
	$site = $_REQUEST['site'];


		//$empno='59014';
		
		if($empno!=''){
				$select="select att_reward,firstname,lastname,empno,site,skill_reward,basic_wage,basic_salary,emptype,position_val, mte_val, travel_val, mobile_val from  tbemployee where empno = '$empno' ";
				$re=mssql_query($select);
				
					$row=mssql_fetch_array($re);
					$site = $row['site'];
					$skill_reward= $row['skill_reward'];
					$empname = iconv("tis-620", "utf-8", $row['firstname'] )." ".iconv("tis-620", "utf-8", $row['lastname'] );
					if($skill_reward==''){
						$skill_reward = 0;
						}
					$att_reward = $row['att_reward'];
					if($att_reward==''){
						$att_reward = 0;
						}
					$basic_wage =  $row['basic_wage'];
					$basic_salary =  $row['basic_salary'];
					$position_val=  $row['position_val'];
					$mte_val=  $row['mte_val']; 
					$travel_val=  $row['travel_val']; 
					$mobile_val=  $row['mobile_val'];
					
					
					
					

					$car_rice = 75;
					$emptype  =  $row['emptype'];
					if($emptype=='employee'){
					$ot_rate_emp = ($basic_salary/30)/8;
					$leave_rate_emp = $basic_salary/30;
					//echo "($basic_salary/30)/8=";
					//	echo $ot_rate_emp;
					}else{
						$ot_rate_emp = ($basic_wage)/8;
						$leave_rate_emp = $basic_wage;
					//	echo "$basic_wage/8=";
					//	echo $ot_rate_emp;
						}
					
					
					if($site=='TSC'){
							$start_ot = "17:20:00";
							$start_ot_night = "05:40:00";
							
						}else{
							$start_ot = "17:30:00";
							$start_ot_night = "05:40:00";
							}
		}
		
		if($paycode!=''){
			
			$select="select paycodeyear,paycode,convert(varchar, startdate, 101)as  startdate,
	convert(varchar, enddate, 101)as  enddate from  tbpaycode where paycode = '$paycode' ";
				$re=mssql_query($select);
				$num=mssql_num_rows($re);
				
					$row=mssql_fetch_array($re);
					$startdate = $row['startdate'];
					$enddate = $row['enddate'];
					$paycodeyear = $row['paycodeyear'];
				
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
	var site = $("#site").val();
	var empno = $("#empno").val();
	window.location = 'time_att_list_mgr.php?paycode='+paycode+'&empno='+empno+'&site='+site;
	}

function updateshift(id){
	var shift_time = $("#shift_time"+id).val();
		$.post( "getajax_att_mgr.php", { 	
	status: "updateshift", 
	shift_time : shift_time,
	id: id,
	sid: Math.random() 
	})
	.done(function( data ) {
	//alert(data);

 });
	}
	
	function upadtehbd(empno,paycode){
	var hbd = $("#hbd").val();
	var leave_without_pay= $("#leave_without_pay").val();
	var personal_leave= $("#personal_leave").val();
	var absent= $("#absent").val();
	var other_deduct= $("#other_deduct").val();
	var total_shift_val= $("#total_shift_val").val();
	var total_fl= $("#total_fl").val();
	var position_val= $("#position_val").val();
	var mte_val= $("#mte_val").val();
	var travel_val= $("#travel_val").val();
	var mobile_val= $("#mobile_val").val();
	
		$.post( "getajax_att_mgr.php", { 	
	status: "upadtehbd_mgr", 
	position_val:position_val, 
	mte_val:mte_val, 
	travel_val:travel_val, 
	mobile_val:mobile_val,
	total_shift_val:total_shift_val,
	total_fl:total_fl,
	hbd : hbd,
	leave_without_pay : leave_without_pay,
	personal_leave : personal_leave,
	absent : absent,
	other_deduct : other_deduct,
	empno: empno,
	paycode: paycode,
	sid: Math.random() 
	})
	.done(function( data ) {
		
	window.location='time_att_list_mgr.php?paycode=<?=$paycode?>&empno=<?=$empno?>&site=<?=$site?>';

 });
	}
	function updateDate(id){
	var attDateTime = $("#attDateTime"+id).val();
	var attDateTime2 = $("#attDateTime2"+id).val();
	var attDateTime3 = $("#attDateTime3"+id).val();
		$.post( "getajax_att_mgr.php", { 	
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
				
				$.post( "getajax_att_mgr.php", { 	
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
	
	
	
	function printslip(empno,paycode,paycodeyear){
		window.open('popslip_mgr.php?empno='+empno+'&paycode='+paycode+'&paycodeyear='+paycodeyear+'','popup','width=800,height=400,scrollbars=yes');
		}
	
	function showemponsite(){
		var site = $("#site").val();
		var paycode = $("#paycode").val();
		$.post( "getajax_att_mgr.php", { 	
					status: "showemponsite_mgr", 
					site : site,
					paycode : paycode,
					sid: Math.random() 
					})
					.done(function( data ) {
					
				//	alert(data);
					
					var aa =data;
					var bb = aa.split("###",150);
					
					
					
					var select, i, option;

					select = document.getElementById( 'empno' );
					select.options.length = 0;
					for ( i = 0; i < bb.length-1; i ++ ) {
						
						 cc = bb[i].split("@@@",150);
						
						option = document.createElement( 'option' );
						option.value = cc[0];
						option.text = cc[1];
						select.add( option );
					}
				
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
     <td width="6%" height="40" align="right"><strong>Site</strong></td>
     <td width="19%"><select id="site" class="form-control"  name="site"   style="width:200px;" onChange="showemponsite();">
     <option value="">Select</option>
    <?
    	$select0="SELECT site from  tbsite ";
	$re0=mssql_query($select0);
	while($row0=mssql_fetch_array($re0)){
		?>
		 <option value="<?=$row0['site']?>" <?
         if($site==$row0['site']){
			 ?> selected<?
			 }
		 ?>><?=$row0['site']?></option>
		<?
		}
	?>
     </select></td>
    <td width="13%" height="40" align="right"><strong>Employee Number</strong></td>
   <td width="30%"><select id="empno" class="form-control"  name="empno"   style="width:280px;">
     <option value="">Select</option>
   <?
	
	if($site!=''){
    $select0="SELECT empno,firstname,lastname from tbemployee where site='".$site."' and emp_level not in('1','2') order by empno asc ";
	$re0=mssql_query($select0);
	while($row0=mssql_fetch_array($re0)){
		?>
		 <option value="<?=$row0['empno']?>" <?
         if($empno==$row0['empno']){
			 ?> selected<?
			 }
		 ?>><?=$site?> <?=$row0['empno']?> <?=$row0['firstname']?> <?=$row0['lastname']?> <?
    if($paycode!=''){
		$selects="SELECT total_salary from tbsalary where empno='".$row0['empno']."' and paycode='$paycode'";
		$res=mssql_query($selects);
		$rows=mssql_fetch_array($res);
		echo "(".$rows['total_salary'].")";
		}
	
		
		
		 ?></option>
		<?
		
		}}
	?>
		
     </select></td>
     <td width="24%"><input type="button" value="Select" onClick="showpaycode();"></td>
     <td width="8%" align="right"><input type="button" value="Update" onClick="window.location.reload();" ></td>
    </tr></table>
    
	<table align="center" width="100%" border="0" cellspacing="2" cellpadding="0" class="table table-striped table-bordered datatables" id="example">
    <tr >
        <td width="96" align="center" bgcolor="#CCCCCC"><strong>Date</strong></td>
        <td width="98"  align="center" bgcolor="#CCCCCC"><strong>Day Name</strong></td>
        <td width="60"  align="center" bgcolor="#CCCCCC"><strong>Shift</strong></td>
        <td width="129" align="center" bgcolor="#CCCCCC"><strong>เวลา เข้างาน</strong></td>
        <td width="116" align="center" bgcolor="#CCCCCC"><strong>เวลา ออกงาน</strong></td>
         <td width="57" align="center" bgcolor="#CCCCCC"><strong>OT </strong></td>
    <td width="53" align="center" bgcolor="#CCCCCC"><strong>Rate</strong></td>
    <td width="84" align="center" bgcolor="#CCCCCC"><strong>เงินค่า OT</strong></td>
    <td width="67" align="center" bgcolor="#CCCCCC"><strong>ข้าว+รถ</strong></td>
     <td width="54" align="center" bgcolor="#CCCCCC"><strong>FL</strong></td>
    <td width="56" align="center" bgcolor="#CCCCCC"><strong>ค่ากะ</strong></td>
   <td width="156" align="center" bgcolor="#CCCCCC"><strong>รวม</strong></td>
       
      </tr>
 
    
    <?
	
		
		
		if($empno!=''){
		/////////////////////////////////////////////////////////////////////////////////////////////
		
		$select0="SELECT *,convert(varchar, iattDateTime1, 101)as  iattDate1,convert(varchar, iattDateTime1, 108)as  iattTime1,convert(varchar, iattDateTime2, 101)as  iattDate2,convert(varchar, iattDateTime2, 108)as  iattTime2 ,
		
		convert(varchar, iotin, 108)as  iotintime,
		convert(varchar, iotout, 108)as  iotouttime 
FROM    tbatt_approve where empno='$empno' and paycode='$paycode'  order by iworkdate asc ";
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
	$ot_time = '';
	$rate = '';
	
	
	$total_personal_leave = 0;
	$total_absent = 0;
	$total_sick_day= 0;
	$total_personal_day= 0;
	$total_anual_day= 0;
	$total_absent_day= 0;
	$total_day_day = 0;
	$total_day_night = 0;
	
	while($row0=mssql_fetch_array($re0)){
		$ot_time = '';
		$rate = '';
		if($row0['irate1']>0){
			$ot_time = $row0['irate1'];
			$rate = 1;
			}
		if($row0['irate1_5']>0){
			$ot_time = $row0['irate1_5'];
			$rate = 1.5;
			}
		if($row0['irate2']>0){
			$ot_time = $row0['irate2'];
			$rate = 2;
			}
		if($row0['irate3']>0){
			$ot_time = $row0['irate3'];
			$rate = 3;
			}
		
		//check leave date
		$select_le = "select * from  tbleave where CAST(leavestartdate AS DATE)='".$row0['iworkdate']."' and empno='$empno'  ";
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
						//check leave date
		
		?>
		<tr >
    <td width="96" align="center"><?=$row0['iworkdate']?></td>
    <td width="98" height="40" align="center"><?=$row0['idayname_en']?></td>
    <td width="60" align="center"><?=$row0['iShift']?></td>
    <td width="129" align="center"><?
	 if($leavetypeid!=''){
		
			echo $leavename;
			
			}
		if($row0['iworkhours']>0){
			echo $row0['iattDate1']?> <?=$row0['iattTime1'];
			}
		?></td>
      <td width="116" align="center"><?
         if($row0['iworkhours']>0){
		 echo $row0['iattDate2']?> <?=$row0['iattTime2'];
		 } ?></td>
     <td width="57" align="center"><?=$ot_time?></td>
     <td width="53" align="center"><?=$rate?></td>  
     <td width="84" align="center"><?
	 $ot_val = 0;
	 if($ot_time!=''){
		 if($emptype=='employee'){
			 $ot_val = ($ot_time*$ot_rate_emp);
			 }else{
				  $ot_val = $ot_time*($ot_rate_emp);
				 }
     	
		$ot_val = number_format($ot_val, 2, '.', '');
		//echo $ot_val;
		$ot_val = $ot_val*$rate;
		$ot_val = number_format($ot_val, 2, '.', '');
		echo $ot_val;
	 }
	 ?></td>  <td width="67" align="center"><?
	 
     if($row0['iworkhours'] > 0 ){
		
	 echo $car_rice;
	 }
	 ?></td>  
     <td width="54" align="center"><?
     if($row0['ifl']=='yes'){
		 $fl = 50;
		 
		 }else{
			$fl = 0; 
			 }
			 echo $fl;
	 ?></td>  
     <td width="56" align="center"><?
     if($row0['iShift']=='Night'){
		 $shift_val = 120;
		 
		 }else{
			$shift_val = 0; 
			 }
			 echo $shift_val;
	 ?></td>  
     <td width="156" align="center"><?
	 //L0001 ลาป่วย
	 //L0002 ลากิจ
	 //L0003 ลาพักร้อน
	 //L0006 ขาดงาน
      if($leavetypeid!=''){
		  
		$basic_wage2 = $basic_wage;
		$basic_salary2 = $basic_salary;
		//echo $leavetypeid;
		if($leavetypeid=='L0001'){
			$car_rice = 0;
			$total_sick_day++;
			}
		if($leavetypeid=='L0002'){
			$car_rice = 0;
			$total_personal_day++;
			$basic_wage2 = 0;
			$total_personal_leave = $total_personal_leave + $leave_rate_emp;
			}
		if($leavetypeid=='L0003'){
			$car_rice = 75;
			$total_anual_day++;
			}
		if($leavetypeid=='L0006'){
			$car_rice = 0;
			$total_absent_day++;
			$basic_wage2 = 0;
			$total_absent = $total_absent + $leave_rate_emp;
			}
		$leaveday = $leaveday+1;
			
			
			
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
			 
		if($emptype=='employee'){
			//echo "basic_salary = ".$basic_salary." <BR>";
			}else{
			echo "basic_wage = ".$basic_wage2." <BR>";
			}
		
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
		if($emptype=='employee'){
			echo $car_rice+$ot_val+$fl+$shift_val;
		$total=$car_rice+$ot_val+$fl+$shift_val;
		$total_total = $total_total+($car_rice+$ot_val+$fl+$shift_val);
			}else{
				echo $basic_wage2+$car_rice+$ot_val+$fl+$shift_val;
		$total=$basic_wage2+$car_rice+$ot_val+$fl+$shift_val;
		$total_total = $total_total+($basic_wage2+$car_rice+$ot_val+$fl+$shift_val);
				}
   		
		
		
		echo "(".$total_total.")";
		
		$car_rice = 75;
		
		}
		
		if($row0['iworkhours']>0){
			
			$total_day = $total_day+1;
			if($row0['iShift']=='Day'){
				$total_day_day++;
				}
			if($row0['iShift']=='Night'){
				$total_day_night++;
				}
			
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
			
			
			if($emptype=='employee'){
			//echo "basic_salary = ".$basic_salary." <BR>";
			}else{
			echo "basic_wage = ".$basic_wage." <BR>";
			} 
		
		
		echo "car_rice = ".$car_rice." <BR>";
		echo "ot_time = ".$ot_time." <BR>";
		echo "fl = ".$fl." <BR>";
		echo "shift_val = ".$shift_val." <BR>";
		echo "<hr>";
		echo "total_ot1 = ".$total_ot1." <BR>";
		echo "total_ot1_5 = ".$total_ot1_5." <BR>";
		echo "total_ot2 = ".$total_ot2." <BR>";
		echo "total_ot3 = ".$total_ot3." <BR>";
		
		echo "ot_val = ".$ot_val." <BR>";
		echo "( total ot = ".$total_ot.")<hr>";
		
		
		$total = 0;
		if($emptype=='employee'){
			echo $car_rice+$ot_val+$fl+$shift_val;
		$total=$car_rice+$ot_val+$fl+$shift_val;
		$total_total = $total_total+($car_rice+$ot_val+$fl+$shift_val);
			}else{
				echo $basic_wage+$car_rice+$ot_val+$fl+$shift_val;
		$total=$basic_wage+$car_rice+$ot_val+$fl+$shift_val;
		$total_total = $total_total+($basic_wage+$car_rice+$ot_val+$fl+$shift_val);
				}
   		
		
		
		echo "(".$total_total.")";
		/// UPDATE Line
		//$update = "update tbatt set fl=$fl, ot_val=$ot_val, car_rice=$car_rice, shift_val=$shift_val, total=$total 
  //where id=".$row2['id']."";
		//mssql_query($update);
		//echo $update;
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
	   
	   // select summary 
	   $selectp="select ytd_income, ytd_tax, ytd_social_in from tbytdsummary where empno='$empno' and paycodeyear='$paycodeyear'  ";
				$rep=mssql_query($selectp);
				
				$nump = mssql_num_rows($rep);
				if($nump>0){
						$rowp=mssql_fetch_array($rep);
						$ytd_income =  $rowp['ytd_income'];
						$ytd_tax =  $rowp['ytd_tax'];
						$ytd_social_in =  $rowp['ytd_social_in'];
					}else{
						$ytd_income =  0;
						$ytd_tax =  0;
						$ytd_social_in =  0;
					}
					
		
		$selecth="select total_fl,total_shift_val,position_val, mte_val, travel_val, mobile_val,hbd,leave_without_pay,personal_leave,absent,other_deduct from tbsalary where empno='$empno' and paycode='$paycode' ";
				$reh=mssql_query($selecth);
					$rowh=mssql_fetch_array($reh);
					$position_val= $rowh['position_val'];
					$mte_val= $rowh['mte_val'];
					$travel_val= $rowh['travel_val'];
					$mobile_val= $rowh['mobile_val'];
					$total_shift_val = $rowh['total_shift_val'];
					$total_fl = $rowh['total_fl'];
					$hbd = $rowh['hbd'];
					$leave_without_pay = $rowh['leave_without_pay'];
					$personal_leave = $rowh['personal_leave'];
					$absent = $rowh['absent'];
					$other_deduct = $rowh['other_deduct'];
					if($hbd==''){
						$hbd = 0;
						}
					if($personal_leave==''){
						$personal_leave = $total_personal_leave;
						}
					if($absent==''){
						$absent = $total_absent;
						}
					if($leave_without_pay==''){
						$leave_without_pay = 0;
						}
					if($other_deduct==''){
						$other_deduct = 0;
						}
					
				
				
				
	   
   ?>
    <table align="center" width="70%" border="1" cellspacing="0" cellpadding="0" >
      
      <tr>
        <td width="194" bgcolor="#CCCCCC">&nbsp;</td>
        <td width="124" align="center" bgcolor="#CCCCCC">&nbsp;</td>
        <td colspan="2" align="center" bgcolor="#CCCCCC">&nbsp;</td>
        <td width="119" bgcolor="#CCCCCC">&nbsp;</td>
        <td width="119" align="center" bgcolor="#CCCCCC"><input type="button" value="Print Slip" onClick="printslip('<?=$empno?>','<?=$paycode?>','<?=$paycodeyear?>');"></td>
      </tr>
      <tr>
        <td>Salary / Wage</td>
        <td align="center"><?
		if($emptype=='employee'){
			echo $basic_salary;
			}else{
				echo $basic_wage;
				}
		?> </td>
        <td colspan="2" align="center"></td>
        <td>Shift Day</td>
        <td><?=$total_day_day?> วัน</td>
      </tr>
      <tr>
        <td>มาทำงาน</td>
        <td align="center"><?=$total_day?> </td>
        <td colspan="2" align="center">วัน</td>
        <td>Shift Night</td>
        <td><?=$total_day_night?> วัน</td>
      </tr>
      <tr>
        <td>ลาป่วย</td>
        <td align="center"><?=$total_sick_day?> </td>
        <td colspan="2" align="center">วัน</td>
        <td></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>ลากิจ</td>
        <td align="center"><?=$total_personal_day?> </td>
        <td colspan="2" align="center">วัน</td>
        <td></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>ลาพักร้อน</td>
        <td align="center"><?=$total_anual_day?> </td>
        <td colspan="2" align="center">วัน</td>
        <td></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>ขาดงาน</td>
        <td align="center"><?=$total_absent_day?> </td>
        <td colspan="2" align="center">วัน</td>
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
        <td>ค่าตำแหน่ง</td>
        <td align="center"><input type="text" id="position_val" value="<?=$position_val?>" class="form-control"></td>
        <td colspan="2" align="center"></td>
        <td></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>ค่าเดินทาง</td>
        <td align="center"><input type="text" id="travel_val" value="<?=$travel_val?>" class="form-control"></td>
        <td colspan="2" align="center"></td>
        <td></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>ค่าโทรศัพท์</td>
        <td align="center"><input type="text" id="mobile_val" value="<?=$mobile_val?>" class="form-control"></td>
        <td colspan="2" align="center"></td>
        <td></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>ค่าซ่อมบำรุง</td>
        <td align="center"><input type="text" id="mte_val" value="<?=$mte_val?>" class="form-control"></td>
        <td colspan="2" align="center"></td>
        <td></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>ค่ากะ</td>
        <td align="center"><input type="text" id="total_shift_val" value="<?=$total_shift_val?>" class="form-control"></td>
        <td colspan="2" align="center"></td>
        <td></td>
        <td>&nbsp;</td>
      </tr>
      
      <tr>
        <td>วันเกิดพนักงานและครอบครัว</td>
        <td align="center"><input type="text" id="hbd" value="<?=$hbd?>" class="form-control"></td>
        <td colspan="2" align="center"></td>
        <td></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>ขาดงาน</td>
        <td align="center"><input type="text" id="absent" value="<?
		if($emptype=='employee'){
			echo $absent;
			}else{
			echo 0;
			}
		?>" class="form-control" ></td>
        <td colspan="2" align="center">(<?=$total_absent?>)</td>
        <td></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>ลากิจ</td>
        <td align="center"><input type="text" id="personal_leave" value="<?
		if($emptype=='employee'){
			echo $personal_leave;
			}else{
			echo 0;
			}
		?>" class="form-control" ></td>
        <td colspan="2" align="center">(<?=$total_personal_leave?>)</td>
        <td></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>ลาไม่ได้รับเงินเดือน</td>
        <td align="center"><input type="text" id="leave_without_pay" value="<?=$leave_without_pay?>" class="form-control"></td>
        <td colspan="2" align="center"></td>
        <td></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>หักอื่นๆ</td>
        <td align="center"><input type="text" id="other_deduct" value="<?=$other_deduct?>" class="form-control"></td>
        <td colspan="2" align="center"><input type="button" value="Save Update" onClick="upadtehbd('<?=$empno?>','<?=$paycode?>');"></td>
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
        <td align="left">เงินเดือน / ค่าแรง</td>
        <td align="center"><font color="#0000FF"><?
		if($emptype=='employee'){
			$total_wage = 0;
			echo $basic_salary;
			}else{
				$total_wage = $basic_wage*($total_day+$total_sick_day);
      			 echo $total_wage;
				}
		
		?></font></td>
        <td align="center">บาท</td>
        <td align="right">&nbsp;</td>
        <td align="center">&nbsp;</td>
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
        <td width="194">ค่าทักษะ</td>
        <td align="center"><font color="#0000FF"><?=$skill_reward?></font></td><td align="center">บาท</td>
        <td></td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
      </tr>
      
      <tr>
        <td width="194">ค่าตำแหน่ง</td>
        <td align="center"><font color="#0000FF"><?=$position_val?></font></td><td align="center">บาท</td>
        <td></td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
      </tr>
      <tr>
        <td width="194">ค่าเดินทาง</td>
        <td align="center"><font color="#0000FF"><?=$travel_val?></font></td><td align="center">บาท</td>
        <td></td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
      </tr>
      <tr>
        <td width="194">ค่าโทรศัพท์</td>
        <td align="center"><font color="#0000FF"><?=$mobile_val?></font></td><td align="center">บาท</td>
        <td></td>

        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
      </tr>
      <tr>
        <td width="194">ค่าซ่อมบำรุง</td>
        <td align="center"><font color="#0000FF"><?=$mte_val?></font></td><td align="center">บาท</td>
        <td></td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
      </tr>
      
      
      <tr>
        <td width="194">วันเกิดพนักงานและครอบครัว</td>
        <td align="center"><font color="#0000FF"><?=$hbd?></font></td><td align="center">บาท</td>
        <td></td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
      </tr>
      <tr>
        <td width="194"></td>
        <td align="center"></td>
        <td align="center"></td>
        <td></td>
        <td></td>
        <td align="center">&nbsp;</td>
      </tr>
      <tr>
        <td align="left">รวมเงินเดือน</td>
        <td align="center"><?
        if($emptype=='employee'){
			$total_total = $total_total+$basic_salary+$hbd+$att_reward+$position_val+$mte_val+$travel_val+$mobile_val+$total_shift_val;
			echo $total_total;
			}else{
				$total_total = $total_total+$hbd;
			echo $total_total;
			}
		?> </td>
        <td align="center">บาท</td>
        <td></td>
        <td></td>
        <td align="center">&nbsp;</td>
      </tr>
      <tr>
        <td align="left">หักขาดงาน</td>
        <td align="center"><font color="#FF0000"><?
		if($emptype=='employee'){
			echo $absent;
			}else{
			echo 0;
			}
		?></font></td>
        <td align="center">บาท</td>
        <td></td>
        <td></td>
        <td align="center">&nbsp;</td>
      </tr>
      <tr>
        <td align="left">หักลากิจ</td>
        <td align="center"><font color="#FF0000"><?
        if($emptype=='employee'){
			echo $personal_leave;
			}else{
			echo 0;
			}
		?></font></td>
        <td align="center">บาท</td>
        <td></td>
        <td></td>
        <td align="center">&nbsp;</td>
      </tr>
      <tr>
        <td align="left">หักลาไม่ได้รับเงินเดือน</td>
        <td align="center"><font color="#FF0000"><?=$leave_without_pay?></font></td>
        <td align="center">บาท</td>
        <td></td>
        <td></td>
        <td align="center">&nbsp;</td>
      </tr>
      <tr>
        <td align="left">หักอื่นๆ</td>
        <td align="center"><font color="#FF0000"><?=$other_deduct?></font></td>
        <td align="center">บาท</td>
        <td></td>
        <td></td>
        <td align="center">&nbsp;</td>
      </tr>
      <tr>
        <td align="left">หักประกันสังคม</td>
        <td align="center"><font color="#FF0000"><?
		if($emptype=='employee'){
				 $social_in = ($basic_salary*.05);
			}else{
				 $social_in =($total_day*$basic_wage)*.05;
				
			}
		if( $social_in > 750 ){
			 $social_in = 750;
			}
       
		?><?=$social_in?></font></td>
        <td align="center">บาท</td>
        <td></td>
        <td></td>
        <td align="center">&nbsp;</td>
      </tr>
      <tr>
        <td align="left">หักภาษีเงินได้</td>
        <td align="center"><font color="#FF0000"><?
		$total_12 = $total_total*12;
		//=IF(C5*50%<100001,C5*50%,100000)
		if(($total_12*0.50)<100001){
			$deduct1=  $total_12*0.50;
			}else{
				$deduct1=  100000;
				}
		//ลดหย่อน 6 หมื่น + ประกันสังคม
	    $allowance = 60000+9000;
		$remain_deduct = $total_12 - $deduct1 -$allowance;
     // echo $remain_deduct."//";
		if($remain_deduct>=5000001){
			$tax = ((($remain_deduct - 5000000)*.35)+ 1265000.00)/12;
			}else if($remain_deduct>=2000001){
				$tax = ((($remain_deduct - 2000000)*.30)+365000.00)/12;
				}else if($remain_deduct>=1000001){
				$tax = ((($remain_deduct - 1000000)*.25)+115000.00)/12;
				}else if($remain_deduct>=750001){
				$tax = ((($remain_deduct - 750000)*.20)+65000.00)/12;
				}else if($remain_deduct>=500001){
				$tax = ((($remain_deduct - 500000)*.15)+27500.00)/12;
				}else if($remain_deduct>=300001){
				$tax = ((($remain_deduct - 300000)*.10)+  7500.00)/12;
				}else if($remain_deduct>=150001){
				$tax = (($remain_deduct - 150000)*.05)/12;
				}else if($remain_deduct>=1){
				$tax = 0;
				}
				echo number_format($tax, 2, '.', '')
				
				
		?><? ?></font></td>
        <td align="center">บาท</td>
        <td></td>
        <td></td>
        <td align="center">&nbsp;</td>
      </tr>
      <tr>
        <td align="left">&nbsp;</td>
        <td align="center"></td>
        <td align="center">&nbsp;</td>
        <td></td>
        <td>เงินได้สะสม</td>
        <td align="center"><?
        	echo $ytd_income;
		?></td>
      </tr>
      <tr>
        <td align="left">คงเหลือเงินเดือน</td>
        <td align="center"><strong><font color="#66CC66"><?
		if($emptype=='employee'){
			$total_salary=($total_total+$skill_reward)-$social_in-$tax-$absent-$personal_leave-$leave_without_pay-$other_deduct;
			}else{
				$total_salary=($total_total+$skill_reward)-$social_in-$leave_without_pay-$other_deduct;
				}
		
		echo number_format($total_salary, 2, '.', '');
		?></font></strong></td>
        <td align="center">บาท</td>
        <td>&nbsp;</td>
        <td>ประกันสังคมสะสม</td>
        <td align="center"><?
        	echo $ytd_social_in;
		?></td>
      </tr>
    </table>
<?



$att_reward=0;

if($total_shift_val==''){
	$total_shift_val = 0;
	}
if($total_fl==''){
	$total_fl = 0;
	}
if($position_val==''){
	$position_val = 0;
	}
if($mte_val==''){
	$mte_val = 0;
	}
if($travel_val==''){
	$travel_val = 0;
	}
if($mobile_val==''){
	$mobile_val = 0;
	}


	
	// insert & update salary table
	$selects="select paystatus,empno from tbsalary where empno='$empno' and paycode='$paycode' ";
				$res=mssql_query($selects);
				$nums=mssql_num_rows($res);
				$rows=mssql_fetch_array($res);
				if($nums>0){
					
					
					if($rows['paystatus']=='paid'){
						
						}else{
							$sqlupdate= "update  tbsalary set total_day=$total_day, total_car_rice=$total_car_rice, total_normal_day=$total_normal_day, total_wage=$total_wage, total_ot1=$total_ot1, total_ot1_5=$total_ot1_5, total_ot2=$total_ot2, total_ot3=$total_ot3,total_ot=$total_ot, att_reward=$att_reward, social_in=$social_in, skill_reward=$skill_reward,total_shift_val=$total_shift_val, total_salary=$total_salary,total_fl=$total_fl,subtotal_salary=$total_total,hbd=$hbd,absent=$absent,personal_leave=$personal_leave,leave_without_pay=$leave_without_pay,other_deduct=$other_deduct,position_val=$position_val, mte_val=$mte_val, travel_val=$travel_val, mobile_val=$mobile_val,tax=$tax  
							
							
							where empno='$empno' and paycode='$paycode' ";
							
					//echo $sqlupdate;
						mssql_query($sqlupdate);
					
							}
					
					
				
					}else{
						//absent=$absent,personal_leave=$personal_leave,leave_without_pay=$leave_without_pay,other_deduct=$other_deduct
						$sqlinsert = "insert into tbsalary(empno, paycode, total_day, total_car_rice, total_normal_day, total_wage, total_ot1, total_ot1_5, total_ot2, total_ot3,total_ot, att_reward, social_in, skill_reward,total_shift_val, total_salary,total_fl,subtotal_salary,paycodeyear,hbd,absent,personal_leave,leave_without_pay,other_deduct,position_val, mte_val, travel_val, mobile_val,tax)
						
						 values('$empno', '$paycode', $total_day, $total_car_rice, $total_normal_day, $total_wage, $total_ot1, $total_ot1_5, $total_ot2, $total_ot3,$total_ot, $att_reward, $social_in, $skill_reward, $total_shift_val,$total_salary,$total_fl,$total_total,'$paycodeyear',$hbd,$absent,$personal_leave,$leave_without_pay,$other_deduct,$position_val, $mte_val, $travel_val, $mobile_val,$tax)";
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