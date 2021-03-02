<? include("connect.php");  ?>
<?
	 
	//echo cal_days_in_month(CAL_GREGORIAN, 11, 2009); 
	$status = $_REQUEST['status'];
	
$empno = $_REQUEST['empno'];
$site = $_REQUEST['site'];


		//$empno='59014';
		
		
	
		$select="select *, 
		convert(varchar, startdate, 103)as  startdate,
		convert(varchar, birthdate, 103)as  birthdate ,
		convert(varchar, probationdate, 103)as  probationdate
	
	from  tbemployee where empno = '$empno' ";
				$re=mssql_query($select);
				$num=mssql_num_rows($re);
				if($num>0){
					$row=mssql_fetch_array($re);
				//	$firstname = iconv("tis-620", "utf-8", $row['firstname'] );
				//	$lastname = iconv("tis-620", "utf-8", $row['lastname'] );
					$firstname = iconv("tis-620", "utf-8", $row['firstname'] );
				    $lastname = iconv("tis-620", "utf-8", $row['lastname'] );
					$firstname_en = $row['firstname_en'];
					$lastname_en = $row['lastname_en'];
					$nickname  = iconv("tis-620", "utf-8", $row['nickname'] );
					$startdate = $row['startdate'];
					$birthdate = $row['birthdate'];
					$probationdate = $row['probationdate'];
					$site  = $row['site'];
					$select2="select positionname from tbposition where positionid ='".$row['positionid']."'  ";
					$re2=mssql_query($select2);
					$num2 = mssql_num_rows($re2);
					if($num2>0){
						$row2=mssql_fetch_array($re2);
						$positionname = $row2['positionname'];
						}
						
					}
		
		
	
	function DateDiff($strDate1,$strDate2)
	 {
				return (strtotime($strDate2) - strtotime($strDate1))/  ( 60 * 60 * 24 );  // 1 day = 60*60*24
	 }
	 function TimeDiff($strTime1,$strTime2)
	 {
				return (strtotime($strTime2) - strtotime($strTime1))/  ( 60 * 60 ); // 1 Hour =  60*60
	 }
	 function DateTimeDiff($strDateTime1,$strDateTime2)
	 {
				return (strtotime($strDateTime2) - strtotime($strDateTime1))/  ( 60 * 60  ); // 1 min =  60*60
	 }
?>

<html>
<head>
	<meta charset="utf-8">
	<title>I-Wis HQ : Employee</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="I-Wis">
	<meta name="author" content="The Red Team">

    


<link rel="stylesheet" href="fonts.css" type="text/css" charset="utf-8" />
<script type="text/javascript" src="assets/js/jquery-1.10.2.min.js"></script>
<!--<script type="text/javascript" src="assets/js/less.js"></script>-->

<script>

$(function() {

	
	});
	
	
</script>

<style type="text/css">
<!--

.demo
	{
		font-family:'Conv_free3of9',Sans-Serif;
		-webkit-transform: rotate(-90deg); 
		-moz-transform: rotate(-90deg);	
		color:#4F290F;
	}
.demo2
	{
		font-family:Arial, Helvetica, sans-serif;
		font-size:9px;
		color:#4F290F;
		font-weight:bold
	}
.demo3
	{
		font-family:Arial, Helvetica, sans-serif;
		font-size:9px;
		color:#eeeeee;
		font-weight:bold
	}
.demo4
	{
		font-family:Arial, Helvetica, sans-serif;
		font-size:3px;
		color:#eeeeee;
		font-weight:bold
	}
div.p{
	page-break-after:always;
	}
div.last{
}
hr{border-top: 1px dashed #8c8b8b;}

-->
</style>
</head>

<body >

<table width="212" align="left" height="330" border="0" cellspacing="0" cellpadding="0" background="images/empcard.png">
  <tr>
    <td height="30" align="right" style="padding-right:18px"><span class="demo2">ID : <?=$empno?></span></td>
  </tr>
  <tr>
    <td height="90" align="center"><img src="images/ipack_logo_big.png" ></td>
  </tr>
  <tr>
    <td height="100" align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="70%" align="right"><?
		
        if(file_exists("emppic/".$empno.".jpg")){
			$pic = $empno.".jpg";
			}else{
				$pic = "blank.jpg";
				}
		?><img src="emppic/<?=$pic?>"></td>
        <td width="30%" align="center"><?
        if($site!='JWD LCB'){
				?><div class="demo" style="font-size:25px">*<?=$empno?>*</div><?
				}
		?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="60" align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="20" align="center"><span class="demo3"><?=$firstname_en?>  <?=$lastname_en?></span></td>
      </tr>
      <tr>
        <td height="20" align="center"><span class="demo3"><?=$firstname?>  <?=$lastname?></span></td>
      </tr>
      <tr>
        <td height="20" align="center"><span class="demo3"><?=$positionname?></span></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="30" align="center"><span class="demo4">บริษัท ไอแพ็ค โลจิสติกส์ จำกัด</span></td>
  </tr>
</table>


<script type='text/javascript' src='assets/js/jquery-1.10.2.min.js'></script> 
<script type='text/javascript' src='assets/js/jqueryui-1.10.3.min.js'></script> 
<script type='text/javascript' src='assets/js/bootstrap.min.js'></script> 
<script type='text/javascript' src='assets/js/enquire.js'></script> 
<script type='text/javascript' src='assets/js/jquery.cookie.js'></script> 
<script type='text/javascript' src='assets/js/jquery.nicescroll.min.js'></script> 
<script type='text/javascript' src='assets/plugins/codeprettifier/prettify.js'></script> 
<script type='text/javascript' src='assets/plugins/easypiechart/jquery.easypiechart.min.js'></script> 
<script type='text/javascript' src='assets/plugins/form-multiselect/js/jquery.multi-select.min.js'></script> 
<script type='text/javascript' src='assets/plugins/sparklines/jquery.sparklines.min.js'></script> 
<script type='text/javascript' src='assets/plugins/form-toggle/toggle.min.js'></script> 
<script type='text/javascript' src='assets/js/placeholdr.js'></script> 
<script type='text/javascript' src='assets/js/application.js'></script> 
<script type='text/javascript' src='assets/plugins/bootbox/bootbox.min.js'></script> 

<script type='text/javascript' src='assets/demo/demo.js'></script> 


</body>
</html>