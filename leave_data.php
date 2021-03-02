<?php
include("connect.php");
date_default_timezone_set("Asia/Bangkok");
$dt = date("Y-m-d");
$status = $_REQUEST['status'];
$empno = $_REQUEST['empno'];

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
				return (strtotime($strDateTime2) - strtotime($strDateTime1))/  ( 60  ); // 1 min =  60*60
	 }
if($status == "R"){
	$select="select emp.firstname as firstname, emp.lastname as lastname, emp.emp_level as emp_level ,emp.startdate as startdate,pos.positionname as positionname  from tbemployee emp JOIN tbposition pos ON emp.positionid = pos.positionid where emp.empno = '$empno' ";
	$re=mssql_query($select);
	$row=mssql_fetch_array($re);
	$name = iconv("tis-620", "utf-8", $row['firstname'])."  ".iconv("tis-620", "utf-8", $row['lastname']);
	$position = $row['positionname'];	
	$startdate = $row['startdate'];	
	$emp_level = $row['emp_level'];	
	$count = (strtotime(date("Y-m-d")) - strtotime($startdate))/( 60 * 60 * 24 );
	$total_annual = 0; //พักร้อน
	$total_ordain = 0; //ลาบวช
	if($count >= 365){
		$total_ordain = 15;
	}
	if($count >= 365 && $count < 730){
		$total_annual = 6.00;
	}else if($count >= 730 && $count < 1095){
		$total_annual = 7.00;
	}else if($count >= 1095 && $count < 1460){
		$total_annual = 8.00;
	}else if($count >= 1460 && $count < 1825){
		$total_annual = 9.00;
	}else if($count >= 1825){
		$total_annual = 10.00;
	}
	if($total_annual == 0){
		$data = array(0,0,0);
	}else{
		$now_date = date("Y-m-d");
		//echo $now_date;
		//where date เข้าไป
		$select="select TOP(1) * from tbleave_work where e_date >= '$now_date' ";
		$re=mssql_query($select);
		$row=mssql_fetch_array($re);
		$e_date = date("d/m/Y", strtotime($row['e_date']));
		$l_years = $row['l_years'];
		//echo $row['s_date'].'-----'.$row['e_date'];
					
		
		$total_use_anual = 0;
		
		
		
		$selectx="select SUM(leavetotal) as total from tbleave_transaction where leavetypeid = 'L0003' AND empno = '$empno' AND (statusapprove = 'Approve' OR statusapprove = 'New') AND (leavestartdate BETWEEN  '".$row['s_date']."' AND '".$row['e_date']."')";
		$rex=mssql_query($selectx);
		$rowx=mssql_fetch_array($rex);
		if($rowx['total']==''){
			$total_use_anual = 0;
			}else{
				$total_use_anual = $rowx['total'];
				}
		
		
		
					$vacation_extra= 0;
					$total_vocation_remain = 0;
					$selectv1 = "SELECT        SUM(vacation_remain)+SUM(vacation_extra) AS total_remain
FROM            tbleave_vacation
WHERE        (empno='$empno') AND (l_years > 2019) and l_years < $l_years";
					$rev1 = mssql_query($selectv1);
					$numv1=mssql_num_rows($rev1);
					if($numv1>0){
					 $rowv1 = mssql_fetch_array($rev1);
					 $total_vocation_remain = $rowv1['total_remain']+$rowv1['total_remain'];
					
					}
					$selectv = "select * FROM  tbleave_vacation where l_years=$l_years and empno='$empno' ";
					$rev = mssql_query($selectv);
					$numv=mssql_num_rows($rev);
					if($numv>0){
						$rowv = mssql_fetch_array($rev);
						$vacation_extra =  (int)$rowv['vacation_extra'];
						$total_annual = $total_annual+$vacation_extra;
						 if($total_vocation_remain>0){
						  $total_annual = $total_annual+$total_vocation_remain;
						 }
						  if($total_annual>20){
							 $total_annual = 20;
							 }
					}
		
		$data = array(number_format($total_annual, 2, '.', ''),number_format($total_annual - $rowx['total'], 2, '.', ''),$total_use_anual,$e_date);
	}
	
	
	echo json_encode(array('info'=>array('name'=>$name,'position'=>$position,'emp_level'=>$emp_level,'startdate'=>date("d/m/Y", strtotime($startdate)),"count"=>$count),'data' => $data));
}
if($status == "C"){
	$s_leave = explode('/',$_POST['s_leave']);
	$s_leave = date("Y-m-d", strtotime($s_leave[1]."/".$s_leave[0]."/".$s_leave[2]));
	$e_leave = explode('/',$_POST['e_leave']);
	$e_leave = date("Y-m-d", strtotime($e_leave[1]."/".$e_leave[0]."/".$e_leave[2]));

	$select=" SELECT COUNT(id) as remain,min(workdate) as s_leave,max(workdate) as e_leave FROM tbot_parameter WHERE work_type != 'Normal working' AND (workdate BETWEEN '$s_leave' AND '$e_leave') AND site = '".$_POST['site']."'";
	$re=mssql_query($select);
	$row=mssql_fetch_array($re);
	$s_leave = 0;
	if($row['s_leave'] != null){
		$s_leave = $row['s_leave'];
	}
	$e_leave = 0;
	if($row['e_leave'] != null){
		$e_leave = $row['e_leave'];
	}
	echo json_encode(array($row['remain'],$s_leave,$e_leave));
}
if($status == "I"){
	$empno = $_POST['empno'];
	$type_leave = $_POST['type_leave'];
	$reasons = iconv( "utf-8","tis-620",$_POST['reasons']);
	$site = $_POST['site'];
	$shift = $_POST['shift'];
	$total_leave = $_POST['total_leave'];
	$sl_s_leave = $_POST['sl_s_leave'];
	$sl_e_leave = $_POST['sl_e_leave'];
	$s_leave = explode('/',$_POST['s_leave']);
	$s_leave = date("Y-m-d", strtotime($s_leave[1]."/".$s_leave[0]."/".$s_leave[2]));
	$e_leave = explode('/',$_POST['e_leave']);
	$e_leave = date("Y-m-d", strtotime($e_leave[1]."/".$e_leave[0]."/".$e_leave[2]));
	$start_time = $_POST['start_time'];
	$end_time = $_POST['end_time'];
	
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
	$file_new = '0';
	if($_FILES["file_att"]["tmp_name"] != ""){
		$type= strrchr($_FILES["file_att"]["name"],".");
		$file_new = $leaveid."$type";
		@move_uploaded_file($_FILES["file_att"]["tmp_name"],"leave_doc/".$file_new);
	}
	if($type_leave=="L0009"){
		$total_leave=DateDiff($s_leave,$e_leave);
		$total_leave=$total_leave+1;
		//echo $start_time;
		$sql = "INSERT INTO tbleave_transaction (empno, leaveid, leavetypeid, createdate, leavestartdate, leaveenddate, statusapprove, shift, leavetotal, reasons, file_att,hr,start_time,end_time) VALUES ('$empno','$leaveid','$type_leave', '".date('Y-m-d')."', '$s_leave', '$e_leave', 'New', '$shift', '$total_leave', '$reasons', '$file_new', 'New','$start_time','$end_time')";
		//echo $sql;
		$re=mssql_query($sql);
		
	}else{
		$sql = "INSERT INTO tbleave_transaction (empno, leaveid, leavetypeid, createdate, leavestartdate,leavestarttime, leaveenddate,leaveendtime, statusapprove, shift, leavetotal, reasons, file_att,hr) VALUES ('$empno','$leaveid','$type_leave', '".date('Y-m-d')."', '$s_leave','$sl_s_leave', '$e_leave','$sl_e_leave', 'New', '$shift', '$total_leave', '$reasons', '$file_new', 'New')";
		$re=mssql_query($sql);
	}
	echo $status."###".$empno."###".$type_leave."###".$s_leave."###".$e_leave."###".$_POST['reasons']."###".$empno;
	//send_mail($status,$empno,$type_leave,$s_leave,$e_leave,$_POST['reasons'],$empno);
	
}
if($status == "T"){
	$result = array();
	$search = @$_POST["search"]["value"];
	$emp_ctl = @$_POST["emp_ctl"];
	$type = $_POST["type"];
		$sql = "SELECT TOP(1)* FROM tbleave_transaction JOIN tbleavetype ON tbleave_transaction.leavetypeid = tbleavetype.leavetypeid ORDER BY tbleave_transaction.id DESC";
		
		if(strlen($search)){
			$search = str_replace('\\' , '' , $search );
			$sql = "SELECT *,tbleave_transaction.id as id,tbemployee.empno as empno FROM tbleave_transaction JOIN tbleavetype ON tbleave_transaction.leavetypeid = tbleavetype.leavetypeid JOIN tbemployee ON tbemployee.empno = tbleave_transaction.empno WHERE  $search ORDER BY tbleave_transaction.id DESC";
		}
		$re=mssql_query($sql);
		$num=mssql_num_rows($re);
		$i = 1;
		while($row = mssql_fetch_assoc($re)){
			$leavetypeid = $row['leavetypeid'];
			if($leavetypeid =="L0009"){
				$s_start = date("H:i",strtotime($row['start_time']));
				$e_end =  date("H:i",strtotime($row['end_time']));
			}else{
				$s_start = $row['leavestarttime'] == '0'? "เต็ม":"ครึ่ง";
				$e_end = $row['leaveendtime'] == '0'? "เต็ม":"ครึ่ง";
			}
			$row_array['item']   = $i;
			$row_array['leave_name']   = iconv("tis-620", "utf-8",$row['firstname'])." ".iconv("tis-620", "utf-8",$row['lastname']);
			$row_array['leave_type']   = iconv("tis-620", "utf-8",$row['leavename']);
			$row_array['shift']   = $row['shift'];
			$row_array['leave_create']   = f_date($row['createdate']);
			$row_array['leave_date']   = f_date($row['leavestartdate'])."(".($s_start).") - ".f_date($row['leaveenddate'])."(".($e_end).")</br> (".$row['leavetotal'].")";
			$row_array['reasons']   = iconv("tis-620", "utf-8",$row['reasons']);
			$row_array['att']   = icon_att($row['file_att']);
			$row_array['leave_status']   = $row['statusapprove']."</br> (".iconv("tis-620", "utf-8",$row['headapprove']).")";
			$row_array['hr']   = $row['hr'];
			$row_array['leave_action']   = $row['id'].",".$row['empno'];
			array_push($result, $row_array);
			$i++;
		}
	echo json_encode(array('data'=>$result));
	
}
if($status == "show_leavecount"){
	
	
		$sl_control = $_POST["sl_control"];
		$sl_control_list = $_POST["sl_control_list"];
		$sl_year = $_POST["sl_year"];
		$sl_year2 = $_POST["sl_year2"];
		
		
		$now_date = date("Y-m-d");
		//$select0="select TOP(1) * from tbleave_work where e_date >= '$now_date' ";
//		$re0=mssql_query($select0);
//		$row0=mssql_fetch_array($re0);
		//$e_date = date("d/m/Y", strtotime($row['e_date']));
		//echo $row['s_date'].'-----'.$row['e_date'];
		
		
		
		?>

		<?
		$select0="select TOP(1) * from tbleave_work where e_date >= '$now_date'  ";
		$re0=mssql_query($select0);
		$row0=mssql_fetch_array($re0);
	//$e_date = date("d/m/Y", strtotime($row0['e_date']));
				$e_date = date("m/d/Y", strtotime($row0['e_date']));
				$s_date = date("m/d/Y", strtotime($row0['s_date']));
				
				if($sl_year!==''){
			$txtsearch = "(leavestartdate BETWEEN  ".$sl_year.")";
			$txtsearch = str_replace('\\' , '' , $txtsearch );
			//echo $txtsearch;
			}else{
				$txtsearch = "(leavestartdate BETWEEN  '".$s_date."' AND '".$e_date."')";
				
				}
				//$arrappointment_date = explode("/",$appointment_date_r);
				//$appointment_date = $arrappointment_date[1]."/".$arrappointment_date[0]."/".$arrappointment_date[2];
		
		
		if($sl_control=='1'){
			$total_annual = calc_anual_day($_SESSION['admin_userid']);
			?>
			<table  border="0" class="table table-striped table-bordered datatables"  cellspacing="1" cellpadding="0">
 <tr>
    
    
    <td colspan="3"  align="center"><strong>ลาป่วย</strong></td>
    <td colspan="3"  align="center"><strong>ลากิจ</strong></td>
    <td colspan="3"  align="center"><strong>ลาพักร้อน</strong></td>
    <td colspan="3"  align="center"><strong>ลาบวช</strong></td>
    <td colspan="3"  align="center"><strong>ลาคลอด</strong></td>
    <td  align="center"><strong>ขาดงาน</strong></td>
    <td  align="center"><strong>ลาไม่ได้รับเงินเดือน</strong></td>
  </tr>
<tr>
    
    
    <td   align="center"><strong>ลาได้ทั้งหมด</strong></td>
    <td   align="center"><strong>ใช้ไปแล้ว</strong></td>
    <td  align="center"><strong>คงเหลือ</strong></td>
     <td   align="center"><strong>ลาได้ทั้งหมด</strong></td>
    <td  align="center"><strong>ใช้ไปแล้ว</strong></td>
    <td   align="center"><strong>คงเหลือ</strong></td>
    <td   align="center"><strong>ลาได้ทั้งหมด</strong></td>
    <td   align="center"><strong>ใช้ไปแล้ว</strong></td>
    <td   align="center"><strong>คงเหลือ</strong></td>
    <td  align="center"><strong>ลาได้ทั้งหมด</strong></td>
    <td   align="center"><strong>ใช้ไปแล้ว</strong></td>
    <td   align="center"><strong>คงเหลือ</strong></td>
    <td  align="center"><strong>ลาได้ทั้งหมด</strong></td>
    <td  align="center"><strong>ใช้ไปแล้ว</strong></td>
    <td align="center"><strong>คงเหลือ</strong></td>
    
    <td  align="center"><strong>ขาดงานไปแล้ว</strong></td>
   <td  align="center"><strong>ลาไปแล้ว</strong></td>
</tr>

            
            <tr>
    
   
    <?
		
	
    	$sql_leavetype = "select * from  tbleavetype where leavetypeid='L0001'";
		$re_leavetype=mssql_query($sql_leavetype);
		$row_leavetype = mssql_fetch_assoc($re_leavetype);
		
		$select="select SUM(leavetotal) as total from tbleave_transaction where leavetypeid = '".$row_leavetype['leavetypeid']."' AND empno = '".$_SESSION['admin_userid']."' AND (statusapprove = 'Approve' OR statusapprove = 'New') AND ".$txtsearch;
//	echo $select;
		$re=mssql_query($select);
		
		$row=mssql_fetch_array($re);
	?>
    <td  align="center"><?=$row_leavetype['leaveday']?></td>
    <td  align="center"><?
    if($row['total']!=''){
		echo $row['total'];
		}else{
			echo 0;
			}
	?></td>
    <td  align="center"><?
	echo $row_leavetype['leaveday']-$row['total'];
	?></td>
    
      <?
    	$sql_leavetype = "select * from  tbleavetype where leavetypeid='L0002'";
		$re_leavetype=mssql_query($sql_leavetype);
		$row_leavetype = mssql_fetch_assoc($re_leavetype);
		$select="select SUM(leavetotal) as total from tbleave_transaction where leavetypeid = '".$row_leavetype['leavetypeid']."' AND empno = '".$_SESSION['admin_userid']."' AND (statusapprove = 'Approve' OR statusapprove = 'New') AND ".$txtsearch;
		$re=mssql_query($select);
		
		$row=mssql_fetch_array($re);
	?>
    <td   align="center"><?=$row_leavetype['leaveday']?></td>
    <td   align="center"><?
    if($row['total']!=''){
		echo $row['total'];
		}else{
			echo 0;
			}
	?></td>
    <td  align="center"><?
	echo $row_leavetype['leaveday']-$row['total'];
	?></td>
    
    <?
    	$sql_leavetype = "select * from  tbleavetype where leavetypeid='L0003'";
		$re_leavetype=mssql_query($sql_leavetype);
		$row_leavetype = mssql_fetch_assoc($re_leavetype);
		$select="select SUM(leavetotal) as total from tbleave_transaction where leavetypeid = '".$row_leavetype['leavetypeid']."' AND empno = '".$_SESSION['admin_userid']."' AND (statusapprove = 'Approve' OR statusapprove = 'New') AND ".$txtsearch;
		
		$re=mssql_query($select);
		
		$row=mssql_fetch_array($re);
	?>
    <td   align="center"><?
   					$vacation_extra= 0;
					$total_vocation_remain = 0;
					$selectv1 = "SELECT       SUM(vacation_remain)+SUM(vacation_extra) AS total_remain
FROM            tbleave_vacation
WHERE        (empno='".$_SESSION['admin_userid']."') AND (l_years > 2019) and l_years < $sl_year2";
					$rev1 = mssql_query($selectv1);
					$numv1=mssql_num_rows($rev1);
					if($numv1>0){
					 $rowv1 = mssql_fetch_array($rev1);
					 $total_vocation_remain = $rowv1['total_remain'];
					
					}
					
					$selectv = "select * FROM  tbleave_vacation where l_years='$sl_year2' and empno='".$_SESSION['admin_userid']."' ";
					//echo $selectv;
					$rev = mssql_query($selectv);
					$numv=mssql_num_rows($rev);
					if($numv>0){
						$rowv = mssql_fetch_array($rev);
						$vacation_extra =  (int)$rowv['vacation_extra'];
						$total_annual = $total_annual+$vacation_extra;
						 if($total_vocation_remain>0){
						  $total_annual = $total_annual+$total_vocation_remain;
						 }
						 if($total_annual>20){
							 $total_annual = 20;
							 }
					}
	
	echo $total_annual;
	?></td>
    <td   align="center"><?
    if($row['total']!=''){
			
			echo $row['total'];
				
		}else{
			echo 0;
			}
	?></td>
    <td  align="center"><?
	echo $total_annual-$row['total'];
	?></td>
    
    <?
    	$sql_leavetype = "select * from  tbleavetype where leavetypeid='L0004'";
		$re_leavetype=mssql_query($sql_leavetype);
		$row_leavetype = mssql_fetch_assoc($re_leavetype);
		$select="select SUM(leavetotal) as total from tbleave_transaction where leavetypeid = '".$row_leavetype['leavetypeid']."' AND empno = '".$_SESSION['admin_userid']."' AND (statusapprove = 'Approve' OR statusapprove = 'New') AND ".$txtsearch;
		$re=mssql_query($select);
		
		$row=mssql_fetch_array($re);
	?>
    <td   align="center"><?=$row_leavetype['leaveday']?></td>
    <td   align="center"><?
    if($row['total']!=''){
		echo $row['total'];
		}else{
			echo 0;
			}
	?></td>
    <td  align="center"><?
	echo $row_leavetype['leaveday']-$row['total'];
	?></td>
    
    <?
    	$sql_leavetype = "select * from  tbleavetype where leavetypeid='L0005'";
		$re_leavetype=mssql_query($sql_leavetype);
		$row_leavetype = mssql_fetch_assoc($re_leavetype);
		$select="select SUM(leavetotal) as total from tbleave_transaction where leavetypeid = '".$row_leavetype['leavetypeid']."' AND empno = '".$_SESSION['admin_userid']."' AND (statusapprove = 'Approve' OR statusapprove = 'New') AND ".$txtsearch;
		$re=mssql_query($select);
		
		$row=mssql_fetch_array($re);
	?>
    <td   align="center"><?=$row_leavetype['leaveday']?></td>
    <td   align="center"><?
    if($row['total']!=''){
		echo $row['total'];
		}else{
			echo 0;
			}
	?></td>
    <td  align="center"><?
	echo $row_leavetype['leaveday']-$row['total'];
	?></td>
    
    <?
    	$sql_leavetype = "select * from  tbleavetype where leavetypeid='L0006'";
		$re_leavetype=mssql_query($sql_leavetype);
		$row_leavetype = mssql_fetch_assoc($re_leavetype);
		$select="select SUM(leavetotal) as total from tbleave_transaction where leavetypeid = '".$row_leavetype['leavetypeid']."' AND empno = '".$_SESSION['admin_userid']."' AND (statusapprove = 'Approve' OR statusapprove = 'New') AND ".$txtsearch;
		$re=mssql_query($select);
		$numL0006 = mssql_num_rows($re);
		$row=mssql_fetch_array($re);
	?>
   
    <td   align="center"><?
    if($row['total']!=''){
		echo $row['total'];
		}else{
			echo 0;
			}
	?></td>
     <?
    	$sql_leavetype = "select * from  tbleavetype where leavetypeid='L0011'";
		$re_leavetype=mssql_query($sql_leavetype);
		$row_leavetype = mssql_fetch_assoc($re_leavetype);
		$select="select SUM(leavetotal) as total from tbleave_transaction where leavetypeid = '".$row_leavetype['leavetypeid']."' AND empno = '".$_SESSION['admin_userid']."' AND (statusapprove = 'Approve' OR statusapprove = 'New') AND ".$txtsearch;
		$re=mssql_query($select);
		$numL0006 = mssql_num_rows($re);
		$row=mssql_fetch_array($re);
	?>
   
    <td   align="center"><?
    if($row['total']!=''){
		echo $row['total'];
		}else{
			echo 0;
			}
	?></td>
   
</tr>
            
            
            
		
			<?
		
		
		
		?></table><?
				
				
				}else{
					
					
					$select_control="select * from tbleave_control where  emp_control='".$_SESSION['admin_userid']."'";
					if($sl_control_list!=''){
							$select_control.=" and emp_under='".$sl_control_list."'";
						}
				
				
				if($_SESSION['admin_userid']=='56038'){
					$select_control="select distinct emp_under from tbleave_control ";
					if($sl_control_list!=''){
							$select_control.=" and emp_under='".$sl_control_list."'";
						}
					}
				$select_control.=" and emp_under not in(select empno from tbemployee where delstatus='1')"	;
			//	echo $select_control;
				$re_control=mssql_query($select_control);
				$num_control=mssql_num_rows($re_control);
				if($num_control>0){
					?>
	<table  border="0" class="table table-striped table-bordered datatables"  cellspacing="1" cellpadding="0">
    <tr>
    <td align="center"><strong>ชื่อ</strong></td>
    <td colspan="3"  align="center"><strong>ลาป่วย</strong></td>
    <td colspan="3"  align="center"><strong>ลากิจ</strong></td>
    <td colspan="3"  align="center"><strong>ลาพักร้อน</strong></td>
    <td colspan="3"  align="center"><strong>ลาบวช</strong></td>
    <td colspan="3"  align="center"><strong>ลาคลอด</strong></td>
    <td  align="center"><strong>ขาดงาน</strong></td>
    <td  align="center"><strong>ลาไม่ได้รับเงินเดือน</strong></td>
  </tr>
<tr>
    
     <td align="center"></td>
    <td   align="center"><strong>ลาได้ทั้งหมด</strong></td>
    <td   align="center"><strong>ใช้ไปแล้ว</strong></td>
    <td  align="center"><strong>คงเหลือ</strong></td>
     <td   align="center"><strong>ลาได้ทั้งหมด</strong></td>
    <td  align="center"><strong>ใช้ไปแล้ว</strong></td>
    <td   align="center"><strong>คงเหลือ</strong></td>
    <td   align="center"><strong>ลาได้ทั้งหมด</strong></td>
    <td   align="center"><strong>ใช้ไปแล้ว</strong></td>
    <td   align="center"><strong>คงเหลือ</strong></td>
    <td  align="center"><strong>ลาได้ทั้งหมด</strong></td>
    <td   align="center"><strong>ใช้ไปแล้ว</strong></td>
    <td   align="center"><strong>คงเหลือ</strong></td>
    <td  align="center"><strong>ลาได้ทั้งหมด</strong></td>
    <td  align="center"><strong>ใช้ไปแล้ว</strong></td>
    <td align="center"><strong>คงเหลือ</strong></td>
    
    <td  align="center"><strong>ขาดงานไปแล้ว</strong></td>
    <td  align="center"><strong>ลาไปแล้ว</strong></td>
   
</tr>
					<?
					while($row_control=mssql_fetch_array($re_control)){
							
					
				$select_emp="select firstname,lastname from tbemployee where  empno='".$row_control['emp_under']."'";
				$re_emp=mssql_query($select_emp);
				$row_emp=mssql_fetch_array($re_emp);		
							
				$empname = iconv("tis-620", "utf-8", $row_emp['firstname'] )." ".iconv("tis-620", "utf-8", $row_emp['lastnanme'] );
					
					
			$total_annual = calc_anual_day($row_control['emp_under']);
			?>
			
 

            
            <tr>
    
   
    <?
    	$sql_leavetype = "select * from  tbleavetype where leavetypeid='L0001'";
		$re_leavetype=mssql_query($sql_leavetype);
		$row_leavetype = mssql_fetch_array($re_leavetype);
		$select="select SUM(leavetotal) as total from tbleave_transaction where leavetypeid = '".$row_leavetype['leavetypeid']."' AND empno = '".$row_control['emp_under']."' AND (statusapprove = 'Approve' OR statusapprove = 'New') AND ".$txtsearch;
	
		$re=mssql_query($select);
		
		$row=mssql_fetch_array($re);
	?>
     <td align="center"><?=$empname?></td>
    <td  align="center"><?=$row_leavetype['leaveday']?></td>
    <td  align="center"><?
    if($row['total']!=''){
		echo $row['total'];
		}else{
			echo 0;
			}
	?></td>
    <td  align="center"><?
	echo $row_leavetype['leaveday']-$row['total'];
	?></td>
    
      <?
    	$sql_leavetype = "select * from  tbleavetype where leavetypeid='L0002'";
		$re_leavetype=mssql_query($sql_leavetype);
		$row_leavetype = mssql_fetch_array($re_leavetype);
		$select="select SUM(leavetotal) as total from tbleave_transaction where leavetypeid = '".$row_leavetype['leavetypeid']."' AND empno = '".$row_control['emp_under']."' AND (statusapprove = 'Approve' OR statusapprove = 'New') AND ".$txtsearch;
		$re=mssql_query($select);
		
		$row=mssql_fetch_array($re);
	?>
    <td   align="center"><?=$row_leavetype['leaveday']?></td>
    <td   align="center"><?
    if($row['total']!=''){
		echo $row['total'];
		}else{
			echo 0;
			}
	?></td>
    <td  align="center"><?
	echo $row_leavetype['leaveday']-$row['total'];
	?></td>
    
    <?
    	$sql_leavetype = "select * from  tbleavetype where leavetypeid='L0003'";
		$re_leavetype=mssql_query($sql_leavetype);
		$row_leavetype = mssql_fetch_array($re_leavetype);
		$select="select SUM(leavetotal) as total from tbleave_transaction where leavetypeid = '".$row_leavetype['leavetypeid']."' AND empno = '".$row_control['emp_under']."' AND (statusapprove = 'Approve' OR statusapprove = 'New') AND ".$txtsearch;
		$re=mssql_query($select);
		
		$row=mssql_fetch_array($re);
		
		
		
	?>
    <td   align="center"><?
    
					$vacation_extra= 0;
					$selectv = "select * FROM  tbleave_vacation where l_years='$sl_year2' and empno='".$row_control['emp_under']."' ";
					//echo $selectv;
					$rev = mssql_query($selectv);
					$numv=mssql_num_rows($rev);
					if($numv>0){
						$rowv = mssql_fetch_array($rev);
						$vacation_extra =  (int)$rowv['vacation_extra'];
						$total_annual = $total_annual+$vacation_extra;
					}
	
	echo $total_annual;
	?></td>
    <td   align="center"><?
    if($row['total']!=''){
		echo $row['total'];
		}else{
			echo 0;
			}
	?></td>
    <td  align="center"><?
	echo $total_annual-$row['total'];
	?></td>
    
    <?
    	$sql_leavetype = "select * from  tbleavetype where leavetypeid='L0004'";
		$re_leavetype=mssql_query($sql_leavetype);
		$row_leavetype = mssql_fetch_array($re_leavetype);
		$select="select SUM(leavetotal) as total from tbleave_transaction where leavetypeid = '".$row_leavetype['leavetypeid']."' AND empno = '".$row_control['emp_under']."' AND (statusapprove = 'Approve' OR statusapprove = 'New') AND ".$txtsearch;
		$re=mssql_query($select);
		
		$row=mssql_fetch_array($re);
	?>
    <td   align="center"><?=$row_leavetype['leaveday']?></td>
    <td   align="center"><?
    if($row['total']!=''){
		echo $row['total'];
		}else{
			echo 0;
			}
	?></td>
    <td  align="center"><?
	echo $row_leavetype['leaveday']-$row['total'];
	?></td>
    
    <?
    	$sql_leavetype = "select * from  tbleavetype where leavetypeid='L0005'";
		$re_leavetype=mssql_query($sql_leavetype);
		$row_leavetype = mssql_fetch_array($re_leavetype);
		$select="select SUM(leavetotal) as total from tbleave_transaction where leavetypeid = '".$row_leavetype['leavetypeid']."' AND empno = '".$row_control['emp_under']."' AND (statusapprove = 'Approve' OR statusapprove = 'New') AND ".$txtsearch;
		$re=mssql_query($select);
		
		$row=mssql_fetch_array($re);
	?>
    <td   align="center"><?=$row_leavetype['leaveday']?></td>
    <td   align="center"><?
    if($row['total']!=''){
		echo $row['total'];
		}else{
			echo 0;
			}
	?></td>
    <td  align="center"><?
	echo $row_leavetype['leaveday']-$row['total'];
	?></td>
    
    <?
    	$sql_leavetype = "select * from  tbleavetype where leavetypeid='L0006'";
		$re_leavetype=mssql_query($sql_leavetype);
		$row_leavetype = mssql_fetch_array($re_leavetype);
		$select="select SUM(leavetotal) as total from tbleave_transaction where leavetypeid = '".$row_leavetype['leavetypeid']."' AND empno = '".$row_control['emp_under']."' AND (statusapprove = 'Approve' OR statusapprove = 'New') AND ".$txtsearch;
		$re=mssql_query($select);
		$numL0006 = mssql_num_rows($re);
		$row=mssql_fetch_array($re);
	?>
   
    <td   align="center"><?
    if($row['total']!=''){
		echo $row['total'];
		}else{
			echo 0;
			}
	?></td>
    <?
    	$sql_leavetype = "select * from  tbleavetype where leavetypeid='L0011'";
		$re_leavetype=mssql_query($sql_leavetype);
		$row_leavetype = mssql_fetch_array($re_leavetype);
		$select="select SUM(leavetotal) as total from tbleave_transaction where leavetypeid = '".$row_leavetype['leavetypeid']."' AND empno = '".$row_control['emp_under']."' AND (statusapprove = 'Approve' OR statusapprove = 'New') AND ".$txtsearch;
		$re=mssql_query($select);
		$numL0006 = mssql_num_rows($re);
		$row=mssql_fetch_array($re);
	?>
   
    <td   align="center"><?
    if($row['total']!=''){
		echo $row['total'];
		}else{
			echo 0;
			}
	?></td>
   
</tr>
            
            
			<?
		
							
						}
						
						?></table><?
					  }
					}
		
		
		
	
}
if($status == "L"){
	$result = array();
	$select="select emp.empno as empno,emp.firstname as firstname, emp.lastname as lastname, emp.nickname as nickname  from tbemployee emp JOIN tbleave_control ctl ON emp.empno = ctl.emp_under where ctl.emp_control = '$empno' ";
	$re=mssql_query($select);
	while($row = mssql_fetch_assoc($re)){
		$row_array['empno']   = $row['empno'];
		$row_array['name']   = iconv("tis-620", "utf-8",$row['firstname'])." ".iconv("tis-620", "utf-8",$row['lastname'])." (".iconv("tis-620", "utf-8",$row['nickname']).")";
		array_push($result, $row_array);
	}
	echo json_encode(array('data'=>$result));
}
if($status == "Q"){
	$id = $_POST["id"];
	$sql = "SELECT *,tbleave_transaction.id as id,tbleave_transaction.reasons_reject as reasons_reject,tbleave_transaction.leaveid as leaveid,tbemployee.empno as empno FROM tbleave_transaction JOIN tbleavetype ON tbleave_transaction.leavetypeid = tbleavetype.leavetypeid JOIN tbemployee ON tbemployee.empno = tbleave_transaction.empno WHERE  tbleave_transaction.id = $id ";
	$re=mssql_query($sql);
	$row = mssql_fetch_assoc($re);
	
	$row_array['id']   = $row['id'];
	$row_array['empno']   = $row['empno'];
	$row_array['leave_name']   = iconv("tis-620", "utf-8",$row['firstname'])." ".iconv("tis-620", "utf-8",$row['lastname']);
	$row_array['leave_type']   = iconv("tis-620", "utf-8",$row['leavetypeid']);
	$row_array['shift']   = $row['shift'];
	$row_array['leave_create']   = f_date($row['createdate']);
	$row_array['leavestartdate']   = f_date($row['leavestartdate']);
	$row_array['leavestarttime']   = $row['leavestarttime'];
	$row_array['leaveenddate']   = f_date($row['leaveenddate']);
	$row_array['leaveendtime']   = $row['leaveendtime'];
	$row_array['reasons']   = iconv("tis-620", "utf-8",$row['reasons']);
	$row_array['reasons_reject']   = iconv("tis-620", "utf-8",$row['reasons_reject']);
	$row_array['att']   = $row['file_att'];
	$row_array['statusapprove']   = $row['statusapprove'];
	$row_array['hr']   = $row['hr'];
	$row_array['empno_leave']   = $row['empno'];
	$row_array['leaveid']   = $row['leaveid'];
	$row_array['leavetypeid'] = $row['leavetypeid'];
	$row_array['start_time'] =date("H:i",strtotime($row['start_time']));
	$row_array['end_time'] = date("H:i",strtotime($row['end_time']));
	echo json_encode(array('data'=>$row_array));
}
if($status == "K"){
	$sql = "SELECT empno FROM  tbemployee";
	$result = array();
	$re=mssql_query($sql);
	while($row = mssql_fetch_assoc($re)){
		array_push($result,  $row['empno']);
	}
	echo json_encode($result);
}
if($status == "M"){
	$sql = "SELECT * FROM  tbemployee";
	$result = array();
	$re=mssql_query($sql);
	while($row = mssql_fetch_assoc($re)){
		$row_array['empno']   = $row['empno'];
		$row_array['name']   = iconv("tis-620", "utf-8",$row['firstname'])." ".iconv("tis-620", "utf-8",$row['lastname'])."(".iconv("tis-620", "utf-8",$row['nickname']).")";
		array_push($result,  $row_array);
	}
	echo json_encode($result);
}
if($status == "J"){
	$name_app = iconv( "utf-8","tis-620",$_POST['name_app']);
	$reasons_reject = iconv( "utf-8","tis-620",$_POST['reasons_reject']);
	$type = $_POST['type'];
	$id = $_POST['id'];
	$select="UPDATE tbleave_transaction SET leaveapprovedate = '$dt', headapprove='$name_app'  ,statusapprove = '$type',reasons_reject='$reasons_reject'  where id = '$id' ";
	mssql_query($select);
	//echo $select;
	
	send_mail_approve($status,$name_app,$type,$id);
}
if($status == "H"){
	$id = $_POST['id'];
	$select="UPDATE tbleave_transaction SET hr = 'Read'  where id = '$id' ";
	
	if($_FILES["model_file_att"]["tmp_name"] != ""){
		@unlink("leave_doc/".$_POST['file_att']);
		$type= strrchr($_FILES["model_file_att"]["name"],".");
		$file_new = $_POST['leaveid']."$type";
		@move_uploaded_file($_FILES["model_file_att"]["tmp_name"],"leave_doc/".$file_new);
		$select="UPDATE tbleave_transaction SET hr = 'Read', file_att = '$file_new'  where id = '$id' ";
	}
	mssql_query($select);
}
if($status == "U"){
	
	$id = $_POST['id'];
	$leaveid = $_POST['leaveid'];
	$empno = $_REQUEST['empno_edit'];
	$empno_edit = $_REQUEST['empno_edit'];
	$empno_name = $_REQUEST['empno_name'];
	//$empno_name = iconv("tis-620", "utf-8", $empno_name );
	$file_att = $_POST['file_att'];
	$total_leave = $_POST['total_leave'];
	$model_sl_s_leave = $_POST['model_sl_s_leave'];
	$model_sl_e_leave = $_POST['model_sl_e_leave'];
	$model_type_leave = $_POST['model_type_leave'];
	$model_shift = $_POST['model_shift'];
	$s_leave = explode('/',$_POST['model_s_leave']);
	$s_leave = date("Y-m-d", strtotime($s_leave[1]."/".$s_leave[0]."/".$s_leave[2]));
	$e_leave = explode('/',$_POST['model_e_leave']);
	$e_leave = date("Y-m-d", strtotime($e_leave[1]."/".$e_leave[0]."/".$e_leave[2]));
	$reasons = iconv( "utf-8","tis-620",$_POST['model_reasons']);
	$start_time = $_POST['start_time'];
	$end_time = $_POST['end_time'];
	//$reasons = iconv( "utf-8","tis-620",$_POST['reasons']);

	if($model_type_leave=="L0009"){
		$total_leave=DateDiff($s_leave,$e_leave);
		$total_leave=$total_leave+1;
		//echo $start_time;
		//$sql = "INSERT INTO tbleave_transaction (empno, leaveid, leavetypeid, createdate, leavestartdate, leaveenddate, statusapprove, shift, leavetotal, reasons, file_att,hr,start_time,end_time) VALUES ('$empno','$leaveid','$type_leave', '".date('Y-m-d')."', '$s_leave', '$e_leave', 'New', '$shift', '$total_leave', '$reasons', '$file_new', 'New','$start_time','$end_time')";
		$sql = "UPDATE tbleave_transaction SET leavetypeid = '$model_type_leave', leavestartdate = '$s_leave',start_time = '$start_time', leaveenddate = '$e_leave',end_time = '$end_time', shift = '$model_shift', leavetotal = '$total_leave', reasons = '$reasons' WHERE id = '$id'";
		//echo $sql;
		$re=mssql_query($sql);
		
	}else{
		$sql = "UPDATE tbleave_transaction SET leavetypeid = '$model_type_leave', leavestartdate = '$s_leave',leavestarttime = '$model_sl_s_leave', leaveenddate = '$e_leave',leaveendtime = '$model_sl_e_leave', shift = '$model_shift', leavetotal = '$total_leave', reasons = '$reasons' WHERE id = '$id'";
		
		$re=mssql_query($sql);
	}


	if($_FILES["model_file_att"]["tmp_name"] != ""){
		@unlink("leave_doc/".$_POST['file_att']);
		$type= strrchr($_FILES["model_file_att"]["name"],".");
		$file_new = $_POST['leaveid']."$type";
		@move_uploaded_file($_FILES["model_file_att"]["tmp_name"],"leave_doc/".$file_new);
		$sql = "UPDATE tbleave_transaction SET file_att = '$file_new' WHERE id = '$id'";
	}


	mssql_query($sql);
	//send_mail($status,$empno,$model_type_leave,$s_leave,$e_leave,$reasons,$empno_edit);
	echo $status."###".$empno."###".$model_type_leave."###".$s_leave."###".$e_leave."###".$_POST['model_reasons']."###".$empno_edit;
	//echo "1";
}
function icon_att($name){
	$res = "-";
	if($name == '0'){
		return $res;
	}else{
		return "<a target='_blank' href='leave_doc/".$name."' ><i class='fa fa-file fa-2x' aria-hidden='true'></i></a>";
	}
	
}
function f_date($f_date){
	return  date("d/m/Y", strtotime($f_date));
}

