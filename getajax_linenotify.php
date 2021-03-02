<? 
include("connect.php");  
include("library.php");  
?>
<?
date_default_timezone_set("Asia/Bangkok");
$date_time = date("m/d/Y H:i:s");
$status = $_REQUEST['status'];

if($status=="line_noti_ot"){
    $job_ot_id = $_REQUEST["job_ot_id"];

    $sql = "SELECT empno
    ,convert(varchar, date_ot,103)as date_ot_date 
    ,shift
    ,departmentid
    FROM tbot_request WHERE job_ot_id='$job_ot_id'";
    $res = mssql_query($sql);
    $row = mssql_fetch_array($res);
    $empno = $row["empno"];
    $date_ot_date = $row["date_ot_date"];
    $shift = $row["shift"];
    $departmentid = $row["departmentid"];
    $sql_department = "SELECT department FROM tbdepartment WHERE departmentid='$departmentid'";
    $res_department = mssql_query($sql_department);
    $row_department = mssql_fetch_array($res_department);
    $department = $row_department["department"];
    if($departmentid=="D006" || $departmentid=="D004"){
        $department = "Planning And Admin";
    } else{
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

    $sql_log = "SELECT empno_submit FROM tbot_request_log WHERE job_ot_id='$job_ot_id' AND status_approve='Request'";
    $res_log = mssql_query($sql_log);
    $row_log = mssql_fetch_array($res_log);
    $empno_submit = $row_log["empno_submit"];


    $sql_site = "SELECT site,firstname FROM tbemployee WHERE empno = '$empno_submit'";
    $res_site = mssql_query($sql_site);
    $row_site = mssql_fetch_array($res_site);
    $site = $row_site["site"];
    $firstname = lang_thai_from_database($row_site["firstname"]);


    if($site=="HQ"){
        $lineapi = "X9LgUp1rs816psbw4lQukTuXCrH6xLKkeBVlrxyTCUI";
    }else if($site=="TSC"){
        $lineapi = "Do7WobNWgZn17b3fNB4N7aaOxnbbtVrClqfmrWCxvmb";
    }else if($site=="OSW"){
        $lineapi = "SMtPPtgBWhrStz9Mik5tKIG8VbiZEJQL3NR1g6uT5L3";
    }

    $mms = "OT request : " . $date_ot_date . "\n";
    $mms .= "Site : " . $site . "\n";
    $mms .= "Shift : " . $shift . "\n";
    $mms .= "Department : " . $department . "\n";
    $mms .= "Name request : " . $firstname . "\n";
    $mms .= "Print : http://ipack-iwis.com/hrs/pop_ot.php?job_ot_id=$job_ot_id"  . "\n";
    $mms .= "Url Approve : http://ipack-iwis.com/hrs/login.php?ref=create_ot"  . "\n";
    // $mms .= "!! ทดสอบระบบ !!";

    $chOne = curl_init();
    curl_setopt($chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
    // SSL USE 
    curl_setopt($chOne, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($chOne, CURLOPT_SSL_VERIFYPEER, 0);
    //POST 
    curl_setopt($chOne, CURLOPT_POST, 1);
    // Message 
    curl_setopt($chOne, CURLOPT_POSTFIELDS, "message=$mms");
    //ถ้าต้องการใส่รุป ให้ใส่ 2 parameter imageThumbnail และimageFullsize
    //curl_setopt( $chOne, CURLOPT_POSTFIELDS, "message=$mms&imageThumbnail=http://plusquotes.com/images/quotes-img/surprise-happy-birthday-gifts-5.jpg&imageFullsize=http://plusquotes.com/images/quotes-img/surprise-happy-birthday-gifts-5.jpg&stickerPackageId=1&stickerId=100"); 
    // follow redirects 
    curl_setopt($chOne, CURLOPT_FOLLOWLOCATION, 1);
    //ADD header array 
    $headers = array('Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer ' . $lineapi . '',);
    curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers);
    //RETURN 
    curl_setopt($chOne, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($chOne);
    //Check error 
    if (curl_error($chOne)) {
        echo 'error:' . curl_error($chOne);
    } else {
        $result_ = json_decode($result, true);
        echo "status : " . $result_['status'];
        echo "message : " . $result_['message'];
    }
    //Close connect 
    curl_close($chOne);
    

}else if($status=="close_picture_line_alert"){
    $site = $_POST["site"]; 

    $select_date = $_POST["select_date"]==""?date('d/m/Y'):$_POST["select_date"];
    $shift = $_POST["shift"]==""?"Day":$_POST["shift"];
    
    $select_date_arr = explode("/",$select_date);
    $select_date_sql = $select_date_arr[1]."/".$select_date_arr[0]."/".$select_date_arr[2];
    
    $sql = "SELECT jobstatus_picture_line FROM  tb5s_picture WHERE site='$site' and shift='$shift' AND createdate='$select_date_sql' AND jobstatus_picture_line='New' ";
    $res = mssql_query($sql);
    $num = mssql_num_rows($res);
    if($num>0){

        $update = "UPDATE  tb5s_picture set jobstatus_picture_line='Close' where site='$site' and shift='$shift' AND createdate='$select_date_sql'";
        mssql_query($update);

        if($site=="HQ"){
            $lineapi = "X9LgUp1rs816psbw4lQukTuXCrH6xLKkeBVlrxyTCUI";
        }else if($site=="TSC"){
            $lineapi = "Do7WobNWgZn17b3fNB4N7aaOxnbbtVrClqfmrWCxvmb";
        }else if($site=="OSW"){
            $lineapi = "SMtPPtgBWhrStz9Mik5tKIG8VbiZEJQL3NR1g6uT5L3";
        }

        $mms = "Warehouse has been taken a photo: " . $select_date . "\n";
        $mms .= "Site : " . $site . "\n";
        $mms .= "Shift : " . $shift . "\n";
        $mms .= "Url Approve : http://ipack-iwis.com/hrs/picture5s_approve.php?shift=$shift"."$"."$select_date"."$"."$site"  . "\n";
        // $mms .= " ทดสอบระบบ ";

        $chOne = curl_init();
        curl_setopt($chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
        // SSL USE 
        curl_setopt($chOne, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($chOne, CURLOPT_SSL_VERIFYPEER, 0);
        //POST 
        curl_setopt($chOne, CURLOPT_POST, 1);
        // Message 
        curl_setopt($chOne, CURLOPT_POSTFIELDS, "message=$mms");
        //ถ้าต้องการใส่รุป ให้ใส่ 2 parameter imageThumbnail และimageFullsize
        //curl_setopt( $chOne, CURLOPT_POSTFIELDS, "message=$mms&imageThumbnail=http://plusquotes.com/images/quotes-img/surprise-happy-birthday-gifts-5.jpg&imageFullsize=http://plusquotes.com/images/quotes-img/surprise-happy-birthday-gifts-5.jpg&stickerPackageId=1&stickerId=100"); 
        // follow redirects 
        curl_setopt($chOne, CURLOPT_FOLLOWLOCATION, 1);
        //ADD header array 
        $headers = array('Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer ' . $lineapi . '',);
        curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers);
        //RETURN 
        curl_setopt($chOne, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($chOne);
        //Check error 
        if (curl_error($chOne)) {
            echo 'error:' . curl_error($chOne);
        } else {
            $result_ = json_decode($result, true);
            echo "status : " . $result_['status'];
            echo "message : " . $result_['message'];
        }
        //Close connect 
        curl_close($chOne);
    }
	

}
?>
