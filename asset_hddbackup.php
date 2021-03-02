<? include("connect_inv.php");  ?>
<?
	
	$asset_no  = $_REQUEST['asset_no'];
	$status = $_REQUEST['status'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>I-Wis : Harddisk Backup Status</title>
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


	
	

			




				



function show_backup(){
	var year = $("#year").val();
//	var location = $("#location").val();
	$("#showsummary").html('loading..');
	$.post("getajax_asset_backup.php",{
				status:"show_backup",year:year,
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
	function showupdate(mmonth,yyear,departmentid){
	//	alert(departmentid);
		$("#backupdetail").val('');
		$("#hddepartmentid").val(departmentid);
		$("#hdbackupmonth").val(mmonth);
		$("#hdbackupyear").val(yyear);
		$.post("getajax_asset_backup.php",{
				status:"showupdate",backupmonth:mmonth,backupyear:yyear,departmentidx:departmentid,
				sid:Math.random()}).done(function(data){
				//alert(data);
					$("#backupdetail").val(data);
					$("#myModalBackup").modal('show');
					});
		
		}
	function close_tb_backup(){
	$("#backupdetail").val('');
	$("#hdbackupmonth").val('');
	$("#hdbackupyear").val('');
	$("#myModalBackup").modal('hide');
}
function save_backup(){
	var backupdetail = $("#backupdetail").val();
	//alert(backupdetail);
	var backupmonth = $("#hdbackupmonth").val();
	var backupyear = $("#hdbackupyear").val();
	var departmentid = $("#hddepartmentid").val();
	$.post("getajax_asset_backup.php",{
				status:"save_backup",backupdetail:backupdetail,backupmonth:backupmonth,backupyear:backupyear,departmentid:departmentid,
				sid:Math.random()}).done(function(data){
				alert('save complete');
				close_tb_backup();
				show_backup();
				//	$("#backupdetail").html(data);
				//	$("#myModalBackup").modal('show');
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
  <div class="modal fade" id="myModalBackup" role="dialog">
    <div class="modal-dialog" style="width:800px">
    
      <!-- Modal content-->
      <div class="modal-content" style="width:100%">
        <div class="modal-header">
          <!--button type="button" class="close" data-dismiss="modal">&times;</button-->
          <h4 class="modal-title"><strong><font color="#e73c3c">รายละเอียดการ Backup</font></strong></h4>
        </div>
        <div class="modal-body">
            <div class="form-group">
            <input type="hidden" id="hddepartmentid">
            <input type="hidden" id="hdbackupmonth"> <input type="hidden" id="hdbackupyear">
                <textarea id="backupdetail" class="form-control"  rows="4"></textarea>
            </div>
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-default" onclick="save_backup();">Save</button>
          <button type="button" class="btn btn-default" onclick="close_tb_backup()">Close</button>
        </div>
      </div>
      
    </div>
  </div>
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

		

	<table align="center" width="100%" border="0" cellspacing="2" cellpadding="0" >
  <tr >
  <td width="6%" height="40" align="right"><strong>Year</strong></td>
  <td width="19%"><select id="year" class="form-control"  name="year"   style="width:200px;">
   
    <?
		$yyear = date('Y');
		$location = "HQ Office";
		for($i=$yyear-1;$i<=$yyear+5;$i++){
			?>
			 <option <?
             	if($yyear==$i){
					?> selected<?
					}
			 ?> value="<?=$i?>"><?=$i?></option>
			<?
			}
    	
	?>
     </select></td>
     
    <td width="13%" height="40" align="left"><input type="button" value="Select" onClick="show_backup();"></td>
   <td width="30%" align="center"></td>
     <td width="24%"></td>
     <td width="8%" align="right"></td>
    </tr></table>
    
          <hr>
          	<div id="showsummary">
            
            
            
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