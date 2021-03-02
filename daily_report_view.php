<?php 
include("connect.php");
include("library.php"); 
$site = $_GET["site"]; 
$tsite = $_GET["site"]; 
$select_date = $_GET["select_date"]==""?date('d/m/Y'):$_GET["select_date"];
$shift = $_GET["shift"]==""?"Day":$_GET["shift"];

$select_date_arr = explode("/",$select_date);
$select_date_sql = $select_date_arr[1]."/".$select_date_arr[0]."/".$select_date_arr[2];
	
	
?>
<html>
<head>
	<meta charset="utf-8">
	<title>Report</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="I-Wis">
	<meta name="author" content="The Red Team">

<!-- <link href="assets/less/styles.less" rel="stylesheet/less" media="all">  -->
<link rel="stylesheet" href="assets/css/styles.css?=140">
    <!-- <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600' rel='stylesheet' type='text/css'>-->

    <link href='assets/demo/variations/default.css' rel='stylesheet' type='text/css' media='all' id='styleswitcher'>
    <link href='assets/demo/variations/default.css' rel='stylesheet' type='text/css' media='all' id='headerswitcher'>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries. Placeholdr.js enables the placeholder attribute -->
    <!--[if lt IE 9]>
        <link rel="stylesheet" href="assets/css/ie8.css">
		<script type="text/javascript" src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/respond.js/1.1.0/respond.min.js"></script>
        <script type="text/javascript" src="assets/plugins/charts-flot/excanvas.min.js"></script>
	<![endif]-->

    <!-- The following CSS are included as plugins and can be removed if unused-->

    <link rel='stylesheet' type='text/css' href='assets/plugins/jqueryui-timepicker/jquery.ui.timepicker.css' /> 
<link rel='stylesheet' type='text/css' href='assets/plugins/form-daterangepicker/daterangepicker-bs3.css' /> 
<link rel='stylesheet' type='text/css' href='assets/js/jqueryui.css' /> 
<link rel='stylesheet' type='text/css' href='assets/plugins/codeprettifier/prettify.css' /> 
<link rel='stylesheet' type='text/css' href='assets/plugins/form-toggle/toggles.css' /> 
<script type="text/javascript" src="assets/js/jquery-1.10.2.min.js"></script>
</head>
<script>

$( document ).ready(function() {
	//$("#select_date").datepicker({
//		dateFormat: 'dd/mm/yy'
//	});
	
});

  function goTo(month, year){
   window.location.href = "daily_report_view.php?year="+ year +"&month="+ month;
    }
</script>

<style>
.heading-quaternary {
    display: block;
    font-size: 10px;
    line-height: 1;
	margin-top: 5px;
    margin-bottom: 2px;
	
}
.heading-quinary {
    text-transform: none;
    font-size: 10px;
	font-weight:bold;
    letter-spacing: 0;
    color: #7d8183;
    white-space: nowrap;
	
}
#card_boder{
	display: block;
	border: 1px solid rgba(0,0,0,.125);
	padding-left:2px;
	padding-right:2px
	
	
	
}
#row_pic{
	margin-bottom : 10px;
}
</style>
<style>
 th,td{width:50px;height: 30px; text-align:center}
 th{background-color: #eeeeee;}
 #tb_calendar, #main{ width : 550px;}
 #main{ border : 2px solid #46A5E0;}
 #nav{
  background-color: #0C79A4;
  min-height: 40px;
  padding: 10px;
  text-align: center;
  color : #000;
 }
 .navLeft{float: left; }
 .navRight{float: right;}
 .title{float: left; text-align: center; width: 300px;}
 </style>
