<?php
ob_start();
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
if ($status == 'showatt_old') {
	$paycode = $_REQUEST['paycode'];
	$tsite = $_REQUEST['tsite'];

	$select = "select paycode,convert(varchar, startdate, 101)as  startdate,
	convert(varchar, enddate, 101)as  enddate from  tbpaycode where paycode = '$paycode' ";
	$re = mssql_query($select);
	$num = mssql_num_rows($re);

	$row = mssql_fetch_array($re);
	$startdate = $row['startdate'];
	$enddate = $row['enddate'];

	//$number = cal_days_in_month(CAL_GREGORIAN, $mmonth, $yyear); 
	//echo "There were {$number} days ";
	?>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td align="center" bgcolor="#CCCCCC">

				<table width="100%" border="0" cellspacing="1" cellpadding="0">
					<tr>
						<td align="center" width="50" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid"><strong>Name</strong></td>
						<?

							$select0 = "SELECT *,
		convert(varchar, workdate, 101)as  workdate2,
		convert(varchar, workdate, 103)as  workdate3
		
FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";
							//echo $select0;
							$re0 = mssql_query($select0);
							$num0 = mssql_num_rows($re0);
							if ($num0 > 0) {
								while ($row0 = mssql_fetch_array($re0)) {
									?><td align="center" width="33" style="border-right:1px solid; border-bottom:1px solid"><strong><?
																															echo date("d", strtotime($row0['workdate']));
																															?></strong></td><?
										};
									}




									?>

					</tr>
					<?
						$select = "select convert(varchar, startdate, 101)as  startdate2,* from  tbemployee where site='$tsite' and emp_level <= 4 and delstatus='0' order by empno asc ";
						$re = mssql_query($select);
						$num = mssql_num_rows($re);
						if ($num > 0) {
							while ($row = mssql_fetch_array($re)) {
								?>

							<tr bgcolor="#FFFFFF">
								<td align="center" width="50" height="40" style="border-right:1px solid; border-left:1px solid; border-bottom:1px solid"><?
																																										echo iconv("tis-620", "utf-8", $row['firstname']);
																																										?></td>
								<?



											$select0 = "SELECT *,
		convert(varchar, workdate, 101)as  workdate2,
		convert(varchar, workdate, 103)as  workdate3
		
FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";

											$re0 = mssql_query($select0);
											$num0 = mssql_num_rows($re0);

											while ($row0 = mssql_fetch_array($re0)) {




												?><td align="center" width="33" style="border-right:1px solid; border-bottom:1px solid" <?
																														if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
																															?> bgcolor="#CCCCCC" <?
												} else { }

												$select2 = "select convert(varchar, attdatetime, 108)as  atttime,shift from  tbatt where empno='" . $row['empno'] . "' and cast(att_real_date as date)='" . $row0['workdate'] . "' and att_status='in' ";

												$re2 = mssql_query($select2);
												$num2 = mssql_num_rows($re2);

												$sql_l = "select reasons,leaveid,leavetypeid from tbleave_transaction 
					where empno='" . $row['empno'] . "' 
					and '" . $row0['workdate'] . "' between leavestartdate and leaveenddate 
					and statusapprove !='Cancel'
					and statusapprove !='Reject'";
												$res_l = mssql_query($sql_l);
												$num_l = mssql_num_rows($res_l);
												if ($num2 == 0 && $num_l > 0) {
													?>bgcolor='#ffff67' <?
												} else {
													//echo $num2.$num_l;
												}
												?>>

										<table width="100%" border="0" cellspacing="0" cellpadding="0">
											<tr>
												<td align="center"><?



																					$select2 = "select convert(varchar, attdatetime, 108)as  atttime,shift from  tbatt where empno='" . $row['empno'] . "' and cast(att_real_date as date)='" . $row0['workdate'] . "' and att_status='in' ";

																					$re2 = mssql_query($select2);
																					$num2 = mssql_num_rows($re2);
																					if ($num2 > 0) {
																						$row2 = mssql_fetch_array($re2);
																						$shift = $row2['shift'];
																						echo $shift . "<br>";
																						if ($shift == "Day") {
																							if (TimeDiff("08:00:01", $row2['atttime']) > 0) {
																								echo "<span style='background-color:#FFFFB7'>" . $row2['atttime'] . "</span>";
																							} else {
																								//B7FFB7
																								echo "<span style='background-color:#ffffff'>" . $row2['atttime'] . "</span>";
																							}
																						}
																					}



																					?></td>
											</tr>
											<tr>
												<td align="center"><?

																					$select2 = "select convert(varchar, attdatetime, 108)as  atttime from  tbatt where empno='" . $row['empno'] . "' and cast(att_real_date as date)='" . $row0['workdate'] . "' and att_status='out' ";

																					$re2 = mssql_query($select2);
																					$num2 = mssql_num_rows($re2);
																					if ($num2 > 0) {
																						$row2 = mssql_fetch_array($re2);
																						echo $row2['atttime'];
																					}



																					?></td>
											</tr>
											<tr>
												<td align="center" bgcolor="#ffff66"><?
																										/* leave display */
																										/*$sql_l = "select reasons,leaveid,leavetypeid from tbleave_transaction 
				where empno='".$row['empno']."' 
				and '".$row0['workdate']."' between leavestartdate and leaveenddate 
				and statusapprove !='Cancel'
				and statusapprove !='Reject'";
				$res_l = mssql_query($sql_l);
				$num_l = mssql_num_rows($res_l);*/
																										if ($num_l > 0) {
																											$row_l = mssql_fetch_array($res_l);
																											$leavetypeid = $row_l['leavetypeid'];
																											$leavename = get_leavename($leavetypeid);
																											$leave_txt = "<center><font color='#6600ff'> $leavename</font></center>";
																											echo $leave_txt;
																										} else { }
																										?></td>
											</tr>
										</table>



									</td><?
														}



														?>

							</tr>

					<?
							}
						}
						?>


				</table>
			</td>
		</tr>
	</table>
<?



}

