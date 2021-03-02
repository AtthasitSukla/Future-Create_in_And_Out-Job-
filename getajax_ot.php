<?php
include("connect.php");
$status = $_REQUEST['status'];
$paycode = $_REQUEST['paycode'];
$empno = $_REQUEST['empno'];
$site = $_REQUEST['site'];
if($status == "R"){
	$select="select paycode,startdate,enddate from  tbpaycode where paycode = '$paycode' ";
	$re=mssql_query($select);
	$num=mssql_num_rows($re);
	$row=mssql_fetch_array($re);
	$startdate = $row['startdate'];
	$enddate = $row['enddate'];	
	
	$sql = "SELECT *,convert(varchar, workdate, 103)as  workdate_new FROM  tbot_mng WHERE paycode = '$paycode' AND empno = '$empno' order by workdate asc ";
	$re=mssql_query($sql);
	$num=mssql_num_rows($re);
	$data = array();
	$conut = 0;
	if($num > 0){
		$type = 'update';
		while($row=mssql_fetch_array($re)){
			
				
					$select_ln = "select leavename from tbleavetype where   leavetypeid in (select leavetypeid from tbleave_transaction
 where  '".$row['workdate']."' between CAST(leavestartdate AS DATE) and CAST(leaveenddate AS DATE) and empno='$empno' AND statusapprove='Approve')  ";
					$re_ln=mssql_query($select_ln);
					$num_ln=mssql_num_rows($re_ln);
					if($num_ln > 0){
						$row_ln=mssql_fetch_array($re_ln);
						$leavename = iconv("tis-620", "utf-8", $row_ln['leavename'] );
					//	$leavename = $row_ln['leavename'];
						}else{
							$leavename = "";
							}
					
			
			$data[] = array(
							"workdate" => $row['workdate'],
							"dayname_en" => $row['dayname_en'],
							"workdate_new" => $row['workdate_new'],
							"shift" => $row['shift'],
							"ot" => $row['ot'],
							"fl" => $row['fl'],
							"remark" => iconv("tis-620", "utf-8", $row['remark']),
							
							
							
					);
			$conut++;
		}
	}else{
		$select="SELECT *,convert(varchar, workdate, 103)as  workdate_new FROM    tbot_parameter where workdate between '".$startdate."' and '".$enddate."' and site='$site'  order by workdate asc ";	
		$re=mssql_query($select);
		$num = mssql_num_rows($re);
		if($num>0){
			$type = 'add';
			while($row=mssql_fetch_array($re)){
				
						$select_ln = "select leavename from tbleavetype where   leavetypeid in (select leavetypeid from tbleave_transaction
 where  '".$row['workdate']."' between CAST(leavestartdate AS DATE) and CAST(leaveenddate AS DATE) and empno='$empno' AND statusapprove='Approve')  ";
					$re_ln=mssql_query($select_ln);
					$num_ln=mssql_num_rows($re_ln);
					if($num_ln > 0){
						$row_ln=mssql_fetch_array($re_ln);
						$leavename = iconv("tis-620", "utf-8", $row_ln['leavename'] );
					//	$leavename = $row_ln['leavename'];
						}else{
							$leavename = "";
							}
				
				
				$data[] = array(
							"workdate" => $row['workdate'],
							"dayname_en" => $row['dayname_en'],
							"workdate_new" => $row['workdate_new'],
							"remark" => $leavename,
						);
				$conut++;
			}
		}
	}
	echo json_encode(array('type'=>$type,'data' => $data,"conut"=>$conut));
}

