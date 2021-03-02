<?php
session_start();
include("connect.php");
$type = $_POST['type'];
$data = array();
if($type == 'all'){
	if($_SESSION['admin_userid']=='56002'){
		$sql = "SELECT * FROM  tbemployee WHERE emp_level < '".$_SESSION['emp_level']."' AND delstatus != 1 order by emp_level desc ";
		}else if($_SESSION['admin_userid']=='61011'){
			$sql = "SELECT * FROM  tbemployee WHERE emp_level < 6 AND delstatus != 1 order by emp_level desc ";
			}else{
		$sql = "SELECT * FROM  tbemployee WHERE emp_level < '".$_SESSION['emp_level']."' AND delstatus != 1 AND site = '".$_SESSION['site']."'";
		}
	
	//echo $sql;
	$re=mssql_query($sql);
	$num=mssql_num_rows($re);
	while($row=mssql_fetch_array($re)){
		$data[] = array(
			"emp_no" => $row['empno'],
			"emp_name" => iconv("tis-620", "utf-8", $row['firstname']).' '.iconv("tis-620", "utf-8", $row['lastname']).' ('.iconv("tis-620", "utf-8", $row['nickname']).')',
		);
	}
}else if($type == 'emp_under') {
	$sql = "SELECT * FROM  tbleave_control WHERE emp_control = '".$_SESSION['admin_userid']."'";
	$re=mssql_query($sql);
	$num=mssql_num_rows($re);
	while($row=mssql_fetch_array($re)){
		array_push($data,$row['emp_under']);
	}
}else if($type == 'add_under') {
	$sql = "INSERT INTO  tbleave_control (emp_control,emp_under) values ('".$_SESSION['admin_userid']."','".$_POST['emp_no'][0]."')";
	mssql_query($sql);

}else if($type == 'del_under') {
	$sql = "DELETE  tbleave_control WHERE emp_control = '".$_SESSION['admin_userid']."' AND emp_under = '".$_POST['emp_no'][0]."'";
	mssql_query($sql);

}
echo json_encode($data);

?>