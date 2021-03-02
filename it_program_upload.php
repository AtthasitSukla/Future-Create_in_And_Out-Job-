<?php
session_start();
include("connect.php");
include("library.php"); 

$time = date("H:i:s");
$date_time = date("m/d/Y H:i:s");

$empno = $_SESSION['admin_userid'];
//$create_date_only = date_format_uk_into_database($_REQUEST['create_date']);
$arr_date = explode("/",$_REQUEST['create_date']);
$create_date_only = $arr_date[1]."/".$arr_date[0]."/".$arr_date[2];
$create_date = $create_date_only." ".$time;
//echo $create_date;
$purpose = lang_thai_into_database($_REQUEST['purpose']);
/*
$importance1 = $_REQUEST['importance1']==""?"":lang_thai_into_database($_REQUEST['importance1']).",";
$importance2 = $_REQUEST['importance2']==""?"":lang_thai_into_database($_REQUEST['importance2']).",";
$importance3 = $_REQUEST['importance3']==""?"":lang_thai_into_database($_REQUEST['importance3']).",";
$importance4 = $_REQUEST['importance4']==""?"":lang_thai_into_database($_REQUEST['importance4']);
$importance = $importance1.$importance2.$importance3.$importance4;
*/
$check_im = 1;
foreach($_REQUEST['importance_arr'] as $key_im => $value_im ){
$purpose = lang_thai_into_database($_REQUEST['purpose']);
    if($check_im==1){
        $importance .= lang_thai_into_database($value_im);
    }else{
        $importance .= ",".lang_thai_into_database($value_im);
    }
    $check_im++;
}


$system_name = lang_thai_into_database($_REQUEST['system_name']);
$reason = lang_thai_into_database($_REQUEST['reason']);
$target_date = date_format_uk_into_database($_REQUEST['target_date']);
$job_status = "New";
$job_id_check = "IT01".$arr_date[2].$arr_date[1];
$sql_check = "select top 1 job_id from tbitprogram_list where job_id like '$job_id_check%' order by job_id desc";
$res = mssql_query($sql_check);
$num = mssql_num_rows($res);
if($num==0){
    $new_id = "IT01".$arr_date[2].$arr_date[1]."001";
}else{
    //IT201803001
    $row = mssql_fetch_array($res);
    $tmp_newid = $row['job_id'];
    $tmp_newid = substr($tmp_newid,-4);
	$qid = (int)$tmp_newid + 1;
    $tmpid = "0000".$qid;
    $qdno = substr($tmpid,-3);
    $new_id = "IT01".$arr_date[2].$arr_date[1].$qdno;
}
$insert = "insert into tbitprogram_list (job_id,empno,job_status,purpose,importance,system_name,reason,create_date,target_date,date_time)
values ('$new_id','$empno','$job_status','$purpose','$importance','$system_name','$reason','$create_date','$target_date','$date_time')";
mssql_query($insert);


$target_dir = "program_pic/";


if(isset($_FILES["program_file"])){
    $count = 1;
	foreach($_FILES['program_file']['tmp_name'] as $key => $val){
        $file_name = basename($_FILES['program_file']['name'][$key]);
        $imageFileType = strtolower(pathinfo($file_name,PATHINFO_EXTENSION));
        $target_file = $target_dir.$new_id."_".$count.".".$imageFileType;
        $file_name_upload = $new_id."_".$count.".".$imageFileType;

		$file_size =$_FILES['program_file']['size'][$key];
		$file_tmp =$_FILES['program_file']['tmp_name'][$key];
        $file_type=$_FILES['program_file']['type'][$key];  
        
        if(move_uploaded_file($file_tmp,$target_file)){
        $insert_file = "insert into tbitprogram_file (job_id,file_name)
                                    values ('$new_id','$file_name_upload')";
        mssql_query($insert_file);
		}
        $count++;
    }
}
echo "Save Success";

?>
<meta http-equiv='refresh' CONTENT='1;URL=it_program_list.php'>