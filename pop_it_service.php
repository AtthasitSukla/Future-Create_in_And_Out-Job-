<?
session_start();
include("connect.php");
include("library.php"); 
$job_id = $_REQUEST['job_id'];


											$sql = "select CONVERT(varchar, create_date,103) as create_date2,
											CONVERT(varchar, solution_date,103) as solution_date2,
											* from tbitservice_list where job_id='$job_id'";
                                            $re = mssql_query($sql);
											$num = mssql_num_rows($re);
											if($num>0){
                                          			 $row = mssql_fetch_array($re);
										    $create_date = date_format_uk_from_databese($row['create_date2']);
										    $solution_date = date_format_uk_from_databese($row['solution_date2']);
											$problem_type = lang_thai_from_database($row['problem_type']);
											$problem_topic = lang_thai_from_database($row['problem_topic']);
											$problem_detail = lang_thai_from_database($row['problem_detail']);
											$requestname = get_full_name($row['empno']);
											
											$sqls = "select top 1 * from tbitservice_chat where job_id='$job_id' and job_status='Close' order by id desc";
                                            $res = mssql_query($sqls);
											$nums = mssql_num_rows($res);
											if($nums>0){
                                          			 $rows = mssql_fetch_array($res);
													  $message =  lang_thai_from_database($rows['message']);
											}
											
											$sql2 = "select * from tbemployee where empno='".$row['empno']."'";
                                            $re2 = mssql_query($sql2);
											$num2 = mssql_num_rows($re2);
											if($num2>0){
                                          			 $row2 = mssql_fetch_array($re2);
													$departmentname = get_departmentname($row2['departmentid']);
													$positionname = get_positionname($row2['positionid']);
													$email = $row2['email'];
													 }
											
										//	$problem_solution = lang_thai_from_database($row['problem_solution']);
												}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>FM-IT-02 IT Service Request</title>
</head>

<body>
<table style=" border: 1px solid black;">
  <tr>
    <td width="834" height="30" align="center" ><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="80" align="center"  style="padding-left:10px"><h3>IPACK Logistics – IT Service Request</h3></td>
    <td align="right"  style="padding-right:5px"><img src="clip_image002.png"></td>
  </tr>
</table>
</td>
  </tr>
  
  
  <tr>
    <td width="834" height="30" align="left" style="padding-left:10px">วันที่ขอ____________________<?=$create_date?>_______________________</td>
  </tr>
  <tr>
    <td height="30" align="left" style="padding-left:10px">แผนกที่ขอ____________________<?=$departmentname?>_______________________</td>
  </tr>
  <tr>
    <td height="30" align="left" style="padding-left:10px">ผู้ประสานงาน____________________<?=$requestname?>_______________________</td>
  </tr>
  <tr>
    <td height="30" align="left" style="padding-left:10px">ตำแหน่ง__<?=$positionname?>___  อีเมล์___<?=$email?>___ โทรศัพท์__________________   </td>
  </tr>
  <tr>
    <td height="30" align="left" style="padding-left:10px">เลือกปัญหา________<?=$problem_type?>____________</td>
  </tr>
  <tr>
    <td height="30" align="left" style="padding-left:10px">รายละเอียดของปัญหา________<?=$problem_detail?>____________</td>
  </tr>
  
 
  <tr>
    <td height="30" align="left" style="padding-left:10px">รายงานการแก้ไข</td>
  </tr>
  <tr>
    <td height="30" style="padding-left:15px"><?=$message?></td>
  </tr>
 
  <tr>
    <td height="30" align="left" style="padding-left:10px">วันที่ดำเนินการแก้ไข____<?=$solution_date?>____</td>
  </tr>
  <tr>
    <td height="30" style="padding-left:10px"></td>
  </tr>
  <tr>
    <td height="30" align="center">   ลงชื่อ ……………………………………………… ผู้ร้องขอ</td>
  </tr>
  <tr>
    <td height="30" align="center">       (………………………………………………) </td>
  </tr>
  <tr>
    <td height="30" align="center"></td>
  </tr>
  <tr>
    <td height="30" align="center">ลงชื่อ ………………………………………………    ผู้ดำเนินการ</td>
  </tr>
  <tr>
    <td height="30" align="center">       (………………………………………………) </td>
  </tr>
  <tr>
    <td height="30" align="center"></td>
  </tr>
  <tr>
    <td height="30" align="center">             ลงชื่อ ………………………………………………  ผู้จัดการแผนก IT</td>
  </tr>
  <tr>
    <td height="30" align="center">       (………………………………………………) </td>
  </tr>
  <tr>
    <td height="30" align="center"> </td>
  </tr>
  <tr>
    <td height="30" align="center">               ลงชื่อ ………………………………………………  ผู้รับมอบ    </td>
  </tr>
  <tr>
    <td height="30" align="center">       (………………………………………………) </td>
  </tr>
  <tr>
    <td height="30" align="center">                 วันที่    ………………………………………………  </td>
  </tr>
   <tr>
    <td height="30"></td>
  </tr>
  
 
</table>
<table width="834">
<tr>
    <td align="right" style="padding-right:5px">FM-IT-02 Rev.00 : 02/09/2016</td>
  </tr>
  </table>
</body>
</html>
