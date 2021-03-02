<? include("connect_inv.php");  ?>
<?
$date_time=date("m/d/Y H:i:s");

$pmid = $_REQUEST['pmid'];


$filename = $pmid.".jpg";
//$step = $_REQUEST['step'];

	
	
	
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
		ImageJPEG($images_fin,"pm_picture/".$new_images);
		ImageDestroy($images_orig);
		ImageDestroy($images_fin);
	}
	
	 echo $filename;
	
}
?>