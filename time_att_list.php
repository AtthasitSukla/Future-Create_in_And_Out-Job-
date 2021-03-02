<?
include("connect.php");
include("library.php");
//error_reporting(0);
?>
<?

//echo cal_days_in_month(CAL_GREGORIAN, 11, 2009); 
$status = $_REQUEST['status'];
$paycode = $_REQUEST['paycode'];
$empno = $_REQUEST['empno'];
$tsite = $_REQUEST['tsite'];
$social_in_calc  = $_REQUEST['social_in_calc'];
if($social_in_calc==''){
	$social_in_calc = 0.05;
	}


//$empno='59014';

if ($empno != '') {

	$select = "SELECT *,convert(varchar, startdate, 101)as  startdate2 from  tbemployee where empno = '$empno' ";
	$re = mssql_query($select);

	$row = mssql_fetch_array($re);
	$tsite = $row['site'];
	$skill_reward = $row['skill_reward'];
	//$empname = $row['firstname']." ".$row['lastname'];
	$empname = iconv("tis-620", "utf-8", $row['firstname'] . " " . $row['lastname']);
	if ($skill_reward == '') {
		$skill_reward = 0;
	}
	$att_reward = $row['att_reward'];
	if ($att_reward == '') {
		$att_reward = 0;
	}
	$basic_wage =  $row['basic_wage'];
	$basic_salary =  $row['basic_salary'];


	$startdate2 = $row['startdate2'];      //รูปแบบการเก็บค่าข้อมูลวันเกิด
	$today = date("m/d/Y");   //จุดต้องเปลี่ยน
	list($bmonth, $bday, $byear) = explode("/", $startdate2);       //จุดต้องเปลี่ยน
	list($tmonth, $tday, $tyear) = explode("/", $today);                //จุดต้องเปลี่ยน
	$mbirthday = mktime(0, 0, 0, $bmonth, $bday, $byear);
	$mnow = mktime(0, 0, 0, $tmonth, $tday, $tyear);
	$mage = ($mnow - $mbirthday);
	$u_y = date("Y", $mage) - 1970;
	$u_m = date("m", $mage) - 1;
	$u_d = date("d", $mage) - 1;
	//อายุงานครบ1ปีได้300บาท , 3 ปี 400 , 5 ปี 500 
	$skill_reward = $row['skill_reward'];

	if ($u_y >= 1) {
		$skill_reward = 300;
		if ($u_y >= 3) {
			$skill_reward = 400;
			if ($u_y >= 5) {
				$skill_reward = 500;
			}
		}
	} else {
		$skill_reward = 0;
	}
	// update skill reward
	$update_skill = "update tbemployee set skill_reward=$skill_reward where empno='$empno' ";
	mssql_query($update_skill);

 //echo $skill_reward;

	$car_rice = 75;
	$emptype  =  $row['emptype'];
	if ($emptype == 'employee') {
		$ot_rate_emp = ($basic_salary / 30) / 8;
		$leave_rate_emp = $basic_salary / 30;
		$salary_per_day = $basic_salary / 30;
		//echo "($basic_salary/30)/8=";
		//	echo $ot_rate_emp;
	} else {
		$ot_rate_emp = ($basic_wage) / 8;
		$leave_rate_emp = $basic_wage;
		$salary_per_day = $basic_wage ;
		//	echo "$basic_wage/8=";
		//	echo $ot_rate_emp;
	}


	if ($tsite == 'TSC') {
		$start_ot = "17:20:00";
		$start_ot_night = "05:40:00";
	} else {
		$start_ot = "17:30:00";
		$start_ot_night = "05:40:00";
	}
}

