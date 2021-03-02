<?
include("connect.php");
include("library.php");
$status = $_REQUEST['status'];
$date_time=date("m/d/Y H:i:s");

if($status=='getdepartment'){
	$site = $_POST['tsite'];
		$sqldepartment  = "SELECT * FROM tbdepartment WHERE site='$site'";
	$department = mssql_query($sqldepartment);
		echo '<option value="" selected>- สาขา -</option>';
	while($row_department= mssql_fetch_array($department)){
			 echo '<option value="'.$row_department['departmentid'].'">'.$row_department['department'].'</option>';
	}
}
if($status=='getposition'){
	$department = $_POST['department'];
		$sqlposition  = "SELECT * FROM tbposition WHERE departmentid='$department'";
	$position = mssql_query($sqlposition);
		echo '<option value="" selected>- ตำแหน่ง -</option>';
	while($row_position= mssql_fetch_array($position)){
			 echo '<option value="'.$row_position['positionid'].'">'.$row_position['positionname'].'</option>';
	}
}
if($status=='getpositionnow'){
	$positionid = $_POST['positionid'];
		$sqlposition  = "SELECT * FROM tbposition WHERE positionid='$positionid'";
	$position = mssql_query($sqlposition);

	while($row_position= mssql_fetch_array($position)){
		if($positionid == $row_position['positionid']){
			 echo '<option value="'.$row_position['positionid'].'">'.$row_position['positionname'].'</option>';
		}					 
	}
}

