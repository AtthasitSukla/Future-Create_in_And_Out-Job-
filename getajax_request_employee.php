<?php
include("connect.php");
include("library.php");
session_start();
$status = $_POST['status'];
$create_empno = $_SESSION['admin_userid'];
$date_time=date("m/d/Y H:i:s");

if($status=='save_request_employee_ver1'){
    $departmentid = $_POST["departmentid"];
    $positionid_one = $_POST["positionid_one"];
    $positionid_two = $_POST["positionid_two"];
    $reason = lang_thai_into_database($_POST["reason"]);
    $male = $_POST["male"];
    $female = $_POST["female"];
    $target_date = date_format_uk_into_database($_POST["target_date"]);
    $cause = lang_thai_into_database($_POST["cause"]);


    $job_id_check = "HR01".date("y").date("m");
    $sql_check = "select top 1 job_id from tbrequest_employee where job_id like '$job_id_check%' order by id desc";
    $res = mssql_query($sql_check);
    $num = mssql_num_rows($res);
    if($num==0){
        $new_id = "HR01".date("y").date("m")."001";
    }else{
        //IT201803001
        $row = mssql_fetch_array($res);
        $tmp_newid = $row['job_id'];
        $tmp_newid = substr($tmp_newid,-4);
        $qid = (int)$tmp_newid + 1;
        $tmpid = "0000".$qid;
        $qdno = substr($tmpid,-3);
        $new_id = "HR01".date("y").date("m").$qdno;
    }

    $sql = "INSERT INTO tbrequest_employee 
        (job_id,departmentid,positionid_one,positionid_two,reason,male,female,target_date,cause,create_date,create_empno)
            VALUES
        ('$new_id','$departmentid','$positionid_one','$positionid_two','$reason','$male','$female','$target_date','$cause','$date_time','$create_empno')";
    mssql_query($sql);
    
}

if($status=="save_comment"){
    $job_id = $_POST["job_id"];
    $comment = lang_thai_into_database($_POST["comment"]);
    $update = "UPDATE tbrequest_employee set comment='$comment',comment_empno='$create_empno',comment_date='$date_time'
                Where job_id='$job_id'";
    mssql_query($update);
}
if($status=="save_status"){
    $job_id = $_POST["job_id"];
    $comment = lang_thai_into_database($_POST["comment"]);
    $status_save = $_POST["status_save"];
    $update = "UPDATE tbrequest_employee set comment='$comment',comment_empno='$create_empno',comment_date='$date_time',status='$status_save'
                Where job_id='$job_id'";
    mssql_query($update);
    //echo $job_id."kkk";
}
if($status=='save_request_employee'){
    $departmentid = $_POST["departmentid"];
    $positionid_one = $_POST["positionid_one"];
    $positionid_two = $_POST["positionid_two"];
    //$reason = lang_thai_into_database($_POST["reason"]);
    $male_one = $_POST["male_one"];
    $female_one = $_POST["female_one"];
    $target_date_one = $_REQUEST['target_date_one']==NULL ? "NULL" :date_format_uk_into_database($_REQUEST['target_date_one']);
	$target_date_one = $target_date_one=="NULL" ? $target_date_one : "'$target_date_one'";
    //$target_date_one = date_format_uk_into_database($_POST["target_date_one"]);
    $cause_one = lang_thai_into_database($_POST["cause_one"]);
    $male_two = $_POST["male_two"];
    $female_two = $_POST["female_two"];
    $target_date_two = $_REQUEST['target_date_two']==NULL ? "NULL" :date_format_uk_into_database($_REQUEST['target_date_two']);
	$target_date_two = $target_date_two=="NULL" ? $target_date_two : "'$target_date_two'";
    //$target_date_two = date_format_uk_into_database($_POST["target_date_two"]);
    $cause_two = lang_thai_into_database($_POST["cause_two"]);
    $male_three = $_POST["male_three"];
    $female_three = $_POST["female_three"];
    $target_date_three = $_REQUEST['target_date_three']==NULL ? "NULL" :date_format_uk_into_database($_REQUEST['target_date_three']);
	$target_date_three = $target_date_three=="NULL" ? $target_date_three : "'$target_date_three'";
    //$target_date_three = date_format_uk_into_database($_POST["target_date_three"]);
    $cause_three = lang_thai_into_database($_POST["cause_three"]);

    $job_id_check = "HR01".date("y").date("m");
    $sql_check = "select top 1 job_id from tbrequest_employee where job_id like '$job_id_check%' order by id desc";
    $res = mssql_query($sql_check);
    $num = mssql_num_rows($res);
    if($num==0){
        $new_id = "HR01".date("y").date("m")."001";
    }else{
        //IT201803001
        $row = mssql_fetch_array($res);
        $tmp_newid = $row['job_id'];
        $tmp_newid = substr($tmp_newid,-4);
        $qid = (int)$tmp_newid + 1;
        $tmpid = "0000".$qid;
        $qdno = substr($tmpid,-3);
        $new_id = "HR01".date("y").date("m").$qdno;
    }

    $sql = "INSERT INTO tbrequest_employee 
        (job_id,departmentid,positionid_one,positionid_two,male_one,female_one,target_date_one,cause_one,male_two,female_two,target_date_two,cause_two,male_three,female_three,target_date_three,cause_three,create_date,create_empno)
            VALUES
        ('$new_id','$departmentid','$positionid_one','$positionid_two','$male_one','$female_one',$target_date_one,'$cause_one','$male_two','$female_two',$target_date_two,'$cause_two','$male_three','$female_three',$target_date_three,'$cause_three','$date_time','$create_empno')";
    mssql_query($sql);
    $full_name = get_full_name($create_empno);
    $email = "pongthorn.w@ipacklogistics.com";
    $subject = "$full_name ขอกำลังคน";
    $body = "<a href='http://www.ipack-iwis.com/hrs/request_employee_list.php?status=view&job_id=$new_id'>คลิกดูรายละเอียด</a>";
    send_mail($email,$subject,$body);
    
}

?>