<?php 
include("connect.php");
include("library.php"); 
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Hrs : Traning</title>
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
<link rel="stylesheet" type="text/css" href="assets/css/multi-select.css">
<script type="text/javascript" src="assets/js/jquery-1.10.2.min.js"></script>

<script>
var st = "";
$(function() {
	$.post("job_data.php",{
		status:"show_empno"
	}).done(function(data){	
		//alert(data);
		$("#empno").html(data);
		$("#empno").multiSelect('refresh');
	})
	/*$.ajax({
			url: 'job_data.php',
			type: "POST",
			async: false,
			dataType: "json",
			data   : {status:'R',type:'tbtra_title',id:0},
			success: function(data) {
				var data = data.data;
				empno = "";
				for(var i=0;i<data.length;i++){
					empno += "<option value="+data[i]['tra_id']+">"+data[i]['tra_title']+"</option>";
				}
				$("#empno").html(empno);
			}
	});*/
	//$(".sl_dep").attr('disabled','disabled');
	/*$.ajax({
			url: 'emp_control.php',
			type: "POST",
			async: false,
			dataType: "json",
			data   : {type:'emp_under'},
			success: function(data) {
				for(var i=0;i<data.length;i++){
					$("#emp_all option[value=" +data[i]+ "]").prop("selected", true);
				}
			}
	});*/
	$('#course_id').on('change', function() {
		var course_id = $("#course_id").val();
		//alert(sl_dep);
		
		$.post("job_data.php",{
			status:"select_coures",
			course_id : course_id,
			//sl_dep : sl_dep
		}).done(function(data){	
			//alert(data);
			$("#empno").html(data);
			$('.sl_dep').val("0").attr("selected", "selected");
			$("#empno").multiSelect('refresh');
		})
		
		$("#empno").multiSelect('refresh');
	});
	
	$('.sl_dep').on('change', function() {
		var course_id = $("#course_id").val();
		var sl_dep = $( ".sl_dep" ).val();
		//alert(sl_dep);
		if(course_id > 0){
			$.post("job_data.php",{
				status:"select_position",
				course_id : course_id,
				sl_dep : sl_dep
			}).done(function(data){	
				//$("#display_error").html(data);
				//alert(data);
				$("#empno").html(data);
				$("#empno").multiSelect('refresh');
			})
		}else{
			alert("กรุณาเลือกหัวข้อการอบรมก่อน");
			$('.sl_dep').val("0").attr("selected", "selected");
		}
		$("#empno").multiSelect('refresh');
	});
	
	
	$('#empno').multiSelect({
		//selectableOptgroup: true,
		selectableHeader: "<div class='custom-header'  style='font-weight:bold;'>รายชื่อพนักงาน</div><input type='button' value='Select All' onClick='select_all();'></br><input type='text' class='search-input' autocomplete='off' placeholder='รายชื่อพนักงาน'>",
		selectionHeader: "<div class='custom-header'  style='font-weight:bold;'>รายที่ที่ถูกเลือก</div><input type='button' value='Delete All' onClick='deselect_all();'></br><input type='text' class='search-input' autocomplete='off' placeholder='รายชื่อพนักงาน'>",
		afterInit: function(ms){
			var that = this,
				$selectableSearch = that.$selectableUl.prev(),
				$selectionSearch = that.$selectionUl.prev(),
				selectableSearchString = '#'+that.$container.attr('id')+' .ms-elem-selectable:not(.ms-selected)',
				selectionSearchString = '#'+that.$container.attr('id')+' .ms-elem-selection.ms-selected';

			that.qs1 = $selectableSearch.quicksearch(selectableSearchString)
			.on('keydown', function(e){
			  if (e.which === 40){
				that.$selectableUl.focus();
				return false;
			  }
			});

			that.qs2 = $selectionSearch.quicksearch(selectionSearchString)
			.on('keydown', function(e){
			  if (e.which == 40){
				that.$selectionUl.focus();
				return false;
			  }
			});
		},
		afterSelect: function(values){
			var course_id = $("#course_id").val();
			//alert($("#course_id").val());
			if(course_id == '0'){
				alert("กรุณาเลือกหัวข้อการอบรม");
				 $("#empno").find("option[value="+values+"]").prop("selected", false);
				 $("#empno").multiSelect('refresh');
				return false;
			}else{
				//alert(values);
				$.post("job_data.php",{
					status:"save_select_emp",
					course_id : course_id,
					empno : values
				}).done(function(data){	
					//alert(data);
					/*$("#empno").html(data);
					$("#empno").multiSelect('refresh');*/
				})
				/*$.ajax({
					url: 'job_data.php',
					type: "POST",
					async: false,
					dataType: "json",
					data   : {status:"Y",type:'add',title:values,depid:$(".sl_dep").val()}
				});*/
			}
		},
		afterDeselect: function(values){
			var course_id = $("#course_id").val();
			$.post("job_data.php",{
				status:"delete_select_emp",
				course_id : course_id,
				empno : values
			}).done(function(data){	
				//alert(data);
				/*$("#empno").html(data);
				$("#empno").multiSelect('refresh');*/
			})
			/*$.ajax({
				url: 'job_data.php',
				type: "POST",
				async: false,
				dataType: "json",
				data   : {status:"Y",type:'del',title:values,depid:$(".sl_dep").val()}
			});*/
		}
    });
	
	
	
	
});
function ch_del(){
	$.ajax({
		url: 'job_data.php',
		type: "POST",
		async: false,
		dataType: "json",
		data   : {status:'X',type:'tbtra_match',depid:"P009"},
		success: function(data) {
			var data = data.data;
			for(var i=0;i<data.length;i++){
				$("#empno option[value='" +data[i]['tra_id']+ "']").prop("selected", true);
			}
		}
	});
}
function getParameterByName(name) {
	name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
	var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
		results = regex.exec(location.search);
	return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}

	function select_all(){
	//alert($('.ms-elem-selectable').lenght());
	$('#empno').multiSelect('select_all');
	//alert($('#empno').val());
	$.ajax({
				url: 'job_data.php',
				type: "POST",
				data   : {status:"Y_all",type:'add',titles:$('#empno').val(),depid:$(".sl_dep").val()},
				success: function(data) {
				
				//alert(data);
				
			
				}});
	}
