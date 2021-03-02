<?php
include("connect.php");
include("library.php");

$status = $_REQUEST['status'];
$date_time = date("m/d/Y H:i:s");
$_time = date("H:i:s");
$txtyear = date('Y');
/*function DateDiff($strDate1,$strDate2)
	 {
				return (strtotime($strDate2) - strtotime($strDate1))/  ( 60 * 60 * 24 );  // 1 day = 60*60*24
	 }
	 function TimeDiff($strTime1,$strTime2)
	 {
				return (strtotime($strTime2) - strtotime($strTime1))/  ( 60 * 60 ); // 1 Hour =  60*60
	 }
	 function DateTimeDiff($strDateTime1,$strDateTime2)
	 {
				return (strtotime($strDateTime2) - strtotime($strDateTime1))/  ( 60 * 60  ); // 1 min =  60*60
	 }*/

if ($status == 'show_daily_tsc') {

	$mmonth = (int) $_POST['mmonth'];
	$tsite = $_POST['tsite2'];
	$yyear = $_POST['yyear'];
	$ddate = $_POST['ddate'];
	$workday_q = $mmonth . "/" . $ddate . "/" . $yyear;

	$select_emp_day = "SELECT report_by,approve_by from tbdaily_report_tsc where workdate = '$workday_q' AND shift='Day'";
	$re_emp_day = mssql_query($select_emp_day);
	$num_emp_day = mssql_num_rows($re_emp_day);
	if ($num_emp_day > 0) {
		$row_emp_day = mssql_fetch_array($re_emp_day);
		$report_by_day = get_full_name($row_emp_day['report_by']);
		$approve_by = get_full_name($row_emp_day['approve_by']);
		$pic_report_day = "<img src='emppic/" . $row_emp_day['report_by'] . "' height='50'>";
		$pic_approve = "<img src='emppic/" . $row_emp_day['approve_by'] . "' height='50'>";
	}

	$select_emp_night = "SELECT report_by,approve_by from tbdaily_report_tsc where workdate = '$workday_q' AND shift='Night'";
	$re_emp_night = mssql_query($select_emp_night);
	$num_emp_night = mssql_num_rows($re_emp_night);
	if ($num_emp_night > 0) {
		$row_emp_night = mssql_fetch_array($re_emp_night);
		$report_by_night = get_full_name($row_emp_night['report_by']);
		// $approve_by_night = get_full_name($row_emp_night['approve_by']);
		$pic_report_night = "<img src='emppic/" . $row_emp_night['report_by'] . "' height='50'>";
		// $pic_approve = "<img src='emppic/" . $row_emp['approve_by'] . "' height='50'>";
	}

	//$month = $_POST['month'];
	//	$tsite = $_POST['tsite2'];
	//	$month_explode_arr = explode("-", $month);
	//	$mmonth = $month_explode_arr[1];
	//	$yyear = $month_explode_arr[0];

	$number = cal_days_in_month(CAL_GREGORIAN, $mmonth, $yyear);
	$startdate = $yyear . "-" . $mmonth . "-01";
	$enddate = $yyear . "-" . $mmonth . "-" . $number;


	if ($tsite == 'TSC') {
		$table_name = "tbdaily_report_tsc";
	} else if ($tsite == 'HQ') {
		$table_name = "tbdaily_report_hq";
	} else if ($tsite == 'OSW') {
		$table_name = "tbdaily_report_osw";
	}

?>





	<table border="0" cellspacing="0" cellpadding="0" class="table table-striped table-bordered datatables">


		<tr>
			<td height="80" style="padding:0px">

				<table width="100%" border="0" cellspacing="0" cellpadding="0">

					<tr>
						<td colspan="5" height="40" bgcolor="#002060" align="center" valign="middle"><img src="images/ipack-logo-mb-2.png" style="float:left"><strong>
								<font color="#FFFFFF" size="5">TSC Daily Operation Report.</font>
							</strong></td>
					</tr>
					<tr>
						<td width="15%" height="120" align="center" bgcolor="#C00000"><strong>
								<font color="#FFFFFF" size="3">Date:</font>
							</strong></td>
						<td align="center" width="15%"><strong>
								<font color="#000000" size="3"><?
																echo $ddate;
																echo "-";
																echo date("F", strtotime($startdate));
																echo "-";
																echo $yyear;
																?></font>
							</strong></td>
						<td width="15%" align="center" bgcolor="#C00000"><strong>
								<font color="#FFFFFF" size="3">Shift:A,B</font>
							</strong></td>
						<td align="center" width="15%"><strong>
								<font color="#000000" size="3">DAY,Night</font>
							</strong></td>
						<td align="center" width="40%">
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td width="30%" height="60" align="center" bgcolor="#FFE699" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; " rowspan="2"><strong>Report By:</strong></td>
									<td width="30%" align="center" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; ">(Day) <?= $report_by_day ?></td>
									<td width="30%" align="center" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; "><?= $pic_report_day ?></td>
								</tr>
								<tr>
									<td width="30%" align="center" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; ">(Night) <?= $report_by_night ?></td>
									<td width="30%" align="center" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; "><?= $pic_report_night ?></td>
								</tr>
								<tr>
									<td height="60" align="center" bgcolor="#FFE699" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; "><strong>Approve By:</strong></td>
									<td align="center" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; "><?= $approve_by ?></td>
									<td align="center" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; "><?= $pic_approve ?></td>
								</tr>
							</table>
						</td>
					</tr>
				</table>

		</tr>
		</td>


		<tr>
			<td align="center" bgcolor="#ffffff" style="padding:0px">

				<table border="0" cellspacing="1" cellpadding="0">

					<tr>
						<td align="left" width="331" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#DBDBDB">&nbsp;</td>
						<td align="center" width="86" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#8EA9DB">&nbsp;</td>
						<?

						$select0 = "SELECT *,
			convert(varchar, workdate, 101)as  workdate2,
			convert(varchar, workdate, 103)as  workdate3
			
	FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";
						//echo $select0;
						//exit();
						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

						?>
								<td align='center' width='70' style='border-right:1px solid; border-bottom:1px solid;border-top:1px solid;' bgcolor="#ffffff">
									<?
									//date("d", strtotime($row0['workdate']));
									if ($ddate == date("d", strtotime($row0['workdate']))) {
									?><img src="images/point.jpg" width="20">
									<?
									}
									?>
								</td>
						<?


							}
						}

						?>
					</tr>
					<tr>
						<td align="left" width="331" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#DBDBDB"><strong>1. SAFETY.</strong></td>
						<td align="center" width="86" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#8EA9DB"><strong>DATE : </strong></td>
						<?

						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";
						//echo $select0;
						//exit();
						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

						?>
								<td align='center' width='70' style='border-right:1px solid; border-bottom:1px solid; color:#FFF' bgcolor="#595959"><strong>
										<?= date("d", strtotime($row0['workdate'])) ?>
									</strong></td>
						<?


							}
						}

						?>
					</tr>


					<!--/// safety_human ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF"><strong>1.1 Human ( Case )<BR>อุบัติเหตุที่เกิดขึ้นกับคน</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Case</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT sum(safety_human) as safety_human FROM    $table_name where workdate ='" . $row0['workdate'] . "' ";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$safety_human = $row1['safety_human'];
								} else {
									$safety_human = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>"><strong>
										<?
										echo $safety_human;
										?>
									</strong></td>
						<?


							}
						}

						?>
					</tr>
					<!--/// safety_human ///-->

					<!--/// safety_part ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF"><strong>1.2 Part ( Pcs.)<BR>อุบัติเหตุที่เกิดขึ้นกับชิ้นงาน</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Pcs</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT sum(safety_part) as safety_part FROM    $table_name where workdate ='" . $row0['workdate'] . "' ";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$safety_part = $row1['safety_part'];
								} else {
									$safety_part = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>"><strong>
										<?
										echo $safety_part;
										?>
									</strong></td>
						<?


							}
						}

						?>
					</tr>
					<!--/// safety_part ///-->

					<!--/// safety_nearmiss ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF"><strong>1.3 Near miss ( Case )<BR>อุบัติเหตุหรือเหตุการณ์ที่อาจทำให้เกิดอุบัติเหตุได้</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Case</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT sum(safety_nearmiss) as safety_nearmiss FROM    $table_name where workdate ='" . $row0['workdate'] . "' ";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$safety_nearmiss = $row1['safety_nearmiss'];
								} else {
									$safety_nearmiss = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>"><strong>
										<?
										echo $safety_nearmiss;
										?>
									</strong></td>
						<?


							}
						}

						?>
					</tr>
					<!--/// safety_nearmiss ///-->

					<!--/// safety_target ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFF00"><strong>Result Performance</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#92D050"><strong>%</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								$bg_day = "#FFE699";

								$select1 = "SELECT safety_target FROM    $table_name where workdate ='" . $row0['workdate'] . "' ";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$safety_target = $row1['safety_target'] . "%";
								} else {
									$safety_target = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>"><strong>
										<?
										echo $safety_target;

										?>
									</strong></td>
						<?


							}
						}

						?>
					</tr>
					<!--/// safety_target ///-->


					<tr>
						<td height="20" colspan="2" align="left" bgcolor="#DBDBDB" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px"><strong>2. 5S. Daily</strong><strong></strong></td>
						<?

						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#FFF' bgcolor="#595959"><strong>
										<?= date("d", strtotime($row0['workdate'])) ?>
									</strong></td>
						<?


							}
						}

						?>
					</tr>


					<!--/// ss_daily ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#00FFFF"><strong>1.Ware house Area</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#00FFFF"><strong></strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {


								$bg_day = "#00FFFF";

								$select1 = "SELECT ss_daily FROM    $table_name where workdate ='" . $row0['workdate'] . "' ";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									if ($row1['ss_daily'] != '') {
										$ss_daily = "<a href='" . $row1['ss_daily'] . "' target='_blank'>Link</a>";
									} else {
										$ss_daily = '';
									}
								} else {
									$ss_daily = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>"><strong>
										<?
										echo $ss_daily;
										?>
									</strong></td>
						<?


							}
						}

						?>
					</tr>
					<!--/// ss_daily ///-->

					<!--/// ss_daily_day ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#00FFFF"><strong>Day</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#00FFFF"><strong></strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {


								$bg_day = "#00FFFF";

								$select1 = "SELECT ss_daily_status FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Day' ";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									if ($row1['ss_daily_status'] != '') {
										$arr_ss_daily_status = explode(",", $row1['ss_daily_status']);
										$ss_daily_status = $arr_ss_daily_status[0] . "<br>" . $arr_ss_daily_status[1];
									} else {
										$ss_daily_status = '';
									}
								} else {
									$ss_daily_status = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>"><strong>
										<?
										echo $ss_daily_status;
										?>
									</strong></td>
						<?


							}
						}

						?>
					</tr>
					<!--/// ss_daily_day ///-->

					<!--/// ss_daily_night ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#00FFFF"><strong>Night</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#00FFFF"><strong></strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

								$bg_day = "#00FFFF";

								$select1 = "SELECT ss_daily_status FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Night'";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									if ($row1['ss_daily_status'] != '') {
										$arr_ss_daily_status = explode(",", $row1['ss_daily_status']);
										$ss_daily_status = $arr_ss_daily_status[0] . "&nbsp;" . $arr_ss_daily_status[1];
									} else {
										$ss_daily_status = '';
									}
								} else {
									$ss_daily_status = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>"><strong>
										<?
										echo $ss_daily_status;
										?>
									</strong></td>
						<?


							}
						}

						?>
					</tr>
					<!--/// ss_daily_night ///-->

					<!--/// ss_daily_percent ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#ffffff"><strong>Status Check </strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#ffffff"><strong>%</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {


								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT ss_daily_percent FROM    $table_name where workdate ='" . $row0['workdate'] . "' ";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									if ($row1['ss_daily_percent'] != '') {
										$ss_daily_percent = $row1['ss_daily_percent'] . "%";
									} else {
										$ss_daily_percent = '';
									}
								} else {
									$ss_daily_percent = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>"><strong>
										<?
										echo $ss_daily_percent;
										?>
									</strong></td>
						<?


							}
						}

						?>
					</tr>
					<!--/// ss_daily_percent ///-->


					<tr>
						<td height="20" colspan="2" align="left" bgcolor="#DBDBDB" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px"><strong>3. TIME ATTENDANCE.</strong><strong></strong></td>
						<?

						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#FFF' bgcolor="#595959"><strong>
										<?= date("d", strtotime($row0['workdate'])) ?>
									</strong></td>
						<?


							}
						}

						?>
					</tr>


					<!--/// att_asst_mgr ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF"><strong>- Asst,wh MGR</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Prs.</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT sum(att_asst_mgr) as att_asst_mgr FROM    $table_name where workdate ='" . $row0['workdate'] . "' ";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$att_asst_mgr = $row1['att_asst_mgr'];
								} else {
									$att_asst_mgr = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>"><strong>
										<?
										echo $att_asst_mgr;
										?>
									</strong></td>
						<?


							}
						}

						?>
					</tr>
					<!--/// att_asst_mgr ///-->

					<!--/// Operator Day shift ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#f9af00"><strong>3.1 Operator Day shift</strong></td>
						<td align="center" height="20" style="border-right:0px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong></strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
											
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


						?>
								<td align='center' style='border-right:0px solid; border-bottom:1px solid; color:#000000' bgcolor="">
									<strong>
										
									</strong>
								</td>
						<?


							}
						}

						?>
					</tr>
					<!--/// Operator Day shift ///-->

					<!--/// att_supervisor ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF"><strong>- Supervisor</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Prs.</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT att_supervisor FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Day'";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$att_supervisor = $row1['att_supervisor'];
								} else {
									$att_supervisor = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>"><strong>
										<?
										echo $att_supervisor;
										?>
									</strong></td>
						<?


							}
						}

						?>
					</tr>
					<!--/// att_supervisor ///-->

					<!--/// att_leader ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF"><strong>- Leader</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Prs.</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT att_leader FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Day'";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$att_leader = $row1['att_leader'];
								} else {
									$att_leader = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>"><strong>
										<?
										echo $att_leader;
										?>
									</strong></td>
						<?


							}
						}

						?>
					</tr>
					<!--/// att_leader ///-->

					<!--/// att_operator ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF"><strong>- Operator</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Prs.</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT att_operator FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Day'";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$att_operator = $row1['att_operator'];
								} else {
									$att_operator = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>"><strong>
										<?
										echo $att_operator;
										?>
									</strong></td>
						<?


							}
						}

						?>
					</tr>
					<!--/// att_operator ///-->
					<!--/// att_admin ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF"><strong>- Admin</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Prs.</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT att_admin FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Day'";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$att_admin = $row1['att_admin'];
								} else {
									$att_admin = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>"><strong>
										<?
										echo $att_admin;
										?>
									</strong></td>
						<?


							}
						}

						?>
					</tr>
					<!--/// att_admin ///-->


					<!--/// att_late ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF"><strong>- Late</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Prs.</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT att_late FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Day'";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$att_late = $row1['att_late'];
								} else {
									$att_late = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>"><strong>
										<?
										echo $att_late;
										?>
									</strong></td>
						<?


							}
						}

						?>
					</tr>
					<!--/// att_late ///-->

					<!--/// Operator Night shift ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#8de5ff"><strong>3.1 Operator Night shift</strong></td>
						<td align="center" height="20" style="border-right:0px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong></strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
											
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


						?>
								<td align='center' style='border-right:0px solid; border-bottom:1px solid; color:#000000' bgcolor="">
									<strong>
										
									</strong>
								</td>
						<?


							}
						}

						?>
					</tr>
					<!--/// Operator Night shift ///-->

					<!--/// att_supervisor Night ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF"><strong>- Supervisor</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Prs.</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT att_supervisor FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Night'";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$att_supervisor = $row1['att_supervisor'];
								} else {
									$att_supervisor = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>"><strong>
										<?
										echo $att_supervisor;
										?>
									</strong></td>
						<?


							}
						}

						?>
					</tr>
					<!--/// att_supervisor Night ///-->

					<!--/// att_leader Night ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF"><strong>- Leader</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Prs.</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT att_leader FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Night'";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$att_leader = $row1['att_leader'];
								} else {
									$att_leader = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>"><strong>
										<?
										echo $att_leader;
										?>
									</strong></td>
						<?


							}
						}

						?>
					</tr>
					<!--/// att_leader Night ///-->

					<!--/// att_operator Night ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF"><strong>- Operator</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Prs.</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT att_operator FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Night'";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$att_operator = $row1['att_operator'];
								} else {
									$att_operator = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>"><strong>
										<?
										echo $att_operator;
										?>
									</strong></td>
						<?


							}
						}

						?>
					</tr>
					<!--/// att_operator Night ///-->
					<!--/// att_admin Night ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF"><strong>- Admin</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Prs.</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT att_admin FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Night'";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$att_admin = $row1['att_admin'];
								} else {
									$att_admin = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>"><strong>
										<?
										echo $att_admin;
										?>
									</strong></td>
						<?


							}
						}

						?>
					</tr>
					<!--/// att_admin Night ///-->


					<!--/// att_late Night ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF"><strong>- Late</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Prs.</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT att_late FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Night'";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$att_late = $row1['att_late'];
								} else {
									$att_late = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>"><strong>
										<?
										echo $att_late;
										?>
									</strong></td>
						<?


							}
						}

						?>
					</tr>
					<!--/// att_late Night ///-->


					<!--/// att_plan ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF">&nbsp;</td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Plan</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT sum(att_plan) as att_plan FROM    $table_name where workdate ='" . $row0['workdate'] . "' ";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$att_plan = $row1['att_plan'];
								} else {
									$att_plan = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>"><strong>
										<?
										echo $att_plan;
										?>
									</strong></td>
						<?


							}
						}

						?>
					</tr>
					<!--/// att_plan ///-->

					<!--/// att_total ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF">&nbsp;</td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Total</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT sum(att_total) as att_total FROM    $table_name where workdate ='" . $row0['workdate'] . "' ";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$att_total = $row1['att_total'];
								} else {
									$att_total = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>"><strong>
										<?
										echo $att_total;
										?>
									</strong></td>
						<?


							}
						}

						?>
					</tr>
					<!--/// att_total ///-->

					<!--/// att_total_percent ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFF00"><strong>Total attendance (%)/Day.</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#92D050"><strong>%</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

								$bg_day = "#FFE699";


								$select1 = "SELECT (sum(att_total)* 100 / (Select sum(att_plan) From $table_name where workdate ='" . $row0['workdate'] . "')) as att_total_percent FROM    $table_name where workdate ='" . $row0['workdate'] . "' ";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									if ($row1['att_total_percent'] != '') {
										if($row1['att_total_percent']>100){
											$att_total_percent = "100%";
										}else{

											$att_total_percent = $row1['att_total_percent'] . "%";
										}
									} else {
										$att_total_percent = '';
									}
								} else {
									$att_total_percent = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>"><strong>
										<?
										echo $att_total_percent;
										?>
									</strong></td>
						<?


							}
						}

						?>
					</tr>
					<!--/// att_total_percent ///-->

					<!--/// att_achieve ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFF00"><strong>Status achieve</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#92D050">&nbsp;</td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

								$bg_day = "#FFE699";


								$select1 = "SELECT (sum(att_total)* 100 / (Select sum(att_plan) From $table_name where workdate ='" . $row0['workdate'] . "')) as att_total_percent FROM    $table_name where workdate ='" . $row0['workdate'] . "' ";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									if ($row1['att_total_percent'] != '') {
										if($row1['att_total_percent'] > 87){
											$att_achieve = "<font color='#00B050'>On</font>";
										} else if($row1['att_total_percent'] > 0){
											$att_achieve = "<font color='#FF0000'>Not</font>";
										}
									} else {
										$att_achieve = '';
									}
								} else {
									$att_achieve = '';
								}
									


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>"><strong>
										<a href="javascript:void(0)" onclick="show_att('<?=$row0['workdate3']?>')">
										<?
										echo $att_achieve.$att_total_percent;
										?>
										</a>
									</strong></td>
						<?


							}
						}

						?>
					</tr>
					<!--/// att_achieve ///-->

					<!-- Fork lift -->
					<tr>
						<td height="20" colspan="2" align="left" bgcolor="#DBDBDB" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px"><strong>Fork lift</strong><strong></strong></td>
						<?

						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#FFF' bgcolor="#595959"><strong>
										<?= date("d", strtotime($row0['workdate'])) ?>
									</strong></td>
						<?


							}
						}

						?>
					</tr>
					<!-- Fork lift -->

					<!--/// att_forklift_day ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF"><strong>- Day shift</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Prs.</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT att_forklift_name FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Day'";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$att_forklift_name = lang_thai_from_database($row1['att_forklift_name']);
								} else {
									$att_forklift_name = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>"><strong>
										<?
										echo $att_forklift_name;
										?>
									</strong></td>
						<?


							}
						}

						?>
					</tr>
					<!--/// att_forklift_day ///-->

					<!--/// att_forklift_night ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF"><strong>- Night shift</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Prs.</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT att_forklift_name FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Night'";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$att_forklift_name = lang_thai_from_database($row1['att_forklift_name']);
								} else {
									$att_forklift_name = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>"><strong>
										<?
										echo $att_forklift_name;
										?>
									</strong></td>
						<?


							}
						}

						?>
					</tr>
					<!--/// att_forklift_night ///-->

					<!-- 4. OT Work -->
					<tr>
						<td height="20" colspan="2" align="left" bgcolor="#DBDBDB" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px"><strong>4. OVERTIME</strong><strong></strong></td>
						<?

						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#FFF' bgcolor="#595959"><strong>
										<?= date("d", strtotime($row0['workdate'])) ?>
									</strong></td>
						<?


							}
						}

						?>
					</tr>
					<!-- 4. OT Work -->

					<!--/// OT Day shift ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#f9af00"><strong>4.1 OT Day shift</strong></td>
						<td align="center" height="20" style="border-right:0px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong></strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
											
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


						?>
								<td align='center' style='border-right:0px solid; border-bottom:1px solid; color:#000000' bgcolor="">
									<strong>
										
									</strong>
								</td>
						<?


							}
						}

						?>
					</tr>
					<!--/// OT Day shift ///-->
					<!--/// ot_asst_mgr_prs Day ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF"><strong>- Asst,wh MGR</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Prs./Hrs.</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								//$bg_day = "#FFFFFF";
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT ot_asst_mgr_prs,ot_asst_mgr_hrs FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Day'";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$ot_asst_mgr_prs = $row1['ot_asst_mgr_prs'];
									$ot_asst_mgr_hrs = $row1['ot_asst_mgr_hrs'];
								} else {
									$ot_asst_mgr_prs = '';
									$ot_asst_mgr_hrs = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
									<?
									if ($num1 != '') {
										echo $ot_asst_mgr_prs;
									?>&nbsp;<strong>/</strong>&nbsp;<?
											echo $ot_asst_mgr_hrs;
										}
											?>

								</td>
						<?


							}
						}

						?>
					</tr>
					<!--/// ot_asst_mgr_prs Day ///-->

					<!--/// ot_supervisor_prs, ot_supervisor_hrs Day ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF"><strong>- Supervisor</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Prs./Hrs.</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								//$bg_day = "#FFFFFF";
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT ot_supervisor_prs, ot_supervisor_hrs FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Day'";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$ot_supervisor_prs = $row1['ot_supervisor_prs'];
									$ot_supervisor_hrs = $row1['ot_supervisor_hrs'];
								} else {
									$ot_supervisor_prs = '';
									$ot_supervisor_hrs = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
									<?
									if ($num1 != '') {
										echo $ot_supervisor_prs;
									?>&nbsp;<strong>/</strong>&nbsp;<?
											echo $ot_supervisor_hrs;
										}
											?>
								</td>
						<?


							}
						}

						?>
					</tr>
					<!--/// ot_supervisor_prs, ot_supervisor_hrs Day ///-->

					<!--/// ot_leader_prs, ot_leader_hrs Day ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF"><strong>- Leader</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Prs./Hrs.</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								//$bg_day = "#FFFFFF";
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT ot_leader_prs, ot_leader_hrs FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Day'";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$ot_leader_prs = $row1['ot_leader_prs'];
									$ot_leader_hrs = $row1['ot_leader_hrs'];
								} else {
									$ot_leader_prs = '';
									$ot_leader_hrs = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
									<?
									if ($num1 != '') {
										echo $ot_leader_prs;
									?>&nbsp;<strong>/</strong>&nbsp;<?
											echo $ot_leader_hrs;
										}
											?>
								</td>
						<?


							}
						}

						?>
					</tr>
					<!--/// ot_leader_prs, ot_leader_hrs Day ///-->

					<!--/// ot_operator_prs, ot_operator_hrs Day ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF"><strong>- Operator</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Prs./Hrs.</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								//$bg_day = "#FFFFFF";
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT ot_operator_prs, ot_operator_hrs FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Day'";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$ot_operator_prs = $row1['ot_operator_prs'];
									$ot_operator_hrs = $row1['ot_operator_hrs'];
								} else {
									$ot_operator_prs = '';
									$ot_operator_hrs = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
									<?
									if ($num1 > 0) {
										echo $ot_operator_prs;
									?>&nbsp;<strong>/</strong>&nbsp;<?
											echo $ot_operator_hrs;
										}
											?>
								</td>
						<?


							}
						}

						?>
					</tr>
					<!--/// ot_operator_prs, ot_operator_hrs Day ///-->
					<!--/// ot_admin_prs, ot_admin_hrs Day ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF"><strong>- Admin</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Prs./Hrs.</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								//$bg_day = "#FFFFFF";
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT ot_admin_prs, ot_admin_hrs FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Day'";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$ot_admin_prs = $row1['ot_admin_prs'];
									$ot_admin_hrs = $row1['ot_admin_hrs'];
								} else {
									$ot_admin_prs = '';
									$ot_admin_hrs = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
									<?
									if ($num1 > 0) {
										echo $ot_admin_prs;
									?>&nbsp;<strong>/</strong>&nbsp;<?
											echo $ot_admin_hrs;
										}
											?>
								</td>
						<?


							}
						}

						?>
					</tr>
					<!--/// ot_admin_prs, ot_admin_hrs Day ///-->

					<!--/// ot_target Day ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF"><strong>Target Day shift</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Hrs.</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								//$bg_day = "#FFFFFF";
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT ot_target FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Day'";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$ot_target = $row1['ot_target'];
								} else {
									$ot_target = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
									<strong>
										<?= $ot_target ?>
									</strong></td>
						<?


							}
						}

						?>
					</tr>
					<!--/// ot_target Day ///-->

					<!--/// ot_actual Day ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF"><strong>Actual Day shift</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Hrs.</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								//$bg_day = "#FFFFFF";
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT ot_actual FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Day'";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$ot_actual = $row1['ot_actual'];
								} else {
									$ot_actual = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
									<strong>
										<?= $ot_actual ?>
									</strong></td>
						<?


							}
						}

						?>
					</tr>
					<!--/// ot_actual Day ///-->

					<!--/// OT Night shift ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#8de5ff"><strong>4.1 OT Night shift</strong></td>
						<td align="center" height="20" style="border-right:0px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong></strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
											
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


						?>
								<td align='center' style='border-right:0px solid; border-bottom:1px solid; color:#000000' bgcolor="">
									<strong>
										
									</strong>
								</td>
						<?


							}
						}

						?>
					</tr>
					<!--/// OT Night shift ///-->
					<!--/// ot_asst_mgr_prs Night ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF"><strong>- Asst,wh MGR</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Prs./Hrs.</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								//$bg_day = "#FFFFFF";
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT ot_asst_mgr_prs,ot_asst_mgr_hrs FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Night'";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$ot_asst_mgr_prs = $row1['ot_asst_mgr_prs'];
									$ot_asst_mgr_hrs = $row1['ot_asst_mgr_hrs'];
								} else {
									$ot_asst_mgr_prs = '';
									$ot_asst_mgr_hrs = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
									<?
									if ($num1 != '') {
										echo $ot_asst_mgr_prs;
									?>&nbsp;<strong>/</strong>&nbsp;<?
											echo $ot_asst_mgr_hrs;
										}
											?>

								</td>
						<?


							}
						}

						?>
					</tr>
					<!--/// ot_asst_mgr_prs Night ///-->

					<!--/// ot_supervisor_prs, ot_supervisor_hrs Night ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF"><strong>- Supervisor</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Prs./Hrs.</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								//$bg_day = "#FFFFFF";
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT ot_supervisor_prs, ot_supervisor_hrs FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Night'";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$ot_supervisor_prs = $row1['ot_supervisor_prs'];
									$ot_supervisor_hrs = $row1['ot_supervisor_hrs'];
								} else {
									$ot_supervisor_prs = '';
									$ot_supervisor_hrs = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
									<?
									if ($num1 != '') {
										echo $ot_supervisor_prs;
									?>&nbsp;<strong>/</strong>&nbsp;<?
											echo $ot_supervisor_hrs;
										}
											?>
								</td>
						<?


							}
						}

						?>
					</tr>
					<!--/// ot_supervisor_prs, ot_supervisor_hrs Night ///-->

					<!--/// ot_leader_prs, ot_leader_hrs Night ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF"><strong>- Leader</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Prs./Hrs.</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								//$bg_day = "#FFFFFF";
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT ot_leader_prs, ot_leader_hrs FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Night'";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$ot_leader_prs = $row1['ot_leader_prs'];
									$ot_leader_hrs = $row1['ot_leader_hrs'];
								} else {
									$ot_leader_prs = '';
									$ot_leader_hrs = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
									<?
									if ($num1 != '') {
										echo $ot_leader_prs;
									?>&nbsp;<strong>/</strong>&nbsp;<?
											echo $ot_leader_hrs;
										}
											?>
								</td>
						<?


							}
						}

						?>
					</tr>
					<!--/// ot_leader_prs, ot_leader_hrs Night ///-->

					<!--/// ot_operator_prs, ot_operator_hrs Night ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF"><strong>- Operator</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Prs./Hrs.</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								//$bg_day = "#FFFFFF";
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT ot_operator_prs, ot_operator_hrs FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Night'";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$ot_operator_prs = $row1['ot_operator_prs'];
									$ot_operator_hrs = $row1['ot_operator_hrs'];
								} else {
									$ot_operator_prs = '';
									$ot_operator_hrs = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
									<?
									if ($num1 > 0) {
										echo $ot_operator_prs;
									?>&nbsp;<strong>/</strong>&nbsp;<?
											echo $ot_operator_hrs;
										}
											?>
								</td>
						<?


							}
						}

						?>
					</tr>
					<!--/// ot_operator_prs, ot_operator_hrs Night ///-->
					<!--/// ot_admin_prs, ot_admin_hrs Night ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF"><strong>- Admin</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Prs./Hrs.</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								//$bg_day = "#FFFFFF";
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT ot_admin_prs, ot_admin_hrs FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Night'";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$ot_admin_prs = $row1['ot_admin_prs'];
									$ot_admin_hrs = $row1['ot_admin_hrs'];
								} else {
									$ot_admin_prs = '';
									$ot_admin_hrs = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
									<?
									if ($num1 > 0) {
										echo $ot_admin_prs;
									?>&nbsp;<strong>/</strong>&nbsp;<?
											echo $ot_admin_hrs;
										}
											?>
								</td>
						<?


							}
						}

						?>
					</tr>
					<!--/// ot_admin_prs, ot_admin_hrs Night ///-->

					<!--/// ot_target Night ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF"><strong>Target Night shift</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Hrs.</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								//$bg_day = "#FFFFFF";
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT ot_target FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Night'";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$ot_target = $row1['ot_target'];
								} else {
									$ot_target = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
									<strong>
										<?= $ot_target ?>
									</strong></td>
						<?


							}
						}

						?>
					</tr>
					<!--/// ot_target Night ///-->

					<!--/// ot_actual Night ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF"><strong>Actual Night shift</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Hrs.</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								//$bg_day = "#FFFFFF";
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT ot_actual FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Night'";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$ot_actual = $row1['ot_actual'];
								} else {
									$ot_actual = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
									<strong>
										<?= $ot_actual ?>
									</strong></td>
						<?


							}
						}

						?>
					</tr>
					<!--/// ot_actual Night ///-->

					<!--/// OT Day+Night shift ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#8dffa6"><strong>Day+Night shift</strong></td>
						<td align="center" height="20" style="border-right:0px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong></strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
											
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


						?>
								<td align='center' style='border-right:0px solid; border-bottom:1px solid; color:#000000' bgcolor="">
									<strong>
										
									</strong>
								</td>
						<?


							}
						}

						?>
					</tr>
					<!--/// OT Day+Night shift ///-->

					<!--/// ot_target Day+Night ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF"><strong>Total Target</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Hrs.</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								//$bg_day = "#FFFFFF";
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT sum(ot_target) as ot_target FROM    $table_name where workdate ='" . $row0['workdate'] . "' ";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$ot_target = $row1['ot_target'];
								} else {
									$ot_target = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
									<strong>
										<?= $ot_target ?>
									</strong></td>
						<?


							}
						}

						?>
					</tr>
					<!--/// ot_target Day+Night ///-->

					<!--/// ot_actual Day+Night ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF"><strong>Total Actual</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Hrs.</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								//$bg_day = "#FFFFFF";
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT sum(ot_actual) as ot_actual  FROM    $table_name where workdate ='" . $row0['workdate'] . "' ";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$ot_actual = $row1['ot_actual'];
								} else {
									$ot_actual = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
									<strong>
										<?= $ot_actual ?>
									</strong></td>
						<?


							}
						}

						?>
					</tr>
					<!--/// ot_actual Day+Night ///-->

					<!--/// ot_achieve ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFF00"><strong>Status achieve</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#92D050">&nbsp;</td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

								$bg_day = "#FFE699";


								$select00 = "SELECT ot_actual FROM    $table_name where workdate ='" . $row0['workdate'] . "' ";
								$re00 =  mssql_query($select00);
								$num00 = mssql_num_rows($re00);

								$select1 = "SELECT sum(ot_target) as ot_target,sum(ot_actual) as ot_actual FROM    $table_name where workdate ='" . $row0['workdate'] . "' ";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num00 > 0) {
									$row1 = mssql_fetch_array($re1);
									if ($row1['ot_target'] >= $row1['ot_actual']) {
										$ot_achieve = "<font color='#00B050'>On</font>";
									} else if ($row1['ot_target'] < $row1['ot_actual']) {
										$ot_achieve = "<font color='#FF0000'>Not</font>";
									} else {
										$ot_achieve = '';
									}
								} else {
									$ot_achieve = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>"><strong>
										<a href="javascript:void(0)" onclick="show_ot('<?=$row0['workdate3']?>')">
										<?
										echo $ot_achieve;
										?>
										</a>
									</strong></td>
						<?


							}
						}

						?>
					</tr>
					<!--/// ot_achieve ///-->

					<!-- 5.Opertion performance -->
					<tr>
						<td height="20" colspan="2" align="left" bgcolor="#DBDBDB" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px"><strong>5.Opertion performance</strong><strong></strong></td>
						<?

						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						$qty_col = 0;
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								$qty_col++;
							}
						}
						?>
						<td align='center' colspan="<?= $qty_col ?>" bgcolor="#DBDBDB"></td>
						<?
						?>
					</tr>
					<tr>
						<td height="20" align="left" bgcolor="#FFFFFF" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px"><strong>5.1 Receive &amp; Put Away</strong><strong></strong></td>
						<td bgcolor="#FFFFFF" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid"></td>
						<?

						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#FFF' bgcolor="#595959"><strong>
										<?= date("d", strtotime($row0['workdate'])) ?>
									</strong></td>
						<?


							}
						}

						?>
					</tr>
					<!-- 5.Opertion performance -->

					<!--/// 5.Day shift ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#f9af00"><strong>Day shift</strong></td>
						<td align="center" height="20" style="border-right:0px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong></strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
											
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


						?>
								<td align='center' style='border-right:0px solid; border-bottom:1px solid; color:#000000' bgcolor="">
									<strong>
										
									</strong>
								</td>
						<?


							}
						}

						?>
					</tr>
					<!--/// 5.Day shift ///-->


					<!--/// per_receive_box  Day ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF">Receive</td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Box</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								//$bg_day = "#FFFFFF";
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT per_receive_box FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Day'";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$per_receive_box = $row1['per_receive_box'];
								} else {
									$per_receive_box = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
									<a href="javascript:void(0)" onclick="show_receive_box('<?=$row0['workdate3']?>','Day')">
									<strong>
										<?= $per_receive_box ?>
									</strong>
									</a>
								</td>
						<?


							}
						}

						?>
					</tr>
					<!--/// per_receive_box  Day ///-->

					<!--/// per_damage_box  Day ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px; padding-left:2px" bgcolor="#FFFFFF">Damage</td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Box</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								//$bg_day = "#FFFFFF";
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT per_damage_box FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Day'";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$per_damage_box = $row1['per_damage_box'];
								} else {
									$per_damage_box = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
									<a href="javascript:void(0)" onclick="show_damage_box('<?=$row0['workdate3']?>')">
									<strong>
										<?= $per_damage_box ?>
									</strong>
									</a>
								</td>
						<?


							}
						}

						?>
					</tr>
					<!--/// per_damage_box  Day ///-->

					<!--/// 5.Night shift ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#8de5ff"><strong>Night shift</strong></td>
						<td align="center" height="20" style="border-right:0px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong></strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
											
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


						?>
								<td align='center' style='border-right:0px solid; border-bottom:1px solid; color:#000000' bgcolor="">
									<strong>
										
									</strong>
								</td>
						<?


							}
						}

						?>
					</tr>
					<!--/// 5.Night shift ///-->
					<!--/// per_receive_box Night ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF">Receive</td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Box</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								//$bg_day = "#FFFFFF";
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT per_receive_box FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Night'";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$per_receive_box = $row1['per_receive_box'];
								} else {
									$per_receive_box = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
									<a href="javascript:void(0)" onclick="show_receive_box('<?=$row0['workdate3']?>','Night')">
									<strong>
										<?= $per_receive_box ?>
									</strong>
									</a>
								</td>
						<?


							}
						}

						?>
					</tr>
					<!--/// per_receive_box Night ///-->

					<!--/// per_damage_box  Night ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px; padding-left:2px" bgcolor="#FFFFFF">Damage</td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Box</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								//$bg_day = "#FFFFFF";
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT per_damage_box FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Night'";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$per_damage_box = $row1['per_damage_box'];
								} else {
									$per_damage_box = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
									<a href="javascript:void(0)" onclick="show_damage_box('<?=$row0['workdate3']?>')">
									<strong>
										<?= $per_damage_box ?>
									</strong>
									</a>
								</td>
						<?


							}
						}

						?>
					</tr>
					<!--/// per_damage_box  Night ///-->

					<!--/// Day+Night shift ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#8dffa6"><strong>Day+Night shift</strong></td>
						<td align="center" height="20" style="border-right:0px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong></strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
											
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


						?>
								<td align='center' style='border-right:0px solid; border-bottom:1px solid; color:#000000' bgcolor="">
									<strong>
										
									</strong>
								</td>
						<?


							}
						}

						?>
					</tr>
					<!--/// Day+Night shift ///-->

					<!--/// per_receive_box Day+Night ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF">Total Receive</td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Box</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								//$bg_day = "#FFFFFF";
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT sum(per_receive_box) as per_receive_box FROM    $table_name where workdate ='" . $row0['workdate'] . "' ";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$per_receive_box = $row1['per_receive_box'];
								} else {
									$per_receive_box = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
									<strong>
										<?= $per_receive_box ?>
									</strong>
								</td>
						<?


							}
						}

						?>
					</tr>
					<!--/// per_receive_box Day+Night ///-->

					<!--/// per_damage_box  Day+Night ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px; padding-left:2px" bgcolor="#FFFFFF">Total Damage</td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Box</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								//$bg_day = "#FFFFFF";
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT sum(per_damage_box) as per_damage_box FROM    $table_name where workdate ='" . $row0['workdate'] . "' ";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$per_damage_box = $row1['per_damage_box'];
								} else {
									$per_damage_box = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
									<strong>
										<?= $per_damage_box ?>
									</strong>
								</td>
						<?


							}
						}

						?>
					</tr>
					<!--/// per_damage_box  Day+Night ///-->
					
					<!-- 5.2 Issue performance -->
					<tr>
						<td height="20" align="left" bgcolor="#FFFFFF" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px"><strong>5.2 Issue performance (Box Management)</strong><strong></strong></td>
						<td bgcolor="#FFFFFF" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid"></td>
						<?

						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#FFF' bgcolor="#595959"><strong>
										<?= date("d", strtotime($row0['workdate'])) ?>
									</strong></td>
						<?


							}
						}

						?>
					</tr>
					<!-- 5.2 Issue performance -->

					<!--/// 5.2 Day shift ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#f9af00"><strong>Day shift</strong></td>
						<td align="center" height="20" style="border-right:0px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong></strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
											
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


						?>
								<td align='center' style='border-right:0px solid; border-bottom:1px solid; color:#000000' bgcolor="">
									<strong>
										
									</strong>
								</td>
						<?


							}
						}

						?>
					</tr>
					<!--/// 5.2 Day shift ///-->

					<!--/// issue_order_order, issue_order_box Day///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF">Order require</td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Order/Box</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								//$bg_day = "#FFFFFF";
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT issue_order_order, issue_order_box FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Day'";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								// echo $select1." ".$num1;
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$issue_order_order = $row1['issue_order_order'];
									$issue_order_box = $row1['issue_order_box'];
								} else {
									$issue_order_order = '';
									$issue_order_box = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
									<a href="javascript:void(0)" onclick="show_issue_order('<?=$row0['workdate3']?>','Day')">
									<?
									if ($issue_order_order != '') {
										echo $issue_order_order;
									?>&nbsp;<strong>/</strong>&nbsp;<?
										echo $issue_order_box;
									}
									?>
									</a>
								</td>
						<?


							}
						}

						?>
					</tr>
					<!--/// issue_order_order, issue_order_box Day///-->

					<!--/// issue_order_incomplete_order, issue_order_incomplete_box Day///-->
					<!-- <tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF">Order incomplete</td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Order/Box</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								//$bg_day = "#FFFFFF";
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT issue_order_incomplete_order, issue_order_incomplete_box FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Day'";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$issue_order_incomplete_order = $row1['issue_order_incomplete_order'];
									$issue_order_incomplete_box = $row1['issue_order_incomplete_box'];
								} else {
									$issue_order_incomplete_order = '';
									$issue_order_incomplete_box = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
									
									<?
									// echo $num1;
									if ($num1 > 0) {
										echo $issue_order_incomplete_order;
									?>&nbsp;<strong>/</strong>&nbsp;<?
										echo $issue_order_incomplete_box;
									}
									?>

								</td>
						<?


							}
						}

						?>
					</tr> -->
					<!--/// issue_order_incomplete_order, issue_order_incomplete_box Day///-->

					<!--/// issue_order_complete_order, issue_order_complete_box Day///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF">Order Issue</td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Order/Box</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								//$bg_day = "#FFFFFF";
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT issue_order_complete_order, issue_order_complete_box FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Day'";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$issue_order_complete_order = $row1['issue_order_complete_order'];
									$issue_order_complete_box = $row1['issue_order_complete_box'];
								} else {
									$issue_order_complete_order = '';
									$issue_order_complete_box = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
									<?
									if ($issue_order_complete_order != '') {
										echo $issue_order_complete_order;
									?>&nbsp;<strong>/</strong>&nbsp;<?
											echo $issue_order_complete_box;
										}
											?>
								</td>
						<?


							}
						}

						?>
					</tr>
					<!--/// issue_order_complete_order, issue_order_complete_box Day///-->

					<!--/// 5.2 Night shift ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#8de5ff"><strong>Night shift</strong></td>
						<td align="center" height="20" style="border-right:0px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong></strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
											
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


						?>
								<td align='center' style='border-right:0px solid; border-bottom:1px solid; color:#000000' bgcolor="">
									<strong>
										
									</strong>
								</td>
						<?


							}
						}

						?>
					</tr>
					<!--/// 5.2 Night shift ///-->

					<!--/// issue_order_order, issue_order_box Night///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF">Order require</td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Order/Box</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								//$bg_day = "#FFFFFF";
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT issue_order_order, issue_order_box FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Night'";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								// echo $select1." ".$num1;
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$issue_order_order = $row1['issue_order_order'];
									$issue_order_box = $row1['issue_order_box'];
								} else {
									$issue_order_order = '';
									$issue_order_box = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
									<a href="javascript:void(0)" onclick="show_issue_order('<?=$row0['workdate3']?>','Night')">
									<?
									if ($issue_order_order != '') {
										echo $issue_order_order;
									?>&nbsp;<strong>/</strong>&nbsp;<?
										echo $issue_order_box;
									}
									?>
									</a>
								</td>
						<?


							}
						}

						?>
					</tr>
					<!--/// issue_order_order, issue_order_box Night///-->

					<!--/// issue_order_incomplete_order, issue_order_incomplete_box Night///-->
					<!-- <tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF">Order incomplete</td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Order/Box</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								//$bg_day = "#FFFFFF";
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT issue_order_incomplete_order, issue_order_incomplete_box FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Night'";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$issue_order_incomplete_order = $row1['issue_order_incomplete_order'];
									$issue_order_incomplete_box = $row1['issue_order_incomplete_box'];
								} else {
									$issue_order_incomplete_order = '';
									$issue_order_incomplete_box = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
									
									<?
									// echo $num1;
									if ($num1 > 0) {
										echo $issue_order_incomplete_order;
									?>&nbsp;<strong>/</strong>&nbsp;<?
										echo $issue_order_incomplete_box;
									}
									?>

								</td>
						<?


							}
						}

						?>
					</tr> -->
					<!--/// issue_order_incomplete_order, issue_order_incomplete_box Night///-->

					<!--/// issue_order_complete_order, issue_order_complete_box Night///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF">Order Issue</td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Order/Box</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								//$bg_day = "#FFFFFF";
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT issue_order_complete_order, issue_order_complete_box FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Night'";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$issue_order_complete_order = $row1['issue_order_complete_order'];
									$issue_order_complete_box = $row1['issue_order_complete_box'];
								} else {
									$issue_order_complete_order = '';
									$issue_order_complete_box = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
									<?
									if ($issue_order_complete_order != '') {
										echo $issue_order_complete_order;
									?>&nbsp;<strong>/</strong>&nbsp;<?
											echo $issue_order_complete_box;
										}
											?>
								</td>
						<?


							}
						}

						?>
					</tr>
					<!--/// issue_order_complete_order, issue_order_complete_box Night///-->
					
					<!--/// Day+Night shift ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#8dffa6"><strong>Day+Night shift</strong></td>
						<td align="center" height="20" style="border-right:0px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong></strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
											
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


						?>
								<td align='center' style='border-right:0px solid; border-bottom:1px solid; color:#000000' bgcolor="">
									<strong>
										
									</strong>
								</td>
						<?


							}
						}

						?>
					</tr>
					<!--/// Day+Night shift ///-->
					
					<!--/// issue_order_order, issue_order_box Day+Night///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF">Total Order require</td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Order/Box</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								//$bg_day = "#FFFFFF";
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT sum(issue_order_order) as issue_order_order, sum(issue_order_box) as issue_order_box FROM    $table_name where workdate ='" . $row0['workdate'] . "' ";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								// echo $select1." ".$num1;
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$issue_order_order = $row1['issue_order_order'];
									$issue_order_box = $row1['issue_order_box'];
								} else {
									$issue_order_order = '';
									$issue_order_box = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
									<a href="javascript:void(0)" onclick="show_issue_order('<?=$row0['workdate3']?>','Night')">
									<?
									if ($issue_order_order != '') {
										echo $issue_order_order;
									?>&nbsp;<strong>/</strong>&nbsp;<?
										echo $issue_order_box;
									}
									?>
									</a>
								</td>
						<?


							}
						}

						?>
					</tr>
					<!--/// issue_order_order, issue_order_box Day+Night///-->

					<!--/// issue_order_incomplete_order, issue_order_incomplete_box Day+Night///-->
					<!-- <tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF">Total Order incomplete</td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Order/Box</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								//$bg_day = "#FFFFFF";
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT sum(issue_order_incomplete_order) as issue_order_incomplete_order, sum(issue_order_incomplete_box) as issue_order_incomplete_box FROM    $table_name where workdate ='" . $row0['workdate'] . "' ";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$issue_order_incomplete_order = $row1['issue_order_incomplete_order'];
									$issue_order_incomplete_box = $row1['issue_order_incomplete_box'];
								} else {
									$issue_order_incomplete_order = '';
									$issue_order_incomplete_box = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
									
									<?
									// echo $num1;
									if ($num1 > 0) {
										echo $issue_order_incomplete_order;
									?>&nbsp;<strong>/</strong>&nbsp;<?
										echo $issue_order_incomplete_box;
									}
									?>

								</td>
						<?


							}
						}

						?>
					</tr> -->
					<!--/// issue_order_incomplete_order, issue_order_incomplete_box Day+Night///-->

					<!--/// issue_order_complete_order, issue_order_complete_box Day+Night///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF">Total Order Issue</td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Order/Box</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								//$bg_day = "#FFFFFF";
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT sum(issue_order_complete_order) as issue_order_complete_order, sum(issue_order_complete_box) as issue_order_complete_box FROM    $table_name where workdate ='" . $row0['workdate'] . "' ";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$issue_order_complete_order = $row1['issue_order_complete_order'];
									$issue_order_complete_box = $row1['issue_order_complete_box'];
								} else {
									$issue_order_complete_order = '';
									$issue_order_complete_box = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
									<?
									if ($issue_order_complete_order != '') {
										echo $issue_order_complete_order;
									?>&nbsp;<strong>/</strong>&nbsp;<?
											echo $issue_order_complete_box;
										}
											?>
								</td>
						<?


							}
						}

						?>
					</tr>
					<!--/// issue_order_complete_order, issue_order_complete_box Day+Night///-->

					
					
					<!--///issue_performance_order, issue_performance_box Day+Night///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFF00"><strong>Result Performance</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#92D050"><strong>%</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								$bg_day = "#FFE699";
								//if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
								//					$bg_day = "#FFFF00";
								//				}else{
								//					$bg_day = "#FFFFFF";
								//					}

								// $select1 = "SELECT (sum(issue_order_complete_order)* 100 / (Select sum(issue_order_order) From $table_name where workdate ='" . $row0['workdate'] . "')) as issue_performance_order
								// , (sum(issue_order_complete_box)* 100 / (Select sum(issue_order_box) From $table_name where workdate ='" . $row0['workdate'] . "')) as issue_performance_box
								// FROM    $table_name where workdate ='" . $row0['workdate'] . "' ";

								$select1 = "SELECT (sum(issue_order_complete_order)* 100 / (Select sum(issue_order_order) From $table_name where workdate ='" . $row0['workdate'] . "')) as issue_performance_order
								, (sum(issue_order_complete_box)* 100 / (Select sum(issue_order_box) From $table_name where workdate ='" . $row0['workdate'] . "')) as issue_performance_box
								FROM    $table_name where workdate ='" . $row0['workdate'] . "' ";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$issue_performance_order = $row1['issue_performance_order'];
									$issue_performance_box = $row1['issue_performance_box'];
								} else {
									$issue_performance_order = '';
									$issue_performance_box = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
									<?
									if ($issue_performance_order != '') {
										echo $issue_performance_order;
									?>&nbsp;<strong>/</strong>&nbsp;<?
											echo $issue_performance_box;
										}
									?>
								</td>
						<?


							}
						}

						?>
					</tr>
					<!--/// issue_performance_order, issue_performance_box Day+Night///-->

					
					
					<tr>
						<td height="20" align="left" bgcolor="#FFFFFF" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px"><strong>5.3 Quality</strong><strong></strong></td>
						<td bgcolor="#FFFFFF" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid"></td>
						<?

						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#FFF' bgcolor="#595959"><strong>
										<?= date("d", strtotime($row0['workdate'])) ?>
									</strong></td>
						<?


							}
						}

						?>
					</tr>

					<!--/// qa_partinbox_cus ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF">5.3.1 Part in box from customer</td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Box</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								//$bg_day = "#FFFFFF";
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT sum(qa_partinbox_cus) as qa_partinbox_cus FROM    $table_name where workdate ='" . $row0['workdate'] . "' ";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$qa_partinbox_cus = $row1['qa_partinbox_cus'];
								} else {
									$qa_partinbox_cus = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
									<a href="javascript:void(0)" onclick="show_partinbox_cus('<?=$row0['workdate3']?>')">
									<strong>
										<?= $qa_partinbox_cus ?>
									</strong>
									</a>
								</td>
						<?


							}
						}

						?>
					</tr>
					<!--/// qa_partinbox_cus ///-->

					<!--/// qa_partinbox_ipack ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF">5.3.2 Part in box from IPACK</td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Box</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								//$bg_day = "#FFFFFF";
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT sum(qa_partinbox_ipack) as qa_partinbox_ipack FROM    $table_name where workdate ='" . $row0['workdate'] . "' ";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$qa_partinbox_ipack = $row1['qa_partinbox_ipack'];
								} else {
									$qa_partinbox_ipack = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">

									<strong>
										<?= $qa_partinbox_ipack ?>
									</strong></td>
						<?


							}
						}

						?>
					</tr>
					<!--/// qa_partinbox_ipack ///-->

					<!--/// qa_westbox_ipack ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF">5.3.3 Wast box,West Box from IPACK</td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Box</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								//$bg_day = "#FFFFFF";
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT sum(qa_westbox_ipack) as qa_westbox_ipack FROM    $table_name where workdate ='" . $row0['workdate'] . "' ";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$qa_westbox_ipack = $row1['qa_westbox_ipack'];
								} else {
									$qa_westbox_ipack = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">

									<strong>
										<?= $qa_westbox_ipack ?>
									</strong></td>
						<?


							}
						}

						?>
					</tr>
					<!--/// qa_westbox_ipack ///-->

					<!--/// qa_result ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFF00"><strong>Result Performance</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#92D050"><strong></strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								$bg_day = "#FFE699";

								$select1 = "SELECT qa_result FROM    $table_name where workdate ='" . $row0['workdate'] . "' ";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);


									if ($row1['qa_result'] == 'OK') {
										$qa_result = "<font color='#00B050'>" . $row1['qa_result'] . "</font>";
									} else if ($row1['qa_result'] == 'NG') {
										//$qa_result = $row1['qa_result'];
										$qa_result = "<font color='#FF0000'>" . $row1['qa_result'] . "</font>";
									} else {
										$qa_result = '';
									}
								} else {
									$qa_result = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>"><strong>
										<?
										echo $qa_result;

										?>
									</strong></td>
						<?


							}
						}

						?>
					</tr>
					<!--/// qa_result ///-->


					<tr>
						<td height="20" align="left" bgcolor="#FFFFFF" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px"><strong>5.4 Receive &amp; Put Away (VMI : Project)</strong><strong></strong></td>
						<td bgcolor="#FFFFFF" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid"></td>
						<?

						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#FFF' bgcolor="#595959"><strong>
										<?= date("d", strtotime($row0['workdate'])) ?>
									</strong></td>
						<?


							}
						}

						?>
					</tr>


					<!--/// per_receive_box_vmi ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF">Receive</td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Pcs.</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								//$bg_day = "#FFFFFF";
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT per_receive_box_vmi FROM    $table_name where workdate ='" . $row0['workdate'] . "' ";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$per_receive_box_vmi = $row1['per_receive_box_vmi'];
								} else {
									$per_receive_box_vmi = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
									<a href="javascript:void(0)" onclick="show_receive_box_vmi('<?=$row0['workdate3']?>')">
									<strong>
										<?= $per_receive_box_vmi ?>
									</strong>
									</a>
								</td>
						<?


							}
						}

						?>
					</tr>
					<!--/// per_receive_box_vmi ///-->

					<!--/// per_hold_box_vmi ///-->
					<!-- <tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF"><strong>5.4.2 Hold</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Pcs.</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								//$bg_day = "#FFFFFF";
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT per_hold_box_vmi FROM    $table_name where workdate ='" . $row0['workdate'] . "' ";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$per_hold_box_vmi = $row1['per_hold_box_vmi'];
								} else {
									$per_hold_box_vmi = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
									<a href="javascript:void(0)" onclick="show_hold_box_vmi('<?=$row0['workdate3']?>')">
									<strong>
										<?= $per_hold_box_vmi ?>
									</strong>
									</a>
								</td>
						<?


							}
						}

						?>
					</tr> -->
					<!--/// per_hold_box_vmi ///-->

					<!--/// per_damage_box_vmi ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF">Damage</td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Pcs.</strong></td>
						<?
						$select0 = "SELECT *,
			convert(varchar, workdate, 101)as  workdate2,
			convert(varchar, workdate, 103)as  workdate3
			
	FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								//$bg_day = "#FFFFFF";
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT per_damage_box_vmi FROM    $table_name where workdate ='" . $row0['workdate'] . "' ";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$per_damage_box_vmi = $row1['per_damage_box_vmi'];
								} else {
									$per_damage_box_vmi = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
									<a href="javascript:void(0)" onclick="show_damage_box_vmi('<?=$row0['workdate3']?>')">
									<strong>
										<?= $per_damage_box_vmi ?>
									</strong>
									</a>
								</td>
						<?


							}
						}

						?>
					</tr>
					<!--/// per_damage_box_vmi ///-->



					<tr>
						<td height="20" align="left" bgcolor="#FFFFFF" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px"><strong>5.5 Issue performance (VMI : Project)</strong><strong></strong></td>
						<td bgcolor="#FFFFFF" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid"></td>
						<?

						$select0 = "SELECT *,
			convert(varchar, workdate, 101)as  workdate2,
			convert(varchar, workdate, 103)as  workdate3
			
	FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#FFF' bgcolor="#595959"><strong>
										<?= date("d", strtotime($row0['workdate'])) ?>
									</strong></td>
						<?


							}
						}

						?>
					</tr>


					<!--/// issue_order_order_vmi, issue_order_box_vmi ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF">Order require</td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Order/Pcs.</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								//$bg_day = "#FFFFFF";
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT sum(issue_order_order_vmi) as issue_order_order_vmi, sum(issue_order_box_vmi) as issue_order_box_vmi FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Day' ";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$issue_order_order_vmi = $row1['issue_order_order_vmi'];
									$issue_order_box_vmi = $row1['issue_order_box_vmi'];
								} else {
									$issue_order_order_vmi = '';
									$issue_order_box_vmi = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
									<a href="javascript:void(0)" onclick="show_issue_order_vmi('<?=$row0['workdate3']?>')">
									<?
									if ($issue_order_order_vmi != '') {
										echo $issue_order_order_vmi;
									?>&nbsp;<strong>/</strong>&nbsp;<?
										echo $issue_order_box_vmi;
									}
									?>
									</a>
								</td>
						<?


							}
						}

						?>
					</tr>
					<!--/// issue_order_order_vmi, issue_order_box_vmi ///-->

					<!--/// issue_order_incomplete_order_vmi, issue_order_incomplete_box_vmi ///-->
					<!-- <tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF">Order incomplete</td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Order/Pcs.</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								//$bg_day = "#FFFFFF";
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select22 = "SELECT issue_order_incomplete_order_vmi
								FROM  $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Day'";
								$res22 = mssql_query($select22);
								$num22 = mssql_num_rows($res22);


								$select1 = "SELECT 
								sum(issue_order_incomplete_order_vmi) as aa, 
								sum(issue_order_incomplete_box_vmi) as issue_order_incomplete_box_vmi
								FROM  $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Day'";

								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$issue_order_incomplete_order_vmi = $row1['aa'];
									$issue_order_incomplete_box_vmi = $row1['issue_order_incomplete_box_vmi'];
									//echo ">".$row1['issue_order_incomplete_order_vmi'];

								} else {
									$issue_order_incomplete_order_vmi = '';
									$issue_order_incomplete_box_vmi = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
									<?
									//echo $select1;
									if ($num22 > 0) {
										echo $issue_order_incomplete_order_vmi;
									?>&nbsp;<strong>/</strong>&nbsp;<?
											echo $issue_order_incomplete_box_vmi;
										}
											?>

								</td>
						<?


							}
						}

						?>
					</tr> -->
					<!--/// issue_order_incomplete_order_vmi, issue_order_incomplete_box_vmi ///-->

					<!--/// issue_order_complete_order_vmi, issue_order_complete_box_vmi ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF">Order Issue</td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Order/Pcs.</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								//$bg_day = "#FFFFFF";
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT sum(issue_order_complete_order_vmi) as issue_order_complete_order_vmi, sum(issue_order_complete_box_vmi) as issue_order_complete_box_vmi FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Day' ";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$issue_order_complete_order_vmi = $row1['issue_order_complete_order_vmi'];
									$issue_order_complete_box_vmi = $row1['issue_order_complete_box_vmi'];
								} else {
									$issue_order_complete_order_vmi = '';
									$issue_order_complete_box_vmi = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
									<?
									if ($issue_order_complete_order_vmi != '') {
										echo $issue_order_complete_order_vmi;
									?>&nbsp;<strong>/</strong>&nbsp;<?
											echo $issue_order_complete_box_vmi;
										}
											?>

								</td>
						<?


							}
						}

						?>
					</tr>
					<!--/// issue_order_complete_order_vmi, issue_order_complete_box_vmi ///-->

					<!--///issue_performance_order_vmi, issue_performance_box_vmi ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFF00"><strong>Result Performance</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#92D050"><strong>%</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								$bg_day = "#FFE699";
								//if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
								//					$bg_day = "#FFFF00";
								//				}else{
								//					$bg_day = "#FFFFFF";
								//					}


								$select1 = "SELECT sum(issue_performance_order_vmi) as issue_performance_order_vmi, sum(issue_performance_box_vmi) as issue_performance_box_vmi FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Day'";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$issue_performance_order_vmi = $row1['issue_performance_order_vmi'];
									$issue_performance_box_vmi = $row1['issue_performance_box_vmi'];
								} else {
									$issue_performance_order_vmi = '';
									$issue_performance_box_vmi = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
									<?
									if ($issue_performance_order_vmi != '') {
										echo $issue_performance_order_vmi;
									?>&nbsp;<strong>/</strong>&nbsp;<?
											echo $issue_performance_box_vmi;
										}
											?>

								</td>
						<?


							}
						}

						?>
					</tr>
					<!--/// issue_performance_order_vmi, issue_performance_box_vmi ///-->
                    
					<tr>
						<td height="20" align="left" bgcolor="#FFFFFF" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px"><strong>5.6 Issue performance (Packing)</strong></td>
						<td bgcolor="#FFFFFF" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid"></td>
						<?

						$select0 = "SELECT *,
			convert(varchar, workdate, 101)as  workdate2,
			convert(varchar, workdate, 103)as  workdate3
			
	FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#FFF' bgcolor="#595959"><strong>
										<?= date("d", strtotime($row0['workdate'])) ?>
									</strong></td>
						<?


							}
						}

						?>
					</tr>
                    
                    <!--order_packing-->
                    <tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF">Total Order on SAP (Spare part)</td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Pcs.</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								//$bg_day = "#FFFFFF";
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT order_packing FROM    $table_name where workdate ='" . $row0['workdate'] . "' ";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$order_packing = $row1['order_packing'];
								} else {
									$order_packing = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
									<a href="javascript:void(0)">
									<strong>
										<?= $order_packing ?>
									</strong>
									</a>
								</td>
						<?


							}
						}

						?>
					</tr>
                    <!--order_packing-->
                    
                    <!--order_complete_packing-->
                    <tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF">Total Order Packing Complete (Spare part)</td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Pcs.</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								//$bg_day = "#FFFFFF";
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT order_complete_packing FROM    $table_name where workdate ='" . $row0['workdate'] . "' ";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$order_complete_packing = $row1['order_complete_packing'];
								} else {
									$order_complete_packing = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
									<a href="javascript:void(0)">
									<strong>
										<?= $order_complete_packing ?>
									</strong>
									</a>
								</td>
						<?


							}
						}

						?>
					</tr>
                    <!--order_complete_packing-->
                    
                    <!--order_delivery_packing-->
                    <tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF">Total Order Delivery to DL (Spare part)</td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Pcs.</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								//$bg_day = "#FFFFFF";
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT order_delivery_packing FROM    $table_name where workdate ='" . $row0['workdate'] . "' ";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$order_delivery_packing = $row1['order_delivery_packing'];
								} else {
									$order_delivery_packing = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
									<a href="javascript:void(0)" >
									<strong>
										<?= $order_delivery_packing ?>
									</strong>
									</a>
								</td>
						<?


							}
						}

						?>
					</tr>
                    <!--order_delivery_packing-->
                    <!--order_performance_packing-->
                    <tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFF00"><strong>Result Performance (Spare part)</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#92D050"><strong>%</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								$bg_day = "#FFE699";
								//if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
								//					$bg_day = "#FFFF00";
								//				}else{
								//					$bg_day = "#FFFFFF";
								//					}


								$select1 = "SELECT sum(order_performance_packing) as order_performance_packing, sum(order_performance_packing_export) as order_performance_packing_export FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Day'";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$order_performance_packing = $row1['order_performance_packing'];
									$order_performance_packing_export = $row1['order_performance_packing_export'];
								} else {
									$order_performance_packing = '';
									$order_performance_packing_export = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
									<?
									echo $order_performance_packing;
									
											?>

								</td>
						<?


							}
						}

						?>
					</tr>
                    <!--order_performance_packing-->
                    
         		  <!--order_packing_export-->
                    <tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF">Total Order on SAP (Export)</td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Pcs.</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								//$bg_day = "#FFFFFF";
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT order_packing_export FROM    $table_name where workdate ='" . $row0['workdate'] . "' ";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$order_packing_export = $row1['order_packing_export'];
								} else {
									$order_packing_export = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
									<a href="javascript:void(0)">
									<strong>
										<?= $order_packing_export ?>
									</strong>
									</a>
								</td>
						<?


							}
						}

						?>
					</tr>
        		  <!--order_packing_export-->
                    
                   <!--order_complete_packing_export-->
                    <tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF">Total Order Packing Complete (Export)</td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Pcs.</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								//$bg_day = "#FFFFFF";
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT order_complete_packing_export FROM    $table_name where workdate ='" . $row0['workdate'] . "' ";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$order_complete_packing_export = $row1['order_complete_packing_export'];
								} else {
									$order_complete_packing_export = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
									<a href="javascript:void(0)">
									<strong>
										<?= $order_complete_packing_export ?>
									</strong>
									</a>
								</td>
						<?


							}
						}

						?>
					</tr>
                   <!--order_complete_packing_export-->
                    
                    <!--order_delivery_packing_export-->
                    <tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF">Total Order Delivery to DL (Export)</td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Pcs.</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								//$bg_day = "#FFFFFF";
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT order_delivery_packing_export FROM    $table_name where workdate ='" . $row0['workdate'] . "' ";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$order_delivery_packing_export = $row1['order_delivery_packing_export'];
								} else {
									$order_delivery_packing_export = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
									<a href="javascript:void(0)" >
									<strong>
										<?= $order_delivery_packing_export ?>
									</strong>
									</a>
								</td>
						<?


							}
						}

						?>
					</tr>
                    <!--order_delivery_packing_export-->
                    <!--order_performance_packing_export-->
                    <tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFF00"><strong>Result Performance (Export)</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#92D050"><strong>%</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								$bg_day = "#FFE699";
								//if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
								//					$bg_day = "#FFFF00";
								//				}else{
								//					$bg_day = "#FFFFFF";
								//					}


								$select1 = "SELECT sum(order_performance_packing) as order_performance_packing, sum(order_performance_packing_export) as order_performance_packing_export FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Day'";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$order_performance_packing = $row1['order_performance_packing'];
									$order_performance_packing_export = $row1['order_performance_packing_export'];
								} else {
									$order_performance_packing = '';
									$order_performance_packing_export = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
									<?
									echo $order_performance_packing_export;
											?>

								</td>
						<?


							}
						}

						?>
					</tr>
                    <!--order_performance_packing_export-->
				</table>

				<HR>

				<div class="row equal" style="margin-left:0px; margin-right:0px">
					<div class="col-md-12">
						<table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'">
							<tr>
								<td height="20" bgcolor="#FFFF00" style="padding-left:2px"><strong>6. Key activity</strong></td>
							</tr>
						</table>
					</div>
					<div class="col-md-6">
						<table width="100%" cellspacing="0" cellpadding="0">
							<tr>
								<td width="559" height="25" colspan="6" align="center" bgcolor="#FF0000" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><strong>
										<font color="#FFFFFF">Internal quality Problem</font>
									</strong></td>
							</tr>
							<tr>
								<td height="25" align="center" bgcolor="#FF0000" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><strong>
										<font color="#FFFFFF">Date</font>
									</strong></td>
								<td align="center" bgcolor="#FF0000" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><strong>
										<font color="#FFFFFF">Problem</font>
									</strong></td>
								<td align="center" bgcolor="#FF0000" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><strong>
										<font color="#FFFFFF">From Customer</font>
									</strong></td>

								<td align="center" bgcolor="#FF0000" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><strong>
										<font color="#FFFFFF">PIC</font>
									</strong></td>
								<td align="center" bgcolor="#FF0000" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><strong>
										<font color="#FFFFFF">Due date</font>
									</strong></td>
							</tr>
							<?
							$selectp = "select CONVERT(nvarchar, due_problem, 103) as due_problem,* from tbdaily_report_activity_external_problem where date_problem between '$startdate' and '$enddate' and site='TSC'";

							$rep = mssql_query($selectp);
							$nump = mssql_num_rows($rep);
							if ($nump > 0) {
								$ip = 0;
								while ($rowp = mssql_fetch_array($rep)) {
									$ip++;
							?>
									<tr align="center">
										<td height="25" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><?= $ip ?></td>
										<td style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><?= lang_thai_from_database($rowp['topic_problem']) ?></td>
										<td style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><?= lang_thai_from_database($rowp['customer_problem']) ?></td>
										<td style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><?= lang_thai_from_database($rowp['pic_problem']) ?></td>

										<td style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><?= $rowp['due_problem'] ?></td>
									</tr>
							<?
								}
							}
							?>

						</table>
					</div>
					<div class="col-md-6">
						<table width="100%" cellspacing="0" cellpadding="0">
							<tr>
								<td width="559" height="25" colspan="9" align="center" bgcolor="#00B050" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><strong>
										<font color="#FFFFFF">Inventory</font>
									</strong></td>
							</tr>
							<tr>
								<td height="25" align="center" bgcolor="#00B050" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><strong>
										<font color="#FFFFFF">Plan count date</font>
									</strong></td>
								<td align="center" bgcolor="#ffffff" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><strong>
										<font color="#000000">Item</font>
									</strong></td>
								<td align="center" bgcolor="#ffffff" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><strong>
										<font color="#000000">System</font>
									</strong></td>

								<td align="center" bgcolor="#ffffff" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><strong>
										<font color="#000000">Actual</font>
									</strong></td>
								<td align="center" bgcolor="#ffffff" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><strong>Diff</strong></td>
								<td align="center" bgcolor="#ffffff" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><strong>% Accuracy</strong></td>
								<td align="center" bgcolor="#ffffff" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><strong>Actual Date</strong></td>
								<td align="center" bgcolor="#ffffff" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><strong>
										<font color="#000000">Status</font>
									</strong></td>
							</tr>
							<?
							$selectp = "select CONVERT(nvarchar, plan_count_date, 103) as plan_count_datedate,
					CONVERT(nvarchar, actual_date, 103) as actual_datedate
					,* from tbdaily_report_tsc_inventory where plan_count_date between '$startdate' and '$enddate' order by  plan_count_date asc";

							$rep = mssql_query($selectp);
							$nump = mssql_num_rows($rep);
							if ($nump > 0) {
								$ip = 0;
								while ($rowp = mssql_fetch_array($rep)) {
									$ip++;

							?>
									<tr align="center">
										<td height="25" bgcolor="#00B050" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><strong>
												<font color="#FFFFFF"><?= $rowp['plan_count_datedate'] ?></font>
											</strong></td>
										<td style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><?= $rowp['item'] ?></td>
										<td style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><?= $rowp['system'] ?></td>
										<td style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><?= $rowp['actual'] ?></td>
										<td style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><?= $rowp['diff'] ?></td>
										<td style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><?= $rowp['accuracy'] ?></td>
										<td style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><?= $rowp['actual_datedate'] ?></td>

										<td style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><?= $rowp['status_inventory'] ?></td>
									</tr>
							<?
								}
							}
							?>

						</table>
					</div>
				</div>
				<div class="row equal" style="margin-left:0px; margin-right:0px">

					<div class="col-md-6">
						<table width="100%" cellspacing="0" cellpadding="0">
							<tr>
								<td height="25" colspan="6" align="center" bgcolor="#C6E0B4" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><strong>
										<font color="#000000">5S. Monthly audit</font>
									</strong></td>
							</tr>
							<tr bgcolor="#C6E0B4">
								<td width="131" height="25" align="center" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><strong>
										<font color="#000000">Month</font>
									</strong></td>
								<td width="253" align="center" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><strong>
										<font color="#000000">Audit Date</font>
									</strong></td>
								<td width="270" align="center" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><strong>
										<font color="#000000">Team</font>
									</strong></td>

								<td width="275" align="center" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><strong>
										<font color="#000000">Score</font>
									</strong></td>

							</tr>
							<?
							$selectp = "select CONVERT(nvarchar, date_audit, 103) as date_auditdate,* from tbdaily_report_activity_5s_audit where date_audit between '$startdate' and '$enddate' and site='TSC'";

							$rep = mssql_query($selectp);
							$nump = mssql_num_rows($rep);
							if ($nump > 0) {
								$ip = 0;
								while ($rowp = mssql_fetch_array($rep)) {
									$ip++;
							?>
									<tr align="center">
										<td height="25" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><?
																																							//$monthName = date('F', mktime(0, 0, 0, $monthNum, 10)); // March
																																							echo date("F", strtotime($rowp['date_audit']));
																																							?></td>
										<td style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><?= $rowp['date_auditdate'] ?></td>
										<td style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><?= $rowp['team_audit'] ?></td>
										<td style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><?= $rowp['score_audit'] ?></td>


									</tr>
							<?
								}
							}

							?>
						</table>
						<table width="100%" cellspacing="0" cellpadding="0">

							<tr>
								<td height="25" colspan="2" align="center" bgcolor="#C6E0B4" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><strong>
										<font color="#000000">Last audit comment</font>
									</strong></td>
							</tr>

							<?
							$pre_month_year = date("m/1/Y", strtotime("$mmonth/1/$yyear -1 month"));
							$deceased_month = date("m",strtotime($pre_month_year));
							$deceased_year = date("Y",strtotime($pre_month_year));
							$selectp = "SELECT CONVERT(nvarchar, date_audit, 103) as date_auditdate,* 
							from tbdaily_report_activity_5s_audit_comment where site='$tsite' AND Month(date_audit)='$deceased_month' AND YEAR(date_audit)='$deceased_year' order by date_audit desc";

							$rep = mssql_query($selectp);
							$nump = mssql_num_rows($rep);
							if ($nump > 0) {
								$ip = 0;
								while ($rowp = mssql_fetch_array($rep)) {
									$ip++;
							?>
									<tr align="center">
										<td width="29%" height="25" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><?= $rowp['date_auditdate'] ?></td>
										<td width="71%" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><?= lang_thai_from_database($rowp['comment_audit']) ?></td>
									</tr>
							<?
								}
							}
							?>

						</table>
					</div>
					<div class="col-md-6">
						<table width="100%" cellspacing="0" cellpadding="0">
							<tr>
								<td height="25" colspan="6" align="center" bgcolor="#9BC2E6" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><strong>
										<font color="#000000">Improvement</font>
									</strong></td>
							</tr>
							<tr>
								<td width="96" height="25" align="center" bgcolor="#9BC2E6" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><strong>
										<font color="#000000">Month</font>
									</strong></td>
								<td width="424" align="center" bgcolor="#FFFFFF" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><strong>
										<font color="#000000">Topic</font>
									</strong></td>
								<td width="96" align="center" bgcolor="#FFFFFF" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><strong>
										<font color="#000000">Status</font>
									</strong></td>

								<td width="123" align="center" bgcolor="#FFFFFF" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><strong>
										<font color="#000000">PIC</font>
									</strong></td>
								<td width="190" align="center" bgcolor="#FFFFFF" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><strong>
										<font color="#000000">Due date</font>
									</strong></td>
							</tr>
							<?
							$selectp = "select CONVERT(nvarchar, month_improve, 103) as month_improvedate,
					 CONVERT(nvarchar, due_improve, 103) as due_improvedate,
					* from tbdaily_report_activity_improvement where month_improve between '$startdate' and '$enddate' and site='TSC'";

							$rep = mssql_query($selectp);
							$nump = mssql_num_rows($rep);
							if ($nump > 0) {
								$ip = 0;
								while ($rowp = mssql_fetch_array($rep)) {
									$ip++;
							?>
									<tr align="center">
										<td height="25" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><?
																																							echo date("F", strtotime($rowp['month_improve']));
																																							?></td>
										<td style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><?= lang_thai_from_database($rowp['topic_improve']) ?></td>
										<td style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><?= lang_thai_from_database($rowp['status_improve']) ?></td>
										<td style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><?= lang_thai_from_database($rowp['pic_improve']) ?></td>

										<td style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><?= $rowp['due_improvedate'] ?></td>
									</tr>
							<?
								}
							}
							?>

						</table>
					</div>
				</div>
				<div class="row equal" style="margin-left:0px; margin-right:0px">
					<div class="col-md-12">
						<table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'">
							<tr>
								<td height="20" bgcolor="#FFFF00"><strong>7. Morning Meeting</strong></td>
							</tr>
						</table>
					</div>
					<div class="col-md-6">

						<table width="100%" cellspacing="0" cellpadding="0">
							<tr>
								<td height="25" colspan="8" align="center" bgcolor="#19C3FF" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><strong>
										<font color="#000000">Morning Meeting in&nbsp;<?
																						echo date("F", strtotime($startdate));
																						echo "&nbsp;";
																						echo $yyear;
																						?></font>
									</strong></td>
							</tr>
							<tr>
								<td width="96" height="25" align="center" bgcolor="#19C3FF" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><strong>
										<font color="#000000">Date</font>
									</strong></td>
								<td width="424" align="center" bgcolor="#FFFFFF" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><strong>Day Name</strong></td>
								<td width="424" align="center" bgcolor="#FFFFFF" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><strong>Type</strong></td>
								<td width="424" align="center" bgcolor="#FFFFFF" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><strong>
										<font color="#000000">Detail Information</font>
									</strong></td>
								<td width="96" align="center" bgcolor="#FFFFFF" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><strong>
										<font color="#000000">Status</font>
									</strong></td>



							</tr>
							<?
							$selectp = "select CONVERT(nvarchar, report_date, 103) as report_datedate,
					* from tbdaily_report_morning_meeting where report_date between '$startdate' and '$enddate' and site='TSC'
					order by report_date desc";

							$rep = mssql_query($selectp);
							$nump = mssql_num_rows($rep);
							if ($nump > 0) {
								$ip = 0;
								while ($rowp = mssql_fetch_array($rep)) {
									$ip++;

									if ($rowp['status_meeting'] == 'On progress') {
										$bg_status = "#FFFF00";
									}else if ($rowp['status_meeting'] == 'Complete') {
										$bg_status = "#00B050";
									}else if ($rowp['status_meeting'] == 'Delay') {
										$bg_status = "#FF0000";
									}else {
										$bg_status = "#FF0000";
									}

									#FFFF00
							?>
									<tr align="center">
										<td height="25" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><?
																																							echo $rowp['report_datedate'];
																																							?></td>
										<td style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><?
																																				echo date("D", strtotime($rowp['report_date']));
																																				?></td>
										<td style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><?= $rowp['type_meeting'] ?></td>
										<td style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><?= lang_thai_from_database($rowp['detail_meeting']) ?></td>
										<td style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'" bgcolor="<?= $bg_status ?>"><?= $rowp['status_meeting'] ?></td>

									</tr>
							<?
								}
							}
							?>

						</table>
					</div>
					<div class="col-md-6">
						<table width="100%" cellspacing="0" cellpadding="0">
							<tr>
								<td height="25" colspan="8" align="center" bgcolor="#FF9900" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><strong>
										<font color="#000000">Morning Meeting Delay Job</font>
									</strong></td>
							</tr>
							<tr>
								<td width="96" height="25" align="center" bgcolor="#FF9900" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><strong>
										<font color="#000000">Date</font>
									</strong></td>
								<td width="424" align="center" bgcolor="#FFFFFF" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><strong>Day Name</strong></td>
								<td width="424" align="center" bgcolor="#FFFFFF" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><strong>Type</strong></td>
								<td width="424" align="center" bgcolor="#FFFFFF" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><strong>
										<font color="#000000">Detail Information</font>
									</strong></td>
								<td width="96" align="center" bgcolor="#FFFFFF" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><strong>
										<font color="#000000">Status</font>
									</strong></td>



							</tr>
							<?
							$selectp = "select CONVERT(nvarchar, report_date, 103) as report_datedate,
					* from tbdaily_report_morning_meeting where report_date < '$startdate'  and site='TSC' and status_meeting not in('Complete')
					order by report_date desc";

							$rep = mssql_query($selectp);
							$nump = mssql_num_rows($rep);
							if ($nump > 0) {
								$ip = 0;
								while ($rowp = mssql_fetch_array($rep)) {
									$ip++;

									if ($rowp['status_meeting'] == 'On progress') {
										$bg_status = "#FFFF00";
									}else if ($rowp['status_meeting'] == 'Complete') {
										$bg_status = "#00B050";
									}else if ($rowp['status_meeting'] == 'Delay') {
										$bg_status = "#FF0000";
									}else {
										$bg_status = "#FF0000";
									}

									#FFFF00
							?>
									<tr align="center">
										<td height="25" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><?
																																							echo $rowp['report_datedate'];
																																							?></td>
										<td style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><?
																																				echo date("D", strtotime($rowp['report_date']));
																																				?></td>
										<td style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><?= $rowp['type_meeting'] ?></td>
										<td style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><?= lang_thai_from_database($rowp['detail_meeting']) ?></td>
										<td style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'" bgcolor="<?= $bg_status ?>"><?= $rowp['status_meeting'] ?></td>

									</tr>
							<?
								}
							}
							?>

						</table>
					</div>
				</div>

			</td>
		</tr>



	</table>








