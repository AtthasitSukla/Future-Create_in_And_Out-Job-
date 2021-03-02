<? include("connect.php");  ?>
<?
$date_time = date("m/d/Y H:i:s");
//$status = $_REQUEST['status'];
$job_id_problem = $_REQUEST['job_id_problem'];
$pos = $_REQUEST['pos'];
$pos_pic = "_" . $pos;
$pic_problem = $job_id_problem.$pos_pic.".jpg";
//$step = $_REQUEST['step'];

$select1 = "SELECT * FROM tbdaily_report_activity_external_problem_picture  where job_id_problem='$job_id_problem' AND pos='$pos'";
$re1=mssql_query($select1);
$num1=mssql_num_rows($re1);
if($num1<=0){
	$insert = "INSERT INTO tbdaily_report_activity_external_problem_picture (job_id_problem,pic_problem,pos,create_date) VALUES ('$job_id_problem','$pic_problem','$pos','$date_time')";
	mssql_query($insert);
}else{
	$update = "UPDATE tbdaily_report_activity_external_problem_picture set create_date='$date_time' where job_id_problem='$job_id_problem' AND pos='$pos'  ";
	mssql_query($update);
}


if (isset($_FILES['myFile'])) {

	if (trim($_FILES["myFile"]["tmp_name"]) != "") {
		$images = $_FILES["myFile"]["tmp_name"];
		$new_images = $pic_problem;
		//copy($_FILES["myFile"]["tmp_name"],"uploads/".$_FILES["myFile"]["name"]);
		$width = 900; //*** Fix Width & Heigh (Autu caculate) ***//
		$size = GetimageSize($images);
		$height = round($width * $size[1] / $size[0]);
		$images_orig = ImageCreateFromJPEG($images);
		$photoX = ImagesX($images_orig);
		$photoY = ImagesY($images_orig);
		$images_fin = ImageCreateTrueColor($width, $height);
		ImageCopyResampled($images_fin, $images_orig, 0, 0, 0, 0, $width + 1, $height + 1, $photoX, $photoY);


		//add datetime to image
		$color = imagecolorallocate($images_fin, 255, 255, 0);
		$string = $date_time;
		$fontSize = 3;
		$x = 20;
		$y = 20;
		ImageString($images_fin, $fontSize, $x, $y, $string, $color);


		ImageJPEG($images_fin, "daily_problem/" . $new_images);
		ImageDestroy($images_orig);
		ImageDestroy($images_fin);
	}

	echo $pic_problem;
}
?>