if ($status == 'showatt') {
	$paycode = $_REQUEST['paycode'];
	$tsite = $_REQUEST['tsite'];
	$select = "select paycode,convert(varchar, startdate, 101)as  startdate,
	convert(varchar, enddate, 101)as  enddate from  tbpaycode where paycode = '$paycode' ";
	$re = mssql_query($select);
	$num = mssql_num_rows($re);

	$row = mssql_fetch_array($re);
	$startdate = $row['startdate'];
	$enddate = $row['enddate'];


	$html0 = "";
	$html0 .= "<table width='100%' border='0' cellspacing='0' cellpadding='0' ><tr><td align='center' bgcolor='#CCCCCC'><table width='100%' border='0' cellspacing='1' cellpadding='0' ><tr><td align='center' width='50' height='20' style='border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid'><strong>Name</strong></td>";

	if($tsite == 'TSC Sub'){
		$select0 = "SELECT *,
		convert(varchar, workdate, 101)as  workdate2,
		convert(varchar, workdate, 103)as  workdate3
		FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='TSC'  order by workdate asc ";
	}else{
		$select0 = "SELECT *,
		convert(varchar, workdate, 101)as  workdate2,
		convert(varchar, workdate, 103)as  workdate3
		FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";
	}
	$re0 = mssql_query($select0);
	$num0 = mssql_num_rows($re0);
	if ($num0 > 0) {
		while ($row0 = mssql_fetch_array($re0)) {

			$html0 .= "<td align='center' width='33' style='border-right:1px solid; border-bottom:1px solid'><strong>";
			$html0 .= date("d", strtotime($row0['workdate']));
			$html0 .= "</strong></td>";
		}
	}

	$html0 .= "</tr>";


	$select = "select convert(varchar, startdate, 101)as  startdate2,* from  tbemployee where site='$tsite' and emp_level <= 4 and delstatus='0' order by empno asc ";
	$re = mssql_query($select);
	$num = mssql_num_rows($re);
	if ($num > 0) {
		$i = 0;
		while ($row = mssql_fetch_array($re)) {

			$html0 .= "<tr bgcolor='#FFFFFF'><td align='center' width='50' height='40' style='border-right:1px solid; border-left:1px solid; border-bottom:1px solid'>";
			$html0 .= $row['empno'] . "<BR>";
			$html0 .= iconv("tis-620", "utf-8", $row['firstname']);
			$html0 .= "</td>";

			if($tsite == 'TSC Sub'){
			$select0 = "SELECT *,
			convert(varchar, workdate, 101)as  workdate2,
			convert(varchar, workdate, 103)as  workdate3
			
			FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='TSC'  order by workdate asc ";
			}else{
				$select0 = "SELECT *,
				convert(varchar, workdate, 101)as  workdate2,
				convert(varchar, workdate, 103)as  workdate3
				
				FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";	
			}
			$re0 = mssql_query($select0);
			$num0 = mssql_num_rows($re0);

			while ($row0 = mssql_fetch_array($re0)) {

				$html0 .= "<td align='center' width='33' style='border-right:1px solid; border-bottom:1px solid' ";
				if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
					$html0 .= "bgcolor='#CCCCCC'";
				}


				$select_scin = "select convert(varchar, attdatetime, 108)as  atttime,shift from  tbatt where empno='" . $row['empno'] . "' and cast(att_real_date as date)='" . $row0['workdate'] . "' and att_status='in' ";
				//echo $select_scin;
				$re_scin = mssql_query($select_scin);
				$num_scin = mssql_num_rows($re_scin);

				$select_scout = "select convert(varchar, attdatetime, 108)as  atttime,shift from  tbatt where empno='" . $row['empno'] . "' and cast(att_real_date as date)='" . $row0['workdate'] . "' and att_status='out' ";

				$re_scout = mssql_query($select_scout);
				$num_scout = mssql_num_rows($re_scout);

				$sql_l = "select reasons,leaveid,leavetypeid from tbleave_transaction 
						where empno='" . $row['empno'] . "' 
						and '" . $row0['workdate'] . "' between leavestartdate and leaveenddate 
						and statusapprove !='Cancel'
						and statusapprove !='Reject'";
				$res_l = mssql_query($sql_l);
				$num_l = mssql_num_rows($res_l);
				if ($num_scin == 0 && $num_l > 0) {
					$html0 .= "bgcolor='#ffff67'";
					$total_leave[$i]++;
				} else {
					//echo $num2.$num_l;
					if (DateDiff($row['startdate2'], $row0['workdate']) > 0) {
						if ($num_scin == 0 && $num_l == 0) {
							if ($row0['work_type'] != 'H Sat , Sun' && $row0['work_type'] != 'H') {
								if (DateDiff($row0['workdate'], $date_time) > 1) {
									$total_noscan_in[$i]++;
								}
							}
						} else {
							if ($row0['work_type'] != 'H Sat , Sun' && $row0['work_type'] != 'H') {
								if (DateDiff($row0['workdate'], $date_time) > 1) {
									if ($num_scout == 0 && $num_l == 0) {
										$total_noscan_out[$i]++;
									}
								}
							}
						}
					}
				}
				$html0 .= ">";


				$html0 .= "<table width='100%' border='0' cellspacing='0' cellpadding='0'><tr ><td align='center' >";


				$select2 = "select convert(varchar, attdatetime, 108)as  atttime,shift from  tbatt where empno='" . $row['empno'] . "' and cast(att_real_date as date)='" . $row0['workdate'] . "' and att_status='in' ";
				
				$re2 = mssql_query($select2);
				$num2 = mssql_num_rows($re2);
				
				if ($num2 > 0) {
					$row2 = mssql_fetch_array($re2);
					$shift = $row2['shift'];
			
					$html0 .= $shift . "<br>";
					
					if ($shift == "Day") {
						if (TimeDiff("08:00:01", $row2['atttime']) > 0) {
							$html0 .= "<span style='background-color:#FFFFB7'>" . $row2['atttime'] . "</span>";
							//echo "<span style='background-color:#FFFFB7'>".$row2['atttime']."</span>";
							$total_late[$i]++;
						} else {
							//B7FFB7
							$html0 .= "<span style='background-color:#ffffff'>" . $row2['atttime'] . "</span>";
							//echo "<span style='background-color:#ffffff'>".$row2['atttime']."</span>";
						}
					}
					if ($shift == "Night") {
						if (TimeDiff("20:20:01", $row2['atttime']) > 0) {
							$html0 .= "<span style='background-color:#FFFFB7'>" . $row2['atttime'] . "</span>";
							//echo "<span style='background-color:#FFFFB7'>".$row2['atttime']."</span>";
							$total_late[$i]++;
						} else {
							//B7FFB7
							$html0 .= "<span style='background-color:#ffffff'>" . $row2['atttime'] . "</span>";
							//echo "<span style='background-color:#ffffff'>".$row2['atttime']."</span>";
						}
					}
				}

				$html0 .= "</td></tr><tr>";
				$html0 .= "<td align='center'>";


				$select2 = "select convert(varchar, attdatetime, 108)as  atttime from  tbatt where empno='" . $row['empno'] . "' and cast(att_real_date as date)='" . $row0['workdate'] . "' and att_status='out' ";

				$re2 = mssql_query($select2);
				$num2 = mssql_num_rows($re2);
				if ($num2 > 0) {
					$row2 = mssql_fetch_array($re2);
					$html0 .= $row2['atttime'];
					//echo $row2['atttime'];
				}

				$html0 .= "</td></tr> <tr><td align='center' bgcolor='#ffff66'>";


				/* leave display */
				/*$sql_l = "select reasons,leaveid,leavetypeid from tbleave_transaction 
					where empno='".$row['empno']."' 
					and '".$row0['workdate']."' between leavestartdate and leaveenddate 
					and statusapprove !='Cancel'
					and statusapprove !='Reject'";
					$res_l = mssql_query($sql_l);
					$num_l = mssql_num_rows($res_l);*/
				if ($num_l > 0) {
					$row_l = mssql_fetch_array($res_l);
					$leavetypeid = $row_l['leavetypeid'];
					$leavename = get_leavename($leavetypeid);
					$leave_txt = "<center><font color='#6600ff'> $leavename</font></center>";
					$html0 .= $leave_txt;
				}

				$html0 .= "</td></tr></table></td>";
			}


			$html0 .= "</tr>";

			$i++;
		}
	}

	$html0 .= "</table></td></tr></table>";
	?>








	<table width="550" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td align="center" bgcolor="#CCCCCC">
				<table width="100%" border="0" cellspacing="1" cellpadding="0">
					<tr bgcolor="#cccccc">
						<td align="center" style="border-right:1px solid; border-bottom:1px solid"><strong>Emp No.</strong></td>
						<td height="25" align="center" style="border-right:1px solid; border-bottom:1px solid"><strong>Name</strong></td>
						<td align="center" style="border-left:1px solid;border-right:1px solid; border-bottom:1px solid"><strong>มาสาย</strong></td>
						<td align="center" style="border-left:1px solid;border-right:1px solid; border-bottom:1px solid"><strong>มาสาย(ต่อปี)</strong></td>
						<td align="center" style="border-left:1px solid;border-right:1px solid; border-bottom:1px solid"><strong>ไม่แสกนเข้า</strong></td>
						<td align="center" style="border-left:1px solid;border-right:1px solid; border-bottom:1px solid"><strong>ไม่แสกนออก</strong></td>
						<td align="center" style="border-left:1px solid;border-right:1px solid; border-bottom:1px solid"><strong>ลา หรือ อื่นๆ</strong></td>
					</tr>
					<?
						$select = "select * from  tbemployee where site='$tsite' and emp_level <= 4 and delstatus='0' order by empno asc ";
						$re = mssql_query($select);
						$num = mssql_num_rows($re);
						if ($num > 0) {
							$i = 0;
							while ($row = mssql_fetch_array($re)) {
								?>
							<tr bgcolor="#ffffff">
								<td style="border-left:1px solid;border-right:1px solid; border-bottom:1px solid"><?= $row['empno'] ?></td>
								<td height="25" style="border-left:1px solid;border-right:1px solid; border-bottom:1px solid"><? echo iconv("tis-620", "utf-8", $row['firstname']); ?></td>
								<td style="border-left:1px solid;border-right:1px solid; border-bottom:1px solid"><?

																																echo $total_late[$i];
																																?></td>
								<td align="center" style="border-right:1px solid; border-bottom:1px solid"><?

																														$select_latey = "select count(empno) as total_late from tbatt_approve where paycode in (SELECT paycode from tbpaycode WHERE paycodeyear='$txtyear') and ishift='Day' and cast(iattDateTime1 as time)>'08:00:00' and status_approve=1
			and empno='" . $row['empno'] . "' and cast(iattDateTime1 as date) not in(select leavestartdate from tbleave_transaction where empno='" . $row['empno'] . "')
			";
																														$re_latey = mssql_query($select_latey);
																														$num_latey = mssql_num_rows($re_latey);
																														if ($num_latey > 0) {
																															$row_latey = mssql_fetch_array($re_latey);
																															$total_late_day =  $row_latey['total_late'];
																														}
																														$select_latey = "select count(empno) as total_late from tbatt_approve where paycode in (SELECT paycode from tbpaycode WHERE paycodeyear='$txtyear') and ishift='Night' and cast(iattDateTime1 as time)>'20:20:00' and status_approve=1
			and empno='" . $row['empno'] . "'  and cast(iattDateTime1 as date) not in(select leavestartdate from tbleave_transaction where empno='" . $row['empno'] . "')
			";
																														$re_latey = mssql_query($select_latey);
																														$num_latey = mssql_num_rows($re_latey);
																														if ($num_latey > 0) {
																															$row_latey = mssql_fetch_array($re_latey);
																															$total_late_night =  $row_latey['total_late'];
																														}
																														
																														 echo $total_late_day + $total_late_night;
																														?>&nbsp;<input type="button" value="view" onClick="window.open('pop_report_att.php?empno=<?= $row['empno'] ?>','pop1','width=600,height=400,scrollbars=yes')"></td>
								<td align="center" style="border-right:1px solid; border-bottom:1px solid"><?
																														echo $total_noscan_in[$i];
																														?></td>
								<td align="center" style="border-right:1px solid; border-bottom:1px solid"><?
																														echo $total_noscan_out[$i];
																														?></td>
								<td align="center" style="border-right:1px solid; border-bottom:1px solid"><?
																														echo $total_leave[$i];
																														?></td>
							</tr>
					<?
								$i++;
							}
						}
						?>
				</table>
			</td>
		</tr>
	</table>

