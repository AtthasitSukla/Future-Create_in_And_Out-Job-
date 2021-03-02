<? include("connect_inv.php");  ?>
<?
	
	$asset_no  = $_REQUEST['asset_no'];
	$status = $_REQUEST['status'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>FM-IT-04 Check Sheet Preventive Maintenance</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="I-Wis">
	<meta name="author" content="The Red Team">

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
<!--<script type="text/javascript" src="assets/js/less.js"></script>-->
<script language="JavaScript" type="text/javascript">
  //window.onbeforeunload = confirmExit;
 // function confirmExit()
 // {
//	 //  if(confirm("คุณต้องการปิดหน้าต่างนี้ ใช่ไหม?")==true){
//		  if(document.getElementById('data_issue').value!=''){
//		 if(document.getElementById('data_master_qty').value!=document.getElementById('data_actual_qty').value){
//			  window.open('popnotcomplete.php?Issue_No='+document.getElementById('data_issue').value,'width=1000,height=600, scrollbar=yes');
//			//return true;
//			 }
//		  }
//		   
//		  // }
//	 
//  // return "คุณต้องการปิดหน้าต่างนี้ ใช่ไหม";
//	//
//  }
</script>


    
    
<script>

$(function(){
	
	
	
	
		
	});

function myTrim(x){return x.replace(/^\s+|\s+$/gm,'')}


	
	

			




				



function show_pm(){
	var year = $("#year").val();
	var location = $("#location").val();
	$.post("getajax_asset.php",{
				status:"show_pm",year:year,location:location,
				sid:Math.random()}).done(function(data){
					$("#showsummary").html(data);
					
					});
	}
	
	
	function update_tbasset_pm_result(){
		var asset_no = $("#asset_no").val();
		var asset_status = $("#asset_status").val();
		var numrow = $("#numrow").val();
		var week = $("#week").val();
		var month = $("#month").val();
		var year = $("#year").val();
		var datepm = $("#datepm").val();
		var data_pm = [];
		
						for(i=1;i<=numrow;i++){
							//alert($("#asset_pm_solution"+i).val().toString());
							var row = {};
							row['asset_pm_solution'] = $("#asset_pm_solution"+i).val().toString();
							row['asset_pm_detail'] = $("#asset_pm_detail"+i).val().toString();
							row['asset_pm_result'] = $("#asset_pm_result"+i).val().toString();
							row['pm_condition_id'] = $("#pm_condition_id"+i).val();
							data_pm.push(row);
							}
		
		$.post("getajax_asset.php",{
				status:"update_tbasset_pm_result",
				week:week,
				month:month,
				year:year,
				asset_no:asset_no,
				data_pm:data_pm,
				datepm:datepm,
				asset_status:asset_status
				}).done(function(data){
				//alert(data);
					//$("#showsummary").html(data);
					alert('save complete');
					});
		}
	
	
</script>
<style>
 .image-upload > input
{
    display: none;
}

.image-upload img
{
    width: 80px;
    cursor: pointer;
}

 </style>
</head>

<body>
<!-- Modal -->
  
<!-- Modal -->


    <header class="navbar navbar-inverse navbar-fixed-top" role="banner">
        <a id="leftmenu-trigger" class="tooltips" data-toggle="tooltip" data-placement="right" title="Toggle Sidebar"></a>
       

        <div class="navbar-header pull-left">
           
        </div>

        <ul class="nav navbar-nav pull-right toolbar">
		</ul>
        
    </header>

    <div id="page-container">
        <!-- BEGIN SIDEBAR -->
        <nav id="page-leftbar" role="navigation">
                <!-- BEGIN SIDEBAR MENU -->
             <? include("menu.php");  ?>
            <!-- END SIDEBAR MENU -->
        </nav>

        <!-- BEGIN RIGHTBAR -->
        <div id="page-rightbar">

            
        </div>
        <!-- END RIGHTBAR -->
<div id="page-content">
	<div id='wrap'>
		<div id="page-heading">
			

			
			
		</div>
		<div class="container">

		

	
    <?
    	if($status==''){
			
			$asset_no = $_REQUEST['asset_no'];
			$week = $_REQUEST['week'];
			$month = $_REQUEST['month'];
			$year = $_REQUEST['year'];
			$select="select asset_status,pm_type,location,asset_name from  tbasset where asset_no = '$asset_no' ";
				$re=mssql_query($select);
				$num=mssql_num_rows($re);
				if($num>0){
					$row=mssql_fetch_array($re);
					$pm_type = $row['pm_type'];
					$location = $row['location'];
					$asset_name = $row['asset_name'];
					$asset_status  = $row['asset_status'];
					}
					
	$select2="select * from  tbasset_pm  where asset_no = '$asset_no' and week='$week' and month='$month' and year='$year' ";
				$re2=mssql_query($select2);
				$num2=mssql_num_rows($re2);
				if($num2>0){
					$row2=mssql_fetch_array($re2);
						//$datepm = $row2['datepm'];
						$asset_status  = $row2['asset_status'];
					}	
					
		$select2="select CONVERT(varchar, datepm, 101) as datepm from  tbasset_pm_result  where asset_no = '$asset_no' and week='$week' and month='$month' and year='$year'";
				$re2=mssql_query($select2);
			
					$row2=mssql_fetch_array($re2);
					$datepm = $row2['datepm'];
					//$datepm_time = $row2['datepmtime'];
			
				?>
				
				<table cellspacing="0" border="1" cellpadding="0">
				 
				  <tr  bgcolor="#FFFFFF">
				    <td width="137"></td>
				    <td colspan="3" align="center"><strong>Check Sheet Preventive Maintenance</strong></td>
				   
				    <td width="206"></td>
			      </tr>
				  <tr>
				    <td></td>
				    <td rowspan="2" width="332"><input type="text" id="asset_no" value="<?=$asset_no?>" readonly></td>
				    <td align="left" valign="top">
				      </td>
				    <td></td>
				    <td></td>
			      </tr>
				  <tr>
				    <td align="left"  bgcolor="#FFFFFF">ชื่อเครื่อง    </td>
				    <td align="right">&nbsp;</td>
				    <td align="right">location</td>
				    <td><?=$location?></td>
			      </tr>
				  <tr  bgcolor="#FFFFFF">
				    <td></td>
				    <td><?=$asset_name?></td>
				    <td align="right">&nbsp;</td>
				    <td align="right">วันที่ตรวจ</td>
				    <td><input type="text" id="datepm" value="<?
                    if($datepm!=''){
						echo $datepm;
					//	echo " ";
					//	echo $datepm_time;
						}else{
						echo date('m/d/Y');
						}
					?>"><input type="hidden" id="year" value="<?=$year?>"><input type="hidden" id="month" value="<?=$month?>"><input type="hidden" id="week" value="<?=$week?>"></td>
			      </tr>
				  <tr>
				    <td align="center" bgcolor="#CCCCCC">No</td>
				    <td width="332" align="center" bgcolor="#CCCCCC">ชื่อ</td>
				    <td width="189" align="center" bgcolor="#CCCCCC">ผลการตรวจสอบ</td>
				    <td width="206" align="center" bgcolor="#CCCCCC">อาการที่พบ</td>
				    <td width="206" align="center" bgcolor="#CCCCCC">การแก้ไข</td>
			      </tr>
                  <?
                 $selectc="select * from  tbasset_pm_condition where pm_type='$pm_type' ";
				$rec=mssql_query($selectc);
				$numc=mssql_num_rows($rec);
				if($num>0){
					$i = 0;
					while($rowc=mssql_fetch_array($rec)){
						$i++;
						
			$select2="select * from  tbasset_pm_result  where asset_no = '$asset_no' and week='$week' and month='$month' and year='$year' and pm_condition_id='".$rowc['pm_condition_id']."'";
				$re2=mssql_query($select2);
				$num2=mssql_num_rows($re2);
				if($num2>0){
					$row2=mssql_fetch_array($re2);
					$asset_pm_result = $row2['asset_pm_result'];
					$asset_pm_solution = $utf8 = iconv("tis-620", "utf-8", $row2['asset_pm_solution'] );
					$asset_pm_detail = $utf8 = iconv("tis-620", "utf-8", $row2['asset_pm_detail'] );
					
					
					}	
						?>
						<tr  bgcolor="#FFFFFF">
				    <td  align="center" ><?=$i?>.</td>
				    <td   width="332"><?=$utf8 = iconv("tis-620", "utf-8", $rowc['pm_title'] );?></td>
				    <td  align="center"><input type="hidden" id="pm_condition_id<?=$i?>" value="<?=$rowc['pm_condition_id']?>"><select id="asset_pm_result<?=$i?>" style="background-color:#FF9">
                    <option value="">Select</option>
                    <option value="normal" <?
                    if($asset_pm_result=='normal'){
						?> selected<?
						}
					?>>ปกติ</option>
                    <option value="abnormal" <?
                    if($asset_pm_result=='abnormal'){
						?> selected<?
						}
					?>>ผิดปกติ</option>
                    <option value="nocheck" <?
                    if($asset_pm_result=='nocheck'){
						?> selected<?
						}
					?>>ไม่ตรวจสอบ</option>
                    </select></td>
				    <td  align="center"><input type="text" id="asset_pm_detail<?=$i?>" value="<?=$asset_pm_detail?>" style="background-color:#FF9"></td>
				    <td  align="center"><input type="text" id="asset_pm_solution<?=$i?>" value="<?=$asset_pm_solution?>" style="background-color:#FF9"></td>
			      </tr>
						<?
						}
					
					?>
                    <tr><td  colspan="5" align="center">ผลการตรวจสอบ สถานะของอุปกรณ์  <select id="asset_status" style="background-color:#FF9">
                    <option value="">Select</option>
                    <option value="normal_use" <?
                    if($asset_status=='normal_use'){
						?> selected<?
						}
					?>>ปกติ ยังใช้งานอยู่</option>
                    
                    <option value="normal_nouse" <?
                    if($asset_status=='normal_nouse'){
						?> selected<?
						}
					?>>ปกติ ไม่ใช้งาน</option>
                    
                     <option value="abnormal" <?
                    if($asset_status=='abnormal'){
						?> selected<?
						}
					?>>ผิดปกติ ใช้งานไม่ได้ เสีย</option>
                    
                    <option value="disappear" <?
                    if($asset_status=='disappear'){
						?> selected<?
						}
					?>>สูญหาย</option>
                    
                    </select></td></tr>
                    <tr><td colspan="5" align="right" style="padding-right:5px"> FM-IT-04 Rev.00 6/3/18</td></tr>
					<tr><td height="50" colspan="5" align="center"><input type="hidden" id="numrow" value="<?=$i?>"><input type="button" value="Save" onClick="update_tbasset_pm_result();"><input type="button" value="Back" onClick="location='asset_viewer.php?asset_no=<?=$asset_no?>'"></td></tr>
                   
                   
					
					<?
					}
				  ?>
                  
				  
				 
				  
				  
				  
		  </table>

<?
			}
			
			
	?>
            
              
			 
        
        <!-- container -->
	</div> <!--wrap -->
</div> <!-- page-content -->

  

</div> <!-- page-container -->


</div>
<!--
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>

<script>!window.jQuery && document.write(unescape('%3Cscript src="assets/js/jquery-1.10.2.min.js"%3E%3C/script%3E'))</script>
<script type="text/javascript">!window.jQuery.ui && document.write(unescape('%3Cscript src="assets/js/jqueryui-1.10.3.min.js'))</script>
-->

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