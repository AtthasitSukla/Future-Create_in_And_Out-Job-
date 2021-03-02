<?
include("connect.php");

$status = $_REQUEST['status'];
$date_time=date("m/d/Y H:i:s");
$data = array();
//$_SESSION['admin_userid'];

if($status=='T'){
	$search = @$_POST["search"]["value"];
	if(strlen($search)){
		$search =  iconv("utf-8","tis-620", $search);
		$sql = "SELECT * FROM  tbtra_title WHERE tra_title LIKE '%$search%' OR tra_desc LIKE '%$search%' ORDER BY tra_id DESC";
	}else{
		$sql = "SELECT * FROM  tbtra_title ORDER BY tra_id DESC";
	}
	//echo $sql;
	$re=mssql_query($sql);
	$item = 1;
	while($row=mssql_fetch_array($re)){
		$row_array["item"] = $item;
		$row_array["title"] = iconv("tis-620", "utf-8", $row['tra_title']);
		$row_array["desc"] = iconv("tis-620", "utf-8", $row['tra_desc']);
		$row_array["tra_from"] = $row['tra_form'].'.00';
		$row_array["tra_to"] = $row['tra_to'].'.00';
		$row_array["tra_total"] = $row['tra_to']-$row['tra_form'];
		$row_array["edit"] = '<center><i class="fa fa-pencil-square-o fa-2x" aria-hidden="true" onclick="add_title('.$row["tra_id"].')"></i></center>';
		
		array_push($data,$row_array);
		$item++;
	}
	
	echo json_encode(array('data'=>$data));
}

