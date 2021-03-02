<?
session_start();
include("connect.php");
include("library.php"); 
$job_id = $_REQUEST['job_id'];

$sql = "select 

CONVERT(varchar, create_date,103) as create_date2,
CONVERT(varchar, target_date_one,103) as target_date_one2,
CONVERT(varchar, target_date_two,103) as target_date_two2,
CONVERT(varchar, target_date_three,103) as target_date_three2,


* from tbrequest_employee where job_id='$job_id'";
                                            $re = mssql_query($sql);
											$num = mssql_num_rows($re);
											if($num>0){
                                           $row = mssql_fetch_array($re);
										   //job_id, departmentid, positionid_one, positionid_two, male_one, female_one, target_date_one, cause_one, male_two, female_two, target_date_two, cause_two, male_three, female_three, target_date_three, 
                         //cause_three, status, create_date, comment, comment_empno, comment_date, create_empno
						 $departmentid =$row['departmentid'];
						 $positionid_one =$row['positionid_one'];
						 $positionid_two =$row['positionid_two'];
						
						 $male_one =$row['male_one']; 
						 $female_one=$row['female_one']; 
						 $target_date_one =$row['target_date_one2']; 
						 $cause_one =lang_thai_from_database($row['cause_one']); 
						 
						  $male_two =$row['male_two']; 
						  $female_two =$row['female_two']; 
						  $target_date_two  =$row['target_date_two2'];
						  $cause_two   =lang_thai_from_database($row['cause_two']);
						  $male_three  =$row['male_three'];
						  $female_three =$row['female_three'];
						  $target_date_three =$row['target_date_three2'];
						  $cause_three =lang_thai_from_database($row['cause_three']);
						 // $create_date=date_format_uk_from_databese($row['create_date2']);
						  $create_date=$row['create_date2'];
						  $comment=lang_thai_from_database($row['comment']); 
						  $comment_empno=$row['comment_empno']; 
						  $comment_date=$row['comment_date'];
                         //cause_three
						 
												}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>แบบฟอร์มใบขอกำลังคน FM-HR-01</title>
</head>

<body>


