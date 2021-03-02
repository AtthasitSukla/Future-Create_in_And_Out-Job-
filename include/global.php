<?php
	/*ini_set("display_errors", 0);
	error_reporting(0);*/

	$base_path		= "http://localhost:8080/hrs/";
	$db_name		= "dhrdb";
	$db_user		= "sa";
	$db_pass		= "1234";
	$db_host		= "PG_NB";
	$time_limit_reg = "15";
	$time_limit_ver = "10";

	$conn = mssql_connect($db_host, $db_user, $db_pass);
	if (!$conn) die("Connection for user $db_user refused!");
	mssql_select_db($db_name, $conn) or die("Can not connect to database!");
?>