<?php
session_start();
//echo $_SESSION['production_line'];
include("connect.php");
include("library.php");

$status = $_POST['status'];
$date_time = date("m/d/Y H:i:s");
$time = time();

$admin_userid = $_SESSION['admin_userid'];

$job_type_array = array();
$sql_job = "SELECT * FROM tbot_request_job_type order by job_type";
$res_job = mssql_query($sql_job);
while($row_job = mssql_fetch_array($res_job)){
    $site = lang_thai_from_database($row_job["site"]);
    $job_type = lang_thai_from_database($row_job["job_type"]);
    $job_type_array[$site][] = $job_type;
    // array_push($job_type_array,$job_type);
}


if($status=="show_ot_list"){
    $paycode = $_POST["paycode"];
    $month = $_POST["month"];
    if($month!=""){
        $month_explode_arr = explode("-", $month);
        $mmonth = $month_explode_arr[1];
        $yyear = $month_explode_arr[0];
        $number = cal_days_in_month(CAL_GREGORIAN, $mmonth, $yyear);
        $startdate = $month . "-01";
        $enddate = $month . "-" . $number;
    }else if($paycode!=""){
        $select = "SELECT 
        paycode
        ,convert(varchar, startdate, 101)as  startdate
        ,convert(varchar, enddate, 101)as  enddate 
        from  tbpaycode 
        where paycode = '$paycode' ";
        $re = mssql_query($select);
        $num = mssql_num_rows($re);
    
        $row = mssql_fetch_array($re);
        $startdate = $row['startdate'];
        $enddate = $row['enddate'];
    }
    $sql_emp = "SELECT * FROM tbemployee WHERE empno='$admin_userid'";
    $res_emp = mssql_query($sql_emp);
    $row_emp = mssql_fetch_array($res_emp);
    $departmentid = $row_emp["departmentid"];
    if($departmentid=="D006" || $departmentid=="D004"){
        $condition_departmentid = "departmentid='D006' OR departmentid='D004'";
    }else if($admin_userid=="61011"){
        $condition_departmentid = "departmentid='D005' OR departmentid='D003' OR departmentid='D008'";
    }else{
        $sqlcheck = "SELECT emp_level , departmentid FROM tbemployee WHERE empno='$admin_userid'";
        $res_check = mssql_query($sqlcheck);
        $row_check = mssql_fetch_array($res_check);            
        $status_level = $row_check['emp_level'];
        $departmentidheck = $row_check['departmentid'];
        if($status_level >= 3  && $departmentidheck == 'D003'){
            $condition_departmentid = "departmentid IN ('$departmentid','D016')";
        }else{
        $condition_departmentid = "departmentid='$departmentid'";
        }
    }
   
    ?>
    <br>
    <div class='table-responsive'>
        <table class='table table-striped table-bordered'>
            <tr>
                <th>Date</th>
                <th>Shift</th>
                <th>Department</th>
                <th>Remark</th>
                <th>Edit</th>
                <th>Status</th>
                <th>Print</th>
                <!-- <th>Log</th> -->
            </tr>
            <?php
            $sql = "SELECT distinct job_ot_id, date_ot,shift,remark,status_approve FROM  tbot_request 
            WHERE ($condition_departmentid )
            AND (date_ot between '$startdate' AND '$enddate' or status_approve in ('Request','Approve') )
            order by date_ot desc";
          
            $res = mssql_query($sql);
            while($row = mssql_fetch_array($res)){
                $job_ot_id = $row["job_ot_id"];
                $date_ot = $row["date_ot"];
                $shift = $row["shift"];
                $remark = lang_thai_from_database($row["remark"]);
                $status_approve = $row["status_approve"];

                $arr_date = explode("-",$date_ot);
                $date_ot = $arr_date[2]."/".$arr_date[1]."/".((int)$arr_date[0]);
                

                $sql_job = "SELECT departmentid FROM tbot_request WHERE job_ot_id='$job_ot_id'";
			//	echo $sql_job;
                $res_job = mssql_query($sql_job);
                $row_job = mssql_fetch_array($res_job);
                $departmentid = $row_job['departmentid'];

                $sql_department = "SELECT department FROM tbdepartment WHERE departmentid='$departmentid'";
                $res_department = mssql_query($sql_department);
                $row_department = mssql_fetch_array($res_department);
                $department = $row_department["department"];
                if($departmentid=="D006" || $departmentid=="D004"){
                    
                    $department = "Planning & Admin";
                }else{
                    $department = $department;
                }
                ?>
                <tr>
                    <td><?=$date_ot?></td>
                    <td><?=$shift?></td>
                    <td><?=$department?></td>
                    <td><?=$remark?></td>
                    <td align="center"><a href="create_ot.php?status=create_ot&date_ot=<?=$date_ot?>&shift=<?=$shift?>&departmentid=<?=$departmentid?>">Edit</a></td>
                    <td align="center">
                        <?
                        if($status_approve=="Request"){
                            ?><a href="create_ot.php?status=approve_ot&date_ot=<?=$date_ot?>&shift=<?=$shift?>&departmentid=<?=$departmentid?>" class='btn btn-warning'><?=$status_approve?></a><?
                        }else if($status_approve=="Approve"){
                            ?><a href="create_ot.php?status=confirm_ot&date_ot=<?=$date_ot?>&shift=<?=$shift?>&departmentid=<?=$departmentid?>" class='btn btn-info'><?=$status_approve?></a><?

                        }else if($status_approve=="Confirm"){
                            ?><a href="create_ot.php?status=confirm_ot&date_ot=<?=$date_ot?>&shift=<?=$shift?>&departmentid=<?=$departmentid?>" class='btn btn-success'><?=$status_approve?></a><?
                        }
                        ?>
                    </td>
                    <td><a href="pop_ot.php?job_ot_id=<?=$job_ot_id?>" target="<?=$job_ot_id?>">Print</a></td>
                </tr>
                <?
            }
            ?>
        </table>
    </div>
    <?


}else if($status=="show_data_ot"){
    $date_ot = $_POST["date_ot"];
    $date_ot_uk = date_format_uk_into_database($date_ot);
    $shift = $_POST["shift"];
    $departmentid = $_POST["departmentid"];
 
    $number_of_day = date("w", strtotime($date_ot_uk));//6 = Saturday,0 = Sunday

    /*$sql_emp = "SELECT * FROM tbemployee WHERE empno='$empno'";
    $res_emp = mssql_query($sql_emp);
    $row_emp = mssql_fetch_array($res_emp);
    $departmentid = $row_emp["departmentid"];*/

    
    
    if($departmentid == "ALL"){
        $codition_department = "(tbposition.departmentid IN ('D003','D016') or tbposition.positionid IN ('P018','P034'))";
        $codition_department_request = "(tbot_request.departmentid IN ('D003','D016'))";
        $department = "OP TSC & TSC Sub";
       // print_r($codition_department_request);
    }else{
    $sql_department = "SELECT department FROM tbdepartment WHERE departmentid='$departmentid'";
    $res_department = mssql_query($sql_department);
    $row_department = mssql_fetch_array($res_department);
    $department = $row_department["department"];
    if($departmentid=="D006" || $departmentid=="D004"){
        $codition_department = "(tbposition.departmentid='D006' or tbposition.departmentid='D004' )";
        $codition_department_request = "(tbot_request.departmentid='D006' or tbot_request.departmentid='D004')";
        $department = "Planning & Admin";
    }else{
        $codition_department = "tbposition.departmentid='$departmentid' ";
        $codition_department_request = "tbot_request.departmentid='$departmentid' ";
        $department = $department;
    }
    }
    ?>
    <p>วันที่ : <?=$date_ot?></p>
    <p>Shift : <?=$shift?></p>
    <p>Department  : <?=$department?></p>
    <div class="table-responsive">
        <table class='table table-striped table-bordered'>
            <tr>
                <td colspan="7" align="right"></td>
                <td width='120px'>
                    <select name="all_status_ot" id="all_status_ot" class='form-control' onchange="all_status_ot()">
                        <option value="">สถานะ OT</option>
                        <option value="O">O</option>
                        <option value="X">X</option>
                        <option value="-">-</option>
                        <option value="#">#</option>
                    </select>
                </td>
                <td width='180px'><input type="text" class='form-control' id="all_start_time" onchange="all_start_time()" readonly></td>
                <td width='180px'><input type="text" class='form-control' id="all_end_time" onchange="all_end_time()" readonly></td>
                <td></td>
            </tr>
            <tr>
                <th>ลำดับ</th>
                <th>ชื่อ</th>
                <th>นามสกุล</th>
                <th>ตำแหน่ง</th>
                <th>FL</th>
                <th>Job</th>
                <th>อัตราจ้างพิเศษ (%)</th>
                <th>สถานะ OT</th>
                <th>เริ่ม</th>
                <th>สิ้นสุด</th>
                <th>หมายเหตุ</th>
                <th>กดเพื่อลบเวลาของคน ๆ นั้น</th>
            </tr>
            <?php
                  
            $sql_ot = "SELECT * FROM tbot_request WHERE date_ot='$date_ot_uk' AND $codition_department_request AND shift='$shift' ";
            $res_ot = mssql_query($sql_ot);
            $num_ot = mssql_num_rows($res_ot);
      
            if($num_ot > 0 ){
                $sql = "SELECT 
                    tbemployee.empno
                , tbemployee.firstname
                , tbemployee.lastname
                , tbemployee.firstname_en
                , tbemployee.lastname_en
                , tbemployee.nickname
                , tbemployee.site
                , tbemployee.delstatus
                , tbemployee.emp_level
                , tbemployee.departmentid
                , tbemployee.positionid
                , tbposition.positionname
                , tbot_request.fl_status
                , tbot_request.salary_rate
                , tbot_request.status_ot
                , tbot_request.start_time_approve
                , tbot_request.end_time_approve
                , tbot_request.remark_person
                , tbot_request.qty_male
                , tbot_request.qty_female
                , tbot_request.remark
                , tbot_request.job_type
                FROM  tbot_request INNER JOIN  tbemployee
                on tbot_request.empno = tbemployee.empno
                 INNER JOIN tbposition 
                ON tbemployee.positionid = tbposition.positionid 
                where $codition_department
                AND date_ot='$date_ot_uk'  AND shift='$shift'
                ORDER BY tbposition.sort_id,tbposition.positionid ,tbemployee.empno";
            }else{
                $sql = "SELECT 
                    tbemployee.empno
                    , tbemployee.firstname
                    , tbemployee.lastname
                    , tbemployee.firstname_en
                    , tbemployee.lastname_en
                    , tbemployee.nickname
                    , tbemployee.site
                    , tbemployee.delstatus
                    , tbemployee.emp_level
                    , tbemployee.departmentid
                    , tbemployee.positionid
                    , tbposition.positionname
                FROM  tbemployee INNER JOIN tbposition 
                ON tbemployee.positionid = tbposition.positionid 
                where tbemployee.display_att=1 AND tbemployee.emp_level < 4
                AND $codition_department
                ORDER BY tbposition.sort_id,tbposition.positionid ,tbemployee.empno";
                
                
            }

            $res = mssql_query($sql);
            $no=0;
            while($row = mssql_fetch_array($res)){
       
                $site = ($row["site"]);
                $empno = ($row["empno"]);
                $firstname = lang_thai_from_database($row["firstname"]);
                $lastname = lang_thai_from_database($row["lastname"]);
                $positionname = lang_thai_from_database($row["positionname"]);
         
                $fl_status = ($row["fl_status"]);
                $salary_rate = ($row["salary_rate"]);
                $status_ot = ($row["status_ot"]);
                $start_time_approve = ($row["start_time_approve"]);
                $end_time_approve = ($row["end_time_approve"]);
                $job_type = ($row["job_type"]);
            
                /* if u don't scan att,Lock OT */
                $sql_att = "SELECT * FROM tbatt WHERE empno='$empno' AND att_real_date='$date_ot_uk' AND shift='$shift'";
                $res_att = mssql_query($sql_att);
                $num_att = mssql_num_rows($res_att);
                
                /* if u don't scan att,Lock OT */

                $leavetypeid = "";
                /* show remark */
                if($num_ot > 0 ){

                    $remark_person = lang_thai_from_database($row["remark_person"]);

                }else{
                    if($num_att==0 && $number_of_day !=6 && $number_of_day !=0){
                        $sql_leave = "SELECT * FROM tbleave_transaction WHERE empno='$empno' AND ('$date_ot_uk' between leavestartdate AND  leaveenddate) AND statusapprove in ('New','Approve')";
                        $res_leave = mssql_query($sql_leave);
                        $num_leave = mssql_num_rows($res_leave);
                        if($num_leave > 0 ){
                            $row_leave = mssql_fetch_array($res_leave);
                            $leavetypeid = $row_leave["leavetypeid"];
                            $remark_person = get_leavename($leavetypeid);
                        }else{ 
                            $remark_person = "ไม่ได้ลงเวลา";
                        }
                        
                    }else{
                        $remark_person= "";
                    }
                }
                /* show remark */

                //echo "$empno att $num_att leave $leavetypeid <br>";
                /* if u don't scan att,Lock OT */
                if($num_att ==0  && $leavetypeid !='L0009' && $number_of_day !=6 && $number_of_day!=0){
                    $disabled_lock_ot = "disabled";
                    $disabled_lock_ot_time = "disabled";
                }else{
                    $disabled_lock_ot = "";
                    $disabled_lock_ot_time = "readonly";
                }
                /* if u don't scan att,Lock OT */

                $sql_shift ="SELECT * FROM tbot_mng WHERE empno='$empno' AND workdate='$date_ot_uk' ";
                $res_shift = mssql_query($sql_shift);
                $num_shift = mssql_num_rows($res_shift);
                if($num_shift==0 && $shift=="Day"){ //if OT-shift isn't seted ,shift is Day
                    $no++;
                    ?>
                    <tr>
                        <td><?=$no?></td>
                        <td><?=$firstname?></td>
                        <td><?=$lastname?></td>
                        <td><?=$positionname?></td>
                        <td>
                            <select name="fl_status[]" id="fl_status<?=$empno?>" class='form-control ' <?=$disabled_lock_ot?> >
                                <option value="no" <?if($fl_status=="no"){echo "selected";}?> >No</option>
                                <option value="yes" <?if($fl_status=="yes"){echo "selected";}?> >Yes</option>
                            </select>
                        </td>
                        <td>
                            <select name="job_type[]" id="job_type<?=$empno?>" class='form-control ' <?=$disabled_lock_ot?> >
                                <option value="">Select</option>
                                <?php
                                foreach($job_type_array[$site] as $job_type_ar){
                                    ?>
                                    <option value="<?=$job_type_ar?>" <?if($job_type==$job_type_ar){echo "selected";}?>><?=$job_type_ar?></option>
                                    <?
                                }
                                ?>
                            </select>
                        </td>
                        <td>
                            <select name="salary_rate[]" id="salary_rate<?=$empno?>" class='form-control ' >
                                <option value="100" <?if($salary_rate=="100"){echo "selected";}?> >100</option>
                                <option value="90" <?if($salary_rate=="90"){echo "selected";}?> >90</option>
                                <option value="75" <?if($salary_rate=="75"){echo "selected";}?> >75</option>
                                <option value="50" <?if($salary_rate=="50"){echo "selected";}?> >50</option>
                                <option value="0" <?if($salary_rate=="0"){echo "selected";}?> >0</option>
                            </select>
                        </td>
                        <td>
                            <input type="hidden"  name="empno[]" id="empno<?=$empno?>" value="<?=$empno?>">
                            <select name="status_ot[]" id="status_ot<?=$empno?>" class='form-control status_ot<?=$disabled_lock_ot?>' onchange="select_ot_status('<?=$empno?>')" <?=$disabled_lock_ot?> >
                                <option value="">สถานะ OT</option>
                                <option value="O" <?if($status_ot=="O"){echo "selected";}?> >O</option>
                                <option value="X" <?if($status_ot=="X"){echo "selected";}?> >X</option>
                                <option value="-" <?if($status_ot=="-" || $disabled_lock_ot=="disabled"){echo "selected";}?> >-</option>
                                <option value="#" <?if($status_ot=="#"){echo "selected";}?> >#</option>
                            </select>
                        </td>
                        <td><input type="text" name="start_time[]" id="start_time<?=$empno?>" class='form-control start_time<?=$disabled_lock_ot?>' value="<?=$start_time_approve?>" <?=$disabled_lock_ot_time?> ></td>
                        <td><input type="text" name="end_time[]" id="end_time<?=$empno?>" class='form-control end_time<?=$disabled_lock_ot?>' value="<?=$end_time_approve?>" <?=$disabled_lock_ot_time?> ></td>
                        <td><input type="text" name="remark_person[]" id="remark_person<?=$empno?>" class='form-control' value="<?=$remark_person?>"></td>
                        <td><button class="btn btn-warning" onclick="clear_time_ot('<?=$empno?>')">ลบเวลา</button></td>
                    </tr>
                    <?
                }else{
                    $sql_shift2 ="SELECT * FROM tbot_mng WHERE empno='$empno' AND workdate='$date_ot_uk' AND shift='$shift'";
                    $res_shift2 = mssql_query($sql_shift2);
                    $num_shift2 = mssql_num_rows($res_shift2);
                    
                    if($num_shift2>0){
                        $no++;
                        ?>
                        <tr>
                            <td><?=$no?></td>
                            <td><?=$firstname?></td>
                            <td><?=$lastname?></td>
                            <td><?=$positionname?></td>
                            <td>
                                <select name="fl_status[]" id="fl_status<?=$empno?>" class='form-control ' <?=$disabled_lock_ot?> >
                                    <option value="no" <?if($fl_status=="no"){echo "selected";}?> >No</option>
                                    <option value="yes" <?if($fl_status=="yes"){echo "selected";}?> >Yes</option>
                                </select>
                            </td>
                            <td>
                                <select name="job_type[]" id="job_type<?=$empno?>" class='form-control ' <?=$disabled_lock_ot?> >
                                    <option value="">Select</option>
                                    <?php
                                    foreach($job_type_array[$site] as $job_type_ar){
                                        ?>
                                        <option value="<?=$job_type_ar?>" <?if($job_type==$job_type_ar){echo "selected";}?>><?=$job_type_ar?></option>
                                        <?
                                    }
                                    ?>
                                </select>
                            </td>
                            <td>
                                <select name="salary_rate[]" id="salary_rate<?=$empno?>" class='form-control ' >
                                    <option value="100" <?if($salary_rate=="100"){echo "selected";}?> >100</option>
                                    <option value="90" <?if($salary_rate=="90"){echo "selected";}?> >90</option>
                                    <option value="75" <?if($salary_rate=="75"){echo "selected";}?> >75</option>
                                    <option value="50" <?if($salary_rate=="50"){echo "selected";}?> >50</option>
                                    <option value="0" <?if($salary_rate=="0"){echo "selected";}?> >0</option>
                                </select>
                            </td>
                            <td>
                                <input type="hidden"  name="empno[]" id="empno<?=$empno?>" value="<?=$empno?>">
                                <select name="status_ot[]" id="status_ot<?=$empno?>" class='form-control status_ot<?=$disabled_lock_ot?>' onchange="select_ot_status('<?=$empno?>')" <?=$disabled_lock_ot?> >
                                    <option value="">สถานะ OT</option>
                                    <option value="O" <?if($status_ot=="O"){echo "selected";}?> >O</option>
                                    <option value="X" <?if($status_ot=="X"){echo "selected";}?> >X</option>
                                    <option value="-" <?if($status_ot=="-" || $disabled_lock_ot=="disabled"){echo "selected";}?> >-</option>
                                    <option value="#" <?if($status_ot=="#"){echo "selected";}?> >#</option>
                                </select>
                            </td>
                            <td><input type="text" name="start_time[]" id="start_time<?=$empno?>" class='form-control start_time<?=$disabled_lock_ot?>' value="<?=$start_time_approve?>"  <?=$disabled_lock_ot_time?> ></td>
                            <td><input type="text" name="end_time[]" id="end_time<?=$empno?>" class='form-control end_time<?=$disabled_lock_ot?>' value="<?=$end_time_approve?>"  <?=$disabled_lock_ot_time?> ></td>
                            <td><input type="text" name="remark_person[]" id="remark_person<?=$empno?>" class='form-control' value="<?=$remark_person?>"></td>
                            <td><button class="btn btn-warning" onclick="clear_time_ot('<?=$empno?>')">ลบเวลา</button></td>
                        </tr>
                        <?
                    }
                }
            }
            ?>
        </table>
    </div>
    <?
    if($num_ot>0){
        $row_ot = mssql_fetch_array($res_ot);
        $remark = lang_thai_from_database($row_ot["remark"]);
        $qty_male = ($row_ot["qty_male"]);
        $qty_female = ($row_ot["qty_female"]);
    }
    ?><b>รายละเอียดที่ขอทำงานล่วงเวลา (OT) :</b><textarea name="remark" id="remark" cols="30" rows="10" class="form-control"><?=$remark?></textarea>
    <br>
     <div class="row">
        <div class="col-md-6">
            <div class="form-horizontal" >
                <div class="form-group">
                    <label class="control-label col-sm-3" for="qty_male">ชาย</label>
                    <div class="col-sm-2">
                        <input type="number" id="qty_male" class="form-control" value='<?=$qty_male?>'>
                    </div>
                    <div class="col-sm-2">
                        <p class='form-control-static'>คน</p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-3" for="qty_female">หญิง</label>
                    <div class="col-sm-2">
                        <input type="number" id="qty_female" class="form-control" value='<?=$qty_female?>'>
                    </div>
                    <div class="col-sm-2">
                        <p class='form-control-static'>คน</p>
                    </div>
                </div>
            </div>
        </div>
        <div class='col-sm-6 text-center' >
            <table>
                <tr>
                    <td colspan="2" align="center">สถานะคนที่ทำงานล่วงเวลา OT</td>    
                </tr>
                <tr>
                    <td align="center">O</td>
                    <td align="center">ทำโอที</td>
                </tr>
                <tr>
                    <td align="center">X</td>
                    <td align="center">ไม่ทำโอที</td>
                </tr>
                <tr>
                    <td align="center">-</td>
                    <td align="center">ไม่มาทำงาน</td>
                </tr>
                <tr>
                    <td align="center">#</td>
                    <td align="center">งดโอที</td>
                </tr>
            </table>
        </div>
    </div>
    <br>
    <center>
        <button class='btn btn-success' onclick='save_request_ot()'>Save</button>
    </center>
    <?

}else if ($status == "save_request_ot"){
    
    $date_ot = $_POST["date_ot"];
    $date_ot_uk = date_format_uk_into_database($date_ot);
    $shift = $_POST["shift"];
    $departmentid = $_POST["departmentid"];
    $empno_arr = $_POST["empno"];
    $fl_status_arr = $_POST["fl_status"];
    $salary_rate_arr = $_POST["salary_rate"];
    $status_ot_arr = $_POST["status_ot"];
    $start_time_arr = $_POST["start_time"];
    $end_time_arr = $_POST["end_time"];
    $remark_person_arr = ($_POST["remark_person"]);
    $remark = lang_thai_into_database($_POST["remark"]);
    $qty_male = $_POST["qty_male"];
    $qty_female = $_POST["qty_female"];
    $job_type_arr = $_POST["job_type"];

    $number_of_day = date("w", strtotime($date_ot_uk));//6 = Saturday,0 = Sunday
    
    $lock = 0;
    $sql_app = "SELECT * FROM tbot_request 
    WHERE date_ot < '$date_ot_uk' 
        AND departmentid='$departmentid' 
        AND shift='$shift' 
        AND status_approve in ('Request','Approve') ";
    $res_app = mssql_query($sql_app);
    $num_app = mssql_num_rows($res_app);
    if($num_app > 0 && $number_of_day !=6 && $number_of_day !=0){
        echo "Approve_before";
    }else{

        $job_ot_id = "OT".date("y").date("m");
        $sql_check = "SELECT top 1 job_ot_id from tbot_request where job_ot_id like '$job_ot_id%' order by job_ot_id desc";
        $res_check = mssql_query($sql_check);
        $num_check = mssql_num_rows($res_check);
        if($num_check ==0){
            $job_ot_id = "OT".date("y").date("m")."00001";
        }else{
            $row_check = mssql_fetch_array($res_check);
            $job_ot_id = $row_check["job_ot_id"];
            
            $tmp_newid = substr($job_ot_id,-5);
            $qid = (int)$tmp_newid + 1;
            $tmpid = "000000".$qid;
            $qdno = substr($tmpid,-5);
            $job_ot_id = "OT".date("y").date("m").$qdno;
        }

        $num_check_new = 0;
        foreach($empno_arr as $key => $empno){
            $fl_status = $fl_status_arr[$key];
            $salary_rate = $salary_rate_arr[$key];
            $status_ot = $status_ot_arr[$key];
            $start_time = $start_time_arr[$key];
            $end_time = $end_time_arr[$key];
            $job_type = lang_thai_into_database($job_type_arr[$key]);
            $remark_person = lang_thai_into_database($remark_person_arr[$key]);
    
            $sql_emp = "SELECT departmentid FROM tbemployee WHERE empno='$empno'";
            $res_emp = mssql_query($sql_emp);
            $row_emp = mssql_fetch_array($res_emp);
            $departmentid = $row_emp["departmentid"];
    
            $sql_ot = "SELECT * FROM tbot_request WHERE empno='$empno' AND date_ot='$date_ot_uk' AND departmentid = '$departmentid' AND shift='$shift' ";
            $res_ot = mssql_query($sql_ot);
            $num_ot = mssql_num_rows($res_ot);
            echo $sql_ot;
            if($num_ot==0){
                
                if($num_check_new==0){
                    echo $job_ot_id;
                    $num_check_new++;
                }
                
                $insert = "INSERT INTO tbot_request 
                    (
                        job_ot_id
                        , date_ot
                        , empno
                        , departmentid
                        , fl_status
                        , salary_rate
                        , status_ot
                        , remark_person
                        , shift
                        , qty_male
                        , qty_female
                        , job_type
                        , start_time_request
                        , end_time_request
                        , start_time_approve
                        , end_time_approve
                        , remark
                        , status_approve
    
                    ) VALUES
                    (
                        '$job_ot_id'
                        , '$date_ot_uk'
                        , '$empno'
                        , '$departmentid'
                        , '$fl_status'
                        , '$salary_rate'
                        , '$status_ot'
                        , '$remark_person'
                        , '$shift'
                        , '$qty_male'
                        , '$qty_female'
                        , '$job_type'
                        , '$start_time'
                        , '$end_time'
                        , '$start_time'
                        , '$end_time'
                        , '$remark'
                        , 'Request'
                    )";
                mssql_query($insert);
                     
               

                $insert_log = "INSERT INTO tbot_request_log
                    (
                        job_ot_id
                        , date_ot
                        , empno
                        , departmentid
                        , fl_status
                        , salary_rate
                        , status_ot
                        , remark_person
                        , shift
                        , qty_male
                        , qty_female
                        , job_type
                        , start_time
                        , end_time
                        , remark
                        , status_approve
                        , empno_submit
                        , date_submit
    
                    ) VALUES
                    (
                        '$job_ot_id'
                        , '$date_ot_uk'
                        , '$empno'
                        , '$departmentid'
                        , '$fl_status'
                        , '$salary_rate'
                        , '$status_ot'
                        , '$remark_person'
                        , '$shift'
                        , '$qty_male'
                        , '$qty_female'
                        , '$job_type'
                        , '$start_time'
                        , '$end_time'
                        , '$remark'
                        , 'Request'
                        , '$admin_userid'
                        , '$date_time'
                    )";
                mssql_query($insert_log);
                
            }else{
                $update = "UPDATE tbot_request set
                         fl_status = '$fl_status'
                        ,salary_rate = '$salary_rate'
                        , status_ot ='$status_ot'
                        , remark_person = '$remark_person'
                        , qty_male = '$qty_male'
                        , qty_female = '$qty_female'
                        , job_type = '$job_type'
                        , start_time_request = '$start_time'
                        , end_time_request = '$end_time'
                        , start_time_approve = '$start_time'
                        , end_time_approve = '$end_time'
                        , remark = '$remark'
                        , status_approve = 'Request'
                WHERE empno='$empno' AND date_ot='$date_ot_uk' AND departmentid = '$departmentid' AND shift='$shift'";
                mssql_query($update);

                $sqljob = "SELECT job_ot_id FROM tbot_request WHERE date_ot='$date_ot_uk' AND departmentid = '$departmentid' AND shift='$shift'";
                $resjob = mssql_query($sqljob);
                $rowjob = mssql_fetch_array($resjob);
                $job_ot_id = $rowjob["job_ot_id"];
                
                $insert_log = "INSERT INTO tbot_request_log
                    (
                        job_ot_id
                        , date_ot
                        , empno
                        , departmentid
                        , fl_status
                        , salary_rate
                        , status_ot
                        , remark_person
                        , shift
                        , qty_male
                        , qty_female
                        , job_type
                        , start_time
                        , end_time
                        , remark
                        , status_approve
                        , empno_submit
                        , date_submit
    
                    ) VALUES
                    (
                        '$job_ot_id'
                        , '$date_ot_uk'
                        , '$empno'
                        , '$departmentid'
                        , '$fl_status'
                        , '$salary_rate'
                        , '$status_ot'
                        , '$remark_person'
                        , '$shift'
                        , '$qty_male'
                        , '$qty_female'
                        , '$job_type'
                        , '$start_time'
                        , '$end_time'
                        , '$remark'
                        , 'Request'
                        , '$admin_userid'
                        , '$date_time'
                    )";
                mssql_query($insert_log);
            }
        }
    }

}else if($status=="save_approve_ot"){
    $date_ot = $_POST["date_ot"];
    $date_ot_uk = date_format_uk_into_database($date_ot);
    $shift = $_POST["shift"];
    $departmentid = $_POST["departmentid"];
    $empno_arr = $_POST["empno"];
    $fl_status_arr = $_POST["fl_status"];
    $salary_rate_arr = $_POST["salary_rate"];
    $status_ot_arr = $_POST["status_ot"];
    $start_time_arr = $_POST["start_time"];
    $end_time_arr = $_POST["end_time"];
    $remark_person_arr = ($_POST["remark_person"]);
    $remark = lang_thai_into_database($_POST["remark"]);
    $qty_male = $_POST["qty_male"];
    $qty_female = $_POST["qty_female"];
    $job_type_arr = $_POST["job_type"];

    $number_of_day = date("w", strtotime($date_ot_uk));//6 = Saturday,0 = Sunday
    
    $sql_admin = "SELECT emp_level FROM tbemployee WHERE empno='$admin_userid'";
    $res_admin = mssql_query($sql_admin);
    $row_admin = mssql_fetch_array($res_admin);
    $emp_level = $row_admin["emp_level"];
    if($emp_level < 3 || $emp_level ==" "){
        echo "Level_not_reached";
    }else{

        foreach($empno_arr as $key => $empno){
            $fl_status = $fl_status_arr[$key];
            $salary_rate = $salary_rate_arr[$key];
            $status_ot = $status_ot_arr[$key];
            $start_time = $start_time_arr[$key];
            $end_time = $end_time_arr[$key];
            $job_type = lang_thai_into_database($job_type_arr[$key]);
            $remark_person = lang_thai_into_database($remark_person_arr[$key]);
    
            $sql_emp = "SELECT departmentid FROM tbemployee WHERE empno='$empno'";
            $res_emp = mssql_query($sql_emp);
            $row_emp = mssql_fetch_array($res_emp);
            $departmentid = $row_emp["departmentid"];
    
            $sql_ot = "SELECT * FROM tbot_request WHERE empno='$empno' AND date_ot='$date_ot_uk' AND departmentid = '$departmentid' AND shift='$shift' ";
            $res_ot = mssql_query($sql_ot);
            $num_ot = mssql_num_rows($res_ot);
            
            $update = "UPDATE tbot_request set
                     fl_status = '$fl_status'
                    , salary_rate = '$salary_rate'
                    ,  status_ot ='$status_ot'
                    , remark_person = '$remark_person'
                    , qty_male = '$qty_male'
                    , qty_female = '$qty_female'
                    , job_type = '$job_type'
                    , start_time_request = '$start_time'
                    , end_time_request = '$end_time'
                    , start_time_approve = '$start_time'
                    , end_time_approve = '$end_time'
                    , remark = '$remark'
                    , status_approve = 'Approve'
            WHERE empno='$empno' AND date_ot='$date_ot_uk' AND departmentid = '$departmentid' AND shift='$shift'";
            mssql_query($update);
    
            $sqljob = "SELECT job_ot_id FROM tbot_request WHERE date_ot='$date_ot_uk' AND departmentid = '$departmentid' AND shift='$shift'";
            $resjob = mssql_query($sqljob);
            $rowjob = mssql_fetch_array($resjob);
            $job_ot_id = $rowjob["job_ot_id"];
            
            $insert_log = "INSERT INTO tbot_request_log
                (
                    job_ot_id
                    , date_ot
                    , empno
                    , departmentid
                    , fl_status
                    , salary_rate
                    , status_ot
                    , remark_person
                    , shift
                    , qty_male
                    , qty_female
                    , job_type
                    , start_time
                    , end_time
                    , remark
                    , status_approve
                    , empno_submit
                    , date_submit
    
                ) VALUES
                (
                    '$job_ot_id'
                    , '$date_ot_uk'
                    , '$empno'
                    , '$departmentid'
                    , '$fl_status'
                    , '$salary_rate'
                    , '$status_ot'
                    , '$remark_person'
                    , '$shift'
                    , '$qty_male'
                    , '$qty_female'
                    , '$job_type'
                    , '$start_time'
                    , '$end_time'
                    , '$remark'
                    , 'Approve'
                    , '$admin_userid'
                    , '$date_time'
                )";
            mssql_query($insert_log);
        }
    }

}else if($status=="save_confirm_ot"){
    $date_today_uk = date('m/d/Y');
    $date_ot = $_POST["date_ot"];
    $date_ot_uk = date_format_uk_into_database($date_ot);
    $shift = $_POST["shift"];
    $departmentid = $_POST["departmentid"];
    $empno_arr = $_POST["empno"];
    $fl_status_arr = $_POST["fl_status"];
    $salary_rate_arr = $_POST["salary_rate"];
    $status_ot_arr = $_POST["status_ot"];
    $start_time_arr = $_POST["start_time"];
    $end_time_arr = $_POST["end_time"];
    $remark_person_arr = ($_POST["remark_person"]);
    $remark = lang_thai_into_database($_POST["remark"]);
    $qty_male = $_POST["qty_male"];
    $qty_female = $_POST["qty_female"];
    $job_type_arr = $_POST["job_type"];
    
    $number_of_day = date("w", strtotime($date_ot_uk));//6 = Saturday,0 = Sunday
    
    $sql_admin = "SELECT emp_level FROM tbemployee WHERE empno='$admin_userid'";
    $res_admin = mssql_query($sql_admin);
    $row_admin = mssql_fetch_array($res_admin);
    $emp_level = $row_admin["emp_level"];
    if($emp_level < 3 || $emp_level ==" "){
        echo "Level_not_reached";
    }else if($date_today_uk  == $date_ot_uk){
        echo "Not_Today";
    }else{

        foreach($empno_arr as $key => $empno){
            $fl_status = $fl_status_arr[$key];
            $salary_rate = $salary_rate_arr[$key];
            $status_ot = $status_ot_arr[$key];
            $start_time = $start_time_arr[$key];
            $end_time = $end_time_arr[$key];
            $job_type = lang_thai_into_database($job_type_arr[$key]);
            $remark_person = lang_thai_into_database($remark_person_arr[$key]);
    
            $sql_emp = "SELECT departmentid FROM tbemployee WHERE empno='$empno'";
            $res_emp = mssql_query($sql_emp);
            $row_emp = mssql_fetch_array($res_emp);
            $departmentid = $row_emp["departmentid"];
    
            $sql_ot = "SELECT * FROM tbot_request WHERE empno='$empno' AND date_ot='$date_ot_uk' AND departmentid = '$departmentid' AND shift='$shift' ";
            $res_ot = mssql_query($sql_ot);
            $num_ot = mssql_num_rows($res_ot);
            
            $update = "UPDATE tbot_request set
                     fl_status = '$fl_status'
                    ,  salary_rate ='$salary_rate'
                    ,  status_ot ='$status_ot'
                    , remark_person = '$remark_person'
                    , qty_male = '$qty_male'
                    , qty_female = '$qty_female'
                    , job_type = '$job_type'
                    , start_time_approve = '$start_time'
                    , end_time_approve = '$end_time'
                    , remark = '$remark'
                    , status_approve = 'Confirm'
            WHERE empno='$empno' AND date_ot='$date_ot_uk' AND departmentid = '$departmentid' AND shift='$shift'";
           mssql_query($update);
    
            $sqljob = "SELECT job_ot_id FROM tbot_request WHERE date_ot='$date_ot_uk' AND departmentid = '$departmentid' AND shift='$shift'";
            $resjob = mssql_query($sqljob);
            $rowjob = mssql_fetch_array($resjob);
            $job_ot_id = $rowjob["job_ot_id"];
            
            $insert_log = "INSERT INTO tbot_request_log
                (
                    job_ot_id
                    , date_ot
                    , empno
                    , departmentid
                    , fl_status
                    , salary_rate
                    , status_ot
                    , remark_person
                    , shift
                    , qty_male
                    , qty_female
                    , job_type
                    , start_time
                    , end_time
                    , remark
                    , status_approve
                    , empno_submit
                    , date_submit
    
                ) VALUES
                (
                    '$job_ot_id'
                    , '$date_ot_uk'
                    , '$empno'
                    , '$departmentid'
                    , '$fl_status'
                    , '$salary_rate'
                    , '$status_ot'
                    , '$remark_person'
                    , '$shift'
                    , '$qty_male'
                    , '$qty_female'
                    , '$job_type'
                    , '$start_time'
                    , '$end_time'
                    , '$remark'
                    , 'Confirm'
                    , '$admin_userid'
                    , '$date_time'
                )";
            mssql_query($insert_log);
    
            $sql_att_in = "SELECT * FROM tbatt WHERE empno='$empno' AND att_real_date='$date_ot_uk' AND shift='$shift' AND att_status='in'";
            
            $res_att_in = mssql_query($sql_att_in);
            $num_att_in = mssql_num_rows($res_att_in);

            if($num_att_in>0){
    
                $row_att_in = mssql_fetch_array($res_att_in);
                $attDateTime_in = date("H:i", strtotime($row_att_in["attDateTime"]));
            }else{
                $attDateTime_in = "";
            }
            
            $sql_att_out = "SELECT * FROM tbatt WHERE empno='$empno' AND att_real_date='$date_ot_uk' AND shift='$shift' AND att_status='out'";
            $res_att_out = mssql_query($sql_att_out);
            $num_att_out = mssql_num_rows($res_att_out);
            if($num_att_out>0){
    
                $row_att_out = mssql_fetch_array($res_att_out);
                $attDateTime_out = date("H:i", strtotime($row_att_out["attDateTime"]));
            }else{
                $attDateTime_out = "";
            }
    
            $sql_site = "SELECT site FROM tbemployee WHERE empno = '$empno'";
            $res_site = mssql_query($sql_site);
            $row_site = mssql_fetch_array($res_site);
            $site = $row_site["site"];
            if($site == 'TSC Sub'){
            $select0 = "SELECT *,
                    convert(varchar, workdate, 101)as  workdate2,
                    convert(varchar, workdate, 103)as  workdate3
                    
            FROM    tbot_parameter where workdate between '" . $date_ot_uk . "' and '" . $date_ot_uk . "' and site='TSC'  order by workdate asc ";
            }else{
            $select0 = "SELECT *,
                    convert(varchar, workdate, 101)as  workdate2,
                    convert(varchar, workdate, 103)as  workdate3
                    
            FROM    tbot_parameter where workdate between '" . $date_ot_uk . "' and '" . $date_ot_uk . "' and site='$site'  order by workdate asc ";
            }
           $re0 = mssql_query($select0);
            $row0 = mssql_fetch_array($re0);
            $idayname_en = $row0["dayname_en"];

            $selects_sot = "SELECT convert(varchar, startotday, 108)as startotday ,convert(varchar, startotnight, 108)as startotnight from  tbsite where site='$site' ";
            $res_sot = mssql_query($selects_sot);
            $rows_sot = mssql_fetch_array($res_sot);
            $startotday = $rows_sot['startotday'];
            $startotnight = $rows_sot['startotnight'];
            
            $attDateTime1 = $date_ot_uk." ".$attDateTime_in.":00";
            if($status_ot=='O' && $end_time!=' '){ // OT
                $attDateTime2 = $date_ot_uk." ".$end_time.":00";
            }else{
                $attDateTime2 = $date_ot_uk." ".$attDateTime_out.":00";
            }
            // echo $date_ot_uk;
            $rate=0;
            if ($attDateTime2 != "" && $attDateTime1 != "") {
                if ($shift == 'Night') {
                    $attDateTime2 = strtotime("+1 day", strtotime($attDateTime2));
                    $attDateTime2 = date("m/d/Y H:i:s", $attDateTime2);
    
                    $workhours =  TimeDiff($date_ot_uk . " 20:00:00", $attDateTime2) - 1;
                    // echo $date_ot_uk.$attDateTime2;
                } else {
                    if ($emptype == 'temp') {
                        //ถ้า temp มาหลัง 8 โมง
                        if (TimeDiff($attDateTime1, $date_ot_uk . " 08:00:00") < 0) {
                            //ถ้า temp มาหลังเที่ยง
                            if (TimeDiff($attDateTime1, $date_ot_uk . " 12:00:00") < 0) {
                                $workhours =  TimeDiff($attDateTime1, $attDateTime2);
                            } else {
                                $workhours =  TimeDiff($attDateTime1, $attDateTime2) - 1;
                            }
                        } else {
                            $workhours =  TimeDiff($date_ot_uk . " 08:00:00", $attDateTime2) - 1;
                        }
    
                    } else {
                        $workhours =  TimeDiff($date_ot_uk . " 08:00:00", $attDateTime2) - 1;
                        
                    }
                    
                }
                // echo $workhours;
                // die;
                // คำนวณเวลาถ้ามีการมาทำงาน
                if ($workhours > 0) {
                    if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H' || $row0['work_type'] == 'H Sat') {
    
                        $otin = "08:00:00";
                        $datecheck = $date_ot_uk . " " . $otin;
                        $xx = 0;
                        $yy = 0;
                        $otout = "";
                        $otout2 = "";
                        $haveot = TimeDiff($datecheck, $attDateTime2);
    
                        $otin = $datecheck;
                    } else {
                        //echo "shift=".$shift;
                        if ($shift == 'Night') {
                            $attDate2 = strtotime("+1 day", strtotime($date_ot_uk));
                            $attDate2 = date("m/d/Y", $attDate2);
                            $otin = $startotnight;
                            $datecheck = $attDate2 . " " . $otin;
                            $otin = $datecheck;
                            $xx = 0;
                            $yy = 0;
                            $otout = "";
                            $otout2 = "";
                            $haveot = TimeDiff($datecheck, $attDateTime2);
                                // echo $haveot;
                            if ($status_ot == "O") {
                                //	echo "haveot";
                                for ($ii = 0; $ii <= 50; $ii++) {
                                    $time = strtotime(date($datecheck));
                                    $datecheck = date("m/d/Y H:i:s", strtotime("+15 minutes", $time));
                                    //echo $datecheck."=";
                                    //	echo TimeDiff($datecheck,$attDateTime2);
    
                                    //	echo "<BR>";
    
                                    if (TimeDiff($datecheck, $attDateTime2) < 0) {
    
                                        if ($xx == 0) {
                                            if (TimeDiff($datecheck, $attDateTime2) > -0.2) {
                                                //echo $datecheck;
                                                $otout =  $datecheck;
                                                $xx = 1;
                                            } else {
                                                $otout = $datecheck2;
                                                $xx = 1;
                                            }
                                        }
                                    } else {
                                        $datecheck2 = $datecheck;
                                    }
                                }
                            }
                        } else {
    
    
                            $otin = $startotday;
    
                            $datecheck = $date_ot_uk . " " . $otin;
                            //$datecheck = $date_ot_uk." 17:00:00";
                            $datecheck2 = '';
                            $otin = $datecheck;
                            $xx = 0;
                            $yy = 0;
                            $otout = "";
                            $otout2 = "";
                            $haveot = TimeDiff($datecheck, $attDateTime2);
                            //echo " Have ot : $haveot";
                            if ($status_ot == "O") {
                                //echo $haveot;
                                //	echo "haveot";
    
    
                                for ($ii = 0; $ii <= 50; $ii++) {
                                    $time = strtotime(date($datecheck));
    
                                    //echo $time;
    
                                    $datecheck = date("m/d/Y H:i:s", strtotime("+15 minutes", $time));
    
                                    //echo $datecheck."=";
                                    //echo TimeDiff($datecheck,$attDateTime2);
    
    
                                    //echo $datecheck;
                                    //echo "<BR>";
    
                                    if (TimeDiff($datecheck, $attDateTime2) < 0) {
    
                                        if ($xx == 0) {
                                            if (TimeDiff($datecheck, $attDateTime2) > -0.2) {
    
                                                //echo ">>".$datecheck."<<<br>";
    
                                                $otout =  $datecheck;
                                                $xx = 1;
                                            } else {
                                                $otout = $datecheck2;
                                                $xx = 1;
                                            }
                                        }
                                    } else {
                                        $datecheck2 = $datecheck;
                                    }
                                }
                            }
                        }
                    }
                }
    
    
    
                
                if ($status_ot == "O") {
                    $otout = $attDateTime2;
                    //  echo "workhours=".$workhours;
                    // echo $otout;
                    $total_ot = TimeDiff($otin, $otout);
                    // echo "total ot $otin, $otout =".$total_ot;
                    //echo $workhours;
                    $workhours_wo_ot = $workhours - $total_ot;
    
                    //echo (int)$workhours_wo_ot;
                    //	echo $total_ot+8;
                    //echo $workhours - $total_ot;
                } else {
                    $workhours_wo_ot = $workhours;
                    $total_ot = "";
                    $otout = "";
                    $otin = "";
                }
            }
            if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H' || $row0['work_type'] == 'H Sat') {
    
                $otin = $attDate1 . " " . $attTime1;
                $otout = $attDate2 . " " . $attTime2;
                $total_ot = (int) $workhours;
                $workhours_wo_ot = 0;
    
                $iworkhours = $total_ot;
            }else{
                $iworkhours = (int) $workhours_wo_ot + $total_ot;
            }
    
            /* OT คำนวณ rate OT */
            if ($status_ot == "O") {
    
      if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H' || $row0['work_type'] == 'H Sat') {
    
    
                    $calc_rate = $attDate2 . " " . $otout;
    
                    if (TimeDiff($calc_rate, $attDate2 . " 08:00:00") < 0) {
                        $rate = $row0['rate1'];
                    } else if (TimeDiff($attDate2 . " 08:00:00", $calc_rate) < 0) {
                        $rate = $row0['rate2'];
                    } else if (TimeDiff($attDate2 . " 00:00:00", $calc_rate)) {
    
                        $rate = $row0['rate3'];
                    } else if (TimeDiff($attDate2 . " 05:00:00", $calc_rate)) {
    
                        $rate = $row0['rate4'];
                    }
					//ถ้าเป็น Holiday ได้ OT rate 2
                    if ($row0['work_type'] == 'H') {
                        if ($emptype == 'temp') {
                            $rate = 2;
                        } else {
                            $rate = 2;
                        }
                    }
    				//ถ้าเป็น SAT, SUN : Temp ได้ OT rate 2, Emp ได้ OT rate 1
					//ถ้าเวลาออกงาน เลย Start OT Day, Start OT Night ให้คิดเป็น OT rate 3
                    if ($row0['work_type'] == 'H Sat , Sun') {
                        if ($emptype == 'temp') {
                            $rate = 2;
                        } else {
                            $rate = 1;
                        }
                    }
					//if ($shift == 'Night') {
					
                } else {
    
    
                    $calc_rate = $attDate2 . " " . $otout;


                    if (TimeDiff($calc_rate, $attDate2 . " " . $startotday) < 0) {
                        $rate = $row0['rate1'];
                    }
                    if (TimeDiff($attDate2 . " " . $startotday, $calc_rate) < 0) {
                        $rate = $row0['rate2'];
                    }
                    if (TimeDiff($attDate2 . " 00:00:00", $calc_rate)) {
    
                        $rate = $row0['rate3'];
                    }
                    if (TimeDiff($attDate2 . " 05:00:00", $calc_rate)) {
    
                        $rate = $row0['rate4'];
                    }
                    
                    
                }


                if ($nocalot == "yes") {
    
                    $rate = '1';
                }
            } else {
                $rate = "";
            }
			/* OT คำนวณ rate OT */

            $iattDateTime1 = "";
            $iattDateTime2 = "";
            $sql_leave = "SELECT * FROM tbleave_transaction WHERE empno='$empno' AND ('$date_ot_uk' between leavestartdate AND  leaveenddate) AND statusapprove in ('New','Approve') AND leavetypeid='L0009'";
            $res_leave = mssql_query($sql_leave);
            $num_leave = mssql_num_rows($res_leave);
            //echo $sql_leave.$num_leave;
           
            if($num_leave > 0 ){ //ถ้าเกิดมีการทำงานนอกสถานที่
                $row_leave = mssql_fetch_array($res_leave);
                $iattDateTime1 = $date_ot_uk." ".date("H:i",$row_leave["start_time"]);
                $iattDateTime2 = $date_ot_uk." ".date("H:i",$row_leave["end_time"]);
            }else{

                if($num_att_in>0){

                    $iattDateTime1 = $row_att_in["attDateTime"];
                }else{
                    $iattDateTime1="";
                }
               
                if($num_att_out>0){

                    $iattDateTime2 = $row_att_out["attDateTime"];
                }else{
                    $iattDateTime2 ="";
                }
                // if($empno=="56022"){
                //     echo $sql_att_in.$iattDateTime1;
                // }
            }
           
            // echo "START $status_ot  $start_time ";
            if($status_ot=="O" && $start_time!=' '){
                $iotin = $date_ot_uk." ".$start_time.":00";
                $iotout = $date_ot_uk." ".$end_time.":00";
                $remark_person .= "OT $start_time - $end_time";
            }else{
                $iotin = "";
                $iotout = "";
            }
          
            if($iworkhours<0){
                $iworkhours=0;
                $inormal=0;
                $irate1=0;
                $irate1_5=0;
                $irate2=0;
                $irate3=0;
            }else{
                $total_ot= floor($total_ot * 2) / 2; // ปัดเศษนับเฉพาะจำนวนเต็มและ 0.5 เท่านั้น
              
                if($rate=="1"){
                    $irate1 = $total_ot;
                }else{
                    $irate1 = "0";
                }
                if($rate=="1.5"){
                    $irate1_5 = $total_ot;
                }else{
                    $irate1_5 = "0";
                }
                if($rate=="2"){
                    $irate2 = $total_ot;
                }else{
                    $irate2 = "0";
                }
                if($rate=="3"){
                    $irate3 = $total_ot;
                }else{
                    $irate3 = "0";
                }
                if($shift=="Night"){
                    $ishiftval = "yes";
                }else{
                    $ishiftval="";
                }
                $inormal = (int)$workhours_wo_ot;
            }

            /* TBATT_APPROVE will be inserted  becuase OT don't confirm  */
            $sql_paycode = "SELECT paycode,startdate,enddate FROM tbpaycode WHERE '$date_ot_uk' Between startdate AND enddate";
            $res_paycode = mssql_query($sql_paycode);
            $row_paycode = mssql_fetch_array($res_paycode);
            $paycode = $row_paycode["paycode"];
            $startdate = $row_paycode["startdate"];
            $enddate = $row_paycode["enddate"];
         
            // Start date
            $start_date_loop = $startdate;
            // End date
            $end_date_loop = $date_ot_uk;

            while (strtotime($start_date_loop) < strtotime($end_date_loop)) {
                $iworkdate_insert = $start_date_loop;
                $sql_att_insert = "SELECT * FROM tbatt_approve WHERE iworkdate='$iworkdate_insert' AND empno='$empno' ";
                $res_att_insert = mssql_query($sql_att_insert);
                $num_att_insert = mssql_num_rows($res_att_insert);
                
                if($num_att_insert == 0){
                 // $insert = "";
                    $select_day = "SELECT dayname_en
                    FROM    tbot_parameter 
                    where workdate between '" . $start_date_loop . "' and '" . $start_date_loop . "' 
                    order by workdate asc ";
                    $re_day = mssql_query($select_day);
                    $row_day = mssql_fetch_array($re_day);
                    $idayname_en_insert = $row_day["dayname_en"];

                    $sql_shift ="SELECT shift FROM tbot_mng WHERE empno='$empno' AND workdate='$start_date_loop' ";
                    $res_shift = mssql_query($sql_shift);
                    $num_shift = mssql_num_rows($res_shift);
                   
                    if($num_shift==0 ){
                        $shift_insert = "Day";
                    }else{
                        $row_shift = mssql_fetch_array($res_shift);
                        $shift_insert = $row_shift["shift"];
                    }
                    $iattDateTime1_insert = "";
                    $iattDateTime2_insert = "";
                    $sql_leave_insert = "SELECT * FROM tbleave_transaction WHERE empno='$empno' AND ('$start_date_loop' between leavestartdate AND  leaveenddate) AND statusapprove in ('New','Approve') AND leavetypeid='L0009'";
                    $res_leave_insert = mssql_query($sql_leave_insert);
                    $num_leave_insert = mssql_num_rows($res_leave_insert);
                    if($num_leave_insert > 0 ){ //ถ้าเกิดมีการทำงานนอกสถานที่
                        $row_leave_insert = mssql_fetch_array($res_leave_insert);
                        $iattDateTime1_insert = $date_ot_uk." ".$row_leave_insert["start_time"];
                        $iattDateTime2_insert = $date_ot_uk." ".$row_leave_insert["end_time"];
                    }else{
                        $sql_att_in_insert = "SELECT * FROM tbatt WHERE empno='$empno' AND att_real_date='$start_date_loop' AND shift='$shift_insert' AND att_status='in'";
                        $res_att_in_insert = mssql_query($sql_att_in_insert);
                        $num_att_in_insert = mssql_num_rows($res_att_in_insert);
                        $row_att_in_insert = mssql_fetch_array($res_att_in_insert);
                        $iattDateTime1_insert = $row_att_in_insert["attDateTime"];

                        $sql_att_out_insert = "SELECT * FROM tbatt WHERE empno='$empno' AND att_real_date='$start_date_loop' AND shift='$shift_insert' AND att_status='out'";
                        $res_att_out_insert = mssql_query($sql_att_out_insert);
                        $num_att_out_insert = mssql_num_rows($res_att_out_insert);
                        $row_att_out_insert = mssql_fetch_array($res_att_out_insert);
                        $iattDateTime2_insert = $row_att_out_insert["attDateTime"];
                    }
                    
                    $workhours_insert =  TimeDiff($iattDateTime1_insert, $iattDateTime2_insert) - 1;

                    if($workhours_insert < 0 || $workhours_insert>24){
                        $workhours_insert = 0;
                    }else{
                        if($workhours_insert>8){
                            $workhours_insert = 8;
                        }else{

                            $workhours_insert = (int)$workhours_insert;
                        }
                    }

                    
                    $insert_approve_default = "INSERT INTO tbatt_approve ( iworkdate, idayname_en, iShift, iattDateTime1, iattDateTime2, iworkhours, iotin, iotout, inormal, irate1, irate1_5, irate2, irate3, iremark, ifl, ishiftval, paycode, empno, status_approve,salary_rate)
                                                    VALUES ('$iworkdate_insert','$idayname_en_insert','$shift_insert','$iattDateTime1_insert','$iattDateTime2_insert','$workhours_insert','','','0','0','0','0','0','','no','','$paycode','$empno','1','100')";
                    mssql_query($insert_approve_default);

                }

                $start_date_loop = date ("Y-m-d", strtotime("+1 day", strtotime($start_date_loop)));
            }
            /* TBATT_APPROVE will be inserted  becuase OT don't confirm  */



            // echo "<br>iworkdate : ".$date_ot_uk;
            // echo "<br>idayname_en : ".$idayname_en;
            // echo "<br>iShift : ".$shift;
            // echo "<br>iattDateTime1 : ".$iattDateTime1;
            // echo "<br>iattDateTime2 : ".$iattDateTime2;
            // echo "<br>iworkhours : ".$iworkhours;
            // echo "<br>iotin : ".$iotin;
            // echo "<br>iotout : ".$iotout;
            // echo "<br>inormal : ".$inormal;
            // echo "<br>irate1 $rate : ".$irate1;
            // echo "<br>irate1_5 $rate : ".$irate1_5;
            // echo "<br>irate2 $rate : ".$irate2;
            // echo "<br>irate3 $rate : ".$irate3;
            // echo "<br>iremark  : ".$remark_person;
            // echo "<br>ifl  : ".$fl_status;
            // echo "<br>ishiftval  : ".$ishiftval;
            // echo "<br>paycode  : ".$paycode;
            // echo "<br>empno  : ".$empno;
            // echo "<br>status_approve  : 1";
          
            if($iworkhours>8 && $status_ot!="O"){
                $iworkhours = 8;
            }
            $iworkhours= floor($iworkhours * 2) / 2; // ปัดเศษนับเฉพาะจำนวนเต็มและ 0.5 เท่านั้น
            $sql_att = "SELECT * FROM tbatt_approve WHERE iworkdate='$date_ot_uk' AND empno='$empno' AND iShift='$shift'";
            $res_att = mssql_query($sql_att);
            $num_att = mssql_num_rows($res_att);
          
            if($num_att == 0){
                $insert_att="INSERT INTO tbatt_approve
                            (
                                    iworkdate
                                    , idayname_en
                                    , iShift
                                    , iattDateTime1
                                    , iattDateTime2
                                    , iworkhours
                                    , iotin
                                    , iotout
                                    , inormal
                                    , irate1
                                    , irate1_5
                                    , irate2
                                    , irate3
                                    , iremark
                                    , ifl
                                    , ishiftval
                                    , paycode
                                    , empno
                                    , status_approve
                                    , salary_rate
                            )
                            VALUES
                            (
                                    '$date_ot_uk'
                                , '$idayname_en'
                                , '$shift'
                                , '$iattDateTime1'
                                , '$iattDateTime2'
                                , '$iworkhours'
                                , '$iotin'
                                , '$iotout'
                                , '$inormal'
                                , '$irate1'
                                , '$irate1_5'
                                , '$irate2'
                                , '$irate3'
                                , '$remark_person'
                                , '$fl_status'
                                , '$ishiftval'
                                , '$paycode'
                                , '$empno'
                                , '1'
                                , '$salary_rate'
                            )
                            ";
                   mssql_query($insert_att);
            }else{
                $row_att = mssql_fetch_array($res_att);
    
                $update_att="UPDATE tbatt_approve set
                           
                                idayname_en ='$idayname_en'
                            , iattDateTime1 = '$iattDateTime1'
                            , iattDateTime2 = '$iattDateTime2'
                            , iworkhours = '$iworkhours'
                            , iotin = '$iotin'
                            , iotout = '$iotout'
                            , inormal = '$inormal'
                            , irate1 = '$irate1'
                            , irate1_5 = '$irate1_5'
                            , irate2 = '$irate2'
                            , irate3 = '$irate3'
                            , iremark = '$remark_person'
                            , ifl = '$fl_status'
                            , ishiftval = '$ishiftval'
                            , paycode = '$paycode'
                            , salary_rate = '$salary_rate'
                    WHERE iworkdate='$date_ot_uk' AND empno='$empno' AND iShift='$shift'
                            ";
                    mssql_query($update_att);
                // echo $update_att;
            }
            
            
        } // LOOP foreach

    } // if else Level not reached

    
}
?>