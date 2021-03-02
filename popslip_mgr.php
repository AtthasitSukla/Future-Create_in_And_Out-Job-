<? include("connect.php");  ?>
<?
//$ordernumber = $_REQUEST['ordernumber'];
$empno = $_REQUEST['empno'];
$paycode = $_REQUEST['paycode'];
$paycodeyear = $_REQUEST['paycodeyear'];


	

			$select="select   position_val, mte_val, travel_val, mobile_val,paystatus,hbd,leave_without_pay,
tax,
late,
personal_leave,
absent,
other_deduct,empno, paycode, total_day, total_car_rice,total_fl, total_normal_day, total_wage, total_ot1, total_ot1_5, total_ot2, total_ot3, total_ot, att_reward, social_in, skill_reward, total_shift_val, total_salary,subtotal_salary ,ytd_social_in,ytd_income,tax  
FROM            tbsalary where empno = '$empno' and paycode='$paycode' ";
				$re=mssql_query($select);
				$row=mssql_fetch_array($re);
				
				
				
				$selecte="select convert(varchar, startdate, 103)as  startdate2,site, basic_salary,basic_wage,empno, firstname, lastname, site, password, delstatus, emp_level, emptype, departmentid, positionid, accountid, probationdate, resigndate, att_reward, skill_reward, basic_wage, 
                         basic_salary FROM  tbemployee where empno = '$empno' ";
				$ree=mssql_query($selecte);
				$rowe=mssql_fetch_array($ree);
				
				$firstname = $rowe['firstname'];
				$lastname = $rowe['lastname'];
				$accountid = $rowe['accountid'];
				$att_reward = $rowe['att_reward'];
				$emptype = $rowe['emptype'];
				$basic_salary = $rowe['basic_salary'];
				$basic_wage = $rowe['basic_wage'];
				$site = $rowe['site'];
				$positionid = $rowe['positionid'];
				$startdate = $rowe['startdate2'];
				
					$selectpp="select positionname
 FROM  tbposition where positionid = '$positionid' ";
				$repp=mssql_query($selectpp);
				$rowpp=mssql_fetch_array($repp);
					
				$positionname =  $rowpp['positionname'];
		
		

?>
<html >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="StyleSheet2.css" type="text/css" media="print" />
<link rel="stylesheet" href="fonts.css" type="text/css" charset="utf-8" />
<title>PAY SLIP <?=$paycode?></title>
<style type="text/css">
.demo
	{
		font-family:'Conv_free3of9',Sans-Serif;
	}
.demo2
	{
		font-family:'tahoma';
	}
</style>
</head>

<body bgcolor="#FFFFFF" onLoad="window.print();">

  
  <?
  	
  ?>
  
<table width="700" border="0" cellpadding="0" cellspacing="0">
 
  <tr>
    <td height="20" colspan="3" align="center">
    
    <table width="100%" border="0" cellpadding="0" cellspacing="1">

<tr>
  <td height="20" colspan="2" align="center" bgcolor="#FFFFFF"><strong><font face="Tahoma" size="2">บริษัทไอแพ็ค โลจิสติกส์ จำกัด</font></strong></td>
  <td colspan="2" rowspan="2"  align="center" bgcolor="#FFFFFF"><b><font size="3" face="Tahoma">ใบแจ้งเงินเดือน / PAY SLIP</font></b></td>
  </tr>
<tr>
  <td height="20" colspan="2" align="center" bgcolor="#FFFFFF"><b><font size="2" face="Tahoma">IPACK LOGISTICS CO.,LTD</font></b></td>
  </tr>
<tr>
  <td width="20%" height="20" align="right" bgcolor="#FFFFFF"><b><font size="1" face="Tahoma">รหัสพนักงาน (EMP.NO.)</font></b></td>
  <td width="30%" bgcolor="#FFFFFF" style="padding-left:5px"><font face="Tahoma" size="1"><?=$empno?> <?=$firstname;?> <?=$lastname;?></font></td>
 
  <td width="23%"  align="right" bgcolor="#FFFFFF"><strong><font size="1" face="Tahoma">ตำแหน่ง (POSITION)</font></strong></td>
  <td width="27%"  align="left" bgcolor="#FFFFFF" style="padding-left:5px"><font face="Tahoma" size="1"><?=$positionname?></font></td>
 
  </tr>
<tr>
  <td height="20" align="right" bgcolor="#FFFFFF"><b><font size="1" face="Tahoma">ชื่อ (NAME)</font></b></td>
  <td bgcolor="#FFFFFF" style="padding-left:5px"><font face="Tahoma" size="1"><?=$firstname;?> <?=$lastname;?></font></td>

  <td align="right" bgcolor="#FFFFFF"><strong><font face="Tahoma" size="1">ประจำงวด (FOR PERIOD)</font></strong></td>
  
  <td bgcolor="#FFFFFF" style="padding-left:5px"><font face="Tahoma" size="1" ><?=$paycode?></font></td>
 
