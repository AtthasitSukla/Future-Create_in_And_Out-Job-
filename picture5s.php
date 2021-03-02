<?php 
//include("connect.php");

    $host="WIN-GRCB1K9LF1N";
	$username="sloxixa";
	$password="eaotft139@%";
	$db="dhrdb";
	
	$sql=mssql_connect($host,$username,$password) or die("Cannot connect");
	mssql_select_db($db);
include("library.php"); 




 
$tsite = $_GET["site"]==""?"HQ":$_GET["site"];

$select_date = $_GET["select_date"]==""?date('d/m/Y'):$_GET["select_date"];
$shift = $_GET["shift"]==""?"Day":$_GET["shift"];

$select_date_arr = explode("/",$select_date);
$select_date_sql = $select_date_arr[1]."/".$select_date_arr[0]."/".$select_date_arr[2];

$date_num=date("m/d/Y");
if($shift=="Day"){
	$txt = "กะเช้า";
}else{
	$txt = "กะค่ำ";
}
$time = time();
// $begin = date('00:01');
// $end = date('05:00');
// $time = date('H:i');
/*$d=strtotime("+1 days");
$attt = date('m/01/Y');
$tomorrow = date('m/d/Y',strtotime($attt . "+1 days"));
$att_real_date =date("m/01/Y",$d);
echo $tomorrow;*/
 /*$d=strtotime("-1 Day");
 $date =date("m/d/Y",$d);
 echo $date;*/
/*if($time >= $begin && $time <= $end){
	echo $time;
}*/
//echo $date;

?>
<html>
<head>
	<meta charset="utf-8">
	<title>ถ่ายรูป 5S</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="I-Wis">
	<meta name="author" content="The Red Team">


  <!--  <link rel="stylesheet" href="assets/css/styles.css?=140">-->


    <link href='assets/demo/variations/default.css' rel='stylesheet' type='text/css' media='all' id='styleswitcher'> 
    <link href='assets/demo/variations/default.css' rel='stylesheet' type='text/css' media='all' id='headerswitcher'> 
     

<!--<link rel='stylesheet' type='text/css' href='jquery-ui-timepicker-0.3.3/jquery.ui.timepicker.css' /> -->
<link rel='stylesheet' type='text/css' href='assets/plugins/form-daterangepicker/daterangepicker-bs3.css' /> 
<link rel='stylesheet' type='text/css' href='assets/js/jqueryui.css' /> 
<link rel='stylesheet' type='text/css' href='assets/plugins/codeprettifier/prettify.css' /> 
<link rel='stylesheet' type='text/css' href='assets/plugins/form-toggle/toggles.css' /> 
<link rel='stylesheet' type='text/css' href='assets/css/bootstrap.min.css' />
<!--
<link rel="stylesheet" href="fonts.css" type="text/css" charset="utf-8" />
<script type="text/javascript" src="DatePicker/js/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="DatePicker/js/jquery-ui-1.8.10.offset.datepicker.min.js"></script>
-->
<script type='text/javascript' src='assets/js/jquery-1.10.2.min.js'></script> 
<script type='text/javascript' src='assets/js/jqueryui-1.10.3.min.js'></script> 
<script type='text/javascript' src='assets/js/bootstrap.min.js'></script> 

</head>
<script>
$( document ).ready(function() {
	
	$("#shift").addClass($("option:selected").attr("class"));
	$("#select_date").datepicker({
		dateFormat: 'dd/mm/yy'
	});
	
	show_picture();
});
function myTimer() {
    var d = new Date();
	var date = d.toLocaleDateString();
	var time = d.toLocaleTimeString();
	var date_time = "วันที่ "+date+" "+time;
	$("#datetime_current").html(date_time);
}
function check_out(){
	 setTimeout(function () { 
      location.reload();
    }, 10000);
	//window.location.reload();
}

function select_shift(){
	var select_date = $("#select_date").val();
	var shift = $("#shift").val();
	var site = $("#tsite").val();
	//select_date="+select_date+"&
	window.location.href="picture5s.php?shift="+shift+"&site="+site+"&select_date="+select_date;
}



