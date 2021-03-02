<? include("connect.php"); 
require_once('mpdf/mpdf.php');
ob_start();
$empno = $_GET['empno'];
$sql = "SELECT empno,firstname,lastname,positionname,startdate ,birthdate,basic_salary FROM  tbemployee JOIN tbposition ON tbemployee.positionid = tbposition.positionid WHERE empno = '$empno' ";
$re=mssql_query($sql);
$row=mssql_fetch_array($re);
//----------------
$sql = "select * from tbprobation where empno = ".$_REQUEST['empno'];
$re=mssql_query($sql);
$row_pro=mssql_fetch_array($re);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=UTF-8">
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=UTF-8">
<link rel="stylesheet" href="fonts.css" type="text/css" charset="utf-8" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>
<body>
<img src="images/logo_bill.gif" height="40" style="position:fixed;padding-left:250px"/>
<br>
<b><h3>แบบฟอร์มประเมินผลการปฏิบัติงานระยะทดลองงาน</h3></b>
<table width="100%" border=0 style="font-size:13px;">
	<tr>
		<th style="text-align: left;">ชื่อ - สกุล</th>
		<td id="full_name" style="text-align: left;">: <? echo iconv("tis-620", "utf-8", $row['firstname']).' '.iconv("tis-620", "utf-8", $row['lastname']); ?></td>
		<th style="text-align: left;">วุฒิการศึกษา</th>
		<td style="text-align: left;">: ............... <b> อายุ : </b><?php echo date("Y")-date("Y",strtotime($row['birthdate']));?> ปี</td>
	</tr>
	<tr>
		<th style="text-align: left;">ตำแหน่ง</th>
		<td id="position" style="text-align: left;"> : <? echo $row['positionname']; ?></td>
		<th style="text-align: left;">สังกัดแผนก/ฝ่าย</th>
		<td style="text-align: left;">: ...................................</td>
	</tr>
	<tr>
		<th style="text-align: left;">วันที่เริ่มงาน</th>
		<td id="startdate" style="text-align: left;">: <? echo date("d/m/Y",strtotime($row['startdate'])); ?></td>
		<th style="text-align: left;">อัตราเงินเดือน</th>
		<td id="salary" style="text-align: left;">: <? echo number_format((float)$row_pro['old_saraly'], 2, '.', ',')." บาท";?></td>
	</tr>
	<tr>
		<th style="text-align: left;">ระยะเวลาทดลองงาน</th>
		<td style="text-align: left;">: .....120 วัน.....</td>
		<th style="text-align: left;">วันครบทดลองงาน</th>
		<td id="pro_date" style="text-align: left;">: <? echo date("d/m/Y",strtotime("+4 months", strtotime($row['startdate']))); ?></td>
	</tr>
	<tr>
		<th style="text-align: left;">การมาทำงาน </th>
		<td colspan="3" id='leave'style="text-align: left;">: <? echo "สาย ".$row_pro['late']." ครั้ง&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ลากิจ ".$row_pro['private']." วัน&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ลาป่วย ".$row_pro['sick']." วัน&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ขาดงาน ".$row_pro['absence']." วัน"?></td>

	</tr>
