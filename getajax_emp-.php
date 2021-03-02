<?
include("connect.php");

$status = $_REQUEST['status'];
$date_time=date("m/d/Y H:i:s");

if($status=='updateemployee'){
	$empno = $_REQUEST['empno'];
	$firstname= $_REQUEST['firstname'];
	$firstname = iconv("utf-8","tis-620", $firstname );
	//$firstname = iconv("utf-8", "tis-620", $firstname );
	$firstname_en= $_REQUEST['firstname_en'];
	$lastname= $_REQUEST['lastname'];
	$lastname = iconv("utf-8","tis-620", $lastname );
	$lastname_en= $_REQUEST['lastname_en'];
	$nickname= $_REQUEST['nickname'];
	$nickname = iconv("utf-8","tis-620" ,$nickname );
	$birthdate= $_REQUEST['birthdate'];
	$age= $_REQUEST['age'];
	$mobile= $_REQUEST['mobile'];
	$email= $_REQUEST['email'];
	$startdate= $_REQUEST['startdate'];
	$mstatus= $_REQUEST['mstatus'];
	$personalid= $_REQUEST['personalid'];
	$accountid= $_REQUEST['accountid'];
	$positionid= $_REQUEST['positionid'];
	$father_name= $_REQUEST['father_name'];
	$father_name = iconv("utf-8","tis-620", $father_name );
	$mother_name= $_REQUEST['mother_name'];
	$mother_name = iconv("utf-8","tis-620" ,$mother_name );
	$father_birthdate= $_REQUEST['father_birthdate'];
	$mother_birthdate= $_REQUEST['mother_birthdate'];
	
	$address= $_REQUEST['address'];
	$address = iconv("utf-8","tis-620",$address );
	$real_address= $_REQUEST['real_address'];
	$real_address = iconv("utf-8","tis-620",$real_address );
	$delstatus = $_REQUEST['delstatus'];
	//$address = iconv("tis-620", "utf-8", $address );
	//$address = iconv("tis-620", "utf-8", $address );
	//$real_address = iconv("tis-620", "utf-8", $real_address );
					//11/08/2523
					$arrbirthdate = explode("/",$birthdate);
					$birthdate = $arrbirthdate[1]."/".$arrbirthdate[0]."/".((int)$arrbirthdate[2]-543);
	
					$arrstartdate = explode("/",$startdate);
					$startdate = $arrstartdate[1]."/".$arrstartdate[0]."/".((int)$arrstartdate[2]-543);
					
					$arrfather_birthdate = explode("/",$father_birthdate);
					$father_birthdate = $arrfather_birthdate[1]."/".$arrfather_birthdate[0]."/".((int)$arrfather_birthdate[2]-543);
					
					$arrmother_birthdate = explode("/",$mother_birthdate);
					$mother_birthdate = $arrmother_birthdate[1]."/".$arrmother_birthdate[0]."/".((int)$arrmother_birthdate[2]-543);
	
	$select="select empno from  tbemployee where empno = '$empno' ";
				$re=mssql_query($select);
				$num=mssql_num_rows($re);
				if($num>0){
					$update = "update tbemployee set 
					firstname ='$firstname',
					firstname_en ='$firstname_en',
					lastname='$lastname',
					lastname_en='$lastname_en',
					nickname='$nickname',
					birthdate='$birthdate',
					age='$age',
					mobile='$mobile',
					email='$email',
					positionid='$positionid',
					startdate='$startdate',
					mstatus='$mstatus',
					personalid='$personalid',
					accountid='$accountid',
					father_name='$father_name',
					mother_name='$mother_name',
					father_birthdate='$father_birthdate',
					mother_birthdate='$mother_birthdate',
					address='$address',delstatus='$delstatus',
					real_address='$real_address' where empno='$empno'
					";
				    echo $update;
					mssql_query($update);
					
	if($_FILES["img_emp"]['name']){
		//$type= strrchr($_FILES["img_emp"]["name"][$i],".");
		//$file_new = $empno."$type";
		unlink("emppic/".$empno.".jpg");
		move_uploaded_file($_FILES["img_emp"]["tmp_name"],"emppic/".$empno.".jpg");
		
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
	$site = $_REQUEST['site'];//HQ
	$password = "password";
	$delstatus = $_REQUEST['delstatus'];//ทำงานหรือไม่
	$emp_level = $_REQUEST['emp_level'];//ตำแหน่ง
	$emptype = $_REQUEST['emp_type'];//temp
	$positionid = $_REQUEST['positionid'];
	$accountid = $_REQUEST['accountid'];
	$startdate = explode("/",$_REQUEST['startdate']);
	$startdate = $startdate[1]."/".$startdate[0]."/".((int)$startdate[2]-543);
	$probationdate = explode("/",$_REQUEST['probationdate']);
	$probationdate = $probationdate[1]."/".$probationdate[0]."/".((int)$probationdate[2]-543);
	$probationdate = '';
	$resigndate = $date_time;
	$email = $_REQUEST['age'];
	$age = $_REQUEST['empno'];
	$birthdate = explode("/",$_REQUEST['birthdate']);
	$birthdate = $birthdate[1]."/".$birthdate[0]."/".((int)$birthdate[2]-543);
	$mstatus = $_REQUEST['mstatus'];
	$address = iconv("utf-8","tis-620", $_REQUEST['address']);
	$real_address = iconv("utf-8","tis-620", $_REQUEST['real_address']);
	$personalid = $_REQUEST['personalid'];
	$father_name = iconv("utf-8","tis-620", $_REQUEST['father_name']);
	$mother_name = iconv("utf-8","tis-620", $_REQUEST['mother_name']);
	$father_birthdate = explode("/",$_REQUEST['father_birthdate']);
	$father_birthdate = $father_birthdate[1]."/".$father_birthdate[0]."/".((int)$father_birthdate[2]-543);
	$mother_birthdate = explode("/",$_REQUEST['mother_birthdate']);
	$mother_birthdate = $mother_birthdate[1]."/".$mother_birthdate[0]."/".((int)$mother_birthdate[2]-543);
	$mobile = $_REQUEST['mobile'];
	$permission = $_REQUEST['permission'];
	$sql = "INSERT INTO tbemployee(empno,firstname,lastname,firstname_en,lastname_en,nickname,site,password,delstatus,emp_level,emptype,positionid,accountid,startdate,resigndate,email,age,birthdate,mstatus,address,real_address,personalid,father_name,mother_name,father_birthdate,mother_birthdate,mobile,permission)";
	$sql .= "VALUES('$empno','$firstname','$lastname','$firstname_en','$lastname_en','$nickname','$site','$password','$delstatus','$emp_level','$emptype','$positionid','$accountid','$startdate','$resigndate','$email','$age','$birthdate','$mstatus','$address','$real_address','$personalid','$father_name','$mother_name','$father_birthdate','$mother_birthdate','$mobile','$permission')";
	//echo $sql;
	mssql_query($sql);
	if($_FILES["img_emp"]['name']){
		$type= strrchr($_FILES["img_emp"]["name"][$i],".");
		$file_new = $empno."$type";
		
		move_uploaded_file($_FILES["img_emp"]["tmp_name"],"emppic/".$empno.".jpg");
		
	}
	echo "1";
}

?>