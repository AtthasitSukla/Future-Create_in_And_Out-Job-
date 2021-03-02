<? ob_start(); ?>
<? include("connect.php");
include("library.php");   ?>
<?
			
			$paycode = $_REQUEST['paycode'];
			$tsite  = $_REQUEST['tsite'];
			$status = $_REQUEST['status'];
			
				if($paycode!=''){
			
			$select="select paycode,convert(varchar, startdate, 101)as  startdate,
	convert(varchar, enddate, 101)as  enddate from  tbpaycode where paycode = '$paycode' ";
				$re=mssql_query($select);
				$num=mssql_num_rows($re);
				
					$row=mssql_fetch_array($re);
					$startdate = $row['startdate'];
					$enddate = $row['enddate'];
				
			}
		

?>
<html >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Export Report</title>

</head>

<body >

  
  <?
  if($status=='rawatt'){
  
$strExcelFileName="rawatt".$paycode.".xls";
header("Content-Type: application/x-msexcel; name=\"$strExcelFileName\"");
header("Content-Disposition: inline; filename=\"$strExcelFileName\"");
header("Pragma:no-cache");
  
  		 
				
				?>
                
               
                <table border="1" cellpadding="0" cellspacing="0">
                
                  <tr>
                    <td width="72" align="center" bgcolor="#CCCCCC"><strong>empno</strong></td>
                    <td width="154" align="center" bgcolor="#CCCCCC"><strong>attdate</strong></td>
                    <td width="101" align="center" bgcolor="#CCCCCC"><strong>Shift</strong></td>
                    <td width="54" align="center" bgcolor="#CCCCCC"><strong>OT</strong></td>
                    <td width="54" align="center" bgcolor="#CCCCCC"><strong>FL</strong></td>
                    <td width="54" align="center" bgcolor="#CCCCCC"><strong>LE</strong></td>
                    <td width="141" align="center" bgcolor="#CCCCCC"><strong>remark</strong></td>
                    <td width="141" align="center" bgcolor="#CCCCCC"><strong>Name</strong></td>
                     <td width="154" align="center" bgcolor="#CCCCCC"><strong>attdate_en</strong></td>
                      <td width="154" align="center" bgcolor="#CCCCCC"><strong>attdate_timestamp</strong></td>
                  </tr>
                  <?
                  	$select0="SELECT *,convert(varchar, attDateTime, 101)as  workdate2,convert(varchar, attDateTime, 103)as  workdate3,convert(varchar, attDateTime, 108)as  worktime
FROM    tbatt where cast(attDateTime as date) between '".$startdate."' and '".$enddate."' and empno in(select empno from tbemployee where site='$tsite')  order by empno,workdate2 asc ";
	//echo $select0;
	$re0=mssql_query($select0);
	
	while($row0=mssql_fetch_array($re0)){
		
		$select2="select firstname,lastname from tbemployee where empno='".$row0['empno']."' ";
		$re2=mssql_query($select2);
		$row2=mssql_fetch_array($re2);
	//	$empname =  $row2['firstname']." ".$row2['lastname'];
		$empname = iconv("tis-620", "utf-8", $row2['firstname']." ".$row2['lastname'] );
		$arr_datetime_thai = explode("/",$row0['workdate2']);
		$datetime_thai = $arr_datetime_thai[1]."/".$arr_datetime_thai[0]."/".$arr_datetime_thai[2];
		$datetime_en= $row0['workdate2'];
		$datetimestamp = $arr_datetime_thai[2].$arr_datetime_thai[0].$arr_datetime_thai[1];
				  ?>
                  <tr>
                    <td align="center"><?=$row0['empno']?></td>
                    <td align="center"><?=$datetime_thai?> <?=$row0['worktime']?></td>
                    <td align="center">&nbsp;</td>
                    <td align="center">&nbsp;</td>
                    <td align="center">&nbsp;</td>
                    <td align="center">&nbsp;</td>
                    <td align="center"> </td>
                       <td align="center"><?=$empname?></td>
                        <td align="center"><?=$datetime_en?> <?=$row0['worktime']?></td>
                         <td align="center"><?=$datetimestamp?></td>
                  </tr>
                  <?
	}
				  ?>
               
                </table>

<?
					
				
				
				
			
				
 
  }
  if($status=='salary'){
  
$strExcelFileName="salary".$paycode.".xls";
header("Content-Type: application/x-msexcel; name=\"$strExcelFileName\"");
header("Content-Disposition: inline; filename=\"$strExcelFileName\"");
header("Pragma:no-cache");
  
  	$selectp="SELECT paycode, paycodename from tbpaycode where paycode='$paycode' ";
	$rep=mssql_query($selectp);
	$rowp=mssql_fetch_array($rep);
				
				?>
                
               
               
                <table width="100%" border="1" cellpadding="0" cellspacing="0">
                  <tr>
                    <td colspan="27" align="center"><strong>บริษัท ไอแพ็ค โลจิสติกส์ จำกัด</strong></td></tr>
                  <tr>
                    <td colspan="27" align="center"><strong>เงินเดือนพนักงานประจำเดือน 
                    <?=iconv("tis-620", "utf-8", $rowp['paycodename'] );?>
                    </strong></td></tr>
                  <tr>
                    <td align="center" width="109">รหัสพนักงาน</td>
                    <td width="188" colspan="2" align="center">ชื่อ - นามสกุล</td>
                    <td width="124">Site</td>
                    <td width="97" align="center">เบี้ยรายวัน/รายเดือน</td>
                    <td width="87" align="center">หักประกันสังคม    5%</td>
                    <td width="84" align="center">หักภาษีบุคคล</td>
                    <td width="89" align="center">หักขาดงาน</td>
                    <td width="89" align="center">หักลากิจ</td>
                    <td width="89" align="center">หักลาไม่ได้รับเงินเดือน</td>
                    <td width="89" align="center">หักอื่นๆ</td>
                    <td width="89" align="center">OT</td>
                    <td width="89" align="center">ค่าข้าว75บาทต่อวัน</td>
                    <td width="86" align="center">ค่ากะ 120    บาทต่อวัน</td>
                    <td width="73" align="center">incentive    Forklift</td>
                    <td width="75" align="center">เบี้ยขยัน</td>
                    <td width="81" align="center">ตกเบิก</td>
                    <td width="81" align="center">วันเกิดพนักงาน</td>
                    <td width="81" align="center">ค่าตำแหน่ง</td>
                    <td width="81" align="center">ค่าทักษะ</td>
                    <td width="93" align="center">ค่าซ่อมบำรุง</td>
                    <td width="93" align="center">ค่าเดินทาง</td>
                    <td width="93" align="center">ค่าโทรศัพท์</td>
                    <td width="93" align="center">โบนัส</td>
                    <td width="96" align="center">รวมเงินเดือน<br>
                      ที่พนักงานได้</td>
                    <td width="130" align="center">รายได้สะสม</td>
                    <td width="64" align="center">หักประกันสังคมสะสม</td>
                    <td width="64" align="center">หักภาษีบุคคลสะสม</td>
                  </tr>
                  <?
				  
				  
				  
				 // if($site!=''){
//					  $select0="select * from tbsalary where paycode='$paycode' and empno in (select empno from tbemployee where site='HQ'  and delstatus='0')  order by empno asc ";
//					  }else{
//						  
//						   $select0="select * from tbsalary where paycode='$paycode' ";
//					  
//					  }
	if($tsite!=''){
		$select0="select * from tbsalary where paycode='$paycode' and empno in (select empno from tbemployee where site='$tsite'  and delstatus='0' ) order by empno asc ";
		}else{
		$select0="select * from tbsalary where paycode='$paycode' and empno in (select empno from tbemployee where delstatus='0' ) order by empno asc ";
		}
	
                  	
//	echo $select0;
	$re0=mssql_query($select0);
	while($row0=mssql_fetch_array($re0)){
		
		$basic_salary = $row0['total_basic_salary'];
		
		$select="select att_reward,emptype,firstname,site,lastname,basic_salary,basic_wage from tbemployee where empno='".$row0['empno']."'";
				$re=mssql_query($select);
				$num=mssql_num_rows($re);
				if($num>0){
					$row=mssql_fetch_array($re);
					
					//$empname = $row['firstname']." ".$row['lastname'];
					$empname = iconv("tis-620", "utf-8", $row['firstname']." ".$row['lastname'] );
					$empsite = $row['site'];
					if($basic_salary==0 || $basic_salary==''){
					$basic_salary = $row['basic_salary'];
					}
					$basic_wage = $row['basic_wage'];
					$emptype = $row['emptype'];
					}
					
					$selectp="select ytd_income, ytd_tax, ytd_social_in from tbytdsummary where empno='".$row0['empno']."' and paycodeyear='".$row0['paycodeyear']."'  ";
			//	echo $selectp;
				$rep=mssql_query($selectp);
				$nump = mssql_num_rows($rep);
				$rowp=mssql_fetch_array($rep);
				
			
				  ?>
                  <tr>
                    <td><?=$row0['empno']?></td>
                    <td colspan="2"><?=$empname?></td>
                    <td><?=$empsite?></td>
                    <td align="right"><?
                    if($emptype=='employee'){
							echo  number_format($basic_salary, 2, '.', '');
						}else{
							//echo  number_format($basic_wage*$row0['total_day'], 2, '.', '');
							echo  number_format($row0['total_wage'], 2, '.', '');
							}
					?></td>
                    <td align="right">-<?
					echo number_format($row0['social_in'], 2, '.', '');
					?>
					</td>
                    <td align="right">-</td>
                    <td align="right">-<?
                   if($emptype=='employee'){
					echo number_format($row0['absent'], 2, '.', '');
					}else{
						echo 0;
						}
					
					?></td>
                    <td align="right">-<?
                   if($emptype=='employee'){
					echo number_format($row0['personal_leave'], 2, '.', '');
					}else{
						echo 0;
						}
					
					?></td>
                    <td align="right">-<?=number_format($row0['leave_without_pay'], 2, '.', '')?></td>
                    <td align="right">-<?=number_format($row0['other_deduct'], 2, '.', '')?></td>
                    <td align="right"><?=number_format($row0['total_ot'], 2, '.', '')?></td>
                    <td align="right"><?=number_format($row0['total_car_rice'], 2, '.', '')?></td>
                    <td align="right"><?=number_format($row0['total_shift_val'], 2, '.', '')?></td>
                    <td align="right"><?=number_format($row0['total_fl'], 2, '.', '')?></td>
                    <td align="right"><?=number_format($row0['att_reward'], 2, '.', '')?></td>
                    <td align="right"><?=number_format($row0['other'], 2, '.', '')?></td>
                    <td align="right"><?=number_format($row0['hbd'], 2, '.', '')?></td>
                    <td align="right"><?=number_format($row0['position_val'], 2, '.', '')?></td>
                     <td align="right"><?=number_format($row0['skill_reward'], 2, '.', '')?></td>
                    <td align="right">&nbsp;</td>
                    <td align="right">&nbsp;</td>
                    <td align="right">&nbsp;</td>
                    <td align="right"><?=number_format($row0['bonus'], 2, '.', '')?></td>
                    <td align="right"><?=number_format($row0['total_salary'], 2, '.', '')?></td>
                    <td align="right"><?=number_format($row0['ytd_income'], 2, '.', '')?></td>
                    <td align="right"><?=number_format($row0['ytd_social_in'], 2, '.', '')?></td>
                    <td align="right">&nbsp;</td>
                  </tr>
                  <?
	}
				  
				  ?>
                  
                   <?
				 // if($site!=''){
//					  $select0="select * from tbsalary where paycode='$paycode' and empno in (select empno from tbemployee where site='TSC'  and delstatus='0' ) order by empno asc ";
//					  }else{
//						  
//						   $select0="select * from tbsalary where 1=0";
//					  
//					  }
					  

				  
				  ?>
                </table>

<?
					
				
				
				
			
				
 
  }
  if($status=='employee'){
  
$strExcelFileName="employee.xls";
header("Content-Type: application/x-msexcel; name=\"$strExcelFileName\"");
header("Content-Disposition: inline; filename=\"$strExcelFileName\"");
header("Pragma:no-cache");

echo "<html xmlns:o='urn:schemas-microsoft-com:office:office'

xmlns:x='urn:schemas-microsoft-com:office:excel'

xmlns='http://www.w3.org/TR/REC-html40 '>";



$sql = "SELECT * FROM  tbemployee WHERE delstatus='0' order by site asc,empno asc";
$result = mssql_query($sql);

echo "<table border='1'>";
echo "<tr>";
$i = 0;
while ($i < mssql_num_fields($result))
{
    $meta = mssql_fetch_field($result, $i);  
    if($meta->name != "finger_data" 
    && $meta->name != "att_reward" 
    && $meta->name != "skill_reward" 
    && $meta->name != "basic_wage"  
    && $meta->name != "basic_salary"
    && $meta->name != "position_val"
    && $meta->name != "mte_val"
    && $meta->name != "travel_val"
    && $meta->name != "mobile_val"){
      echo "<th>".$meta->name."</th>";
    }
      $fields[] = $meta->name;
        $i++;
    
   
}


//foreach ($fields as $f) { echo "<br>Field name: ".$f; }

while ($row = mssql_fetch_row($result))
{
	
    echo '<tr>';
	$i=0;
    foreach($row as $item)
    {
      if($fields[$i]!='finger_data' 
      && $fields[$i] != "att_reward" 
      && $fields[$i] != "skill_reward" 
      && $fields[$i] != "basic_wage"  
      && $fields[$i] != "basic_salary"
      && $fields[$i] != "position_val"
      && $fields[$i] != "mte_val"
      && $fields[$i] != "travel_val"
      && $fields[$i] != "mobile_val"
      ){
          if($fields[$i]=='password'){
          echo "<td>*****</td>";
          }else if($fields[$i]=='mobile'){
            echo "<td x:str>".$item."</td>";
          }else if($fields[$i]=='positionid'){
            $sql_po = "SELECT * FROM tbposition WHERE positionid='$item'";
            $res_po = mssql_query($sql_po);
            $row_po = mssql_fetch_array($res_po);
            $positionname = $row_po["positionname"];
            echo "<td>".$positionname."</td>";
          }else{
					 echo "<td>".iconv("tis-620", "utf-8", $item )."</td>";
          }
      }
     $i++;  
    }

    echo '</tr>';
	
}

echo "</table>";
				
				?>
                
               
               
                

<?
					
				
				
				
			
				
 
  }
