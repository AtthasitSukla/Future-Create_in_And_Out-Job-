<?
include("connect_inv.php");

	$id = $_REQUEST['id'];
	$filename = $_REQUEST['filename'];
	$filename = str_replace("asset_picture/","",$filename);
	 
	$select="select convert(varchar, dateadd, 103)as  dateadddate,
	convert(varchar, dateadd, 108)as  dateaddtime from   tbasset_picture where filename='$filename' and pos = '$id' ";
				$re=mssql_query($select);
				$num=mssql_num_rows($re);
				if($num>0){
					$row=mssql_fetch_array($re);
	$date_time=$row['dateadddate']." ".$row['dateaddtime'];
					}

	//$date_time=date("m/d/Y H:i:s");
	
    header("Content-type: image/jpeg");
   //$imgPath = 'asset_picture/A18000076_1.jpg';
   $imgPath = $_REQUEST['filename'];
   
   $image = imagecreatefromjpeg($imgPath);
    $color = imagecolorallocate($image, 255, 255, 0);
    $string = $date_time;
   $fontSize = 3;
   $x = 20;
   $y = 20;
    imagestring($image, $fontSize, $x, $y, $string, $color);
 	imagejpeg($image);
  
  
?>



