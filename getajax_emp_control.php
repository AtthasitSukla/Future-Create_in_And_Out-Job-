<?php
session_start();
include("connect.php");
$status=$_REQUEST["status"];

if($status=="show_header_control"){
	$empno_get = $_REQUEST["empno"];
	$sql = "select * from tbemployee where delstatus != 1 order by site asc,empno asc ";
	$res = mssql_query($sql);
	while($row = mssql_fetch_array($res)){
        $empno = $row["empno"];
        $firstname = iconv("tis-620", "utf-8", $row['firstname']);
        $lastname = iconv("tis-620", "utf-8", $row['lastname']);
        $nickname = iconv("tis-620", "utf-8", $row['nickname']);
        $site = $row["site"];
        $full_name = "[$site] $firstname $lastname($nickname)";
        
        ?>
        <option value="<?=$empno?>"><?=$full_name?></option>
        <?php
	}
	
}

if($status=="add_emp_control"){
        $emp_control = $_REQUEST["emp_control"][0];
        $emp_under = $_REQUEST["emp_under"];
        $sql = "INSERT INTO  tbleave_control (emp_control,emp_under) values ('$emp_control','$emp_under')";
	mssql_query($sql);
        //echo $emp_control;
}
if($status=="del_emp_control"){
        $emp_control = $_REQUEST["emp_control"][0];
        $emp_under = $_REQUEST["emp_under"];
        $sql = "DELETE  tbleave_control WHERE emp_control='$emp_control' and emp_under='$emp_under'";
	mssql_query($sql);

}

if($status=="add_emp_under"){
        $emp_control = $_REQUEST["emp_control"];
        $emp_under = $_REQUEST["emp_under"][0];
        $sql = "INSERT INTO  tbleave_control (emp_control,emp_under) values ('$emp_control','$emp_under')";
	mssql_query($sql);
}
if($status=="del_emp_under"){
        $emp_control = $_REQUEST["emp_control"];
        $emp_under = $_REQUEST["emp_under"][0];
        $sql = "DELETE  tbleave_control WHERE emp_control='$emp_control' and emp_under='$emp_under'";
	mssql_query($sql);
}
?>