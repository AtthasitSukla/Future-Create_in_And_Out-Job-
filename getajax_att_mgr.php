<?
include("connect.php");

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
	$empno = $_REQUEST['empno'];
	$paycode = $_REQUEST['paycode'];
	$leave_without_pay = $_REQUEST['leave_without_pay'];
	$personal_leave = $_REQUEST['personal_leave'];
	$absent = $_REQUEST['absent'];
	$other_deduct = $_REQUEST['other_deduct'];
	
		$update = "update tbsalary set hbd=$hbd,leave_without_pay=$leave_without_pay,
personal_leave=$personal_leave,absent=$absent,other_deduct=$other_deduct where empno='$empno' and paycode='$paycode' ";
		mssql_query($update);
		//echo $update;
	}



if($status=='upadtehbd_mgr'){
	$hbd = $_REQUEST['hbd'];
	$empno = $_REQUEST['empno'];
	$paycode = $_REQUEST['paycode'];
	$leave_without_pay = $_REQUEST['leave_without_pay'];
	$personal_leave = $_REQUEST['personal_leave'];
	$absent = $_REQUEST['absent'];
	$other_deduct = $_REQUEST['other_deduct'];
	$shift_val = $_REQUEST['shift_val'];
	$mte_val = $_REQUEST['mte_val'];
	$travel_val = $_REQUEST['travel_val'];
	$mobile_val = $_REQUEST['mobile_val'];
	$total_shift_val = $_REQUEST['total_shift_val'];
	$position_val = $_REQUEST['position_val'];
	//$total_fl = $_REQUEST['total_fl'];
	
	
		$update = "update tbsalary set hbd=$hbd,leave_without_pay=$leave_without_pay,
personal_leave=$personal_leave,absent=$absent,other_deduct=$other_deduct ,mte_val=$mte_val,travel_val=$travel_val,mobile_val=$mobile_val,position_val=$position_val,total_shift_val=$total_shift_val where empno='$empno' and paycode='$paycode' ";
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
	
	
	if($status=='showemponsite'){
	$site = $_REQUEST['site'];
	$paycode = $_REQUEST['paycode'];
	$select0="SELECT site,empno,firstname,lastname from tbemployee where site='".$site."' and emp_level in('1','2') order by empno asc ";
	$re0=mssql_query($select0);
	while($row0=mssql_fetch_array($re0)){
		$empnosly = "";
		 if($paycode!=''){
		$selects="SELECT total_salary from tbsalary where empno='".$row0['empno']."' and paycode='$paycode'";
		$res=mssql_query($selects);
		$rows=mssql_fetch_array($res);
		$empnosly =  " (".$rows['total_salary'].")";
		}
		
		echo $row0['empno']."@@@".$row0['site']." ".$row0['empno']." ".$row0['firstname']." ".$row0['lastname'].$empnosly."###";
		
		
		
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
		$empnosly =  " (".$rows['total_salary'].")";
		}
		
		echo $row0['empno']."@@@".$row0['site']." ".$row0['empno']." ".$row0['firstname']." ".$row0['lastname'].$empnosly."###";
		
		
		
		}
		
		}


if($status=='updateATT'){
	$iremark  = $_REQUEST['iremark'];
	$ifl = $_REQUEST['ifl'];
	$irate3 = $_REQUEST['irate3'];
	$irate2 = $_REQUEST['irate2'];
	$irate1_5 = $_REQUEST['irate1_5'];
	$irate1 = $_REQUEST['irate1'];
	$inormal = $_REQUEST['inormal'];
	$iotout = $_REQUEST['iotout'];
	$iotin= $_REQUEST['iotin'];
	$iworkhours = $_REQUEST['iworkhours'];
	$id= $_REQUEST['id'];
	
	
	
	$update = "update tbatt_approve set  
	iworkhours=$iworkhours, iotin='$iotin', iotout='$iotout', inormal=$inormal, irate1=$irate1, irate1_5=$irate1_5, irate2=$irate2, irate3=$irate3, iremark='$iremark', ifl='$ifl' where id=$id";
	echo $update;
	mssql_query($update);
	}
	
	if($status=='updateRemark'){
	$iremark  = $_REQUEST['iremark'];
	
	$id= $_REQUEST['id'];
	$update = "update tbatt_approve set iremark='$iremark' where id=$id";
	echo $update;
	mssql_query($update);
	}
?>