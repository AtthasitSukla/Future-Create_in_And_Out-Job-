<? 
session_start();
include("connect.php");  ?>
<?

	$date_time=date("m/d/Y H:i:s");
	$status = $_REQUEST['status'];
    
    if($status=='checkpassword'){
		$admin_userid = $_REQUEST['admin_userid'];
		$old_password = $_REQUEST['old_password'];
	$select="select * from tbemployee where empno='".$admin_userid."' and password='".$old_password."'";
	$re=mssql_query($select);
	$num=mssql_num_rows($re);
	if($num<=0){
		echo "nodata";
	}
		}
		
		if($status=='savenewpassword'){
		
		$admin_userid = $_REQUEST['admin_userid'];
		$old_password = $_REQUEST['old_password'];
		$new_password = $_REQUEST['new_password'];
			$update="update tbemployee set password='$new_password' where empno='".$admin_userid."' and password='".$old_password."'";
	mssql_query($update);
			}
	
?>