<body class="" >
<div id="headerbar">
        <div class="container">
            <div class="row">


            </div>
        </div>
    </div>

    <header class="navbar navbar-inverse navbar-fixed-top" role="banner">
        <a id="leftmenu-trigger" class="tooltips" data-toggle="tooltip" data-placement="right" title="Toggle Sidebar"></a>


        <div class="navbar-header pull-left">

        </div>

        <ul class="nav navbar-nav pull-right toolbar">





        </ul>
    </header>

    <div id="page-container">
        <!-- BEGIN SIDEBAR -->
        <nav id="page-leftbar" role="navigation">
            <!-- BEGIN SIDEBAR MENU -->
            <? include("menu.php");  ?>
            <!-- END SIDEBAR MENU -->
        </nav>

        <!-- BEGIN RIGHTBAR -->
        <div id="page-rightbar">


        </div>
        <!-- END RIGHTBAR -->
        <div id="page-content">
            <div id='wrap'>

                <div class="container">
					<div class="panel panel-primary">
						<div class="panel-heading">
							<h4>Daily Report</h4>
						</div>
						<div class="panel-body">
					<!-- <div class="row">
					<div class='col-sm-6' style="padding-top:5px; padding-left:20px"><img src="images/ipack-logo-mb-1.png"></div>
					<div class='col-sm-6' style="padding-top:5px"><div class="form-group ">
					<? //=$tsite ?>
										
										<div class="col-md-2">
											
										</div>
										
										
										
										
										
									
									
									
								
							
								


								
							</div>
						
									</div>
									
									</div> -->

						
						
						
						<!-- <div class='col-xs-12 col-md-12 col-sm-12'><HR></div> -->
						<div class='col-xs-12 col-md-12 col-sm-12'>
						
						<?
						$weekDay = array( 'อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสฯ', 'ศุกร์', 'เสาร์');
					$thaiMon = array( "01" => "มกราคม", "02" => "กุมภาพันธ์", "03" => "มีนาคม", "04" => "เมษายน",
						"05" => "พฤษภาคม","06" => "มิถุนายน", "07" => "กรกฎาคม", "08" => "สิงหาคม",
						"09" => "กันยายน", "10" => "ตุลาคม", "11" => "พฤศจิกายน", "12" => "ธันวาคม");
						
						//Sun - Sat
					$month = isset($_GET['month']) ? $_GET['month'] : date('m'); //ถ้าส่งค่าเดือนมาใช้ค่าที่ส่งมา ถ้าไม่ส่งมาด้วย ใช้เดือนปัจจุบัน
					$year = isset($_GET['year']) ? $_GET['year'] : date('Y'); //ถ้าส่งค่าปีมาใช้ค่าที่ส่งมา ถ้าไม่ส่งมาด้วย ใช้ปีปัจจุบัน
					//echo "month=".$month;
					//วันที่
					$startDay = $year.'-'.$month."-01";   //วันที่เริ่มต้นของเดือน

					$timeDate = strtotime($startDay);   //เปลี่ยนวันที่เป็น timestamp
					$lastDay = date("t", $timeDate);   //จำนวนวันของเดือน

					$endDay = $year.'-'.$month."-". $lastDay;  //วันที่สุดท้ายของเดือน

					$startPoint = date('w', $timeDate);   //จุดเริ่มต้น วันในสัปดาห์




					//echo "<br>\$data ";
					//print_r($data);
					//echo "<hr>";
					?>


					<?php
					//echo "<br/>ตำแหน่งของวันที่ $startDay คือ <strong>", $startPoint , " (ตรงกับ วัน" , $weekDay[$startPoint].")</strong>";

					$title = "เดือน $thaiMon[$month] <strong>". $startDay. " : ". $endDay."</strong>";

					//ลดเวลาลง 1 เดือน
					$prevMonTime = strtotime ( '-1 month' , $timeDate  );
					$prevMon = date('m', $prevMonTime);
					$prevYear = date('Y', $prevMonTime);
					//เพิ่มเวลาขึ้น 1 เดือน
					$nextMonTime = strtotime ( '+1 month' , $timeDate  );
					$nextMon = date('m', $nextMonTime);
					$nextYear = date('Y', $nextMonTime);

					echo '<div id="main">';
					echo '<div id="nav">
					<button class="navLeft" onclick="goTo(\''.$prevMon.'\', \''.$prevYear.'\');"><< เดือนที่แล้ว</button>
					<div class="title">'.$title.'</div>
					<button class="navRight" onclick="goTo(\''.$nextMon.'\', \''.$nextYear.'\');">เดือนต่อไป >></button>
					</div>
					<div style="clear:both"></div>';
					echo "<table id='tb_calendar' border='1'>"; //เปิดตาราง
					echo "<tr>
					<th>อาทิตย์</th><th>จันทร์</th><th>อังคาร</th><th>พุธ</th><th>พฤหัสฯ</th><th>ศุกร์</th><th>เสาร์</th>
					</tr>";
					echo "<tr>";    //เปิดแถวใหม่
					$col = $startPoint;          //ให้นับลำดับคอลัมน์จาก ตำแหน่งของ วันในสับดาห์ 
					if($startPoint < 7){         //ถ้าวันอาทิตย์จะเป็น 7
					echo str_repeat("<td> </td>", $startPoint); //สร้างคอลัมน์เปล่า กรณี วันแรกของเดือนไม่ใช่วันอาทิตย์
					}
					for($i=1; $i <= $lastDay; $i++){ //วนลูป ตั้งแต่วันที่ 1 ถึงวันสุดท้ายของเดือน
					/// link to daily report
					$link_tsc = "<a href='daily_report_tsc.php?yyear=$year&mmonth=$month&ddate=$i&tsite=TSC' target='_blank'>T</a>";
					$link_hq = "<a href='daily_report_hq.php?yyear=$year&mmonth=$month&ddate=$i&tsite=HQ' target='_blank'>H</a>";
					$link_osw = "<a href='daily_report_osw.php?yyear=$year&mmonth=$month&ddate=$i&tsite=OSW' target='_blank'>O</a>";


					$col++;       //นับจำนวนคอลัมน์ เพื่อนำไปเช็กว่าครบ 7 คอลัมน์รึยัง
					$txtosw = '';
					$txthq = '';
					$txttsc = '';
					//สร้างคอลัมน์ แสดงวันที่ 
					echo "<td>";
					echo "<table width='100%' border='0' cellspacing='0' cellpadding='0'>
					<tr>
						<td>$i</td>
					</tr>
					<tr>
						<td>
						
						<table width='100%' border='0' cellspacing='0' cellpadding='0'>
						<tr>";
										$workdate = $month."/".$i."/".$year;
										$date_delay = strtotime("+1 day", strtotime("$workdate 10:00:00"));
										// echo date("Y-m-d H:i:s", $date_delay);;
										$select = "select * from  tbot_parameter where site='HQ' and workdate = '$workdate'";
										$re = mssql_query($select);
										$num=mssql_num_rows($re);
										if($num>0){
										$row = mssql_fetch_array($re);
										if($row['work_type']=='Normal working'){
											
											$select1 = "select * from   tbdaily_report_hq where  workdate = '$workdate' ";
												$re1 = mssql_query($select1);
												$num1=mssql_num_rows($re1);
												if($num1>0){
													$row1 = mssql_fetch_array($re1);
													if($row1['report_by']!=''){
														$txthq = "<td bgcolor='#FFFF99'>$link_hq</td>";
													}
													if($row1['approve_by']!=''){
														if(strtotime($row1["approve_by_date"])>$date_delay){
															$txthq = "<td bgcolor='#f55830'>$link_hq</td>";

														}else{
															$txthq = "<td bgcolor='#66FF99'>$link_hq</td>";

														}
													}
													}else{
														$txthq = "<td bgcolor='#CCCCCC'>H</td>";
													}
														
														echo $txthq;
											
											}else{
												
												$select1 = "select * from   tbdaily_report_hq where  workdate = '$workdate' ";
												$re1 = mssql_query($select1);
												$num1=mssql_num_rows($re1);
												if($num1>0){
													$row1 = mssql_fetch_array($re1);
													if($row1['report_by']!=''){
														$txthq = "<td bgcolor='#FFFF99'>$link_hq</td>";
														}
													if($row1['approve_by']!=''){
														if(strtotime($row1["approve_by_date"])>$date_delay){
															$txthq = "<td bgcolor='#f55830'>$link_hq</td>";

														}else{
															$txthq = "<td bgcolor='#66FF99'>$link_hq</td>";

														}
														// $txthq = "<td bgcolor='#66FF99'>$link_hq</td>";
														}
													}else{
														$txthq = "<td>&nbsp;</td>";
														}
												echo $txthq;
											
												
												}
										}
										$select = "select * from  tbot_parameter where site='TSC' and workdate = '$workdate'";
										$re = mssql_query($select);
										$num=mssql_num_rows($re);
										if($num>0){
										$row = mssql_fetch_array($re);
										if($row['work_type']=='Normal working'){
											
												$select1 = "select * from   tbdaily_report_tsc where  workdate = '$workdate' ";
												$re1 = mssql_query($select1);
												$num1=mssql_num_rows($re1);
												if($num1>0){
													
													$sql_day = "SELECT * from   tbdaily_report_tsc where  workdate = '$workdate' AND shift='Day'";
													$res_day = mssql_query($sql_day);
													$num_day = mssql_num_rows($res_day);
													$row_day = mssql_fetch_array($res_day);
													// $deley_date = $workdate+1;

													$sql_night = "SELECT * from   tbdaily_report_tsc where  workdate = '$workdate' AND shift='Night'";
													$res_night = mssql_query($sql_night);
													$num_night = mssql_num_rows($res_night);
													$row_night = mssql_fetch_array($res_night);

													if($row_day['report_by']!='' ){
														$bg_day = "#FFFF99";
													}else{
														$bg_day = "#CCCCCC";
													}
													if($row_day['approve_by']!='' ){
														// $bg_day = "#66FF99";
														if(strtotime($row_day["approve_by_date"])>$date_delay){
															$bg_day = "#f55830";

														}else{
															$bg_day = "#66FF99";

														}
													}
													if($row_night['report_by']!=''){
														$bg_night = "#FFFF99";
													}else{
														$bg_night = "#CCCCCC";
													}
													if($row_night['approve_by']!=''){
														// $bg_night = "#66FF99";
														if(strtotime($row_night["approve_by_date"])>$date_delay){
															$bg_night = "#f55830";

														}else{
															$bg_night = "#66FF99";

														}
													}
													// style='background:linear-gradient(to right, #FFFF99 50%, #66FF99 50%);'
													// if($row1['report_by']!=''){
													// 	$txtosw = "<td bgcolor='#FFFF99'>$link_osw</td>";
													// }
													// if($row1['approve_by']!=''){
													// 	$txtosw = "<td bgcolor='#66FF99'>$link_osw</td>";
													// }
													$txttsc = "<td style='background:linear-gradient(to right, $bg_day 50%, $bg_night 50%);'>$link_tsc</td>";
												}else{
													$txttsc = "<td bgcolor='#CCCCCC'>T</td>";
												}
											
											echo $txttsc;
											
											}else{
												
												$select1 = "select * from   tbdaily_report_tsc where  workdate = '$workdate' ";
												$re1 = mssql_query($select1);
												$num1=mssql_num_rows($re1);
												if($num1>0){
													$sql_day = "SELECT * from   tbdaily_report_tsc where  workdate = '$workdate' AND shift='Day'";
													$res_day = mssql_query($sql_day);
													$num_day = mssql_num_rows($res_day);
													$row_day = mssql_fetch_array($res_day);

													$sql_night = "SELECT * from   tbdaily_report_tsc where  workdate = '$workdate' AND shift='Night'";
													$res_night = mssql_query($sql_night);
													$num_night = mssql_num_rows($res_night);
													$row_night = mssql_fetch_array($res_night);

													if($row_day['report_by']!='' ){
														$bg_day = "#FFFF99";
													}else{
														$bg_day = "#CCCCCC";
													}
													if($row_day['approve_by']!='' ){
														// $bg_day = "#66FF99";
														if(strtotime($row_day["approve_by_date"])>$date_delay){
															$bg_day = "#f55830";

														}else{
															$bg_day = "#66FF99";

														}
													}
													if($row_night['report_by']!=''){
														$bg_night = "#FFFF99";
													}else{
														$bg_night = "#CCCCCC";
													}
													if($row_night['approve_by']!=''){
														// $bg_night = "#66FF99";
														if(strtotime($row_night["approve_by_date"])>$date_delay){
															$bg_night = "#f55830";

														}else{
															$bg_night = "#66FF99";

														}
													}
													// style='background:linear-gradient(to right, #FFFF99 50%, #66FF99 50%);'
													// if($row1['report_by']!=''){
													// 	$txtosw = "<td bgcolor='#FFFF99'>$link_osw</td>";
													// }
													// if($row1['approve_by']!=''){
													// 	$txtosw = "<td bgcolor='#66FF99'>$link_osw</td>";
													// }
													$txttsc = "<td style='background:linear-gradient(to right, $bg_day 50%, $bg_night 50%);'>$link_tsc</td>";
												}else{
														$txttsc =  "<td>&nbsp;</td>";
												}
												echo $txttsc;
											}
										}
										$select = "SELECT * from  tbot_parameter where site='OSW' and workdate = '$workdate'";
										$re = mssql_query($select);
										$num=mssql_num_rows($re);
										if($num>0){
										$row = mssql_fetch_array($re);
										if($row['work_type']=='Normal working'){
														
												$select1 = "SELECT * from   tbdaily_report_osw where  workdate = '$workdate' ";
												$re1 = mssql_query($select1);
												$num1=mssql_num_rows($re1);
												if($num1>0){
													$sql_day = "SELECT * from   tbdaily_report_osw where  workdate = '$workdate' AND shift='Day'";
													$res_day = mssql_query($sql_day);
													$num_day = mssql_num_rows($res_day);
													$row_day = mssql_fetch_array($res_day);

													$sql_night = "SELECT * from   tbdaily_report_osw where  workdate = '$workdate' AND shift='Night'";
													$res_night = mssql_query($sql_night);
													$num_night = mssql_num_rows($res_night);
													$row_night = mssql_fetch_array($res_night);

													if($row_day['report_by']!='' ){
														$bg_day = "#FFFF99";
													}else{
														$bg_day = "#CCCCCC";
													}
													if($row_day['approve_by']!='' ){
														// $bg_day = "#66FF99";
														if(strtotime($row_day["approve_by_date"])>$date_delay){
															$bg_day = "#f55830";

														}else{
															$bg_day = "#66FF99";

														}
													}
													if($row_night['report_by']!=''){
														$bg_night = "#FFFF99";
													}else{
														$bg_night = "#CCCCCC";
													}
													if($row_night['approve_by']!=''){
														// $bg_night = "#66FF99";
														if(strtotime($row_night["approve_by_date"])>$date_delay){
															$bg_night = "#f55830";

														}else{
															$bg_night = "#66FF99";

														}
													}
													// style='background:linear-gradient(to right, #FFFF99 50%, #66FF99 50%);'
													// if($row1['report_by']!=''){
													// 	$txtosw = "<td bgcolor='#FFFF99'>$link_osw</td>";
													// }
													// if($row1['approve_by']!=''){
													// 	$txtosw = "<td bgcolor='#66FF99'>$link_osw</td>";
													// }
													$txtosw = "<td style='background:linear-gradient(to right, $bg_day 50%, $bg_night 50%);'>$link_osw</td>";
												}else{
													$txtosw = "<td bgcolor='#CCCCCC'>O</td>";
												}
														
													echo $txtosw;	
											}else{
												
												$select1 = "SELECT * from   tbdaily_report_osw where  workdate = '$workdate' ";
												$re1 = mssql_query($select1);
												$num1=mssql_num_rows($re1);
												if($num1>0){
													$sql_day = "SELECT * from   tbdaily_report_osw where  workdate = '$workdate' AND shift='Day'";
													$res_day = mssql_query($sql_day);
													$num_day = mssql_num_rows($res_day);
													$row_day = mssql_fetch_array($res_day);

													$sql_night = "SELECT * from   tbdaily_report_osw where  workdate = '$workdate' AND shift='Night'";
													$res_night = mssql_query($sql_night);
													$num_night = mssql_num_rows($res_night);
													$row_night = mssql_fetch_array($res_night);

													if($row_day['report_by']!=''){
														$bg_day = "#FFFF99";
													}else{
														$bg_day = "#CCCCCC";
													}
													if($row_day['approve_by']!=''){
														// $bg_day = "#66FF99";
														if(strtotime($row_day["approve_by_date"])>$date_delay){
															$bg_day = "#f55830";

														}else{
															$bg_day = "#66FF99";

														}
													}
													if($row_night['report_by']!=''){
														$bg_night = "#FFFF99";
													}else{
														$bg_night = "#CCCCCC";
													}
													if($row_night['approve_by']!=''){
														// $bg_night = "#66FF99";
														if(strtotime($row_night["approve_by_date"])>$date_delay){
															$bg_night = "#f55830";

														}else{
															$bg_night = "#66FF99";

														}
													}
													// style='background:linear-gradient(to right, #FFFF99 50%, #66FF99 50%);'
													// if($row1['report_by']!=''){
													// 	$txtosw = "<td bgcolor='#FFFF99'>$link_osw</td>";
													// }
													// if($row1['approve_by']!=''){
													// 	$txtosw = "<td bgcolor='#66FF99'>$link_osw</td>";
													// }
													$txtosw = "<td style='background:linear-gradient(to right, $bg_day 50%, $bg_night 50%);'>$link_osw</td>";
												}else{
													$txtosw =  "<td>&nbsp;</td>";
												}
												
												echo $txtosw;	
											}
										}
					
					
					echo " </tr>
						</table>
						
						</td>
					</tr>
					</table>
					";
					echo  "</td>";
					
					
					if($col % 7 == false){   //ถ้าครบ 7 คอลัมน์ให้ขึ้นบรรทัดใหม่
					echo "</tr><tr>";   //ปิดแถวเดิม และขึ้นแถวใหม่
					$col = 0;     //เริ่มตัวนับคอลัมน์ใหม่
					}
					}
					if($col < 7){         // ถ้ายังไม่ครบ7 วัน
					echo str_repeat("<td> </td>", 7-$col); //สร้างคอลัมน์ให้ครบตามจำนวนที่ขาด
					}
					echo '</tr>';  //ปิดแถวสุดท้าย
					echo '</table>'; //ปิดตาราง
					echo '</main>';
						
						//echo ">>".$_COOKIE["main_userid"];
						?>
						
						
						
							</div>
							<br>
							<table>
								<tr>
									<td bgcolor="#CCCCCC" style="width: 120px;"></td>
									<td style="width: 500px;text-align:left">&nbsp;ไม่มี Action ใดๆ </td>
								</tr>
								<tr>
									<td bgcolor="#FFFF99" style="width: 120px;"></td>
									<td style="width: 500px;text-align:left">&nbsp;รออนุมัติ </td>
								</tr>
								<tr>
									<td bgcolor="#66FF99" style="width: 120px;"></td>
									<td style="width: 500px;text-align:left">&nbsp;อนุมัติ  ภายใน 10.00 ในวันถัดมา </td>
								</tr>
								<tr>
									<td bgcolor="#f55830" style="width: 120px;"></td>
									<td style="width: 500px;text-align:left" >&nbsp;อนุมัติ หลังจาก 10.00 ในวันถัดมา</td>
								</tr>
							</table>
							
						</div>
						</div>
						
						
					</div>
						


	</div> <!-- container -->
            </div>
            <!--wrap -->
        </div> <!-- page-content -->

        <footer role="contentinfo">
            <div class="clearfix">
                <ul class="list-unstyled list-inline">
                    <li>I-Wis</li>
                    <button class="pull-right btn btn-inverse-alt btn-xs hidden-print" id="back-to-top"><i class="fa fa-arrow-up"></i></button>
                </ul>
            </div>
        </footer>

    </div> <!-- page-container -->
	