if ($paycode != '') {

	$select = "select paycodeyear,paycode,convert(varchar, startdate, 101)as  startdate,
	convert(varchar, enddate, 101)as  enddate from  tbpaycode where paycode = '$paycode' ";
	$re = mssql_query($select);
	$num = mssql_num_rows($re);

	$row = mssql_fetch_array($re);
	$startdate = $row['startdate'];
	$enddate = $row['enddate'];
	$paycodeyear = $row['paycodeyear'];
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<title>I-Wis HRS : Calculate Salary</title>
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

	<link rel='stylesheet' type='text/css' href='assets/plugins/codeprettifier/prettify.css' />
	<link rel='stylesheet' type='text/css' href='assets/plugins/form-multiselect/css/multi-select.css' />
	<link rel='stylesheet' type='text/css' href='assets/plugins/form-toggle/toggles.css' />
	<script type="text/javascript" src="assets/js/jquery-1.10.2.min.js"></script>
	<!--<script type="text/javascript" src="assets/js/less.js"></script>-->

	<script>
		$(function() {


		});





		function showpaycode() {
			var social_in_calc = $("#social_in_calc").val();
			var paycode = $("#paycode").val();
			var site = $("#site").val();
			var empno = $("#empno").val();
			window.location = 'time_att_list.php?paycode=' + paycode + '&empno=' + empno + '&tsite=' + site+ '&social_in_calc=' + social_in_calc;
		}

		function updateshift(id) {
			var shift_time = $("#shift_time" + id).val();
			$.post("getajax_att.php", {
					status: "updateshift",
					shift_time: shift_time,
					id: id,
					sid: Math.random()
				})
				.done(function(data) {
					//alert(data);

				});
		}

		function upadtehbd(empno, paycode) {
			var hbd = $("#hbd").val();
			var other = $("#other").val();
			var leave_without_pay = $("#leave_without_pay").val();
			var personal_leave = $("#personal_leave").val();
			var absent = $("#absent").val();
			var bonus = $("#bonus").val();

			var other_deduct = $("#other_deduct").val();
			var no_attendance = $("#no_attendance").val();

			$.post("getajax_att.php", {
					status: "upadtehbd",
					hbd: hbd,
					other: other,
					bonus: bonus,
					leave_without_pay: leave_without_pay,
					personal_leave: personal_leave,
					absent: absent,
					other_deduct: other_deduct,
					empno: empno,
					paycode: paycode,
					no_attendance: no_attendance,
					sid: Math.random()
				})
				.done(function(data) {
					alert(data);
					window.location = 'time_att_list.php?paycode=<?= $paycode ?>&empno=<?= $empno ?>&tsite=<?= $tsite ?>';

				});
		}

		function updateDate(id) {
			var attDateTime = $("#attDateTime" + id).val();
			var attDateTime2 = $("#attDateTime2" + id).val();
			var attDateTime3 = $("#attDateTime3" + id).val();
			$.post("getajax_att.php", {
					status: "updateDate",
					attDateTime: attDateTime,
					attDateTime2: attDateTime2,
					attDateTime3: attDateTime3,
					id: id,
					sid: Math.random()
				})
				.done(function(data) {
					alert('save complete.');

				});
		}

		function createleave(id, empno, leavedate) {

			var leavetypeid = $("#leavetypeid" + id).val();
			if (leavetypeid == '') {
				alert('Please Select Leave');
				return false;
			} else {

				$.post("getajax_att.php", {
						status: "createleave",
						leavedate: leavedate,
						leavetypeid: leavetypeid,
						empno: empno,
						id: id,
						sid: Math.random()
					})
					.done(function(data) {
						alert('save complete.');

					});


			}

		}



		function printslip(empno, paycode, paycodeyear) {
			window.open('popslip.php?empno=' + empno + '&paycode=' + paycode + '&paycodeyear=' + paycodeyear + '', 'popup', 'width=800,height=400,scrollbars=yes');
		}

		function showemponsite() {
			var site = $("#site").val();
			var paycode = $("#paycode").val();
			$.post("getajax_att.php", {
					status: "showemponsite",
					tsite: site,
					paycode: paycode,
					sid: Math.random()
				})
				.done(function(data) {

					//	alert(data);

					var aa = data;
					var bb = aa.split("###", 150);



					var select, i, option;

					select = document.getElementById('empno');
					select.options.length = 0;
					for (i = 0; i < bb.length - 1; i++) {

						cc = bb[i].split("@@@", 150);

						option = document.createElement('option');
						option.value = cc[0];
						option.text = cc[1];
						select.add(option);
					}

				});
		}

		function modal_personal_leave(paycode, empno) {
			//$("#personal_leave_head").html(paycode);
			$.post("getajax_att.php", {
					status: "modal_personal_leave",
					paycode: paycode,
					empno: empno
				})
				.done(function(data) {
					$("#personal_leave_body").html(data);
					$("#modal_personal_leave").modal();
				});
		}

		function close_job_no_att(id) {
			$.post("getajax_att.php", {
					status: "close_job_no_att",
					id: id

				})
				.done(function(data) {
					alert('Save Complete');
					window.location.reload();
				});
		}
	</script>
</head>

<body class=" ">
	<!-- Modal -->
	<div class="modal fade" id="modal_personal_leave" role="dialog">
		<div class="modal-dialog">

			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title" id="personal_leave_head">ลากิจทั้งปี</h4>
				</div>
				<div class="modal-body" id="personal_leave_body">
					<p>Some text in the modal.</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
				</div>
			</div>

		</div>
	</div>

	<div id="headerbar">
		<div class="container">
			<div class="row">
				<div class="col-xs-6 col-sm-2">
					<a href="#" class="shortcut-tiles tiles-brown">
						<div class="tiles-body">
							<div class="pull-left"><i class="fa fa-pencil"></i></div>
						</div>
						<div class="tiles-footer">
							Create Post
						</div>
					</a>
				</div>
				<div class="col-xs-6 col-sm-2">
					<a href="#" class="shortcut-tiles tiles-grape">
						<div class="tiles-body">
							<div class="pull-left"><i class="fa fa-group"></i></div>
							<div class="pull-right"><span class="badge">2</span></div>
						</div>
						<div class="tiles-footer">
							Contacts
						</div>
					</a>
				</div>
				<div class="col-xs-6 col-sm-2">
					<a href="#" class="shortcut-tiles tiles-primary">
						<div class="tiles-body">
							<div class="pull-left"><i class="fa fa-envelope-o"></i></div>
							<div class="pull-right"><span class="badge">10</span></div>
						</div>
						<div class="tiles-footer">
							Messages
						</div>
					</a>
				</div>
				<div class="col-xs-6 col-sm-2">
					<a href="#" class="shortcut-tiles tiles-inverse">
						<div class="tiles-body">
							<div class="pull-left"><i class="fa fa-camera"></i></div>
							<div class="pull-right"><span class="badge">3</span></div>
						</div>
						<div class="tiles-footer">
							Gallery
						</div>
					</a>
				</div>

				<div class="col-xs-6 col-sm-2">
					<a href="#" class="shortcut-tiles tiles-midnightblue">
						<div class="tiles-body">
							<div class="pull-left"><i class="fa fa-cog"></i></div>
						</div>
						<div class="tiles-footer">
							Settings
						</div>
					</a>
				</div>
				<div class="col-xs-6 col-sm-2">
					<a href="#" class="shortcut-tiles tiles-orange">
						<div class="tiles-body">
							<div class="pull-left"><i class="fa fa-wrench"></i></div>
						</div>
						<div class="tiles-footer">
							Plugins
						</div>
					</a>
				</div>

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
				<div id="page-heading">




				</div>
				<div class="container">



					<div class="row">
						<div class="col-md-12">
							<div class="panel panel-primary">

								<div class="panel-body">




									<?
if($status == '') {

										?>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="16%" align="right"><strong>หักประกันสังคม</strong></td>
<td width="81%">&nbsp;<select id="social_in_calc" class="form-control" name="social_in_calc" style="width:200px;">
														<option value="">Select</option>
														<?
															$select0 = "SELECT * from  tbsocial_in order by id asc ";
															$re0 = mssql_query($select0);
															while ($row0 = mssql_fetch_array($re0)) {
																?>
															<option value="<?= $row0['social_in_calc'] ?>" <? if ($social_in_calc == $row0['social_in_calc']) { ?> selected <?
																																								}
																																								?>><?= $row0['social_in_text'] ?></option>
														<?
															}
															?>
													</select></td>
    <td width="3%">&nbsp;</td>
  </tr>
</table>
<HR>
                                        
										<table align="center" width="100%" border="0" cellspacing="2" cellpadding="0">
											<tr>
												<td width="6%" height="40" align="right"><strong>PayCode</strong></td>
												<td width="19%"><select id="paycode" class="form-control" name="paycode" style="width:200px;">
														<option value="">Select</option>
														<?
															$select0 = "SELECT paycode from tbpaycode order by startdate asc ";
															$re0 = mssql_query($select0);
															while ($row0 = mssql_fetch_array($re0)) {
																?>
															<option value="<?= $row0['paycode'] ?>" <? if ($paycode == $row0['paycode']) { ?> selected <?
																																								}
																																								?>><?= $row0['paycode'] ?></option>
														<?
															}
															?>
													</select></td>
												<td width="3%" height="40" align="right"><strong>Site</strong></td>
												<td width="19%"><select id="site" class="form-control" name="site" style="width:200px;" onChange="showemponsite();">
														<option value="">Select</option>
														<?
															$select0 = "SELECT site from  tbsite ";
															$re0 = mssql_query($select0);
															while ($row0 = mssql_fetch_array($re0)) {
																?>
															<option value="<?= $row0['site'] ?>" <? if ($tsite == $row0['site']) { ?> selected <?
																																						}
																																						?>><?= $row0['site'] ?></option>
														<?
															}
															?>
													</select></td>
												<td width="7%" height="40" align="right"><strong>Employee Number</strong></td>
												<td width="27%"><select id="empno" class="form-control" name="empno" style="width:280px;">
														<option value="">Select</option>
														<?

															if ($tsite != '') {
																$select0 = "SELECT empno,firstname,lastname from tbemployee where site='" . $tsite . "' and emp_level in('1','2') and delstatus='0' order by empno asc ";
																$re0 = mssql_query($select0);
																while ($row0 = mssql_fetch_array($re0)) {
																	?>
																<option value="<?= $row0['empno'] ?>" <? if ($empno == $row0['empno']) { ?> selected <?
																																									}
																																									?>><?= $site ?> <?= $row0['empno'] ?> <?= iconv("tis-620", "utf-8", $row0['firstname']); ?> <?= iconv("tis-620", "utf-8", $row0['lastname']); ?>
																	<?
																				if ($paycode != '') {
																					$selects = "SELECT total_salary from tbsalary where empno='" . $row0['empno'] . "' and paycode='$paycode'";
																					$res = mssql_query($selects);
																					$rows = mssql_fetch_array($res);
																					//echo "(" . $rows['total_salary'] . ")";
																					echo "(" . number_format($rows['total_salary'], 2, '.', '') . ")";
																				}



																				?>
																</option>
														<?

																}
															}
															?>

													</select></td>
												<td width="8%"><input type="button" value="Select & update" onClick="showpaycode();"></td>
												<td width="11%" align="right">
													<!--<input type="button" value="Update" onClick="window.location.reload();" >-->

													<a href="javascript:void(0);" onclick="printslip('<?= $empno ?>','<?= $paycode ?>','<?= $paycodeyear ?>');" class="btn-primary btn" style="background-color:#16a085;"><i class="fa fa-print"></i> Print Slip</a>
												</td>
											</tr>
										</table>

										<table align="center" width="100%" border="0" cellspacing="2" cellpadding="0" class="table table-striped table-bordered datatables" id="example">
											<tr>
												<td width="96" align="center" bgcolor="#CCCCCC"><strong>Date</strong></td>
												<td width="98" align="center" bgcolor="#CCCCCC"><strong>Day Name</strong></td>
												<td width="60" align="center" bgcolor="#CCCCCC"><strong>Shift</strong></td>
												<td width="129" align="center" bgcolor="#CCCCCC"><strong>เวลา เข้างาน</strong></td>
												<td width="116" align="center" bgcolor="#CCCCCC"><strong>เวลา ออกงาน</strong></td>
												<td width="57" align="center" bgcolor="#CCCCCC"><strong>OT </strong></td>
												<td width="53" align="center" bgcolor="#CCCCCC"><strong>Rate</strong></td>
												<td width="84" align="center" bgcolor="#CCCCCC"><strong>เงินค่า OT</strong></td>
												<td width="67" align="center" bgcolor="#CCCCCC"><strong>ข้าว+รถ</strong></td>
												<td width="54" align="center" bgcolor="#CCCCCC"><strong>FL</strong></td>
												<td width="56" align="center" bgcolor="#CCCCCC"><strong>ค่ากะ</strong></td>
												<td width="156" align="center" bgcolor="#CCCCCC"><strong>รวม</strong></td>

											</tr>


											<?



if ($empno != '') {
													/////////////////////////////////////////////////////////////////////////////////////////////
													$extra_salary =0;
													$select_check = "SELECT salary_rate
												FROM    tbatt_approve where empno='$empno' and paycode='$paycode' and salary_rate < 100  ";
													$re_check = mssql_query($select_check);
													$num_check = mssql_num_rows($re_check);
													if($num_check>0){
														$extra_salary = 1;	
													}else{
														$extra_salary = 0;	
													}
													
													
													
													
													$select0 = "SELECT *,convert(varchar, iattDateTime1, 101)as  iattDate1,convert(varchar, iattDateTime1, 108)as  iattTime1,convert(varchar, iattDateTime2, 101)as  iattDate2,convert(varchar, iattDateTime2, 108)as  iattTime2 ,convert(varchar, iotin, 108)as  iotintime,
														convert(varchar, iotout, 108)as  iotouttime 
												FROM    tbatt_approve where empno='$empno' and paycode='$paycode'  order by iworkdate asc ";
													$re0 = mssql_query($select0);
													$total_day = 0;
													$total_normal_day = 0;
													$total_ot1 = 0;
													$total_ot1_5 = 0;
													$total_ot2 = 0;
													$total_ot3 = 0;
													$total_no_attendance = 0;
													$total_ot = 0;
													$total_car_rice = 0;
													$total_fl = 0;
													$total_shift_val = 0;
													$total_total = 0;
													$leaveday = 0;
													$shift = "";
													$ot_time = '';
													$rate = '';
													$total_day_extra = 0;
													$total_extra0 = 0;
													$total_extra50 = 0;
													$total_extra75 = 0;
													$total_extra90 = 0;
													$total_satsun_100 = 0;
													$total_personal_leave = 0;
													$total_bypass_personal_leave = 0;
													$total_absent = 0;
													$total_sick_day = 0;
													$total_personal_day = 0;
													$total_anual_day = 0;
													$total_absent_day = 0;
													$total_day_day = 0;
													$total_day_night = 0;
													$total_late = 0;
													$total_working_day  = 0;
													$total_working_day_standard  = 0;
													$total_leave_without_pay = 0;
													$total_leave_without_pay_day = 0;
													while ($row0 = mssql_fetch_array($re0)) {
														////CHECK SALARY RATE
														if($row0['salary_rate']==100){
															
															
														$ot_time1 = 0;
														$ot_time1_5 = 0;
														$ot_time2 = 0;
														$ot_time3 = 0;
														$rate1 = 0;
														$rate1_5 = 0;
														$rate2 = 0;
														$rate3 = 0;

														if ($row0['irate1'] > 0) {
															$ot_time1 = $row0['irate1'];
															$rate1 = 1;
														}
														if ($row0['irate1_5'] > 0) {
															$ot_time1_5 = $row0['irate1_5'];
															$rate1_5 = 1.5;
														}
														if ($row0['irate2'] > 0) {
															$ot_time2 = $row0['irate2'];
															$rate2 = 2;
														}
														if ($row0['irate3'] > 0) {
															$ot_time3 = $row0['irate3'];
															$rate3 = 3;
														}
			
														//check leave date
														//$select_le = "select * from  tbleave_transaction where CAST(leavestartdate AS DATE)='".$row0['iworkdate']."' and empno='$empno'  ";
														$select_le = "select * from  tbleave_transaction where '" . $row0['iworkdate'] . "' between CAST(leavestartdate AS DATE) and CAST(leaveenddate AS DATE) and empno='$empno' and statusapprove='Approve' ";

														$re_le = mssql_query($select_le);
														$num_le = mssql_num_rows($re_le);
														if ($num_le > 0) {
															$row_le = mssql_fetch_array($re_le);
															$leavetypeid = $row_le['leavetypeid'];
															$leaveid = $row_le['leaveid'];
															$reasons = lang_thai_from_database($row_le["reasons"]);
															//	$leavetotalday = $row_le['leavetotal'];
															if ($row_le['leavetotal'] < 1) {
																$leavetotalday = $row_le['leavetotal'];
															} else {
																$leavetotalday = 1;
															}


															$select_ln = "select leavename from tbleavetype where   leavetypeid='$leavetypeid'  ";

															$re_ln = mssql_query($select_ln);
															$row_ln = mssql_fetch_array($re_ln);
															$leavename = iconv("tis-620", "utf-8", $row_ln['leavename']);
														} else {
															$leavetypeid = "";
															$leavename = "";
															$leavetotalday = 0;
														}
														//check leave date



														$select1 = "select work_type from  tbot_parameter where CAST(workdate AS DATE)='" . $row0['iworkdate'] . "' and site='$tsite'  ";
														$re1 = mssql_query($select1);
														$num1 = mssql_num_rows($re1);
														if ($num1 > 0) {
															$row1 = mssql_fetch_array($re1);
															$work_type = $row1['work_type'];
														}

														?>
													<tr>
														<td width="96" align="center"><?
                                                        
														
														?><?= $row0['iworkdate'] ?></td>
														<td width="98" height="40" align="center"><?= $row0['idayname_en'] ?></td>
														<td width="60" align="center"><?= $row0['iShift'] ?></td>
														<td width="129" align="center">
															<?
																		if ($leavetypeid != '') {

																			echo "ข้อความจากระบบลา :" . $leavename;
																			echo "<BR>เหตผล :" . $reasons;
																			echo "<HR>";
																		}
																		if ($row0['iworkhours'] > 0) {
																			echo $row0['iattDate1'] ?> <?= $row0['iattTime1'];

																											if ($leavetypeid == 'L0010') {
																												//$total_late = $total_late + 1;
																											} else {

																												if ($row0['iShift'] == 'Day' && $work_type == 'Normal working') {
																													$check_late = $row0['iattDate1'] . " " . $row0['iattTime1'];
																													$check_late2 = $row0['iattDate1'] . " 08:01";
																													//echo ">>".DateTimeDiff($check_late,$check_late2);
																													if (DateTimeDiff($check_late, $check_late2) < 0) {
																														if ($leavetypeid != 'L0007' && $leavetypeid == 'L0010') {
																															$total_late = $total_late + 1;
																														}
																													}
																												}
																											}

																											if ($row0['iShift'] == 'Night' && $work_type == 'Normal working') {
																												$check_late = $row0['iattDate1'] . " " . $row0['iattTime1'];
																												$check_late2 = $row0['iattDate1'] . " 20:21";
																												//echo ">>".DateTimeDiff($check_late,$check_late2);
																												if (DateTimeDiff($check_late, $check_late2) < 0) {
																													$total_late = $total_late + 1;
																												}
																											}
																										}


																										/// check no attendance data
			if ($work_type == 'Normal working') {
			$sql_emp = "SELECT * FROM tbemployee WHERE empno='$empno'";
			$res_emp = mssql_query($sql_emp);
			$row_emp = mssql_fetch_array($res_emp);
			$startdatex = $row_emp["startdate"];
			$resigndate = $row_emp["resigndate"];
		if(((strtotime($row0['iworkdate']) > strtotime($resigndate)) && $resigndate!='') || strtotime($row0['iworkdate']) < strtotime($startdatex)){
	// echo "X";
	}else{
	// echo "O";
																												$select_no = "SELECT top 1 att_real_date from  tbatt 	where empno='$empno' and att_real_date='" . $row0['iworkdate'] . "'";
				$re_no = mssql_query($select_no);
				$num_no = mssql_num_rows($re_no);
						if ($num_no <= 0) {
																													
	$select_no2 = "SELECT leavestartdate from tbleave_transaction where  empno='$empno' and '" . $row0['iworkdate'] . "' between leavestartdate and leaveenddate 	and statusapprove='Approve'";
																													$re_no2 = mssql_query($select_no2);
																													$num_no2 = mssql_num_rows($re_no2);
		if ($num_no2 <= 0) {
																														echo "<font color='red'>no attendance data</font>";
																														$update = "update  tbatt_approve set status_noatt_deduct='New' where id=" . $row0['id'] . "";
																														mssql_query($update);
																														$total_no_attendance++;
     }else {
																														if ($row0['status_noatt_deduct'] == 'New') {
																															$update = "update  tbatt_approve set status_noatt_deduct=NULL where id=" . $row0['id'] . "";
																															mssql_query($update);
																														}
																													}
																												}
																											}
																										}
																										/// check no attendance data													


																										?></td>
														<td width="116" align="center">
															<?
																		if ($row0['iworkhours'] > 0) {
																			echo $row0['iattDate2'] ?> <?= $row0['iattTime2'];
																										} ?></td>
														<td width="57" align="center"></td>
														<td width="53" align="center">
															<?

																		echo "rate1=";
																		echo $ot_time1;
																		echo "<BR>rate1_5=";
																		echo $ot_time1_5;
																		echo "<BR>rate2=";
																		echo $ot_time2;
																		echo "<BR>rate3=";
																		echo $ot_time3;

																		?>
														</td>
														<td width="84" align="center">
															<?
																		$ot_val = 0;
																		$ot_val1 = 0;
																		$ot_val1_5 = 0;
																		$ot_val2 = 0;
																		$ot_val3 = 0;
																		if ($ot_time1 != 0) {
																			$ot_val1 = ($ot_time1 * $ot_rate_emp);
																			$ot_val1 = $ot_val1 * $rate1;
																		}
																		if ($ot_time1_5 != 0) {
																			$ot_val1_5 = ($ot_time1_5 * $ot_rate_emp);
																			$ot_val1_5 = $ot_val1_5 * $rate1_5;
																		}
																		if ($ot_time2 != 0) {
																			$ot_val2 = ($ot_time2 * $ot_rate_emp);
																			$ot_val2 = $ot_val2 * $rate2;
																		}
																		if ($ot_time3 != 0) {
																			$ot_val3 = ($ot_time3 * $ot_rate_emp);
																			$ot_val3 = $ot_val3 * $rate3;
																		}
																		$ot_val =  $ot_val1 + $ot_val1_5 + $ot_val2 + $ot_val3;
																		$ot_val = number_format($ot_val, 2, '.', '');
																		echo $ot_val;
																		?>
														</td>
														<td width="67" align="center">
															<?

																		if ($row0['iworkhours'] > 0) {

																			echo $car_rice;
																		}
																		?>
														</td>
														<td width="54" align="center">
															<?
																		if ($row0['ifl'] == 'yes') {
																			$fl = 50;
																		} else {
																			$fl = 0;
																		}
																		echo $fl;
																		?>
														</td>
														<td width="56" align="center">
															<?
																		if ($row0['iShift'] == 'Night') {
																			$shift_val = 120;
																		} else {
																			$shift_val = 0;
																		}
																		echo $shift_val;
																		?>
														</td>
														<td width="156" align="center">
															<?

																		echo $work_type;
																		if ($work_type == 'Normal working') {
																			$total_working_day_standard++;
																			if ($row0['iworkhours'] > 0) {
																				$total_working_day++;
																			}
																		}
																		echo "<hr>";
																		//L0001 ลาป่วย
																		//L0002 ลากิจ
																		//L0003 ลาพักร้อน
																		//L0004 ลาบวช
																		//L0005 ลาคลอด
																		//L0006 ขาดงาน
																		//L0007 ไม่ได้ลงเวลาเข้า
																		//L0008 ไม่ได้ลงเวลาออก
																		//L0009 ทำงานนอกสถานที่
																		//L0010 ไม่ได้ลงเวลาเข้า + ออก
																		//L0011 ลาไม่ได้รับเงินเดือน
																		if ($leavetypeid != ''  && $leavetypeid != 'L0008' && $leavetypeid != 'L0007' && $leavetypeid != 'L0010') {

																			$basic_wage2 = $basic_wage;
																			$basic_salary2 = $basic_salary;
																			//echo $leavetypeid;
																			//////ลาป่วย//////////
																			if ($leavetypeid == 'L0001') {
																				$car_rice = 0;
																				//$total_sick_day++;
																				$total_sick_day = $total_sick_day + $leavetotalday;
																				echo ">>$leavetotalday<<<";
																			}
																			//////ลาป่วย//////////
																			/////ลากิจ///////////
																			if ($leavetypeid == 'L0002') {
																				if ($work_type == 'Normal working') {

																					$car_rice = 0;
																					//$total_personal_day++;
																					$total_personal_day = $total_personal_day + $leavetotalday;
																					//echo "leavetotalday = ".$leavetotalday;
																					// ถ้าลากิจครึ่งวัน 
																					$leave_personal_rate_emp = $leavetotalday * $leave_rate_emp;
																					//echo "leave_personal_rate_emp = ".$leave_personal_rate_emp;
																					$basic_wage2 = 0;
																					$total_personal_leave = $total_personal_leave + $leave_personal_rate_emp;


																					///// คำนวน bypass ลากิจ 3 วันต่อปี
																					$add = 0;
																					$select_plt = "SELECT * FROM  tbleave_transaction_bypass WHERE  (empno = '$empno') and paycodeyear ='$paycodeyear' ";
																					$re_plt = mssql_query($select_plt);
																					$num_plt = mssql_num_rows($re_plt);
																					//	echo "num_plt>>".$num_plt."<<";
																					if ($num_plt <= 0) {
																						$add = 1;
																						$row_plt_total = 0;
																					} else {
																						$select_plt2 = "SELECT sum(leave_bypass_day) as total FROM  tbleave_transaction_bypass WHERE  (empno = '$empno') and paycodeyear ='$paycodeyear' ";
																						$re_plt2 = mssql_query($select_plt2);

																						$row_plt2 = mssql_fetch_array($re_plt2);
																						if ($row_plt2['total'] < 3) {
																							$row_plt_total = $row_plt['total'];
																							$add = 1;
																						}
																					}

																					if ($add == 1) {
																						//echo "ลาทั้งหมด[[[";
																						//echo $row_plt_total;
																						//echo "--";
																						//echo $leavetotalday;
																						//echo "--";
																						//echo (float)$row_plt_total+(float)$leavetotalday;
																						//echo "]]]";
																						$select_plt3 = "SELECT * FROM  tbleave_transaction_bypass WHERE  (empno = '$empno') and paycodeyear ='$paycodeyear' and iworkdate='" . $row0['iworkdate'] . "'  ";
																						$re_plt3 = mssql_query($select_plt3);
																						$num_plt3 = mssql_num_rows($re_plt3);
																						if ($num_plt3 <= 0) {
			if (((float) $leavetotalday + (float) $row_plt_total) > 3) {
					$ans = 3 - (float) $row_plt_total;
																							} else {
																								$ans = $leavetotalday;
																							}
																							$ins = "insert into tbleave_transaction_bypass(iworkdate,leaveid, empno, paycode, paycodeyear, leave_bypass_day) values('" . $row0['iworkdate'] . "','$leaveid','$empno','$paycode','$paycodeyear',$ans)";
																							//	echo $ins;
																							mssql_query($ins);
																						}
																					}

																					$select_plt4 = "SELECT leave_bypass_day FROM  tbleave_transaction_bypass WHERE  (empno = '$empno') and paycodeyear ='$paycodeyear' and iworkdate='" . $row0['iworkdate'] . "' ";

																					$re_plt4 = mssql_query($select_plt4);
																					$num_plt4 = mssql_num_rows($re_plt4);
																					if ($num_plt4 > 0) {
																						$row_plt4 = mssql_fetch_array($re_plt4);
																						$total_bypass_personal_leave = (float) $total_bypass_personal_leave + ((float) $row_plt4['leave_bypass_day'] * (float) $leave_rate_emp);
																					}
																					//	echo "----".$total_bypass_personal_leave."----";



																					//$select_pl = "SELECT * FROM  tbleave_transaction WHERE  (empno = '$empno') AND (leavetypeid = 'L0002') and statusapprove='Approve' and leaveid = '$leaveid' ";
																					//							$re_pl = mssql_query($select_pl);
																					//							 $row_pl = mssql_fetch_array($re_pl);


																					//	$select_pl2 = "SELECT * FROM  tbleave_transaction_bypass WHERE  (empno = '$empno') AND (leaveid = '".$row_pl['leaveid']."') and paycodeyear ='$paycodeyear' ";
																					//												$re_pl2 = mssql_query($select_pl2);
																					//												$num_pl2 = mssql_num_rows($re_pl2);
																					//												if($num_pl2<=0){}
																					//												
																					//													

																					///// คำนวน bypass ลากิจ 3 วันต่อปี


																				}
																			}
																			/////ลากิจ///////////

																			////ลาพักร้อน/////////
																			if ($leavetypeid == 'L0003') {
																				$car_rice = 75;
																				$total_day++;
																				//$total_anual_day++;
																				$total_anual_day = $total_anual_day + $leavetotalday;
																			}
																			////ลาพักร้อน/////////
																			//////ลาบวช///////
																			if ($leavetypeid == 'L0004') {
																				$car_rice = 0;
																			}
																			//////ลาบวช///////
																			/////ลาคลอด///////
																			if ($leavetypeid == 'L0005') {
																				$car_rice = 0;
																			}
																			/////ลาคลอด///////
																			/////ขาดงาน///////
																			if ($leavetypeid == 'L0006') {
														$car_rice = 0;
																				//$total_absent_day++;
														$total_absent_day = $total_absent_day + $leavetotalday;
														$basic_wage2 = 0;
														$total_absent = $total_absent + $leave_rate_emp;
																			}

																			/////ขาดงาน///////
																			
																			/////ลาไม่ได้รับเงินเดือน///////
																			if ($leavetypeid == 'L0011') {
														$car_rice = 0;
														
														//$total_absent_day++;
														$total_leave_without_pay_day = $total_leave_without_pay_day + $leavetotalday;
														$basic_wage2 = 0;
														$total_leave_without_pay = $total_leave_without_pay + $leave_rate_emp;
																			}

																			/////ลาไม่ได้รับเงินเดือน///////

																			//$leaveday = $leaveday+1;
																			$leaveday = $leaveday + $leavetotalday;
																			//////ไม่ได้ลงเวลาออก////////
																			if ($leavetypeid == 'L0008') { }
																			//////ไม่ได้ลงเวลาออก////////
																			//////ไม่ได้ลงเวลาออก////////
																			if ($leavetypeid == 'L0007') { }
																			//////ไม่ได้ลงเวลาออก////////

																			//////ทำงานนอกสถานที่////////
																			if ($leavetypeid == 'L0009') {
																				$car_rice = 0;
																				$total_working_day = $total_working_day + 1;
																			}
																			//////ทำงานนอกสถานที่////////
																			//////ไม่ได้ลงเวลาเข้า + ออก////////
																			if ($leavetypeid == 'L0010') { }
																			//////ไม่ได้ลงเวลาเข้า + ออก////////

																			if ($leavetypeid != 'L0009') {
																				$total_ot1 = $total_ot1 + $ot_time1;
																				$total_ot1_5 = $total_ot1_5 + $ot_time1_5;
																				$total_ot2 = $total_ot2 + $ot_time2;
																				$total_ot3 = $total_ot3 + $ot_time3;

																				$total_ot = $total_ot + $ot_val;
																				$total_shift_val = $total_shift_val + $shift_val;
																				$total_fl = $total_fl + $fl;
																				$total_car_rice = $total_car_rice + $car_rice;
																			}


																			if ($emptype == 'employee') {
																				//echo "basic_salary = ".$basic_salary." <BR>";
																			} else {
																				echo "basic_wage = " . $basic_wage2 . " <BR>";
																			}

																			echo "car_rice = " . $car_rice . " <BR>";
																			echo "ot_time = " . $ot_time . " <BR>";
																			echo "fl = " . $fl . " <BR>";
																			echo "shift_val = " . $shift_val . " <BR>";

																			echo "total_ot1 = " . $total_ot1 . " <BR>";
																			echo "total_ot1_5 = " . $total_ot1_5 . " <BR>";
																			echo "total_ot2 = " . $total_ot2 . " <BR>";
																			echo "total_ot3 = " . $total_ot3 . " <BR>";

																			echo "ot_val = " . $ot_val . " <BR>";
																			echo "(" . $total_ot . ")<BR>";


																			$total = 0;
																			if ($emptype == 'employee') {
																				echo $car_rice + $ot_val + $fl + $shift_val;
																				$total = $car_rice + $ot_val + $fl + $shift_val;
																				$total_total = $total_total + ($car_rice + $ot_val + $fl + $shift_val);
																			} else {
																				echo $basic_wage2 + $car_rice + $ot_val + $fl + $shift_val;
																				$total = $basic_wage2 + $car_rice + $ot_val + $fl + $shift_val;
																				$total_total = $total_total + ($basic_wage2 + $car_rice + $ot_val + $fl + $shift_val);
																			}



																			echo "(" . $total_total . ")";

																			$car_rice = 75;
																		}

																		if ($row0['iworkhours'] > 0) {


																			//	if($work_type!='H Sat , Sun'){
																			$total_day = $total_day + 1;
																			if ($row0['iShift'] == 'Day') {
																				$total_day_day++;
																			}
																			if ($row0['iShift'] == 'Night') {
																				$total_day_night++;
																			}
																			//}



																			$total_ot1 = $total_ot1 + $ot_time1;
																			$total_ot1_5 = $total_ot1_5 + $ot_time1_5;
																			$total_ot2 = $total_ot2 + $ot_time2;
																			$total_ot3 = $total_ot3 + $ot_time3;

																			$total_ot = $total_ot + $ot_val;
																			$total_shift_val = $total_shift_val + $shift_val;
																			$total_fl = $total_fl + $fl;
																			$total_car_rice = $total_car_rice + $car_rice;

																			if ($work_type == 'H Sat , Sun') {

																				if ($emptype == 'employee') { } else {
																					echo "basic_wage = 0 <BR>";
																				}
																			} else {

																				if ($emptype == 'employee') { } else {
																					echo "basic_wage = " . $basic_wage . " <BR>";
																				}
																			}



																			echo "car_rice = " . $car_rice . " <BR>";
																			echo "ot_time = " . $ot_time . " <BR>";
																			echo "fl = " . $fl . " <BR>";
																			echo "shift_val = " . $shift_val . " <BR>";
																			echo "<hr>";
																			echo "total_ot1 = " . $total_ot1 . " <BR>";
																			echo "total_ot1_5 = " . $total_ot1_5 . " <BR>";
																			echo "total_ot2 = " . $total_ot2 . " <BR>";
																			echo "total_ot3 = " . $total_ot3 . " <BR>";

																			echo "ot_val = " . $ot_val . " <BR>";
																			echo "( total ot = " . $total_ot . ")<hr>";


																			$total = 0;
																			if ($emptype == 'employee') {
																				echo $car_rice + $ot_val + $fl + $shift_val;
																				$total = $car_rice + $ot_val + $fl + $shift_val;
																				$total_total = $total_total + ($car_rice + $ot_val + $fl + $shift_val);
																			} else {
																				if ($work_type == 'H Sat , Sun') {
																					echo $car_rice + $ot_val + $fl + $shift_val;
																					$total = $car_rice + $ot_val + $fl + $shift_val;
																					$total_total = $total_total + ($car_rice + $ot_val + $fl + $shift_val);
																				} else {
																					echo $basic_wage + $car_rice + $ot_val + $fl + $shift_val;
																					$total = $basic_wage + $car_rice + $ot_val + $fl + $shift_val;
																					$total_total = $total_total + ($basic_wage + $car_rice + $ot_val + $fl + $shift_val);
																				}
																			}



																			echo "(" . $total_total . ")";
																			/// UPDATE Line
																			//$update = "update tbatt set fl=$fl, ot_val=$ot_val, car_rice=$car_rice, shift_val=$shift_val, total=$total 
																			//where id=".$row2['id']."";
																			//mssql_query($update);
																			//echo $update;
																		} else {
																			if ($work_type == 'H') {

																				if ($emptype == 'employee') {
																					$total_day = $total_day + 1;
																				} else {
																					if ($total_day == 0) { } else {
																						echo $basic_wage;
																						$total_day = $total_day + 1;
																						$total_total = $total_total + $basic_wage;
																						echo "(" . $total_total . ")";
																					}
																				}
																			}
																		}
																		echo "<BR>Total Day = " . $total_day;
																		?>
														</td>


													</tr>
											<?
													
															
														}else{
													    ////SALARY RATE != 100%
														$extra_salary =1;	
														$ot_time1 = 0;
														$ot_time1_5 = 0;
														$ot_time2 = 0;
														$ot_time3 = 0;
														$rate1 = 0;
														$rate1_5 = 0;
														$rate2 = 0;
														$rate3 = 0;

														if ($row0['irate1'] > 0) {
															$ot_time1 = $row0['irate1'];
															$rate1 = 1;
														}
														if ($row0['irate1_5'] > 0) {
															$ot_time1_5 = $row0['irate1_5'];
															$rate1_5 = 1.5;
														}
														if ($row0['irate2'] > 0) {
															$ot_time2 = $row0['irate2'];
															$rate2 = 2;
														}
														if ($row0['irate3'] > 0) {
															$ot_time3 = $row0['irate3'];
															$rate3 = 3;
														}
														
														if ($work_type == 'Normal working' || ($work_type == 'H Sat , Sun' && $emptype=='employee') ) {
																$total_day_extra++;
																if($row0['salary_rate']==90){
																	$total_extra90 ++;
																}
																if($row0['salary_rate']==75){
																	$total_extra75 ++;
																}
																if($row0['salary_rate']==50){
																	$total_extra50 ++;
																}
																if($row0['salary_rate']==0){
																	$total_extra0 ++;
																}
														}

														//check leave date
														$select_le = "select * from  tbleave_transaction where '" . $row0['iworkdate'] . "' between CAST(leavestartdate AS DATE) and CAST(leaveenddate AS DATE) and empno='$empno' and statusapprove='Approve' ";
														$re_le = mssql_query($select_le);
														$num_le = mssql_num_rows($re_le);
														if ($num_le > 0) {
															$row_le = mssql_fetch_array($re_le);
															$leavetypeid = $row_le['leavetypeid'];
															$leaveid = $row_le['leaveid'];
															$reasons = lang_thai_from_database($row_le["reasons"]);
															if ($row_le['leavetotal'] < 1) {
																$leavetotalday = $row_le['leavetotal'];
															} else {
																$leavetotalday = 1;
															}


					$select_ln = "select leavename from tbleavetype where   leavetypeid='$leavetypeid'  ";
															$re_ln = mssql_query($select_ln);
															$row_ln = mssql_fetch_array($re_ln);
															$leavename = iconv("tis-620", "utf-8", $row_ln['leavename']);
														} else {
															$leavetypeid = "";
															$leavename = "";
															$leavetotalday = 0;
														}
														//check leave date
														

														$select1 = "select work_type from  tbot_parameter where CAST(workdate AS DATE)='" . $row0['iworkdate'] . "' and site='$tsite'  ";
														$re1 = mssql_query($select1);
														$num1 = mssql_num_rows($re1);
														if ($num1 > 0) {
															$row1 = mssql_fetch_array($re1);
															$work_type = $row1['work_type'];
														}

														?>
													<tr>
														<td width="96" align="center"><?= $row0['iworkdate'] ?></td>
														<td width="98" height="40" align="center"><?= $row0['idayname_en'] ?></td>
														<td width="60" align="center"><?= $row0['iShift'] ?></td>
														<td width="129" align="center">
															<?
																		if ($leavetypeid != '') {

																			echo "ข้อความจากระบบลา :" . $leavename;
																			echo "<BR>เหตผล :" . $reasons;
																			echo "<HR>";
																		}
				if ($row0['iworkhours'] > 0) {
						echo $row0['iattDate1'];
						 ?> <?
						 echo $row0['iattTime1'];

					if ($leavetypeid == 'L0010' || $leavetypeid != 'L0007' || $leavetypeid != 'L0009' ) {																																					                      	//ไม่ได้ลงเวลาเข้า + ออก ,ทำงานนอกสถานที่
								} else {
						
						if ($row0['iShift'] == 'Day' && $work_type == 'Normal working') {
							
							
							$check_late = $row0['iattDate1'] . " " . $row0['iattTime1'];
							$check_late2 = $row0['iattDate1'] . " 08:01";																							
						
							if (DateTimeDiff($check_late, $check_late2) < 0) {
									$total_late = $total_late + 1;
							}
						}
					

						if ($row0['iShift'] == 'Night' && $work_type == 'Normal working') {
							
							$check_late = $row0['iattDate1'] . " " . $row0['iattTime1'];
							$check_late2 = $row0['iattDate1'] . " 20:21";
							if (DateTimeDiff($check_late, $check_late2) < 0) {
								$total_late = $total_late + 1;
							}
						}
					}
				}
			
			
			
			/// check no attendance data
			if ($work_type == 'Normal working' || ($work_type == 'H Sat , Sun' && $emptype=='employee')) {
			
			
			
			
			$sql_emp = "SELECT * FROM tbemployee WHERE empno='$empno'";
			$res_emp = mssql_query($sql_emp);
			$row_emp = mssql_fetch_array($res_emp);
			$startdatex = $row_emp["startdate"];
			$resigndate = $row_emp["resigndate"];
		if(((strtotime($row0['iworkdate']) > strtotime($resigndate)) && $resigndate!='') || strtotime($row0['iworkdate']) < strtotime($startdatex)){
			// echo "X";
	}else{
			// echo "O";
																												$select_no = "SELECT top 1 att_real_date from  tbatt 	where empno='$empno' and att_real_date='" . $row0['iworkdate'] . "'";
				$re_no = mssql_query($select_no);
				$num_no = mssql_num_rows($re_no);
			if ($num_no <= 0) {
																													
				$select_no2 = "SELECT leavestartdate from tbleave_transaction where  empno='$empno' and '" . $row0['iworkdate'] . "' between leavestartdate and leaveenddate 	and statusapprove='Approve'";
				$re_no2 = mssql_query($select_no2);
				$num_no2 = mssql_num_rows($re_no2);
					if ($num_no2 <= 0) {
						echo "<font color='red'>no attendance data but pay ".$row0['salary_rate']."%</font>";
						//$update = "update  tbatt_approve set status_noatt_deduct='New' where id=" . $row0['id'] . "";
						//mssql_query($update);
						//$total_no_attendance++;
						if ($row0['status_noatt_deduct'] == 'New') {
							$update = "update  tbatt_approve set status_noatt_deduct=NULL where id=" . $row0['id'] . "";
							mssql_query($update);
						}
			 }else {
				if ($row0['status_noatt_deduct'] == 'New') {
					$update = "update  tbatt_approve set status_noatt_deduct=NULL where id=" . $row0['id'] . "";
					mssql_query($update);
				}
			}
		 }
	  }
	}
																										/// check no attendance data													


																										?></td>
														<td width="116" align="center">
															<?
																		if ($row0['iworkhours'] > 0) {
																			echo $row0['iattDate2'] ?> <?= $row0['iattTime2'];
																										} ?></td>
														<td width="57" align="center"></td>
														<td width="53" align="center">
															<?

																		echo "rate1=";
																		echo $ot_time1;
																		echo "<BR>rate1_5=";
																		echo $ot_time1_5;
																		echo "<BR>rate2=";
																		echo $ot_time2;
																		echo "<BR>rate3=";
																		echo $ot_time3;

																		?>
														</td>
														<td width="84" align="center">
															<?
																		$ot_val = 0;
																		$ot_val1 = 0;
																		$ot_val1_5 = 0;
																		$ot_val2 = 0;
																		$ot_val3 = 0;
																		if ($ot_time1 != 0) {
																			$ot_val1 = ($ot_time1 * $ot_rate_emp);
																			$ot_val1 = $ot_val1 * $rate1;
																		}
																		if ($ot_time1_5 != 0) {
																			$ot_val1_5 = ($ot_time1_5 * $ot_rate_emp);
																			$ot_val1_5 = $ot_val1_5 * $rate1_5;
																		}
																		if ($ot_time2 != 0) {
																			$ot_val2 = ($ot_time2 * $ot_rate_emp);
																			$ot_val2 = $ot_val2 * $rate2;
																		}
																		if ($ot_time3 != 0) {
																			$ot_val3 = ($ot_time3 * $ot_rate_emp);
																			$ot_val3 = $ot_val3 * $rate3;
																		}
																		$ot_val =  $ot_val1 + $ot_val1_5 + $ot_val2 + $ot_val3;
																		$ot_val = number_format($ot_val, 2, '.', '');
																		echo $ot_val;
																		?>
														</td>
														<td width="67" align="center">
															<?

																		if ($row0['iworkhours'] > 0) {

																			echo $car_rice;
																		}
																		?>
														</td>
														<td width="54" align="center">
															<?
																		if ($row0['ifl'] == 'yes') {
																			$fl = 50;
																		} else {
																			$fl = 0;
																		}
																		echo $fl;
																		?>
														</td>
														<td width="56" align="center">
															<?
																		if ($row0['iShift'] == 'Night') {
																			$shift_val = 120;
																		} else {
																			$shift_val = 0;
																		}
																		echo $shift_val;
																		?>
														</td>
														<td width="156" align="center">
															<?

																		echo $work_type;
																		if ($work_type == 'Normal working') {
																			$total_working_day_standard++;
																			if ($row0['iworkhours'] > 0) {
																				$total_working_day++;
																			}
																		}
																		echo "<hr>";
																		//L0001 ลาป่วย
																		//L0002 ลากิจ
																		//L0003 ลาพักร้อน
																		//L0004 ลาบวช
																		//L0005 ลาคลอด
																		//L0006 ขาดงาน
																		//L0007 ไม่ได้ลงเวลาเข้า
																		//L0008 ไม่ได้ลงเวลาออก
																		//L0009 ทำงานนอกสถานที่
																		//L0010 ไม่ได้ลงเวลาเข้า + ออก
																		//L0011 ลาไม่ได้รับเงินเดือน
			if ($leavetypeid != ''  && $leavetypeid != 'L0008' && $leavetypeid != 'L0007' && $leavetypeid != 'L0010') {

																			$basic_wage2 = $basic_wage;
																			$basic_salary2 = $basic_salary;
																			//echo $leavetypeid;
												//////ลาป่วย//////////
												if ($leavetypeid == 'L0001') {
												$car_rice = 0;
												$total_sick_day = $total_sick_day + $leavetotalday;
												echo ">>$leavetotalday<<<";
												}
												//////ลาป่วย//////////
												/////ลากิจ///////////
												if ($leavetypeid == 'L0002') {
													if ($work_type == 'Normal working') {
														$car_rice = 0;
														$total_personal_day = $total_personal_day + $leavetotalday;
														// ถ้าลากิจครึ่งวัน 
														$leave_personal_rate_emp = $leavetotalday * $leave_rate_emp;
														$basic_wage2 = 0;
														$total_personal_leave = $total_personal_leave + $leave_personal_rate_emp;
														///// คำนวน bypass ลากิจ 3 วันต่อปี
														$add = 0;
														$select_plt = "SELECT * FROM  tbleave_transaction_bypass WHERE  (empno = '$empno') and paycodeyear ='$paycodeyear' ";
														$re_plt = mssql_query($select_plt);
														$num_plt = mssql_num_rows($re_plt);
														if ($num_plt <= 0) {
															$add = 1;
															$row_plt_total = 0;
														} else {
															$select_plt2 = "SELECT sum(leave_bypass_day) as total FROM  tbleave_transaction_bypass WHERE  (empno = '$empno') and paycodeyear ='$paycodeyear' ";
															$re_plt2 = mssql_query($select_plt2);
															$row_plt2 = mssql_fetch_array($re_plt2);
															if ($row_plt2['total'] < 3) {
																$row_plt_total = $row_plt['total'];
																$add = 1;
															}
														}

														if ($add == 1) {
															$select_plt3 = "SELECT * FROM  tbleave_transaction_bypass WHERE  (empno = '$empno') and paycodeyear ='$paycodeyear' and iworkdate='" . $row0['iworkdate'] . "'  ";
															$re_plt3 = mssql_query($select_plt3);
															$num_plt3 = mssql_num_rows($re_plt3);
															if ($num_plt3 <= 0) {
																if (((float) $leavetotalday + (float) $row_plt_total) > 3) {
																	$ans = 3 - (float) $row_plt_total;
																} else {
																	$ans = $leavetotalday;
															}
															$ins = "insert into tbleave_transaction_bypass(iworkdate,leaveid, empno, paycode, paycodeyear, leave_bypass_day) values('" . $row0['iworkdate'] . "','$leaveid','$empno','$paycode','$paycodeyear',$ans)";
															mssql_query($ins);
														}
													}

													$select_plt4 = "SELECT leave_bypass_day FROM  tbleave_transaction_bypass WHERE  (empno = '$empno') and paycodeyear ='$paycodeyear' and iworkdate='" . $row0['iworkdate'] . "' ";
													$re_plt4 = mssql_query($select_plt4);
													$num_plt4 = mssql_num_rows($re_plt4);
													if ($num_plt4 > 0) {
													$row_plt4 = mssql_fetch_array($re_plt4);
													$total_bypass_personal_leave = (float) $total_bypass_personal_leave + ((float) $row_plt4['leave_bypass_day'] * (float) $leave_rate_emp);
													}
																					
													///// คำนวน bypass ลากิจ 3 วันต่อปี
																				}
																			}
													/////ลากิจ///////////
													////ลาพักร้อน/////////
													if ($leavetypeid == 'L0003') {
													$car_rice = 75;
													$total_day++;
													//$total_anual_day++;
													$total_anual_day = $total_anual_day + $leavetotalday;
													}
													////ลาพักร้อน/////////
													//////ลาบวช///////
													if ($leavetypeid == 'L0004') {
													$car_rice = 0;
													}
													//////ลาบวช///////
													/////ลาคลอด///////
													if ($leavetypeid == 'L0005') {
													$car_rice = 0;
													}
													/////ลาคลอด///////
													/////ขาดงาน///////
													if ($leavetypeid == 'L0006') {
													$car_rice = 0;
													$total_absent_day = $total_absent_day + $leavetotalday;
													$basic_wage2 = 0;
													$total_absent = $total_absent + $leave_rate_emp;
													}
													/////ขาดงาน///////
													/////ลาไม่ได้รับเงินเดือน///////
													if ($leavetypeid == 'L0011') {
									$car_rice = 0;
									$total_leave_without_pay_day = $total_leave_without_pay_day + $leavetotalday;
									$basic_wage2 = 0;
									$total_leave_without_pay = $total_leave_without_pay + $leave_rate_emp;
													}
													/////ลาไม่ได้รับเงินเดือน///////
													$leaveday = $leaveday + $leavetotalday;
													//////ไม่ได้ลงเวลาออก////////
													if ($leavetypeid == 'L0008') { }
													//////ไม่ได้ลงเวลาออก////////
													//////ไม่ได้ลงเวลาออก////////
													if ($leavetypeid == 'L0007') { }
													//////ไม่ได้ลงเวลาออก////////
													//////ทำงานนอกสถานที่////////
													if ($leavetypeid == 'L0009') {
													$car_rice = 0;
													$total_working_day = $total_working_day + 1;
													}
													//////ทำงานนอกสถานที่////////
													//////ไม่ได้ลงเวลาเข้า + ออก////////
													if ($leavetypeid == 'L0010') { }
													//////ไม่ได้ลงเวลาเข้า + ออก////////
													if ($leavetypeid != 'L0009') {
													$total_ot1 = $total_ot1 + $ot_time1;
													$total_ot1_5 = $total_ot1_5 + $ot_time1_5;
													$total_ot2 = $total_ot2 + $ot_time2;
													$total_ot3 = $total_ot3 + $ot_time3;
													$total_ot = $total_ot + $ot_val;
													$total_shift_val = $total_shift_val + $shift_val;
													$total_fl = $total_fl + $fl;
													$total_car_rice = $total_car_rice + $car_rice;
													}
													
													if ($emptype == 'employee') {
														//echo "basic_salary = ".$basic_salary." <BR>";
													} else {
														echo "basic_wage = " . $basic_wage2 . " <BR>";
													}
														echo "car_rice = " . $car_rice . " <BR>";
														echo "ot_time = " . $ot_time . " <BR>";
														echo "fl = " . $fl . " <BR>";
														echo "shift_val = " . $shift_val . " <BR>";
														echo "total_ot1 = " . $total_ot1 . " <BR>";
														echo "total_ot1_5 = " . $total_ot1_5 . " <BR>";
														echo "total_ot2 = " . $total_ot2 . " <BR>";
														echo "total_ot3 = " . $total_ot3 . " <BR>";
														echo "ot_val = " . $ot_val . " <BR>";
														echo "(" . $total_ot . ")<BR>";
														$total = 0;
														if ($emptype == 'employee') {
															echo $car_rice + $ot_val + $fl + $shift_val;
															$total = $car_rice + $ot_val + $fl + $shift_val;
															$total_total = $total_total + ($car_rice + $ot_val + $fl + $shift_val);
															} else {
															echo $basic_wage2 + $car_rice + $ot_val + $fl + $shift_val;
															$total = $basic_wage2 + $car_rice + $ot_val + $fl + $shift_val;
															$total_total = $total_total + ($basic_wage2 + $car_rice + $ot_val + $fl + $shift_val);
														}
														echo "(" . $total_total . ")";
														$car_rice = 75;
			}
							
							if ($row0['iworkhours'] > 0) {
								$total_day = $total_day + 1;
								if ($row0['iShift'] == 'Day') {
									//	$total_day_day++;
								}
								if ($row0['iShift'] == 'Night') {
										//$total_day_night++;
							}
							
											$total_ot1 = $total_ot1 + $ot_time1;
											$total_ot1_5 = $total_ot1_5 + $ot_time1_5;
											$total_ot2 = $total_ot2 + $ot_time2;
											$total_ot3 = $total_ot3 + $ot_time3;
											$total_ot = $total_ot + $ot_val;
											$total_shift_val = $total_shift_val + $shift_val;
											$total_fl = $total_fl + $fl;
											$total_car_rice = $total_car_rice + $car_rice;

								if ($work_type == 'H Sat , Sun') {

									if ($emptype == 'employee') { } else {
											echo "basic_wage = 0 <BR>";
									}
								} else {

									if ($emptype == 'employee') { } else {
										echo "basic_wage = " . $basic_wage . " <BR>";
									}
								}
								
											echo "car_rice = " . $car_rice . " <BR>";
											echo "ot_time = " . $ot_time . " <BR>";
											echo "fl = " . $fl . " <BR>";
											echo "shift_val = " . $shift_val . " <BR>";
											echo "<hr>";
											echo "total_ot1 = " . $total_ot1 . " <BR>";
											echo "total_ot1_5 = " . $total_ot1_5 . " <BR>";
											echo "total_ot2 = " . $total_ot2 . " <BR>";
											echo "total_ot3 = " . $total_ot3 . " <BR>";
											echo "ot_val = " . $ot_val . " <BR>";
											echo "( total ot = " . $total_ot . ")<hr>";
											$total = 0;
											if ($emptype == 'employee') {
												echo $car_rice + $ot_val + $fl + $shift_val;
												$total = $car_rice + $ot_val + $fl + $shift_val;
												$total_total = $total_total + ($car_rice + $ot_val + $fl + $shift_val);
											} else {
												if ($work_type == 'H Sat , Sun') {
													echo $car_rice + $ot_val + $fl + $shift_val;
													$total = $car_rice + $ot_val + $fl + $shift_val;
													$total_total = $total_total + ($car_rice + $ot_val + $fl + $shift_val);
												} else {
													echo $basic_wage + $car_rice + $ot_val + $fl + $shift_val;
													$total = $basic_wage + $car_rice + $ot_val + $fl + $shift_val;
													$total_total = $total_total + ($basic_wage + $car_rice + $ot_val + $fl + $shift_val);
												}
											}
											
											echo "(" . $total_total . ")";
																			
																		} else {
																			if ($work_type == 'H') {

																				if ($emptype == 'employee') {
																					$total_day = $total_day + 1;
																				} else {
																					if ($total_day == 0) { } else {
																						echo $basic_wage;
																						$total_day = $total_day + 1;
																						$total_total = $total_total + $basic_wage;
																						echo "(" . $total_total . ")";
																					}
																				}
																			}
																		}
																		echo "<BR>Total Day = " . $total_day;
																		?>
														</td>


													</tr>
											<?
													
														////SALARY RATE != 100%		
														}
														////CHECK SALARY RATE
													
													}
													
}


												?>

										</table>

										<HR>
										<?
										
				if ($paycode != '') {
					if($extra_salary==1){
						
												// select summary 
												$selectp = "SELECT ytd_income, ytd_tax, ytd_social_in from tbytdsummary where empno='$empno' and paycodeyear='$paycodeyear'  ";
												$rep = mssql_query($selectp);

												$nump = mssql_num_rows($rep);
												if ($nump > 0) {
													$rowp = mssql_fetch_array($rep);
													$ytd_income =  $rowp['ytd_income'];
													$ytd_tax =  $rowp['ytd_tax'];
													$ytd_social_in =  $rowp['ytd_social_in'];
												} else {
													$ytd_income =  0;
													$ytd_tax =  0;
													$ytd_social_in =  0;
												}


												$selecth = "SELECT bonus,other,paystatus,att_reward_old, att_reward,position_val, mte_val, travel_val, mobile_val,hbd,leave_without_pay,personal_leave,absent,other_deduct,no_attendance from tbsalary where empno='$empno' and paycode='$paycode' ";
												$reh = mssql_query($selecth);
												$rowh = mssql_fetch_array($reh);
												$hbd = $rowh['hbd'];
												$satt_reward_old = $rowh['att_reward_old'];
												$satt_reward = $rowh['att_reward'];
												$position_val = $rowh['position_val'];
												$mte_val = $rowh['mte_val'];
												$travel_val = $rowh['travel_val'];
												$mobile_val = $rowh['mobile_val'];
												$leave_without_pay = $rowh['leave_without_pay'];
												$no_attendance = $rowh['no_attendance'];
												$personal_leave = $rowh['personal_leave'];
												$absent = $rowh['absent'];
												$other_deduct = $rowh['other_deduct'];
												$paystatus = $rowh['paystatus'];
												$other = $rowh['other'];
												$bonus = $rowh['bonus'];
												if ($hbd == '') {
													$hbd = 0;
												}
												if ($personal_leave == '') {
													$personal_leave = $total_personal_leave;
												}

												if ($personal_leave > 0) {
													$personal_leave =  number_format($personal_leave, 2, '.', '');
												}
												if ($absent == '') {
													$absent = $total_absent;
												}
												if ($leave_without_pay == '') {
													$leave_without_pay = 0;
												}
												if ($no_attendance == '') {
													$no_attendance = 0;
												}
												if ($other_deduct == '') {
													$other_deduct = 0;
												}
												if ($other == '') {
													$other = 0;
												}
												if ($bonus == '') {
													$bonus = 0;
												}





												?>
											<table align="center" width="70%" border="1" cellspacing="0" cellpadding="0">

												<tr>
													<td width="194" bgcolor="#CCCCCC" colspan="2">
														<?
											echo " | วันเริ่มงาน $startdate2";
											echo " | วันที่ปัจจุบัน $today";
											echo " | อายุงาน $u_y   ปี    $u_m เดือน      $u_d  วัน<br><br>";
											echo $work_age_day = DateDiff($startdate2, $today);
																?>
													</td>

													<td colspan="2" align="center" bgcolor="#CCCCCC">&nbsp;</td>
													<td width="119" bgcolor="#CCCCCC">&nbsp;</td>
													<td width="119" align="center" bgcolor="#CCCCCC"> <a href="javascript:void(0);" onclick="printslip('<?= $empno ?>','<?= $paycode ?>','<?= $paycodeyear ?>');" class="btn-primary btn" style="background-color:#16a085;"><i class="fa fa-print"></i> Print Slip</a></td>
												</tr>
												<tr>
													<td>Salary / Wage</td>
													<td align="center">
														<?
																if ($emptype == 'employee') {
																	
																	//$select_ss = "select count(id) as total_satsun_100  
//FROM            tbatt_approve
//WHERE        (empno = '$empno') AND idayname_en in('Saturday','Sunday') and (salary_rate = '100') AND (paycode = '$paycode') AND (iworkhours = 0)";
//																	$re_ss = mssql_query($select_ss);
//																	$num_ss=mssql_num_rows($re_ss);
//																	if($num_ss>0){
//																	 $row_ss = mssql_fetch_array($re_ss);
//																	 $total_satsun_100 = $row_ss['total_satsun_100'];
//																	}
																	
																	 $total_satsun_100 =30-($total_day_day+$total_day_night+$total_extra90+$total_extra75+$total_extra50+$total_extra0);
																	//echo "total_day_day = $total_day_day <BR> ";
																	//echo "total_day_night = $total_day_night <BR> ";
																	//echo "total_extra90 = $total_extra90 <BR> ";
																	//echo "total_extra75 = $total_extra75 <BR> ";
																	//echo "total_extra50 = $total_extra50 <BR> ";
																	//echo "total_extra0 = $total_extra0 <BR> ";
																	
																	//echo "total_satsun_100 = $total_satsun_100 <BR> ";
																	echo "basic_salary per day = ";
																	echo "(".number_format(($basic_salary/30), 2, '.', '')."per day)";
																	echo "<BR>";
																	//echo "total_day_day = $total_day_day";
																	//echo "<BR>";
																	//echo "total_day_night = $total_day_night";
																	//echo "<BR>";
																	//echo "total_satsun_100 = $total_satsun_100";
																	//echo "<BR>";
																	$s100 = $basic_salary/30;
																	$s90 = ($s100*90)/100;
																	$s75 = ($s100*75)/100;
																	$s50 = ($s100*50)/100;
																	$s0 = 0;
											$s100 = $s100 * ($total_day_day+$total_day_night+$total_satsun_100);
																	//echo "s100=".$s100;
																	
																	
																	$sk100 = $skill_reward/30;
																	$sk90 = ($sk100*90)/100;
																	$sk75 = ($sk100*75)/100;
																	$sk50 = ($sk100*50)/100;
																	$sk0 = 0;
																	
																	
																} else {
																	echo number_format($basic_wage, 2, '.', '');
																	$s100 = $basic_wage;
																	$s90 = ($s100*90)/100;
																	$s75 = ($s100*75)/100;
																	$s50 = ($s100*50)/100;
																	$s0 = 0;
													$s100 = $s100 * ($total_day_day+$total_day_night + $total_sick_day);
																	
																}
																
																$s90 = $s90 * ($total_extra90);
																$s75 = $s75 * ($total_extra75);
																$s50 = $s50 * ($total_extra50);
																$s0 = $s0 * ($total_extra50);
																echo "<BR>";
																echo number_format($s100, 2, '.', '');
																echo "+";
																echo number_format($s75, 2, '.', '');
																echo "=";
																$s_salary = $s100+$s90+$s75+$s50+$s0;
																echo number_format($s_salary, 2, '.', '');
																
																
																$sk100 = $sk100 * ($total_day_day+$total_day_night);
																$sk90 = $sk90 * ($total_extra90);
																$sk75 = $sk75 * ($total_extra75);
																$sk50 = $sk50 * ($total_extra50);
																$sk0 = $sk0 * ($total_extra0);
																echo "<BR>";
																echo $sk100;
																echo "+";
																echo $sk75;
																echo "=";
																//$s_skill_reward = $sk100+$sk90+$sk75+$sk50+$sk0;
																$s_skill_reward = $sk90+$sk75+$sk50+$sk0;
																echo $s_skill_reward;
																?>
													</td>
													<td colspan="2" align="center"></td>
													<td>Shift Day (100%)</td>
													<td><?= $total_day_day ?> วัน</td>
												</tr>
												<tr>
													<td>มาทำงาน</td>
													<td align="center"><?= $total_day ?> </td>
													<td colspan="2" align="center">วัน</td>
													<td>Shift Night(100%)</td>
													<td><?= $total_day_night ?> วัน</td>
												</tr>

												<tr>
													<td>มาสาย</td>
													<td align="center"><?= $total_late ?> </td>
													<td colspan="2" align="center">วัน</td>
													<td>Total Day (Extra)</td>
												  <td>Total : <?=$total_day_extra?> วัน<BR>
                                                  (90% <?=$total_extra90?> วัน)<BR>
                                                  (75% <?=$total_extra75?> วัน)<BR>
                                                  (50% <?=$total_extra50?> วัน)<BR>
                                                  (0% <?=$total_extra0?> วัน)
                                                  </td>
												</tr>

												<tr>
													<td>
														<font color="#FF0000">No attendance data</font>
													</td>
													<td align="center"><?= $total_no_attendance ?> </td>
													<td colspan="2" align="center">วัน</td>
													<td>Total Working Day</td>
													<td><?= $total_working_day ?>วัน จาก Standard <?= $total_working_day_standard ?></td>
												</tr>

												<tr>
													<td>ลาไม่ได้รับเงินเดือน</td>
													<td align="center"><?
													echo $total_leave_without_pay_day;
													if($total_leave_without_pay_day>0){
																if ($emptype == 'employee') {
																	//echo $basic_salary;
									$leave_without_pay = ($s_salary/30)*$total_leave_without_pay_day;
																} else {
									$leave_without_pay = $s_salary*$total_leave_without_pay_day;
																	//echo $basic_wage;
																}
														}
													
													
													 ?> </td>
													<td colspan="2" align="center">วัน</td>
													<td>&nbsp;</td>
												  <td></td>
												</tr>
                                                <tr>
													<td>ลาป่วย</td>
													<td align="center"><?= $total_sick_day ?> </td>
													<td colspan="2" align="center">วัน</td>
													<td>&nbsp;</td>
												  <td></td>
												</tr>
												<tr>
													<td>ลากิจ</td>
													<td align="center"><?= $total_personal_day ?> </td>
													<td colspan="2" align="center">วัน</td>
													<td align="center">
														<!--ลาป่วยต่อปี--><button class='btn btn-info btn-sm' onclick="modal_personal_leave('<?= $paycode ?>','<?= $empno ?>')">ดูลากิจทั้งปี</button></td>
													<td>&nbsp;</td>
												</tr>
												<tr>
													<td colspan="6">
														<table width="100%" border="0" cellspacing="0" cellpadding="0">
															<tr>
																<td width="50%" valign="top"> ข้อมูลลากิจในรอบนี้
																	<table class='table table-bordered' width="50%">
																		<thead>
																			<th bgcolor="#FFFFCC">Start Date</th>
																			<th bgcolor="#FFFFCC">End Date</th>
																			<th bgcolor="#FFFFCC">Total Date</th>
																			<th bgcolor="#FFFFCC">Reason</th>
																			<th bgcolor="#FFFFCC">Approve By</th>
																		</thead>
																		<?



					$sql_leave = "SELECT leaveid,convert(varchar, leavestartdate, 103)as leavestartdate_date,
					convert(varchar, leaveenddate, 103)as leaveenddate_date,
					reasons,headapprove,leavetotal,* FROM tbleave_transaction  WHERE leaveenddate between '$startdate' and '$enddate' AND leavetypeid='L0002' AND empno='$empno' AND statusapprove='Approve' order by leavestartdate asc";
					//echo $sql_leave;
					$res_leave = mssql_query($sql_leave);
					while ($row_leave = mssql_fetch_array($res_leave)) {
							$leavestartdate = $row_leave["leavestartdate_date"];
							$leaveenddate = $row_leave["leaveenddate_date"];
							$leavetotal = $row_leave["leavetotal"];
							//$leavetotal++;
							$reasons = lang_thai_from_database($row_leave["reasons"]);
							$headapprove = lang_thai_from_database($row_leave["headapprove"]);
							
							
					?>
																			<tr>
																				<td><?= $leavestartdate ?></td>
																				<td><?= $leaveenddate ?></td>
																				<td><?
																								//$leavetotal;
																								//$leavetotal = 0;
//																								$sql_leave0 = "	SELECT * FROM   tbleave_transaction where empno='$empno' and paycode='$paycode'
//	 and iworkdate between '" . $row_leave['leavestartdate'] . "' 
//	and '" . $row_leave['leaveenddate'] . "' order by iworkdate asc";
//																								
//																								$re_leave0 = mssql_query($sql_leave0);
//																								while ($row_leave0 = mssql_fetch_array($re_leave0)) {
//																									
//																									$leavetotal++;
//																								}
																								echo $leavetotal;

																								?></td>
																				<td><?= $reasons ?></td>
																				<td><?= $headapprove ?></td>
																			</tr>
																		<?
																				}
																				?>
																	</table>
																</td>
																<td width="50%" valign="top">ข้อมูล bypass ลากิจของปีนี้ทั้งหมด
																	<table class='table table-bordered' width="50%">
																		<thead>
																			<tr>
																				<th bgcolor="#95FF95">Paycode</th>
																				<th bgcolor="#95FF95">Leave Date</th>

																				<th bgcolor="#95FF95">Total Date</th>

																		</thead>
																		<?
																				$sql_leave = "select paycode,iworkdate,empno,leave_bypass_day from  tbleave_transaction_bypass where paycodeyear='$paycodeyear' and empno='$empno'";
																				$res_leave = mssql_query($sql_leave);
																				while ($row_leave = mssql_fetch_array($res_leave)) {
																					$leavestartdate = $row_leave["iworkdate"];
																					$paycode_bypass = $row_leave["paycode"];
																					$leavetotal = $row_leave["leave_bypass_day"];
																				
																					?>
																			<tr>
																				<th><?= $paycode_bypass ?></th>
																				<th><?= $leavestartdate ?></th>

																				<th><?= $leavetotal ?></th>

																			</tr>
																		<?
																				}
																				?>
																	</table>
																</td>
															</tr>
														</table>



													</td>
												</tr>
												<tr>
													<td colspan="6">
														<table width="100%" border="0" cellspacing="0" cellpadding="0">
															<tr>
																<td width="50%" valign="top">
																	<font color="#FF0000">ข้อมูลขาดงานในรอบนี้</font>
																	<table class='table table-bordered' width="50%">
																		<thead>
																			<tr>
																				<th bgcolor="#FF9900">Paycode</th>
																				<th bgcolor="#FF9900"> Date</th>
																				<th bgcolor="#FF9900">Status</th>
																				<th bgcolor="#FF9900">ข้อมูลการลา</th>
																				<th bgcolor="#FF9900">Close</th>
																		</thead>
																		<?

																				$select_no = "SELECT *,
	convert(varchar, iworkdate, 101)as  iworkdatedate FROM    tbatt_approve where empno='$empno' and paycode='$paycode' 
	and status_noatt_deduct in ('New','deduct','Close') order by iworkdate asc ";
																				$res_no = mssql_query($select_no);
																				while ($row_no = mssql_fetch_array($res_no)) {


																					$sql_leave = "select reasons,headapprove from tbleave_transaction where 
 empno='$empno' and '" . $row_no['iworkdate'] . "'
  between leavestartdate and leaveenddate and statusapprove='Approve'";
																					$reasons = '';
																					$res_leave = mssql_query($sql_leave);
																					$row_leave = mssql_fetch_array($res_leave);
																					$reasons = lang_thai_from_database($row_leave["reasons"]);
																					$headapprove = lang_thai_from_database($row_leave["headapprove"]);
																					?>
																			<tr>
																				<td align="center"><?= $row_no['paycode'] ?></td>
																				<td align="center"><?= $row_no['iworkdatedate'] ?></td>
																				<td align="center"><?
																												if ($row_no['status_noatt_deduct'] == 'New') {
																													echo "New";
																												}
																												if ($row_no['status_noatt_deduct'] == 'deduct') {
																													echo "หักเงินแล้ว";
																												}
																												if ($row_no['status_noatt_deduct'] == 'Close') {
																													echo "Close";
																												}
																												?></td>
																				<td align="center"><?= $reasons ?></td>
																				<td align="center"><?
																												if ($reasons != '') {
																													?><input type="button" value="Close" onClick="close_job_no_att('<?= $row_no['id'] ?>');"><?
																													}
																													?></td>
																			</tr>
																		<?

																				}
																				?>
																	</table>
																</td>
																<td width="50%" valign="top">
																	<font color="#FF0000"> ข้อมูลขาดงานทั้งหมดที่ยังไม่ Close</font>
																	<table class='table table-bordered' width="50%">
																		<thead>
																			<tr>
																				<th bgcolor="#FFCC00">Paycode</th>
																				<th bgcolor="#FFCC00"> Date</th>
																				<th bgcolor="#FFCC00">Status</th>
																				<th bgcolor="#FFCC00">ข้อมูลการลา</th>
																				<th bgcolor="#FFCC00">Close</th>
																		</thead>
																		<?

																				$select_no = "SELECT *,
	convert(varchar, iworkdate, 101)as  iworkdatedate FROM    tbatt_approve where empno='$empno' and paycode<>'$paycode' 
	and status_noatt_deduct in ('New','deduct') order by iworkdate asc ";
																				$res_no = mssql_query($select_no);
																				while ($row_no = mssql_fetch_array($res_no)) {


																					$sql_leave = "select reasons,headapprove from tbleave_transaction where 
 empno='$empno' and '" . $row_no['iworkdate'] . "'
  between leavestartdate and leaveenddate and statusapprove='Approve'";
																					$reasons = '';
																					$res_leave = mssql_query($sql_leave);
																					$row_leave = mssql_fetch_array($res_leave);
																					$reasons = lang_thai_from_database($row_leave["reasons"]);
																					$headapprove = lang_thai_from_database($row_leave["headapprove"]);
																					?>
																			<tr>
																				<td align="center"><?= $row_no['paycode'] ?></td>
																				<td align="center"><?= $row_no['iworkdatedate'] ?></td>
																				<td align="center"><?
																												if ($row_no['status_noatt_deduct'] == 'New') {
																													echo "New";
																												}
																												if ($row_no['status_noatt_deduct'] == 'deduct') {
																													echo "หักเงินแล้ว";
																												}
																												if ($row_no['status_noatt_deduct'] == 'Close') {
																													echo "Close";
																												}
																												?></td>
																				<td align="center"><?= $reasons ?></td>
																				<td align="center"><?
																												if ($reasons != '') {
																													?><input type="button" value="Close" onClick="close_job_no_att('<?= $row_no['id'] ?>');"><?
																													}
																													?></td>
																			</tr>
																		<?

																				}
																				?>
																	</table>




																</td>
															</tr>
														</table>



													</td>
												</tr>

												<tr>
													<td>ลาพักร้อน</td>
													<td align="center"><?= $total_anual_day ?> </td>
													<td colspan="2" align="center">วัน</td>
													<td></td>
													<td>&nbsp;</td>
												</tr>
												<tr>
													<td>ขาดงาน</td>
													<td align="center"><?= $total_absent_day ?> </td>
													<td colspan="2" align="center">วัน</td>
													<td></td>
													<td>&nbsp;</td>
												</tr>
												<tr>
													<td align="left">ค่าข้าว</td>
													<td align="center">50.00 </td>
													<td colspan="2" align="center">บาทต่อวัน</td>
													<td align="center"></td>
													<td align="center"></td>
												</tr>
												<tr>
													<td align="left">ค่ารถ</td>
													<td align="center">25.00 </td>
													<td colspan="2" align="center">บาทต่อวัน</td>
													<td align="center"></td>
													<td align="center"></td>
												</tr>

												<tr>
													<td></td>
													<td align="center"></td>
													<td colspan="2" align="center"></td>
													<td></td>
													<td>&nbsp;</td>
												</tr>
												<tr>
													<td>วันเกิดพนักงานและครอบครัว</td>
													<td align="center"><input type="text" id="hbd" value="<?= $hbd ?>" class="form-control"></td>
													<td colspan="2" align="center"></td>
													<td></td>
													<td>&nbsp;</td>
												</tr>
												<tr>
													<td>โบนัส</td>
													<td align="center"><input type="text" id="bonus" value="<?= $bonus ?>" class="form-control"></td>
													<td colspan="2" align="center"></td>
													<td></td>
													<td>&nbsp;</td>
												</tr>
												<tr>
													<td>ตกเบิก</td>
													<td align="center"><input type="text" id="other" value="<?= $other ?>" class="form-control"></td>
													<td colspan="2" align="center"></td>
													<td></td>
													<td>&nbsp;</td>
												</tr>

												<tr>
													<td>ขาดงาน</td>
													<td align="center"><input type="text" id="absent" value="<?

												if ($total_absent > 0) {
													echo number_format($total_absent, 2, '.', '');
												} else {
													echo 0;
												}
												?>" class="form-control"></td>
													<td colspan="2" align="center">(<?= $total_absent ?>)</td>
													<td></td>
													<td>&nbsp;</td>
												</tr>
												<tr>
													<td>ลากิจ</td>
													<td align="center"><input type="text" id="personal_leave" value="<?
										if ($emptype == 'employee') {
											if ($total_bypass_personal_leave > 0) {
												$total_personal_leave = $total_personal_leave - $total_bypass_personal_leave;
											}
										// bypass personal leave 3 day per year
											if ($total_personal_leave > 0) {
												echo number_format($total_personal_leave, 2, '.', '');
												} else {
											echo 0;
											}
										} else {
											echo 0;
										}
										?>" class="form-control"></td>
												<td colspan="2" align="center">(<?= $total_personal_leave ?>)</td>
												<td></td>
												<td>&nbsp;</td>
												</tr>
												<tr>
													<td>No attendance data</td>
													<td align="center"><input type="text" id="no_attendance" value="<?
																															$no_attendance = $total_no_attendance * $leave_rate_emp;
																															echo number_format($no_attendance, 2, '.', '');
																															?>" class="form-control"></td>
													<td colspan="2" align="center">(<? echo number_format($no_attendance, 2, '.', ''); ?>)</td>
													<td></td>
													<td>&nbsp;</td>
												</tr>
												<tr>
													<td>ลาไม่ได้รับเงินเดือน</td>
													<td align="center"><input type="text" id="leave_without_pay" value="<?= $leave_without_pay ?>" class="form-control"></td>
													<td colspan="2" align="center"></td>
													<td></td>
													<td>&nbsp;</td>
												</tr>
												<tr>
													<td>หักอื่นๆ</td>
													<td align="center"><input type="text" id="other_deduct" value="<?= $other_deduct ?>" class="form-control"></td>
													<td colspan="2" align="center"><input type="button" value="Save Update" onClick="upadtehbd('<?= $empno ?>','<?= $paycode ?>');"></td>
													<td></td>
													<td>&nbsp;</td>
												</tr>
												<tr>
													<td></td>
													<td align="center"></td>
													<td colspan="2" align="center"></td>
													<td></td>
													<td>&nbsp;</td>
												</tr>
												<tr>
													<td align="left">โอที</td>
													<td align="center"><?= number_format($ot_rate_emp, 2, '.', ''); ?></td>
													<td colspan="2" align="center">บาท ต่อ ชั่วโมง</td>
													<td align="center">8</td>
													<td align="center">ชั่วโมง ต่อ วัน</td>
												</tr>
												<tr>
													<td align="center" bgcolor="#CCCCCC"></td>
													<td align="center" bgcolor="#CCCCCC">ชั่วโมงทำงาน</td>
													<td width="101" align="center" bgcolor="#CCCCCC"></td>
													<td width="65" align="center" bgcolor="#CCCCCC"></td>
													<td align="center" bgcolor="#CCCCCC">ชั่วโมงทำงาน คูณ OT</td>
													<td align="center" bgcolor="#CCCCCC">&nbsp;</td>
												</tr>
												<tr>
													<td align="left">OT 1</td>
													<td align="center"><?= $total_ot1 ?></td>
													<td align="center">ชั่วโมง</td>
													<td align="right">คิดเป็น</td>
													<td align="center"><?= $total_ot1 * 1 ?></td>
													<td align="center">ชั่วโมง</td>
												</tr>
												<tr>
													<td align="left">OT 1.5</td>
													<td align="center"><?= $total_ot1_5 ?></td>
													<td align="center">ชั่วโมง</td>
													<td align="right">คิดเป็น</td>
													<td align="center"><?= $total_ot1_5 * 1.5 ?></td>
													<td align="center">ชั่วโมง</td>
												</tr>
												<tr>
													<td align="left">OT 2</td>
													<td align="center"><?= $total_ot2 ?></td>
													<td align="center">ชั่วโมง</td>
													<td align="right">คิดเป็น</td>
													<td align="center"><?= $total_ot2 * 2 ?></td>
													<td align="center">ชั่วโมง</td>
												</tr>
												<tr>
													<td align="left">OT 3</td>
													<td align="center"><?= $total_ot3 ?></td>
													<td align="center"></td>
													<td align="right">คิดเป็น</td>
													<td align="center"><?= $total_ot3 * 3 ?></td>
													<td align="center">ชั่วโมง</td>
												</tr>
												<tr>
													<td align="left">&nbsp;</td>
													<td align="center">&nbsp;</td>
													<td align="center">&nbsp;</td>
													<td align="right">รวม</td>
													<td align="center">
														<?
							echo ($total_ot1 * 1) + ($total_ot1_5 * 1.5) + ($total_ot2 * 2) + ($total_ot3 * 3);
																?>
													</td>
													<td align="center">&nbsp;</td>
												</tr>
												<tr>
													<td align="left">เงินเดือน / ค่าแรง</td>
													<td align="center">
														<font color="#0000FF">
															<?
																	if ($emptype == 'employee') {
																		$total_wage = 0;
																	//	echo $basic_salary;
																	$basic_salary = $s_salary;
																	    echo number_format($s_salary, 2, '.', '');
																	} else {

																		//echo "( " . $basic_wage . " x  ";
																		//echo $total_working_day + $total_sick_day;
																		//\echo $total_day+$total_sick_day;

																		//echo " ) = ";
																		$total_wage = $s_salary;
																		//	$total_wage = $basic_wage*($total_day+$total_sick_day);
																		 echo number_format($total_wage, 2, '.', '');
																		
																	}

																	?>
														</font>
													</td>
													<td align="center">บาท</td>
													<td align="right">&nbsp;</td>
													<td align="center">&nbsp;</td>
													<td align="center">&nbsp;</td>
												</tr>
												<tr>
													<td align="left">เงินค่า OT</td>
													<td align="center">
														<font color="#0000FF"><?= $total_ot ?></font>
													</td>
													<td align="center">บาท</td>
													<td align="right">&nbsp;</td>
													<td align="center">&nbsp;</td>
													<td align="center">&nbsp;</td>
												</tr>
												<tr>
													<td align="left">ค่ากะ</td>
													<td align="center">
														<font color="#0000FF"><?= $total_shift_val ?></font>
													</td>
													<td align="center">บาท</td>
													<td></td>
													<td></td>
													<td align="center">&nbsp;</td>
												</tr>
												<tr>
													<td align="left">ค่าข้าว ค่ารถ</td>
													<td align="center">
														<font color="#0000FF"><?= $total_car_rice ?></font>
													</td>
													<td align="center">บาท</td>
													<td></td>
													<td></td>
													<td align="center">&nbsp;</td>
												</tr>
												<tr>
													<td align="left">ค่า FL</td>
													<td align="center">
														<font color="#0000FF"><?= $total_fl ?></font>
													</td>
													<td align="center">บาท</td>
													<td></td>
													<td></td>
													<td align="center">&nbsp;</td>
												</tr>
												<tr>
													<td align="left">เบี้ยขยัน</td>
													<td align="center">
														<font color="#0000FF">
															<?
															if ($satt_reward_old == '') {
																		$satt_reward_old = 0;
																	}
															if($extra_salary==1){
																echo "old =" . $satt_reward_old;
																$satt_reward = 0;
																echo "/now = ".$satt_reward." (stop pay)";
															}else{
																	
																	if ($paystatus == 'paid') {
																		echo "old =" . $satt_reward_old;
																		echo "/now =" . $satt_reward;
																	} else {

																		echo "old =" . $att_reward;
																		$satt_reward_old = $att_reward;
																		
																		if ($total_anual_day > 0) {
																			$total_working_day = $total_working_day + $total_anual_day;
																		}
																		if ($total_sick_day == 0 && $total_personal_day == 0 && $total_absent_day == 0 && $total_late == 0 && $total_day != 0 && ($total_working_day >= $total_working_day_standard)) {

																			if ($att_reward == 0) {
																				$satt_reward = 500;
																			} else if ($att_reward == 500) {
																				$satt_reward = 600;
																			} else if ($att_reward == 600) {
																				$satt_reward = 700;
																			} else if ($att_reward == 700) {
																				$satt_reward = 700;
																			}
																		} else {
																			$satt_reward = 0;
																		}
																	}

																	if ($total_working_day > $total_day) {
																		$satt_reward = 0;
																		echo "/now =" . $satt_reward;
																	} else {
																		echo "/now =" . $satt_reward;
																	}
																	
															}
																	

																	




																	?>
														</font>
													</td>
													<td align="center">บาท</td>
													<td></td>
													<td></td>
													<td align="center">&nbsp;</td>
												</tr>
												<tr>
													<td width="194">ค่าทักษะ</td>
													<td align="center">
														<font color="#0000FF"><? 
										if($total_leave_without_pay_day>13 && $total_leave_without_pay_day<=15){
															$s_skill_reward = $s_skill_reward/2;
															}else if($total_leave_without_pay_day>15){
																$s_skill_reward = 0;
																}
												
														echo number_format($s_skill_reward , 2, '.', ''); 
														?></font>
													</td>
													<td align="center">บาท</td>
													<td></td>
													<td align="center">&nbsp;</td>
													<td align="center">&nbsp;</td>
												</tr>
												<tr>
													<td width="194">วันเกิดพนักงานและครอบครัว</td>
													<td align="center">
														<font color="#0000FF"><?= $hbd ?></font>
													</td>
													<td align="center">บาท</td>
													<td></td>
													<td align="center">&nbsp;</td>
													<td align="center">&nbsp;</td>
												</tr>
												<tr>
													<td width="194">โบนัส</td>
													<td align="center">
														<font color="#0000FF"><?= $bonus ?></font>
													</td>
													<td align="center">บาท</td>
													<td></td>
													<td align="center">&nbsp;</td>
													<td align="center">&nbsp;</td>
												</tr>
												<tr>
													<td width="194">ตกเบิก</td>
													<td align="center">
														<font color="#0000FF"><?= $other ?></font>
													</td>
													<td align="center">บาท</td>
													<td></td>
													<td align="center">&nbsp;</td>
													<td align="center">&nbsp;</td>
												</tr>
												<tr>
													<td width="194"></td>
													<td align="center"></td>
													<td align="center"></td>
													<td></td>
													<td></td>
													<td align="center">&nbsp;</td>
												</tr>
												<tr>
													<td align="left">รวมเงินเดือน</td>
													<td align="center">
														<?
																//+$skill_reward
										if ($emptype == 'employee') {
					
					
					//echo "s_salary=$s_salary<BR>";
//					echo "hbd=$hbd<BR>";	
//					echo "satt_reward=$satt_reward<BR>";	
//					echo "other=$other<BR>";	
//					echo "bonus=$bonus<BR>";	
//					echo "s_skill_reward=$s_skill_reward<BR>";		
					//$total_total = $total_total + $s_salary + $hbd + $satt_reward + $other + $bonus + $s_skill_reward;
		$total_total =	$s_salary+$hbd+$satt_reward+$other+$bonus+$s_skill_reward+$total_ot+$total_shift_val+$total_car_rice+$total_fl;					
				
																	echo number_format($total_total , 2, '.', ''); 
																} else {
																	
																	$total_total = 	$total_wage + $total_ot + $total_shift_val + $total_car_rice + $total_fl + $satt_reward + $skill_reward + $hbd + $bonus +				$other;
																	echo number_format($total_total , 2, '.', ''); 
																	
																}
																?>
													</td>
													<td align="center">บาท</td>
													<td></td>
													<td></td>
													<td align="center">&nbsp;</td>
												</tr>
												<tr>
													<td align="left">หักขาดงาน</td>
													<td align="center">
														<font color="#FF0000">
															<?
																	if ($emptype == 'employee') {
																		echo $absent;
																	} else {
																		echo 0;
																	}
																	if ($absent > 0) {
																		$absent =  number_format($absent, 2, '.', '');
																	}
																	?>
														</font>
													</td>
													<td align="center">บาท</td>
													<td></td>
													<td></td>
													<td align="center">&nbsp;</td>
												</tr>
												<tr>
													<td align="left">หักลากิจ</td>
													<td align="center">
														<font color="#FF0000">
															<?
																	if ($emptype == 'employee') {
																		echo $total_personal_leave;
																	} else {
																		echo 0;
																	}
																	?>
														</font>
													</td>
													<td align="center">บาท</td>
													<td></td>
													<td></td>
													<td align="center">&nbsp;</td>
												</tr>

												<tr>
													<td align="left">หัก No attendance</td>
													<td align="center">
														<font color="#FF0000">
															<?
																	echo number_format($no_attendance, 2, '.', '');
																	$no_attendance = number_format($no_attendance, 2, '.', '');
																	?>
														</font>
													</td>
													<td align="center">บาท</td>
													<td></td>
													<td></td>
													<td align="center">&nbsp;</td>
												</tr>
												<tr>
													<td align="left">หักลาไม่ได้รับเงินเดือน</td>
													<td align="center">
														<font color="#FF0000"><?= $leave_without_pay ?></font>
													</td>
													<td align="center">บาท</td>
													<td></td>
													<td></td>
													<td align="center">&nbsp;</td>
												</tr>
												<tr>
													<td align="left">หักอื่นๆ</td>
													<td align="center">
														<font color="#FF0000"><?= $other_deduct ?></font>
													</td>
													<td align="center">บาท</td>
													<td></td>
													<td></td>
													<td align="center">&nbsp;</td>
												</tr>
												<tr>
													<td align="left">หักประกันสังคม</td>
													<td align="center">
														<font color="#FF0000">
															<?
																	if ($emptype == 'employee') {
														//$social_in = ($s_salary + $s_skill_reward) * .01;
														//$social_in = ($s_salary + $s_skill_reward) * .05;
														$social_in = ($s_salary + $s_skill_reward) * $social_in_calc;
														
																	} else {
														$social_in =($total_day*$basic_wage)*$social_in_calc;
																		//$social_in =($total_day*$basic_wage)*0.05;
																		//$social_in = $total_wage * 0.01;
																	}

																	if ($social_in > 0) {
																		if ($social_in > 750) {
																			$social_in = 750;
																		}
																		$social_in =  number_format($social_in, 2, '.', '');
																	}

																	?><?= $social_in ?></font>
													</td>
													<td align="center">บาท</td>
													<td></td>
													<td></td>
													<td align="center">&nbsp;</td>
												</tr>
												<tr>
													<td align="left">&nbsp;</td>
													<td align="center"></td>
													<td align="center">&nbsp;</td>
													<td></td>
													<td>เงินได้สะสม</td>
													<td align="center">
														<?
																echo $ytd_income;
																?>
													</td>
												</tr>
												<tr>
													<td align="left">คงเหลือเงินเดือน</td>
													<td align="center"><strong>
															<font color="#66CC66">
																<?
																		if ($emptype == 'employee') {
																			$total_salary = ($total_total) - $social_in - $absent - $total_personal_leave - $leave_without_pay - $other_deduct - $no_attendance;
																		} else {
																			$total_salary = ($total_total + $s_skill_reward) - $social_in - $leave_without_pay - $other_deduct - $no_attendance;
																		}

																		echo number_format($total_salary, 2, '.', '');															//echo $total_salary;
																		?>
															</font>
														</strong></td>
													<td align="center">บาท</td>
													<td>&nbsp;</td>
													<td>ประกันสังคมสะสม</td>
													<td align="center">
														<?
																echo $ytd_social_in;
																?>
													</td>
												</tr>
											</table>
									<?



											$att_reward = 0;



											// update total day + sick leave day
											$total_day = $total_day + $total_sick_day;
											// insert & update salary table
											$selects = "SELECT paystatus,empno from tbsalary where empno='$empno' and paycode='$paycode' ";
											$res = mssql_query($selects);
											$nums = mssql_num_rows($res);
											$rows = mssql_fetch_array($res);
											// echo $selects;
											if ($nums > 0) {


												if ($rows['paystatus'] == 'paid') { 
												
												} else {

													$sqlupdate = "update  tbsalary set total_basic_salary=$basic_salary,total_day=$total_day, total_car_rice=$total_car_rice, total_normal_day=$total_normal_day, total_wage=$total_wage, total_ot1=$total_ot1, total_ot1_5=$total_ot1_5, total_ot2=$total_ot2, total_ot3=$total_ot3,total_ot=$total_ot, att_reward=$satt_reward,att_reward_old=$satt_reward_old, social_in=$social_in, skill_reward=$s_skill_reward,total_shift_val=$total_shift_val, total_salary=$total_salary,total_fl=$total_fl,subtotal_salary=$total_total,hbd=$hbd,other=$other,bonus=$bonus,absent=$absent,personal_leave=$total_personal_leave,leave_without_pay=$leave_without_pay,other_deduct=$other_deduct,no_attendance=$no_attendance where empno='$empno' and paycode='$paycode' ";

													//echo $sqlupdate;
													mssql_query($sqlupdate);
												}
											} else {
												
//total_basic_salary=$basic_salary												//absent=$absent,personal_leave=$personal_leave,leave_without_pay=$leave_without_pay,other_deduct=$other_deduct
												$sqlinsert = "insert into tbsalary(empno, paycode, total_day, total_car_rice, total_normal_day, total_wage, total_ot1, total_ot1_5, total_ot2, total_ot3,total_ot, att_reward_old,att_reward, social_in, skill_reward,total_shift_val, total_salary,total_fl,subtotal_salary,paycodeyear,hbd,other,absent,personal_leave,leave_without_pay,other_deduct,bonus,no_attendance,total_basic_salary) values('$empno', '$paycode', $total_day, $total_car_rice, $total_normal_day, $total_wage, $total_ot1, $total_ot1_5, $total_ot2, $total_ot3,$total_ot, $satt_reward_old,$satt_reward, $social_in, $s_skill_reward, $total_shift_val,$total_salary,$total_fl,$total_total,'$paycodeyear',$hbd,$other,$absent,$personal_leave,$leave_without_pay,$other_deduct,$bonus,$no_attendance,$basic_salary)";
												//	echo $sqlinsert;
												mssql_query($sqlinsert);
											}
										
										
										
											
					}else{
						
					
					

												// select summary 
												$selectp = "SELECT ytd_income, ytd_tax, ytd_social_in from tbytdsummary where empno='$empno' and paycodeyear='$paycodeyear'  ";
												$rep = mssql_query($selectp);

												$nump = mssql_num_rows($rep);
												if ($nump > 0) {
													$rowp = mssql_fetch_array($rep);
													$ytd_income =  $rowp['ytd_income'];
													$ytd_tax =  $rowp['ytd_tax'];
													$ytd_social_in =  $rowp['ytd_social_in'];
												} else {
													$ytd_income =  0;
													$ytd_tax =  0;
													$ytd_social_in =  0;
												}


												$selecth = "SELECT bonus,other,paystatus,att_reward_old, att_reward,position_val, mte_val, travel_val, mobile_val,hbd,leave_without_pay,personal_leave,absent,other_deduct,no_attendance from tbsalary where empno='$empno' and paycode='$paycode' ";
												$reh = mssql_query($selecth);
												$rowh = mssql_fetch_array($reh);
												$hbd = $rowh['hbd'];
												$satt_reward_old = $rowh['att_reward_old'];
												$satt_reward = $rowh['att_reward'];
												$position_val = $rowh['position_val'];
												$mte_val = $rowh['mte_val'];
												$travel_val = $rowh['travel_val'];
												$mobile_val = $rowh['mobile_val'];
												$leave_without_pay = $rowh['leave_without_pay'];
												$no_attendance = $rowh['no_attendance'];
												$personal_leave = $rowh['personal_leave'];
												$absent = $rowh['absent'];
												$other_deduct = $rowh['other_deduct'];
												$paystatus = $rowh['paystatus'];
												$other = $rowh['other'];
												$bonus = $rowh['bonus'];
												if ($hbd == '') {
													$hbd = 0;
												}
												if ($personal_leave == '') {
													$personal_leave = $total_personal_leave;
												}

												if ($personal_leave > 0) {
													$personal_leave =  number_format($personal_leave, 2, '.', '');
												}
												if ($absent == '') {
													$absent = $total_absent;
												}
												if ($leave_without_pay == '') {
													$leave_without_pay = 0;
												}
												if ($no_attendance == '') {
													$no_attendance = 0;
												}
												if ($other_deduct == '') {
													$other_deduct = 0;
												}
												if ($other == '') {
													$other = 0;
												}
												if ($bonus == '') {
													$bonus = 0;
												}





												?>
											<table align="center" width="70%" border="1" cellspacing="0" cellpadding="0">

												<tr>
													<td width="194" bgcolor="#CCCCCC" colspan="2">
														<?
											echo " | วันเริ่มงาน $startdate2";
											echo " | วันที่ปัจจุบัน $today";
											echo " | อายุงาน $u_y   ปี    $u_m เดือน      $u_d  วัน<br><br>";
											echo $work_age_day = DateDiff($startdate2, $today);
																?>
													</td>

													<td colspan="2" align="center" bgcolor="#CCCCCC">&nbsp;</td>
													<td width="119" bgcolor="#CCCCCC">&nbsp;</td>
													<td width="119" align="center" bgcolor="#CCCCCC"> <a href="javascript:void(0);" onclick="printslip('<?= $empno ?>','<?= $paycode ?>','<?= $paycodeyear ?>');" class="btn-primary btn" style="background-color:#16a085;"><i class="fa fa-print"></i> Print Slip</a></td>
												</tr>
												<tr>
													<td>Salary / Wage</td>
													<td align="center">
														<?
																if ($emptype == 'employee') {
																	echo $basic_salary;
																} else {
																	echo $basic_wage;
																}
																?>
													</td>
													<td colspan="2" align="center"></td>
													<td>Shift Day</td>
													<td><?= $total_day_day ?> วัน</td>
												</tr>
												<tr>
													<td>มาทำงาน</td>
													<td align="center"><?= $total_day ?> </td>
													<td colspan="2" align="center">วัน</td>
													<td>Shift Night</td>
													<td><?= $total_day_night ?> วัน</td>
												</tr>

												<tr>
													<td>มาสาย</td>
													<td align="center"><?= $total_late ?> </td>
													<td colspan="2" align="center">วัน</td>
													<td>Total Working Day</td>
													<td><?= $total_working_day ?>วัน จาก Standard <?= $total_working_day_standard ?></td>
												</tr>

												<tr>
													<td>
														<font color="#FF0000">No attendance data</font>
													</td>
													<td align="center"><?= $total_no_attendance ?> </td>
													<td colspan="2" align="center">วัน</td>
													<td></td>
													<td></td>
												</tr>

												<tr>
													<td>ลาป่วย</td>
													<td align="center"><?= $total_sick_day ?> </td>
													<td colspan="2" align="center">วัน</td>
													<td></td>
													<td>&nbsp;</td>
												</tr>
                                                
                                                <tr>
													<td>ลาไม่ได้รับเงินเดือน</td>
													<td align="center"><?
                                                    echo $total_leave_without_pay_day;
													if($total_leave_without_pay_day>0){
																if ($emptype == 'employee') {
																	//echo $basic_salary;
									$leave_without_pay = ($basic_salary/30)*$total_leave_without_pay_day;
																} else {
									$leave_without_pay = $basic_wage*$total_leave_without_pay_day;
																	//echo $basic_wage;
																}
														}
													//	echo $total_leave_without_pay;
													?> </td>
													<td colspan="2" align="center">วัน</td>
													<td>&nbsp;</td>
												  <td></td>
												</tr>
												<tr>
													<td>ลากิจ</td>
													<td align="center"><?= $total_personal_day ?> </td>
													<td colspan="2" align="center">วัน</td>
													<td align="center">
														<!--ลาป่วยต่อปี--><button class='btn btn-info btn-sm' onclick="modal_personal_leave('<?= $paycode ?>','<?= $empno ?>')">ดูลากิจทั้งปี</button></td>
													<td>&nbsp;</td>
												</tr>
												<tr>
													<td colspan="6">
														<table width="100%" border="0" cellspacing="0" cellpadding="0">
															<tr>
																<td width="50%" valign="top"> ข้อมูลลากิจในรอบนี้
																	<table class='table table-bordered' width="50%">
																		<thead>
																			<th bgcolor="#FFFFCC">Start Date</th>
																			<th bgcolor="#FFFFCC">End Date</th>
																			<th bgcolor="#FFFFCC">Total Date</th>
																			<th bgcolor="#FFFFCC">Reason</th>
																			<th bgcolor="#FFFFCC">Approve By</th>
																		</thead>
																		<?



					$sql_leave = "SELECT leaveid,convert(varchar, leavestartdate, 103)as leavestartdate_date,
					convert(varchar, leaveenddate, 103)as leaveenddate_date,
					reasons,headapprove,leavetotal,* FROM tbleave_transaction  WHERE leaveenddate between '$startdate' and '$enddate' AND leavetypeid='L0002' AND empno='$empno' AND statusapprove='Approve' order by leavestartdate asc";
					$res_leave = mssql_query($sql_leave);
					while ($row_leave = mssql_fetch_array($res_leave)) {
							$leavestartdate = $row_leave["leavestartdate_date"];
							$leaveenddate = $row_leave["leaveenddate_date"];
							$leavetotal = $row_leave["leavetotal"];
						//	$leavetotal++;
							$reasons = lang_thai_from_database($row_leave["reasons"]);
							$headapprove = lang_thai_from_database($row_leave["headapprove"]);
							
							
					?>
																			<tr>
																				<td><?= $leavestartdate ?></td>
																				<td><?= $leaveenddate ?></td>
																				<td><?
																								
																								//$leavetotal = 0;
//																								$sql_leave0 = "	SELECT * FROM   tbatt_approve where empno='$empno' and paycode='$paycode'
//	 and iworkdate between '" . $row_leave['leavestartdate'] . "' 
//	and '" . $row_leave['leaveenddate'] . "' order by iworkdate asc";
//																								//echo $sql_leave0;
//																								$re_leave0 = mssql_query($sql_leave0);
//																								while ($row_leave0 = mssql_fetch_array($re_leave0)) {
//																									$leavetotal++;
//																								}
																								echo $leavetotal;

																								?></td>
																				<td><?= $reasons ?></td>
																				<td><?= $headapprove ?></td>
																			</tr>
																		<?
																				}
																				?>
																	</table>
																</td>
																<td width="50%" valign="top">ข้อมูล bypass ลากิจของปีนี้ทั้งหมด
																	<table class='table table-bordered' width="50%">
																		<thead>
																			<tr>
																				<th bgcolor="#95FF95">Paycode</th>
																				<th bgcolor="#95FF95">Leave Date</th>

																				<th bgcolor="#95FF95">Total Date</th>

																		</thead>
																		<?
																				$sql_leave = "select paycode,iworkdate,empno,leave_bypass_day from  tbleave_transaction_bypass where paycodeyear='$paycodeyear' and empno='$empno'";
																				$res_leave = mssql_query($sql_leave);
																				while ($row_leave = mssql_fetch_array($res_leave)) {
				$leavestartdate = $row_leave["iworkdate"];
				$paycode_bypass = $row_leave["paycode"];
				$leavetotal = $row_leave["leave_bypass_day"];
																				
																					?>
																			<tr>
																				<th><?= $paycode_bypass ?></th>
																				<th><?= $leavestartdate ?></th>

																				<th><?= $leavetotal ?></th>

																			</tr>
																		<?
																				}
																				?>
																	</table>
																</td>
															</tr>
														</table>



													</td>
												</tr>
												<tr>
													<td colspan="6">
														<table width="100%" border="0" cellspacing="0" cellpadding="0">
															<tr>
																<td width="50%" valign="top">
																	<font color="#FF0000">ข้อมูลขาดงานในรอบนี้</font>
																	<table class='table table-bordered' width="50%">
																		<thead>
																			<tr>
																				<th bgcolor="#FF9900">Paycode</th>
																				<th bgcolor="#FF9900"> Date</th>
																				<th bgcolor="#FF9900">Status</th>
																				<th bgcolor="#FF9900">ข้อมูลการลา</th>
																				<th bgcolor="#FF9900">Close</th>
																		</thead>
																		<?

																				$select_no = "SELECT *,
	convert(varchar, iworkdate, 101)as  iworkdatedate FROM    tbatt_approve where empno='$empno' and paycode='$paycode' 
	and status_noatt_deduct in ('New','deduct','Close') order by iworkdate asc ";
																				$res_no = mssql_query($select_no);
																				while ($row_no = mssql_fetch_array($res_no)) {


																					$sql_leave = "select reasons,headapprove from tbleave_transaction where 
 empno='$empno' and '" . $row_no['iworkdate'] . "'
  between leavestartdate and leaveenddate and statusapprove='Approve'";
																					$reasons = '';
																					$res_leave = mssql_query($sql_leave);
																					$row_leave = mssql_fetch_array($res_leave);
																					$reasons = lang_thai_from_database($row_leave["reasons"]);
																					$headapprove = lang_thai_from_database($row_leave["headapprove"]);
																					?>
																			<tr>
																				<td align="center"><?= $row_no['paycode'] ?></td>
																				<td align="center"><?= $row_no['iworkdatedate'] ?></td>
																				<td align="center"><?
																												if ($row_no['status_noatt_deduct'] == 'New') {
																													echo "New";
																												}
																												if ($row_no['status_noatt_deduct'] == 'deduct') {
																													echo "หักเงินแล้ว";
																												}
																												if ($row_no['status_noatt_deduct'] == 'Close') {
																													echo "Close";
																												}
																												?></td>
																				<td align="center"><?= $reasons ?></td>
																				<td align="center"><?
																												if ($reasons != '') {
																													?><input type="button" value="Close" onClick="close_job_no_att('<?= $row_no['id'] ?>');"><?
																													}
																													?></td>
																			</tr>
																		<?

																				}
																				?>
																	</table>
																</td>
																<td width="50%" valign="top">
																	<font color="#FF0000"> ข้อมูลขาดงานทั้งหมดที่ยังไม่ Close</font>
																	<table class='table table-bordered' width="50%">
																		<thead>
																			<tr>
																				<th bgcolor="#FFCC00">Paycode</th>
																				<th bgcolor="#FFCC00"> Date</th>
																				<th bgcolor="#FFCC00">Status</th>
																				<th bgcolor="#FFCC00">ข้อมูลการลา</th>
																				<th bgcolor="#FFCC00">Close</th>
																		</thead>
																		<?

																				$select_no = "SELECT *,
	convert(varchar, iworkdate, 101)as  iworkdatedate FROM    tbatt_approve where empno='$empno' and paycode<>'$paycode' 
	and status_noatt_deduct in ('New','deduct') order by iworkdate asc ";
																				$res_no = mssql_query($select_no);
																				while ($row_no = mssql_fetch_array($res_no)) {


																					$sql_leave = "select reasons,headapprove from tbleave_transaction where 
 empno='$empno' and '" . $row_no['iworkdate'] . "'
  between leavestartdate and leaveenddate and statusapprove='Approve'";
																					$reasons = '';
																					$res_leave = mssql_query($sql_leave);
																					$row_leave = mssql_fetch_array($res_leave);
																					$reasons = lang_thai_from_database($row_leave["reasons"]);
																					$headapprove = lang_thai_from_database($row_leave["headapprove"]);
																					?>
																			<tr>
																				<td align="center"><?= $row_no['paycode'] ?></td>
																				<td align="center"><?= $row_no['iworkdatedate'] ?></td>
																				<td align="center"><?
																												if ($row_no['status_noatt_deduct'] == 'New') {
																													echo "New";
																												}
																												if ($row_no['status_noatt_deduct'] == 'deduct') {
																													echo "หักเงินแล้ว";
																												}
																												if ($row_no['status_noatt_deduct'] == 'Close') {
																													echo "Close";
																												}
																												?></td>
																				<td align="center"><?= $reasons ?></td>
																				<td align="center"><?
																												if ($reasons != '') {
																													?><input type="button" value="Close" onClick="close_job_no_att('<?= $row_no['id'] ?>');"><?
																													}
																													?></td>
																			</tr>
																		<?

																				}
																				?>
																	</table>




																</td>
															</tr>
														</table>



													</td>
												</tr>

												<tr>
													<td>ลาพักร้อน</td>
													<td align="center"><?= $total_anual_day ?> </td>
													<td colspan="2" align="center">วัน</td>
													<td></td>
													<td>&nbsp;</td>
												</tr>
												<tr>
													<td>ขาดงาน</td>
													<td align="center"><?= $total_absent_day ?> </td>
													<td colspan="2" align="center">วัน</td>
													<td></td>
													<td>&nbsp;</td>
												</tr>
												<tr>
													<td align="left">ค่าข้าว</td>
													<td align="center">50.00 </td>
													<td colspan="2" align="center">บาทต่อวัน</td>
													<td align="center"></td>
													<td align="center"></td>
												</tr>
												<tr>
													<td align="left">ค่ารถ</td>
													<td align="center">25.00 </td>
													<td colspan="2" align="center">บาทต่อวัน</td>
													<td align="center"></td>
													<td align="center"></td>
												</tr>

												<tr>
													<td></td>
													<td align="center"></td>
													<td colspan="2" align="center"></td>
													<td></td>
													<td>&nbsp;</td>
												</tr>
												<tr>
													<td>วันเกิดพนักงานและครอบครัว</td>
													<td align="center"><input type="text" id="hbd" value="<?= $hbd ?>" class="form-control"></td>
													<td colspan="2" align="center"></td>
													<td></td>
													<td>&nbsp;</td>
												</tr>
												<tr>
													<td>โบนัส</td>
													<td align="center"><input type="text" id="bonus" value="<?= $bonus ?>" class="form-control"></td>
													<td colspan="2" align="center"></td>
													<td></td>
													<td>&nbsp;</td>
												</tr>
												<tr>
													<td>ตกเบิก</td>
													<td align="center"><input type="text" id="other" value="<?= $other ?>" class="form-control"></td>
													<td colspan="2" align="center"></td>
													<td></td>
													<td>&nbsp;</td>
												</tr>

												<tr>
													<td>ขาดงาน</td>
													<td align="center"><input type="text" id="absent" value="<?

												if ($total_absent > 0) {
													echo number_format($total_absent, 2, '.', '');
												} else {
													echo 0;
												}
												?>" class="form-control"></td>
													<td colspan="2" align="center">(<?= $total_absent ?>)</td>
													<td></td>
													<td>&nbsp;</td>
												</tr>
												<tr>
													<td>ลากิจ</td>
													<td align="center"><input type="text" id="personal_leave" value="<?
										if ($emptype == 'employee') {
											if ($total_bypass_personal_leave > 0) {
												$total_personal_leave = $total_personal_leave - $total_bypass_personal_leave;
											}
										// bypass personal leave 3 day per year
											if ($total_personal_leave > 0) {
												echo number_format($total_personal_leave, 2, '.', '');
												} else {
											echo 0;
											}
										} else {
											echo 0;
										}
										?>" class="form-control"></td>
												<td colspan="2" align="center">(<?= $total_personal_leave ?>)</td>
												<td></td>
												<td>&nbsp;</td>
												</tr>
												<tr>
													<td>No attendance data</td>
													<td align="center"><input type="text" id="no_attendance" value="<?
																															$no_attendance = $total_no_attendance * $leave_rate_emp;
																															echo number_format($no_attendance, 2, '.', '');
																															?>" class="form-control"></td>
													<td colspan="2" align="center">(<? echo number_format($no_attendance, 2, '.', ''); ?>)</td>
													<td></td>
													<td>&nbsp;</td>
												</tr>
												<tr>
													<td>ลาไม่ได้รับเงินเดือน</td>
													<td align="center"><input type="text" id="leave_without_pay" value="<?= $leave_without_pay ?>" class="form-control"></td>
													<td colspan="2" align="center"></td>
													<td></td>
													<td>&nbsp;</td>
												</tr>
												<tr>
													<td>หักอื่นๆ</td>
													<td align="center"><input type="text" id="other_deduct" value="<?= $other_deduct ?>" class="form-control"></td>
													<td colspan="2" align="center"><input type="button" value="Save Update" onClick="upadtehbd('<?= $empno ?>','<?= $paycode ?>');"></td>
													<td></td>
													<td>&nbsp;</td>
												</tr>
												<tr>
													<td></td>
													<td align="center"></td>
													<td colspan="2" align="center"></td>
													<td></td>
													<td>&nbsp;</td>
												</tr>
												<tr>
													<td align="left">โอที</td>
													<td align="center"><?= number_format($ot_rate_emp, 2, '.', ''); ?></td>
													<td colspan="2" align="center">บาท ต่อ ชั่วโมง</td>
													<td align="center">8</td>
													<td align="center">ชั่วโมง ต่อ วัน</td>
												</tr>
												<tr>
													<td align="center" bgcolor="#CCCCCC"></td>
													<td align="center" bgcolor="#CCCCCC">ชั่วโมงทำงาน</td>
													<td width="101" align="center" bgcolor="#CCCCCC"></td>
													<td width="65" align="center" bgcolor="#CCCCCC"></td>
													<td align="center" bgcolor="#CCCCCC">ชั่วโมงทำงาน คูณ OT</td>
													<td align="center" bgcolor="#CCCCCC">&nbsp;</td>
												</tr>
												<tr>
													<td align="left">OT 1</td>
													<td align="center"><?= $total_ot1 ?></td>
													<td align="center">ชั่วโมง</td>
													<td align="right">คิดเป็น</td>
													<td align="center"><?= $total_ot1 * 1 ?></td>
													<td align="center">ชั่วโมง</td>
												</tr>
												<tr>
													<td align="left">OT 1.5</td>
													<td align="center"><?= $total_ot1_5 ?></td>
													<td align="center">ชั่วโมง</td>
													<td align="right">คิดเป็น</td>
													<td align="center"><?= $total_ot1_5 * 1.5 ?></td>
													<td align="center">ชั่วโมง</td>
												</tr>
												<tr>
													<td align="left">OT 2</td>
													<td align="center"><?= $total_ot2 ?></td>
													<td align="center">ชั่วโมง</td>
													<td align="right">คิดเป็น</td>
													<td align="center"><?= $total_ot2 * 2 ?></td>
													<td align="center">ชั่วโมง</td>
												</tr>
												<tr>
													<td align="left">OT 3</td>
													<td align="center"><?= $total_ot3 ?></td>
													<td align="center"></td>
													<td align="right">คิดเป็น</td>
													<td align="center"><?= $total_ot3 * 3 ?></td>
													<td align="center">ชั่วโมง</td>
												</tr>
												<tr>
													<td align="left">&nbsp;</td>
													<td align="center">&nbsp;</td>
													<td align="center">&nbsp;</td>
													<td align="right">รวม</td>
													<td align="center">
														<?
							echo ($total_ot1 * 1) + ($total_ot1_5 * 1.5) + ($total_ot2 * 2) + ($total_ot3 * 3);
																?>
													</td>
													<td align="center">&nbsp;</td>
												</tr>
												<tr>
													<td align="left">เงินเดือน / ค่าแรง</td>
													<td align="center">
														<font color="#0000FF">
															<?
																	if ($emptype == 'employee') {
																		$total_wage = 0;
																		echo $basic_salary;
																	} else {

																		echo "( " . $basic_wage . " x  ";
																		echo $total_working_day + $total_sick_day;
																		//\echo $total_day+$total_sick_day;

																		echo " ) = ";
																		$total_wage = $basic_wage * ($total_working_day + $total_sick_day);
																		//	$total_wage = $basic_wage*($total_day+$total_sick_day);
																		echo $total_wage;
																	}

																	?>
														</font>
													</td>
													<td align="center">บาท</td>
													<td align="right">&nbsp;</td>
													<td align="center">&nbsp;</td>
													<td align="center">&nbsp;</td>
												</tr>
												<tr>
													<td align="left">เงินค่า OT</td>
													<td align="center">
														<font color="#0000FF"><?= $total_ot ?></font>
													</td>
													<td align="center">บาท</td>
													<td align="right">&nbsp;</td>
													<td align="center">&nbsp;</td>
													<td align="center">&nbsp;</td>
												</tr>
												<tr>
													<td align="left">ค่ากะ</td>
													<td align="center">
														<font color="#0000FF"><?= $total_shift_val ?></font>
													</td>
													<td align="center">บาท</td>
													<td></td>
													<td></td>
													<td align="center">&nbsp;</td>
												</tr>
												<tr>
													<td align="left">ค่าข้าว ค่ารถ</td>
													<td align="center">
														<font color="#0000FF"><?= $total_car_rice ?></font>
													</td>
													<td align="center">บาท</td>
													<td></td>
													<td></td>
													<td align="center">&nbsp;</td>
												</tr>
												<tr>
													<td align="left">ค่า FL</td>
													<td align="center">
														<font color="#0000FF"><?= $total_fl ?></font>
													</td>
													<td align="center">บาท</td>
													<td></td>
													<td></td>
													<td align="center">&nbsp;</td>
												</tr>
												<tr>
													<td align="left">เบี้ยขยัน</td>
													<td align="center">
														<font color="#0000FF">
															<?
															if($extra_salary==1){
																echo "old =" . $satt_reward_old;
																$satt_reward = 0;
																echo "/now = ".$satt_reward." (stop pay)";
															}else{
																	if ($satt_reward_old == '') {
																		$satt_reward_old = 0;
																	}
																	if ($paystatus == 'paid') {
																		echo "old =" . $satt_reward_old;
																		echo "/now =" . $satt_reward;
																	} else {

																		echo "old =" . $att_reward;
																		$satt_reward_old = $att_reward;
																		
																		if ($total_anual_day > 0) {
																			$total_working_day = $total_working_day + $total_anual_day;
																		}
																		if ($total_sick_day == 0 && $total_personal_day == 0 && $total_absent_day == 0 && $total_late == 0 && $total_leave_without_pay_day == 0 && $total_day != 0 && ($total_working_day >= $total_working_day_standard)) {

																			if ($att_reward == 0) {
																				$satt_reward = 500;
																			} else if ($att_reward == 500) {
																				$satt_reward = 600;
																			} else if ($att_reward == 600) {
																				$satt_reward = 700;
																			} else if ($att_reward == 700) {
																				$satt_reward = 700;
																			}
																		} else {
																			$satt_reward = 0;
																		}
																	}

																	if ($total_working_day > $total_day) {
																		$satt_reward = 0;
																		echo "/now =" . $satt_reward;
																	} else {
																		echo "/now =" . $satt_reward;
																	}
																	
															}
																	

																	




																	?>
														</font>
													</td>
													<td align="center">บาท</td>
													<td></td>
													<td></td>
													<td align="center">&nbsp;</td>
												</tr>
												<tr>
													<td width="194">ค่าทักษะ</td>
													<td align="center">
														<font color="#0000FF"><?
														
														
						if($total_leave_without_pay_day>13 && $total_leave_without_pay_day<=15){
															$skill_reward = $skill_reward/2;
															}else if($total_leave_without_pay_day>15){
																$skill_reward = 0;
																}
												echo  $skill_reward;
														
														 ?></font>
													</td>
													<td align="center">บาท</td>
													<td></td>
													<td align="center">&nbsp;</td>
													<td align="center">&nbsp;</td>
												</tr>
												<tr>
													<td width="194">วันเกิดพนักงานและครอบครัว</td>
													<td align="center">
														<font color="#0000FF"><?= $hbd ?></font>
													</td>
													<td align="center">บาท</td>
													<td></td>
													<td align="center">&nbsp;</td>
													<td align="center">&nbsp;</td>
												</tr>
												<tr>
													<td width="194">โบนัส</td>
													<td align="center">
														<font color="#0000FF"><?= $bonus ?></font>
													</td>
													<td align="center">บาท</td>
													<td></td>
													<td align="center">&nbsp;</td>
													<td align="center">&nbsp;</td>
												</tr>
												<tr>
													<td width="194">ตกเบิก</td>
													<td align="center">
														<font color="#0000FF"><?= $other ?></font>
													</td>
													<td align="center">บาท</td>
													<td></td>
													<td align="center">&nbsp;</td>
													<td align="center">&nbsp;</td>
												</tr>
												<tr>
													<td width="194"></td>
													<td align="center"></td>
													<td align="center"></td>
													<td></td>
													<td></td>
													<td align="center">&nbsp;</td>
												</tr>
												<tr>
													<td align="left">รวมเงินเดือน</td>
													<td align="center">
														<?
																//+$skill_reward
																if ($emptype == 'employee') {
																	
					//echo "basic_salary=$basic_salary<BR>";
//					echo "total_car_rice=$total_car_rice<BR>";
//					echo "total_fl=$total_fl<BR>";	
//					echo "hbd=$hbd<BR>";	
//					echo "satt_reward=$satt_reward<BR>";	
//					echo "other=$other<BR>";	
//					echo "bonus=$bonus<BR>";	
//					echo "skill_reward=$skill_reward<BR>";	
					
					
					//$total_total = $total_total + $s_salary + $hbd + $satt_reward + $other + $bonus + $s_skill_reward;
		$total_total =	$basic_salary+$hbd+$satt_reward+$other+$bonus+$skill_reward+$total_ot+$total_shift_val+$total_car_rice+$total_fl;							
																	
																	//$total_total = $total_total + $basic_salary + $hbd + $satt_reward + $other + $bonus + $skill_reward;
																	echo $total_total;
																} else {
																	
																	$total_total = 	$total_wage + $total_ot + $total_shift_val + $total_car_rice + $total_fl + $satt_reward + $skill_reward + $hbd + $bonus +				$other;
																	echo $total_total;
																}
																?>
													</td>
													<td align="center">บาท</td>
													<td></td>
													<td></td>
													<td align="center">&nbsp;</td>
												</tr>
												<tr>
													<td align="left">หักขาดงาน</td>
													<td align="center">
														<font color="#FF0000">
															<?
																	if ($emptype == 'employee') {
																		echo $absent;
																	} else {
																		echo 0;
																	}
																	if ($absent > 0) {
																		$absent =  number_format($absent, 2, '.', '');
																	}
																	?>
														</font>
													</td>
													<td align="center">บาท</td>
													<td></td>
													<td></td>
													<td align="center">&nbsp;</td>
												</tr>
												<tr>
													<td align="left">หักลากิจ</td>
													<td align="center">
														<font color="#FF0000">
															<?
																	if ($emptype == 'employee') {
																		echo $total_personal_leave;
																	} else {
																		echo 0;
																	}
																	?>
														</font>
													</td>
													<td align="center">บาท</td>
													<td></td>
													<td></td>
													<td align="center">&nbsp;</td>
												</tr>

												<tr>
													<td align="left">หัก No attendance</td>
													<td align="center">
														<font color="#FF0000">
															<?
																	echo number_format($no_attendance, 2, '.', '');
																	$no_attendance = number_format($no_attendance, 2, '.', '');
																	?>
														</font>
													</td>
													<td align="center">บาท</td>
													<td></td>
													<td></td>
													<td align="center">&nbsp;</td>
												</tr>
												<tr>
													<td align="left">หักลาไม่ได้รับเงินเดือน</td>
													<td align="center">
														<font color="#FF0000"><?= $leave_without_pay ?></font>
													</td>
													<td align="center">บาท</td>
													<td></td>
													<td></td>
													<td align="center">&nbsp;</td>
												</tr>
												<tr>
													<td align="left">หักอื่นๆ</td>
													<td align="center">
														<font color="#FF0000"><?= $other_deduct ?></font>
													</td>
													<td align="center">บาท</td>
													<td></td>
													<td></td>
													<td align="center">&nbsp;</td>
												</tr>
												<tr>
													<td align="left">หักประกันสังคม</td>
													<td align="center">
														<font color="#FF0000">
															<?
																	if ($emptype == 'employee') {
										//$social_in = ($basic_salary + $skill_reward) * .05;
										$social_in = ($basic_salary + $skill_reward) * $social_in_calc;
										
																	} else {
										$social_in =($total_day*$basic_wage)*$social_in_calc;
																		//$social_in =($total_day*$basic_wage)*0.05;
																		//$social_in = $total_wage * 0.01;
																	}

																	if ($social_in > 0) {
																		if ($social_in > 750) {
																			$social_in = 750;
																		}
																		$social_in =  number_format($social_in, 2, '.', '');
																	}

																	?><?= $social_in ?></font>
													</td>
													<td align="center">บาท</td>
													<td></td>
													<td></td>
													<td align="center">&nbsp;</td>
												</tr>
												<tr>
													<td align="left">&nbsp;</td>
													<td align="center"></td>
													<td align="center">&nbsp;</td>
													<td></td>
													<td>เงินได้สะสม</td>
													<td align="center">
														<?
																echo $ytd_income;
																?>
													</td>
												</tr>
												<tr>
													<td align="left">คงเหลือเงินเดือน</td>
													<td align="center"><strong>
															<font color="#66CC66">
																<?
																		if ($emptype == 'employee') {
																			$total_salary = ($total_total) - $social_in - $absent - $total_personal_leave - $leave_without_pay - $other_deduct - $no_attendance;
																		} else {
																			$total_salary = ($total_total + $skill_reward) - $social_in - $leave_without_pay - $other_deduct - $no_attendance;
																		}

																		echo number_format($total_salary, 2, '.', '');															//echo $total_salary;
																		?>
															</font>
														</strong></td>
													<td align="center">บาท</td>
													<td>&nbsp;</td>
													<td>ประกันสังคมสะสม</td>
													<td align="center">
														<?
																echo $ytd_social_in;
																?>
													</td>
												</tr>
											</table>
									<?



											$att_reward = 0;



											// update total day + sick leave day
											$total_day = $total_day + $total_sick_day;
											// insert & update salary table
											$selects = "SELECT paystatus,empno from tbsalary where empno='$empno' and paycode='$paycode' ";
											$res = mssql_query($selects);
											$nums = mssql_num_rows($res);
											$rows = mssql_fetch_array($res);
											// echo $selects;
											if ($nums > 0) {


												if ($rows['paystatus'] == 'paid') { 
												
												} else {

													$sqlupdate = "update  tbsalary set total_basic_salary=$basic_salary,total_day=$total_day, total_car_rice=$total_car_rice, total_normal_day=$total_normal_day, total_wage=$total_wage, total_ot1=$total_ot1, total_ot1_5=$total_ot1_5, total_ot2=$total_ot2, total_ot3=$total_ot3,total_ot=$total_ot, att_reward=$satt_reward,att_reward_old=$satt_reward_old, social_in=$social_in, skill_reward=$skill_reward,total_shift_val=$total_shift_val, total_salary=$total_salary,total_fl=$total_fl,subtotal_salary=$total_total,hbd=$hbd,other=$other,bonus=$bonus,absent=$absent,personal_leave=$total_personal_leave,leave_without_pay=$leave_without_pay,other_deduct=$other_deduct,no_attendance=$no_attendance where empno='$empno' and paycode='$paycode' ";

													//echo $sqlupdate;
													mssql_query($sqlupdate);
												}
											} else {
										//total_basic_salary=$basic_salary
												//absent=$absent,personal_leave=$personal_leave,leave_without_pay=$leave_without_pay,other_deduct=$other_deduct
												$sqlinsert = "insert into tbsalary(empno, paycode, total_day, total_car_rice, total_normal_day, total_wage, total_ot1, total_ot1_5, total_ot2, total_ot3,total_ot, att_reward_old,att_reward, social_in, skill_reward,total_shift_val, total_salary,total_fl,subtotal_salary,paycodeyear,hbd,other,absent,personal_leave,leave_without_pay,other_deduct,bonus,no_attendance,total_basic_salary) values('$empno', '$paycode', $total_day, $total_car_rice, $total_normal_day, $total_wage, $total_ot1, $total_ot1_5, $total_ot2, $total_ot3,$total_ot, $satt_reward_old,$satt_reward, $social_in, $skill_reward, $total_shift_val,$total_salary,$total_fl,$total_total,'$paycodeyear',$hbd,$other,$absent,$personal_leave,$leave_without_pay,$other_deduct,$bonus,$no_attendance,$basic_salary)";
												//	echo $sqlinsert;
												mssql_query($sqlinsert);
											}
										
										
										
										
					}
					
										
										}
										
										
}
									?>






								</div>
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

	<!--
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>

<script>!window.jQuery && document.write(unescape('%3Cscript src="assets/js/jquery-1.10.2.min.js"%3E%3C/script%3E'))</script>
<script type="text/javascript">!window.jQuery.ui && document.write(unescape('%3Cscript src="assets/js/jqueryui-1.10.3.min.js'))</script>
-->

	<script type='text/javascript' src='assets/js/jquery-1.10.2.min.js'></script>
	<script type='text/javascript' src='assets/js/jqueryui-1.10.3.min.js'></script>
	<script type='text/javascript' src='assets/js/bootstrap.min.js'></script>
	<script type='text/javascript' src='assets/js/enquire.js'></script>
	<script type='text/javascript' src='assets/js/jquery.cookie.js'></script>
	<script type='text/javascript' src='assets/js/jquery.nicescroll.min.js'></script>
	<script type='text/javascript' src='assets/plugins/codeprettifier/prettify.js'></script>
	<script type='text/javascript' src='assets/plugins/easypiechart/jquery.easypiechart.min.js'></script>
	<script type='text/javascript' src='assets/plugins/form-multiselect/js/jquery.multi-select.min.js'></script>
	<script type='text/javascript' src='assets/plugins/sparklines/jquery.sparklines.min.js'></script>
	<script type='text/javascript' src='assets/plugins/form-toggle/toggle.min.js'></script>
	<script type='text/javascript' src='assets/js/placeholdr.js'></script>
	<script type='text/javascript' src='assets/js/application.js'></script>
	<script type='text/javascript' src='assets/plugins/bootbox/bootbox.min.js'></script>

	<script type='text/javascript' src='assets/demo/demo.js'></script>


</body>

</html>