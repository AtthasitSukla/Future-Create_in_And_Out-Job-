<? include("connect.php");  ?>
<?
//$ordernumber = $_REQUEST['ordernumber'];
$empno = $_REQUEST['empno'];
$paycode = $_REQUEST['paycode'];

		//update print slip
		//$sqlupdate= "update  tbsalary set paystatus='paid' where empno = '$empno' and paycode='$paycode'";
		//mssql_query($sqlupdate);

			$select="select  empno, paycode, total_day, total_car_rice, total_normal_day, total_wage, total_ot1, total_ot1_5, total_ot2, total_ot3, total_ot, att_reward, social_in, skill_reward, total_shift_val, total_salary,subtotal_salary ,ytd_social_in,ytd_income 
FROM            tbsalary where empno = '$empno' and paycode='$paycode' ";
				$re=mssql_query($select);
				$row=mssql_fetch_array($re);
				
				
				
				$selecte="select  basic_salary,basic_wage,empno, firstname, lastname, site, password, delstatus, emp_level, emptype, departmentid, positionid, accountid, startdate, probationdate, resigndate, att_reward, skill_reward, basic_wage, 
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
  
<table width="800" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="206" height="10"  align="center"></td>
    <td width="308"   align="center"></td>
    <td width="278"  align="center"></td>
  </tr>
  <tr>
    <td height="25" colspan="3" align="center">
    
    <table width="100%" border="0" cellpadding="0" cellspacing="1">

<tr>
  <td height="20" colspan="2" align="center" bgcolor="#FFFFFF"><strong><font face="Tahoma" size="1">บริษัทไอแพ็ค โลจิสติกส์ จำกัด</font></strong></td>
  <td colspan="2" rowspan="2"  align="center" bgcolor="#FFFFFF"><b><font size="3" face="Tahoma">ใบแจ้งเงินเดือน / PAY SLIP</font></b></td>
  </tr>
<tr>
  <td height="20" colspan="2" align="center" bgcolor="#FFFFFF"><b><font size="1" face="Tahoma">IPACK LOGISTICS CO.,LTD</font></b></td>
  </tr>
<tr>
  <td width="20%" height="20" align="right" bgcolor="#FFFFFF"><b><font size="1" face="Tahoma">รหัสพนักงาน (EMP.NO.)</font></b></td>
  <td width="31%" bgcolor="#FFFFFF" style="padding-left:5px"><font face="Tahoma" size="1"><?=$empno?></font></td>
 
  <td width="22%"  align="right" bgcolor="#FFFFFF"><strong><font size="1" face="Tahoma">ตำแหน่ง (POSITION)</font></strong></td>
  <td width="27%"  align="left" bgcolor="#FFFFFF" style="padding-left:5px"><font face="Tahoma" size="1"><?=$position?></font></td>
 
  </tr>
<tr>
  <td height="25" align="right" bgcolor="#FFFFFF"><b><font size="1" face="Tahoma">ชื่อ (NAME)</font></b></td>
  <td bgcolor="#FFFFFF" style="padding-left:5px"><font face="Tahoma" size="1"><?=iconv("tis-620", "utf-8", $firstname );?> <?=iconv("tis-620", "utf-8", $lastname );?></font></td>

  <td align="right" bgcolor="#FFFFFF"><strong><font face="Tahoma" size="1">ประจำงวด (FOR PERIOD)</font></strong></td>
  
  <td bgcolor="#FFFFFF" style="padding-left:5px"><font face="Tahoma" size="1" ><?=$paycode?></font></td>
 
</tr>
<tr>
  <td height="20" align="right"  bgcolor="#FFFFFF"><strong><font size="1" face="Tahoma">สังกัด (SECT/DEPT.)</font></strong></td>
  <td bgcolor="#FFFFFF" style="padding-left:5px"><font face="Tahoma" size="1"><?=$department?></font></td>
 
  <td align="right" bgcolor="#FFFFFF" ><strong><font face="Tahoma" size="1">เลขที่บัญชี</font></strong></td>
 
  <td bgcolor="#FFFFFF" style="padding-left:5px"><font face="Tahoma" size="1"><?=$accountid?></font></td>
 
</tr>





