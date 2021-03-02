<?php
function dropdown_position(){
	$str = "";
	$str .= "<select class='sl_dep ' name='sl_dep' >";
	$str .= "<option value='0'>---เลือก---</option>";
	$sql = "select * from tbposition";
	$res = mssql_query($sql);
	while($row=mssql_fetch_array($res)){
		$positionid = $row['positionid'];
		$positionname = $row['positionname'];
		$str .= "<option value='$positionid'>$positionname</option>";
	}
	$str .="</select>";
	return $str;
}
function dropdown_coures_list(){
	$str = "";
	$str .= "<select class='course_id ' name='course_id' id='course_id'>";
	$str .= "<option value='0'>---เลือก---</option>";
	$sql = "select * from tbcourse_list order by course_id DESC";
	$res = mssql_query($sql);
	while($row=mssql_fetch_array($res)){
		$course_id = $row['course_id'];
		$course_title = lang_thai_from_database($row['course_title']);
		$str .= "<option value='$course_id'>$course_title</option>";
	}
	$str .="</select>";
	return $str;
}
function dropdown_leave_type(){
	$str = "";
	$str .= "
		<select id='type_leave' name='type_leave'>";
	$sql = "select * from tbleavetype  ";
	$res = mssql_query($sql);
	while($row = mssql_fetch_array($res)){
		$leavetypeid = $row['leavetypeid'];
		$leavename = lang_thai_from_database($row['leavename']);
		$str .=	"<option value='$leavetypeid'>$leavename</option>";
	}
	$str.= "</select>";
	return $str;
}
function get_rec_empno($empno){
	$sql = "select * from tbemployee where empno='$empno'";
	$res = mssql_query($sql);
	$rec=mssql_fetch_array($res);
	return $rec;
}
function get_rec_tbtra_group($group_id){
	$sql = "select * from tbtra_group where group_id='$group_id'";
	$res = mssql_query($sql);
	$rec=mssql_fetch_array($res);
	return $rec;
}
function get_positionname($positionid){
	$sql = "select * from tbposition where positionid='$positionid'";
	$res = mssql_query($sql);
	$row=mssql_fetch_array($res);
	$positionname=$row['positionname'];
	return $positionname;
}
function get_department($departmentid){
	$sql = "select * from tbdepartment where departmentid='$departmentid'";
	$res = mssql_query($sql);
	$row=mssql_fetch_array($res);
	$department=$row['department'];
	return $department;
}
function get_full_name($empno){
	$sql = "select * from tbemployee where empno='$empno'";
	$res = mssql_query($sql);
	$row = mssql_fetch_array($res);
	$first_name = lang_thai_from_database($row['firstname']);
	$last_name = lang_thai_from_database($row['lastname']);
	$full_name = $first_name." ".$last_name;
	return $full_name;
	
}
function get_leavename($leavetypeid){
	$sql = "select * from tbleavetype where leavetypeid='$leavetypeid'";
	$res = mssql_query($sql);
	$num = mssql_num_rows($res);
	$row = mssql_fetch_array($res);
	$leavename = lang_thai_from_database($row['leavename']);
	return $leavename;

}
function lang_thai_from_database($text){
	$text_thai = iconv("tis-620", "utf-8",$text);
	return $text_thai;
}
function lang_thai_into_database($text){
	$text_thai = iconv("utf-8","tis-620",$text);
	return $text_thai;
}
function date_format_thai_from_databese($date){
	$arr_date = explode("-",$date);
	$date_format = $arr_date[2]."/".$arr_date[1]."/".((int)$arr_date[0]+543);
	return $date_format;
}
function test($date){
	return $date;
}
function date_format_thai_into_database($date){
	$arr_date = explode("/",$date);
	$date_format = $arr_date[1]."/".$arr_date[0]."/".((int)$arr_date[2]-543);
	return $date_format;
}
function date_format_uk_into_database($date){
	//22/03/2018 - 03/22/2018
	$arr_date = explode("/",$date);
	$date_format = $arr_date[1]."/".$arr_date[0]."/".$arr_date[2];
	return $date_format;
}
function access_it_service(){ //
	$empno = $_SESSION['admin_userid'];
	if($empno=="61001" || $empno=="59011"){
		return true;
	}else{
		return false;
	}
}
function DateDiff($strDate1,$strDate2)
	 {
				return (strtotime($strDate2) - strtotime($strDate1))/  ( 60 * 60 * 24 );  // 1 day = 60*60*24
	 }
	 function TimeDiff($strTime1,$strTime2)
	 {
				return (strtotime($strTime2) - strtotime($strTime1))/  ( 60 * 60 ); // 1 Hour =  60*60
	 }
	 function DateTimeDiff($strDateTime1,$strDateTime2)
	 {
				return (strtotime($strDateTime2) - strtotime($strDateTime1))/  ( 60  ); // 1 min =  60*60
	 }

?>