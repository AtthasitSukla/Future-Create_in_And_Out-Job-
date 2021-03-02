<?php
session_start();
include("connect.php");
include("library.php"); 

$time = date("H:i:s");
$date_time = date("m/d/Y H:i:s");
header('Content-Type: text/html; charset=utf-8');
$empno = $_SESSION['admin_userid'];
$full_name = lang_thai_into_database(get_full_name($empno));
$departmentid_post = ($_POST['departmentid']);
$doc_use = lang_thai_into_database($_POST['doc_use']);
$doc_use_remark = lang_thai_into_database($_POST['doc_use_remark']);
$doc_copy_type = lang_thai_into_database($_POST['doc_copy_type']);
$doc_copy_qty = ($_POST['doc_copy_qty']);
$doc_type = ($_POST['doc_type']);
$doc_type_remark = lang_thai_into_database(($_POST['doc_type_remark']));
$doc_name = lang_thai_into_database($_POST['doc_name']);
$doc_code = trim($_POST['doc_code']);
$doc_revision = ($_POST['doc_revision']);
$doc_revision_int = (int)($_POST['doc_revision']);
$date_announcement = date_format_uk_into_database($_POST['date_announcement']);
$doc_detail = lang_thai_into_database(($_POST['doc_detail']));
$pages = ($_POST['pages']);
$departmentid_checkbox = ($_POST['departmentid_checkbox']);


$sql_rev = "SELECT * FROM tbe_document 
WHERE doc_code='$doc_code' 
AND CAST(doc_revision AS int) >= '$doc_revision_int' 
AND doc_status not in ('Reviewer Reject','Approver Reject','DCC Reject')
order by doc_revision desc ";
$res_rev = mssql_query($sql_rev);
$row_rev = mssql_fetch_array($res_rev);
$num_rev = mssql_num_rows($res_rev);


