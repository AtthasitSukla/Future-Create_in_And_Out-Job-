<?
	session_start();
	$host="LAPTOP-93B2STQO\SQLEXPRESS";
	$username="sa";
	$password="1234";
	$db="dhrdb";
	$base_path	= "http://ipack-iwis.com/HRS/";
	$time_limit_reg = "15";
	$time_limit_ver = "10";
	$sql=mssql_connect($host,$username,$password) or die("Cannot connect");
	mssql_select_db($db);

	// $host="BACKUP_PC";
	// $username="sa";
	// $password="eaotft139@%";
	// $db="dhrdb";
	// $base_path	= "http://ipack-iwis.com/HRS/";
	// $time_limit_reg = "15";
	// $time_limit_ver = "10";
	// $sql=mssql_connect($host,$username,$password) or die("Cannot connect");
	// mssql_select_db($db);


	


if($_SESSION['admin_userid']==''){
	
		$_SESSION['admin_userid'] =  $_COOKIE["admin_userid"];
		$_SESSION['site'] = $_COOKIE["site"];
		$_SESSION['permission'] = $_COOKIE["permission"];
		$_SESSION['emp_level'] = $_COOKIE["emp_level"];
		$_SESSION['departmentid'] = $_COOKIE["departmentid"];
		
	
		}

//// SSO
if($_COOKIE["main_userid"]!=''){
	
		$sql_cookie="select * from tbemployee where empno='".$_COOKIE["main_userid"]."' and sso ='yes'";
		$result_cookie=mssql_query($sql_cookie);
		$row_cookie=mssql_fetch_array($result_cookie);
		setcookie('admin_userid', $row_cookie['empno'],time()+3600*24*356);//เซ็ตคุกกี้ 1ปี
		$_SESSION['admin_userid'] = $row_cookie['empno'];
		setcookie('site', $row_cookie['site'],time()+3600*24*356);//เซ็ตคุกกี้ 1ปี
		$_SESSION['site'] = $row_cookie['site'];
		setcookie('permission', $row_cookie['permission'],time()+3600*24*356);//เซ็ตคุกกี้ 1ปี
		$_SESSION['permission'] = $row_cookie['permission'];
		setcookie('emp_level', $row_cookie['emp_level'],time()+3600*24*356);//เซ็ตคุกกี้ 1ปี
		$_SESSION['emp_level'] = $row_cookie['emp_level'];
		setcookie('departmentid', $row_cookie['departmentid'],time()+3600*24*356);//เซ็ตคุกกี้ 1ปี
		$_SESSION['departmentid'] = $row_cookie['departmentid'];
		
	}
//// SSO

?>