<? include("connect.php");  ?>
<?
//$ordernumber = $_REQUEST['ordernumber'];
$empno = $_REQUEST['empno'];
$paycode = $_REQUEST['paycode'];

		//update print count
	
if($empno!=''){
				$select="select firstname,lastname,empno,site,skill_reward,basic_wage,basic_salary,emptype from  tbemployee where empno = '$empno' ";
				$re=mssql_query($select);
				
					$row=mssql_fetch_array($re);
					$site = $row['site'];
					$skill_reward= $row['skill_reward'];
					//$empname = $row['firstname']." ".$row['lastname'];
					$empname = iconv("tis-620", "utf-8", $row['firstname']." ".$row['lastname'] );
					
					if($skill_reward==''){
						$skill_reward = 0;
						}
					$att_reward = $row['att_reward'];
					if($att_reward==''){
						$att_reward = 0;
						}
					$basic_wage =  $row['basic_wage'];
					$basic_salary =  $row['basic_salary'];
					$car_rice = 75;
					$emptype  =  $row['emptype'];
					
					if($site=='TSC'){
							$start_ot = "17:20:00";
							$start_ot_night = "05:40:00";
							
						}else{
							$start_ot = "17:30:00";
							$start_ot_night = "05:40:00";
							}
		}
				
					
		
		
		

?>
<html >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="StyleSheet2.css" type="text/css" media="print" />
<link rel="stylesheet" href="fonts.css" type="text/css" charset="utf-8" />
  <!-- <link href="assets/less/styles.less" rel="stylesheet/less" media="all">  -->
    <link rel="stylesheet" href="assets/css/styles.css?=140">
   <!-- <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600' rel='stylesheet' type='text/css'>-->

    <link href='assets/demo/variations/default.css' rel='stylesheet' type='text/css' media='all' id='styleswitcher'> 
    <link href='assets/demo/variations/default.css' rel='stylesheet' type='text/css' media='all' id='headerswitcher'> 
     
	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries. Placeholdr.js enables the placeholder attribute -->
	<!--[if lt IE 9]>
        <link rel="stylesheet" href="assets/css/ie8.css">
		<script type="text/javascript" src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/respond.js/1.1.0/respond.min.js"></script>
        <script type="text/javascript" src="assets/plugins/charts-flot/excanvas.min.js"></script>
	<![endif]-->

	<!-- The following CSS are included as plugins and can be removed if unused-->

<link rel='stylesheet' type='text/css' href='assets/plugins/codeprettifier/prettify.css' /> 
<link rel='stylesheet' type='text/css' href='assets/plugins/form-multiselect/css/multi-select.css' /> 
<link rel='stylesheet' type='text/css' href='assets/plugins/form-toggle/toggles.css' /> 
<script type="text/javascript" src="assets/js/jquery-1.10.2.min.js"></script>
<title>ATT <?=$paycode?></title>
<style type="text/css">
.demo
	{
		font-family:'Conv_free3of9',Sans-Serif;
	}
.demo2
	{
		font-family:'tahoma';
	}

.table > tbody > tr > td,
.table > tfoot > tr > td {
  padding: 3px;
  line-height: 1.428571429;
  vertical-align: top;
  border-top: 1px solid #e6e7e8;
}
</style>
</head>

