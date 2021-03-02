<?
include("connect.php"); 
	//$host='DESKTOP-C78BTEH';
	//$host='DESKTOP-MAO6R9N';
	$host2='61.19.251.102';
	//'11.22.33.44',1433;
	$username2="sloxixa";
	$password2="eaotft139@%";
	$db2="dhrdb";
	$sql2=mssql_connect($host2,$username2,$password22) or die("Cannot connect");
	mssql_select_db($db2);
	
$status=$_REQUEST['status'];
if($status==''){
	
	$select =  "select  * from tbemployee ";
	$re=mssql_query($select,$sql2);
  	while($row=mssql_fetch_array($re)){
		
	$select2 =  "select  * from tbemployee where empno='".$row['empno']."'";
	$re2=mssql_query($select2,$sql);
	$num2 = mssql_num_rows($re2);
	if($num2<=0){
			$insert = "INSERT INTO tbemployee(empno,firstname,lastname,firstname_en,lastname_en,nickname,site,password,delstatus,emp_level,emptype,positionid,accountid,startdate,resigndate,email,age,birthdate,mstatus,address,real_address,personalid,father_name,mother_name,father_birthdate,mother_birthdate,mobile,permission)";
	$sql .= "VALUES('".$row['empno']."','".$row['firstname']."',
	'".$row['lastname']."',
	'".$row['firstname_en']."',
	'".$row['lastname_en']."',
	'".$row['nickname']."',
	'".$row['site']."',
	'".$row['password']."',
	'".$row['delstatus']."',
	'".$row['emp_level']."',
	'".$row['emptype']."',
	'".$row['positionid']."',
	'".$row['accountid']."',
	'".$row['startdate']."',
	'".$row['resigndate']."',
	'".$row['email']."','".$row['age']."',
	'".$row['birthdate']."',
	'".$row['mstatus']."',
	'".$row['address']."',
	'".$row['real_address']."',
	'".$row['personalid']."',
	'".$row['father_name']."',
	'".$row['mother_name']."',
	'".$row['father_birthdate']."',
	'".$row['mother_birthdate']."',
	'".$row['mobile']."',
	'".$row['permission']."')";
	echo $sql;
//	mssql_query($insert,sql);
		}else{
			$update = "update tbemployee set 
					firstname='".$row['firstname']."',
					firstname_en ='".$row['firstname_en']."',
					lastname='".$row['lastname']."',
					lastname_en='".$row['lastname_en']."',
					nickname='".$row['nickname']."',
					birthdate='".$row['birthdate']."',
					age='".$row['age']."',
					mobile='".$row['mobile']."',
					email='".$row['email']."',
					positionid='".$row['positionid']."',
					startdate='".$row['startdate']."',
					mstatus='".$row['mstatus']."',
					personalid='".$row['personalid']."',
					accountid='".$row['accountid']."',
					father_name='".$row['father_name']."',
					mother_name='".$row['mother_name']."',
					father_birthdate='".$row['father_birthdate']."',
					mother_birthdate='".$row['mother_birthdate']."',
					address='".$row['address']."',
					delstatus='".$row['delstatus']."',
					real_address='".$row['real_address']."',
					where empno='".$row['empno']."'";
				    echo $update;
					//	mssql_query($update,sql);
		}
  
		
		
		}
	
	
	}
?>