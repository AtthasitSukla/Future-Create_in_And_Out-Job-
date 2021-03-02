<? 
include("connect.php"); 
include("library.php"); 
$date_num=date("m/d/Y");
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>I-Wis HQ : OJT Record</title>
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
<script type="text/javascript" src="assets/js/jquery-1.10.2.min.js"></script>
<style>
.textAlignVer{
    display:block;
    filter: flipv fliph;
    -webkit-transform: rotate(-90deg); 
    -moz-transform: rotate(-90deg); 
    transform: rotate(-90deg); 
    position:relative;
    white-space:nowrap;
    font-size:12px;
	font-family:Tahoma;
	/*font-weight:bold*/
	
    
}
td {
    font-size: 12px;
}
th {
    font-size: 12px;
	text-align: center;
}

#tr_h{
    font-size: 18px;
}
.ui-draggable, .ui-droppable {
	background-position: top;
}
.img_click{
    cursor: pointer;
}


</style>
<script>

$(document).on("click", ".open_edit_skill_metric", function () {
    //$("#type_skill").val("Manual");
    var empno = $(this).data('todo').empno;
    var tra_id = $(this).data('todo').tra_id;
    $("#empno").val(empno);
    $("#tra_id").val(tra_id);
    $.post("getajax_skill_metric.php",{
        status:"show_skill_metric",
        empno : empno,
        tra_id : tra_id
    }).done(function(data){			
        var aa =data;					
        var bb = aa.split("###",150);
        //alert(bb[0]);
        $("#type_skill").val(bb[0]);
        if(bb[1]==0){
            $("#number_skill").val(1);
            $("#show_number_skill").hide();
        }else{
            //alert(bb[1]);
            $("#number_skill").val(bb[1]);
        }
    })
    //alert(tra_id);
});