<?

	echo $html0;
}
if ($status == 'showatt_month') {
	$month = $_REQUEST['month'];
	$tsite = $_REQUEST['tsite2'];
	$month_explode_arr = explode("-", $month);
	$mmonth = $month_explode_arr[1];
	$yyear = $month_explode_arr[0];


	//$select="select paycode,convert(varchar, startdate, 101)as  startdate,
	//convert(varchar, enddate, 101)as  enddate from  tbpaycode where paycode = '$paycode' ";
	//$re=mssql_query($select);
	//$num=mssql_num_rows($re);

	//$row=mssql_fetch_array($re);
	$number = cal_days_in_month(CAL_GREGORIAN, $mmonth, $yyear);
	$startdate = $month . "-01";
	$enddate = $month . "-" . $number;


	$html0 = "";
	$html0 .= "<table width='100%' border='0' cellspacing='0' cellpadding='0' ><tr><td align='center' bgcolor='#CCCCCC'><table width='100%' border='0' cellspacing='1' cellpadding='0' ><tr><td align='center' width='50' height='20' style='border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid'><strong>Name</strong></td>";


	if($tsite == 'TSC Sub'){
	$select0 = "SELECT *,
			convert(varchar, workdate, 101)as  workdate2,
			convert(varchar, workdate, 103)as  workdate3
			
	FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='TSC'  order by workdate asc ";
	}else{
	$select0 = "SELECT *,
			convert(varchar, workdate, 101)as  workdate2,
			convert(varchar, workdate, 103)as  workdate3
			
	FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";
	}
	$re0 = mssql_query($select0);
	$num0 = mssql_num_rows($re0);
	if ($num0 > 0) {
		while ($row0 = mssql_fetch_array($re0)) {

			$html0 .= "<td align='center' width='33' style='border-right:1px solid; border-bottom:1px solid'><strong>";
			$html0 .= date("d", strtotime($row0['workdate']));
			$html0 .= "</strong></td>";
		}
	}

	$html0 .= "</tr>";


	$select = "select convert(varchar, startdate, 101)as  startdate2,* from  tbemployee where site='$tsite' and emp_level <= 7 and delstatus='0' order by empno asc ";
	$re = mssql_query($select);
	$num = mssql_num_rows($re);
	if ($num > 0) {
		$i = 0;
		while ($row = mssql_fetch_array($re)) {

			$html0 .= "<tr bgcolor='#FFFFFF'><td align='center' width='50' height='40' style='border-right:1px solid; border-left:1px solid; border-bottom:1px solid'>";
			$html0 .= $row['empno'] . "<BR>";
			$html0 .= iconv("tis-620", "utf-8", $row['firstname']);
			$html0 .= "</td>";

			if($tsite == 'TSC Sub'){
			$select0 = "SELECT *,
			convert(varchar, workdate, 101)as  workdate2,
			convert(varchar, workdate, 103)as  workdate3
			
			FROM tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='TSC'  order by workdate asc ";
			}else{
			$select0 = "SELECT *,
			convert(varchar, workdate, 101)as  workdate2,
			convert(varchar, workdate, 103)as  workdate3
			
			FROM tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";
			}
			$re0 = mssql_query($select0);
			$num0 = mssql_num_rows($re0);

			while ($row0 = mssql_fetch_array($re0)) {

				$html0 .= "<td align='center' width='33' style='border-right:1px solid; border-bottom:1px solid' ";
				if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
					$html0 .= "bgcolor='#CCCCCC'";
				}


				$select_scin = "select convert(varchar, attdatetime, 108)as  atttime,shift from  tbatt where empno='" . $row['empno'] . "' and cast(att_real_date as date)='" . $row0['workdate'] . "' and att_status='in' ";

				$re_scin = mssql_query($select_scin);
				$num_scin = mssql_num_rows($re_scin);

				$select_scout = "select convert(varchar, attdatetime, 108)as  atttime,shift from  tbatt where empno='" . $row['empno'] . "' and cast(att_real_date as date)='" . $row0['workdate'] . "' and att_status='out' ";

				$re_scout = mssql_query($select_scout);
				$num_scout = mssql_num_rows($re_scout);

				$sql_l = "select reasons,leaveid,leavetypeid from tbleave_transaction 
						where empno='" . $row['empno'] . "' 
						and '" . $row0['workdate'] . "' between leavestartdate and leaveenddate 
						and statusapprove !='Cancel'
						and statusapprove !='Reject'";
				$res_l = mssql_query($sql_l);
				$num_l = mssql_num_rows($res_l);
				if ($num_scin == 0 && $num_l > 0) {
					$html0 .= "bgcolor='#ffff67'";
					$total_leave[$i]++;
				} else {
					//echo $num2.$num_l;
					if (DateDiff($row['startdate2'], $row0['workdate']) > 0) {
						if ($num_scin == 0 && $num_l == 0) {
							if ($row0['work_type'] != 'H Sat , Sun' && $row0['work_type'] != 'H') {
								if (DateDiff($row0['workdate'], $date_time) > 1) {
									$total_noscan_in[$i]++;
								}
							}
						} else {
							if ($row0['work_type'] != 'H Sat , Sun' && $row0['work_type'] != 'H') {
								if (DateDiff($row0['workdate'], $date_time) > 1) {
									if ($num_scout == 0 && $num_l == 0) {
										$total_noscan_out[$i]++;
									}
								}
							}
						}
					}
				}
				$html0 .= ">";


				$html0 .= "<table width='100%' border='0' cellspacing='0' cellpadding='0'><tr ><td align='center' >";


				$select2 = "select convert(varchar, attdatetime, 108)as  atttime,shift from  tbatt where empno='" . $row['empno'] . "' and cast(att_real_date as date)='" . $row0['workdate'] . "' and att_status='in' ";

				$re2 = mssql_query($select2);
				$num2 = mssql_num_rows($re2);
				if ($num2 > 0) {
					$row2 = mssql_fetch_array($re2);
					$shift = $row2['shift'];

					$html0 .= $shift . "<br>";

					if ($shift == "Day") {
						if (TimeDiff("08:00:01", $row2['atttime']) > 0) {
							$html0 .= "<span style='background-color:#FFFFB7'>" . $row2['atttime'] . "</span>";
							//echo "<span style='background-color:#FFFFB7'>".$row2['atttime']."</span>";
							$total_late[$i]++;
						} else {
							//B7FFB7
							$html0 .= "<span style='background-color:#ffffff'>" . $row2['atttime'] . "</span>";
							//echo "<span style='background-color:#ffffff'>".$row2['atttime']."</span>";
						}
					}
					if ($shift == "Night") {
						if (TimeDiff("20:20:01", $row2['atttime']) > 0) {
							$html0 .= "<span style='background-color:#FFFFB7'>" . $row2['atttime'] . "</span>";
							//echo "<span style='background-color:#FFFFB7'>".$row2['atttime']."</span>";
							$total_late[$i]++;
						} else {
							//B7FFB7
							$html0 .= "<span style='background-color:#ffffff'>" . $row2['atttime'] . "</span>";
							//echo "<span style='background-color:#ffffff'>".$row2['atttime']."</span>";
						}
					}
				}

				$html0 .= "</td></tr><tr>";
				$html0 .= "<td align='center'>";


				$select2 = "select convert(varchar, attdatetime, 108)as  atttime from  tbatt where empno='" . $row['empno'] . "' and cast(att_real_date as date)='" . $row0['workdate'] . "' and att_status='out' ";

				$re2 = mssql_query($select2);
				$num2 = mssql_num_rows($re2);
				if ($num2 > 0) {
					$row2 = mssql_fetch_array($re2);
					$html0 .= $row2['atttime'];
					//echo $row2['atttime'];
				}

				$html0 .= "</td></tr> <tr><td align='center' bgcolor='#ffff66'>";


				/* leave display */
				/*$sql_l = "select reasons,leaveid,leavetypeid from tbleave_transaction 
					where empno='".$row['empno']."' 
					and '".$row0['workdate']."' between leavestartdate and leaveenddate 
					and statusapprove !='Cancel'
					and statusapprove !='Reject'";
					$res_l = mssql_query($sql_l);
					$num_l = mssql_num_rows($res_l);*/
				if ($num_l > 0) {
					$row_l = mssql_fetch_array($res_l);
					$leavetypeid = $row_l['leavetypeid'];
					$leavename = get_leavename($leavetypeid);
					$leave_txt = "<center><font color='#6600ff'> $leavename</font></center>";
					$html0 .= $leave_txt;
				}

				$html0 .= "</td></tr></table></td>";
			}


			$html0 .= "</tr>";

			$i++;
		}
	}

	$html0 .= "</table></td></tr></table>";
	?>








	<table width="550" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td align="center" bgcolor="#CCCCCC">
				<table width="100%" border="0" cellspacing="1" cellpadding="0">
					<tr bgcolor="#cccccc">
						<td align="center" style="border-right:1px solid; border-bottom:1px solid"><strong>Emp No.</strong></td>
						<td height="25" align="center" style="border-right:1px solid; border-bottom:1px solid"><strong>Name</strong></td>
						<td align="center" style="border-left:1px solid;border-right:1px solid; border-bottom:1px solid"><strong>มาสาย</strong></td>
						<td align="center" style="border-left:1px solid;border-right:1px solid; border-bottom:1px solid"><strong>มาสาย(ต่อปี)</strong></td>
						<td align="center" style="border-left:1px solid;border-right:1px solid; border-bottom:1px solid"><strong>ไม่แสกนเข้า</strong></td>
						<td align="center" style="border-left:1px solid;border-right:1px solid; border-bottom:1px solid"><strong>ไม่แสกนออก</strong></td>
						<td align="center" style="border-left:1px solid;border-right:1px solid; border-bottom:1px solid"><strong>ลา หรือ อื่นๆ</strong></td>
					</tr>
					<?
						$select = "select * from  tbemployee where site='$tsite' and emp_level <= 7 and delstatus='0' order by empno asc ";
						$re = mssql_query($select);
						$num = mssql_num_rows($re);
						if ($num > 0) {
							$i = 0;
							while ($row = mssql_fetch_array($re)) {
								?>
							<tr bgcolor="#ffffff">
								<td style="border-left:1px solid;border-right:1px solid; border-bottom:1px solid"><?= $row['empno'] ?></td>
								<td height="25" style="border-left:1px solid;border-right:1px solid; border-bottom:1px solid"><? echo iconv("tis-620", "utf-8", $row['firstname']); ?></td>
								<td style="border-left:1px solid;border-right:1px solid; border-bottom:1px solid"><?

																																echo $total_late[$i];
																																?></td>
								<td align="center" style="border-right:1px solid; border-bottom:1px solid"><?

																														$select_latey = "select count(empno) as total_late from tbatt_approve where paycode in (SELECT paycode from tbpaycode WHERE paycodeyear='$txtyear') and ishift='Day' and cast(iattDateTime1 as time)>'08:00:00' and status_approve=1
			and empno='" . $row['empno'] . "'  and cast(iattDateTime1 as date) not in(select leavestartdate from tbleave_transaction where empno='" . $row['empno'] . "') 
			";
																														$re_latey = mssql_query($select_latey);
																														$num_latey = mssql_num_rows($re_latey);
																														if ($num_latey > 0) {
																															$row_latey = mssql_fetch_array($re_latey);
																															$total_late_day =  $row_latey['total_late'];
																														}
																														$select_latey = "select count(empno) as total_late from tbatt_approve where paycode in (SELECT paycode from tbpaycode WHERE paycodeyear='$txtyear') and ishift='Night' and cast(iattDateTime1 as time)>'20:20:00' and status_approve=1
			and empno='" . $row['empno'] . "'  and cast(iattDateTime1 as date) not in(select leavestartdate from tbleave_transaction where empno='" . $row['empno'] . "')
			";
																														$re_latey = mssql_query($select_latey);
																														$num_latey = mssql_num_rows($re_latey);
																														if ($num_latey > 0) {
																															$row_latey = mssql_fetch_array($re_latey);
																															$total_late_night =  $row_latey['total_late'];
																														}
																														echo $total_late_day + $total_late_night;
																														?>&nbsp;<input type="button" value="view" onClick="window.open('pop_report_att.php?empno=<?= $row['empno'] ?>','pop1','width=600,height=400,scrollbars=yes')"></td>
								<td align="center" style="border-right:1px solid; border-bottom:1px solid"><?
																														echo $total_noscan_in[$i];
																														?></td>
								<td align="center" style="border-right:1px solid; border-bottom:1px solid"><?
																														echo $total_noscan_out[$i];
																														?></td>
								<td align="center" style="border-right:1px solid; border-bottom:1px solid"><?
																														echo $total_leave[$i];
																														?></td>
							</tr>
					<?
								$i++;
							}
						}
						?>
				</table>
			</td>
		</tr>
	</table>

	<?

	echo $html0;
}

