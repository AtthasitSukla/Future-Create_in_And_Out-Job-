<?php
session_start();
ini_set('session.bug_compat_warn', 0);
ini_set('session.bug_compat_42', 0);
//echo $_SESSION['production_line'];
include("connect.php");
include("library.php");

$job_ot_id = $_GET["job_ot_id"];
$thai_day_arr=array("อาทิตย์","จันทร์","อังคาร","พุธ","พฤหัสบดี","ศุกร์","เสาร์");

$sql_h = "SELECT date_ot,departmentid,remark,qty_male,qty_female FROM tbot_request WHERE job_ot_id='$job_ot_id'";
$res_h = mssql_query($sql_h);
$row_h = mssql_fetch_array($res_h);
$date_ot = $row_h["date_ot"];
$departmentid = $row_h["departmentid"];
$remark = lang_thai_from_database($row_h["remark"]);
$qty_male = $row_h["qty_male"];
$qty_female = $row_h["qty_female"];
$dayname_ot = $thai_day_arr[date("w", strtotime($date_ot))];
$day_ot = date("d", strtotime($date_ot));
$mounth_ot = date("m", strtotime($date_ot));
$year_ot = (int)date("Y", strtotime($date_ot))+543;

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
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="fonts.css" type="text/css" charset="utf-8" />
    <title>FM-HR-09 Rev.02 :10/9/18</title>
    <style type="text/css">
        .demo {
            font-family: 'Conv_free3of9', Sans-Serif;
        }

        .demo2 {
            font-family: 'tahoma';
        }

        table {
            border-collapse: collapse;
        }

        #table_ot,
        {
            border: 1px solid black;
        }
    </style>