function send_mail($status,$empno,$type_leave,$s_leave,$e_leave,$reasons,$empno_edit){
	
	
				$select2="select firstname,lastname from  tbemployee where empno = '".$empno_edit."' ";
				$re2=mssql_query($select2);
				$row2=mssql_fetch_array($re2);
				 
				$empno_name = iconv("tis-620", "utf-8", $row2['firstname'] )." ".iconv("tis-620", "utf-8", $row2['lastname'] );
	
	$type = "";
	if($type_leave == "L0001"){
		$type = "ลาป่วย";
	}
	if($type_leave == "L0002"){
		$type = "ลากิจ";
	}
	if($type_leave == "L0003"){
		$type = "ลาพักร้อน";
	}
	if($type_leave == "L0004"){
		$type = "ลาบวช";
	}
	if($type_leave == "L0005"){
		$type = "ลาคลอด";
	}
	if($type_leave == "L0006"){
		$type = "ขาดงาน";
	}
	
	$sql = "SELECT emp_control FROM  tbleave_control WHERE emp_under = $empno";
	$result = array();
	$re=mssql_query($sql);
	while($row = mssql_fetch_assoc($re)){
		array_push($result,  $row['emp_control']);
	}
	$sql = "SELECT email FROM  tbemployee WHERE empno IN (".implode(",",$result).")";
	$result_mail = array();
	$re=mssql_query($sql);
	while($row = mssql_fetch_assoc($re)){
		array_push($result_mail,  $row['email']);
	}
	$s_leave = explode('-',$s_leave);
	$e_leave = explode('-',$e_leave);
	$html = "Leave Online System Information : <BR><BR>";		
	if($status == 'U'){
		
				
				//$empno_name = $row2['firstname'];
				//$empno_name2 = iconv("tis-620", "utf-8", $row2['firstname'] );
				//$empno_name3 = iconv("utf-8", "tis-620", $row2['firstname'] );
		
		$html .= "<u><b>แก้ไขการลา</b></u> คุณ ".$empno_name." ได้ทำการลาเนื่องจาก : ".$reasons." (".$type.")  ช่วงวันที่  ".date("d/m/Y", strtotime($s_leave[0]."/".$s_leave[1]."/".$s_leave[2]))." ถึง ".date("d/m/Y", strtotime($e_leave[0]."/".$e_leave[1]."/".$e_leave[2]))." <br/><br/>สามารถเข้าตรวจสอบได้ที่ : http://www.ipack-iwis.com/hrs/login.php?ref=1";
		$txtsubject = "Leave Online : คุณ ".$empno_name." ได้ทำการแก้ไขใบลา";
	}else{
		$html .= "คุณ ".$empno_name." ได้ทำการลาเนื่องจาก : ".$reasons." (".$type.")  ช่วงวันที่  ".date("d/m/Y", strtotime($s_leave[0]."/".$s_leave[1]."/".$s_leave[2]))." ถึง ".date("d/m/Y", strtotime($e_leave[0]."/".$e_leave[1]."/".$e_leave[2]))." <br/><br/>สามารถเข้าตรวจสอบได้ที่ : http://www.ipack-iwis.com/hrs/login.php?ref=1";
		$txtsubject = "Leave Online : คุณ ".$empno_name." ได้ทำการลา ".$type;
	}
		require 'PHPMailer/PHPMailerAutoload.php';

		$mail = new PHPMailer(); // create a new object
		$mail->IsSMTP(); // enable SMTP
		//$mail->SMTPDebug = 2; // debugging: 1 = errors and messages, 2 = messages only
		$mail->SMTPAuth = true; // authentication enabled
		$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
		$mail->Host = "smtp.gmail.com";
		$mail->CharSet = "utf-8";
		$mail->Port = 465; // or 587
		$mail->IsHTML(true);
		$mail->Username = "ipackiwis@gmail.com";
		$mail->Password = "ipack@@@@2017";
		$mail->SetFrom("ipackiwis@gmail.com");
		$mail->Subject = $txtsubject;
		
		$mail->Body = $html;

		$mail->IsHTML(true); 
		foreach($result_mail as $result_mail)
		{
		   $mail->AddAddress($result_mail);
		}
		
		$mail->AddCC("thanatwat.m@ipacklogistics.com");
		$mail->Send();
		
		
	}