<body bgcolor="#FFFFFF"  onLoad="window.print();" style="padding-top: 0px;">
  <table width="1200" border="0" height="800" cellspacing="0" cellpadding="0">
  <tr>
    <td >
     <table width="100%"  cellspacing="2" cellpadding="0">
    	<tr><td><font size="2" face="Tahoma"><strong>Emp No : <?=$empno?> Name : <?=$empname?> </strong> </font>
		</td></tr>
     </table>
   
    <table width="100%"  cellspacing="2" cellpadding="0" class="table table-striped table-bordered datatables" id="example">
     
      <tr bgcolor="#CCCCCC">
        <td width="113" height="20"  rowspan="2" align="center" bgcolor="#CCCCCC"><font size="1" face="Tahoma"><strong>Date</strong></font></td>
        <td width="85"  rowspan="2" align="center" bgcolor="#CCCCCC"><font size="1" face="Tahoma"><strong>Day Name</strong></font></td>
        <td width="63" rowspan="2" align="center" bgcolor="#CCCCCC"><font size="1" face="Tahoma"><strong>Shift</strong></font></td>
        <td width="108" rowspan="2" align="center" bgcolor="#CCCCCC"><font size="1" face="Tahoma"><strong>เวลา เข้างาน</strong></font></td>
        <td width="110" rowspan="2" align="center" bgcolor="#CCCCCC"><font size="1" face="Tahoma"><strong>เวลา ออกงาน</strong></font></td>
        <td width="71" rowspan="2" align="center" bgcolor="#CCCCCC"><font size="1" face="Tahoma"><strong>ชั่วโมงทำงาน</strong></font></td>
        <td width="108" rowspan="2" align="center" bgcolor="#CCCCCC"><font size="1" face="Tahoma"><strong>OT In</strong></font></td>
        <td width="87" rowspan="2" align="center" bgcolor="#CCCCCC"><font size="1" face="Tahoma"><strong>OT Out</strong></font></td>
        <td width="47" align="center" bgcolor="#CCCCCC"><font size="1" face="Tahoma"><strong>Normal</strong></font></td>
        <td colspan="4" align="center" bgcolor="#CCCCCC"><font size="1" face="Tahoma"><strong>OT</strong></font></td>
        <td width="50" rowspan="2" align="center" bgcolor="#CCCCCC"><font size="1" face="Tahoma"><strong>FL</strong></font></td>
        <td width="122" rowspan="2" align="center" bgcolor="#CCCCCC"><font size="1" face="Tahoma"><strong>Remark</strong></font></td>
      </tr>
     
      <tr>
        <td align="center" bgcolor="#CCCCCC"><font size="1" face="Tahoma"><strong>1</strong></font></td>
        <td width="41" align="center" bgcolor="#CCCCCC"><font size="1" face="Tahoma"><strong>1</strong></font></td>
        <td width="49" align="center" bgcolor="#CCCCCC"><font size="1" face="Tahoma"><strong>1.5</strong></font></td>
        <td width="54" align="center" bgcolor="#CCCCCC"><font size="1" face="Tahoma"><strong>2</strong></font></td>
        <td width="58" align="center" bgcolor="#CCCCCC"><font size="1" face="Tahoma"><strong>3</strong></font></td>
        </tr>
       <?
	 
					
	   
      	$select0="SELECT *,
		convert(varchar, iworkdate, 103)as  iworkdate2,
		convert(varchar, iattDateTime1, 103)as  iattDate1,
		convert(varchar, iattDateTime1, 108)as  iattTime1,
		convert(varchar, iattDateTime2, 103)as  iattDate2,
		convert(varchar, iattDateTime2, 108)as  iattTime2 ,
		convert(varchar, iotin, 108)as  iotintime,
		convert(varchar, iotout, 108)as  iotouttime 
