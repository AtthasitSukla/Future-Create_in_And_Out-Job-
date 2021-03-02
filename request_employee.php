<?php  
session_start();
include("connect.php");
include("library.php"); 
//$status = $_GET["status"];
$status = $_GET['status'];

 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Hrs : Request Employee</title>
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

    <link rel='stylesheet' type='text/css' href='assets/css/bootstrap.min.css' /> 
    <link rel='stylesheet' type='text/css' href='assets/css/buttons.dataTables.min.css' />
    <link rel='stylesheet' type='text/css' href='assets/css/dataTables.bootstrap.min.css' /> 

    <script type="text/javascript" src="assets/js/jquery-1.10.2.min.js"></script>
    
    <link rel='stylesheet' type='text/css' href='assets/plugins/jqueryui-timepicker/jquery.ui.timepicker.css' /> 
    <link rel='stylesheet' type='text/css' href='assets/plugins/form-daterangepicker/daterangepicker-bs3.css' /> 
    <link rel='stylesheet' type='text/css' href='assets/js/jqueryui.css' /> 

<style>
td {
    padding: 5px;
}
</style>
<script>
$(document).ready(function() {
    $('#example').DataTable({
        "order": [[ 0, "desc" ]]
    });

    $("#target_date_one,#target_date_two,#target_date_three").datepicker({
        dateFormat: 'dd/mm/yy'
    });

});
function save_request_employee_ver1(){
    var departmentid = $("#departmentid").val();
    var positionid_one = $("#positionid_one").val();
    var positionid_two = $("#positionid_two").val();
    var reason = $("#reason").val();
    var male = $("#male").val();
    var female = $("#famale").val();
    var target_date = $("#target_date").val();
    var cause = $("#cause").val();
    //alert(reason);
    $.post("getajax_request_employee.php",{
        status:"save_request_employee_ver1",
        departmentid : departmentid,
        positionid_one : positionid_one,
        positionid_two : positionid_two,
        reason : reason,
        male : male,
        female : female,
        target_date : target_date,
        cause : cause
    }).done(function(data){			
        alert("Success");
        window.location.href="request_employee_list.php";
    })

}