<table width="700" border="1" cellpadding="0" cellspacing="0">
 
  <tr>
    <td height="60" colspan="11" align="center" valign="middle"><img width="304" height="51" src="clip_image002.png" />
      <table cellpadding="0" cellspacing="0">
        <tr>
          <td colspan="11" width="593"></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td width="16"></td>
    <td width="98"></td>
    <td width="98"></td>
    <td width="16"></td>
    <td width="16"></td>
    <td width="114"></td>
    <td width="0"></td>
    <td width="92"></td>
    <td width="22"></td>
    <td width="97"></td>
    <td width="107"></td>
  </tr>
  <tr>
    <td height="30" colspan="11" align="center"><strong>ใบขออัตรากำลังคน</strong></td>
  </tr>
  <tr>
    <td height="30" colspan="7" style="padding-left:5px">ฝ่าย    / แผนก / หน่วยงาน : <?
    
	
											$sqld = "select department from tbdepartment where departmentid='$departmentid'";
                                            $red = mssql_query($sqld);
											$rowd = mssql_fetch_array($red);
												echo $rowd['department'];
												
											$sqlp = "select positionname from tbposition where positionid='$positionid_one'";
                                            $rep = mssql_query($sqlp);
											$rowp = mssql_fetch_array($rep);
											$positionname_one = $rowp['positionname'];	
											$sqlp = "select positionname from tbposition where positionid='$positionid_two'";
                                            $rep = mssql_query($sqlp);
											$rowp = mssql_fetch_array($rep);
											$positionname_two = $rowp['positionname'];	
	
	?></td>
    <td colspan="4">  วันที่     :  <?=$create_date?></td>
  </tr>
  <tr>
    <td height="30" colspan="11" style="padding-left:5px">1. ตำแหน่งงาน : <?=$positionname_one?></td>
  </tr>
  <tr>
    <td height="30" colspan="11" style="padding-left:5px">2. ตำแหน่งงาน : <?=$positionname_two?></td>
  </tr>
  <tr>
    <td height="30" colspan="3" style="padding-left:5px">ขอทดแทนพนักงานเดิม</td>
    <td colspan="3" align="center">ชาย  <?=$male_one?>  อัตรา</td>
    <td colspan="5" style="padding-left:5px">วันที่ต้องการ  <?=$target_date_one?></td>
  </tr>
  <tr>
    <td height="30" colspan="3" align="center">( ที่ลาออกไป )</td>
    <td colspan="3" align="center">หญิง  <?=$female_one?>  อัตรา</td>
    <td colspan="5"> </td>
  </tr>
  <tr>
    <td height="70" valign="top" colspan="11" style="padding-left:5px">สาเหตุ : <?=$cause_one?></td>
  </tr>

  <tr>
    <td height="30" colspan="3" style="padding-left:5px">ขอเพิ่มอัตราพนักงาน</td>
    <td colspan="3" align="center">ชาย  <?=$male_two?>  อัตรา</td>
    <td colspan="5" style="padding-left:5px">วันที่ต้องการ  <?=$target_date_two?></td>
  </tr>
  <tr>
    <td height="30" colspan="3" align="center">( รองรับงานที่เพิ่มขึ้น )</td>
    <td colspan="3" align="center">หญิง  <?=$female_two?>  อัตรา</td>
    <td colspan="5"> </td>
  </tr>
  <tr>
    <td  height="70" valign="top" colspan="11" style="padding-left:5px">สาเหตุ : <?=$cause_two?></td>
  </tr>
  
  <tr>
    <td height="30" colspan="3" style="padding-left:5px">ขอทดแทนพนักงาน</td>
    <td colspan="3" align="center">ชาย  <?=$male_three?>  อัตรา</td>
    <td colspan="5" style="padding-left:5px">วันที่ต้องการ  <?=$target_date_three?></td>
  </tr>
  <tr>
    <td height="30" colspan="3" align="center">( ที่โอนย้ายไปหน่วยงานอื่น )</td>
    <td colspan="3" align="center">หญิง  <?=$female_three?>  อัตรา</td>
    <td colspan="5"> </td>
  </tr>
  <tr>
    <td height="70" valign="top" colspan="11" style="padding-left:5px">สาเหตุ : <?=$cause_three?></td>
  </tr>
  
  <tr>
    <td height="30" colspan="11" style="padding-left:5px">ความคิดเห็นและข้อเสนอแนะของผู้จัดการแผนก    /  GM</td>
  </tr>
  <tr>
    <td height="60" colspan="11" valign="top">     <?=$comment?></td>
  </tr>
  
  <tr>
    <td height="30" colspan="11" style="padding-left:5px">การรับสมัครพนักงานใหม่  ให้อ้างอิงคุณสมบัติในใบกำหนดหน้าที่การทำงาน    ( ในตำแหน่งที่ขอรับพนักงาน )</td>
  </tr>
  <tr>
    <td height="50" colspan="4" align="center" valign="bottom">        ..................................................</td>
    <td colspan="4" align="center" valign="bottom">        ..................................................</td>
    <td colspan="3" align="center" valign="bottom">        ..................................................</td>
  </tr>
  <tr>
    <td height="40" colspan="4" align="center">ผู้จัดการฝ่าย / แผนกที่ขอพนักงาน</td>
    <td colspan="4" align="center">ผู้จัดการฝ่ายบุคคล</td>
    <td colspan="3">                          GM</td>
  </tr>
  <tr>
    <td height="40" colspan="4" align="center" valign="bottom">   วันที่ ........./........../..........</td>
    <td colspan="4" align="center" valign="bottom">วันที่ ........./........../..........</td>
    <td colspan="3" valign="bottom">          วันที่    ........./........../..........</td>
  </tr>
  <tr>
    <td height="30" colspan="11"></td>
  </tr>
</table>
<table width="700" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="right" style="padding-right:5px">FM-HR-01 rev.00 : 20/9/2015</td>
  </tr>
</table>


</body>
</html>