</tr>
<tr>
  <td height="20" align="right"  bgcolor="#FFFFFF"><strong><font size="1" face="Tahoma">สังกัด (SECT/DEPT.)</font></strong></td>
  <td bgcolor="#FFFFFF" style="padding-left:5px"><font face="Tahoma" size="1"><?=$site?></font></td>
 
  <td align="right" bgcolor="#FFFFFF" ><strong><font face="Tahoma" size="1">วันที่เริ่มงาน (START DATE)</font></strong></td>
 
  <td bgcolor="#FFFFFF" style="padding-left:5px"><font face="Tahoma" size="1"><?=$startdate?></font></td>
 
</tr>

<tr>
  <td height="20" align="right"  bgcolor="#FFFFFF"><strong><font face="Tahoma" size="1">เลขที่บัญชี</font></strong></td>
  <td bgcolor="#FFFFFF" style="padding-left:5px"><font face="Tahoma" size="1"><?=$accountid?></font></td>
 
  <td align="right" bgcolor="#FFFFFF" ></td>
 
  <td bgcolor="#FFFFFF" style="padding-left:5px"></td>
 
</tr>






</table>

  </td>
  </tr>
  
  <tr>
    <td colspan="3" align="center">
 
    
    <table width="100%" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td height="20" align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="70%" height="20" bgcolor="#CCCCCC" style="padding-left:5px"><b><font size="2" face="Tahoma">รายการได้ (INCOME)</font></b></td>
        <td width="30%" align="right" bgcolor="#CCCCCC" style="padding-right:5px"><b><font size="2" face="Tahoma">บาท (Baht)</font></b></td>
      </tr>
    </table></td>
    <td align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="70%" height="20" bgcolor="#CCCCCC" style="padding-left:5px"><b><font size="2" face="Tahoma">รายการหัก (DEDUCTION)</font></b></td>
        <td width="30%" align="right" bgcolor="#CCCCCC" style="padding-right:5px"><b><font size="2" face="Tahoma">บาท (Baht)</font></b></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="70%" height="20"  style="padding-left:5px"><b><font size="1" face="Tahoma">ค่าแรง/เงินเดือน (Wage/Salary)</font></b></td>
        <td width="30%" align="right"  style="padding-right:5px"><b><font size="1" face="Tahoma"><?
        if($emptype=='employee'){
			echo number_format($basic_salary, 2, '.', '');
			}else{
				echo number_format($basic_wage, 2, '.', '');
				echo "x";
				echo $row['total_day'];
				echo "=";
				echo number_format($basic_wage*$row['total_day'], 2, '.', '');
			}	
		?></font></b></td>
      </tr>
      <tr>
        <td width="70%" height="20"  style="padding-left:5px"><b><font size="1" face="Tahoma">ค่าตำแหน่ง (Position Allowance)</font></b></td>
        <td width="30%" align="right"  style="padding-right:5px"><b><font size="1" face="Tahoma"><?=number_format($row['position_val'], 2, '.', '');?></font></b></td>
      </tr>
      <tr>
        <td width="70%" height="20"  style="padding-left:5px"><b><font size="1" face="Tahoma">ค่าเดินทาง (Travel Allowance)</font></b></td>
        <td width="30%" align="right"  style="padding-right:5px"><b><font size="1" face="Tahoma"><?=number_format($row['travel_val'], 2, '.', '');?></font></b></td>
      </tr>
       <tr>
        <td width="70%" height="20"  style="padding-left:5px"><b><font size="1" face="Tahoma">ค่าซ่อมบำรุง (Maintenance)</font></b></td>
        <td width="30%" align="right"  style="padding-right:5px"><b><font size="1" face="Tahoma"><?=number_format($row['mte_val'], 2, '.', '');?></font></b></td>
      </tr>
      <tr>
        <td width="70%" height="20"  style="padding-left:5px"><b><font size="1" face="Tahoma">ค่ากะ/เบี้ยเลี้ยง (Shift)</font></b></td>
        <td width="30%" align="right"  style="padding-right:5px"><b><font size="1" face="Tahoma"><?=number_format($row['total_shift_val'], 2, '.', '');?></font></b></td>
      </tr>
      <tr>
        <td width="70%" height="20"  style="padding-left:5px"><b><font size="1" face="Tahoma">ค่าโทรศัพท์ (Phone Allowance)</font></b></td>
        <td width="30%" align="right"  style="padding-right:5px"><b><font size="1" face="Tahoma"><?=number_format($row['mobile_val'], 2, '.', '');?></font></b></td>
      </tr>
     
      <tr>
        <td width="70%" height="20"  style="padding-left:5px"><b><font size="1" face="Tahoma">โบนัส (Bonus)</font></b></td>
        <td width="30%" align="right"  style="padding-right:5px"><b><font size="1" face="Tahoma"><?=number_format($row['bonus'], 2, '.', '');?></font></b></td>
      </tr>
      <tr>
        <td width="70%" height="20"  style="padding-left:5px"><b><font size="1" face="Tahoma">วันเกิดพนักงานและครอบครัว (HBD &amp; HFM)</font></b></td>
        <td width="30%" align="right"  style="padding-right:5px"><b><font size="1" face="Tahoma"><?=number_format($row['hbd'], 2, '.', '');?></font></b></td>
      </tr>
    </table></td>
    <td align="center" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="70%" height="20"  style="padding-left:5px"><b><font size="1" face="Tahoma">ขาดงาน (Absent)</font></b></td>
        <td width="30%" align="right"  style="padding-right:5px"><b><font size="1" face="Tahoma"><?
         if($emptype=='employee'){
		echo number_format($row['absent'], 2, '.', '');
		 }else{
		echo number_format(0, 2, '.', '');	 
			 }
		?></font></b></td>
      </tr>
      <tr>
        <td width="70%" height="20"  style="padding-left:5px"><b><font size="1" face="Tahoma">ลากิจ (Personal Leave)</font></b></td>
        <td width="30%" align="right"  style="padding-right:5px"><b><font size="1" face="Tahoma"><?
         if($emptype=='employee'){
		echo number_format($row['personal_leave'], 2, '.', '');
		 }else{
		echo number_format(0, 2, '.', '');	 
			 }
		?></font></b></td>
      </tr>
      <tr>
        <td width="70%" height="20"  style="padding-left:5px"><b><font size="1" face="Tahoma">สาย (Late)</font></b></td>
        <td width="30%" align="right"  style="padding-right:5px"><b><font size="1" face="Tahoma"><?=number_format($row['late'], 2, '.', '');?></font></b></td>
      </tr>
      <tr>
        <td width="70%" height="20"  style="padding-left:5px"><b><font size="1" face="Tahoma">ลาไม่ได้รับเงินเดือน (Leave Without Pay)</font></b></td>
        <td width="30%" align="right"  style="padding-right:5px"><b><font size="1" face="Tahoma"><?=number_format($row['leave_without_pay'], 2, '.', '');?></font></b></td>
      </tr>
      <tr>
        <td width="70%" height="20"  style="padding-left:5px"><b><font size="1" face="Tahoma">ประกันสังคม (Social Security Fund)</font></b></td>
        <td width="30%" align="right"  style="padding-right:5px"><b><font size="1" face="Tahoma"><?=number_format($row['social_in'], 2, '.', '');?></font></b></td>
      </tr>
      <tr>
        <td width="70%" height="20"  style="padding-left:5px"><b><font size="1" face="Tahoma">ภาษีเงินได้ (Tax)</font></b></td>
        <td width="30%" align="right"  style="padding-right:5px"><b><font size="1" face="Tahoma"><?=number_format($row['tax'], 2, '.', '');?></font></b></td>
      </tr>
      <tr>
        <td width="70%" height="20"  style="padding-left:5px"><b><font size="1" face="Tahoma">หักอื่นๆ (Others Deduction)</font></b></td>
        <td width="30%" align="right"  style="padding-right:5px"><b><font size="1" face="Tahoma"><?=number_format($row['other_deduct'], 2, '.', '');?></font></b></td>
      </tr>
      <tr>
        <td width="70%" height="21"  style="padding-left:5px">&nbsp;</td>
        <td width="30%" align="right"  style="padding-right:5px"><b><font size="1" face="Tahoma"></font></b></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="70%" height="20"  style="padding-left:5px"><b><font size="2" face="Tahoma">รวมรายได้ (TOTAL INCOME)</font></b></td>
        <td width="30%" align="right"  style="padding-right:5px"><b><font size="2" face="Tahoma"><?=number_format($row['subtotal_salary'], 2, '.', '');?></font></b></td>
      </tr>
    </table></td>
    <td align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="70%" height="20"  style="padding-left:5px"><b><font size="2" face="Tahoma">รวมรายการหัก (TOTAL DEDUCTION)</font></b></td>
        <td width="30%" align="right"  style="padding-right:5px"><b><font size="2" face="Tahoma"><?
		
		$tax = number_format($row['tax'], 2, '.', '');
		$late = number_format($row['late'], 2, '.', '');
		$personal_leave = number_format($row['personal_leave'], 2, '.', '');
		$absent = number_format($row['absent'], 2, '.', '');
		$other_deduct = number_format($row['other_deduct'], 2, '.', '');
		$leave_without_pay = number_format($row['leave_without_pay'], 2, '.', '');
		$social_in = number_format($row['social_in'], 2, '.', '');
		
		 if($emptype=='employee'){
			 $total_deduction = $late+$personal_leave+$absent+$other_deduct+$leave_without_pay+$social_in+$tax;
			 }else{
			 $total_deduction = $social_in;
			 }
		
		echo number_format($total_deduction, 2, '.', '');
		
		?></font></b></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="20" colspan="2" align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="28%" height="20" style="padding-left:5px"><b><font size="2" face="Tahoma">รายได้สุทธิ (NET INCOME)</font></b></td>
        <td width="19%" align="right"  style="padding-right:5px"><b><font size="2" face="Tahoma"><?=number_format($row['total_salary'], 2, '.', '');?></font></b></td>
        <td width="28%"  style="padding-left:5px"><b><font size="2" face="Tahoma">บาท (Baht)</font></b></td>
        <td width="25%">&nbsp;</td>
      </tr>
    </table></td>
    </tr>
  <tr>
    <td colspan="2" align="center"><?
		
    //calc ytd summary
	if($row['paystatus']!='paid'){
		//echo "xx";
				$selectp="select ytd_income, ytd_tax, ytd_social_in from tbytdsummary where empno='$empno' and paycodeyear='$paycodeyear'  ";
				$rep=mssql_query($selectp);
				
				$nump = mssql_num_rows($rep);
				if($nump<=0){
						$insert = "insert into tbytdsummary(ytd_income, ytd_tax, ytd_social_in,empno,paycodeyear) values(".$row['total_salary'].", $tax, $social_in,'$empno','$paycodeyear')";
						mssql_query($insert);
					}else{
						
						//$rowp=mssql_fetch_array($rep);
						//$ytd_income2 = $rowp['$ytd_income']+$row['total_salary'];
						//$ytd_tax2= $rowp['$ytd_tax']+$tax;
						//$ytd_social_in2= $rowp['$ytd_social_in']+$social_in;
						
					//	$update = "update tbytdsummary set ytd_income=$ytd_income2, ytd_tax=$ytd_tax2, ytd_social_in=$ytd_social_in2 where empno='$empno' and paycodeyear='$paycodeyear'";
					//	mssql_query($update);
						}
	}
						
		//update print slip
		//$sqlupdate= "update  tbsalary set paystatus='paid' where empno = '$empno' and paycode='$paycode'";
		//mssql_query($sqlupdate);
		
					
				$selectp="select ytd_income, ytd_tax, ytd_social_in from tbytdsummary where empno='$empno' and paycodeyear='$paycodeyear'  ";
				$rep=mssql_query($selectp);
				
				$nump = mssql_num_rows($rep);
				if($nump>0){
						$rowp=mssql_fetch_array($rep);
						$ytd_income =  $rowp['ytd_income'];
						$ytd_tax =  $rowp['ytd_tax'];
						$ytd_social_in =  $rowp['ytd_social_in'];
					}
	
	?><table width="100%" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td width="31%" height="20" align="center"><b><font size="1" face="Tahoma">เงินได้สะสม</font></b></td>
    <td width="32%" align="center"><b><font size="1" face="Tahoma">ภาษีสะสม</font></b></td>
    <td width="37%" align="center"><b><font size="1" face="Tahoma">ประกันสังคมสะสม</font></b></td>
    </tr>
  <tr>
    <td height="20" align="center"><b><font size="1" face="Tahoma">( YTD INCOME )</font></b></td>
    <td align="center"><b><font size="1" face="Tahoma">( YTD TAX )</font></b></td>
    <td align="center"><b><font size="1" face="Tahoma">( YTD Social Security Fund )</font></b></td>
    </tr>
   <tr>
    <td height="20" align="center"><b><font size="1" face="Tahoma"><?=number_format($ytd_income, 2, '.', '');?></font></b></td>
    <td align="center"><b><font size="1" face="Tahoma"><?=number_format($ytd_tax, 2, '.', '');?></font></b></td>
    <td align="center"><b><font size="1" face="Tahoma"><?=number_format($ytd_social_in, 2, '.', '');?></font></b></td>
    </tr>
</table>
</td>
    </tr>
</table>

    	
			
		
        
        	
        
        

    </td>
    </tr>
  
  
</table>


</body>
</html>