if ($status == 'exportatt_month') {
	header("Content-Type: application/vnd.ms-excel");
	header('Content-Disposition: attachment; filename="att_report"' . $date_time . '".xls"'); #ชื่อไฟล์
	?>

	<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet" xmlns="http://www.w3.org/TR/REC-html40">

	<body>
		<?
			$month = $_REQUEST['month'];
			$tsite = $_REQUEST['tsite2'];
			$month_explode_arr = explode("-", $month);
			$mmonth = $month_explode_arr[1];
			$yyear = $month_explode_arr[0];



			$number = cal_days_in_month(CAL_GREGORIAN, $mmonth, $yyear);
			$startdate = $month . "-01";
			$enddate = $month . "-" . $number;


			$html0 = "";
			$html0 .= "<table width='100%' border='0' cellspacing='0' cellpadding='0' ><tr><td align='center' bgcolor='#CCCCCC'><table width='100%' border='0' cellspacing='1' cellpadding='0' ><tr><td align='center' width='50' height='20' style='border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid'><strong>Name</strong></td>";


			if($tsite == 'TSC Sub'){
			$select0 = "SELECT *,
			convert(varchar, workdate, 101)as  workdate2,
			convert(varchar, workdate, 103)as  workdate3
			
			FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='TSC'  order by workdate asc ";
			}else{
			$select0 = "SELECT *,
			convert(varchar, workdate, 101)as  workdate2,
			convert(varchar, workdate, 103)as  workdate3
			
			FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";
			}
			$re0 = mssql_query($select0);
			$num0 = mssql_num_rows($re0);
			if ($num0 > 0) {
				while ($row0 = mssql_fetch_array($re0)) {

					$html0 .= "<td align='center' width='33' style='border-right:1px solid; border-bottom:1px solid'><strong>";
					$html0 .= date("d", strtotime($row0['workdate']));
					$html0 .= "</strong></td>";
				}
			}

			$html0 .= "</tr>";


			$select = "select convert(varchar, startdate, 101)as  startdate2,* from  tbemployee where site='$tsite' and emp_level <= 7 and delstatus='0' order by empno asc ";
			$re = mssql_query($select);
			$num = mssql_num_rows($re);
			if ($num > 0) {
				$i = 0;
				while ($row = mssql_fetch_array($re)) {

					$html0 .= "<tr bgcolor='#FFFFFF'><td align='center' width='50' height='40' style='border-right:1px solid; border-left:1px solid; border-bottom:1px solid'>";
					$html0 .= $row['empno'] . "<BR>";
					$html0 .= iconv("tis-620", "utf-8", $row['firstname']);
					$html0 .= "</td>";

					if($tsite == 'TSC Sub'){
					$select0 = "SELECT *,
			convert(varchar, workdate, 101)as  workdate2,
			convert(varchar, workdate, 103)as  workdate3
			
			FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='TSC'  order by workdate asc ";
					}else{
			$select0 = "SELECT *,
			convert(varchar, workdate, 101)as  workdate2,
			convert(varchar, workdate, 103)as  workdate3
			
			FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";
					}
					$re0 = mssql_query($select0);
					$num0 = mssql_num_rows($re0);

					while ($row0 = mssql_fetch_array($re0)) {

						$html0 .= "<td align='center' width='33' style='border-right:1px solid; border-bottom:1px solid' ";
						if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
							//$html0.="bgcolor='#CCCCCC'";
							$bgcolor = "#CCCCCC";
						} else {
							$bgcolor = "#FFFFFF";
						}


						$select_scin = "select convert(varchar, attdatetime, 108)as  atttime,shift from  tbatt where empno='" . $row['empno'] . "' and cast(att_real_date as date)='" . $row0['workdate'] . "' and att_status='in' ";

						$re_scin = mssql_query($select_scin);
						$num_scin = mssql_num_rows($re_scin);

						$select_scout = "select convert(varchar, attdatetime, 108)as  atttime,shift from  tbatt where empno='" . $row['empno'] . "' and cast(att_real_date as date)='" . $row0['workdate'] . "' and att_status='out' ";

						$re_scout = mssql_query($select_scout);
						$num_scout = mssql_num_rows($re_scout);

						$sql_l = "select reasons,leaveid,leavetypeid from tbleave_transaction 
						where empno='" . $row['empno'] . "' 
						and '" . $row0['workdate'] . "' between leavestartdate and leaveenddate 
						and statusapprove !='Cancel'
						and statusapprove !='Reject'";
						$res_l = mssql_query($sql_l);
						$num_l = mssql_num_rows($res_l);
						if ($num_scin == 0 && $num_l > 0) {
							//$html0.="bgcolor='#ffff67'";
							$bgcolor = "#ffff67";
							$total_leave[$i]++;
						} else {
							//$html0.="bgcolor='#FFFFFF'";

							//echo $num2.$num_l;
							if (DateDiff($row['startdate2'], $row0['workdate']) > 0) {
								if ($num_scin == 0 && $num_l == 0) {
									if ($row0['work_type'] != 'H Sat , Sun' && $row0['work_type'] != 'H') {
										if (DateDiff($row0['workdate'], $date_time) > 1) {
											$total_noscan_in[$i]++;
										}
									}
								} else {
									if ($row0['work_type'] != 'H Sat , Sun' && $row0['work_type'] != 'H') {
										if (DateDiff($row0['workdate'], $date_time) > 1) {
											if ($num_scout == 0 && $num_l == 0) {
												$total_noscan_out[$i]++;
											}
										}
									}
								}
							}
						}
						$html0 .= " bgcolor='$bgcolor'>";


						$html0 .= "<table width='100%' border='0' cellspacing='0' cellpadding='0'><tr ><td align='center' >";


						$select2 = "select convert(varchar, attdatetime, 108)as  atttime,shift from  tbatt where empno='" . $row['empno'] . "' and cast(att_real_date as date)='" . $row0['workdate'] . "' and att_status='in' ";

						$re2 = mssql_query($select2);
						$num2 = mssql_num_rows($re2);
						if ($num2 > 0) {
							$row2 = mssql_fetch_array($re2);
							$shift = $row2['shift'];

							$html0 .= $shift . "<br>";
							$fontcolor = "#000000";
							if ($shift == "Day") {
								if (TimeDiff("08:00:01", $row2['atttime']) > 0) {
									$fontcolor = "red";
									$total_late[$i]++;
								}
							}
							if ($shift == "Night") {
								if (TimeDiff("20:20:01", $row2['atttime']) > 0) {
									$fontcolor = "red";
									$total_late[$i]++;
								}
							}
							$html0 .= "<font color=$fontcolor>" . $row2['atttime'] . "</font>";
						}

						$html0 .= "</td></tr><tr>";
						$html0 .= "<td align='center'>";


						$select2 = "select convert(varchar, attdatetime, 108)as  atttime from  tbatt where empno='" . $row['empno'] . "' and cast(att_real_date as date)='" . $row0['workdate'] . "' and att_status='out' ";

						$re2 = mssql_query($select2);
						$num2 = mssql_num_rows($re2);
						if ($num2 > 0) {
							$row2 = mssql_fetch_array($re2);
							$html0 .= $row2['atttime'];
							//echo $row2['atttime'];
						}

						$html0 .= "</td></tr> <tr><td align='center' bgcolor='$bgcolor'>";
						//ffff66

						/* leave display */
						/*$sql_l = "select reasons,leaveid,leavetypeid from tbleave_transaction 
					where empno='".$row['empno']."' 
					and '".$row0['workdate']."' between leavestartdate and leaveenddate 
					and statusapprove !='Cancel'
					and statusapprove !='Reject'";
					$res_l = mssql_query($sql_l);
					$num_l = mssql_num_rows($res_l);*/
						if ($num_l > 0) {
							$row_l = mssql_fetch_array($res_l);
							$leavetypeid = $row_l['leavetypeid'];
							$leavename = get_leavename($leavetypeid);
							$leave_txt = "<span style='background-color:#ffff66'>$leavename</span>";
							$html0 .= $leave_txt;
						}

						$html0 .= "</td></tr></table></td>";
					}


					$html0 .= "</tr>";

					$i++;
				}
			}

			$html0 .= "</table></td></tr></table>";
			?>






		<table width="550" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td align="center" bgcolor="#CCCCCC">
					<table width="100%" border="0" cellspacing="1" cellpadding="0">
						<tr bgcolor="#cccccc">
							<td align="center" style="border-right:1px solid; border-bottom:1px solid"><strong>Emp No.</strong></td>
							<td height="25" align="center" style="border-right:1px solid; border-bottom:1px solid"><strong>Name</strong></td>
							<td align="center" style="border-left:1px solid;border-right:1px solid; border-bottom:1px solid"><strong>มาสาย</strong></td>
							<td align="center" style="border-left:1px solid;border-right:1px solid; border-bottom:1px solid"><strong>มาสาย(ต่อปี)</strong></td>
							<td align="center" style="border-left:1px solid;border-right:1px solid; border-bottom:1px solid"><strong>ไม่แสกนเข้า</strong></td>
							<td align="center" style="border-left:1px solid;border-right:1px solid; border-bottom:1px solid"><strong>ไม่แสกนออก</strong></td>
							<td align="center" style="border-left:1px solid;border-right:1px solid; border-bottom:1px solid"><strong>ลา หรือ อื่นๆ</strong></td>
						</tr>
						<?
							$select = "select * from  tbemployee where site='$tsite' and emp_level <= 7 and delstatus='0' order by empno asc ";
							$re = mssql_query($select);
							$num = mssql_num_rows($re);
							if ($num > 0) {
								$i = 0;
								while ($row = mssql_fetch_array($re)) {
									?>
								<tr bgcolor="#ffffff">
									<td style="border-left:1px solid;border-right:1px solid; border-bottom:1px solid"><?= $row['empno'] ?></td>
									<td height="25" style="border-left:1px solid;border-right:1px solid; border-bottom:1px solid"><? echo iconv("tis-620", "utf-8", $row['firstname']); ?></td>
									<td style="border-left:1px solid;border-right:1px solid; border-bottom:1px solid"><?

																																	echo $total_late[$i];
																																	?></td>
									<td align="center" style="border-right:1px solid; border-bottom:1px solid"><?

																															$select_latey = "select count(empno) as total_late from tbatt_approve where paycode in (SELECT paycode from tbpaycode WHERE paycodeyear='$txtyear') and ishift='Day' and cast(iattDateTime1 as time)>'08:00:00' and status_approve=1
			and empno='" . $row['empno'] . "'  and cast(iattDateTime1 as date) not in(select leavestartdate from tbleave_transaction where empno='" . $row['empno'] . "')
			";
																															$re_latey = mssql_query($select_latey);
																															$num_latey = mssql_num_rows($re_latey);
																															if ($num_latey > 0) {
																																$row_latey = mssql_fetch_array($re_latey);
																																$total_late_day =  $row_latey['total_late'];
																															}
																															$select_latey = "select count(empno) as total_late from tbatt_approve where paycode in (SELECT paycode from tbpaycode WHERE paycodeyear='$txtyear') and ishift='Night' and cast(iattDateTime1 as time)>'20:20:00' and status_approve=1
			and empno='" . $row['empno'] . "'  and cast(iattDateTime1 as date) not in(select leavestartdate from tbleave_transaction where empno='" . $row['empno'] . "')
			";
																															$re_latey = mssql_query($select_latey);
																															$num_latey = mssql_num_rows($re_latey);
																															if ($num_latey > 0) {
																																$row_latey = mssql_fetch_array($re_latey);
																																$total_late_night =  $row_latey['total_late'];
																															}
																															echo $total_late_day + $total_late_night;
																															?></td>
									<td align="center" style="border-right:1px solid; border-bottom:1px solid"><?
																															echo $total_noscan_in[$i];
																															?></td>
									<td align="center" style="border-right:1px solid; border-bottom:1px solid"><?
																															echo $total_noscan_out[$i];
																															?></td>
									<td align="center" style="border-right:1px solid; border-bottom:1px solid"><?
																															echo $total_leave[$i];
																															?></td>
								</tr>
						<?
									$i++;
								}
							}
							?>
					</table>
				</td>
			</tr>
		</table>

	<?

		echo $html0;
	}
	if ($status == 'exportatt') {


		header("Content-Type: application/vnd.ms-excel");
		header('Content-Disposition: attachment; filename="att_report"' . $date_time . '".xls"'); #ชื่อไฟล์
		?>

		<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet" xmlns="http://www.w3.org/TR/REC-html40">

		<body>
			<?

				$paycode = $_REQUEST['paycode'];
				$tsite = $_REQUEST['tsite'];

				$select = "select paycode,convert(varchar, startdate, 101)as  startdate,
	convert(varchar, enddate, 101)as  enddate from  tbpaycode where paycode = '$paycode' ";
				$re = mssql_query($select);
				$num = mssql_num_rows($re);

				$row = mssql_fetch_array($re);
				$startdate = $row['startdate'];
				$enddate = $row['enddate'];


				$html0 = "";
				$html0 .= "<table width='100%' border='0' cellspacing='0' cellpadding='0' ><tr><td align='center' bgcolor='#CCCCCC'><table width='100%' border='0' cellspacing='1' cellpadding='0' ><tr><td align='center' width='50' height='20' style='border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid'><strong>Name</strong></td>";


				if($tsite == 'TSC Sub'){
				$select0 = "SELECT *,
			convert(varchar, workdate, 101)as  workdate2,
			convert(varchar, workdate, 103)as  workdate3
			
			FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='TSC'  order by workdate asc ";
				}else{
				$select0 = "SELECT *,
			convert(varchar, workdate, 101)as  workdate2,
			convert(varchar, workdate, 103)as  workdate3
			
			FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";
				}
				$re0 = mssql_query($select0);
				$num0 = mssql_num_rows($re0);
				if ($num0 > 0) {
					while ($row0 = mssql_fetch_array($re0)) {

						$html0 .= "<td align='center' width='33' style='border-right:1px solid; border-bottom:1px solid'><strong>";
						$html0 .= date("d", strtotime($row0['workdate']));
						$html0 .= "</strong></td>";
					}
				}

				$html0 .= "</tr>";


				$select = "select convert(varchar, startdate, 101)as  startdate2,* from  tbemployee where site='$tsite' and emp_level <= 4 and delstatus='0' order by empno asc ";
				$re = mssql_query($select);
				$num = mssql_num_rows($re);
				if ($num > 0) {
					$i = 0;
					while ($row = mssql_fetch_array($re)) {

						$html0 .= "<tr bgcolor='#FFFFFF'><td align='center' width='50' height='40' style='border-right:1px solid; border-left:1px solid; border-bottom:1px solid'>";
						$html0 .= $row['empno'] . "<BR>";
						$html0 .= iconv("tis-620", "utf-8", $row['firstname']);
						$html0 .= "</td>";

						if($tsite == 'TSC Sub'){
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='TSC'  order by workdate asc ";
						}else{
						$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
						FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";
						}
						$re0 = mssql_query($select0);
						$num0 = mssql_num_rows($re0);

						while ($row0 = mssql_fetch_array($re0)) {

							$html0 .= "<td align='center' width='33' style='border-right:1px solid; border-bottom:1px solid' ";
							if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
								//$html0.="bgcolor='#CCCCCC'";
								$bgcolor = "#CCCCCC";
							} else {
								$bgcolor = "#FFFFFF";
							}


							$select_scin = "select convert(varchar, attdatetime, 108)as  atttime,shift from  tbatt where empno='" . $row['empno'] . "' and cast(att_real_date as date)='" . $row0['workdate'] . "' and att_status='in' ";

							$re_scin = mssql_query($select_scin);
							$num_scin = mssql_num_rows($re_scin);

							$select_scout = "select convert(varchar, attdatetime, 108)as  atttime,shift from  tbatt where empno='" . $row['empno'] . "' and cast(att_real_date as date)='" . $row0['workdate'] . "' and att_status='out' ";

							$re_scout = mssql_query($select_scout);
							$num_scout = mssql_num_rows($re_scout);

							$sql_l = "select reasons,leaveid,leavetypeid from tbleave_transaction 
						where empno='" . $row['empno'] . "' 
						and '" . $row0['workdate'] . "' between leavestartdate and leaveenddate 
						and statusapprove !='Cancel'
						and statusapprove !='Reject'";
							$res_l = mssql_query($sql_l);
							$num_l = mssql_num_rows($res_l);
							if ($num_scin == 0 && $num_l > 0) {
								//$html0.="bgcolor='#ffff67'";
								$bgcolor = "#ffff67";
								$total_leave[$i]++;
							} else {
								//$html0.="bgcolor='#FFFFFF'";

								//echo $num2.$num_l;
								if (DateDiff($row['startdate2'], $row0['workdate']) > 0) {
									if ($num_scin == 0 && $num_l == 0) {
										if ($row0['work_type'] != 'H Sat , Sun' && $row0['work_type'] != 'H') {
											if (DateDiff($row0['workdate'], $date_time) > 1) {
												$total_noscan_in[$i]++;
											}
										}
									} else {
										if ($row0['work_type'] != 'H Sat , Sun' && $row0['work_type'] != 'H') {
											if (DateDiff($row0['workdate'], $date_time) > 1) {
												if ($num_scout == 0 && $num_l == 0) {
													$total_noscan_out[$i]++;
												}
											}
										}
									}
								}
							}
							$html0 .= " bgcolor='$bgcolor'>";


							$html0 .= "<table width='100%' border='0' cellspacing='0' cellpadding='0'><tr ><td align='center' >";


							$select2 = "select convert(varchar, attdatetime, 108)as  atttime,shift from  tbatt where empno='" . $row['empno'] . "' and cast(att_real_date as date)='" . $row0['workdate'] . "' and att_status='in' ";

							$re2 = mssql_query($select2);
							$num2 = mssql_num_rows($re2);
							if ($num2 > 0) {
								$row2 = mssql_fetch_array($re2);
								$shift = $row2['shift'];

								$html0 .= $shift . "<br>";
								$fontcolor = "#000000";
								if ($shift == "Day") {
									if (TimeDiff("08:00:01", $row2['atttime']) > 0) {
										$fontcolor = "red";
										$total_late[$i]++;
									}
								}
								if ($shift == "Night") {
									if (TimeDiff("20:20:01", $row2['atttime']) > 0) {
										$fontcolor = "red";
										$total_late[$i]++;
									}
								}
								$html0 .= "<font color=$fontcolor>" . $row2['atttime'] . "</font>";
							}

							$html0 .= "</td></tr><tr>";
							$html0 .= "<td align='center'>";


							$select2 = "select convert(varchar, attdatetime, 108)as  atttime from  tbatt where empno='" . $row['empno'] . "' and cast(att_real_date as date)='" . $row0['workdate'] . "' and att_status='out' ";

							$re2 = mssql_query($select2);
							$num2 = mssql_num_rows($re2);
							if ($num2 > 0) {
								$row2 = mssql_fetch_array($re2);
								$html0 .= $row2['atttime'];
								//echo $row2['atttime'];
							}

							$html0 .= "</td></tr> <tr><td align='center' bgcolor='$bgcolor'>";
							//ffff66

							/* leave display */
							/*$sql_l = "select reasons,leaveid,leavetypeid from tbleave_transaction 
					where empno='".$row['empno']."' 
					and '".$row0['workdate']."' between leavestartdate and leaveenddate 
					and statusapprove !='Cancel'
					and statusapprove !='Reject'";
					$res_l = mssql_query($sql_l);
					$num_l = mssql_num_rows($res_l);*/
							if ($num_l > 0) {
								$row_l = mssql_fetch_array($res_l);
								$leavetypeid = $row_l['leavetypeid'];
								$leavename = get_leavename($leavetypeid);
								$leave_txt = "<span style='background-color:#ffff66'>$leavename</span>";
								$html0 .= $leave_txt;
							}

							$html0 .= "</td></tr></table></td>";
						}


						$html0 .= "</tr>";

						$i++;
					}
				}

				$html0 .= "</table></td></tr></table>";
				?>








			<table width="550" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td align="center" bgcolor="#CCCCCC">
						<table width="100%" border="0" cellspacing="1" cellpadding="0">
							<tr bgcolor="#cccccc">
								<td align="center" style="border-right:1px solid; border-bottom:1px solid"><strong>Emp No.</strong></td>
								<td height="25" align="center" style="border-right:1px solid; border-bottom:1px solid"><strong>Name</strong></td>
								<td align="center" style="border-left:1px solid;border-right:1px solid; border-bottom:1px solid"><strong>มาสาย</strong></td>
								<td align="center" style="border-left:1px solid;border-right:1px solid; border-bottom:1px solid"><strong>มาสาย(ต่อปี)</strong></td>
								<td align="center" style="border-left:1px solid;border-right:1px solid; border-bottom:1px solid"><strong>ไม่แสกนเข้า</strong></td>
								<td align="center" style="border-left:1px solid;border-right:1px solid; border-bottom:1px solid"><strong>ไม่แสกนออก</strong></td>
								<td align="center" style="border-left:1px solid;border-right:1px solid; border-bottom:1px solid"><strong>ลา หรือ อื่นๆ</strong></td>
							</tr>
							<?
								$select = "select * from  tbemployee where site='$tsite' and emp_level <= 4 and delstatus='0' order by empno asc ";
								$re = mssql_query($select);
								$num = mssql_num_rows($re);
								if ($num > 0) {
									$i = 0;
									while ($row = mssql_fetch_array($re)) {
										?>
									<tr bgcolor="#ffffff">
										<td style="border-left:1px solid;border-right:1px solid; border-bottom:1px solid"><?= $row['empno'] ?></td>
										<td height="25" style="border-left:1px solid;border-right:1px solid; border-bottom:1px solid"><? echo iconv("tis-620", "utf-8", $row['firstname']); ?></td>
										<td style="border-left:1px solid;border-right:1px solid; border-bottom:1px solid"><?

																																		echo $total_late[$i];
																																		?></td>
										<td align="center" style="border-right:1px solid; border-bottom:1px solid"><?

																																$select_latey = "select count(empno) as total_late from tbatt_approve where paycode in (SELECT paycode from tbpaycode WHERE paycodeyear='$txtyear') and ishift='Day' and cast(iattDateTime1 as time)>'08:00:00' and status_approve=1
			and empno='" . $row['empno'] . "'  and cast(iattDateTime1 as date) not in(select leavestartdate from tbleave_transaction where empno='" . $row['empno'] . "')
			";
																																$re_latey = mssql_query($select_latey);
																																$num_latey = mssql_num_rows($re_latey);
																																if ($num_latey > 0) {
																																	$row_latey = mssql_fetch_array($re_latey);
																																	$total_late_day =  $row_latey['total_late'];
																																}
																																$select_latey = "select count(empno) as total_late from tbatt_approve where paycode in (SELECT paycode from tbpaycode WHERE paycodeyear='$txtyear') and ishift='Night' and cast(iattDateTime1 as time)>'20:20:00' and status_approve=1
			and empno='" . $row['empno'] . "'  and cast(iattDateTime1 as date) not in(select leavestartdate from tbleave_transaction where empno='" . $row['empno'] . "')
			";
																																$re_latey = mssql_query($select_latey);
																																$num_latey = mssql_num_rows($re_latey);
																																if ($num_latey > 0) {
																																	$row_latey = mssql_fetch_array($re_latey);
																																	$total_late_night =  $row_latey['total_late'];
																																}
																																echo $total_late_day + $total_late_night;
																																?></td>
										<td align="center" style="border-right:1px solid; border-bottom:1px solid"><?
																																echo $total_noscan_in[$i];
																																?></td>
										<td align="center" style="border-right:1px solid; border-bottom:1px solid"><?
																																echo $total_noscan_out[$i];
																																?></td>
										<td align="center" style="border-right:1px solid; border-bottom:1px solid"><?
																																echo $total_leave[$i];
																																?></td>
									</tr>
							<?
										$i++;
									}
								}
								?>
						</table>
					</td>
				</tr>
			</table>

			<?

				echo $html0;

				?> </body>

		</html><?

				}
