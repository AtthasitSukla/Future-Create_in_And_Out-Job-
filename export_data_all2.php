<?php
include("connect.php"); 
include("library.php"); 
$date_time=date("m/d/Y H:i:s");
header('Content-Type: text/html; charset=utf-8');
require_once('PHPExcel-1.8/Classes/PHPExcel.php');
$cond = str_replace('\\' , '' , $_GET['data'] );
$leave_year = $_GET["leave_year"];
$objPHPExcel = new PHPExcel();
$sheet = $objPHPExcel->getActiveSheet();
$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
					 ->setLastModifiedBy("Maarten Balliauw")
					 ->setTitle("Office 2007 XLSX Test Document")
					 ->setSubject("Office 2007 XLSX Test Document")
					 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
					 ->setKeywords("office 2007 openxml php")
					 ->setCategory("Test result file");
					 
					 
$pageMargins = $sheet->getPageMargins();


//กำหนดความกว้างในแต่ละ Colum
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(7);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(18);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(18);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(18);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(18);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(18);
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(50);
$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(20);

//สร้าง Style เพื่อกำหนดฟอร์แมตของหัว Colum
$styleHeader = array(
		'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'ffff00')),
		'borders' => array('bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN)),
		'font'  => array('bold'  => true,'size'  => 9,'name'  => 'Arial')
		);
//กำหนดตัวหนา
$objPHPExcel->getActiveSheet()->getStyle('1:1')->getFont()->setBold(true);
//กำหนดสีพื้นหลัง header
$objPHPExcel->getActiveSheet()
			->getStyle('1:1')
			//->getStyle('A1:M1')
			->getFill()
			->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
			->getStartColor()
			->setARGB('00ff80');
//if($type == "material"){
	$rowCell=2;
	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A1', 'สำดับ')
				->setCellValue('B1', 'รหัสผนักงาน')
				->setCellValue('C1', 'ชื่อ - สกุล')
				->setCellValue('D1', 'ประเภทการลา')
				->setCellValue('E1', 'กะ')
				->setCellValue('F1', 'วันที่ทำรายการ')
				->setCellValue('G1', 'ช่วงวันหยุด(เริ่ม)')
				->setCellValue('H1', 'เวลาหยุด(เริ่ม)')
				->setCellValue('I1', 'ช่วงวันหยุด(สิ้นสุด)')
				->setCellValue('J1', 'เวลาหยุด(สิ้นสุด)')
				->setCellValue('K1', 'จำนวนวันที่หยุด')
				->setCellValue('L1', 'เหตุผลการลา')
				->setCellValue('M1', 'เอกสารแนบ')
				->setCellValue('N1', 'สถานะการอนุมัติ(หัวหน้า)')
				->setCellValue('O1', 'ผู้อนุมัติ')
                ->setCellValue('P1', 'สถานะฝ่ายบุคคล')
				 ->setCellValue('Q1', 'Site');
                
    $selectw="SELECT TOP(1) * from tbleave_work_custom where l_years >= '$leave_year' ";
    $rew=mssql_query($selectw);
    $roww=mssql_fetch_array($rew);
    $s_date = $roww['s_date'];
    $e_date = $roww['e_date'];

	//$sqlptn    = "SELECT *,tbleave_transaction.id as id,tbemployee.empno as empno FROM tbleave_transaction JOIN tbleavetype ON tbleave_transaction.leavetypeid = tbleavetype.leavetypeid JOIN tbemployee ON tbemployee.empno = tbleave_transaction.empno WHERE  $cond ORDER BY tbleave_transaction.id DESC";				
	$sqlptn    = "SELECT tbemployee.empno as empno,tbemployee.firstname as firstname,tbemployee.lastname as lastname,tbleavetype.leavename as leavename,tbleave_transaction.shift as shift, tbleave_transaction.createdate as createdate,tbleave_transaction.leavestartdate as leavestartdate, tbleave_transaction.leavestarttime as leavestarttime, tbleave_transaction.leaveenddate as leaveenddate,tbleave_transaction.leaveendtime as leaveendtime, tbleave_transaction.leavetotal as leavetotal,tbleave_transaction.reasons as reasons, tbleave_transaction.file_att as file_att,tbleave_transaction.statusapprove as statusapprove,tbleave_transaction.headapprove as headapprove,tbleave_transaction.hr as hr 
    FROM tbleave_transaction JOIN tbleavetype ON tbleave_transaction.leavetypeid = tbleavetype.leavetypeid 
    JOIN tbemployee ON tbemployee.empno = tbleave_transaction.empno 
    where tbleave_transaction.leavestartdate BETWEEN  '".$roww['s_date']."' AND '".$roww['e_date']."'
     ORDER BY tbleave_transaction.id DESC";				
	//echo $sqlptn ;
	//return false;
	$queryptn = mssql_query($sqlptn);
	$i = 1;
	while($row = mssql_fetch_assoc($queryptn)){
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A'.$rowCell, $i)
					->setCellValue('B'.$rowCell, $row['empno'])
					->setCellValue('C'.$rowCell, iconv("tis-620", "utf-8",$row['firstname'])." ".iconv("tis-620", "utf-8",$row['lastname']))
					->setCellValue('D'.$rowCell, iconv("tis-620", "utf-8",$row['leavename']))
					->setCellValue('E'.$rowCell, $row['shift'])
					->setCellValue('F'.$rowCell, f_date($row['createdate']))
					->setCellValue('G'.$rowCell, f_date($row['leavestartdate']))
					->setCellValue('H'.$rowCell, ($row['leavestarttime'] == '0'? "เต็มวัน":"ครึ่งวัน"))
					->setCellValue('I'.$rowCell, f_date($row['leaveenddate']))
					->setCellValue('J'.$rowCell, ($row['leaveendtime'] == '0'? "เต็มวัน":"ครึ่งวัน"))
					->setCellValue('K'.$rowCell, $row['leavetotal'])
					->setCellValue('L'.$rowCell, iconv("tis-620", "utf-8",$row['reasons']))
					->setCellValue('M'.$rowCell, ($row['file_att'] == '0'? "ไม่มี":"มี"))
					->setCellValue('N'.$rowCell, $row['statusapprove'])
					->setCellValue('O'.$rowCell, iconv("tis-620", "utf-8",$row['headapprove']))
					->setCellValue('P'.$rowCell, $row['hr'])
					->setCellValue('Q'.$rowCell, get_site_name($row['empno']));
					
		$rowCell++; 
		$i++;		
	}
	
	//First sheet
   // $sheet = $objPHPExcel->getActiveSheet();

    //Start adding next sheets
    //$i=1;
   // while ($i < 10) {

      // Add new sheet
    //  $objWorkSheet = $objPHPExcel->createSheet($i); //Setting index when creating

      //Write cells
     // $objWorkSheet->setCellValue('A1', 'Hello'.$i)
                //   ->setCellValue('B2', 'world!')
                 //  ->setCellValue('C1', 'Hello')
                 //  ->setCellValue('D2', 'world!');

      // Rename sheet
     // $objWorkSheet->setTitle("$i");

    //  $i++;
    ///}
	
	
	
	// Rename worksheet
	

	$objPHPExcel->setActiveSheetIndex(0);
	
	
	 $objWorkSheet = $objPHPExcel->createSheet(1);
	 
	  $objWorkSheet->getStyle('A1:V1')
	->getFill()
	->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
	->getStartColor()
	->setRGB('cccccc');
	 $objWorkSheet->setCellValue('A1', 'รหัสพนักงาน')
	 				->setCellValue('B1', 'ชื่อ')
	 				->setCellValue('C1', 'Site')
					
					->setCellValue('D1', 'ลาป่วย')
                   ->setCellValue('G1', 'ลากิจ')
                   ->setCellValue('J1', 'ลาพักร้อน')
                   ->setCellValue('M1', 'ลาบวช')
				   ->setCellValue('P1', 'ลาคลอด')
				   ->setCellValue('S1', 'ขาดงาน')
				    ->setCellValue('T1', 'ไม่ได้ลงเวลาเข้า')
					 ->setCellValue('U1', 'ไม่ได้ลงเวลาออก')
					  ->setCellValue('V1', 'ไม่ได้ลงเวลาเข้า + ออก')
					  ->setCellValue('W1', 'ทำงานนอกสถานที่')
					  ->setCellValue('X1', 'มาสาย');
					  
	$objWorkSheet->mergeCells('D1:F1');
	$objWorkSheet->mergeCells('G1:I1');
	$objWorkSheet->mergeCells('J1:L1');
	$objWorkSheet->mergeCells('M1:O1');
	$objWorkSheet->mergeCells('P1:R1');
	
	$objWorkSheet->setCellValue('A2', '')
	->setCellValue('B2', '')
	->setCellValue('C2', '')
					
					
					->setCellValue('D2', 'ลาได้ทั้งหมด')
                   ->setCellValue('E2', 'ใช้ไปแล้ว')
                   ->setCellValue('F2', 'คงเหลือ')
                  ->setCellValue('G2', 'ลาได้ทั้งหมด')
                   ->setCellValue('H2', 'ใช้ไปแล้ว')
                   ->setCellValue('I2', 'คงเหลือ')
				   ->setCellValue('J2', 'ลาได้ทั้งหมด')
                   ->setCellValue('K2', 'ใช้ไปแล้ว')
                   ->setCellValue('L2', 'คงเหลือ')
				   ->setCellValue('M2', 'ลาได้ทั้งหมด')
                   ->setCellValue('N2', 'ใช้ไปแล้ว')
                   ->setCellValue('O2', 'คงเหลือ')
				   ->setCellValue('P2', 'ลาได้ทั้งหมด')
                   ->setCellValue('Q2', 'ใช้ไปแล้ว')
                   ->setCellValue('R2', 'คงเหลือ')
				     ->setCellValue('S2', 'จำนวนวัน')
					->setCellValue('T2', 'จำนวนวัน')
					->setCellValue('U2', 'จำนวนวัน')
					->setCellValue('V2', 'จำนวนวัน')
					->setCellValue('W2', 'จำนวนวัน')
					->setCellValue('X2', 'จำนวนวัน');
					
		$rowCell=3;	
		// emp_control='".$_SESSION['admin_userid']."' and
		$selectx = "SELECT empno,site,emp_level from tbemployee where delstatus=0 order by empno";
	  // echo $selectx;
                                            $rex = mssql_query($selectx);
											$numx = mssql_num_rows($rex);
											if($numx>0){
                                            while($rowx = mssql_fetch_array($rex)){
												
												
					
					/// calc anual leave days
					
    $select="SELECT emp.firstname as firstname, emp.lastname as lastname, emp.emp_level as emp_level ,emp.startdate as startdate,pos.positionname as positionname  
    from tbemployee emp JOIN tbposition pos ON emp.positionid = pos.positionid
     where emp.empno = '".$rowx['empno']."' ";
	$re=mssql_query($select);
	$row=mssql_fetch_array($re);
	$name = iconv("tis-620", "utf-8", $row['firstname'])."  ".iconv("tis-620", "utf-8", $row['lastname']);
	$position = $row['positionname'];
	$csite = $rowx['site'];	
	$emp_level =$rowx['emp_level'];
	$startdate = $row['startdate'];	
	$emp_level = $row['emp_level'];	
	$count = (strtotime(date("Y-m-d")) - strtotime($startdate))/( 60 * 60 * 24 );
	$total_annual = 0; //พักร้อน
	$total_ordain = 0; //ลาบวช
	if($count >= 365){
		$total_ordain = 15;
	}
	if($count >= 365 && $count < 730){
		$total_annual = 6.00;
	}else if($count >= 730 && $count < 1095){
		$total_annual = 7.00;
	}else if($count >= 1095 && $count < 1460){
		$total_annual = 8.00;
	}else if($count >= 1460 && $count < 1825){
		$total_annual = 9.00;
	}else if($count >= 1825){
		$total_annual = 10.00;
	}
	if($total_annual == 0){
		$dataL0003 = array(0,0,0);
	}else{
		$now_date = date("Y-m-d");
		//echo $now_date;
		//where date เข้าไป
		$selectw="select TOP(1) * from tbleave_work_custom where l_years >= '$leave_year' ";
		$rew=mssql_query($selectw);
		$roww=mssql_fetch_array($rew);
	//	$e_date = date("d/m/Y", strtotime($row['e_date']));
		//echo $row['s_date'].'-----'.$row['e_date'];
		$select="select SUM(leavetotal) as total from tbleave_transaction where leavetypeid = 'L0003' AND empno = '".$rowx['empno']."' AND (statusapprove = 'Approve') AND (leavestartdate BETWEEN  '".$roww['s_date']."' AND '".$roww['e_date']."')";
		//echo $select;
		$re=mssql_query($select);
		$row=mssql_fetch_array($re);
		$dataL0003 = array(number_format($total_annual, 2, '.', ''),number_format($total_annual - $row['total'], 2, '.', ''),$row['total']);
	}
	
					/// calc anual leave days	
					
					/// get sick leave		
		$select="select SUM(leavetotal) as total from tbleave_transaction where leavetypeid = 'L0001' AND empno = '".$rowx['empno']."' AND (statusapprove = 'Approve') AND (leavestartdate BETWEEN  '".$roww['s_date']."' AND '".$roww['e_date']."')";
		//echo $select;
		$re=mssql_query($select);
		$row=mssql_fetch_array($re);
		$dataL0001 = array(number_format(30, 2, '.', ''),number_format(30 - $row['total'], 2, '.', ''),$row['total']);
					/// get sick leave	
					/// get personal leave		
		$select="select SUM(leavetotal) as total from tbleave_transaction where leavetypeid = 'L0002' AND empno = '".$rowx['empno']."' AND (statusapprove = 'Approve') AND (leavestartdate BETWEEN  '".$roww['s_date']."' AND '".$roww['e_date']."')";
		//echo $select;
		$re=mssql_query($select);
		$row=mssql_fetch_array($re);
		$dataL0002 = array(number_format(30, 2, '.', ''),number_format(30 - $row['total'], 2, '.', ''),$row['total']);
				  /// get personal leave	
				  
				  /// get ordination leave		
		$select="select SUM(leavetotal) as total from tbleave_transaction where leavetypeid = 'L0004' AND empno = '".$rowx['empno']."' AND (statusapprove = 'Approve') AND (leavestartdate BETWEEN  '".$roww['s_date']."' AND '".$roww['e_date']."')";
		//echo $select;
		$re=mssql_query($select);
		$row=mssql_fetch_array($re);
		$dataL0004 = array(number_format($total_ordain, 2, '.', ''),number_format($total_ordain - $row['total'], 2, '.', ''),$row['total']);
				  /// get ordination leave	
				  
				    /// get Maternity leave		
		$select="select SUM(leavetotal) as total from tbleave_transaction where leavetypeid = 'L0005' AND empno = '".$rowx['empno']."' AND (statusapprove = 'Approve') AND (leavestartdate BETWEEN  '".$roww['s_date']."' AND '".$roww['e_date']."')";
		//echo $select;
		$re=mssql_query($select);
		$row=mssql_fetch_array($re);
		$dataL0005 = array(number_format(90, 2, '.', ''),number_format(90 - $row['total'], 2, '.', ''),$row['total']);
				  /// get Maternity leave	
				  
				      /// get absent leave		
		$select="select SUM(leavetotal) as total from tbleave_transaction where leavetypeid = 'L0006' AND empno = '".$rowx['empno']."' AND (statusapprove = 'Approve') AND (leavestartdate BETWEEN  '".$roww['s_date']."' AND '".$roww['e_date']."')";
		//echo $select;
		$re=mssql_query($select);
		$row=mssql_fetch_array($re);
		$dataL0006 = $row['total'];
				  /// get absent leave	
				  
		$dataL0007 = 0;
		$dataL0008 = 0;
		$dataL0009 = 0;
		$dataL0010 = 0;		  
		$select="select SUM(leavetotal) as total from tbleave_transaction where leavetypeid = 'L0007' AND empno = '".$rowx['empno']."' AND (statusapprove = 'Approve') AND (leavestartdate BETWEEN  '".$roww['s_date']."' AND '".$roww['e_date']."')";
		//echo $select;
		$re=mssql_query($select);
		$row=mssql_fetch_array($re);
		$dataL0007 = $row['total'];
		$select="select SUM(leavetotal) as total from tbleave_transaction where leavetypeid = 'L0008' AND empno = '".$rowx['empno']."' AND (statusapprove = 'Approve') AND (leavestartdate BETWEEN  '".$roww['s_date']."' AND '".$roww['e_date']."')";
		//echo $select;
		$re=mssql_query($select);
		$row=mssql_fetch_array($re);
		$dataL0008 = $row['total'];
		$select="select SUM(leavetotal) as total from tbleave_transaction where leavetypeid = 'L0009' AND empno = '".$rowx['empno']."' AND (statusapprove = 'Approve') AND (leavestartdate BETWEEN  '".$roww['s_date']."' AND '".$roww['e_date']."')";
		//echo $select;
		$re=mssql_query($select);
		$row=mssql_fetch_array($re);
		$dataL0009 = $row['total'];
		$select="select SUM(leavetotal) as total from tbleave_transaction where leavetypeid = 'L0010' AND empno = '".$rowx['empno']."' AND (statusapprove = 'Approve') AND (leavestartdate BETWEEN  '".$roww['s_date']."' AND '".$roww['e_date']."')";
		//echo $select;
		$re=mssql_query($select);
		$row=mssql_fetch_array($re);
		$dataL0010 = $row['total'];
		
		
		
	$total_late= 0;
	 $total_late_day =0;
	 $total_late_night=0;	
		if((int)$emp_level < 3){
			
	////////// LATE FOR OPERATION
	
	//"select *  
//FROM            tbatt
//WHERE        (empno = '56001') and paycode in (SELECT paycode from tbpaycode WHERE paycodeyear='2019') 
//and att_status = 'in' and cast(attDateTime as time)>'08:00:00' and 
//cast(attdatetime as date) not in(select leavestartdate from tbleave_transaction where empno='56001')
// order by attdatetime asc";
 
 		//paycode in (SELECT paycode from tbpaycode WHERE paycodeyear='$leave_year') 
		
		$select_latey = "select count(empno) as total_late from tbatt_approve where 
		cast(iattDateTime1 as date) between '".$roww['s_date']."' and '".$roww['e_date']."'	
		
		
		and ishift='Day' and cast(iattDateTime1 as time)>'08:00:00' and status_approve=1
			and empno='" . $rowx['empno'] . "'  and cast(iattDateTime1 as date) not in(select leavestartdate from tbleave_transaction where empno='" . $rowx['empno'] . "')
			";
																															$re_latey = mssql_query($select_latey);
																															$num_latey = mssql_num_rows($re_latey);
				if ($num_latey > 0) {
																																$row_latey = mssql_fetch_array($re_latey);
																																$total_late_day =  $row_latey['total_late'];
					}
				//paycode in (SELECT paycode from tbpaycode WHERE paycodeyear='$leave_year')
																															$select_latey = "select count(empno) as total_late from tbatt_approve where
																															
		cast(iattDateTime1 as date) between '".$roww['s_date']."' and '".$roww['e_date']."'																													 
		
		
		 and ishift='Night' and cast(iattDateTime1 as time)>'20:20:00' and status_approve=1
			and empno='" . $rowx['empno'] . "'  and cast(iattDateTime1 as date) not in(select leavestartdate from tbleave_transaction where empno='" . $rowx['empno'] . "')
			";
																															$re_latey = mssql_query($select_latey);
																															$num_latey = mssql_num_rows($re_latey);
			if ($num_latey > 0) {
																																$row_latey = mssql_fetch_array($re_latey);
																																$total_late_night =  $row_latey['total_late'];
				}
	 $total_late = $total_late_day + $total_late_night;
	 ////////// LATE FOR OPERATION
		
		
		}else{
			
			
	////////// LATE FOR MANGEMENT
			$select_latey ="select count(empno) as total_late  
FROM            tbatt 
WHERE     shift='Day' and   (empno = '".$rowx['empno']."') and cast(attdatetime as date) between '".$roww['s_date']."' and '".$roww['e_date']."'
and att_status = 'in' and cast(attDateTime as time)>'08:00:00' and 
cast(attdatetime as date) not in(select leavestartdate from tbleave_transaction where empno='".$rowx['empno']."')
 ";
 $re_latey = mssql_query($select_latey);
																															$num_latey = mssql_num_rows($re_latey);
	if ($num_latey > 0) {
																																$row_latey = mssql_fetch_array($re_latey);
				$total_late_day =  $row_latey['total_late'];	
	}
	
	
																																
				
				
				$select_latey ="select count(empno) as total_late  
			FROM            tbatt 
			WHERE     shift='Night' and   (empno = '".$rowx['empno']."') and cast(attdatetime as date) between '".$roww['s_date']."' and '".$roww['e_date']."'
			and att_status = 'in' and cast(attDateTime as time)>'20:20:00' and 
			cast(attdatetime as date) not in(select leavestartdate from tbleave_transaction where empno='".$rowx['empno']."')
			 ";
			 $re_latey = mssql_query($select_latey);
																																		$num_latey = mssql_num_rows($re_latey);
																																		if ($num_latey > 0) {
																																			$row_latey = mssql_fetch_array($re_latey);
																																			$total_late_night =  $row_latey['total_late'];

																																		}
																																		$total_late = $total_late_day + $total_late_night;
			
			////////// LATE FOR MANGEMENT
			
																															
																															
			}
			
			
			
		
		
		
	
										
										
												
												
												
		$objWorkSheet->setCellValue('A'.$rowCell, $rowx['empno'])
					->setCellValue('B'.$rowCell, get_full_name($rowx['empno']))
					->setCellValue('C'.$rowCell, $csite)
					->setCellValue('D'.$rowCell, $dataL0001[0])
                   ->setCellValue('E'.$rowCell, $dataL0001[2])
                   ->setCellValue('F'.$rowCell, $dataL0001[1])
                   ->setCellValue('G'.$rowCell, $dataL0002[0])
                   ->setCellValue('H'.$rowCell, $dataL0002[2])
                   ->setCellValue('I'.$rowCell, $dataL0002[1])
				   ->setCellValue('J'.$rowCell, $dataL0003[0])
                   ->setCellValue('K'.$rowCell, $dataL0003[2])
                   ->setCellValue('L'.$rowCell, $dataL0003[1])
				   ->setCellValue('M'.$rowCell, $dataL0004[0])
                   ->setCellValue('N'.$rowCell, $dataL0004[2])
                   ->setCellValue('O'.$rowCell, $dataL0004[1])
				   ->setCellValue('P'.$rowCell, $dataL0005[0])
                   ->setCellValue('Q'.$rowCell, $dataL0005[2])
                   ->setCellValue('R'.$rowCell, $dataL0005[1])
				    ->setCellValue('S'.$rowCell, $dataL0006)
					->setCellValue('T'.$rowCell, $dataL0007)
					->setCellValue('U'.$rowCell, $dataL0008)
					->setCellValue('V'.$rowCell, $dataL0009)
					->setCellValue('W'.$rowCell, $dataL0010)
					->setCellValue('X'.$rowCell, $total_late);
												
												$rowCell++;
												}
												}
				
	$objPHPExcel->getActiveSheet()->setTitle('Leave Summary');
	
	
	 $objWorkSheet = $objPHPExcel->createSheet(2);
	  $objWorkSheet->getStyle('A1:V1')
	->getFill()
	->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
	->getStartColor()
	->setRGB('cccccc');
			
			 $objWorkSheet->setCellValue('A1', 'รหัสพนักงาน')
	 				->setCellValue('B1', 'ชื่อ')
	 				->setCellValue('C1', 'Site')
					->setCellValue('D1', 'ลงเวลาเข้า')
					->setCellValue('E1', 'ลงเวลาออก')
                   ->setCellValue('F1', 'Shift');
	
	   $rowCell=2;	
		$selectx = "SELECT empno,site,emp_level from tbemployee where delstatus=0 and emp_level >2 order by empno";
	  
                                            $rex = mssql_query($selectx);
											$numx = mssql_num_rows($rex);
		if($numx>0){
        while($rowx = mssql_fetch_array($rex)){
												
			$select_latey ="select 
			CONVERT(varchar, attDateTime, 101) as attDateTimedate,
			CONVERT(varchar, attDateTime, 108) as attDateTimetime,
			* 
FROM            tbatt
WHERE     shift='Day' and   (empno = '".$rowx['empno']."') and cast(attDateTime as date) between '".$roww['s_date']."' and '".$roww['e_date']."'
and att_status = 'in' and cast(attDateTime as time)>'08:00:00' and 
cast(attDateTime as date) not in(select leavestartdate from tbleave_transaction where empno='".$rowx['empno']."')
 ";
		 $re_latey = mssql_query($select_latey);
		 $num_latey = mssql_num_rows($re_latey);
				if ($num_latey > 0) {
					while($row_latey = mssql_fetch_array($re_latey)){
						
						$select_out ="select 
			CONVERT(varchar, attDateTime, 101) as attDateTimedate,
			CONVERT(varchar, attDateTime, 108) as attDateTimetime,
			* 
FROM            tbatt
WHERE      (empno = '".$rowx['empno']."') and att_real_date='".$row_latey['attDateTimedate']."' and att_status = 'out' 
 ";
 						 $re_out = mssql_query($select_out);
						 $row_out = mssql_fetch_array($re_out);
						
							 $objWorkSheet->setCellValue('A'.$rowCell, $rowx['empno'])
								->setCellValue('B'.$rowCell, get_full_name($rowx['empno']))
								->setCellValue('C'.$rowCell, $rowx['site'])
								->setCellValue('D'.$rowCell, $row_latey['attDateTimedate']." ".$row_latey['attDateTimetime'])
								->setCellValue('E'.$rowCell, $row_out['attDateTimedate']." ".$row_out['attDateTimetime'])
							   ->setCellValue('F'.$rowCell, $row_latey['shift']);
						$rowCell++;
						}
					
				}
				
				$select_latey ="select * 
FROM            tbatt
WHERE     shift='Night' and   (empno = '".$rowx['empno']."') and cast(attDateTime as date) between '".$roww['s_date']."' and '".$roww['e_date']."'
and att_status = 'in' and cast(attDateTime as time)>'20:20:00' and 
cast(attDateTime as date) not in(select leavestartdate from tbleave_transaction where empno='".$rowx['empno']."')
 ";
		 $re_latey = mssql_query($select_latey);
		 $num_latey = mssql_num_rows($re_latey);
				if ($num_latey > 0) {
					while($row_latey = mssql_fetch_array($re_latey)){
						
						
						$select_out ="select 
			CONVERT(varchar, attDateTime, 101) as attDateTimedate,
			CONVERT(varchar, attDateTime, 108) as attDateTimetime,
			* 
FROM            tbatt
WHERE      (empno = '".$rowx['empno']."') and att_real_date='".$row_latey['attDateTimedate']."' and att_status = 'out' 
 ";
 						 $re_out = mssql_query($select_out);
						 $row_out = mssql_fetch_array($re_out);
						
							 $objWorkSheet->setCellValue('A'.$rowCell, $rowx['empno'])
								->setCellValue('B'.$rowCell, get_full_name($rowx['empno']))
								->setCellValue('C'.$rowCell, $rowx['site'])
								->setCellValue('D'.$rowCell, $row_latey['attDateTimedate']." ".$row_latey['attDateTimetime'])
								->setCellValue('E'.$rowCell, $row_latey['attDateTimedate']." ".$row_latey['attDateTimetime'])
							   ->setCellValue('F'.$rowCell, $row_latey['shift']);
						$rowCell++;
						}
					
				}
											
			}
	}
	$objWorkSheet->setTitle("Late Transaction Management");
	
	
	// Save Excel 2007 file
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel,  'Excel2007');
	ob_end_clean();
	header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment; filename=leave'.date('d_m_Y').'.xlsx');
	header('Cache-Control:max-age=0');
	$objWriter->save('php://output');
	exit();
	
	
function f_date($f_date){
	return  date("d/m/Y", strtotime($f_date));
}
?>