if($status=='I'){
	$name = iconv("utf-8","tis-620", $_REQUEST['title_name']);
	$desc = iconv("utf-8","tis-620", $_REQUEST['title_desc']);
	$dep = $_REQUEST['sl_dep'];
	$tra_s = $_REQUEST['time_start'];
	$tra_e = $_REQUEST['time_end'];
	$sql = "INSERT INTO tbtra_title (tra_title, tra_desc, tra_form, tra_to)";
	$sql .= " VALUES('".$name."', '".$desc."', '".$tra_s."', '".$tra_e."') SELECT @@IDENTITY AS last_id";
	$res = mssql_query($sql);
	$row = mssql_fetch_array($res);
	$last_id = $row['last_id'];
	if($dep > '0'){
		$sql = "INSERT INTO tbtra_match (tra_id, positionid)";
		$sql .= " VALUES('".$last_id."', '".$dep."') ";
		mssql_query($sql);
	}
	echo "1";
}
if($status=='R'){
	$type = $_POST['type'];
	$id = $_POST['id'];
	if($type = "tbtra_title"){
		if($id>0){
			$sql = "SELECT * FROM  tbtra_title WHERE tra_id = $id";
			$res = mssql_query($sql);
			$row = mssql_fetch_array($res);
			$row_array["tra_id"] = iconv("tis-620", "utf-8", $row['tra_id']);
			$row_array["tra_title"] = iconv("tis-620", "utf-8", $row['tra_title']);
			$row_array["tra_desc"] = iconv("tis-620", "utf-8", $row['tra_desc']);
			$row_array["tra_form"] = iconv("tis-620", "utf-8", $row['tra_form']);
			$row_array["tra_to"] = iconv("tis-620", "utf-8", $row['tra_to']);
			$data = $row_array;
		}else{
			$sql = "SELECT * FROM  tbtra_title ";
			$re=mssql_query($sql);
			while($row=mssql_fetch_array($re)){
				$row_array["tra_id"] = iconv("tis-620", "utf-8", $row['tra_id']);
				$row_array["tra_title"] = iconv("tis-620", "utf-8", $row['tra_title']);
				$row_array["tra_desc"] = iconv("tis-620", "utf-8", $row['tra_desc']);
				$row_array["tra_form"] = iconv("tis-620", "utf-8", $row['tra_form']);
				$row_array["tra_to"] = iconv("tis-620", "utf-8", $row['tra_to']);
				
				array_push($data,$row_array);
			}
		}
	}
	echo json_encode(array('data'=>$data));
}
if($status=='U'){
	$title_id = $_POST['title_id'];
	$name = iconv("utf-8","tis-620", $_REQUEST['title_name']);
	$desc = iconv("utf-8","tis-620", $_REQUEST['title_desc']);
	$dep = $_REQUEST['sl_dep'];
	$tra_s = $_REQUEST['time_start'];
	$tra_e = $_REQUEST['time_end'];
	$sql = "UPDATE tbtra_title SET tra_title ='".$name."', tra_desc ='".$desc."', tra_form='".$tra_s."', tra_to='".$tra_e."' WHERE tra_id = $title_id";
	mssql_query($sql);
	echo "1";
}
if($status=='X'){
	$depid = $_POST['depid'];
	$sql = "SELECT tra_id FROM tbtra_match WHERE positionid = '$depid'";
	$re=mssql_query($sql);
	while($row=mssql_fetch_array($re)){
		array_push($data,$row['tra_id']);
	}
	echo json_encode(array('data'=>$data));
}
if($status=='Y'){
	if($_POST['type'] == 'add'){
		$sql = "INSERT INTO tbtra_match (tra_id, positionid)";
		$sql .= " VALUES('".$_POST['title'][0]."', '".$_POST['depid']."') ";
		mssql_query($sql);
	}else{
		$sql = "DELETE FROM tbtra_match WHERE tra_id = '".$_POST['title'][0]."'AND positionid = '".$_POST['depid']."'";
		mssql_query($sql);
	}
}
if($status=='Y_all'){
	if($_POST['type'] == 'add'){
		$titles = $_REQUEST['titles'];
		for($i=0;$i<sizeof($titles);$i++){
				
		$sql = "INSERT INTO tbtra_match (tra_id, positionid)";
		$sql .= " VALUES('".$titles[$i]."', '".$_POST['depid']."') ";
		mssql_query($sql);
		//echo $sql;
		//echo "<BR>";
			}
	
	}else{
		$sql = "DELETE FROM tbtra_match WHERE  positionid = '".$_POST['depid']."' ";
		mssql_query($sql);
	}
}
if($status=='B'){
	$result = array();
	
	$search = @$_POST["search"]["value"];
	if(strlen($search)){
		$search =  iconv("utf-8","tis-620", $search);
		$sql = "SELECT * FROM  tbtra_title WHERE  ORDER BY tra_id DESC";
		$select="select emp.empno as empno,emp.firstname as firstname, emp.lastname as lastname, emp.nickname as nickname,pos.positionname as positionname,pos.positionid as positionid from tbemployee emp JOIN tbleave_control ctl ON emp.empno = ctl.emp_under JOIN tbposition pos ON emp.positionid = pos.positionid where ctl.emp_control = '".$_SESSION['admin_userid']."' AND (empno LIKE '%$search%' OR firstname LIKE '%$search%' OR lastname LIKE '%$search%' OR nickname LIKE '%$search%') ORDER BY emp.id DESC";
	}else{
		$select="select emp.empno as empno,emp.firstname as firstname, emp.lastname as lastname, emp.nickname as nickname,pos.positionname as positionname,pos.positionid as positionid from tbemployee emp JOIN tbleave_control ctl ON emp.empno = ctl.emp_under JOIN tbposition pos ON emp.positionid = pos.positionid where ctl.emp_control = '".$_SESSION['admin_userid']."' ORDER BY emp.id DESC";
	}
	
	
	$re=mssql_query($select);
	$item = 1;
	while($row = mssql_fetch_assoc($re)){
		$empno = $row['empno'];
		$sql_gruop = "select * from tbtra_group where empno='$empno'  order by tra_date";
		$res_gruop = mssql_query($sql_gruop);
		$found = mssql_num_rows($res_gruop);
		$number_train= "";
		if($found > 0){
			$i=1;
			while($row_group = mssql_fetch_array($res_gruop)){
				$group_id = $row_group['group_id'];
				$tra_date  = $row_group['tra_date'];
				$coach = $row_group['coach'];
				/*$sql_trainer = "select tra_empno from tbtra_result where tra_date='$tra_date' and empno='$empno'";
				$res_trainer = mssql_query($sql_trainer);
				$row_trainer = mssql_fetch_array($res_trainer);
				$tra_empno = $row_trainer['tra_empno'];*/
				$number_train .= "<a href='job_table.php?number=$i&group_id=$group_id' target='_blank'> No.$i </a>/";
				$i++;
			}
		}else{
			$number_train = "";
		}
		
		
		$row_array['item']   = $item;
		$row_array['empno']   = $row['empno'];
		$row_array['name']   = iconv("tis-620", "utf-8",$row['firstname'])." ".iconv("tis-620", "utf-8",$row['lastname'])." (".iconv("tis-620", "utf-8",$row['nickname']).") $number_train";
		$row_array['positionname']   = iconv("tis-620", "utf-8",$row['positionname']);
		$row_array['html']   = '<center><a href="job_show_emp.php?type=1&empno='.$row['empno'].'&dep='.$row['positionid'].'" target="_blank"><i class="fa fa-pencil-square-o fa-lg" aria-hidden="true"></i></a>';
		$row_array['add']   = '<center><a href="job_add.php?empno='.$row['empno'].'&positionid='.$row['positionid'].'"  class="btn btn-primary" target="_blank">สร้าง</a>';
		array_push($result, $row_array);
		$item++;
	}
	echo json_encode(array('data'=>$result));
}
if($status=='C'){
	$result = array();
	$sql = "SELECT title.tra_id,title.tra_title,title.tra_desc,title.tra_form,title.tra_to FROM  tbtra_match match JOIN tbtra_title title ON match.tra_id = title.tra_id  WHERE  match.positionid = '".$_POST['dep']."'";
	$re=mssql_query($sql);
	$item = 1;
	while($row = mssql_fetch_assoc($re)){
		$row_array['item']   = $item;
		$row_array['tra_id']   = $row['tra_id'];
		$row_array['tra_title']   = iconv("tis-620", "utf-8",$row['tra_title']);
		$row_array['tra_desc']   = iconv("tis-620", "utf-8",$row['tra_desc']);
		$row_array['tra_form']   = $row['tra_form'];
		$row_array['tra_to']   = $row['tra_to'];
		$row_array['total']   = $row['tra_to']-$row['tra_form'];
		//$sql = "SELECT res.tra_res,res.tra_date FROM  tbtra_result res  WHERE   res.empno = '".$_POST['empno']."' AND tra_id = '".$row['tra_id']."'";
		//$row_array['sql']   = $sql;
		$sql1 = "SELECT res.tra_res,res.tra_date FROM  tbtra_result res  WHERE   res.empno = '".$_POST['empno']."' AND tra_id = '".$row['tra_id']."'";
		$re1=mssql_query($sql1);
		$num1=mssql_num_rows($re1);
		if($num1 > 0){
			while($row1 = mssql_fetch_assoc($re1)){
				$row_array['tra_res']   = $row1['tra_res'];
				$originalDate = explode('-',$row1['tra_date']);
				$newDate = date("d-m-Y", strtotime($originalDate[0]."-".$originalDate[1]."-".$originalDate[2]));
				$row_array['tra_date']   = $newDate;
				$row_array['type']   = 1;
			}
		}else{
			$row_array['tra_res']   = '';
			$row_array['tra_date']   = '';
			$row_array['type']   = 0;
		}
		
		array_push($result, $row_array);
		$item++;
	}
	$sql = "SELECT * FROM  tbtra_method  WHERE   empno = '".$_POST['empno']."'";
	$re=mssql_query($sql);
	$num=mssql_num_rows($re);
	$method = array();
	if($num > 0){
		$row = mssql_fetch_assoc($re);
		$method['method1'] = $row['result1'];
		$method['method2'] = $row['result2'];
		$method['method3'] = $row['result3'];
		$method['recommend'] = iconv("tis-620", "utf-8",$row['recommend']);
		$method['type']   = 1;
	}else{
		$method['method1']   = '';
		$method['method2']   = '';
		$method['method3']   = '';
		$method['recommend']   = '';
		$method['type']   = 0;
	}
	echo json_encode(array('data'=>$result,'method'=>$method));
}
if($status=='A'){
	if($_POST['method_type'] == '0'){
		$sql = "INSERT INTO tbtra_method (empno, result1,result2,result3,recommend)";
		$sql .= " VALUES('".$_POST['empno']."', '".$_REQUEST['method1']."', '".$_REQUEST['method2']."', '".$_REQUEST['method3']."', '".iconv("utf-8","tis-620",$_REQUEST['recommend'])."') ";
		mssql_query($sql);
	}else{
		$sql = "UPDATE tbtra_method SET result1 = '".$_REQUEST['method1']."',result2 = '".$_REQUEST['method2']."',result3 = '".$_REQUEST['method3']."',recommend = '".iconv("utf-8","tis-620",$_REQUEST['recommend'])."' WHERE empno = '".$_POST['empno']."'";
		mssql_query($sql);
	}
	//echo $sql;
	
	for($i = 0;$i<count($_POST['tra_date']);$i++){
		if($_POST['type'][$i] == '0'){
			$r = $i+1;
			$originalDate = explode('-',$_POST['tra_date'][$i]);
			$newDate = date("Y-m-d", strtotime($originalDate[2]."/".$originalDate[1]."/".$originalDate[0]));
			$sql = "INSERT INTO tbtra_result (empno, tra_id,tra_res,tra_date)";
			$sql .= " VALUES('".$_POST['empno']."', '".$_POST['tra_id'][$i]."','".$_REQUEST["tra_res$r"]."','".$newDate."') ";
			mssql_query($sql);
		}else{
			$r = $i+1;
			$originalDate = explode('-',$_POST['tra_date'][$i]);
			$newDate = date("Y-m-d", strtotime($originalDate[2]."/".$originalDate[1]."/".$originalDate[0]));
			$sql = "UPDATE tbtra_result SET tra_res = '".$_REQUEST["tra_res$r"]."',tra_date = '".$newDate."' WHERE empno = '".$_POST['empno']."' AND tra_id = '".$_POST['tra_id'][$i]."'";
			mssql_query($sql);
		}
	}
	
	
	echo "1";
	
}

