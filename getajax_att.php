<?
include("connect.php");
include("library.php");

$status = $_REQUEST['status'];
$date_time=date("m/d/Y H:i:s");

if($status=='updateshift'){
	$id = $_REQUEST['id'];
	$shift_time = $_REQUEST['shift_time'];
	
		$update = "update tbatt set shift='".$shift_time."' where id=$id";
		mssql_query($update);
		//echo $update;
	}
if($status=='upadtehbd'){
	$hbd = $_REQUEST['hbd'];
	$other = $_REQUEST['other'];
	$bonus = $_REQUEST['bonus'];
	$empno = $_REQUEST['empno'];
	$paycode = $_REQUEST['paycode'];
	$leave_without_pay = $_REQUEST['leave_without_pay'];
	$personal_leave = $_REQUEST['personal_leave'];
	$absent = $_REQUEST['absent'];
	$other_deduct = $_REQUEST['other_deduct'];
	$no_attendance = $_REQUEST['no_attendance'];
	
		$update = "update tbsalary set hbd=$hbd,other=$other,leave_without_pay=$leave_without_pay,
personal_leave=$personal_leave,absent=$absent,other_deduct=$other_deduct,bonus=$bonus,no_attendance=$no_attendance where empno='$empno' and paycode='$paycode' ";
		mssql_query($update);
		echo $update;
	}



if($status=='upadtehbd_mgr'){
	$hbd = $_REQUEST['hbd'];
	$empno = $_REQUEST['empno'];
	$paycode = $_REQUEST['paycode'];
	$leave_without_pay = $_REQUEST['leave_without_pay'];
	$personal_leave = $_REQUEST['personal_leave'];
	$absent = $_REQUEST['absent'];
	$other_deduct = $_REQUEST['other_deduct'];
	
	$mte_val = $_REQUEST['mte_val'];
	$travel_val = $_REQUEST['travel_val'];
	$mobile_val = $_REQUEST['mobile_val'];
	$position_val = $_REQUEST['position_val'];
	
	
		$update = "update tbsalary set hbd=$hbd,leave_without_pay=$leave_without_pay,
personal_leave=$personal_leave,absent=$absent,other_deduct=$other_deduct ,mte_val=$mte_val,travel_val=$travel_val,mobile_val=$mobile_val,position_val=$position_val where empno='$empno' and paycode='$paycode' ";
		mssql_query($update);
		//echo $update;
	}

if($status=='updateDate'){
	$id = $_REQUEST['id'];
	$attDateTime = $_REQUEST['attDateTime'];
	$attDateTime2 = $_REQUEST['attDateTime2'];
	$attDateTime3 = $_REQUEST['attDateTime3'];
	if($attDateTime2=='' || $attDateTime2==' '){
			//$update = "update tbatt set attDateTime2=NULL,attDateTime3='$attDateTime3' where id=$id";
			//mssql_query($update);
			$update = "update tbatt set attDateTime2=NULL ";
			
		}else{
			$update = "update tbatt set attDateTime2='$attDateTime2' ";
			}
	if($attDateTime3=='' || $attDateTime3==' ' ){
		//	$update = "update tbatt set attDateTime2='$attDateTime2',attDateTime3=NULL where id=$id";
		//	mssql_query($update);
		//$attDateTime3 =NULL;
		$update .= ",attDateTime3=NULL ";
		}else{
			$update .= ",attDateTime3='$attDateTime3' ";
			}
				$update .= "  where id=$id";
			
	mssql_query($update);
		
		echo $update;
	}


if($status=='createleave'){
					$leavedate  = $_REQUEST['leavedate'];
					$leavetypeid= $_REQUEST['leavetypeid'];
					$empno = $_REQUEST['empno'];
		//empno, leaveid, createdate, leaveapprovedate, leavestartdate, leaveenddate, remark, headapprove
		//CAST(attDateTime AS DATE)='".$row0['workdate']."'
		
		$select0 = "select * from  tbleave where CAST(leavestartdate AS DATE)='".$leavedate."' and empno='$empno'  ";
				$re0=mssql_query($select0);
				$num0=mssql_num_rows($re0);
				if($num0<=0){
					
		$select="select leaveid from tbrunning  ";
		$re=mssql_query($select);
		$num=mssql_num_rows($re);
		$row=mssql_fetch_array($re);
		if($num==0){
		//	$newid = "TR".date("y")."000001";
			}else{
				//OPDA011507160001
				//PCS121016000001
				$tmp_newid = $row['leaveid'];
				//$num_day = substr($tmp_newid,5,2);
				//echo $num_day;
				//$tmp_newid = $tmp_newid+1;
									$qid = (int)$tmp_newid + 1;
									$tmpid = "00000000000".$qid;
									$qdno = substr($tmpid,-11);
									$leaveid = "L".$qdno;	
									
									$update="update tbrunning set leaveid=leaveid+1  ";
									mssql_query($update);
				}
				
				$createdate = $date_time;
				$leaveapprovedate  = $date_time;
				$leavestartdate  = $leavedate;
				$leaveenddate  = $leavedate;
				$remark = "Manual Leave from system";
				
				
					
					
					$insert = "insert into tbleave(empno,leavetypeid, leaveid, createdate, leaveapprovedate, leavestartdate, leaveenddate, remark, headapprove) values('$empno','$leavetypeid', '$leaveid', '$createdate', '$leaveapprovedate', '$leavestartdate', '$leaveenddate', '$remark', '$headapprove')";
					mssql_query($insert);
					
					
					
					
					}

	}
