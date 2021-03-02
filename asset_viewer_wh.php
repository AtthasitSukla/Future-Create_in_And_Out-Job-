<? include("connect_inv.php");  ?>
<?
	
	$asset_no  = $_REQUEST['asset_no'];
	$status = $_REQUEST['status'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>I-Wis HQ : Asset View</title>
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

<link rel='stylesheet' type='text/css' href='assets/plugins/jqueryui-timepicker/jquery.ui.timepicker.css' /> 
<link rel='stylesheet' type='text/css' href='assets/plugins/form-daterangepicker/daterangepicker-bs3.css' /> 
<link rel='stylesheet' type='text/css' href='assets/js/jqueryui.css' /> 
<script type="text/javascript" src="assets/js/jquery-1.10.2.min.js"></script>
<!--<script type="text/javascript" src="assets/js/less.js"></script>-->


 <script type="text/javascript">
 
 
 	  function fileSelected_pm(id,step) {
		  
		  document.getElementById('idselect').value=id;
 
        var count = document.getElementById('fileToUpload'+id).files.length;
 
             // document.getElementById('details'+id).innerHTML = "";
 
              for (var index = 0; index < count; index ++)
 
              {
 
                     var file = document.getElementById('fileToUpload'+id).files[index];
 
                     var fileSize = 0;
 
                     if (file.size > 1024 * 1024)
 
                            fileSize = (Math.round(file.size * 100 / (1024 * 1024)) / 100).toString() + 'MB';
 
                     else
 
                            fileSize = (Math.round(file.size * 100 / 1024) / 100).toString() + 'KB';
 
                 //    document.getElementById('details'+id).innerHTML += 'Name: ' + file.name + '<br>Size: ' + fileSize + '<br>Type: ' + file.type;
 
                  //   document.getElementById('details'+id).innerHTML += '<p>';
 					uploadFile_pm(id,step)
              }
 
      }
 
      function uploadFile_pm(id,step) {
 	document.getElementById("cam"+id).src = 'images/cam_load.png';
        var fd = new FormData();
 
              var count = document.getElementById('fileToUpload'+id).files.length;
 
              for (var index = 0; index < count; index ++)
 
              {
 
                     var file = document.getElementById('fileToUpload'+id).files[index];
 
                     fd.append('myFile', file);
 
              }
			
			var pmid = document.getElementById('pmid'+id).value;
			 
			   fd.append('pmid',pmid );
			 
			 
 
        var xhr = new XMLHttpRequest();
 
        xhr.upload.addEventListener("progress", uploadProgress_pm, false);
 
        xhr.addEventListener("load", uploadComplete_pm, false);
 
        xhr.addEventListener("error", uploadFailed_pm, false);
 
        xhr.addEventListener("abort", uploadCanceled_pm, false);
 
        xhr.open("POST", "testcam_upload_asset_pm.php");
 
        xhr.send(fd);
 
      }
 
      function uploadProgress_pm(evt) {
 
        if (evt.lengthComputable) {
			
 		 var idselect = $("#idselect").val();
          var percentComplete = Math.round(evt.loaded * 100 / evt.total);
 
          document.getElementById('progress'+idselect).innerHTML = percentComplete.toString() + '%';
 
        }
 
        else {
 
          document.getElementById('progress'+id).innerHTML = 'unable to compute';
 
        }
 
      }
 
      function uploadComplete_pm(evt) {
 	
        /* This event is raised when the server send back a response */
 //	var idselect =  document.getElementById('idselect').value;
	//var asset_no =  document.getElementById('asset_no').value;
 //	document.getElementById("cam"+idselect).src = 'uploads_dn/'+evt.target.responseText;
	//document.getElementById("fn"+idselect).value = 'uploads_dn/'+evt.target.responseText;
	
	//showpicture2(asset_no)
      }
 
      function uploadFailed_pm(evt) {
 
        alert("There was an error attempting to upload the file.");
 
      }
 
      function uploadCanceled_pm(evt) {
 
        alert("The upload has been canceled by the user or the browser dropped the connection.");
 
      }
 
 
 
      function fileSelected(id,step) {
		  
		  document.getElementById('idselect').value=id;
 
        var count = document.getElementById('fileToUpload'+id).files.length;
 
             // document.getElementById('details'+id).innerHTML = "";
 
              for (var index = 0; index < count; index ++)
 
              {
 
                     var file = document.getElementById('fileToUpload'+id).files[index];
 
                     var fileSize = 0;
 
                     if (file.size > 1024 * 1024)
 
                            fileSize = (Math.round(file.size * 100 / (1024 * 1024)) / 100).toString() + 'MB';
 
                     else
 
                            fileSize = (Math.round(file.size * 100 / 1024) / 100).toString() + 'KB';
 
                 //    document.getElementById('details'+id).innerHTML += 'Name: ' + file.name + '<br>Size: ' + fileSize + '<br>Type: ' + file.type;
 
                  //   document.getElementById('details'+id).innerHTML += '<p>';
 					uploadFile(id,step)
              }
 
      }
 
      function uploadFile(id,step) {
 	document.getElementById("cam"+id).src = 'images/cam_load.png';
        var fd = new FormData();
 
              var count = document.getElementById('fileToUpload'+id).files.length;
 
              for (var index = 0; index < count; index ++)
 
              {
 
                     var file = document.getElementById('fileToUpload'+id).files[index];
 
                     fd.append('myFile', file);
 
              }
			var pos = '0'+id;
			pos = pos.slice(-2);
			var asset_no = document.getElementById('asset_no').value;
			   fd.append('id',id );
			   fd.append('pos',id );
			   fd.append('asset_no',asset_no );
			 
			 
 
        var xhr = new XMLHttpRequest();
 
        xhr.upload.addEventListener("progress", uploadProgress, false);
 
        xhr.addEventListener("load", uploadComplete, false);
 
        xhr.addEventListener("error", uploadFailed, false);
 
        xhr.addEventListener("abort", uploadCanceled, false);
 
        xhr.open("POST", "testcam_upload_asset.php");
 
        xhr.send(fd);
 
      }
 
      function uploadProgress(evt) {
 
        if (evt.lengthComputable) {
			
 		 var idselect = $("#idselect").val();
          var percentComplete = Math.round(evt.loaded * 100 / evt.total);
 
          document.getElementById('progress'+idselect).innerHTML = percentComplete.toString() + '%';
 
        }
 
        else {
 
          document.getElementById('progress'+id).innerHTML = 'unable to compute';
 
        }
 
      }
 
      function uploadComplete(evt) {
 	
        /* This event is raised when the server send back a response */
 	var idselect =  document.getElementById('idselect').value;
	var asset_no =  document.getElementById('asset_no').value;
 //	document.getElementById("cam"+idselect).src = 'uploads_dn/'+evt.target.responseText;
	//document.getElementById("fn"+idselect).value = 'uploads_dn/'+evt.target.responseText;
	
	showpicture2(asset_no)
      }
 
      function uploadFailed(evt) {
 
        alert("There was an error attempting to upload the file.");
 
      }
 
      function uploadCanceled(evt) {
 
        alert("The upload has been canceled by the user or the browser dropped the connection.");
 
      }
 
    </script>
    
    
<script>

$(function(){
	
	<?
	if($asset_no!=''){
		?>
		$("#asset_no").val('<?=$asset_no?>');
		show_asset('<?=$asset_no?>');
		<?
		}else{
			?>
			$("#asset_no").focus();
			<?
        }

        if($status=="add"){
            ?>
            var asset_no = $("#asset_no").val();
            show_from_add(asset_no);
            <?
        }
        
	?>
	
	
		
	});

function myTrim(x){return x.replace(/^\s+|\s+$/gm,'')}


	
	

			


function checkenter_field(tabindex,event){			
			setTimeout(
  function() 
  {
    //do something special
	checkenter_fieldd(tabindex,event);
  }, 350);
}			
function checkenter_fieldd(tabindex,event){
	
	var keycode=(event.keyCode?event.keyCode:event.which);
if(keycode=='13'){
	var sound = document.getElementById("audio");
	//var empno = $("#empno").val();
	var asset_no=$("#asset_no").val();
	//var dn=$("#dn").val();
	//SZNE117401
	//ZNE1174
//	var nissan_issue = '';
	//var Issue_No=$("#Issue_No").val();
	//nissan_issue = Issue_No;
	//Issue_No=Issue_No.substring(1,8);
	
	//alert(nissan_qty);
		
			
			
				
	
	if(tabindex==1){
		
		//$("#Issue_No").prop('disabled',true);
		//$("#dn").prop('disabled',false);
		
		$.post("getajax_asset.php",{
		status:"show_asset_wh",asset_no:asset_no,
		sid:Math.random()}).done(function(data){
			//alert(data);
						var aa=myTrim(data);
						var bb=aa.split("###",150);
						
						if(data=='nodata'){
									bootbox.dialog({
            closeButton: true,
            title: "Asset ID นี้ไม่มีในระบบ ",
            message: "<BR><BR><select><option value='OK'>OK</option></select>",
            buttons: {
               success: {
                      label: "OK",
                      className: "btn-success",
                      callback: function() {
						  $('.bootbox').on('hidden.bs.modal', function() { 
						  		
								$("#asset_no").focus().select();
											
							});
                       
                    }
                  }
            }       
        });
							}else{
                                var aa =data;					
                                var bb = aa.split("###",150);
                                $("#showsummary").html(bb[0]);
                                showpicture(asset_no);
                                show_asset_pm(asset_no);
                                show_empno(bb[1]);
							
								
								}
						
						
						
			 });
			 
		 
	}
		
	
	
	
		
		
	
	
	
					  }
	
			}

				


function show_from_add(asset_no){
	$.post("getajax_asset.php",{
		status:"show_from_add_wh",
		asset_no:asset_no,
		sid:Math.random()
		})
		.done(function(data){
			$("#showsummary").html(data);
			showpicture(asset_no);
            show_empno();
			$( "#purchase_date,#po_open_date,#warranty_start,#warranty_end" ).datepicker({
				dateFormat: 'dd/mm/yy'
			});
			/*
			$( "#po_open_date" ).datepicker();
			$( "#warranty_start" ).datepicker();
			$( "#warranty_end" ).datepicker();
			*/
	});
}
function show_asset(asset_no){
	$.post("getajax_asset.php",{
        status:"show_asset_wh",asset_no:asset_no,
        sid:Math.random()}).done(function(data){
            var aa =data;					
	        var bb = aa.split("###",150);
            $("#showsummary").html(bb[0]);
            showpicture(asset_no);
            show_asset_pm(asset_no);
            show_empno(bb[1]);
            $("#purchase_date,#po_open_date,#warranty_start,#warranty_end").datepicker({
                dateFormat: 'dd/mm/yy'
            });
        });
	}
function show_empno(empno){
    $.post("getajax_emp.php",{
        status:"show_empno",
        empno:empno,
        sid:Math.random()})
    .done(function(data){
           
        $("#show_empno").html(data);
        
    });
}
function show_asset_pm(asset_no){
	 $("#pm_area").html("loading..");
		$.post("getajax_asset.php",{
				status:"show_asset_pm",asset_no:asset_no,
				sid:Math.random()}).done(function(data){
					$("#pm_area").html(data);

        /*$('#table_pm').DataTable({
            "order": [[ 0, "desc" ]],
			"pageLength": 100
        });	*/
		
					});
	}
function showdelivery(deliveryID){
	$.post("getajax_delivery.php",{
		status:"show_delivery",deliveryID:deliveryID,
		sid:Math.random()}).done(function(data){
			//alert(data);
						var aa=myTrim(data);
						var bb=aa.split("###",150);
						
						if(data=='nodata'){
									bootbox.dialog({
            closeButton: true,
            title: "Delivery Barcode นี้ไม่มีในระบบ ",
            message: "<BR><BR><select><option value='OK'>OK</option></select>",
            buttons: {
               success: {
                      label: "OK",
                      className: "btn-success",
                      callback: function() {
						  $('.bootbox').on('hidden.bs.modal', function() { 
						  		
								$("#deliveryID").focus().select();
											
							});
                       
                    }
                  }
            }       
        });
							}else{
								$("#qtyissue").val(bb[0]);
								if(bb[2]==''){
									bb[2] = 0; 
									}
								$("#display_status").html(bb[3]);
								$("#qtydn").val(bb[1]);
							//	$("#qtydn").val(bb[2]+'/'+bb[1]);
								$("#dn").focus();
							}
						
						
						
			 });
	}



function showpicture(asset_no){
	$("#cam_area1").show();
	//var dn = $("#dn").val();
	
	$.post("getajax_asset.php",{
					status:"showpicture_asset",
					asset_no:asset_no,
					
					sid:Math.random()}).done(function(data){
					
					$("#cam_area1").html(data);
							
						
						})
	}

function showpicture2(asset_no){
					$.post("getajax_asset.php",{
							status:"showpicture_asset",
						
							asset_no:asset_no,
							sid:Math.random()}).done(function(data){
							
							$("#cam_area1").html(data);
									
								
								});
	}







	
	function showmodal(img){
		//'QPoint/"+xx+".jpg'
		
		$("#myModal2").modal({backdrop: "static"});
		$("#img1").html('<img src='+img+'>');
		}
	function showmodal2(id){
		//'QPoint/"+xx+".jpg'
		var img = $("#fn"+id).val();
		$("#myModal2").modal({backdrop: "static"});
		$("#img1").html('<img src=showpicture_asset.php?id='+id+'&filename='+img+' width=550>');
		}
	function showmodal2_pm(id){
		//'QPoint/"+xx+".jpg'
		var img = $("#fn"+id).val();
		
		$("#myModal2").modal({backdrop: "static"});
		$("#img1").html('<img src='+img+' width=550>');
		}
	function hidemodal(){
		$("#myModal2").modal("hide");
		}
	
	
    function update_asset(asset_no){
		//table left
		var location = $("#location").val();
		var asset_name = $("#asset_name").val();
        var empno = $("#empno").val();
		//var owner = $("#owner").val();
		var asset_group = $('#asset_group').val();
		var device_type = $("#device_type").val();
		var manufacturer = $("#manufacturer").val();
		var model = $("#model").val();
		var serialnumber = $("#serialnumber").val();
		var asset_status = $("#asset_status").val();
		var asset_action = $("#asset_action").val();
		//table right
		var macaddress = $("#macaddress").val();
		var ipaddress = $("#ipaddress").val();
		var po_open_date = $("#po_open_date").val();
		var purchase_date = $("#purchase_date").val();
		var purchase_price = $("#purchase_price").val();
		var warranty_start = $("#warranty_start").val();
		var warranty_end = $("#warranty_end").val();
		//var assetfile =  $("#assetfile").val();
		//owner:owner,
		//device_type : device_type,
		$.post("getajax_asset.php",{
			status:"update_asset",
			asset_no:asset_no,
			asset_name:asset_name,
            empno : empno,
			asset_group : asset_group,
			device_type:device_type,
			manufacturer : manufacturer,
			model : model,
			serialnumber:serialnumber,
			macaddress : macaddress,
			ipaddress : ipaddress,
			po_open_date : po_open_date,
			purchase_date : purchase_date,
			purchase_price : purchase_price,
			warranty_start : warranty_start,
			warranty_end : warranty_end,
			asset_status:asset_status,
			asset_action:asset_action,
			
		location:location,
			sid:Math.random()
		})
		.done(function(data){
			alert("update success"+data);			
		});
	}
				
	 // $(".assetfile").change(function() {
//         alert($("#assetfile").val());
//});	

function uploadfilea(){
		//alert($("#assetfile").val());
		var asset_no = $("#asset_no").val();
		 var file = document.getElementById('assetfile').files[0];
        
		 var fd = new FormData();
		fd.append('assetfile', file);
	    fd.append('asset_no',asset_no );
		fd.append('status','uploadfilea' );
		$.ajax({
			url: 'getajax_asset.php',
			type: 'POST',
			data: fd,
			async: false,
			cache: false,
			contentType: false,
			processData: false,
			success: function (returndata) {
				//alert(returndata);
		alert("บันทึกข้อมูลสำเร็จ...");
		//$("#myModalPo_doc").modal('hide');
			}
		});
	}
	
    function add_asset(){
		//table left
		var asset_no = $("#asset_no").val();
		var location = $("#location").val();
		var asset_name = $("#asset_name").val();
        var empno = $("#empno").val();
	//	var owner = $("#owner").val();
	
		var asset_group = $('#asset_group').val();
		var device_type = $('#device_type').val();
		//var device_type = $("#device_type").val();
		var manufacturer = $("#manufacturer").val();
		var model = $("#model").val();
		var serialnumber = $("#serialnumber").val();
		//alert(asset_no);
		//table right
		var macaddress = $("#macaddress").val();
		var ipaddress = $("#ipaddress").val();
		var po_open_date = $("#po_open_date").val();
		var purchase_date = $("#purchase_date").val();
		var purchase_price = $("#purchase_price").val();
		var warranty_start = $("#warranty_start").val();
		var warranty_end = $("#warranty_end").val();
		//var asset_status = $("#asset_status").val();
		//device_type : device_type,
		//owner:owner,
		$.post("getajax_asset.php",{
			status:"add_asset",
			asset_no:asset_no,
			location : location,
			asset_name:asset_name,
            empno : empno,
			
			asset_group : asset_group,
			device_type:device_type,
			manufacturer : manufacturer,
			model : model,
			serialnumber:serialnumber,
			macaddress : macaddress,
			ipaddress : ipaddress,
			po_open_date : po_open_date,
			purchase_date : purchase_date,
			purchase_price : purchase_price,
			warranty_start : warranty_start,
			warranty_end : warranty_end,
			
			sid:Math.random()
		})
		.done(function(data){
			alert("Add success");	
			window.location.href="asset_viewer_wh.php?asset_no="+asset_no;
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
<!-- Modal -->
<audio id="audio" src="Sound/alert.mp3" autostart="false"></audio>
    

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

		
        <?php
	if($status==''){
		?>

    <div class="row" id="page1" style="display:">
                 
        
        
                    
                  
                         
                         <div class="col-sm-6">
                        <div class="panel panel-primary">
                        <div class="panel-body" style="border-top-color:#DDDDDD;background-color:#FF9 ">
                                 <div class="form-group">
                    <label class="col-sm-5 control-label" style="text-align:right"><font color="#e73c3c">Asset ID :</font></label>
                    <div class="col-sm-7">
                      <input type="text" name="asset_no" id="asset_no" class="form-control" onkeypress="checkenter_field(1,event);" tabindex="1">
                    </div>
                    
                     
                </div>
                 				
                
                			</div>
                         </div>
                       
                         
                         </div>
                         
                         
                    
                
             
    
                    <div class="col-sm-12">
                 <div class="panel panel-primary" >
                 <div class="panel-body" style="border-top-color:#e6e7e8; ">
                  <div class="form-group">
                         
                <label class="col-sm-12 control-label">
                <h4><strong><u>Summary</u></strong></h4>
                </label>
               
           				 </div>
                         
                         <div class="form-group">
                         <div class="col-sm-12" align="center" id="showsummary" >
                 
              
                   
                   </div>
                
               
           				 </div>
                 
                         </div>
						
                 </div>
                  </div>
                    
                    
                   
        
        
                    <div class="col-sm-12" id="cam_area1" style="display:none">
                    <form id="form1" enctype="multipart/form-data" method="post" action="testcam_upload.php">
     <input type="hidden" id="idselect"> <span id="progress"></span>
                        <div class="panel panel-primary">
                            
                            <div class="panel-body" style="border-top-color:#DDDDDD;background-color:#ffffff ">
                             <div class="form-group">
                             
                    <label class="col-sm-12 control-label">
                    <h4><strong><u>Take Picture </u></strong></h4></label>
                   
                             </div>
                            
                           <div class="form-group">
                           <div class="col-sm-1">
                    </div>
                   <?
                   for($i=1;$i<=5;$i++){
                       ?>
                       <div class="col-sm-2">
                     <div class="image-upload" style="text-align:center">
        <label for="fileToUpload<?=$i?>">
            <img id="cam<?=$i?>" src="images/cam.png"/>
        </label>
    
        <input name="fileToUpload<?=$i?>"  onchange="fileSelected('<?=$i?>','1');" accept="image/*" capture="camera" id="fileToUpload<?=$i?>" type="file"/>
    </div><div  style="text-align:center"><input type="button" value="view" onClick="showmodal2('<?=$i?>');"><input type="hidden" id="fn<?=$i?>"></div>
                    </div>
                       
                       <?
                       }
                   ?>
                    
                   
                    <div class="col-sm-1">
                    </div>
                    
                    
                    
                </div>
                
                
                
                
                
                
                  
                 
                             
                          </div>
                          
                        
                            
                            <div class="panel-body" style="border-top-color:#DDDDDD;background-color:#ffffff ">
                             
                            
                           <div class="form-group">
                           <div class="col-sm-1">
                    </div>
                   <?
                   for($i=6;$i<=10;$i++){
                       ?>
                       <div class="col-sm-2">
                     <div class="image-upload" style="text-align:center">
        <label for="fileToUpload<?=$i?>">
            <img id="cam<?=$i?>" src="images/cam.png"/>
        </label>
    
        <input name="fileToUpload<?=$i?>"  onchange="fileSelected('<?=$i?>','1');" accept="image/*" capture="camera" id="fileToUpload<?=$i?>" type="file"/>
    </div><div  style="text-align:center"><input type="button" value="view" onClick="showmodal2('<?=$i?>');"><input type="hidden" id="fn<?=$i?>"></div>
                    </div>
                       
                       <?
                       }
                   ?>
                    
                   
                    <div class="col-sm-1">
                    </div>
                    
                    
                    
                </div>
                
                
                
                
                
                
                  
                 
                             
                          </div>
                          
                        </div>
                        
                       </form> 
                    </div>
                    
                    
                    
                         
                   
                    
                    
              
                    <div class="col-sm-12" id="pm_area" style=" background-color:#FFF">
                        <table id="table_pm" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Week PM</th>
                                        <th>Month PM</th>
                                        <th>Year PM</th>
                                        <th>PM Date</th>
                                        <th>PM result</th>
                                        <th>View & Update</th>
                                    </tr>
                                </thead>
                                
                               
                            </table>
                         </div>
                    
                    
                   
                   
              </div>
          
          	
            <div class="row" id="page2" style="display:none">
            
            <div class="col-sm-4"></div>
           	<div class="col-sm-4">
					
                    <div class="panel panel-primary">
						
						<div class="panel-body" style="border-top-color:#DDDDDD; ">
                         <div class="form-group">
                         	
               				 <div class="col-sm-12" style="text-align:center">
                            <h4><strong> <font color="#FF0000">Program Lock</font> </strong></h4>
                             </div>
                             </div>
                        	 <div class="form-group">
                         
                <label class="col-sm-12 control-label">
                <h4><strong><u>User Name</u></strong></h4></label>
               				 <div class="col-sm-12"><input type="hidden" id="real_issue" value=""><input type="hidden" id="issue_lock" value=""><input type="hidden" id="fieldname" value="">
                <input type="text" name="lusername" id="lusername" class="form-control" placeholder="Supervisor Username"  AUTOCOMPLETE="false" />
                			</div>
                              <label class="col-sm-12 control-label">
                <h4><strong><u>Password</u></strong></h4></label>
               				 <div class="col-sm-12">
                <input type="password" name="lpassword" id="lpassword" class="form-control" placeholder="Supervisor Password"  AUTOCOMPLETE="false" />
                			</div>
                             <div class="col-sm-12">
                <input type="button" name="btt" id="btt" value="Save Login" onClick="saveunlock();" class="form-control">
                			</div>
                            
           				 	</div>
                            
                         </div>
                         
                     </div>
            </div>
            <div class="col-sm-4"></div>
            
            
            </div>
            
              <div class="row" id="page3" style="display:none">
            
            <div class="col-sm-4"></div>
           	<div class="col-sm-4">
					
                    <div class="panel panel-primary">
						
						<div class="panel-body" style="border-top-color:#DDDDDD; ">
                        	 <div class="form-group">
                         
                <label class="col-sm-12 control-label">
                <h4><strong><u>Reason (เลือกเหตผล)</u></strong></h4></label>
               				 <div class="col-sm-12">
               			 <select class="form-control" name="reason_ng" id="reason_ng">
                          <option value="">Select</option>
                           <?
                           $select0="select  * from tbreason_ng order by id asc ";
							$re0=mssql_query($select0);
							while($row0=mssql_fetch_array($re0)){
								?>
								 <option value="<?=$row0['reason_id']?>"><?=iconv("tis-620", "utf-8", $row0['reason_ng'] )?></option>
								<?
								}
						   ?>
                          
                          
                        </select>
                			</div>
                            <div class="form-group">
                         
                <label class="col-sm-12 control-label">
                <h4><strong><u>เหตผลอื่นๆ</u></strong></h4></label>
               				 <div class="col-sm-12">
               			  <textarea name="reason_ng_other" id="reason_ng_other" class="form-control"></textarea>
                			</div>
                             <div class="col-sm-12" style="text-align:center; height:10px">
              
             
                			</div>
                             <div class="col-sm-12" style="text-align:center">
              
                <button style="width:150px; background-color:#16a085;"  onClick="saveunlockdb();" class="btn-primary btn">Save UnLock</button>
                			</div>
                            
           				 	</div>
                            
                         </div>
                         
                     </div>
            </div>
            <div class="col-sm-4"></div>
            
            
            </div>
            
          




			



		</div>
			 
<?php } ?>

<?php
	if($status=='add'){
	?>
          	
     <div class="row" id="page1" style="display:">
                 
       
        
                    
         
                         
                    <div class="col-sm-6">
                        <div class="panel panel-primary">
							<div class="panel-body" style="border-top-color:#DDDDDD;background-color:#FF9 ">
								<div class="form-group">
									<label class="col-sm-5 control-label" style="text-align:right"><font color="#e73c3c">Asset ID :</font></label>
									<div class="col-sm-7">
									<?php
									$asset_no_check = "A".date("y");
									$sql = "select top 1 asset_no from  tbasset where asset_no like '$asset_no_check%' order by asset_no desc";
									//echo $sql;

									$res = mssql_query($sql);
									$num = mssql_num_rows($res);
									if($num == 0){
										$newid = "A".date("y")."000001";
									}else{
										$row = mssql_fetch_array($res);
										$tmp_newid = $row['asset_no'];
									
										//date("y")
										$tmp_newid = substr($tmp_newid,-4);
										$qid = (int)$tmp_newid + 1;
										$tmpid = "000000".$qid;
										$qdno = substr($tmpid,-6);
										$newid = "A".date("y").$qdno;
									}
									//$update ="update tbrun_asset_no set asset_no='$newid'";
								//	mssql_query($update);
									?>
									  <input type="text" name="asset_no" id="asset_no" class="form-control" value='<?=$newid?>' readonly>
									</div>
									
							 
								</div>
									
					
							</div>
						</div>
 
                         
                    </div>
                         
         
                
             
    
                <div class="col-sm-12">
                 <div class="panel panel-primary" >
                 <div class="panel-body" style="border-top-color:#e6e7e8; ">
                  <div class="form-group">
                         
                <label class="col-sm-12 control-label">
                <h4><strong><u>Summary</u></strong></h4>
                </label>
               
           				 </div>
                         
                         <div class="form-group">
                         <div class="col-sm-12"  align="center" id="showsummary" >
							              
                   
						</div>
                
               
           				 </div>
                 
                         </div>
						
                 </div>
                </div>
                    
                    
                   
        
        
                    <div class="col-sm-12" id="cam_area1" style="display:none">
                    <form id="form1" enctype="multipart/form-data" method="post" action="testcam_upload.php">
     <input type="hidden" id="idselect"> <span id="progress"></span>
                        <div class="panel panel-primary">
                            
                            <div class="panel-body" style="border-top-color:#DDDDDD;background-color:#ffffff ">
                             <div class="form-group">
                             
                    <label class="col-sm-12 control-label">
                    <h4><strong><u>Take Picture </u></strong></h4></label>
                   
                             </div>
                            
                           <div class="form-group">
                           <div class="col-sm-1">
                    </div>
                   <?
                   for($i=1;$i<=5;$i++){
                       ?>
                       <div class="col-sm-2">
                     <div class="image-upload" style="text-align:center">
        <label for="fileToUpload<?=$i?>">
            <img id="cam<?=$i?>" src="images/cam.png"/>
        </label>
    
        <input name="fileToUpload<?=$i?>"  onchange="fileSelected('<?=$i?>','1');" accept="image/*" capture="camera" id="fileToUpload<?=$i?>" type="file"/>
    </div><div  style="text-align:center"><input type="button" value="view" onClick="showmodal2('<?=$i?>');"><input type="hidden" id="fn<?=$i?>"></div>
                    </div>
                       
                       <?
                       }
                   ?>
                    
                   
                    <div class="col-sm-1">
                    </div>
                    
                    
                    
                </div>
                
                
                
                
                
                
                  
                 
                             
                          </div>
                          
                        
                            
                            <div class="panel-body" style="border-top-color:#DDDDDD;background-color:#ffffff ">
                             
                            
                           <div class="form-group">
                           <div class="col-sm-1">
                    </div>
                   <?
                   for($i=6;$i<=10;$i++){
                       ?>
                       <div class="col-sm-2">
                     <div class="image-upload" style="text-align:center">
        <label for="fileToUpload<?=$i?>">
            <img id="cam<?=$i?>" src="images/cam.png"/>
        </label>
    
        <input name="fileToUpload<?=$i?>"  onchange="fileSelected('<?=$i?>','1');" accept="image/*" capture="camera" id="fileToUpload<?=$i?>" type="file"/>
    </div><div  style="text-align:center"><input type="button" value="view" onClick="showmodal2('<?=$i?>');"><input type="hidden" id="fn<?=$i?>"></div>
                    </div>
                       
                       <?
                       }
                   ?>
                    
                   
                    <div class="col-sm-1">
                    </div>
                    
                    
                    
                </div>
                
                
                
                
                
                
                  
                 
                             
                          </div>
                          
                        </div>
                        
                       </form> 
                    </div>
                    
               
                    
                   
                   
              </div>     
            
	
<?php } ?>

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