if($status == "R_new"){
	$select="select paycode,startdate,enddate from  tbpaycode where paycode = '$paycode' ";
	$re=mssql_query($select);
	$num=mssql_num_rows($re);
	$row=mssql_fetch_array($re);
	$startdate = $row['startdate'];
	$enddate = $row['enddate'];	
	
	$sql = "SELECT *,convert(varchar, workdate, 103)as  workdate_new FROM  tbot_mng WHERE paycode = '$paycode' AND empno = '$empno' order by workdate asc ";
	$re=mssql_query($sql);
	$num=mssql_num_rows($re);
	$data = array();
	$conut = 0;
	if($num > 0){
		$type = 'update';
		while($row=mssql_fetch_array($re)){
			
				
			$select_ln = "select leavename from tbleavetype where   leavetypeid in (select leavetypeid from tbleave_transaction
where  CAST(leavestartdate AS DATE)='".$row['workdate']."' and empno='$empno' ) ";
			$re_ln=mssql_query($select_ln);
			$num_ln=mssql_num_rows($re_ln);
			if($num_ln > 0){
				$row_ln=mssql_fetch_array($re_ln);
				$leavename = iconv("tis-620", "utf-8", $row_ln['leavename'] );
			//	$leavename = $row_ln['leavename'];
			}else{
				$leavename = "";
			}
			$workdate = $row['workdate'];		
			$sql_att_in = "select *,convert(varchar, attDateTime, 103)as attDateTimedate,
convert(varchar, attDateTime, 108)as attDateTimetime from tbatt where empno='$empno' and att_real_date='$workdate' and att_status='in'";
			$res_att_in = mssql_query($sql_att_in);
			$num_in = mssql_num_rows($res_att_in);
			$row_time_in = mssql_fetch_array($res_att_in);
			//$id = $row_time_in['id'];
			$attDateTimedate_in = $row_time_in['attDateTimedate'];
			$attDateTimetime_in = $row_time_in['attDateTimetime'];
			$shift_att = $row_time_in['shift']=="" ? "" :$row_time_in['shift'];
			
			
			
			
			$sql_att_out = "select *,convert(varchar, attDateTime, 103)as attDateTimedate,
convert(varchar, attDateTime, 108)as attDateTimetime from tbatt where empno='$empno' and att_real_date='$workdate'  and att_status='out' order by id";
			$res_att_out = mssql_query($sql_att_out);
			$num_out = mssql_num_rows($res_att_out);
			if($num_out >0){
				$row_time_out = mssql_fetch_array($res_att_out);
				$id = $row_time_out['id'];
				$attDateTimedate_out = $row_time_out['attDateTimedate'];
				$attDateTimetime_out = $row_time_out['attDateTimetime'];
				//$shift_att = $row_time_out['shift'];
			}else{
				$attDateTimedate_out = "";
				$attDateTimetime_out = "";
			}
			
			
			$data[] = array(
				"workdate" => $row['workdate'],
				"dayname_en" => $row['dayname_en'],
				"workdate_new" => $row['workdate_new'],
				"shift" => $row['shift'],
				"ot" => $row['ot'],
				"fl" => $row['fl'],
				"remark" => iconv("tis-620", "utf-8", $row['remark']),
				"attDateTime_in" => $attDateTimedate_in." ".$attDateTimetime_in,
				"attDateTime_out" => $attDateTimedate_out." ".$attDateTimetime_out,
				"shift_att" => $shift_att,
					
			);
			
			//tbatt
			//$sql_att = "select";
			
			$conut++;
		}
	}else{
		$select="SELECT *,convert(varchar, workdate, 103)as  workdate_new FROM    tbot_parameter where workdate between '".$startdate."' and '".$enddate."' and site='$site'  order by workdate asc ";	
		$re=mssql_query($select);
		$num = mssql_num_rows($re);
		if($num>0){
			$type = 'add';
			while($row=mssql_fetch_array($re)){
				
				$select_ln = "select leavename from tbleavetype where   leavetypeid in (select leavetypeid from tbleave_transaction
 where  CAST(leavestartdate AS DATE)='".$row['workdate']."' and empno='$empno' )  ";
					$re_ln=mssql_query($select_ln);
					$num_ln=mssql_num_rows($re_ln);
					if($num_ln > 0){
						$row_ln=mssql_fetch_array($re_ln);
						$leavename = iconv("tis-620", "utf-8", $row_ln['leavename'] );
					//	$leavename = $row_ln['leavename'];
					}else{
						$leavename = "";
					}
				
				
			$workdate = $row['workdate'];		
			$sql_att_in = "select *,convert(varchar, attDateTime, 103)as attDateTimedate,
convert(varchar, attDateTime, 108)as attDateTimetime from tbatt where empno='$empno' and att_real_date='$workdate' and att_status='in'";
			$res_att_in = mssql_query($sql_att_in);
			$num_in = mssql_num_rows($res_att_in);
			$row_time_in = mssql_fetch_array($res_att_in);
			//$id = $row_time_in['id'];
			$attDateTimedate_in = $row_time_in['attDateTimedate'];
			$attDateTimetime_in = $row_time_in['attDateTimetime'];
			$shift_att = $row_time_in['shift']=="" ? "" :$row_time_in['shift'];
			
			
			
			
			$sql_att_out = "select *,convert(varchar, attDateTime, 103)as attDateTimedate,
convert(varchar, attDateTime, 108)as attDateTimetime from tbatt where empno='$empno' and att_real_date='$workdate'  and att_status='out' order by id";
			$res_att_out = mssql_query($sql_att_out);
			$num_out = mssql_num_rows($res_att_out);
			if($num_out >0){
				$row_time_out = mssql_fetch_array($res_att_out);
				$id = $row_time_out['id'];
				$attDateTimedate_out = $row_time_out['attDateTimedate'];
				$attDateTimetime_out = $row_time_out['attDateTimetime'];
				//$shift_att = $row_time_out['shift'];
			}else{
				$attDateTimedate_out = "";
				$attDateTimetime_out = "";
			}
			
				
				$data[] = array(
							"workdate" => $row['workdate'],
							"dayname_en" => $row['dayname_en'],
							"workdate_new" => $row['workdate_new'],
							"remark" => $leavename,
							"attDateTime_in" => $attDateTimedate_in." ".$attDateTimetime_in,
							"attDateTime_out" => $attDateTimedate_out." ".$attDateTimetime_out,
							"shift_att" => $shift_att,
						);
				$conut++;
			}
		}
	}
	echo json_encode(array('type'=>$type,'data' => $data,"conut"=>$conut));
}
if($status == "I"){
	for($i = 0; $i < $_REQUEST['conut'] ;$i++){
		$insert = "insert into tbot_mng( empno, paycode, workdate, dayname_en, shift,  fl, remark)";
		$insert .= "values('".$empno."','".$paycode."','".$_POST['workdate'][$i]."','".$_POST['dayname_en'][$i]."', '".$_POST['shift_time'][$i]."', '".$_POST['fl_status'][$i]."', '".iconv( "utf-8","tis-620",$_POST['remark'][$i])."')";
		mssql_query($insert);
	}
}
if($status == "U"){
	for($i = 0; $i < $_REQUEST['conut'] ;$i++){
		$insert = "update tbot_mng set shift = '".$_POST['shift_time'][$i]."', fl = '".$_POST['fl_status'][$i]."', remark = '".iconv( "utf-8","tis-620",$_POST['remark'][$i])."' where empno = '".$empno."' AND paycode = '".$paycode."' AND workdate = '".$_POST['workdate'][$i]."'";
		mssql_query($insert);
	}
}
	
?>