</table>

  </td>
  </tr>
  
  <tr>
    <td colspan="3" align="center">
 
    
    <table width="100%" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td height="35" align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="60%" height="35" bgcolor="#CCCCCC" style="padding-left:5px"><b><font size="2" face="Tahoma">รายการได้ (INCOME)</font></b></td>
        <td width="40%" align="right" bgcolor="#CCCCCC" style="padding-right:5px"><b><font size="2" face="Tahoma">บาท (Baht)</font></b></td>
      </tr>
    </table></td>
    <td align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="60%" height="35" bgcolor="#CCCCCC" style="padding-left:5px"><b><font size="2" face="Tahoma">รายการหัก (DEDUCTION)</font></b></td>
        <td width="40%" align="right" bgcolor="#CCCCCC" style="padding-right:5px"><b><font size="2" face="Tahoma">บาท (Baht)</font></b></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="60%" height="30"  style="padding-left:5px"><b><font size="1" face="Tahoma">ค่าแรง/เงินเดือน (Wage/Salary)</font></b></td>
        <td width="40%" align="right"  style="padding-right:5px"><b><font size="1" face="Tahoma"><?
        if($emptype=='employee'){
			echo number_format($basic_salary, 2, '.', '');
			}else{
				echo number_format($basic_wage, 2, '.', '');
			}	
		?></font></b></td>
      </tr>
      <tr>
        <td width="60%" height="30"  style="padding-left:5px"><b><font size="1" face="Tahoma">ค่าล่วงเวลา (Over Time)</font></b></td>
        <td width="40%" align="right"  style="padding-right:5px"><b><font size="1" face="Tahoma"><?=number_format($row['total_ot'], 2, '.', '');?></font></b></td>
      </tr>
      <tr>
        <td width="60%" height="30"  style="padding-left:5px"><b><font size="1" face="Tahoma">ค่าตำแหน่ง (Position Allowance)</font></b></td>
        <td width="40%" align="right"  style="padding-right:5px"><b><font size="1" face="Tahoma"></font></b></td>
      </tr>
      <tr>
        <td width="60%" height="30"  style="padding-left:5px"><b><font size="1" face="Tahoma">ค่ากะ/เบี้ยเลี้ยง (Shift)</font></b></td>
        <td width="40%" align="right"  style="padding-right:5px"><b><font size="1" face="Tahoma"><?=number_format($row['total_shift_val'], 2, '.', '');?></font></b></td>
      </tr>
      <tr>
        <td width="60%" height="30"  style="padding-left:5px"><b><font size="1" face="Tahoma">เบี้ยขยัน (Attendance Reward)</font></b></td>
        <td width="40%" align="right"  style="padding-right:5px"><b><font size="1" face="Tahoma"><?=number_format($att_reward, 2, '.', '');?></font></b></td>
      </tr>
      <tr>
        <td width="60%" height="30"  style="padding-left:5px"><b><font size="1" face="Tahoma">โบนัส (Bonus)</font></b></td>
        <td width="40%" align="right"  style="padding-right:5px"><b><font size="1" face="Tahoma"></font></b></td>
      </tr>
      <tr>
        <td width="60%" height="30"  style="padding-left:5px"><b><font size="1" face="Tahoma">รายได้อื่นๆ (Other Incomes)</font></b></td>
        <td width="40%" align="right"  style="padding-right:5px"><b><font size="1" face="Tahoma"><?=number_format($row['total_car_rice'], 2, '.', '');?></font></b></td>
      </tr>
    </table></td>
    <td align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="60%" height="30"  style="padding-left:5px"><b><font size="1" face="Tahoma">ขาดงาน (Absent)</font></b></td>
        <td width="40%" align="right"  style="padding-right:5px"><b><font size="1" face="Tahoma"></font></b></td>
      </tr>
      <tr>
        <td width="60%" height="30"  style="padding-left:5px"><b><font size="1" face="Tahoma">สาย (Late)</font></b></td>
        <td width="40%" align="right"  style="padding-right:5px"><b><font size="1" face="Tahoma"></font></b></td>
      </tr>
      <tr>
        <td width="60%" height="30"  style="padding-left:5px"><b><font size="1" face="Tahoma">ภาษี (Tax)</font></b></td>
        <td width="40%" align="right"  style="padding-right:5px"><b><font size="1" face="Tahoma"></font></b></td>
      </tr>
      <tr>
        <td width="60%" height="30"  style="padding-left:5px"><b><font size="1" face="Tahoma">ประกันสังคม (Social Security Fund)</font></b></td>
        <td width="40%" align="right"  style="padding-right:5px"><b><font size="1" face="Tahoma"><?=number_format($row['social_in'], 2, '.', '');?></font></b></td>
      </tr>
      <tr>
        <td width="60%" height="30"  style="padding-left:5px"><b><font size="1" face="Tahoma">เงินสะสมเข้ากองทุน PVF (Provident Fund)</font></b></td>
        <td width="40%" align="right"  style="padding-right:5px"><b><font size="1" face="Tahoma"></font></b></td>
      </tr>
      <tr>
        <td width="60%" height="30"  style="padding-left:5px"><b><font size="1" face="Tahoma">เบิกล่วงหน้า (Cash)</font></b></td>
        <td width="40%" align="right"  style="padding-right:5px"><b><font size="1" face="Tahoma"></font></b></td>
      </tr>
      <tr>
        <td width="60%" height="30"  style="padding-left:5px"><b><font size="1" face="Tahoma">หักอื่นๆ (Others Deduction)</font></b></td>
        <td width="40%" align="right"  style="padding-right:5px"><b><font size="1" face="Tahoma"></font></b></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="60%" height="35"  style="padding-left:5px"><b><font size="2" face="Tahoma">รวมรายได้ (TOTAL INCOME)</font></b></td>
        <td width="40%" align="right"  style="padding-right:5px"><b><font size="2" face="Tahoma"><?=number_format($row['subtotal_salary'], 2, '.', '');?></font></b></td>
      </tr>
    </table></td>
    <td align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="60%" height="35"  style="padding-left:5px"><b><font size="2" face="Tahoma">รวมรายการหัก (TOTAL DEDUCTION)</font></b></td>
        <td width="40%" align="right"  style="padding-right:5px"><b><font size="2" face="Tahoma"><?=number_format($row['social_in'], 2, '.', '');?></font></b></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="35" colspan="2" align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="28%" height="35" style="padding-left:5px"><b><font size="2" face="Tahoma">รายได้สุทธิ (NET INCOME)</font></b></td>
        <td width="19%" align="right"  style="padding-right:5px"><b><font size="2" face="Tahoma"><?=number_format($row['total_salary'], 2, '.', '');?></font></b></td>
        <td width="28%"  style="padding-left:5px"><b><font size="2" face="Tahoma">บาท (Baht)</font></b></td>
        <td width="25%">&nbsp;</td>
      </tr>
    </table></td>
    </tr>
  <tr>
    <td colspan="2" align="center"><table width="100%" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td height="20" align="center"><b><font size="1" face="Tahoma">เงินได้สะสม</font></b></td>
    <td align="center"><b><font size="1" face="Tahoma">ภาษีสะสม</font></b></td>
    <td align="center"><b><font size="1" face="Tahoma">ประกันสังคมสะสม</font></b></td>
    <td align="center"><b><font size="1" face="Tahoma">กองทุนสำรองเลี้ยงชีพสะสม</font></b></td>
  </tr>
  <tr>
    <td height="20" align="center"><b><font size="1" face="Tahoma">(YTD INCOME)</font></b></td>
    <td align="center"><b><font size="1" face="Tahoma">(YTD TAX)</font></b></td>
    <td align="center"><b><font size="1" face="Tahoma">(YTD Social Security Fund)</font></b></td>
    <td align="center"><b><font size="1" face="Tahoma">(YTD Provident Fund)</font></b></td>
  </tr>
   <tr>
    <td height="30" align="center"><b><font size="1" face="Tahoma"><?=number_format($row['ytd_income'], 2, '.', '');?></font></b></td>
    <td align="center">&nbsp;</td>
    <td align="center"><b><font size="1" face="Tahoma"><?=number_format($row['ytd_social_in'], 2, '.', '');?></font></b></td>
    <td align="center">&nbsp;</td>
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
