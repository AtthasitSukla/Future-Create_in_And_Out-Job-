<?
include("connect.php");

$status = $_REQUEST['status'];
$date_time=date("m/d/Y H:i:s");
$data = array();
//$_SESSION['admin_userid'];

if($status=='T'){
	$type = $_POST['type'];
	$empno = array();
	$sql = "SELECT * FROM  tbleave_control WHERE emp_control = '".$_SESSION['admin_userid']."'";
	$re=mssql_query($sql);
	$num=mssql_num_rows($re);
	while($row=mssql_fetch_array($re)){
		array_push($empno,$row['emp_under']);
	}
	$search = @$_POST["search"]["value"];
	$empno = join("','",$empno);  
	$tt = 1;
	if(strlen($search)){
		$num = 0;
		$tt = 0;
		$sql = "SELECT empno,firstname,lastname,nickname,positionname,startdate FROM  tbemployee JOIN tbposition ON tbemployee.positionid = tbposition.positionid WHERE empno IN ('$empno') $search";
	}else{
		$num = 89;
		$sql = "SELECT empno,firstname,lastname,nickname,positionname,startdate FROM  tbemployee JOIN tbposition ON tbemployee.positionid = tbposition.positionid WHERE empno IN ('$empno') AND status_pro = 0 ";
	}
	//echo $search."<br/>".$sql;
	$re=mssql_query($sql);
	$item = 1;
	while($row=mssql_fetch_array($re)){
		$count = (strtotime(date("Y-m-d")) - strtotime($row['startdate']))/( 60 * 60 * 24 );
		if($count > $num){
			$row_array["item"] = $item;
			$row_array["empno"] = $row['empno'];
			$row_array["fullname"] = iconv("tis-620", "utf-8", $row['firstname']).' '.iconv("tis-620", "utf-8", $row['lastname']).' ('.iconv("tis-620", "utf-8", $row['nickname']).')';
			$row_array["position"] = $row['positionname'];
			$row_array["startdate"] = date("d/m/Y",strtotime($row['startdate']));
			$row_array["pro_date"] = date("d/m/Y",strtotime("+4 months", strtotime($row['startdate'])));
			if($tt == 0){
				$row_array["action"] = "<center><a href='form_probation.php?type=2&empno=".$row_array["empno"]."' ><i class='fa fa-pencil-square-o fa-2x' aria-hidden='true'></i></a> <a target='_blank' href='print_probation.php?type=2&empno=".$row_array["empno"]."' ><i class='fa fa-print fa-2x' aria-hidden='true'></i></a></center>";
			}else{
				$row_array["action"] = "<center><a href='form_probation.php?type=1&empno=".$row_array["empno"]."' ><i class='fa fa-pencil-square-o fa-2x' aria-hidden='true'></i></a></center>";
			}
			array_push($data,$row_array);
			$item++;
		}
	}
	
echo json_encode(array('data'=>$data));
}
if($status=='R'){
	$type = $_POST['type'];
	$empno = $_POST['empno'];
	$sql = "SELECT empno,firstname,lastname,positionname,startdate ,birthdate,basic_salary FROM  tbemployee JOIN tbposition ON tbemployee.positionid = tbposition.positionid WHERE empno = '$empno' ";
	$re=mssql_query($sql);
	$row=mssql_fetch_array($re);
	$row_array["empno"] = $row['empno'];
	$row_array["age"] = date("Y")-date("Y",strtotime($row['birthdate']));
	$row_array["fullname"] = iconv("tis-620", "utf-8", $row['firstname']).' '.iconv("tis-620", "utf-8", $row['lastname']);
	$row_array["position"] = $row['positionname'];
	$row_array["education"] = $row['education'];
	$row_array["startdate"] = date("d/m/Y",strtotime($row['startdate']));
	$row_array["pro_date"] = date("d/m/Y",strtotime("+4 months", strtotime($row['startdate'])));
	
	if($type == '1'){	
		$row_array["old_saraly"] = number_format((float)$row['basic_salary'], 2, '.', ',')." บาท";
		
		$sql = "select leavetypeid,sum(leavetotal) as leavetotal from tbleave_transaction where empno = $empno group by leavetypeid";
		$re=mssql_query($sql);
		$row_array["private"] = 0;
		$row_array["sick"] = 0;
		$row_array["absence"] = 0;
		while($row=mssql_fetch_array($re)){
			if($row['leavetypeid'] == 'L0002'){
				$row_array["private"] = $row['leavetotal'];
			}
			if($row['leavetypeid'] == 'L0001'){
				$row_array["sick"] = $row['leavetotal'];
			}
			if($row['leavetypeid'] == 'L0006'){
				$row_array["absence"] = $row['leavetotal'];
			}
		}
	}else{

		$sql = "select late,private,sick,absence,old_saraly,new_saraly from tbprobation where empno = $empno ";
		$re=mssql_query($sql);
		$row=mssql_fetch_array($re);
		$row_array["new_saraly"] = number_format((float)$row['new_saraly'], 2, '.', ',')." บาท";
		$row_array["old_saraly"] = number_format((float)$row['old_saraly'], 2, '.', ',')." บาท";
		$row_array["late"] = $row['late'];
		$row_array["private"] = $row['private'];
		$row_array["sick"] = $row['sick'];
		$row_array["absence"] = $row['absence'];
		
	}
echo json_encode(array('data'=>$row_array));
}
if($status=='I'){
	$txt_pro_date = explode("/",$_REQUEST['txt_pro_date']);
	$txt_pro_date = $txt_pro_date[2]."-".$txt_pro_date[1]."-".$txt_pro_date[0];
	$sql = "INSERT INTO tbprobation (empno, late, private, sick, absence, title1, note1, title2, note2, title3, note3, title4, note4, title5, note5, title6, note6, title7, note7, title8, note8, title9, note9, title10, note10, recomend, result, senior_pro, date_pro, old_saraly, new_saraly)";
	$sql .= " VALUES('".$_REQUEST['empno']."', '".$_REQUEST['late']."', '".$_REQUEST['txt_private']."', '".$_REQUEST['txt_sick']."', '".$_REQUEST['txt_absence']."', '".$_REQUEST['title1']."', '".iconv("utf-8","tis-620", $_REQUEST['note1'])."', '".$_REQUEST['title2']."', '".iconv("utf-8","tis-620", $_REQUEST['note2'])."', '".$_REQUEST['title3']."', '".iconv("utf-8","tis-620", $_REQUEST['note3'])."', '".$_REQUEST['title4']."', '".iconv("utf-8","tis-620", $_REQUEST['note4'])."','".$_REQUEST['title5']."', '".iconv("utf-8","tis-620", $_REQUEST['note5'])."', '".$_REQUEST['title6']."', '".iconv("utf-8","tis-620", $_REQUEST['note6'])."', '".$_REQUEST['title7']."', '".iconv("utf-8","tis-620", $_REQUEST['note7'])."', '".$_REQUEST['title8']."', '".iconv("utf-8","tis-620", $_REQUEST['note8'])."', '".$_REQUEST['title9']."', '".iconv("utf-8","tis-620", $_REQUEST['note9'])."', '".$_REQUEST['title10']."', '".iconv("utf-8","tis-620", $_REQUEST['note10'])."', '".iconv("utf-8","tis-620", $_REQUEST['comment'])."', '".$_REQUEST['title11']."', '".$_SESSION['admin_userid']."', '".$txt_pro_date."', '".$_REQUEST['txt_old_salary']."', '".$_REQUEST['new_salary']."')";
	mssql_query($sql);
	$sql_u = "UPDATE tbemployee SET status_pro = 1 WHERE empno = '".$_REQUEST['empno']."'";
	mssql_query($sql_u);
	echo "1";
}
if($status=='U'){
	$txt_pro_date = explode("/",$_REQUEST['txt_pro_date']);
	$txt_pro_date = $txt_pro_date[2]."-".$txt_pro_date[1]."-".$txt_pro_date[0];
	$sql = "UPDATE tbprobation SET  title1='".$_REQUEST['title1']."', note1='".iconv("utf-8","tis-620", $_REQUEST['note1'])."', title2='".$_REQUEST['title2']."', note2='".iconv("utf-8","tis-620", $_REQUEST['note2'])."', title3='".$_REQUEST['title3']."', note3='".iconv("utf-8","tis-620", $_REQUEST['note3'])."', title4='".$_REQUEST['title4']."', note4='".iconv("utf-8","tis-620", $_REQUEST['note4'])."', title5='".$_REQUEST['title5']."', note5='".iconv("utf-8","tis-620", $_REQUEST['note5'])."', title6='".$_REQUEST['title6']."', note6='".iconv("utf-8","tis-620", $_REQUEST['note6'])."', title7='".$_REQUEST['title7']."', note7='".iconv("utf-8","tis-620", $_REQUEST['note7'])."', title8='".$_REQUEST['title8']."', note8='".iconv("utf-8","tis-620", $_REQUEST['note8'])."', title9='".$_REQUEST['title9']."', note9='".iconv("utf-8","tis-620", $_REQUEST['note9'])."', title10='".$_REQUEST['title10']."', note10='".iconv("utf-8","tis-620", $_REQUEST['note10'])."', recomend = '".iconv("utf-8","tis-620", $_REQUEST['comment'])."',result='".$_REQUEST['title11']."', senior_pro = '".$_SESSION['admin_userid']."',  new_saraly ='".$_REQUEST['new_salary']."' WHERE empno = ".$_REQUEST['empno'];
	mssql_query($sql);
	echo "1";
}
if($status=='C'){
	$sql = "select * from tbprobation where empno = ".$_REQUEST['empno'];
	$re=mssql_query($sql);
	$row=mssql_fetch_array($re);
	$row_array["salary"] = number_format((float)$row['new_saraly'], 2, '.', ',')." บาท";
	$row_array["late"] = $row['late'];
	$row_array["private"] = $row['private'];
	$row_array["sick"] = $row['sick'];
	$row_array["absence"] = $row['absence'];
	$row_array["title1"] = $row['title1'];
	$row_array["note1"] = iconv("tis-620", "utf-8", $row['note1']);
	$row_array["title2"] = $row['title2'];
	$row_array["note2"] = iconv("tis-620", "utf-8", $row['note2']);
	$row_array["title3"] = $row['title3'];
	$row_array["note3"] = iconv("tis-620", "utf-8", $row['note3']);
	$row_array["title4"] = $row['title4'];
	$row_array["note4"] = iconv("tis-620", "utf-8", $row['note4']);
	$row_array["title5"] = $row['title5'];
	$row_array["note5"] = iconv("tis-620", "utf-8", $row['note5']);
	$row_array["title6"] = $row['title6'];
	$row_array["note6"] = iconv("tis-620", "utf-8", $row['note6']);
	$row_array["title7"] = $row['title7'];
	$row_array["note7"] = iconv("tis-620", "utf-8", $row['note7']);
	$row_array["title8"] = $row['title8'];
	$row_array["note8"] = iconv("tis-620", "utf-8", $row['note8']);
	$row_array["title9"] = $row['title9'];
	$row_array["note9"] = iconv("tis-620", "utf-8", $row['note9']);
	$row_array["title10"] = $row['title10'];
	$row_array["note10"] = iconv("tis-620", "utf-8", $row['note10']);
	$row_array["recomend"] = iconv("tis-620", "utf-8", $row['recomend']);
	$row_array["result"] = $row['result'];
	$row_array["old_saraly"] = $row['old_saraly'];
	$row_array["new_saraly"] = $row['new_saraly'];
	echo json_encode(array('data'=>$row_array));
}
?>