function save_request_employee(){
    var departmentid = $("#departmentid").val();
    var positionid_one = $("#positionid_one").val();
    var positionid_two = $("#positionid_two").val();
   // var reason = $("#reason").val();
    var male_one = $("#male_one").val();
    var female_one = $("#female_one").val();
    var target_date_one = $("#target_date_one").val();
    var cause_one = $("#cause_one").val();
    var male_two = $("#male_two").val();
    var female_two = $("#female_two").val();
    var target_date_two = $("#target_date_two").val();
    var cause_two = $("#cause_two").val();
    var male_three = $("#male_three").val();
    var female_three = $("#female_three").val();
    var target_date_three = $("#target_date_three").val();
    var cause_three = $("#cause_three").val();
    //alert(female_one);
    
    $.post("getajax_request_employee.php",{
        status:"save_request_employee",
        departmentid : departmentid,
        positionid_one : positionid_one,
        positionid_two : positionid_two,
        //reason : reason,
        male_one : male_one,
        female_one : female_one,
        target_date_one : target_date_one,
        cause_one : cause_one,
        male_two : male_two,
        female_two : female_two,
        target_date_two : target_date_two,
        cause_two : cause_two,
        male_three : male_three,
        female_three : female_three,
        target_date_three : target_date_three,
        cause_three : cause_three
    }).done(function(data){	
       // alert(data);		
        alert("Success");
        window.location.href="request_employee_list.php";
    })
    
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

<?php if($status=="ver1") { ?>

			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-primary">
						<div class="panel-heading">ขออัตรากำลังคน</div>
						<div class="panel-body">

                            <div class="form-horizontal" >
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="departmentid">ฝ่าย/แผนก/หน่วยงาน :</label>
                                    <div class="col-sm-2">
                                        <select name="departmentid" id="departmentid" class="form-control">
                                            <option value="">เลือกแผนก</option>
                                            <?php 
                                            $empno_session = $_SESSION['admin_userid'];
                                            $sql_emp = "select departmentid from tbemployee where empno='$empno_session'";
                                            $res_emp = mssql_query($sql_emp);
                                            $row_emp = mssql_fetch_array($res_emp);
                                            $departmentid_emp = $row_emp["departmentid"];
                                            
                                            $sql = "select * from tbdepartment order by department";
                                            $res = mssql_query($sql);
                                            while($row = mssql_fetch_array($res)){
                                                $departmentid = $row["departmentid"];
                                                $department = $row["department"];
                                                if($departmentid_emp==$departmentid){
                                                    $selected = "selected";
                                                }else{
                                                    $selected = "";
                                                }
                                                ?><option value="<?=$departmentid?>" <?=$selected?>><?=$department?></option><?

                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="positionid_one">1.ตำแหน่งงาน :</label>
                                    <div class="col-sm-3">
                                        <select name="positionid_one" id="positionid_one" class="form-control">
                                            <option value="">เลือกตำแหน่ง</option>
                                            <?php 
                                            $sql = "select * from tbposition order by positionname";
                                            $res = mssql_query($sql);
                                            while($row = mssql_fetch_array($res)){
                                                $positionid = $row["positionid"];
                                                $positionname = $row["positionname"];
                                                ?><option value="<?=$positionid?>"><?=$positionname?></option><?

                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="positionid_two">2.ตำแหน่งงาน :</label>
                                    <div class="col-sm-3">
                                        <select name="positionid_two" id="positionid_two" class="form-control">
                                            <option value="">เลือกตำแหน่ง</option>
                                            <?php 
                                            $sql = "select * from tbposition order by positionname";
                                            $res = mssql_query($sql);
                                            while($row = mssql_fetch_array($res)){
                                                $positionid = $row["positionid"];
                                                $positionname = $row["positionname"];
                                                ?><option value="<?=$positionid?>"><?=$positionname?></option><?

                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="reason">ขอเพิ่มพนักงาน :</label>
                                    <div class="col-sm-3">
                                        <select name="reason" id="reason" class="form-control">
                                            <option value="">เลือกเหตุผล</option>
                                            <option value="แทนคนที่ลาออกไป">แทนคนที่ลาออกไป</option>
                                            <option value="รองรับงานที่เพิ่มขึ้น">รองรับงานที่เพิ่มขึ้น</option>
                                            <option value="โดนโอนย้ายไปหน่วยงานอื่น">โดนโอนย้ายไปหน่วยงานอื่น</option>
                                            
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="male">ชาย </label>
                                    <div class="col-sm-1">
                                        <input type="number" name="male" id="male"  class="form-control">
                                    </div>
                                    <label class=" col-sm-2">
                                        อัตรา
                                    </label>

                                </div>    

                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="female">หญิง </label>
                                    <div class="col-sm-1">
                                        <input type="number" name="female" id="female"  class="form-control">
                                    </div>
                                    <label class=" col-sm-2">
                                        อัตรา
                                    </label>

                                </div>   

                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="target_date">วันที่ต้องการ </label>
                                    <div class="col-sm-3">
                                        <input type="text" name="target_date" id="target_date"  class="form-control">
                                    </div>
                                </div>                     
                                    
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="cause">สาเหตุ </label>
                                    <div class="col-sm-6">
                                        <textarea name="cause" id="cause" cols="30" rows="10" class="form-control"></textarea>
                                        
                                    </div>
                                </div>      
                                    
                                <div class="form-group">        
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <?php if($_SESSION['admin_userid']==""){?>
                                            <font color='red'>*กรุณาล็อคอินก่อน</font>
                                        <?php }else{?>
                                            <button class="btn btn-primary" onclick='save_request_employee_ver1()'>Submit</button>
                                        <?php }?>
                                    </div>
                                </div>
                            </div>
                        
					    </div>
					</div>
				</div>
			</div>


<?php } ?>
			
<?php if($status=="") { ?>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading">ขออัตรากำลังคน</div>
            <div class="panel-body">

                <div class="form-horizontal" >
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="departmentid">ฝ่าย/แผนก/หน่วยงาน :</label>
                        <div class="col-sm-2">
                            <select name="departmentid" id="departmentid" class="form-control">
                                <option value="">เลือกแผนก</option>
                                <?php 
                                $empno_session = $_SESSION['admin_userid'];
                                $sql_emp = "select departmentid from tbemployee where empno='$empno_session'";
                                $res_emp = mssql_query($sql_emp);
                                $row_emp = mssql_fetch_array($res_emp);
                                $departmentid_emp = $row_emp["departmentid"];
                                
                                $sql = "select * from tbdepartment order by department";
                                $res = mssql_query($sql);
                                while($row = mssql_fetch_array($res)){
                                    $departmentid = $row["departmentid"];
                                    $department = $row["department"];
                                    if($departmentid_emp==$departmentid){
                                        $selected = "selected";
                                    }else{
                                        $selected = "";
                                    }
                                    ?><option value="<?=$departmentid?>" <?=$selected?>><?=$department?></option><?

                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-2" for="positionid_one">1.ตำแหน่งงาน :</label>
                        <div class="col-sm-3">
                            <select name="positionid_one" id="positionid_one" class="form-control">
                                <option value="">เลือกตำแหน่ง</option>
                                <?php 
                                $sql = "select * from tbposition order by positionname";
                                $res = mssql_query($sql);
                                while($row = mssql_fetch_array($res)){
                                    $positionid = $row["positionid"];
                                    $positionname = $row["positionname"];
                                    ?><option value="<?=$positionid?>"><?=$positionname?></option><?

                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-2" for="positionid_two">2.ตำแหน่งงาน :</label>
                        <div class="col-sm-3">
                            <select name="positionid_two" id="positionid_two" class="form-control">
                                <option value="">เลือกตำแหน่ง</option>
                                <?php 
                                $sql = "select * from tbposition order by positionname";
                                $res = mssql_query($sql);
                                while($row = mssql_fetch_array($res)){
                                    $positionid = $row["positionid"];
                                    $positionname = $row["positionname"];
                                    ?><option value="<?=$positionid?>"><?=$positionname?></option><?

                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <table align='center'width="80%">
                        <tr>
                            <td >ขอทดแทนพนักงานเดิม <br> (ที่ลาออกไป)</td>
                            <td >ชาย <input type="number" id="male_one" name="male_one" style="width: 80px;">  อัตรา <br>หญิง <input type="number" id="female_one" name="female_one" style="width: 75px;">   อัตรา </td>
                            <td>วันที่ต้องการ : <input type="text" name="target_date_one" id="target_date_one" class="form-control"> </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td  colspan="4">สาเหตุ : <textarea name="cause_one" id="cause_one" cols="30" rows="10" class="form-control"></textarea></td>
                        </tr>
                        
                        <tr>
                            <td >ขอเพิ่มอัตราพนักงาน <br> (รองรับงานที่เพิ่มขึ้น)</td>
                            <td >ชาย <input type="number" id="male_two" name="male_two" style="width: 80px;">  อัตรา <br>หญิง <input type="number" id="female_two" name="female_two" style="width: 75px;">   อัตรา </td>
                            <td>วันที่ต้องการ : <input type="text" name="target_date_two" id="target_date_two" class="form-control"> </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td  colspan="4">สาเหตุ : <textarea name="cause_two" id="cause_two" cols="30" rows="10" class="form-control"></textarea></td>
                        </tr>
                        
                        <tr>
                            <td >ขอทดแทนพนักงาน <br> (ที่โอนย้ายไปหน่วยอื่น)</td>
                            <td >ชาย <input type="number" id="male_three" name="male_three" style="width: 80px;">  อัตรา <br>หญิง <input type="number" id="female_three" name="female_three" style="width: 75px;">   อัตรา </td>
                            <td>วันที่ต้องการ : <input type="text" name="target_date_three" id="target_date_three" class="form-control"> </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td  colspan="4">สาเหตุ : <textarea name="cause_three" id="cause_three" cols="30" rows="10" class="form-control"></textarea></td>
                        </tr>
                    </table>              
                    <!--
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="reason">ขอเพิ่มพนักงาน :</label>
                        <div class="col-sm-3">
                            <select name="reason" id="reason" class="form-control">
                                <option value="">เลือกเหตุผล</option>
                                <option value="แทนคนที่ลาออกไป">แทนคนที่ลาออกไป</option>
                                <option value="รองรับงานที่เพิ่มขึ้น">รองรับงานที่เพิ่มขึ้น</option>
                                <option value="โดนโอนย้ายไปหน่วยงานอื่น">โดนโอนย้ายไปหน่วยงานอื่น</option>
                                
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-2" for="male">ชาย </label>
                        <div class="col-sm-1">
                            <input type="number" name="male" id="male"  class="form-control">
                        </div>
                        <label class=" col-sm-2">
                            อัตรา
                        </label>

                    </div>    

                    <div class="form-group">
                        <label class="control-label col-sm-2" for="female">หญิง </label>
                        <div class="col-sm-1">
                            <input type="number" name="female" id="female"  class="form-control">
                        </div>
                        <label class=" col-sm-2">
                            อัตรา
                        </label>

                    </div>   

                    <div class="form-group">
                        <label class="control-label col-sm-2" for="target_date">วันที่ต้องการ </label>
                        <div class="col-sm-3">
                            <input type="text" name="target_date" id="target_date"  class="form-control">
                        </div>
                    </div>                     
                        
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="cause">สาเหตุ </label>
                        <div class="col-sm-6">
                            <textarea name="cause" id="cause" cols="30" rows="10" class="form-control"></textarea>
                            
                        </div>
                    </div>      
                    -->
                    <div class="form-group">        
                        <div class="col-sm-offset-2 col-sm-10">
                            <?php if($_SESSION['admin_userid']==""){?>
                                <font color='red'>*กรุณาล็อคอินก่อน</font>
                            <?php }else{?>
                                <button class="btn btn-primary" onclick='save_request_employee()'>Submit</button>
                            <?php }?>
                        </div>
                    </div>
                </div>
            
            </div>
        </div>
    </div>
</div>


<?php } ?>



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

<script type='text/javascript' src='assets/js/jquery.dataTables.min.js'></script> 
<script type='text/javascript' src='assets/js/dataTables.bootstrap.min.js'></script> 


</body>
</html>