<script type='text/javascript' src='assets/js/enquire.js'></script> 
<script type='text/javascript' src='assets/js/jquery.cookie.js'></script> 
<script type='text/javascript' src='assets/js/jquery.nicescroll.min.js'></script> 
<script type='text/javascript' src='assets/plugins/codeprettifier/prettify.js'></script> 
<script type='text/javascript' src='assets/plugins/easypiechart/jquery.easypiechart.min.js'></script> 
<script type='text/javascript' src='assets/plugins/sparklines/jquery.sparklines.min.js'></script> 
<script type='text/javascript' src='assets/plugins/form-toggle/toggle.min.js'></script> 
<script type='text/javascript' src='assets/js/placeholdr.js'></script> 
<script type='text/javascript' src='assets/js/application.js'></script> 
<script type='text/javascript' src='assets/plugins/bootbox/bootbox.min.js'></script> 

<!--<script type='text/javascript' src='jquery-ui-timepicker-0.3.3/jquery.ui.timepicker.js'></script> -->

<!--<script type='text/javascript' src='assets/plugins/form-daterangepicker/daterangepicker.min.js'></script> -->
<script type='text/javascript' src='assets/plugins/bootbox/bootbox.min.js'></script>
<!--<script type='text/javascript' src='assets/plugins/form-datepicker/js/bootstrap-datepicker.js'></script> -->
<script type='text/javascript' src='assets/plugins/form-typeahead/typeahead.min.js'></script> 


</body>
</html>