<?
include("connect.php");
include("library.php");

$status = $_REQUEST['status'];
$date_time=date("m/d/Y H:i:s");
$data = array(); 
//$_SESSION['admin_userid'];

if($status=='T'){
    $id = $_POST['id'];
	$search = @$_POST["search"]["value"];
	if(strlen($search)){
		$search =  iconv("utf-8","tis-620", $search);
		$sql = "SELECT * FROM  tbsite WHERE site LIKE '%$search%' ORDER BY id DESC";
	}else{
		$sql = "SELECT * FROM  tbsite ORDER BY id DESC";
	}
	//echo $sql;
	$re=mssql_query($sql);
	$item = 1;
	while($row=mssql_fetch_array($re)){
		$row_array["item"] = $item;
		// $id = $row['positionid'];
		$row_array["id"] = iconv("tis-620", "utf-8", $row['id']);
		$row_array["site"] = iconv("tis-620", "utf-8", $row['site']);
		 $row_array["site_id"] = iconv("tis-620", "utf-8", $row['site_id']);		
		$row_array["edit"] = '<center><i class="fa fa-pencil-square-o fa-2x" aria-hidden="true" onclick="add_title('.$row["id"].')"></i></center>';

		array_push($data,$row_array);
		
		$item++;
	}
	
	echo json_encode(array('data'=>$data));
}
if($status=='I'){
	$site_name = iconv("utf-8","tis-620", $_REQUEST['site_name']);
	$site_id_1 = iconv("utf-8","tis-620", $_REQUEST['site_id_1']);
	$tra_group = iconv("utf-8","tis-620", $_REQUEST['tra_group']);
	$startdate =  $_REQUEST['startdate'];
	$startnight = $_REQUEST['startnight'];
	//$tra_s = $_REQUEST['time_start'];
	//$tra_e = $_REQUEST['time_end'];
  
	$sql = "INSERT INTO tbsite (site,emptype, site_id, startotday ,startotnight)";
	$sql .= " VALUES('".$site_name."','".$tra_group."', '".$site_id_1."', '".$startdate."' , '".$startnight."')";
	$res = mssql_query($sql);
	$row = mssql_fetch_array($res);

    $sqlsearch= "SELECT * FROM  tbsite WHERE  site = '$site_name' AND site_id = '$site_id_1'";
    $res = mssql_query($sqlsearch);
    $num_rows = mssql_num_rows($res);
    if($num_rows == 0){
        echo '0';
    }else{
        echo '1';
    }
	
}
if($status=='U'){
	$id = $_POST['site'];
	$site_name = iconv("utf-8","tis-620", $_REQUEST['site_name']);
	$site_id_1 = iconv("utf-8","tis-620", $_REQUEST['site_id_1']);
	$tra_group = iconv("utf-8","tis-620", $_REQUEST['tra_group']);
	$startdate = iconv("utf-8","tis-620", $_REQUEST['startdate']);
	$startnight = iconv("utf-8","tis-620", $_REQUEST['startnight']);
	
	$update = "UPDATE tbsite SET site='".$site_name."',
	emptype ='".$tra_group."', 
	site_id ='".$site_id_1."' ,
	startotday ='".$startdate."' ,
	startotnight ='".$startnight."' 
	WHERE id = $id";
	mssql_query($update);
    $sqlsearch= "SELECT * FROM  tbsite WHERE  site = '$site_name' AND site_id = '$site_id_1'";
    $res = mssql_query($sqlsearch);
    $num_rows = mssql_num_rows($res);
    if($num_rows == 0){
        echo '0';
    }else{
        echo '1';
    }
}
if($status=='R'){
	$id = $_POST['id'];
		if($id>0){
			$sql = "SELECT *, CONVERT(varchar, startotday, 108) as  totday ,CONVERT(varchar, startotnight, 108) as  otnight
             FROM  tbsite WHERE id = $id";
			$res = mssql_query($sql);
			$row = mssql_fetch_array($res);
            $row_array['site_name'] = iconv("utf-8","tis-620", $row['site']);
            $row_array['tra_group'] = iconv("utf-8","tis-620", $row['emptype']);
            $row_array['site_id_1'] = iconv("utf-8","tis-620", $row['site_id']);
            $row_array['startdate'] = iconv("utf-8","tis-620", $row['totday']);
            $row_array['startnight'] = iconv("utf-8","tis-620", $row['otnight']);
        //	$row_array["tra_form"] = iconv("tis-620", "utf-8", $row['tra_form']);
		//	$row_array["tra_to"] = iconv("tis-620", "utf-8", $row['tra_to']);
		// $row_array["tra_time"] = iconv("tis-620", "utf-8", $row['tra_time']);
			$data = $row_array;
		}else{
			$sql = "SELECT * FROM  tbsite ";
			$re=mssql_query($sql);
			while($row=mssql_fetch_array($re)){
                $row_array['site_name'] = iconv("utf-8","tis-620", $row['site']);
                $row_array['tra_group'] = iconv("utf-8","tis-620", $row['emptype']);
                $row_array['site_id_1'] = iconv("utf-8","tis-620", $row['site_id']);
                $row_array['startdate'] = iconv("utf-8","tis-620", $row['startotday']);
                $row_array['startnight'] = iconv("utf-8","tis-620", $row['startotnight']);
				array_push($data,$row_array);
			}
		}
	echo json_encode(array('data'=>$data));
}
if($status=='checksite'){
    $i_name = $_POST['site'];
	// $site = $_REQUEST['site'];
	$site_id = $_REQUEST['site_id'];
	$select="select * from  tbsite where site = '$i_name' AND site_id = '$site_id' ";
				$re=mssql_query($select);
				$num=mssql_num_rows($re);
				if($num>0){
					echo "dupplicate";
					}
}
?>