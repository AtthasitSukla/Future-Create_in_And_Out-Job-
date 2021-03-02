<? //include("connect.php");

$host = "WIN-GRCB1K9LF1N";
$username = "sloxixa";
$password = "eaotft139@%";
$db = "dhrdb";

$sql = mssql_connect($host, $username, $password) or die("Cannot connect");
mssql_select_db($db);
?>
<?
$date_time = date("m/d/Y H:i:s");
$date_num = date("m/d/Y");
//$status = $_REQUEST['status'];
$select_date = $_POST['select_date'];
$select_date_arr = explode("/", $select_date);
$select_date_sql = $select_date_arr[1] . "/" . $select_date_arr[0] . "/" . $select_date_arr[2];

$shift = $_POST['shift'];
$site = $_POST['site'];
$pos = $_POST['id'];

$filename = $site . $shift . $select_date_arr[1] . $select_date_arr[0] . $select_date_arr[2] . $pos;
$filename = $filename . ".jpg";
		
$select1 = "SELECT  pos from  tb5s_picture 
where site='$site' 
and createdate = '$select_date_sql' 
and shift='$shift' 
and pos='$pos' ";
$re1 = mssql_query($select1);
$num1 = mssql_num_rows($re1);
if ($num1 <= 0) {

	$insert = "INSERT into tb5s_picture
	(site, createdate, pos, filename, jobstatus, shift, jobstatus_picture_line,photo_date_time) 
	values
	('$site', '$select_date_sql', $pos, '$filename', 'New', '$shift', 'New','$date_time')";
	mssql_query($insert);


}else{
	$update = "UPDATE tb5s_picture set photo_date_time='$date_time' ,jobstatus='New' ,jobstatus_approve=NULL
	where site='$site' 
	and createdate = '$select_date_sql' 
	and shift='$shift' 
	and pos='$pos' ";
	mssql_query($update);
}
if (isset($_FILES['myFile'])) {

	if (trim($_FILES["myFile"]["tmp_name"]) != "") {
		$images = $_FILES["myFile"]["tmp_name"];
		$new_images = $filename;
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


		ImageJPEG($images_fin, "5spicture/" . $new_images);
		ImageDestroy($images_orig);
		ImageDestroy($images_fin);
	}

	echo $filename;

}

?>
