<? 
session_start();
include("connect.php");
include("library.php");
$eva_id = $_REQUEST['eva_id'];
$eva_period = $_REQUEST['eva_period'];	
$empno 	= $_REQUEST['empno'];	
$status = $_REQUEST['status'];
					
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>I-Wis HRS : Evaluate</title>
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
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel='stylesheet' type='text/css' href='assets/css/bootstrap.min.css' /> 
<!--link rel='stylesheet' type='text/css' href='assets/css/dataTables.bootstrap.min.css' /--> 
<link rel='stylesheet' type='text/css' href='assets/css/buttons.dataTables.min.css' />
<!--link rel="stylesheet" type="text/css" href="assets/css/multi-select.css"-->
<!--<script type="text/javascript" src="assets/js/jquery-1.10.2.min.js"></script>-->
<script src="https://code.jquery.com/jquery-2.2.0.min.js"></script> 
<style>
td {
    font-size: 12px;
}
th {
    font-size: 12px;
}

#tr_h{
    font-size: 18px;
}
.ui-draggable, .ui-droppable {
	background-position: top;
}

</style>
<script>

$(function() {
	
	
	});
	function myTrim(x){return x.replace(/^\s+|\s+$/gm,'')}
	function import_data(){
		
			var eva_period =  $("#eva_period").val();
			var empno =  $("#empno").val();
			//var eva_group_title = $("#eva_group_title").val();
			var eva_id = $("#eva_id").val();
			var eva_id_clone = $("#eva_id_clone").val();
			if(eva_id_clone==''){
					alert('Please Select Person To Import');
				}else{
						$.post("getajax_evaluate.php",{
					status:"import_data",
					eva_id_clone:eva_id_clone,
					eva_id:eva_id,
					eva_period:eva_period,
					empno:empno,
					sid:Math.random()}).done(function(data){

					//	var aa=myTrim(data);					
					//	 var bb = aa.split("###",150);
						
						
						
					//	$("#nissan_issue").focus();
						//showsummary(eva_id);
		window.location = 'form_evaluate.php?eva_id='+eva_id+'&eva_period='+eva_period+'&empno='+empno;
					});
					}
		
		}
	function add_group_title(){
			var eva_period =  $("#eva_period").val();
			var empno =  $("#empno").val();
			var eva_group_title = $("#eva_group_title").val();
			var eva_id = $("#eva_id").val();
			if(eva_group_title==''){
					alert('Please input group tilte');
				}else{
						$.post("getajax_evaluate.php",{
					status:"add_group_title",
					eva_group_title:eva_group_title,
					eva_id:eva_id,
					eva_period:eva_period,
					empno:empno,
					sid:Math.random()}).done(function(data){

					//	var aa=myTrim(data);					
					//	 var bb = aa.split("###",150);
						
						
						
						$("#nissan_issue").focus();
						//showsummary(eva_id);
		window.location = 'form_evaluate.php?eva_id='+eva_id+'&eva_period='+eva_period+'&empno='+empno;
					});
					}
		}
	
	function create_new(){
		
			$.post("getajax_evaluate.php",{
					status:"create_new",
					eva_period:eva_period,
					sid:Math.random()}).done(function(data){
						var aa=myTrim(data);	
							window.location = 'form_evaluate.php?eva_id='+aa;
					});
		}
	
	function add_sub_title(eva_group_id){
		var eva_period =  $("#eva_period").val();
		var empno  =  $("#empno").val();
		var eva_id = $("#eva_id").val();
		var eva_title_add = $("#eva_title_add"+eva_group_id).val();
				$.post("getajax_evaluate.php",{
					status:"add_sub_title",
					eva_id:eva_id,
					eva_title_add:eva_title_add,
					eva_group_id:eva_group_id,
					sid:Math.random()}).done(function(data){
						var aa=myTrim(data);	
				window.location = 'form_evaluate.php?eva_id='+eva_id+'&eva_period='+eva_period+'&empno='+empno;
					});
		}
	function update_eva(eva_group_id,id){
		var eva_id = $("#eva_id").val();
		var eva_type= $("#eva_type"+id).val();
		var eva_title= $("#eva_title"+id).val();
		var eva_weight= $("#eva_weight"+id).val();
		var eva_criteria= $("#eva_criteria"+id).val();
		//eva_criteria.replace(/\r\n|\r|\n/g,"<br />");
				$.post("getajax_evaluate.php",{
					status:"update_eva",
					eva_id:eva_id,
					eva_type:eva_type,
					eva_title:eva_title,
					eva_weight:eva_weight,
					eva_criteria:eva_criteria,
					eva_group_id:eva_group_id,
					id:id,
					sid:Math.random()}).done(function(data){
						$("#display_eva_weight").html('');
						var aa=myTrim(data);	
						$("#display_eva_weight").html(aa);
					});
		}
	function update_eva2(eva_group_id,id){
		var eva_id = $("#eva_id").val();
		//var eva_type= $("#eva_type"+id).val();
		//var eva_title= $("#eva_title"+id).val();
		//var eva_weight= $("#eva_weight"+id).val();
		var eva_result= $("#eva_result"+id).val();
		//eva_criteria.replace(/\r\n|\r|\n/g,"<br />");
				$.post("getajax_evaluate.php",{
					status:"update_eva2",
					eva_id:eva_id,
					
					eva_result:eva_result,
					id:id,
					sid:Math.random()}).done(function(data){
						//$("#display_eva_weight").html('');
						//var aa=myTrim(data);	
						//$("#display_eva_weight").html(aa);
					});
		}
		function delete_eva(id){
				$.post("getajax_evaluate.php",{
					status:"delete_eva",
					id:id,
					sid:Math.random()}).done(function(data){
						window.location.reload();
					});
		}
		function delete_title(eva_group_id){
				$.post("getajax_evaluate.php",{
					status:"delete_title",
					eva_group_id:eva_group_id,
					sid:Math.random()}).done(function(data){
						window.location.reload();
					});
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
                    <div class="panel-body" style="border:2px solid #dddddd;">
			
            <?
            		$select_emp = "select * from tbemployee where empno='$empno'";
					$re_emp = mssql_query($select_emp);
					$num_emp=mssql_num_rows($re_emp);
					if($num_emp>0){
					 $row_emp = mssql_fetch_array($re_emp);
					 $positionid = $row_emp['positionid'];
					  $departmentid = $row_emp['departmentid'];
					}
			?>
            <table align="left" width="400" border="0" cellspacing="0" cellpadding="0">
  <tr>
    
    <td width="150"><table width="150" align="left"  border="0" cellspacing="0" cellpadding="0" >
  
  <tr>
    <td height="50" align="center"><img src="images/ipack_logo_big.png" height="60" ></td>
  </tr>
  <tr>
    <td height="70" align="center" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td  align="center"><?
        if(file_exists("emppic/".$empno.".jpg")){
			$pic = $empno.".jpg";
			}else{
				$pic = "blank.jpg";
				}
		?><img src="emppic/<?=$pic?>"></td>
       
      </tr>
    </table></td>
  </tr>
  
  
</table></td>
<td valign="bottom"><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="right">&nbsp;ชื่อ :&nbsp;<?=get_full_name($empno);?></td>
  </tr>
  <tr>
    <td align="right">&nbsp;ตำแหน่ง :&nbsp;<?=get_positionname($positionid);?></td>
  </tr>
  <tr>
    <td align="right">&nbsp;แผนก :&nbsp;<?=get_departmentname($departmentid);?></td>
  </tr>
</table>
</td>
  </tr>
</table>

            
	
    </div>
    		<?
            if($status==''){
			?>

			
						
						<div class="panel-body">
							 <div class="col-md-12" >
                             <input type="hidden" id="eva_period" value="<?=$eva_period?>">
                             <input type="hidden" id="empno" value="<?=$empno?>">
								<?
								if($eva_id==''){
									?>
									 <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="17%" align="right">&nbsp;</td> 
    <td width="35%">&nbsp;<input type="button" value="Create New" onClick="create_new();"></td> 
    <td width="48%"></td>
  </tr>
</table>
									<?
									}
                                if($eva_id!=''){
								?>
 <table width="100%" border="0" cellspacing="0" cellpadding="0">
 <tr>
    <td width="17%" align="right"><strong>Evaluate ID :</strong></td> <td width="35%">
      <input type="text" readonly value="<?=$eva_id?>" id="eva_id" size="50"></td> <td width="48%"><?
      				
					$selectx = "select departmentid,positionid,emp_level from  tbemployee where empno='$empno'";
					$rex = mssql_query($selectx);
					$numx=mssql_num_rows($rex);
					if($numx>0){
					$rowx = mssql_fetch_array($rex);
					$departmentid = $rowx['departmentid'];
					$positionid = $rowx['positionid'];
					$emp_level = $rowx['emp_level'];
					}
					?>
					<select id="eva_id_clone">
                    <option value="">Select</option>
                    <?
					$selectx = "select distinct eva_id,empno from  tbevaluate where eva_period='$eva_period' and empno in(select empno from tbemployee where departmentid='$departmentid' and emp_level='$emp_level') and empno<>'$empno' order by empno asc";
					$rex = mssql_query($selectx);
					$numx=mssql_num_rows($rex);
					if($numx>0){
					 while($rowx = mssql_fetch_array($rex)){
							?><option value="<?=$rowx['eva_id']?>"><?=$rowx['empno']?>&nbsp;<?=get_full_name($rowx['empno'])?></option><?
					 	}
					}
		
	 				 ?>
                    </select>&nbsp;<input type="button" value="Import Data" onClick="import_data();">
					</td>
  </tr>
 
  <tr>
    <td width="17%" align="right"><strong>Group Title :</strong></td> 
    <td width="35%"><input type="text" value="" id="eva_group_title" size="50">&nbsp;<input type="button" value="Add" onClick="add_group_title();"></td> 
    <td width="48%"></td>
  </tr>
  
  
</table>
<HR>
<div id="showsummary">
 <table align="center" width="100%" border="0" cellspacing="2" cellpadding="0" class="table table-striped table-bordered datatables" id="example">
 
  <?
  					$select = "select * from tbevaluate where eva_id ='$eva_id' order by id asc";
					$re = mssql_query($select);
					$num=mssql_num_rows($re);
					if($num>0){
						 $i= 0;
					 while($row = mssql_fetch_array($re)){
						 $i++;
						 $eva_group_title = lang_thai_from_database($row['eva_group_title']);
						 $eva_group_id =$row['eva_group_id'];
					?>
                    
  <tr>
    <td align="center"><font size="4"><strong><?=$i?>.</strong></font></td> 
    <td align="left" style="padding-left:5px"><font size="4"><strong><?=$eva_group_title?></strong></font>&nbsp;<input type="button" value="Del" onClick="delete_title('<?=$eva_group_id?>')"></td> 
   
  </tr>
					
                    <tr>
        <td align="center">&nbsp;</td>             
    <td  colspan="2" align="center">
  
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="17%" align="right"><strong>Sub Title :</strong></td> 
    <td width="35%"><input type="text" value="" id="eva_title_add<?=$eva_group_id?>" size="50">&nbsp;<input type="button" value="Add" onClick="add_sub_title('<?=$eva_group_id?>');"></td> 
    <td width="48%"></td>
  </tr>
</table>
					<?
					$select2 = "select * from tbevaluate_detail where eva_id ='$eva_id' and eva_group_id='$eva_group_id' order by id asc";
					$re2 = mssql_query($select2);
					$num2=mssql_num_rows($re2);
					if($num2>0){
						 $i2= 0;
						 ?>
						 <table align="center" width="100%" border="0" cellspacing="2" cellpadding="0" class="table table-striped table-bordered datatables" id="example">
  <tr>
    <td align="center" bgcolor="#CCCCCC"><strong>No.</strong></td> 
    <td align="center" bgcolor="#CCCCCC"><strong>Title</strong></td> 
     <td align="center" bgcolor="#CCCCCC"><strong>Evaluate</strong></td> 
    <td align="center" bgcolor="#CCCCCC"><strong>Weight</strong></td> 
    <td align="center" bgcolor="#CCCCCC"><strong>Criteria</strong></td> 
     <td align="center" bgcolor="#CCCCCC"><strong>Delete</strong></td> 
  </tr>
						 <?
					 while($row2 = mssql_fetch_array($re2)){
						 $i2++;
						 $eva_title = lang_thai_from_database($row2['eva_title']);
						 $eva_criteria = lang_thai_from_database($row2['eva_criteria']);
						 $eva_criteria = str_replace("<br />", "\n", $eva_criteria); 
						 $eva_weight = $row2['eva_weight'];
						 $total_eva_weight =  $total_eva_weight+$eva_weight;
						 $eva_type = $row2['eva_type'];
						 $id = $row2['id'];
						 ?>
						 <tr>
                            <td align="center"><?=$i?>.<?=$i2?></td> 
                            <td align="center"><input type="text" value="<?=$eva_title?>" id="eva_title<?=$id?>" size="50" onChange="update_eva('<?=$eva_group_id?>','<?=$id?>');"></td> 
                            <td align="center"><select id="eva_type<?=$id?>" onChange="update_eva('<?=$eva_group_id?>','<?=$id?>');">
                            <option value="Monthly" <?
                            if($eva_type=='Monthly'){
								?> selected<?
								}
							?>>Monthly</option>
                             <option value="Yearly" <?
                            if($eva_type=='Yearly'){
								?> selected<?
								}
							?>>Yearly</option>
                            </select></td> 
                            <td align="center"><input type="number" value="<?=$eva_weight?>" id="eva_weight<?=$id?>" size="50" onChange="update_eva('<?=$eva_group_id?>','<?=$id?>');">%</td> 
                             <td align="center"><textarea rows="6" id="eva_criteria<?=$id?>" style="resize: none;" cols="60" onChange="update_eva('<?=$eva_group_id?>','<?=$id?>');"><?=$eva_criteria?></textarea></td> 
                             <td align="center"><input type="button" value="Del" onClick="delete_eva('<?=$id?>');"></td> 
                          </tr>
						 <?
						 }
						 ?>
                         
						 </table>
						 <?
						 }
						 ?>
						 </td></tr>
						 <?
					
					 	}
						?>
						
						<?
					}
  ?>
  <tr>
   
    <td align="center" colspan="2"><strong>Total Weight : <span id="display_eva_weight"><?=$total_eva_weight?>&nbsp;%</span></strong></td> 
  
  </tr>
 
  
  
</table>


</div>


<?
								}
?>

									
							 </div>
							 <hr>
							 
					  </div>
                     
            
            <?
			}
			?>
             
					
            <?
            if($status=='evaluate'){
			?>

		
						
						<div class="panel-body">
							 <div class="col-md-12" >
                             <input type="hidden" id="eva_period" value="<?=$eva_period?>">
                             <input type="hidden" id="empno" value="<?=$empno?>">
								<?
								
									
                                if($eva_id!=''){
								?>
 <table width="100%" border="0" cellspacing="0" cellpadding="0">
 <tr>
    <td width="17%" align="right"><strong>Evaluate ID : </strong></td> <td width="35%">
      <input type="text" readonly value="<?=$eva_id?>" id="eva_id" size="50"></td> <td width="48%"></td>
  </tr>
 
  
  
  
</table>
<HR>
<div id="showsummary">
 <table align="center" width="100%" border="0" cellspacing="2" cellpadding="0" class="table table-striped table-bordered datatables" id="example">
 
  <?
  					$select = "select * from tbevaluate where eva_id ='$eva_id' order by id asc";
					$re = mssql_query($select);
					$num=mssql_num_rows($re);
					if($num>0){
						 $i= 0;
						 $total_eva_result = 0;
					 while($row = mssql_fetch_array($re)){
						 $i++;
						 $eva_group_title = lang_thai_from_database($row['eva_group_title']);
						 $eva_group_id =$row['eva_group_id'];
					?>
                    
  <tr>
    <td align="center"><font size="4"><strong><?=$i?>.</strong></font></td> 
    <td align="left" style="padding-left:5px"><font size="4"><strong><?=$eva_group_title?></strong></font>&nbsp;</td> 
   
  </tr>
					
                    <tr>
        <td align="center">&nbsp;</td>             
    <td  colspan="2" align="center">
  
  
					<?
					$select2 = "select * from tbevaluate_detail where eva_id ='$eva_id' and eva_group_id='$eva_group_id' order by id asc";
					$re2 = mssql_query($select2);
					$num2=mssql_num_rows($re2);
					if($num2>0){
						 $i2= 0;
						 ?>
						 <table align="center" width="100%" border="0" cellspacing="2" cellpadding="0" class="table table-striped table-bordered datatables" id="example">
  <tr>
    <td align="center" bgcolor="#CCCCCC"><strong>No.</strong></td> 
    <td align="center" bgcolor="#CCCCCC"><strong>Title</strong></td> 
     <td align="center" bgcolor="#CCCCCC"><strong>Evaluate</strong></td> 
    <td align="center" bgcolor="#CCCCCC"><strong>Weight</strong></td> 
    <td align="center" bgcolor="#CCCCCC"><strong>Criteria</strong></td> 
     <td align="center" bgcolor="#CCCCCC"><strong>Score</strong></td> 
  </tr>
						 <?
					 while($row2 = mssql_fetch_array($re2)){
						 $i2++;
						 $eva_title = lang_thai_from_database($row2['eva_title']);
						 $eva_criteria = lang_thai_from_database($row2['eva_criteria']);
						 $eva_weight = $row2['eva_weight'];
						 $total_eva_weight =  $total_eva_weight+$eva_weight;
						 $eva_type = $row2['eva_type'];
						 $id = $row2['id'];
						 $eva_result  = $row2['eva_result'];
						 
						 $total_eva_result =  $total_eva_result+(($eva_result*$eva_weight)/100);
						 ?>
						 <tr>
                            <td align="center"><?=$i?>.<?=$i2?></td> 
                            <td align="center"><?=$eva_title?></td> 
                            <td align="center"><?=$eva_type?></td> 
                            <td align="center"><?=$eva_weight?>%</td> 
                             <td align="center"><?=$eva_criteria?></td> 
                             <td align="center"><input type="number" min="0" max="100" value="<?=$eva_result?>" style="width:50px; background-color:#FFC " maxlength="5" id="eva_result<?=$id?>" onChange="update_eva2('<?=$eva_group_id?>','<?=$id?>');">%</td> 
                          </tr>
						 <?
						 }
						 
						 
						 ?>
                         
						 </table>
						 <?
						 }
						 ?>
					    </td></tr>
						 <?
					
					 	}
						?>
						
						<?
					}
  ?>
  <tr>
   
    <td align="right" colspan="2"><font size="4"><strong>Total Weight : <span id="display_eva_weight"><?=$total_eva_weight?>&nbsp;%</span></strong></font>&nbsp;&nbsp;<font size="4"><strong>Total Score : <span id="display_eva_weight"><?=$total_eva_result?>&nbsp;%</span></strong></font></td> 
  
  </tr>
 
  
  
</table>


</div>


<?
								}
?>

									
							 </div>
							 <hr>
							 
					  </div>
					
            
            <?
			}
			?>
            
             <?
            if($status=='preview'){
			?>

			
						
						<div class="panel-body">
							 <div class="col-md-12" >
                             <input type="hidden" id="eva_period" value="<?=$eva_period?>">
                             <input type="hidden" id="empno" value="<?=$empno?>">
								<?
								
									
                                if($eva_id!=''){
								?>
 <table width="100%" border="0" cellspacing="0" cellpadding="0">
 <tr>
    <td width="17%" align="right"><strong>Evaluate ID : </strong></td> <td width="35%">
      <input type="text" readonly value="<?=$eva_id?>" id="eva_id" size="50"></td> <td width="48%"></td>
  </tr>
 
  
  
  
</table>
<HR>
<div id="showsummary">
 <table align="center" width="100%" border="0" cellspacing="2" cellpadding="0" class="table table-striped table-bordered datatables" id="example">
 
  <?
  					$select = "select * from tbevaluate where eva_id ='$eva_id' order by id asc";
					$re = mssql_query($select);
					$num=mssql_num_rows($re);
					if($num>0){
						 $i= 0;
						 $total_eva_result = 0;
					 while($row = mssql_fetch_array($re)){
						 $i++;
						 $eva_group_title = lang_thai_from_database($row['eva_group_title']);
						 $eva_group_id =$row['eva_group_id'];
					?>
                    
  <tr>
    <td align="center"><font size="4"><strong><?=$i?>.</strong></font></td> 
    <td align="left" style="padding-left:5px"><font size="4"><strong><?=$eva_group_title?></strong></font>&nbsp;</td> 
   
  </tr>
					
                    <tr>
        <td align="center">&nbsp;</td>             
    <td  colspan="2" align="center">
  
  
					<?
					$select2 = "select * from tbevaluate_detail where eva_id ='$eva_id' and eva_group_id='$eva_group_id' order by id asc";
					$re2 = mssql_query($select2);
					$num2=mssql_num_rows($re2);
					if($num2>0){
						 $i2= 0;
						 ?>
						 <table align="center" width="100%" border="0" cellspacing="2" cellpadding="0" class="table table-striped table-bordered datatables" id="example">
  <tr>
    <td align="center" bgcolor="#CCCCCC"><strong>No.</strong></td> 
    <td align="center" bgcolor="#CCCCCC"><strong>Title</strong></td> 
     <td align="center" bgcolor="#CCCCCC"><strong>Evaluate</strong></td> 
    <td align="center" bgcolor="#CCCCCC"><strong>Weight</strong></td> 
    <td align="center" bgcolor="#CCCCCC"><strong>Criteria</strong></td> 
     <td align="center" bgcolor="#CCCCCC"><strong>Score</strong></td> 
  </tr>
						 <?
					 while($row2 = mssql_fetch_array($re2)){
						 $i2++;
						 $eva_title = lang_thai_from_database($row2['eva_title']);
						 $eva_criteria = lang_thai_from_database($row2['eva_criteria']);
						 $eva_weight = $row2['eva_weight'];
						 $total_eva_weight =  $total_eva_weight+$eva_weight;
						 $eva_type = $row2['eva_type'];
						 $id = $row2['id'];
						 $eva_result  = $row2['eva_result'];
						 
						 $total_eva_result =  $total_eva_result+(($eva_result*$eva_weight)/100);
						 ?>
						 <tr>
                            <td align="center"><?=$i?>.<?=$i2?></td> 
                            <td align="center"><?=$eva_title?></td> 
                            <td align="center"><?=$eva_type?></td>
                            <td align="center"><?=$eva_weight?>%</td>
                             <td align="center"><?=$eva_criteria?></td> 
                             <td align="center"><?=$eva_result?>%</td> 
                          </tr>
						 <?
						 }
						 
						 
						 ?>
                         
						 </table>
						 <?
						 }
						 ?>
					    </td></tr>
						 <?
					
					 	}
						?>
						
						<?
					}
  ?>
  <tr>
   
    <td align="right" colspan="2"><font size="4"><strong>Total Weight : <span id="display_eva_weight"><?=$total_eva_weight?>&nbsp;%</span></strong></font>&nbsp;&nbsp;<font size="4"><strong>Total Score : <span id="display_eva_weight"><?=$total_eva_result?>&nbsp;%</span></strong></font></td> 
  
  </tr>
 
  
  
</table>


</div>


<?
								}
?>

									
							 </div>
							 <hr>
							 
					  </div>
					
            
            <?
			}
			?>
            </div>
				</div>
			</div>
            <input type="button" value="Back" onClick="location='http://ipack-iwis.com/hrs/list_evaluate.php'">
            
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


<div class="modal fade" id="myModalLeave" role="dialog" >
	<div class="modal-dialog" style="width:700px">
	
	  <!-- Modal content-->
	  
	  
	</div>
  </div>


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
<script type='text/javascript' src='assets/js/jquery.dataTables.min.js'></script> 
<script type='text/javascript' src='assets/js/dataTables.bootstrap.min.js'></script> 


</body>
</html>