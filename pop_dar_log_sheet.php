<?php
session_start();
include("connect.php");
include("library.php");
$doc_use_log_sheet = lang_thai_into_database($_GET['doc_use_log_sheet']);
$doc_type_log_sheet = $_GET['doc_type_log_sheet'];
$create_date_log_sheet_start = date_format_uk_into_database($_GET['create_date_log_sheet_start']);
$create_date_log_sheet_end = date_format_uk_into_database($_GET['create_date_log_sheet_end']);

?>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>FM-QMS-15 rev.00 : 7/7/2016</title>
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
<!-- onload="window.print();" -->
<body >
    <table border="1" width='100%' id="table_main" cellpadding='5'>
        <tr>
            <td colspan="2" class="td_main" align='center'>
                <img src="clip_image002.png" width="200">
                <br>
                <font size='2'><strong>IPACK Logistics Co.,Ltd</strong></font>
            </td>
            <td colspan="5" align='center'>
                <strong>
                    ทะเบียนควบคุมเอกสาร (DAR LOG SHEET)
                </strong>
            </td>

        </tr>
        <tr>
            <td align='center'><font size='2'><strong>ลำดับที่</strong></font></td>
            <td align='center'><font size='2'><strong>หมายเลข DAR</strong></font></td>
            <td align='center'><font size='2'><strong>รายละเอียด-การแก้ไข</strong></font></td>
            <td align='center'><font size='2'><strong>แก้ไขครั้งที่</strong></font></td>
            <td align='center'><font size='2'><strong>ประกาศใช้</strong></font></td>
            <td align='center'><font size='2'><strong>หน่วยงาน</strong></font></td>
            <td align='center'><font size='2'><strong>หมายเหตุ</strong></font></td>
        </tr>
        <?php
        if($doc_use_log_sheet!=""){
            $doc_use_log_sheet_condition = "AND doc_use = '$doc_use_log_sheet'";
        }else{
            $doc_use_log_sheet_condition = "";
        }
        
        if($doc_type_log_sheet!=""){
            $doc_type_log_sheet_condition = "AND doc_type = '$doc_type_log_sheet'";
        }else{
            $doc_type_log_sheet_condition = "";
        }

        $sql = "SELECT *,convert(varchar, create_date,103)as create_date_date
        ,convert(varchar, create_date,108)as create_date_time 
        ,convert(varchar, date_announcement,103)as date_announcement_date
        FROM tbe_document 
        WHERE date_announcement between '$create_date_log_sheet_start' AND '$create_date_log_sheet_end'
        AND dar_no != ''
        $doc_use_log_sheet_condition
        $doc_type_log_sheet_condition
        order by dar_no";
        $res = mssql_query($sql);
        // echo $sql;
        $no=0;
        while($row = mssql_fetch_array($res)){
            $doc_use = lang_thai_from_database($row["doc_use"]);
            $doc_use_remark = lang_thai_from_database($row["doc_use_remark"]);
            $doc_type = $row["doc_type"];
            $departmentid_sql = $row["departmentid"];
            $department = get_departmentname($departmentid_sql);
            $doc_revision = $row["doc_revision"];
            $date_announcement = $row["date_announcement_date"];
            $doc_detail = lang_thai_from_database($row["doc_detail"]);
            $doc_status = $row["doc_status"];
            $dar_no = $row["dar_no"];
            $no++;

            if($doc_status=="Cancel Document"){
                $bg_color = "bgcolor='red'";
            }else{
                $bg_color = ""; 
            }
            ?>
            <tr <?=$bg_color?>>
                <td align='center'><font size='2'><?=$no?></font></td>
                <td align='center'><font size='2'><?=$dar_no?></font></td>
                <td><font size='2'><?=$doc_detail?></font></td>
                <td align='center'><font size='2'><?=$doc_revision?></font></td>
                <td align='center'><font size='2'><?=$date_announcement?></font></td>
                <td align='center'><font size='2'><?=$department?></font></td>
                <td align='center'><font size='2'><?=$doc_use?> <?=$doc_use_remark?></font></td>
            </tr>
            <?
        }

        ?>
        
    </table>
    <table border="0" width='100%'>
        <tr>
            <td align="right"><font size='2'>FM-QMS-15 rev.00 : 7/7/2016</font></td>
        </tr>
    </table>
</body>

</html>