function send_mail_approve($status,$name_app,$type,$id){
	
	
				$select="select * from  tbleave_transaction where id = $id ";
				$re=mssql_query($select);
				$num=mssql_num_rows($re);
				if($num>0){
				$row=mssql_fetch_array($re);
					
				$select2="select firstname,lastname from  tbemployee where empno = '".$row['empno']."' ";
				$re2=mssql_query($select2);
				$row2=mssql_fetch_array($re2);
				$name_app = iconv("tis-620", "utf-8", $name_app );
				$empname = iconv("tis-620", "utf-8", $row2['firstname'] )." ".iconv("tis-620", "utf-8", $row2['lastname'] );
					
		$html = "Leave Online System Information : <BR><BR>";		
		$html .= "คุณ ".$name_app." ได้ทำการ : ".$type." การลาหมายเลข : ";
		$html .= $row['leaveid'];
		$html .= " ของคุณ ".$empname." แล้ว";
		$html .= "<br/><br/>สามารถเข้าตรวจสอบได้ที่ : http://www.ipack-iwis.com/hrs/login.php?ref=1";
		require 'PHPMailer/PHPMailerAutoload.php';

		$mail = new PHPMailer(); // create a new object
		$mail->IsSMTP(); // enable SMTP
		//$mail->SMTPDebug = 2; // debugging: 1 = errors and messages, 2 = messages only
		$mail->SMTPAuth = true; // authentication enabled
		$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
		$mail->Host = "smtp.gmail.com";
		$mail->CharSet = "utf-8";
		$mail->Port = 465; // or 587
		$mail->IsHTML(true);
		$mail->Username = "ipackiwis@gmail.com";
		$mail->Password = "ipack@@@@2017";
		$mail->SetFrom("ipackiwis@gmail.com");
		$mail->Subject = "Leave Online : "."คุณ ".$name_app." ได้ทำการ : ".$type." การลาหมายเลข : ".$row['leaveid'];
		
		$mail->Body = $html;

		$mail->IsHTML(true); 
		$mail->AddAddress("natwarin.t@ipacklogistics.com");
		//$mail->AddAddress("natwarin.t@ipacklogistics.com");
		$mail->AddCC("thanatwat.m@ipacklogistics.com");
		$mail->Send();
					
					
					}
	
		
		
		
	}
	
	
	if($status=='uploadfile_leave'){
		//$file = $_REQUEST['file'];
		//echo "a";
		
		if($_FILES["file"]["tmp_name"] != ""){
		//@unlink("leave_doc/".$_POST['file']);
		$type= strrchr($_FILES["file"]["name"],".");
		$file_new = $_POST['leaveid']."$type";
		$leaveid = $_REQUEST['leaveid'];
		@move_uploaded_file($_FILES["file"]["tmp_name"],"leave_doc/".$file_new);
		$sql = "UPDATE tbleave_transaction SET file_att = '$file_new'  WHERE leaveid = '$leaveid'";
		//echo $sql;
		mssql_query($sql);
	}
	
		}
	
	function calc_anual_day($empno){
		$select="select emp.firstname as firstname, emp.lastname as lastname, emp.emp_level as emp_level ,emp.startdate as startdate,pos.positionname as positionname  from tbemployee emp JOIN tbposition pos ON emp.positionid = pos.positionid where emp.empno = '$empno' ";
	$re=mssql_query($select);
	$row=mssql_fetch_array($re);
	$name = iconv("tis-620", "utf-8", $row['firstname'])."  ".iconv("tis-620", "utf-8", $row['lastname']);
	$position = $row['positionname'];	
	$startdate = $row['startdate'];	
	$emp_level = $row['emp_level'];	
	$count = (strtotime(date("Y-m-d")) - strtotime($startdate))/( 60 * 60 * 24 );
	$total_annual = 0; //พักร้อน
	$total_ordain = 0; //ลาบวช
	if($count >= 365){
		$total_ordain = 15;
	}
	if($count >= 365 && $count < 730){
		$total_annual = 6.00;
	}else if($count >= 730 && $count < 1095){
		$total_annual = 7.00;
	}else if($count >= 1095 && $count < 1460){
		$total_annual = 8.00;
	}else if($count >= 1460 && $count < 1825){
		$total_annual = 9.00;
	}else if($count >= 1825){
		$total_annual = 10.00;
	}
	return $total_annual;
	
		}
if($status=="type_leave_change"){
	$type_leave = $_REQUEST['type_leave'];
	?>
	<?php
	if($type_leave=='L0009'){
	?>	
			
		<input type="time" id="start_time" name="start_time"  class="form-control" required>
		<? echo "###"?>
		
		<input type="time" id="end_time" name="end_time"  class="form-control" required>
	<?php
	}else{
	?>
		<select id="sl_s_leave"  class="form-control">
			<option value="0">เต็มวัน</option>
			<option value="0.5">ครึงวัน</option>
		</select>
		<? echo "###"?>
		<select id="sl_e_leave"  class="form-control">
			<option value="0">เต็มวัน</option>
			<option value="0.5">ครึงวัน</option>
		</select>
	<?php
	}
}
?>
