<?php
session_start();
include("connect.php");
include("library.php"); 

$time = date("H:i:s");
$date_time = date("m/d/Y H:i:s");
$empno = $_REQUEST['empno'];
if($empno==''){
	$empno = $_SESSION['admin_userid'];
}
//$create_date_only = date_format_uk_into_database($_REQUEST['create_date']);
$arr_date = explode("/",$_REQUEST['create_date']);
$create_date_only = $arr_date[1]."/".$arr_date[0]."/".$arr_date[2];
$create_date = $create_date_only." ".$time;
//echo $create_date;
//echo $_REQUEST['problem_topic'];
//$problem_topic = str_replace("'", "", $_REQUEST['problem_topic']);
//$problem_topic = str_replace(array("'", "\""), "", htmlspecialchars($_POST['problem_topic']));
$problem_topic =addslashes($_POST['problem_topic']);
//$problem_topic = htmlentities(str_replace(array('"', "'"), '', $_POST['problem_topic']));
$problem_topic = lang_thai_into_database($problem_topic);
$problem_type  =$_REQUEST['problem_type'];

if($problem_topic!=""){
	//$problem_topic = preg_replace("/'/", "\&#39;", $problem_topic);
	$problem_detail = lang_thai_into_database($_REQUEST['problem_detail']);
	$problem_detail = str_replace("\n", "<br />", $problem_detail); 

	$job_status = "New";
	$job_id_check = "IT02".$arr_date[2].$arr_date[1];
	$sql_check = "select top 1 job_id from tbitservice_list where job_id like '$job_id_check%' order by job_id desc";
	$res = mssql_query($sql_check);
	$num = mssql_num_rows($res);
	if($num==0){
		$new_id = "IT02".$arr_date[2].$arr_date[1]."001";
	}else{
		//IT201803001
		$row = mssql_fetch_array($res);
		$tmp_newid = $row['job_id'];
		$tmp_newid = substr($tmp_newid,-4);
		$qid = (int)$tmp_newid + 1;
		$tmpid = "0000".$qid;
		$qdno = substr($tmpid,-3);
		$new_id = "IT02".$arr_date[2].$arr_date[1].$qdno;
	}

		$sqle = "select emp_level from tbemployee where empno='$empno'";
		$rese = mssql_query($sqle);
		$rowe=mssql_fetch_array($rese);
		$emp_level = $rowe['emp_level'];
		
	if($emp_level>=4){
		$insert = "insert into tbitservice_list (job_id,empno,job_status,problem_type,problem_topic,problem_detail,create_date,date_time,approve_status,approve_empno)
	values ('$new_id','$empno','$job_status','$problem_type','$problem_topic','$problem_detail','$create_date','$date_time','approved','$empno')";
		//echo $insert;
	mssql_query($insert);

		}else{
		$insert = "insert into tbitservice_list (job_id,empno,job_status,problem_type,problem_topic,problem_detail,create_date,date_time)
	values ('$new_id','$empno','$job_status','$problem_type','$problem_topic','$problem_detail','$create_date','$date_time')";
	mssql_query($insert);

		}


	$target_dir = "service_pic/";
	/*$file_name = basename($_FILES["problem_file"]["name"]);
	$imageFileType = strtolower(pathinfo($file_name,PATHINFO_EXTENSION));
	$target_file = $target_dir.$new_id.".".$imageFileType;
	*/

	if(isset($_FILES["problem_file"])){
		$count = 1;
		foreach($_FILES['problem_file']['tmp_name'] as $key => $val){
			$file_name = basename($_FILES['problem_file']['name'][$key]);
			$imageFileType = strtolower(pathinfo($file_name,PATHINFO_EXTENSION));
			$target_file = $target_dir.$new_id."_".$count.".".$imageFileType;
			$file_name_upload = $new_id."_".$count.".".$imageFileType;

			$file_size =$_FILES['problem_file']['size'][$key];
			$file_tmp =$_FILES['problem_file']['tmp_name'][$key];
			$file_type=$_FILES['problem_file']['type'][$key];  
			
			if(move_uploaded_file($file_tmp,$target_file)){
			$insert_file = "insert into tbitservice_file (job_id,file_name)
										values ('$new_id','$file_name_upload')";
			mssql_query($insert_file);
			}
			$count++;
		}
	}
	echo "Save Success  | ";
	/*if (move_uploaded_file($_FILES["problem_file"]["tmp_name"], $target_file)) {
		echo "Save Success";
		//insert
	
		$insert = "insert into tbitservice_list (job_id,empno,job_status,problem_type,problem_topic,problem_detail,create_date,date_time)
				values ('$new_id','$empno','$job_status','$problem_type','$problem_topic','$problem_detail','$create_date','$date_time')";
	
	
	}else{
		echo "Save Success";
	
	}*/




	//SEND MESSAGE TO LINE NOTIFY
	$lineapi = "p7CGhSlDh7dM0SfIqCn7rIcFXr0biMm9WnTGv8orPea";
	$mms =  "\nYou have new IT Service Request \n";
	$mms .=  "Job No : ".$new_id."\n";
	$mms .=  "Problem : ".lang_thai_from_database($problem_topic)."\n";
	$mms .=  "Request By : ".get_full_name($empno)."\n";
	//line Send

	$chOne = curl_init(); 
	curl_setopt( $chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify"); 
	// SSL USE 
	curl_setopt( $chOne, CURLOPT_SSL_VERIFYHOST, 0); 
	curl_setopt( $chOne, CURLOPT_SSL_VERIFYPEER, 0); 
	//POST 
	curl_setopt( $chOne, CURLOPT_POST, 1); 
	// Message 
	curl_setopt( $chOne, CURLOPT_POSTFIELDS, "message=$mms"); 
	//ถ้าต้องการใส่รุป ให้ใส่ 2 parameter imageThumbnail และimageFullsize
	//curl_setopt( $chOne, CURLOPT_POSTFIELDS, "message=$mms&imageThumbnail=http://plusquotes.com/images/quotes-img/surprise-happy-birthday-gifts-5.jpg&imageFullsize=http://plusquotes.com/images/quotes-img/surprise-happy-birthday-gifts-5.jpg&stickerPackageId=1&stickerId=100"); 
	// follow redirects 
	curl_setopt( $chOne, CURLOPT_FOLLOWLOCATION, 1); 
	//ADD header array 
	$headers = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.$lineapi.'', ); 
	curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers); 
	//RETURN 
	curl_setopt( $chOne, CURLOPT_RETURNTRANSFER, 1); 
	$result = curl_exec( $chOne ); 
	//Check error 
	if(curl_error($chOne)) { echo 'error:' . curl_error($chOne); } 
	else { 
	$result_ = json_decode($result, true); 
	//echo "status : ".$result_['status']; echo "message : ". $result_['message']; 
	} 
	//Close connect 
	curl_close( $chOne );   
			
												$aemail = array();
												$select_emp = "select departmentid from tbemployee where empno='$empno'";
												$re_emp = mssql_query($select_emp);
												$num_emp = mssql_num_rows($re_emp);
												if($num_emp>0){
												$row_emp = mssql_fetch_array($re_emp);
													$html =  "You have new IT Service Request <BR>";
													$html .=  "Job No : ".$new_id."<BR>";
													$html .=  "Problem : ".lang_thai_from_database($problem_topic)."<BR>";
													$html .=  "Request By : ".get_full_name($empno)."<BR><BR><BR>";
													$departmentid = $row_emp['departmentid'];
													
													//get management email
													$selectm = "select emp_control from tbleave_control where emp_under='$empno'";
													$rem = mssql_query($selectm);
													$numm = mssql_num_rows($rem);
													if($numm>0){
														while($rowm = mssql_fetch_array($rem)){
																	$selectm2 = "select email from tbemployee where empno='".$rowm['emp_control']."' and delstatus='0' and departmentid='$departmentid'";
																	$rem2 = mssql_query($selectm2);
																	$numm2 = mssql_num_rows($rem2);
																	if($numm2>0){
																		$rowm2 = mssql_fetch_array($rem2);
																		array_push($aemail,$rowm2['email']);
																		
																	}
															
															}	
														}
													}
		

	/// send mail
	require 'PHPMailer/PHPMailerAutoload.php';
				$mail = new PHPMailer(); // create a new object
	$mail->IsSMTP(); // enable SMTP
	$mail->CharSet = "utf-8";
	//$mail->SMTPDebug = 2; // debugging: 1 = errors and messages, 2 = messages only
	$mail->SMTPAuth = true; // authentication enabled
	$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
	$mail->Host = "smtp.gmail.com";
	$mail->Port = 465; // or 587
	$mail->IsHTML(true);
	$mail->Username = "ipackiwis@gmail.com";
	$mail->Password = "ipack@@@@2017";
	$mail->SetFrom("ipackiwis@gmail.com");
	$mail->Subject = "[IPACK I-Wis system notification] You have new IT Service Request (".$new_id.") ";
	$html0 = "<br><br>";
	$html2 ="***Please do not reply to this message. Replies to this message are routed to an unmonitored mailbox, If you have questions please call IPACK IT Team.";
	$mail->Body = $html.$html2;

	$mail->IsHTML(true); 
	//$mail->AddAddress("sitthiphan.pimki@autoliv.com");

	for($i=0;$i<sizeof($aemail);$i++){
		$mail->AddAddress($aemail[$i]);
		}
	$mail->AddCC("thanatwat.m@ipacklogistics.com");
	//$mail->AddCC("panyadanai.k@ipacklogistics.com");
	//$mail->AddCC("suriya.s@ipacklogistics.com");

	//$mail->AddCC("thanaphon.s@ipacklogistics.com");
	//$mail->AddCC("verapong.s@ipacklogistics.com");
	//$mail->AddCC("nakarin.j@ipacklogistics.com");

	if(!$mail->Send()) {
		echo "Mailer Error: " . $mail->ErrorInfo;
	} else {
		echo "Message has been sent";
	}
				
				///send email

}


?>
<meta http-equiv='refresh' CONTENT='1;URL=it_service_list.php'>
