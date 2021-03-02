<? include("connect.php"); 
require_once('mpdf/mpdf.php');
ob_start();
$empno = $_GET['empno'];
$sql = "SELECT empno,firstname,lastname,positionname,startdate  FROM  tbemployee JOIN tbposition ON tbemployee.positionid = tbposition.positionid WHERE empno = '$empno' ";
$re=mssql_query($sql);
$row=mssql_fetch_array($re);
$originalDate = explode('-',$row['startdate']);
$newDate = date("d-m-Y", strtotime($originalDate[0]."-".$originalDate[1]."-".$originalDate[2]));
//----------------
$sql1 = "SELECT empno,firstname,lastname,positionname,startdate  FROM  tbemployee JOIN tbposition ON tbemployee.positionid = tbposition.positionid WHERE empno = ".$_SESSION['admin_userid'];
$re1=mssql_query($sql1);
$row1=mssql_fetch_array($re1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=UTF-8">
<link rel="stylesheet" href="fonts.css" type="text/css" charset="utf-8" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>
<body>
<img src="images/logo_bill.gif" height="25" style="position:fixed;padding-left:440px"/>
<br>
<h5 style="position:fixed;padding-left:380px;margin-top:45;">ON - THE - JOB TRAINING RECORD<br/>&nbsp;&nbsp;&nbsp;&nbsp;แบบบันทึกการปฏิบัติงานในสถานที่จริง</h5></b>
<div style="margin-top:45;font-size:11px;">
Start Date:/ เริ่มงานวันที่  <? echo $newDate;?>
<table width="100%" border="1" style="border: 1px solid black;border-collapse: collapse;font-size:11px;">
  <tr>
    <td colspan="2">Name of Employee :<br>ชื่อพนักงาน :  <? echo iconv("tis-620", "utf-8", $row['firstname']).' '.iconv("tis-620", "utf-8", $row['lastname']); ?></td>
    <td colspan="4">Position:<br>ตำแหน่ง : <? echo $row['positionname']; ?></td>
    <td width="7%">ID .<br>รหัส : <? echo $_GET['empno'];?> </td>
    <td colspan="3">Department........................<br>แผนก ................................</td> 
  </tr>
  <tr>
    <td colspan="2">Name of Coach : <? echo iconv("tis-620", "utf-8", $row1['firstname']).' '.iconv("tis-620", "utf-8", $row1['lastname']); ?></td>
    <td colspan="4">Position:<br>ตำแหน่ง : <? echo $row1['positionname']; ?></td>
    <td>ID .<br>รหัส : <? echo $_SESSION['admin_userid'];?> </td>
    <td colspan="3">Department........................<br>แผนก ................................</td>
  </tr>
  <tr>
    <td width="19%" rowspan="2"><center>OJT Title / หัวข้อที่สอบ</center></td>
    <td width="19%" rowspan="2"><center>Description / ลักษณะงาน</center></td>
    <td width="6%" rowspan="2"><center>Date / วันที่</center></td>
    <td colspan="2"><center>Time / เวลา</center></td>
    <td width="5%">Total Hrs.</td>
    <td colspan="2"><center>Signature / ลายเซ็น</center></td>
    <td colspan="2"><center>Overall Assessment</center></td>
  </tr>
  <tr>
    <td width="5%"><center>From/จาก</center></td>
    <td width="5%"><center>To/ถึง</center></td>
    <td ><center>ชั่วโมง</center></td>
    <td width="8%"><center>Employee พนักงาน</center></td>
    <td width="6%"><center>Coach ผู้สอน</center></td>
    <td width="3%"><center>Pass ผ่าน</center></td>
    <td width="3%"><center>Fail ไม่ผ่าน</center></td>
  </tr>
  <?
  $sql = "SELECT title.tra_id,title.tra_title,title.tra_desc,title.tra_form,title.tra_to FROM  tbtra_match match JOIN tbtra_title title ON match.tra_id = title.tra_id  WHERE  match.positionid = '".$_GET['dep']."'";
	$re=mssql_query($sql);
	$item = 1;
	while($row = mssql_fetch_assoc($re)){
  ?>
  <tr >
    <td height="20"><? echo $item.".".iconv("tis-620", "utf-8",$row['tra_title'])?></td>
    <td><? echo iconv("tis-620", "utf-8",$row['tra_desc'])?></td>
	<?
		$sql1 = "SELECT res.tra_res,res.tra_date FROM  tbtra_result res  WHERE   res.empno = '".$_GET['empno']."' AND tra_id = '".$row['tra_id']."'";
		$re1=mssql_query($sql1);
		$row1 = mssql_fetch_assoc($re1);
		$originalDate = explode('-',$row1['tra_date']);
		$newDate = date("d-m-Y", strtotime($originalDate[0]."-".$originalDate[1]."-".$originalDate[2]));
	?>
    <td><center><? echo $newDate?></center></td>
    <td><center><? echo $row['tra_form'].".00"?></center></td>
    <td><center><? echo $row['tra_to'].".00"?></center></td>
    <td><center><? echo $row['tra_to']-$row['tra_form']?></center></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
	<?
		if($row1['tra_res']=='1'){
			echo "<td><center>/</center></td><td></td>";
		}else{
			echo "<td></td><td><center>/</center></td>";
		}
	?>
    
  </tr>
  <?
	$item++;
	}
	$sql2 = "SELECT * FROM  tbtra_method  WHERE   empno = '".$_GET['empno']."'";
	$re2=mssql_query($sql2);
	$row2 = mssql_fetch_assoc($re2);
  ?>
   <tr>
    <td colspan="10" height="20"><b> Recommend / ข้อคิดเห็น : </b><? echo iconv("tis-620", "utf-8",$row2['recommend']);?></td>
  </tr>
  <tr>
    <td colspan="4" height="40">Approve By  (อนุมัติโดย) (GM)...............................................................................................................................................................................<br/>Position (ตำแหน่ง)...................................................................................................................................................................................................</td>
    <td colspan="6">&nbsp;<b> วิธีประเมินผลการฝึกอบรม : </b> [ <? if($row2['result1'] =='1'){echo "/";}else{echo "&nbsp;";}?> ] ทำข้อสอบ  &nbsp;&nbsp;&nbsp;[  <? if($row2['result2'] =='1'){echo "/";}else{echo "&nbsp;";}?> ]  ถาม - ตอบ<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[ <? if($row2['result3'] =='1'){echo "/";}else{echo "&nbsp;";}?> ]  ดูจากการทำงานจริง</td>
  </tr>
</table>
</div>


</body>
</html>
<?Php
$html = ob_get_contents();
ob_end_clean();
$pdf = new mPDF('th', 'A4-L', '0', '');
$footer = '<div style="font-size:11px;"><div style="margin-left:880px;">FM-HR-04 Rev.01: 20/8/16</div></div>';
$pdf->SetHTMLFooter($footer);
$pdf->SetAutoFont();
$pdf->SetDisplayMode('fullpage');
$pdf->WriteHTML($html, 2);
$pdf->Output($_GET['empno'].'.pdf', 'I');
?> 