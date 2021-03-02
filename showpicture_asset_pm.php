<?
include("connect_inv.php");

	$asset_no = $_REQUEST['asset_no'];
	$wweek = $_REQUEST['wweek'];
	$mmonth = $_REQUEST['mmonth'];
	$yyear = $_REQUEST['yyear'];
	$filename = $_REQUEST['filename'];
	$filename = str_replace("pm_picture/","",$filename);
	 
	$select="select convert(varchar, datepm, 103)as  dateadddate from   tbasset_pm_result
 where asset_no='$asset_no' and week = '$wweek' and month = '$mmonth' and year = '$yyear' ";
				$re=mssql_query($select);
				$num=mssql_num_rows($re);
				if($num>0){
					$row=mssql_fetch_array($re);
	$date_time=$row['dateadddate'];
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



