<?php
include("connect.php"); 
include("library.php"); 
$date_time=date("m/d/Y H:i:s");
header('Content-Type: text/html; charset=utf-8');
require_once('PHPExcel-1.8/Classes/PHPExcel.php');
$cond = str_replace('\\' , '' , $_GET['data'] );
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
				->setCellValue('P1', 'สถานะฝ่ายบุคคล');
	
	//$sqlptn    = "SELECT *,tbleave_transaction.id as id,tbemployee.empno as empno FROM tbleave_transaction JOIN tbleavetype ON tbleave_transaction.leavetypeid = tbleavetype.leavetypeid JOIN tbemployee ON tbemployee.empno = tbleave_transaction.empno WHERE  $cond ORDER BY tbleave_transaction.id DESC";				
	$sqlptn    = "SELECT tbemployee.empno as empno,tbemployee.firstname as firstname,tbemployee.lastname as lastname,tbleavetype.leavename as leavename,tbleave_transaction.shift as shift, tbleave_transaction.createdate as createdate,tbleave_transaction.leavestartdate as leavestartdate, tbleave_transaction.leavestarttime as leavestarttime, tbleave_transaction.leaveenddate as leaveenddate,";
	$sqlptn    .= "tbleave_transaction.leaveendtime as leaveendtime, tbleave_transaction.leavetotal as leavetotal,tbleave_transaction.reasons as reasons, tbleave_transaction.file_att as file_att,tbleave_transaction.statusapprove as statusapprove,tbleave_transaction.headapprove as headapprove,tbleave_transaction.hr as hr FROM tbleave_transaction JOIN tbleavetype ON tbleave_transaction.leavetypeid = tbleavetype.leavetypeid JOIN tbemployee ON tbemployee.empno = tbleave_transaction.empno WHERE  $cond ORDER BY tbleave_transaction.id DESC";				
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
					->setCellValue('P'.$rowCell, $row['hr']);
					
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
	$objPHPExcel->getActiveSheet()->setTitle('Leave Transaction');

	$objPHPExcel->setActiveSheetIndex(0);
	
	
	 $objWorkSheet = $objPHPExcel->createSheet(1);
	  $objWorkSheet->getStyle('A1:W1')
	->getFill()
	->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
	->getStartColor()
	->setRGB('cccccc');
	 $objWorkSheet->setCellValue('A1', 'รหัสพนักงาน')
	 				->setCellValue('B1', 'ชื่อ')
	 				->setCellValue('C1', 'ลาป่วย')
                   ->setCellValue('F1', 'ลากิจ')
                   ->setCellValue('I1', 'ลาพักร้อน')
                   ->setCellValue('L1', 'ลาบวช')
				   ->setCellValue('O1', 'ลาคลอด')
				   ->setCellValue('R1', 'ขาดงาน')
				    ->setCellValue('S1', 'ไม่ได้ลงเวลาเข้า')
					 ->setCellValue('T1', 'ไม่ได้ลงเวลาออก')
					  ->setCellValue('U1', 'ไม่ได้ลงเวลาเข้า + ออก')
					  ->setCellValue('V1', 'ทำงานนอกสถานที่')
					    ->setCellValue('W1', 'ลาไม่ได้รับเงินเดือน');
					  
	$objWorkSheet->mergeCells('C1:E1');
	$objWorkSheet->mergeCells('F1:H1');
	$objWorkSheet->mergeCells('I1:K1');
	$objWorkSheet->mergeCells('L1:N1');
	$objWorkSheet->mergeCells('O1:Q1');
	
	$objWorkSheet->setCellValue('A2', '')
	->setCellValue('B2', '')
	->setCellValue('C2', 'ลาได้ทั้งหมด')
                   ->setCellValue('D2', 'ใช้ไปแล้ว')
                   ->setCellValue('E2', 'คงเหลือ')
                  ->setCellValue('F2', 'ลาได้ทั้งหมด')
                   ->setCellValue('G2', 'ใช้ไปแล้ว')
                   ->setCellValue('H2', 'คงเหลือ')
				   ->setCellValue('I2', 'ลาได้ทั้งหมด')
                   ->setCellValue('J2', 'ใช้ไปแล้ว')
                   ->setCellValue('K2', 'คงเหลือ')
				   ->setCellValue('L2', 'ลาได้ทั้งหมด')
                   ->setCellValue('M2', 'ใช้ไปแล้ว')
                   ->setCellValue('N2', 'คงเหลือ')
				   ->setCellValue('O2', 'ลาได้ทั้งหมด')
                   ->setCellValue('P2', 'ใช้ไปแล้ว')
                   ->setCellValue('Q2', 'คงเหลือ')
				     ->setCellValue('R2', 'จำนวนวัน')
					->setCellValue('S2', 'จำนวนวัน')
					->setCellValue('T2', 'จำนวนวัน')
					->setCellValue('U2', 'จำนวนวัน')
					->setCellValue('V2', 'จำนวนวัน')
					->setCellValue('W2', 'จำนวนวัน');
					
		$rowCell=3;	
		// emp_control='".$_SESSION['admin_userid']."' and
		$selectx = "select distinct emp_under from tbleave_control where emp_control='".$_SESSION['admin_userid']."' and emp_under in(select empno from tbemployee where delstatus=0)";
	  // echo $selectx;
                                            $rex = mssql_query($selectx);
											$numx = mssql_num_rows($rex);
											if($numx>0){
                                            while($rowx = mssql_fetch_array($rex)){
					
					/// calc anual leave days
					
	$select="select emp.firstname as firstname, emp.lastname as lastname, emp.emp_level as emp_level ,emp.startdate as startdate,pos.positionname as positionname  from tbemployee emp JOIN tbposition pos ON emp.positionid = pos.positionid where emp.empno = '".$rowx['emp_under']."' ";
	$re=mssql_query($select);
	$row=mssql_fetch_array($re);
	$name = iconv("tis-620", "utf-8", $row['firstname'])."  ".iconv("tis-620", "utf-8", $row['lastname']);
	$position = $row['positionname'];	
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
		$selectw="select TOP(1) * from tbleave_work where e_date >= '$now_date' ";
		$rew=mssql_query($selectw);
		$roww=mssql_fetch_array($rew);
	//	$e_date = date("d/m/Y", strtotime($row['e_date']));
		//echo $row['s_date'].'-----'.$row['e_date'];
		$select="select SUM(leavetotal) as total from tbleave_transaction where leavetypeid = 'L0003' AND empno = '".$rowx['emp_under']."' AND (statusapprove = 'Approve') AND (leavestartdate BETWEEN  '".$roww['s_date']."' AND '".$roww['e_date']."')";
		//echo $select;
		$re=mssql_query($select);
		$row=mssql_fetch_array($re);
		$dataL0003 = array(number_format($total_annual, 2, '.', ''),number_format($total_annual - $row['total'], 2, '.', ''),$row['total']);
	}
	
					/// calc anual leave days	
					
					/// get sick leave		
		$select="select SUM(leavetotal) as total from tbleave_transaction where leavetypeid = 'L0001' AND empno = '".$rowx['emp_under']."' AND (statusapprove = 'Approve') AND (leavestartdate BETWEEN  '".$roww['s_date']."' AND '".$roww['e_date']."')";
		//echo $select;
		$re=mssql_query($select);
		$row=mssql_fetch_array($re);
		$dataL0001 = array(number_format(30, 2, '.', ''),number_format(30 - $row['total'], 2, '.', ''),$row['total']);
					/// get sick leave	
					/// get personal leave		
		$select="select SUM(leavetotal) as total from tbleave_transaction where leavetypeid = 'L0002' AND empno = '".$rowx['emp_under']."' AND (statusapprove = 'Approve') AND (leavestartdate BETWEEN  '".$roww['s_date']."' AND '".$roww['e_date']."')";
		//echo $select;
		$re=mssql_query($select);
		$row=mssql_fetch_array($re);
		$dataL0002 = array(number_format(30, 2, '.', ''),number_format(30 - $row['total'], 2, '.', ''),$row['total']);
				  /// get personal leave	
				  
				  /// get ordination leave		
		$select="select SUM(leavetotal) as total from tbleave_transaction where leavetypeid = 'L0004' AND empno = '".$rowx['emp_under']."' AND (statusapprove = 'Approve') AND (leavestartdate BETWEEN  '".$roww['s_date']."' AND '".$roww['e_date']."')";
		//echo $select;
		$re=mssql_query($select);
		$row=mssql_fetch_array($re);
		$dataL0004 = array(number_format($total_ordain, 2, '.', ''),number_format($total_ordain - $row['total'], 2, '.', ''),$row['total']);
				  /// get ordination leave	
				  
				    /// get Maternity leave		
		$select="select SUM(leavetotal) as total from tbleave_transaction where leavetypeid = 'L0005' AND empno = '".$rowx['emp_under']."' AND (statusapprove = 'Approve') AND (leavestartdate BETWEEN  '".$roww['s_date']."' AND '".$roww['e_date']."')";
		//echo $select;
		$re=mssql_query($select);
		$row=mssql_fetch_array($re);
		$dataL0005 = array(number_format(90, 2, '.', ''),number_format(90 - $row['total'], 2, '.', ''),$row['total']);
				  /// get Maternity leave	
				  
				      /// get absent leave		
		$select="select SUM(leavetotal) as total from tbleave_transaction where leavetypeid = 'L0006' AND empno = '".$rowx['emp_under']."' AND (statusapprove = 'Approve') AND (leavestartdate BETWEEN  '".$roww['s_date']."' AND '".$roww['e_date']."')";
		//echo $select;
		$re=mssql_query($select);
		$row=mssql_fetch_array($re);
		$dataL0006 = $row['total'];
				  /// get absent leave	
				  
		$dataL0007 = 0;
		$dataL0008 = 0;
		$dataL0009 = 0;
		$dataL0010 = 0;		  
		$select="select SUM(leavetotal) as total from tbleave_transaction where leavetypeid = 'L0007' AND empno = '".$rowx['emp_under']."' AND (statusapprove = 'Approve') AND (leavestartdate BETWEEN  '".$roww['s_date']."' AND '".$roww['e_date']."')";
		//echo $select;
		$re=mssql_query($select);
		$row=mssql_fetch_array($re);
		$dataL0007 = $row['total'];
		$select="select SUM(leavetotal) as total from tbleave_transaction where leavetypeid = 'L0008' AND empno = '".$rowx['emp_under']."' AND (statusapprove = 'Approve') AND (leavestartdate BETWEEN  '".$roww['s_date']."' AND '".$roww['e_date']."')";
		//echo $select;
		$re=mssql_query($select);
		$row=mssql_fetch_array($re);
		$dataL0008 = $row['total'];
		$select="select SUM(leavetotal) as total from tbleave_transaction where leavetypeid = 'L0009' AND empno = '".$rowx['emp_under']."' AND (statusapprove = 'Approve') AND (leavestartdate BETWEEN  '".$roww['s_date']."' AND '".$roww['e_date']."')";
		//echo $select;
		$re=mssql_query($select);
		$row=mssql_fetch_array($re);
		$dataL0009 = $row['total'];
		$select="select SUM(leavetotal) as total from tbleave_transaction where leavetypeid = 'L0010' AND empno = '".$rowx['emp_under']."' AND (statusapprove = 'Approve') AND (leavestartdate BETWEEN  '".$roww['s_date']."' AND '".$roww['e_date']."')";
		//echo $select;
		$re=mssql_query($select);
		$row=mssql_fetch_array($re);
		$dataL0010 = $row['total'];
		
		$select="select SUM(leavetotal) as total from tbleave_transaction where leavetypeid = 'L0011' AND empno = '".$rowx['emp_under']."' AND (statusapprove = 'Approve') AND (leavestartdate BETWEEN  '".$roww['s_date']."' AND '".$roww['e_date']."')";
		//echo $select;
		$re=mssql_query($select);
		$row=mssql_fetch_array($re);
		$dataL0011 = $row['total'];
				
				
										
												
												
												
												
		$objWorkSheet->setCellValue('A'.$rowCell, $rowx['emp_under'])
					->setCellValue('B'.$rowCell, get_full_name($rowx['emp_under']))
					->setCellValue('C'.$rowCell, $dataL0001[0])
                   ->setCellValue('D'.$rowCell, $dataL0001[2])
                   ->setCellValue('E'.$rowCell, $dataL0001[1])
                   ->setCellValue('F'.$rowCell, $dataL0002[0])
                   ->setCellValue('G'.$rowCell, $dataL0002[2])
                   ->setCellValue('H'.$rowCell, $dataL0002[1])
				   ->setCellValue('I'.$rowCell, $dataL0003[0])
                   ->setCellValue('J'.$rowCell, $dataL0003[2])
                   ->setCellValue('K'.$rowCell, $dataL0003[1])
				   ->setCellValue('L'.$rowCell, $dataL0004[0])
                   ->setCellValue('M'.$rowCell, $dataL0004[2])
                   ->setCellValue('N'.$rowCell, $dataL0004[1])
				   ->setCellValue('O'.$rowCell, $dataL0005[0])
                   ->setCellValue('P'.$rowCell, $dataL0005[2])
                   ->setCellValue('Q'.$rowCell, $dataL0005[1])
				    ->setCellValue('R'.$rowCell, $dataL0006)
					->setCellValue('S'.$rowCell, $dataL0007)
					->setCellValue('T'.$rowCell, $dataL0008)
					->setCellValue('U'.$rowCell, $dataL0010)
					->setCellValue('V'.$rowCell, $dataL0009)
					->setCellValue('W'.$rowCell, $dataL0011);
												
												$rowCell++;
												}
												}
				
	$objWorkSheet->setTitle("Leave Summary");
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