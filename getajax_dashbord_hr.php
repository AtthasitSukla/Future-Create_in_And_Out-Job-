<?php
//include("connect.php"); 
ini_set('session.bug_compat_warn', 0);
ini_set('session.bug_compat_42', 0);
include("library.php"); 

$date_time=date("m/d/Y H:i:s");
$status = $_POST['status'];


if($status=="chart_hbd"){
    include "connect.php";
    for($i=1;$i<=12;$i++){
        $sql_empno = "SELECT empno 
        from tbemployee
        where delstatus!=1 
        AND MONTH(birthdate)='$i'";
        $res_empno = mssql_query($sql_empno);
        $num_empno = mssql_num_rows($res_empno);

        $sql_father = "SELECT empno 
        from tbemployee 
        where delstatus!=1 
        AND MONTH(father_birthdate)='$i'";
        $res_father = mssql_query($sql_father);
        $num_father = mssql_num_rows($res_father);

        $sql_mother = "SELECT empno 
        from tbemployee 
        where delstatus!=1 
        AND MONTH(mother_birthdate)='$i'";
        $res_mother = mssql_query($sql_mother);
        $num_mother = mssql_num_rows($res_mother);


        $sum_birthday = $num_empno+$num_father+$num_mother;
        if($i==1){
            echo $sum_birthday;
        }else{
            echo "#".$sum_birthday;
        }
    }
   // $data = array(10,20);
    //echo "10,20";
}else if($status=="chart_late"){
    $mmonth = $_POST["mmonth"];
    $yyear = $_POST["yyear"];
    include "connect.php";

    $last_day = cal_days_in_month(CAL_GREGORIAN, $mmonth, $yyear);
    $count_late_HQ = "";
    $count_late_TSC = "";
    $count_late_OSW = "";
    for($i=1;$i<=$last_day;$i++){
        $loop_date = "$yyear-$mmonth-$i";
        $count_late=0;
        $sql_hq = "SELECT count(id) as count_late FROM tbatt 
        WHERE (att_status = 'in') 
        AND (shift = 'Day') 
        AND site='HQ'
        AND (CONVERT(varchar, attDateTime, 108) > '08:00:00') 
        AND att_real_date = '$loop_date'";
        $res_hq = mssql_query($sql_hq);
        $row_hq = mssql_fetch_array($res_hq);
        $count_late = $row_hq["count_late"];
        if($i==1){
            $count_late_HQ .= $count_late;
        }else{
            $count_late_HQ .= "#".$count_late;
        }
   
        $count_late = 0;
        $sql_TSC_Day = "SELECT count(id) as count_late_Day FROM tbatt 
        WHERE (att_status = 'in') 
        AND (shift = 'Day') 
        AND site='TSC'
        AND (CONVERT(varchar, attDateTime, 108) > '08:00:00') 
        AND att_real_date = '$loop_date'";
        $res_TSC_Day = mssql_query($sql_TSC_Day);
        $row_TSC_Day = mssql_fetch_array($res_TSC_Day);
        $count_late_Day = $row_TSC_Day["count_late_Day"];

        $sql_TSC_Night = "SELECT count(id) as count_late_Night FROM tbatt 
        WHERE (att_status = 'in') 
        AND (shift = 'Night') 
        AND site='TSC'
        AND (CONVERT(varchar, attDateTime, 108) > '20:20:00') 
        AND att_real_date = '$loop_date'";
        $res_TSC_Night = mssql_query($sql_TSC_Night);
        $row_TSC_Night = mssql_fetch_array($res_TSC_Night);
        $count_late_Night = $row_TSC_Night["count_late_Night"];

        $count_late=$count_late_Day+$count_late_Night;
        if($i==1){
            $count_late_TSC .= $count_late;
        }else{
            $count_late_TSC .= "#".$count_late;
        }
    
        $count_late = 0;
        $sql_OSW_Day = "SELECT count(id) as count_late_Day FROM tbatt 
        WHERE (att_status = 'in') 
        AND (shift = 'Day') 
        AND site='OSW'
        AND (CONVERT(varchar, attDateTime, 108) > '08:00:00') 
        AND att_real_date = '$loop_date'";
        $res_OSW_Day = mssql_query($sql_OSW_Day);
        $row_OSW_Day = mssql_fetch_array($res_OSW_Day);
        $count_late_Day = $row_OSW_Day["count_late_Day"];

        $sql_OSW_Night = "SELECT count(id) as count_late_Night FROM tbatt 
        WHERE (att_status = 'in') 
        AND (shift = 'Night') 
        AND site='OSW'
        AND (CONVERT(varchar, attDateTime, 108) > '20:00:00') 
        AND att_real_date = '$loop_date'";
        $res_OSW_Night = mssql_query($sql_OSW_Night);
        $row_OSW_Night = mssql_fetch_array($res_OSW_Night);
        $count_late_Night = $row_OSW_Night["count_late_Night"];

        $count_late=$count_late_Day+$count_late_Night;
        if($i==1){
            $count_late_OSW .= $count_late;
        }else{
            $count_late_OSW .= "#".$count_late;
        }
    }
    

    echo "$count_late_HQ###$count_late_TSC###$count_late_OSW###";

}else if($status=="chart_ot"){
    $mmonth = $_POST["mmonth"];
    $yyear = $_POST["yyear"];
    include "connect.php";

    $last_day = cal_days_in_month(CAL_GREGORIAN, $mmonth, $yyear);
    $count_ot_HQ = "";
    $count_ot_TSC = "";
    $count_ot_OSW = "";
    for($i=1;$i<=$last_day;$i++){
        $loop_date = "$yyear-$mmonth-$i";

        $count_ot_all=0;
        $sql_ot_HQ = "SELECT sum(irate1+irate1_5+irate2+irate3) as count_ot 
        FROM tbatt_approve
         WHERE iworkdate='$loop_date' 
         AND empno IN (SELECT empno FROM tbemployee WHERE site='HQ' AND delstatus='0' AND emp_level < 3 )";
        $res_ot_HQ = mssql_query($sql_ot_HQ);
        $row_ot_HQ = mssql_fetch_array($res_ot_HQ);
        $count_ot = $row_ot_HQ["count_ot"];

        $sql_ot_sup_HQ = "SELECT sum(irate1+irate1_5+irate2+irate3) as count_ot_sup 
        FROM tbatt_approve
        WHERE iworkdate='$loop_date' 
        AND empno IN (SELECT empno FROM tbemployee WHERE site='HQ' AND delstatus='0' AND emp_level = 3 )
        AND iworkdate IN (SELECT workdate FROM tbot_parameter where workdate = '$loop_date' AND (work_type='H Sat , Sun' OR work_type='H'))";
        $res_ot_sup_HQ = mssql_query($sql_ot_sup_HQ);
        $row_ot_sup_HQ = mssql_fetch_array($res_ot_sup_HQ);
        $count_ot_sup = $row_ot_sup_HQ["count_ot_sup"];

        $count_ot_all = $count_ot+$count_ot_sup;
        if($i==1){
            $count_ot_HQ .= $count_ot_all;
        }else{
            $count_ot_HQ .= "#".$count_ot_all;
        }

        $count_ot_all=0;
        $sql_ot_TSC = "SELECT sum(irate1+irate1_5+irate2+irate3) as count_ot 
        FROM tbatt_approve
         WHERE iworkdate='$loop_date' 
         AND empno IN (SELECT empno FROM tbemployee WHERE site='TSC' AND delstatus='0' AND emp_level < 3 )";
        $res_ot_TSC = mssql_query($sql_ot_TSC);
        $row_ot_TSC = mssql_fetch_array($res_ot_TSC);
        $count_ot = $row_ot_TSC["count_ot"];

        $sql_ot_sup_TSC = "SELECT sum(irate1+irate1_5+irate2+irate3) as count_ot_sup 
        FROM tbatt_approve
        WHERE iworkdate='$loop_date' 
        AND empno IN (SELECT empno FROM tbemployee WHERE site='TSC' AND delstatus='0' AND emp_level = 3 )
        AND iworkdate IN (SELECT workdate FROM tbot_parameter where workdate = '$loop_date' AND (work_type='H Sat , Sun' OR work_type='H'))";
        $res_ot_sup_TSC = mssql_query($sql_ot_sup_TSC);
        $row_ot_sup_TSC = mssql_fetch_array($res_ot_sup_TSC);
        $count_ot_sup = $row_ot_sup_TSC["count_ot_sup"];

        $count_ot_all = $count_ot+$count_ot_sup;
        if($i==1){
            $count_ot_TSC .= $count_ot_all;
        }else{
            $count_ot_TSC .= "#".$count_ot_all;
        }

        $count_ot_all=0;
        $sql_ot_OSW = "SELECT sum(irate1+irate1_5+irate2+irate3) as count_ot 
        FROM tbatt_approve
         WHERE iworkdate='$loop_date' 
         AND empno IN (SELECT empno FROM tbemployee WHERE site='OSW' AND delstatus='0' AND emp_level < 3 )";
        $res_ot_OSW = mssql_query($sql_ot_OSW);
        $row_ot_OSW = mssql_fetch_array($res_ot_OSW);
        $count_ot = $row_ot_OSW["count_ot"];

        $sql_ot_sup_OSW = "SELECT sum(irate1+irate1_5+irate2+irate3) as count_ot_sup 
        FROM tbatt_approve
        WHERE iworkdate='$loop_date' 
        AND empno IN (SELECT empno FROM tbemployee WHERE site='OSW' AND delstatus='0' AND emp_level = 3 )
        AND iworkdate IN (SELECT workdate FROM tbot_parameter where workdate = '$loop_date' AND (work_type='H Sat , Sun' OR work_type='H'))";
        $res_ot_sup_OSW = mssql_query($sql_ot_sup_OSW);
        $row_ot_sup_OSW = mssql_fetch_array($res_ot_sup_OSW);
        $count_ot_sup = $row_ot_sup_OSW["count_ot_sup"];

        $count_ot_all = $count_ot+$count_ot_sup;
        if($i==1){
            $count_ot_OSW .= $count_ot_all;
        }else{
            $count_ot_OSW .= "#".$count_ot_all;
        }
        
    }
    

    echo "$count_ot_HQ###$count_ot_TSC###$count_ot_OSW";

    
}else if($status=="chart_absenteeism"){
    $mmonth = $_POST["mmonth"];
    $yyear = $_POST["yyear"];
    $current_date = date('Y-m-d');
    include "connect.php";

    $last_day = cal_days_in_month(CAL_GREGORIAN, $mmonth, $yyear);
    $absenteeism_HQ = "";
    $absenteeism_TSC = "";
    $absenteeism_OSW = "";
    for($i=1;$i<=$last_day;$i++){
        $not_scan=0;
        $loop_date = "$yyear-$mmonth-$i";

        if((strtotime($loop_date) <= strtotime($current_date))){ //ไม่นับวันที่เป็นอนาคต

            $sql_work_HQ = "SELECT work_type FROM tbot_parameter WHERE workdate='$loop_date' AND site='HQ'";
            $res_work_HQ = mssql_query($sql_work_HQ);
            $row_work_HQ = mssql_fetch_array($res_work_HQ);
            $work_type_HQ = $row_work_HQ["work_type"];

            if(($work_type_HQ != 'H Sat , Sun' && $work_type_HQ != 'H')){//ไม่นับวันหยุด
                $sql_absenteeism_HQ = "SELECT count(id) as count_absenteeism_HQ FROM tbemployee
                WHERE site='HQ' 
                AND display_att='1'
                AND startdate<'$loop_date'
                AND empno not in (SELECT empno FROM tbleave_transaction 
                                where '$loop_date' between leavestartdate AND leaveenddate
                                AND statusapprove in ('New','Approve'))
                AND empno not in (SELECT empno FROM tbatt 
                    WHERE (att_status = 'in') 
                    AND site='HQ'
                    AND MONTH(att_real_date)='$mmonth'
                    AND YEAR(att_real_date)='$yyear'
                    AND Day(att_real_date)='$i')
                ";
                $res_absenteeism_HQ = mssql_query($sql_absenteeism_HQ);
                $row_absenteeism_HQ = mssql_fetch_array($res_absenteeism_HQ);
                $count_absenteeism_HQ = $row_absenteeism_HQ["count_absenteeism_HQ"];
            }else{
                $count_absenteeism_HQ = 0;
            }

            $sql_work_TSC = "SELECT work_type FROM tbot_parameter WHERE workdate='$loop_date' AND site='TSC'";
            $res_work_TSC = mssql_query($sql_work_TSC);
            $row_work_TSC = mssql_fetch_array($res_work_TSC);
            $work_type_TSC = $row_work_TSC["work_type"];

            if(($work_type_TSC != 'H Sat , Sun' && $work_type_TSC != 'H')){//ไม่นับวันหยุด
                $sql_absenteeism_TSC = "SELECT count(id) as count_absenteeism_TSC FROM tbemployee
                WHERE site='TSC' 
                AND display_att='1'
                AND startdate<'$loop_date'
                AND empno not in (SELECT empno FROM tbleave_transaction 
                                where '$loop_date' between leavestartdate AND leaveenddate
                                AND statusapprove in ('New','Approve'))
                AND empno not in (SELECT empno FROM tbatt 
                    WHERE (att_status = 'in') 
                    AND site='TSC'
                    AND MONTH(att_real_date)='$mmonth'
                    AND YEAR(att_real_date)='$yyear'
                    AND Day(att_real_date)='$i')
                ";
                $res_absenteeism_TSC = mssql_query($sql_absenteeism_TSC);
                $row_absenteeism_TSC = mssql_fetch_array($res_absenteeism_TSC);
                $count_absenteeism_TSC = $row_absenteeism_TSC["count_absenteeism_TSC"];
            }else{
                $count_absenteeism_TSC = 0;
            }


            $sql_work_OSW = "SELECT work_type FROM tbot_parameter WHERE workdate='$loop_date' AND site='OSW'";
            $res_work_OSW = mssql_query($sql_work_OSW);
            $row_work_OSW = mssql_fetch_array($res_work_OSW);
            $work_type_OSW = $row_work_OSW["work_type"];

            if(($work_type_OSW != 'H Sat , Sun' && $work_type_OSW != 'H')){//ไม่นับวันหยุด
                $sql_absenteeism_OSW = "SELECT count(id) as count_absenteeism_OSW FROM tbemployee
                WHERE site='OSW' 
                AND display_att='1'
                AND startdate<'$loop_date'
                AND empno not in (SELECT empno FROM tbleave_transaction 
                                where '$loop_date' between leavestartdate AND leaveenddate
                                AND statusapprove in ('New','Approve'))
                AND empno not in (SELECT empno FROM tbatt 
                    WHERE (att_status = 'in') 
                    AND site='OSW'
                    AND MONTH(att_real_date)='$mmonth'
                    AND YEAR(att_real_date)='$yyear'
                    AND Day(att_real_date)='$i')
                ";
                $res_absenteeism_OSW = mssql_query($sql_absenteeism_OSW);
                $row_absenteeism_OSW = mssql_fetch_array($res_absenteeism_OSW);
                $count_absenteeism_OSW = $row_absenteeism_OSW["count_absenteeism_OSW"];
            }else{
                $count_absenteeism_OSW = 0;
            }

        }else{
            $count_absenteeism_HQ=0;
            $count_absenteeism_TSC=0;
            $count_absenteeism_OSW=0;
        }
        if($i==1){
            $absenteeism_HQ .= $count_absenteeism_HQ;
            $absenteeism_TSC .= $count_absenteeism_TSC;
            $absenteeism_OSW .= $count_absenteeism_OSW;
        }else{
            $absenteeism_HQ .= "#".$count_absenteeism_HQ;
            $absenteeism_TSC .= "#".$count_absenteeism_TSC;
            $absenteeism_OSW .= "#".$count_absenteeism_OSW;
        }


    }
    // $absenteeism_TSC = "0#1";
    // $absenteeism_OSW = "3#2";
    echo "$absenteeism_HQ###$absenteeism_TSC###$absenteeism_OSW";

}else if($status=="chart_leave"){
    $mmonth = $_POST["mmonth"];
    $yyear = $_POST["yyear"];
    $current_date = date('Y-m-d');
    include "connect.php";

    $last_day = cal_days_in_month(CAL_GREGORIAN, $mmonth, $yyear);
    $leave_HQ = "";
    $leave_TSC = "";
    $leave_OSW = "";
    for($i=1;$i<=$last_day;$i++){
        $not_scan=0;
        $loop_date = "$yyear-$mmonth-$i";

        if((strtotime($loop_date) <= strtotime($current_date))){ //ไม่นับวันที่เป็นอนาคต

            
            $sql_leave_HQ = "SELECT count(id) as count_leave_HQ FROM tbemployee
            WHERE site='HQ' 
            AND display_att='1'
            AND empno in (SELECT empno FROM tbleave_transaction 
                            where '$loop_date' between leavestartdate AND leaveenddate
                            AND leavetypeid not in ('L0009')
                            AND statusapprove in ('New','Approve'))
            ";
            $res_leave_HQ = mssql_query($sql_leave_HQ);
            $row_leave_HQ = mssql_fetch_array($res_leave_HQ);
            $count_leave_HQ = $row_leave_HQ["count_leave_HQ"];

            $sql_leave_TSC = "SELECT count(id) as count_leave_TSC FROM tbemployee
            WHERE site='TSC' 
            AND display_att='1'
            AND empno in (SELECT empno FROM tbleave_transaction 
                            where '$loop_date' between leavestartdate AND leaveenddate
                            AND leavetypeid not in ('L0009')
                            AND statusapprove in ('New','Approve'))
            ";
            $res_leave_TSC = mssql_query($sql_leave_TSC);
            $row_leave_TSC = mssql_fetch_array($res_leave_TSC);
            $count_leave_TSC = $row_leave_TSC["count_leave_TSC"];

            $sql_leave_OSW = "SELECT count(id) as count_leave_OSW FROM tbemployee
            WHERE site='OSW' 
            AND display_att='1'
            AND empno in (SELECT empno FROM tbleave_transaction 
                            where '$loop_date' between leavestartdate AND leaveenddate
                            AND leavetypeid not in ('L0009')
                            AND statusapprove in ('New','Approve'))
            ";
            $res_leave_OSW = mssql_query($sql_leave_OSW);
            $row_leave_OSW = mssql_fetch_array($res_leave_OSW);
            $count_leave_OSW = $row_leave_OSW["count_leave_OSW"];
            

            
        }else{
            $count_leave_HQ=0;
            $count_leave_TSC=0;
            $count_leave_OSW=0;
        }
        if($i==1){
            $leave_HQ .= $count_leave_HQ;
            $leave_TSC .= $count_leave_TSC;
            $leave_OSW .= $count_leave_OSW;
        }else{
            $leave_HQ .= "#".$count_leave_HQ;
            $leave_TSC .= "#".$count_leave_TSC;
            $leave_OSW .= "#".$count_leave_OSW;
        }


    }
    echo "$leave_HQ###$leave_TSC###$leave_OSW";
}else if($status=="chart_training"){
    include ("connect.php");
    $total_target_HQ = 0;
    $total_target_TSC = 0;
    $total_target_OSW = 0;

    $sql_HQ = "SELECT        COUNT(mat_id) AS count_target_HQ,positionid
    FROM            tbtra_match
    WHERE        (positionid IN
                                 (SELECT        positionid
                                   FROM            tbemployee
                                   WHERE        (site = 'HQ')
                                   AND delstatus=0))
    Group by positionid";
    $res_HQ = mssql_query($sql_HQ);
    while($row_HQ = mssql_fetch_array($res_HQ)){
        $count_target_HQ = $row_HQ["count_target_HQ"];
        $positionid = $row_HQ["positionid"];

        $sql_emp_HQ = "SELECT        count(id) as count_emp_HQ
        FROM            tbemployee
        WHERE        (site = 'HQ') 
        AND delstatus=0
        AND positionid='$positionid'
        ";
        $res_emp_HQ = mssql_query($sql_emp_HQ);
        $row_emp_HQ = mssql_fetch_array($res_emp_HQ);
        $count_emp_HQ = $row_emp_HQ["count_emp_HQ"];

        $total_target_HQ = $total_target_HQ+($count_target_HQ * $count_emp_HQ);

    }

    $sql_TSC = "SELECT        COUNT(mat_id) AS count_target_TSC,positionid
    FROM            tbtra_match
    WHERE        (positionid IN
                                 (SELECT        positionid
                                   FROM            tbemployee
                                   WHERE        (site = 'TSC')
                                   AND delstatus=0))
    Group by positionid";
    $res_TSC = mssql_query($sql_TSC);
    while($row_TSC = mssql_fetch_array($res_TSC)){
        $count_target_TSC = $row_TSC["count_target_TSC"];
        $positionid = $row_TSC["positionid"];

        $sql_emp_TSC = "SELECT        count(id) as count_emp_TSC
        FROM            tbemployee
        WHERE        (site = 'TSC') 
        AND delstatus=0
        AND positionid='$positionid'
        ";
        $res_emp_TSC = mssql_query($sql_emp_TSC);
        $row_emp_TSC = mssql_fetch_array($res_emp_TSC);
        $count_emp_TSC = $row_emp_TSC["count_emp_TSC"];

        $total_target_TSC = $total_target_TSC+($count_target_TSC * $count_emp_TSC);

    }

    $sql_OSW = "SELECT        COUNT(mat_id) AS count_target_OSW,positionid
    FROM            tbtra_match
    WHERE        (positionid IN
                                 (SELECT        positionid
                                   FROM            tbemployee
                                   WHERE        (site = 'OSW')
                                   AND delstatus=0))
    Group by positionid";
    $res_OSW = mssql_query($sql_OSW);
    while($row_OSW = mssql_fetch_array($res_OSW)){
        $count_target_OSW = $row_OSW["count_target_OSW"];
        $positionid = $row_OSW["positionid"];

        $sql_emp_OSW = "SELECT        count(id) as count_emp_OSW
        FROM            tbemployee
        WHERE        (site = 'OSW') 
        AND delstatus=0
        AND positionid='$positionid'
        ";
        $res_emp_OSW = mssql_query($sql_emp_OSW);
        $row_emp_OSW = mssql_fetch_array($res_emp_OSW);
        $count_emp_OSW = $row_emp_OSW["count_emp_OSW"];

        $total_target_OSW = $total_target_OSW+($count_target_OSW * $count_emp_OSW);

    }

    
    $sql_ac_HQ = "SELECT count(tra_res) as ac_HQ from tbtra_group inner join tbtra_result on tbtra_group.group_id=tbtra_result.group_id
    where empno IN (SELECT   empno
                    FROM            tbemployee
                    WHERE        (site = 'HQ')
                    AND delstatus=0)  
	and tra_res=1";
    $res_ac_HQ = mssql_query($sql_ac_HQ);
    $row_ac_HQ = mssql_fetch_array($res_ac_HQ); 
    $ac_HQ = $row_ac_HQ["ac_HQ"];

    $sql_ac_TSC = "SELECT count(tra_res) as ac_TSC from tbtra_group inner join tbtra_result on tbtra_group.group_id=tbtra_result.group_id
    where empno IN (SELECT   empno
                    FROM            tbemployee
                    WHERE        (site = 'TSC')
                    AND delstatus=0)  
	and tra_res=1";
    $res_ac_TSC = mssql_query($sql_ac_TSC);
    $row_ac_TSC = mssql_fetch_array($res_ac_TSC); 
    $ac_TSC = $row_ac_TSC["ac_TSC"];

    $sql_ac_OSW = "SELECT count(tra_res) as ac_OSW from tbtra_group inner join tbtra_result on tbtra_group.group_id=tbtra_result.group_id
    where empno IN (SELECT   empno
                    FROM            tbemployee
                    WHERE        (site = 'OSW')
                    AND delstatus=0)  
	and tra_res=1";
    $res_ac_OSW = mssql_query($sql_ac_OSW);
    $row_ac_OSW = mssql_fetch_array($res_ac_OSW); 
    $ac_OSW = $row_ac_OSW["ac_OSW"];

    echo "$total_target_HQ#$total_target_TSC#$total_target_OSW###$ac_HQ#$ac_TSC#$ac_OSW";
}else if($status=="chart_turnover_rate"){
    $mmonth = $_POST["mmonth"];
    $yyear = $_POST["yyear"];
    $current_date = date('Y-m-d');
    include "connect.php";

    $last_day = cal_days_in_month(CAL_GREGORIAN, $mmonth, $yyear);

    $sql_in_HQ = "SELECT count(id) as turnover_rate_in_HQ
    FROM tbemployee
    WHERE MONTH(startdate) = '$mmonth'
    AND YEAR(startdate) = '$yyear'
    AND site='HQ'";
    $res_in_HQ = mssql_query($sql_in_HQ);
    $row_in_HQ = mssql_fetch_array($res_in_HQ);
    $turnover_rate_in_HQ = $row_in_HQ["turnover_rate_in_HQ"];

    $sql_out_HQ = "SELECT count(id) as turnover_rate_out_HQ
    FROM tbemployee
    WHERE MONTH(resigndate) = '$mmonth'
    AND YEAR(resigndate) = '$yyear'
    AND site='HQ'";
    $res_out_HQ = mssql_query($sql_out_HQ);
    $row_out_HQ = mssql_fetch_array($res_out_HQ);
    $turnover_rate_out_HQ = $row_out_HQ["turnover_rate_out_HQ"];

    $sql_in_TSC = "SELECT count(id) as turnover_rate_in_TSC
    FROM tbemployee
    WHERE MONTH(startdate) = '$mmonth'
    AND YEAR(startdate) = '$yyear'
    AND site='TSC'";
    $res_in_TSC = mssql_query($sql_in_TSC);
    $row_in_TSC = mssql_fetch_array($res_in_TSC);
    $turnover_rate_in_TSC = $row_in_TSC["turnover_rate_in_TSC"];

    $sql_out_TSC = "SELECT count(id) as turnover_rate_out_TSC
    FROM tbemployee
    WHERE MONTH(resigndate) = '$mmonth'
    AND YEAR(resigndate) = '$yyear'
    AND site='TSC'";
    $res_out_TSC = mssql_query($sql_out_TSC);
    $row_out_TSC = mssql_fetch_array($res_out_TSC);
    $turnover_rate_out_TSC = $row_out_TSC["turnover_rate_out_TSC"];

    $sql_in_OSW = "SELECT count(id) as turnover_rate_in_OSW
    FROM tbemployee
    WHERE MONTH(startdate) = '$mmonth'
    AND YEAR(startdate) = '$yyear'
    AND site='OSW'";
    $res_in_OSW = mssql_query($sql_in_OSW);
    $row_in_OSW = mssql_fetch_array($res_in_OSW);
    $turnover_rate_in_OSW = $row_in_OSW["turnover_rate_in_OSW"];

    $sql_out_OSW = "SELECT count(id) as turnover_rate_out_OSW
    FROM tbemployee
    WHERE MONTH(resigndate) = '$mmonth'
    AND YEAR(resigndate) = '$yyear'
    AND site='OSW'";
    $res_out_OSW = mssql_query($sql_out_OSW);
    $row_out_OSW = mssql_fetch_array($res_out_OSW);
    $turnover_rate_out_OSW = $row_out_OSW["turnover_rate_out_OSW"];


    echo "$turnover_rate_in_HQ#$turnover_rate_in_TSC#$turnover_rate_in_OSW###$turnover_rate_out_HQ#$turnover_rate_out_TSC#$turnover_rate_out_OSW";


}
?>