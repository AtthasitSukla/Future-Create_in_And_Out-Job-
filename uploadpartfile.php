<?
  $file_name=$_FILES["filename"]["name"];
  $file_type=$_FILES["filename"]["type"];
  $file_size=($_FILES["filename"]["size"] / 1024);
  $file_tmpname=$_FILES["filename"]["tmp_name"]; 
  
  
  // Move files
   move_uploaded_file($file_tmpname,"textfile/".$file_name);
	  echo "<meta http-equiv='refresh' content='1; URL=import_text.php?status=import_text&filename=$file_name'>";
  
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