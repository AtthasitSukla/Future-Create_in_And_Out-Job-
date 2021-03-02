<?
include("connect.php");
$empno_cal = "56001";
$select_v1="select emp.firstname as firstname, emp.lastname as lastname, emp.emp_level as emp_level ,emp.startdate as startdate,pos.positionname as positionname  from tbemployee emp JOIN tbposition pos ON emp.positionid = pos.positionid where emp.empno = '$empno_cal' ";
	$re_v1=mssql_query($select_v1);
	$row_v1=mssql_fetch_array($re_v1);
	
	
	function cal_vacation($startdate,$enddate){
	$count = (strtotime($enddate) - strtotime($startdate))/( 60 * 60 * 24 );
	$total_annual = 0; //พักร้อน

	if($count >= 365 && $count < 730){
		$total_annual = 6.00;
	}else if($count >= 730 && $count < 1095){
		$total_annual = 7.00;
	}else if($count >= 1095 && $count < 1460){
		$total_annual = 8.00;
	}else if($count >= 1460 && $count < 1825){
		$total_annual = 9.00;
	}else if($count >= 1825){
		$total_annual = 10.00;
	}
	
	return $total_annual;
	}
	//echo "<BR>";
//	echo "start date=".$row_v1['startdate'];	
//	echo "<BR>";
//	echo "vacation allowed : ".cal_vacation($row_v1['startdate'],$row['startdate']);
//	echo "<BR>";
//	echo "vacation allowed : ".cal_vacation($row_v1['startdate'],date("Y-m-d"));
//	echo "<BR>";
	
		$select_v2="select * from tbleave_work where e_date >= '".$row_v1['startdate']."' and s_date<=GETDATE()  order by l_years asc ";
		$re_v2=mssql_query($select_v2);
		while($row_v2=mssql_fetch_array($re_v2)){
			//$e_date = date("d/m/Y", strtotime($row_v2['e_date']));
			
					$select_v3 = "select SUM(leavetotal) as total from tbleave_transaction where leavetypeid = 'L0003' AND empno = '$empno_cal' AND (statusapprove = 'Approve' OR statusapprove = 'New') AND (leavestartdate BETWEEN  '".$row_v2['s_date']."' AND '".$row_v2['e_date']."')";
					
					$re_v3 = mssql_query($select_v3);
					$num_v3=mssql_num_rows($re_v3);
					if($num_v3>0){
					 while($row_v3= mssql_fetch_array($re_v3)){
						 $vacation_use = 0;
						 $vacation_day = 0;
						 $vacation_remain = 0;
						 if( $row_v3['total']!=''){
							 $vacation_use  = $row_v3['total'];
							 }else{
								 $vacation_use = 0;
								 }
						 	
							echo $row_v2['l_years'];
							echo "<BR>";
			echo "vacation allowed : ".cal_vacation($row_v1['startdate'],$row_v2['e_date']);
							echo "<BR>";
							echo "use = ".$vacation_use;
							echo "<BR>";
							
							$vacation_day = cal_vacation($row_v1['startdate'],$row_v2['e_date']);
							$vacation_remain = (float)$vacation_day-(float)$vacation_use;
							
		$select_v4 = "select * from tbleave_vacation where empno='$empno_cal' and l_years='".$row_v2['l_years']."'";
					$re_v4 = mssql_query($select_v4);
					$num_v4=mssql_num_rows($re_v4);
					if($num_v4>0){
		$update_v4 = "update tbleave_vacation set  vacation_day=$vacation_day, vacation_use=$vacation_use, vacation_remain=$vacation_remain where 
empno='$empno_cal' and l_years='".$row_v2['l_years']."' ";
			mssql_query($update_v4);
						}else{
							$insert_v4="insert into tbleave_vacation(empno, l_years, vacation_day, vacation_use, vacation_remain) values('$empno_cal', '".$row_v2['l_years']."', $vacation_day, $vacation_use, $vacation_remain)";
							mssql_query($insert_v4);
							}
							
							
					 	}
					}	
		}
		
		
?>



