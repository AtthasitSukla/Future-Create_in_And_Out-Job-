<?
	session_start();
	$host="BACKUP_PC";
	$username="sa";
	$password="eaotft139@%";
	
	//$host='DESKTOP-MAO6R9N';
//	$username="sa";
	//$password="1234";
	
	$db="dinvb";
	$sql=mssql_connect($host,$username,$password) or die("Cannot connect");
	mssql_select_db($db);

if($_SESSION['admin_userid']==''){
	
		$_SESSION['admin_userid'] =  $_COOKIE["admin_userid"];
		$_SESSION['admin_pos'] = $_COOKIE["admin_pos"];
		$_SESSION['admin_email'] = $_COOKIE["admin_email"];
		
	
		}
		
//echo $_SESSION['admin_userid'];

?>