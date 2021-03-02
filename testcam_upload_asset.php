<? include("connect_inv.php");  ?>
<?
$date_time=date("m/d/Y H:i:s");

$asset_no = $_REQUEST['asset_no'];
$id = $_REQUEST['id'];
$pos = $_REQUEST['pos'];
//$empno = $_REQUEST['empno'];
//$dn = $_REQUEST['dn'];
//$pos = substr($dn,-2);


//$pos = intval($pos);

$pos_pic ="_".$pos;

//$dn=substr($dn,0,7);
//$Issue_No=$transactionID;
$filename = $asset_no.$pos_pic.".jpg";
//$step = $_REQUEST['step'];

	
	$select1="select * from  tbasset_picture where asset_no='$asset_no'  and filename = '".$filename."'";
	$re1=mssql_query($select1);
	$num1=mssql_num_rows($re1);
	if($num1<=0){
		 $ins="insert into  tbasset_picture(asset_no,pos, filename, dateadd) values('$asset_no','$id','$filename','$date_time') ";
		 mssql_query($ins);
		}else{
			$update="update tbasset_picture set dateadd='$date_time' where asset_no='$asset_no'  and filename = '".$filename."' ";
		 mssql_query($update);
			}
	
if (isset($_FILES['myFile'])) {
    // Example:
    //move_uploaded_file($_FILES['myFile']['tmp_name'], "uploads/" . $filename);
   
	
	if(trim($_FILES["myFile"]["tmp_name"]) != "")
	{
		$images = $_FILES["myFile"]["tmp_name"];
		$new_images = $filename;
		//copy($_FILES["myFile"]["tmp_name"],"uploads/".$_FILES["myFile"]["name"]);
		$width=900; //*** Fix Width & Heigh (Autu caculate) ***//
		$size=GetimageSize($images);
		$height=round($width*$size[1]/$size[0]);
		$images_orig = ImageCreateFromJPEG($images);
		$photoX = ImagesX($images_orig);
		$photoY = ImagesY($images_orig);
		$images_fin = ImageCreateTrueColor($width, $height);
		ImageCopyResampled($images_fin, $images_orig, 0, 0, 0, 0, $width+1, $height+1, $photoX, $photoY);
		ImageJPEG($images_fin,"asset_picture/".$new_images);
		ImageDestroy($images_orig);
		ImageDestroy($images_fin);
	}
	
	 echo $filename;
	
}
?>