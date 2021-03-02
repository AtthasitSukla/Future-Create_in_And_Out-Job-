<?php
session_start();
include("connect.php");
include("library.php");
$doc_id = $_REQUEST['doc_id'];

$sql = "SELECT *,convert(varchar, create_date,103)as create_date_date
,convert(varchar, create_date,108)as create_date_time 
,convert(varchar, date_announcement,103)as date_announcement_date
FROM tbe_document WHERE doc_id='$doc_id'";
$res = mssql_query($sql);
$row = mssql_fetch_array($res);
$doc_use = lang_thai_from_database($row["doc_use"]);
$doc_use_remark = lang_thai_from_database($row["doc_use_remark"]);
$doc_type = $row["doc_type"];
$doc_type_remark = lang_thai_from_database($row["doc_type_remark"]);
$doc_name = lang_thai_from_database($row["doc_name"]);
$doc_code = $row["doc_code"];
$departmentid_sql = $row["departmentid"];
$department = $row["department"];
$doc_revision = $row["doc_revision"];
$date_announcement = $row["date_announcement_date"];
$doc_detail = lang_thai_from_database($row["doc_detail"]);
$doc_creator_empno = ($row["doc_creator"]);
$doc_creator = get_full_name($row["doc_creator"]);
$create_date = $row["create_date_date"]." ".$row["create_date_time"];
$doc_status = $row["doc_status"];
$dar_no = $row["dar_no"];
$reviewer_empno = ($row["reviewer"]);
$reviewer = get_full_name($row["reviewer"]);
$date_reviewer = $row["date_reviewer"];
$approve_name_empno = ($row["approve_name"]);
$approve_name = get_full_name($row["approve_name"]);
$date_approve = $row["date_approve"];
$file_name = $row["file_name"];
$file_fullname = lang_thai_from_database($row["file_fullname"]);
?>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>FM-QMS-10 rev.00 : 20/9/2015</title>
</head>
<style type="text/css">
    .demo {
        font-family: 'Conv_free3of9', Sans-Serif;
    }

    .demo2 {
        font-family: 'tahoma';
    }

    #table_main {
        border-collapse: collapse;

    }

    #table_main .td_main,
    #table_main {
        border: 1px solid black;
    }
</style>

