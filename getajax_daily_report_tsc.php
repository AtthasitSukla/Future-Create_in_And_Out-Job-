<?php
session_start();
//echo $_SESSION['production_line'];
include("connect.php");
include("library.php");

$status = $_POST['status'];
$date_time = date("m/d/Y H:i:s");
$time = time();
$admin_userid = $_SESSION["admin_userid"];

if ($status == "select_date_report_tsc") {
    $report_date_dmy = ($_POST["report_date"]);
    $shift = ($_POST["shift"]);
    $report_date = date_format_uk_into_database($_POST["report_date"]);
    $report_date_yesterday = date("m/d/Y", strtotime($report_date." -1 days"));

    if($shift=="Day"){
        $panel_text = "orange";
        $report_start_date = $report_date." 08:00:00";
        $report_end_date = $report_date." 20:20:00";
        $report_start_date_dmy = $report_date_dmy." 08:00:00";
        $report_end_date_dmy = $report_date_dmy." 20:20:00";
        
        
        $report_start_input = $report_date." 16:00:00";
    }else if($shift=="Night"){
        $panel_text = "inverse";
        $report_start_date = $report_date." 20:20:00";
        $report_end_date = date("m/d/Y", strtotime($report_date." +1 days"))." 07:59:59";
        
        $report_start_date_dmy = $report_date_dmy." 20:20:00";
        $report_end_date_dmy = date("d/m/Y", strtotime($report_date." +1 days"))." 07:59:59";

        
        $report_start_input = date("m/d/Y", strtotime($report_date." +1 days"))." 04:00:00";
    }
    echo "<h4> $shift <br> เริ่ม $report_start_date_dmy - $report_end_date_dmy </h4>";
    $sql = "SELECT *  FROM tbdaily_report_tsc WHERE workdate='$report_date' AND shift='$shift'";
    $res = mssql_query($sql);
    $num = mssql_num_rows($res);
    //echo $sql;
    if ($num > 0) {
        $row = mssql_fetch_array($res);
        //var_dump($row);
        $safety_human = $row["safety_human"];//..
        $safety_part = $row["safety_part"];//..
        $safety_nearmiss = $row["safety_nearmiss"];//..
        $safety_target = $row["safety_target"];//.

        $att_plan = $row["att_plan"];
        
        $ot_target = $row["ot_target"];//..
        $ot_achieve = $row["ot_achieve"];
        $ot_remark = $row["ot_remark"];

        
        $issue_remark = lang_thai_from_database($row["issue_remark"]);//..

        $qa_partinbox_ipack = $row["qa_partinbox_ipack"];//..
        $qa_westbox_ipack = $row["qa_westbox_ipack"];//..
        $qa_result = $row["qa_result"];

        
        $issue_remark_vmi = lang_thai_from_database($row["issue_remark_vmi"]);//..
        
        if($_SESSION["emp_level"]>3){
            $sql_app = "SELECT *  FROM tbdaily_report_tsc WHERE workdate='$report_date' AND approve_by IS NULL";
            $res_app = mssql_query($sql_app);
            $num_app = mssql_num_rows($res_app);
            if($num_app>0){
                $btn_txt = "<button class='btn btn-success' onclick='approve_daily_report_tsc()'>Approve</button>";
            }else{
                $btn_txt = "Approve เรียบร้อยแล้ว";
            }
        }else{
            
            $btn_txt = "<button class='btn btn-warning' onclick='save_daily_report_tsc()'>Update</button>";
        }
    } else {
        $safety_human = 0;
        $safety_part = 0;
        $safety_nearmiss = 0;
        $safety_target = 100;
        $att_plan = "";
        $ot_target = "";
        
        $ot_achieve = "";
        $ot_remark = "";
        
        /* 5.2 Issue performance (Box Management) */
        $issue_remark = "";
        /* 5.2 Issue performance (Box Management) */

        /* 5.3 Quality */
        $qa_partinbox_ipack = 0;
        $qa_westbox_ipack = 0;

        $qa_result = "";
        /* 5.3 Quality */

        
        /* 5.5 Issue performance (VMI : Project) */
        $issue_remark_vmi = "";
        /* 5.5 Issue performance (VMI : Project) */

        if(TimeDiff($date_time,$report_start_input)>0){
            $btn_txt = "<font color='red'>ยังไม่ถึงเวลา Save กรุณาเลือกวันที่ใหม่</font>";
        }else if($_SESSION["emp_level"]>3){
            
            $btn_txt = "<font color='red'>กรุณา Save ข้อมูลก่อน Approve</font>";
        }else{
            
            $btn_txt = "<button class='btn btn-success' onclick='save_daily_report_tsc()'>Save</button>";
        }
    }
    include("connect.php");
    $sql_emp  = "SELECT * FROM tbemployee WHERE empno='".$_SESSION['admin_userid']."'";
    // echo $sql_emp;
    $res_emp = mssql_query($sql_emp);
    $num_emp = mssql_num_rows($res_emp);
    if($num_emp==0){
        $btn_txt = "<font color='red'>กรุณา Login รหัส Hrs ก่อน</font>";
    }

    //ช่องที่ถึงข้อมูล Auto ควรมาจากที่เดิม 

    include("connect.php");
    /* 2. 5S Daily */
    $total_picture = 0;
    $total_picture_ok = 0;
    $total_picture_ng = 0;

    $ss_daily = "picture5s_approve.php?shift=$shift&select_date=$report_date_dmy&site=TSC";
    $ss_daily_status = "";
    $ss_daily_night = "";


    $sql_ss = "SELECT  COUNT(jobstatus_approve) AS count_job, jobstatus_approve FROM tb5s_picture
                    WHERE createdate='$report_date' AND site='TSC' AND shift='$shift'
                    group by jobstatus_approve
                    order by jobstatus_approve desc";
    $res_ss = mssql_query($sql_ss);
    $num_ss = mssql_num_rows($res_ss);
    // $ss_daily_status = $sql_ss;
    while($row_ss = mssql_fetch_array($res_ss)){
        $count_job = $row_ss["count_job"];
        $jobstatus_approve = $row_ss["jobstatus_approve"];

        $total_picture = $total_picture+$count_job;

        if($jobstatus_approve=="OK"){
            $total_picture_ok = $total_picture_ok+$count_job;
        }else{
            $total_picture_ng = $total_picture_ng+$count_job;

        }

        $ss_daily_status.="$count_job $jobstatus_approve, ";

    }

    // $sql_ss_night = "SELECT  COUNT(jobstatus_approve) AS count_job, jobstatus_approve FROM tb5s_picture
    //                 WHERE createdate='$report_date_yesterday' AND site='TSC' AND shift='Night'
    //                 group by jobstatus_approve
    //                 order by jobstatus_approve desc";
    // $res_ss_night = mssql_query($sql_ss_night);
    // $num_ss_night = mssql_num_rows($res_ss_night);
    // // echo $sql_ss_night;
    // // $ss_daily_night = $sql_ss_night;
    // while($row_ss_night = mssql_fetch_array($res_ss_night)){
    //     $count_job = $row_ss_night["count_job"];
    //     $jobstatus_approve = $row_ss_night["jobstatus_approve"];

    //     $total_picture = $total_picture+$count_job;

    //     if($jobstatus_approve=="OK"){
    //         $total_picture_ok = $total_picture_ok+$count_job;
    //     }else{
    //         $total_picture_ng = $total_picture_ng+$count_job;

    //     }

    //     $ss_daily_night.="$count_job $jobstatus_approve, ";

    // }
    

    
    
    $ss_daily_percent = "";
    $sql_sum = "SELECT count(id) as all_pic FROM tb5s_picture WHERE createdate='$report_date' AND site='TSC' AND shift='$shift'";
    $res_sum = mssql_query($sql_sum);
    $row_sum = mssql_fetch_array($res_sum);
    $all_pic = $row_sum["all_pic"];

    $sql_check = "SELECT count(id) as pic_check FROM tb5s_picture WHERE createdate='$report_date' AND site='TSC' AND jobstatus_approve IN ('OK','NG')  AND shift='$shift'";
    $res_check = mssql_query($sql_check);
    $row_check = mssql_fetch_array($res_check);
    $pic_check = $row_check["pic_check"];

    if($all_pic!=""){

        $ss_daily_percent = ($pic_check*100)/$all_pic;
    }
    /* 2. 5S Daily */

    /* 3. TIME ATTENDANCE. AND 4. OVERTIME Work. */
    $sql_ot_start = "SELECT * FROM tbsite WHERE site='TSC' ";
    $res_ot_start = mssql_query($sql_ot_start);
    $row_ot_start = mssql_fetch_array($res_ot_start);
    $startotday = $row_ot_start["startotday"];
    $startotnight = $row_ot_start["startotnight"];
    
    // $att_plan = 0;


    $att_asst_mgr =0;
    $ot_asst_mgr_prs = 0;
    $ot_asst_mgr_hrs = 0;
    $sql = "SELECT    empno
        FROM            tbemployee
        WHERE        (positionid = 'P025') AND (display_att='1' )";// Asst,wh MGR 
    $res = mssql_query($sql);
    while($row=mssql_fetch_array($res)){
        $empno = $row["empno"];
        $sql_att = "SELECT count(id) as count_id FROM tbatt WHERE empno='$empno' AND att_status='in' and att_real_date='$report_date' AND shift='$shift'";
        $res_att = mssql_query($sql_att);
        $row_att = mssql_fetch_array($res_att);
        $count_id = (int)$row_att["count_id"];
        if($count_id>0){
            $att_asst_mgr = $att_asst_mgr+1;

        }else{
            $sql_leave = "SELECT count(id) as count_id FROM tbleave_transaction WHERE empno='$empno' AND ('$report_date' between leavestartdate AND  leaveenddate) AND statusapprove in ('New','Approve') AND leavetypeid='L0009'";
            $res_leave = mssql_query($sql_leave);
            $num_leave = mssql_num_rows($res_leave);
            $row_leave = mssql_fetch_array($res_leave);
            $count_id = (int)$row_leave["count_id"];
            //echo $sql_leave.$num_leave;
            if($count_id > 0 ){ //ถ้าเกิดมีการทำงานนอกสถานที่
                $att_asst_mgr = $att_asst_mgr+1;
            }
        }
        if($shift=="Day"){
            $start_ot_asst = "18:20:00";
        }else if($shift=="Night"){
            $start_ot_asst = "06:40:00";
        }
        /*ot_asst_mgr_prs */
        // $select0 = "SELECT *,
		// 	convert(varchar, workdate, 101)as  workdate2,
		// 	convert(varchar, workdate, 103)as  workdate3
			
	    // FROM    tbot_parameter where workdate = '$report_date' AND site='TSC'  order by workdate asc ";
        // $re0 = mssql_query($select0);
        // $num0 = mssql_num_rows($re0);
        // if ($num0 > 0) {
        //     while ($row0 = mssql_fetch_array($re0)) {

        //         if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') { // OT Holiday

        //             $sql_att_ot_prs_in = "SELECT CONVERT(varchar, attDateTime, 108) as attDateTime_time FROM tbatt 
        //                 WHERE empno='$empno' 
        //                 AND att_status='in' 
        //                 AND shift='$shift' 
        //                 and att_real_date='$report_date' 
        //                 ";
        //             $res_att_ot_prs_in = mssql_query($sql_att_ot_prs_in);
        //             $num_att_ot_prs_in = mssql_num_rows($res_att_ot_prs_in);

        //             $sql_att_ot_prs = "SELECT CONVERT(varchar, attDateTime, 108) as attDateTime_time FROM tbatt 
        //                 WHERE empno='$empno' 
        //                 AND att_status='out' 
        //                 AND shift='$shift' 
        //                 and att_real_date='$report_date' 
        //                 ";
        //             $res_att_ot_prs = mssql_query($sql_att_ot_prs);
        //             $num_att_ot_prs = mssql_num_rows($res_att_ot_prs);
        //             if($num_att_ot_prs_in>0 && $num_att_ot_prs>0){
        //                 $row_att_ot_prs_in = mssql_fetch_array($res_att_ot_prs_in);
        //                 $attDateTime_time_in = $row_att_ot_prs_in["attDateTime_time"];
        //                 $row_att_ot_prs = mssql_fetch_array($res_att_ot_prs);
        //                 $attDateTime_time_out = $row_att_ot_prs["attDateTime_time"];
        //                 if (TimeDiff($attDateTime_time_in, "08:00:00") < 0 ) {
        //                     // echo "1";
        //                     $hrs_prs = floor(TimeDiff($attDateTime_time_in,$attDateTime_time_out) * 2) / 2; // ปัดเศษนับเฉพาะจำนวนเต็มและ 0.5 เท่านั้น
                            
        //                 }else{
        //                     // echo "2";
                            
        //                     $hrs_prs = floor(TimeDiff("08:00:00",$attDateTime_time_out) * 2) / 2; // ปัดเศษนับเฉพาะจำนวนเต็มและ 0.5 เท่านั้น
                            
        //                 }
        //                 $ot_asst_mgr_hrs = $ot_asst_mgr_hrs+($hrs_prs-1); //-1 คือเวลาพัก
        //                 $ot_asst_mgr_prs = $ot_asst_mgr_prs+1;
                    
        //             }
        //         } else {
        //             $sql_att_ot_prs = "SELECT CONVERT(varchar, attDateTime, 108) as attDateTime_time FROM tbatt 
        //                 WHERE empno='$empno' 
        //                 AND att_status='out' 
        //                 AND shift='$shift' 
        //                 and att_real_date='$report_date' 
        //                 AND (CONVERT(varchar, attDateTime, 108) >= '$start_ot_asst')";
        //             $res_att_ot_prs = mssql_query($sql_att_ot_prs);
        //             $num_att_ot_prs = mssql_num_rows($res_att_ot_prs);
        //             if($num_att_ot_prs>0){
        //                 $row_att_ot_prs = mssql_fetch_array($res_att_ot_prs);
        //                 $attDateTime_time = $row_att_ot_prs["attDateTime_time"];
        //                 $hrs_prs = floor(TimeDiff($startotday,$attDateTime_time) * 2) / 2; // ปัดเศษนับเฉพาะจำนวนเต็มและ 0.5 เท่านั้น
        //                 $ot_asst_mgr_hrs = $ot_asst_mgr_hrs+$hrs_prs;
        //                 $ot_asst_mgr_prs = $ot_asst_mgr_prs+1;
                    
        //             }
        //         }
        //     }
        // }
        /*ot_asst_mgr_prs */

        // /*ATT PLAN*/
        // $sql_plan = "SELECT shift FROM tbot_mng WHERE workdate='$report_date' AND empno='$empno' And shift='$shift'";
        // $res_plan = mssql_query($sql_plan);
        // $num_plan = mssql_num_rows($res_plan);
        // if($num_plan>0){
        //     $att_plan++;
        // }else{
        //     $sql_plan2 = "SELECT shift FROM tbot_mng WHERE workdate='$report_date' AND empno='$empno'";
        //     $res_plan2 = mssql_query($sql_plan2);
        //     $num_plan2 = mssql_num_rows($res_plan2);
        //     if($num_plan2==0 && $shift=="Day"){
        //         $att_plan++;
        //     }
        // }
        // $sql_vacation = "SELECT empno FROM tbleave_transaction WHERE leavetypeid='L0003' AND statusapprove='Approve' AND empno='$empno' AND ('$report_date' BETWEEN leavestartdate AND leaveenddate)";//ถ้าลาพักร้อนให้ลบออกจาก plan
        // $res_vacation = mssql_query($sql_vacation);
        // $num_vacation = mssql_num_rows($res_vacation);
        // if($num_vacation>0){
        //     $att_plan=$att_plan-1;
        // }
        // /*ATT PLAN*/
    }

    

    $att_supervisor = 0;
    $ot_supervisor_prs = 0;
    $ot_supervisor_hrs = 0;
    $sql = "SELECT    empno
        FROM            tbemployee
        WHERE        (positionid = 'P022') AND (display_att='1')";// Suppervisor
    $res = mssql_query($sql);
    while($row=mssql_fetch_array($res)){
        $empno = $row["empno"];
        $sql_att = "SELECT count(id) as count_id FROM tbatt WHERE empno='$empno' AND att_status='in' and att_real_date='$report_date' AND shift='$shift'";
        $res_att = mssql_query($sql_att);
        $row_att = mssql_fetch_array($res_att);
        $count_id = (int)$row_att["count_id"];
        if($count_id>0){
            $att_supervisor = $att_supervisor+1;

        }else{
            $sql_leave = "SELECT count(id) as count_id FROM tbleave_transaction WHERE empno='$empno' AND ('$report_date' between leavestartdate AND  leaveenddate) AND statusapprove in ('New','Approve') AND leavetypeid='L0009'";
            $res_leave = mssql_query($sql_leave);
            $num_leave = mssql_num_rows($res_leave);
            $row_leave = mssql_fetch_array($res_leave);
            $count_id = (int)$row_leave["count_id"];
            //echo $sql_leave.$num_leave;
            if($count_id > 0 ){ //ถ้าเกิดมีการทำงานนอกสถานที่
                $att_supervisor = $att_supervisor+1;
            }
        }
        
        $sql_att_ot_prs = "SELECT start_time_approve,end_time_approve FROM tbot_request 
            WHERE empno='$empno' 
            AND shift='$shift' 
            AND status_ot='O'
            and date_ot='$report_date' ";
        $res_att_ot_prs = mssql_query($sql_att_ot_prs);
        $num_att_ot_prs = mssql_num_rows($res_att_ot_prs);
        if($num_att_ot_prs>0){
            $row_att_ot_prs = mssql_fetch_array($res_att_ot_prs);
        }

        $select0 = "SELECT *,
            convert(varchar, workdate, 101)as  workdate2,
            convert(varchar, workdate, 103)as  workdate3
            
        FROM    tbot_parameter where workdate = '$report_date' AND site='TSC'  order by workdate asc ";
        $re0 = mssql_query($select0);
        $num0 = mssql_num_rows($re0);
        if ($num0 > 0) {
            $row0 = mssql_fetch_array($re0);

            if (($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H')) { // OT Holiday
                /* ot_supervisor_prs and ot_supervisor_hrs version 2  */
                if($num_att_ot_prs>0 && $shift=="Night"){
                    $start_time_approve = $report_date." ".$row_att_ot_prs["start_time_approve"];
                    $end_time_approve = $report_date." ".$row_att_ot_prs["end_time_approve"];
                    $end_time_approve =  date("m/d/Y H:i:s",strtotime("+1 day", strtotime($end_time_approve)));
                    $hrs_prs = floor(TimeDiff($start_time_approve,$end_time_approve) * 2) / 2; // ปัดเศษนับเฉพาะจำนวนเต็มและ 0.5 เท่านั้น
                    $ot_supervisor_hrs = $ot_supervisor_hrs+$hrs_prs;

                    $ot_supervisor_prs = $ot_supervisor_prs+1;
                    
                }else if($num_att_ot_prs>0 && $shift=="Day"){
                    $start_time_approve = $row_att_ot_prs["start_time_approve"];
                    $end_time_approve = $row_att_ot_prs["end_time_approve"];
                    $hrs_prs = floor(TimeDiff($start_time_approve,$end_time_approve) * 2) / 2; // ปัดเศษนับเฉพาะจำนวนเต็มและ 0.5 เท่านั้น
                    $ot_supervisor_hrs = $ot_supervisor_hrs+$hrs_prs;

                    $ot_supervisor_prs = $ot_supervisor_prs+1;
                }
                /* ot_supervisor_prs and ot_supervisor_hrs version 2  */
                if($hrs_prs>6 && $num_att_ot_prs>0){

                    $ot_supervisor_hrs=$ot_supervisor_hrs-1;
                }
            }
            
        }
        
        // /* ot_supervisor_prs and ot_supervisor_hrs version 2  */
        // $sql_att_ot_prs = "SELECT start_time_approve,end_time_approve FROM tbot_request 
        //     WHERE empno='$empno' 
        //     AND shift='$shift' 
        //     AND status_ot='O'
        //     and date_ot='$report_date' ";
        // $res_att_ot_prs = mssql_query($sql_att_ot_prs);
        // $num_att_ot_prs = mssql_num_rows($res_att_ot_prs);
        // if($num_att_ot_prs>0){
        //     $row_att_ot_prs = mssql_fetch_array($res_att_ot_prs);
        //     $start_time_approve = $row_att_ot_prs["start_time_approve"];
        //     $end_time_approve = $row_att_ot_prs["end_time_approve"];
        //     $hrs_prs = floor(TimeDiff($start_time_approve,$end_time_approve) * 2) / 2; // ปัดเศษนับเฉพาะจำนวนเต็มและ 0.5 เท่านั้น
        //     $ot_supervisor_hrs = $ot_supervisor_hrs+$hrs_prs;

        //     $ot_supervisor_prs = $ot_supervisor_prs+1;

        // }
        // /* ot_supervisor_prs and ot_supervisor_hrs version 2  */

        // $select0 = "SELECT *,
		// 	convert(varchar, workdate, 101)as  workdate2,
		// 	convert(varchar, workdate, 103)as  workdate3
			
	    // FROM    tbot_parameter where workdate = '$report_date' AND site='TSC'  order by workdate asc ";
        // $re0 = mssql_query($select0);
        // $num0 = mssql_num_rows($re0);
        // if ($num0 > 0) {
        //     $row0 = mssql_fetch_array($re0);

        //     if (($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') && $hrs_prs>6 && $num_att_ot_prs>0) { // OT Holiday
        //         $ot_supervisor_hrs=$ot_supervisor_hrs-1;
        //     }
            
        // }



        // /*ATT PLAN*/
        // $sql_plan = "SELECT shift FROM tbot_mng WHERE workdate='$report_date' AND empno='$empno' And shift='$shift'";
        // $res_plan = mssql_query($sql_plan);
        // $num_plan = mssql_num_rows($res_plan);
        // if($num_plan>0){
        //     $att_plan++;
        // }else{
        //     $sql_plan2 = "SELECT shift FROM tbot_mng WHERE workdate='$report_date' AND empno='$empno'";
        //     $res_plan2 = mssql_query($sql_plan2);
        //     $num_plan2 = mssql_num_rows($res_plan2);
        //     if($num_plan2==0 && $shift=="Day"){
        //         $att_plan++;
        //     }
        // }
        // $sql_vacation = "SELECT empno FROM tbleave_transaction WHERE leavetypeid='L0003' AND statusapprove='Approve' AND empno='$empno' AND ('$report_date' BETWEEN leavestartdate AND leaveenddate)";//ถ้าลาพักร้อนให้ลบออกจาก plan
        // $res_vacation = mssql_query($sql_vacation);
        // $num_vacation = mssql_num_rows($res_vacation);
        // if($num_vacation>0){
        //     $att_plan=$att_plan-1;
        // }
        // /*ATT PLAN*/
    }


    $att_leader = 0;
    $ot_leader_prs = 0;
    $ot_leader_hrs = 0;
    $sql = "SELECT    empno
        FROM            tbemployee
        WHERE        (positionid = 'P020') AND (display_att='1')";// Leader
    $res = mssql_query($sql);
    while($row=mssql_fetch_array($res)){
        $empno = $row["empno"];
        $sql_att = "SELECT count(id) as count_id FROM tbatt WHERE empno='$empno' AND att_status='in' and att_real_date='$report_date' AND shift='$shift'";
        $res_att = mssql_query($sql_att);
        $row_att = mssql_fetch_array($res_att);
        $count_id = (int)$row_att["count_id"];
        if($count_id>0){
            $att_leader = $att_leader+1;

        }else{
            $sql_leave = "SELECT count(id) as count_id FROM tbleave_transaction WHERE empno='$empno' AND ('$report_date' between leavestartdate AND  leaveenddate) AND statusapprove in ('New','Approve') AND leavetypeid='L0009'";
            $res_leave = mssql_query($sql_leave);
            $num_leave = mssql_num_rows($res_leave);
            $row_leave = mssql_fetch_array($res_leave);
            $count_id = (int)$row_leave["count_id"];
            //echo $sql_leave.$num_leave;
            if($count_id > 0 ){ //ถ้าเกิดมีการทำงานนอกสถานที่
                $att_leader = $att_leader+1;
            }
        }

        $sql_att_ot_prs = "SELECT start_time_approve,end_time_approve FROM tbot_request 
            WHERE empno='$empno' 
            AND shift='$shift' 
            AND status_ot='O'
            and date_ot='$report_date' ";
        $res_att_ot_prs = mssql_query($sql_att_ot_prs);
        $num_att_ot_prs = mssql_num_rows($res_att_ot_prs);
        if($num_att_ot_prs>0){
            $row_att_ot_prs = mssql_fetch_array($res_att_ot_prs);
        }

         

        $select0 = "SELECT *,
			convert(varchar, workdate, 101)as  workdate2,
			convert(varchar, workdate, 103)as  workdate3
			
	    FROM    tbot_parameter where workdate = '$report_date' AND site='TSC'  order by workdate asc ";
        $re0 = mssql_query($select0);
        $num0 = mssql_num_rows($re0);
        if ($num0 > 0) {
            $row0 = mssql_fetch_array($re0);

            if (($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') ) { // OT Holiday
                /* ot_leader_prs and ot_leader_hrs version 2  */
                
                    if($num_att_ot_prs>0 && $shift=="Night"){
                        $start_time_approve = $report_date." ".$row_att_ot_prs["start_time_approve"];
                        $end_time_approve = $report_date." ".$row_att_ot_prs["end_time_approve"];
                        $end_time_approve =  date("m/d/Y H:i:s",strtotime("+1 day", strtotime($end_time_approve)));
                        $hrs_prs = floor(TimeDiff($start_time_approve,$end_time_approve) * 2) / 2; // ปัดเศษนับเฉพาะจำนวนเต็มและ 0.5 เท่านั้น
                        $ot_leader_hrs = $ot_leader_hrs+$hrs_prs;
    
                        $ot_leader_prs = $ot_leader_prs+1;
                        
                    }else if($num_att_ot_prs>0 && $shift=="Day"){
                        $start_time_approve = $row_att_ot_prs["start_time_approve"];
                        $end_time_approve = $row_att_ot_prs["end_time_approve"];
                        $hrs_prs = floor(TimeDiff($start_time_approve,$end_time_approve) * 2) / 2; // ปัดเศษนับเฉพาะจำนวนเต็มและ 0.5 เท่านั้น
                        $ot_leader_hrs = $ot_leader_hrs+$hrs_prs;
    
                        $ot_leader_prs = $ot_leader_prs+1;
                    }
                
                /* ot_leader_prs and ot_leader_hrs version 2  */
                
                
                if($hrs_prs>6 && $num_att_ot_prs>0){
                    $ot_leader_hrs=$ot_leader_hrs-1;
                }
            }else{
                if($num_att_ot_prs>0){
                    $start_time_approve = $row_att_ot_prs["start_time_approve"];
                    $end_time_approve = $row_att_ot_prs["end_time_approve"];
                    $hrs_prs = floor(TimeDiff($start_time_approve,$end_time_approve) * 2) / 2; // ปัดเศษนับเฉพาะจำนวนเต็มและ 0.5 เท่านั้น
                    $ot_leader_hrs = $ot_leader_hrs+$hrs_prs;

                    $ot_leader_prs = $ot_leader_prs+1;
                }
            }
            
        }

        // /*ATT PLAN*/
        // $sql_plan = "SELECT shift FROM tbot_mng WHERE workdate='$report_date' AND empno='$empno' And shift='$shift'";
        // $res_plan = mssql_query($sql_plan);
        // $num_plan = mssql_num_rows($res_plan);
        // if($num_plan>0){
        //     $att_plan++;
        // }else{
        //     $sql_plan2 = "SELECT shift FROM tbot_mng WHERE workdate='$report_date' AND empno='$empno'";
        //     $res_plan2 = mssql_query($sql_plan2);
        //     $num_plan2 = mssql_num_rows($res_plan2);
        //     if($num_plan2==0 && $shift=="Day"){
        //         $att_plan++;
        //     }
        // }
        // $sql_vacation = "SELECT empno FROM tbleave_transaction WHERE leavetypeid='L0003' AND statusapprove='Approve' AND empno='$empno' AND ('$report_date' BETWEEN leavestartdate AND leaveenddate)";//ถ้าลาพักร้อนให้ลบออกจาก plan
        // $res_vacation = mssql_query($sql_vacation);
        // $num_vacation = mssql_num_rows($res_vacation);
        // if($num_vacation>0){
        //     $att_plan=$att_plan-1;
        // }
        // /*ATT PLAN*/
    }

    $att_operator = 0;
    $ot_operator_prs = 0;
    $ot_operator_hrs = 0;
    $sql = "SELECT    empno
        FROM            tbemployee
        WHERE        (positionid = 'P018') AND (display_att='1')"; // Oreration
    $res = mssql_query($sql);
    while($row=mssql_fetch_array($res)){
        $empno = $row["empno"];
        $sql_att = "SELECT count(id) as count_id FROM tbatt WHERE empno='$empno' AND att_status='in' and att_real_date='$report_date' AND shift='$shift'";
        $res_att = mssql_query($sql_att);
        $row_att = mssql_fetch_array($res_att);
        $count_id = (int)$row_att["count_id"];
        if($count_id>0){
            $att_operator = $att_operator+1;

        }else{
            $sql_leave = "SELECT count(id) as count_id FROM tbleave_transaction WHERE empno='$empno' AND ('$report_date' between leavestartdate AND  leaveenddate) AND statusapprove in ('New','Approve') AND leavetypeid='L0009'";
            $res_leave = mssql_query($sql_leave);
            $num_leave = mssql_num_rows($res_leave);
            $row_leave = mssql_fetch_array($res_leave);
            $count_id = (int)$row_leave["count_id"];
            //echo $sql_leave.$num_leave;
            if($count_id > 0 ){ //ถ้าเกิดมีการทำงานนอกสถานที่
                $att_operator = $att_operator+1;
            }
        }

        
        $sql_att_ot_prs = "SELECT start_time_approve,end_time_approve FROM tbot_request 
            WHERE empno='$empno' 
            AND shift='$shift' 
            AND status_ot='O'
            and date_ot='$report_date' ";
        $res_att_ot_prs = mssql_query($sql_att_ot_prs);
        $num_att_ot_prs = mssql_num_rows($res_att_ot_prs);
        if($num_att_ot_prs>0){
            $row_att_ot_prs = mssql_fetch_array($res_att_ot_prs);
        }

        $select0 = "SELECT *,
			convert(varchar, workdate, 101)as  workdate2,
			convert(varchar, workdate, 103)as  workdate3
			
	    FROM    tbot_parameter where workdate = '$report_date' AND site='TSC'  order by workdate asc ";
        $re0 = mssql_query($select0);
        $num0 = mssql_num_rows($re0);
        if ($num0 > 0) {
            $row0 = mssql_fetch_array($re0);

            if (($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') ) { // OT Holiday
                /* ot_operator_prs and ot_operator_hrs version 2  */
                
                    if($num_att_ot_prs>0 && $shift=="Night"){
                        $start_time_approve = $report_date." ".$row_att_ot_prs["start_time_approve"];
                        $end_time_approve = $report_date." ".$row_att_ot_prs["end_time_approve"];
                        $end_time_approve =  date("m/d/Y H:i:s",strtotime("+1 day", strtotime($end_time_approve)));
                        $hrs_prs = floor(TimeDiff($start_time_approve,$end_time_approve) * 2) / 2; // ปัดเศษนับเฉพาะจำนวนเต็มและ 0.5 เท่านั้น
                        $ot_operator_hrs = $ot_operator_hrs+$hrs_prs;
    
                        $ot_operator_prs = $ot_operator_prs+1;
                        
                    }else if($num_att_ot_prs>0 && $shift=="Day"){
                        $start_time_approve = $row_att_ot_prs["start_time_approve"];
                        $end_time_approve = $row_att_ot_prs["end_time_approve"];
                        $hrs_prs = floor(TimeDiff($start_time_approve,$end_time_approve) * 2) / 2; // ปัดเศษนับเฉพาะจำนวนเต็มและ 0.5 เท่านั้น
                        $ot_operator_hrs = $ot_operator_hrs+$hrs_prs;
    
                        $ot_operator_prs = $ot_operator_prs+1;
                    }
                
                /* ot_operator_prs and ot_operator_hrs version 2  */
                
                
                if($hrs_prs>6 && $num_att_ot_prs>0){
                    $ot_operator_hrs=$ot_operator_hrs-1;
                }
            }else{
                if($num_att_ot_prs>0){
                    $start_time_approve = $row_att_ot_prs["start_time_approve"];
                    $end_time_approve = $row_att_ot_prs["end_time_approve"];
                    $hrs_prs = floor(TimeDiff($start_time_approve,$end_time_approve) * 2) / 2; // ปัดเศษนับเฉพาะจำนวนเต็มและ 0.5 เท่านั้น
                    $ot_operator_hrs = $ot_operator_hrs+$hrs_prs;

                    $ot_operator_prs = $ot_operator_prs+1;
                }
            }
            
        }

        // /*ATT PLAN*/
        // $sql_plan = "SELECT shift FROM tbot_mng WHERE workdate='$report_date' AND empno='$empno' And shift='$shift'";
        // $res_plan = mssql_query($sql_plan);
        // $num_plan = mssql_num_rows($res_plan);
        // if($num_plan>0){
        //     $att_plan++;
        // }else{
        //     $sql_plan2 = "SELECT shift FROM tbot_mng WHERE workdate='$report_date' AND empno='$empno'";
        //     $res_plan2 = mssql_query($sql_plan2);
        //     $num_plan2 = mssql_num_rows($res_plan2);
        //     if($num_plan2==0 && $shift=="Day"){
        //         $att_plan++;
        //     }
        // }
        // $sql_vacation = "SELECT empno FROM tbleave_transaction WHERE leavetypeid='L0003' AND statusapprove='Approve' AND empno='$empno' AND ('$report_date' BETWEEN leavestartdate AND leaveenddate)";//ถ้าลาพักร้อนให้ลบออกจาก plan
        // $res_vacation = mssql_query($sql_vacation);
        // $num_vacation = mssql_num_rows($res_vacation);
        // if($num_vacation>0){
        //     $att_plan=$att_plan-1;
        // }
        // /*ATT PLAN*/
    }

    $att_admin = 0;
    $ot_admin_prs = 0;
    $ot_admin_hrs = 0;
    $sql = "SELECT    empno
        FROM            tbemployee
        WHERE        (positionid = 'P029') AND (display_att='1')"; // Admin
    $res = mssql_query($sql);
    while($row=mssql_fetch_array($res)){
        $empno = $row["empno"];
        $sql_att = "SELECT count(id) as count_id FROM tbatt WHERE empno='$empno' AND att_status='in' and att_real_date='$report_date' AND shift='$shift'";
        $res_att = mssql_query($sql_att);
        $row_att = mssql_fetch_array($res_att);
        $count_id = (int)$row_att["count_id"];
        if($count_id>0){
            $att_admin = $att_admin+1;

        }else{
            $sql_leave = "SELECT count(id) as count_id FROM tbleave_transaction WHERE empno='$empno' AND ('$report_date' between leavestartdate AND  leaveenddate) AND statusapprove in ('New','Approve') AND leavetypeid='L0009'";
            $res_leave = mssql_query($sql_leave);
            $num_leave = mssql_num_rows($res_leave);
            $row_leave = mssql_fetch_array($res_leave);
            $count_id = (int)$row_leave["count_id"];
            //echo $sql_leave.$num_leave;
            if($count_id > 0 ){ //ถ้าเกิดมีการทำงานนอกสถานที่
                $att_admin = $att_admin+1;
            }
        }

        
        $sql_att_ot_prs = "SELECT start_time_approve,end_time_approve FROM tbot_request 
            WHERE empno='$empno' 
            AND shift='$shift' 
            AND status_ot='O'
            and date_ot='$report_date' ";
        $res_att_ot_prs = mssql_query($sql_att_ot_prs);
        $num_att_ot_prs = mssql_num_rows($res_att_ot_prs);
        if($num_att_ot_prs>0){
            $row_att_ot_prs = mssql_fetch_array($res_att_ot_prs);
        }

        $select0 = "SELECT *,
			convert(varchar, workdate, 101)as  workdate2,
			convert(varchar, workdate, 103)as  workdate3
			
	    FROM    tbot_parameter where workdate = '$report_date' AND site='TSC'  order by workdate asc ";
        $re0 = mssql_query($select0);
        $num0 = mssql_num_rows($re0);
        if ($num0 > 0) {
            $row0 = mssql_fetch_array($re0);

            if (($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') ) { // OT Holiday
                /* ot_admin_prs and ot_admin_hrs version 2  */
                
                    if($num_att_ot_prs>0 && $shift=="Night"){
                        $start_time_approve = $report_date." ".$row_att_ot_prs["start_time_approve"];
                        $end_time_approve = $report_date." ".$row_att_ot_prs["end_time_approve"];
                        $end_time_approve =  date("m/d/Y H:i:s",strtotime("+1 day", strtotime($end_time_approve)));
                        $hrs_prs = floor(TimeDiff($start_time_approve,$end_time_approve) * 2) / 2; // ปัดเศษนับเฉพาะจำนวนเต็มและ 0.5 เท่านั้น
                        $ot_admin_hrs = $ot_admin_hrs+$hrs_prs;
    
                        $ot_admin_prs = $ot_admin_prs+1;
                        
                    }else if($num_att_ot_prs>0 && $shift=="Day"){
                        $start_time_approve = $row_att_ot_prs["start_time_approve"];
                        $end_time_approve = $row_att_ot_prs["end_time_approve"];
                        $hrs_prs = floor(TimeDiff($start_time_approve,$end_time_approve) * 2) / 2; // ปัดเศษนับเฉพาะจำนวนเต็มและ 0.5 เท่านั้น
                        $ot_admin_hrs = $ot_admin_hrs+$hrs_prs;
    
                        $ot_admin_prs = $ot_admin_prs+1;
                    }
                
                /* ot_admin_prs and ot_admin_hrs version 2  */
                
                
                if($hrs_prs>6 && $num_att_ot_prs>0){
                    $ot_admin_hrs=$ot_admin_hrs-1;
                }
            }else{
                if($num_att_ot_prs>0){
                    $start_time_approve = $row_att_ot_prs["start_time_approve"];
                    $end_time_approve = $row_att_ot_prs["end_time_approve"];
                    $hrs_prs = floor(TimeDiff($start_time_approve,$end_time_approve) * 2) / 2; // ปัดเศษนับเฉพาะจำนวนเต็มและ 0.5 เท่านั้น
                    $ot_admin_hrs = $ot_admin_hrs+$hrs_prs;

                    $ot_admin_prs = $ot_admin_prs+1;
                }
            }
            
        }

        // /*ATT PLAN*/
        // $sql_plan = "SELECT shift FROM tbot_mng WHERE workdate='$report_date' AND empno='$empno' And shift='$shift'";
        // $res_plan = mssql_query($sql_plan);
        // $num_plan = mssql_num_rows($res_plan);
        // if($num_plan>0){
        //     $att_plan++;
        // }else{
        //     $sql_plan2 = "SELECT shift FROM tbot_mng WHERE workdate='$report_date' AND empno='$empno'";
        //     $res_plan2 = mssql_query($sql_plan2);
        //     $num_plan2 = mssql_num_rows($res_plan2);
        //     if($num_plan2==0 && $shift=="Day"){
        //         $att_plan++;
        //     }
        // }
        // $sql_vacation = "SELECT empno FROM tbleave_transaction WHERE leavetypeid='L0003' AND statusapprove='Approve' AND empno='$empno' AND ('$report_date' BETWEEN leavestartdate AND leaveenddate)";//ถ้าลาพักร้อนให้ลบออกจาก plan
        // $res_vacation = mssql_query($sql_vacation);
        // $num_vacation = mssql_num_rows($res_vacation);
        // if($num_vacation>0){
        //     $att_plan=$att_plan-1;
        // }
        // /*ATT PLAN*/
    }
    if($shift=="Day"){
        $late_time = "08:00:00";
    }else if($shift=="Night"){
        $late_time = "20:20:00";
    }
    /* att_late */
    $att_late = 0;
    $sql_late = "SELECT count(id) as att_late 
    FROM tbatt 
    WHERE (att_status = 'in') 
    AND (shift = '$shift' ) 
    AND (CONVERT(varchar, attDateTime, 108) > '$late_time') 
    AND site='TSC' 
    and att_real_date='$report_date'
    AND empno not in (SELECT empno FROM tbleave_transaction WHERE  ('$report_date' between leavestartdate AND  leaveenddate) AND statusapprove in ('New','Approve') AND leavetypeid='L0009' AND shift='Day' )";
    $res_late = mssql_query($sql_late);
    $row_late = mssql_fetch_array($res_late);
    $att_late = $row_late["att_late"];

    // $sql_night = "SELECT count(id) as count_late_night 
    // FROM tbatt WHERE (att_status = 'in') 
    // AND (shift = 'Night' ) 
    // AND (CONVERT(varchar, attDateTime, 108) > '20:20:00') 
    // AND site='TSC' and att_real_date='$report_date'
    // AND empno not in (SELECT empno FROM tbleave_transaction WHERE  ('$report_date' between leavestartdate AND  leaveenddate) AND statusapprove in ('New','Approve') AND leavetypeid='L0009' AND shift='Night' )";
    // $res_night = mssql_query($sql_night);
    // $row_night = mssql_fetch_array($res_night);
    // $count_late_night = $row_night["count_late_night"];

    // $att_late = $count_late_day+$count_late_night;
    /* att_late */

    $att_forklift_name = "";
    $sql_fl_day = "SELECT empno FROM tbot_request 
    WHERE empno in (SELECT empno FROM tbemployee WHERE site='TSC')
    AND fl_status='yes'
    AND shift='$shift' 
    and date_ot='$report_date'
    ";
    $res_fl_day = mssql_query($sql_fl_day);
    $no_day=0;
    while($row_fl_day = mssql_fetch_array($res_fl_day)){
        $empno_name = get_full_name($row_fl_day["empno"]);
        if($no_day==0){
            $att_forklift_name .= $empno_name;
        }else{
            $att_forklift_name .= ",".$empno_name;
        }
        $no_day++;
       
    }
   
    // $att_forklift_night = "";
    // $sql_fl_night = " SELECT empno FROM tbot_request 
    // WHERE empno in (SELECT empno FROM tbemployee WHERE site='TSC')
    // AND fl_status='yes'
    // AND shift='Night' 
    // and date_ot='$report_date'";
    // $res_fl_night = mssql_query($sql_fl_night);
    // $no_night=0;
    // while($row_fl_night = mssql_fetch_array($res_fl_night)){
    //     $empno_name = get_full_name($row_fl_night["empno"]);
    //     if($no_night==0){
    //         $att_forklift_night .= $empno_name;
    //     }else{
    //         $att_forklift_night .= ",".$empno_name;
    //     }
    //     $no_night++;
       
    // }
    
    // echo "($att_asst_mgr+$att_supervisor+$att_leader+$att_operator+$att_admin)-$att_late;";
    $att_total = ($att_asst_mgr+$att_supervisor+$att_leader+$att_operator+$att_admin)-$att_late;
    // $att_total_percent = round(($att_total/$att_plan)*100,2);
    // if($att_total_percent>100){
    //     $att_total_percent=100;
    // }
    // //$att_achieve = "";
    // if($att_total_percent>87){
    //     $att_achieve="On";
    // }else{
    //     $att_achieve="Not";
    // }

    $ot_actual = $ot_asst_mgr_hrs+$ot_supervisor_hrs+$ot_leader_hrs+$ot_operator_hrs;
    /* 3. TIME ATTENDANCE. AND 4. OVERTIME Work. */

    /* 5.1 Receive & Put Away (Box Management) */
    include "connect_tsc.php";
    $sql_receive_plastic = "SELECT count(id) as per_receive_box FROM returnbox WHERE returndate between '$report_start_date' AND '$report_end_date' and ordernumber_sub in (select ordernumber_sub from issuebox)";
    $res_receive_plastic = mssql_query($sql_receive_plastic);
    $row_receive_plastic = mssql_fetch_array($res_receive_plastic);
    $per_receive_box = $row_receive_plastic["per_receive_box"];

    // $per_hold_box = 0;

    $sql_damage_plastic = "SELECT count(id) as per_damage_box FROM returnbox_damage WHERE create_date between '$report_start_date' AND '$report_end_date'";
    $res_damage_plastic = mssql_query($sql_damage_plastic);
    $row_damage_plastic = mssql_fetch_array($res_damage_plastic);
    $per_damage_box = $row_damage_plastic["per_damage_box"];
    /* 5.1 Receive & Put Away (Box Management) */

    /* 5.2 Issue performance (Box Management) */
    include "connect_tsc.php";
    $sql_order_order = "SELECT count(DISTINCT ordernumber_sub) as issue_order_order FROM tbpickupsheet WHERE appointment_time1 between '$report_start_date' AND '$report_end_date' AND cancel is null";
    $res_order_order = mssql_query($sql_order_order);
    $row_order_order = mssql_fetch_array($res_order_order);
    $issue_order_order = $row_order_order["issue_order_order"];

    $sql_order_box = "SELECT sum(qty) as issue_order_box FROM tbpickupsheet WHERE appointment_time1 between '$report_start_date' AND '$report_end_date' AND cancel is null";
    $res_order_box = mssql_query($sql_order_box);
    $row_order_box = mssql_fetch_array($res_order_box);
    $issue_order_box = $row_order_box["issue_order_box"];

    $issue_order_incomplete_order = 0;
    $issue_order_incomplete_box = 0;
    $sql_order_complete_order = "SELECT count(DISTINCT ordernumber_sub) as issue_order_complete_order FROM tbpickupsheet 
    WHERE (appointment_time1 between '$report_start_date' AND '$report_end_date')
    AND (customer_received_date <= '$report_end_date')
    AND cancel is null";
    $res_order_complete_order = mssql_query($sql_order_complete_order);
    $row_order_complete_order = mssql_fetch_array($res_order_complete_order);
    $issue_order_complete_order = $row_order_complete_order["issue_order_complete_order"];
    $sql_order_complete_box = "SELECT count(id) as issue_order_complete_box FROM issuebox WHERE customer_received_date <= '$report_end_date' AND ordernumber_sub in (SELECT ordernumber_sub FROM tbpickupsheet WHERE appointment_time1 between '$report_start_date' AND '$report_end_date' AND cancel is null)";
    $res_order_complete_box = mssql_query($sql_order_complete_box);
    $row_order_complete_box = mssql_fetch_array($res_order_complete_box);
    $issue_order_complete_box = $row_order_complete_box["issue_order_complete_box"];

    $issue_order_incomplete_order = $issue_order_order-$issue_order_complete_order;
    $issue_order_incomplete_box = $issue_order_box-$issue_order_complete_box;

    $issue_performance_order = round(($issue_order_complete_order/$issue_order_order)*100,2);
    $issue_performance_box = round(($issue_order_complete_box/$issue_order_box)*100,2);
    /* 5.2 Issue performance (Box Management) */

    /* 5.3 Quality */
    include "connect_tsc.php";
    $sql_partjam_plastic = "SELECT count(id) as qa_partinbox_cus FROM returnbox_partjam WHERE create_date between '$report_start_date' AND '$report_end_date'";
    $res_partjam_plastic = mssql_query($sql_partjam_plastic);
    $row_partjam_plastic = mssql_fetch_array($res_partjam_plastic);
    $qa_partinbox_cus = $row_partjam_plastic["qa_partinbox_cus"];
    /* 5.3 Quality */

    /* 5.4 Receive & Put Away Performace VMI : Project */
    include "connect_inv.php";
    $per_receive_box_vmi = 0;
    $per_receive_box_vmi_arr = array();
    $sql_receive_box_vmi = "SELECT (select sum(po_receive) from tbpo_receive where mat_code= tbbom_mat_vmi.mat_code AND receive_date between '$report_start_date' AND '$report_end_date') as total_receive,* 
    from tbbom_mat_vmi 
    where mat_code in (select mat_code from tbpo_receive where receive_date between '$report_start_date' AND '$report_end_date')
    
    order by part_no asc";
    //echo $sql_receive_box_vmi;
    $res_receive_box_vmi = mssql_query($sql_receive_box_vmi);
    $check_part=1;
    while($row_receive_box_vmi = mssql_fetch_array($res_receive_box_vmi)){
        $total_receive = $row_receive_box_vmi["total_receive"];
        $part_no = $row_receive_box_vmi["part_no"];
        $mat_code = $row_receive_box_vmi["mat_code"];
        $mat_qty = $row_receive_box_vmi["mat_qty"];

        $total_bom = $total_receive/$mat_qty;
        if($part_no != $part_no_old){
            if($check_part!=1){
                $minimum = min($per_receive_box_vmi_arr);
                if($minimum<0){
                    $minimum=0;
                }else{
                    $minimum=$minimum;
                }
                $per_receive_box_vmi = $per_receive_box_vmi+$minimum;
            }
            $check_part++;
            $per_receive_box_vmi_arr = array();
            array_push($per_receive_box_vmi_arr, $total_bom);
        }else{
            array_push($per_receive_box_vmi_arr, $total_bom);
            
        }
        
        $part_no_old = $part_no;

        
    }
    if(count($per_receive_box_vmi_arr)>0){
        $minimum = min($per_receive_box_vmi_arr);
        if($minimum<0){
            $minimum=0;
        }else{
            $minimum=$minimum;
        }
        $per_receive_box_vmi = $per_receive_box_vmi+$minimum;
    }
    


    // $per_hold_box_vmi = 0;
    $sql_damage_vmi = "SELECT sum(ng_qty) as per_damage_box_vmi FROM tbvmi_ng WHERE create_date between '$report_start_date' AND '$report_end_date'";
    $res_damage_vmi = mssql_query($sql_damage_vmi);
    $row_damage_vmi = mssql_fetch_array($res_damage_vmi);
    $per_damage_box_vmi = $row_damage_vmi["per_damage_box_vmi"]==""?0:$row_damage_vmi["per_damage_box_vmi"];
    /* 5.4 Receive & Put Away Performace VMI : Project */

    /* 5.5 Issue performance (VMI : Project) */
    include "connect_inv.php";
    $sql_order_order_vmi = "SELECT count(DISTINCT order_number) as issue_order_order_vmi FROM  tbvmi_order WHERE appointment_date between '$report_start_date' AND '$report_end_date' AND order_status not in ('Rejected','cancel') ";
    $res_order_order_vmi = mssql_query($sql_order_order_vmi);
    $row_order_order_vmi = mssql_fetch_array($res_order_order_vmi);
    $issue_order_order_vmi = $row_order_order_vmi["issue_order_order_vmi"];
    //echo $sql_order_order_vmi;

    $sql_order_box_vmi = "SELECT sum(qty) as issue_order_box_vmi FROM  tbvmi_order WHERE appointment_date between '$report_start_date' AND '$report_end_date' AND order_status not in ('Rejected','cancel') ";
    $res_order_box_vmi = mssql_query($sql_order_box_vmi);
    $row_order_box_vmi = mssql_fetch_array($res_order_box_vmi);
    $issue_order_box_vmi = $row_order_box_vmi["issue_order_box_vmi"]==""?0:$row_order_box_vmi["issue_order_box_vmi"];

    
    $issue_order_incomplete_order_vmi = 0;
    $issue_order_incomplete_box_vmi = 0;

    $sql_order_complete_order_vmi = "SELECT count(DISTINCT order_number) as issue_order_complete_order_vmi FROM  tbvmi_delivery WHERE close_job_date <= '$report_end_date' AND order_number in (SELECT order_number FROM  tbvmi_order WHERE appointment_date between '$report_start_date' AND '$report_end_date')";
    $res_order_complete_order_vmi = mssql_query($sql_order_complete_order_vmi);
    $row_order_complete_order_vmi = mssql_fetch_array($res_order_complete_order_vmi);
    $issue_order_complete_order_vmi = $row_order_complete_order_vmi["issue_order_complete_order_vmi"];
    $sql_order_complete_box_vmi = "SELECT sum(qty_issue) as issue_order_complete_box_vmi FROM  tbvmi_delivery WHERE close_job_date <= '$report_end_date' AND order_number in (SELECT order_number FROM  tbvmi_order WHERE appointment_date between '$report_start_date' AND '$report_end_date')";
    $res_order_complete_box_vmi = mssql_query($sql_order_complete_box_vmi);
    $row_order_complete_box_vmi = mssql_fetch_array($res_order_complete_box_vmi);
    $issue_order_complete_box_vmi = $row_order_complete_box_vmi["issue_order_complete_box_vmi"]==""?0:$row_order_complete_box_vmi["issue_order_complete_box_vmi"];
    $issue_order_incomplete_order_vmi = $issue_order_order_vmi-$issue_order_complete_order_vmi;
    $issue_order_incomplete_box_vmi = $issue_order_box_vmi-$issue_order_complete_box_vmi;
    if($issue_order_order_vmi==0){
        $issue_performance_order_vmi = 100;
    }else{

        $issue_performance_order_vmi = round(($issue_order_complete_order_vmi/$issue_order_order_vmi)*100,2);
    }

    if($issue_order_box_vmi==0){
        $issue_performance_box_vmi = 100;
    }else{

        $issue_performance_box_vmi = round(($issue_order_complete_box_vmi/$issue_order_box_vmi)*100,2);
    }
	/* 5.5 Issue performance (VMI : Project) */
	/* 5.6 Issue performance (Packing Sparepart & export) */
	include "connect_tsc_packing.php";
	/* Packing Sparepart */
	 		$sql_order_packing = "SELECT sum(cast(Order_quantity as int)) as sum_Order_quantity 
                        FROM tborder_sparepart
                        WHERE  Request_dlv_dt='$report_start_date' 
                        AND status_show='1' ";
   			 $res_order_packing = mssql_query($sql_order_packing);
   			 $row_order_packing = mssql_fetch_array($res_order_packing);
			 $order_packing		= $row_order_packing["sum_Order_quantity"];
			 
			 $sql_order_complete_packing = "SELECT sum(packing_qty) as sum_packing_qty FROM tbpacking_sparepart
                        WHERE jobstatus_packing='Close'
                        AND Issue_No IN (SELECT Issue_No FROM tborder_sparepart
                        WHERE   Request_dlv_dt='$report_start_date') ";
   			 $res_order_complete_packing = mssql_query($sql_order_complete_packing);
   			 $row_order_complete_packing = mssql_fetch_array($res_order_complete_packing);
			 $order_complete_packing = $row_order_complete_packing["sum_packing_qty"]==""? 0 : $row_order_complete_packing["sum_packing_qty"];		
			 
			 
			  $sql_order_delivery_packing = "SELECT sum(packing_qty) as sum_delivery_qty FROM tbpacking_sparepart
                        WHERE jobstatus_packing='Close'
                        AND Issue_No IN (SELECT Issue_No FROM tborder_sparepart
                        WHERE   Request_dlv_dt='$report_start_date' and Sloc='DLS') ";
   			 $res_order_delivery_packing = mssql_query($sql_order_delivery_packing);
			 $row_order_delivery_packing = mssql_fetch_array($res_order_delivery_packing);
			  $order_delivery_packing = $row_order_delivery_packing["sum_delivery_qty"]==""? 0 : $row_order_delivery_packing["sum_delivery_qty"];	
			
    if($order_packing==0){
        $order_performance_packing = 100;
    }else{

        $order_performance_packing = round(($order_complete_packing/$order_packing)*100,2);
    } 
      /* Packing Sparepart */
	  /* Packing Export */         
	  $sql_sum = "SELECT sum(cast(Split_Qty as int)) as sum_Order_quantity1 
                        FROM tborder_export
                        WHERE  Request_dlv_dt='$report_start_date'
						and Split_Qty > 0";
                        $res_sum = mssql_query($sql_sum);
                        $row_sum = mssql_fetch_array($res_sum);
                        $sum_Order_quantity1 = $row_sum["sum_Order_quantity1"];
						$sql_sum2 = "SELECT sum(cast(Order_quantity as int)) as sum_Order_quantity2 
                        FROM tborder_export
                        WHERE  Request_dlv_dt='$report_start_date'
						and Split_Qty =0";
                        $res_sum2 = mssql_query($sql_sum2);
                        $row_sum2 = mssql_fetch_array($res_sum2);
                        $sum_Order_quantity2 = $row_sum2["sum_Order_quantity2"];
	 $order_packing_export = (int)$sum_Order_quantity1+(int)$sum_Order_quantity2;
			 
			 $sql_order_complete_packing_export = "SELECT sum(packing_qty) as sum_packing_qty FROM tbpacking_export
                        WHERE jobstatus_packing='Close'
                        AND Issue_No IN (SELECT Issue_No FROM tborder_export
                        WHERE Request_dlv_dt='$report_start_date') ";
   			 $res_order_complete_packing_export = mssql_query($sql_order_complete_packing_export);
   			 $row_order_complete_packing_export = mssql_fetch_array($res_order_complete_packing_export);
			 $order_complete_packing_export = $row_order_complete_packing_export["sum_packing_qty"]==""? 0 : $row_order_complete_packing_export["sum_packing_qty"];		
			 
			 
			  $sql_order_delivery_packing_export = "SELECT sum(packing_qty) as sum_delivery_qty 
			  FROM tbpacking_sparepart
                        WHERE jobstatus_packing='Close'
                        AND Issue_No IN (SELECT Issue_No FROM tborder_export
                        WHERE   Request_dlv_dt='$report_start_date' and Pallet_No in(select Pallet_No from tbdelivery_plan_export where jobstatus='Close')) ";
   			 $res_order_delivery_packing_export = mssql_query($sql_order_delivery_packing_export);
			 $row_order_delivery_packing_export = mssql_fetch_array($res_order_delivery_packing_export);
			  $order_delivery_packing_export = $row_order_delivery_packing_export["sum_delivery_qty"]==""? 0 : $row_order_delivery_packing_export["sum_delivery_qty"];	
			
    if($order_packing_export==0){
        $order_performance_packing_export = 100;
    }else{

        $order_performance_packing_export = round(($order_complete_packing_export/$order_packing_export)*100,2);
    } 
	  /* Packing Export */ 				
	/* 5.6 Issue performance (Packing Sparepart & export) */
    ?>
    <div class="panel panel-<?=$panel_text?>">
        <div class="panel-heading">
            <h4>1. SAFETY.</h4>
        </div>
        <div class="panel-body">
            <div class="form-horizontal">
                <div class="form-group " style="background-color:#ffff6678;padding:5px;">
                    <label class="control-label col-sm-2" for="safety_human">Human ( Case ) <br> อุบัติเหตุที่เกิดขึ้นกับคน</label>
                    <div class="col-sm-2">
                        <input type="number" class="form-control" id="safety_human" name="safety_human" autocomplete="off" value="<?= $safety_human ?>" onchange="safety_cal()">
                    </div>
                </div>
                <div class="form-group" style="background-color:#ffff6678;padding:5px;">
                    <label class="control-label col-sm-2" for="safety_part">Part ( Pcs.) <br>อุบัติเหตุที่เกิดขึ้นกับชิ้นงาน</label>
                    <div class="col-sm-2">
                        <input type="number" class="form-control" id="safety_part" name="safety_part" autocomplete="off" value="<?= $safety_part ?>" onchange="safety_cal()">
                    </div>
                </div>
                <div class="form-group" style="background-color:#ffff6678;padding:5px;">
                    <label class="control-label col-sm-2" for="safety_nearmiss">Near miss ( Case ) <br> อุบัติเหตุหรือเหตุการณ์ที่อาจทำให้เกิดอุบัติเหตุได้ </label>
                    <div class="col-sm-2">
                        <input type="number" class="form-control" id="safety_nearmiss" name="safety_nearmiss" autocomplete="off" value="<?= $safety_nearmiss ?>" onchange="safety_cal()">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="safety_target">Result Performance (%)</label>
                    <div class="col-sm-2">
                        <input type="number" class="form-control" id="safety_target" name="safety_target" autocomplete="off" value="<?= $safety_target ?>" readonly>
                        
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="panel panel-<?=$panel_text?>">
        <div class="panel-heading">
            <h4>2. 5S. Daily.</h4>
        </div>
        <div class="panel-body">
            <div class="form-horizontal">

                <div class="form-group">
                    <label class="control-label col-sm-2" for="ss_daily">1.Ware house Area</label>
                    <div class="col-sm-2" >
                        <a href="<?= $ss_daily ?>" class="btn btn-info" target='_blank'>Picture</a>
                        <input type="hidden" class="form-control" id="ss_daily" name="ss_daily" autocomplete="off" value="<?= $ss_daily ?>" readonly>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-2" for="ss_daily_status">Day</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" id="ss_daily_status" name="ss_daily_status" autocomplete="off" value="<?= $ss_daily_status ?>" readonly>
                    </div>
                </div>

                <!-- <div class="form-group">
                    <label class="control-label col-sm-2" for="ss_daily_night">Night</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" id="ss_daily_night" name="ss_daily_night" autocomplete="off" value="<?= $ss_daily_night ?>" readonly>
                    </div>
                </div> -->
                <div class="form-group">
                    <label class="control-label col-sm-2" for="ss_daily_percent">Status Check </label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" id="ss_daily_percent" name="ss_daily_percent" autocomplete="off" value="<?= $ss_daily_percent ?>" readonly>
                    </div>
                </div>


            </div>
        </div>
    </div>
    <div class="panel panel-<?=$panel_text?>">
        <div class="panel-heading">
            <h4>3. TIME ATTENDANCE.</h4>
        </div>
        <div class="panel-body">
            <div class="form-horizontal">
                <div class="form-group ">
                    <label class="control-label col-sm-2" for="att_asst_mgr">3.1 Asst,wh MGR </label>
                    <div class="col-sm-2">
                        <input type="number" class="form-control  " id="att_asst_mgr" name="att_asst_mgr" autocomplete="off" value="<?= $att_asst_mgr ?>" readonly>
                    </div>
                    <div class="col-sm-2">
                        <p class="form-control-static"><i class='fa fa-info-circle fa-lg'  style='cursor: pointer;' onclick="show_att()"></i></p>    
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="att_supervisor">3.2 Supervisor </label>
                    <div class="col-sm-2">
                        <input type="number" class="form-control" id="att_supervisor" name="att_supervisor" autocomplete="off" value="<?= $att_supervisor ?>" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="att_leader">3.3 Leader </label>
                    <div class="col-sm-2">
                        <input type="number" class="form-control" id="att_leader" name="att_leader" autocomplete="off" value="<?= $att_leader ?>" readonly>
                        
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="att_operator">3.4 Operator </label>
                    <div class="col-sm-2">
                        <input type="number" class="form-control" id="att_operator" name="att_operator" autocomplete="off" value="<?= $att_operator ?>" readonly>
                        
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="att_admin">3.5 Admin </label>
                    <div class="col-sm-2">
                        <input type="number" class="form-control" id="att_admin" name="att_admin" autocomplete="off" value="<?= $att_admin ?>" readonly>
                        
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="att_late">3.6 Late </label>
                    <div class="col-sm-2">
                        <input type="number" class="form-control" id="att_late" name="att_late" autocomplete="off" value="<?= $att_late ?>" readonly>
                        
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="att_forklift">3.7 Forkift </label>
                    <div class="col-sm-2">

                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="att_forklift_name">- <?=$shift?> shift </label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" id="att_forklift_name" name="att_forklift_name" autocomplete="off" value="<?= $att_forklift_name ?>" readonly>
                        
                    </div>
                </div>
                <!-- <div class="form-group">
                    <label class="control-label col-sm-2" for="att_forklift_night">- Night shift </label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" id="att_forklift_night" name="att_forklift_night" autocomplete="off" value="<?= $att_forklift_night ?>" readonly>
                        
                    </div>
                </div> -->
                <div class="form-group" style="background-color:#ffff6678;padding:5px;">
                    <label class="control-label col-sm-2" for="att_plan">Plan </label>
                    <div class="col-sm-2">
                        <input type="number" class="form-control" id="att_plan" name="att_plan" autocomplete="off" value="<?= $att_plan ?>" onchange="time_att_cal()" >
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="att_total">Total </label>
                    <div class="col-sm-2">
                        <input type="number" class="form-control" id="att_total" name="att_total" autocomplete="off" value="<?= $att_total ?>" readonly>
                        
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="att_total_percent">Total attendance (%)/Day. </label>
                    <div class="col-sm-2">
                        <input type="number" class="form-control" id="att_total_percent" name="att_total_percent" autocomplete="off" value="<?= $att_total_percent ?>" readonly>
                        
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="att_achieve">Target achieve </label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" id="att_achieve" name="att_achieve" autocomplete="off" value="<?= $att_achieve ?>" readonly>
                        
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="panel panel-<?=$panel_text?>">
        <div class="panel-heading">
            <h4>4. OVERTIME Work.</h4>
        </div>
        <div class="panel-body">
            <div class="form-horizontal">

                <div class="form-group" >
                    <label class="control-label col-sm-2" for="ot_asst_mgr_prs">4.1 Asst,wh MGR </label>
                    <div class="col-sm-2 text-center">
                        คนที่ทำโอที <input type="number" class="form-control" id="ot_asst_mgr_prs" name="ot_asst_mgr_prs" autocomplete="off" value="<?= $ot_asst_mgr_prs ?>" readonly>                        
                    </div>
                    <div class="col-sm-2 text-center">
                        ชั่วโมงที่ทำโอที <input type="number" class="form-control" id="ot_asst_mgr_hrs" name="ot_asst_mgr_hrs" autocomplete="off" value="<?= $ot_asst_mgr_hrs ?>" readonly>
                    </div>
                    <div class="col-sm-2">
                        <br>
                        <p class="form-control-static"><i class='fa fa-info-circle fa-lg'  style='cursor: pointer;' onclick="show_ot()"></i></p>    
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="ot_supervisor_prs">4.2 Supervisor </label>
                    <div class="col-sm-2 text-center">
                        คนที่ทำโอที <input type="number" class="form-control" id="ot_supervisor_prs" name="ot_supervisor_prs" autocomplete="off" value="<?= $ot_supervisor_prs ?>" readonly>
                    </div>
                    <div class="col-sm-2 text-center">
                        ชั่วโมงที่ทำโอที <input type="number" class="form-control" id="ot_supervisor_hrs" name="ot_supervisor_hrs" autocomplete="off" value="<?= $ot_supervisor_hrs ?>" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="ot_leader_prs">4.3 Leader </label>
                    <div class="col-sm-2 text-center">
                        คนที่ทำโอที<input type="number" class="form-control" id="ot_leader_prs" name="ot_leader_prs" autocomplete="off" value="<?= $ot_leader_prs ?>" readonly>
                    </div>
                    <div class="col-sm-2 text-center">
                        ชั่วโมงที่ทำโอที <input type="number" class="form-control" id="ot_leader_hrs" name="ot_leader_hrs" autocomplete="off" value="<?= $ot_leader_hrs ?>" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="ot_operator_hrs">4.4 Operator </label>
                    <div class="col-sm-2 text-center">
                        คนที่ทำโอที <input type="number" class="form-control" id="ot_operator_prs" name="ot_operator_prs" autocomplete="off" value="<?= $ot_operator_prs ?>" readonly>
                    </div>
                    <div class="col-sm-2 text-center">
                        ชั่วโมงที่ทำโอที<input type="number" class="form-control" id="ot_operator_hrs" name="ot_operator_hrs" autocomplete="off" value="<?= $ot_operator_hrs ?>" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="ot_admin_hrs">4.5 Admin </label>
                    <div class="col-sm-2 text-center">
                        คนที่ทำโอที <input type="number" class="form-control" id="ot_admin_prs" name="ot_admin_prs" autocomplete="off" value="<?= $ot_admin_prs ?>" readonly>
                    </div>
                    <div class="col-sm-2 text-center">
                        ชั่วโมงที่ทำโอที<input type="number" class="form-control" id="ot_admin_hrs" name="ot_admin_hrs" autocomplete="off" value="<?= $ot_admin_hrs ?>" readonly>
                    </div>
                </div>
                <div class="form-group" style="background-color:#ffff6678;padding:5px;">
                    <label class="control-label col-sm-2" for="ot_target">Overtime Target </label>
                    <div class="col-sm-2 text-center">
                         <input type="number" class="form-control" id="ot_target" name="ot_target" autocomplete="off" value="<?= $ot_target ?>" onchange="ot_achieve_cal()">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="ot_actual">Actual Overtime</label>
                    <div class="col-sm-2 text-center">
                         <input type="number" class="form-control" id="ot_actual" name="ot_actual" autocomplete="off" value="<?= $ot_actual ?>" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="ot_achieve">Status achieve</label>
                    <div class="col-sm-2 text-center">
                         <input type="text" class="form-control" id="ot_achieve" name="ot_achieve" autocomplete="off" value="<?= $ot_achieve ?>" readonly>
                    </div>
                </div>

                <!--
                <div class="form-group" style="background-color:#ffff6678;padding:5px;">
                    <label class="control-label col-sm-2" for="ot_remark">Remark </label>
                    <div class="col-sm-4 text-center">
                        <textarea name="ot_remark" id="ot_remark" cols="30" rows="10" class="form-control"><?=$ot_remark?></textarea>
                    </div>
                </div>
                -->

            </div>
        </div>
    </div>
    <div class="panel panel-<?=$panel_text?>">
        <div class="panel-heading">
            <h4>5.Operation performance</h4>
        </div>
        <div class="panel-body">
            <div class="form-horizontal">
                <div class="form-group">
                    <label class="col-sm-5" for="5_1">
                        <h5><b>5.1 Receive & Put Away (Box Management) </b></h5>
                    </label>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="per_receive_box">5.1.1 Receive</label>
                    <div class="col-sm-2 text-center">
                        <input type="number" class="form-control" id="per_receive_box" name="per_receive_box" autocomplete="off" value="<?= $per_receive_box ?>" readonly>
                    </div>
                    <div class="col-sm-2">
                        <p class="form-control-static"><i class='fa fa-info-circle fa-lg'  style='cursor: pointer;' onclick="show_receive_box('<?=$shift?>')"></i></p>    
                    </div>
                </div>

                <!-- <div class="form-group">
                    <label class="control-label col-sm-2" for="per_hold_box">5.1.2 Hold</label>
                    <div class="col-sm-2 text-center">
                        <input type="number" class="form-control" id="per_hold_box" name="per_hold_box" autocomplete="off" value="<?= $per_hold_box ?>" readonly>
                    </div>
                    <div class="col-sm-2">
                        <p class="form-control-static"><i class='fa fa-info-circle fa-lg'  style='cursor: pointer;' onclick="show_hold_box()"></i></p>    
                    </div>
                </div> -->
                <div class="form-group">
                    <label class="control-label col-sm-2" for="per_damage_box">5.1.2 Damage</label>
                    <div class="col-sm-2 text-center">
                        <input type="number" class="form-control" id="per_damage_box" name="per_damage_box" autocomplete="off" value="<?= $per_damage_box ?>" readonly>
                    </div>
                    <div class="col-sm-2">
                        <p class="form-control-static"><i class='fa fa-info-circle fa-lg'  style='cursor: pointer;' onclick="show_damage_box()"></i></p>    
                    </div>
                </div>

                

                <!--5.2-->
                <div class="form-group">
                    <label class=" col-sm-5" for="5_3">
                        <h5><b>5.2 Issue performance (Box Management)</b></h5>
                    </label>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="issue_order_order">5.2.1 Order require(Total)</label>
                    <div class="col-sm-2 text-center">
                        จำนวน order <input type="number" class="form-control" id="issue_order_order" name="issue_order_order" autocomplete="off" value="<?= $issue_order_order ?>" readonly>
                    </div>
                    <div class="col-sm-2 text-center">
                        จำนวนกล่อง <input type="number" class="form-control" id="issue_order_box" name="issue_order_box" autocomplete="off" value="<?= $issue_order_box ?>" readonly>
                    </div>
                    <div class="col-sm-2">
                        <br>
                        <p class="form-control-static"><i class='fa fa-info-circle fa-lg'  style='cursor: pointer;' onclick="show_issue_order('<?=$shift?>')"></i></p>    
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-2" for="issue_order_incomplete_order">5.2.2 Order incomplete</label>
                    <div class="col-sm-2 text-center">
                        จำนวน order<input type="number" class="form-control" id="issue_order_incomplete_order" name="issue_order_incomplete_order" autocomplete="off" value="<?= $issue_order_incomplete_order ?>" readonly>
                    </div>
                    <div class="col-sm-2 text-center">
                        จำนวนกล่อง <input type="number" class="form-control" id="issue_order_incomplete_box" name="issue_order_incomplete_box" autocomplete="off" value="<?= $issue_order_incomplete_box ?>" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="issue_order_complete_order">5.2.3 Order Issue</label>
                    <div class="col-sm-2 text-center">
                        จำนวน order<input type="number" class="form-control" id="issue_order_complete_order" name="issue_order_complete_order" autocomplete="off" value="<?= $issue_order_complete_order ?>" readonly>
                    </div>
                    <div class="col-sm-2 text-center">
                        จำนวนกล่อง <input type="number" class="form-control" id="issue_order_complete_box" name="issue_order_complete_box" autocomplete="off" value="<?= $issue_order_complete_box ?>" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="issue_performance_order">Result Performance</label>
                    <div class="col-sm-2 text-center">
                        จำนวน order (%)<input type="number" class="form-control" id="issue_performance_order" name="issue_performance_order" autocomplete="off" value="<?= $issue_performance_order ?>" readonly>
                    </div>
                    <div class="col-sm-2 text-center">
                        จำนวนกล่อง (%)<input type="number" class="form-control" id="issue_performance_box" name="issue_performance_box" autocomplete="off" value="<?= $issue_performance_box ?>" readonly>
                    </div>
                </div>
                <div class="form-group" style="background-color:#ffff6678;padding:5px;">
                    <label class="control-label col-sm-2" for="issue_remark">Remark </label>
                    <div class="col-sm-4 text-center">
                        <textarea name="issue_remark" id="issue_remark" cols="30" rows="10" class="form-control"><?=$issue_remark?></textarea>
                    </div>
                </div>

                <!--5.3-->
                <div class="form-group">
                    <label class=" col-sm-5" for="5_3">
                        <h5><b>5.3 Quality</b></h5>
                    </label>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="qa_partinbox_cus">5.3.1 Part in box from customer</label>
                    <div class="col-sm-2 text-center">
                        <input type="number" class="form-control" id="qa_partinbox_cus" name="qa_partinbox_cus" autocomplete="off" value="<?= $qa_partinbox_cus ?>" readonly>
                    </div>
                    <div class="col-sm-2">
                        <p class="form-control-static"><i class='fa fa-info-circle fa-lg'  style='cursor: pointer;' onclick="show_partinbox_cus()"></i></p>    
                    </div>
                </div>

                <div class="form-group" style="background-color:#ffff6678;padding:5px;">
                    <label class="control-label col-sm-2" for="qa_partinbox_ipack">5.3.2 Part in box from IPACK</label>
                    <div class="col-sm-2 text-center">
                        <input type="number" class="form-control" id="qa_partinbox_ipack" name="qa_partinbox_ipack" autocomplete="off" value="<?= $qa_partinbox_ipack ?>" onchange="qa_result_cal()">
                    </div>

                </div>
                <div class="form-group" style="background-color:#ffff6678;padding:5px;">
                    <label class="control-label col-sm-2" for="qa_westbox_ipack">5.3.3 Wast box,West Box from IPACK</label>
                    <div class="col-sm-2 text-center">
                        <input type="number" class="form-control" id="qa_westbox_ipack" name="qa_westbox_ipack" autocomplete="off" value="<?= $qa_westbox_ipack ?>" onchange="qa_result_cal()">
                    </div>
                </div>
                <div class="form-group" >
                    <label class="control-label col-sm-2" for="qa_result">Result</label>
                    <div class="col-sm-2 text-center">
                        <input type="text" class="form-control" id="qa_result" name="qa_result" autocomplete="off" value="<?= $qa_result ?>" readonly>
                    </div>

                </div>

                <!--5.4-->
                <div class="form-group">
                    <label class=" col-sm-5" for="5_2">
                        <h5><b>5.4 Receive & Put Away Performace (VMI : Project)</b></h5>
                    </label>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="per_receive_box_vmi">5.4.1 Receive</label>
                    <div class="col-sm-2 text-center">
                        <input type="number" class="form-control" id="per_receive_box_vmi" name="per_receive_box_vmi" autocomplete="off" value="<?= $per_receive_box_vmi ?>" readonly>
                    </div>
                    <div class="col-sm-2">
                        <p class="form-control-static"><i class='fa fa-info-circle fa-lg'  style='cursor: pointer;' onclick="show_receive_box_vmi()"></i></p>    
                    </div>

                </div>

                <!-- <div class="form-group">
                    <label class="control-label col-sm-2" for="per_hold_box_vmi">5.4.2 Hold</label>
                    <div class="col-sm-2 text-center">
                        <input type="number" class="form-control" id="per_hold_box_vmi" name="per_hold_box_vmi" autocomplete="off" value="<?= $per_hold_box_vmi ?>" readonly>
                    </div>
                    <div class="col-sm-2">
                        <p class="form-control-static"><i class='fa fa-info-circle fa-lg'  style='cursor: pointer;' onclick="show_hold_box_vmi()"></i></p>    
                    </div>

                </div> -->
                <div class="form-group">
                    <label class="control-label col-sm-2" for="per_damage_box_vmi">5.4.2 Damage</label>
                    <div class="col-sm-2 text-center">
                        <input type="number" class="form-control" id="per_damage_box_vmi" name="per_damage_box_vmi" autocomplete="off" value="<?= $per_damage_box_vmi ?>" readonly>
                    </div>
                    <div class="col-sm-2">
                        <p class="form-control-static"><i class='fa fa-info-circle fa-lg'  style='cursor: pointer;' onclick="show_damage_box_vmi()"></i></p>    
                    </div>

                </div>

                <!--5.5-->
                <div class="form-group">
                    <label class=" col-sm-5" for="5_3">
                        <h5><b>5.5 Issue performance (VMI : Project)</b></h5>
                    </label>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="issue_order_order_vmi">5.5.1 Order require(Total)</label>
                    <div class="col-sm-2 text-center">
                        จำนวน order <input type="number" class="form-control" id="issue_order_order_vmi" name="issue_order_order_vmi" autocomplete="off" value="<?= $issue_order_order_vmi ?>" readonly>
                    </div>
                    <div class="col-sm-2 text-center">
                        จำนวนกล่อง <input type="number" class="form-control" id="issue_order_box_vmi" name="issue_order_box_vmi" autocomplete="off" value="<?= $issue_order_box_vmi ?>" readonly>
                    </div>
                    <div class="col-sm-2">
                        <br>
                        <p class="form-control-static"><i class='fa fa-info-circle fa-lg'  style='cursor: pointer;' onclick="show_issue_order_vmi()"></i></p>    
                    </div>

                </div>

                <div class="form-group">
                    <label class="control-label col-sm-2" for="issue_order_incomplete_order_vmi">5.5.2 Order incomplete</label>
                    <div class="col-sm-2 text-center">
                        จำนวน order<input type="number" class="form-control" id="issue_order_incomplete_order_vmi" name="issue_order_incomplete_order_vmi" autocomplete="off" value="<?= $issue_order_incomplete_order_vmi ?>" readonly>
                    </div>
                    <div class="col-sm-2 text-center">
                        จำนวนกล่อง <input type="number" class="form-control" id="issue_order_incomplete_box_vmi" name="issue_order_incomplete_box_vmi" autocomplete="off" value="<?= $issue_order_incomplete_box_vmi ?>" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="issue_order_complete_order_vmi">5.5.3 Order Issue</label>
                    <div class="col-sm-2 text-center">
                        จำนวน order<input type="number" class="form-control" id="issue_order_complete_order_vmi" name="issue_order_complete_order_vmi" autocomplete="off" value="<?= $issue_order_complete_order_vmi ?>" readonly>
                    </div>
                    <div class="col-sm-2 text-center">
                        จำนวนกล่อง <input type="number" class="form-control" id="issue_order_complete_box_vmi" name="issue_order_complete_box_vmi" autocomplete="off" value="<?= $issue_order_complete_box_vmi ?>" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="issue_performance_order_vmi">Result Performance</label>
                    <div class="col-sm-2 text-center">
                        จำนวน order (%)<input type="number" class="form-control" id="issue_performance_order_vmi" name="issue_performance_order_vmi" autocomplete="off" value="<?= $issue_performance_order_vmi ?>" readonly>
                    </div>
                    <div class="col-sm-2 text-center">
                        จำนวนกล่อง (%)<input type="number" class="form-control" id="issue_performance_box_vmi" name="issue_performance_box_vmi" autocomplete="off" value="<?= $issue_performance_box_vmi ?>" readonly>
                    </div>
                </div>
                <div class="form-group" style="background-color:#ffff6678;padding:5px;">
                    <label class="control-label col-sm-2" for="issue_remark_vmi">Remark </label>
                    <div class="col-sm-4 text-center">
                        <textarea name="issue_remark_vmi" id="issue_remark_vmi" cols="30" rows="10" class="form-control"><?=$issue_remark_vmi?></textarea>
                    </div>
                </div>
                
				 <!--5.6-->
				<div class="form-group">
                    <label class=" col-sm-5" for="5_3">
                        <h5><b>5.6 Issue performance (Packing)</b></h5>
                    </label>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="order_packing">Total Order on SAP<BR>(Spare part)</label>
                   
<div class="col-sm-6 text-center">
                        จำนวน  (pcs) 
                          <input type="number" class="form-control" id="order_packing" name="order_packing" autocomplete="off" value="<?= $order_packing ?>" readonly>
                    </div>
                    
                   

                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" for="order_complete_packing">Total Order Packing Complete<BR>(Spare part)</label>

                    <div class="col-sm-6 text-center">
                      จำนวน (pcs) <input type="number" class="form-control" id="order_complete_packing" name="order_complete_packing" autocomplete="off" value="<?= $order_complete_packing ?>" readonly>
                  </div>
                    
                   

                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" for="order_delivery_packing">Total Order Delivery to DL<BR>(Spare part)</label>

                    <div class="col-sm-6 text-center">
                      จำนวน (pcs) <input type="number" class="form-control" id="order_delivery_packing" name="order_delivery_packing" autocomplete="off" value="<?= $order_delivery_packing ?>" readonly>
                  </div>
                    
                   

                </div>
                
                 <div class="form-group">
                    <label class="control-label col-sm-2" for="order_packing_export">Total Order on SAP<BR>(Export)</label>
                    
<div class="col-sm-6 text-center">
                        จำนวน  (pcs) 
                          <input type="number" class="form-control" id="order_packing_export" name="order_packing_export" autocomplete="off" value="<?= $order_packing_export ?>" readonly>
                    </div>
                    
                   

                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" for="order_complete_packing_export">Total Order Packing Complete<BR>(Export)</label>

                    <div class="col-sm-6 text-center">
                      จำนวน (pcs) <input type="number" class="form-control" id="order_complete_packing_export" name="order_complete_packing_export" autocomplete="off" value="<?= $order_complete_packing_export ?>" readonly>
                  </div>
                    
                   

                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" for="order_delivery_packing_export">Total Order Delivery to DL <BR>(Export)</label>

                    <div class="col-sm-6 text-center">
                      จำนวน (pcs) <input type="number" class="form-control" id="order_delivery_packing_export" name="order_delivery_packing_export" autocomplete="off" value="<?= $order_delivery_packing_export ?>" readonly>
                  </div>
                    
                   

                </div>
                
                
                
                <div class="form-group">
                    <label class="control-label col-sm-2" for="order_performance_packing">Result Performance</label>
                    <div class="col-sm-2 text-center">
                        จำนวน order Spare part(%) <input type="number" class="form-control" id="order_performance_packing" name="order_performance_packing" autocomplete="off" value="<?= $order_performance_packing ?>" readonly>
                    </div>
                    <div class="col-sm-2 text-center">
                        จำนวน order Export (%)<input type="number" class="form-control" id="order_performance_packing_export" name="order_performance_packing_export" autocomplete="off" value="<?= $order_performance_packing_export ?>" readonly>
                    </div>
                </div>
                 <!--5.6-->
                
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-4 col-sm-10">
            <?=$btn_txt?>
            <!-- <button  class="btn btn-<?=$btn_color?>" onclick='save_daily_report_tsc()'><?=$text_save?></button> -->
        </div>
    </div>
<?
}else if($status=="save_daily_report_tsc"){
    $report_date = date_format_uk_into_database($_POST["report_date"]);
    $shift = $_POST["shift"];
    $safety_human = $_POST["safety_human"];
    $safety_part = $_POST["safety_part"];
    $safety_nearmiss = $_POST["safety_nearmiss"];
    $safety_target = $_POST["safety_target"];
    $ss_daily = $_POST["ss_daily"];
    $ss_daily_status = $_POST["ss_daily_status"];
    $ss_daily_percent = $_POST["ss_daily_percent"];
    $att_asst_mgr = $_POST["att_asst_mgr"];
    $att_supervisor = $_POST["att_supervisor"];
    $att_leader = $_POST["att_leader"];
    $att_operator = $_POST["att_operator"];
    $att_admin = $_POST["att_admin"];
    $att_late = $_POST["att_late"];
    $att_forklift_name = lang_thai_into_database($_POST["att_forklift_name"]);
    $att_plan = $_POST["att_plan"];
    $att_total = $_POST["att_total"];
    $att_total_percent = $_POST["att_total_percent"];
    $att_achieve = $_POST["att_achieve"];
    $ot_asst_mgr_prs = $_POST["ot_asst_mgr_prs"];
    $ot_asst_mgr_hrs = $_POST["ot_asst_mgr_hrs"];
    $ot_supervisor_prs = $_POST["ot_supervisor_prs"];
    $ot_supervisor_hrs = $_POST["ot_supervisor_hrs"];
    $ot_leader_prs = $_POST["ot_leader_prs"];
    $ot_leader_hrs = $_POST["ot_leader_hrs"];
    $ot_operator_prs = $_POST["ot_operator_prs"];
    $ot_operator_hrs = $_POST["ot_operator_hrs"];
    $ot_admin_prs = $_POST["ot_admin_prs"];
    $ot_admin_hrs = $_POST["ot_admin_hrs"];
    $ot_target = $_POST["ot_target"];
    $ot_actual = $_POST["ot_actual"];
    $ot_achieve = $_POST["ot_achieve"];
    $ot_remark = $_POST["ot_remark"];
    $per_receive_box = $_POST["per_receive_box"];
    
    $per_damage_box = $_POST["per_damage_box"];
    
    $issue_order_order = $_POST["issue_order_order"];
    $issue_order_box = $_POST["issue_order_box"];
    $issue_order_incomplete_order = $_POST["issue_order_incomplete_order"];
    $issue_order_incomplete_box = $_POST["issue_order_incomplete_box"];
    $issue_order_complete_order = $_POST["issue_order_complete_order"];
    $issue_order_complete_box = $_POST["issue_order_complete_box"];
    $issue_performance_order = $_POST["issue_performance_order"];
    $issue_performance_box = $_POST["issue_performance_box"];
    $issue_remark = lang_thai_into_database($_POST["issue_remark"]);

    $qa_partinbox_cus = $_POST["qa_partinbox_cus"];
    $qa_partinbox_ipack = $_POST["qa_partinbox_ipack"];
    $qa_westbox_ipack = $_POST["qa_westbox_ipack"];
    $qa_result = $_POST["qa_result"];

    $per_receive_box_vmi = $_POST["per_receive_box_vmi"];
    
    $per_damage_box_vmi = $_POST["per_damage_box_vmi"];
    
    $issue_order_order_vmi = $_POST["issue_order_order_vmi"];
    $issue_order_box_vmi = $_POST["issue_order_box_vmi"];
    $issue_order_incomplete_order_vmi = $_POST["issue_order_incomplete_order_vmi"];
    $issue_order_incomplete_box_vmi = $_POST["issue_order_incomplete_box_vmi"];
    $issue_order_complete_order_vmi = $_POST["issue_order_complete_order_vmi"];
    $issue_order_complete_box_vmi = $_POST["issue_order_complete_box_vmi"];
    $issue_performance_order_vmi = $_POST["issue_performance_order_vmi"];
    $issue_performance_box_vmi = $_POST["issue_performance_box_vmi"];
    $issue_remark_vmi = lang_thai_into_database($_POST["issue_remark_vmi"]);
	
	
	$order_packing= $_POST["order_packing"];
	$order_complete_packing= $_POST["order_complete_packing"];
	$order_delivery_packing= $_POST["order_delivery_packing"];
	$order_performance_packing= $_POST["order_performance_packing"];
	
	$order_packing_export= $_POST["order_packing_export"];
	$order_complete_packing_export= $_POST["order_complete_packing_export"];
	$order_delivery_packing_export= $_POST["order_delivery_packing_export"];
	$order_performance_packing_export= $_POST["order_performance_packing_export"];


    $sql = "SELECT *  FROM tbdaily_report_tsc WHERE workdate='$report_date' AND shift='$shift'";
    $res = mssql_query($sql);
    $num = mssql_num_rows($res);
    //echo $sql;
    if ($num == 0) {
        $insert = " INSERT INTO tbdaily_report_tsc
           (workdate
           ,shift
           ,safety_human
           ,safety_part
           ,safety_nearmiss
           ,safety_target
           ,ss_daily
           ,ss_daily_status
           ,ss_daily_percent
           ,att_asst_mgr
           ,att_supervisor
           ,att_leader
           ,att_operator
           ,att_admin
           ,att_late
           ,att_forklift_name
           ,att_plan
           ,att_total
           ,att_total_percent
           ,att_achieve
           ,ot_asst_mgr_prs
           ,ot_asst_mgr_hrs
           ,ot_supervisor_prs
           ,ot_supervisor_hrs
           ,ot_leader_prs
           ,ot_leader_hrs
           ,ot_operator_prs
           ,ot_operator_hrs
           ,ot_admin_prs
           ,ot_admin_hrs
           ,ot_target
           ,ot_actual
           ,ot_achieve
           ,ot_remark
           ,per_receive_box
           
           ,per_damage_box
           ,per_receive_box_vmi
           
           ,per_damage_box_vmi
           ,qa_partinbox_cus
           ,qa_partinbox_ipack
           ,qa_westbox_ipack
           ,qa_result
           ,issue_order_order
           ,issue_order_box
           ,issue_order_incomplete_order
           ,issue_order_incomplete_box
           ,issue_order_complete_order
           ,issue_order_complete_box
           ,issue_performance_order
           ,issue_performance_box
           ,issue_remark
           ,issue_order_order_vmi
           ,issue_order_box_vmi
           ,issue_order_incomplete_order_vmi
           ,issue_order_incomplete_box_vmi
           ,issue_order_complete_order_vmi
           ,issue_order_complete_box_vmi
           ,issue_performance_order_vmi
           ,issue_performance_box_vmi
           ,issue_remark_vmi
           ,report_by
           ,report_by_date,
		    order_packing,
			order_complete_packing,
			order_delivery_packing,
			order_performance_packing,
			order_packing_export,
			order_complete_packing_export,
			order_delivery_packing_export,
			order_performance_packing_export
		   )
            VALUES
           ('$report_date'
           ,'$shift'
           ,'$safety_human'
           ,'$safety_part'
           ,'$safety_nearmiss'
           ,'$safety_target'
           ,'$ss_daily'
           ,'$ss_daily_status'
           ,'$ss_daily_percent'
           ,'$att_asst_mgr'
           ,'$att_supervisor'
           ,'$att_leader'
           ,'$att_operator'
           ,'$att_admin'
           ,'$att_late'
           ,'$att_forklift_name'
           ,'$att_plan'
           ,'$att_total'
           ,'$att_total_percent'
           ,'$att_achieve'
           ,'$ot_asst_mgr_prs'
           ,'$ot_asst_mgr_hrs'
           ,'$ot_supervisor_prs'
           ,'$ot_supervisor_hrs'
           ,'$ot_leader_prs'
           ,'$ot_leader_hrs'
           ,'$ot_operator_prs'
           ,'$ot_operator_hrs'
           ,'$ot_admin_prs'
           ,'$ot_admin_hrs'
           ,'$ot_target'
           ,'$ot_actual'
           ,'$ot_achieve'
           ,'$ot_remark'
           ,'$per_receive_box'
           
           ,'$per_damage_box'
           ,'$per_receive_box_vmi'
           
           ,'$per_damage_box_vmi'
           ,'$qa_partinbox_cus'
           ,'$qa_partinbox_ipack'
           ,'$qa_westbox_ipack'
           ,'$qa_result'
           ,'$issue_order_order'
           ,'$issue_order_box'
           ,'$issue_order_incomplete_order'
           ,'$issue_order_incomplete_box'
           ,'$issue_order_complete_order'
           ,'$issue_order_complete_box'
           ,'$issue_performance_order'
           ,'$issue_performance_box'
           ,'$issue_remark'
           ,'$issue_order_order_vmi'
           ,'$issue_order_box_vmi'
           ,'$issue_order_incomplete_order_vmi'
           ,'$issue_order_incomplete_box_vmi'
           ,'$issue_order_complete_order_vmi'
           ,'$issue_order_complete_box_vmi'
           ,'$issue_performance_order_vmi'
           ,'$issue_performance_box_vmi'
           ,'$issue_remark_vmi'
           ,'$admin_userid'
           ,'$date_time',
		    $order_packing,
			$order_complete_packing,
			$order_delivery_packing,
			$order_performance_packing,
			$order_packing_export,
			$order_complete_packing_export,
			$order_delivery_packing_export,
			$order_performance_packing_export
		   
		   
		   )";
        mssql_query($insert);
        // echo $insert;
    }else{
        $update = "UPDATE tbdaily_report_tsc
        SET safety_human = '$safety_human'
           ,safety_part = '$safety_part'
           ,safety_nearmiss = '$safety_nearmiss'
           ,safety_target = '$safety_target'
           ,ss_daily = '$ss_daily'
           ,ss_daily_status = '$ss_daily_status'
           ,ss_daily_percent = '$ss_daily_percent'
           ,att_asst_mgr = '$att_asst_mgr'
           ,att_supervisor = '$att_supervisor'
           ,att_leader = '$att_leader'
           ,att_operator = '$att_operator'
           ,att_admin = '$att_admin'
           ,att_late = '$att_late'
           ,att_forklift_name = '$att_forklift_name'
           ,att_plan = '$att_plan'
           ,att_total = '$att_total'
           ,att_total_percent = '$att_total_percent'
           ,att_achieve = '$att_achieve'
           ,ot_asst_mgr_prs = '$ot_asst_mgr_prs'
           ,ot_asst_mgr_hrs = '$ot_asst_mgr_hrs'
           ,ot_supervisor_prs = '$ot_supervisor_prs'
           ,ot_supervisor_hrs = '$ot_supervisor_hrs'
           ,ot_leader_prs = '$ot_leader_prs'
           ,ot_leader_hrs = '$ot_leader_hrs'
           ,ot_operator_prs = '$ot_operator_prs'
           ,ot_operator_hrs = '$ot_operator_hrs'
           ,ot_admin_prs = '$ot_admin_prs'
           ,ot_admin_hrs = '$ot_admin_hrs'
           ,ot_target = '$ot_target'
           ,ot_actual = '$ot_actual'
           ,ot_achieve = '$ot_achieve'
           ,ot_remark = '$ot_remark'
           ,per_receive_box = '$per_receive_box'
           
           ,per_damage_box = '$per_damage_box'
           ,per_receive_box_vmi = '$per_receive_box_vmi'
           
           ,per_damage_box_vmi = '$per_damage_box_vmi'
           ,qa_partinbox_cus = '$qa_partinbox_cus'
           ,qa_partinbox_ipack = '$qa_partinbox_ipack'
           ,qa_westbox_ipack = '$qa_westbox_ipack'
           ,qa_result = '$qa_result'
           ,issue_order_order = '$issue_order_order'
           ,issue_order_box = '$issue_order_box'
           ,issue_order_incomplete_order = '$issue_order_incomplete_order'
           ,issue_order_incomplete_box = '$issue_order_incomplete_box'
           ,issue_order_complete_order = '$issue_order_complete_order'
           ,issue_order_complete_box = '$issue_order_complete_box'
           ,issue_performance_order = '$issue_performance_order'
           ,issue_performance_box = '$issue_performance_box'
           ,issue_remark = '$issue_remark'
           ,issue_order_order_vmi = '$issue_order_order_vmi'
           ,issue_order_box_vmi = '$issue_order_box_vmi'
           ,issue_order_incomplete_order_vmi = '$issue_order_incomplete_order_vmi'
           ,issue_order_incomplete_box_vmi = '$issue_order_incomplete_box_vmi'
           ,issue_order_complete_order_vmi = '$issue_order_complete_order_vmi'
           ,issue_order_complete_box_vmi = '$issue_order_complete_box_vmi'
           ,issue_performance_order_vmi = '$issue_performance_order_vmi'
           ,issue_performance_box_vmi = '$issue_performance_box_vmi'
           ,issue_remark_vmi = '$issue_remark_vmi'
           ,report_by = '$admin_userid'
           ,report_by_date = '$date_time'
           ,approve_by = null
           ,approve_by_date = null,
		    order_packing=$order_packing,
			order_complete_packing=$order_complete_packing,
			order_delivery_packing=$order_delivery_packing,
			order_performance_packing=$order_performance_packing,
			order_packing_export=$order_packing_export,
			order_complete_packing_export=$order_complete_packing_export,
			order_delivery_packing_export=$order_delivery_packing_export,
			order_performance_packing_export=$order_performance_packing_export
      WHERE  workdate='$report_date' AND shift='$shift'";
      mssql_query($update);
    }


}else if($status=="approve_daily_report_tsc"){
    $report_date = date_format_uk_into_database($_POST["report_date"]);
    $shift = $_POST["shift"];
    $safety_human = $_POST["safety_human"];
    $safety_part = $_POST["safety_part"];
    $safety_nearmiss = $_POST["safety_nearmiss"];
    $safety_target = $_POST["safety_target"];
    $ss_daily = $_POST["ss_daily"];
    $ss_daily_status = $_POST["ss_daily_status"];
    $ss_daily_percent = $_POST["ss_daily_percent"];
    $att_asst_mgr = $_POST["att_asst_mgr"];
    $att_supervisor = $_POST["att_supervisor"];
    $att_leader = $_POST["att_leader"];
    $att_operator = $_POST["att_operator"];
    $att_admin = $_POST["att_admin"];
    $att_late = $_POST["att_late"];
    $att_forklift_name = lang_thai_into_database($_POST["att_forklift_name"]);
    $att_plan = $_POST["att_plan"];
    $att_total = $_POST["att_total"];
    $att_total_percent = $_POST["att_total_percent"];
    $att_achieve = $_POST["att_achieve"];
    $ot_asst_mgr_prs = $_POST["ot_asst_mgr_prs"];
    $ot_asst_mgr_hrs = $_POST["ot_asst_mgr_hrs"];
    $ot_supervisor_prs = $_POST["ot_supervisor_prs"];
    $ot_supervisor_hrs = $_POST["ot_supervisor_hrs"];
    $ot_leader_prs = $_POST["ot_leader_prs"];
    $ot_leader_hrs = $_POST["ot_leader_hrs"];
    $ot_operator_prs = $_POST["ot_operator_prs"];
    $ot_operator_hrs = $_POST["ot_operator_hrs"];
    $ot_admin_prs = $_POST["ot_admin_prs"];
    $ot_admin_hrs = $_POST["ot_admin_hrs"];
    $ot_target = $_POST["ot_target"];
    $ot_actual = $_POST["ot_actual"];
    $ot_achieve = $_POST["ot_achieve"];
    $ot_remark = $_POST["ot_remark"];
    $per_receive_box = $_POST["per_receive_box"];
    
    $per_damage_box = $_POST["per_damage_box"];
    
    $issue_order_order = $_POST["issue_order_order"];
    $issue_order_box = $_POST["issue_order_box"];
    $issue_order_incomplete_order = $_POST["issue_order_incomplete_order"];
    $issue_order_incomplete_box = $_POST["issue_order_incomplete_box"];
    $issue_order_complete_order = $_POST["issue_order_complete_order"];
    $issue_order_complete_box = $_POST["issue_order_complete_box"];
    $issue_performance_order = $_POST["issue_performance_order"];
    $issue_performance_box = $_POST["issue_performance_box"];
    $issue_remark = lang_thai_into_database($_POST["issue_remark"]);

    $qa_partinbox_cus = $_POST["qa_partinbox_cus"];
    $qa_partinbox_ipack = $_POST["qa_partinbox_ipack"];
    $qa_westbox_ipack = $_POST["qa_westbox_ipack"];
    $qa_result = $_POST["qa_result"];

    $per_receive_box_vmi = $_POST["per_receive_box_vmi"];
    
    $per_damage_box_vmi = $_POST["per_damage_box_vmi"];
    
    $issue_order_order_vmi = $_POST["issue_order_order_vmi"];
    $issue_order_box_vmi = $_POST["issue_order_box_vmi"];
    $issue_order_incomplete_order_vmi = $_POST["issue_order_incomplete_order_vmi"];
    $issue_order_incomplete_box_vmi = $_POST["issue_order_incomplete_box_vmi"];
    $issue_order_complete_order_vmi = $_POST["issue_order_complete_order_vmi"];
    $issue_order_complete_box_vmi = $_POST["issue_order_complete_box_vmi"];
    $issue_performance_order_vmi = $_POST["issue_performance_order_vmi"];
    $issue_performance_box_vmi = $_POST["issue_performance_box_vmi"];
    $issue_remark_vmi = lang_thai_into_database($_POST["issue_remark_vmi"]);
	
	
	$order_packing= $_POST["order_packing"];
	$order_complete_packing= $_POST["order_complete_packing"];
	$order_delivery_packing= $_POST["order_delivery_packing"];
	$order_performance_packing= $_POST["order_performance_packing"];
	
	$order_packing_export= $_POST["order_packing_export"];
	$order_complete_packing_export= $_POST["order_complete_packing_export"];
	$order_delivery_packing_export= $_POST["order_delivery_packing_export"];
	$order_performance_packing_export= $_POST["order_performance_packing_export"];

    $update = "UPDATE tbdaily_report_tsc
        SET safety_human = '$safety_human'
        ,safety_part = '$safety_part'
        ,safety_nearmiss = '$safety_nearmiss'
        ,safety_target = '$safety_target'
        ,ss_daily = '$ss_daily'
        ,ss_daily_status = '$ss_daily_status'
        ,ss_daily_percent = '$ss_daily_percent'
        ,att_asst_mgr = '$att_asst_mgr'
        ,att_supervisor = '$att_supervisor'
        ,att_leader = '$att_leader'
        ,att_operator = '$att_operator'
        ,att_admin = '$att_admin'
        ,att_late = '$att_late'
        ,att_forklift_name = '$att_forklift_name'
        ,att_plan = '$att_plan'
        ,att_total = '$att_total'
        ,att_total_percent = '$att_total_percent'
        ,att_achieve = '$att_achieve'
        ,ot_asst_mgr_prs = '$ot_asst_mgr_prs'
        ,ot_asst_mgr_hrs = '$ot_asst_mgr_hrs'
        ,ot_supervisor_prs = '$ot_supervisor_prs'
        ,ot_supervisor_hrs = '$ot_supervisor_hrs'
        ,ot_leader_prs = '$ot_leader_prs'
        ,ot_leader_hrs = '$ot_leader_hrs'
        ,ot_operator_prs = '$ot_operator_prs'
        ,ot_operator_hrs = '$ot_operator_hrs'
        ,ot_admin_prs = '$ot_admin_prs'
        ,ot_admin_hrs = '$ot_admin_hrs'
        ,ot_target = '$ot_target'
        ,ot_actual = '$ot_actual'
        ,ot_achieve = '$ot_achieve'
        ,ot_remark = '$ot_remark'
        ,per_receive_box = '$per_receive_box'
        ,per_damage_box = '$per_damage_box'
        ,per_receive_box_vmi = '$per_receive_box_vmi'
        ,per_damage_box_vmi = '$per_damage_box_vmi'
        ,qa_partinbox_cus = '$qa_partinbox_cus'
        ,qa_partinbox_ipack = '$qa_partinbox_ipack'
        ,qa_westbox_ipack = '$qa_westbox_ipack'
        ,qa_result = '$qa_result'
        ,issue_order_order = '$issue_order_order'
        ,issue_order_box = '$issue_order_box'
        ,issue_order_incomplete_order = '$issue_order_incomplete_order'
        ,issue_order_incomplete_box = '$issue_order_incomplete_box'
        ,issue_order_complete_order = '$issue_order_complete_order'
        ,issue_order_complete_box = '$issue_order_complete_box'
        ,issue_performance_order = '$issue_performance_order'
        ,issue_performance_box = '$issue_performance_box'
        ,issue_remark = '$issue_remark'
        ,issue_order_order_vmi = '$issue_order_order_vmi'
        ,issue_order_box_vmi = '$issue_order_box_vmi'
        ,issue_order_incomplete_order_vmi = '$issue_order_incomplete_order_vmi'
        ,issue_order_incomplete_box_vmi = '$issue_order_incomplete_box_vmi'
        ,issue_order_complete_order_vmi = '$issue_order_complete_order_vmi'
        ,issue_order_complete_box_vmi = '$issue_order_complete_box_vmi'
        ,issue_performance_order_vmi = '$issue_performance_order_vmi'
        ,issue_performance_box_vmi = '$issue_performance_box_vmi'
        ,issue_remark_vmi = '$issue_remark_vmi'
        ,approve_by = '$admin_userid'
        ,approve_by_date = '$date_time',
		    order_packing=$order_packing,
			order_complete_packing=$order_complete_packing,
			order_delivery_packing=$order_delivery_packing,
			order_performance_packing=$order_performance_packing,
			order_packing_export=$order_packing_export,
			order_complete_packing_export=$order_complete_packing_export,
			order_delivery_packing_export=$order_delivery_packing_export,
			order_performance_packing_export=$order_performance_packing_export 
    WHERE  workdate='$report_date' AND shift='$shift'";
    mssql_query($update);

    $report_date_show = ($_POST["report_date"]);
    $arr_date = explode("/",$report_date_show);
	$date_format = $arr_date[1]."/".$arr_date[0]."/".$arr_date[2];

    $html = "Dear Team <br>";		
    $html .= "Daily report TSC $report_date_show";
    $html .= "<BR>Shift $shift";
    $html .= "<BR> Approve by ".get_full_name($admin_userid);
    $html .= "<br/><br/>สามารถเข้าตรวจสอบได้ที่ : http://www.ipack-iwis.com/hrs/daily_report_tsc.php?yyear=$arr_date[2]&mmonth=$arr_date[1]&ddate=$arr_date[0]&tsite=TSC";

    require 'PHPMailer/PHPMailerAutoload.php';

    $mail = new PHPMailer(); // create a new object
    $mail->IsSMTP(); // enable SMTP
    //$mail->SMTPDebug = 2; // debugging: 1 = errors and messages, 2 = messages only
    $mail->SMTPAuth = true; // authentication enabled
    $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
    $mail->Host = "smtp.gmail.com";
    $mail->CharSet = "utf-8";
    $mail->Port = 465; // or 587
    $mail->IsHTML(true);
    $mail->Username = "ipackiwis@gmail.com";
    $mail->Password = "ipack@@@@2017";
    $mail->SetFrom("ipackiwis@gmail.com");
    $mail->Subject = "[I-WIS SYSTEM] TSC Daily report $report_date_show shift $shift";
    
    $mail->Body = $html;

    $mail->IsHTML(true); 

    $mail->AddAddress("ipack@ipacklogistics.com");
    $mail->AddAddress("ipack-logistics@live.com");
    $mail->AddAddress("pongthorn.w@ipacklogistics.com");
    $mail->AddCC("panyadanai.k@ipacklogistics.com");
    $mail->AddCC("suriya.s@ipacklogistics.com");

    $mail->AddCC("thanatwat.m@ipacklogistics.com");
    //$mail->AddAddress("nakarin.j@ipacklogistics.com");
    // $mail->AddCC("nakarin.j@ipacklogistics.com");
    $mail->Send();

}else if($status=="show_att"){
    $report_date = date_format_uk_into_database($_POST["report_date"]);
    $report_date_show = ($_POST["report_date"]);
    ?>
    <h4>วันที่ : <?=$report_date_show?></h4>
    <h5>Shift : Day</h5>
    <div class="table-responsive">   
        <table class="table table-bordered table-striped">
            <tr>
                <th width='20px'>ลำดับ</th>
                <th width='150px'>ตำแหน่ง</th>
                <th width='180px'>ชื่อ - นามสกุล</th>
                <th width='50px'>กะ</th>
                <th width='80px'>เวลาเข้างาน</th>
                <th width='80px'>เวลาออกงาน</th>
            </tr>
        <?
        $sql = "SELECT    *
        FROM            tbemployee
        WHERE        (departmentid = 'D008') AND (display_att='1' )
        ORDER BY emp_level desc";
        $sql = "SELECT    empno
        ,firstname
        ,lastname
        ,positionid
        ,(SELECT top 1 shift FROM tbot_mng WHERE tbot_mng.workdate='$report_date' AND empno=tbemployee.empno) as shift
        FROM            tbemployee
        WHERE        (departmentid = 'D003') AND (display_att='1' )
        AND ((SELECT top 1 shift FROM tbot_mng WHERE tbot_mng.workdate='$report_date' AND empno=tbemployee.empno)='Day' or (SELECT top 1 shift FROM tbot_mng WHERE tbot_mng.workdate='$report_date' AND empno=tbemployee.empno) is NULL)
        ORDER BY emp_level desc";
        $res = mssql_query($sql);
        $no=0;
        while($row = mssql_fetch_array($res)){
            $empno = ($row["empno"]);
            $firstname = lang_thai_from_database($row["firstname"]);
            $lastname = lang_thai_from_database($row["lastname"]);
            $positionname = get_positionname($row["positionid"]);
            $shift = ($row["shift"]);
            $no++;

            $sql_att = "SELECT shift,convert(varchar, attDateTime,103)as attDateTime_date
            ,convert(varchar, attDateTime,108)as attDateTime_time
            FROM tbatt
            WHERE empno='$empno'
            AND att_status='in' 
            AND shift='Day' 
            and att_real_date='$report_date'";
            $res_att = mssql_query($sql_att);
            $row_att = mssql_fetch_array($res_att);
            $attDateTime_time = $row_att["attDateTime_time"];

            $sql_att_out = "SELECT shift,convert(varchar, attDateTime,103)as attDateTime_date
                ,convert(varchar, attDateTime,108)as attDateTime_time
                FROM tbatt
                WHERE empno='$empno'
                AND att_status='out' 
                AND shift='Day'
                and att_real_date='$report_date'";
                // echo $sql_att_out;
            $res_att_out = mssql_query($sql_att_out);
            $row_att_out = mssql_fetch_array($res_att_out);
            $attDateTime_time_out = $row_att_out["attDateTime_time"];
            ?>
            <tr>
                <td><?=$no?></td>
                <td><?=$positionname?></td>
                <td><?=$firstname?> <?=$lastname?></td>
                <td>Day</td>
                <td><?=$attDateTime_time?></td>
                <td><?=$attDateTime_time_out?></td>
            </tr>
            <?

        }
        ?>
        </table>
    </div>
    <h5>Shift : Night</h5>
    <div class="table-responsive">   
        <table class="table table-bordered table-striped">
            <tr>
                <th width='20px'>ลำดับ</th>
                <th width='150px'>ตำแหน่ง</th>
                <th width='180px'>ชื่อ - นามสกุล</th>
                <th width='50px'>กะ</th>
                <th width='80px'>เวลาเข้างาน</th>
                <th width='80px'>เวลาออกงาน</th>
            </tr>
        <?
        $sql = "SELECT    empno
        ,firstname
        ,lastname
        ,positionid
        ,(SELECT top 1 shift FROM tbot_mng WHERE tbot_mng.workdate='$report_date' AND empno=tbemployee.empno) as shift
        FROM            tbemployee
        WHERE        (departmentid = 'D003') AND (display_att='1' )
        AND (SELECT top 1 shift FROM tbot_mng WHERE tbot_mng.workdate='$report_date' AND empno=tbemployee.empno)='Night' 
        ORDER BY emp_level desc";
        $res = mssql_query($sql);
        $no=0;
        while($row = mssql_fetch_array($res)){
            $empno = ($row["empno"]);
            $firstname = lang_thai_from_database($row["firstname"]);
            $lastname = lang_thai_from_database($row["lastname"]);
            $positionname = get_positionname($row["positionid"]);
            $shift = ($row["shift"]);
            $no++;

            $sql_att = "SELECT shift,convert(varchar, attDateTime,103)as attDateTime_date
            ,convert(varchar, attDateTime,108)as attDateTime_time
            FROM tbatt
            WHERE empno='$empno'
            AND att_status='in' 
            AND shift='Night' 
            and att_real_date='$report_date'";
            $res_att = mssql_query($sql_att);
            $row_att = mssql_fetch_array($res_att);
            $attDateTime_time = $row_att["attDateTime_time"];

            $sql_att_out = "SELECT shift,convert(varchar, attDateTime,103)as attDateTime_date
                ,convert(varchar, attDateTime,108)as attDateTime_time
                FROM tbatt
                WHERE empno='$empno'
                AND att_status='out' 
                AND shift='Night'
                and att_real_date='$report_date'";
            $res_att_out = mssql_query($sql_att_out);
            $row_att_out = mssql_fetch_array($res_att_out);
            $attDateTime_time_out = $row_att_out["attDateTime_time"];
            ?>
            <tr>
                <td><?=$no?></td>
                <td><?=$positionname?></td>
                <td><?=$firstname?> <?=$lastname?></td>
                <td>Night</td>
                <td><?=$attDateTime_time?></td>
                <td><?=$attDateTime_time_out?></td>
            </tr>
            <?

        }
        ?>
        </table>
    </div>
    
    <?
}else if($status=="show_ot"){
    $report_date = date_format_uk_into_database($_POST["report_date"]);
    $report_date_show = ($_POST["report_date"]);
    ?>
    <h4>วันที่ : <?=$report_date_show?></h4>
    <h5>Shift : Day</h5>
    <div class="table-responsive">   
        <table class="table table-bordered table-striped">
            <tr>
                <th width='20px'>ลำดับ</th>
                <th width='150px'>ตำแหน่ง</th>
                <th width='180px'>ชื่อ - นามสกุล</th>
                <th width='50px'>กะ</th>
                <th width='80px'>เริ่ม OT</th>
                <th width='80px'>สิ้นสุด OT</th>
            </tr>

            <?
            $sql = "SELECT    empno
            ,firstname
            ,lastname
            ,positionid
            ,emp_level
            ,(SELECT top 1 shift FROM tbot_mng WHERE tbot_mng.workdate='$report_date' AND empno=tbemployee.empno) as shift
            FROM            tbemployee
            WHERE        (departmentid = 'D003') AND (display_att='1' )
            AND ((SELECT top 1 shift FROM tbot_mng WHERE tbot_mng.workdate='$report_date' AND empno=tbemployee.empno)='Day' or (SELECT top 1 shift FROM tbot_mng WHERE tbot_mng.workdate='$report_date' AND empno=tbemployee.empno) is NULL)
            ORDER BY emp_level desc";
            $res = mssql_query($sql);
            $no=0;
            while($row = mssql_fetch_array($res)){
                $empno = ($row["empno"]);
                $emp_level_select = ($row["emp_level"]);
                $firstname = lang_thai_from_database($row["firstname"]);
                $lastname = lang_thai_from_database($row["lastname"]);
                $positionname = get_positionname($row["positionid"]);
                $no++;
    
                // $sql_att_in = "SELECT shift,convert(varchar, attDateTime,103)as attDateTime_date
                // ,convert(varchar, attDateTime,108)as attDateTime_time
                // FROM tbatt
                // WHERE empno='$empno'
                // AND att_status='in' 
                // and att_real_date='$report_date'";
                // $res_att_in = mssql_query($sql_att_in);
                // $row_att_in = mssql_fetch_array($res_att_in);
                // $shift = $row_att_in["shift"];
                // $attDateTime_time_in = $row_att_in["attDateTime_time"];
                $attDateTime_time_in ="";
                $attDateTime_time_out ="";
                if($emp_level_select<=3){
                    $sql_att_ot = "SELECT start_time_approve,end_time_approve FROM tbot_request 
                        WHERE empno='$empno' 
                        AND status_ot='O'
                        and date_ot='$report_date' ";
                    $res_att_ot = mssql_query($sql_att_ot);
                    $num_att_ot = mssql_num_rows($res_att_ot);
                    if($num_att_ot>0){
                        $row_att_ot = mssql_fetch_array($res_att_ot);
                        $attDateTime_time_in = $row_att_ot["start_time_approve"].":00";
                        $attDateTime_time_out = $row_att_ot["end_time_approve"].":00";
                    }
                    // else{
                    //     $sql_att_out = "SELECT shift,convert(varchar, attDateTime,103)as attDateTime_date
                    //         ,convert(varchar, attDateTime,108)as attDateTime_time
                    //         FROM tbatt
                    //         WHERE empno='$empno'
                    //         AND att_status='out' 
                    //         and att_real_date='$report_date'";
                    //     $res_att_out = mssql_query($sql_att_out);
                    //     $row_att_out = mssql_fetch_array($res_att_out);
                    //     $attDateTime_time_out = $row_att_out["attDateTime_time"];
                    // }
                }else{
                    $sql_att_in = "SELECT shift,convert(varchar, attDateTime,103)as attDateTime_date
                        ,convert(varchar, attDateTime,108)as attDateTime_time
                        FROM tbatt
                        WHERE empno='$empno'
                        AND att_status='in' 
                        and att_real_date='$report_date'";
                    $res_att_in = mssql_query($sql_att_in);
                    $row_att_in = mssql_fetch_array($res_att_in);
                    $shift = $row_att_in["shift"];
                    $attDateTime_time_in = $row_att_in["attDateTime_time"];

                    $sql_att_out = "SELECT shift,convert(varchar, attDateTime,103)as attDateTime_date
                        ,convert(varchar, attDateTime,108)as attDateTime_time
                        FROM tbatt
                        WHERE empno='$empno'
                        AND att_status='out' 
                        and att_real_date='$report_date'";
                    $res_att_out = mssql_query($sql_att_out);
                    $row_att_out = mssql_fetch_array($res_att_out);
                    $attDateTime_time_out = $row_att_out["attDateTime_time"];
                    
                }
                ?>
                <tr>
                    <td><?=$no?></td>
                    <td><?=$positionname?></td>
                    <td><?=$firstname?> <?=$lastname?></td>
                    <td>Day</td>
                    <td><?=$attDateTime_time_in?></td>
                    <td><?=$attDateTime_time_out?></td>
                </tr>
                <?


            }
            ?>
        </table>
    </div>
    <h5>Shift : Night</h5>
    <div class="table-responsive">   
        <table class="table table-bordered table-striped">
            <tr>
                <th width='20px'>ลำดับ</th>
                <th width='150px'>ตำแหน่ง</th>
                <th width='180px'>ชื่อ - นามสกุล</th>
                <th width='50px'>กะ</th>
                <th width='80px'>เริ่ม OT</th>
                <th width='80px'>สิ้นสุด OT</th>
            </tr>

            <?
            $sql = "SELECT    empno
            ,firstname
            ,lastname
            ,positionid
            ,emp_level
            ,(SELECT top 1 shift FROM tbot_mng WHERE tbot_mng.workdate='$report_date' AND empno=tbemployee.empno) as shift
            FROM            tbemployee
            WHERE        (departmentid = 'D003') AND (display_att='1' )
            AND (SELECT top 1 shift FROM tbot_mng WHERE tbot_mng.workdate='$report_date' AND empno=tbemployee.empno)='Night'
            ORDER BY emp_level desc";
            $res = mssql_query($sql);
            $no=0;
            while($row = mssql_fetch_array($res)){
                $empno = ($row["empno"]);
                $emp_level_select = ($row["emp_level"]);
                $firstname = lang_thai_from_database($row["firstname"]);
                $lastname = lang_thai_from_database($row["lastname"]);
                $positionname = get_positionname($row["positionid"]);
                $no++;
    
                // $sql_att_in = "SELECT shift,convert(varchar, attDateTime,103)as attDateTime_date
                // ,convert(varchar, attDateTime,108)as attDateTime_time
                // FROM tbatt
                // WHERE empno='$empno'
                // AND att_status='in' 
                // and att_real_date='$report_date'";
                // $res_att_in = mssql_query($sql_att_in);
                // $row_att_in = mssql_fetch_array($res_att_in);
                // $shift = $row_att_in["shift"];
                // $attDateTime_time_in = $row_att_in["attDateTime_time"];
                $attDateTime_time_in ="";
                $attDateTime_time_out ="";
                if($emp_level_select<=3){
                    $sql_att_ot = "SELECT start_time_approve,end_time_approve FROM tbot_request 
                        WHERE empno='$empno' 
                        AND status_ot='O'
                        and date_ot='$report_date' ";
                    $res_att_ot = mssql_query($sql_att_ot);
                    $num_att_ot = mssql_num_rows($res_att_ot);
                    if($num_att_ot>0){
                        $row_att_ot = mssql_fetch_array($res_att_ot);
                        $attDateTime_time_in = $row_att_ot["start_time_approve"].":00";
                        $attDateTime_time_out = $row_att_ot["end_time_approve"].":00";
                    }
                    // else{
                    //     $sql_att_out = "SELECT shift,convert(varchar, attDateTime,103)as attDateTime_date
                    //         ,convert(varchar, attDateTime,108)as attDateTime_time
                    //         FROM tbatt
                    //         WHERE empno='$empno'
                    //         AND att_status='out' 
                    //         and att_real_date='$report_date'";
                    //     $res_att_out = mssql_query($sql_att_out);
                    //     $row_att_out = mssql_fetch_array($res_att_out);
                    //     $attDateTime_time_out = $row_att_out["attDateTime_time"];
                    // }
                }else{
                    $sql_att_in = "SELECT shift,convert(varchar, attDateTime,103)as attDateTime_date
                    ,convert(varchar, attDateTime,108)as attDateTime_time
                    FROM tbatt
                    WHERE empno='$empno'
                    AND att_status='in' 
                    and att_real_date='$report_date'";
                    $res_att_in = mssql_query($sql_att_in);
                    $row_att_in = mssql_fetch_array($res_att_in);
                    $shift = $row_att_in["shift"];
                    $attDateTime_time_in = $row_att_in["attDateTime_time"];

                    $sql_att_out = "SELECT shift,convert(varchar, attDateTime,103)as attDateTime_date
                    ,convert(varchar, attDateTime,108)as attDateTime_time
                    FROM tbatt
                    WHERE empno='$empno'
                    AND att_status='out' 
                    and att_real_date='$report_date'";
                    $res_att_out = mssql_query($sql_att_out);
                    $row_att_out = mssql_fetch_array($res_att_out);
                    $attDateTime_time_out = $row_att_out["attDateTime_time"];
                    
                }
                ?>
                <tr>
                    <td><?=$no?></td>
                    <td><?=$positionname?></td>
                    <td><?=$firstname?> <?=$lastname?></td>
                    <td>Night</td>
                    <td><?=$attDateTime_time_in?></td>
                    <td><?=$attDateTime_time_out?></td>
                </tr>
                <?


            }
            ?>
        </table>
    </div>
    <?
    
}else if ($status=="show_receive_box"){
    $report_date = date_format_uk_into_database($_POST["report_date"]);
    $report_date_dmy = ($_POST["report_date"]);
    $shift = ($_POST["shift"]);

    if($shift=="Day"){
        $report_start_date = $report_date." 08:00:00";
        $report_end_date = $report_date." 19:59:59";
        $report_start_date_dmy = $report_date_dmy." 08:00:00";
        $report_end_date_dmy = $report_date_dmy." 19:59:59";
    }else if($shift=="Night"){
        $report_start_date = $report_date." 20:00:00";
        $report_end_date = date("m/d/Y", strtotime($report_date." +1 days"))." 07:59:59";
        
        $report_start_date_dmy = $report_date_dmy." 20:00:00";
        $report_end_date_dmy = date("d/m/Y", strtotime($report_date." +1 days"))." 07:59:59";
        
    }

    ?>
    <h4>Receive วันที่ : <?=$report_start_date_dmy?> - <?=$report_end_date_dmy?></h4>
    <h5>Shift : <?=$shift?></h5>
    <div class="table-responsive">   
        <table class="table table-bordered table-striped">
            <tr>
                <th>ลำดับ</th>
                <th>Code Box</th>
                <th>Barcode</th>
                <th>Truck No.</th>
                <th>Return Form</th>
                <th>Date</th>

            </tr>

            <?  
            include "connect_tsc.php";
            $sql = "SELECT barcode_number,codebox_ipack,truckno,returnfrom,oem_returnnumber,convert(varchar, returndate,103)as returndate_date,convert(varchar, returndate,108)as returndate_time
            FROM returnbox 
            WHERE returndate between '$report_start_date' AND '$report_end_date'
            and ordernumber_sub in (select ordernumber_sub from issuebox)
            order by returndate
            ";
            $no = 0;
            $res = mssql_query($sql);
            while($row = mssql_fetch_array($res)){
                $qty_return = $row["qty_return"];
                $codebox_ipack = $row["codebox_ipack"];
                $barcode_number = $row["barcode_number"];
                $truckno = $row["truckno"];
                $returnfrom = $row["returnfrom"];
                $oem_returnnumber = $row["oem_returnnumber"];
                $returndate = $row["returndate_date"]." ".$row["returndate_time"];
                $no++;
                
                ?>
                <tr>
                    <td><?=$no?></td>
                    <td><?=$codebox_ipack?></td>
                    <td><?=$barcode_number?></td>
                    <td><?=$truckno?></td>
                    <td><?=$returnfrom?></td>
                    <td><?=$returndate?></td>
                </tr>
                <?
            }
            ?>
        </table>
    </div>

    <?
}else if ($status=="show_hold_box"){
    $report_date = date_format_uk_into_database($_POST["report_date"]);
    $report_date_show = ($_POST["report_date"]);
    ?>
    <h4>Hold วันที่ : <?=$report_date_show?></h4>
    <div class="table-responsive">   
        
    </div>

    <?
}else if ($status=="show_damage_box"){
    $report_date = date_format_uk_into_database($_POST["report_date"]);
    $report_date_dmy = ($_POST["report_date"]);
    // $shift = ($_POST["shift"]);

    $report_start_date = $report_date." 08:00:00";
    $report_start_date_dmy = $report_date_dmy." 08:00:00";

    $report_end_date = date("m/d/Y", strtotime($report_date." +1 days"))." 07:59:59";
    $report_end_date_dmy = date("d/m/Y", strtotime($report_date." +1 days"))." 07:59:59";
        
    ?>
    <h4>Damage วันที่ : <?=$report_start_date_dmy?> - <?=$report_end_date_dmy?></h4>
    <div class="table-responsive">   
        <table class="table table-bordered table-striped">
            <tr>
                <th>ลำดับ</th>
                <th>Return No.</th>
                <th>Code Box</th>
                <th>Barcode No.</th>
                <th>Return Form</th>
                <th>Date</th>
            </tr>

            <?
            include "connect_tsc.php";
            $sql = "SELECT *
            ,convert(varchar, create_date,103)as create_date_date
            ,convert(varchar, create_date,108)as create_date_time
             FROM returnbox_damage WHERE create_date between '$report_start_date' AND '$report_end_date' order by create_date";
            $res = mssql_query($sql);
            $no=0;
            while($row = mssql_fetch_array($res)){
                $returnnumber = $row["returnnumber"];
                $codebox_ipack = $row["codebox_ipack"];
                $barcode_number = $row["barcode_number"];
                $returnfrom = $row["returnfrom"];
                $create_date = $row["create_date_date"]." ".$row["create_date_time"];
                $no++;
                ?>
                <tr>
                    <td><?=$no?></td>
                    <td><?=$returnnumber?></td>
                    <td><?=$codebox_ipack?></td>
                    <td><?=$barcode_number?></td>
                    <td><?=$returnfrom?></td>
                    <td><?=$create_date?></td>
                </tr>
                <?
            }
            ?>
        </table>
    </div>

    <?
}else if ($status=="show_issue_order"){
    $report_date = date_format_uk_into_database($_POST["report_date"]);
    $report_date_dmy = ($_POST["report_date"]);
    $shift = ($_POST["shift"]);

    if($shift=="Day"){
        $report_start_date = $report_date." 08:00:00";
        $report_end_date = $report_date." 19:59:59";

        $report_start_date_dmy = $report_date_dmy." 08:00:00";
        $report_end_date_dmy = $report_date_dmy." 19:59:59";
    }else if($shift=="Night"){
        $report_start_date = $report_date." 20:00:00";
        $report_end_date = date("m/d/Y", strtotime($report_date." +1 days"))." 07:59:59";
        
        $report_start_date_dmy = $report_date_dmy." 20:00:00";
        $report_end_date_dmy = date("d/m/Y", strtotime($report_date." +1 days"))." 07:59:59";
        
    }

    ?>
    <h4>วันที่ : <?=$report_start_date_dmy?> - <?=$report_end_date_dmy?></h4>
    <h5>Shift : <?=$shift?></h5>
    <div class="table-responsive">   
        <table class="table table-bordered table-striped">
            <tr>
                <th>ลำดับ</th>
                <th>Order No.</th>
                <th>Code Box</th>
                <th>Qty</th>
                <th>Appointment date</th>
                <th>Receive date</th>
            </tr>

            <?
            include "connect_tsc.php";
            $sql = "SELECT *
            ,convert(varchar, appointment_time1,103)as appointment_time1_date
            ,convert(varchar, appointment_time1,108)as appointment_time1_time
            ,convert(varchar, customer_received_date,103)as customer_received_date_date
            ,convert(varchar, customer_received_date,108)as customer_received_date_time
             FROM tbpickupsheet WHERE appointment_time1 between '$report_start_date' AND '$report_end_date' AND cancel is null
             order by appointment_time1";
            $res = mssql_query($sql);
            $no=0;
            // echo $sql;
            while($row = mssql_fetch_array($res)){
                $ordernumber_sub = $row["ordernumber_sub"];
                $codebox_ipack = $row["codebox_ipack"];
                $qty = $row["qty"];
                $appointment_time1 = $row["appointment_time1_date"]." ".$row["appointment_time1_time"];
                $customer_received_date = $row["customer_received_date_date"]." ".$row["customer_received_date_time"];
                
                $no++;

                $sql_receive = "SELECT count(DISTINCT ordernumber_sub) as issue_order_complete_order FROM issuebox 
                WHERE convert(varchar, customer_received_date, 101) = '$report_date' 
                AND ordernumber_sub in (SELECT ordernumber_sub FROM tbpickupsheet WHERE convert(varchar, appointment_time1, 101) = '$report_date' AND cancel is null)";
                // $res_receive = mssql_query($sql_receive);
                ?>
                <tr>
                    <td><?=$no?></td>
                    <td><?=$ordernumber_sub?></td>
                    <td><?=$codebox_ipack?></td>
                    <td align="center"><?=$qty?></td>
                    <td><?=$appointment_time1?></td>
                    <td><?=$customer_received_date?></td>
                </tr>
                <?
            }
            ?>
        </table>
    </div>

    
    <?
}else if ($status=="show_partinbox_cus"){
    $report_date = date_format_uk_into_database($_POST["report_date"]);
    $report_date_dmy = ($_POST["report_date"]);
    // $shift = ($_POST["shift"]);

    $report_start_date = $report_date." 08:00:00";
    $report_start_date_dmy = $report_date_dmy." 08:00:00";

    $report_end_date = date("m/d/Y", strtotime($report_date." +1 days"))." 07:59:59";
    $report_end_date_dmy = date("d/m/Y", strtotime($report_date." +1 days"))." 07:59:59";
        
    ?>
    <h4>วันที่ : <?=$report_start_date_dmy?> - <?=$report_end_date_dmy?></h4>
    <div class="table-responsive">   
        <table class="table table-bordered table-striped">
            <tr>
                <th>ลำดับ</th>
                <th>Return No.</th>
                <th>Part</th>
                <th>Barcode No.</th>
                <th>Return Form</th>
                <th>Date</th>
            </tr>

            <?
            include "connect_tsc.php";
            $sql = "SELECT *,convert(varchar, create_date,103)as create_date_date
            ,convert(varchar, create_date,108)as create_date_time
             FROM returnbox_partjam WHERE create_date between '$report_start_date' AND '$report_end_date' order by create_date";
            $res = mssql_query($sql);
            $no=0;
            while($row = mssql_fetch_array($res)){
                $returnnumber = $row["returnnumber"];
                $part_no = $row["part_no"];
                $barcode_number = $row["barcode_number"];
                $returnfrom = $row["returnfrom"];
                $create_date = $row["create_date_date"]." ".$row["create_date_time"];
                $no++;
                ?>
                <tr>
                    <td><?=$no?></td>
                    <td><?=$returnnumber?></td>
                    <td><?=$part_no?></td>
                    <td><?=$barcode_number?></td>
                    <td><?=$returnfrom?></td>
                    <td><?=$create_date?></td>
                </tr>
                <?
            }
            ?>
        </table>
    </div>

    <?
    
}else if ($status=="show_receive_box_vmi"){
    $report_date = date_format_uk_into_database($_POST["report_date"]);
    $report_date_dmy = ($_POST["report_date"]);
    // $shift = ($_POST["shift"]);

    $report_start_date = $report_date." 08:00:00";
    $report_start_date_dmy = $report_date_dmy." 08:00:00";

    $report_end_date = date("m/d/Y", strtotime($report_date." +1 days"))." 07:59:59";
    $report_end_date_dmy = date("d/m/Y", strtotime($report_date." +1 days"))." 07:59:59";
        
    ?>
    <h4>Receive วันที่ : <?=$report_start_date_dmy?> - <?=$report_end_date_dmy?></h4>
    <div class="table-responsive">   
        <table class="table table-bordered table-striped">
            <tr>
                <th>ลำดับ</th>
                <th>Job Id</th>
                <th>PO No</th>
                <th>Material</th>
                <th>Qty</th>
                <th>Unit</th>
                <th>Date</th>
            </tr>

            <?  
            include "connect_inv.php";
            $sql = "SELECT *
            ,convert(varchar, receive_date,103)as receive_date_date
            ,convert(varchar, receive_date,108)as receive_date_time 
            FROM tbvmi_supplier_delivery_scheduling_receive 
            WHERE receive_date between '$report_start_date' AND '$report_end_date' 
            AND job_id in (SELECT job_id FROM tbvmi_supplier_delivery_scheduling WHERE customer_po='VMI TSC')
            order by receive_date
            ";
            $no = 0;
            $res = mssql_query($sql);
            while($row = mssql_fetch_array($res)){
                $job_id = $row["job_id"];
                $po_no = $row["po_no"];
                $mat_code = $row["mat_code"];
                $job_receive = $row["job_receive"];
                $receive_date = $row["receive_date_date"]." ".$row["receive_date_time"];

                $sql_mat = "SELECT mat_name,mat_unit FROM material WHERE mat_code='$mat_code'";
                $res_mat = mssql_query($sql_mat);
                $row_mat = mssql_fetch_array($res_mat);
                $mat_name = lang_thai_from_database($row_mat["mat_name"]);
                $mat_unit = lang_thai_from_database($row_mat["mat_unit"]);
                $no++;
                
                ?>
                <tr>
                    <td><?=$no?></td>
                    <td><?=$job_id?></td>
                    <td><?=$po_no?></td>
                    <td><?=$mat_name?> (<?=$mat_code?>)</td>
                    <td><?=$job_receive?></td>
                    <td><?=$mat_unit?></td>
                    <td><?=$receive_date?></td>
                </tr>
                <?
            }
            ?>
        </table>
    </div>

    <?
}else if ($status=="show_hold_box_vmi"){
    $report_date = date_format_uk_into_database($_POST["report_date"]);
    $report_date_show = ($_POST["report_date"]);
    ?>
    <h4>Hold วันที่ : <?=$report_date_show?></h4>
    <div class="table-responsive">   
        
    </div>

    <?
}else if ($status=="show_damage_box_vmi"){
    $report_date = date_format_uk_into_database($_POST["report_date"]);
    $report_date_dmy = ($_POST["report_date"]);
    // $shift = ($_POST["shift"]);

    $report_start_date = $report_date." 08:00:00";
    $report_start_date_dmy = $report_date_dmy." 08:00:00";

    $report_end_date = date("m/d/Y", strtotime($report_date." +1 days"))." 07:59:59";
    $report_end_date_dmy = date("d/m/Y", strtotime($report_date." +1 days"))." 07:59:59";
        
    ?>
    <h4>Damage วันที่ : <?=$report_start_date_dmy?> - <?=$report_end_date_dmy?></h4>
    <div class="table-responsive">   
        <table class="table table-bordered table-striped">
            <tr>
                <th>ลำดับ</th>
                <th>NG No.</th>
                <th>Part</th>
                <th>Q'ty</th>
                <th>Date</th>
            </tr>

            <?
            include "connect_inv.php";
            $sql = "SELECT *,convert(varchar, create_date,103)as create_date_date
            ,convert(varchar, create_date,108)as create_date_time
             FROM tbvmi_ng 
             WHERE create_date between '$report_start_date' AND '$report_end_date' 
             order by create_date";
            $res = mssql_query($sql);
            $no=0;
            while($row = mssql_fetch_array($res)){
                $ng_id = $row["ng_id"];
                $code_number = $row["code_number"];
                $ng_qty = $row["ng_qty"];
                $create_date = $row["create_date_date"]." ".$row["create_date_time"];

                $sql_master = "SELECT * FROM tbvmi_part_master WHERE vmi_number='$code_number'";
                $res_master = mssql_query($sql_master);
                $row_master = mssql_fetch_array($res_master);
                $Material = lang_thai_from_database($row_master["Material"]);

                $no++;
                ?>
                <tr>
                    <td><?=$no?></td>
                    <td><?=$ng_id?></td>
                    <td><?=$Material?></td>
                    <td><?=$ng_qty?></td>
                    <td><?=$create_date?></td>
                </tr>
                <?
            }
            ?>
        </table>
    </div>

    <?
}else if ($status=="show_issue_order_vmi"){
    $report_date = date_format_uk_into_database($_POST["report_date"]);
    $report_date_dmy = ($_POST["report_date"]);
    // $shift = ($_POST["shift"]);

    $report_start_date = $report_date." 08:00:00";
    $report_start_date_dmy = $report_date_dmy." 08:00:00";

    $report_end_date = date("m/d/Y", strtotime($report_date." +1 days"))." 07:59:59";
    $report_end_date_dmy = date("d/m/Y", strtotime($report_date." +1 days"))." 07:59:59";
    ?>
    <h4>วันที่ : <?=$report_start_date_dmy?> - <?=$report_end_date_dmy?></h4>
    <div class="table-responsive">   
        <table class="table table-bordered table-striped">
            <tr>
                <th>ลำดับ</th>
                <th>Order No.</th>
                <th>Part</th>
                <th>Qty</th>
                <th>Qty Issue</th>
                <th>Unit</th>
                <th>Appointment date</th>
                <th>Receive date</th>
            </tr>

            <?
            include "connect_inv.php";
            $sql = "SELECT DISTINCT order_number,appointment_date FROM tbvmi_order 
            WHERE appointment_date between '$report_start_date' AND '$report_end_date' AND order_status not in ('Rejected','cancel') 
            order by appointment_date";
            // $sql = "SELECT *
            // ,convert(varchar, appointment_date,103)as appointment_date_date
            // ,convert(varchar, appointment_date,108)as appointment_date_time
            // ,convert(varchar, customer_receive_date,103)as customer_receive_date_date
            // ,convert(varchar, customer_receive_date,108)as customer_receive_date_time
            //  FROM tbvmi_order WHERE convert(varchar, appointment_date, 101) = '$report_date' AND order_status not in ('Rejected','cancel') 
            //  order by appointment_date,create_date";
            $res = mssql_query($sql);
            $no=0;
            $no_old=0;
            // echo $sql;
            while($row = mssql_fetch_array($res)){
                $order_number = $row["order_number"];
                $no++;

                $sql_order_vmi = "SELECT *
                ,convert(varchar, appointment_date,103)as appointment_date_date
                ,convert(varchar, appointment_date,108)as appointment_date_time
                ,convert(varchar, customer_receive_date,103)as customer_receive_date_date
                ,convert(varchar, customer_receive_date,108)as customer_receive_date_time
                FROM tbvmi_order WHERE order_number = '$order_number' AND order_status not in ('Rejected','cancel') 
                order by appointment_date,create_date";
                $res_order_vmi = mssql_query($sql_order_vmi);
                while($row_order_vmi = mssql_fetch_array($res_order_vmi)){
                    
                    $vmi_number = $row_order_vmi["vmi_number"];
                    $qty = $row_order_vmi["qty"];
                    $qty_issue = $row_order_vmi["qty_issue"];
                    $appointment_date = $row_order_vmi["appointment_date_date"]." ".$row_order_vmi["appointment_date_time"];
                    $customer_receive_date = $row_order_vmi["customer_receive_date_date"]." ".$row_order_vmi["customer_receive_date_time"];
                    
                    $sql_master = "SELECT * FROM tbvmi_part_master WHERE vmi_number='$vmi_number' ";
                    $res_master = mssql_query($sql_master);
                    $row_master = mssql_fetch_array($res_master);
                    $Material = lang_thai_from_database($row_master["Material"]);
                    $Unit = lang_thai_from_database($row_master["Unit"]);

                    
                    
                    ?>
                    <tr>
                        <td>
                            <?php
                            if($no_old != $no){
                                echo $no;
                            }
                            ?></td>
                        <td><?=$order_number?></td>
                        <td><?=$Material?></td>
                        <td align="center"><?=$qty?></td>
                        <td align="center"><?=$qty_issue?></td>
                        <td align="center"><?=$Unit?></td>
                        <td><?=$appointment_date?></td>
                        <td><?=$customer_receive_date?></td>
                    </tr>
                    <?
                    $no_old = $no;
                }
            }
            ?>
        </table>
    </div>

    
    <?
}
    
?>