if($status=="add_train_each_empno"){
	$empno = $_REQUEST['empno'];
	$coach = $_REQUEST['trainer'];
	$train_date = $_REQUEST['train_date'];
	$tra_checkbox = $_REQUEST['tra_checkbox'];//tra_id is array
	$tra_res = $_REQUEST['tra_res'];
	$train_date = explode("/",$train_date);
	$train_date = $train_date[1]."/".$train_date[0]."/".((int)$train_date[2]-543);
	
	
	$sql_found = "select * from tbtra_group where empno='$empno' and tra_date='$train_date'";
	$res_found = mssql_query($sql_found);
	$found = mssql_num_rows($res_found);
	if($found>0){
		$row_group = mssql_fetch_array($res_found);
		$group_id = $row_group['group_id'];
		$sql_g = "update tbtra_group set coach='$coach' where group_id='$group_id'";
		mssql_query($sql_g);
		
	}else{
		$sql_g = "insert into tbtra_group (empno,coach,tra_date,result1,result2,result3)
									values ('$empno','$coach','$train_date','0','0','0')";
		mssql_query($sql_g);
		$sql_last_g = "SELECT @@IDENTITY AS group_id";
		$res_last_g = mssql_query($sql_last_g);
		$row_last_g = mssql_fetch_array($res_last_g);
		$group_id = $row_last_g['group_id'];
	}
	
	
	foreach($tra_checkbox as $key => $n){
		//$tra_ress=$tra_res[$key];
		
		$sql_found = "select * from tbtra_result where group_id='$group_id' and tra_id='$n'";
		$res_found = mssql_query($sql_found);
		$found = mssql_num_rows($res_found);
		if($found>0){
			/*$sql = "update tbtra_result 
					set tra_empno='$coach' 
					where empno='$empno' and tra_id='$n' and tra_date='$train_date'";
			mssql_query($sql);*/
			//echo 1;
		}else{
			
			$sql = "insert into tbtra_result (tra_id,tra_res,group_id)
						values ('$n','$tra_res','$group_id')";
			mssql_query($sql);
			//echo 2;
		}
		//echo $tra_res;
		
	}
	
	/******* ลบตัวที่ไม่ได้ส่งเข้ามา ********/
	$sql_form = "select * from tbtra_result where group_id='$group_id' "; 
	$res_form = mssql_query($sql_form);
	$found = mssql_num_rows($res_form);
	if($found>0){
		while($row_form = mssql_fetch_array($res_form)){
			$res_id = $row_form['res_id'];
			$tra_id = $row_form['tra_id'];
			if (in_array($tra_id, $tra_checkbox)){
				//echo 1;
			}else{
				$sql_del = "delete from tbtra_result where res_id='$res_id'";
				mssql_query($sql_del);
			}
			
		}
	}
	 echo 1;
}