</table  >
<table width="100%" border="1" style="border: 1px solid black;border-collapse: collapse;font-size:13px;">
<tr>
		<th width="25%" height="45">หัวข้อพิจารณา</th>
		<th width="6%">ดีมาก<br>5</th>
		<th width="6%">ดี<br>4</th>
		<th width="6%">พอใช้<br>3</th>
		<th width="9%">ต้องปรับปรุง<br>2</th>
		<th width="9%">ไม่ผ่านเกณฑ์<br>1</th>
		<th width="19%">หมายเหตุ</th>
	</tr>
	<tr>
		<td height="25">&nbsp;&nbsp;&nbsp;1. การตรงต่อเวลา</td>
		<td style="text-align: center;"><? if($row_pro['title1'] == '5'){echo '/';}?></td>
		<td style="text-align: center;"><? if($row_pro['title1'] == '4'){echo '/';}?></td>
		<td style="text-align: center;"><? if($row_pro['title1'] == '3'){echo '/';}?></td>
		<td style="text-align: center;"><? if($row_pro['title1'] == '2'){echo '/';}?></td>
		<td style="text-align: center;"><? if($row_pro['title1'] == '1'){echo '/';}?></td>
		<td ><? echo iconv("tis-620", "utf-8", $row_pro['note1']);?></td>
	</tr>
	<tr>
		<td height="25">&nbsp;&nbsp;&nbsp;2. ความรู้เกี่ยวกับงาน</td>
		<td style="text-align: center;"><? if($row_pro['title2'] == '5'){echo '/';}?></td>
		<td style="text-align: center;"><? if($row_pro['title2'] == '4'){echo '/';}?></td>
		<td style="text-align: center;"><? if($row_pro['title2'] == '3'){echo '/';}?></td>
		<td style="text-align: center;"><? if($row_pro['title2'] == '2'){echo '/';}?></td>
		<td style="text-align: center;"><? if($row_pro['title2'] == '1'){echo '/';}?></td>
		<td ><? echo iconv("tis-620", "utf-8", $row_pro['note2']);?></td>
	</tr>
	<tr>
		<td height="25">&nbsp;&nbsp;&nbsp;3. ความคิดริเริ่ม</td>
		<td style="text-align: center;"><? if($row_pro['title3'] == '5'){echo '/';}?></td>
		<td style="text-align: center;"><? if($row_pro['title3'] == '4'){echo '/';}?></td>
		<td style="text-align: center;"><? if($row_pro['title3'] == '3'){echo '/';}?></td>
		<td style="text-align: center;"><? if($row_pro['title3'] == '2'){echo '/';}?></td>
		<td style="text-align: center;"><? if($row_pro['title3'] == '1'){echo '/';}?></td>
		<td ><? echo iconv("tis-620", "utf-8", $row_pro['note3']);?></td>
	</tr>
	<tr>
		<td height="25">&nbsp;&nbsp;&nbsp;4. ความสามารถในการทำงานรวมกับผู้อื่น</td>
		<td style="text-align: center;"><? if($row_pro['title4'] == '5'){echo '/';}?></td>
		<td style="text-align: center;"><? if($row_pro['title4'] == '4'){echo '/';}?></td>
		<td style="text-align: center;"><? if($row_pro['title4'] == '3'){echo '/';}?></td>
		<td style="text-align: center;"><? if($row_pro['title4'] == '2'){echo '/';}?></td>
		<td style="text-align: center;"><? if($row_pro['title4'] == '1'){echo '/';}?></td>
		<td ><? echo iconv("tis-620", "utf-8", $row_pro['note4']);?></td>
	</tr>
	<tr>
		<td height="25">&nbsp;&nbsp;&nbsp;5. การปฏิบัติตามคำสั่งของผู้บังคับบัญชา</td>
		<td style="text-align: center;"><? if($row_pro['title5'] == '5'){echo '/';}?></td>
		<td style="text-align: center;"><? if($row_pro['title5'] == '4'){echo '/';}?></td>
		<td style="text-align: center;"><? if($row_pro['title5'] == '3'){echo '/';}?></td>
		<td style="text-align: center;"><? if($row_pro['title5'] == '2'){echo '/';}?></td>
		<td style="text-align: center;"><? if($row_pro['title5'] == '1'){echo '/';}?></td>
		<td ><? echo iconv("tis-620", "utf-8", $row_pro['note5']);?></td>
	</tr>
	<tr>
		<td height="25">&nbsp;&nbsp;&nbsp;6. ความสามารถในการเรียนรู้ การรับมอบงาน</td>
		<td style="text-align: center;"><? if($row_pro['title6'] == '5'){echo '/';}?></td>
		<td style="text-align: center;"><? if($row_pro['title6'] == '4'){echo '/';}?></td>
		<td style="text-align: center;"><? if($row_pro['title6'] == '3'){echo '/';}?></td>
		<td style="text-align: center;"><? if($row_pro['title6'] == '2'){echo '/';}?></td>
		<td style="text-align: center;"><? if($row_pro['title6'] == '1'){echo '/';}?></td>
		<td ><? echo iconv("tis-620", "utf-8", $row_pro['note6']);?></td>
	</tr>
	<tr>
		<td height="25">&nbsp;&nbsp;&nbsp;7. คุณภาพของงานที่ทำได้</td>
		<td style="text-align: center;"><? if($row_pro['title7'] == '5'){echo '/';}?></td>
		<td style="text-align: center;"><? if($row_pro['title7'] == '4'){echo '/';}?></td>
		<td style="text-align: center;"><? if($row_pro['title7'] == '3'){echo '/';}?></td>
		<td style="text-align: center;"><? if($row_pro['title7'] == '2'){echo '/';}?></td>
		<td style="text-align: center;"><? if($row_pro['title7'] == '1'){echo '/';}?></td>
		<td ><? echo iconv("tis-620", "utf-8", $row_pro['note7']);?></td>
	</tr>
	<tr>
		<td height="25">&nbsp;&nbsp;&nbsp;8. ความรับผิดชอบ</td>
		<td style="text-align: center;"><? if($row_pro['title8'] == '5'){echo '/';}?></td>
		<td style="text-align: center;"><? if($row_pro['title8'] == '4'){echo '/';}?></td>
		<td style="text-align: center;"><? if($row_pro['title8'] == '3'){echo '/';}?></td>
		<td style="text-align: center;"><? if($row_pro['title8'] == '2'){echo '/';}?></td>
		<td style="text-align: center;"><? if($row_pro['title8'] == '1'){echo '/';}?></td>
		<td ><? echo iconv("tis-620", "utf-8", $row_pro['note8']);?></td>
	</tr>
	<tr>
		<td height="25">&nbsp;&nbsp;&nbsp;9. การแก้ปัญหา และการตัดสินใจ</td>
		<td style="text-align: center;"><? if($row_pro['title9'] == '5'){echo '/';}?></td>
		<td style="text-align: center;"><? if($row_pro['title9'] == '4'){echo '/';}?></td>
		<td style="text-align: center;"><? if($row_pro['title9'] == '3'){echo '/';}?></td>
		<td style="text-align: center;"><? if($row_pro['title9'] == '2'){echo '/';}?></td>
		<td style="text-align: center;"><? if($row_pro['title9'] == '1'){echo '/';}?></td>
		<td ><? echo iconv("tis-620", "utf-8", $row_pro['note9']);?></td>
	</tr>
	<tr>
		<td height="25">&nbsp;&nbsp;&nbsp;10. ทัศนคติต่อการทำงาน ต่อเพื่อนร่วมงาน ต่อบริษัท</td>
		<td style="text-align: center;"><? if($row_pro['title10'] == '5'){echo '/';}?></td>
		<td style="text-align: center;"><? if($row_pro['title10'] == '4'){echo '/';}?></td>
		<td style="text-align: center;"><? if($row_pro['title10'] == '3'){echo '/';}?></td>
		<td style="text-align: center;"><? if($row_pro['title10'] == '2'){echo '/';}?></td>
		<td style="text-align: center;"><? if($row_pro['title10'] == '1'){echo '/';}?></td>
		<td ><? echo iconv("tis-620", "utf-8", $row_pro['note10']);?></td>
	</tr>
