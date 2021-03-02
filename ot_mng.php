<? include("connect.php"); 
	 
$status = $_REQUEST['status'];
$paycode = $_REQUEST['paycode'];
$empno = $_REQUEST['empno'];

		if($empno!=''){
				$select="select firstname,lastname,empno,site from  tbemployee where empno = '$empno' ";
				$re=mssql_query($select);
				$row=mssql_fetch_array($re);
				$empname = iconv("tis-620", "utf-8",$row['firstname'].' '.$row['lastname']);
				$site = $row['site'];
		}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>I-Wis HQ : Time Attendance List</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="I-Wis">
	<meta name="author" content="The Red Team">

    <link rel="stylesheet" href="assets/css/styles.css?=140">

    <link href='assets/demo/variations/default.css' rel='stylesheet' type='text/css' media='all' id='styleswitcher'> 
    <link href='assets/demo/variations/default.css' rel='stylesheet' type='text/css' media='all' id='headerswitcher'> 
     

<link rel='stylesheet' type='text/css' href='assets/plugins/codeprettifier/prettify.css' /> 
<link rel='stylesheet' type='text/css' href='assets/plugins/form-multiselect/css/multi-select.css' /> 
<link rel='stylesheet' type='text/css' href='assets/plugins/form-toggle/toggles.css' /> 
<script type="text/javascript" src="assets/js/jquery-1.10.2.min.js"></script>
<script>

$(function() {
	var data = {};
	var type = "";
	var conut = "";
	data['empno'] = getParameterByName('empno');
	data['paycode'] = getParameterByName('paycode');
	data['status'] = 'R';
	data['site'] = "<?php echo $site; ?>";
	//data['paycode'] = <? //=$paycode; ?>;
	$.ajax({
		url: 'getajax_ot.php',
		type: "POST",
		async: false,
		dataType: "json",
		data   : data,
		success: function(data) {
			var tr = "";
			type = data['type'];
			conut = data['conut'];
			if(data['type'] == 'add'){
				for(var i = 0;i<data['data'].length;i++){
					tr += "<tr>";
					tr += '<td align="center">'+data["data"][i]["workdate_new"]+'<input type="hidden" name="workdate[]" value="'+data["data"][i]["workdate"]+'" class="form-control"></td>';
					tr += '<td align="center">'+data["data"][i]["dayname_en"]+'<input type="hidden" name="dayname_en[]" value="'+data["data"][i]["dayname_en"]+'" class="form-control"></td>';
					tr += '<td align="center"><select style="width:70px" name="shift_time[]" class="form-control" ><option value="Day" >Day</option><option value="Night" >Night</option></select></td>';
					//tr += '<td align="center"><select name="ot_status[]" class="form-control" style="width:60px"><option value="no">No</option><option value="yes">Yes</option></select></td>';
					tr += '<td align="center"><select name="fl_status[]" class="form-control" style="width:60px"><option value="no">No</option><option value="yes">Yes</option></select></td>';
					tr += '<td align="center"><input type="text" name="remark[]" value="'+data["data"][i]["remark"]+'" class="form-control"></td>';
					tr += "</tr>";
					
				}
			}
			if(data['type'] == 'update'){
				for(var i = 0;i<data['data'].length;i++){
					tr += "<tr>";
					tr += '<td align="center">'+data["data"][i]["workdate_new"]+'<input type="hidden" name="workdate[]" value="'+data["data"][i]["workdate"]+'" class="form-control"></td>';
					tr += '<td align="center">'+data["data"][i]["dayname_en"]+'<input type="hidden" name="dayname_en[]" value="'+data["data"][i]["dayname_en"]+'" class="form-control"></td>';
					tr += '<td align="center"><select style="width:70px" name="shift_time[]" id="shift_time'+i+'" class="form-control" ><option value="Day" >Day</option><option value="Night" >Night</option></select></td>';
					//tr += '<td align="center"><select name="ot_status[]" id="ot_status'+i+'" class="form-control" style="width:60px"><option value="no">No</option><option value="yes">Yes</option></select></td>';
					tr += '<td align="center"><select name="fl_status[]" id="fl_status'+i+'" class="form-control" style="width:60px"><option value="no">No</option><option value="yes">Yes</option></select></td>';
					tr += '<td align="center"><input type="text" name="remark[]" value="'+data["data"][i]["remark"]+'" class="form-control"></td>';
					tr += "</tr>";
				}
			}
			$("#example").append(tr);
			
			if(data['type'] == 'update'){
				for(var i = 0;i<data['data'].length;i++){
					$('#shift_time'+i+' option[value="'+data["data"][i]["shift"]+'"]').prop("selected", true);
					$('#ot_status'+i+' option[value="'+data["data"][i]["ot"]+'"]').prop("selected", true);
					$('#fl_status'+i+' option[value="'+data["data"][i]["fl"]+'"]').prop("selected", true);
				}
			}
			
		}
	});
	
	$("form#myform").submit(function(event){
		var formData = new FormData($(this)[0]);
		if(type == "add"){
			formData.append("status", 'I');
		}else{
			formData.append("status", 'U');
		}
		formData.append("empno", getParameterByName('empno'));
		formData.append("paycode", getParameterByName('paycode'));
		formData.append("conut", conut);
		$.ajax({
			url: 'getajax_ot.php',
			type: 'POST',
			data: formData,
			async: false,
			cache: false,
			contentType: false,
			processData: false,
			success: function () {
				alert("บันทึกข้อมูลสำเร็จ");
				window.location="ot_mng.php?empno="+getParameterByName('empno')+"&paycode="+getParameterByName('paycode');
			}
		});
		return false;
	});
	
});
function getParameterByName(name) {
	name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
	var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
		results = regex.exec(location.search);
	return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}