if($status=="select_train_date"){
	
	?>
	<p><b>หัวข้อที่อบรม</b></p><br>
	<div class='row'>
		<b>
		<div class='col-sm-1'>
			<center>เลือก</center>
		</div>
		
		<div class='col-sm-4'>
			OJT Title / หัวข้อที่สอน
		</div>
		<div class='col-sm-4'>
			Description / ลักษณะงาน
		</div>
		<div class='col-sm-1'>
			Form / จาก
		</div>
		<div class='col-sm-1'>
			To / ถึง
		</div>
		<div class='col-sm-1'>
			ชั่วโมง
		</div>
		
		</b>
	</div>
	<hr>
<?php
	$empno = $_REQUEST['empno'];
	$train_date = $_REQUEST['train_date'];
	$train_date = explode("/",$train_date);
	$train_date = $train_date[1]."/".$train_date[0]."/".((int)$train_date[2]-543);
	$sql_found = "select * from tbtra_group where empno='$empno' and tra_date='$train_date'";
	$res_found = mssql_query($sql_found);
	$found = mssql_num_rows($res_found);
	if($found>0){
		$row_group = mssql_fetch_array($res_found);
		$group_id = $row_group['group_id'];
		$coach = $row_group['coach'];
		
		$sql = "select * from tbtra_result where group_id='$group_id' ";
		$res = mssql_query($sql);
		$found = mssql_num_rows($res);
		if($found > 0 ){
			while($row = mssql_fetch_array($res)){
				$tra_id = $row['tra_id'];
				$tra_res = $row['tra_res'];
				
				$sql_title = "select * from tbtra_title where tra_id='$tra_id'";
				$res_title = mssql_query($sql_title);
				while($row2 = mssql_fetch_array($res_title)){
					$tra_title = iconv("tis-620", "utf-8",$row2['tra_title']);
					$tra_desc = iconv("tis-620", "utf-8",$row2['tra_desc']);
					$tra_form = $row2['tra_form'].".00";
					$tra_to = $row2['tra_to'].".00";
					$hours = $tra_to-$tra_form; 
					
					
					switch($tra_res){
						case 0 : 
							$check_pass ="";
							$check_fail="";
							break;
						case 1 : 
							$check_pass="checked";
							$check_fail="";
							break;
						case 2 : 
							$check_pass ="";
							$check_fail="checked";
							break;
					}
					?>
						
						<div id="num_<?=$tra_id?>">
							<div class='col-sm-1 ' id="checkbox_<?=$tra_id?>">
								<center><input type="checkbox" onclick="remove_select_checkbox(<?=$tra_id?>)" id="checkbox_move[]" name="checkbox_move[]" value="<?=$tra_id?>" checked></center>
								
							</div>
							
							<div class='col-sm-4'>
								<?=$tra_title ?>
							</div>
							<div class='col-sm-4'>
								<?=$tra_desc ?>
							</div>
							<div class='col-sm-1'>
								<?=$tra_form ?>
							</div>
							<div class='col-sm-1'>
								<?=$tra_to ?>
							</div>
							<div class='col-sm-1'>
								<?=$hours ?>
							</div>
							
							<br><br>
							<hr>
						</div>
								
						
							<?php
				}
				
			}
			echo "###$coach";
		}
	}
	
}
if($status=='save_evaluation'){
	$res_id = $_REQUEST['res_id'];
	$tra_res = $_REQUEST['tra_res'];
	$remark = $_REQUEST['remark'];
	$group_id = $_REQUEST['group_id'];
	$recommend = iconv("utf-8","tis-620",$_REQUEST['recommend']);
	$result1 = $_REQUEST['result1'];
	$result2 = $_REQUEST['result2'];
	$result3 = $_REQUEST['result3'];
	foreach($res_id as $key => $value){
		$tra_res_ar = $tra_res[$key];
		$remark_ar = $remark[$key];
		$sql = "update tbtra_result set tra_res='$tra_res_ar' where res_id='$value'";//,remark='$remark_ar'
		mssql_query($sql);
	}
	$sql_group = "update tbtra_group 
					set recommend='$recommend',result1='$result1',result2='$result2',result3='$result3'
					where group_id='$group_id'";
	mssql_query($sql_group);
	echo 1;
}
?>