<?
	session_start();
	$host="BACKUP_PC";
	$username="sa";
	$password="eaotft139@%";
	$db="dbssodb";
	
	$sql=mssql_connect($host,$username,$password) or die("Cannot connect");
	mssql_select_db($db);



?>