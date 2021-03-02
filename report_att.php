<? include("connect.php");  ?>
<?
	 
	$status = $_REQUEST['status'];
	//$status = $_REQUEST['status'];
	//$yyear = $_REQUEST['yyear'];
	//$mmonth = $_REQUEST['mmonth'];

$yyear = date('Y');
		
	
	
	 
	
function get_minutes ( $start, $end ) {  

   while ( strtotime($start) <= strtotime($end) ) {  
       $minutes[] = date("H:i:s", strtotime( "$start" ) );  
       $start = date("H:i:s", strtotime( "$start + 30 mins")) ;      
   }  
   return $minutes;  
}  


	 
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>I-Wis HRS : Time Attendance Report</title>
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
<style>
.loader {
  border: 16px solid #f3f3f3;
  border-radius: 50%;
  border-top: 16px solid #3498db;
  width: 60px;
  height: 60px;
  -webkit-animation: spin 2s linear infinite; /* Safari */
  animation: spin 2s linear infinite;
}

/* Safari */
@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>
<script>

$(function() {
    $(".loader").hide();
	
	});
	
function showatt(){
	//$("#xpane").html("<span class='fa-li fa fa-spinner fa-spin'></span>");
    $("#xpane").html("");
    $(".loader").show();
	var tsite =$("#tsite").val();
	var paycode =$("#paycode").val();
//	alert(datetype);
	$.post("getajax_report_att.php", { status:"showatt",tsite:tsite,paycode:paycode,
	sid: Math.random() },
   function(data) {
	  // alert(data);
	  
	// $("#xpane0").html(getFormattedDate(ddate) + ' - ' + getFormattedDate(ddate2)+ '=' + days);
	 $("#xpane").html(data);
     $(".loader").hide();
	// $("#pulsate1").pulsate({color:"#FF0000",speed:500});
	// $("#xpane0").html(getFormattedDate(ddate)+" You waited: " + difference + " seconds");
	 
	
	   });
      
	}
	
	
function showatt_month(){
	//$("#xpane").html("<span class='fa-li fa fa-spinner fa-spin'></span>");
    $("#xpane").html("");
    $(".loader").show();
	var tsite2 =$("#tsite2").val();
	var month =$("#month").val();
	//alert(tsite2);
//	alert(datetype);
	$.post("getajax_report_att.php", { status:"showatt_month",tsite2:tsite2,month:month,
	sid: Math.random() },
   function(data) {
	  // alert(data);
	  
	// $("#xpane0").html(getFormattedDate(ddate) + ' - ' + getFormattedDate(ddate2)+ '=' + days);
	 $("#xpane").html(data);
     $(".loader").hide();
	// $("#pulsate1").pulsate({color:"#FF0000",speed:500});
	// $("#xpane0").html(getFormattedDate(ddate)+" You waited: " + difference + " seconds");
	 
	
	   });
      
}
function exportatt(){

    var tsite =$("#tsite").val();
    var paycode =$("#paycode").val();
    window.location='getajax_report_att.php?status=exportatt&tsite='+tsite+'&paycode='+paycode;
  
}
function exportatt_month(){

	var tsite =$("#tsite").val();
	var paycode =$("#paycode").val();
	var tsite2 =$("#tsite2").val();
	var month =$("#month").val();
	window.location='getajax_report_att.php?status=exportatt_month&tsite2='+tsite2+'&paycode='+paycode+'&month='+month;
      
}
function export_ot(){

    var tsite =$("#tsite").val();
    var paycode =$("#paycode").val();
    window.location='getajax_report_att.php?status=export_ot&tsite='+tsite+'&paycode='+paycode;
  
}
function export_ot_month(){

	var tsite =$("#tsite").val();
	var paycode =$("#paycode").val();
	var tsite2 =$("#tsite2").val();
	var month =$("#month").val();
	window.location='getajax_report_att.php?status=export_ot_month&tsite2='+tsite2+'&paycode='+paycode+'&month='+month;
      
}
	



	
	
</script>
</head>

