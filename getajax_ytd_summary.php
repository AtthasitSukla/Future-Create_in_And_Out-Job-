<?
include("connect.php");

$status = $_REQUEST['status'];
$date_time=date("m/d/Y H:i:s");




	
	if($status=='showemponsite'){
	$tsite = $_REQUEST['tsite'];
	$paycode = $_REQUEST['paycode'];
	$select0="SELECT site,empno,firstname,lastname from tbemployee where site='".$tsite."' and emp_level in('3','4','5','6','7') and delstatus='0' order by empno asc ";
	$re0=mssql_query($select0);
	while($row0=mssql_fetch_array($re0)){
		$empnosly = "";
		 if($paycode!=''){
		$selects="SELECT total_salary from tbsalary where empno='".$row0['empno']."' and paycode='$paycode'";
		$res=mssql_query($selects);
		$rows=mssql_fetch_array($res);
		$empnosly =  " (".$rows['total_salary'].")";
		}
		
		echo $row0['empno']."@@@".$row0['site']." ".$row0['empno']." ".iconv("tis-620", "utf-8", $row0['firstname'])." ".iconv("tis-620", "utf-8", $row0['lastname'])." ".$empnosly."###";
		
		
		
		}
		
		}
		if($status=='update_ytdsummary'){
			$fieldx = $_REQUEST['fieldx'];
			$fieldx_value = $_REQUEST['fieldx_value'];
			$empno = $_REQUEST['empno'];
			$paycode  = $_REQUEST['paycode'];
			
			$update = "update tbsalary set $fieldx=$fieldx_value where empno='$empno' and paycode='$paycode'";
			//echo $update;
			mssql_query($update);
			
			}
		if($status=='update_ytdsummary2'){
			$fieldx = $_REQUEST['fieldx'];
			$fieldx_value = $_REQUEST['fieldx_value'];
			$empno = $_REQUEST['empno'];
			$paycodeyear  = $_REQUEST['paycodeyear'];
			
			$update = "update tbytdsummary
 set $fieldx=$fieldx_value where empno='$empno' and paycodeyear='$paycodeyear'";
// echo $update;
			mssql_query($update);
			}
		
		
		
	

?>