if($status=='updateemployee'){
	 ini_set('mssql.charset', 'UTF-8');
	$empno = $_REQUEST['empno'];
	$firstname =  $_REQUEST['firstname'];
	$firstname = iconv("utf-8","tis-620", $firstname );
	//$firstname = iconv("utf-8", "tis-620", $firstname );
	$firstname_en= $_REQUEST['firstname_en'];
	$lastname= $_REQUEST['lastname'];
	$lastname = iconv("utf-8","tis-620", $lastname );
	$lastname_en= $_REQUEST['lastname_en'];
	$nickname= $_REQUEST['nickname'];
	$nickname = iconv("utf-8","tis-620" ,$nickname );
	$birthdate= $_REQUEST['birthdate'];
	//$age= $_REQUEST['age'];
	$mobile= $_REQUEST['mobile'];
	$email= $_REQUEST['email'];
	$startdate= $_REQUEST['startdate'];
	$mstatus= $_REQUEST['mstatus'];
	$personalid= $_REQUEST['personalid'];
	$accountid= $_REQUEST['accountid'];
	$positionidx= $_POST['positionid'];
	$departmentid= $_POST['departmentid'];
	
	$father_name= $_REQUEST['father_name'];
	$father_name = iconv("utf-8","tis-620", $father_name );
	$mother_name= $_REQUEST['mother_name'];
	$mother_name = iconv("utf-8","tis-620" ,$mother_name );
	$father_birthdate= $_REQUEST['father_birthdate'];
	$mother_birthdate= $_REQUEST['mother_birthdate'];
	$resigndate= $_REQUEST['resigndate'];
	$display_att= $_REQUEST['display_att'];
	
	$address= $_REQUEST['address'];
	$address = iconv("utf-8","tis-620",$address );
	$real_address= $_REQUEST['real_address'];
	$real_address = iconv("utf-8","tis-620",$real_address );
	$delstatus = $_REQUEST['delstatus'];
	
	$emp_level_edit = $_POST['emp_level_edit'];

	$att_reward= $_REQUEST['att_reward'];
	$skill_reward= $_REQUEST['skill_reward'];
	$basic_wage= $_REQUEST['basic_wage'];
	$basic_salary= $_REQUEST['basic_salary'];
	$position_val= $_REQUEST['position_val'];
	$travel_val= $_REQUEST['travel_val'];
	$mobile_val= $_REQUEST['mobile_val'];
	$emptype= $_REQUEST['emp_type'];
	$probationdate = $_REQUEST['probationdate'];

	$shirt_size = iconv("utf-8","tis-620",$_REQUEST["shirt_size"]);
	$shoe_size = $_REQUEST["shoe_size"];
	//$address = iconv("tis-620", "utf-8", $address );
	//$address = iconv("tis-620", "utf-8", $address );
	//$real_address = iconv("tis-620", "utf-8", $real_address );
					//11/08/2523
					if($birthdate!=''){
					$arrbirthdate = explode("/",$birthdate);
					$birthdate = $arrbirthdate[1]."/".$arrbirthdate[0]."/".((int)$arrbirthdate[2]-543);
					}
					
					if($startdate!=''){
					$arrstartdate = explode("/",$startdate);
					$startdate = $arrstartdate[1]."/".$arrstartdate[0]."/".((int)$arrstartdate[2]-543);
					}
					if($probationdate!=''){
						$arrprobationdate = explode("/",$probationdate);
						$probationdate = $arrprobationdate[1]."/".$arrprobationdate[0]."/".((int)$arrprobationdate[2]-543);
					}
					if($father_birthdate!=''){
					$arrfather_birthdate = explode("/",$father_birthdate);
					$father_birthdate = $arrfather_birthdate[1]."/".$arrfather_birthdate[0]."/".((int)$arrfather_birthdate[2]-543);
					}
					if($mother_birthdate!=''){
					$arrmother_birthdate = explode("/",$mother_birthdate);
					$mother_birthdate = $arrmother_birthdate[1]."/".$arrmother_birthdate[0]."/".((int)$arrmother_birthdate[2]-543);
					}
					if($resigndate!=''){
					$arrresigndate = explode("/",$resigndate);
					$resigndate = $arrresigndate[1]."/".$arrresigndate[0]."/".((int)$arrresigndate[2]-543);
					}
				$lock = 0;
				
				if($delstatus=='1'){
					if($emp_level_edit=='1' || $emp_level_edit=='2'){
						$select0="SELECT paycode FROM  tbpaycode WHERE ('$resigndate' BETWEEN startdate AND enddate)";
						$re0=mssql_query($select0);
						$num0=mssql_num_rows($re0);
						if($num0>0){
							$row0 = mssql_fetch_array($re0);
							$paycode = $row0['paycode'];
													$select2 = "select * from tbsalary where paycode='$paycode' and empno='$empno' and paystatus='paid'";
													$re2 = mssql_query($select2);
													$num2 = mssql_num_rows($re2);
													if($num2<=0){
														
															echo "waitpaysalary";
															$lock = 1;
															
													
														}
						}
						
				}
						
					}
		if($lock==0){	
	$select="select empno from  tbemployee where empno = '$empno' ";
				$re=mssql_query($select);
				$num=mssql_num_rows($re);
				if($num>0){
					$update = "update tbemployee set 
					firstname='$firstname',
					firstname_en ='$firstname_en',
					lastname='$lastname',
					lastname_en='$lastname_en',
					nickname='$nickname',
					mobile='$mobile',
					email='$email',
					positionid='$positionidx',
					mstatus='$mstatus',
					personalid='$personalid',
					accountid='$accountid',
					father_name='$father_name',
					mother_name='$mother_name',
					address='$address',
					delstatus='$delstatus',
					real_address='$real_address',
					att_reward=$att_reward,
					skill_reward=$skill_reward, 
					basic_wage=$basic_wage, 
					basic_salary=$basic_salary, 
					position_val=$position_val,
					travel_val=$travel_val,
					mobile_val=$mobile_val,
					emptype='$emptype',
					departmentid='$departmentid',
					emp_level='$emp_level_edit',
					shirt_size='$shirt_size',
					shoe_size='$shoe_size',display_att='$display_att' ";
					
					if($startdate!=''){
						$update.=",startdate='$startdate' ";
						}
					if($probationdate!=''){
						$update.=",probationdate='$probationdate' ";
						}
					if($birthdate!=''){
						$update.=",birthdate='$birthdate' ";
						}
					if($father_birthdate!=''){
						$update.=",father_birthdate='$father_birthdate' ";
						}
					if($mother_birthdate!=''){
						$update.=",mother_birthdate='$mother_birthdate' ";
						}
					if($resigndate!=''){
						$update.=",resigndate='$resigndate' ";
						}
					
					
					
					$update.=" where empno='$empno'";
					echo $update;
				    //echo $emp_level;
					mssql_query($update);
					
					if($_FILES["img_emp"]['name']){
						//$type= strrchr($_FILES["img_emp"]["name"][$i],".");
						//$file_new = $empno."$type";
						unlink("emppic/".$empno.".jpg");
						move_uploaded_file($_FILES["img_emp"]["tmp_name"],"emppic/".$empno.".jpg");
						
					}
					
				}
				
	}	
}
if($status=='I'){
	$empno = $_REQUEST['id_emp'];//56012
	$firstname = iconv("utf-8","tis-620", $_REQUEST['firstname']);//วรรณิศา 
	$lastname = iconv("utf-8","tis-620", $_REQUEST['lastname']);//ไกรรุ่ง
	$firstname_en = iconv("utf-8","tis-620", $_REQUEST['firstname_en']);//ไกรรุ่ง
	$lastname_en = iconv("utf-8","tis-620", $_REQUEST['lastname_en']);//ไกรรุ่ง
	$nickname = iconv("utf-8","tis-620", $_REQUEST['nickname']);//เค้ก
	$tsite = $_REQUEST['tsite'];//HQ
	$password = "password";
	$delstatus = $_REQUEST['delstatus'];//ทำงานหรือไม่
	$emp_level = $_REQUEST['emp_level'];//ตำแหน่ง
	$emptype = $_REQUEST['emp_type'];//temp
	$positionidx = $_POST['positionid'];
	$department = $_POST['department'];
	$accountid = $_REQUEST['accountid'];
	/*$startdate = explode("/",$_REQUEST['startdate']);
	$startdate = $startdate[1]."/".$startdate[0]."/".((int)$startdate[2]-543);*/
	$startdate = $_REQUEST['startdate']==NULL ? "NULL" :date_format_thai_into_database($_REQUEST['startdate']);
	$startdate = $startdate=="NULL" ? $startdate : "'$startdate'";
/*	$probationdate = explode("/",$_REQUEST['probationdate']);
	$probationdate = $probationdate[1]."/".$probationdate[0]."/".((int)$probationdate[2]-543);
	$probationdate = '';*/
	$probationdate = $_REQUEST['probationdate']==NULL ?"NULL" :date_format_thai_into_database($_REQUEST['probationdate']);
	$probationdate = $probationdate=="NULL" ? $probationdate : "'$probationdate'";
	//$resigndate = $date_time;
	$email = $_REQUEST['email'];
	//$age = $_REQUEST['age'];
	/*$birthdate = explode("/",$_REQUEST['birthdate']);
	$birthdate = $birthdate[1]."/".$birthdate[0]."/".((int)$birthdate[2]-543);*/
	$birthdate = $_REQUEST['birthdate']==NULL ?"NULL" :date_format_thai_into_database($_REQUEST['birthdate']);
	$birthdate = $birthdate=="NULL" ? $birthdate : "'$birthdate'";
	$mstatus = $_REQUEST['mstatus'];
	$address = iconv("utf-8","tis-620", $_REQUEST['address']);
	$real_address = iconv("utf-8","tis-620", $_REQUEST['real_address']);
	$personalid = $_REQUEST['personalid'];
	$father_name = iconv("utf-8","tis-620", $_REQUEST['father_name']);
	$mother_name = iconv("utf-8","tis-620", $_REQUEST['mother_name']);
	/*$father_birthdate = explode("/",$_REQUEST['father_birthdate']);
	$father_birthdate = $father_birthdate[1]."/".$father_birthdate[0]."/".((int)$father_birthdate[2]-543);*/
	$father_birthdate = $_REQUEST['father_birthdate']==NULL ?"NULL" :date_format_thai_into_database($_REQUEST['father_birthdate']);
	$father_birthdate = $father_birthdate=="NULL" ? $father_birthdate : "'$father_birthdate'";
	/*$mother_birthdate = explode("/",$_REQUEST['mother_birthdate']);
	$mother_birthdate = $mother_birthdate[1]."/".$mother_birthdate[0]."/".((int)$mother_birthdate[2]-543);*/
	$mother_birthdate = $_REQUEST['mother_birthdate']==NULL ?"NULL" :date_format_thai_into_database($_REQUEST['mother_birthdate']);
	$mother_birthdate = $mother_birthdate=="NULL" ? $mother_birthdate : "'$mother_birthdate'";
	$mobile = $_REQUEST['mobile'];
	$tpermission = $_REQUEST['tpermission'];
	$shirt_size = iconv("utf-8","tis-620",$_REQUEST["shirt_size"]);
	$shoe_size = $_REQUEST["shoe_size"];
	
	//// encode empno
						$num = str_pad(mt_rand(1,999),3,'0',STR_PAD_LEFT);
						$ch1 = substr($empno,0,1);
						$ch2 = substr($num,0,1);
						$ch3 = substr($empno,1,1);
						$ch4 = substr($num,1,1);
						$ch5 = substr($empno,2,1);
						$ch6 = substr($num,2,1);
						$ch7 = substr($empno,3,1);
						$ch8 = substr($empno,4,1);
						$empno_encode = $ch1.$ch2.$ch3.$ch4.$ch5.$ch6.$ch7.$ch8;
	//// encode empno
	// $departmentid = "";
	// $department = "SELECT *
	// FROM     tbdepartment
	// WHERE  department = '$tsite'";
	// 	$select_department = mssql_query($department);
	// 	while($row_department = mssql_fetch_array($select_department)){
	// 	$departmentid = $row_department["departmentid"];
	// 	}
	$sql = "INSERT INTO tbemployee(empno,firstname,lastname,firstname_en,lastname_en,nickname,site,password,delstatus,emp_level,emptype,departmentid,positionid,accountid,startdate,probationdate,email,birthdate,mstatus,address,real_address,personalid,father_name,mother_name,father_birthdate,mother_birthdate,mobile,shirt_size,shoe_size,display_att,empno_encode)";
	$sql .= "VALUES('$empno','$firstname','$lastname','$firstname_en','$lastname_en','$nickname','$tsite','$password','$delstatus','$emp_level','$emptype','$department','$positionidx','$accountid',$startdate,$probationdate,'$email',$birthdate,'$mstatus','$address','$real_address','$personalid','$father_name','$mother_name',$father_birthdate,$mother_birthdate,'$mobile','$shirt_size','$shoe_size','1','$empno_encode')";
	echo $sql;
	mssql_query($sql);
	if($_FILES["img_emp"]['name']){
		$type= strrchr($_FILES["img_emp"]["name"][$i],".");
		$file_new = $empno."$type";
		
		move_uploaded_file($_FILES["img_emp"]["tmp_name"],"emppic/".$empno.".jpg");
		
	}
	echo "1";
}


