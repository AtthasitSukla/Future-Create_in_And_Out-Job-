<?php

if (isset($_POST['RegTemp']) && !empty($_POST['RegTemp'])) {
		
    	include 'connect.php';
    	include 'include/function.php';
		$test = $_POST['RegTemp'];
		$data 		= explode(";",$_POST['RegTemp']);
		$vStamp 	= $data[0];
		$sn 		= $data[1];
		$empno	= $data[2];
		$regTemp 	= $data[3];
		//echo $data[0];
		$device = getDeviceBySn($sn);
		
		$salt = md5($device[0]['ac'].$device[0]['vkey'].$regTemp.$sn.$empno);
		
		if (strtoupper($vStamp) == strtoupper($salt)) {
			
			
			/*$sq2 		= "INSERT INTO demo_finger (user_id,finger_id,finger_data)
										values ('".$user_id."',".($fid+1).",'".$regTemp."' )";*/
			$sq2 = "update tbemployee set finger_data='$regTemp' where empno='$empno'";
			$result2	= mssql_query($sq2);
			if ($result1 && $result2) {
				$res['result'] = true;				
			} else {
				$res['server'] = "Error insert registration data!";
			}
			
			
			echo "empty";
			
		} else {
			
			$msg = "Parameter invalid..";
			
			echo $base_path."messages.php?msg=$msg";
			
		}

		
}

?>