if($status=='createleave2'){
					$leavedate  = $_REQUEST['leavedate'];
					$leavetypeid= $_REQUEST['leavetypeid'];
					$empno = $_REQUEST['empno'];
		//empno, leaveid, createdate, leaveapprovedate, leavestartdate, leaveenddate, remark, headapprove
		//CAST(attDateTime AS DATE)='".$row0['workdate']."'
		
		$select0 = "select * from  tbleave_transaction where CAST(leavestartdate AS DATE)='".$leavedate."' and empno='$empno'  ";
				$re0=mssql_query($select0);
				$num0=mssql_num_rows($re0);
				if($num0<=0){
		
		
		$sql = "SELECT TOP(1) leaveid FROM tbleave_transaction ORDER BY leaveid DESC";
		$re=mssql_query($sql);
		$num=mssql_num_rows($re);
		$leaveid = 'L00000000001';
		if($num>0){
		$row=mssql_fetch_array($re);
		$leaveid = (int)substr($row['leaveid'],1)+1;
		$leaveid = "00000000000".$leaveid;
		$leaveid = substr($leaveid,-11);
		$leaveid = "L".$leaveid;	
		}
				
		
				
				$createdate = $date_time;
				$leaveapprovedate  = $date_time;
				$leavestartdate  = $leavedate;
				$leaveenddate  = $leavedate;
				$remark = "Manual Leave from system";
				
					
					
					$insert = "insert into tbleave_transaction(empno,leavetypeid, leaveid, createdate, leaveapprovedate, leavestartdate, leaveenddate, remark, headapprove,statusapprove,leavetotal,hr) values('$empno','$leavetypeid', '$leaveid', '$createdate', '$leaveapprovedate', '$leavestartdate', '$leaveenddate', '$remark', '$headapprove','Approve',1,'Approve')";
					mssql_query($insert);
					
					
					
					
					}

	}
	
	if($status=='showemponsite'){
	$tsite = $_REQUEST['tsite'];
	$paycode = $_REQUEST['paycode'];
	$select0="SELECT site,empno,firstname,lastname from tbemployee where site='".$tsite."' and emp_level in('1','2') and delstatus='0' order by empno asc ";
	$re0=mssql_query($select0);
	while($row0=mssql_fetch_array($re0)){
		$empnosly = "";
		 if($paycode!=''){
		$selects="SELECT total_salary from tbsalary where empno='".$row0['empno']."' and paycode='$paycode'";
		$res=mssql_query($selects);
		$rows=mssql_fetch_array($res);
		$empnosly =  " (".$rows['total_salary'].")";
		}
		
		echo $row0['empno']."@@@".$row0['site']." ".$row0['empno']." ".iconv("tis-620", "utf-8", $row0['firstname'])." ".iconv("tis-620", "utf-8", $row0['lastname'])." ".$empnosly."###";
		
		
		
		}
		
		}
		
		if($status=='showemponsite_mgr'){
	$site = $_REQUEST['site'];
	$paycode = $_REQUEST['paycode'];
	$select0="SELECT site,empno,firstname,lastname from tbemployee where site='".$site."' and emp_level not in('1','2') order by empno asc ";
	$re0=mssql_query($select0);
	while($row0=mssql_fetch_array($re0)){
		$empnosly = "";
		 if($paycode!=''){
		$selects="SELECT total_salary from tbsalary where empno='".$row0['empno']."' and paycode='$paycode'";
		$res=mssql_query($selects);
		$rows=mssql_fetch_array($res);
		$empnosly =  " (".number_format($rows['total_salary'], 2, '.', '').")";
		}
		
		echo $row0['empno']."@@@".$row0['site']." ".$row0['empno']." ".$row0['firstname']." ".$row0['lastname'].$empnosly."###";
		
		
		
		}
		
		}