function select_date(){
	select_shift();
}



   function fileSelected(id) {
		 
		  document.getElementById('idselect').value=id;
        var count = document.getElementById('fileToUpload'+id).files.length;
              for (var index = 0; index < count; index ++)
              {
                     var file = document.getElementById('fileToUpload'+id).files[index];
                     var fileSize = 0;
                     if (file.size > 1024 * 1024){
                            fileSize = (Math.round(file.size * 100 / (1024 * 1024)) / 100).toString() + 'MB';
					 }else{
                            fileSize = (Math.round(file.size * 100 / 1024) / 100).toString() + 'KB';
 					
              }
			  uploadFile(id);
 
      }
   }
      	function uploadFile(id) {
		  //alert(id);
 			document.getElementById("cam"+id).src = 'images/cam_load.png';
        	var fd = new FormData();
 
              var count = document.getElementById('fileToUpload'+id).files.length;
 			// resize_image(document.getElementById('fileToUpload'+id));
              for (var index = 0; index < count; index ++)
 
              {
					
                     var file = document.getElementById('fileToUpload'+id).files[index];
 					 
                     fd.append('myFile', file);
 
              }
			
			
		
		
			var select_date = $("#select_date").val();
			var shift = $("#shift").val();
			var site = $("#tsite").val();
			
			fd.append('select_date',select_date );
			fd.append('shift',shift );
			fd.append('site',site );
			fd.append('id',id);
			//fd.append('layer_id',layer_id );
			//fd.append('step',step);
 		
			var url = '';
			var xhr = new XMLHttpRequest();
	
			xhr.upload.addEventListener("progress", uploadProgress, false);
	
			xhr.addEventListener("load", uploadComplete, false);
	
			xhr.addEventListener("error", uploadFailed, false);
	
			xhr.addEventListener("abort", uploadCanceled, false);
			
			url ="testcam_upload_5s.php";
			
			xhr.open("POST", url);
	
			xhr.send(fd);
 
      }
      function uploadProgress(evt) {
		 
 
        if (evt.lengthComputable) {
 
          var percentComplete = Math.round(evt.loaded * 100 / evt.total);
 
          document.getElementById('progress').innerHTML = percentComplete.toString() + '%';
 
        }
 
        else {
 
          document.getElementById('progress').innerHTML = 'unable to compute';
 
        }
 
      }
	function uploadComplete(evt) {
		var idselect = document.getElementById('idselect').value;
		document.getElementById("cam" + idselect).src = '5spicture/' + evt.target.responseText + '?T='+Math.random();
		document.getElementById("fn" + idselect).value = '5spicture/' + evt.target.responseText + '?T='+Math.random();
		// show_picture();
	
	
	}
      function uploadFailed(evt) {
 
        alert("There was an error attempting to upload the file.");
 
      }
      function uploadCanceled(evt) {
 
        alert("The upload has been canceled by the user or the browser dropped the connection.");
 
      }
function showmodal2(id){
		//'QPoint/"+xx+".jpg'
		var img_master = $("#master"+id).val();
		var img = $("#fn"+id).val();
		$("#myModal2").modal({backdrop: "static"});
		$("#img1").html('<img src='+img_master+' width=100%><br><img src='+img+' width=100%>');
		}
	function hidemodal(){
		$("#myModal2").modal("hide");
		}