<body class=" ">


    <div id="headerbar">
        <div class="container">
            <div class="row">
                <div class="col-xs-6 col-sm-2">
                    <a href="#" class="shortcut-tiles tiles-brown">
                        <div class="tiles-body">
                            <div class="pull-left"><i class="fa fa-pencil"></i></div>
                        </div>
                        <div class="tiles-footer">
                            Create Post
                        </div>
                    </a>
                </div>
                <div class="col-xs-6 col-sm-2">
                    <a href="#" class="shortcut-tiles tiles-grape">
                        <div class="tiles-body">
                            <div class="pull-left"><i class="fa fa-group"></i></div>
                            <div class="pull-right"><span class="badge">2</span></div>
                        </div>
                        <div class="tiles-footer">
                            Contacts
                        </div>
                    </a>
                </div>
                <div class="col-xs-6 col-sm-2">
                    <a href="#" class="shortcut-tiles tiles-primary">
                        <div class="tiles-body">
                            <div class="pull-left"><i class="fa fa-envelope-o"></i></div>
                            <div class="pull-right"><span class="badge">10</span></div>
                        </div>
                        <div class="tiles-footer">
                            Messages
                        </div>
                    </a>
                </div>
                <div class="col-xs-6 col-sm-2">
                    <a href="#" class="shortcut-tiles tiles-inverse">
                        <div class="tiles-body">
                            <div class="pull-left"><i class="fa fa-camera"></i></div>
                            <div class="pull-right"><span class="badge">3</span></div>
                        </div>
                        <div class="tiles-footer">
                            Gallery
                        </div>
                    </a>
                </div>

                <div class="col-xs-6 col-sm-2">
                    <a href="#" class="shortcut-tiles tiles-midnightblue">
                        <div class="tiles-body">
                            <div class="pull-left"><i class="fa fa-cog"></i></div>
                        </div>
                        <div class="tiles-footer">
                            Settings
                        </div>
                    </a>
                </div>
                <div class="col-xs-6 col-sm-2">
                    <a href="#" class="shortcut-tiles tiles-orange">
                        <div class="tiles-body">
                            <div class="pull-left"><i class="fa fa-wrench"></i></div>
                        </div>
                        <div class="tiles-footer">
                            Plugins
                        </div>
                    </a>
                </div>
                            
            </div>
        </div>
    </div>

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



			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-primary">
						
						<div class="panel-body">
                        



<?
if($status==''){
	
	
		
					
	?>
    <table align="center" width="100%" border="0" cellspacing="2" cellpadding="0" >
  <tr >
  <td width="6%" height="40" align="right"><strong>PayCode</strong></td>
  <td width="19%"><select id="paycode" class="form-control"  name="paycode"   style="width:200px;">
     <option value="">Select</option>
    <?
	
    	$select0="SELECT paycode from tbpaycode WHERE paycodeyear='$yyear' order by startdate asc ";
	$re0=mssql_query($select0);
	while($row0=mssql_fetch_array($re0)){
		?>
		 <option value="<?=$row0['paycode']?>" <?
         if($paycode==$row0['paycode']){
			 ?> selected<?
			 }
		 ?>><?=$row0['paycode']?></option>
		<?
		}
	?>
     </select></td>
      <td width="6%" height="40" align="right"><strong>Site</strong></td>
     <td width="19%"><select id="tsite" class="form-control"  name="tsite"   style="width:200px;">
     <option value="">Select</option>
    <?
    	$select0="SELECT site from  tbsite ";
	$re0=mssql_query($select0);
	while($row0=mssql_fetch_array($re0)){
		?>
		 <option value="<?=$row0['site']?>" <?
         if($tsite==$row0['site']){
			 ?> selected<?
			 }
		 ?>><?=$row0['site']?></option>
		<?
		}
	?>
     </select></td>
    <td width="13%" height="40" align="left"><input type="button" value="Select" onClick="showatt();"></td>
   <td  align="left"><input type="button" value="Export ATT" onClick="exportatt();"></td>
     <td align="left"><input type="button" value="Export OT" onClick="export_ot();"></td>
     <td width="8%" align="right"></td>
    </tr></table>
     
    <table align="center" width="100%" border="0" cellspacing="2" cellpadding="0" >
  <tr >
  <td width="6%" height="40" align="right"><strong>Month</strong></td>
  <td width="19%"><input type="month" name="month" id="month" class="form-control"></td>
      <td width="6%" height="40" align="right"><strong>Site</strong></td>
     <td width="19%"><select id="tsite2" class="form-control"  name="tsite2"   style="width:200px;">
     <option value="">Select</option>
    <?
    	$select0="SELECT site from  tbsite ";
	$re0=mssql_query($select0);
	while($row0=mssql_fetch_array($re0)){
		?>
		 <option value="<?=$row0['site']?>" <?
         if($tsite==$row0['site']){
			 ?> selected<?
			 }
		 ?>><?=$row0['site']?></option>
		<?
		}
	?>
     </select></td>
    <td width="13%" height="40" align="left"><input type="button" value="Select" onClick="showatt_month();"></td>
   <td  align="left"><input type="button" value="Export ATT" onClick="exportatt_month();"></td>
     <td  align="left"><input type="button" value="Export OT" onClick="export_ot_month();"></td>
     <td width="8%" align="right"></td>
    </tr></table>
    <HR>
  	<div id="xpane">
        
      </div>
     <center> <div class="loader"></div></center>
		<?
        }
		
		
		
		?>	


	  

					  </div>
					</div>
				</div>
			</div>



			



		</div> <!-- container -->
	</div> <!--wrap -->
</div> <!-- page-content -->

    <footer role="contentinfo">
        <div class="clearfix">
            <ul class="list-unstyled list-inline">
                <li>I-Wis</li>
                <button class="pull-right btn btn-inverse-alt btn-xs hidden-print" id="back-to-top"><i class="fa fa-arrow-up"></i></button>
            </ul>
        </div>
    </footer>

</div> <!-- page-container -->

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