/*function showpaycode(){
	var paycode = $("#paycode").val();
	var empno = $("#empno").val();
	window.location = 'time_att_list.php?paycode='+paycode+'&empno='+empno;
	}

function updateshift(id){
	var shift_time = $("#shift_time"+id).val();
		$.post( "getajax_att.php", { 	
	status: "updateshift", 
	shift_time : shift_time,
	id: id,
	sid: Math.random() 
	})
	.done(function( data ) {
	alert('save complete');
	window.location='view_att_list.php?empno=<?=$empno?>&paycode=<?=$paycode?>';

 });
	}
	
	function updatefl(id){
	var fl = $("#fl"+id).val();
		$.post( "getajax_att.php", { 	
	status: "updatefl", 
	fl : fl,
	id: id,
	sid: Math.random() 
	})
	.done(function( data ) {
	//alert(data);

 });
	}
	function updateDate(id){
	var attDateTime = $("#attDateTime"+id).val();
	var attDateTime2 = $("#attDateTime2"+id).val();
	var attDateTime3 = $("#attDateTime3"+id).val();
		$.post( "getajax_att.php", { 	
	status: "updateDate", 
	attDateTime : attDateTime,
	attDateTime2 : attDateTime2,
	attDateTime3 : attDateTime3,
	id: id,
	sid: Math.random() 
	})
	.done(function( data ) {
	alert('save complete.');

 });
	}
	
	function createleave(id,empno,leavedate){
		
		var leavetypeid = $("#leavetypeid"+id).val();
		if(leavetypeid==''){
			alert('Please Select Leave');
			return false;
			}else{
				
				$.post( "getajax_att.php", { 	
					status: "createleave", 
					leavedate : leavedate,
					leavetypeid:leavetypeid,
					empno : empno,
					id : id,
					sid: Math.random() 
					})
					.done(function( data ) {
					alert('save complete.');
				
				 });
 
 
				}
		
		}
	
	
	
	function printslip(empno,paycode){
		window.open('popslip.php?empno='+empno+'&paycode='+paycode+'','popup','width=800,height=400,scrollbars=yes');
		}
	*/
	
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
     <table width="100%"  cellspacing="2" cellpadding="0">
    	<tr><td><h4>Emp No : <?=$empno?> Name : <?=$empname?> </h4></td></tr>
     </table>
     <form name="form" method="post" action="" id="myform">
     <input type="hidden" name="hdempno" value="<?=$empno?>">
     <input type="hidden" name="hdpaycode" value="<?=$paycode?>">
    <table width="100%"  cellspacing="2" cellpadding="0" class="table table-striped table-bordered datatables" id="example">
		<tr >
			<td width="67" align="center" bgcolor="#CCCCCC"><strong>Date</strong></td>
			<td width="67" align="center" bgcolor="#CCCCCC"><strong>Day Name</strong></td>
			<td width="76" align="center" bgcolor="#CCCCCC"><strong>Shift</strong></td>
			
			<td width="94" align="center" bgcolor="#CCCCCC"><strong>FL</strong></td>
			<td width="106" align="center" bgcolor="#CCCCCC"><strong>Remark</strong></td>
		</tr>
    </table>

    <input type="submit" value="Submit">

     </form>
    <HR>
  

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