<body onload="window.print();">
    <table border="1" width='100%' id="table_main" cellpadding='5'>
        <tr>
            <td colspan="4" class="td_main"><img src="clip_image002.png" width="200">
                <br>
                <strong>
                    <center>ใบขอดำเนินการเกี่ยวกับเอกสาร<br> Document Action Requset ( DAR )</center>
                </strong>
            </td>

        </tr>
        <tr>
            <td colspan="2" align="center" class="td_main" width='50%'>
                <font size='2'>วันที่ร้องขอ : <?=$create_date?></font>
            </td>
            <td colspan="2" align="center">
                <font size='2'>DAR No. : <?=$dar_no?> ( สำหรับ DCC ) </font>
            </td>
        </tr>
        <tr>
            <td colspan="2" align="center" class="td_main" >
                <font size='2'><strong>ยื่นคำร้องเพื่อ : </strong></font>
                    <table border="0" width='100%' cellpadding='0'>
                        <tr>
                            <td>
                                <font size='2'>
                                    <?php
                                    if($doc_use=="ขอจัดทำเอกสารใหม่"){
                                        ?>
                                        <img src='images/check_checked.JPG' width="15px">
                                        <?php
                                    }else{
                                        ?>
                                        <img src='images/check_emty.JPG' width="15px">
                                        <?php
                                    }
                                    ?>
                                    ขอจัดทำเอกสารใหม่
                                </font>
                            </td>
                            <td>
                                <font size='2'>
                                <?php
                                    if($doc_use=="ขอเปลี่ยนแปลงแก้ไข"){
                                        ?>
                                        <img src='images/check_checked.JPG' width="15px">
                                        <?php
                                    }else{
                                        ?>
                                        <img src='images/check_emty.JPG' width="15px">
                                        <?php
                                    }
                                    ?>
                                    ขอเปลี่ยนแปลงแก้ไข
                                </font>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <font size='2'>
                                    <?php
                                    if($doc_use=="ขอยกเลิกเอกสาร"){
                                        ?>
                                        <img src='images/check_checked.JPG' width="15px">
                                        <?php
                                    }else{
                                        ?>
                                        <img src='images/check_emty.JPG' width="15px">
                                        <?php
                                    }
                                    ?>
                                    ขอยกเลิกเอกสาร
                                </font>
                            </td>
                            <td>
                                <font size='2'>
                                    <?php
                                    if($doc_use=="ขอสำเนาควบคุม"){
                                        ?>
                                        <img src='images/check_checked.JPG' width="15px">
                                        <?php
                                    }else{
                                        ?>
                                        <img src='images/check_emty.JPG' width="15px">
                                        <?php
                                    }
                                    ?>
                                    ขอสำเนาควบคุม
                                </font>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <font size='2'>
                                    <?php
                                    if($doc_use=="ขอสำเนาไม่ควบคุม"){
                                        ?>
                                        <img src='images/check_checked.JPG' width="15px">
                                        <?php
                                    }else{
                                        ?>
                                        <img src='images/check_emty.JPG' width="15px">
                                        <?php
                                    }
                                    ?>
                                    ขอสำเนาไม่ควบคุม
                                </font>
                            </td>
                            <td>
                                <font size='2'>
                                    <?php
                                    if($doc_use=="อื่น ๆ"){
                                        ?>
                                        <img src='images/check_checked.JPG' width="15px">
                                        <?php
                                    }else{
                                        ?>
                                        <img src='images/check_emty.JPG' width="15px">
                                        <?php
                                    }
                                    ?>
                                    
                                    อื่น ๆ <?=$doc_use_remark?>
                                </font>
                            </td>
                        </tr>
                    </table>

            </td>
            <td colspan="2" align="center" class="td_main" width='50%'>
                <font size='2'><strong>ประเภทของเอกสาร : </strong></font>
                    <table border="0" width='100%' cellpadding='0'>
                        <tr>
                            <td>
                                <font size='2'>
                                    <?php
                                    if($doc_type=="QM"){
                                        ?>
                                        <img src='images/check_checked.JPG' width="15px">
                                        <?php
                                    }else{
                                        ?>
                                        <img src='images/check_emty.JPG' width="15px">
                                        <?php
                                    }
                                    ?>
                                    คู่มือคุณภาพ (QM)
                                </font>
                            </td>
                            <td>
                                <font size='2'>
                                <?php
                                    if($doc_type=="QP"){
                                        ?>
                                        <img src='images/check_checked.JPG' width="15px">
                                        <?php
                                    }else{
                                        ?>
                                        <img src='images/check_emty.JPG' width="15px">
                                        <?php
                                    }
                                    ?>
                                    ระเบียบปฏิบัติงาน (QP)
                                </font>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <font size='2'>
                                <?php
                                    if($doc_type=="WI"){
                                        ?>
                                        <img src='images/check_checked.JPG' width="15px">
                                        <?php
                                    }else{
                                        ?>
                                        <img src='images/check_emty.JPG' width="15px">
                                        <?php
                                    }
                                    ?>
                                    วิธีปฏิบัติงาน (WI)
                                </font>
                            </td>
                            <td>
                                <font size='2'>
                                <?php
                                    if($doc_type=="FM"){
                                        ?>
                                        <img src='images/check_checked.JPG' width="15px">
                                        <?php
                                    }else{
                                        ?>
                                        <img src='images/check_emty.JPG' width="15px">
                                        <?php
                                    }
                                    ?>
                                    แบบฟอร์ม (FM)
                                </font>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <font size='2'>
                                <?php
                                    if($doc_type=="SD"){
                                        ?>
                                        <img src='images/check_checked.JPG' width="15px">
                                        <?php
                                    }else{
                                        ?>
                                        <img src='images/check_emty.JPG' width="15px">
                                        <?php
                                    }
                                    ?>
                                    มาตรฐานการทำงาน (SD)
                                </font>
                            </td>
                            <td>
                                <font size='2'>
                                <?php
                                    if($doc_type=="Other"){
                                        ?>
                                        <img src='images/check_checked.JPG' width="15px">
                                        <?php
                                    }else{
                                        ?>
                                        <img src='images/check_emty.JPG' width="15px">
                                        <?php
                                    }
                                    ?>
                                    อื่น ๆ  <?=$doc_type_remark?>
                                </font>
                            </td>
                        </tr>
                    </table>
            </td>
        <tr>
            <td colspan='4' class="td_main">
                <font size='2'><strong>รายละเอียดเอกสารเดิม (ถ้ามี)</strong></font>
                <table width='100%' border='0'>
                    <tr>
                        <td colspan='2'> <font size='2'>ชื่อเอกสาร <?=$doc_name?></font></td>
                        <td > <font size='2'>รหัส <?=$doc_code?></font></td>
                        <td> <font size='2'>แก้ไขครั้งที่ <?=$doc_revision?></font></td>
                        <td> <font size='2'>วันที่เริ่มใช้ <?=$date_announcement?></font></td>
                    </tr>
                    <tr>
                        <td colspan='5'>
                            <font size='2'>
                                <strong>รายละเอียดการแก้ไข</strong>
                            </font>
                        </td>

                    </tr>
                    <tr>
                        <td colspan='5'style="padding: 20px;">
                            <font size='2'>
                                <?=$doc_detail?>
                                <br>
                            </font>
                        </td>

                    </tr>
                    <tr>
                        <td width='170px'>
                            <font size='2'>
                                <strong>เอกสารที่แนบมาด้วย : </strong>
                            </font>
                        </td>
                        <td >
                            <font size='2'>
                                <?
                                if($file_fullname!="" && $file_fullname!=" "){
                                    ?>
                                    <img src='images/check_checked.JPG' width="15px"> มี
                                    <br>
                                    <img src='images/check_emty.JPG' width="15px"> ไม่มี
                                    <?
                                }else{
                                    ?>
                                    <img src='images/check_emty.JPG' width="15px"> มี
                                    <br>
                                    <img src='images/check_checked.JPG' width="15px"> ไม่มี
                                    <?
                                }
                                ?>
                                
                            </font>
                        </td>
                        <td colspan='3' valign="top">
                            <font size='2'>
                                <?=$file_fullname?>
                                
                            </font>
                        </td>
                    </tr>
                    
                </table>
            </td>
            <tr>
                <td align="center" valign="bottom" height="50" class="td_main" width='33%'>
                    <font size='2'> 
                        ผู้ยื่นคำร้อง 
                        <?php
                        if(file_exists("signature_empno/$doc_creator_empno.png") ){
                            ?><img src="signature_empno/<?=$doc_creator_empno?>.png" alt="" width="70px"><?
                        }else{
                            echo $doc_creator;
                        }
                        ?>
                        
                    </font>
                </td>
                <td align="center" valign="bottom" height="50" class="td_main" width='33%' colspan='2'>
                    <font size='2'>
                        ผู้ทบทวน 
                        <?php
                        if(file_exists("signature_empno/$reviewer_empno.png") ){
                            ?><img src="signature_empno/<?=$reviewer_empno?>.png" alt="" width="70px"><?
                        }else{
                            echo $reviewer;
                        }
                        ?>
                    </font>
                </td>
                <td align="center" valign="bottom" height="50" class="td_main" width='33%'>
                    <font size='2'>
                        ผู้อนุมัติ 
                        <?php
                        if(file_exists("signature_empno/$approve_name_empno.png") ){
                            ?><img src="signature_empno/<?=$approve_name_empno?>.png" alt="" width="70px"><?
                        }else{
                            echo $approve_name;
                        }
                        ?>
                    </font>
                </td>
            </tr>
        </tr>
    </table>
    <br>
    <table border="1" width='100%' id="table_main" cellpadding='5'>
        <tr>
            <td colspan="7" align="center" class="td_main"><strong>ส่วนการแจกจ่าย / เรียกคืนเอกสาร</strong></td>
        </tr>
        <tr>
            <td align="center" class="td_main" rowspan="2"><font size='2'><strong>ลำดับ</strong></font></td>
            <td align="center" class="td_main" rowspan="2"><font size='2'><strong>รายนามผู้ได้รับเอกสาร</strong></font></td>
            <td align="center" class="td_main" rowspan="2"><font size='2'><strong>หน่วยงาน</strong></font></td>
            <td align="center" class="td_main" colspan="2"><font size='2'><strong>ลายมือชื่อผู้รับ / คืนเอกสาร</strong></font></td>
            <td align="center" class="td_main" rowspan="2"><font size='2'><strong>วันที่<br>รับเอกสาร</strong></font></td>
            <td align="center" class="td_main" rowspan="2"><font size='2'><strong>วันที่<br>คืนเอกสาร</strong></font></td>
        </tr>    
        <tr>
            <td align="center" class="td_main"><font size='2'><strong>รับเอกสาร</strong></font></td>
            <td align="center" class="td_main"><font size='2'><strong>คืนเอกสาร</strong></font></td>
        </tr>  
        <?
        for($i=0;$i<10;$i++){
            ?>
            <tr>
                <td align="center" class="td_main" height='25'><font size='2'></font></td>
                <td align="center" class="td_main" ><font size='2'></font></td>
                <td align="center" class="td_main" ><font size='2'></font></td>
                <td align="center" class="td_main" ><font size='2'></font></td>
                <td align="center" class="td_main" ><font size='2'></font></td>
                <td align="center" class="td_main" ><font size='2'></font></td>
                <td align="center" class="td_main" ><font size='2'></font></td>
            </tr>                
            <?
        }
        ?>
    </table>
    <table border="0" width='100%'>
        <tr>
            <td align="right"><font size='2'>FM-QMS-10 rev.00 : 20/9/2015</font></td>
        </tr>

    </table>
</body>

</html>