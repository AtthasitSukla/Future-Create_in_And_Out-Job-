<?
include("connect.php");
include("library.php");

$status = $_REQUEST['status'];
$date_time=date("m/d/Y H:i:s");
$data = array(); 
//$_SESSION['admin_userid'];

if($status=='T'){
	$search = @$_POST["search"]["value"];
	if(strlen($search)){
		$search =  iconv("utf-8","tis-620", $search);
		$sql = "SELECT * FROM  tbposition WHERE positionid LIKE '%$search%' ORDER BY id DESC";
	}else{
		$sql = "SELECT * FROM  tbposition ORDER BY id DESC";
	}
	//echo $sql;
	$re=mssql_query($sql);
	$item = 1;
	while($row=mssql_fetch_array($re)){
		$row_array["item"] = $item;
		// $id = $row['positionid'];
		$row_array["id"] = iconv("tis-620", "utf-8", $row['positionid']);
		$row_array["title"] = iconv("tis-620", "utf-8", $row['positionname']);
		$row_array["desc"] = iconv("tis-620", "utf-8", $row['site']);		
		$row_array["edit"] = '<center><i class="fa fa-pencil-square-o fa-2x" aria-hidden="true" onclick="add_title('.$row["id"].')"></i></center>';

		array_push($data,$row_array);
		
		$item++;
	}
	
	echo json_encode(array('data'=>$data));
}
if($status=='I'){
	$positionidnumber = iconv("utf-8","tis-620", $_REQUEST['positionidnumber']);
	$name = iconv("utf-8","tis-620", $_REQUEST['title_name']);
	$tra_department = iconv("utf-8","tis-620", $_REQUEST['tra_department']);
	$tra_group = iconv("utf-8","tis-620", $_REQUEST['tra_group']);
	//$tra_s = $_REQUEST['time_start'];
	//$tra_e = $_REQUEST['time_end'];
	$sql = "INSERT INTO tbposition (positionid,positionname, departmentid, site)";
	$sql .= " VALUES('".$positionidnumber."','".$name."', '".$tra_department."', '".$tra_group."')";
	$res = mssql_query($sql);
	$row = mssql_fetch_array($res);
	echo '1';
}
if($status=='U'){
	$id = $_POST['title_id'];
	$name = iconv("utf-8","tis-620", $_REQUEST['title_name']);
	$tra_department = iconv("utf-8","tis-620", $_REQUEST['tra_department']);
	$tra_group = iconv("utf-8","tis-620", $_REQUEST['tra_group']);
	
	$sql = "UPDATE tbposition SET positionname='".$name."',
	departmentid ='".$tra_department."', 
	site ='".$tra_group."' 
	WHERE id = $id";
	mssql_query($sql);
	echo $sql;
}
if($status=='R'){
	$type = $_POST['type'];
	$id = $_POST['id'];
	if($type = "tbposition"){
		if($id>0){
			$sql = "SELECT * FROM  tbposition WHERE id = $id";
			$res = mssql_query($sql);
			$row = mssql_fetch_array($res);
			$row_array["positionid"] = iconv("tis-620", "utf-8", $row['positionid']);
			$row_array["title_name"] = iconv("tis-620", "utf-8", $row['positionname']);
			$row_array["tra_department"] = iconv("tis-620", "utf-8", $row['departmentid']);
			$row_array["tra_group"] = iconv("tis-620", "utf-8", $row['site']);
		//	$row_array["tra_form"] = iconv("tis-620", "utf-8", $row['tra_form']);
		//	$row_array["tra_to"] = iconv("tis-620", "utf-8", $row['tra_to']);
			// $row_array["tra_time"] = iconv("tis-620", "utf-8", $row['tra_time']);
			$data = $row_array;
		}else{
			$sql = "SELECT * FROM  tbposition ";
			$re=mssql_query($sql);
			while($row=mssql_fetch_array($re)){
			$row_array["positionid"] = iconv("tis-620", "utf-8", $row['positionid']);
			$row_array["title_name"] = iconv("tis-620", "utf-8", $row['positionname']);
			$row_array["tra_department"] = iconv("tis-620", "utf-8", $row['departmentid']);
			$row_array["tra_group"] = iconv("tis-620", "utf-8", $row['site']);
				array_push($data,$row_array);
			}
		}
	}
	echo json_encode(array('data'=>$data));
}
?>