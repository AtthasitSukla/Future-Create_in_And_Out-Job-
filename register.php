<?php
	
if (isset($_GET['empno']) && !empty($_GET['empno'])) {
	
	include 'connect.php';
	include 'include/function.php';

	$empno 	= $_GET['empno'];
	//array 0		1	   2					3	
	//echo "1;SecurityKey;15;http://localhost:8080/demo_figerprint/process_register.php;http://localhost:8080/demo_figerprint/getac.php";
	echo "$empno;SecurityKey;".$time_limit_reg.";".$base_path."process_register.php;".$base_path."getac.php";
	
}

?>