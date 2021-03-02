<?
ob_start();
?>
<ul class="acc-menu" id="sidebar">

<li><a href="#"><i class="fa fa-cubes"></i> <span>Dashboard</span> </a>
    <ul class="acc-menu">
      <?php if ($_SESSION['emp_level'] >= 4) { 
        ?>
         <li><a href="dashboard_sale.php" target="_blank">Dashboard Sale </a></li>
          <li><a href="dashboard_purchase.php" target="_blank">Dashboard Purchase</a></li>
         
      <?php }
      ?>  
    </ul>
  </li>



  <?php if ($_SESSION['emp_level'] >= 3 || $_SESSION['admin_userid'] == '56038' || $_SESSION['admin_userid'] == '56002' || $_SESSION['admin_userid'] == '63008') { ?>
    <li><a href="#"><i class="fa fa-cubes"></i> <span>Employee</span> </a>
      <ul class="acc-menu">
        <?php if ($_SESSION['emp_level'] >= 3 || $_SESSION['admin_userid'] == '56038' || $_SESSION['admin_userid'] == '56002'  || $_SESSION['admin_userid'] == '63008') { ?>
          <li><a href="view_employee.php">Employee List</a></li>
          <li><a href="request_employee_list.php">Request Employee List</a>

          <?php }
            if ($_SESSION['emp_level'] >= 3) { ?>

          <li><a href="view_probation.php">Probation</a></li>
          <li><a href="list_evaluate.php">Evaluate</a></li>
          <li><a href="edit_manage_position.php">Manage Position</a></li>
          <li><a href="edit_manage_site.php">Manage Site</a></li>
          <li><a href="manage_in_out.php">Manage In and Out</a></li>
        <?php } ?>
        <?php if ($_SESSION['emp_level'] >= 3 || $_SESSION['admin_userid'] == '56038' || $_SESSION['admin_userid'] == '56002'  || $_SESSION['admin_userid'] == '63008') { ?>


        <?php } ?>
      </ul>
    </li>
  <? } ?>
  <?php if ($_SESSION['emp_level'] >= 3 || $_SESSION['admin_userid'] == '56038') { ?>
    <li><a href="#"><i class="fa fa-cubes"></i> <span>Training</span> </a>
      <ul class="acc-menu">
        <li><a href="job_train.php">OJT Training</a></li>
        <li><a href="job_mng.php">OJT List</a></li>
        <li><a href="job_rec.php">OJT Record</a></li>
        <li><a href="skill_metric.php">Skill Metric</a></li>
        <li><a href="training_course.php">Training Course</a></li>
        <li><a href="training_list.php">Training List</a></li>
        <li><a href="training_record.php">Training Record</a></li>
      </ul>
    </li>
  <? } ?>
  <?php if ($_SESSION['emp_level'] >= 2 || $_SESSION['admin_userid'] == '56038' || $_SESSION['admin_userid'] == '59017' || $_SESSION['admin_userid'] == '59030') { ?>
    <li><a href="#"><i class="fa fa-cubes"></i> <span>Payroll</span> </a>
      <ul class="acc-menu">
        <?
          if ($_SESSION['admin_userid'] == '59011' || $_SESSION['admin_userid'] == '56002' || $_SESSION['admin_userid'] == '59017' || $_SESSION['admin_userid'] == '59030') {
            ?>
          <!--<li><a href="import_text.php">Upload ATT Text file</a></li>-->
        <? } ?>
        <li><a href="view_employee_att.php">View employee list</a></li>
        <?
          if ($_SESSION['admin_userid'] == '59011' || $_SESSION['admin_userid'] == '56002' || $_SESSION['admin_userid'] == '63007'  || $_SESSION['admin_userid'] == '63008') {
            ?>
          <!-- <li><a href="import_ot.php">Upload Shift & OT file</a></li>-->
          <li><a href="time_att_list.php">Calculate</a></li>
          <li><a href="report.php">Report</a></li>
        <? } ?>
      </ul>
    </li>
  <?php } ?>
  <li><a href="#"><i class="fa fa-cubes"></i> <span>Leave & Attendance</span> </a>
    <ul class="acc-menu">
      <li><a href="leave_form.php">Leave form</a></li>
      <li><a href="list_leave.php">Leave List</a></li>
      <?php if ($_SESSION['emp_level'] >= 3 || $_SESSION['admin_userid'] == '56038'  || $_SESSION['admin_userid'] == '63007') { ?>
        <li><a href="mng_leave.php">Approve List</a></li>
        <li><a href="report_leave.php">Leave Report</a></li>

        <li><a target="_blank" href="http://ipack-iwis.com/att/view_report.php?site=<?= $_SESSION['site'] ?>">Daily Attendance</a></li>
        <li><a href="report_att.php">Attendance Report</a></li>
      <?php } ?>
      <?php if ($_SESSION['emp_level'] >= 2 || $_SESSION['admin_userid'] == '59030' || $_SESSION['admin_userid'] == '59017') { ?>
        <li><a href="create_ot.php">Confirm OT </a></li>
      <? } ?>
    </ul>
  </li>

  <?php

  if ($_SESSION['admin_userid'] == '59011' || $_SESSION['admin_userid'] == '56038') {
    ?>
    <li><a href="#"><i class="fa fa-cubes"></i> <span>IT SERVICE & DEVOLOP</span> </a>
      <ul class="acc-menu">
      <li><a href="view_asset.php">ASSET LIST IT</a></li>
        <li><a href="view_asset_wh.php">ASSET LIST Warehouse</a></li>
        <li><a href="asset_hddbackup.php">Backup Data</a></li>
        <li><a href="it_service_list.php">IT SERVICE LIST</a></li>
        <li><a href="it_service_new.php">ADD IT SERVICE </a></li>
        <!--<li><a href="it_program_list.php">Software Development List</a></li>
	  <li><a href="it_program_new.php">ADD Software Development  </a></li>-->
        <li><a href="add_manual_iwis.php">Upload Manual I-Wis </a></li>
        <li><a href="sso.php">I-Wis Single Sign-on</a></li>
      </ul>

    </li>
  <?php } else if ($_SESSION['emp_level'] >= 2) {
    ?>
    <li><a href="#"><i class="fa fa-cubes"></i> <span>IT SERVICE REQUEST</span> </a>
      <ul class="acc-menu">
        <li><a href="view_asset.php">ASSET LIST</a></li>
         <li><a href="view_asset_wh.php">ASSET LIST Warehouse</a></li>
        <li><a href="asset_hddbackup.php">Backup Data</a></li>
        <li><a href="it_service_list.php">IT SERVICE LIST</a></li>
        <li><a href="it_service_new.php">ADD IT SERVICE </a></li>
        <li><a href="add_manual_iwis.php">Upload Manual I-Wis </a></li>
        <li><a href="sso.php">I-Wis Single Sign-on</a></li>
      </ul>
    </li>
  <?
  }
  ?>
  <li><a href="#"><i class="fa fa-cubes"></i> <span>E-Document</span> </a>
    <ul class="acc-menu">
      <?php if ($_SESSION['emp_level'] >= 2) { ?>
        <li><a href="create_dar.php">Create DAR</a></li>
        <li><a href="create_dar.php?status=reviewer">DAR log sheet</a></li>
        <li><a href="document_control.php">Document Control</a></li>
      <?php }
      if ($_SESSION["admin_userid"] == "56002" || $_SESSION["admin_userid"] == "56038" || $_SESSION["admin_userid"] == "63007"  || $_SESSION['admin_userid'] == '63008' ) { ?>

          <li><a href="document_control.php?status=obsolete">Document Obsolete</a></li>

      <?}
      ?>
      <li><a href="#">-----------------------------</a></li>
      <li><a href="create_dar_admin.php">Create DAR ADMIN</a></li>
        
    </ul>
  </li>
  <li><a href="#"><i class="fa fa-cubes"></i> <span>Daily Report</span> </a>
    <ul class="acc-menu">
      <li><a href="daily_report_view.php">View Daily Report </a></li>
      <?php if ($_SESSION['departmentid'] == 'D005' || $_SESSION['admin_userid']=='59011') { 
        ?>
      
        <li><a href="picture5s.php?shift=Day&site=HQ">HQ Take photo </a></li>
        <li><a href="picture5s_approve.php?shift=Day&site=HQ">HQ Check photo</a></li>
        <li><a href="daily_report_input_hq.php">HQ Input data report</a></li>
      <?php }
      ?>  
      <?php if ($_SESSION['departmentid'] == 'D003' || $_SESSION['admin_userid']=='59011') { 
        ?>
      
        <li><a href="picture5s.php?shift=Day&site=TSC">TSC Take photo </a></li>
        <li><a href="picture5s_approve.php?shift=Day&site=TSC">TSC Check photo</a></li>
        <li><a href="daily_report_input_tsc.php">TSC Input data report</a></li>
      <?php }
      ?>
       <?php if ($_SESSION['departmentid'] == 'D008' || $_SESSION['admin_userid']=='59011') { 
        ?>
      
        <li><a href="picture5s.php?shift=Day&site=OSW">OSW Take photo </a></li>
        <li><a href="picture5s_approve.php?shift=Day&site=OSW">OSW Check photo</a></li>
        <li><a href="daily_report_input_osw.php">OSW Input data report</a></li>
      <?php }
      ?>  
        
    </ul>
  </li>
  
  
  <li><a href="#"><i class="fa fa-cubes"></i> <span>Setting</span> </a>
    <ul class="acc-menu">
      <li><a href="changepassword.php">Change Password</a></li>
    </ul>
  </li>

  <li><a href="logout.php"><i class="fa  fa-sign-out"></i> <span>Logout</span> </a> </li>



</ul>