if($status=="it_service_list"){
	$mmonth = $_REQUEST['mmonth'];
	$yyear = $_REQUEST['yyear'];
    $strExcelFileName="it_service_list.xls";
    header("Content-Type: application/x-msexcel; name=\"$strExcelFileName\"");
    header("Content-Disposition: inline; filename=\"$strExcelFileName\"");
    header("Pragma:no-cache");
    
    echo "<html xmlns:o='urn:schemas-microsoft-com:office:office'
    
    xmlns:x='urn:schemas-microsoft-com:office:excel'
    
    xmlns='http://www.w3.org/TR/REC-html40 '>";

    $start_date = $_GET["start_date"];
    $end_date = $_GET["end_date"];

    $arr_start_date = explode("/",$start_date);
  	$start_date_sql = $arr_start_date[1]."/".$arr_start_date[0]."/".($arr_start_date[2]);
    $arr_end_date = explode("/",$end_date);
    $end_date_sql = $arr_end_date[1]."/".$arr_end_date[0]."/".($arr_end_date[2]);
    
    ?>
    <table x:str border='1'>
        <thead>
            <th>JOB ID</th>
            <th>CREATE DATE</th>
            <th>RESPONSE DATE</th>
            <th> STATUS</th>
            <th>TOPIC</th>
            <th>DETAIL</th>
            <th>TYPE</th>
            <th> NAME</th>
            <th>CLOSE DATE</th>
            <th>CLOSE MESSAGE</th>
        </thead>

    <?php
    $sql = "SELECT *,
      convert(varchar, create_date, 101)as create_date_date,
      convert(varchar, create_date, 108)as create_date_time,
      convert(varchar, solution_date, 101)as solution_date_date,
      convert(varchar, solution_date, 108)as solution_date_time
     FROM tbitservice_list WHERE create_date BETWEEN '$start_date_sql 00:00:01' AND '$end_date_sql 23:59:00'
     ORDER BY create_date asc";
    $res = mssql_query($sql);
    while($row = mssql_fetch_array($res)){
        $job_id = $row['job_id'];
        $empno = $row['empno'];
        $full_name = get_full_name($empno);
        $problem_type = $row['problem_type'];
        $job_status = $row['job_status'];
        $approve_status = $row['approve_status'];
        $problem_topic = lang_thai_from_database($row['problem_topic']);
        $problem_detail = lang_thai_from_database($row['problem_detail']);
        $create_date = $row['create_date_date']." ".$row['create_date_time'];
        $close_date  = $row['solution_date_date']." ".$row['solution_date_time'];
        $problem_solution = lang_thai_from_database($row["problem_solution"]);

        $select1="SELECT top 1 convert(varchar, create_date, 103)as res_create_date,
                            convert(varchar, create_date, 108)as res_create_time from  tbitservice_chat where job_id = '".$row['job_id']."' and job_status='In progress' order by id asc";
        $re1=mssql_query($select1);
        $num1=mssql_num_rows($re1);
        if($num1>0){
          $row1=mssql_fetch_array($re1);
          $res_date =  $row1['res_create_date']." ".$row1['res_create_time'];
        }
        ?>
        <tr>
            <td><?=$job_id?></td>
            <td><?=$create_date?></td>
            <td><?=$res_date?></td>
            <td><?=$job_status?></td>
            <td><?=$problem_topic?></td>
            <td><?=$problem_detail?></td>
            <td><?=$problem_type?></td>
            <td><?=$full_name?></td>
            <td><?=$close_date?></td>
            <td><?=$problem_solution?></td>
        </tr>
        <?
    }


    ?>
      </table>
       <table x:str border='1'>
        <thead>
        	<th>PROJECT NAME</th>
            <th>JOB ID</th>
            <th>TASK ID</th>
            <th>START DATE</th>
            <th>DUE DATE</th>
            <th> STATUS</th>
            <th>DETAIL</th>
            <th>NAME</th>
        </thead>
     <?php
    $sql = "SELECT *,
      convert(varchar, start_date, 101)as create_date_date,
      convert(varchar, due_date, 101)as solution_date_date 
     FROM tbitprogram_list WHERE 
	YEAR(start_date) = $yyear and MONTH(start_date) = $mmonth or (job_status in ('In progress','New'))
	 
     ORDER BY start_date asc";
    $res = mssql_query($sql);
    while($row = mssql_fetch_array($res)){
        $job_id = $row['job_id'];
		$develop_id = $row['develop_id'];
      //  $empno = $row['empno'];
     //   $full_name = get_full_name($empno);
     //   $problem_type = $row['problem_type'];
        $job_status = $row['job_status'];
   //     $approve_status = $row['approve_status'];
      //  $problem_topic = lang_thai_from_database($row['problem_topic']);
        $problem_detail = lang_thai_from_database($row['detail']);
        $create_date = $row['create_date_date'];
        $due_date  = $row['solution_date_date'];
        $problem_solution = lang_thai_from_database($row["problem_solution"]);
		$incharge = $row['incharge'];
		$project_name = $row['project_name'];

        
        ?>
        <tr>
        	 <td><?=$project_name?></td>
            <td><?=$job_id?></td>
            <td><?=$develop_id?></td>
            <td><?=$create_date?></td>
            <td><?=$due_date?></td>
            <td><?=$job_status?></td>
            <td><?=$problem_detail?></td>
            <td><?=$incharge?></td>
           
        </tr>
        <?
    }


    ?>
   </table>
    <?

}
  
  ?>
  
  

</body>
</html>
