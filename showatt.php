<? 
session_start();
include("connect.php");  ?>
<?
	$status = $_REQUEST['status'];
	$deliveryorderdate = $_REQUEST['deliveryorderdate'];
	$datetype = $_REQUEST['datetype'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>I-Wis HQ : Show Summary</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="I-Wis">
	<meta name="author" content="The Red Team">

    <!-- <link href="assets/less/styles.less" rel="stylesheet/less" media="all">  -->
    <link rel="stylesheet" href="assets/css/styles.css?=141">
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
<link rel='stylesheet' type='text/css' href='assets/plugins/jqueryui-timepicker/jquery.ui.timepicker.css' /> 
<link rel='stylesheet' type='text/css' href='assets/plugins/form-daterangepicker/daterangepicker-bs3.css' /> 
<link rel='stylesheet' type='text/css' href='assets/js/jqueryui.css' /> 
<link rel='stylesheet' type='text/css' href='assets/plugins/codeprettifier/prettify.css' /> 
<link rel='stylesheet' type='text/css' href='assets/plugins/form-toggle/toggles.css' /> 
<script type="text/javascript" src="assets/js/jquery-1.10.2.min.js"></script>


<!-- <script type="text/javascript" src="assets/js/less.js"></script> -->
<script language="javascript">


function getFormattedDate(d){
   // var d = new Date();

d = ('0' + (d.getMonth() + 1)).slice(-2) + "/" + ('0' + d.getDate()).slice(-2) + "/" + d.getFullYear() + " " + ('0' + d.getHours()).slice(-2) + ":" + ('0' + d.getMinutes()).slice(-2) + ":" + ('0' + d.getSeconds()).slice(-2);

    return d;
}
</script>

<script>

$(function() {
	  $("#deliveryorderdate").datepicker({
		  format: 'dd/mm/yyyy'
		  });
		
});


function countdown(element, minutes, seconds) {
		showdaily('showsummary');
		//showdailyreceive('showqueue_receiver');
    // set time for the particular countdown
    var time = minutes*60 + seconds;
	var i=1;
    var interval = setInterval(function() {
        var el = document.getElementById(element);
        // if the time is 0 then end the counter
        if(time == 0) {
			// window.location = location.href;
			
			
			 el.innerHTML = '';
			  clearInterval(interval);
			countdown('countdown', 2, 0);
			//showdaily('pending_st');
           // el.innerHTML = "countdown's over!";    
          
            //return;
        }
        var minutes = Math.floor( time / 60 );
        if (minutes < 10) minutes = "0" + minutes;
        var seconds = time % 60;
        if (seconds < 10) seconds = "0" + seconds; 
        var text = minutes + ':' + seconds;
        el.innerHTML = text;
        time--;
    }, 1000);
}



function showdaily(str){
	//$("#xpane").html("<span class='fa-li fa fa-spinner fa-spin'></span>");
//	var deliveryorderdate =$("#deliveryorderdate").val();
//	var datetype =$("#datetype").val();
//	alert(datetype);
	$.post("getajax_showatt.php", { status:str,deliveryorderdate:deliveryorderdate,datetype:datetype,
	sid: Math.random() },
   function(data) {
	  // alert(data);
	  
	// $("#xpane0").html(getFormattedDate(ddate) + ' - ' + getFormattedDate(ddate2)+ '=' + days);
	 $("#xpane").html(data);
	 
	// $("#pulsate1").pulsate({color:"#FF0000",speed:500});
	// $("#xpane0").html(getFormattedDate(ddate)+" You waited: " + difference + " seconds");
	 
	
	   });
	}
	
	
	
	
function showdatang(ngtagID){
	
	$.post("getajax_summary.php", { 
	status:'showdatang',
	ngtagID:ngtagID,
	sid: Math.random() },
   function(data) {
	$("#myModal2").modal({backdrop: "static"});
	$("#img1").html(data);
	   });
}
	


</script>

</head>

<body  onload="countdown('countdown', 2, 0);">

<!-- Modal -->
  <div class="modal fade" id="myModal2" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
         
          <h4 class="modal-title">NG Information</h4>
        </div>
        <div class="modal-body">
          <div class="form-group" id="img1" style="text-align:center">
            
             
      		</div>
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
<!-- Modal -->

   

    <header class="navbar navbar-inverse navbar-fixed-top" role="banner"><div  id="countdown"></div> </header>

    <div id="page-container">
        <!-- BEGIN SIDEBAR -->
        

        <!-- BEGIN RIGHTBAR -->
    
        <!-- END RIGHTBAR -->
<div id="page-content" style="margin-left:0px">
	<div id='wrap'>
		
		<div class="container">



			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-primary">
						<div class="panel-heading">NHK Summary</div>
						<div class="panel-body">
                        




<?
if($status==''){
	
	
	
	?>
    <table width="100%">
    <tr><td width="18%" align="right"><select id="datetype" class="form-control" style="float:left">
   
     <option value="Delivery Date" <?
     if($datetype=='' || $datetype=='Delivery Date'){
		 ?> selected<?
		 }
	 ?>>Delivery Date</option>
      <option value="Receive Date" <?
     if($datetype=='Receive Date'){
		 ?> selected<?
		 }
	 ?>>Receive Date</option>
       <option value="Packing Date" <?
     if($datetype=='Packing Date'){
		 ?> selected<?
		 }
	 ?>>Packing Date</option>
        <option value="Loading Date" <?
     if($datetype=='Loading Date'){
		 ?> selected<?
		 }
	 ?>>Loading Date</option>
        
    </select></td>
    
    <td width="82%" align="left"><input type="text" class="form-control hasTimepicker" value="<?
     if($deliveryorderdate!=''){ echo $deliveryorderdate; }else{ 
	 	$date = new DateTime();
		echo $date->format('d/m/Y');
	 }
	 ?>"  maxlength="50" id="deliveryorderdate" style="width:150px; float:left" onChange="location='showsummary.php?deliveryorderdate='+this.value+'&datetype='+document.getElementById('datetype').value+'';"><input  style="float:left; height:34px" class="btn-primary" type="button" value="SEARCH" onClick="location='showsummary.php?deliveryorderdate='+document.getElementById('deliveryorderdate').value+'&datetype='+document.getElementById('datetype').value+'';"><input  style="float:left; height:34px" class="btn-primary" type="button" value="TODAY" onClick="location='showsummary.php?datetype='+document.getElementById('datetype').value+'';"></td></tr>
    </table>
    
      <div id="dis1" class="col-md-2" ></div>
    <div class="col-md-4" ></div>
     <div id="dis2"></div>
      <div id="dis3"></div>
    <div id="xpane0"></div>
   <div class="col-md-12">
    <div id="xpane"></div>
    </div>
  
   
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
<script type='text/javascript' src='assets/plugins/sparklines/jquery.sparklines.min.js'></script> 
<script type='text/javascript' src='assets/plugins/form-toggle/toggle.min.js'></script> 
<script type='text/javascript' src='assets/js/placeholdr.js'></script> 
<script type='text/javascript' src='assets/js/application.js'></script> 
<script type='text/javascript' src='assets/plugins/bootbox/bootbox.min.js'></script> 
<script type='text/javascript' src='assets/plugins/pulsate/jQuery.pulsate.min.js'></script> 
<script type='text/javascript' src='assets/plugins/jqueryui-timepicker/jquery.ui.timepicker.min.js'></script> 
<script type='text/javascript' src='assets/plugins/form-daterangepicker/daterangepicker.min.js'></script> 
<script type='text/javascript' src='assets/plugins/form-datepicker/js/bootstrap-datepicker.js'></script> 
<script type='text/javascript' src='assets/plugins/form-typeahead/typeahead.min.js'></script> 




</body>
</html>