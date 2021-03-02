<? ob_start(); ?>
<? include("connect.php");  ?>
<?
			
			$paycode = $_REQUEST['paycode'];
			$site  = $_REQUEST['site'];
			$status = $_REQUEST['status'];
			
				if($paycode!=''){
			
			$select="select paycode,convert(varchar, startdate, 101)as  startdate,
	convert(varchar, enddate, 101)as  enddate from  tbpaycode where paycode = '$paycode' ";
				$re=mssql_query($select);
				$num=mssql_num_rows($re);
				
					$row=mssql_fetch_array($re);
					$startdate = $row['startdate'];
					$enddate = $row['enddate'];
				
			}
		

?>
<html >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Export Report</title>

</head>

<body >

  
  <?
  if($status=='rawatt'){
  
$strExcelFileName="rawatt".$paycode.".xls";
header("Content-Type: application/x-msexcel; name=\"$strExcelFileName\"");
header("Content-Disposition: inline; filename=\"$strExcelFileName\"");
header("Pragma:no-cache");
  
  		 
				
				?>
                
               
                <table border="1" cellpadding="0" cellspacing="0">
                
                  <tr>
                    <td width="72" align="center" bgcolor="#CCCCCC"><strong>empno</strong></td>
                    <td width="154" align="center" bgcolor="#CCCCCC"><strong>attdate</strong></td>
                    <td width="101" align="center" bgcolor="#CCCCCC"><strong>Shift</strong></td>
                    <td width="54" align="center" bgcolor="#CCCCCC"><strong>OT</strong></td>
                    <td width="54" align="center" bgcolor="#CCCCCC"><strong>FL</strong></td>
                    <td width="54" align="center" bgcolor="#CCCCCC"><strong>LE</strong></td>
                    <td width="141" align="center" bgcolor="#CCCCCC"><strong>remark</strong></td>
                  </tr>
                  <?
                  	$select0="SELECT *,convert(varchar, attDateTime, 101)as  workdate2,convert(varchar, attDateTime, 103)as  workdate3,convert(varchar, attDateTime, 108)as  worktime
FROM    tbatt where attDateTime between '".$startdate."' and '".$enddate."' and empno in(select empno from tbemployee where site='$site')  order by empno asc ";
	echo $select0;
	$re0=mssql_query($select0);
	
	while($row0=mssql_fetch_array($re0)){
				  ?>
                  <tr>
                    <td align="center"><?=$row0['empno']?></td>
                    <td align="center"><?=$row0['workdate2']?> <?=$row0['worktime']?></td>
                    <td align="center">&nbsp;</td>
                    <td align="center">&nbsp;</td>
                    <td align="center">&nbsp;</td>
                    <td align="center">&nbsp;</td>
                    <td align="center"> </td>
                  </tr>
                  <?
	}
				  ?>
               
                </table>

<?
					
				
				
				
			
				
 
  }
  if($status=='salary'){
  
$strExcelFileName="salary".$paycode.".xls";
header("Content-Type: application/x-msexcel; name=\"$strExcelFileName\"");
header("Content-Disposition: inline; filename=\"$strExcelFileName\"");
header("Pragma:no-cache");
  
  	$selectp="SELECT paycode, paycodename from tbpaycode where paycode='$paycode' ";
	$rep=mssql_query($selectp);
	$rowp=mssql_fetch_array($rep);
				
				?>
                
               
               
                <table width="100%" border="1" cellpadding="0" cellspacing="0">
                  <tr>
                    <td colspan="22" align="center"><strong>บริษัท ไอแพ็ค โลจิสติกส์ จำกัด</strong></td></tr>
                  <tr>
                    <td colspan="22" align="center"><strong>เงินเดือนพนักงานประจำเดือน 
                    <?=iconv("tis-620", "utf-8", $rowp['paycodename'] );?>
                    </strong></td></tr>
                  <tr>
                    <td align="center" width="109">รหัสพนักงาน</td>
                    <td width="188" colspan="2" align="center">ชื่อ - นามสกุล</td>
                    <td width="124">Site</td>
                    <td width="97" align="center">เบี้ยรายวัน/รายเดือน</td>
                    <td width="87" align="center">หักประกันสังคม    5%</td>
                    <td width="84" align="center">หักภาษีบุคคล</td>
                    <td width="89" align="center">OT</td>
                    <td width="89" align="center">ค่าข้าว75บาทต่อวัน</td>
                    <td width="86" align="center">ค่ากะ 120    บาทต่อวัน</td>
                    <td width="73" align="center">incentive    Forklift</td>
                    <td width="75" align="center">เบี้ยขยัน</td>
                    <td width="81" align="center">วันเกิดพนักงาน</td>
                    <td width="81" align="center">ค่าตำแหน่ง</td>
                    <td width="93" align="center">ค่าซ่อมบำรุง</td>
                    <td width="93" align="center">ค่าเดินทาง</td>
                    <td width="93" align="center">ค่าโทรศัพท์</td>
                    <td width="93" align="center">โบนัส</td>
                    <td width="96" align="center">รวมเงินเดือน<br>
                      ที่พนักงานได้</td>
                    <td width="130" align="center">รายได้สะสม</td>
                    <td width="64" align="center">หักประกันสังคมสะสม</td>
                    <td width="64" align="center">หักภาษีบุคคลสะสม</td>
                  </tr>
                  <?
				  
				  
				  
				 // if($site!=''){
//					  $select0="select * from tbsalary where paycode='$paycode' and empno in (select empno from tbemployee where site='HQ'  and delstatus='0')  order by empno asc ";
//					  }else{
//						  
//						   $select0="select * from tbsalary where paycode='$paycode' ";
//					  
//					  }
	
	$select0="select * from tbsalary where paycode='$paycode' and empno in (select empno from tbemployee where site='HQ'  and delstatus='0' ) order by empno asc ";
                  	
//	echo $select0;
	$re0=mssql_query($select0);
	while($row0=mssql_fetch_array($re0)){
		
		$select="select att_reward,emptype,firstname,site,lastname,basic_salary,basic_wage from tbemployee where empno='".$row0['empno']."'";
				$re=mssql_query($select);
				$num=mssql_num_rows($re);
				if($num>0){
					$row=mssql_fetch_array($re);
					$empname = iconv("tis-620", "utf-8", $row['firstname']." ".$row['lastname'] );
					$empsite = $row['site'];
					$basic_salary = $row['basic_salary'];
					$basic_wage = $row['basic_wage'];
					$emptype = $row['emptype'];
					}
			
				  ?>
                  <tr>
                    <td><?=$row0['empno']?></td>
                    <td colspan="2"><?=$empname?></td>
                    <td><?=$empsite?></td>
                    <td align="right"><?
                    if($emptype=='employee'){
							echo  number_format($basic_salary, 2, '.', '');
						}else{
							echo  number_format($basic_wage*$row0['total_day'], 2, '.', '');
							}
					?></td>
                    <td align="right"><?
					echo number_format($row0['social_in'], 2, '.', '');
					?>
					</td>
                    <td align="right">-</td>
                    <td align="right"><?=number_format($row0['total_ot'], 2, '.', '')?></td>
                    <td align="right"><?=number_format($row0['total_car_rice'], 2, '.', '')?></td>
                    <td align="right"><?=number_format($row0['total_shift_val'], 2, '.', '')?></td>
                    <td align="right"><?=number_format($row0['total_fl'], 2, '.', '')?></td>
                    <td align="right"><?=number_format($row['att_reward'], 2, '.', '')?></td>
                    <td align="right"><?=number_format($row0['hbd'], 2, '.', '')?></td>
                    <td align="right"><?=number_format($row0['position_val'], 2, '.', '')?></td>
                    <td align="right"><?=number_format($row0['mte_val'], 2, '.', '')?></td>
                    <td align="right"><?=number_format($row0['travel_val'], 2, '.', '')?></td>
                    <td align="right"><?=number_format($row0['mobile_val'], 2, '.', '')?></td>
                    <td align="right"><?=number_format($row0['bonus'], 2, '.', '')?></td>
                    <td align="right"><?=number_format($row0['total_salary'], 2, '.', '')?></td>
                    <td align="right"><?=number_format($row0['ytd_income'], 2, '.', '')?></td>
                    <td align="right"><?=number_format($row0['ytd_social_in'], 2, '.', '')?></td>
                    <td align="right"><?=number_format($row0['ytd_tax'], 2, '.', '')?></td>
                  </tr>
                  <?
	}
				  
				  ?>
                  
                   <?
				 // if($site!=''){
//					  $select0="select * from tbsalary where paycode='$paycode' and empno in (select empno from tbemployee where site='TSC'  and delstatus='0' ) order by empno asc ";
//					  }else{
//						  
//						   $select0="select * from tbsalary where 1=0";
//					  
//					  }
					  
	$select0="select * from tbsalary where paycode='$paycode' and empno in (select empno from tbemployee where site='TSC'  and delstatus='0' ) order by empno asc ";
                  	
	
	$re0=mssql_query($select0);
	while($row0=mssql_fetch_array($re0)){
		
		$select="select att_reward,emptype,firstname,site,lastname,basic_salary,basic_wage from tbemployee where empno='".$row0['empno']."'";
				$re=mssql_query($select);
				$num=mssql_num_rows($re);
				if($num>0){
					$row=mssql_fetch_array($re);
					$empname = iconv("tis-620", "utf-8", $row['firstname']." ".$row['lastname'] );
					$empsite = $row['site'];
					$basic_salary = $row['basic_salary'];
					$basic_wage = $row['basic_wage'];
					$emptype = $row['emptype'];
					}
			
				  ?>
                  <tr>
                    <td><?=$row0['empno']?></td>
                    <td colspan="2"><?=$empname?></td>
                    <td><?=$empsite?></td>
                    <td align="right"><?
                    if($emptype=='employee'){
							echo  number_format($basic_salary, 2, '.', '');
						}else{
							echo  number_format($basic_wage*$row0['total_day'], 2, '.', '');
							}
					?></td>
                    <td align="right"><?
					echo number_format($row0['social_in'], 2, '.', '');
					?>
					</td>
                    <td align="right">-</td>
                    <td align="right"><?=number_format($row0['total_ot'], 2, '.', '')?></td>
                    <td align="right"><?=number_format($row0['total_car_rice'], 2, '.', '')?></td>
                    <td align="right"><?=number_format($row0['total_shift_val'], 2, '.', '')?></td>
                    <td align="right"><?=number_format($row0['total_fl'], 2, '.', '')?></td>
                    <td align="right"><?=number_format($row['att_reward'], 2, '.', '')?></td>
                    <td align="right"><?=number_format($row0['hbd'], 2, '.', '')?></td>
                    <td align="right"><?=number_format($row0['position_val'], 2, '.', '')?></td>
                    <td align="right"><?=number_format($row0['mte_val'], 2, '.', '')?></td>
                    <td align="right"><?=number_format($row0['travel_val'], 2, '.', '')?></td>
                    <td align="right"><?=number_format($row0['mobile_val'], 2, '.', '')?></td>
                    <td align="right"><?=number_format($row0['bonus'], 2, '.', '')?></td>
                    <td align="right"><?=number_format($row0['total_salary'], 2, '.', '')?></td>
                    <td align="right"><?=number_format($row0['ytd_income'], 2, '.', '')?></td>
                    <td align="right"><?=number_format($row0['ytd_social_in'], 2, '.', '')?></td>
                    <td align="right"><?=number_format($row0['ytd_tax'], 2, '.', '')?></td>
                  </tr>
                  <?
	}
				  
				  ?>
                </table>

<?
					
				
				
				
			
				
 
  }
  
  
  ?>
  
  

</body>
</html>
