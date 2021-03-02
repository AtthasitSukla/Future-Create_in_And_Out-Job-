<?php
session_start();
//echo $_SESSION['production_line'];
include("connect.php");
include("library.php");

$status = $_POST['status'];
$date_time = date("m/d/Y H:i:s");
$time = time();
$shift = $_POST["shift"];
$admin_userid = $_SESSION["admin_userid"];

if ($status == "select_date_report_hq") {
    $report_date_dmy = ($_POST["report_date"]);
    $shift = ($_POST["shift"]);
    $report_date = date_format_uk_into_database($_POST["report_date"]);
    $report_date_yesterday = date("m/d/Y", strtotime($report_date." -1 days"));

    if($shift=="Day"){
        $panel_text = "orange";
        $report_start_date = $report_date." 08:00:00";
        $report_end_date = $report_date." 19:59:59";
        $report_start_date_dmy = $report_date_dmy." 08:00:00";
        $report_end_date_dmy = $report_date_dmy." 19:59:59";
        
        
        $report_start_input = $report_date." 16:00:00";
    }else if($shift=="Night"){
        $panel_text = "inverse";
        $report_start_date = $report_date." 20:00:00";
        $report_end_date = date("m/d/Y", strtotime($report_date." +1 days"))." 07:59:59";
        
        $report_start_date_dmy = $report_date_dmy." 20:00:00";
        $report_end_date_dmy = date("d/m/Y", strtotime($report_date." +1 days"))." 07:59:59";

        
        $report_start_input = date("m/d/Y", strtotime($report_date." +1 days"))." 04:00:00";
    }

    $sql = "SELECT *  FROM tbdaily_report_hq WHERE workdate='$report_date' AND shift='$shift'";
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

        
        $per_remark_sp = lang_thai_from_database($row["per_remark_sp"]);//..

        $qa_status_qrqc = lang_thai_from_database($row["qa_status_qrqc"]);//..
        $qa_external_ng = $row["qa_external_ng"];//..
        $qa_status_external_qrqc = lang_thai_from_database($row["qa_status_external_qrqc"]);

        
        if($_SESSION["emp_level"]>3){
            $sql_app = "SELECT *  FROM tbdaily_report_hq WHERE workdate='$report_date' AND approve_by IS NULL";
            $res_app = mssql_query($sql_app);
            $num_app = mssql_num_rows($res_app);
            if($num_app>0){
                $btn_txt = "<button class='btn btn-success' onclick='approve_daily_report_hq()'>Approve</button>";
            }else{
                $btn_txt = "Approve เรียบร้อยแล้ว";
            }
        }else{
            
            $btn_txt = "<button class='btn btn-warning' onclick='save_daily_report_hq()'>Update</button>";
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
        
        /* 5.3 Efficiency performance */
        $per_remark_sp = "";
        /* 5.3 Efficiency performance */

        $qa_status_qrqc= "";
        $qa_external_ng= 0;
        $qa_status_external_qrqc= "";

        if(TimeDiff($date_time,$report_start_input)>0){

            $btn_txt = "<font color='red'>ยังไม่ถึงเวลา Save กรุณาเลือกวันที่ใหม่</font>";
            
        }elseif($_SESSION["emp_level"]>3){
            
            $btn_txt = "<font color='red'>กรุณา Save ข้อมูลก่อน Approve</font>";
        }else{
            
            $btn_txt = "<button class='btn btn-success' onclick='save_daily_report_hq()'>Save</button>";
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

    $ss_daily = "picture5s_approve.php?shift=$shift&select_date=$report_date_dmy&site=HQ";
    $ss_daily_status = "";
    $ss_daily_night = "";


    $sql_ss = "SELECT  COUNT(jobstatus_approve) AS count_job, jobstatus_approve FROM tb5s_picture
                    WHERE createdate='$report_date' AND site='HQ' AND shift='$shift'
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
    

    
    
    $ss_daily_percent = "";
    $sql_sum = "SELECT count(id) as all_pic FROM tb5s_picture WHERE createdate='$report_date' AND site='HQ' ";
    $res_sum = mssql_query($sql_sum);
    $row_sum = mssql_fetch_array($res_sum);
    $all_pic = $row_sum["all_pic"];

    $sql_check = "SELECT count(id) as pic_check FROM tb5s_picture WHERE createdate='$report_date' AND site='HQ' AND jobstatus_approve IN ('OK','NG')  ";
    $res_check = mssql_query($sql_check);
    $row_check = mssql_fetch_array($res_check);
    $pic_check = $row_check["pic_check"];

    if($all_pic!=""){

        $ss_daily_percent = ($pic_check*100)/$all_pic;
    }
    /* 2. 5S Daily */

    /* 3. TIME ATTENDANCE. AND 4. OVERTIME Work. */
    $sql_ot_start = "SELECT * FROM tbsite WHERE site='HQ' ";
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
        WHERE        (positionid = 'P011' ) AND (display_att='1' ) AND departmentid='D005'";// Asst,wh MGR //or positionid='P012'
    $res = mssql_query($sql);
    while($row=mssql_fetch_array($res)){
        $empno = $row["empno"];
        
        $sql_att = "SELECT count(id) as count_id FROM tbatt WHERE empno='$empno' AND att_status='in' and att_real_date='$report_date'";
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

        /*ot_asst_mgr_prs */
        // if($shift=="Day"){
        //     $start_ot_asst = "18:20:00";
        // }else if($shift=="Night"){
        //     $start_ot_asst = "06:40:00";
        // }

        // $select0 = "SELECT *,
		// 	convert(varchar, workdate, 101)as  workdate2,
		// 	convert(varchar, workdate, 103)as  workdate3
			
	    // FROM    tbot_parameter where workdate = '$report_date' AND site='HQ'  order by workdate asc ";
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
        // $att_plan++;
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
        WHERE        (positionid = 'P004') AND (display_att='1')";// Suppervisor
    $res = mssql_query($sql);
    while($row=mssql_fetch_array($res)){
        $empno = $row["empno"];
        $sql_att = "SELECT count(id) as count_id FROM tbatt WHERE empno='$empno' AND att_status='in' and att_real_date='$report_date'";
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
            // echo $sql_leave.$count_id;
            if($count_id > 0 ){ //ถ้าเกิดมีการทำงานนอกสถานที่
                $att_supervisor = $att_supervisor+1;
            }
        }

        $select0 = "SELECT *,
			convert(varchar, workdate, 101)as  workdate2,
			convert(varchar, workdate, 103)as  workdate3
			
	    FROM    tbot_parameter where workdate = '$report_date' AND site='HQ'  order by workdate asc ";
        $re0 = mssql_query($select0);
        $num0 = mssql_num_rows($re0);
        if ($num0 > 0) {
            $row0 = mssql_fetch_array($re0);

            if (($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H')) { // OT Holiday
                /* ot_supervisor_prs and ot_supervisor_hrs version 2  */
                $sql_att_ot_prs = "SELECT start_time_approve,end_time_approve FROM tbot_request 
                    WHERE empno='$empno' 
                    AND shift='$shift' 
                    AND status_ot='O'
                    and date_ot='$report_date' ";
                $res_att_ot_prs = mssql_query($sql_att_ot_prs);
                $num_att_ot_prs = mssql_num_rows($res_att_ot_prs);
                if($num_att_ot_prs>0){
                    $row_att_ot_prs = mssql_fetch_array($res_att_ot_prs);
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
        
    //    /* ot_supervisor_prs and ot_supervisor_hrs version 2  */
    //    $sql_att_ot_prs = "SELECT start_time_approve,end_time_approve FROM tbot_request 
    //         WHERE empno='$empno' 
    //         AND shift='$shift' 
    //         AND status_ot='O'
    //         and date_ot='$report_date' ";
    //     $res_att_ot_prs = mssql_query($sql_att_ot_prs);
    //     $num_att_ot_prs = mssql_num_rows($res_att_ot_prs);
    //     if($num_att_ot_prs>0){
    //         $row_att_ot_prs = mssql_fetch_array($res_att_ot_prs);
    //         $start_time_approve = $row_att_ot_prs["start_time_approve"];
    //         $end_time_approve = $row_att_ot_prs["end_time_approve"];
    //         $hrs_prs = floor(TimeDiff($start_time_approve,$end_time_approve) * 2) / 2; // ปัดเศษนับเฉพาะจำนวนเต็มและ 0.5 เท่านั้น
    //         $ot_supervisor_hrs = $ot_supervisor_hrs+$hrs_prs;

    //         $ot_supervisor_prs = $ot_supervisor_prs+1;

    //     }
    //     /* ot_supervisor_prs and ot_supervisor_hrs version 2  */

    //     $select0 = "SELECT *,
    //         convert(varchar, workdate, 101)as  workdate2,
    //         convert(varchar, workdate, 103)as  workdate3
            
    //     FROM    tbot_parameter where workdate = '$report_date' AND site='HQ'  order by workdate asc ";
    //     $re0 = mssql_query($select0);
    //     $num0 = mssql_num_rows($re0);
    //     if ($num0 > 0) {
    //         $row0 = mssql_fetch_array($re0);

    //         if (($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') && $hrs_prs>6 && $num_att_ot_prs>0) { // OT Holiday
    //             $ot_supervisor_hrs=$ot_supervisor_hrs-1;
    //         }
            
    //     }

        


        // /*ATT PLAN*/
        // $att_plan++;
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
        WHERE        (positionid = 'P005') AND (display_att='1')";// Leader
    $res = mssql_query($sql);
    while($row=mssql_fetch_array($res)){
        $empno = $row["empno"];
        $sql_att = "SELECT count(id) as count_id FROM tbatt WHERE empno='$empno' AND att_status='in' and att_real_date='$report_date'";
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

        

        /* ot_leader_prs and ot_leader_hrs version 2  */
        $sql_att_ot_prs = "SELECT start_time_approve,end_time_approve FROM tbot_request 
            WHERE empno='$empno' 
            AND shift='$shift' 
            AND status_ot='O'
            and date_ot='$report_date' ";
        $res_att_ot_prs = mssql_query($sql_att_ot_prs);
        $num_att_ot_prs = mssql_num_rows($res_att_ot_prs);
        if($num_att_ot_prs>0){
            $row_att_ot_prs = mssql_fetch_array($res_att_ot_prs);
            $start_time_approve = $row_att_ot_prs["start_time_approve"];
            $end_time_approve = $row_att_ot_prs["end_time_approve"];
            $hrs_prs = floor(TimeDiff($start_time_approve,$end_time_approve) * 2) / 2; // ปัดเศษนับเฉพาะจำนวนเต็มและ 0.5 เท่านั้น
            $ot_leader_hrs = $ot_leader_hrs+$hrs_prs;

            $ot_leader_prs = $ot_leader_prs+1;
        }
        /* ot_leader_prs and ot_leader_hrs version 2  */

        $select0 = "SELECT *,
            convert(varchar, workdate, 101)as  workdate2,
            convert(varchar, workdate, 103)as  workdate3
            
        FROM    tbot_parameter where workdate = '$report_date' AND site='HQ'  order by workdate asc ";
        $re0 = mssql_query($select0);
        $num0 = mssql_num_rows($re0);
        if ($num0 > 0) {
            $row0 = mssql_fetch_array($re0);

            if (($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') && $hrs_prs>6 && $num_att_ot_prs>0) { // OT Holiday
                $ot_leader_hrs=$ot_leader_hrs-1;
            }
            
        }

        // /*ATT PLAN*/
        // $att_plan++;
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
        WHERE        (positionid = 'P009') AND (display_att='1')"; // Oreration
    $res = mssql_query($sql);
    while($row=mssql_fetch_array($res)){
        $empno = $row["empno"];
        $sql_att = "SELECT count(id) as count_id FROM tbatt WHERE empno='$empno' AND att_status='in' and att_real_date='$report_date'";
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

        

        /* ot_operator_prs and ot_operator_hrs version 2  */
        $sql_att_ot_prs = "SELECT start_time_approve,end_time_approve FROM tbot_request 
            WHERE empno='$empno' 
            AND shift='$shift' 
            AND status_ot='O'
            and date_ot='$report_date' ";
        $res_att_ot_prs = mssql_query($sql_att_ot_prs);
        $num_att_ot_prs = mssql_num_rows($res_att_ot_prs);
        if($num_att_ot_prs>0){
            $row_att_ot_prs = mssql_fetch_array($res_att_ot_prs);
            $start_time_approve = $row_att_ot_prs["start_time_approve"];
            $end_time_approve = $row_att_ot_prs["end_time_approve"];
            $hrs_prs = floor(TimeDiff($start_time_approve,$end_time_approve) * 2) / 2; // ปัดเศษนับเฉพาะจำนวนเต็มและ 0.5 เท่านั้น
            $ot_operator_hrs = $ot_operator_hrs+$hrs_prs;

            $ot_operator_prs = $ot_operator_prs+1;
        }
        /* ot_operator_prs and ot_operator_hrs version 2  */

        $select0 = "SELECT *,
			convert(varchar, workdate, 101)as  workdate2,
			convert(varchar, workdate, 103)as  workdate3
			
	    FROM    tbot_parameter where workdate = '$report_date' AND site='HQ'  order by workdate asc ";
        $re0 = mssql_query($select0);
        $num0 = mssql_num_rows($re0);
        if ($num0 > 0) {
            $row0 = mssql_fetch_array($re0);

            if (($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') && $hrs_prs>6 && $num_att_ot_prs>0) { // OT Holiday
                $ot_operator_hrs=$ot_operator_hrs-1;
            }
            
        }

        // /*ATT PLAN*/
        // $att_plan++;
        // $sql_vacation = "SELECT empno FROM tbleave_transaction WHERE leavetypeid='L0003' AND statusapprove='Approve' AND empno='$empno' AND ('$report_date' BETWEEN leavestartdate AND leaveenddate)";//ถ้าลาพักร้อนให้ลบออกจาก plan
        // $res_vacation = mssql_query($sql_vacation);
        // $num_vacation = mssql_num_rows($res_vacation);
        // if($num_vacation>0){
        //     $att_plan=$att_plan-1;
        // }
        // /*ATT PLAN*/
    }

    $att_forklift = 0;
    $ot_forklift_prs = 0;
    $ot_forklift_hrs = 0;
    $sql = "SELECT    empno
        FROM            tbemployee
        WHERE        (positionid = 'P008') AND (display_att='1')"; // Forklift
    $res = mssql_query($sql);
    while($row=mssql_fetch_array($res)){
        $empno = $row["empno"];
        $sql_att = "SELECT count(id) as count_id FROM tbatt WHERE empno='$empno' AND att_status='in' and att_real_date='$report_date'";
        $res_att = mssql_query($sql_att);
        $row_att = mssql_fetch_array($res_att);
        $count_id = (int)$row_att["count_id"];
        if($count_id>0){

            $att_forklift = $att_forklift+1;
        }else{
            $sql_leave = "SELECT count(id) as count_id FROM tbleave_transaction WHERE empno='$empno' AND ('$report_date' between leavestartdate AND  leaveenddate) AND statusapprove in ('New','Approve') AND leavetypeid='L0009'";
            $res_leave = mssql_query($sql_leave);
            $num_leave = mssql_num_rows($res_leave);
            $row_leave = mssql_fetch_array($res_leave);
            $count_id = (int)$row_leave["count_id"];
            //echo $sql_leave.$num_leave;
            if($count_id > 0 ){ //ถ้าเกิดมีการทำงานนอกสถานที่
                $att_forklift = $att_forklift+1;
            }
        }

        /* ot_forklift_prs and ot_forklift_hrs version 2  */
        $sql_att_ot_prs = "SELECT start_time_approve,end_time_approve FROM tbot_request 
            WHERE empno='$empno' 
            AND shift='$shift' 
            AND status_ot='O'
            and date_ot='$report_date' ";
        $res_att_ot_prs = mssql_query($sql_att_ot_prs);
        $num_att_ot_prs = mssql_num_rows($res_att_ot_prs);
        if($num_att_ot_prs>0){
            $row_att_ot_prs = mssql_fetch_array($res_att_ot_prs);
            $start_time_approve = $row_att_ot_prs["start_time_approve"];
            $end_time_approve = $row_att_ot_prs["end_time_approve"];
            $hrs_prs = floor(TimeDiff($start_time_approve,$end_time_approve) * 2) / 2; // ปัดเศษนับเฉพาะจำนวนเต็มและ 0.5 เท่านั้น
            $ot_forklift_hrs = $ot_forklift_hrs+$hrs_prs;

            $ot_forklift_prs = $ot_forklift_prs+1;
        }
        /* ot_forklift_prs and ot_forklift_hrs version 2  */

        $select0 = "SELECT *,
			convert(varchar, workdate, 101)as  workdate2,
			convert(varchar, workdate, 103)as  workdate3
			
	    FROM    tbot_parameter where workdate = '$report_date' AND site='HQ'  order by workdate asc ";
        $re0 = mssql_query($select0);
        $num0 = mssql_num_rows($re0);
        if ($num0 > 0) {
            $row0 = mssql_fetch_array($re0);

            if (($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') && $hrs_prs>6 && $num_att_ot_prs>0) { // OT Holiday
                $ot_forklift_hrs=$ot_forklift_hrs-1;
            }
            
        }

        

        // /*ATT PLAN*/
        // $att_plan++;
        // $sql_vacation = "SELECT empno FROM tbleave_transaction WHERE leavetypeid='L0003' AND statusapprove='Approve' AND empno='$empno' AND ('$report_date' BETWEEN leavestartdate AND leaveenddate)";//ถ้าลาพักร้อนให้ลบออกจาก plan
        // $res_vacation = mssql_query($sql_vacation);
        // $num_vacation = mssql_num_rows($res_vacation);
        // if($num_vacation>0){
        //     $att_plan=$att_plan-1;
        // }
        // /*ATT PLAN*/
    }

    /* att_late */
    $att_late = 0;
    $sql_day = "SELECT count(id) as count_late_day FROM tbatt 
    WHERE (att_status = 'in') AND (shift = 'Day' ) 
    AND (CONVERT(varchar, attDateTime, 108) > '08:00:00') 
    AND site='HQ' 
    and att_real_date='$report_date'
    AND empno in (SELECT empno FROM tbemployee WHERE departmentid='D005' AND display_att='1' AND empno not in (SELECT empno FROM tbleave_transaction WHERE  ('$report_date' between leavestartdate AND  leaveenddate) AND statusapprove in ('New','Approve') AND leavetypeid='L0009' AND shift='Day' ) )
    ";
    $res_day = mssql_query($sql_day);
    $row_day = mssql_fetch_array($res_day);
    $count_late_day = $row_day["count_late_day"];

    $sql_night = "SELECT count(id) as count_late_night FROM tbatt 
    WHERE (att_status = 'in') 
    AND (shift = 'Night' ) 
    AND (CONVERT(varchar, attDateTime, 108) > '20:20:00') 
    AND site='HQ' 
    and att_real_date='$report_date'
    AND empno in (SELECT empno FROM tbemployee WHERE departmentid='D005' AND display_att='1' AND empno not in (SELECT empno FROM tbleave_transaction WHERE  ('$report_date' between leavestartdate AND  leaveenddate) AND statusapprove in ('New','Approve') AND leavetypeid='L0009' AND shift='Night' ) )
    ";
    $res_night = mssql_query($sql_night);
    $row_night = mssql_fetch_array($res_night);
    $count_late_night = $row_night["count_late_night"];

    $att_late = $count_late_day+$count_late_night;
    /* att_late */

    $att_forklift_day1 = "";
    $sql_fl_day = "SELECT top 1 empno FROM tbot_request 
    WHERE empno in (SELECT empno FROM tbemployee WHERE site='HQ')
    AND fl_status='yes'
    AND shift='Day' 
    and date_ot='$report_date'
    order by empno
    ";
    $res_fl_day = mssql_query($sql_fl_day);
    $no_day=0;
    while($row_fl_day = mssql_fetch_array($res_fl_day)){
        $empno_name = get_full_name($row_fl_day["empno"]);
        if($no_day==0){
            $att_forklift_day1 .= $empno_name;
        }else{
            $att_forklift_day1 .= ",".$empno_name;
        }
        $no_day++;
       
    }
   
    $att_forklift_day2 = "";
    $sql_fl_night = " SELECT top 1 empno FROM tbot_request 
    WHERE empno in (SELECT empno FROM tbemployee WHERE site='HQ')
    AND fl_status='yes'
    AND shift='Day' 
    and date_ot='$report_date'
    order by empno desc
    ";
    $res_fl_night = mssql_query($sql_fl_night);
    $no_night=0;
    while($row_fl_night = mssql_fetch_array($res_fl_night)){
        $empno_name = get_full_name($row_fl_night["empno"]);
        if($no_night==0){
            $att_forklift_day2 .= $empno_name;
        }else{
            $att_forklift_day2 .= ",".$empno_name;
        }
        $no_night++;
       
    }
    if($att_forklift_day1==$att_forklift_day2){
        $att_forklift_day2="";
    }
    
    
    $att_total = ($att_asst_mgr+$att_supervisor+$att_leader+$att_operator+$att_forklift)-$att_late;
    // echo "$att_total = ($att_asst_mgr+$att_supervisor+$att_leader+$att_operator+$att_forklift)-$att_late";
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

    $ot_actual = $ot_asst_mgr_hrs+$ot_supervisor_hrs+$ot_leader_hrs+$ot_operator_hrs+$ot_forklift_hrs;
    /* 3. TIME ATTENDANCE. AND 4. OVERTIME Work. */

    /* 5 Efficiency Operation */
    include "connect_hq.php";
    $sql_receive_sab = "SELECT count(id) as per_receive_sab FROM tbsaborder_receive WHERE convert(varchar, last_receive, 101) = '$report_date' ";
    $res_receive_sab = mssql_query($sql_receive_sab);
    $row_receive_sab = mssql_fetch_array($res_receive_sab);
    $per_receive_sab = $row_receive_sab["per_receive_sab"];

    $sql_packing_sab = "SELECT count(id) as per_packing_sab FROM tbsaborder_receive WHERE convert(varchar, close_date, 101) = '$report_date' ";
    $res_packing_sab = mssql_query($sql_packing_sab);
    $row_packing_sab = mssql_fetch_array($res_packing_sab);
    $per_packing_sab = $row_packing_sab["per_packing_sab"];
    
    $sql_loading_sab = "SELECT count(id) as per_loading_sab FROM tbdelivery_plan WHERE convert(varchar, closestatus_date, 101) = '$report_date' ";
    $res_loading_sab = mssql_query($sql_loading_sab);
    $row_loading_sab = mssql_fetch_array($res_loading_sab);
    $per_loading_sab = $row_loading_sab["per_loading_sab"];


    include "connect_topre.php";
    $sql_receive_topre = "SELECT count(id) as per_receive_topre FROM tbtopreorder_receive WHERE convert(varchar, create_date, 101) = '$report_date' ";
    $res_receive_topre = mssql_query($sql_receive_topre);
    $row_receive_topre = mssql_fetch_array($res_receive_topre);
    $per_receive_topre = $row_receive_topre["per_receive_topre"];

    $sql_packing_topre = "SELECT count(id) as per_packing_topre FROM tbtopre_packing WHERE convert(varchar, date_close_packing, 101) = '$report_date' ";
    $res_packing_topre = mssql_query($sql_packing_topre);
    $row_packing_topre = mssql_fetch_array($res_packing_topre);
    $per_packing_topre = $row_packing_topre["per_packing_topre"];
    
    $sql_loading_topre = "SELECT count(id) as per_loading_topre FROM tbdelivery_plan WHERE convert(varchar, closestatus_date, 101) = '$report_date' ";
    $res_loading_topre = mssql_query($sql_loading_topre);
    $row_loading_topre = mssql_fetch_array($res_loading_topre);
    $per_loading_topre = $row_loading_topre["per_loading_topre"];

    include "connect_inv.php";
    $sql_trading_tts = "SELECT count(id) as per_trading_tts FROM sp_issue_job 
    where  convert(varchar, date_close_packing, 101)  = '$report_date' 
    AND job_issue_id in (SELECT job_issue_id FROM sp_part_issue WHERE part_master_id in ( SELECT part_master_id FROM sp_part_master WHERE customer_id='CUS201801008'))"; 
    $res_trading_tts = mssql_query($sql_trading_tts);
    $row_trading_tts = mssql_fetch_array($res_trading_tts);
    $per_trading_tts = $row_trading_tts["per_trading_tts"];

    $sql_trading_brose = "SELECT count(id) as per_trading_brose FROM sp_issue_job 
    where  convert(varchar, date_close_packing, 101)  = '$report_date' 
    AND job_issue_id in (SELECT job_issue_id FROM sp_part_issue WHERE part_master_id in ( SELECT part_master_id FROM sp_part_master WHERE customer_id='CUS201801001'))"; 
    $res_trading_brose = mssql_query($sql_trading_brose);
    $row_trading_brose = mssql_fetch_array($res_trading_brose);
    $per_trading_brose = $row_trading_brose["per_trading_brose"];

    $sql_trading_smrc = "SELECT count(id) as per_trading_smrc FROM sp_issue_job 
    where  convert(varchar, date_close_packing, 101)  = '$report_date' 
    AND job_issue_id in (SELECT job_issue_id FROM sp_part_issue WHERE part_master_id in ( SELECT part_master_id FROM sp_part_master WHERE customer_id='CUS201801003'))"; 
    $res_trading_smrc = mssql_query($sql_trading_smrc);
    $row_trading_smrc = mssql_fetch_array($res_trading_smrc);
    $per_trading_smrc = $row_trading_smrc["per_trading_smrc"];

    $sql_trading_gkn = "SELECT count(id) as per_trading_gkn FROM sp_issue_job 
    where  convert(varchar, date_close_packing, 101)  = '$report_date' 
    AND job_issue_id in (SELECT job_issue_id FROM sp_part_issue WHERE part_master_id in ( SELECT part_master_id FROM sp_part_master WHERE customer_id='CUS201804001'))"; 
    $res_trading_gkn = mssql_query($sql_trading_gkn);
    $row_trading_gkn = mssql_fetch_array($res_trading_gkn);
    $per_trading_gkn = $row_trading_gkn["per_trading_gkn"];
    
    $sql_other_sp = "SELECT count(id) as per_other_sp FROM sp_issue_job 
    where  convert(varchar, date_close_packing, 101)  = '$report_date' 
    AND in_charge = 'Warehouse'
    AND job_issue_id not in (SELECT job_issue_id FROM sp_part_issue WHERE part_master_id in ( SELECT part_master_id FROM sp_part_master WHERE customer_id in ('CUS201801008','CUS201801001','CUS201801003','CUS201804001')))
    "; 
    $res_other_sp = mssql_query($sql_other_sp);
    $row_other_sp = mssql_fetch_array($res_other_sp);
    $per_other_sp = $row_other_sp["per_other_sp"];

    include "connect_nhk.php";
    $sql_receive_nhk = "SELECT count(id) as per_receive_nhk FROM tbnhk_receive_transaction_leaf WHERE convert(varchar, receive_date, 101) = '$report_date' AND receive_qty>0 ";
    $res_receive_nhk = mssql_query($sql_receive_nhk);
    $row_receive_nhk = mssql_fetch_array($res_receive_nhk);
    $per_receive_nhk = $row_receive_nhk["per_receive_nhk"];

    $sql_packing_nhk = "SELECT count(id) as per_packing_nhk FROM tbnhk_packing_leaf WHERE convert(varchar, date_close_packing, 101) = '$report_date' ";
    $res_packing_nhk = mssql_query($sql_packing_nhk);
    $row_packing_nhk = mssql_fetch_array($res_packing_nhk);
    $per_packing_nhk = $row_packing_nhk["per_packing_nhk"];
    
    $sql_loading_nhk = "SELECT count(id) as per_loading_nhk FROM tbdelivery_plan_leaf WHERE convert(varchar, closestatus_date, 101) = '$report_date' ";
    $res_loading_nhk = mssql_query($sql_loading_nhk);
    $row_loading_nhk = mssql_fetch_array($res_loading_nhk);
    $per_loading_nhk = $row_loading_nhk["per_loading_nhk"];

    include "connect_inv.php";
    $sql_receive_rack_sab = "SELECT count(Distinct receiveno) as per_receive_rack_sab FROM tbrack_receive WHERE convert(varchar, receive_date, 101) = '$report_date' AND customer='SAB' AND mat_code is not null";
    $res_receive_rack_sab = mssql_query($sql_receive_rack_sab);
    $row_receive_rack_sab = mssql_fetch_array($res_receive_rack_sab);
    $per_receive_rack_sab = $row_receive_rack_sab["per_receive_rack_sab"];
    
    $sql_receive_rack_topre = "SELECT count(Distinct receiveno) as per_receive_rack_topre FROM tbrack_receive WHERE convert(varchar, receive_date, 101) = '$report_date' AND customer='Topre' AND mat_code is not null";
    $res_receive_rack_topre = mssql_query($sql_receive_rack_topre);
    $row_receive_rack_topre = mssql_fetch_array($res_receive_rack_topre);
    $per_receive_rack_topre = $row_receive_rack_topre["per_receive_rack_topre"];
   

    /* 5 Efficiency Operation */

    /* 6 Qaulity */
    include "connect_hq.php";
    $sql_sab_ng = "SELECT count(id) as qa_sab_ng FROM tbsaborder_partng WHERE convert(varchar, dateadd, 101)  = '$report_date' ";
    $res_sab_ng = mssql_query($sql_sab_ng);
    $row_sab_ng = mssql_fetch_array($res_sab_ng);
    $qa_sab_ng = $row_sab_ng["qa_sab_ng"];
    
    include "connect_topre.php";
    $sql_topre_ng = "SELECT count(id) as qa_topre_ng FROM tbtopreorder_ranng WHERE convert(varchar, create_date, 101)  = '$report_date' ";
    $res_topre_ng = mssql_query($sql_topre_ng);
    $row_topre_ng = mssql_fetch_array($res_topre_ng);
    $qa_topre_ng = $row_topre_ng["qa_topre_ng"];
    /* 6 Qaulity */

    /* 7 Status Racks NG Return  */
    include "connect_inv.php";
    $sql_rack_sab = "SELECT sum(ng_clear.non_replacement_qty) as return_rack_sab
     FROM material_ng_clear_log as ng_clear 
    INNER JOIN material_ng as ng
    ON ng_clear.ngtagID = ng.ngtagID
    WHERE convert(varchar, ng_clear.create_date, 101)  = '$report_date' 
    AND ng_clear.non_replacement_qty > 0
    AND mat_code IN (SELECT mat_code FROM material WHERE mat_use_type='Rack' AND (mat_cus1='SAB' or mat_cus2='SAB' or mat_cus3='SAB'))
    ";
    $res_rack_sab = mssql_query($sql_rack_sab);
    $row_rack_sab = mssql_fetch_array($res_rack_sab);
    $return_rack_sab = $row_rack_sab["return_rack_sab"]==""?0:$row_rack_sab["return_rack_sab"];
    

    $sql_rack_topre = "SELECT sum(ng_clear.non_replacement_qty) as return_rack_topre
     FROM material_ng_clear_log as ng_clear 
    INNER JOIN material_ng as ng
    ON ng_clear.ngtagID = ng.ngtagID
    WHERE convert(varchar, ng_clear.create_date, 101)  = '$report_date' 
    AND ng_clear.non_replacement_qty > 0
    AND mat_code IN (SELECT mat_code FROM material WHERE mat_use_type='Rack' AND (mat_cus1='Topre' or mat_cus2='Topre' or mat_cus3='Topre'))
    ";
    $res_rack_topre = mssql_query($sql_rack_topre);
    $row_rack_topre = mssql_fetch_array($res_rack_topre);
    $return_rack_topre = $row_rack_topre["return_rack_topre"]==""?0:$row_rack_topre["return_rack_topre"];
    
    /* 7 Status Racks NG Return  */
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
                    <label class="control-label col-sm-2" for="ss_daily_status"><?=$shift?> Status</label>
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
                    <label class="control-label col-sm-2" for="att_forklift">3.5 Forkift </label>
                    <div class="col-sm-2">
                        <input type="number" class="form-control" id="att_forklift" name="att_forklift" autocomplete="off" value="<?= $att_forklift ?>" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="att_forklift_day1">- Day shift </label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" id="att_forklift_day1" name="att_forklift_day1" autocomplete="off" value="<?= $att_forklift_day1 ?>" readonly>
                        
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="att_forklift_day2">- Day shift </label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" id="att_forklift_day2" name="att_forklift_day2" autocomplete="off" value="<?= $att_forklift_day2 ?>" readonly>
                        
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="att_late">3.6 Late </label>
                    <div class="col-sm-2">
                        <input type="number" class="form-control" id="att_late" name="att_late" autocomplete="off" value="<?= $att_late ?>" readonly>
                        
                    </div>
                </div>
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
                    <label class="control-label col-sm-2" for="ot_operator_hrs">4.4 Packing Staff </label>
                    <div class="col-sm-2 text-center">
                        คนที่ทำโอที <input type="number" class="form-control" id="ot_operator_prs" name="ot_operator_prs" autocomplete="off" value="<?= $ot_operator_prs ?>" readonly>
                    </div>
                    <div class="col-sm-2 text-center">
                        ชั่วโมงที่ทำโอที<input type="number" class="form-control" id="ot_operator_hrs" name="ot_operator_hrs" autocomplete="off" value="<?= $ot_operator_hrs ?>" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="ot_forklift_hrs">4.5 Forklif </label>
                    <div class="col-sm-2 text-center">
                        คนที่ทำโอที <input type="number" class="form-control" id="ot_forklift_prs" name="ot_forklift_prs" autocomplete="off" value="<?= $ot_forklift_prs ?>" readonly>
                    </div>
                    <div class="col-sm-2 text-center">
                        ชั่วโมงที่ทำโอที<input type="number" class="form-control" id="ot_forklift_hrs" name="ot_forklift_hrs" autocomplete="off" value="<?= $ot_forklift_hrs ?>" readonly>
                    </div>
                </div>
                <div class="form-group" style="background-color:#ffff6678;padding:5px;">
                    <label class="control-label col-sm-2" for="ot_target">Overtime Target (Hrs.) </label>
                    <div class="col-sm-2 text-center">
                         <input type="number" class="form-control" id="ot_target" name="ot_target" autocomplete="off" value="<?= $ot_target ?>" onchange="ot_achieve_cal()">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="ot_actual">Actual Overtime (Hrs.)</label>
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
            <h4>5.Efficiency performance</h4>
        </div>
        <div class="panel-body">
            <div class="form-horizontal">
                <div class="form-group">
                    <label class="col-sm-5" for="5_1">
                        <h5><b>5.1 SAB </b></h5>
                    </label>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="per_receive_sab">5.1.1 Receive</label>
                    <div class="col-sm-2 text-center">
                        <input type="number" class="form-control" id="per_receive_sab" name="per_receive_sab" autocomplete="off" value="<?= $per_receive_sab ?>" readonly>
                    </div>
                    <div class="col-sm-2">
                        <p class="form-control-static"><i class='fa fa-info-circle fa-lg'  style='cursor: pointer;' onclick="show_receive_sab()"></i></p>    
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-2" for="per_packing_sab">5.1.2 Packing</label>
                    <div class="col-sm-2 text-center">
                        <input type="number" class="form-control" id="per_packing_sab" name="per_packing_sab" autocomplete="off" value="<?= $per_packing_sab ?>" readonly>
                    </div>
                    <div class="col-sm-2">
                        <p class="form-control-static"><i class='fa fa-info-circle fa-lg'  style='cursor: pointer;' onclick="show_packing_sab()"></i></p>    
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="per_loading_sab">5.1.3 Loading</label>
                    <div class="col-sm-2 text-center">
                        <input type="number" class="form-control" id="per_loading_sab" name="per_loading_sab" autocomplete="off" value="<?= $per_loading_sab ?>" readonly>
                    </div>
                    <div class="col-sm-2">
                        <p class="form-control-static"><i class='fa fa-info-circle fa-lg'  style='cursor: pointer;' onclick="show_loading_sab()"></i></p>    
                    </div>
                </div>



                <div class="form-group">
                    <label class="col-sm-5" for="5_1">
                        <h5><b>5.2 Topre </b></h5>
                    </label>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="per_receive_topre">5.2.1 Receive</label>
                    <div class="col-sm-2 text-center">
                        <input type="number" class="form-control" id="per_receive_topre" name="per_receive_topre" autocomplete="off" value="<?= $per_receive_topre ?>" readonly>
                    </div>
                    <div class="col-sm-2">
                        <p class="form-control-static"><i class='fa fa-info-circle fa-lg'  style='cursor: pointer;' onclick="show_receive_topre()"></i></p>    
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-2" for="per_packing_topre">5.2.2 Packing</label>
                    <div class="col-sm-2 text-center">
                        <input type="number" class="form-control" id="per_packing_topre" name="per_packing_topre" autocomplete="off" value="<?= $per_packing_topre ?>" readonly>
                    </div>
                    <div class="col-sm-2">
                        <p class="form-control-static"><i class='fa fa-info-circle fa-lg'  style='cursor: pointer;' onclick="show_packing_topre()"></i></p>    
                    </div>

                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="per_loading_topre">5.2.3 Loading</label>
                    <div class="col-sm-2 text-center">
                        <input type="number" class="form-control" id="per_loading_topre" name="per_loading_topre" autocomplete="off" value="<?= $per_loading_topre ?>" readonly>
                    </div>
                    <div class="col-sm-2">
                        <p class="form-control-static"><i class='fa fa-info-circle fa-lg'  style='cursor: pointer;' onclick="show_loading_topre()"></i></p>    
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-5" for="5_1">
                        <h5><b>5.3 Trading </b></h5>
                    </label>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="per_trading_tts">5.3.1 TTS</label>
                    <div class="col-sm-2 text-center">
                        <input type="number" class="form-control" id="per_trading_tts" name="per_trading_tts" autocomplete="off" value="<?= $per_trading_tts ?>" readonly>
                    </div>
                    <div class="col-sm-2">
                        <p class="form-control-static"><i class='fa fa-info-circle fa-lg'  style='cursor: pointer;' onclick="show_trading_tts()"></i></p>    
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-2" for="per_trading_brose">5.3.2 Brose</label>
                    <div class="col-sm-2 text-center">
                        <input type="number" class="form-control" id="per_trading_brose" name="per_trading_brose" autocomplete="off" value="<?= $per_trading_brose ?>" readonly>
                    </div>
                    <div class="col-sm-2">
                        <p class="form-control-static"><i class='fa fa-info-circle fa-lg'  style='cursor: pointer;' onclick="show_trading_brose()"></i></p>    
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="per_trading_smrc">5.3.3 SMRC</label>
                    <div class="col-sm-2 text-center">
                        <input type="number" class="form-control" id="per_trading_smrc" name="per_trading_smrc" autocomplete="off" value="<?= $per_trading_smrc ?>" readonly>
                    </div>
                    <div class="col-sm-2">
                        <p class="form-control-static"><i class='fa fa-info-circle fa-lg'  style='cursor: pointer;' onclick="show_trading_smrc()"></i></p>    
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="per_trading_gkn">5.3.3 GKN</label>
                    <div class="col-sm-2 text-center">
                        <input type="number" class="form-control" id="per_trading_gkn" name="per_trading_gkn" autocomplete="off" value="<?= $per_trading_gkn ?>" readonly>
                    </div>
                    <div class="col-sm-2">
                        <p class="form-control-static"><i class='fa fa-info-circle fa-lg'  style='cursor: pointer;' onclick="show_trading_gkn()"></i></p>    
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="per_other_sp">5.3.4 Orther Special Job.</label>
                    <div class="col-sm-2 text-center">
                        <input type="number" class="form-control" id="per_other_sp" name="per_other_sp" autocomplete="off" value="<?= $per_other_sp ?>" readonly>
                    </div>
                    <div class="col-sm-2">
                        <p class="form-control-static"><i class='fa fa-info-circle fa-lg'  style='cursor: pointer;' onclick="show_trading_sp()"></i></p>    
                    </div>
                </div>

                <div class="form-group" style="background-color:#ffff6678;padding:5px;">
                    <label class="control-label col-sm-2" for="per_remark_sp">Remark </label>
                    <div class="col-sm-4 text-center">
                        <textarea name="per_remark_sp" id="per_remark_sp" cols="30" rows="10" class="form-control"><?=$per_remark_sp?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-5" for="5_1">
                        <h5><b>5.4 NHK leaf </b></h5>
                    </label>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="per_receive_nhk">5.4.1 Receive</label>
                    <div class="col-sm-2 text-center">
                        <input type="number" class="form-control" id="per_receive_nhk" name="per_receive_nhk" autocomplete="off" value="<?= $per_receive_nhk ?>" readonly>
                    </div>
                    <div class="col-sm-2">
                        <p class="form-control-static"><i class='fa fa-info-circle fa-lg'  style='cursor: pointer;' onclick="show_receive_nhk()"></i></p>    
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-2" for="per_packing_nhk">5.4.2 Packing</label>
                    <div class="col-sm-2 text-center">
                        <input type="number" class="form-control" id="per_packing_nhk" name="per_packing_nhk" autocomplete="off" value="<?= $per_packing_nhk ?>" readonly>
                    </div>
                    <div class="col-sm-2">
                        <p class="form-control-static"><i class='fa fa-info-circle fa-lg'  style='cursor: pointer;' onclick="show_packing_nhk()"></i></p>    
                    </div>

                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="per_loading_nhk">5.4.3 Loading</label>
                    <div class="col-sm-2 text-center">
                        <input type="number" class="form-control" id="per_loading_nhk" name="per_loading_nhk" autocomplete="off" value="<?= $per_loading_nhk ?>" readonly>
                    </div>
                    <div class="col-sm-2">
                        <p class="form-control-static"><i class='fa fa-info-circle fa-lg'  style='cursor: pointer;' onclick="show_loading_nhk()"></i></p>    
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-5" for="5_1">
                        <h5><b>5.5 Rack receive </b></h5>
                    </label>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="per_receive_rack_sab">5.5.1 SAB</label>
                    <div class="col-sm-2 text-center">
                        <input type="text" class="form-control" id="per_receive_rack_sab" name="per_receive_rack_sab" autocomplete="off" value="<?= $per_receive_rack_sab ?>" readonly>
                    </div>
                    <div class="col-sm-2">
                        <p class="form-control-static"><i class='fa fa-info-circle fa-lg'  style='cursor: pointer;' onclick="show_receive_rack_sab()"></i></p>    
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-2" for="per_receive_rack_topre">5.5.2 Topre</label>
                    <div class="col-sm-2 text-center">
                        <input type="text" class="form-control" id="per_receive_rack_topre" name="per_receive_rack_topre" autocomplete="off" value="<?= $per_receive_rack_topre ?>" readonly>
                    </div>
                    <div class="col-sm-2">
                        <p class="form-control-static"><i class='fa fa-info-circle fa-lg'  style='cursor: pointer;' onclick="show_receive_rack_topre()"></i></p>    
                    </div>
                </div>
                
                
            </div>
        </div>
    </div>
    <div class="panel panel-<?=$panel_text?>">
        <div class="panel-heading">
            <h4>6.Qaulity</h4>
        </div>
        <div class="panel-body">
            <div class="form-horizontal">
                <div class="form-group">
                    <label class="col-sm-5" for="5_1">
                        <h5><b>6.1 NG External </b></h5>
                    </label>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="qa_sab_ng">6.1.1 SAB</label>
                    <div class="col-sm-2 text-center">
                        <input type="number" class="form-control" id="qa_sab_ng" name="qa_sab_ng" autocomplete="off" value="<?= $qa_sab_ng ?>" readonly>
                    </div>
                    <div class="col-sm-2">
                        <p class="form-control-static"><i class='fa fa-info-circle fa-lg'  style='cursor: pointer;' onclick="show_qa_sab_ng()"></i></p>    
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="qa_topre_ng">6.1.2 Topre</label>
                    <div class="col-sm-2 text-center">
                        <input type="number" class="form-control" id="qa_topre_ng" name="qa_topre_ng" autocomplete="off" value="<?= $qa_topre_ng ?>" readonly>
                    </div>
                    <div class="col-sm-2">
                        <p class="form-control-static"><i class='fa fa-info-circle fa-lg'  style='cursor: pointer;' onclick="show_qa_topre_ng()"></i></p>    
                    </div>
                </div>
                <div class="form-group " style="background-color:#ffff6678;padding:5px;">
                    <label class="control-label col-sm-2" for="qa_status_qrqc">6.1.3 Status QRQC</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" id="qa_status_qrqc" name="qa_status_qrqc" autocomplete="off" value="<?= $qa_status_qrqc ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-5" for="5_1">
                        <h5><b>6.2 NG Internal </b></h5>
                    </label>
                </div>
                <div class="form-group" style="background-color:#ffff6678;padding:5px;">
                    <label class="control-label col-sm-2" for="qa_external_ng">6.2.1 External</label>
                    <div class="col-sm-2 text-center">
                        <input type="number" class="form-control" id="qa_external_ng" name="qa_external_ng" autocomplete="off" value="<?= $qa_external_ng ?>" >
                    </div>
                </div>
                <div class="form-group " style="background-color:#ffff6678;padding:5px;">
                    <label class="control-label col-sm-2" for="qa_status_external_qrqc">6.1.3 External Status QRQC</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" id="qa_status_external_qrqc" name="qa_status_external_qrqc" autocomplete="off" value="<?= $qa_status_external_qrqc ?>">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="panel panel-<?=$panel_text?>">
        <div class="panel-heading">
            <h4>7.Status Racks NG Return</h4>
        </div>
        <div class="panel-body">
            <div class="form-horizontal">
                <div class="form-group">
                    <label class="col-sm-5" for="5_1">
                        <h5><b>7.1 SAB </b></h5>
                    </label>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="return_rack_sab">7.1.1 Rack</label>
                    <div class="col-sm-5 text-center">
                        <input type="text" class="form-control" id="return_rack_sab" name="return_rack_sab" autocomplete="off" value="<?= $return_rack_sab ?>" readonly>
                    </div>
                    <div class="col-sm-2">
                        <p class="form-control-static"><i class='fa fa-info-circle fa-lg'  style='cursor: pointer;' onclick="show_return_rack_sab()"></i></p>    
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-5" for="5_1">
                        <h5><b>7.2 Topre </b></h5>
                    </label>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="return_rack_topre">7.2.1 Rack</label>
                    <div class="col-sm-5 text-center">
                        <input type="text" class="form-control" id="return_rack_topre" name="return_rack_topre" autocomplete="off" value="<?= $return_rack_topre ?>" readonly>
                    </div>
                    <div class="col-sm-2">
                        <p class="form-control-static"><i class='fa fa-info-circle fa-lg'  style='cursor: pointer;' onclick="show_return_rack_topre()"></i></p>    
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-4 col-sm-10">
            <?=$btn_txt?>
            <!-- <button  class="btn btn-<?=$btn_color?>" onclick='save_daily_report_hq()'><?=$text_save?></button> -->
        </div>
    </div>
<?
}else if($status=="save_daily_report_hq"){
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
    $att_late = $_POST["att_late"];
    $att_forklift = $_POST["att_forklift"];
    $att_forklift_day1 = lang_thai_into_database($_POST["att_forklift_day1"]);
    $att_forklift_day2 = lang_thai_into_database($_POST["att_forklift_day2"]);
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
    $ot_forklift_prs = $_POST["ot_forklift_prs"];
    $ot_forklift_hrs = $_POST["ot_forklift_hrs"];
    $ot_target = $_POST["ot_target"];
    $ot_actual = $_POST["ot_actual"];
    $ot_achieve = $_POST["ot_achieve"];
    $ot_remark = $_POST["ot_remark"];

    $per_receive_sab = $_POST["per_receive_sab"];
    $per_packing_sab = $_POST["per_packing_sab"];
    $per_loading_sab = $_POST["per_loading_sab"];
    
    $per_receive_topre = $_POST["per_receive_topre"];
    $per_packing_topre = $_POST["per_packing_topre"];
    $per_loading_topre = $_POST["per_loading_topre"];
    $per_trading_tts = $_POST["per_trading_tts"];
    $per_trading_brose = $_POST["per_trading_brose"];
    $per_trading_smrc = $_POST["per_trading_smrc"];
    $per_trading_gkn = $_POST["per_trading_gkn"];
    $per_other_sp = $_POST["per_other_sp"];
    $per_remark_sp = lang_thai_into_database($_POST["per_remark_sp"]);
    $per_receive_nhk = $_POST["per_receive_nhk"];
    $per_packing_nhk = $_POST["per_packing_nhk"];
    $per_loading_nhk = $_POST["per_loading_nhk"];
    $per_receive_rack_sab = $_POST["per_receive_rack_sab"];
    $per_receive_rack_topre = $_POST["per_receive_rack_topre"];

    $qa_sab_ng = $_POST["qa_sab_ng"];
    $qa_topre_ng = $_POST["qa_topre_ng"];
    $qa_status_qrqc = lang_thai_into_database($_POST["qa_status_qrqc"]);
    $qa_external_ng = $_POST["qa_external_ng"];
    $qa_status_external_qrqc = lang_thai_into_database($_POST["qa_status_external_qrqc"]);
    $return_rack_sab = $_POST["return_rack_sab"];
    $return_rack_topre = $_POST["return_rack_topre"];

    

    $sql = "SELECT *  FROM tbdaily_report_hq WHERE workdate='$report_date' AND shift = '$shift'";
    $res = mssql_query($sql);
    $num = mssql_num_rows($res);
    //echo $sql;
    if ($num == 0) {
        $insert = " INSERT INTO tbdaily_report_hq
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
           ,att_late
           ,att_forklift
           ,att_forklift_day1
           ,att_forklift_day2
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
           ,ot_forklift_prs
           ,ot_forklift_hrs
           ,ot_target
           ,ot_actual
           ,ot_achieve
           ,ot_remark
            ,per_receive_sab
            ,per_packing_sab
            ,per_loading_sab
            
            ,per_receive_topre
            ,per_packing_topre
            ,per_loading_topre
            ,per_trading_tts
            ,per_trading_brose
            ,per_trading_smrc
            ,per_trading_gkn
            ,per_other_sp
            ,per_remark_sp
            ,per_receive_nhk
            ,per_packing_nhk
            ,per_loading_nhk
            ,per_receive_rack_sab
            ,per_receive_rack_topre
            ,qa_sab_ng
            ,qa_topre_ng
            ,qa_status_qrqc
            ,qa_external_ng
            ,qa_status_external_qrqc
            ,return_rack_sab
            ,return_rack_topre
           ,report_by
           ,report_by_date)
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
           ,'$att_late'
           ,'$att_forklift'
           ,'$att_forklift_day1'
           ,'$att_forklift_day2'
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
           ,'$ot_forklift_prs'
           ,'$ot_forklift_hrs'
           ,'$ot_target'
           ,'$ot_actual'
           ,'$ot_achieve'
           ,'$ot_remark'
            ,'$per_receive_sab'
            ,'$per_packing_sab'
            ,'$per_loading_sab'
            
            ,'$per_receive_topre'
            ,'$per_packing_topre'
            ,'$per_loading_topre'
            ,'$per_trading_tts'
            ,'$per_trading_brose'
            ,'$per_trading_smrc'
            ,'$per_trading_gkn'
            ,'$per_other_sp'
            ,'$per_remark_sp'
            ,'$per_receive_nhk'
            ,'$per_packing_nhk'
            ,'$per_loading_nhk'
            ,'$per_receive_rack_sab'
            ,'$per_receive_rack_topre'
            ,'$qa_sab_ng'
            ,'$qa_topre_ng'
            ,'$qa_status_qrqc'
            ,'$qa_external_ng'
            ,'$qa_status_external_qrqc'
            ,'$return_rack_sab'
            ,'$return_rack_topre'
           ,'$admin_userid'
           ,'$date_time')";
        mssql_query($insert);
        // echo $insert;
    }else{
        $update = "UPDATE tbdaily_report_hq
        SET 
            safety_human = '$safety_human'
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
           ,att_late = '$att_late'
           ,att_forklift = '$att_forklift'
           ,att_forklift_day1 = '$att_forklift_day1'
           ,att_forklift_day2 = '$att_forklift_day2'
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
           ,ot_forklift_prs = '$ot_forklift_prs'
           ,ot_forklift_hrs = '$ot_forklift_hrs'
           ,ot_target = '$ot_target'
           ,ot_actual = '$ot_actual'
           ,ot_achieve = '$ot_achieve'
           ,ot_remark = '$ot_remark'
           ,per_receive_sab = '$per_receive_sab'
            ,per_packing_sab = '$per_packing_sab'
            ,per_loading_sab = '$per_loading_sab'
            
            ,per_receive_topre = '$per_receive_topre'
            ,per_packing_topre = '$per_packing_topre'
            ,per_loading_topre = '$per_loading_topre'
            ,per_trading_tts = '$per_trading_tts'
            ,per_trading_brose = '$per_trading_brose'
            ,per_trading_smrc = '$per_trading_smrc'
            ,per_trading_gkn = '$per_trading_gkn'
            ,per_other_sp = '$per_other_sp'
            ,per_remark_sp = '$per_remark_sp'
            ,per_receive_nhk = '$per_receive_nhk'
            ,per_packing_nhk = '$per_packing_nhk'
            ,per_loading_nhk = '$per_loading_nhk'
            ,per_receive_rack_sab = '$per_receive_rack_sab'
            ,per_receive_rack_topre = '$per_receive_rack_topre'

            ,qa_sab_ng = '$qa_sab_ng'
            ,qa_topre_ng = '$qa_topre_ng'
            ,qa_status_qrqc = '$qa_status_qrqc'
            ,qa_external_ng = '$qa_external_ng'
            ,qa_status_external_qrqc = '$qa_status_external_qrqc'
            ,return_rack_sab = '$return_rack_sab'
            ,return_rack_topre = '$return_rack_topre'
           ,report_by = '$admin_userid'
           ,report_by_date = '$date_time'
           ,approve_by = null
           ,approve_by_date = null
      WHERE  workdate='$report_date'  AND shift = '$shift'";
      mssql_query($update);
    }


}else if($status=="approve_daily_report_hq"){
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
    $att_late = $_POST["att_late"];
    $att_forklift = $_POST["att_forklift"];
    $att_forklift_day1 = lang_thai_into_database($_POST["att_forklift_day1"]);
    $att_forklift_day2 = lang_thai_into_database($_POST["att_forklift_day2"]);
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
    $ot_forklift_prs = $_POST["ot_forklift_prs"];
    $ot_forklift_hrs = $_POST["ot_forklift_hrs"];
    $ot_target = $_POST["ot_target"];
    $ot_actual = $_POST["ot_actual"];
    $ot_achieve = $_POST["ot_achieve"];
    $ot_remark = $_POST["ot_remark"];

    $per_receive_sab = $_POST["per_receive_sab"];
    $per_packing_sab = $_POST["per_packing_sab"];
    $per_loading_sab = $_POST["per_loading_sab"];
    
    $per_receive_topre = $_POST["per_receive_topre"];
    $per_packing_topre = $_POST["per_packing_topre"];
    $per_loading_topre = $_POST["per_loading_topre"];
    $per_trading_tts = $_POST["per_trading_tts"];
    $per_trading_brose = $_POST["per_trading_brose"];
    $per_trading_smrc = $_POST["per_trading_smrc"];
    $per_trading_gkn = $_POST["per_trading_gkn"];
    $per_other_sp = $_POST["per_other_sp"];
    $per_remark_sp = lang_thai_into_database($_POST["per_remark_sp"]);
    
    $per_receive_nhk = $_POST["per_receive_nhk"];
    $per_packing_nhk = $_POST["per_packing_nhk"];
    $per_loading_nhk = $_POST["per_loading_nhk"];
    $per_receive_rack_sab = $_POST["per_receive_rack_sab"];
    $per_receive_rack_topre = $_POST["per_receive_rack_topre"];

    $qa_sab_ng = $_POST["qa_sab_ng"];
    $qa_topre_ng = $_POST["qa_topre_ng"];
    $qa_status_qrqc = lang_thai_into_database($_POST["qa_status_qrqc"]);
    $qa_external_ng = $_POST["qa_external_ng"];
    $qa_status_external_qrqc = lang_thai_into_database($_POST["qa_status_external_qrqc"]);
    $return_rack_sab = $_POST["return_rack_sab"];
    $return_rack_topre = $_POST["return_rack_topre"];

    $update = "UPDATE tbdaily_report_hq
        SET 
        safety_human = '$safety_human'
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
        ,att_late = '$att_late'
        ,att_forklift = '$att_forklift'
        ,att_forklift_day1 = '$att_forklift_day1'
        ,att_forklift_day2 = '$att_forklift_day2'
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
        ,ot_forklift_prs = '$ot_forklift_prs'
        ,ot_forklift_hrs = '$ot_forklift_hrs'
        ,ot_target = '$ot_target'
        ,ot_actual = '$ot_actual'
        ,ot_achieve = '$ot_achieve'
        ,ot_remark = '$ot_remark'
        ,per_receive_sab = '$per_receive_sab'
        ,per_packing_sab = '$per_packing_sab'
        ,per_loading_sab = '$per_loading_sab'
        
        ,per_receive_topre = '$per_receive_topre'
        ,per_packing_topre = '$per_packing_topre'
        ,per_loading_topre = '$per_loading_topre'
        ,per_trading_tts = '$per_trading_tts'
        ,per_trading_brose = '$per_trading_brose'
        ,per_trading_smrc = '$per_trading_smrc'
        ,per_trading_gkn = '$per_trading_gkn'
        ,per_other_sp = '$per_other_sp'
        ,per_remark_sp = '$per_remark_sp'
        ,per_receive_nhk = '$per_receive_nhk'
        ,per_packing_nhk = '$per_packing_nhk'
        ,per_loading_nhk = '$per_loading_nhk'
        ,per_receive_rack_sab = '$per_receive_rack_sab'
        ,per_receive_rack_topre = '$per_receive_rack_topre'

        ,qa_sab_ng = '$qa_sab_ng'
        ,qa_topre_ng = '$qa_topre_ng'
        ,qa_status_qrqc = '$qa_status_qrqc'
        ,qa_external_ng = '$qa_external_ng'
        ,qa_status_external_qrqc = '$qa_status_external_qrqc'
        ,return_rack_sab = '$return_rack_sab'
        ,return_rack_topre = '$return_rack_topre'
        ,approve_by = '$admin_userid'
        ,approve_by_date = '$date_time'
    WHERE  workdate='$report_date' AND shift = '$shift'";
    mssql_query($update);


    $report_date_show = ($_POST["report_date"]);
    $arr_date = explode("/",$report_date_show);
	$date_format = $arr_date[1]."/".$arr_date[0]."/".$arr_date[2];

    $html = "Dear Team <br>";		
    $html .= "Daily report HQ $report_date_show";
    $html .= "<BR> Approve by ".get_full_name($admin_userid);
    $html .= "<br/><br/>สามารถเข้าตรวจสอบได้ที่ : http://www.ipack-iwis.com/hrs/daily_report_hq.php?yyear=$arr_date[2]&mmonth=$arr_date[1]&ddate=$arr_date[0]&tsite=HQ";

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
    $mail->Subject = "[I-WIS SYSTEM] HQ Daily report $report_date_show";
    
    $mail->Body = $html;

    $mail->IsHTML(true); 

    $mail->AddAddress("ipack@ipacklogistics.com");
    $mail->AddAddress("ipack-logistics@live.com");
    $mail->AddAddress("pongthorn.w@ipacklogistics.com");
    $mail->AddCC("panyadanai.k@ipacklogistics.com");
    $mail->AddCC("arnon.s@ipacklogistics.com");

    $mail->AddCC("nakarin.j@ipacklogistics.com");
    //$mail->AddAddress("nakarin.j@ipacklogistics.com");
    // $mail->AddCC("nakarin.j@ipacklogistics.com");
    $mail->Send();

}else if($status=="show_att"){
    $report_date = date_format_uk_into_database($_POST["report_date"]);

    $report_date_show = ($_POST["report_date"]);
    ?>
    <h4>วันที่ : <?=$report_date_show?></h4>
    <div class="table-responsive">   
        <table class="table table-bordered table-striped">
            <tr>
                <th>ลำดับ</th>
                <th>ตำแหน่ง</th>
                <th>ชื่อ - นามสกุล</th>
                <th>กะ</th>
                <th>เวลาเข้างาน</th>
                <th>เวลาออกงาน</th>
            </tr>
            <?
        $sql = "SELECT    *
        FROM            tbemployee
        WHERE        (departmentid = 'D005') AND (display_att='1' )
        ORDER BY emp_level desc";
        $sql = "SELECT    empno
        ,firstname
        ,lastname
        ,positionid
        ,(SELECT top 1 shift FROM tbot_mng WHERE tbot_mng.workdate='$report_date' AND empno=tbemployee.empno) as shift
        FROM            tbemployee
        WHERE        (departmentid = 'D005') AND (display_att='1' )
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
            WHERE        (departmentid = 'D005') AND (display_att='1' )
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
    <?
}else if ($status == "show_receive_sab"){
    $report_date = date_format_uk_into_database($_POST["report_date"]);
    $report_date_show = ($_POST["report_date"]);
    ?>
    <h4>วันที่ : <?=$report_date_show?></h4>
    <div class="table-responsive">   
        <table class="table table-bordered table-striped">
            <tr>
                <th>ลำดับ</th>
                <th>SAB Input</th>
                <th>Issue No</th>
                <th>Part No</th>
                <th>Part Name</th>
                <th>Qty</th>
                <th>Receive Date</th>
            </tr>

            <?
            include "connect_hq.php";
            $sql = "SELECT *
            ,convert(varchar, last_receive,103)as last_receive_date
            ,convert(varchar, last_receive,108)as last_receive_time
             FROM tbsaborder_receive WHERE convert(varchar, last_receive, 101) = '$report_date' order by last_receive ";
            $res = mssql_query($sql);
            $no=0;
            while($row = mssql_fetch_array($res)){
                
                $Issue_No = ($row["Issue_No"]);
                $sabinput = lang_thai_from_database($row["sabinput"]);
                $receive_qty = ($row["receive_qty"]);
                $last_receive = $row["last_receive_date"]." ".$row["last_receive_time"];
                $no++;
                
                $sql_issue = "SELECT * FROM tbsaborder WHERE Issue_No='$Issue_No'";
                $res_issue = mssql_query($sql_issue);
                $row_issue = mssql_fetch_array($res_issue);
                $Part_No = $row_issue["Part_No"];
                $Part_Name = $row_issue["Part_Name"];
                ?>
                <tr>
                    <td><?=$no?></td>
                    <td><?=$sabinput?></td>
                    <td><?=$Issue_No?> </td>
                    <td><?=$Part_No?></td>
                    <td><?=$Part_Name?></td>
                    <td><?=$receive_qty?></td>
                    <td><?=$last_receive?></td>
                </tr>
                <?


            }
            ?>
        </table>
    </div>

    <?
}else if ($status == "show_packing_sab"){
    $report_date = date_format_uk_into_database($_POST["report_date"]);
    $report_date_show = ($_POST["report_date"]);
    ?>
    <h4>วันที่ : <?=$report_date_show?></h4>
    <div class="table-responsive">   
        <table class="table table-bordered table-striped">
            <tr>
                <th>ลำดับ</th>
                <th>Issue No</th>
                <th>Part No</th>
                <th>Part Name</th>
                <th>Qty</th>
                <th>Close Packing</th>
            </tr>

            <?
            include "connect_hq.php";
            $sql = "SELECT *
            ,convert(varchar, close_date,103)as close_date_date
            ,convert(varchar, close_date,108)as close_date_time
             FROM tbsaborder_receive WHERE convert(varchar, close_date, 101) = '$report_date' order by close_date ";
            $res = mssql_query($sql);
            $no=0;
            while($row = mssql_fetch_array($res)){
                
                $Issue_No = ($row["Issue_No"]);
                $sabinput = lang_thai_from_database($row["sabinput"]);
                $packing_qty = ($row["packing_qty"]);
                $close_date = $row["close_date_date"]." ".$row["close_date_time"];
                $no++;
                
                $sql_issue = "SELECT * FROM tbsaborder WHERE Issue_No='$Issue_No'";
                $res_issue = mssql_query($sql_issue);
                $row_issue = mssql_fetch_array($res_issue);
                $Part_No = $row_issue["Part_No"];
                $Part_Name = $row_issue["Part_Name"];
                ?>
                <tr>
                    <td><?=$no?></td>
                    <td><?=$Issue_No?> </td>
                    <td><?=$Part_No?></td>
                    <td><?=$Part_Name?></td>
                    <td><?=$packing_qty?></td>
                    <td><?=$close_date?></td>
                </tr>
                <?


            }
            ?>
        </table>
    </div>

    <?
}else if ($status == "show_loading_sab"){
    $report_date = date_format_uk_into_database($_POST["report_date"]);
    $report_date_show = ($_POST["report_date"]);
    ?>
    <h4>วันที่ : <?=$report_date_show?></h4>
    <div class="table-responsive">   
        <table class="table table-bordered table-striped">
            <tr>
                <th>ลำดับ</th>
                <th>deliveryID</th>
                <th>DN</th>
                <th>Issue No</th>
                <th>Part No</th>
                <th>Part Name</th>
                <th>Qty</th>
                <th>Loading Date</th>
            </tr>

            <?
            include "connect_hq.php";
            $sql = "SELECT *
            ,convert(varchar, closestatus_date,103)as closestatus_date_date
            ,convert(varchar, closestatus_date,108)as closestatus_date_time
             FROM tbdelivery_plan WHERE convert(varchar, closestatus_date, 101) = '$report_date' order by closestatus_date ";
            $res = mssql_query($sql);
            $no=0;
            while($row = mssql_fetch_array($res)){
                
                $deliveryID = ($row["deliveryID"]);
                $dn = ($row["dn"]);
                $Issue_No = ($row["Issue_No"]);
                $SNEP = ($row["SNEP"]);
                $closestatus_date = $row["closestatus_date_date"]." ".$row["closestatus_date_time"];
                $no++;
                
                $sql_issue = "SELECT * FROM tbsaborder WHERE Issue_No='$Issue_No'";
                $res_issue = mssql_query($sql_issue);
                $row_issue = mssql_fetch_array($res_issue);
                $Part_No = $row_issue["Part_No"];
                $Part_Name = $row_issue["Part_Name"];
                ?>
                <tr>
                    <td><?=$no?></td>
                    <td><?=$deliveryID?> </td>
                    <td><?=$dn?> </td>
                    <td><?=$Issue_No?> </td>
                    <td><?=$Part_No?></td>
                    <td><?=$Part_Name?></td>
                    <td><?=$SNEP?></td>
                    <td><?=$closestatus_date?></td>
                </tr>
                <?


            }
            ?>
        </table>
    </div>

<?
}else if ($status == "show_receive_topre"){
    $report_date = date_format_uk_into_database($_POST["report_date"]);
    $report_date_show = ($_POST["report_date"]);
    ?>
    <h4>วันที่ : <?=$report_date_show?></h4>
    <div class="table-responsive">   
        <table class="table table-bordered table-striped">
            <tr>
                <th>ลำดับ</th>
                <th>PickupSheetID</th>
                <th>Topre Issue No</th>
                <th>Part No</th>
                <th>Part Name</th>
                <th>Qty</th>
                <th>Receive Date</th>
            </tr>

            <?
            include "connect_topre.php";
            $sql = "SELECT *
            ,convert(varchar, create_date,103)as create_date_date
            ,convert(varchar, create_date,108)as create_date_time
             FROM tbtopreorder_receive WHERE convert(varchar, create_date, 101) = '$report_date' order by create_date ";
            $res = mssql_query($sql);
            $no=0;
            while($row = mssql_fetch_array($res)){
                
                $PickupSheetID = ($row["PickupSheetID"]);
                $Ran_No = ($row["Ran_No"]);
                $receive_qty = ($row["receive_qty"]);
                $create_date = $row["create_date_date"]." ".$row["create_date_time"];
                $no++;
                
                $sql_issue = "SELECT * FROM tbtopreorder WHERE Ran_No='$Ran_No'";
                $res_issue = mssql_query($sql_issue);
                $row_issue = mssql_fetch_array($res_issue);
                $Part_No = $row_issue["Part_No"];
                $Part_Name = $row_issue["Part_Name"];
                ?>
                <tr>
                    <td><?=$no?></td>
                    <td><?=$PickupSheetID?></td>
                    <td><?=$Ran_No?> </td>
                    <td><?=$Part_No?></td>
                    <td><?=$Part_Name?></td>
                    <td><?=$receive_qty?></td>
                    <td><?=$create_date?></td>
                </tr>
                <?


            }
            ?>
        </table>
    </div>
    <?    
}else if ($status == "show_packing_topre"){
    $report_date = date_format_uk_into_database($_POST["report_date"]);
    $report_date_show = ($_POST["report_date"]);
    ?>
    <h4>วันที่ : <?=$report_date_show?></h4>
    <div class="table-responsive">   
        <table class="table table-bordered table-striped">
            <tr>
                <th>ลำดับ</th>
                <th>Issue No</th>
                <th>Part No</th>
                <th>Part Name</th>
                <th>Qty</th>
                <th>Close Packing</th>
            </tr>

            <?
            include "connect_topre.php";
            $sql = "SELECT *
            ,convert(varchar, date_close_packing,103)as date_close_packing_date
            ,convert(varchar, date_close_packing,108)as date_close_packing_time
             FROM tbtopre_packing WHERE convert(varchar, date_close_packing, 101) = '$report_date' order by date_close_packing";
            $res = mssql_query($sql);
            $no=0;
            while($row = mssql_fetch_array($res)){
                
                $PickupSheetID = ($row["PickupSheetID"]);
                $dn = ($row["dn"]);
                $Issue_No = ($row["Issue_No"]);
                $packing_qty = ($row["packing_qty"]);
                $date_close_packing = $row["date_close_packing_date"]." ".$row["date_close_packing_time"];
                $no++;
                
                $sql_issue = "SELECT * FROM tbsaborder WHERE Issue_No='$Issue_No'";
                $res_issue = mssql_query($sql_issue);
                $row_issue = mssql_fetch_array($res_issue);
                $Part_No = $row_issue["Part_No"];
                $Part_Name = $row_issue["Part_Name"];
                ?>
                <tr>
                    <td><?=$no?></td>
                    <td><?=$Issue_No?> </td>
                    <td><?=$Part_No?></td>
                    <td><?=$Part_Name?></td>
                    <td><?=$packing_qty?></td>
                    <td><?=$date_close_packing?></td>
                </tr>
                <?


            }
            ?>
        </table>
    </div>

    <?
}else if ($status == "show_loading_topre"){
    $report_date = date_format_uk_into_database($_POST["report_date"]);
    $report_date_show = ($_POST["report_date"]);
    ?>
    <h4>วันที่ : <?=$report_date_show?></h4>
    <div class="table-responsive">   
        <table class="table table-bordered table-striped">
            <tr>
                <th>ลำดับ</th>
                <th>deliveryID</th>
                <th>DN</th>
                <th>Issue No</th>
                <th>Part No</th>
                <th>Part Name</th>
                <th>Qty</th>
                <th>Loading</th>
            </tr>

            <?
            include "connect_topre.php";
            $sql = "SELECT *
            ,convert(varchar, closestatus_date,103)as closestatus_date_date
            ,convert(varchar, closestatus_date,108)as closestatus_date_time
             FROM tbdelivery_plan WHERE convert(varchar, closestatus_date, 101) = '$report_date' order by closestatus_date";
            $res = mssql_query($sql);
            $no=0;
            while($row = mssql_fetch_array($res)){
                
                $deliveryID = ($row["deliveryID"]);
                $dn = ($row["dn"]);
                $Issue_No = ($row["Issue_No"]);
                $SNEP = ($row["SNEP"]);
                $closestatus_date = $row["closestatus_date_date"]." ".$row["closestatus_date_time"];
                $no++;
                
                $sql_issue = "SELECT * FROM tbsaborder WHERE Issue_No='$Issue_No'";
                $res_issue = mssql_query($sql_issue);
                $row_issue = mssql_fetch_array($res_issue);
                $Part_No = $row_issue["Part_No"];
                $Part_Name = $row_issue["Part_Name"];
                ?>
                <tr>
                    <td><?=$no?></td>
                    <td><?=$deliveryID?> </td>
                    <td><?=$dn?> </td>
                    <td><?=$Issue_No?> </td>
                    <td><?=$Part_No?></td>
                    <td><?=$Part_Name?></td>
                    <td><?=$SNEP?></td>
                    <td><?=$closestatus_date?></td>
                </tr>
                <?


            }
            ?>
        </table>
    </div>

    <?
}else if ($status == "show_receive_nhk"){
    $report_date = date_format_uk_into_database($_POST["report_date"]);
    $report_date_show = ($_POST["report_date"]);
    ?>
    <h4>วันที่ : <?=$report_date_show?></h4>
    <div class="table-responsive">   
        <table class="table table-bordered table-striped">
            <tr>
                <th>ลำดับ</th>
                <th>Truck No.</th>
                <th>Doc No.</th>
                <th>Lot</th>
                <th>Part No</th>
                <th>Part Name</th>
                <th>Qty</th>
                <th>Receive</th>
            </tr>

            <?
            include "connect_nhk.php";
            $sql = "SELECT *
            ,convert(varchar, receive_date,103)as receive_date_date
            ,convert(varchar, receive_date,108)as receive_date_time
             FROM tbnhk_receive_transaction_leaf WHERE convert(varchar, receive_date, 101) = '$report_date' AND receive_qty>0 order by receive_date ";
            $res = mssql_query($sql);
            $no=0;
            while($row = mssql_fetch_array($res)){
                
                $truckno = ($row["truckno"]);
                $docinput = ($row["docinput"]);
                $lot = ($row["lot"]);
                $receive_qty = ($row["receive_qty"]);
                $receive_date = $row["receive_date_date"]." ".$row["receive_date_time"];
                $no++;

                $part_no = $row["part_no"];

                $sql_issue = "SELECT * FROM partmaster_leaf WHERE partnumber='$part_no'";
                $res_issue = mssql_query($sql_issue);
                $row_issue = mssql_fetch_array($res_issue);
                $partname = $row_issue["partname"];
                ?>
                <tr>
                    <td><?=$no?></td>
                    <td><?=$truckno?></td>
                    <td><?=$docinput?></td>
                    <td><?=$lot?> </td>
                    <td><?=$part_no?></td>
                    <td><?=$partname?></td>
                    <td><?=$receive_qty?></td>
                    <td><?=$receive_date?></td>
                </tr>
                <?


            }
            ?>
        </table>
    </div>
    <?    
}else if ($status == "show_packing_nhk"){
    $report_date = date_format_uk_into_database($_POST["report_date"]);
    $report_date_show = ($_POST["report_date"]);
    ?>
    <h4>วันที่ : <?=$report_date_show?></h4>
    <div class="table-responsive">   
        <table class="table table-bordered table-striped">
            <tr>
                <th>ลำดับ</th>
                <th>Issue No</th>
                <th>Part No</th>
                <th>Part Name</th>
                <th>Qty</th>
                <th>Packing</th>
            </tr>

            <?
            include "connect_nhk.php";
            $sql = "SELECT *
            ,convert(varchar, date_close_packing,103)as date_close_packing_date
            ,convert(varchar, date_close_packing,108)as date_close_packing_time
             FROM tbnhk_packing_leaf WHERE convert(varchar, date_close_packing, 101) = '$report_date' order by date_close_packing";
            $res = mssql_query($sql);
            $no=0;
            while($row = mssql_fetch_array($res)){
                $dn = ($row["dn"]);
                $Issue_No = ($row["Issue_No"]);
                $packing_qty = ($row["packing_qty"]);
                $date_close_packing = $row["date_close_packing_date"]." ".$row["date_close_packing_time"];
                $no++;
                
                $Part_No = $row["Part_No"];
                $Part_Name = $row["Part_Name"];
                ?>
                <tr>
                    <td><?=$no?></td>
                    <td><?=$Issue_No?> </td>
                    <td><?=$Part_No?></td>
                    <td><?=$Part_Name?></td>
                    <td><?=$packing_qty?></td>
                    <td><?=$date_close_packing?></td>
                </tr>
                <?


            }
            ?>
        </table>
    </div>

    <?
}else if ($status == "show_loading_nhk"){
    $report_date = date_format_uk_into_database($_POST["report_date"]);
    $report_date_show = ($_POST["report_date"]);
    ?>
    <h4>วันที่ : <?=$report_date_show?></h4>
    <div class="table-responsive">   
        <table class="table table-bordered table-striped">
            <tr>
                <th>ลำดับ</th>
                <th>deliveryID</th>
                <th>Pallet No</th>
                <th>Part No</th>
                <th>Qty</th>
                <th>Loading</th>
            </tr>

            <?
            include "connect_nhk.php";
            $sql = "SELECT *
            ,convert(varchar, closestatus_date,103)as closestatus_date_date
            ,convert(varchar, closestatus_date,108)as closestatus_date_time
             FROM tbdelivery_plan_leaf WHERE convert(varchar, closestatus_date, 101) = '$report_date' order by closestatus_date";
            $res = mssql_query($sql);
            $no=0;
            while($row = mssql_fetch_array($res)){
                
                $deliveryID = ($row["deliveryID"]);
                $pallet_barcode = ($row["pallet_barcode"]);
                $Issue_No = ($row["Issue_No"]);
                $SNEP = ($row["SNEP"]);
                $closestatus_date = $row["closestatus_date_date"]." ".$row["closestatus_date_time"];
                $no++;
                
                $sql_issue = "SELECT * FROM tbpallet_barcode_leaf WHERE pallet_barcode='$pallet_barcode'";
                $res_issue = mssql_query($sql_issue);
                $row_issue = mssql_fetch_array($res_issue);
                $partnumber = $row_issue["partnumber"];
                $qty = $row_issue["qty"];
                $Part_Name = $row_issue["Part_Name"];
                ?>
                <tr>
                    <td><?=$no?></td>
                    <td><?=$deliveryID?> </td>
                    <td><?=$pallet_barcode?> </td>
                    <td><?=$partnumber?></td>
                    <td><?=$qty?></td>
                    <td><?=$closestatus_date?></td>
                </tr>
                <?


            }
            ?>
        </table>
    </div>

    <?
}else if ($status == "show_receive_rack_sab"){
    $report_date = date_format_uk_into_database($_POST["report_date"]);
    $report_date_show = ($_POST["report_date"]);
    ?>
    <h4>วันที่ : <?=$report_date_show?></h4>
    <div class="table-responsive">   
        <table class="table table-bordered table-striped">
            <tr>
                <th>ลำดับ</th>
                <th>Receive No.</th>
                <th>Tuck No.</th>
                <th>Doc No.</th>
                <th>Rack</th>
                <th>Q'ty</th>
                <th>Receive</th>
            </tr>

            <?
            include "connect_inv.php";
            $sql = "SELECT DISTINCT receiveno FROM tbrack_receive WHERE convert(varchar, receive_date, 101) = '$report_date' AND customer='SAB' AND mat_code is not null order by receiveno";
            $res = mssql_query($sql);
            $no=0;
            while($row = mssql_fetch_array($res)){
                
                $receiveno = ($row["receiveno"]);
                
                $no++;
                
                $sql_issue = "SELECT *
                ,convert(varchar, receive_date,103)as receive_date_date
                ,convert(varchar, receive_date,108)as receive_date_time
                 FROM tbrack_receive 
                 WHERE convert(varchar, receive_date, 101) = '$report_date'
                 AND customer='SAB' 
                 AND receiveno='$receiveno'
                 order by receive_date";
                $res_issue = mssql_query($sql_issue);
                while($row_issue = mssql_fetch_array($res_issue)){
                    $receive_date = $row_issue["receive_date_date"]." ".$row_issue["receive_date_time"];
                    $truckno = $row_issue["truckno"];
                    $docinput = $row_issue["docinput"];
                    $mat_code = $row_issue["mat_code"];
                    $receive_qty = $row_issue["receive_qty"];

                    $sql_mate = "SELECT mat_name FROM material WHERE mat_code='$mat_code'";
                    $res_mate = mssql_query($sql_mate);
                    $row_mate = mssql_fetch_array($res_mate);
                    $mat_name = lang_thai_from_database($row_mate["mat_name"]);
                    ?>
                    <tr>
                        <td>
                            <?php
                            if($no_old != $no){
                                echo $no;
                            }
                            ?></td>
                        <td><?=$receiveno?> </td>
                        <td><?=$truckno?> </td>
                        <td><?=$docinput?> </td>
                        <td><?=$mat_name?> </td>
                        <td><?=$receive_qty?></td>
                        <td><?=$receive_date?></td>
                    </tr>
                    <?
                    $no_old = $no;
                }


            }
            ?>
        </table>
    </div>

    <?
}else if ($status == "show_receive_rack_topre"){
    $report_date = date_format_uk_into_database($_POST["report_date"]);
    $report_date_show = ($_POST["report_date"]);
    ?>
    <h4>วันที่ : <?=$report_date_show?></h4>
    <div class="table-responsive">   
        <table class="table table-bordered table-striped">
            <tr>
                <th>ลำดับ</th>
                <th>Receive No.</th>
                <th>Tuck No.</th>
                <th>Doc No.</th>
                <th>Rack</th>
                <th>Q'ty</th>
                <th>Receive</th>
            </tr>

            <?
            include "connect_inv.php";
            $sql = "SELECT DISTINCT receiveno FROM tbrack_receive WHERE convert(varchar, receive_date, 101) = '$report_date' AND customer='Topre' AND mat_code is not null order by receiveno";
            $res = mssql_query($sql);
            $no=0;
            while($row = mssql_fetch_array($res)){
                
                $receiveno = ($row["receiveno"]);
                
                $no++;
                
                $sql_issue = "SELECT *
                ,convert(varchar, receive_date,103)as receive_date_date
                ,convert(varchar, receive_date,108)as receive_date_time
                 FROM tbrack_receive 
                 WHERE convert(varchar, receive_date, 101) = '$report_date' 
                 AND customer='Topre' 
                 AND receiveno='$receiveno'
                 order by receive_date";
                $res_issue = mssql_query($sql_issue);
                while($row_issue = mssql_fetch_array($res_issue)){
                    $receive_date = $row_issue["receive_date_date"]." ".$row_issue["receive_date_time"];
                    $truckno = $row_issue["truckno"];
                    $docinput = $row_issue["docinput"];
                    $mat_code = $row_issue["mat_code"];
                    $receive_qty = $row_issue["receive_qty"];

                    $sql_mate = "SELECT mat_name FROM material WHERE mat_code='$mat_code'";
                    $res_mate = mssql_query($sql_mate);
                    $row_mate = mssql_fetch_array($res_mate);
                    $mat_name = lang_thai_from_database($row_mate["mat_name"]);
                    ?>
                    <tr>
                        <td>
                            <?php
                            if($no_old != $no){
                                echo $no;
                            }
                            ?></td>
                        <td><?=$receiveno?> </td>
                        <td><?=$truckno?> </td>
                        <td><?=$docinput?> </td>
                        <td><?=$mat_name?> </td>
                        <td><?=$receive_qty?></td>
                        <td><?=$receive_date?></td>
                    </tr>
                    <?
                    $no_old = $no;
                }


            }
            ?>
        </table>
    </div>

    <?

}else if ($status == "show_trading_tts"){
    $report_date = date_format_uk_into_database($_POST["report_date"]);
    $report_date_show = ($_POST["report_date"]);
    ?>
    <h4>วันที่ : <?=$report_date_show?></h4>
    <div class="table-responsive">   
        <table class="table table-bordered table-striped">
            <tr>
                <th>ลำดับ</th>
                <th>Job Id</th>
                <th>Part No</th>
                <th>Part Name</th>
                <th>Qty</th>
            </tr>

            <?
            include "connect_inv.php";
            $sql = "SELECT * FROM sp_issue_job 
            where  convert(varchar, date_close_packing, 101)  = '$report_date' 
            AND job_issue_id in (SELECT job_issue_id FROM sp_part_issue WHERE part_master_id in ( SELECT part_master_id FROM sp_part_master WHERE customer_id='CUS201801008'))
            order by date_close_packing";
            $res = mssql_query($sql);
            $no=0;
            $no_old=0;
            while($row = mssql_fetch_array($res)){
                $job_issue_id = ($row["job_issue_id"]);
            
                $no++;


                $sql_part = "SELECT * FROM sp_part_issue as issue INNER JOIN sp_part_master as p_master
                ON issue.part_master_id = p_master.part_master_id
                WHERE job_issue_id='$job_issue_id' ";
                $res_part = mssql_query($sql_part);
                while($row_part = mssql_fetch_array($res_part)){
                    $part_number = $row_part["part_number"];
                    $part_name = $row_part["part_name"];
                    $qty = $row_part["qty"];
                    ?>
                    <tr>
                        <td><?php
                            if($no_old != $no){
                                echo $no;
                            }
                            ?></td>
                        <td><?=$job_issue_id?> </td>
                        <td><?=$part_number?></td>
                        <td><?=$part_name?></td>
                        <td><?=$qty?></td>
                    </tr>
                    <?
                    $no_old = $no;
                }


            }
            ?>
        </table>
    </div>

    <?
}else if ($status == "show_trading_brose"){
    $report_date = date_format_uk_into_database($_POST["report_date"]);
    $report_date_show = ($_POST["report_date"]);
    ?>
    <h4>วันที่ : <?=$report_date_show?></h4>
    <div class="table-responsive">   
        <table class="table table-bordered table-striped">
            <tr>
                <th>ลำดับ</th>
                <th>Job Id</th>
                <th>Part No</th>
                <th>Part Name</th>
                <th>Qty</th>
            </tr>

            <?
            include "connect_inv.php";
            $sql = "SELECT * FROM sp_issue_job 
            where  convert(varchar, date_close_packing, 101)  = '$report_date' 
            AND job_issue_id in (SELECT job_issue_id FROM sp_part_issue WHERE part_master_id in ( SELECT part_master_id FROM sp_part_master WHERE customer_id='CUS201801001'))
            order by date_close_packing";
            $res = mssql_query($sql);
            $no=0;
            $no_old=0;
            while($row = mssql_fetch_array($res)){
                $job_issue_id = ($row["job_issue_id"]);
         
                $no++;


                $sql_part = "SELECT * FROM sp_part_issue as issue INNER JOIN sp_part_master as p_master
                ON issue.part_master_id = p_master.part_master_id
                WHERE job_issue_id='$job_issue_id' ";
                $res_part = mssql_query($sql_part);
                while($row_part = mssql_fetch_array($res_part)){
                    $part_number = $row_part["part_number"];
                    $part_name = $row_part["part_name"];
                    $qty = $row_part["qty"];
                    ?>
                    <tr>
                        <td><?php
                            if($no_old != $no){
                                echo $no;
                                // echo $no_old;
                            }
                            ?></td>
                        <td><?=$job_issue_id?> </td>
                        <td><?=$part_number?></td>
                        <td><?=$part_name?></td>
                        <td><?=$qty?></td>
                    </tr>
                    <?
                    $no_old = $no;
                }


            }
            ?>
        </table>
    </div>

    <?
}else if ($status == "show_trading_smrc"){
    $report_date = date_format_uk_into_database($_POST["report_date"]);
    $report_date_show = ($_POST["report_date"]);
    ?>
    <h4>วันที่ : <?=$report_date_show?></h4>
    <div class="table-responsive">   
        <table class="table table-bordered table-striped">
            <tr>
                <th>ลำดับ</th>
                <th>Job Id</th>
                <th>Part No</th>
                <th>Part Name</th>
                <th>Qty</th>
            </tr>

            <?
            include "connect_inv.php";
            $sql = "SELECT * FROM sp_issue_job 
            where  convert(varchar, date_close_packing, 101)  = '$report_date' 
            AND job_issue_id in (SELECT job_issue_id FROM sp_part_issue WHERE part_master_id in ( SELECT part_master_id FROM sp_part_master WHERE customer_id='CUS201801003'))
            order by date_close_packing";
            $res = mssql_query($sql);
            $no=0;
            $no_old=0;
            while($row = mssql_fetch_array($res)){
                $job_issue_id = ($row["job_issue_id"]);
               
                $no++;


                $sql_part = "SELECT * FROM sp_part_issue as issue INNER JOIN sp_part_master as p_master
                ON issue.part_master_id = p_master.part_master_id
                WHERE job_issue_id='$job_issue_id' ";
                $res_part = mssql_query($sql_part);
                while($row_part = mssql_fetch_array($res_part)){
                    $part_number = $row_part["part_number"];
                    $part_name = $row_part["part_name"];
                    $qty = $row_part["qty"];
                    ?>
                    <tr>
                        <td><?php
                            if($no_old != $no){
                                echo $no;
                                // echo $no_old;
                            }
                            ?></td>
                        <td><?=$job_issue_id?> </td>
                        <td><?=$part_number?></td>
                        <td><?=$part_name?></td>
                        <td><?=$qty?></td>
                    </tr>
                    <?
                    $no_old = $no;
                }


            }
            ?>
        </table>
    </div>

    <?
}else if ($status == "show_trading_gkn"){
    $report_date = date_format_uk_into_database($_POST["report_date"]);
    $report_date_show = ($_POST["report_date"]);
    ?>
    <h4>วันที่ : <?=$report_date_show?></h4>
    <div class="table-responsive">   
        <table class="table table-bordered table-striped">
            <tr>
                <th>ลำดับ</th>
                <th>Job Id</th>
                <th>Part No</th>
                <th>Part Name</th>
                <th>Qty</th>
            </tr>

            <?
            include "connect_inv.php";
            $sql = "SELECT * FROM sp_issue_job 
            where  convert(varchar, date_close_packing, 101)  = '$report_date' 
            AND job_issue_id in (SELECT job_issue_id FROM sp_part_issue WHERE part_master_id in ( SELECT part_master_id FROM sp_part_master WHERE customer_id='CUS201804001'))
            order by date_close_packing";
            $res = mssql_query($sql);
            $no=0;
            $no_old=0;
            while($row = mssql_fetch_array($res)){
                $job_issue_id = ($row["job_issue_id"]);
                
                $no++;


                $sql_part = "SELECT * FROM sp_part_issue as issue INNER JOIN sp_part_master as p_master
                ON issue.part_master_id = p_master.part_master_id
                WHERE job_issue_id='$job_issue_id' ";
                $res_part = mssql_query($sql_part);
                while($row_part = mssql_fetch_array($res_part)){
                    $part_number = $row_part["part_number"];
                    $part_name = $row_part["part_name"];
                    $qty = $row_part["qty"];
                    ?>
                    <tr>
                        <td><?php
                            if($no_old != $no){
                                echo $no;
                                // echo $no_old;
                            }
                            ?></td>
                        <td><?=$job_issue_id?> </td>
                        <td><?=$part_number?></td>
                        <td><?=$part_name?></td>
                        <td><?=$qty?></td>
                    </tr>
                    <?
                    $no_old = $no;
                }


            }
            ?>
        </table>
    </div>

    <?
}else if ($status == "show_trading_sp"){
    $report_date = date_format_uk_into_database($_POST["report_date"]);
    $report_date_show = ($_POST["report_date"]);
    ?>
    <h4>วันที่ : <?=$report_date_show?></h4>
    <div class="table-responsive">   
        <table class="table table-bordered table-striped">
            <tr>
                <th>ลำดับ</th>
                <th>Job Id</th>
                <th>Part No</th>
                <th>Part Name</th>
                <th>Qty</th>
            </tr>

            <?
            include "connect_inv.php";
            $sql = "SELECT * FROM sp_issue_job 
            where  convert(varchar, date_close_packing, 101)  = '$report_date' 
            AND in_charge = 'Warehouse'
            AND job_issue_id not in (SELECT job_issue_id FROM sp_part_issue WHERE part_master_id in ( SELECT part_master_id FROM sp_part_master WHERE customer_id in ('CUS201801008','CUS201801001','CUS201801003','CUS201804001')))
            order by date_close_packing";
            $res = mssql_query($sql);
            $no=0;
            $no_old=0;
            while($row = mssql_fetch_array($res)){
                $job_issue_id = ($row["job_issue_id"]);
                
                $no++;


                $sql_part = "SELECT * FROM sp_part_issue as issue INNER JOIN sp_part_master as p_master
                ON issue.part_master_id = p_master.part_master_id
                WHERE job_issue_id='$job_issue_id' ";
                $res_part = mssql_query($sql_part);
                while($row_part = mssql_fetch_array($res_part)){
                    $part_number = $row_part["part_number"];
                    $part_name = $row_part["part_name"];
                    $qty = $row_part["qty"];
                    ?>
                    <tr>
                        <td><?php
                            if($no_old != $no){
                                echo $no;
                                // echo $no_old;
                            }
                            ?></td>
                        <td><?=$job_issue_id?> </td>
                        <td><?=$part_number?></td>
                        <td><?=$part_name?></td>
                        <td><?=$qty?></td>
                    </tr>
                    <?
                    $no_old = $no;
                }


            }
            ?>
        </table>
    </div>

    <?
}else if ($status == "show_qa_sab_ng"){
    $report_date = date_format_uk_into_database($_POST["report_date"]);
    $report_date_show = ($_POST["report_date"]);
    ?>
    <h4>วันที่ : <?=$report_date_show?></h4>
    <div class="table-responsive">   
        <table class="table table-bordered table-striped">
            <tr>
                <th>ลำดับ</th>
                <th>NG ID</th>
                <th>Issue No</th>
                <th>Part No</th>
                <th>Part Name</th>
                <th>Reason NG</th>
                <th>Remark</th>
                <th>Qty NG</th>
            </tr>

            <?
            include "connect_hq.php";
            $sql = "SELECT * FROM tbsaborder_partng WHERE convert(varchar, dateadd, 101)  = '$report_date'
            order by dateadd";
            $res = mssql_query($sql);
            $no=0;
            $no_old=0;
            while($row = mssql_fetch_array($res)){
                $ngtagID = ($row["ngtagID"]);
                $Issue_No = ($row["Issue_No"]);
                $reason_id = ($row["reason_ng"]);
                $reason_ng_other = lang_thai_from_database($row["reason_ng_other"]);
                $qtyng = ($row["qtyng"]);
                $no++;

                $sql_ng = "SELECT * FROM tbreason_ng WHERE reason_id='$reason_id'";
                $res_ng = mssql_query($sql_ng);
                $row_ng = mssql_fetch_array($res_ng);
                $reason_ng = lang_thai_from_database($row_ng["reason_ng"]);

                $sql_part = "SELECT * FROM tbsaborder 
                WHERE Issue_No='$Issue_No' ";
                $res_part = mssql_query($sql_part);
                $row_part = mssql_fetch_array($res_part);
                $Part_No = $row_part["Part_No"];
                $Part_Name = $row_part["Part_Name"];
                
                    ?>
                <tr>
                    <td><?=$no?></td>
                    <td><?=$ngtagID?> </td>
                    <td><?=$Issue_No?> </td>
                    <td><?=$Part_No?></td>
                    <td><?=$Part_Name?></td>
                    <td><?=$reason_ng?></td>
                    <td><?=$reason_ng_other?></td>
                    <td><?=$qtyng?></td>
                </tr>
                <?
                $no_old = $no;
                


            }
            ?>
        </table>
    </div>

    <?
}else if ($status == "show_qa_topre_ng"){
    $report_date = date_format_uk_into_database($_POST["report_date"]);
    $report_date_show = ($_POST["report_date"]);
    ?>
    <h4>วันที่ : <?=$report_date_show?></h4>
    <div class="table-responsive">   
        <table class="table table-bordered table-striped">
            <tr>
                <th>ลำดับ</th>
                <th>NG ID</th>
                <th>Topre Issue No</th>
                <th>Part No</th>
                <th>Part Name</th>
                <th>Reason NG</th>
                <th>Remark</th>
                <th>Qty NG</th>
            </tr>

            <?
            include "connect_topre.php";
            $sql = "SELECT * FROM tbtopreorder_ranng WHERE convert(varchar, create_date, 101)  = '$report_date'
            order by create_date";
            $res = mssql_query($sql);
            $no=0;
            $no_old=0;
            while($row = mssql_fetch_array($res)){
                $ngtagID = ($row["ngtagID"]);
                $Ran_No = ($row["Ran_No"]);
                $reason_id = ($row["reason_ng"]);
                $reason_ng_other = lang_thai_from_database($row["reason_ng_other"]);
                $qtyng = ($row["qtyng"]);
                $no++;

                $sql_ng = "SELECT * FROM tbreason_ng WHERE reason_id='$reason_id'";
                $res_ng = mssql_query($sql_ng);
                $row_ng = mssql_fetch_array($res_ng);
                $reason_ng = lang_thai_from_database($row_ng["reason_ng"]);

                $sql_part = "SELECT * FROM tbtopreorder 
                WHERE Ran_No='$Ran_No' ";
                $res_part = mssql_query($sql_part);
                $row_part = mssql_fetch_array($res_part);
                $Part_No = $row_part["Part_No"];
                $Part_Name = $row_part["Part_Name"];
                
                    ?>
                <tr>
                    <td><?=$no?></td>
                    <td><?=$ngtagID?> </td>
                    <td><?=$Ran_No?> </td>
                    <td><?=$Part_No?></td>
                    <td><?=$Part_Name?></td>
                    <td><?=$reason_ng?></td>
                    <td><?=$reason_ng_other?></td>
                    <td><?=$qtyng?></td>
                </tr>
                <?
                $no_old = $no;
                


            }
            ?>
        </table>
    </div>

    <?
}else if ($status == "show_return_rack_sab"){
    $report_date = date_format_uk_into_database($_POST["report_date"]);
    $report_date_show = ($_POST["report_date"]);
    ?>
    <h4>วันที่ : <?=$report_date_show?></h4>
    <div class="table-responsive">   
        <table class="table table-bordered table-striped">
            <tr>
                <th>ลำดับ</th>
                <th>NG ID</th>
                <th>Rack</th>
                <th>Return Qty </th>
            </tr>

            <?
            include "connect_inv.php";
            $sql = "SELECT *
            FROM material_ng_clear_log as ng_clear 
            INNER JOIN material_ng as ng
            ON ng_clear.ngtagID = ng.ngtagID
            WHERE convert(varchar, ng_clear.create_date, 101)  = '$report_date' 
            AND ng_clear.non_replacement_qty > 0
            AND mat_code IN (SELECT mat_code FROM material WHERE mat_use_type='Rack' AND (mat_cus1='SAB' or mat_cus2='SAB' or mat_cus3='SAB'))
            order by ng_clear.create_date
            ";
            $res = mssql_query($sql);
            $no=0;
            while($row = mssql_fetch_array($res)){
                $ngtagID = $row["ngtagID"];
                $non_replacement_qty = $row["non_replacement_qty"];
                $mat_code = $row["mat_code"];
                $no++;
                $sql_mate = "SELECT mat_name FROM material WHERE mat_code='$mat_code'";
                $res_mate = mssql_query($sql_mate);
                $row_mate = mssql_fetch_array($res_mate);
                $mat_name = lang_thai_from_database($row_mate["mat_name"]);
                
                ?>
                <tr>
                    <td><?=$no?></td>
                    <td><?=$ngtagID?> </td>
                    <td><?=$mat_name?> </td>
                    <td><?=$non_replacement_qty?></td>
                </tr>
                <?
            }

            ?>
        </table>
    </div>

    <?
}else if ($status == "show_return_rack_topre"){
    $report_date = date_format_uk_into_database($_POST["report_date"]);
    $report_date_show = ($_POST["report_date"]);
    ?>
    <h4>วันที่ : <?=$report_date_show?></h4>
    <div class="table-responsive">   
        <table class="table table-bordered table-striped">
            <tr>
                <th>ลำดับ</th>
                <th>NG ID</th>
                <th>Rack</th>
                <th>Return Qty </th>
            </tr>

            <?
            include "connect_inv.php";
            $sql = "SELECT *
            FROM material_ng_clear_log as ng_clear 
            INNER JOIN material_ng as ng
            ON ng_clear.ngtagID = ng.ngtagID
            WHERE convert(varchar, ng_clear.create_date, 101)  = '$report_date' 
            AND ng_clear.non_replacement_qty > 0
            AND mat_code IN (SELECT mat_code FROM material WHERE mat_use_type='Rack' AND (mat_cus1='Topre' or mat_cus2='Topre' or mat_cus3='Topre'))
            order by ng_clear.create_date
            ";
            $res = mssql_query($sql);
            $no=0;
            while($row = mssql_fetch_array($res)){
                $ngtagID = $row["ngtagID"];
                $non_replacement_qty = $row["non_replacement_qty"];
                $mat_code = $row["mat_code"];
                $no++;
                $sql_mate = "SELECT mat_name FROM material WHERE mat_code='$mat_code'";
                $res_mate = mssql_query($sql_mate);
                $row_mate = mssql_fetch_array($res_mate);
                $mat_name = lang_thai_from_database($row_mate["mat_name"]);
                
                ?>
                <tr>
                    <td><?=$no?></td>
                    <td><?=$ngtagID?> </td>
                    <td><?=$mat_name?> </td>
                    <td><?=$non_replacement_qty?></td>
                </tr>
                <?
            }

            ?>
        </table>
    </div>

    <?
}
    
?>