<?


}
if ($status == 'show_daily_hq') {

	$mmonth = (int) $_POST['mmonth'];
	$tsite = $_POST['tsite2'];
	$yyear = $_POST['yyear'];
	$ddate = $_POST['ddate'];
	$workday_q = $mmonth . "/" . $ddate . "/" . $yyear;

	if ($tsite == 'TSC') {
		$table_name = "tbdaily_report_tsc";
	} else if ($tsite == 'HQ') {
		$table_name = "tbdaily_report_hq";
	} else if ($tsite == 'OSW') {
		$table_name = "tbdaily_report_osw";
	}

	$select_emp = "select report_by,approve_by from tbdaily_report_hq where workdate = '$workday_q' AND shift='Day'";
	$re_emp = mssql_query($select_emp);
	$num_emp = mssql_num_rows($re_emp);
	if ($num_emp > 0) {
		$row_emp = mssql_fetch_array($re_emp);
		$report_by = get_full_name($row_emp['report_by']);
		$approve_by = get_full_name($row_emp['approve_by']);
		$pic_report = "<img src='emppic/" . $row_emp['report_by'] . "' height='50'>";
		$pic_approve = "<img src='emppic/" . $row_emp['approve_by'] . "' height='50'>";
	}

	//$month = $_POST['month'];
	//	$tsite = $_POST['tsite2'];
	//	$month_explode_arr = explode("-", $month);
	//	$mmonth = $month_explode_arr[1];
	//	$yyear = $month_explode_arr[0];

	$number = cal_days_in_month(CAL_GREGORIAN, $mmonth, $yyear);
	$startdate = $yyear . "-" . $mmonth . "-01";
	$enddate = $yyear . "-" . $mmonth . "-" . $number;




?>





	<table border="0" cellspacing="0" cellpadding="0" class="table table-striped table-bordered datatables">


		<tr>
			<td height="80" style="padding:0px">

				<table width="100%" border="0" cellspacing="0" cellpadding="0">

					<tr>
						<td colspan="5" height="40" bgcolor="#002060" align="center" valign="middle"><img src="images/ipack-logo-mb-2.png" style="float:left"><strong>
								<font color="#FFFFFF" size="5">HQ Daily Operation Report.</font>
							</strong></td>
					</tr>
					<tr>
						<td width="15%" height="120" align="center" bgcolor="#C00000"><strong>
								<font color="#FFFFFF" size="3">Date:</font>
							</strong></td>
						<td align="center" width="15%"><strong>
								<font color="#000000" size="3"><?
																echo $ddate;
																echo "-";
																echo date("F", strtotime($startdate));
																echo "-";
																echo $yyear;
																?></font>
							</strong></td>
						<td width="15%" align="center" bgcolor="#C00000"><strong>
								<font color="#FFFFFF" size="3">Shift:A,B</font>
							</strong></td>
						<td align="center" width="15%"><strong>
								<font color="#000000" size="3">DAY,Night</font>
							</strong></td>
						<td align="center" width="40%">
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td width="30%" height="60" align="center" bgcolor="#FFE699" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; "><strong>Report By:</strong></td>
									<td width="30%" align="center" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; "><?= $report_by ?></td>
									<td width="30%" align="center" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; "><?= $pic_report ?></td>
								</tr>
								<tr>
									<td height="60" align="center" bgcolor="#FFE699" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; "><strong>Approve By:</strong></td>
									<td align="center" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; "><?= $approve_by ?></td>
									<td align="center" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; "><?= $pic_approve ?></td>
								</tr>
							</table>
						</td>
					</tr>
				</table>

		</tr>
		</td>


		<tr>
			<td align="center" bgcolor="#ffffff" style="padding:0px">

				<table border="0" cellspacing="1" cellpadding="0">

					<tr>
						<td align="left" width="331" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#DBDBDB">&nbsp;</td>
						<td align="center" width="86" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#8EA9DB">&nbsp;</td>
						<?

						$select0 = "SELECT *,
			convert(varchar, workdate, 101)as  workdate2,
			convert(varchar, workdate, 103)as  workdate3
			
	FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";
						//echo $select0;
						//exit();
						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

						?>
								<td align='center' width='70' style='border-right:1px solid; border-bottom:1px solid;border-top:1px solid;' bgcolor="#ffffff">
									<?
									//date("d", strtotime($row0['workdate']));
									if ($ddate == date("d", strtotime($row0['workdate']))) {
									?><img src="images/point.jpg" width="20">
									<?
									}
									?>
								</td>
						<?


							}
						}

						?>
					</tr>
					<tr>
						<td align="left" width="331" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#DBDBDB"><strong>1. SAFETY.</strong></td>
						<td align="center" width="86" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#8EA9DB"><strong>DATE : </strong></td>
						<?

						$select0 = "SELECT *,
			convert(varchar, workdate, 101)as  workdate2,
			convert(varchar, workdate, 103)as  workdate3
			
	FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";
						//echo $select0;
						//exit();
						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

						?>
								<td align='center' width='70' style='border-right:1px solid; border-bottom:1px solid; color:#FFF' bgcolor="#595959"><strong>
										<?= date("d", strtotime($row0['workdate'])) ?>
									</strong></td>
						<?


							}
						}

						?>
					</tr>


					<!--/// safety_human ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF"><strong>1.1 Human ( Case )<BR>อุบัติเหตุที่เกิดขึ้นกับคน</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Case</strong></td>
						<?
						$select0 = "SELECT *,
			convert(varchar, workdate, 101)as  workdate2,
			convert(varchar, workdate, 103)as  workdate3
			
	FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT safety_human FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Day' ";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$safety_human = $row1['safety_human'];
								} else {
									$safety_human = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>"><strong>
										<?
										echo $safety_human;
										?>
									</strong></td>
						<?


							}
						}

						?>
					</tr>
					<!--/// safety_human ///-->

					<!--/// safety_part ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF"><strong>1.2 Part ( Pcs.)<BR>อุบัติเหตุที่เกิดขึ้นกับชิ้นงาน</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Pcs</strong></td>
						<?
						$select0 = "SELECT *,
			convert(varchar, workdate, 101)as  workdate2,
			convert(varchar, workdate, 103)as  workdate3
			
	FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT safety_part FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Day' ";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$safety_part = $row1['safety_part'];
								} else {
									$safety_part = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>"><strong>
										<?
										echo $safety_part;
										?>
									</strong></td>
						<?


							}
						}

						?>
					</tr>
					<!--/// safety_part ///-->

					<!--/// safety_nearmiss ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF"><strong>1.3 Near miss ( Case )<BR>อุบัติเหตุหรือเหตุการณ์ที่อาจทำให้เกิดอุบัติเหตุได้</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Case</strong></td>
						<?
						$select0 = "SELECT *,
			convert(varchar, workdate, 101)as  workdate2,
			convert(varchar, workdate, 103)as  workdate3
			
	FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT safety_nearmiss FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Day' ";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$safety_nearmiss = $row1['safety_nearmiss'];
								} else {
									$safety_nearmiss = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>"><strong>
										<?
										echo $safety_nearmiss;
										?>
									</strong></td>
						<?


							}
						}

						?>
					</tr>
					<!--/// safety_nearmiss ///-->

					<!--/// safety_target ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFF00"><strong>Result Performance</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#92D050"><strong>%</strong></td>
						<?
						$select0 = "SELECT *,
			convert(varchar, workdate, 101)as  workdate2,
			convert(varchar, workdate, 103)as  workdate3
			
	FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								$bg_day = "#FFE699";

								$select1 = "SELECT safety_target FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Day' ";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$safety_target = $row1['safety_target'] . "%";
								} else {
									$safety_target = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>"><strong>
										<?
										echo $safety_target;

										?>
									</strong></td>
						<?


							}
						}

						?>
					</tr>
					<!--/// safety_target ///-->


					<tr>
						<td height="20" colspan="2" align="left" bgcolor="#DBDBDB" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px"><strong>2. 5S. Daily</strong><strong></strong></td>
						<?

						$select0 = "SELECT *,
			convert(varchar, workdate, 101)as  workdate2,
			convert(varchar, workdate, 103)as  workdate3
			
	FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#FFF' bgcolor="#595959"><strong>
										<?= date("d", strtotime($row0['workdate'])) ?>
									</strong></td>
						<?


							}
						}

						?>
					</tr>


					<!--/// ss_daily ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#00FFFF"><strong>1.Ware house Area</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#00FFFF"><strong></strong></td>
						<?
						$select0 = "SELECT *,
			convert(varchar, workdate, 101)as  workdate2,
			convert(varchar, workdate, 103)as  workdate3
			
	FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {


								$bg_day = "#00FFFF";

								$select1 = "SELECT ss_daily FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Day' ";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									if ($row1['ss_daily'] != '') {
										$ss_daily = "<a href='" . $row1['ss_daily'] . "' target='_blank'>Link</a>";
									} else {
										$ss_daily = '';
									}
								} else {
									$ss_daily = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>"><strong>
										<?
										echo $ss_daily;
										?>
									</strong></td>
						<?


							}
						}

						?>
					</tr>
					<!--/// ss_daily ///-->

					<!--/// ss_daily_day ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#00FFFF"><strong>Day</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#00FFFF"><strong></strong></td>
						<?
						$select0 = "SELECT *,
			convert(varchar, workdate, 101)as  workdate2,
			convert(varchar, workdate, 103)as  workdate3
			
	FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {


								$bg_day = "#00FFFF";

								$select1 = "SELECT ss_daily_status FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Day' ";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									if ($row1['ss_daily_status'] != '') {
										$arr_ss_daily_status = explode(",", $row1['ss_daily_status']);
										$ss_daily_status = $arr_ss_daily_status[0] . "<br>" . $arr_ss_daily_status[1];
									} else {
										$ss_daily_status = '';
									}
								} else {
									$ss_daily_status = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>"><strong>
										<?
										echo $ss_daily_status;
										?>
									</strong></td>
						<?


							}
						}

						?>
					</tr>
					<!--/// ss_daily_day ///-->

					<!--/// ss_daily_night ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#00FFFF"><strong>Night</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#00FFFF"><strong></strong></td>
						<?
						$select0 = "SELECT *,
			convert(varchar, workdate, 101)as  workdate2,
			convert(varchar, workdate, 103)as  workdate3
			
	FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

								$bg_day = "#00FFFF";

								$select1 = "SELECT ss_daily_status FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Night' ";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									if ($row1['ss_daily_status'] != '') {
										$arr_ss_daily_status = explode(",", $row1['ss_daily_status']);
										$ss_daily_status = $arr_ss_daily_status[0] . "&nbsp;" . $arr_ss_daily_status[1];
									} else {
										$ss_daily_status = '';
									}
								} else {
									$ss_daily_status = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>"><strong>
										<?
										echo $ss_daily_status;
										?>
									</strong></td>
						<?


							}
						}

						?>
					</tr>
					<!--/// ss_daily_night ///-->

					<!--/// ss_daily_percent ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#ffffff"><strong>Status Check </strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#ffffff"><strong>%</strong></td>
						<?
						$select0 = "SELECT *,
			convert(varchar, workdate, 101)as  workdate2,
			convert(varchar, workdate, 103)as  workdate3
			
	FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {


								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT ss_daily_percent FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Day' ";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									if ($row1['ss_daily_percent'] != '') {
										$ss_daily_percent = $row1['ss_daily_percent'] . "%";
									} else {
										$ss_daily_percent = '';
									}
								} else {
									$ss_daily_percent = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>"><strong>
										<?
										echo $ss_daily_percent;
										?>
									</strong></td>
						<?


							}
						}

						?>
					</tr>
					<!--/// ss_daily_percent ///-->


					<tr>
						<td height="20" colspan="2" align="left" bgcolor="#DBDBDB" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px"><strong>3. TIME ATTENDANCE.</strong><strong></strong></td>
						<?

						$select0 = "SELECT *,
			convert(varchar, workdate, 101)as  workdate2,
			convert(varchar, workdate, 103)as  workdate3
			
	FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#FFF' bgcolor="#595959"><strong>
										<?= date("d", strtotime($row0['workdate'])) ?>
									</strong></td>
						<?


							}
						}

						?>
					</tr>


					<!--/// att_asst_mgr ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF"><strong>3.1 Asst,wh MGR</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Prs.</strong></td>
						<?
						$select0 = "SELECT *,
			convert(varchar, workdate, 101)as  workdate2,
			convert(varchar, workdate, 103)as  workdate3
			
	FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT att_asst_mgr FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Day' ";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$att_asst_mgr = $row1['att_asst_mgr'];
								} else {
									$att_asst_mgr = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>"><strong>
										<?
										echo $att_asst_mgr;
										?>
									</strong></td>
						<?


							}
						}

						?>
					</tr>
					<!--/// att_asst_mgr ///-->

					<!--/// att_supervisor ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF"><strong>3.2 Supervisor</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Prs.</strong></td>
						<?
						$select0 = "SELECT *,
			convert(varchar, workdate, 101)as  workdate2,
			convert(varchar, workdate, 103)as  workdate3
			
	FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT att_supervisor FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Day' ";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$att_supervisor = $row1['att_supervisor'];
								} else {
									$att_supervisor = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>"><strong>
										<?
										echo $att_supervisor;
										?>
									</strong></td>
						<?


							}
						}

						?>
					</tr>
					<!--/// att_supervisor ///-->

					<!--/// att_leader ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF"><strong>3.3 Leader</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Prs.</strong></td>
						<?
						$select0 = "SELECT *,
			convert(varchar, workdate, 101)as  workdate2,
			convert(varchar, workdate, 103)as  workdate3
			
	FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT att_leader FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Day' ";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$att_leader = $row1['att_leader'];
								} else {
									$att_leader = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>"><strong>
										<?
										echo $att_leader;
										?>
									</strong></td>
						<?


							}
						}

						?>
					</tr>
					<!--/// att_leader ///-->

					<!--/// att_operator ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF"><strong>3.4 Packing Staff</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Prs.</strong></td>
						<?
						$select0 = "SELECT *,
			convert(varchar, workdate, 101)as  workdate2,
			convert(varchar, workdate, 103)as  workdate3
			
	FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT att_operator FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Day' ";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$att_operator = $row1['att_operator'];
								} else {
									$att_operator = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>"><strong>
										<?
										echo $att_operator;
										?>
									</strong></td>
						<?


							}
						}

						?>
					</tr>
					<!--/// att_operator ///-->




					<!--/// att_forklift ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF"><strong>3.5 Forkift</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Prs.</strong></td>
						<?
						$select0 = "SELECT *,
			convert(varchar, workdate, 101)as  workdate2,
			convert(varchar, workdate, 103)as  workdate3
			
	FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT att_forklift FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Day' ";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$att_forklift = $row1['att_forklift'];
								} else {
									$att_forklift = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>"><strong>
										<?
										echo $att_forklift;
										?>
									</strong></td>
						<?


							}
						}

						?>
					</tr>
					<!--/// att_forklift ///-->

					<!--/// att_forklift_day ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF"><strong>- Day shift</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Prs.</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT att_forklift_day1, att_forklift_day2 FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Day' ";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$att_forklift_day = lang_thai_from_database($row1['att_forklift_day1']);
								} else {
									$att_forklift_day = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>"><strong>
										<?
										echo $att_forklift_day;
										?>
									</strong></td>
						<?


							}
						}

						?>
					</tr>
					<!--/// att_forklift_day ///-->

					<!--/// att_forklift_night ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF"><strong>- Day shift</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Prs.</strong></td>
						<?
						$select0 = "SELECT *,
			convert(varchar, workdate, 101)as  workdate2,
			convert(varchar, workdate, 103)as  workdate3
			
	FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT att_forklift_day1, att_forklift_day2 FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Day' ";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$att_forklift_night = lang_thai_from_database($row1['att_forklift_day2']);
								} else {
									$att_forklift_night = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>"><strong>
										<?
										echo $att_forklift_night;
										?>
									</strong></td>
						<?


							}
						}

						?>
					</tr>
					<!--/// att_forklift_night ///-->

					<!--/// att_late ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF"><strong>3.6 Late</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Prs.</strong></td>
						<?
						$select0 = "SELECT *,
			convert(varchar, workdate, 101)as  workdate2,
			convert(varchar, workdate, 103)as  workdate3
			
	FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT att_late FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Day' ";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$att_late = $row1['att_late'];
								} else {
									$att_late = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>"><strong>
										<?
										echo $att_late;
										?>
									</strong></td>
						<?


							}
						}

						?>
					</tr>
					<!--/// att_late ///-->
					<!--/// att_plan ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF">&nbsp;</td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Plan</strong></td>
						<?
						$select0 = "SELECT *,
			convert(varchar, workdate, 101)as  workdate2,
			convert(varchar, workdate, 103)as  workdate3
			
	FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT att_plan FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Day' ";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$att_plan = $row1['att_plan'];
								} else {
									$att_plan = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>"><strong>
										<?
										echo $att_plan;
										?>
									</strong></td>
						<?


							}
						}

						?>
					</tr>
					<!--/// att_plan ///-->

					<!--/// att_total ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF">&nbsp;</td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Total</strong></td>
						<?
						$select0 = "SELECT *,
			convert(varchar, workdate, 101)as  workdate2,
			convert(varchar, workdate, 103)as  workdate3
			
	FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT att_total FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Day' ";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$att_total = $row1['att_total'];
								} else {
									$att_total = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>"><strong>
										<?
										echo $att_total;
										?>
									</strong></td>
						<?


							}
						}

						?>
					</tr>
					<!--/// att_total ///-->

					<!--/// att_total_percent ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFF00"><strong>Total attendance (%)/Day.</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#92D050"><strong>%</strong></td>
						<?
						$select0 = "SELECT *,
			convert(varchar, workdate, 101)as  workdate2,
			convert(varchar, workdate, 103)as  workdate3
			
	FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

								$bg_day = "#FFE699";


								$select1 = "SELECT att_total_percent FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Day' ";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									if ($row1['att_total_percent'] != '') {
										$att_total_percent = $row1['att_total_percent'] . "%";
									} else {
										$att_total_percent = '';
									}
								} else {
									$att_total_percent = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>"><strong>
										<?
										echo $att_total_percent;
										?>
									</strong></td>
						<?


							}
						}

						?>
					</tr>
					<!--/// att_total_percent ///-->

					<!--/// att_achieve ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFF00"><strong>Status achieve</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#92D050">&nbsp;</td>
						<?
						$select0 = "SELECT *,
			convert(varchar, workdate, 101)as  workdate2,
			convert(varchar, workdate, 103)as  workdate3
			
	FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

								$bg_day = "#FFE699";


								$select1 = "SELECT att_achieve FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Day' ";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									if ($row1['att_achieve'] == 'On') {
										$att_achieve = "<font color='#00B050'>" . $row1['att_achieve'] . "</font>";
									} else if ($row1['att_achieve'] == 'Not') {
										$att_achieve = "<font color='#FF0000'>" . $row1['att_achieve'] . "</font>";
									} else {
										$att_achieve = '';
									}
								} else {
									$att_achieve = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>"><strong>
										<a href="javascript:void(0)" onclick="show_att('<?=$row0['workdate3']?>')">
										<?
										echo $att_achieve;
										?>
										</a>
									</strong></td>
						<?


							}
						}


						?>
					</tr>
					<!--/// att_achieve ///-->

					<tr>
						<td height="20" colspan="2" align="left" bgcolor="#DBDBDB" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px"><strong>4. OVERTIME</strong><strong></strong></td>
						<?

						$select0 = "SELECT *,
			convert(varchar, workdate, 101)as  workdate2,
			convert(varchar, workdate, 103)as  workdate3
			
	FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#FFF' bgcolor="#595959"><strong>
										<?= date("d", strtotime($row0['workdate'])) ?>
									</strong></td>
						<?


							}
						}

						?>
					</tr>


					<!--/// ot_asst_mgr_prs ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF"><strong>4.1 Asst,wh MGR</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Prs./Hrs.</strong></td>
						<?
						$select0 = "SELECT *,
			convert(varchar, workdate, 101)as  workdate2,
			convert(varchar, workdate, 103)as  workdate3
			
	FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								//$bg_day = "#FFFFFF";
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT ot_asst_mgr_prs,ot_asst_mgr_hrs FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Day' ";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$ot_asst_mgr_prs = $row1['ot_asst_mgr_prs'];
									$ot_asst_mgr_hrs = $row1['ot_asst_mgr_hrs'];
								} else {
									$ot_asst_mgr_prs = '';
									$ot_asst_mgr_hrs = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
									<?
									if ($num1 > 0) {
										echo $ot_asst_mgr_prs;
									?>&nbsp;<strong>/</strong>&nbsp;<?
											echo $ot_asst_mgr_hrs;
										}
											?>

								</td>
						<?


							}
						}

						?>
					</tr>
					<!--/// ot_asst_mgr_prs ///-->

					<!--/// ot_supervisor_prs, ot_supervisor_hrs ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF"><strong>4.2 Supervisor</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Prs./Hrs.</strong></td>
						<?
						$select0 = "SELECT *,
			convert(varchar, workdate, 101)as  workdate2,
			convert(varchar, workdate, 103)as  workdate3
			
	FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								//$bg_day = "#FFFFFF";
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT ot_supervisor_prs, ot_supervisor_hrs FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Day' ";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$ot_supervisor_prs = $row1['ot_supervisor_prs'];
									$ot_supervisor_hrs = $row1['ot_supervisor_hrs'];
								} else {
									$ot_supervisor_prs = '';
									$ot_supervisor_hrs = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
									<?
									if ($num1 > 0) {
										echo $ot_supervisor_prs;
									?>&nbsp;<strong>/</strong>&nbsp;<?
											echo $ot_supervisor_hrs;
										}
											?>
								</td>
						<?


							}
						}

						?>
					</tr>
					<!--/// ot_supervisor_prs, ot_supervisor_hrs ///-->

					<!--/// ot_leader_prs, ot_leader_hrs ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF"><strong>4.3 Leader</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Prs./Hrs.</strong></td>
						<?
						$select0 = "SELECT *,
			convert(varchar, workdate, 101)as  workdate2,
			convert(varchar, workdate, 103)as  workdate3
			
	FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								//$bg_day = "#FFFFFF";
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT ot_leader_prs, ot_leader_hrs FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Day' ";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$ot_leader_prs = $row1['ot_leader_prs'];
									$ot_leader_hrs = $row1['ot_leader_hrs'];
								} else {
									$ot_leader_prs = '';
									$ot_leader_hrs = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
									<?
									if ($num1 > 0) {
										echo $ot_leader_prs;
									?>&nbsp;<strong>/</strong>&nbsp;<?
											echo $ot_leader_hrs;
										}
											?>
								</td>
						<?


							}
						}

						?>
					</tr>
					<!--/// ot_leader_prs, ot_leader_hrs ///-->

					<!--/// ot_operator_prs, ot_operator_hrs ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF"><strong>4.4 Packing Staff</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Prs./Hrs.</strong></td>
						<?
						$select0 = "SELECT *,
			convert(varchar, workdate, 101)as  workdate2,
			convert(varchar, workdate, 103)as  workdate3
			
	FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								//$bg_day = "#FFFFFF";
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT ot_operator_prs, ot_operator_hrs FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Day' ";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$ot_operator_prs = $row1['ot_operator_prs'];
									$ot_operator_hrs = $row1['ot_operator_hrs'];
								} else {
									$ot_operator_prs = '';
									$ot_operator_hrs = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
									<?
									if ($num1 > 0) {
										echo $ot_operator_prs;
									?>&nbsp;<strong>/</strong>&nbsp;<?
											echo $ot_operator_hrs;
										}
											?>
								</td>
						<?


							}
						}

						?>
					</tr>
					<!--/// ot_operator_prs, ot_operator_hrs ///-->

					<!--/// ot_forklift_prs,ot_forklift_hrs ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF"><strong>4.5 Forklift</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Prs./Hrs.</strong></td>
						<?
						$select0 = "SELECT *,
			convert(varchar, workdate, 101)as  workdate2,
			convert(varchar, workdate, 103)as  workdate3
			
	FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								//$bg_day = "#FFFFFF";
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT ot_forklift_prs,ot_forklift_hrs FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Day' ";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$ot_forklift_prs = $row1['ot_forklift_prs'];
									$ot_forklift_hrs = $row1['ot_forklift_hrs'];
								} else {
									$ot_forklift_prs = '';
									$ot_forklift_hrs = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
									<?
									if ($num1 > 0) {
										echo $ot_forklift_prs;
									?>&nbsp;<strong>/</strong>&nbsp;<?
											echo $ot_forklift_hrs;
										}
											?>
								</td>
						<?


							}
						}

						?>
					</tr>
					<!--/// ot_forklift_prs,ot_forklift_hrs ///-->

					<!--/// ot_sub_prs, ot_sub_hrs ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF"><strong>4.6 Sub contract</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Prs./Hrs.</strong></td>
						<?
						$select0 = "SELECT *,
			convert(varchar, workdate, 101)as  workdate2,
			convert(varchar, workdate, 103)as  workdate3
			
	FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								//$bg_day = "#FFFFFF";
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT ot_sub_prs, ot_sub_hrs FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Day' ";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$ot_sub_prs = $row1['ot_sub_prs'];
									$ot_sub_hrs = $row1['ot_sub_hrs'];
								} else {
									$ot_sub_prs = '';
									$ot_sub_hrs = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
									<?
									if ($num1 > 0) {
										echo $ot_sub_prs;
									?>&nbsp;<strong>/</strong>&nbsp;<?
											echo $ot_sub_hrs;
										}
											?>
								</td>
						<?


							}
						}

						?>
					</tr>
					<!--/// ot_sub_prs, ot_sub_hrs ///-->

					<!--/// ot_target ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF"><strong>Overtime Target</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Hr.</strong></td>
						<?
						$select0 = "SELECT *,
			convert(varchar, workdate, 101)as  workdate2,
			convert(varchar, workdate, 103)as  workdate3
			
	FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								//$bg_day = "#FFFFFF";
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT ot_target FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Day' ";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$ot_target = $row1['ot_target'];
								} else {
									$ot_target = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
									<strong>
										<?= $ot_target ?>
									</strong></td>
						<?


							}
						}

						?>
					</tr>
					<!--/// ot_target ///-->

					<!--/// ot_actual ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF"><strong>Actual Overtime</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Hr.</strong></td>
						<?
						$select0 = "SELECT *,
			convert(varchar, workdate, 101)as  workdate2,
			convert(varchar, workdate, 103)as  workdate3
			
	FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								//$bg_day = "#FFFFFF";
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT ot_actual FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Day' ";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$ot_actual = $row1['ot_actual'];
								} else {
									$ot_actual = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
									<strong>
										<?= $ot_actual ?>
									</strong></td>
						<?


							}
						}

						?>
					</tr>
					<!--/// ot_actual ///-->


					<!--/// ot_achieve ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFF00"><strong>Status achieve</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#92D050">&nbsp;</td>
						<?
						$select0 = "SELECT *,
			convert(varchar, workdate, 101)as  workdate2,
			convert(varchar, workdate, 103)as  workdate3
			
	FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

								$bg_day = "#FFE699";


								$select1 = "SELECT ot_achieve FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Day' ";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									if ($row1['ot_achieve'] == 'On') {
										$ot_achieve = "<font color='#00B050'>" . $row1['ot_achieve'] . "</font>";
									} else if ($row1['ot_achieve'] == 'Not') {
										$ot_achieve = "<font color='#FF0000'>" . $row1['ot_achieve'] . "</font>";
									} else {
										$ot_achieve = '';
									}
								} else {
									$ot_achieve = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>"><strong>
										<a href="javascript:void(0)" onclick="show_ot('<?=$row0['workdate3']?>')">
										<?
										echo $ot_achieve;
										?>
										</a>
									</strong></td>
						<?


							}
						}

						?>
					</tr>
					<!--/// ot_achieve ///-->

					<tr>
						<td height="20" colspan="2" align="left" bgcolor="#DBDBDB" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px"><strong>5. Efficiency Operation</strong><strong></strong></td>
						<?

						$select0 = "SELECT *,
			convert(varchar, workdate, 101)as  workdate2,
			convert(varchar, workdate, 103)as  workdate3
			
	FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						$qty_col = 0;
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								$qty_col++;
							}
						}
						?>
						<td align='center' colspan="<?= $qty_col ?>" bgcolor="#DBDBDB"></td>
						<?
						?>
					</tr>
					<tr>
						<td height="20" align="left" bgcolor="#FFFFFF" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px"><strong>SAB</strong><strong></strong></td>
						<td bgcolor="#FFFFFF" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid"></td>
						<?

						$select0 = "SELECT *,
			convert(varchar, workdate, 101)as  workdate2,
			convert(varchar, workdate, 103)as  workdate3
			
	FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#FFF' bgcolor="#595959"><strong>
										<?= date("d", strtotime($row0['workdate'])) ?>
									</strong></td>
						<?


							}
						}

						?>
					</tr>

					<!--/// per_receive_sab ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF"><strong>5.1.1 Receive</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Issue</strong></td>
						<?
						$select0 = "SELECT *,
			convert(varchar, workdate, 101)as  workdate2,
			convert(varchar, workdate, 103)as  workdate3
			
	FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								//$bg_day = "#FFFFFF";
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT per_receive_sab FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Day' ";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$per_receive_sab = $row1['per_receive_sab'];
								} else {
									$per_receive_sab = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
									<a href="javascript:void(0)" onclick="show_receive_sab('<?=$row0['workdate3']?>')">
									<strong>
										<?= $per_receive_sab ?>
									</strong>
									</a>
								</td>
						<?


							}
						}

						?>
					</tr>
					<!--/// per_receive_sab ///-->

					<!--/// per_packing_sab ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF"><strong>5.1.2 Packing</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Issue</strong></td>
						<?
						$select0 = "SELECT *,
			convert(varchar, workdate, 101)as  workdate2,
			convert(varchar, workdate, 103)as  workdate3
			
	FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								//$bg_day = "#FFFFFF";
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT per_packing_sab FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Day' ";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$per_packing_sab = $row1['per_packing_sab'];
								} else {
									$per_packing_sab = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
									<a href="javascript:void(0)" onclick="show_packing_sab('<?=$row0['workdate3']?>')">
									<strong>
										<?= $per_packing_sab ?>
									</strong>
									</a>
								</td>
						<?


							}
						}

						?>
					</tr>
					<!--/// per_packing_sab ///-->

					<!--/// per_loading_sab ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px; padding-left:2px" bgcolor="#FFFFFF"><strong>5.1.3 Loading</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Issue</strong></td>
						<?
						$select0 = "SELECT *,
			convert(varchar, workdate, 101)as  workdate2,
			convert(varchar, workdate, 103)as  workdate3
			
	FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								//$bg_day = "#FFFFFF";
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT per_loading_sab FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Day' ";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$per_loading_sab = $row1['per_loading_sab'];
								} else {
									$per_loading_sab = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
									<a href="javascript:void(0)" onclick="show_loading_sab('<?=$row0['workdate3']?>')">
									<strong>
										<?= $per_loading_sab ?>
									</strong>
									</a>
								</td>
						<?


							}
						}

						?>
					</tr>
					<!--/// per_loading_sab ///-->

					<tr>
						<td height="20" align="left" bgcolor="#FFFFFF" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px"><strong>Topre</strong><strong></strong></td>
						<td bgcolor="#FFFFFF" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid"></td>
						<?

						$select0 = "SELECT *,
			convert(varchar, workdate, 101)as  workdate2,
			convert(varchar, workdate, 103)as  workdate3
			
	FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#FFF' bgcolor="#595959"><strong>
										<?= date("d", strtotime($row0['workdate'])) ?>
									</strong></td>
						<?


							}
						}

						?>
					</tr>


					<!--/// per_receive_topre ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF"><strong>5.2.1 Receive</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Issue</strong></td>
						<?
						$select0 = "SELECT *,
			convert(varchar, workdate, 101)as  workdate2,
			convert(varchar, workdate, 103)as  workdate3
			
	FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								//$bg_day = "#FFFFFF";
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT per_receive_topre FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Day' ";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$per_receive_topre = $row1['per_receive_topre'];
								} else {
									$per_receive_topre = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
									<a href="javascript:void(0)" onclick="show_receive_topre('<?=$row0['workdate3']?>')">
									<strong>
									<?
									echo $per_receive_topre;

									?>
									</strong>
									</a>
								</td>
						<?


							}
						}

						?>
					</tr>
					<!--/// per_receive_topre ///-->

					<!--/// per_packing_topre ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF"><strong>5.2.2 Packing</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Issue</strong></td>
						<?
						$select0 = "SELECT *,
			convert(varchar, workdate, 101)as  workdate2,
			convert(varchar, workdate, 103)as  workdate3
			
	FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								//$bg_day = "#FFFFFF";
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT per_packing_topre FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Day' ";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$per_packing_topre = $row1['per_packing_topre'];
								} else {
									$per_packing_topre = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
									<a href="javascript:void(0)" onclick="show_packing_topre('<?=$row0['workdate3']?>')">
									<strong>
									<?
									echo $per_packing_topre;

									?>
									</strong>
									</a>

								</td>
						<?


							}
						}

						?>
					</tr>
					<!--/// per_packing_topre ///-->

					<!--/// per_loading_topre ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF"><strong>5.2.3 Loading</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Issue</strong></td>
						<?
						$select0 = "SELECT *,
			convert(varchar, workdate, 101)as  workdate2,
			convert(varchar, workdate, 103)as  workdate3
			
	FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								//$bg_day = "#FFFFFF";
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT per_loading_topre FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Day' ";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$per_loading_topre = $row1['per_loading_topre'];
								} else {
									$per_loading_topre = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
									<a href="javascript:void(0)" onclick="show_loading_topre('<?=$row0['workdate3']?>')">
									<strong>
									<?
									echo $per_loading_topre;

									?>
									</strong>
									</a>
								</td>
						<?


							}
						}

						?>
					</tr>
					<!--/// per_loading_topre ///-->


					<tr>
						<td height="20" align="left" bgcolor="#FFFFFF" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px"><strong>Trading</strong><strong></strong></td>
						<td bgcolor="#FFFFFF" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid"></td>
						<?

						$select0 = "SELECT *,
			convert(varchar, workdate, 101)as  workdate2,
			convert(varchar, workdate, 103)as  workdate3
			
	FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#FFF' bgcolor="#595959">
									<strong>
										<?= date("d", strtotime($row0['workdate'])) ?>
									</strong>
								</td>
						<?


							}
						}

						?>
					</tr>

					<!--/// per_trading_tts ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF"><strong>5.3.1 TTS</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Issue</strong></td>
						<?
						$select0 = "SELECT *,
			convert(varchar, workdate, 101)as  workdate2,
			convert(varchar, workdate, 103)as  workdate3
			
	FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								//$bg_day = "#FFFFFF";
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT per_trading_tts FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Day' ";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$per_trading_tts = $row1['per_trading_tts'];
								} else {
									$per_trading_tts = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
									<a href="javascript:void(0)" onclick="show_trading_tts('<?=$row0['workdate3']?>')">
									<strong>
									<?
									echo $per_trading_tts;

									?>
									</strong>
									</a>
								</td>
						<?


							}
						}

						?>
					</tr>
					<!--/// per_trading_tts ///-->

					<!--/// per_trading_brose ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF"><strong>5.3.2 Brose</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Issue</strong></td>
						<?
						$select0 = "SELECT *,
			convert(varchar, workdate, 101)as  workdate2,
			convert(varchar, workdate, 103)as  workdate3
			
	FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								//$bg_day = "#FFFFFF";
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT per_trading_brose FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Day' ";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$per_trading_brose = $row1['per_trading_brose'];
								} else {
									$per_trading_brose = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
									<a href="javascript:void(0)" onclick="show_trading_brose('<?=$row0['workdate3']?>')">
									<strong>
									<?
									echo $per_trading_brose;

									?>
									</strong>
									</a>
								</td>
						<?


							}
						}

						?>
					</tr>
					<!--/// per_trading_brose ///-->

					<!--/// per_trading_smrc ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF"><strong>5.3.3 SMRC</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Issue</strong></td>
						<?
						$select0 = "SELECT *,
			convert(varchar, workdate, 101)as  workdate2,
			convert(varchar, workdate, 103)as  workdate3
			
	FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								//$bg_day = "#FFFFFF";
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT per_trading_smrc FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Day' ";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$per_trading_smrc = $row1['per_trading_smrc'];
								} else {
									$per_trading_smrc = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
									<a href="javascript:void(0)" onclick="show_trading_smrc('<?=$row0['workdate3']?>')">
									<strong>
									<?
									echo $per_trading_smrc;

									?>
									</strong>
									</a>
								</td>
						<?


							}
						}

						?>
					</tr>
					<!--/// per_trading_smrc ///-->
					<!--/// per_trading_gkn ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF"><strong>5.3.3 GKN</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Issue</strong></td>
						<?
						$select0 = "SELECT *,
			convert(varchar, workdate, 101)as  workdate2,
			convert(varchar, workdate, 103)as  workdate3
			
	FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								//$bg_day = "#FFFFFF";
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT per_trading_gkn FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Day' ";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$per_trading_gkn = $row1['per_trading_gkn'];
								} else {
									$per_trading_gkn = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
									<a href="javascript:void(0)" onclick="show_trading_gkn('<?=$row0['workdate3']?>')">
									<strong>
									<?
									echo $per_trading_gkn;

									?>
									</strong>
									</a>
								</td>
						<?


							}
						}

						?>
					</tr>
					<!--/// per_trading_gkn ///-->

					<tr>
						<td height="20" align="left" bgcolor="#FFFFFF" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px"><strong>Orther Special Job</strong><strong></strong></td>
						<td bgcolor="#FFFFFF" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid"></td>
						<?

						$select0 = "SELECT *,
			convert(varchar, workdate, 101)as  workdate2,
			convert(varchar, workdate, 103)as  workdate3
			
	FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#FFF' bgcolor="#595959"><strong>
										<?= date("d", strtotime($row0['workdate'])) ?>
									</strong></td>
						<?


							}
						}

						?>
					</tr>

					<!--/// per_other_sp ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF"><strong>5.4.1 Q'ty Job</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Issue</strong></td>
						<?
						$select0 = "SELECT *,
			convert(varchar, workdate, 101)as  workdate2,
			convert(varchar, workdate, 103)as  workdate3
			
	FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								//$bg_day = "#FFFFFF";
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT per_other_sp FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Day' ";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$per_other_sp = $row1['per_other_sp'];
								} else {
									$per_other_sp = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
									<a href="javascript:void(0)" onclick="show_trading_sp('<?=$row0['workdate3']?>')">
									<strong>
									<?
									echo $per_other_sp;

									?>
									</strong>
									</a>
								</td>
						<?


							}
						}

						?>
					</tr>
					<!--/// per_other_sp ///-->
					<!--/// per_remark_sp ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF"><strong>Remark</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Issue</strong></td>
						<?
						$select0 = "SELECT *,
			convert(varchar, workdate, 101)as  workdate2,
			convert(varchar, workdate, 103)as  workdate3
			
	FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								//$bg_day = "#FFFFFF";
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT per_remark_sp FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Day' ";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$per_remark_sp = lang_thai_from_database($row1['per_remark_sp']);
								} else {
									$per_remark_sp = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
									<strong>
									<?
									echo $per_remark_sp;

									?>
									</strong>
								</td>
						<?


							}
						}

						?>
					</tr>
					<!--/// per_remark_sp ///-->
					
					<!--/// NHK LEAF ///-->
					<tr>
						<td height="20" align="left" bgcolor="#FFFFFF" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px"><strong>NHK leaf</strong><strong></strong></td>
						<td bgcolor="#FFFFFF" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid"></td>
						<?

						$select0 = "SELECT *,
			convert(varchar, workdate, 101)as  workdate2,
			convert(varchar, workdate, 103)as  workdate3
			
	FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#FFF' bgcolor="#595959"><strong>
										<?= date("d", strtotime($row0['workdate'])) ?>
									</strong></td>
						<?


							}
						}

						?>
					</tr>
					<!--/// NHK LEAF ///-->

					<!--/// per_receive_nhk ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF"><strong>5.5.1 Receive</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Issue</strong></td>
						<?
						$select0 = "SELECT *,
			convert(varchar, workdate, 101)as  workdate2,
			convert(varchar, workdate, 103)as  workdate3
			
	FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								//$bg_day = "#FFFFFF";
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT per_receive_nhk FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Day' ";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$per_receive_nhk = $row1['per_receive_nhk'];
								} else {
									$per_receive_nhk = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
									<a href="javascript:void(0)" onclick="show_receive_nhk('<?=$row0['workdate3']?>')">
									<strong>
									<?
									echo $per_receive_nhk;

									?>
									</strong>
									</a>
								</td>
						<?


							}
						}

						?>
					</tr>
					<!--/// per_receive_nhk ///-->
					<!--/// per_packing_nhk ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF"><strong>5.5.2 Packing</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Issue</strong></td>
						<?
						$select0 = "SELECT *,
			convert(varchar, workdate, 101)as  workdate2,
			convert(varchar, workdate, 103)as  workdate3
			
	FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								//$bg_day = "#FFFFFF";
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT per_packing_nhk FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Day' ";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$per_packing_nhk = $row1['per_packing_nhk'];
								} else {
									$per_packing_nhk = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
									<a href="javascript:void(0)" onclick="show_packing_nhk('<?=$row0['workdate3']?>')">
									<strong>
									<?
									echo $per_packing_nhk;

									?>
									</strong>
									</a>
								</td>
						<?


							}
						}

						?>
					</tr>
					<!--/// per_packing_nhk ///-->
					<!--/// per_loading_nhk ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF"><strong>5.5.3 Loading</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Issue</strong></td>
						<?
						$select0 = "SELECT *,
			convert(varchar, workdate, 101)as  workdate2,
			convert(varchar, workdate, 103)as  workdate3
			
	FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								//$bg_day = "#FFFFFF";
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT per_loading_nhk FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Day' ";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$per_loading_nhk = $row1['per_loading_nhk'];
								} else {
									$per_loading_nhk = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
									<a href="javascript:void(0)" onclick="show_loading_nhk('<?=$row0['workdate3']?>')">
									<strong>
									<?
									echo $per_loading_nhk;

									?>
									</strong>
									</a>
								</td>
						<?


							}
						}

						?>
					</tr>
					<!--/// per_loading_nhk ///-->

					<!--/// Receive Rack ///-->
					<tr>
						<td height="20" align="left" bgcolor="#FFFFFF" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px"><strong>Receive Rack</strong><strong></strong></td>
						<td bgcolor="#FFFFFF" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid"></td>
						<?

						$select0 = "SELECT *,
			convert(varchar, workdate, 101)as  workdate2,
			convert(varchar, workdate, 103)as  workdate3
			
	FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#FFF' bgcolor="#595959"><strong>
										<?= date("d", strtotime($row0['workdate'])) ?>
									</strong></td>
						<?


							}
						}

						?>
					</tr>
					<!--/// Receive Rack ///-->
					<!--/// per_receive_rack_sab ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF"><strong>5.6.1 SAB</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Time</strong></td>
						<?
						$select0 = "SELECT *,
			convert(varchar, workdate, 101)as  workdate2,
			convert(varchar, workdate, 103)as  workdate3
			
	FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								//$bg_day = "#FFFFFF";
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT per_receive_rack_sab FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Day' ";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$per_receive_rack_sab = $row1['per_receive_rack_sab'];
								} else {
									$per_receive_rack_sab = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
									<a href="javascript:void(0)" onclick="show_receive_rack_sab('<?=$row0['workdate3']?>')">
									<strong>
									<?
									echo $per_receive_rack_sab;

									?>
									</strong>
									</a>
								</td>
						<?


							}
						}

						?>
					</tr>
					<!--/// per_receive_rack_sab ///-->

					<!--/// per_receive_rack_topre ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF"><strong>5.6.2 Topre</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Time</strong></td>
						<?
						$select0 = "SELECT *,
			convert(varchar, workdate, 101)as  workdate2,
			convert(varchar, workdate, 103)as  workdate3
			
	FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								//$bg_day = "#FFFFFF";
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT per_receive_rack_topre FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Day' ";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$per_receive_rack_topre = $row1['per_receive_rack_topre'];
								} else {
									$per_receive_rack_topre = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
									<a href="javascript:void(0)" onclick="show_receive_rack_topre('<?=$row0['workdate3']?>')">
									<strong>
									<?
									echo $per_receive_rack_topre;

									?>
									</strong>
									</a>
								</td>
						<?


							}
						}

						?>
					</tr>
					<!--/// per_receive_rack_topre ///-->



					<tr>
						<td height="20" colspan="2" align="left" bgcolor="#DBDBDB" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px"><strong>6. Qaulity</strong><strong></strong></td>
						<?

						$select0 = "SELECT *,
			convert(varchar, workdate, 101)as  workdate2,
			convert(varchar, workdate, 103)as  workdate3
			
	FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						$qty_col = 0;
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								$qty_col++;
							}
						}
						?>
						<td align='center' colspan="<?= $qty_col ?>" bgcolor="#DBDBDB"></td>
						<?
						?>
					</tr>


					<tr>
						<td height="20" align="left" bgcolor="#FFFFFF" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px"><strong>6.1 External</strong><strong></strong></td>
						<td bgcolor="#FFFFFF" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid"></td>
						<?

						$select0 = "SELECT *,
			convert(varchar, workdate, 101)as  workdate2,
			convert(varchar, workdate, 103)as  workdate3
			
	FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#FFF' bgcolor="#595959"><strong>
										<?= date("d", strtotime($row0['workdate'])) ?>
									</strong></td>
						<?


							}
						}

						?>
					</tr>

					<!--/// qa_sab_ng ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF"><strong>6.1.1 SAB NG</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Issue</strong></td>
						<?
						$select0 = "SELECT *,
			convert(varchar, workdate, 101)as  workdate2,
			convert(varchar, workdate, 103)as  workdate3
			
	FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								//$bg_day = "#FFFFFF";
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT qa_sab_ng FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Day' ";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$qa_sab_ng = $row1['qa_sab_ng'];
								} else {
									$qa_sab_ng = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
									<a href="javascript:void(0)" onclick="show_qa_sab_ng('<?=$row0['workdate3']?>')">
									<strong>
										<?= $qa_sab_ng ?>
									</strong>
									</a>	
								</td>
						<?


							}
						}

						?>
					</tr>
					<!--/// qa_sab_ng ///-->

					<!--/// qa_topre_ng ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF"><strong>6.1.2 Topre NG</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Issue</strong></td>
						<?
						$select0 = "SELECT *,
			convert(varchar, workdate, 101)as  workdate2,
			convert(varchar, workdate, 103)as  workdate3
			
	FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								//$bg_day = "#FFFFFF";
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT qa_topre_ng FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Day' ";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$qa_topre_ng = $row1['qa_topre_ng'];
								} else {
									$qa_topre_ng = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
									<a href="javascript:void(0)" onclick="show_qa_topre_ng('<?=$row0['workdate3']?>')">
									<strong>
										<?= $qa_topre_ng ?>
									</strong>
									</a>
								</td>
						<?


							}
						}

						?>
					</tr>
					<!--/// qa_topre_ng ///-->

					<!--/// qa_status_qrqc ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFF00"><strong>External Status QRQC</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#92D050">&nbsp;</td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								$bg_day = "#FFE699";
								//if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
								//					$bg_day = "#FFFF00";
								//				}else{
								//					$bg_day = "#FFFFFF";
								//					}


								$select1 = "SELECT qa_status_qrqc FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Day' ";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$qa_status_qrqc = $row1['qa_status_qrqc'];
								} else {
									$qa_status_qrqc = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">

									<strong>
										<?= lang_thai_from_database($qa_status_qrqc) ?>
									</strong></td>
						<?


							}
						}

						?>
					</tr>
					<!--/// qa_status_qrqc ///-->

					<tr>
						<td height="20" align="left" bgcolor="#FFFFFF" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px"><strong>6.2 Internal</strong><strong></strong></td>
						<td bgcolor="#FFFFFF" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid"></td>
						<?

						$select0 = "SELECT *,
			convert(varchar, workdate, 101)as  workdate2,
			convert(varchar, workdate, 103)as  workdate3
			
	FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#FFF' bgcolor="#595959"><strong>
										<?= date("d", strtotime($row0['workdate'])) ?>
									</strong></td>
						<?


							}
						}

						?>
					</tr>

					<!--/// qa_external_ng ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF"><strong>6.2.1 Internal NG</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Issue</strong></td>
						<?
						$select0 = "SELECT *,
			convert(varchar, workdate, 101)as  workdate2,
			convert(varchar, workdate, 103)as  workdate3
			
	FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								//$bg_day = "#FFFFFF";
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT qa_external_ng FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Day' ";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$qa_external_ng = $row1['qa_external_ng'];
								} else {
									$qa_external_ng = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">

									<strong>
										<?= $qa_external_ng ?>
									</strong></td>
						<?


							}
						}

						?>
					</tr>
					<!--/// qa_external_ng ///-->

					<!--/// qa_status_external_qrqc ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFF00"><strong>Internal Status QRQC</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#92D050">&nbsp;</td>
						<?
						$select0 = "SELECT *,
			convert(varchar, workdate, 101)as  workdate2,
			convert(varchar, workdate, 103)as  workdate3
			
	FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								$bg_day = "#FFE699";
								//if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
								//					$bg_day = "#FFFF00";
								//				}else{
								//					$bg_day = "#FFFFFF";
								//					}


								$select1 = "SELECT qa_status_external_qrqc FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Day' ";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$qa_status_external_qrqc = lang_thai_from_database($row1['qa_status_external_qrqc']);
								} else {
									$qa_status_external_qrqc = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">

									<strong>
										<?= $qa_status_external_qrqc ?>
									</strong></td>
						<?


							}
						}

						?>
					</tr>
					<!--/// qa_status_external_qrqc ///-->






					<tr>
						<td height="20" colspan="2" align="left" bgcolor="#DBDBDB" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px"><strong>7. </strong><strong>Status Racks NG Return</strong></td>
						<?

						$select0 = "SELECT *,
			convert(varchar, workdate, 101)as  workdate2,
			convert(varchar, workdate, 103)as  workdate3
			
	FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						$qty_col = 0;
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								$qty_col++;
							}
						}
						?>
						<td align='center' colspan="<?= $qty_col ?>" bgcolor="#DBDBDB"></td>
						<?
						?>
					</tr>

					<tr>
						<td height="20" align="left" bgcolor="#FFFFFF" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px"><strong>SAB &amp; Topre</strong></td>
						<td bgcolor="#FFFFFF" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid"></td>
						<?

						$select0 = "SELECT *,
			convert(varchar, workdate, 101)as  workdate2,
			convert(varchar, workdate, 103)as  workdate3
			
	FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#FFF' bgcolor="#595959"><strong>
										<?= date("d", strtotime($row0['workdate'])) ?>
									</strong></td>
						<?


							}
						}

						?>
					</tr>


					<!--/// return_rack_sab ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF"><strong>7.1 SAB Q'ty NG Return</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Q'ty</strong></td>
						<?
						$select0 = "SELECT *,
			convert(varchar, workdate, 101)as  workdate2,
			convert(varchar, workdate, 103)as  workdate3
			
	FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								//$bg_day = "#FFFFFF";
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT return_rack_sab FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Day' ";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$return_rack_sab = $row1['return_rack_sab'];
								} else {
									$return_rack_sab = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
									<a href="javascript:void(0)" onclick="show_return_rack_sab('<?=$row0['workdate3']?>')">
									<strong>
										<?= $return_rack_sab ?>
									</strong>
									</a>
								</td>
						<?


							}
						}

						?>
					</tr>
					<!--/// return_rack_sab ///-->



					<!--/// return_rack_topre ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF"><strong>7.2 Topre Q'ty NG Return</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Q'ty</strong></td>
						<?
						$select0 = "SELECT *,
			convert(varchar, workdate, 101)as  workdate2,
			convert(varchar, workdate, 103)as  workdate3
			
	FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								//$bg_day = "#FFFFFF";
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT return_rack_topre FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Day' ";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$return_rack_topre = $row1['return_rack_topre'];
								} else {
									$return_rack_topre = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
									<a href="javascript:void(0)" onclick="show_return_rack_topre('<?=$row0['workdate3']?>')">
									<strong>
										<?= $return_rack_topre ?>
									</strong>
									</a>

								</td>
						<?


							}
						}

						?>
					</tr>
					<!--/// return_rack_topre ///-->





				</table>

				<HR>

				<div class="row equal" style="margin-left:0px; margin-right:0px">
					<div class="col-md-12">
						<table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'">
							<tr>
								<td height="20" bgcolor="#FFFF00" style="padding-left:2px"><strong>8. Key activity</strong></td>
							</tr>
						</table>
					</div>
					<div class="col-md-6">
						<table width="100%" cellspacing="0" cellpadding="0">
							<tr>
								<td width="559" height="25" colspan="6" align="center" bgcolor="#FF0000" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><strong>
										<font color="#FFFFFF">Internal quality Problem</font>
									</strong></td>
							</tr>
							<tr>
								<td height="25" align="center" bgcolor="#FF0000" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><strong>
										<font color="#FFFFFF">Date</font>
									</strong></td>
								<td align="center" bgcolor="#FF0000" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><strong>
										<font color="#FFFFFF">Problem</font>
									</strong></td>
								<td align="center" bgcolor="#FF0000" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><strong>
										<font color="#FFFFFF">From Customer</font>
									</strong></td>

								<td align="center" bgcolor="#FF0000" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><strong>
										<font color="#FFFFFF">PIC</font>
									</strong></td>
								<td align="center" bgcolor="#FF0000" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><strong>
										<font color="#FFFFFF">Due date</font>
									</strong></td>
							</tr>
							<?
							$selectp = "select CONVERT(nvarchar, due_problem, 103) as due_problem,* from tbdaily_report_activity_external_problem where date_problem between '$startdate' and '$enddate' and site='HQ'";

							$rep = mssql_query($selectp);
							$nump = mssql_num_rows($rep);
							if ($nump > 0) {
								$ip = 0;
								while ($rowp = mssql_fetch_array($rep)) {
									$ip++;
							?>
									<tr align="center">
										<td height="25" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><?= $ip ?></td>
										<td style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><?= lang_thai_from_database($rowp['topic_problem']) ?></td>
										<td style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><?= lang_thai_from_database($rowp['customer_problem']) ?></td>
										<td style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><?= lang_thai_from_database($rowp['pic_problem']) ?></td>

										<td style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><?= $rowp['due_problem'] ?></td>
									</tr>
							<?
								}
							}
							?>

						</table>
					</div>
					<div class="col-md-6">
						<table width="100%" cellspacing="0" cellpadding="0">
							<tr>
								<td width="559" height="25" colspan="9" align="center" bgcolor="#00B050" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><strong>
										<font color="#FFFFFF">Inventory</font>
									</strong></td>
							</tr>
							<tr>
								<td height="25" align="center" bgcolor="#ffffff" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><strong>
										<font color="#000000">Month</font>
									</strong></td>
								<td align="center" bgcolor="#ffffff" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><strong>
										<font color="#000000">Plan Date</font>
									</strong></td>

							</tr>
							<?
							$selectp = "select CONVERT(nvarchar, plan_count_date, 103) as plan_count_datedate
					,* from tbdaily_report_hq_inventory where plan_count_date between '$startdate' and '$enddate' order by  plan_count_date asc";

							$rep = mssql_query($selectp);
							$nump = mssql_num_rows($rep);
							if ($nump > 0) {
								$ip = 0;
								while ($rowp = mssql_fetch_array($rep)) {
									$ip++;

							?>
									<tr align="center">
										<td height="25" bgcolor="#ffffff" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><strong>
												<font color="#000000"><?

																		echo date("F", strtotime($rowp['plan_count_date']));

																		?></font>
											</strong></td>
										<td style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><?= $rowp['plan_count_datedate'] ?></td>


									</tr>
								<?
								}
								?>
								<TR>
									<TD height="25" colspan="2" align="center" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><strong>ต้องโฟกัส อะไร</strong></TD>
								</TR>
								<?
								$selectp = "select CONVERT(nvarchar, plan_count_date, 103) as plan_count_datedate
					,* from tbdaily_report_hq_inventory where plan_count_date between '$startdate' and '$enddate' order by  plan_count_date asc";

								$rep = mssql_query($selectp);
								$nump = mssql_num_rows($rep);
								if ($nump > 0) {
									$ip = 0;
									while ($rowp = mssql_fetch_array($rep)) {
										$ip++;
								?>
										<TR>
											<TD height="25" align="center" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><?= $ip ?>.</TD>
											<TD height="25" align="center" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><?
																																											echo lang_thai_from_database($rowp['focus_inven']);
																																											?></TD>
										</TR>

							<?
									}
								}
							}
							?>

						</table>
					</div>
				</div>
				<div class="row equal" style="margin-left:0px; margin-right:0px">

					<div class="col-md-6">
						<table width="100%" cellspacing="0" cellpadding="0">
							<tr>
								<td height="25" colspan="6" align="center" bgcolor="#C6E0B4" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><strong>
										<font color="#000000">5S. Monthly audit</font>
									</strong></td>
							</tr>
							<tr bgcolor="#C6E0B4">
								<td width="131" height="25" align="center" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><strong>
										<font color="#000000">Month</font>
									</strong></td>
								<td width="253" align="center" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><strong>
										<font color="#000000">Audit Date</font>
									</strong></td>
								<td width="270" align="center" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><strong>
										<font color="#000000">Team</font>
									</strong></td>

								<td width="275" align="center" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><strong>
										<font color="#000000">Score</font>
									</strong></td>

							</tr>
							<?
							$selectp = "select CONVERT(nvarchar, date_audit, 103) as date_auditdate,* from tbdaily_report_activity_5s_audit where date_audit between '$startdate' and '$enddate' and site='HQ'";

							$rep = mssql_query($selectp);
							$nump = mssql_num_rows($rep);
							if ($nump > 0) {
								$ip = 0;
								while ($rowp = mssql_fetch_array($rep)) {
									$ip++;
							?>
									<tr align="center">
										<td height="25" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><?
																																							//$monthName = date('F', mktime(0, 0, 0, $monthNum, 10)); // March
																																							echo date("F", strtotime($rowp['date_audit']));
																																							?></td>
										<td style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><?= $rowp['date_auditdate'] ?></td>
										<td style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><?= $rowp['team_audit'] ?></td>
										<td style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><?= $rowp['score_audit'] ?></td>


									</tr>
							<?
								}
							}

							?>
						</table>
						<table width="100%" cellspacing="0" cellpadding="0">

							<tr>
								<td height="25" colspan="2" align="center" bgcolor="#C6E0B4" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><strong>
										<font color="#000000">Last audit comment</font>
									</strong></td>
							</tr>

							<?
							$pre_month_year = date("m/1/Y", strtotime("$mmonth/1/$yyear -1 month"));
							$deceased_month = date("m",strtotime($pre_month_year));
							$deceased_year = date("Y",strtotime($pre_month_year));
							$selectp = "SELECT CONVERT(nvarchar, date_audit, 103) as date_auditdate,* 
							from tbdaily_report_activity_5s_audit_comment where site='$tsite' AND Month(date_audit)='$deceased_month' AND YEAR(date_audit)='$deceased_year' order by date_audit desc";

							$rep = mssql_query($selectp);
							$nump = mssql_num_rows($rep);
							if ($nump > 0) {
								$ip = 0;
								while ($rowp = mssql_fetch_array($rep)) {
									$ip++;
							?>
									<tr align="center">
										<td width="29%" height="25" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><?= $rowp['date_auditdate'] ?></td>
										<td width="71%" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><?= lang_thai_from_database($rowp['comment_audit']) ?></td>
									</tr>
							<?
								}
							}
							?>

						</table>
					</div>
					<div class="col-md-6">
						<table width="100%" cellspacing="0" cellpadding="0">
							<tr>
								<td height="25" colspan="6" align="center" bgcolor="#9BC2E6" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><strong>
										<font color="#000000">Improvement</font>
									</strong></td>
							</tr>
							<tr>
								<td width="96" height="25" align="center" bgcolor="#9BC2E6" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><strong>
										<font color="#000000">Month</font>
									</strong></td>
								<td width="424" align="center" bgcolor="#FFFFFF" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><strong>
										<font color="#000000">Topic</font>
									</strong></td>
								<td width="96" align="center" bgcolor="#FFFFFF" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><strong>
										<font color="#000000">Status</font>
									</strong></td>

								<td width="123" align="center" bgcolor="#FFFFFF" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><strong>
										<font color="#000000">PIC</font>
									</strong></td>
								<td width="190" align="center" bgcolor="#FFFFFF" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><strong>
										<font color="#000000">Due date</font>
									</strong></td>
							</tr>
							<?
							$selectp = "select CONVERT(nvarchar, month_improve, 103) as month_improvedate,
					 CONVERT(nvarchar, due_improve, 103) as due_improvedate,
					* from tbdaily_report_activity_improvement where month_improve between '$startdate' and '$enddate' and site='HQ'";

							$rep = mssql_query($selectp);
							$nump = mssql_num_rows($rep);
							if ($nump > 0) {
								$ip = 0;
								while ($rowp = mssql_fetch_array($rep)) {
									$ip++;
							?>
									<tr align="center">
										<td height="25" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><?
																																							echo date("F", strtotime($rowp['month_improve']));
																																							?></td>
										<td style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><?= lang_thai_from_database($rowp['topic_improve']) ?></td>
										<td style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><?= lang_thai_from_database($rowp['status_improve']) ?></td>
										<td style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><?= lang_thai_from_database($rowp['pic_improve']) ?></td>

										<td style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><?= $rowp['due_improvedate'] ?></td>
									</tr>
							<?
								}
							}
							?>

						</table>
					</div>
				</div>
				<div class="row equal" style="margin-left:0px; margin-right:0px">
					<div class="col-md-12">
						<table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'">
							<tr>
								<td height="20" bgcolor="#FFFF00"><strong>7. Morning Meeting</strong></td>
							</tr>
						</table>
					</div>
					<div class="col-md-6">

						<table width="100%" cellspacing="0" cellpadding="0">
							<tr>
								<td height="25" colspan="8" align="center" bgcolor="#19C3FF" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><strong>
										<font color="#000000">Morning Meeting in&nbsp;
										<?
											echo date("F", strtotime($startdate));
											echo "&nbsp;";
											echo $yyear;
										?>
										</font>
									</strong></td>
							</tr>
							<tr>
								<td width="96" height="25" align="center" bgcolor="#19C3FF" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><strong>
										<font color="#000000">Date</font>
									</strong></td>
								<td width="424" align="center" bgcolor="#FFFFFF" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><strong>Day Name</strong></td>
								<td width="424" align="center" bgcolor="#FFFFFF" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><strong>Type</strong></td>
								<td width="424" align="center" bgcolor="#FFFFFF" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><strong>
										<font color="#000000">Detail Information</font>
									</strong></td>
								<td width="96" align="center" bgcolor="#FFFFFF" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><strong>
										<font color="#000000">Status</font>
									</strong></td>



							</tr>
							<?
							$selectp = "select CONVERT(nvarchar, report_date, 103) as report_datedate,
					* from tbdaily_report_morning_meeting where report_date between '$startdate' and '$enddate' and site='HQ'
					order by report_date desc";

							$rep = mssql_query($selectp);
							$nump = mssql_num_rows($rep);
							if ($nump > 0) {
								$ip = 0;
								while ($rowp = mssql_fetch_array($rep)) {
									$ip++;

									if ($rowp['status_meeting'] == 'On progress') {
										$bg_status = "#FFFF00";
									}else if ($rowp['status_meeting'] == 'Complete') {
										$bg_status = "#00B050";
									}else if ($rowp['status_meeting'] == 'Delay') {
										$bg_status = "#FF0000";
									}else {
										$bg_status = "#FF0000";
									}

									#FFFF00
							?>
									<tr align="center">
										<td height="25" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><?
																																							echo $rowp['report_datedate'];
																																							?></td>
										<td style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><?
																																				echo date("D", strtotime($rowp['report_date']));
																																				?></td>
										<td style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><?= $rowp['type_meeting'] ?></td>
										<td style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><?= lang_thai_from_database($rowp['detail_meeting']) ?></td>
										<td style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'" bgcolor="<?= $bg_status ?>"><?= $rowp['status_meeting'] ?></td>

									</tr>
							<?
								}
							}
							?>

						</table>
					</div>
					<div class="col-md-6">
						<table width="100%" cellspacing="0" cellpadding="0">
							<tr>
								<td height="25" colspan="8" align="center" bgcolor="#FF9900" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><strong>
										<font color="#000000">Morning Meeting Delay Job</font>
									</strong></td>
							</tr>
							<tr>
								<td width="96" height="25" align="center" bgcolor="#FF9900" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><strong>
										<font color="#000000">Date</font>
									</strong></td>
								<td width="424" align="center" bgcolor="#FFFFFF" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><strong>Day Name</strong></td>
								<td width="424" align="center" bgcolor="#FFFFFF" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><strong>Type</strong></td>
								<td width="424" align="center" bgcolor="#FFFFFF" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><strong>
										<font color="#000000">Detail Information</font>
									</strong></td>
								<td width="96" align="center" bgcolor="#FFFFFF" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><strong>
										<font color="#000000">Status</font>
									</strong></td>



							</tr>
							<?
							$selectp = "select CONVERT(nvarchar, report_date, 103) as report_datedate,
					* from tbdaily_report_morning_meeting where report_date < '$startdate'  and site='HQ' and status_meeting not in('Complete')
					order by report_date desc";

							$rep = mssql_query($selectp);
							$nump = mssql_num_rows($rep);
							if ($nump > 0) {
								$ip = 0;
								while ($rowp = mssql_fetch_array($rep)) {
									$ip++;

									if ($rowp['status_meeting'] == 'On progress') {
										$bg_status = "#FFFF00";
									}else if ($rowp['status_meeting'] == 'Complete') {
										$bg_status = "#00B050";
									}else if ($rowp['status_meeting'] == 'Delay') {
										$bg_status = "#FF0000";
									}else {
										$bg_status = "#FF0000";
									}

									#FFFF00
							?>
									<tr align="center">
										<td height="25" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><?
																																							echo $rowp['report_datedate'];
																																							?></td>
										<td style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><?
																																				echo date("D", strtotime($rowp['report_date']));
																																				?></td>
										<td style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><?= $rowp['type_meeting'] ?></td>
										<td style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><?= lang_thai_from_database($rowp['detail_meeting']) ?></td>
										<td style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'" bgcolor="<?= $bg_status ?>"><?= $rowp['status_meeting'] ?></td>

									</tr>
							<?
								}
							}
							?>

						</table>
					</div>
				</div>

			</td>
		</tr>



	</table>








