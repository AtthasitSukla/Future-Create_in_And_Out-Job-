<?
include("connect_sso.php");

$status = $_REQUEST['status'];
$date_time=date("m/d/Y H:i:s");


if($status=='uploadFile'){
			$id = $_REQUEST['id'];
					// $partnumber = $_REQUEST['partnumber'];
			
					  $file_name_pds=$_FILES["pds"]["name"];
					  $file_type_pds=$_FILES["pds"]["type"];
					  $file_size_pds=($_FILES["pds"]["size"] / 1024);
					  $file_tmpname_pds=$_FILES["pds"]["tmp_name"]; 
					  
					//  $file_name_qpoint=$partnumber.".jpg";
					//  $file_type_qpoint=$_FILES["qpoint"]["type"];
					//  $file_size_qpoint=($_FILES["qpoint"]["size"] / 1024);
					//  $file_tmpname_qpoint=$_FILES["qpoint"]["tmp_name"]; 
					  
					//   $file_name_pps=$_FILES["pps"]["name"];
					//  $file_type_pps=$_FILES["pps"]["type"];
					//  $file_size_pps=($_FILES["pps"]["size"] / 1024);
					//  $file_tmpname_pps=$_FILES["pps"]["tmp_name"]; 
					  
					  if($file_name_pds!=''){
						// echo $file_name_pds;	
						   move_uploaded_file($file_tmpname_pds,"manual_file/".$file_name_pds);
					 		$update = "update tbiwis_diagram set filename='$file_name_pds',updatedate='$date_time' where systemid='$id'";
							mssql_query($update);
						  }
						 
					  echo $update;
					 
			}
?>