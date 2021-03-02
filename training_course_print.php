<?php
session_start();
include("connect.php");
include("library.php");
$course_id = $_GET['course_id'];
$sql = "select * from tbcourse_list where course_id='$course_id'";
$res = mssql_query($sql);
$row = mssql_fetch_array($res);
$course_title = lang_thai_from_database($row['course_title']);
$coach = lang_thai_from_database($row['coach']);
$institution = lang_thai_from_database($row['institution']);
$start_date = date_format_thai_from_databese($row['start_date']);
$end_date = date_format_thai_from_databese($row['end_date']);
$place = lang_thai_from_database($row['place']);
$time = $row['time'];
$result1 = $row['result1']==1?"<img src='images/icon/checkbox_checked.png' width='10px'>":"<img src='images/icon/checkbox.png' width='10px'>";
$result2 = $row['result2']==1?"<img src='images/icon/checkbox_checked.png' width='10px'>":"<img src='images/icon/checkbox.png' width='10px'>";
$result3 = $row['result3']==1?"<img src='images/icon/checkbox_checked.png' width='10px'>":"<img src='images/icon/checkbox.png' width='10px'>";
$result4 = $row['result4']==1?"<img src='images/icon/checkbox_checked.png' width='10px'>":"<img src='images/icon/checkbox.png' width='10px'>";
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>HRS : JOB TRAINING</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="I-Wis">
	<meta name="author" content="The Red Team">

  
<!--link rel="stylesheet" type="text/css" href="assets/css/multi-select.css"-->
<script type="text/javascript" src="assets/js/jquery-1.10.2.min.js"></script>
<style>
body{
	font-size:14px;
}
#header_under_logo{
	font-size:18px;
}
table {
    border-collapse: collapse;
	
}
#iso_doc {
    float: right;
    width: 150px;
	font-size:10px;
}
</style>
<script>

$(function() {
	var d = new Date();
		    var toDay = d.getDate() + '/'
        + (d.getMonth() + 1) + '/'
        + (d.getFullYear() + 543);
	
	
	
});

</script>
</head>

<body class=" " onLoad="window.print();" > <!--  onLoad="window.print();" -->
<center><img src='images/ipacklogo.jpg' width="250px"><br><span id="header_under_logo">ใบลงทะเบียนการฝึกอบรม</span></center>
<br>
<table border=1 cellpadding="7" width='100%'>
	<tr >
		
		<td colspan="3">หัวข้อการฝึกอบรม <?=$course_title?><br>วิทยากร <?=$coach?><br>สถาบัน <?=$institution?></td>
		<td colspan="4">วันที่ฝึกอบรม <?=$start_date." - ".$end_date?><br>สถานที่อบรม <?=$place?><br>เวลา <?=$time?></td>
		
	</tr>
	<tr >
		<th rowspan="2" width='40px'>ลำดับ</th>
		<th rowspan="2" width='80px'>หน่วยงาน</th>
		<th rowspan="2" width='250px'>ชื่อ - สกุล</th>
		<th colspan="2">ผลการประเมิน</th>
		<th rowspan="2">ลายเซ็น</th>
		<th rowspan="2">หมายเหตุ</th>
	</tr>
	<tr >
		
		<th>ผ่าน</th>
		<th>ไม่ผ่าน</th>
		
	</tr>
	<?php
										$i = 1;
										$sql_result = "SELECT * from tbcourse_result  
										WHERE  course_id = '$course_id'";
										$res_reult=mssql_query($sql_result);
										while($row_result = mssql_fetch_array($res_reult)){
											$result_id  = $row_result['result_id'];
											$empno = $row_result['empno'];
											$result = $row_result['result'];
											$remark = $row_result['remark'];
											
											$row_empno = get_rec_empno($empno);
											$firstname = lang_thai_from_database($row_empno['firstname']);
											$lastname = lang_thai_from_database($row_empno['lastname']);
											$site = $row_empno['site'];
											
											switch($result){
												case 0 : 
													$check_pass ="";
													$check_fail="";
													break;
												case 1 : 
													$check_pass="<img src='images/icon/ok.png' width='10px'>";
													$check_fail="";
													break;
												case 2 : 
													$check_pass ="";
													$check_fail="<img src='images/icon/ok.png' width='10px'>";
													break;
											}
										 
											?>
											
												<tr id="<?=$result_id?>">
													
													<td><center><?=$i?></center></td>
													<td><center><?=$site ?></center></td>
													<td><?=$firstname." ".$lastname ?></td>
													<td><center><?=$check_pass?></center></td>
													<td><center><?=$check_fail?></center></td>
													<td></td>
													<td><?=$remark?></td>
												</tr>
										
									<?php
											
											$i++;
										}
										while($i<21){ //ตีตารางเผื่อ เพื่อความสวยงาม
											?>
											<tr id="">
													
												<td><center><?=$i?></center></td>
												<td><center></center></td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
											</tr>
										<?php $i++;
										}
									?>
							<tr>
								<td colspan="7">วิธีการประเมิน : <?=$result1?> ทำแบบทดสอบ <?=$result2?>  การซัก - ถามจากวิทยากร <?=$result3?> เขียนรายงานอบรม <?=$result4?> ระยะเวลาเข้าฝึกอบรม
											<br>(ทำเครื่องหมายถูกหน้าช่องว่าประเมินแบบใด)</td>
							</tr>

</table>
<br>
<div id='iso_doc'>FM-HR-06 rev.00 : 20/9/2015</div>




</body>
</html>