<?


}
if ($status == 'show_daily_osw') {

	$mmonth = (int) $_POST['mmonth'];
	$tsite = $_POST['tsite2'];
	$yyear = $_POST['yyear'];
	$ddate = $_POST['ddate'];
	$workday_q = $mmonth . "/" . $ddate . "/" . $yyear;

	$select_emp_day = "SELECT report_by,approve_by from tbdaily_report_osw where workdate = '$workday_q' AND shift='Day'";
	$re_emp_day = mssql_query($select_emp_day);
	$num_emp_day = mssql_num_rows($re_emp_day);
	if ($num_emp_day > 0) {
		$row_emp_day = mssql_fetch_array($re_emp_day);
		$report_by_day = get_full_name($row_emp_day['report_by']);
		$approve_by = get_full_name($row_emp_day['approve_by']);
		$pic_report_day = "<img src='emppic/" . $row_emp_day['report_by'] . "' height='50'>";
		$pic_approve = "<img src='emppic/" . $row_emp_day['approve_by'] . "' height='50'>";
	}

	$select_emp_night = "SELECT report_by,approve_by from tbdaily_report_osw where workdate = '$workday_q' AND shift='Night'";
	$re_emp_night = mssql_query($select_emp_night);
	$num_emp_night = mssql_num_rows($re_emp_night);
	if ($num_emp_night > 0) {
		$row_emp_night = mssql_fetch_array($re_emp_night);
		$report_by_night = get_full_name($row_emp_night['report_by']);
		// $approve_by_night = get_full_name($row_emp_night['approve_by']);
		$pic_report_night = "<img src='emppic/" . $row_emp_night['report_by'] . "' height='50'>";
		// $pic_approve = "<img src='emppic/" . $row_emp['approve_by'] . "' height='50'>";
	}

	//$month = $_POST['month'];
	//	$tsite = $_POST['tsite2'];
	//	$month_explode_arr = explode("-", $month);
	//	$mmonth = $month_explode_arr[1];
	//	$yyear = $month_explode_arr[0];

	$number = cal_days_in_month(CAL_GREGORIAN, $mmonth, $yyear);
	$startdate = $yyear . "-" . $mmonth . "-01";
	$enddate = $yyear . "-" . $mmonth . "-" . $number;


	if ($tsite == 'TSC') {
		$table_name = "tbdaily_report_tsc";
	} else if ($tsite == 'HQ') {
		$table_name = "tbdaily_report_hq";
	} else if ($tsite == 'OSW') {
		$table_name = "tbdaily_report_osw";
	}

?>





	<table border="0" cellspacing="0" cellpadding="0" class="table table-striped table-bordered datatables">


		<tr>
			<td height="80" style="padding:0px">

				<table width="100%" border="0" cellspacing="0" cellpadding="0">

					<tr>
						<td colspan="5" height="40" bgcolor="#002060" align="center" valign="middle"><img src="images/ipack-logo-mb-2.png" style="float:left"><strong>
								<font color="#FFFFFF" size="5">OSW Daily Operation Report.</font>
							</strong></td>
					</tr>
					<tr>
						<td width="15%" height="120" align="center" bgcolor="#C00000"><strong>
								<font color="#FFFFFF" size="3">Date:</font>
							</strong></td>
						<td align="center" width="15%"><strong>
								<font color="#000000" size="3"><?
																echo $ddate;
																echo "-";
																echo date("F", strtotime($startdate));
																echo "-";
																echo $yyear;
																?></font>
							</strong></td>
						<td width="15%" align="center" bgcolor="#C00000"><strong>
								<font color="#FFFFFF" size="3">Shift:A,B</font>
							</strong></td>
						<td align="center" width="15%"><strong>
								<font color="#000000" size="3">DAY,Night</font>
							</strong></td>
						<td align="center" width="40%">
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td width="30%" height="60" align="center" bgcolor="#FFE699" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; " rowspan="2"><strong>Report By:</strong></td>
									<td width="30%" align="center" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; ">(Day) <?= $report_by_day ?></td>
									<td width="30%" align="center" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; "><?= $pic_report_day ?></td>
								</tr>
								<tr>
									<td width="30%" align="center" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; ">(Night) <?= $report_by_night ?></td>
									<td width="30%" align="center" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; "><?= $pic_report_night ?></td>
								</tr>
								<tr>
									<td height="60" align="center" bgcolor="#FFE699" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; "><strong>Approve By:</strong></td>
									<td align="center" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; "><?= $approve_by ?></td>
									<td align="center" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; "><?= $pic_approve ?></td>
								</tr>
							</table>
						</td>
					</tr>
				</table>

		</tr>
		</td>


		<tr>
			<td align="center" bgcolor="#ffffff" style="padding:0px">

				<table border="0" cellspacing="1" cellpadding="0">

					<tr>
						<td align="left" width="331" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#DBDBDB">&nbsp;</td>
						<td align="center" width="86" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#8EA9DB">&nbsp;</td>
						<?

						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";
						//echo $select0;
						//exit();
						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

						?>
								<td align='center' width='70' style='border-right:1px solid; border-bottom:1px solid;border-top:1px solid;' bgcolor="#ffffff">
									<?
									//date("d", strtotime($row0['workdate']));
									if ($ddate == date("d", strtotime($row0['workdate']))) {
									?><img src="images/point.jpg" width="20">
									<?
									}
									?>
								</td>
						<?


							}
						}

						?>
					</tr>
					<tr>
						<td align="left" width="331" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#DBDBDB"><strong>1. SAFETY.</strong></td>
						<td align="center" width="86" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#8EA9DB"><strong>DATE : </strong></td>
						<?

						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";
						//echo $select0;
						//exit();
						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

						?>
								<td align='center' width='70' style='border-right:1px solid; border-bottom:1px solid; color:#FFF' bgcolor="#595959"><strong>
										<?= date("d", strtotime($row0['workdate'])) ?>
									</strong></td>
						<?


							}
						}

						?>
					</tr>


					<!--/// safety_human ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF"><strong>1.1 Human ( Case )<BR>อุบัติเหตุที่เกิดขึ้นกับคน</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Case</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT sum(safety_human) as safety_human FROM    $table_name where workdate ='" . $row0['workdate'] . "' ";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$safety_human = $row1['safety_human'];
								} else {
									$safety_human = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>"><strong>
										<?
										echo $safety_human;
										?>
									</strong></td>
						<?


							}
						}

						?>
					</tr>
					<!--/// safety_human ///-->

					<!--/// safety_part ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF"><strong>1.2 Part ( Pcs.)<BR>อุบัติเหตุที่เกิดขึ้นกับชิ้นงาน</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Pcs</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT sum(safety_part) as safety_part FROM    $table_name where workdate ='" . $row0['workdate'] . "' ";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$safety_part = $row1['safety_part'];
								} else {
									$safety_part = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>"><strong>
										<?
										echo $safety_part;
										?>
									</strong></td>
						<?


							}
						}

						?>
					</tr>
					<!--/// safety_part ///-->

					<!--/// safety_nearmiss ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF"><strong>1.3 Near miss ( Case )<BR>อุบัติเหตุหรือเหตุการณ์ที่อาจทำให้เกิดอุบัติเหตุได้</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Case</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT sum(safety_nearmiss) as safety_nearmiss FROM    $table_name where workdate ='" . $row0['workdate'] . "' ";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$safety_nearmiss = $row1['safety_nearmiss'];
								} else {
									$safety_nearmiss = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>"><strong>
										<?
										echo $safety_nearmiss;
										?>
									</strong></td>
						<?


							}
						}

						?>
					</tr>
					<!--/// safety_nearmiss ///-->

					<!--/// safety_target ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFF00"><strong>Result Performance</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#92D050"><strong>%</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								$bg_day = "#FFE699";

								$select1 = "SELECT safety_target FROM    $table_name where workdate ='" . $row0['workdate'] . "' ";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$safety_target = $row1['safety_target'] . "%";
								} else {
									$safety_target = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>"><strong>
										<?
										echo $safety_target;

										?>
									</strong></td>
						<?


							}
						}

						?>
					</tr>
					<!--/// safety_target ///-->


					<tr>
						<td height="20" colspan="2" align="left" bgcolor="#DBDBDB" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px"><strong>2. 5S. Daily</strong><strong></strong></td>
						<?

						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#FFF' bgcolor="#595959"><strong>
										<?= date("d", strtotime($row0['workdate'])) ?>
									</strong></td>
						<?


							}
						}

						?>
					</tr>


					<!--/// ss_daily ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#00FFFF"><strong>1.Ware house Area</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#00FFFF"><strong></strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {


								$bg_day = "#00FFFF";

								$select1 = "SELECT ss_daily FROM    $table_name where workdate ='" . $row0['workdate'] . "' ";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									if ($row1['ss_daily'] != '') {
										$ss_daily = "<a href='" . $row1['ss_daily'] . "' target='_blank'>Link</a>";
									} else {
										$ss_daily = '';
									}
								} else {
									$ss_daily = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>"><strong>
										<?
										echo $ss_daily;
										?>
									</strong></td>
						<?


							}
						}

						?>
					</tr>
					<!--/// ss_daily ///-->

					<!--/// ss_daily_day ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#00FFFF"><strong>Day</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#00FFFF"><strong></strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {


								$bg_day = "#00FFFF";

								$select1 = "SELECT ss_daily_status FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Day' ";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									if ($row1['ss_daily_status'] != '') {
										$arr_ss_daily_status = explode(",", $row1['ss_daily_status']);
										$ss_daily_status = $arr_ss_daily_status[0] . "<br>" . $arr_ss_daily_status[1];
									} else {
										$ss_daily_status = '';
									}
								} else {
									$ss_daily_status = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>"><strong>
										<?
										echo $ss_daily_status;
										?>
									</strong></td>
						<?


							}
						}

						?>
					</tr>
					<!--/// ss_daily_day ///-->

					<!--/// ss_daily_night ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#00FFFF"><strong>Night</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#00FFFF"><strong></strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

								$bg_day = "#00FFFF";

								$select1 = "SELECT ss_daily_status FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Night'";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									if ($row1['ss_daily_status'] != '') {
										$arr_ss_daily_status = explode(",", $row1['ss_daily_status']);
										$ss_daily_status = $arr_ss_daily_status[0] . "&nbsp;" . $arr_ss_daily_status[1];
									} else {
										$ss_daily_status = '';
									}
								} else {
									$ss_daily_status = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>"><strong>
										<?
										echo $ss_daily_status;
										?>
									</strong></td>
						<?


							}
						}

						?>
					</tr>
					<!--/// ss_daily_night ///-->

					<!--/// ss_daily_percent ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#ffffff"><strong>Status Check </strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#ffffff"><strong>%</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {


								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT ss_daily_percent FROM    $table_name where workdate ='" . $row0['workdate'] . "' ";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									if ($row1['ss_daily_percent'] != '') {
										$ss_daily_percent = $row1['ss_daily_percent'] . "%";
									} else {
										$ss_daily_percent = '';
									}
								} else {
									$ss_daily_percent = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>"><strong>
										<?
										echo $ss_daily_percent;
										?>
									</strong></td>
						<?


							}
						}

						?>
					</tr>
					<!--/// ss_daily_percent ///-->


					<tr>
						<td height="20" colspan="2" align="left" bgcolor="#DBDBDB" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px"><strong>3. TIME ATTENDANCE.</strong><strong></strong></td>
						<?

						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#FFF' bgcolor="#595959"><strong>
										<?= date("d", strtotime($row0['workdate'])) ?>
									</strong></td>
						<?


							}
						}

						?>
					</tr>


					<!--/// att_asst_mgr ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF"><strong>- Asst,wh MGR</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Prs.</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT sum(att_asst_mgr) as att_asst_mgr FROM    $table_name where workdate ='" . $row0['workdate'] . "' ";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$att_asst_mgr = $row1['att_asst_mgr'];
								} else {
									$att_asst_mgr = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>"><strong>
										<?
										echo $att_asst_mgr;
										?>
									</strong></td>
						<?


							}
						}

						?>
					</tr>
					<!--/// att_asst_mgr ///-->

					<!--/// Operator Day shift ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#f9af00"><strong>3.1 Operator Day shift</strong></td>
						<td align="center" height="20" style="border-right:0px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong></strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
											
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


						?>
								<td align='center' style='border-right:0px solid; border-bottom:1px solid; color:#000000' bgcolor="">
									<strong>
										
									</strong>
								</td>
						<?


							}
						}

						?>
					</tr>
					<!--/// Operator Day shift ///-->

					<!--/// att_supervisor ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF"><strong>- Supervisor</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Prs.</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT att_supervisor FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Day'";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$att_supervisor = $row1['att_supervisor'];
								} else {
									$att_supervisor = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>"><strong>
										<?
										echo $att_supervisor;
										?>
									</strong></td>
						<?


							}
						}

						?>
					</tr>
					<!--/// att_supervisor ///-->

					<!--/// att_leader ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF"><strong>- Leader</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Prs.</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT att_leader FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Day'";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$att_leader = $row1['att_leader'];
								} else {
									$att_leader = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>"><strong>
										<?
										echo $att_leader;
										?>
									</strong></td>
						<?


							}
						}

						?>
					</tr>
					<!--/// att_leader ///-->

					<!--/// att_operator ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF"><strong>- Operator</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Prs.</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT att_operator FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Day'";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$att_operator = $row1['att_operator'];
								} else {
									$att_operator = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>"><strong>
										<?
										echo $att_operator;
										?>
									</strong></td>
						<?


							}
						}

						?>
					</tr>
					<!--/// att_operator ///-->


					<!--/// att_late ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF"><strong>- Late</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Prs.</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT att_late FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Day'";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$att_late = $row1['att_late'];
								} else {
									$att_late = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>"><strong>
										<?
										echo $att_late;
										?>
									</strong></td>
						<?


							}
						}

						?>
					</tr>
					<!--/// att_late ///-->

					<!--/// Operator Night shift ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#8de5ff"><strong>3.1 Operator Night shift</strong></td>
						<td align="center" height="20" style="border-right:0px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong></strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
											
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


						?>
								<td align='center' style='border-right:0px solid; border-bottom:1px solid; color:#000000' bgcolor="">
									<strong>
										
									</strong>
								</td>
						<?


							}
						}

						?>
					</tr>
					<!--/// Operator Night shift ///-->

					<!--/// att_supervisor Night ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF"><strong>- Supervisor</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Prs.</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT att_supervisor FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Night'";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$att_supervisor = $row1['att_supervisor'];
								} else {
									$att_supervisor = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>"><strong>
										<?
										echo $att_supervisor;
										?>
									</strong></td>
						<?


							}
						}

						?>
					</tr>
					<!--/// att_supervisor Night ///-->

					<!--/// att_leader Night ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF"><strong>- Leader</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Prs.</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT att_leader FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Night'";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$att_leader = $row1['att_leader'];
								} else {
									$att_leader = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>"><strong>
										<?
										echo $att_leader;
										?>
									</strong></td>
						<?


							}
						}

						?>
					</tr>
					<!--/// att_leader Night ///-->

					<!--/// att_operator Night ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF"><strong>- Operator</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Prs.</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT att_operator FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Night'";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$att_operator = $row1['att_operator'];
								} else {
									$att_operator = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>"><strong>
										<?
										echo $att_operator;
										?>
									</strong></td>
						<?


							}
						}

						?>
					</tr>
					<!--/// att_operator Night ///-->


					<!--/// att_late Night ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF"><strong>- Late</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Prs.</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT att_late FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Night'";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$att_late = $row1['att_late'];
								} else {
									$att_late = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>"><strong>
										<?
										echo $att_late;
										?>
									</strong></td>
						<?


							}
						}

						?>
					</tr>
					<!--/// att_late Night ///-->


					<!--/// att_plan ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF">&nbsp;</td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Plan</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT sum(att_plan) as att_plan FROM    $table_name where workdate ='" . $row0['workdate'] . "' ";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$att_plan = $row1['att_plan'];
								} else {
									$att_plan = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>"><strong>
										<?
										echo $att_plan;
										?>
									</strong></td>
						<?


							}
						}

						?>
					</tr>
					<!--/// att_plan ///-->

					<!--/// att_total ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF">&nbsp;</td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Total</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT sum(att_total) as att_total FROM    $table_name where workdate ='" . $row0['workdate'] . "' ";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$att_total = $row1['att_total'];
								} else {
									$att_total = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>"><strong>
										<?
										echo $att_total;
										?>
									</strong></td>
						<?


							}
						}

						?>
					</tr>
					<!--/// att_total ///-->

					<!--/// att_total_percent ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFF00"><strong>Total attendance (%)/Day.</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#92D050"><strong>%</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

								$bg_day = "#FFE699";


								$select1 = "SELECT (sum(att_total)* 100 / (Select sum(att_plan) From $table_name where workdate ='" . $row0['workdate'] . "')) as att_total_percent FROM    $table_name where workdate ='" . $row0['workdate'] . "' ";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									if ($row1['att_total_percent'] != '') {
										if($row1['att_total_percent']>100){
											$att_total_percent = "100%";
										}else{

											$att_total_percent = $row1['att_total_percent'] . "%";
										}
									} else {
										$att_total_percent = '';
									}
								} else {
									$att_total_percent = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>"><strong>
										<?
										echo $att_total_percent;
										?>
									</strong></td>
						<?


							}
						}

						?>
					</tr>
					<!--/// att_total_percent ///-->

					<!--/// att_achieve ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFF00"><strong>Status achieve</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#92D050">&nbsp;</td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

								$bg_day = "#FFE699";


								$select1 = "SELECT (sum(att_total)* 100 / (Select sum(att_plan) From $table_name where workdate ='" . $row0['workdate'] . "')) as att_total_percent FROM    $table_name where workdate ='" . $row0['workdate'] . "' ";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									if ($row1['att_total_percent'] != '') {
										if($row1['att_total_percent'] > 87){
											$att_achieve = "<font color='#00B050'>On</font>";
										} else if($row1['att_total_percent'] > 0){
											$att_achieve = "<font color='#FF0000'>Not</font>";
										}
									} else {
										$att_achieve = '';
									}
								} else {
									$att_achieve = '';
								}
									


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>"><strong>
										<a href="javascript:void(0)" onclick="show_att('<?=$row0['workdate3']?>')">
										<?
										echo $att_achieve.$att_total_percent;
										?>
										</a>
									</strong></td>
						<?


							}
						}

						?>
					</tr>
					<!--/// att_achieve ///-->

					<!-- Fork lift -->
					<tr>
						<td height="20" colspan="2" align="left" bgcolor="#DBDBDB" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px"><strong>Fork lift</strong><strong></strong></td>
						<?

						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#FFF' bgcolor="#595959"><strong>
										<?= date("d", strtotime($row0['workdate'])) ?>
									</strong></td>
						<?


							}
						}

						?>
					</tr>
					<!-- Fork lift -->

					<!--/// att_forklift_day ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF"><strong>- Day shift</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Prs.</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT att_forklift_name FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Day'";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$att_forklift_name = lang_thai_from_database($row1['att_forklift_name']);
								} else {
									$att_forklift_name = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>"><strong>
										<?
										echo $att_forklift_name;
										?>
									</strong></td>
						<?


							}
						}

						?>
					</tr>
					<!--/// att_forklift_day ///-->

					<!--/// att_forklift_night ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF"><strong>- Night shift</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Prs.</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT att_forklift_name FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Night'";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$att_forklift_name = lang_thai_from_database($row1['att_forklift_name']);
								} else {
									$att_forklift_name = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>"><strong>
										<?
										echo $att_forklift_name;
										?>
									</strong></td>
						<?


							}
						}

						?>
					</tr>
					<!--/// att_forklift_night ///-->

					<!-- 4. OT Work -->
					<tr>
						<td height="20" colspan="2" align="left" bgcolor="#DBDBDB" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px"><strong>4. OVERTIME</strong><strong></strong></td>
						<?

						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#FFF' bgcolor="#595959"><strong>
										<?= date("d", strtotime($row0['workdate'])) ?>
									</strong></td>
						<?


							}
						}

						?>
					</tr>
					<!-- 4. OT Work -->

					<!--/// OT Day shift ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#f9af00"><strong>4.1 OT Day shift</strong></td>
						<td align="center" height="20" style="border-right:0px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong></strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
											
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


						?>
								<td align='center' style='border-right:0px solid; border-bottom:1px solid; color:#000000' bgcolor="">
									<strong>
										
									</strong>
								</td>
						<?


							}
						}

						?>
					</tr>
					<!--/// OT Day shift ///-->
					<!--/// ot_asst_mgr_prs Day ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF"><strong>- Asst,wh MGR</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Prs./Hrs.</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								//$bg_day = "#FFFFFF";
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT ot_asst_mgr_prs,ot_asst_mgr_hrs FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Day'";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$ot_asst_mgr_prs = $row1['ot_asst_mgr_prs'];
									$ot_asst_mgr_hrs = $row1['ot_asst_mgr_hrs'];
								} else {
									$ot_asst_mgr_prs = '';
									$ot_asst_mgr_hrs = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
									<?
									if ($num1 != '') {
										echo $ot_asst_mgr_prs;
									?>&nbsp;<strong>/</strong>&nbsp;<?
											echo $ot_asst_mgr_hrs;
										}
											?>

								</td>
						<?


							}
						}

						?>
					</tr>
					<!--/// ot_asst_mgr_prs Day ///-->

					<!--/// ot_supervisor_prs, ot_supervisor_hrs Day ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF"><strong>- Supervisor</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Prs./Hrs.</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								//$bg_day = "#FFFFFF";
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT ot_supervisor_prs, ot_supervisor_hrs FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Day'";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$ot_supervisor_prs = $row1['ot_supervisor_prs'];
									$ot_supervisor_hrs = $row1['ot_supervisor_hrs'];
								} else {
									$ot_supervisor_prs = '';
									$ot_supervisor_hrs = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
									<?
									if ($num1 != '') {
										echo $ot_supervisor_prs;
									?>&nbsp;<strong>/</strong>&nbsp;<?
											echo $ot_supervisor_hrs;
										}
											?>
								</td>
						<?


							}
						}

						?>
					</tr>
					<!--/// ot_supervisor_prs, ot_supervisor_hrs Day ///-->

					<!--/// ot_leader_prs, ot_leader_hrs Day ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF"><strong>- Leader</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Prs./Hrs.</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								//$bg_day = "#FFFFFF";
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT ot_leader_prs, ot_leader_hrs FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Day'";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$ot_leader_prs = $row1['ot_leader_prs'];
									$ot_leader_hrs = $row1['ot_leader_hrs'];
								} else {
									$ot_leader_prs = '';
									$ot_leader_hrs = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
									<?
									if ($num1 != '') {
										echo $ot_leader_prs;
									?>&nbsp;<strong>/</strong>&nbsp;<?
											echo $ot_leader_hrs;
										}
											?>
								</td>
						<?


							}
						}

						?>
					</tr>
					<!--/// ot_leader_prs, ot_leader_hrs Day ///-->

					<!--/// ot_operator_prs, ot_operator_hrs Day ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF"><strong>- Operator</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Prs./Hrs.</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								//$bg_day = "#FFFFFF";
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT ot_operator_prs, ot_operator_hrs FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Day'";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$ot_operator_prs = $row1['ot_operator_prs'];
									$ot_operator_hrs = $row1['ot_operator_hrs'];
								} else {
									$ot_operator_prs = '';
									$ot_operator_hrs = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
									<?
									if ($num1 > 0) {
										echo $ot_operator_prs;
									?>&nbsp;<strong>/</strong>&nbsp;<?
											echo $ot_operator_hrs;
										}
											?>
								</td>
						<?


							}
						}

						?>
					</tr>
					<!--/// ot_operator_prs, ot_operator_hrs Day ///-->

					<!--/// ot_target Day ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF"><strong>Target Day shift</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Hrs.</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								//$bg_day = "#FFFFFF";
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT ot_target FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Day'";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$ot_target = $row1['ot_target'];
								} else {
									$ot_target = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
									<strong>
										<?= $ot_target ?>
									</strong></td>
						<?


							}
						}

						?>
					</tr>
					<!--/// ot_target Day ///-->

					<!--/// ot_actual Day ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF"><strong>Actual Day shift</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Hrs.</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								//$bg_day = "#FFFFFF";
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT ot_actual FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Day'";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$ot_actual = $row1['ot_actual'];
								} else {
									$ot_actual = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
									<strong>
										<?= $ot_actual ?>
									</strong></td>
						<?


							}
						}

						?>
					</tr>
					<!--/// ot_actual Day ///-->

					<!--/// OT Night shift ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#8de5ff"><strong>4.1 OT Night shift</strong></td>
						<td align="center" height="20" style="border-right:0px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong></strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
											
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


						?>
								<td align='center' style='border-right:0px solid; border-bottom:1px solid; color:#000000' bgcolor="">
									<strong>
										
									</strong>
								</td>
						<?


							}
						}

						?>
					</tr>
					<!--/// OT Night shift ///-->
					<!--/// ot_asst_mgr_prs Night ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF"><strong>- Asst,wh MGR</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Prs./Hrs.</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								//$bg_day = "#FFFFFF";
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT ot_asst_mgr_prs,ot_asst_mgr_hrs FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Night'";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$ot_asst_mgr_prs = $row1['ot_asst_mgr_prs'];
									$ot_asst_mgr_hrs = $row1['ot_asst_mgr_hrs'];
								} else {
									$ot_asst_mgr_prs = '';
									$ot_asst_mgr_hrs = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
									<?
									if ($num1 != '') {
										echo $ot_asst_mgr_prs;
									?>&nbsp;<strong>/</strong>&nbsp;<?
											echo $ot_asst_mgr_hrs;
										}
											?>

								</td>
						<?


							}
						}

						?>
					</tr>
					<!--/// ot_asst_mgr_prs Night ///-->

					<!--/// ot_supervisor_prs, ot_supervisor_hrs Night ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF"><strong>- Supervisor</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Prs./Hrs.</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								//$bg_day = "#FFFFFF";
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT ot_supervisor_prs, ot_supervisor_hrs FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Night'";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$ot_supervisor_prs = $row1['ot_supervisor_prs'];
									$ot_supervisor_hrs = $row1['ot_supervisor_hrs'];
								} else {
									$ot_supervisor_prs = '';
									$ot_supervisor_hrs = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
									<?
									if ($num1 != '') {
										echo $ot_supervisor_prs;
									?>&nbsp;<strong>/</strong>&nbsp;<?
											echo $ot_supervisor_hrs;
										}
											?>
								</td>
						<?


							}
						}

						?>
					</tr>
					<!--/// ot_supervisor_prs, ot_supervisor_hrs Night ///-->

					<!--/// ot_leader_prs, ot_leader_hrs Night ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF"><strong>- Leader</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Prs./Hrs.</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								//$bg_day = "#FFFFFF";
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT ot_leader_prs, ot_leader_hrs FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Night'";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$ot_leader_prs = $row1['ot_leader_prs'];
									$ot_leader_hrs = $row1['ot_leader_hrs'];
								} else {
									$ot_leader_prs = '';
									$ot_leader_hrs = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
									<?
									if ($num1 != '') {
										echo $ot_leader_prs;
									?>&nbsp;<strong>/</strong>&nbsp;<?
											echo $ot_leader_hrs;
										}
											?>
								</td>
						<?


							}
						}

						?>
					</tr>
					<!--/// ot_leader_prs, ot_leader_hrs Night ///-->

					<!--/// ot_operator_prs, ot_operator_hrs Night ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF"><strong>- Operator</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Prs./Hrs.</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								//$bg_day = "#FFFFFF";
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT ot_operator_prs, ot_operator_hrs FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Night'";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$ot_operator_prs = $row1['ot_operator_prs'];
									$ot_operator_hrs = $row1['ot_operator_hrs'];
								} else {
									$ot_operator_prs = '';
									$ot_operator_hrs = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
									<?
									if ($num1 > 0) {
										echo $ot_operator_prs;
									?>&nbsp;<strong>/</strong>&nbsp;<?
											echo $ot_operator_hrs;
										}
											?>
								</td>
						<?


							}
						}

						?>
					</tr>
					<!--/// ot_operator_prs, ot_operator_hrs Night ///-->

					<!--/// ot_target Night ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF"><strong>Target Night shift</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Hrs.</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								//$bg_day = "#FFFFFF";
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT ot_target FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Night'";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$ot_target = $row1['ot_target'];
								} else {
									$ot_target = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
									<strong>
										<?= $ot_target ?>
									</strong></td>
						<?


							}
						}

						?>
					</tr>
					<!--/// ot_target Night ///-->

					<!--/// ot_actual Night ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF"><strong>Actual Night shift</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Hrs.</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								//$bg_day = "#FFFFFF";
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT ot_actual FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Night'";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$ot_actual = $row1['ot_actual'];
								} else {
									$ot_actual = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
									<strong>
										<?= $ot_actual ?>
									</strong></td>
						<?


							}
						}

						?>
					</tr>
					<!--/// ot_actual Night ///-->

					<!--/// OT Day+Night shift ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#8dffa6"><strong>Day+Night shift</strong></td>
						<td align="center" height="20" style="border-right:0px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong></strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
											
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


						?>
								<td align='center' style='border-right:0px solid; border-bottom:1px solid; color:#000000' bgcolor="">
									<strong>
										
									</strong>
								</td>
						<?


							}
						}

						?>
					</tr>
					<!--/// OT Day+Night shift ///-->

					<!--/// ot_target Day+Night ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF"><strong>Total Target</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Hrs.</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								//$bg_day = "#FFFFFF";
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT sum(ot_target) as ot_target FROM    $table_name where workdate ='" . $row0['workdate'] . "' ";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$ot_target = $row1['ot_target'];
								} else {
									$ot_target = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
									<strong>
										<?= $ot_target ?>
									</strong></td>
						<?


							}
						}

						?>
					</tr>
					<!--/// ot_target Day+Night ///-->

					<!--/// ot_actual Day+Night ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF"><strong>Total Actual</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Hrs.</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								//$bg_day = "#FFFFFF";
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT sum(ot_actual) as ot_actual  FROM    $table_name where workdate ='" . $row0['workdate'] . "' ";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$ot_actual = $row1['ot_actual'];
								} else {
									$ot_actual = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
									<strong>
										<?= $ot_actual ?>
									</strong></td>
						<?


							}
						}

						?>
					</tr>
					<!--/// ot_actual Day+Night ///-->

					<!--/// ot_achieve ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFF00"><strong>Status achieve</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#92D050">&nbsp;</td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

								$bg_day = "#FFE699";


								$select00 = "SELECT ot_actual FROM    $table_name where workdate ='" . $row0['workdate'] . "' ";
								$re00 =  mssql_query($select00);
								$num00 = mssql_num_rows($re00);

								$select1 = "SELECT sum(ot_target) as ot_target,sum(ot_actual) as ot_actual FROM    $table_name where workdate ='" . $row0['workdate'] . "' ";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num00 > 0) {
									$row1 = mssql_fetch_array($re1);
									if ($row1['ot_target'] >= $row1['ot_actual']) {
										$ot_achieve = "<font color='#00B050'>On</font>";
									} else if ($row1['ot_target'] < $row1['ot_actual']) {
										$ot_achieve = "<font color='#FF0000'>Not</font>";
									} else {
										$ot_achieve = '';
									}
								} else {
									$ot_achieve = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>"><strong>
										<a href="javascript:void(0)" onclick="show_ot('<?=$row0['workdate3']?>')">
										<?
										echo $ot_achieve;
										?>
										</a>
									</strong></td>
						<?


							}
						}

						?>
					</tr>
					<!--/// ot_achieve ///-->

					<!-- 5.Opertion performance -->
					<tr>
						<td height="20" colspan="2" align="left" bgcolor="#DBDBDB" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px"><strong>5.Opertion performance</strong><strong></strong></td>
						<?

						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						$qty_col = 0;
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								$qty_col++;
							}
						}
						?>
						<td align='center' colspan="<?= $qty_col ?>" bgcolor="#DBDBDB"></td>
						<?
						?>
					</tr>
					<!-- 5.Opertion performance -->

					<tr>
						<td height="20" align="left" bgcolor="#FFFFFF" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px"><strong>5.1 Receive&Cleaning peformance</strong><strong></strong></td>
						<td bgcolor="#FFFFFF" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid"></td>
						<?

						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#FFF' bgcolor="#595959"><strong>
										<?= date("d", strtotime($row0['workdate'])) ?>
									</strong></td>
						<?


							}
						}

						?>
					</tr>


					<!--/// Day shift ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#f9af00"><strong>Day shift</strong></td>
						<td align="center" height="20" style="border-right:0px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong></strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
											
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


						?>
								<td align='center' style='border-right:0px solid; border-bottom:1px solid; color:#000000' bgcolor="">
									<strong>
										
									</strong>
								</td>
						<?


							}
						}

						?>
					</tr>
					<!--/// Day shift ///-->

					<!--/// per_receive_box Day ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF"><strong>Receive</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Box</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								//$bg_day = "#FFFFFF";
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT per_receive_box FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Day'";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$per_receive_box = $row1['per_receive_box'];
								} else {
									$per_receive_box = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
									<a href="javascript:void(0)" onclick="show_receive_box('<?=$row0['workdate3']?>','Day')">
									<strong>
										<?= $per_receive_box ?>
									</strong>
									</a>
								</td>
						<?


							}
						}

						?>
					</tr>
					<!--/// per_receive_box Day ///-->

					<!--/// per_cleaning_box Day ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF"><strong>Cleaning</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Box</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								//$bg_day = "#FFFFFF";
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT per_cleaning_box FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Day'";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$per_cleaning_box = $row1['per_cleaning_box'];
								} else {
									$per_cleaning_box = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
									<a href="javascript:void(0)" onclick="show_cleaning_box('<?=$row0['workdate3']?>','Day')">
									<strong>
										<?= $per_cleaning_box ?>
									</strong>
									</a>
								</td>
						<?


							}
						}

						?>
					</tr>
					<!--/// per_cleaning_box Day ///-->

					<!--/// Night shift ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#8de5ff"><strong>Night shift</strong></td>
						<td align="center" height="20" style="border-right:0px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong></strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
											
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


						?>
								<td align='center' style='border-right:0px solid; border-bottom:1px solid; color:#000000' bgcolor="">
									<strong>
										
									</strong>
								</td>
						<?


							}
						}

						?>
					</tr>
					<!--/// Night shift ///-->

					<!--/// per_receive_box Night ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF"><strong>Receive</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Box</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								//$bg_day = "#FFFFFF";
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT per_receive_box FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Night'";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$per_receive_box = $row1['per_receive_box'];
								} else {
									$per_receive_box = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
									<a href="javascript:void(0)" onclick="show_receive_box('<?=$row0['workdate3']?>','Night')">
									<strong>
										<?= $per_receive_box ?>
									</strong>
									</a>
								</td>
						<?


							}
						}

						?>
					</tr>
					<!--/// per_receive_box Night ///-->

					<!--/// per_cleaning_box Night ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF"><strong>Cleaning</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Box</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								//$bg_day = "#FFFFFF";
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT per_cleaning_box FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Night'";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$per_cleaning_box = $row1['per_cleaning_box'];
								} else {
									$per_cleaning_box = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
									<a href="javascript:void(0)" onclick="show_cleaning_box('<?=$row0['workdate3']?>','Night')">
									<strong>
										<?= $per_cleaning_box ?>
									</strong>
									</a>
								</td>
						<?


							}
						}

						?>
					</tr>
					<!--/// per_cleaning_box Night ///-->

					<!--/// Day+Night shift ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#8dffa6"><strong>Day+Night shift</strong></td>
						<td align="center" height="20" style="border-right:0px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong></strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
											
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


						?>
								<td align='center' style='border-right:0px solid; border-bottom:1px solid; color:#000000' bgcolor="">
									<strong>
										
									</strong>
								</td>
						<?


							}
						}

						?>
					</tr>
					<!--/// Day+Night shift ///-->

					<!--/// per_receive_box Day+Night ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF"><strong>Total Receive</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Box</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								//$bg_day = "#FFFFFF";
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT sum(per_receive_box) as per_receive_box FROM    $table_name where workdate ='" . $row0['workdate'] . "'";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$per_receive_box = $row1['per_receive_box'];
								} else {
									$per_receive_box = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
									<strong>
										<?= $per_receive_box ?>
									</strong>
								</td>
						<?


							}
						}

						?>
					</tr>
					<!--/// per_receive_box Day+Night ///-->
					
					<!--/// per_cleaning_box Day+Night ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF"><strong>Total Cleaning</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Box</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								//$bg_day = "#FFFFFF";
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT sum(per_cleaning_box) as per_cleaning_box FROM    $table_name where workdate ='" . $row0['workdate'] . "'";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$per_cleaning_box = $row1['per_cleaning_box'];
								} else {
									$per_cleaning_box = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
									<strong>
										<?= $per_cleaning_box ?>
									</strong>
								</td>
						<?


							}
						}

						?>
					</tr>
					<!--/// per_cleaning_box Day+Night ///-->

					<!--/// per_receive_box+per_cleaning_box Day+Night ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFF00"><strong>Result Performance</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#92D050">%</td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

								$bg_day = "#FFE699";


								$select1 = "SELECT (sum(per_cleaning_box)* 100 / (Select sum(per_receive_box) From $table_name where workdate ='" . $row0['workdate'] . "')) as per_total_percent FROM    $table_name where workdate ='" . $row0['workdate'] . "' ";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									if ($row1['per_total_percent'] != '') {
										$per_total_percent = $row1['per_total_percent'] . "%";
									} else {
										$per_total_percent = '';
									}
								} else {
									$per_total_percent = '';
								}

						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
									<strong>
										<?
										echo $per_total_percent;
										?>
									</strong>
								</td>
						<?


							}
						}

						?>
					</tr>
					<!--/// per_receive_box+per_cleaning_box Day+Night ///-->

					

					<tr>
						<td height="20" align="left" bgcolor="#FFFFFF" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px"><strong>5.2 Issue on time</strong><strong></strong></td>
						<td bgcolor="#FFFFFF" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid"></td>
						<?

						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#FFF' bgcolor="#595959"><strong>
										<?= date("d", strtotime($row0['workdate'])) ?>
									</strong></td>
						<?


							}
						}

						?>
					</tr>

					<!--/// 5.2 Day shift ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#f9af00"><strong>Day shift</strong></td>
						<td align="center" height="20" style="border-right:0px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong></strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
											
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


						?>
								<td align='center' style='border-right:0px solid; border-bottom:1px solid; color:#000000' bgcolor="">
									<strong>
										
									</strong>
								</td>
						<?


							}
						}

						?>
					</tr>
					<!--/// 5.2 Day shift ///-->

					<!--/// issue_on_time_target Day ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF">Target Issue order on time</td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Time</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								//$bg_day = "#FFFFFF";
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT issue_on_time_target FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Day'";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$issue_on_time_target = $row1['issue_on_time_target'];
								} else {
									$issue_on_time_target = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
									<a href="javascript:void(0)" onclick="show_issue_on_time('<?=$row0['workdate3']?>','Day')">
									<strong>
									<?
									echo $issue_on_time_target;
									?>
									</strong>
									</a>
								</td>
						<?


							}
						}



						?>
					</tr>
					<!--/// issue_on_time_target Day ///-->

					<!--/// issue_on_time_actual Day ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF">Result actual issue order on time</td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Time</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								//$bg_day = "#FFFFFF";
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT issue_on_time_actual FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Day'";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$issue_on_time_actual = $row1['issue_on_time_actual'];
								} else {
									$issue_on_time_actual = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
									<?
									echo $issue_on_time_actual;
									?>
								</td>
						<?


							}
						}



						?>
					</tr>
					<!--/// issue_on_time_actual Day ///-->

					<!--/// issue_on_time_delay Day ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF">Order to customer delay</td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Time</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								//$bg_day = "#FFFFFF";
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT issue_on_time_delay FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Day'";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$issue_on_time_delay = $row1['issue_on_time_delay'];
								} else {
									$issue_on_time_delay = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
									<?
									echo $issue_on_time_delay;
									?>
								</td>
						<?


							}
						}



						?>
					</tr>
					<!--/// issue_on_time_delay Day ///-->

					<!--/// 5.2 Night shift ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#8de5ff"><strong>Night shift</strong></td>
						<td align="center" height="20" style="border-right:0px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong></strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
											
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


						?>
								<td align='center' style='border-right:0px solid; border-bottom:1px solid; color:#000000' bgcolor="">
									<strong>
										
									</strong>
								</td>
						<?


							}
						}

						?>
					</tr>
					<!--/// 5.2 Night shift ///-->

					<!--/// issue_on_time_target Night ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF">Target Issue order on time</td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Time</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								//$bg_day = "#FFFFFF";
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT issue_on_time_target FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Night'";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$issue_on_time_target = $row1['issue_on_time_target'];
								} else {
									$issue_on_time_target = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
									<a href="javascript:void(0)" onclick="show_issue_on_time('<?=$row0['workdate3']?>','Night')">
									<strong>
									<?
									echo $issue_on_time_target;
									?>
									</strong>
									</a>
								</td>
						<?


							}
						}



						?>
					</tr>
					<!--/// issue_on_time_target Night ///-->

					<!--/// issue_on_time_actual Night ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF">Result actual issue order on time</td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Time</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								//$bg_day = "#FFFFFF";
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT issue_on_time_actual FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Night'";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$issue_on_time_actual = $row1['issue_on_time_actual'];
								} else {
									$issue_on_time_actual = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
									<?
									echo $issue_on_time_actual;
									?>
								</td>
						<?


							}
						}



						?>
					</tr>
					<!--/// issue_on_time_actual Night ///-->

					<!--/// issue_on_time_delay Night ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF">Order to customer delay</td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Time</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								//$bg_day = "#FFFFFF";
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT issue_on_time_delay FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Night'";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$issue_on_time_delay = $row1['issue_on_time_delay'];
								} else {
									$issue_on_time_delay = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
									<?
									echo $issue_on_time_delay;
									?>
								</td>
						<?


							}
						}



						?>
					</tr>
					<!--/// issue_on_time_delay Night ///-->

					<!--/// 5.2 Day+Night shift ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#8dffa6"><strong>Day+Night shift</strong></td>
						<td align="center" height="20" style="border-right:0px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong></strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
											
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


						?>
								<td align='center' style='border-right:0px solid; border-bottom:1px solid; color:#000000' bgcolor="">
									<strong>
										
									</strong>
								</td>
						<?


							}
						}

						?>
					</tr>
					<!--/// 5.2 Day+Night shift ///-->

					<!--/// issue_on_time_target Day+Night ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF">Total Target Issue order on time</td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Time</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								//$bg_day = "#FFFFFF";
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT sum(issue_on_time_target) as issue_on_time_target FROM    $table_name where workdate ='" . $row0['workdate'] . "' ";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$issue_on_time_target = $row1['issue_on_time_target'];
								} else {
									$issue_on_time_target = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
									<?
									echo $issue_on_time_target;
									?>
								</td>
						<?


							}
						}



						?>
					</tr>
					<!--/// issue_on_time_target Day+Night ///-->

					<!--/// issue_on_time_actual Day+Night ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF">Total Result actual issue order on time</td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Time</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								//$bg_day = "#FFFFFF";
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT sum(issue_on_time_actual) as issue_on_time_actual FROM    $table_name where workdate ='" . $row0['workdate'] . "'";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$issue_on_time_actual = $row1['issue_on_time_actual'];
								} else {
									$issue_on_time_actual = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
									<?
									echo $issue_on_time_actual;
									?>
								</td>
						<?


							}
						}



						?>
					</tr>
					<!--/// issue_on_time_actual Day+Night ///-->

					<!--/// issue_on_time_delay Day+Night ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF">Total Order to customer delay</td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Time</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								//$bg_day = "#FFFFFF";
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT sum(issue_on_time_delay) as issue_on_time_delay FROM    $table_name where workdate ='" . $row0['workdate'] . "' ";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$issue_on_time_delay = $row1['issue_on_time_delay'];
								} else {
									$issue_on_time_delay = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
									<?
									echo $issue_on_time_delay;
									?>
								</td>
						<?


							}
						}



						?>
					</tr>
					<!--/// issue_on_time_delay Day+Night ///-->

					<!-- 5.3 Issue performance -->
					<tr>
						<td height="20" align="left" bgcolor="#FFFFFF" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px"><strong>5.3 Issue performance</strong></td>
						<td bgcolor="#FFFFFF" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid"></td>
						<?

						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}

						
								?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#FFF' bgcolor="#595959"><strong>
										<?= date("d", strtotime($row0['workdate'])) ?>
									</strong></td>
								<?


							}
						}

						?>
					</tr>
					<!-- 5.3 Issue performance -->

					<!--/// 5.3 Day shift ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#f9af00"><strong>Day shift</strong></td>
						<td align="center" height="20" style="border-right:0px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong></strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
											
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


						?>
								<td align='center' style='border-right:0px solid; border-bottom:1px solid; color:#000000' bgcolor="">
									<strong>
										
									</strong>
								</td>
						<?


							}
						}

						?>
					</tr>
					<!--/// 5.3 Day shift ///-->

					<!--/// issue_order_box, issue_order_order Day ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF">Order require</td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Order/Box</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								//$bg_day = "#FFFFFF";
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT  issue_order_box, issue_order_order FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Day'";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$issue_order_box = $row1['issue_order_box'];
									$issue_order_order = $row1['issue_order_order'];
								} else {
									$issue_order_box = '';
									$issue_order_order = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
									<a href="javascript:void(0)" onclick="show_issue_order('<?=$row0['workdate3']?>','Day')">
									<?
									if ($issue_order_order != '') {
										echo $issue_order_order;
									?>&nbsp;<strong>/</strong>&nbsp;<?
										echo $issue_order_box;
									}
									?>
									</a>
								</td>
						<?


							}
						}



						?>
					</tr>
					<!--/// issue_order_box, issue_order_order Day ///-->

					<!--/// issue_order_incomplete_order, issue_order_incomplete_box Day ///-->
					<!-- <tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF">Order incomplete</td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Order/Box</strong></td>
						<?
						// $select0 = "SELECT *,
						// 	convert(varchar, workdate, 101)as  workdate2,
						// 	convert(varchar, workdate, 103)as  workdate3
							
						// FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						// $re0 = mssql_query($select0);
						// $num0 = mssql_num_rows($re0);
						// if ($num0 > 0) {
						// 	while ($row0 = mssql_fetch_array($re0)) {
						// 		//$bg_day = "#FFFFFF";
						// 		if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
						// 			$bg_day = "#FFFF00";
						// 		} else {
						// 			$bg_day = "#FFFFFF";
						// 		}


						// 		$select1 = "SELECT  issue_order_incomplete_order, issue_order_incomplete_box FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Day'";
						// 		$re1 = mssql_query($select1);
						// 		$num1 = mssql_num_rows($re1);
						// 		if ($num1 > 0) {
						// 			$row1 = mssql_fetch_array($re1);
						// 			$issue_order_incomplete_order = $row1['issue_order_incomplete_order'];
						// 			$issue_order_incomplete_box = $row1['issue_order_incomplete_box'];
						// 		} else {
						// 			$issue_order_incomplete_box = '';
						// 			$issue_order_incomplete_order = '';
						// 		}


						// ?>
						// 		<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
						// 			<?
						// 			if ($issue_order_incomplete_order != '') {
						// 				echo $issue_order_incomplete_order;
						// 			?>&nbsp;<strong>/</strong>&nbsp;<?
						// 					echo $issue_order_incomplete_box;
						// 				}
						// 					?>
						// 		</td>
						// <?


						// 	}
						// }



						?>
					</tr> -->
					<!--/// issue_order_incomplete_order, issue_order_incomplete_box Day ///-->

					<!--/// issue_order_complete_order, issue_order_complete_box Day ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF"> Order Issue</td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Order/Box</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								//$bg_day = "#FFFFFF";
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT  issue_order_complete_order, issue_order_complete_box FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Day'";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$issue_order_complete_order = $row1['issue_order_complete_order'];
									$issue_order_complete_box = $row1['issue_order_complete_box'];
								} else {
									$issue_order_complete_order = '';
									$issue_order_complete_box = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
									<?
									if ($issue_order_complete_order != '') {
										echo $issue_order_complete_order;
									?>&nbsp;<strong>/</strong>&nbsp;<?
											echo $issue_order_complete_box;
										}
											?>
								</td>
						<?


							}
						}



						?>
					</tr>
					<!--/// issue_order_complete_order, issue_order_complete_box Day ///-->
					
					<!--/// 5.3 Night shift ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#8de5ff"><strong>Night shift</strong></td>
						<td align="center" height="20" style="border-right:0px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong></strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
											
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


						?>
								<td align='center' style='border-right:0px solid; border-bottom:1px solid; color:#000000' bgcolor="">
									<strong>
										
									</strong>
								</td>
						<?


							}
						}

						?>
					</tr>
					<!--/// 5.3 Night shift ///-->

					<!--/// issue_order_box, issue_order_order Night ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF">Order require</td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Order/Box</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								//$bg_day = "#FFFFFF";
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT  issue_order_box, issue_order_order FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Night'";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$issue_order_box = $row1['issue_order_box'];
									$issue_order_order = $row1['issue_order_order'];
								} else {
									$issue_order_box = '';
									$issue_order_order = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
									<a href="javascript:void(0)" onclick="show_issue_order('<?=$row0['workdate3']?>','Night')">
									<?
									if ($issue_order_order != '') {
										echo $issue_order_order;
									?>&nbsp;<strong>/</strong>&nbsp;<?
										echo $issue_order_box;
									}
									?>
									</a>
								</td>
						<?


							}
						}



						?>
					</tr>
					<!--/// issue_order_box, issue_order_order Night ///-->

					<!--/// issue_order_incomplete_order, issue_order_incomplete_box Night ///-->
					<!-- <tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF">Order incomplete</td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Order/Box</strong></td>
						<?
						// $select0 = "SELECT *,
						// 	convert(varchar, workdate, 101)as  workdate2,
						// 	convert(varchar, workdate, 103)as  workdate3
							
						// FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						// $re0 = mssql_query($select0);
						// $num0 = mssql_num_rows($re0);
						// if ($num0 > 0) {
						// 	while ($row0 = mssql_fetch_array($re0)) {
						// 		//$bg_day = "#FFFFFF";
						// 		if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
						// 			$bg_day = "#FFFF00";
						// 		} else {
						// 			$bg_day = "#FFFFFF";
						// 		}


						// 		$select1 = "SELECT  issue_order_incomplete_order, issue_order_incomplete_box FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Night'";
						// 		$re1 = mssql_query($select1);
						// 		$num1 = mssql_num_rows($re1);
						// 		if ($num1 > 0) {
						// 			$row1 = mssql_fetch_array($re1);
						// 			$issue_order_incomplete_order = $row1['issue_order_incomplete_order'];
						// 			$issue_order_incomplete_box = $row1['issue_order_incomplete_box'];
						// 		} else {
						// 			$issue_order_incomplete_box = '';
						// 			$issue_order_incomplete_order = '';
						// 		}


						// ?>
						// 		<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
						// 			<?
						// 			if ($issue_order_incomplete_order != '') {
						// 				echo $issue_order_incomplete_order;
						// 			?>&nbsp;<strong>/</strong>&nbsp;<?
						// 					echo $issue_order_incomplete_box;
						// 				}
						// 					?>
						// 		</td>
						// <?


						// 	}
						// }



						?>
					</tr> -->
					<!--/// issue_order_incomplete_order, issue_order_incomplete_box Night ///-->

					<!--/// issue_order_complete_order, issue_order_complete_box Night ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF"> Order Issue</td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Order/Box</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								//$bg_day = "#FFFFFF";
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT  issue_order_complete_order, issue_order_complete_box FROM    $table_name where workdate ='" . $row0['workdate'] . "' AND shift='Night'";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$issue_order_complete_order = $row1['issue_order_complete_order'];
									$issue_order_complete_box = $row1['issue_order_complete_box'];
								} else {
									$issue_order_complete_order = '';
									$issue_order_complete_box = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
									<?
									if ($issue_order_complete_order != '') {
										echo $issue_order_complete_order;
									?>&nbsp;<strong>/</strong>&nbsp;<?
											echo $issue_order_complete_box;
										}
											?>
								</td>
						<?


							}
						}



						?>
					</tr>
					<!--/// issue_order_complete_order, issue_order_complete_box Night ///-->

					<!--/// 5.3 Day+Night shift ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#8dffa6"><strong>Day+Night shift</strong></td>
						<td align="center" height="20" style="border-right:0px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong></strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
											
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {

								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


						?>
								<td align='center' style='border-right:0px solid; border-bottom:1px solid; color:#000000' bgcolor="">
									<strong>
										
									</strong>
								</td>
						<?


							}
						}

						?>
					</tr>
					<!--/// 5.3 Day+Night shift ///-->

					<!--/// issue_order_box, issue_order_order Day+Night ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF">Total Order require</td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Order/Box</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								//$bg_day = "#FFFFFF";
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT  sum(issue_order_box) as issue_order_box, sum(issue_order_order) as issue_order_order FROM    $table_name where workdate ='" . $row0['workdate'] . "'";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$issue_order_box = $row1['issue_order_box'];
									$issue_order_order = $row1['issue_order_order'];
								} else {
									$issue_order_box = '';
									$issue_order_order = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
									<?
									if ($issue_order_order != '') {
										echo $issue_order_order;
									?>&nbsp;<strong>/</strong>&nbsp;<?
										echo $issue_order_box;
									}
									?>
								</td>
						<?


							}
						}



						?>
					</tr>
					<!--/// issue_order_box, issue_order_order Day+Night ///-->

					<!--/// issue_order_incomplete_order, issue_order_incomplete_box Day+Night ///-->
					<!-- <tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF">Total Order incomplete</td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Order/Box</strong></td>
						<?
						// $select0 = "SELECT *,
						// 	convert(varchar, workdate, 101)as  workdate2,
						// 	convert(varchar, workdate, 103)as  workdate3
							
						// FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						// $re0 = mssql_query($select0);
						// $num0 = mssql_num_rows($re0);
						// if ($num0 > 0) {
						// 	while ($row0 = mssql_fetch_array($re0)) {
						// 		//$bg_day = "#FFFFFF";
						// 		if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
						// 			$bg_day = "#FFFF00";
						// 		} else {
						// 			$bg_day = "#FFFFFF";
						// 		}


						// 		$select1 = "SELECT  sum(issue_order_incomplete_order) as issue_order_incomplete_order, sum(issue_order_incomplete_box) as issue_order_incomplete_box FROM    $table_name where workdate ='" . $row0['workdate'] . "' ";
						// 		$re1 = mssql_query($select1);
						// 		$num1 = mssql_num_rows($re1);
						// 		if ($num1 > 0) {
						// 			$row1 = mssql_fetch_array($re1);
						// 			$issue_order_incomplete_order = $row1['issue_order_incomplete_order'];
						// 			$issue_order_incomplete_box = $row1['issue_order_incomplete_box'];
						// 		} else {
						// 			$issue_order_incomplete_box = '';
						// 			$issue_order_incomplete_order = '';
						// 		}


						// ?>
						// 		<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
						// 			<?
						// 			if ($issue_order_incomplete_order != '') {
						// 				echo $issue_order_incomplete_order;
						// 			?>&nbsp;<strong>/</strong>&nbsp;<?
						// 					echo $issue_order_incomplete_box;
						// 				}
						// 					?>
						// 		</td>
						// <?


						// 	}
						// }



						?>
					</tr> -->
					<!--/// issue_order_incomplete_order, issue_order_incomplete_box Day+Night ///-->

					<!--/// issue_order_complete_order, issue_order_complete_box Day+Night ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF">Total Order Issue</td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Order/Box</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								//$bg_day = "#FFFFFF";
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT  sum(issue_order_complete_order) as issue_order_complete_order, sum(issue_order_complete_box) as issue_order_complete_box FROM    $table_name where workdate ='" . $row0['workdate'] . "' ";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$issue_order_complete_order = $row1['issue_order_complete_order'];
									$issue_order_complete_box = $row1['issue_order_complete_box'];
								} else {
									$issue_order_complete_order = '';
									$issue_order_complete_box = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
									<?
									if ($issue_order_complete_order != '') {
										echo $issue_order_complete_order;
									?>&nbsp;<strong>/</strong>&nbsp;<?
											echo $issue_order_complete_box;
										}
											?>
								</td>
						<?


							}
						}



						?>
					</tr>
					<!--/// issue_order_complete_order, issue_order_complete_box Day+Night ///-->

					<!--///issue_performance_order, issue_performance_box Day+Night ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFF00"><strong>Result Performance</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#92D050"><strong>%</strong></td>
						<?
						$select0 = "SELECT *,
							convert(varchar, workdate, 101)as  workdate2,
							convert(varchar, workdate, 103)as  workdate3
							
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								$bg_day = "#FFE699";

								
								$select1 = "SELECT (sum(issue_order_complete_order)* 100 / (Select sum(issue_order_order) From $table_name where workdate ='" . $row0['workdate'] . "')) as issue_performance_order
								, (sum(issue_order_complete_box)* 100 / (Select sum(issue_order_box) From $table_name where workdate ='" . $row0['workdate'] . "')) as issue_performance_box
								FROM    $table_name where workdate ='" . $row0['workdate'] . "' ";
								// echo $select1;
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$issue_performance_order = $row1['issue_performance_order'];
									$issue_performance_box = $row1['issue_performance_box'];
								} else {
									$issue_performance_order = '';
									$issue_performance_box = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
									<?
									if ($issue_performance_order != '') {
										echo $issue_performance_order."%";
									?>&nbsp;<strong>/</strong>&nbsp;<?
											echo $issue_performance_box."%";
										}
											?>
								</td>
						<?


							}
						}

						?>
					</tr>
					<!--/// issue_performance_order, issue_performance_box Day+Night ///-->

					<!-- 6.Hold & Damage -->
					<tr>
						<td height="20" colspan="2" align="left" bgcolor="#DBDBDB" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px"><strong>6.Hold & Damage</strong><strong></strong></td>
						<?

						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						$qty_col = 0;
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								$qty_col++;
								?>
									<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#FFF' bgcolor="#595959"><strong>
											<?= date("d", strtotime($row0['workdate'])) ?>
										</strong></td>
								

								<?
							}
						}
						
						?>
					</tr>
					<!-- 6.Hold & Damage -->

					<!--/// per_hold_box ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF">6.1 Hold</td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Box</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								//$bg_day = "#FFFFFF";
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT sum(per_hold_box) as per_hold_box FROM    $table_name where workdate ='" . $row0['workdate'] . "' ";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$per_hold_box = $row1['per_hold_box'];
								} else {
									$per_hold_box = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
									<a href="javascript:void(0)" onclick="show_hold_box('<?=$row0['workdate3']?>')">
									<strong>
										<?= $per_hold_box ?>
									</strong>
									</a>
								</td>
						<?


							}
						}

						?>
					</tr>
					<!--/// per_hold_box ///-->

					<!--/// per_damage_box ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px; padding-left:2px" bgcolor="#FFFFFF">6.2 Damage</td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Box</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								//$bg_day = "#FFFFFF";
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT sum(per_damage_box) as per_damage_box FROM    $table_name where workdate ='" . $row0['workdate'] . "' ";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$per_damage_box = $row1['per_damage_box'];
								} else {
									$per_damage_box = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
									<a href="javascript:void(0)" onclick="show_damage_box('<?=$row0['workdate3']?>')">
									<strong>
										<?= $per_damage_box ?>
									</strong>
									</a>
								</td>
						<?


							}
						}

						?>
					</tr>
					<!--/// per_damage_box ///-->

					

					<!-- 7.Quality -->
					<tr>
						<td height="20" colspan="2" align="left" bgcolor="#DBDBDB" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px"><strong>7.Quality</strong><strong></strong></td>
						<?

						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						$qty_col = 0;
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								$qty_col++;
								?>
									<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#FFF' bgcolor="#595959"><strong>
											<?= date("d", strtotime($row0['workdate'])) ?>
										</strong></td>
								

								<?
							}
						}
						
						?>
					</tr>
					<!-- 7.Quality -->
					<!--/// qa_partinbox_cus ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF">7.1 Part in box from customer</td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Box</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								//$bg_day = "#FFFFFF";
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT sum(qa_partinbox_cus) as qa_partinbox_cus FROM    $table_name where workdate ='" . $row0['workdate'] . "' ";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$qa_partinbox_cus = $row1['qa_partinbox_cus'];
								} else {
									$qa_partinbox_cus = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
									<a href="javascript:void(0)" onclick="show_partinbox_cus('<?=$row0['workdate3']?>')">
									<strong>
										<?= $qa_partinbox_cus ?>
									</strong>
									</a>
								</td>
						<?


							}
						}

						?>
					</tr>
					<!--/// qa_partinbox_cus ///-->

					<!--/// qa_partinbox_ipack ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF">7.2 Part in box from IPACK</td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Box</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								//$bg_day = "#FFFFFF";
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT qa_partinbox_ipack FROM    $table_name where workdate ='" . $row0['workdate'] . "' ";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$qa_partinbox_ipack = $row1['qa_partinbox_ipack'];
								} else {
									$qa_partinbox_ipack = '';
								}


								?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">

										<?= $qa_partinbox_ipack ?>
								</td>
								<?


							}
						}

						?>
					</tr>
					<!--/// qa_partinbox_ipack ///-->

					<!--/// qa_westbox_ipack ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFFFF">7.3 Wast box,West Box from IPACK</td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#FFFFFF"><strong>Box</strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								//$bg_day = "#FFFFFF";
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bg_day = "#FFFF00";
								} else {
									$bg_day = "#FFFFFF";
								}


								$select1 = "SELECT qa_westbox_ipack FROM    $table_name where workdate ='" . $row0['workdate'] . "' ";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);
									$qa_westbox_ipack = $row1['qa_westbox_ipack'];
								} else {
									$qa_westbox_ipack = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>">
										<?= $qa_westbox_ipack ?>
								</td>
						<?


							}
						}

						?>
					</tr>
					<!--/// qa_westbox_ipack ///-->

					<!--/// qa_result ///-->
					<tr>
						<td align="left" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid; padding-left:2px" bgcolor="#FFFF00"><strong>Result Performance</strong></td>
						<td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid" bgcolor="#92D050"><strong></strong></td>
						<?
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);
						if ($num0 > 0) {
							while ($row0 = mssql_fetch_array($re0)) {
								$bg_day = "#FFE699";

								$select1 = "SELECT qa_result FROM    $table_name where workdate ='" . $row0['workdate'] . "' ";
								$re1 = mssql_query($select1);
								$num1 = mssql_num_rows($re1);
								if ($num1 > 0) {
									$row1 = mssql_fetch_array($re1);


									if ($row1['qa_result'] == 'OK') {
										$qa_result = "<font color='#00B050'>" . $row1['qa_result'] . "</font>";
									} else if ($row1['qa_result'] == 'NG') {
										//$qa_result = $row1['qa_result'];
										$qa_result = "<font color='#FF0000'>" . $row1['qa_result'] . "</font>";
									} else {
										$qa_result = '';
									}
								} else {
									$qa_result = '';
								}


						?>
								<td align='center' style='border-right:1px solid; border-bottom:1px solid; color:#000000' bgcolor="<?= $bg_day ?>"><strong>
										<?
										echo $qa_result;

										?>
									</strong></td>
						<?


							}
						}

						?>
					</tr>
					<!--/// qa_result ///-->


				</table>

				<HR>

				<div class="row equal" style="margin-left:0px; margin-right:0px">
					<div class="col-md-12">
						<table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'">
							<tr>
								<td height="20" bgcolor="#FFFF00" style="padding-left:2px"><strong>6. Key activity</strong></td>
							</tr>
						</table>
					</div>
					<div class="col-md-6">
						<table width="100%" cellspacing="0" cellpadding="0">
							<tr>
								<td width="559" height="25" colspan="6" align="center" bgcolor="#FF0000" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><strong>
										<font color="#FFFFFF">Internal quality Problem</font>
									</strong></td>
							</tr>
							<tr>
								<td height="25" align="center" bgcolor="#FF0000" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><strong>
										<font color="#FFFFFF">Date</font>
									</strong></td>
								<td align="center" bgcolor="#FF0000" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><strong>
										<font color="#FFFFFF">Problem</font>
									</strong></td>
								<td align="center" bgcolor="#FF0000" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><strong>
										<font color="#FFFFFF">From Customer</font>
									</strong></td>

								<td align="center" bgcolor="#FF0000" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><strong>
										<font color="#FFFFFF">PIC</font>
									</strong></td>
								<td align="center" bgcolor="#FF0000" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><strong>
										<font color="#FFFFFF">Due date</font>
									</strong></td>
							</tr>
							<?
							$selectp = "select CONVERT(nvarchar, due_problem, 103) as due_problem,* from tbdaily_report_activity_external_problem where date_problem between '$startdate' and '$enddate' and site='OSW'";

							$rep = mssql_query($selectp);
							$nump = mssql_num_rows($rep);
							if ($nump > 0) {
								$ip = 0;
								while ($rowp = mssql_fetch_array($rep)) {
									$ip++;
							?>
									<tr align="center">
										<td height="25" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><?= $ip ?></td>
										<td style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><?= lang_thai_from_database($rowp['topic_problem']) ?></td>
										<td style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><?= lang_thai_from_database($rowp['customer_problem']) ?></td>
										<td style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><?= lang_thai_from_database($rowp['pic_problem']) ?></td>

										<td style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><?= $rowp['due_problem'] ?></td>
									</tr>
							<?
								}
							}
							?>

						</table>
					</div>
					<div class="col-md-6">
						<table width="100%" cellspacing="0" cellpadding="0">
							<tr>
								<td width="559" height="25" colspan="9" align="center" bgcolor="#00B050" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><strong>
										<font color="#FFFFFF">Inventory</font>
									</strong></td>
							</tr>
							<tr>
								<td height="25" align="center" bgcolor="#ffffff" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><strong>
										<font color="#000000">Month</font>
									</strong></td>
								<td align="center" bgcolor="#ffffff" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><strong>
										<font color="#000000">Plan Date</font>
									</strong></td>

							</tr>
							<?
							$selectp = "select CONVERT(nvarchar, plan_count_date, 103) as plan_count_datedate
					,* from tbdaily_report_osw_inventory where plan_count_date between '$startdate' and '$enddate' order by  plan_count_date asc";

							$rep = mssql_query($selectp);
							$nump = mssql_num_rows($rep);
							if ($nump > 0) {
								$ip = 0;
								while ($rowp = mssql_fetch_array($rep)) {
									$ip++;

							?>
									<tr align="center">
										<td height="25" bgcolor="#ffffff" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><strong>
												<font color="#000000"><?

																		echo date("F", strtotime($rowp['plan_count_date']));

																		?></font>
											</strong></td>
										<td style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><?= $rowp['plan_count_datedate'] ?></td>


									</tr>
								<?
								}



								$selectp = "select CONVERT(nvarchar, plan_count_date, 103) as plan_count_datedate
					,* from tbdaily_report_osw_inventory where plan_count_date between '$startdate' and '$enddate' order by  plan_count_date asc";

								$rep = mssql_query($selectp);
								$rowp = mssql_fetch_array($rep);


								?>
								<TR>
									<TD height="25" colspan="2" align="left" bgcolor="#CCCCCC" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000; padding-left:2px'"><strong>Pallet</strong></TD>
								</TR>

								<TR>
									<TD height="25" align="left" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000; padding-left:2px'">System</TD>
									<TD height="25" align="center" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><?
																																									echo $rowp['system_pallet'];
																																									?></TD>
								</TR>
								<TR>
									<TD height="25" align="left" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000; padding-left:2px'">Actual</TD>
									<TD height="25" align="center" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><?
																																									echo $rowp['actual_pallet'];
																																									?></TD>
								</TR>
								<TR>
									<TD height="25" align="left" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000; padding-left:2px'">Diff</TD>
									<TD height="25" align="center" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><?
																																									echo $rowp['diff_pallet'];
																																									?></TD>
								</TR>
								<TR>
									<TD height="25" align="left" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000; padding-left:2px'">% Accuracy</TD>
									<TD height="25" align="center" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><?
																																									echo $rowp['accuracy_pallet'];
																																									?></TD>
								</TR>

								<TR>
									<TD height="25" colspan="2" align="left" bgcolor="#CCCCCC" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000; padding-left:2px'"><strong>Box remain pallet</strong></TD>
								</TR>

								<TR>
									<TD height="25" align="left" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000; padding-left:2px'">System</TD>
									<TD height="25" align="center" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><?
																																									echo $rowp['system_box'];
																																									?></TD>
								</TR>
								<TR>
									<TD height="25" align="left" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000; padding-left:2px'">Actual</TD>
									<TD height="25" align="center" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><?
																																									echo $rowp['actual_box'];
																																									?></TD>
								</TR>
								<TR>
									<TD height="25" align="left" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000; padding-left:2px'">Diff</TD>
									<TD height="25" align="center" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><?
																																									echo $rowp['diff_box'];
																																									?></TD>
								</TR>
								<TR>
									<TD height="25" align="left" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000; padding-left:2px'">% Accuracy</TD>
									<TD height="25" align="center" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><?
																																									echo $rowp['accuracy_box'];
																																									?></TD>
								</TR>

							<?
							}
							?>

						</table>
					</div>
				</div>
				<div class="row equal" style="margin-left:0px; margin-right:0px">

					<div class="col-md-6">
						<table width="100%" cellspacing="0" cellpadding="0">
							<tr>
								<td height="25" colspan="6" align="center" bgcolor="#C6E0B4" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><strong>
										<font color="#000000">5S. Monthly audit</font>
									</strong></td>
							</tr>
							<tr bgcolor="#C6E0B4">
								<td width="131" height="25" align="center" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><strong>
										<font color="#000000">Month</font>
									</strong></td>
								<td width="253" align="center" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><strong>
										<font color="#000000">Audit Date</font>
									</strong></td>
								<td width="270" align="center" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><strong>
										<font color="#000000">Team</font>
									</strong></td>

								<td width="275" align="center" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><strong>
										<font color="#000000">Score</font>
									</strong></td>

							</tr>
							<?
							$selectp = "select CONVERT(nvarchar, date_audit, 103) as date_auditdate,* from tbdaily_report_activity_5s_audit where date_audit between '$startdate' and '$enddate' and site='OSW'";

							$rep = mssql_query($selectp);
							$nump = mssql_num_rows($rep);
							if ($nump > 0) {
								$ip = 0;
								while ($rowp = mssql_fetch_array($rep)) {
									$ip++;
							?>
									<tr align="center">
										<td height="25" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><?
																																							//$monthName = date('F', mktime(0, 0, 0, $monthNum, 10)); // March
																																							echo date("F", strtotime($rowp['date_audit']));
																																							?></td>
										<td style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><?= $rowp['date_auditdate'] ?></td>
										<td style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><?= $rowp['team_audit'] ?></td>
										<td style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><?= $rowp['score_audit'] ?></td>


									</tr>
							<?
								}
							}

							?>
						</table>
						<table width="100%" cellspacing="0" cellpadding="0">

							<tr>
								<td height="25" colspan="2" align="center" bgcolor="#C6E0B4" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><strong>
										<font color="#000000">Last audit comment</font>
									</strong></td>
							</tr>

							<?
							$pre_month_year = date("m/1/Y", strtotime("$mmonth/1/$yyear -1 month"));
							$deceased_month = date("m",strtotime($pre_month_year));
							$deceased_year = date("Y",strtotime($pre_month_year));
							$selectp = "SELECT CONVERT(nvarchar, date_audit, 103) as date_auditdate,* 
							from tbdaily_report_activity_5s_audit_comment where site='$tsite' AND Month(date_audit)='$deceased_month' AND YEAR(date_audit)='$deceased_year' order by date_audit desc";

							$rep = mssql_query($selectp);
							$nump = mssql_num_rows($rep);
							if ($nump > 0) {
								$ip = 0;
								while ($rowp = mssql_fetch_array($rep)) {
									$ip++;
							?>
									<tr align="center">
										<td width="29%" height="25" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><?= $rowp['date_auditdate'] ?></td>
										<td width="71%" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><?= lang_thai_from_database($rowp['comment_audit']) ?></td>
									</tr>
							<?
								}
							}
							?>

						</table>
					</div>
					<div class="col-md-6">
						<table width="100%" cellspacing="0" cellpadding="0">
							<tr>
								<td height="25" colspan="6" align="center" bgcolor="#9BC2E6" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><strong>
										<font color="#000000">Improvement</font>
									</strong></td>
							</tr>
							<tr>
								<td width="96" height="25" align="center" bgcolor="#9BC2E6" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><strong>
										<font color="#000000">Month</font>
									</strong></td>
								<td width="424" align="center" bgcolor="#FFFFFF" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><strong>
										<font color="#000000">Topic</font>
									</strong></td>
								<td width="96" align="center" bgcolor="#FFFFFF" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><strong>
										<font color="#000000">Status</font>
									</strong></td>

								<td width="123" align="center" bgcolor="#FFFFFF" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><strong>
										<font color="#000000">PIC</font>
									</strong></td>
								<td width="190" align="center" bgcolor="#FFFFFF" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><strong>
										<font color="#000000">Due date</font>
									</strong></td>
							</tr>
							<?
							$selectp = "select CONVERT(nvarchar, month_improve, 103) as month_improvedate,
					 CONVERT(nvarchar, due_improve, 103) as due_improvedate,
					* from tbdaily_report_activity_improvement where month_improve between '$startdate' and '$enddate' and site='OSW'";

							$rep = mssql_query($selectp);
							$nump = mssql_num_rows($rep);
							if ($nump > 0) {
								$ip = 0;
								while ($rowp = mssql_fetch_array($rep)) {
									$ip++;
							?>
									<tr align="center">
										<td height="25" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><?
																																							echo date("F", strtotime($rowp['month_improve']));
																																							?></td>
										<td style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><?= lang_thai_from_database($rowp['topic_improve']) ?></td>
										<td style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><?= lang_thai_from_database($rowp['status_improve']) ?></td>
										<td style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><?= lang_thai_from_database($rowp['pic_improve']) ?></td>

										<td style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><?= $rowp['due_improvedate'] ?></td>
									</tr>
							<?
								}
							}
							?>

						</table>
					</div>
				</div>
				<div class="row equal" style="margin-left:0px; margin-right:0px">
					<div class="col-md-12">
						<table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'">
							<tr>
								<td height="20" bgcolor="#FFFF00" style="padding-left:2px"><strong>7. Morning Meeting</strong></td>
							</tr>
						</table>
					</div>
					<div class="col-md-6">

						<table width="100%" cellspacing="0" cellpadding="0">
							<tr>
								<td height="25" colspan="8" align="center" bgcolor="#19C3FF" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><strong>
										<font color="#000000">Morning Meeting in&nbsp;<?
																						echo date("F", strtotime($startdate));
																						echo "&nbsp;";
																						echo $yyear;
																						?></font>
									</strong></td>
							</tr>
							<tr>
								<td width="96" height="25" align="center" bgcolor="#19C3FF" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><strong>
										<font color="#000000">Date</font>
									</strong></td>
								<td width="424" align="center" bgcolor="#FFFFFF" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><strong>Day Name</strong></td>
								<td width="424" align="center" bgcolor="#FFFFFF" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><strong>Type</strong></td>
								<td width="424" align="center" bgcolor="#FFFFFF" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><strong>
										<font color="#000000">Detail Information</font>
									</strong></td>
								<td width="96" align="center" bgcolor="#FFFFFF" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><strong>
										<font color="#000000">Status</font>
									</strong></td>



							</tr>
							<?
							$selectp = "select CONVERT(nvarchar, report_date, 103) as report_datedate,
					* from tbdaily_report_morning_meeting where report_date between '$startdate' and '$enddate' and site='OSW'
					order by report_date desc";

							$rep = mssql_query($selectp);
							$nump = mssql_num_rows($rep);
							if ($nump > 0) {
								$ip = 0;
								while ($rowp = mssql_fetch_array($rep)) {
									$ip++;

									if ($rowp['status_meeting'] == 'On progress') {
										$bg_status = "#FFFF00";
									}else if ($rowp['status_meeting'] == 'Complete') {
										$bg_status = "#00B050";
									}else if ($rowp['status_meeting'] == 'Delay') {
										$bg_status = "#FF0000";
									}else {
										$bg_status = "#FF0000";
									}

									#FFFF00
							?>
									<tr align="center">
										<td height="25" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><?
																																							echo $rowp['report_datedate'];
																																							?></td>
										<td style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><?
																																				echo date("D", strtotime($rowp['report_date']));
																																				?></td>
										<td style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><?= $rowp['type_meeting'] ?></td>
										<td style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><?= lang_thai_from_database($rowp['detail_meeting']) ?></td>
										<td style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'" bgcolor="<?= $bg_status ?>"><?= $rowp['status_meeting'] ?></td>

									</tr>
							<?
								}
							}
							?>

						</table>
					</div>
					<div class="col-md-6">
						<table width="100%" cellspacing="0" cellpadding="0">
							<tr>
								<td height="25" colspan="8" align="center" bgcolor="#FF9900" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><strong>
										<font color="#000000">Morning Meeting Delay Job</font>
									</strong></td>
							</tr>
							<tr>
								<td width="96" height="25" align="center" bgcolor="#FF9900" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><strong>
										<font color="#000000">Date</font>
									</strong></td>
								<td width="424" align="center" bgcolor="#FFFFFF" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><strong>Day Name</strong></td>
								<td width="424" align="center" bgcolor="#FFFFFF" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><strong>Type</strong></td>
								<td width="424" align="center" bgcolor="#FFFFFF" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><strong>
										<font color="#000000">Detail Information</font>
									</strong></td>
								<td width="96" align="center" bgcolor="#FFFFFF" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><strong>
										<font color="#000000">Status</font>
									</strong></td>



							</tr>
							<?
							$selectp = "select CONVERT(nvarchar, report_date, 103) as report_datedate,
					* from tbdaily_report_morning_meeting where report_date < '$startdate'  and site='OSW' and status_meeting not in('Complete')
					order by report_date desc";

							$rep = mssql_query($selectp);
							$nump = mssql_num_rows($rep);
							if ($nump > 0) {
								$ip = 0;
								while ($rowp = mssql_fetch_array($rep)) {
									$ip++;

									if ($rowp['status_meeting'] == 'On progress') {
										$bg_status = "#FFFF00";
									}else if ($rowp['status_meeting'] == 'Complete') {
										$bg_status = "#00B050";
									}else if ($rowp['status_meeting'] == 'Delay') {
										$bg_status = "#FF0000";
									}else {
										$bg_status = "#FF0000";
									}

									#FFFF00
							?>
									<tr align="center">
										<td height="25" style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><?
																																							echo $rowp['report_datedate'];
																																							?></td>
										<td style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><?
																																				echo date("D", strtotime($rowp['report_date']));
																																				?></td>
										<td style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><?= $rowp['type_meeting'] ?></td>
										<td style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'"><?= lang_thai_from_database($rowp['detail_meeting']) ?></td>
										<td style="border-right:1px solid; border-width:1px 1px 1px 1px; border-style:solid; color:#000000'" bgcolor="<?= $bg_status ?>"><?= $rowp['status_meeting'] ?></td>

									</tr>
							<?
								}
							}
							?>

						</table>
					</div>
				</div>

			</td>
		</tr>



	</table>








<?


}




?>