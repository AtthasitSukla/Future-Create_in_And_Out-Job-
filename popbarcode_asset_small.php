<? include("connect_inv.php");  

	session_start();
	/*
	$host="WIN-GRCB1K9LF1N";
	$username="sloxixa";
	$password="eaotft139@%";
	$db="dinvb";
	$sql=mssql_connect($host,$username,$password) or die("Cannot connect");
	mssql_select_db($db);
	
	*/
	$location = $_REQUEST['location'];
	$asset_no = $_REQUEST['asset_no'];
?>
<?
	//$boxcode = $_REQUEST['boxcode'];
	//$qty_to_ptint = $_REQUEST['qty_to_ptint'];
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="fonts.css" type="text/css" charset="utf-8" />
<title>Untitled Document</title>
<style type="text/css">
<!--
@media all {
	.page-break	{ display: none; }
}
@media print { 
	.page-break	{ display: block; page-break-after: always; }
	.noprint { display:none; }

	
}
.demo
	{
		font-family:'Conv_free3of9',Sans-Serif;
	}
.demo2
	{
		font-family:'tahoma';
	}
div.p{
	page-break-after:always;
	}
div.last{
}

-->
</style>
</head>

<body onLoad="window.print();">


<?

// $select="SELECT  top $qty_to_ptint id, codebox_ipack, barcode_number, printby, printdate, barcode_text, barcode_status, location, revise_reason
//FROM            tbbox_barcode where codebox_ipack = '$boxcode'  order by id desc";
//	$re=mssql_query($select);
//	$num=mssql_num_rows($re);
//	//$i=0;
//	//$bg='#DFD0C4';
//	$ixx = 0;
//	while($row=mssql_fetch_array($re)){
//		$ixx++;
//		$update="update tbbox_barcode set firstprint=$ixx where barcode_number='".$row['barcode_number']."'";	
//		//echo 	$insertsql."<BR>";
//		mssql_query($update);
//		
//		}
//	
	if($location != ""){
		$select="SELECT  * from tbasset where location='$location' order by asset_no asc";
	}else if($asset_no !=""){
		$select="SELECT  * from tbasset where asset_no='$asset_no' order by asset_no asc";
	}
	$re=mssql_query($select);
	$num=mssql_num_rows($re);
	$i=0;
	$bg='#DFD0C4';
	
	while($row=mssql_fetch_array($re)){
		
		//for($ii=1;$ii<=3;$ii++){
			
		     $barcode = $row['asset_no'];
			   $asset_name = iconv("tis-620", "utf-8",$row['asset_name']);

		?>
    
		<table  border="0" cellspacing="0" cellpadding="0">
        <tr>
    <td align="center"> 
   <BR>
     </td>
  </tr>
		<tr>
    <td align="center"></td>
  </tr>
  
     <tr>
    <td align="center"><div class="demo2" style="font-size:8px; font-weight:bold;"><?=$barcode?></div><!--<img src="images/Logo IPACK (Black)2.png" />--></td>
  </tr>
  <tr>
    <td >
    <div class="demo" style="font-size:35px">*<?=$barcode?>*</div>
     </td>
  </tr>
    <tr>
    <td align="center"> 
    <div class="demo2" style="font-size:8px; font-weight:bold;"><?=$asset_name?></div>
     </td>
  </tr>
</table>
<div class="page-break"></div>
<?
		
			//}
		
	}
	
	
	//$select="SELECT  top $qty_to_ptint id, codebox_ipack, barcode_number FROM   tbbox_barcode where codebox_ipack = '$boxcode'  order by id desc";
//	$re=mssql_query($select);
//	$num=mssql_num_rows($re);
//	//$i=0;
//	//$bg='#DFD0C4';
//	$ixx = 0;
//	while($row=mssql_fetch_array($re)){
//		$ixx++;
//		$update="update tbbox_barcode set firstprint=NULL where barcode_number='".$row['barcode_number']."'";	
//	//	echo 	$insertsql."<BR>";
//		mssql_query($update);
//		
//		}
	
?>

</body>
</html>