function select_type_skill(){
    var type_skill = $("#type_skill").val();
    if(type_skill=="Auto"){
        $("#show_number_skill").hide();
    }else if(type_skill=="Manual"){
        $("#show_number_skill").show();
    }
}
function save_skill_metric(){
    var type_skill = $("#type_skill").val();
    var number_skill = $("#number_skill").val();
    var empno = $("#empno").val();
    var tra_id = $("#tra_id").val();
    if(type_skill == "Auto"){
        number_skill = 0;
    }
    $.post("getajax_skill_metric.php",{
        status:"save_skill_metric",
        empno : empno,
        tra_id : tra_id,
        type_skill : type_skill,
        number_skill : number_skill
    }).done(function(data){	
        location.reload();	
        /*var aa =data;					
        var bb = aa.split("###",150);
        $("#type_skill").val(bb[0]);
        if(bb[1]==0){
            $("#show_number_skill").hide();
        }else{
            $("number_skill").val(bb[1]);
        }*/
    })
}
function gotosearch(){
	var tra_group = $("#tra_group").val();
	var txtsearch= $("#txtsearch").val();
	window.location='skill_metric.php?tra_group='+tra_group+'&txtsearch='+txtsearch;
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
                            $departmentid = $_SESSION['departmentid'];
                            //echo $departmentid."SSSSS";
							$tra_group = $_REQUEST['tra_group'];
							$txtsearch = $_REQUEST['txtsearch'];
							
							
							
                            $sql = "select * from tbdepartment where departmentid='$departmentid'";
                            //echo $sql;
                                            $re = mssql_query($sql);
											$num = mssql_num_rows($re);
											if($num>0){
                                           $row = mssql_fetch_array($re);
										   $department = $row['department'];
												}			
										
							
						?>
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="10%"><p ><b>Select Group : </b>
                                
                                
								</p></td>
    <td width="16%">  <select id="tra_group" name="tra_group" class="form-control" style="width:150px">
                    <option value="">Select</option>
                    <option value="QP" <?
                    if($tra_group=='QP'){
						?> selected<?
						}
					?>>QP</option>
                    <option value="JD" <?
                    if($tra_group=='JD'){
						?> selected<?
						}
					?>>JD</option>
                     <option value="WI" <?
                    if($tra_group=='WI'){
						?> selected<?
						}
					?>>WI</option>
                     <option value="Q-Point" <?
                    if($tra_group=='Q-Point'){
						?> selected<?
						}
					?>>Q-Point</option>
                     <option value="PDS" <?
                    if($tra_group=='PDS'){
						?> selected<?
						}
					?>>PDS</option>
                     <option value="PPS" <?
                    if($tra_group=='PPS'){
						?> selected<?
						}
					?>>PPS</option>
                     <option value="Other" <?
                    if($tra_group=='Other'){
						?> selected<?
						}
					?>>Other</option>
                    </select></td><td width="10%"><p ><b>Search : </b></p></td><td width="16%"><input type="text" value="<?=$txtsearch?>" class="form-control" id="txtsearch">
								
    </td>
    <td width="74%"><button type="button" class="btn btn-success"  onClick="gotosearch();">ค้นหา</button></td>
  </tr>
</table>

							 
                                <HR>
                                <div class="col-md-12" >
                                
  <table border="0" cellspacing="0" cellpadding="0" style="display: block;overflow: scroll;">
  <tr>
    <td bgcolor="#ffffff">
    <table cellspacing="1" border="1" >
  <tr>
    <td width="100" height="25" align="center" bgcolor="#cccccc"><strong>Department</strong></td>
    <td width="200" align="center" colspan="2"  bgcolor="#cccccc"><strong><?=$department?></strong></td>
    <td width="40" align="center" bgcolor="#cccccc"><strong>No.</strong></td>
    
    
     <?
	 
	 						if($departmentid!=''){
										
	 									if($tra_group!=''){
											$condition = "and tra_group='$tra_group'";
											}else{
												$condition = " ";
												}
										
										if($txtsearch!=''){
											$condition2 = " and tra_title like '%".$txtsearch."%' ";
											}else{
												$condition2 = " ";
												}
										
	 									if($tra_group=='' && $txtsearch==''){
											$sql = "select * from  tbtra_title where 1=0";
											}else{
											//	$sql = "select * from  tbtra_title where tra_id in(select tra_id from tbtra_match where positionid in(select positionid from tbemployee where departmentid='$departmentid')) $condition $condition2";
												$sql = "select * from  tbtra_title where tra_id in(select tra_id from tbtra_match where positionid in(select positionid from tbemployee where empno in(select emp_under from tbleave_control where emp_control='".$_SESSION['admin_userid']."')) ) $condition $condition2";
												}
	 
    										
									//	echo $sql;
                                            $re = mssql_query($sql);
											$num = mssql_num_rows($re);
											if($num>0){
												$itra=0;
                                           while($row = mssql_fetch_array($re)){
											   $itra++;
											   	?>
				<td width="400" align="center" bgcolor="#cccccc"><strong><?=$itra?>.</strong></td>
												<?
											   }
												}
	?>
    
  </tr>
  <tr>
    <td height="25" align="center" bgcolor="#FFFFFF"><strong>Group</strong></td>
    <td width="200" align="center" colspan="2"  bgcolor="#FFFFFF"><?
    if($tra_group!=''){
		echo $tra_group;
		}else{
			echo "ALL"; 
			}
	?></td>
    <td rowspan="2" height="200" align="center" bgcolor="#FFFFFF" ><span class="textAlignVer">JOB NAME</span></td>
    <?
    										//$sql = "select * from  tbtra_title where tra_id in(select tra_id from tbtra_match where positionid in(select positionid from tbemployee where departmentid='$departmentid')) $condition ";
											if($tra_group=='' && $txtsearch==''){
											$sql = "select * from  tbtra_title where 1=0";
											}else{
											//	$sql = "select * from  tbtra_title where tra_id in(select tra_id from tbtra_match where positionid in(select positionid from tbemployee where departmentid='$departmentid')) $condition $condition2";
											$sql = "select * from  tbtra_title where tra_id in(select tra_id from tbtra_match where positionid in(select positionid from tbemployee where empno in(select emp_under from tbleave_control where emp_control='".$_SESSION['admin_userid']."'))) $condition $condition2";
												}
                                            $re = mssql_query($sql);
											$num = mssql_num_rows($re);
											if($num>0){
                                           while($row = mssql_fetch_array($re)){
											   	?>
<td rowspan="3" align="center" bgcolor="#FFFFFF"><span class="textAlignVer"><?

//echo "12345";
//=lang_thai_from_database($row['tra_title'])
//lang_thai_from_database($row['tra_title'])
//echo lang_thai_from_database(substr($row['tra_title'], 0, 17));
echo lang_thai_from_database($row['tra_title']);

?></span></td>
												<?
											   }
												}
	?>
   
  </tr>
  <tr>
    <td height="25" align="center" bgcolor="#FFFFFF"><strong>Issue Date</strong></td>
    <td width="200" colspan="2"  align="center" bgcolor="#FFFFFF"><?=$date_num?></td>
  </tr>
  
  
  <tr>
    <td height="25" align="center" bgcolor="#FFFFFF"><strong>No.</strong></td>
    <td width="200" align="center" bgcolor="#FFFFFF"><strong>Position</strong></td>
    <td width="200" align="center" bgcolor="#FFFFFF"><strong>Name</strong></td>
    <td width="200" align="center" bgcolor="#FFFFFF"><strong>Empno</strong></td>
  </tr>
  
  <?
  					//$sqlx = "select * from tbemployee where departmentid='$departmentid' and delstatus='0' order by emp_level desc";
					$sqlx = "select * from tbemployee where empno in(select emp_under from tbleave_control where emp_control='".$_SESSION['admin_userid']."') and delstatus='0' order by emp_level desc";
											
                                            $rex = mssql_query($sqlx);
											$numx = mssql_num_rows($rex);
											if($numx>0){
												$iemp = 0;
                                            while($rowx = mssql_fetch_array($rex)){
												$iemp++;
												
													?>
													<tr>
    <td height="25" align="center" bgcolor="#FFFFFF"><?=$iemp?>.</td>
      <td  align="center" bgcolor="#FFFFFF"><?=get_positionname($rowx['positionid'])?></td>
    <td  align="center" bgcolor="#FFFFFF"><?=lang_thai_from_database($rowx['firstname'])?></td>
    <td  align="center" bgcolor="#FFFFFF"><?=$rowx['empno']?></td>
   
  <?
    										//$sql = "select * from  tbtra_title where tra_id in(select tra_id from tbtra_match where positionid in(select positionid from tbemployee where departmentid='$departmentid')) $condition ";
											if($tra_group=='' && $txtsearch==''){
											$sql = "select * from  tbtra_title where 1=0";
											}else{
											//	$sql = "select * from  tbtra_title where tra_id in(select tra_id from tbtra_match where positionid in(select positionid from tbemployee where departmentid='$departmentid')) $condition $condition2";
											$sql = "select * from  tbtra_title where tra_id in(select tra_id from tbtra_match where positionid in(select positionid from tbemployee where empno in(select emp_under from tbleave_control where emp_control='".$_SESSION['admin_userid']."'))) $condition $condition2";
												}
                                            $re = mssql_query($sql);
											$num = mssql_num_rows($re);
											if($num>0){
                                           while($row = mssql_fetch_array($re)){
											   
											   
											   $sqltra = "select *,convert(varchar, tra_date, 101)as  startdate2 from tbtra_group where empno='".$rowx['empno']."' and group_id in(select group_id from  tbtra_result where tra_id='".$row['tra_id']."')";
											//  echo $sqltra;
                                            $retra = mssql_query($sqltra);
											$numtra = mssql_num_rows($retra);
											if($numtra>0){
												 $rowtra = mssql_fetch_array($retra);	
												 //calc 
													$startdate2 = $rowtra['startdate2'];      //รูปแบบการเก็บค่าข้อมูลวันเกิด
													$today = date("m/d/Y");   //จุดต้องเปลี่ยน
													list($bmonth, $bday, $byear)= explode("/",$startdate2);       //จุดต้องเปลี่ยน
													list($tmonth, $tday, $tyear)= explode("/",$today);                //จุดต้องเปลี่ยน
													$mbirthday = mktime(0, 0, 0, $bmonth, $bday, $byear); 
													$mnow = mktime(0, 0, 0, $tmonth, $tday, $tyear );
													$mage = ($mnow - $mbirthday);
													$u_y=date("Y", $mage)-1970;
													$u_m=date("m",$mage);
													$u_d=date("d",$mage)-1;
													//อายุงานครบ1ปีได้300บาท , 3 ปี 400 , 5 ปี 500 
													$month_employment = 0;
													if($u_y>=1){
														$month_employment = 12;
														}else{
															$month_employment = $u_m;
															}
												}
											   
											?><td align="center" bgcolor="#FFFFFF"><?
                                          //  echo "( $u_y   ปี  $u_m เดือน  $u_d  วัน )";
                                            
                                            $empno_tra = $rowx['empno'];
                                            $tra_id = $row['tra_id'];
                                            $sql_tra_manual = "SELECT * FROM tbskill_metric_munual WHERE empno='$empno_tra' AND tra_id='$tra_id' AND type_skill='Manual'";
                                            $res_tra_manual = mssql_query($sql_tra_manual);
                                            $num_tra_manual = mssql_num_rows($res_tra_manual);
                                            if($num_tra_manual>0){
                                                $row_tra_manual = mssql_fetch_array($res_tra_manual);
                                                $number_skill = $row_tra_manual["number_skill"];
                                                ?><span class="img_click"><span data-toggle="modal" class="open_edit_skill_metric" data-target="#modal_skill_metric" data-todo='{"empno":"<?=$rowx['empno']?>","tra_id":"<?=$row['tra_id'];?>"}'><img src="images/<?=$number_skill?>_manual.jpg" width="25"></span></span><?
                                            }else{

                                                if($rowx['emp_level']>=4){
                                                    ?><span class="img_click"><span data-toggle="modal" class="open_edit_skill_metric" data-target="#modal_skill_metric" data-todo='{"empno":"<?=$rowx['empno']?>","tra_id":"<?=$row['tra_id'];?>"}'><img src="images/4.jpg" width="25"></span></span><?
                                                }else{
                                                        $sqlskill = "select * from tbtra_result where 
                                                    tra_res = '1' and
                                                    tra_id='".$row['tra_id']."' and 
                                                    group_id in(select group_id from tbtra_group where empno='".$rowx['empno']."' )";
                                                    //echo  $sqlskill;
                                                        $reskill = mssql_query($sqlskill);
                                                        $numskill = mssql_num_rows($reskill);
                                                        if($numskill>0){
                                                            
                                                            $imageskill = "1";
                            
                                                        if($month_employment==1){
                                                            $imageskill = "2";
                                                            }
                                                        if($month_employment==2){
                                                            $imageskill = "3";
                                                              }
                                                        if($month_employment>3){
                                                            $imageskill = "4";
                                                            }
                                                            
                                                    ?>
                                                <span class="img_click"><span data-toggle="modal" class="open_edit_skill_metric" data-target="#modal_skill_metric" data-todo='{"empno":"<?=$rowx['empno']?>","tra_id":"<?=$row['tra_id'];?>"}'><img src="images/<?=$imageskill?>.jpg" width="25"></span></span>
                                                    <?
                                                    
                                                    
                                                    
                                                    
                                                    }
                                                }
                                            }
												
												
											   	?></td>
												<?
											   }
												}
	?>
    
    
  </tr>
													<?
												}
												}
  ?>
  
  
  
  <?
  }
  ?>
</table>

      <BR>
        
       
    </td>
   
  </tr>
  <tr> <td height="20" align="right" bgcolor="#FFFFFF">FM-HR-08 Rev.00 : 20/9/2015<BR></td></tr>
</table>


                              

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

 <!-- Modal -->
    <div class="modal fade" id="modal_skill_metric" role="dialog">
        <div class="modal-dialog modal-sm">
        
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Edit Skill Metric</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="empno" name="empno" >
                    <input type="hidden" id="tra_id" name="tra_id" >
                    <div class="form-group">
                        <select name="type_skill" id="type_skill" class="form-control" onchange="select_type_skill()">
                            <option value="Auto">Auto</option>
                            <option value="Manual">Manual</option>
                        </select>
                    </div>
                    <div class="form-group" id="show_number_skill">
                        <select name="number_skill" id="number_skill" class="form-control">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" onclick="save_skill_metric()">Save</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        
        </div>
    </div>

    <footer role="contentinfo">
        <div class="clearfix">
            <ul class="list-unstyled list-inline">
                <li>I-Wis</li>
                <button class="pull-right btn btn-inverse-alt btn-xs hidden-print" id="back-to-top"><i class="fa fa-arrow-up"></i></button>
            </ul>
        </div>
    </footer>

</div> <!-- page-container -->

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