if($status=="export_ot"){
	$paycode = $_REQUEST['paycode'];
	$tsite = $_REQUEST['tsite'];
	$select = "SELECT paycode,convert(varchar, startdate, 101)as  startdate,
		convert(varchar, enddate, 101)as  enddate from  tbpaycode where paycode = '$paycode' ";
	$re = mssql_query($select);
	$num = mssql_num_rows($re);

	$row = mssql_fetch_array($re);
	$startdate = $row['startdate'];
	$enddate = $row['enddate'];

	header("Content-Type: application/vnd.ms-excel");
	header('Content-Disposition: attachment; filename="OT_report"' .$tsite. $date_time . '".xls"'); #ชื่อไฟล์

	
	
	
	?>
	<html >
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		</head>

		<body bgcolor="#FFFFFF" >
      <?
       
	  ?>
			<table class="table table-striped table-bordered" id="part_list" border='1' x:str>
				<thead>
					<th bgcolor="#cccccc">Name</th>
					<?
					if($tsite == 'TSC Sub'){
					$select0 = "SELECT *,
							convert(varchar, workdate, 101)as  workdate2,
							convert(varchar, workdate, 103)as  workdate3
							
					FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='TSC'  order by workdate asc ";
					}else{
					$select0 = "SELECT *,
							convert(varchar, workdate, 101)as  workdate2,
							convert(varchar, workdate, 103)as  workdate3
							
					FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";
					}
					$re0 = mssql_query($select0);
					$num0 = mssql_num_rows($re0);

					if ($num0 > 0) {
						while ($row0 = mssql_fetch_array($re0)) {
							?><th bgcolor="#cccccc"><?=date("d", strtotime($row0['workdate']))?></th><?
						}
					}
					?>
				</thead>
				<?php

				$select = "SELECT convert(varchar, startdate, 101)as  startdate2,* from  tbemployee 
				where site='$tsite' and emp_level < 4 
				and delstatus='0' 
				order by empno asc ";
				$re = mssql_query($select);
				$num = mssql_num_rows($re);
				if ($num > 0) {
					$i = 0;
					while ($row = mssql_fetch_array($re)) {
						$empno = $row['empno'];
						$firstname = iconv("tis-620", "utf-8", $row['firstname']);
						?>
						<tr>
							<th>Shift</th>
							<?php
								if($tsite == 'TSC Sub'){
								$select0 = "SELECT *,
									convert(varchar, workdate, 101)as  workdate2,
									convert(varchar, workdate, 103)as  workdate3
									
							FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='TSC'  order by workdate asc ";	
						}else{
								$select0 = "SELECT *,
								convert(varchar, workdate, 101)as  workdate2,
								convert(varchar, workdate, 103)as  workdate3
								
							FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";
							}
							$re0 = mssql_query($select0);
							$num0 = mssql_num_rows($re0);
						
							while ($row0 = mssql_fetch_array($re0)) {
								$workdate = $row0['workdate'];
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bgcolor = "#CCCCCC";
								} else {
									$bgcolor = "#FFFFFF";
								}
								
								$sql_att = "SELECT iShift FROM tbatt_approve WHERE iworkdate='$workdate' AND empno='$empno'";
								$res_att = mssql_query($sql_att);
								$row_att = mssql_fetch_array($res_att);
								$iShift = $row_att["iShift"];
								?>
								<td bgcolor="<?=$bgcolor?>" align='center'><?=$iShift?></td>
								<?
							}
							?>
						</tr>
						<tr>
							<td align='center'><?=$empno?><br><?=$firstname?></td>
							<?php
							if($tsite == 'TSC Sub'){
							$select0 = "SELECT *,
									convert(varchar, workdate, 101)as  workdate2,
									convert(varchar, workdate, 103)as  workdate3
									
							FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='TSC'  order by workdate asc ";
							}else{
							$select0 = "SELECT *,
									convert(varchar, workdate, 101)as  workdate2,
									convert(varchar, workdate, 103)as  workdate3
									
							FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";
							}
							$re0 = mssql_query($select0);
							$num0 = mssql_num_rows($re0);

							while ($row0 = mssql_fetch_array($re0)) {
								$workdate = $row0['workdate'];
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bgcolor = "#CCCCCC";
								} else {
									$bgcolor = "#FFFFFF";
								}
								$sql_att = "SELECT sum(irate1+irate1_5+irate2+irate3) as att_ot FROM tbatt_approve WHERE iworkdate='$workdate' AND empno='$empno'";
								$res_att = mssql_query($sql_att);
								$row_att = mssql_fetch_array($res_att);
								$att_ot = $row_att["att_ot"];
								?>
								<td bgcolor="<?=$bgcolor?>" align="right"><?=$att_ot?></td>
								<?
							}
							?>

						</tr>
						<?
					}
				}
				?>
			</table>
		</body>
	</html>
	
	<?
	
}
if($status=="export_ot_month_old"){
	$month = $_REQUEST['month'];
	$tsite = $_REQUEST['tsite2'];
	$month_explode_arr = explode("-", $month);
	$mmonth = $month_explode_arr[1];
	$yyear = $month_explode_arr[0];



	$number = cal_days_in_month(CAL_GREGORIAN, $mmonth, $yyear);
	$startdate = $month . "-01";
	$enddate = $month . "-" . $number;

	header("Content-Type: application/vnd.ms-excel");
	header('Content-Disposition: attachment; filename="OT_report"' .$tsite. $date_time . '".xls"'); #ชื่อไฟล์
	// header("Content-Type: application/vnd.ms-excel");
	// header('Content-Disposition: attachment; filename="VMI Quota '.$date_file.'.xls"');#ชื่อไฟล์
	
	// http://www.ipack-iwis.com/hrs/getajax_report_att.php?status=export_ot&paycode=PAYFEB20&tsite=OSW
	?>
	<html >
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		</head>

		<body bgcolor="#FFFFFF" >
			<table class="table table-striped table-bordered" id="part_list" border='1' x:str>
				<thead>
					<th bgcolor="#cccccc">Name</th>
					<?
					if($tsite == 'TSC Sub'){
					$select0 = "SELECT *,
							convert(varchar, workdate, 101)as  workdate2,
							convert(varchar, workdate, 103)as  workdate3
							
					FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='TSC'  order by workdate asc ";
					}else{
					$select0 = "SELECT *,
							convert(varchar, workdate, 101)as  workdate2,
							convert(varchar, workdate, 103)as  workdate3
							
					FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";
					}
					$re0 = mssql_query($select0);
					$num0 = mssql_num_rows($re0);
					if ($num0 > 0) {
						while ($row0 = mssql_fetch_array($re0)) {
							?><th bgcolor="#cccccc"><?=date("d", strtotime($row0['workdate']))?></th><?
						}
					}
					?>
				</thead>
				<?php
				$select = "SELECT convert(varchar, startdate, 101)as  startdate2,* from  tbemployee 
				where site='$tsite' and emp_level < 4 
				and delstatus='0' 
				order by empno asc ";
				$re = mssql_query($select);
				$num = mssql_num_rows($re);
				if ($num > 0) {
					$i = 0;
					while ($row = mssql_fetch_array($re)) {
						$empno = $row['empno'];
						$emp_level = $row['emp_level'];
						$firstname = iconv("tis-620", "utf-8", $row['firstname']);
						?>
						<tr>
							<th>Shift</th>
							<?php
							if($tsite == 'TSC Sub'){
							$select0 = "SELECT *,
									convert(varchar, workdate, 101)as  workdate2,
									convert(varchar, workdate, 103)as  workdate3
									
							FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='TSC'  order by workdate asc ";
							}else{
							$select0 = "SELECT *,
									convert(varchar, workdate, 101)as  workdate2,
									convert(varchar, workdate, 103)as  workdate3
									
							FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";
							}
							$re0 = mssql_query($select0);
							$num0 = mssql_num_rows($re0);

							while ($row0 = mssql_fetch_array($re0)) {
								$workdate = $row0['workdate'];
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bgcolor = "#CCCCCC";
								} else {
									$bgcolor = "#FFFFFF";
								}
								$sql_att = "SELECT iShift FROM tbatt_approve WHERE iworkdate='$workdate' AND empno='$empno'";
								$res_att = mssql_query($sql_att);
								$row_att = mssql_fetch_array($res_att);
								$iShift = $row_att["iShift"];

								?>
								<td bgcolor="<?=$bgcolor?>" align='center'><?=$iShift?></td>
								<?
							}
							?>
						</tr>
						<tr>
							<th>Job</th>
							<?php
								if($tsite == 'TSC Sub'){
							$select0 = "SELECT *,
									convert(varchar, workdate, 101)as  workdate2,
									convert(varchar, workdate, 103)as  workdate3
									
							FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='TSC'  order by workdate asc ";
								}else{
							$select0 = "SELECT *,
									convert(varchar, workdate, 101)as  workdate2,
									convert(varchar, workdate, 103)as  workdate3
									
							FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";
								}
							$re0 = mssql_query($select0);
							$num0 = mssql_num_rows($re0);

							while ($row0 = mssql_fetch_array($re0)) {
								$workdate = $row0['workdate'];
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bgcolor = "#CCCCCC";
								} else {
									$bgcolor = "#FFFFFF";
								}
								$sql_att = "SELECT job_type FROM tbot_request WHERE date_ot='$workdate' AND empno='$empno'";
								$res_att = mssql_query($sql_att);
								$row_att = mssql_fetch_array($res_att);
								$job_type = $row_att["job_type"];

								?>
								<td bgcolor="<?=$bgcolor?>" align='center'>
									<?php 
									if($emp_level == 3 && $bgcolor == "#FFFFFF"){
										// echo "0";
									}else{
										echo $job_type;
									}
									?>
								</td>
								<?
							}
							?>
						</tr>
						<tr>
							<td align='center'><?=$empno?><br><?=$firstname?></td>
							<?php
							if($tsite == 'TSC Sub'){
							$select0 = "SELECT *,
									convert(varchar, workdate, 101)as  workdate2,
									convert(varchar, workdate, 103)as  workdate3
									
							FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='TSC'  order by workdate asc ";
							}else{
							$select0 = "SELECT *,
									convert(varchar, workdate, 101)as  workdate2,
									convert(varchar, workdate, 103)as  workdate3
									
							FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";
							}
							$re0 = mssql_query($select0);
							$num0 = mssql_num_rows($re0);

							while ($row0 = mssql_fetch_array($re0)) {
								$workdate = $row0['workdate'];
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bgcolor = "#CCCCCC";
								} else {
									$bgcolor = "#FFFFFF";
								}
								$sql_att = "SELECT sum(irate1+irate1_5+irate2+irate3) as att_ot FROM tbatt_approve WHERE iworkdate='$workdate' AND empno='$empno'";
								$res_att = mssql_query($sql_att);
								$row_att = mssql_fetch_array($res_att);
								$att_ot = $row_att["att_ot"];

								?>
								<td bgcolor="<?=$bgcolor?>" align="right">
									<?php 
									if($emp_level == 3 && $bgcolor == "#FFFFFF"){
										echo "0";
									}else{
										echo $att_ot;
									}
									?>
								</td>
								<?
							}
							?>

						</tr>
						<?
					}
				}
				?>
			</table>
		</body>
	</html>
	
	<?
	
}
if($status=="export_ot_month"){
	$month = $_REQUEST['month'];
	$tsite = $_REQUEST['tsite2'];
	$month_explode_arr = explode("-", $month);
	$mmonth = $month_explode_arr[1];
	$yyear = $month_explode_arr[0];



	$number = cal_days_in_month(CAL_GREGORIAN, $mmonth, $yyear);
	$startdate = $month . "-01";
	$enddate = $month . "-" . $number;

	header("Content-Type: application/vnd.ms-excel");
	header('Content-Disposition: attachment; filename="OT_report"' .$tsite. $date_time . '".xls"'); #ชื่อไฟล์
	// header("Content-Type: application/vnd.ms-excel");
	// header('Content-Disposition: attachment; filename="VMI Quota '.$date_file.'.xls"');#ชื่อไฟล์
	
	// http://www.ipack-iwis.com/hrs/getajax_report_att.php?status=export_ot&paycode=PAYFEB20&tsite=OSW
	?>
	<html >
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		</head>

		<body bgcolor="#FFFFFF" >



		<?
        ///// TOTAL OT
	$total_ot_site = 0;
	$select = "SELECT convert(varchar, startdate, 101)as  startdate2,* from  tbemployee 
				where site='$tsite' and emp_level < 4 
				and delstatus='0' 
				order by empno asc ";
				$re = mssql_query($select);
				$num = mssql_num_rows($re);
				if ($num > 0) {
					while ($row = mssql_fetch_array($re)) {
						
						$select_jt = "select distinct job_type from tbot_request
	where empno='".$row['empno']."' and date_ot between '" . $startdate . "' and '" . $enddate . "' and status_ot='O' ";
							$re_jt = mssql_query($select_jt);
							$num_jt=mssql_num_rows($re_jt);
							if($num_jt>0){
							 while($row_jt = mssql_fetch_array($re_jt)){
								if($tsite == 'TSC Sub'){
								 $select0 = "SELECT *,
									convert(varchar, workdate, 101)as  workdate2,
									convert(varchar, workdate, 103)as  workdate3
									
							FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='TSC'  order by workdate asc ";
								}else{
								 $select0 = "SELECT *,
									convert(varchar, workdate, 101)as  workdate2,
									convert(varchar, workdate, 103)as  workdate3
									
							FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";
								}
							$re0 = mssql_query($select0);
							while ($row0 = mssql_fetch_array($re0)) {
									$sql_att = "SELECT sum(irate1+irate1_5+irate2+irate3) as att_ot FROM tbatt_approve WHERE iworkdate='".$row0['workdate']."' AND empno='".$row['empno']."' and iworkdate in(select date_ot from tbot_request where empno='".$row['empno']."' and job_type='".$row_jt['job_type']."' and status_ot='O')";
								$res_att = mssql_query($sql_att);
								$row_att = mssql_fetch_array($res_att);
								
								$total_ot_site = $total_ot_site+$row_att["att_ot"];
								}
								 }
								 }
						
						
							
						
					}
				}
	//echo $total_ot_site;
	///// TOTAL OT
	
	///// SEPARATE JOB OT
	?>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><strong><u>Summary OT <?=$month?></u></strong></td>
  </tr>
</table>

	<table border='1' x:str>
    <tr>
    <td>Job</td>
    <?
                            $select_jt = "select distinct job_type from tbot_request
where  date_ot between '" . $startdate . "' and '" . $enddate . "' and status_ot='O' and empno in(select empno from tbemployee 	where site='$tsite' and emp_level < 4 
				and delstatus='0'
				 )";
							$re_jt = mssql_query($select_jt);
							$num_jt=mssql_num_rows($re_jt);
							if($num_jt>0){
								 while($row_jt = mssql_fetch_array($re_jt)){
									 	?><td><?=lang_thai_from_database($row_jt['job_type'])?></td><?
									 }
								}
	?>
    
    <td>Total</td>
    </tr>
    <tr>
    <td>OT Hours</td>
    <?
                            $select_jt = "select distinct job_type from tbot_request
where  date_ot between '" . $startdate . "' and '" . $enddate . "' and status_ot='O' and empno in(select empno from tbemployee 	where site='$tsite' and emp_level < 4 
				and delstatus='0' and site='$tsite'
				 )";
							$re_jt = mssql_query($select_jt);
							$num_jt=mssql_num_rows($re_jt);
							if($num_jt>0){
								 while($row_jt = mssql_fetch_array($re_jt)){
									$total_ot_job = 0;
									$sql_att0 = "select date_ot,empno from tbot_request where  job_type='".$row_jt['job_type']."' and status_ot='O' and date_ot between '" . $startdate . "' and '" . $enddate . "' and empno in(select empno from tbemployee 	where site='$tsite' and emp_level < 4  and delstatus='0'
				 )";
				 			
									$re_att0 = mssql_query($sql_att0);
									$num_att0=mssql_num_rows($re_att0);
									if($num_att0>0){
										
									 while($row_att0 = mssql_fetch_array($re_att0)){
										 
				$sql_att = "SELECT sum(irate1+irate1_5+irate2+irate3) as att_ot FROM tbatt_approve WHERE   iworkdate ='".$row_att0['date_ot']."' and empno='".$row_att0['empno']."' ";
								$res_att = mssql_query($sql_att);
								$row_att = mssql_fetch_array($res_att);
								$total_ot_job = $total_ot_job+$row_att["att_ot"];
										}
									}
										?><td>
                                        <?
                                        echo $total_ot_job;
										?>
                                        </td><?
									 }
								}
	?>
    <td> <?
                                        echo $total_ot_site;
										?></td>
    </tr>
    <tr>
    <td>%</td>
     <?
                            $select_jt = "select distinct job_type from tbot_request