if($status=='checknewemp'){
	$empno = $_REQUEST['empno'];
	$select="select empno from  tbemployee where empno = '$empno' ";
				$re=mssql_query($select);
				$num=mssql_num_rows($re);
				//echo $num;
				if($num>0){
					echo "dupplicate";
					}
	}
	if($status == 'checknsite'){
		$site = $_REQUEST['tsite'];
		$empnomax = "";

		$select = "select * FROM  tbemployee WHERE empno = (select MAX(empno) AS empnomax FROM tbemployee
				 WHERE   site = '$site')";
			$select_site = mssql_query($select);
			$num_rows_data = mssql_num_rows($select_site);
			while($row_site = mssql_fetch_array($select_site)){
				$empnomax = $row_site["empno"];
				$site = $row_site["site"];
			}
			$tbsite_type = "SELECT *
			FROM  tbsite 
			Where site = '$site'";
			$select_type = mssql_query($tbsite_type);
			while($row_type = mssql_fetch_array($select_type)){
				$emptype = $row_type["emptype"];
				$site_id = $row_type["site_id"];
				if($site != ''){
					$data['type'] = $emptype;
				}else {
					
				}

			}
			$date  = date("Y") + 543;
			$yearnew = substr($date,2,4);
			if($num_rows_data == 0){
				$empnomaxn = $site_id.$yearnew.'001';
				$data['empno'] = $empnomaxn;
			}else{
		if($emptype == 'Sub'){
			if($site == 'JWD LCB'){
				$empnowt = substr($empnomax,0,3);
				$empnow = substr($empnomax,3,9) + 1;
				$empnomaxn = $empnowt.$empnow;
				$data['empno'] = $empnomaxn;
			}else{
				$site_id_number = strlen($site_id);
				$num = strlen($empnomax);
				$empnowt = substr($empnomax,0,$site_id_number);
				$empnow = substr($empnomax,$site_id_number,$num) + 1;
				$empnomaxn = $empnowt.$empnow;
				$data['empno'] = $empnomaxn;
			}
		} 
	}
		// if($site_id != ''){

		// }
		if($emptype == 'IPACK'){
			$year  = date("Y") + 543;
			$yearnow = substr($year,2,4);
			$empnowt = $empnomax + 1;
			$empnow = substr($empnowt,2,6);
			$empnomaxn = $yearnow.$empnow;
			$checkemp = "select *
			FROM     tbemployee
			WHERE  empno = '$empnomaxn'";
			$select_checkemp = mssql_query($checkemp);
			$num_checkemp = mssql_num_rows($select_checkemp);
			if($num_checkemp == 0){
				$empnomaxn = $yearnow.$empnow;
				if(strlen($empnomaxn) < 3){
				
				}else {
					$data['empno'] = $empnomaxn;
				}
			}else{
			$newmaxemp = "select * FROM  tbemployee WHERE empno = (select MAX(empno) AS empnomax FROM tbemployee
			WHERE   empno LIKE '%$yearnow%')";
				$newmaxemp = mssql_query($newmaxemp);
				while($row_newmaxemp = mssql_fetch_array($newmaxemp)){
					$empnomax = $row_newmaxemp["empno"];
				}
				$empnowt = $empnomax + 1;
				$empnomaxn = $yearnow.$empnow;
				$empnow = substr($empnowt,2,6);
				$empnomaxn = $yearnow.$empnow;
				$data['empno'] = $empnomaxn;
			}
				
			}
			$data['site'] = $site;
			echo json_encode($data);
	}
	if($status=='set_probationdate'){
		$startdate = date_format_thai_into_database($_REQUEST['startdate']);
		$probationdate = date('d/m/Y', strtotime("+4 months", strtotime($startdate)));
		$arr_date = explode("/",$probationdate);
		$probationdate = $arr_date[0]."/".$arr_date[1]."/".((int)$arr_date[2]+543);
		//$probationdate = date_format_thai_from_databese($probationdate);
		echo $probationdate;
	}

	if($status=="noti_birthdate"){
		$month_current = date("m");
		$sum = 0;
		$noti1 = "";
		$noti2 = "";
		$noti3 = "";

		$sql = "select convert(varchar, birthdate, 103)as birthdate_date,
		convert(varchar, father_birthdate, 103)as father_birthdate_date,
		convert(varchar, mother_birthdate, 103)as mother_birthdate_date,* 
		from tbemployee where delstatus!=1 order by site desc,empno asc";
		$res = mssql_query($sql);
		while($row = mssql_fetch_array($res)){
			$fullname = get_full_name($row["empno"]);
			$site = $row["site"];
			$nickname = lang_thai_from_database($row["nickname"]);
			$birthdate = $row["birthdate_date"];
			if($row["birthdate"]!=''){
				$birthdate_month = date("m", strtotime($row["birthdate"])); 
			}else{
				$birthdate_month="";
			}
			if($row["father_birthdate"]!=''){
				$father_birthdate_month = date("m", strtotime($row["father_birthdate"])); 
			}else{
				$father_birthdate_month ="";
			}
			
			$father_birthdate = $row["father_birthdate_date"];
			//$father_birthdate_month = date("m", strtotime($row["father_birthdate"]));
			$mother_birthdate = $row["mother_birthdate_date"];
			if($row["mother_birthdate"]!=''){
				$st=$row["mother_birthdate"];
				$mother_birthdate_month = date("m", strtotime($row["mother_birthdate"])); 
			}else{
				$mother_birthdate_month ="";
			}
			//$mother_birthdate_month = date("m", strtotime($row["mother_birthdate"])); 
			$show_name = "[$site] $fullname($nickname)";

			if($month_current == $birthdate_month){
				$noti3 .="<li><a href='#'>$show_name  <span class='time'>$birthdate</span></a></li>";
				$sum++;
			}
			if($month_current == $father_birthdate_month){
				$noti3 .="<li><a href='#'>พ่อของ $show_name  <span class='time'>$father_birthdate</span></a></li>";
				$sum++;
			}
			if($month_current == $mother_birthdate_month){
				$noti3 .="<li><a href='#'>แม่ของ $show_name  <span class='time'>$mother_birthdate</span></a></li>";
				$sum++;
			}

		}
		$noti1 = $sum;
		$noti2 = "เดือน $month_current มีคนเกิดจำนวน $sum คน";
		echo $noti1."###".$noti2."###".$noti3;
	}
	
	
	if($status=="show_empno"){
    $empno =$_POST["empno"];
    ?>
    <select name="empno" id="empno" class="form-control">
        <option value="" >Select employee</option>
    <?php
    $sql = "select empno,site,firstname,lastname,nickname from tbemployee where delstatus!=1 order by site,empno asc";
    $res = mssql_query($sql);
    while($row = mssql_fetch_array($res)){
        $empno_query = $row["empno"];
        $site = $row["site"];
        $firstname = lang_thai_from_database($row["firstname"]);
        $lastname = lang_thai_from_database($row["lastname"]);
        $nickname = lang_thai_from_database($row["nickname"]);
        $full_name_nickname = "$firstname $lastname ($nickname)";
        if($empno_query==$empno){
            $selected = "selected";
        }else{
            $selected = "";
        }
        ?><option value="<?=$empno_query?>" <?=$selected?>>[<?=$site?>]&nbsp;<?=$full_name_nickname?></option><?
       // echo $lastname;

    }
    ?></select><?
}
?>