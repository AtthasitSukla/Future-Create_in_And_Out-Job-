<? include("connect_inv.php");
include("library.php");

 ?>
<?
	
	$asset_no  = $_REQUEST['asset_no'];
	$status = $_REQUEST['status'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>ทะเบียนรายการเครื่องจักรอุปกรณ์</title>
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
	var asset_group=$("#asset_group").val();
	$("#showsummary").html('loading..');
	$.post("getajax_asset.php",{
				status:"show_pm",year:year,location:location,asset_group:asset_group,
				sid:Math.random()}).done(function(data){
					$("#showsummary").html(data);
					
					});
	}
	
	
	function save_pm(week,month,year,asset_no){
		var txtstatus = "";
		var location = $("#location").val();
		//alert($("."+asset_no+week+month).prop("checked"));
		if($("."+asset_no+week+month).prop("checked")==true){
				//txtstatus = "";
			}
		if($("."+asset_no+week+month).prop("checked")==false){
				txtstatus = "delete";
			}
		$.post("getajax_asset.php",{
				status:"save_pm",week:week,month:month,year:year,asset_no:asset_no,
				txtstatus:txtstatus,location:location,
				sid:Math.random()}).done(function(data){
				//alert(data);
					//$("#showsummary").html(data);
					
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

		
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#FFFFFF">
	
		  <table cellspacing="0" cellpadding="0" width="100%" style="border:1px solid">
		   
		    <tr>
		      <td colspan="3" align="center" valign="middle"><img width="150" src="asset_form_wh_clip_image002.png">
		        </td>
		      <td colspan="3" align="center"><h3><strong>IPACK Logistics    Co.,Ltd</strong></h3></td>
              <td colspan="3" > </td>
	        </tr>
            <tr>
		      <td colspan="3" align="center" valign="middle">
		        </td>
		      <td colspan="3" align="center"><strong>ทะเบียนรายการเครื่องจักรอุปกรณ์</strong></td>
              <td colspan="3" > </td>
	        </tr>
		  
		    
		    <tr>
		      <td height="35" align="center" bgcolor="#CCCCCC" style="border:1px solid"><strong>ลำดับ</strong></td>
		      <td align="center" bgcolor="#CCCCCC" style="border:1px solid"><strong>Asset No.</strong></td>
		      <td align="center" bgcolor="#CCCCCC" style="border:1px solid"><strong>วันที่ติดตั้ง</strong></td>
		      <td align="center" bgcolor="#CCCCCC" style="border:1px solid"><strong>ชื่อเครื่องจักร</strong></td>
		      <td align="center" bgcolor="#CCCCCC" style="border:1px solid"><strong>หมายเลขเครื่องจักร</strong></td>
		      <td align="center" bgcolor="#CCCCCC" style="border:1px solid"><strong>ยี่ห้อ/รุ่น/ขนาด</strong></td>
		      <td align="center" bgcolor="#CCCCCC" style="border:1px solid"><strong>SERIAL NO.</strong></td>
		      <td align="center" bgcolor="#CCCCCC" style="border:1px solid"><strong>สถานที่ติดตั้ง/ใช้งาน</strong></td>
		      <td align="center" bgcolor="#CCCCCC" style="border:1px solid"><strong>หมายเหตุ</strong></td>
	        </tr>
            <?
            	$select = "select
				convert(varchar, po_open_date, 103)as po_open_date2,
				convert(varchar, po_open_date, 108)as po_open_time,
				convert(varchar, purchase_date, 103)as purchase_date2,
				convert(varchar, purchase_date, 108)as purchase_time,
				convert(varchar, warranty_start, 103)as warranty_start_date,
				convert(varchar, warranty_start, 108)as warranty_start_time,
				convert(varchar, warranty_end, 103)as warranty_end_date,
				convert(varchar, warranty_end, 108)as warranty_end_time,*
				from  tbasset where  asset_group ='Warehouse Equipment' ";
					$re = mssql_query($select);
					$num=mssql_num_rows($re);
					if($num>0){
						$i=0;
					 while($row = mssql_fetch_array($re)){
						 $i++;
							?>
							 <tr>
		      <td height="30" align="center" style="border:1px solid"><?=$i?>.</td>
		      <td align="center" style="border:1px solid"><?=$row['asset_no']?></td>
		      <td align="center" style="border:1px solid"><?=$row['purchase_date2']?></td>
		      <td align="center" style="border:1px solid"><?=lang_thai_from_database($row['asset_name'])?></td>
		      <td align="center" style="border:1px solid"><?=$row['serialnumber']?></td>
		      <td align="center" style="border:1px solid"><?=lang_thai_from_database($row['model'])?></td>
		      <td align="center" style="border:1px solid">ไม่มี</td>
		      <td align="center" style="border:1px solid">WH# ข้างออฟฟิต</td>
		      <td align="center" style="border:1px solid">&nbsp;</td>
	        </tr>
							<?
					 	}
					}
			?>
		   
	      </table>
		 </td>
  </tr>
</table>
          <div style="text-align:right">
            FM-MN-01 rev.00 : 15/9/2015
          </div>  
			 
        
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