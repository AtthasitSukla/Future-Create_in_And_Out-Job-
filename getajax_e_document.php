<?php
session_start();
//echo $_SESSION['production_line'];
include("connect.php");
include("library.php");

$status = $_POST['status'];
$date_time = date("m/d/Y H:i:s");
$time = time();

if($status=="open_amendment_record"){
    $doc_code = $_POST["doc_code"];
    

    ?>
    <table class='table table-bordered'>
        <tr>
            <th>แก้ไขครั้งที่</th>
            <th>หน้าที่</th>
            <th>Dar No.</th>
            <th>รายละเอียดการแก้ไข</th>
            <th>วันที่เริ่มใช้</th>
        </tr>
        <?
        $sql = "SELECT *,convert(varchar, date_announcement,103)as date_announcement_date 
        FROM tbe_document 
        WHERE doc_code = '$doc_code' 
        AND doc_status in ('Old Revision','Approver Approve','Cancel Document') 
        order by doc_revision asc";
        $res = mssql_query($sql);
        while($row = mssql_fetch_array($res)){
            $doc_revision = $row["doc_revision"];
            $pages = $row["pages"];
            $dar_no = $row["dar_no"];
            $doc_detail = lang_thai_from_database($row["doc_detail"]);
            $date_announcement = $row["date_announcement_date"];
            ?>
            <tr>
                <td align="center"><?=$doc_revision?></td>
                <td align="center"><?=$pages?></td>
                <td align="center"><?=$dar_no?></td>
                <td align="center"><?=$doc_detail?></td>
                <td align="center"><?=$date_announcement?></td>
            </tr>
            <?
        }
        ?>
    </table>
    <?
}else if($status=="select_doc_use_or_type"){
    $doc_use = $_POST["doc_use"];
    $doc_type = $_POST["doc_type"];
    $departmentid_select = $_POST["departmentid"];
    $doc_use_remark = $_POST["doc_use_remark"];

    if($doc_use =="ขอเปลี่ยนแปลงแก้ไข" || $doc_use =="ขอยกเลิกเอกสาร" ){

        echo "###";
        ?>
        <div class="form-group">
            <label class="control-label col-sm-2" for="doc_name">ชื่อเอกสาร :</label>
            <div class="col-sm-4">
                <select name="doc_name" id="doc_name" class="form-control" onchange="select_doc_name()" required>
                    <option value="">Select Document</option>
                    <?
                    $doc_use_cancel = lang_thai_into_database("ขอยกเลิกเอกสาร");
                    $sql = "SELECT doc_id,doc_name,doc_code FROM tbe_document WHERE doc_status='Approver Approve' AND doc_type='$doc_type' AND departmentid='$departmentid_select' AND doc_use!='$doc_use_cancel' order by doc_code";
                    $res = mssql_query($sql);
                    while($row = mssql_fetch_array($res)){
                        $doc_id = ($row["doc_id"]);
                        $doc_code = ($row["doc_code"]);
                        $doc_name = lang_thai_from_database($row["doc_name"]);
                        ?>
                        <option value="<?=$doc_name?>">( <?=$doc_code?> ) <?=$doc_name?></option>
                        <?
                    }
                    ?>
                </select>

            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="doc_code">รหัส :</label>
            <div class="col-sm-3">
                <input type="text" name="doc_code" id="doc_code" class="form-control" readonly required>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="doc_revision">แก้ไขครั้งที่ :</label>
            <div class="col-sm-2">
                <input type="text" name="doc_revision" id="doc_revision" class="form-control" readonly required>
            </div>
        </div>
        
        
        <?
    }else{
        if($doc_use=="อื่นๆ"){
            ?>
            <input type="text" name="doc_use_remark" id="doc_use_remark" class="form-control" value="<?=$doc_use_remark?>">
            <?
        }
        echo "###";
        ?>
        <div class="form-group">
            <label class="control-label col-sm-2" for="doc_name">ชื่อเอกสาร :</label>
            <div class="col-sm-4">
                <input type="text" name="doc_name" id="doc_name" class="form-control" required>

            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="doc_code">รหัส :</label>
            <div class="col-sm-3">
                <input type="text" name="doc_code" id="doc_code" class="form-control" onchange="select_department()" required>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="doc_revision">แก้ไขครั้งที่ :</label>
            <div class="col-sm-2">
                <input type="text" name="doc_revision" id="doc_revision" class="form-control"
                <?php 
                if($doc_use =="ขอจัดทำเอกสารใหม่"){
                    echo "value='00' readonly";
                }
                ?>
                required>
            </div>
        </div>
        <?

    }

    if($doc_type=="Other"){
        echo "###";
        ?>
        <input type="text" name="doc_type_remark" id="doc_type_remark" class="form-control">
        <?
    }else{
        echo "###";
    }
}else if($status=="select_doc_use_or_type_admin"){
    $doc_use = $_POST["doc_use"];
    $doc_type = $_POST["doc_type"];
    $departmentid_select = $_POST["departmentid"];
    $doc_use_remark = $_POST["doc_use_remark"];

    
        if($doc_use=="อื่นๆ"){
            ?>
            <input type="text" name="doc_use_remark" id="doc_use_remark" class="form-control" value="<?=$doc_use_remark?>">
            <?
        }
        echo "###";
        ?>
        <div class="form-group">
            <label class="control-label col-sm-2" for="doc_name">ชื่อเอกสาร :</label>
            <div class="col-sm-4">
                <input type="text" name="doc_name" id="doc_name" class="form-control" required>

            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="doc_code">รหัส :</label>
            <div class="col-sm-3">
                <input type="text" name="doc_code" id="doc_code" class="form-control" onchange="select_department()" required>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="doc_revision">แก้ไขครั้งที่ :</label>
            <div class="col-sm-2">
                <input type="text" name="doc_revision" id="doc_revision" class="form-control"
                <?php 
                if($doc_use =="ขอจัดทำเอกสารใหม่"){
                    echo "value='00' readonly";
                }
                ?>
                required>
            </div>
        </div>
        <?

    

    if($doc_type=="Other"){
        echo "###";
        ?>
        <input type="text" name="doc_type_remark" id="doc_type_remark" class="form-control">
        <?
    }else{
        echo "###";
    }

}else if($status=='select_doc_name'){
    $doc_use = $_POST["doc_use"];
    $doc_type = $_POST["doc_type"];
    $doc_name = lang_thai_into_database($_POST["doc_name"]);
    if($doc_name!=''){

        $sql = "SELECT * FROM tbe_document WHERE doc_status='Approver Approve' AND doc_type='$doc_type' AND doc_name='$doc_name'";
        $res = mssql_query($sql);
        $row = mssql_fetch_array($res);
        $doc_code = $row["doc_code"];
        $doc_revision = $row["doc_revision"];
        
        if($doc_use =="ขอเปลี่ยนแปลงแก้ไข"  ){
            $qid = (int)$doc_revision + 1;
            $tmpid = "000000".$qid;
            $doc_revision_next = substr($tmpid,-2);
            $doc_revision = $doc_revision_next;
        }else if($doc_use =="ขอยกเลิกเอกสาร"){
            $doc_revision = $doc_revision;
        }
        echo "$doc_code###$doc_revision";
    }

}else if($status=="event_review"){
    $doc_id = $_POST["doc_id"];
    $doc_status = $_POST["doc_status"];
    $reviewer_remark = lang_thai_into_database($_POST["reviewer_remark"]);

    $reviewer = $_SESSION["admin_userid"];

    $sql_doc = "SELECT doc_creator,doc_use,doc_name,doc_code,doc_type FROM tbe_document WHERE doc_id='$doc_id'";
    $res_doc = mssql_query($sql_doc);
    $row_doc = mssql_fetch_array($res_doc);
    $doc_creator = $row_doc["doc_creator"];
    $doc_use = lang_thai_from_database($row_doc["doc_use"]);
    $doc_name = lang_thai_from_database($row_doc["doc_name"]);
    $doc_code_doc = $row_doc["doc_code"];
    $doc_type_doc = $row_doc["doc_type"];


    $sql_control = "SELECT * FROM  tbleave_control WHERE emp_under='$doc_creator' AND emp_control in ('$reviewer')";
    $re_control = mssql_query($sql_control);
    $num_control = mssql_num_rows($re_control);
    if($num_control==0 ){
        echo "Not_permission";
    }else{

        $update = "UPDATE tbe_document set 
            reviewer='$reviewer'
            ,date_reviewer='$date_time'
            ,doc_status='$doc_status'
            ,reviewer_remark='$reviewer_remark'
            WHERE doc_id='$doc_id'";
        mssql_query($update);

        if($doc_status=="Reviewer Approve"){

            $html = "Approve Review : <BR><BR>";		
            $html .= "ยื่นคำร้อง ".$doc_use;
            $html .= "<BR> เอกสาร ".$doc_name;
            $html .= "<BR> ประเภท ".$doc_type_doc;
            $html .= "<BR> รหัส ".$doc_code_doc;
            $html .= "<BR> ยื่นคำร้องโดยคุณ ".get_full_name($doc_creator);
            $html .= "<BR> ทบทวนโดยคุณ ".get_full_name($reviewer);
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
            $mail->Subject = "Review ".$doc_code_doc;
            
            $mail->Body = $html;
    
            $mail->IsHTML(true); 
    
            $mail->AddAddress("natwarin.t@ipacklogistics.com");
            // $mail->AddAddress("pongthorn.w@ipacklogistics.com");
            //$mail->AddAddress("nakarin.j@ipacklogistics.com");
            //$mail->AddAddress("nakarin.j@ipacklogistics.com");
            // $mail->AddCC("nakarin.j@ipacklogistics.com");
            $mail->Send();
        }
    }
    
    
    // echo $update;
}else if($status=="show_department_to_see"){
    $departmentid_select = $_POST["departmentid"];
    $doc_code = $_POST["doc_code"];

    ?>
    <div class="checkbox">
    <?
    $sql_department = "SELECT * FROM tbdepartment order by department";
    $res_department = mssql_query($sql_department);
    while($row_department = mssql_fetch_array($res_department)){
        $departmentid_check = $row_department["departmentid"];
        $department = $row_department["department"];

        $sql_permission = "SELECT * FROM tbe_document_permission WHERE doc_code='$doc_code' AND departmentid='$departmentid_check'";
        $res_permission = mssql_query($sql_permission);
        $num_permission = mssql_num_rows($res_permission);

        if($departmentid_check==$departmentid_select){
            $checked_depart = "checked onclick='return false;'";
        }else if($num_permission>0){ //Check old revision 
            $checked_depart = "checked";
        }else{
            $checked_depart = "";
        }

        ?><label><input type="checkbox" name="departmentid_checkbox[]" value='<?=$departmentid_check?>' <?=$checked_depart?>> <?=$department?>&nbsp;&nbsp;</label><?
    }
   ?>
   </div>
   <?     
}else if($status=="show_data_dcc_action"){
    $doc_id = $_POST["doc_id"];

    $sql = "SELECT departmentid,doc_code FROM tbe_document WHERE doc_id='$doc_id'";
    $res = mssql_query($sql);
    $row = mssql_fetch_array($res);
    $departmentid_doc = $row["departmentid"];
    $doc_code_doc = $row["doc_code"];

    $sql_department = "SELECT * FROM tbdepartment order by department";
    $res_department = mssql_query($sql_department);
    while($row_department = mssql_fetch_array($res_department)){
        $departmentid_select = $row_department["departmentid"];
        $department = $row_department["department"];

        $sql_permission = "SELECT * FROM tbe_document_permission WHERE doc_code='$doc_code_doc' AND departmentid='$departmentid_select'";
        $res_permission = mssql_query($sql_permission);
        $num_permission = mssql_num_rows($res_permission);

        if($departmentid_select==$departmentid_doc){
            $checked_depart = "checked onclick='return false;'";
        }else if($num_permission>0){ //Check old revision 
            $checked_depart = "checked";
        }else{
            $checked_depart = "";
        }

        ?><label><input type="checkbox" name="departmentid_checkbox_dcc_action[]" value='<?=$departmentid_select?>' <?=$checked_depart?>> <?=$department?></label><br><?
    }

}else if($status=="show_data_approve"){
    $doc_id = $_POST["doc_id"];

    $sql = "SELECT departmentid,doc_code FROM tbe_document WHERE doc_id='$doc_id'";
    $res = mssql_query($sql);
    $row = mssql_fetch_array($res);
    $departmentid_doc = $row["departmentid"];
    $doc_code_doc = $row["doc_code"];

    $sql_department = "SELECT * FROM tbdepartment order by department";
    $res_department = mssql_query($sql_department);
    while($row_department = mssql_fetch_array($res_department)){
        $departmentid_select = $row_department["departmentid"];
        $department = $row_department["department"];

        $sql_permission = "SELECT * FROM tbe_document_permission WHERE doc_code='$doc_code_doc' AND departmentid='$departmentid_select'";
        $res_permission = mssql_query($sql_permission);
        $num_permission = mssql_num_rows($res_permission);

        if($departmentid_select==$departmentid_doc){
            $checked_depart = "checked onclick='return false;'";
        }else if($num_permission>0){ //Check old revision 
            $checked_depart = "checked";
        }else{
            $checked_depart = "";
        }

        ?><label><input type="checkbox" name="departmentid_checkbox[]" value='<?=$departmentid_select?>' <?=$checked_depart?>> <?=$department?></label><br><?
    }


}else if($status=="event_dcc_action"){
    $approve_name = $_SESSION["admin_userid"];

    if( $approve_name!="56038"  ){

        echo "Not_permission";

    }else{

        $doc_id = $_POST["doc_id"];
        $doc_status = $_POST["doc_status"];
        $departmentid_checkbox = $_POST["departmentid"];
        $dcc_remark = lang_thai_into_database($_POST["dcc_remark"]);
        
        
        $sql = "SELECT doc_name,doc_code,doc_type,doc_revision,doc_use,departmentid,doc_creator,reviewer FROM tbe_document WHERE doc_id='$doc_id'";
        $res = mssql_query($sql);
        $row = mssql_fetch_array($res);
        $doc_name = lang_thai_from_database($row["doc_name"]);
        $doc_code_doc = $row["doc_code"];
        $doc_type_doc = $row["doc_type"];
        $doc_creator = $row["doc_creator"];
        $reviewer = $row["reviewer"];
        $departmentid_doc = $row["departmentid"];
        $doc_revision_doc = (int)$row["doc_revision"];
        $doc_use = lang_thai_from_database($row["doc_use"]);
            
        $update = "UPDATE tbe_document set 
                dcc_date='$date_time'
                ,doc_status='$doc_status'
                ,dcc_remark='$dcc_remark'
                WHERE doc_id='$doc_id'";
            mssql_query($update);

        if($doc_status=="DCC Approve"){

            $html = "DCC Approve : <BR><BR>";		
            $html .= "ยื่นคำร้อง ".$doc_use;
            $html .= "<BR> เอกสาร ".$doc_name;
            $html .= "<BR> ประเภท ".$doc_type_doc;
            $html .= "<BR> รหัส ".$doc_code_doc;
            $html .= "<BR> ยื่นคำร้องโดยคุณ ".get_full_name($doc_creator);
            $html .= "<BR> ทบทวนโดยคุณ ".get_full_name($reviewer);
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
            $mail->Subject = "DCC Approve ".$doc_code_doc;
            
            $mail->Body = $html;
    
            $mail->IsHTML(true); 
    
            // $mail->AddAddress("natwarin.t@ipacklogistics.com");
            $mail->AddAddress("pongthorn.w@ipacklogistics.com");
            // $mail->AddAddress("nakarin.j@ipacklogistics.com");
            //$mail->AddAddress("nakarin.j@ipacklogistics.com");
            // $mail->AddCC("nakarin.j@ipacklogistics.com");
            $mail->Send();
        }
                
                
        foreach($departmentid_checkbox as $departmentid_checkbox_value){
            // echo $departmentid_checkbox_value;
            $sql_permission = "SELECT doc_code FROM tbe_document_permission WHERE doc_code='$doc_code_doc' AND departmentid='$departmentid_checkbox_value'";
            $res_permission = mssql_query($sql_permission);
            $num_permission = mssql_num_rows($res_permission);
            if($num_permission>0){
                $update_permission = "UPDATE tbe_document_permission set doc_id='$doc_id',last_update='$date_time'
                                        WHERE doc_code='$doc_code_doc' AND departmentid='$departmentid_checkbox_value'";
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
                    ,'$doc_code_doc'
                    ,'$departmentid_checkbox_value'
                    ,'$date_time'
                )";
                mssql_query($insert_permission);
            }
    
        }
        
            

        //UPLOAD FILE
        // if(isset($_FILES["file"])){
        //     $count=1;
        //     $sql_department = "SELECT department FROM tbdepartment WHERE departmentid='$departmentid_doc'";
        //     $res_department = mssql_query($sql_department);
        //     $row_department = mssql_fetch_array($res_department);
        //     $department = $row_department["department"];

        //     $target_dir = "e_document/";
        //     $target_dir = "e_document/$doc_type_doc/$department/";
        //     if(!is_dir($target_dir)){
        //         mkdir($target_dir, 0777, true);
        //     }
        //     $file_fullname = lang_thai_into_database(basename($_FILES['file']['name']));
        //     $file_name = basename($_FILES['file']['name']);
        //     $imageFileType = strtolower(pathinfo($file_name,PATHINFO_EXTENSION));
        //     $target_file = $target_dir.$doc_id."_".$count.".".$imageFileType;
        //     $file_name_upload = $doc_id."_".$count.".".$imageFileType;

        //     $file_size =$_FILES['file']['size'];
        //     $file_tmp =$_FILES['file']['tmp_name'];
        //     $file_type=$_FILES['file']['type'];  
            
        //     if(move_uploaded_file($file_tmp,$target_file)){
        //         $UPDATE_file = "UPDATE  tbe_document set file_name='$target_file',file_fullname='$file_fullname'
        //                                     WHERE doc_id='$doc_id'";
        //         mssql_query($UPDATE_file);
        //     }
        // }
        
    }
        

}else if($status=="event_approve"){
    $approve_name = $_SESSION["admin_userid"];

    if($approve_name != "56002" && $approve_name!="56038" ){

        echo "Not_permission";

    }else{

        $doc_id = $_POST["doc_id"];
        $doc_status = $_POST["doc_status"];
        $departmentid_checkbox = $_POST["departmentid"];
        $pages = $_POST["pages"];
        $approve_remark = lang_thai_into_database($_POST["approve_remark"]);
        
        $sql = "SELECT doc_code,doc_type,doc_revision,doc_use,departmentid FROM tbe_document WHERE doc_id='$doc_id'";
        $res = mssql_query($sql);
        $row = mssql_fetch_array($res);
        $doc_code_doc = $row["doc_code"];
        $doc_type_doc = $row["doc_type"];
        $departmentid_doc = $row["departmentid"];
        $doc_revision_doc = (int)$row["doc_revision"];
        $doc_use = lang_thai_from_database($row["doc_use"]);
        if($doc_use=="ขอยกเลิกเอกสาร" && $doc_status=="Approver Approve"){
            
            
            $update_cancel = "UPDATE tbe_document set 
                doc_status='Cancel Document'
                ,old_date='$date_time'
                
                WHERE doc_status='Approver Approve'
                AND doc_code='$doc_code_doc'";
            mssql_query($update_cancel);

            $update = "UPDATE tbe_document set 
                approve_name='$approve_name'
                ,date_approve='$date_time'
                ,doc_status='$doc_status'
                ,approve_remark='$approve_remark'
                
                WHERE doc_id='$doc_id'";
            mssql_query($update);

        }else{
            $dar_no = date("Y");
            $sql_check = "SELECT top 1 dar_no from tbe_document where dar_no like '%$dar_no' order by dar_no desc";
            $res_check = mssql_query($sql_check);
            $num_check = mssql_num_rows($res_check);
            if($num_check ==0){
                $dar_no = "001/".date("Y");
            }else{
                $row_check= mssql_fetch_array($res_check);
                $dar_no = $row_check["dar_no"];
                
                $tmp_newid = substr($dar_no,0,3);
                $qid = (int)$tmp_newid + 1;
                $tmpid = "000000".$qid;
                $qdno = substr($tmpid,-3);
                $dar_no = "$qdno/".date("Y");
            }
            

            $update = "UPDATE tbe_document set 
                approve_name='$approve_name'
                ,date_approve='$date_time'
                ,doc_status='$doc_status'
                ,approve_remark='$approve_remark'
                WHERE doc_id='$doc_id'";
            mssql_query($update);
        
            $update_old = "UPDATE tbe_document set old_date='$date_time',doc_status='Old Revision' WHERE doc_code='$doc_code_doc' AND CAST(doc_revision AS int) < '$doc_revision_doc' AND doc_status='Approver Approve'";
            mssql_query($update_old);
        
            if($doc_status=="Approver Approve"){

                
                $sql_dar = "SELECT * FROM tbe_document WHERE  doc_id='$doc_id' AND dar_no IS NULL";
                $res_dar = mssql_query($sql_dar);
                $num_dar = mssql_num_rows($res_dar);
                if($num_dar>0){
                    $update_dar = "UPDATE tbe_document set dar_no='$dar_no' WHERE doc_id='$doc_id' AND dar_no IS NULL";
                    mssql_query($update_dar);
                    echo $dar_no;
                }else{

                }

                foreach($departmentid_checkbox as $departmentid_checkbox_value){
                    // echo $departmentid_checkbox_value;
                    $sql_permission = "SELECT doc_code FROM tbe_document_permission WHERE doc_code='$doc_code_doc' AND departmentid='$departmentid_checkbox_value'";
                    $res_permission = mssql_query($sql_permission);
                    $num_permission = mssql_num_rows($res_permission);
                    if($num_permission>0){
                        $update_permission = "UPDATE tbe_document_permission set doc_id='$doc_id',last_update='$date_time'
                                                WHERE doc_code='$doc_code_doc' AND departmentid='$departmentid_checkbox_value'";
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
                            ,'$doc_code_doc'
                            ,'$departmentid_checkbox_value'
                            ,'$date_time'
                        )";
                        mssql_query($insert_permission);
                    }
            
                }
               
            }

            
        }
    }
        
    
}else if($status=="show_all_department"){
    $doc_type = $_POST["doc_type"];

    $sql = "SELECT * FROM tbdepartment order by department";
    $res = mssql_query($sql);
    $no = 1;
    while($row = mssql_fetch_array($res)){
        $departmentid_select =  $row["departmentid"];
        $department =  $row["department"];

        if($no==1 || $no==8){
            ?>
            <div class="col-sm-4">

            
            <?
        }
        ?>
                <div class="form-group">
                    <button class="classDepartment btn btn-warning btn-label" onclick="select_department('<?=$departmentid_select?>','<?=$doc_type?>')" id="<?=$departmentid_select?>" ><i class="fa fa-folder-o icon_type_department" id="<?=$departmentid_select?>_icon"></i><?=$department?></button>
                </div>
        <?
        if($no==7){
            ?>
            </div>

            
            <?
        }
        $no++;
    }

}else if($status=="show_document_approve"){
    $doc_type = $_POST["doc_type"];
    $departmentid_select = $_POST["departmentid_select"];

    $departmentid = $_SESSION['departmentid'];

    $empno = array();
    array_push($empno, $_SESSION['admin_userid']);
    //array_push($empno,"60111");
    $sql = "SELECT * FROM  tbleave_control WHERE emp_control = '" . $_SESSION['admin_userid'] . "'";
    $re = mssql_query($sql);
    $num = mssql_num_rows($re);
    while ($row = mssql_fetch_array($re)) {
        array_push($empno, $row['emp_under']);
    }
    $empno = join("','", $empno);

    ?>
    <div class="table table-responsive">

        <table class='table table-striped table-bordered' id="table_document">
            <thead>
                <th>ลำดับ</th>
                <!-- <th>ยื่นคำร้องเพื่อ</th> -->
                <th>แผนก</th>
                <th>ชื่อเอกสาร</th>
                <th>รหัส</th>
                <th>แก้ไขครั้งที่</th>
                <th>วันที่เริ่มใช้</th>
                <th>รายละเอียดการแก้ไข</th>
                <th>ผู้จัดทำ</th>
                <th>Dar No</th>
                <th>ไฟล์</th>
            </thead>
            <?php
                $doc_use1 = lang_thai_into_database("ขอยกเลิกเอกสาร");
                $doc_use2 = lang_thai_into_database("ขอสำเนาควบคุม");
                $doc_use3 = lang_thai_into_database("ขอสำเนาไม่ควบคุม");
                if ($_SESSION["admin_userid"] == "56002" || $_SESSION["admin_userid"] == "56038" || $_SESSION["admin_userid"] == "61019") {
                    $sql2 = "SELECT top 100 *,convert(varchar, create_date,103)as create_date_date
                    ,convert(varchar, create_date,108)as create_date_time
                    ,convert(varchar, date_announcement,103)as date_announcement_date
                    FROM tbe_document 
                    WHERE doc_status ='Approver Approve'
                    AND departmentid = '$departmentid_select'  
                    AND doc_type = '$doc_type'  
                    AND doc_use not in ('$doc_use1','$doc_use2','$doc_use3')
                    order by create_date desc";
                } else {
                    $sql2 = "SELECT top 100 *,convert(varchar, create_date,103)as create_date_date
                    ,convert(varchar, create_date,108)as create_date_time
                    ,convert(varchar, date_announcement,103)as date_announcement_date
                    FROM tbe_document 
                    WHERE doc_status ='Approver Approve' 
                    AND departmentid = '$departmentid_select'  
                    AND doc_type = '$doc_type'
                    AND (doc_creator in ('$empno')  OR doc_code in (SELECT doc_code FROM tbe_document_permission WHERE departmentid='$departmentid') )
                    AND doc_use not in ('$doc_use1','$doc_use2','$doc_use3')
                    order by create_date desc";
                }
    
                // echo $sql2;
    
                $no = 0;
                $res2 = mssql_query($sql2);
                $num2 = mssql_num_rows($res2);
                // echo $num2;
                while ($row2 = mssql_fetch_array($res2)) {
                    $no++;
                    $doc_id = $row2["doc_id"];
                    $doc_use = lang_thai_from_database($row2["doc_use"]);
                    $doc_type = $row2["doc_type"];
                    $dar_no = $row2["dar_no"];
                    $doc_name = lang_thai_from_database($row2["doc_name"]);
                    $doc_code = $row2["doc_code"];
                    $departmentid_select = $row2["departmentid"];
                    $department = get_departmentname($departmentid_select);
                    $doc_revision = $row2["doc_revision"];
                    $date_announcement = $row2["date_announcement_date"];
                    $doc_detail = lang_thai_from_database($row2["doc_detail"]);
                    $doc_creator = get_full_name($row2["doc_creator"]);
                    $create_date = $row2["create_date_date"] . " " . $row2["create_date_time"];
                    $file_name = $row2["file_name"];
                    $doc_status = $row2["doc_status"];
                    $file_fullname = lang_thai_from_database($row2["file_fullname"]);
    
                    ?>
                    <tr>
                        <td><?= $no ?></td>
                        <!-- <td><?= $doc_use ?></td> -->
                        <td><?= $department ?></td>
                        <td><?= $doc_name ?></td>
                        <td><?= $doc_code ?></td>
                        <td><button class='btn btn-link' onclick="open_amendment_record('<?= $doc_code ?>')"><?= $doc_revision ?></button></td>
                        <td><?= $date_announcement ?></td>
                        <td><?= $doc_detail ?></td>
                        <td><?= $doc_creator ?></td>
                        <td><?= $dar_no ?></td>
                        <td><a href="<?= $file_name ?>" target="_<?= $doc_id ?>" ><?= $file_fullname ?></a></td>
                    </tr>
                    <?
                }
    
                ?>
        </table>
    </div>


    <?  

    
}else if($status=="show_all_department_obsolete"){
    $doc_type = $_POST["doc_type"];

    $sql = "SELECT * FROM tbdepartment order by department";
    $res = mssql_query($sql);
    $no = 1;
    while($row = mssql_fetch_array($res)){
        $departmentid_select =  $row["departmentid"];
        $department =  $row["department"];

        if($no==1 || $no==8){
            ?>
            <div class="col-sm-4">

            
            <?
        }
        ?>
                <div class="form-group">
                    <button class="classDepartment btn btn-warning btn-label" onclick="select_department_obsolete('<?=$departmentid_select?>','<?=$doc_type?>')" id="<?=$departmentid_select?>" ><i class="fa fa-folder-o icon_type_department" id="<?=$departmentid_select?>_icon"></i><?=$department?></button>
                </div>
        <?
        if($no==7){
            ?>
            </div>

            
            <?
        }
        $no++;
    }

}else if($status=="show_document_obsolete"){
    $doc_type = $_POST["doc_type"];
    $departmentid_select = $_POST["departmentid_select"];

    $departmentid = $_SESSION['departmentid'];

    $empno = array();
    array_push($empno, $_SESSION['admin_userid']);
    //array_push($empno,"60111");
    $sql = "SELECT * FROM  tbleave_control WHERE emp_control = '" . $_SESSION['admin_userid'] . "'";
    $re = mssql_query($sql);
    $num = mssql_num_rows($re);
    while ($row = mssql_fetch_array($re)) {
        array_push($empno, $row['emp_under']);
    }
    $empno = join("','", $empno);

    ?>
    <div class="table table-responsive">

        <table class='table table-striped table-bordered' id="table_document">
            <thead>
                <th>ลำดับ</th>
                <!-- <th>ยื่นคำร้องเพื่อ</th> -->
                <th>แผนก</th>
                <th>ชื่อเอกสาร</th>
                <th>รหัส</th>
                <th>แก้ไขครั้งที่</th>
                <th>วันที่เริ่มใช้</th>
                <th>รายละเอียดการแก้ไข</th>
                <th>ผู้จัดทำ</th>
                <th>Dar No</th>
                <th>ไฟล์</th>
                <th>Status</th>
            </thead>
            <?php
                $doc_use1 = lang_thai_into_database("ขอยกเลิกเอกสาร");
                $doc_use2 = lang_thai_into_database("ขอสำเนาควบคุม");
                $doc_use3 = lang_thai_into_database("ขอสำเนาไม่ควบคุม");
                if ($_SESSION["admin_userid"] == "56002" || $_SESSION["admin_userid"] == "56038") {
                    $sql2 = "SELECT top 100 *,convert(varchar, create_date,103)as create_date_date
                    ,convert(varchar, create_date,108)as create_date_time
                    ,convert(varchar, date_announcement,103)as date_announcement_date
                    FROM tbe_document 
                    WHERE doc_status in ('Old Revision','Cancel Document')
                    AND departmentid = '$departmentid_select'  
                    AND doc_type = '$doc_type'  
                    
                    order by create_date desc";
                } else {
                    $sql2 = "SELECT top 100 *,convert(varchar, create_date,103)as create_date_date
                    ,convert(varchar, create_date,108)as create_date_time
                    ,convert(varchar, date_announcement,103)as date_announcement_date
                    FROM tbe_document 
                    WHERE doc_status in ('Old Revision','Cancel Document') 
                    AND departmentid = '$departmentid_select'  
                    AND doc_type = '$doc_type'
                    AND doc_code in (SELECT doc_code FROM tbe_document_permission WHERE departmentid='$departmentid')
                    
                    order by create_date desc";
                }
    
                // echo $sql2;
    
                $no = 0;
                $res2 = mssql_query($sql2);
                $num2 = mssql_num_rows($res2);
                // echo $num2;
                while ($row2 = mssql_fetch_array($res2)) {
                    $no++;
                    $doc_id = $row2["doc_id"];
                    $doc_use = lang_thai_from_database($row2["doc_use"]);
                    $doc_type = $row2["doc_type"];
                    $dar_no = $row2["dar_no"];
                    $doc_name = lang_thai_from_database($row2["doc_name"]);
                    $doc_code = $row2["doc_code"];
                    $departmentid_select = $row2["departmentid"];
                    $department = get_departmentname($departmentid_select);
                    $doc_revision = $row2["doc_revision"];
                    $date_announcement = $row2["date_announcement_date"];
                    $doc_detail = lang_thai_from_database($row2["doc_detail"]);
                    $doc_creator = get_full_name($row2["doc_creator"]);
                    $create_date = $row2["create_date_date"] . " " . $row2["create_date_time"];
                    $file_name = $row2["file_name"];
                    $doc_status = $row2["doc_status"];
                    $file_fullname = lang_thai_from_database($row2["file_fullname"]);
    
                    ?>
                    <tr>
                        <td><?= $no ?></td>
                        <!-- <td><?= $doc_use ?></td> -->
                        <td><?= $department ?></td>
                        <td><?= $doc_name ?></td>
                        <td><?= $doc_code ?></td>
                        <td><button class='btn btn-link' onclick="open_amendment_record('<?= $doc_code ?>')"><?= $doc_revision ?></button></td>
                        <td><?= $date_announcement ?></td>
                        <td><?= $doc_detail ?></td>
                        <td><?= $doc_creator ?></td>
                        <td><?= $dar_no ?></td>
                        <td><a href="<?= $file_name ?>" target="_<?= $doc_id ?>" ><?= $file_fullname ?></a></td>
                        <td><?= $doc_status ?></td>
                    </tr>
                    <?
                }
    
                ?>
        </table>
    </div>


    <?  
}else if($status=="search_log_sheet"){
    $doc_use = lang_thai_into_database($_POST['doc_use_log_sheet']);
    $doc_type = $_POST['doc_type_log_sheet'];
    $doc_status = $_POST['doc_status_log_sheet'];
    $create_date_start = date_format_uk_into_database($_POST['create_date_log_sheet_start']);
    $create_date_end = date_format_uk_into_database($_POST['create_date_log_sheet_end']);

    $empno = array();
    array_push($empno, $_SESSION['admin_userid']);
    //array_push($empno,"60111");
    $sql = "SELECT * FROM  tbleave_control WHERE emp_control = '" . $_SESSION['admin_userid'] . "'";
    $re = mssql_query($sql);
    $num = mssql_num_rows($re);
    while ($row = mssql_fetch_array($re)) {
        array_push($empno, $row['emp_under']);
    }
    $empno = join("','", $empno);

    if($doc_use!=""){
        $condition_doc_use = "AND doc_use='$doc_use' ";
    }else{
        $condition_doc_use = "";
    }
    if($doc_type!=""){
        $condition_doc_type = "AND doc_type='$doc_type' ";
    }else{
        $condition_doc_type = "";
    }
    if($doc_status!=""){
        $condition_doc_status = "AND doc_status = '$doc_status' ";
    }else{
        $condition_doc_status = "";
    }
   
    if($_POST['create_date_log_sheet_start'] !="" || $_POST['create_date_log_sheet_end'] !=""){
        $condition_create_date = "AND create_date between '$create_date_start' AND '$create_date_end' ";
    }else{
        $condition_create_date = "";
    }
    ?>
    <!-- <div class="pull-right">
        <button class="btn btn-warning btn-sm active">All</button>
        <button class="btn btn-warning btn-sm">รอ Review ( 2 )</button>
        <button class="btn btn-warning btn-sm">รอ DCC ( 1 )</button>
        <button class="btn btn-warning btn-sm">รอ Approve ( 2 )</button>
    </div>
    <br><br> -->
    <table class='table table-striped table-bordered' id="table_document_log_sheet">
        <thead>
            <th>ลำดับ</th>
            <th width='120px'>ยื่นคำร้องเพื่อ</th>
            <th>ประเภทของเอกสาร</th>
            <th>แผนก</th>
            <th>ชื่อเอกสาร</th>
            <th>รหัส</th>
            <th>แก้ไขครั้งที่</th>
            <th>วันที่สร้าง</th>
            <th>วันที่เริ่มใช้</th>
            <th>รายละเอียดการแก้ไข</th>
            <th>ผู้ยื่นคำร้อง</th>
            <th>ไฟล์</th>
            <th>DAR No.</th>
            <th>ปริ๊น DAR</th>
            <th>สถานะ</th>
        </thead>
        <?php
            if ($_SESSION["admin_userid"] == "56002" || $_SESSION["admin_userid"] == "56038" || $_SESSION["admin_userid"] == "61001") {
                $sql = "SELECT top 200 *,convert(varchar, create_date,103)as create_date_date
                ,convert(varchar, create_date,108)as create_date_time
                ,convert(varchar, date_announcement,103)as date_announcement_date
                FROM tbe_document  
                where 1=1
                $condition_doc_use
                $condition_doc_type
                $condition_doc_status
                $condition_create_date
                order by create_date desc";
            } else {
                $sql = "SELECT top 200 *,convert(varchar, create_date,103)as create_date_date
                ,convert(varchar, create_date,108)as create_date_time
                ,convert(varchar, date_announcement,103)as date_announcement_date
                FROM tbe_document 
                WHERE (doc_creator in ('$empno') 
                or departmentid ='".$_SESSION['departmentid']."' )
                $condition_doc_use
                $condition_doc_type
                $condition_doc_status
                $condition_create_date
                order by create_date desc";
            }
            // echo $sql;
            $no = 0;
            $res = mssql_query($sql);
            while ($row = mssql_fetch_array($res)) {
                $no++;
                $doc_id = $row["doc_id"];
                $doc_use = lang_thai_from_database($row["doc_use"]);
                $doc_copy_type = lang_thai_from_database($row["doc_copy_type"]);
                $doc_copy_qty = ($row["doc_copy_qty"]);
                $doc_type = $row["doc_type"];
                $doc_name = lang_thai_from_database($row["doc_name"]);
                $doc_code = $row["doc_code"];
                $departmentid = $row["departmentid"];
                $department = get_departmentname($departmentid);
                $doc_revision = $row["doc_revision"];
                $date_announcement = $row["date_announcement_date"];
                $doc_detail = lang_thai_from_database($row["doc_detail"]);
                $doc_creator_empno = ($row["doc_creator"]);
                $doc_creator = get_full_name($row["doc_creator"]);
                $create_date = $row["create_date_date"] . " " . $row["create_date_time"];
                $file_name = $row["file_name"];
                $doc_status = $row["doc_status"];
                $dar_no = $row["dar_no"];
                $file_fullname = lang_thai_from_database($row["file_fullname"]);

                ?>
                <tr id="tr<?=$doc_id?>">
                    <td ><?= $no ?>
                        
                    </td>
                    <td>
                        <?= $doc_use ?>
                        <hr>
                        <?= $doc_copy_type ?> 
                        <?php
                        if($doc_copy_qty>0){
                            echo "( $doc_copy_qty )";
                        }
                        

                        ?>
                        

                    
                    </td>
                    <td>
                    <?= $doc_type ?>
                    <br>
                    <?php
                    if($_SESSION['admin_userid'] == $doc_creator_empno){
                        ?>
                        <br><button class="btn btn-warning" onclick="edit_document('<?=$doc_id?>')">แก้ไข</button>
                        <?
                    }

                    if($doc_status != "Approver Approve" && $doc_status != "Approver Reject" && $doc_status != "Old Revision" && $doc_status != "Cancel Document"){
                        ?>
                        <br><br><button class="btn btn-danger" onclick="delete_document('<?=$doc_id?>')">ลบ</button>
                        <?
                    }
                    ?>
                    </td>
                    <td><?= $department ?></td>
                    <td><?= $doc_name ?></td>
                    <td><?= $doc_code ?></td>
                    <td><button class='btn btn-link' onclick="open_amendment_record('<?= $doc_code ?>')"><?= $doc_revision ?></button></td>
                    <td><?= $create_date ?></td>
                    <td><?= $date_announcement ?></td>
                    <td><?= $doc_detail ?></td>
                    <td><?= $doc_creator ?></td>
                    <td>
                        <?php
                        if($doc_status != "Old Revision" && $doc_status != "Cancel Document"){

                            ?>
                            <a href="<?= $file_name ?>" target="_<?= $doc_id ?>" download="<?= $file_fullname ?>"><?= $file_fullname ?></a>
                            <?
                        }
                        ?>
                    </td>
                    <td id="show_dar_no<?=$doc_id?>"><?= $dar_no ?></td>
                    <td ><a class="btn btn-info " href="pop_dar.php?doc_id=<?= $doc_id ?>" target="_pop<?= $doc_id ?>">Print</a></td>
                    <td align="center">
                    <?
                            if ($doc_status == "Create") {
                                ?>
                        <button class="btn btn-success btn-label" style="margin-bottom:5px"><i class="fa fa-folder-open-o"></i> Create</button><br>
                        <button class="btn btn-warning " style="margin-bottom:5px" id="btn_reivew<?=$doc_id?>" onclick="pop_review('<?= $doc_id ?>','<?= $doc_name ?>')"><i class="fa fa-spinner fa-spin"></i> Review</button><br>
                        <button class="btn btn-defualt btn-label" style="margin-bottom:5px" id="btn_dcc<?=$doc_id?>"><i class="fa fa-ban"></i> DCC</button><br>
                        <button class="btn btn-defualt btn-label" style="margin-bottom:5px" id="btn_approve<?=$doc_id?>"><i class="fa fa-ban"></i> Approve</button><br>
                    <?
                            } else if ($doc_status == "Reviewer Approve") {
                                ?>
                        <button class="btn btn-success btn-label" style="margin-bottom:5px"><i class="fa fa-folder-open-o"></i> Create</button><br>
                        <button class="btn btn-success btn-label" style="margin-bottom:5px" id="btn_reivew<?=$doc_id?>" onclick="pop_review('<?= $doc_id ?>','<?= $doc_name ?>')"><i class="fa fa-check"></i> Review</button><br>
                        <button class="btn btn-warning " style="margin-bottom:5px"  id="btn_dcc<?=$doc_id?>" onclick="pop_dcc_action('<?= $doc_id ?>','<?= $doc_name ?>')"><i class="fa fa-spinner fa-spin"></i> DCC</button><br>
                        <button class="btn btn-defualt btn-label" style="margin-bottom:5px" id="btn_approve<?=$doc_id?>"><i class="fa fa-ban"></i> Approve</button><br>

                    <?
                            } else if ($doc_status == "Reviewer Reject") {
                                ?>
                        <button class="btn btn-success btn-label" style="margin-bottom:5px"><i class="fa fa-folder-open-o"></i> Create</button><br>
                        <button class="btn btn-danger btn-label" style="margin-bottom:5px" id="btn_reivew<?=$doc_id?>" onclick="pop_review('<?= $doc_id ?>','<?= $doc_name ?>')"><i class="fa fa-times"></i> Review</button><br>
                        <button class="btn btn-defualt btn-label" style="margin-bottom:5px" id="btn_dcc<?=$doc_id?>"><i class="fa fa-ban"></i> DCC</button><br>
                        <button class="btn btn-defualt btn-label" style="margin-bottom:5px" id="btn_approve<?=$doc_id?>"><i class="fa fa-ban"></i> Approve</button><br>
                    <?
                            } else if ($doc_status == "DCC Approve") {
                                ?>
                        <button class="btn btn-success btn-label" style="margin-bottom:5px"><i class="fa fa-folder-open-o"></i> Create</button><br>
                        <button class="btn btn-success btn-label" style="margin-bottom:5px" id="btn_reivew<?=$doc_id?>"><i class="fa fa-check"></i> Review</button><br>
                        <button class="btn btn-success btn-label" style="margin-bottom:5px"  id="btn_dcc<?=$doc_id?>" onclick="pop_dcc_action('<?= $doc_id ?>','<?= $doc_name ?>')"><i class="fa fa-check"></i> DCC </button><br>
                        <button class="btn btn-warning " style="margin-bottom:5px" id="btn_approve<?=$doc_id?>" onclick="pop_approve('<?= $doc_id ?>','<?= $doc_name ?>')"><i class="fa fa-spinner fa-spin"></i> Approve</button><br>
                    <?
                            } else if ($doc_status == "DCC Reject") {
                                ?>
                        <button class="btn btn-success btn-label" style="margin-bottom:5px"><i class="fa fa-folder-open-o"></i> Create</button><br>
                        <button class="btn btn-success btn-label" style="margin-bottom:5px" id="btn_reivew<?=$doc_id?>"><i class="fa fa-check"></i> Review</button><br>
                        <button class="btn btn-danger btn-label" style="margin-bottom:5px" id="btn_dcc<?=$doc_id?>" onclick="pop_dcc_action('<?= $doc_id ?>','<?= $doc_name ?>')"><i class="fa fa-times"></i> DCC </button><br>
                        <button class="btn btn-defualt btn-label" style="margin-bottom:5px" id="btn_approve<?=$doc_id?>"><i class="fa fa-ban"></i> Approve</button><br>
                    <?
                            } else if ($doc_status == "Approver Approve") {
                                ?>
                        <button class="btn btn-success btn-label" style="margin-bottom:5px"><i class="fa fa-folder-open-o"></i> Create</button><br>
                        <button class="btn btn-success btn-label" style="margin-bottom:5px" id="btn_reivew<?=$doc_id?>"><i class="fa fa-check"></i> Review</button><br>
                        <button class="btn btn-success btn-label" style="margin-bottom:5px" id="btn_dcc<?=$doc_id?>"><i class="fa fa-check"></i> DCC</button><br>
                        <button class="btn btn-success btn-label" style="margin-bottom:5px" id="btn_approve<?=$doc_id?>" onclick="pop_approve('<?= $doc_id ?>','<?= $doc_name ?>')"><i class="fa fa-check"></i> Approve</button><br>
                    <?
                            } else if ($doc_status == "Approver Reject") {
                                ?>
                        <button class="btn btn-success btn-label" style="margin-bottom:5px"><i class="fa fa-folder-open-o"></i> Create</button><br>
                        <button class="btn btn-success btn-label" style="margin-bottom:5px" id="btn_reivew<?=$doc_id?>"><i class="fa fa-check"></i> Review</button><br>
                        <button class="btn btn-danger btn-label" style="margin-bottom:5px" id="btn_dcc<?=$doc_id?>"><i class="fa fa-times"></i> DCC</button><br>
                        <button class="btn btn-danger btn-label" style="margin-bottom:5px" id="btn_approve<?=$doc_id?>" onclick="pop_approve('<?= $doc_id ?>','<?= $doc_name ?>')"><i class="fa fa-times"></i> Approve</button><br>
                    <?
                            } else if ($doc_status == "Old Revision") {
                                ?>
                        <button class="btn btn-inverse btn-label" style="margin-bottom:5px"><i class="fa fa-trash-o"></i> Old rev</button><br>
                    <?

                            } else if ($doc_status == "Cancel Document") {
                                ?>
                        <button class="btn btn-danger btn-label" style="margin-bottom:5px"><i class="fa fa-power-off"></i> Cancel</button><br>
                    <?
                            }
                            ?>

                </td>
            </tr>
        <?
            }

            ?>
    </table>
    <?
}else if($status=="edit_document"){
    $doc_id = $_POST["doc_id"];

    $sql = "SELECT *,convert(varchar, date_announcement,103)as date_announcement_date FROM tbe_document WHERE doc_id='$doc_id'";
    $res = mssql_query($sql);
    $row = mssql_fetch_array($res);
    $doc_id = $row["doc_id"];
    $doc_use = lang_thai_from_database($row["doc_use"]);
    $doc_use_remark = lang_thai_from_database($row["doc_use_remark"]);
    $doc_type = lang_thai_from_database($row["doc_type"]);
    $doc_type_remark = $row["doc_type_remark"];
    $doc_name = lang_thai_from_database($row["doc_name"]);
    $doc_code = lang_thai_from_database($row["doc_code"]);
    $departmentid = $row["departmentid"];
    $department = $row["department"];
    $doc_revision = $row["doc_revision"];
    $date_announcement = $row["date_announcement_date"];
    $doc_detail = lang_thai_from_database($row["doc_detail"]);
    $file_name = $row["file_name"];
    $file_fullname = $row["file_fullname"];
    $pages = $row["pages"];

    ?>
    <div class="form-horizontal"  method="post" enctype="multipart/form-data">
        <input type="hidden" name="doc_id_edit" id="doc_id_edit" value="<?=$doc_id?>">
        <div class="form-group">
            <label class="control-label col-sm-3" for="doc_use_edit">ยื่นคำร้องเพื่อ :</label>
            <div class="col-sm-3">
                <select name="doc_use_edit" id="doc_use_edit" class="form-control" readonly>
                    <option value="<?=$doc_use?>"><?=$doc_use?></option>
                </select>

            </div>
            <div class="col-sm-4" id="show_doc_use_remark"></div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-3" for="doc_type_edit">ประเภทของเอกสาร :</label>
            <div class="col-sm-3">
                <select name="doc_type_edit" id="doc_type_edit" class="form-control" onchange="select_doc_use_or_type()" readonly>
                    <option value="<?=$doc_type?>"><?=$doc_type?></option>
                    <!-- <?php
                    $sql_type = "SELECT * FROM tbe_document_doc_type where status_show='1' order by sort_id";
                    $res_type = mssql_query($sql_type);
                    while($row_type = mssql_fetch_array($res_type)){
                        $doc_type2 = $row_type["doc_type"];
                        $doc_type_show2 = lang_thai_from_database($row_type["doc_type_show"]);
                        ?>
                        <option value="<?=$doc_type2?>"
                        <?php if($doc_type2==$doc_type){
                            echo "selected";
                        }
                        ?>
                        ><?=$doc_type_show2?>
                        </option><?
                    }
                    ?> -->
                </select>
            </div>
            <div class="col-sm-4" id="show_doc_type_remark"></div>
        </div>      
        <div class="form-group">
            <label class="control-label col-sm-3" for="doc_name_edit">ชื่อเอกสาร :</label>
            <div class="col-sm-4">
                <input type="text" name="doc_name_edit" id="doc_name_edit" class="form-control" value="<?=$doc_name?>">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-3" for="doc_code_edit">รหัส :</label>
            <div class="col-sm-3">
                <input type="text" name="doc_code_edit" id="doc_code_edit" class="form-control" value="<?=$doc_code?>" readonly>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-3" for="doc_revision_edit">แก้ไขครั้งที่ :</label>
            <div class="col-sm-2">
                <input type="text" name="doc_revision_edit" id="doc_revision_edit" class="form-control" value="<?=$doc_revision?>" readonly>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-3" for="date_announcement_edit">วันที่เริ่มใช้ :</label>
            <div class="col-sm-2">
                <input type="text" name="date_announcement_edit" id="date_announcement_edit" class="form-control hasDatepicker" autocomplete="off" value="<?=$date_announcement?>">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-3" for="doc_detail_edit">รายละเอียดการแก้ไข :</label>
            <div class="col-sm-9">
                <textarea name="doc_detail_edit" id="doc_detail_edit" cols="30" rows="10" class="form-control" ><?=$doc_detail?></textarea>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-3" for="file_name">เอกสารที่แนบมาด้วย :</label>
            <div class="col-sm-5">
                <a href="<?=$file_name?>" target="_<?=$doc_id?>" download="<?=$file_fullname?>"><?=$file_fullname?></a>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-3" for="pages_edit">หน้าที่ :</label>
            <div class="col-sm-2">
                <input type="text" name="pages_edit" id="pages_edit" class="form-control" placeholder="1-3" autocomplete="off" value="<?=$pages?>">
                
            </div>
        </div>
    </div>
    <?
}else if($status=="update_doc"){
    $doc_id = $_POST["doc_id"];
    $doc_name = lang_thai_into_database($_POST["doc_name"]);
    $date_announcement = date_format_uk_into_database($_POST["date_announcement"]);
    $doc_detail = lang_thai_into_database($_POST["doc_detail"]);
    $pages = $_POST["pages"];

    $empno = $_SESSION["admin_userid"];

    $sql_doc = "SELECT * FROM tbe_document WHERE doc_id='$doc_id'";
    $res_doc = mssql_query($sql_doc);
    $row_doc = mssql_fetch_array($res_doc);
    $doc_use = $row_doc["doc_use"];
    $doc_use_remark = $row_doc["doc_use_remark"];
    $doc_copy_type = $row_doc["doc_copy_type"];
    $doc_copy_qty = $row_doc["doc_copy_qty"];
    $doc_type = $row_doc["doc_type"];
    $doc_type_remark = $row_doc["doc_type_remark"];
    $doc_code = $row_doc["doc_code"];
    $departmentid = $row_doc["departmentid"];
    $department = $row_doc["department"];
    $doc_revision = $row_doc["doc_revision"];
    $doc_creator = $row_doc["doc_creator"];
    $create_date = $row_doc["create_date"];
    $doc_status = $row_doc["doc_status"];
    $dar_no = $row_doc["dar_no"];
    $file_name = $row_doc["file_name"];
    $file_fullname = $row_doc["file_fullname"];
    $reviewer = $row_doc["reviewer"];
    $reviewer_remark = $row_doc["reviewer_remark"];
    $date_reviewer = $row_doc["date_reviewer"];
    $approve_name = $row_doc["approve_name"];
    $approve_remark = $row_doc["approve_remark"];
    $date_approve = $row_doc["date_approve"];

    $insert = "INSERT INTO tbe_document_log
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
            ,department 
            ,doc_revision 
            ,date_announcement 
            ,doc_detail 
            ,doc_creator 
            ,create_date 
            ,doc_status 
            ,dar_no 
            ,reviewer
            ,reviewer_remark
            ,date_reviewer
            ,approve_name
            ,approve_remark
            ,date_approve
            ,file_name 
            ,file_fullname 
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
            ,'$departmentid'
            ,'$department'
            ,'$doc_revision'
            ,'$date_announcement'
            ,'$doc_detail'
            ,'$doc_creator'
            ,'$create_date'
            ,'$doc_status'
            ,'$dar_no'
            ,'$reviewer'
            ,'$reviewer_remark'
            ,'$date_reviewer'
            ,'$approve_name'
            ,'$approve_remark'
            ,'$date_approve'
            ,'$file_name'
            ,'$file_fullname'
            ,'$pages'
            ,'$empno'
            ,'Update'
            ,'$date_time'
        )";
    mssql_query($insert);

    
    


    $update = "UPDATE tbe_document set 
        doc_name='$doc_name'
        ,date_announcement='$date_announcement' 
        ,doc_detail='$doc_detail' 
        ,pages='$pages' 
        ,create_date='$date_time' 
        ,doc_status='Create'
        WHERE doc_id='$doc_id'
        ";
    mssql_query($update);

    

    $html = "Edit Dar : <BR><BR>";		
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
    $mail->Subject = "Edit Dar ".$_POST['doc_code'];
    
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



}else if($status=="delete_document"){
    $doc_id = $_POST["doc_id"];
    
    $sql = "SELECT * FROM tbe_document WHERE doc_id = '$doc_id'";
    $res = mssql_query($sql);
    $row = mssql_fetch_array($res);
    $doc_id = $row["doc_id"];
    $doc_use = $row["doc_use"];
    $doc_use_remark = $row["doc_use_remark"];
    $doc_type = $row["doc_type"];
    $doc_type_remark = $row["doc_type_remark"];
    $doc_name = $row["doc_name"];
    $doc_code = $row["doc_code"];
    $departmentid = $row["departmentid"];
    $department = $row["department"];
    $doc_revision = $row["doc_revision"];
    $date_announcement = $row["date_announcement"];
    $doc_detail = $row["doc_detail"];
    $doc_creator = $row["doc_creator"];
    $create_date = $row["create_date"];
    $doc_status = $row["doc_status"];
    $dar_no = $row["dar_no"];
    $file_name = $row["file_name"];
    $file_fullname = $row["file_fullname"];
    $pages = $row["pages"];

    $empno = $_SESSION["admin_userid"];

    $insert = "INSERT INTO tbe_document_log
        (
            doc_id 
            ,doc_use 
            ,doc_use_remark 
            ,doc_type 
            ,doc_type_remark 
            ,doc_name 
            ,doc_code 
            ,departmentid 
            ,department 
            ,doc_revision 
            ,date_announcement 
            ,doc_detail 
            ,doc_creator 
            ,create_date 
            ,doc_status 
            ,dar_no 
            ,file_name 
            ,file_fullname 
            ,pages 
            ,admin_userid_action 
            ,action 
            ,action_date 
        ) VALUES
        (
            '$doc_id'
            ,'$doc_use'
            ,'$doc_use_remark'
            ,'$doc_type'
            ,'$doc_type_remark'
            ,'$doc_name'
            ,'$doc_code'
            ,'$departmentid'
            ,'$department'
            ,'$doc_revision'
            ,'$date_announcement'
            ,'$doc_detail'
            ,'$doc_creator'
            ,'$create_date'
            ,'$doc_status'
            ,'$dar_no'
            ,'$file_name'
            ,'$file_fullname'
            ,'$pages'
            ,'$empno'
            ,'Delete'
            ,'$date_time'
        )";
    mssql_query($insert);
    
    $delete = "DELETE FROM tbe_document WHERE doc_id='$doc_id'";
    mssql_query($delete);
    

}

?>