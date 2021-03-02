<? 
ob_start();
?> 
 <ul class="acc-menu" id="sidebar">
  <?php if($_SESSION['emp_level']>=3 || $_SESSION['admin_userid']=='56038' || $_SESSION['admin_userid']=='56002'){?>
  <li><a href="#"><i class="fa fa-cubes"></i> <span>Employee</span> </a> 
              	 <ul class="acc-menu">
						<?php if($_SESSION['admin_userid']=='56038' || $_SESSION['admin_userid']=='56002' || $_SESSION['admin_userid']=='59011'){?>
                 		 <li><a href="view_employee.php">Employee List</a></li>
						<?php }else{
							?> <li><a href="view_employee.php?status=viewdetail&empno=<?=$_SESSION['admin_userid']?>">Employee Info</a></li><?
							}
						
						 if($_SESSION['emp_level']>=3){?>
                 		 <li><a href="view_probation.php">Probation</a></li>
						<?php }?>
                   </ul>
                 </li>
    <? } ?>
	 <?php if($_SESSION['emp_level']>=3 || $_SESSION['admin_userid']=='56038'){?>
  <li><a href="#"><i class="fa fa-cubes"></i> <span>Training</span> </a> 
              	 <ul class="acc-menu">
                 		 <li><a href="job_train.php">Job training</a></li>
                 		 <li><a href="job_mng.php">Training List</a></li>
                         <li><a href="#">Training Course</a></li>
                 		 <li><a href="job_rec.php">Training record</a></li>
                   </ul>
                 </li>
    <? } ?>
  <?php if($_SESSION['emp_level']>=3 || $_SESSION['admin_userid']=='56038'){?>
    <li><a href="#"><i class="fa fa-cubes"></i> <span>Payroll</span> </a> 
              	 <ul class="acc-menu">
							<?
                         if($_SESSION['admin_userid']=='59011' || $_SESSION['admin_userid']=='56002'){
						 ?>
                 		 <li><a href="import_text.php">Upload ATT Text file</a></li>
						  <? } ?>
                         <li><a href="view_employee_att.php">View employee list</a></li>
						 <?
                         if($_SESSION['admin_userid']=='59011' || $_SESSION['admin_userid']=='56002'){
						 ?>
                          <li><a href="import_ot.php">Upload Shift & OT file</a></li>
                          <li><a href="time_att_list.php">Calculate</a></li>
                           <li><a href="report.php">Report</a></li>
						 <? } ?>
                   </ul>
                 </li>
	 <?php }?>
     <li><a href="#"><i class="fa fa-cubes"></i> <span>Leave Online</span> </a> 
     	<ul class="acc-menu">
             <li><a href="leave_form.php">Leave form</a></li>
             <li><a href="list_leave.php">Leave List</a></li>
			 <?php if($_SESSION['emp_level']>=3){?>
             <li><a href="mng_leave.php">Approve List</a></li>
			 <?php }?>
             <li><a href="report_leave.php">Report</a></li>
       	</ul>
     </li>
     
     
  <li><a href="#"><i class="fa fa-cubes"></i> <span>Setting</span> </a> 
  <ul class="acc-menu">
  <li><a href="changepassword.php">Change Password</a></li>
  </ul>
   </li>       
                        
 <li><a href="logout.php"><i class="fa  fa-sign-out"></i> <span>Logout</span> </a>       </li>    
                
               
               
            </ul>