function deselect_all(){
	
	$('#empno').multiSelect('deselect_all');
	$.ajax({
				url: 'job_data.php',
				type: "POST",
				data   : {status:"Y_all",type:'del',depid:$(".sl_dep").val()},
				success: function(data) {
				
				//alert(data);
				
			
				}});
	
	}
</script>
</head>

<body class=" ">


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
                        	<b>หัวข้อการอบรม : </b><?php echo dropdown_coures_list();?>
							
							<br><br>
							<b>ตำแหน่ง : </b><?php echo dropdown_position();?>
									<!--<select class="sl_dep" name="sl_dep">
											<option value="0">---เลือก---</option>
											<option value="P017">IT Support</option>
											<option value="P016">W/H Manager</option>
											<option value="P015">Programmer</option>
											<option value="P014">Engineer</option>
											<option value="P013">Engineer Manager</option>
											<option value="P012">Senior W/H Manager</option>
											<option value="P011">Assist W/H Manager</option>
											<option value="P010">IT Manager</option>
											<option value="P009">Operative</option>
											<option value="P008">FL</option>
											<option value="P007">Admin</option>
											<option value="P006">PL staff</option>
											<option value="P005">Leader</option>
											<option value="P004">Supervisor</option>
											<option value="P003">Manager</option>
											<option value="P002">General Manager</option>
											<option value="P001">Managing Director</option>
										  </select>--><hr>
							<select id='empno' class="searchable" multiple='multiple' >
								
							</select>
							
							<div id='display_error'></div>
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
<script type="text/javascript" src="assets/js/jquery.multi-select.js"></script>
<script type="text/javascript" src="assets/js/jquery.quicksearch.js"></script>


</body>
</html>