function show_picture(){
	var select_date = $("#select_date").val();
	var shift = $("#shift").val();
	var site = $("#tsite").val();
	//alert(site);
		$.post("getajax_picture5s.php",{
					status:"show_picture_ver2",
					select_date:select_date,
					shift:shift,
					site:site,
					sid:Math.random()}).done(function(data){
					$("#showpic").html(data);
						
					});
	
	}
	function close_picture_line_alert(){
		var site = $("#tsite").val();
		var select_date = $("#select_date").val();
		var shift = $("#shift").val();
		$.post("getajax_linenotify.php",{
			status:"close_picture_line_alert",
			select_date:select_date,
			shift:shift,
			site:site,
			sid:Math.random()
		}).done(function(data){
			// alert(data);
			if(site=="OSW"||site=="TSC"){
				alert("Save Complete");
				window.location.href = "daily_report_view.php";
			
			}else{
				$("#close_picture_line_alert").html("Done");

			}
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
.form-group {
     margin-bottom: 0px; 
}

 </style>
<style>
.heading-quaternary {
    display: block;
    font-size: 10px;
    line-height: 1;
	margin-top: 5px;
    margin-bottom: 2px;
	
}
.heading-quinary {
    text-transform: none;
    font-size: 8px;
    letter-spacing: 0;
    color: #7d8183;
    white-space: nowrap;
	
}
#card_boder{
	display: block;
	border: 1px solid rgba(0,0,0,.125);
	
	
}
#row_pic{
	margin-bottom : 10px;
}
.Night{
	background-color: #000;
	color: #FFF;
}
.Day{
	background-color: #FFF;
	color: #000;
}
</style>
<body class="">
<div class='container'>
<div class="modal fade" id="myModal2" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
         
          <h4 class="modal-title">Picture</h4>
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


	<div class="row">
		<center><h2><?php echo $tsite." ".$txt ?></h2></center>
	</div>
	
	<div class="row">
<div class='col-sm-6' style="padding-top:5px; padding-left:20px"><img src="http://www.ipack-iwis.com/att/ipack-logo-mb-1.png"></div>
<div class='col-sm-6' style="padding-top:5px"><div class="form-group ">
<? //=$tsite ?>
					 <label class="control-label col-md-2" for="shift">เลือก Site :</label>
					<div class="col-md-2">
						<select id="tsite" class='form-control' onChange="select_shift()">
							<?php 
							//	$select_site = $tsite =="TSC" ? "selected" : ""; 
							//	$select_site = $tsite =="HQ" ? "selected" : ""; 
							/////	$select_site = $tsite =="OSW" ? "selected" : ""; 
									?>
							<option value="HQ" <?
                            
							if($tsite=='HQ'){
								?> selected<?
								}?>>HQ</option>
							<option value="TSC" <?
                            
							if($tsite=='TSC'){
								?> selected<?
								}?>>TSC</option>
                            <option value="OSW" <?
                            
							if($tsite=='OSW'){
								?> selected<?
								}?>>OSW</option>
						</select>
					</div>
                    
					<label class="control-label col-md-2" for="select_date">เลือกวันที่ :</label>
					<div class="col-md-2">
					<input type="text" name="select_date" id="select_date" value="<?=$select_date?>" onChange="select_shift()" class='form-control' >
					</div>
                    
                    <label class="control-label col-md-2" for="shift">เลือกกะ :</label>
					<div class="col-md-2">
						<select id="shift" class='form-control' onChange="select_shift()">
							<?php 
								$select_day = $shift =="Day" ? "selected" : ""; 
								$select_night = $shift =="Night" ? "selected" : ""; 
									?>
							<option value="Day" <?=$select_day?>>Day</option>
							<option value="Night" <?=$select_night?>>Night</option>
						</select>
					</div>
                 
				
				
			
		
			


			
		</div>
	
				</div>
                
                </div>
	<BR>
	<!-- <div class='row'>
     <div class='col-sm-12'>
     <form id="form1" enctype="multipart/form-data" method="post" action="testcam_upload_5s.php">
 			<input type="hidden" id="idselect"> 
    
			<div class="image-upload" style="text-align:center">
										<label for="fileToUpload0">
                                       
											<img id="cam0" src="images/cam.png" />
										</label>
									

										<input name="fileToUpload0"  onchange="fileSelected('0');" accept="image/*" capture="camera" id="fileToUpload0" type="file"/>
									</div>
                                    <span id="progress" style="text-align:center"></span>
                                    
                                    	
                                    
                  </form>                  
		</div>
	
	</div> -->
</div>
<!-- <HR> -->
<center id="close_picture_line_alert">
	<?
	$sql = "SELECT jobstatus_picture_line FROM  tb5s_picture WHERE site='$tsite' and shift='$shift' AND createdate='$select_date_sql' AND jobstatus_picture_line='New' ";
	$res = mssql_query($sql);
	$num = mssql_num_rows($res);

	$sql_1 = "SELECT jobstatus_picture_line FROM  tb5s_picture WHERE site='$tsite' and shift='$shift' AND createdate='$select_date_sql'  ";
	$res_1 = mssql_query($sql_1);
	$num_1 = mssql_num_rows($res_1);
	// echo $sql;
	if($num>0 || $num_1==0){
		?><button onclick="close_picture_line_alert()">Close Job</button><?
	}else{
		echo "Done";
	}
	?>
</center>
<br>
<div id="showpic">


     </div>
    
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

<!--<script type='text/javascript' src='jquery-ui-timepicker-0.3.3/jquery.ui.timepicker.js'></script> -->

<!--<script type='text/javascript' src='assets/plugins/form-daterangepicker/daterangepicker.min.js'></script> -->
<script type='text/javascript' src='assets/plugins/bootbox/bootbox.min.js'></script>
<!--<script type='text/javascript' src='assets/plugins/form-datepicker/js/bootstrap-datepicker.js'></script> -->
<script type='text/javascript' src='assets/plugins/form-typeahead/typeahead.min.js'></script> 


</body>
</html>