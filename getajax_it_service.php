<?php
include("connect.php");
include("library.php");
$status = $_REQUEST['status'];
$date_time=date("m/d/Y H:i:s");

if($status =="save_message"){
    $empno = $_SESSION["admin_userid"];
    $job_id = $_REQUEST["job_id"];
    $message = lang_thai_into_database($_REQUEST["message"]);
    $job_status = $_REQUEST["job_status"];
    if($job_status != "user"){
        if($job_status=="Close"){
            $update = "update tbitservice_list 
                        set job_status='$job_status',problem_solution='$message',solution_date='$date_time'
                        where job_id='$job_id'";
            mssql_query($update);
        }else{
            $update = "update tbitservice_list set job_status='$job_status'
            where job_id='$job_id'";
            mssql_query($update);
        }
    }
    $insert = "insert into tbitservice_chat (job_id,empno,message,create_date,job_status)
                values ('$job_id','$empno','$message','$date_time','$job_status')";
    mssql_query($insert);
}
if($status=='save_approve'){
	 $empno = $_SESSION["admin_userid"];
    $job_id = $_REQUEST["job_id"];
    $approve_status = $_REQUEST["approve_status"];
     $update = "update tbitservice_list set approve_status='$approve_status',approve_empno='$empno'
            where job_id='$job_id'";
            mssql_query($update);
			
 //   $insert = "insert into tbitservice_chat (job_id,empno,message,create_date,job_status)
             //   values ('$job_id','$empno','$message','$date_time','$job_status')";
  // mssql_query($insert);
	}
if($status =="save_message_program"){
    $empno = $_SESSION["admin_userid"];
    $job_id = $_REQUEST["job_id"];
    $message = lang_thai_into_database($_REQUEST["message"]);
    $job_status = $_REQUEST["job_status"];
    if($job_status != "user"){
        if($job_status=="Close"){
            $update = "update tbitprogram_list 
                        set job_status='$job_status',finish_date='$date_time'
                        where job_id='$job_id'";
            mssql_query($update);
        }else{
            $update = "update tbitprogram_list set job_status='$job_status'
            where job_id='$job_id'";
            mssql_query($update);
        }
    }
    $insert = "insert into tbitprogram_chat (job_id,empno,message,create_date,job_status)
                values ('$job_id','$empno','$message','$date_time','$job_status')";
    mssql_query($insert);
}

if($status=='create_task'){
		$job_id = $_REQUEST['job_id'];
		
		$project_name = $_REQUEST['project_name'];
		$detail = lang_thai_into_database($_REQUEST['detail']);
		//$start_date = $_REQUEST['start_date'];
	//	$due_date = $_REQUEST['due_date'];
		$incharge = $_REQUEST['incharge'];
		$job_id = $_REQUEST['job_id'];
		
		$job_id_check = "IT01".$arr_date[2].$arr_date[1];
		$sql_check = "select top 1 develop_id from tbitprogram_list where develop_id like '$job_id_check%' order by develop_id desc";
		$res = mssql_query($sql_check);
		$num = mssql_num_rows($res);
		if($num==0){
			$new_id = "IT01".date("y").date("m")."001";
		}else{
			//IT201803001
			$row = mssql_fetch_array($res);
			$tmp_newid = $row['develop_id'];
			$tmp_newid = substr($tmp_newid,-4);
			$qid = (int)$tmp_newid + 1;
			$tmpid = "0000".$qid;
			$qdno = substr($tmpid,-3);
			$new_id = "IT01".date("y").date("m").$qdno;
		}
		
		
		$insert = "insert into   tbitprogram_list (job_id, develop_id, project_name, detail, create_date, job_status, incharge)
                values ('$job_id', '$new_id', '$project_name', '$detail', '$date_time', 'New', '$incharge'
)";
   		 mssql_query($insert);
		
	}
	if($status=='edit_problem_type'){
		$problem_type = $_REQUEST['problem_type'];
		$job_id = $_REQUEST['job_id'];
		
		$update=  "update tbitservice_list set problem_type='$problem_type' where job_id='$job_id'";
		 mssql_query($update);
		}
	if($status=='edit_piority_range'){
		$piority_range = $_REQUEST['piority_range'];
		$job_id = $_REQUEST['job_id'];
		
		$update=  "update tbitservice_list set piority_range='$piority_range' where job_id='$job_id'";
		 mssql_query($update);
		}
	if($status=='edit_level_range'){
		$level_range = $_REQUEST['level_range'];
		$job_id = $_REQUEST['job_id'];
		
		$update=  "update tbitservice_list set level_range='$level_range' where job_id='$job_id'";
		 mssql_query($update);
		}
	if($status=='edit_job_type'){
		$job_type = $_REQUEST['job_type'];
		$job_id = $_REQUEST['job_id'];
		
		$update=  "update tbitservice_list set job_type='$job_type' where job_id='$job_id'";
		 mssql_query($update);
		}
		
	if($status=='edit_due_date'){
		$due_date = $_REQUEST['due_date'];
		
		$remark = $_REQUEST['remark'];
		$remark = lang_thai_into_database($remark);
		$job_id = $_REQUEST['job_id'];
		
		$update=  "update tbitservice_list set due_date='$due_date' where job_id='$job_id'";
		 mssql_query($update);
		 
		$insert = "insert into tbitservice_log(job_id, empno, due_date, remark) values('$job_id', '".$_SESSION['admin_userid']."', '$due_date', '$remark')"; 
		 mssql_query($insert);
		 
		}
	if($status=='update_programlist'){
			$incharge =  $_REQUEST['incharge'];
			$start_date =  $_REQUEST['start_date'];
			$due_date =  $_REQUEST['due_date'];
			$job_status =  $_REQUEST['job_status'];
			$id = $_REQUEST['id'];
			
			if($start_date!=''){
			$update=  "update tbitprogram_list set incharge='$incharge',start_date='$start_date',due_date='$due_date',job_status='$job_status' where id=$id";
			}else{
				$update=  "update tbitprogram_list set incharge='$incharge',job_status='$job_status' where id=$id";
				}
			
		 mssql_query($update);
			
		}
		
		if($status=='edit_asset_no'){
			$job_id = $_REQUEST['job_id'];
			$asset_no = $_POST['asset_no'];
			$asset_no2 = $_POST['asset_no2'];
			$asset_no3 = $_POST['asset_no3'];
			$asset_no4 = $_POST['asset_no4'];
			$asset_no5 = $_POST['asset_no5'];
			
			if($asset_no2!=''){
				$cond = ",asset_no2='$asset_no2'";
				}
			if($asset_no3!=''){
				$cond .= ",asset_no3='$asset_no3'";
				}
			if($asset_no4!=''){
				$cond .= ",asset_no4='$asset_no4'";
				}
			if($asset_no5!=''){
				$cond .= ",asset_no5='$asset_no5'";
				}
			
			$update=  "update tbitservice_list set asset_no='$asset_no' $cond where job_id='$job_id'";
			//echo $update;
			mssql_query($update);
			
			}
?>