</head>
<!-- onLoad="window.print();" -->
<body bgcolor="#FFFFFF" > 
    <table width='100%' border="1" id="table_ot">
        <tr>
            <td align="center" colspan="5"><img src="images/powered_barcode.png" width="80px" style="margin-bottom:-5px"><b><font size='3px'>I PACK LOGISTICESCO.,LTD</font></b></td>
            <td align="center" ><?=$dayname_ot?></td>
            <td align="center" ><?=$day_ot?></td>
            <td align="center" ><?=$mounth_ot?></td>
            <td align="center" colspan="2"><?=$year_ot?></td>
            <td align="center" colspan="3" width='150px'><font size='2px'>OT หลังห้าโมงเย็น</font></td>
            <td align="center" colspan="3" width='150px'> <font size='2px'>OT พิเศษ</font></td>
        </tr>
        <tr>
            <td align="center" colspan="5" rowspan="2">แบบฟอร์มขอทำงานล่วงเวลา (OT)(แผนก <?=$department?> )</td>
            <td align="center" ><font size='1'>วัน</font></td>
            <td align="center" ><font size='1'>วันที่</font></td>
            <td align="center" ><font size='1'>เดือน</font></td>
            <td align="center" colspan="2"><font size='1'>พ.ศ.</font></td>
            <td align="center" rowspan="3"><font size='2px'>เริ่ม</font></td>
            <td align="center" colspan="2" rowspan="3"><font size='2px'> 17:30  - 20:00 </font></td>
            <td align="center" rowspan="3"><font size='2px'>เริ่ม</font></td>
            <td align="center" colspan="2" rowspan="3"><font size='2px'>__:__น. - __:__น.</font></td>
        </tr>
        <tr>
            <td align="center" colspan="2" rowspan="2"><font size='2px'>พนักงานเซนต์รับทราบ</font></td>
            <td align="center" colspan="3"><font size='2px'>ผู้อนุมัติ</font></td>
        </tr>
        <tr>
            <td align="center"><font size='2px'>ลำดับ</font></td>
            <td align="center"><font size='2px'>รายชื่อ</font></td>
            <td align="center"><font size='2px'>นามสกุล</font></td>
            <td align="center"><font size='2px'>ตำแหน่ง</font></td>
            <td align="center"><font size='2px'>สถานะ OT</font></td>
            <td align="center"><font size='2px'>Supervisor</font></td>
            <td align="center"><font size='2px'>Manager</font></td>
            <td align="center"><font size='2px'>GM</font></td>
            
        </tr>
        <?php
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
            , tbot_request.status_ot
            , tbot_request.start_time_approve
            , tbot_request.end_time_approve
            , tbot_request.remark_person
            , tbot_request.qty_male
            , tbot_request.qty_female
            , tbot_request.remark
            FROM  tbot_request INNER JOIN  tbemployee
            on tbot_request.empno = tbemployee.empno
            INNER JOIN tbposition 
            ON tbemployee.positionid = tbposition.positionid 
            where tbot_request.job_ot_id='$job_ot_id'
            ORDER BY tbposition.sort_id,tbposition.positionid ,tbemployee.empno";
            $res = mssql_query($sql);
            $no=0;
            while($row = mssql_fetch_array($res)){
                $no++;
                $empno = ($row["empno"]);
                $firstname = lang_thai_from_database($row["firstname"]);
                $lastname = lang_thai_from_database($row["lastname"]);
                $positionname = lang_thai_from_database($row["positionname"]);
                $remark_person = lang_thai_from_database($row["remark_person"]);
                $status_ot = ($row["status_ot"]);
                $start_time_approve = ($row["start_time_approve"]);
                $end_time_approve = ($row["end_time_approve"]);
            
                ?>
                <tr>
                    <td align="center"><font size='2px'><?=$no?></font></td>
                    <td ><font size='2px'><?=$firstname?></font></td>
                    <td ><font size='2px'><?=$lastname?></font></td>
                    <td align="center"><font size='2px'><?=$positionname?></font></td>
                    <td align="center"><font size='2px'><?=$status_ot?></font></td>
                    <td  colspan="2">
                        <font size='2px'>
                        <?php
                        // echo "signature_empno/$empno.png $status_ot";
                        if(file_exists("signature_empno/$empno.png") && $status_ot=='O'){
                            ?><img src="signature_empno/<?=$empno?>.png" alt="" width="50px"><?
                        }else{
                            ?><?
                        }
                        ?>
                        <?=$remark_person?>
                        </font>
                    </td>
                    <td align="center"><font size='2px'></font></td>
                    <td align="center"><font size='2px'></font></td>
                    <td align="center"><font size='2px'></font></td>
                    <td align="center"><font size='2px'></font></td>
                    <td align="center"><font size='2px'><?=$start_time_approve?></font></td>
                    <td align="center"><font size='2px'><?=$end_time_approve?></font></td>
                    <td align="center"><font size='2px'></font></td>
                    <td align="center"><font size='2px'></font></td>
                    <td align="center"><font size='2px'></font></td>
                    
                </tr>
                <?
                
            }
            if($no%19!=0){
                $no++;
                for($i=$no;$i<=19;$i++){
                    ?>
                    <tr>
                        <td align="center"><font size='2px'><?=$i?></font></td>
                        <td ></td>
                        <td ></td>
                        <td align="center"></td>
                        <td align="center"></td>
                        <td align="center" colspan="2"></td>
                        <td align="center"></td>
                        <td align="center"></td>
                        <td align="center"></td>
                        <td align="center"></td>
                        <td align="center"></td>
                        <td align="center"></td>
                        <td align="center"></td>
                        <td align="center"></td>
                        <td align="center"></td>
                        
                    </tr>
                    <?
                }
            }
        ?>
        <tr>
            <td colspan='16'>
                <table  width='100%' border="0">
                    <tr>
                        <td width='250px'><font size='2px' style="margin:20px">รายละเอียดที่ขอทำงานล่วงเวลา (OT) :</font></td>
                        <td><font size='2px' style="margin:20px"><?=$remark?></font></td>
                    </tr>
                    <tr>
                        <td align="center">
                            <table>
                                <tr>
                                    <td colspan="3" align="center"><font size='2px' >สรุปพนักงานที่ทำงานล่วงเวลาประจำวัน</font></td>    
                                </tr>
                                <tr>
                                    <td align="center"><font size='2px' >ชาย</font></td>
                                    <td align="center"><font size='2px' ><?=$qty_male?></font></td>
                                    <td align="center"><font size='2px' >คน</font></td>
                                </tr>
                                <tr>
                                    <td align="center"><font size='2px' >หญิง</font></td>
                                    <td align="center"><font size='2px' ><?=$qty_female?></font></td>
                                    <td align="center"><font size='2px' >คน</font></td>
                                </tr>
                            </table>
                        </td>
                        <td align="center">
                            <table>
                                <tr>
                                    <td colspan="2" align="center"><font size='2px' >สถานะคนที่ทำงานล่วงเวลา OT</font></td>    
                                </tr>
                                <tr>
                                    <td align="center"><font size='2px' >O</font></td>
                                    <td align="center"><font size='2px' >ทำโอที</font></td>
                                </tr>
                                <tr>
                                    <td align="center"><font size='2px' >X</font></td>
                                    <td align="center"><font size='2px' >ไม่ทำโอที</font></td>
                                </tr>
                                <tr>
                                    <td align="center"><font size='2px' >-</font></td>
                                    <td align="center"><font size='2px' >ไม่มาทำงาน</font></td>
                                </tr>
                                <tr>
                                    <td align="center"><font size='2px' >#</font></td>
                                    <td align="center"><font size='2px' >งดโอที</font></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
            <!-- <td colspan='16'><font size='2px' style="margin:20px">รายละเอียดที่ขอทำงานล่วงเวลา (OT) : <?=$remark?> </font></td> -->
        </tr>
    </table>
    <table width='100%' border="0">
        <tr>
            <td align="right"><font size='1px'>FM-HR-09 Rev.02 :10/9/18</font></td>
        </tr>
    </table>
    
</body>

</html>