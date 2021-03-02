<?
include("connect.php");
$dt = date("Y-m-d");
$status = $_REQUEST['status'];
$empno = $_REQUEST['empno'];

if($status=='send_mail'){
	
	$empno = $_REQUEST['empno'];
	$type_leave = $_REQUEST['type_leave'];
	$s_leave = $_REQUEST['s_leave'];
	$e_leave = $_REQUEST['e_leave'];
	$reasons = $_REQUEST['reasons'];
	$empno_edit = $_REQUEST['empno_edit'];
	$mailtype = $_REQUEST['mailtype'];
	
	
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
	if($mailtype == 'U'){
		
				
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
?>