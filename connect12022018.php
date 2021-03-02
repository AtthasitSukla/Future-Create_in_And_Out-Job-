<?
	session_start();
	$host="PG_NB";
	$username="sa";
	$password="1234";
	$db="dhrdb";
	$base_path	= "http://localhost:8080/hrs/";
	$time_limit_reg = "15";
	$time_limit_ver = "10";
	$sql=mssql_connect($host,$username,$password) or die("Cannot connect");
	mssql_select_db($db);


	//ini_set('display_errors', 1);
	//error_reporting(0);
   //$serverName = "localhost";
//   $userName = "sa";
//   $userPassword = "eaotft139@%";
//   $dbName = "dbnissandb";
//  
//   $connectionInfo = array("Database"=>$dbName, "UID"=>$userName, "PWD"=>$userPassword, "MultipleActiveResultSets"=>true);
//
//   $conn = sqlsrv_connect( $serverName, $connectionInfo);
//
//	if($conn)
//	{
//		echo "Database Connected.";
//	}
//	else
//	{
//		die( print_r( sqlsrv_errors(), true));
//	}
	
	
//	
//$sql_select="select * from tbadmin where admin_userid='admin' and admin_password='password'";
////echo $sql_select;
//$result=sqlsrv_query($sql_select);
//$num=sqlsrv_num_rows($result);
//$row=sqlsrv_fetch_array($result);
//
//if($num!=0){
//	echo $row['admin_password'];
//	}


?>