// echo $doc_use;
if($num_rev>0 && $_POST['doc_use']!="ขอยกเลิกเอกสาร"){
    $last_rev = $row_rev["doc_revision"];
    ?>
    <h3><font color="red">กรุณาอัพเอกสาร <?=$doc_code?> ที่มีเลข Revision มากกว่า <?=$last_rev?></font></h3>
    <form>
        <input type=button onClick="window.history.back()" value="Back">
    </form>
    <?
}else{
    $sql_doc = "SELECT * FROM tbe_document WHERE doc_code='$doc_code' AND doc_status='Approver Approve'";
    $res_doc = mssql_query($sql_doc);
    $num_doc = mssql_num_rows($res_doc);
    if($num_doc>0 && $_POST['doc_use']=="ขอจัดทำเอกสารใหม่"){
        $last_rev = $row_rev["doc_revision"];
        ?>
        <h3><font color="red">เอกสาร <?=$doc_code?> มีในระบบอยู่แล้ว กรุณาอัพใหม่อีกครั้ง</font></h3>
        <form>
            <input type=button onClick="window.history.back()" value="Back">
        </form>
        <?
    }else{

        //echo $doc_detail;
        $doc_id_check = "DAR".date("y").date("m");
        $sql_check = "SELECT top 1 doc_id from tbe_document where doc_id like '$doc_id_check%' order by doc_id desc";
        $res = mssql_query($sql_check);
        $num = mssql_num_rows($res);
        if($num==0){
            $doc_id = "DAR".date("y").date("m")."001";
        }else{
            $row = mssql_fetch_array($res);
            $tmp_newid = $row['doc_id'];
            $tmp_newid = substr($tmp_newid,-4);
            $qid = (int)$tmp_newid + 1;
            $tmpid = "0000".$qid;
            $qdno = substr($tmpid,-3);
            $doc_id = "DAR".date("y").date("m").$qdno;
        }

        
        $insert = "INSERT into tbe_document 
                    (
                        doc_id
                        ,doc_use
                        ,doc_use_remark
                        ,doc_copy_type
                        ,doc_copy_qty
                        ,doc_type
                        ,doc_type_remark
                        ,doc_name
                        ,doc_code
                        ,departmentid
                        ,doc_revision
                        ,date_announcement
                        ,doc_detail
                        ,doc_creator
                        ,create_date
                        ,doc_status
                        ,pages
                    ) VALUES
                    (
                        '$doc_id'
                        ,'$doc_use'
                        ,'$doc_use_remark'
                        ,'$doc_copy_type'
                        ,'$doc_copy_qty'
                        ,'$doc_type'
                        ,'$doc_type_remark'
                        ,'$doc_name'
                        ,'$doc_code'
                        ,'$departmentid_post'
                        ,'$doc_revision'
                        ,'$date_announcement'
                        ,'$doc_detail'
                        ,'$empno'
                        ,'$date_time'
                        ,'Create'
                        ,'$pages'
                    )";
        mssql_query($insert);

        $insert_log = "INSERT into tbe_document_log 
                    (
                        doc_id
                        ,doc_use
                        ,doc_use_remark
                        ,doc_copy_type
                        ,doc_copy_qty
                        ,doc_type
                        ,doc_type_remark
                        ,doc_name
                        ,doc_code
                        ,departmentid
                        ,doc_revision
                        ,date_announcement
                        ,doc_detail
                        ,doc_creator
                        ,create_date
                        ,doc_status
                        ,pages
                        ,admin_userid_action
                        ,action
                        ,action_date
                    ) VALUES
                    (
                        '$doc_id'
                        ,'$doc_use'
                        ,'$doc_use_remark'
                        ,'$doc_copy_type'
                        ,'$doc_copy_qty'
                        ,'$doc_type'
                        ,'$doc_type_remark'
                        ,'$doc_name'
                        ,'$doc_code'
                        ,'$departmentid_post'
                        ,'$doc_revision'
                        ,'$date_announcement'
                        ,'$doc_detail'
                        ,'$empno'
                        ,'$date_time'
                        ,'Create'
                        ,'$pages'
                        ,'$empno'
                        ,'Insert'
                        ,'$date_time'
                    )";
        mssql_query($insert_log);

        foreach($departmentid_checkbox as $departmentid_checkbox_value){
            // echo $departmentid_checkbox_value;
            $sql_permission = "SELECT doc_code FROM tbe_document_permission WHERE doc_code='$doc_code' AND departmentid='$departmentid_checkbox_value'";
            $res_permission = mssql_query($sql_permission);
            $num_permission = mssql_num_rows($res_permission);
            if($num_permission>0){
                $update_permission = "UPDATE tbe_document_permission set doc_id='$doc_id',last_update='$date_time'
                                        WHERE doc_code='$doc_code' AND departmentid='$departmentid_checkbox_value'";
                mssql_query($update_permission);
            }else{

                $insert_permission = "INSERT INTO tbe_document_permission 
                (
                    doc_id
                    ,doc_code
                    ,departmentid
                    ,last_update
                ) VALUES
                (
                    '$doc_id'
                    ,'$doc_code'
                    ,'$departmentid_checkbox_value'
                    ,'$date_time'
                )";
                mssql_query($insert_permission);
            }

        }
        

        if(isset($_FILES["file_name"])){
            $count = 1;

            $sql_department = "SELECT department FROM tbdepartment WHERE departmentid='$departmentid_post'";
            $res_department = mssql_query($sql_department);
            $row_department = mssql_fetch_array($res_department);
            $department = $row_department["department"];

            $target_dir = "e_document/";
            $target_dir = "e_document/$doc_type/$department/";
            if(!is_dir($target_dir)){
                mkdir($target_dir, 0777, true);
            }
            
            $file_fullname = lang_thai_into_database(basename($_FILES['file_name']['name']));
            $file_name = basename($_FILES['file_name']['name']);
            $imageFileType = strtolower(pathinfo($file_name,PATHINFO_EXTENSION));
            $target_file = $target_dir.$doc_id."_".$count.".".$imageFileType;
            $file_name_upload = $doc_id."_".$count.".".$imageFileType;

            $file_size =$_FILES['file_name']['size'];
            $file_tmp =$_FILES['file_name']['tmp_name'];
            $file_type=$_FILES['file_name']['type'];  
            
            if(move_uploaded_file($file_tmp,$target_file)){
                $UPDATE_file = "UPDATE  tbe_document set file_name='$target_file',file_fullname='$file_fullname'
                                            WHERE doc_id='$doc_id'";
                mssql_query($UPDATE_file);
            }
            $count++;
            
        }

        
        $html = "Create Dar : <BR><BR>";		
        $html .= "ยื่นคำร้อง ".$_POST['doc_use'];
        $html .= "<BR> เอกสาร ".$_POST['doc_name'];
        $html .= "<BR> รหัส ".$_POST['doc_code'];
        $html .= "<BR> ประเภท ".$_POST['doc_type'];
        $html .= "<BR> โดยคุณ ".get_full_name($empno);
        $html .= "<br/><br/>สามารถเข้าตรวจสอบได้ที่ : http://www.ipack-iwis.com/hrs/login.php?ref=create_dar";

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
        $mail->Subject = "Create Dar ".$_POST['doc_code'];
        
        $mail->Body = $html;

        $mail->IsHTML(true); 
        $sql_control = "SELECT * FROM  tbleave_control WHERE emp_under = '" . $_SESSION['admin_userid'] . "'";
        $re_control = mssql_query($sql_control);
        $num_control = mssql_num_rows($re_control);
        while ($row_control = mssql_fetch_array($re_control)) {
            $emp_control = $row_control["emp_control"];

            $sql_email = "SELECT email FROM tbemployee WHERE empno='$emp_control' ";
            $res_email = mssql_query($sql_email);
            while($row_email = mssql_fetch_array($res_email)){
                $email = $row_email["email"];
                $mail->AddAddress("$email");
            }
            //array_push($empno, $row['emp_under']);
        }
        // $mail->AddAddress("natwarin.t@ipacklogistics.com");
        //$mail->AddAddress("nakarin.j@ipacklogistics.com");
        $mail->AddCC("nakarin.j@ipacklogistics.com");
        $mail->Send();


        echo "Save Complete";

        ?>
        <meta http-equiv='refresh' CONTENT='1;URL=create_dar.php?status=reviewer'>
        <?
    }
}