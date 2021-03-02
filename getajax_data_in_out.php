<?
include("connect.php");
include("library.php");
$status = $_REQUEST['status'];
$date_time=date("m/d/Y H:i:s");
if($status=='checkempsite'){
	$site = $_POST['tsite'];
		$sqldepartment  = "SELECT * FROM tbemployee WHERE site='$site'";
	$department = mssql_query($sqldepartment);
		    echo '<option value="" selected>- พนักงาน -</option>';
	while($row_department= mssql_fetch_array($department)){
			 echo '<option value="'.lang_thai_from_database($row_department['empno']).'">'.lang_thai_from_database($row_department['firstname']).' '.lang_thai_from_database($row_department['lastname']).'</option>';
	}
}
if($status=='checkemp'){
	$employee = $_POST['employee'];
		$sqlemployee  = "SELECT * FROM tbemployee WHERE empno='$employee'";
	$employee = mssql_query($sqlemployee);
	while($row_employee_name= mssql_fetch_array($employee)){

     $empnamefull  =   lang_thai_from_database($row_employee_name['firstname'].' '.$row_employee_name['lastname']);

	}
    echo $empnamefull;
}
if($status == 'set_datetime'){
    $startdate = date_format_thai_into_database($_REQUEST['startdate']);
    $probationdate = date('d/m/Y', strtotime("+4 months", strtotime($startdate)));
    $arr_date = explode("/",$probationdate);
    $probationdate = $arr_date[0]."/".$arr_date[1]."/".((int)$arr_date[2]+543);
    //$probationdate = date_format_thai_from_databese($probationdate);
    echo $probationdate;
}
if($status == 'set_paycode'){
  $datetime = $_POST['datetime'];
 $sqlpaycodee  = "SELECT * FROM tbpaycode WHERE  '$datetime' BETWEEN startdate AND enddate ";
 $paycodee = mssql_query($sqlpaycodee);
 while($row_paycodee = mssql_fetch_array($paycodee)){
 $paycode  =   $row_paycodee['paycode'];

 }
echo  $paycode;
}
if($status=='I'){
    $tsite = $_REQUEST['tsite'];
	$employee = iconv("utf-8","tis-620", $_REQUEST['employee']);
	$empname = $_REQUEST['empname'];
	$shift = $_REQUEST['shift'];
	$attstatus = $_REQUEST['attstatus'];
	$datetime = $_REQUEST['datetime'];
	$timeinout = $_REQUEST['timeinout'];
	$paycode = $_REQUEST['paycode'];
	$remark = $_REQUEST['remark'];
    $today = date("s"); 
    $datetoday = date("Y-m-d"); 
    $datenow = $datetime.' '.$timeinout.':'.$today;
     
     $sql = "INSERT INTO tbatt(empno,Name,attDateTime,site,shift,remark,paycode,att_status,att_real_date)";
     $sql .= "VALUES('$employee','lang_thai_from_database($empname)','$datenow','$tsite','$shift','$remark','$paycode','$attstatus','$datetoday')";
     mssql_query($sql);
     $sqlcheck  = "SELECT * FROM tbatt WHERE empno = '$employee' and attDateTime = '$datenow' ";
     $checkinsert = mssql_query($sqlcheck);
     $number = mssql_num_rows($checkinsert);
     if($number == 0){
        echo '0';
     }else{
        echo '1';
     }

} 
?>