FROM    tbatt_approve where empno='$empno' and paycode='$paycode'  order by iworkdate asc ";
	$re0=mssql_query($select0);
	$num0 = mssql_num_rows($re0);
	if($num0>0){
		
	while($row0=mssql_fetch_array($re0)){
		
		
		
		//check leave date
		$select_le = "select * from  tbleave where CAST(leavestartdate AS DATE)='".$row0['iworkdate']."' and empno='$empno'  ";
				$re_le=mssql_query($select_le);
				$num_le=mssql_num_rows($re_le);
				if($num_le>0){
					$row_le=mssql_fetch_array($re_le);
					$leavetypeid = $row_le['leavetypeid'];
					$select_ln = "select leavename from tbleavetype where   leavetypeid='$leavetypeid'  ";
					
					$re_ln=mssql_query($select_ln);
					$row_ln=mssql_fetch_array($re_ln);
					$leavename = iconv("tis-620", "utf-8", $row_ln['leavename'] );
					
					
					}else{
						$leavetypeid = "";
						$leavename ="";
						}
		 
		
		
	  ?>
      <tr>
      
       <td height="20" align="center"><font size="1" face="Tahoma"><?=$row0['iworkdate2']?></font></td>
        <td align="center"><font size="1" face="Tahoma"><?=$row0['idayname_en']?></font></td>
        <td align="center"><font size="1" face="Tahoma"><?=$row0['iShift']?></font></td>
        <td align="center"><font size="1" face="Tahoma"><?
		if($row0['iworkhours']!='0'){
			echo $row0['iattDate1']?> <?=$row0['iattTime1'];
			}else{
											//check leave date
				$select_le = "select * from  tbleave_transaction where '".$row0['iworkdate']."' between CAST(leavestartdate AS DATE) and CAST(leaveenddate AS DATE) and empno='$empno' and statusapprove='Approve'  ";
				$re_le=mssql_query($select_le);
				$num_le=mssql_num_rows($re_le);
				if($num_le>0){
					$row_le=mssql_fetch_array($re_le);
					$leavetypeid = $row_le['leavetypeid'];
					
				
					
					$select_ln = "select leavename from tbleavetype where   leavetypeid='$leavetypeid'  ";
					
					$re_ln=mssql_query($select_ln);
					$row_ln=mssql_fetch_array($re_ln);
					$leavename = iconv("tis-620", "utf-8", $row_ln['leavename'] );
					//$leavename = $row_ln['leavename'];
					echo $leavename;
					}
				}
		?></font>
		</td>
         <td align="center"><font size="1" face="Tahoma"><?
         if($row0['iworkhours']!='0'){
		 echo $row0['iattDate2']?> <?=$row0['iattTime2'];
		 } ?></font></td>
          <td align="center"><font size="1" face="Tahoma"><?=$row0['iworkhours']?></font></td>
        <td align="center"><font size="1" face="Tahoma"><?
		 if($row0['iworkhours']!='0'){
			 echo $row0['iotintime'];
			 }
		?></font></td>
        <td align="center"><font size="1" face="Tahoma"><?
		if($row0['iworkhours']!='0'){
			echo $row0['iotouttime'];
			}
		?></font></td>
        <td align="center"><font size="1" face="Tahoma"><?
        if($row0['iworkhours']!='0'){
		echo $row0['inormal'];
		}
		?></font></td>
        <td width="41" align="center"><font size="1" face="Tahoma"><?
		 if($row0['iworkhours']!='0'){
			echo $row0['irate1'];
			$tirate1 = $tirate1+$row0['irate1'];
		 }?></font></td>
        <td width="49" align="center"><font size="1" face="Tahoma"><?
		 if($row0['iworkhours']!='0'){
		echo $row0['irate1_5'];
		$tirate1_5 = $tirate1_5+$row0['irate1_5'];
		 }?></font></td>
        <td width="54" align="center"><font size="1" face="Tahoma"><?
		if($row0['iworkhours']!='0'){
		echo $row0['irate2'];
		$tirate2 = $tirate2+$row0['irate2'];
		}?></font></td>
        <td width="58" align="center"><font size="1" face="Tahoma"><?
		if($row0['iworkhours']!='0'){
		echo $row0['irate3'];
		$tirate3 = $tirate3+$row0['irate3'];
		}?></font></td>
        <td align="center"><font size="1" face="Tahoma"><?
		if($row0['iworkhours']!='0'){
		echo $row0['ifl'];
		}?></font></td>
        <td align="center"><font size="1" face="Tahoma"><?=iconv("tis-620", "utf-8", $row0['iremark'] )?><?
         if($leavetypeid==''){
			 
					 }else{
						// echo $leavename;
						 }
		?></font></td>
      </tr>
      <?
	}
	}
	  ?>
    <tr><td height="20"></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td align="center"></td>
    <td align="center"><font size="1" face="Tahoma"><?=$tirate1?></font></td>
    <td align="center"><font size="1" face="Tahoma"><?=$tirate1_5?></font></td>
    <td align="center"><font size="1" face="Tahoma"><?=$tirate2?></font></td>
    <td align="center"><font size="1" face="Tahoma"><?=$tirate3?></font></td>
    <td></td>
    <td></td>
    
    </tr>  
    </table>
    
    
    </td>
  </tr>
</table>

 
   
  
  
  



</body>
</html>


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
