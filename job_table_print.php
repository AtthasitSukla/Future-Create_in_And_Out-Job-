<?php 
session_start();
include("connect.php");
include("library.php");

$number = $_GET['number'];
$group_id= $_GET['group_id'];

$rec_group = get_rec_tbtra_group($group_id);
$empno = $rec_group['empno'];
$tra_date = $rec_group['tra_date'];
$tra_time1 = $rec_group['tra_time1'];
$tra_time2 = $rec_group['tra_time2'];
$coach = $rec_group['coach'];
$recommend = lang_thai_from_database($rec_group['recommend']);
$result1 = $rec_group['result1']==1?"<img src='images/icon/checkbox_checked.png' width='10px'>":"<img src='images/icon/checkbox.png' width='10px'>";
$result2 = $rec_group['result2']==1?"<img src='images/icon/checkbox_checked.png' width='10px'>":"<img src='images/icon/checkbox.png' width='10px'>";
$result3 = $rec_group['result3']==1?"<img src='images/icon/checkbox_checked.png' width='10px'>":"<img src='images/icon/checkbox.png' width='10px'>";

$tra_date_format = date_format_thai_from_databese($tra_date); // วันที่อบรม

$row_empno = get_rec_empno($empno);
$firstname = lang_thai_from_database($row_empno['firstname']);
$lastname = lang_thai_from_database($row_empno['lastname']);
$nickname = lang_thai_from_database($row_empno['nickname']);
$positionid = $row_empno['positionid'];
$positionname = get_positionname($positionid);
$departmentid = $row_empno['departmentid'];
$department = get_departmentname($departmentid);
$start_date = date_format_thai_from_databese($row_empno['startdate']);

$row_coach = get_rec_empno($coach);
$firstname_coach = lang_thai_from_database($row_coach['firstname']);
$lastname_coach = lang_thai_from_database($row_coach['lastname']);
$nickname_coach = lang_thai_from_database($row_coach['nickname']);
$positionid_coach = $row_coach['positionid'];
$positionname_coach = get_positionname($positionid_coach);
$departmentid_coach = $row_coach['departmentid'];
$department_coach = get_departmentname($departmentid_coach);

//get_positionname($positionid);
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
	font-size:12px;
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

<body class=" " onLoad="window.print();"> <!--  onLoad="window.print();" -->
<center><img src='images/ipacklogo.jpg' width="250px"><br><span id="header_under_logo">ON - THE - JOB TRAINING RECORD<br>แบบบันทึกการปฏิบัติงานในสถานที่จริง</span></center>
<p>Start Date: / เริ่มงานวันที่ : <?=$start_date?></p>
<table border=1 cellpadding="7" width='100%'>
	<tr>
		<td colspan='2'>Name of Employee : <?php echo $firstname." ".$lastname ?><br>ชื่อหนักงาน </td>
		<td colspan='4'>Position : <?=$positionname?><br>ตำแหน่ง  </td>
		<td >ID. <?=$empno?><br> รหัส</td>
		<td colspan='3'>Department : <?=$department?> <br>แผนก</td>
	</tr>
	<tr>
		<td colspan='2'>Name of Coach :   <?php echo $firstname_coach." ".$lastname_coach ?></td>
		<td colspan='4'>Position : <?=$positionname_coach?><br>ตำแหน่ง  </td>
		<td >ID. <?=$coach?><br> รหัส</td>
		<td colspan='3'>Department : <?=$department_coach?> <br>แผนก</td>
	</tr>
	<tr align="center">
		<td rowspan="2" width='250px'>OJT Title / หัวข้อที่สอน</td>
		<td rowspan="2" width='250px'>Description / ลักษณะงาน</td>
		<td rowspan="2">Date / วันที่</td>
		<td colspan="2">Time / เวลา</td>
		<td>Total Hrs.</td>
		<td colspan="2">Signature / ลายเซ็น</td>
		<td colspan="2">Overall Assessment</td>
	</tr>
	<tr align="center">
		<td>From / จาก</td>
		<td>To / ถึง</td>
		<td>ชั่วโมง</td>
		<td>Employee/พนักงาน</td>
		<td>Coach/ผู้สอน</td>
		<td>Pass/ผ่าน</td>
		<td>Fail/ไม่ผ่าน</td>
	</tr>
	<?php
	$i = 1;
	$sql_result = "SELECT * from tbtra_result  
					WHERE  group_id = '$group_id'";
	$res_reult=mssql_query($sql_result);
	while($row_result = mssql_fetch_array($res_reult)){
		$res_id = $row_result['res_id'];
		$tra_id = $row_result['tra_id'];
		$tra_res = $row_result['tra_res'];
		$remark = $row_result['remark'];
		switch($tra_res){
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
		$sql_train = "select * from tbtra_title where tra_id='$tra_id'";
		$res_train=mssql_query($sql_train);
		while($row_train = mssql_fetch_array($res_train)){
			$tra_title = lang_thai_from_database($row_train['tra_title']);
			$tra_desc = lang_thai_from_database($row_train['tra_desc']);
			//$tra_form = $row_train['tra_form'].".00";
//			$tra_to = $row_train['tra_to'].".00";
//			$hours = $row_train['tra_time'];
											$sqlg = "select * from tbtra_group where group_id='$group_id'";
                                            $reg = mssql_query($sqlg);
											$numg = mssql_num_rows($reg);
                                           	$rowg = mssql_fetch_array($reg);
											$tra_form = $rowg['tra_time1'];
											$tra_to = $rowg['tra_time2'];
											//	$hours = $tra_to-$tra_form; 
												$hours = TimeDiff($tra_form,$tra_to); 
	
		?>
		<tr >
			<td><?=$i.". ".$tra_title?></td>
			<td><?=$tra_desc?></td>
			<td align="center"><?=$tra_date_format?></td>
			<td align="center"><?=$tra_time1?></td>
			<td align="center"><?=$tra_time2?></td>
			<td align="center"><?=$hours?></td>
			<td></td>
			<td></td>
			<td align="center"><?=$check_pass?></td>
			<td align="center"><?=$check_fail?></td>
		</tr>
	<?php 
			$i++;
		}
	}
		?>
		<tr >
			<td colspan="10">Recommend / ข้อคิดเห็น : <?=$recommend?></td>
		</tr >	
		<tr >
			<td colspan="4">Approved By (อนุมัติโดย) GM :<br>Position (ตำแหน่ง)  :</td>
			<td colspan="6">วิธีการประเมินผล : <?=$result1?> ทำข้อสอบ <?=$result2?> ถาม-ตอบ  <?=$result3?> ดูจากสถานที่จริง</td>
		</tr >			
</table>
<br>
<div id='iso_doc'>FM-HR-04 Rev.01 : 20/8/16</div>




</body>
</html>