if($status=='updateATT'){
	$iremark  = $_REQUEST['iremark'];
	$iremark = iconv( "utf-8","tis-620", $iremark );
	$ifl = $_REQUEST['ifl'];
	if(empty($ifl)){
		$ifl =0;
		}
	$irate3 = $_REQUEST['irate3'];
	if(empty($irate3)){
		$irate3 =0;
		}
	$irate2 = $_REQUEST['irate2'];
	if(empty($irate2)){
		$irate2 =0;
		}
	$irate1_5 = $_REQUEST['irate1_5'];
	if(empty($irate1_5)){
		$irate1_5 =0;
		}
	$irate1 = $_REQUEST['irate1'];
	if(empty($irate1)){
		$irate1 =0;
		}
	$inormal = $_REQUEST['inormal'];
	if(empty($inormal)){
		$inormal =0;
		}
	$iotin= $_REQUEST['iotin'];
	$iotout = $_REQUEST['iotout'];
	if(!empty($iotout) && !empty($iotin)){
	//	$condout = "iotout='$iotout'";
		$condin = "iotin='$iotin',iotout='$iotout',";
		}
	
	
	$iworkhours = $_REQUEST['iworkhours'];
	if(empty($iworkhours)){
		$iworkhours =0;
		}
	$id= $_REQUEST['id'];
	
	
	
	$update = "update tbatt_approve set  
	iworkhours=$iworkhours, $condin inormal=$inormal, irate1=$irate1, irate1_5=$irate1_5, irate2=$irate2, irate3=$irate3, iremark='$iremark', ifl='$ifl' where id=$id";
	//echo $update;
	mssql_query($update);
	}
	
	if($status=='updateRemark'){
	$iremark  = $_REQUEST['iremark'];
	$iremark = iconv( "utf-8","tis-620", $iremark );
	$id= $_REQUEST['id'];
	$update = "update tbatt_approve set iremark='$iremark' where id=$id";
	echo $update;
	mssql_query($update);
	}
if($status=="modal_personal_leave"){
	$paycode = $_POST["paycode"];
	$empno = $_POST["empno"];
	$sql_paycode = "SELECT * FROM tbpaycode WHERE paycode='$paycode'";
	$res_paycode= mssql_query($sql_paycode);
	$row_paycode = mssql_fetch_array($res_paycode);
	$startdate = $row_paycode["startdate"];
	$enddate = $row_paycode["enddate"];
	$paycodeyear = $row_paycode["paycodeyear"];

	/*$sql_leave = "SELECT * FROM tbleave_transaction 
	WHERE ('$enddate' between leavestartdate  AND leaveenddate  or CAST(leaveenddate as date) <='$enddate')
	AND YEAR(leavestartdate) ='$paycodeyear'
	AND leavetypeid='L0002'
	AND empno='$empno'
	AND statusapprove='Approve'
	order by leavestartdate asc";*/
	?>
	<table class='table table-bordered'>
		<thead>
			<th>Start Date</th>
			<th>End Date</th>
			<th>Total Date</th>
			<th>Reason</th>
			<th>Approve By</th>
		</thead>
	<?
	$sql_leave = "SELECT convert(varchar, leavestartdate, 103)as leavestartdate_date,
					convert(varchar, leaveenddate, 103)as leaveenddate_date,
					reasons,headapprove,leavetotal
	 FROM tbleave_transaction 
	WHERE YEAR(leavestartdate) ='$paycodeyear'
	AND leavetypeid='L0002'
	AND empno='$empno'
	AND statusapprove='Approve'
	order by leavestartdate asc";
	$res_leave = mssql_query($sql_leave);
	while($row_leave = mssql_fetch_array($res_leave)){
		$leavestartdate = $row_leave["leavestartdate_date"];
		$leaveenddate = $row_leave["leaveenddate_date"];
		$leavetotal = $row_leave["leavetotal"];
		$reasons = lang_thai_from_database($row_leave["reasons"]);
		$headapprove = lang_thai_from_database($row_leave["headapprove"]);
		?>
		<tr>
			<th><?=$leavestartdate?></th>
			<th><?=$leaveenddate?></th>
			<th><?=$leavetotal?></th>
			<th><?=$reasons?></th>
			<th><?=$headapprove?></th>
		</tr>
		<?
	}
	?></table><?
	
}



if($status=='close_job_no_att'){
	$id = $_REQUEST['id'];
	
	$update = "update tbatt_approve set status_noatt_deduct = 'Close' where id =$id";
	mssql_query($update);
	}