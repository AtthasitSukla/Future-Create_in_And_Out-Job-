<?
	session_start();
	$host="BACKUP_PC";
	$username="sa";
	$password="eaotft139@%";
	$db="diwishb";
	$sql=mssql_connect($host,$username,$password) or die("Cannot connect");
	mssql_select_db($db);
	
	if($_SESSION['admin_userid']==''){
		$_SESSION['admin_userid'] = $_COOKIE["admin_userid"];
		$_SESSION['admin_pos'] = $_COOKIE["admin_pos"];
	$_SESSION['admin_email'] = $_COOKIE["admin_email"];
	$_SESSION['area'] = $_COOKIE["area"];
	$_SESSION['admin_department'] = $_COOKIE["admin_department"];
	$_SESSION['admin_production_line'] = $_COOKIE["admin_production_line"];
	$_SESSION['ipaddress'] = $_COOKIE["ipaddress"];
	
		}
	
//echo $_SESSION['admin_production_line'];
?>