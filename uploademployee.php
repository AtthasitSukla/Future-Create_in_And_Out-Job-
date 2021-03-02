<?
  $file_name=$_FILES["file_employee"]["name"];
  $file_type=$_FILES["file_employee"]["type"];
  $file_size=($_FILES["file_employee"]["size"] / 1024);
  $file_tmpname=$_FILES["file_employee"]["tmp_name"]; 
  
  
  // Move files
   move_uploaded_file($file_tmpname,"DB/".$file_name);
	  echo "<meta http-equiv='refresh' content='1; URL=report_mgr.php?status=import_employee&filename=$file_name'>";
  
 //if (file_exists("opencaseplanFiles/".$file_name))
//      {
//      echo $file_name." This files is Duplicate Data ";
//	  echo "<meta http-equiv='refresh' content='2; URL=uploadplan_project.php'>";
//      }
//    else
//      {
//     
//      }

	  //$keep="odmFiles/".$file_name;

//End move file
?>