</table>
<br><br><div style="font-size:13px;"><b>ความคิดเห็นเพิ่มเติมของผู้ประเมิน</b> <? echo iconv("tis-620", "utf-8", $row_pro['recomend']);?>
<br/><br/>
								<b>สรุปผลการประเมิน</b>&nbsp;<? if($row_pro['result'] == '0'){echo '[ / ]';}else{echo '[&nbsp;&nbsp;&nbsp;]';}?> ไม่ผ่านการทดลองงาน &nbsp;<? if($row_pro['result'] == '1'){echo '[ / ]';}else{echo '[&nbsp;&nbsp;&nbsp;]';}?> ผ่านการทดลองงาน<br/>
								<? if($row_pro['result'] == '3') {?>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<? if($row_pro['result'] == '3'){echo '[ / ]';}else{echo '[&nbsp;&nbsp;&nbsp;]';}?> เสนอพิจารณาปรับเงินเดือนจาก <? echo number_format((float)$row_pro['old_saraly'], 2, '.', ',');?> เป็น <? echo number_format((float)$row_pro['new_saraly'], 2, '.', ',');?><br/>
								<?}else{?>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<? if($row_pro['result'] == '3'){echo '[ / ]';}else{echo '[&nbsp;&nbsp;&nbsp;]';}?> เสนอพิจารณาปรับเงินเดือนจาก ........................... เป็น  ...........................<br/>
								<?} ?>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<? if($row_pro['result'] == '2'){echo '[ / ]';}else{echo '[&nbsp;&nbsp;&nbsp;]';}?> ยังไม่ควรปรับ
			</div>

</body>
</html>
<?Php
$html = ob_get_contents();
ob_end_clean();
$pdf = new mPDF('th', 'A4', '0', '');
$footer = '<div style="font-size:13px;">
			<table width="100%" border="1" style="border: 1px solid black;border-collapse: collapse;">
				<tr>
					<td>
						<center><br>
						(1) ลงชื่อ.........................................................ผู้ถูกประเมิน<br><br>
						(......................................................)<br><br>
						ตำแหน่ง..........'.$row['positionname'].'..........<br><br>
						วันที่.............../.............../...............
						</center>
					</td>

					<td>
						<center><br>
						(2) ความเห็น......................................................<br><br>
						&nbsp;&nbsp;&nbsp;&nbsp;....................................................................<br><br>
						&nbsp;&nbsp;&nbsp;&nbsp;ลงชื่อ.........................................................<br><br>
						&nbsp;&nbsp;&nbsp;วันที่.............../.............../...............
						</center>
					</td>
				</tr>
				<tr>
					<td>
						<center><br>
						(1) ลงชื่อ.............................................................ผู้ประเมิน<br><br>
						(......................................................)<br><br>
						ตำแหน่ง......................................................<br><br>
						วันที่.............../.............../...............
						</center>
					</td>

					<td>
						<center><br>
						(2) ความเห็น......................................................<br><br>
						&nbsp;&nbsp;&nbsp;&nbsp;....................................................................<br><br>
						&nbsp;&nbsp;&nbsp;&nbsp;ลงชื่อ.........................................................<br><br>
						&nbsp;&nbsp;&nbsp;วันที่.............../.............../...............
						</center>
					</td>
				</tr>
			</table><br/><div style="margin-left:450px;">รับคืนวันที่.............../.............../...............</div><br/><br/><br/>
		   <div style="margin-left:530px;">FM-HR-05 Rev.01: 13/6/16</div></div>';
$pdf->SetHTMLFooter($footer);
$pdf->SetAutoFont();
$pdf->SetDisplayMode('fullpage');
$pdf->WriteHTML($html, 2);
$pdf->Output($_GET['empno'].'.pdf', 'I');
?> 