where  date_ot between '" . $startdate . "' and '" . $enddate . "' and status_ot='O' and empno in(select empno from tbemployee 	where site='$tsite' and emp_level < 4 
				and delstatus='0' and site='$tsite'
				 )";
							$re_jt = mssql_query($select_jt);
							$num_jt=mssql_num_rows($re_jt);
							if($num_jt>0){
								 while($row_jt = mssql_fetch_array($re_jt)){
									$total_ot_job = 0;
									$sql_att0 = "select date_ot,empno from tbot_request where  job_type='".$row_jt['job_type']."' and status_ot='O' and date_ot between '" . $startdate . "' and '" . $enddate . "' and empno in(select empno from tbemployee 	where site='$tsite' and emp_level < 4  and delstatus='0'
				 )";
				 			
									$re_att0 = mssql_query($sql_att0);
									$num_att0=mssql_num_rows($re_att0);
									if($num_att0>0){
										
									 while($row_att0 = mssql_fetch_array($re_att0)){
										 
				$sql_att = "SELECT sum(irate1+irate1_5+irate2+irate3) as att_ot FROM tbatt_approve WHERE   iworkdate ='".$row_att0['date_ot']."' and empno='".$row_att0['empno']."' ";
								$res_att = mssql_query($sql_att);
								$row_att = mssql_fetch_array($res_att);
								$total_ot_job = $total_ot_job+$row_att["att_ot"];
									 
										}
									}
										?><td>
                                        <?
										@$total_ot_site_percent = $total_ot_site_percent+round(($total_ot_job/$total_ot_site)*100);
                                        echo @round(($total_ot_job/$total_ot_site)*100);
										echo "%";
										?>
                                        </td><?
									 }
								}
	?>
    <td><?=@$total_ot_site_percent?>%</td>
    </tr>
    </table>
	<?
	///// SEPARATE JOB OT
		?>



      
			<table border='1' x:str>
				<thead>
					<th bgcolor="#cccccc">Name</th>
                    <th bgcolor="#cccccc">&nbsp;</th>
					<?
						if($tsite == 'TSC Sub'){
						$select0 = "SELECT *,
							convert(varchar, workdate, 101)as  workdate2,
							convert(varchar, workdate, 103)as  workdate3
							
					FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='TSC'  order by workdate asc ";
						}else{
							
							$select0 = "SELECT *,
							convert(varchar, workdate, 101)as  workdate2,
							convert(varchar, workdate, 103)as  workdate3
							
					FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";
						}
					$re0 = mssql_query($select0);
					$num0 = mssql_num_rows($re0);
					if ($num0 > 0) {
						while ($row0 = mssql_fetch_array($re0)) {
							?><th bgcolor="#cccccc"><?=date("d", strtotime($row0['workdate']))?></th><?
						}
					}
					?>
                     <th bgcolor="#FFCC00">Total</th>
				</thead>
				<?php
				$select = "SELECT convert(varchar, startdate, 101)as  startdate2,* from  tbemployee 
				where site='$tsite' and emp_level < 4 
				and delstatus='0' 
				order by empno asc ";
	
				$re = mssql_query($select);
				$num = mssql_num_rows($re);
				if ($num > 0) {
					$i = 0;
					while ($row = mssql_fetch_array($re)) {
						$empno = $row['empno'];
						$emp_level = $row['emp_level'];
						$firstname = iconv("tis-620", "utf-8", $row['firstname']);

						?>
						<tr>
							<th>Emp ID./Name</th>
                            <th>Job OT/Shift</th>
                           
							<?php
							if($tsite == 'TSC Sub'){
							$select0 = "SELECT *,
									convert(varchar, workdate, 101)as  workdate2,
									convert(varchar, workdate, 103)as  workdate3
									
							FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='TSC'  order by workdate asc ";
							}else{
							$select0 = "SELECT *,
									convert(varchar, workdate, 101)as  workdate2,
									convert(varchar, workdate, 103)as  workdate3
									
							FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";
							}
							$re0 = mssql_query($select0);
							$num0 = mssql_num_rows($re0);

							while ($row0 = mssql_fetch_array($re0)) {
								$workdate = $row0['workdate'];
								
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bgcolor = "#CCCCCC";
								} else {
									$bgcolor = "#FFFFFF";
								}
								$sql_att = "SELECT iShift FROM tbatt_approve WHERE iworkdate='$workdate' AND empno='$empno'";
								$res_att = mssql_query($sql_att);
								$row_att = mssql_fetch_array($res_att);
								$iShift = $row_att["iShift"];

								?>
								<td bgcolor="<?=$bgcolor?>" align='center'><?=$iShift?></td>
								<?
							}
							?>
                            <th>&nbsp;</th>
						</tr>
                        
                        
                        <?
                        	$select_jt = "select distinct job_type from tbot_request
where empno='$empno' and date_ot between '" . $startdate . "' and '" . $enddate . "' and status_ot='O' ";
							$re_jt = mssql_query($select_jt);
							$num_jt=mssql_num_rows($re_jt);
							if($num_jt>0){
							 while($row_jt = mssql_fetch_array($re_jt)){
									?>
									<tr>
                           <td align='center'><?
                           if($old_empno == $empno){
							   }else{
							   ?><?=$empno?> <?=$firstname?><?
							   $old_empno = $empno;
							   }
						   ?></td>
							<td><?=lang_thai_from_database($row_jt['job_type'])?></td>
							<?php
							$total_ot_job_emp = 0;
							if($tsite == 'TSC Sub'){
							$select0 = "SELECT *,
									convert(varchar, workdate, 101)as  workdate2,
									convert(varchar, workdate, 103)as  workdate3
									
							FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='TSC'  order by workdate asc ";
							}else{
							$select0 = "SELECT *,
									convert(varchar, workdate, 101)as  workdate2,
									convert(varchar, workdate, 103)as  workdate3
									
							FROM    tbot_parameter where workdate between '" . $startdate . "' and '" . $enddate . "' and site='$tsite'  order by workdate asc ";
							}
							$re0 = mssql_query($select0);
							$num0 = mssql_num_rows($re0);

							while ($row0 = mssql_fetch_array($re0)) {
								$workdate = $row0['workdate'];
								if ($row0['work_type'] == 'H Sat , Sun' || $row0['work_type'] == 'H') {
									$bgcolor = "#CCCCCC";
								} else {
									$bgcolor = "#FFFFFF";
								}
								$att_ot = 0;
								$sql_att = "SELECT sum(irate1+irate1_5+irate2+irate3) as att_ot FROM tbatt_approve WHERE iworkdate='$workdate' AND empno='$empno' and iworkdate in(select date_ot from tbot_request where empno='$empno' and job_type='".$row_jt['job_type']."' and status_ot='O')";
								$res_att = mssql_query($sql_att);
								$row_att = mssql_fetch_array($res_att);
								$att_ot = $row_att["att_ot"];
								$total_ot_job_emp = $total_ot_job_emp+$row_att["att_ot"];
								
								?>
								<td bgcolor="<?=$bgcolor?>" align="right">
									<?php 
									if($emp_level == 3 && $bgcolor == "#FFFFFF"){
										echo "0";
									}else{
										echo $att_ot;
									}
									?>
								</td>
								<?
							}
							?>
                            <td><?=$total_ot_job_emp?></td>
						</tr>
									<?
								}
							}
						?>
						
                        
                        
						
						<?
					}
				}
				?>
			</table>
		</body>
	</html>
	
	<?
	
}
	?>