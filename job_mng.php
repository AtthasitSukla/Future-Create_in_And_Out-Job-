<? include("connect.php");  ?>
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
<link rel="stylesheet" type="text/css" href="assets/css/multi-select.css">
<script type="text/javascript" src="assets/js/jquery-1.10.2.min.js"></script>

<script>
var st = "";
$(function() {
	$.ajax({
			url: 'job_data.php',
			type: "POST",
			async: false,
			dataType: "json",
			data   : {status:'R',type:'tbtra_title',id:0},
			success: function(data) {
				var data = data.data;
				title_all = "";
				for(var i=0;i<data.length;i++){
					title_all += "<option value="+data[i]['tra_id']+">"+data[i]['tra_title']+"</option>";
				}
				$("#title_all").html(title_all);
			}
	});
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
	$('.sl_dep').on('change', function() {
		$("#title_all option:selected").removeAttr("selected");
		var sl_dep = $( ".sl_dep" ).val();
		if( sl_dep != '0' ){
			$.ajax({
				url: 'job_data.php',
				type: "POST",
				async: false,
				dataType: "json",
				data   : {status:'X',type:'tbtra_match',depid:sl_dep},
				success: function(data) {
					var data = data.data;
					for(var i=0;i<data.length;i++){
						 $("#title_all").find("option[value="+data[i]+"]").prop("selected", "selected");
					}
				}
			});
		}
		$("#title_all").multiSelect('refresh');
	});
	
	$('#title_all').multiSelect({
		//selectableOptgroup: true,
		selectableHeader: "<div class='custom-header' style='font-weight:bold;'>หัวข้อทั้งหมด</div><input type='button' value='Select All' onClick='select_all();'></br><input type='text' class='search-input' autocomplete='off' placeholder='หัวข้อทั้งหมด'>",
		selectionHeader: "<div class='custom-header' style='font-weight:bold;'>หัวข้อที่สอน</div><input type='button' value='De Select All' onClick='deselect_all();'></br><input type='text' class='search-input' autocomplete='off' placeholder='หัวข้อที่สอน'>",
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
			if($(".sl_dep").val() == '0'){
				alert("กรุณาเลือกหลักสูตรตำแหน่ง");
				 $("#title_all").find("option[value="+values+"]").prop("selected", false);
				 $("#title_all").multiSelect('refresh');
				return false;
			}
			$.ajax({
				url: 'job_data.php',
				type: "POST",
				async: false,
				dataType: "json",
				data   : {status:"Y",type:'add',title:values,depid:$(".sl_dep").val()}
			});
		},
		afterDeselect: function(values){
			$.ajax({
				url: 'job_data.php',
				type: "POST",
				async: false,
				dataType: "json",
				data   : {status:"Y",type:'del',title:values,depid:$(".sl_dep").val()}
			});
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
				$("#title_all option[value='" +data[i]['tra_id']+ "']").prop("selected", true);
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
	$('#title_all').multiSelect('select_all');
	//alert($('#title_all').val());
	$.ajax({
				url: 'job_data.php',
				type: "POST",
				data   : {status:"Y_all",type:'add',titles:$('#title_all').val(),depid:$(".sl_dep").val()},
				success: function(data) {
				
				//alert(data);
				
			
				}});
	}
function deselect_all(){
	
	$('#title_all').multiSelect('deselect_all');
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
                        	
							<b>หลักสูตรตำแหน่ง : </b><select class="sl_dep" name="sl_dep" style="width:200px">
											<option value="0">---เลือก---</option>
                                           
                                            <?
                                            $sql = "select * from tbposition where site='HQ' order by positionid";
                                            $re = mssql_query($sql);
											$num = mssql_num_rows($re);
											if($num>0){
                                            while($row = mssql_fetch_array($re)){
												?>
												<option value="<?=$row['positionid']?>">[HQ] <?=$row['positionname']?></option>
												<?
												}
												}
											?>
                                            
                                            <?
                                            $sql = "select * from tbposition where site='TSC' order by positionid";
                                            $re = mssql_query($sql);
											$num = mssql_num_rows($re);
											if($num>0){
                                            while($row = mssql_fetch_array($re)){
												?>
												<option value="<?=$row['positionid']?>">[TSC] <?=$row['positionname']?></option>
												<?
												}
												}
											?>
                                             <?
                                            $sql = "select * from tbposition where site='OSW' order by positionid";
                                            $re = mssql_query($sql);
											$num = mssql_num_rows($re);
											if($num>0){
                                            while($row = mssql_fetch_array($re)){
												?>
												<option value="<?=$row['positionid']?>">[OSW] <?=$row['positionname']?></option>
												<?
												}
												}
											?>
											
										  </select><hr>
							 <select id='title_all' class="searchable" multiple='multiple' ></select>
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