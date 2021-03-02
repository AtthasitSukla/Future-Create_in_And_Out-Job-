<? 
include("connect.php");
				
include("library.php"); ?>
<?

	$date_num=date("m/d/Y");
	$times=date("H:i:s",time());
	$date_time=date("m/d/Y H:i:s");
	$status = $_POST['status'];
	
	if($status=='import_data' ){
		$eva_id_clone =$_POST['eva_id_clone'];
		$eva_id =$_POST['eva_id'];
		$empno = $_POST['empno'];
		$eva_period = $_POST['eva_period'];
		
		
		
					$selectx = "select * from   tbevaluate where eva_id='$eva_id_clone'";
					$rex = mssql_query($selectx);
					$numx=mssql_num_rows($rex);
					if($numx>0){
					 while($rowx = mssql_fetch_array($rex)){
							
							
							//gen id
							$eva_group_id = "EVG".date("y").date("m");
							$select="select top 1 eva_group_id from    tbevaluate where eva_group_id like '$eva_group_id%' order by eva_group_id desc ";
							$re=mssql_query($select);
							$num=mssql_num_rows($re);
							if($num==0){
								$newid  = "EVG".date("y").date("m")."0001";
							}else{
								$row=mssql_fetch_array($re);
								$tmp_newid = $row['eva_group_id'];
								$tmp_newid = substr($tmp_newid,-4);
								$qid = (int)$tmp_newid + 1;
								$tmpid = "0000".$qid;
								$qdno = substr($tmpid,-4);
								$newid = "EVG".date("y").date("m").$qdno;
							}
							$eva_group_id = $newid;
							//gen id
							
							$insert = "insert into tbevaluate(eva_period,eva_id, eva_group_id, eva_group_title,create_date, empno,empno_create
) values('$eva_period','$eva_id','$eva_group_id', '".$rowx['eva_group_title']."','$date_time', '$empno','".$_SESSION['admin_userid']."')";
							mssql_query($insert);
							
					$selectx2 = "select * from   tbevaluate_detail where eva_id='$eva_id_clone' and eva_group_id='".$rowx['eva_group_id']."'";
					$rex2 = mssql_query($selectx2);
					$numx2=mssql_num_rows($rex2);
					if($numx2>0){
					 while($rowx2 = mssql_fetch_array($rex2)){
							
						$insert2 = "insert into   tbevaluate_detail(eva_id, eva_group_id, eva_title,eva_type, eva_weight, eva_criteria) values('$eva_id','$eva_group_id', '".$rowx2['eva_title']."','".$rowx2['eva_type']."', ".$rowx2['eva_weight'].",  '".$rowx2['eva_criteria']."')";
					mssql_query($insert2);	
							
							
					 	}
					}
							
							
							
					 	}
					}
					
					
					
					
					
					
					
		
		
		
		
		
		
		
		
		
		
	}
	if($status=='add_group_title' ){
		$eva_group_title = lang_thai_into_database($_REQUEST['eva_group_title']);
		$eva_id =$_POST['eva_id'];
		$empno = $_POST['empno'];
		$eva_period = $_POST['eva_period'];
		//gen id
		$eva_group_id = "EVG".date("y").date("m");
		$select="select top 1 eva_group_id from    tbevaluate where eva_group_id like '$eva_group_id%' order by eva_group_id desc ";
		$re=mssql_query($select);
		$num=mssql_num_rows($re);
		
		if($num==0){
			$newid  = "EVG".date("y").date("m")."0001";
		}else{
			$row=mssql_fetch_array($re);
			$tmp_newid = $row['eva_group_id'];
			$tmp_newid = substr($tmp_newid,-4);
			$qid = (int)$tmp_newid + 1;
			$tmpid = "0000".$qid;
			$qdno = substr($tmpid,-4);
			$newid = "EVG".date("y").date("m").$qdno;
		}
				
		$eva_group_id = $newid;
		//gen id
		
		
		
		$insert = "insert into tbevaluate(eva_period,eva_id, eva_group_id, eva_group_title,create_date, empno,empno_create
) values('$eva_period','$eva_id','$eva_group_id', '$eva_group_title','$date_time', '$empno','".$_SESSION['admin_userid']."')";
		mssql_query($insert);
		
		
		
	}
	if($status=='add_sub_title' ){
		$eva_sub_title = lang_thai_into_database($_REQUEST['eva_title_add']);
		$eva_id =$_POST['eva_id'];
		$eva_group_id =$_POST['eva_group_id'];
		
		$insert = "insert into   tbevaluate_detail(eva_id, eva_group_id, eva_title) values('$eva_id','$eva_group_id', '$eva_sub_title')";
		mssql_query($insert);
		
		
		
	}
	
	if($status=='create_new'){
		
		//gen id
		$eva_id = "EVA".date("y").date("m");
		$select="select top 1 eva_id from    tbevaluate where eva_id like '$eva_id%' order by eva_id desc";
		$re=mssql_query($select);
		$num=mssql_num_rows($re);
		
		if($num==0){
			$newid  = "EVA".date("y").date("m")."0001";
		}else{
			$row=mssql_fetch_array($re);
			$tmp_newid = $row['eva_id'];
			$tmp_newid = substr($tmp_newid,-4);
			$qid = (int)$tmp_newid + 1;
			$tmpid = "0000".$qid;
			$qdno = substr($tmpid,-4);
			$newid = "EVA".date("y").date("m").$qdno;
		}
				
		echo  $newid;
		//gen id
		}
		
		
		if($status=='update_eva'){
			$id = $_POST['id'];
			$eva_group_id =$_POST['eva_group_id'];
			$eva_id =$_POST['eva_id'];
			$eva_type =$_POST['eva_type'];
			$eva_title =lang_thai_into_database($_POST['eva_title']);
			$eva_weight =$_POST['eva_weight'];
			$eva_criteria =addslashes($_POST['eva_criteria']);
			$eva_criteria =lang_thai_into_database($eva_criteria);
			$eva_criteria = str_replace("\n", "<br />", $eva_criteria); 


			
			$update = "update tbevaluate_detail set eva_type='$eva_type',eva_title='$eva_title',eva_weight=$eva_weight,eva_criteria='$eva_criteria' where  id=$id " ;
		//echo $update;
			mssql_query($update);
			
					$select = "select sum(eva_weight) as total from tbevaluate_detail where eva_id='$eva_id' ";
					$re = mssql_query($select);
					$row = mssql_fetch_array($re);
					echo $row['total'];
			
			}
		if($status=='update_eva2'){
			$id = $_POST['id'];
			$eva_id = $_POST['eva_id'];
			
			$eva_result =$_POST['eva_result'];
			
			$update = "update tbevaluate_detail set eva_result=$eva_result  where  id=$id " ;
		//echo $update;
			mssql_query($update);
			
			$select2 = "select * from tbevaluate_detail where eva_id ='$eva_id' order by id asc";
					$re2 = mssql_query($select2);
					$num2=mssql_num_rows($re2);
					if($num2>0){
						 while($row2 = mssql_fetch_array($re2)){
						 $eva_weight = $row2['eva_weight'];
						 $eva_result = $row2['eva_result'];
						 $total_eva_result =  $total_eva_result+(($eva_result*$eva_weight)/100);
						 }
						 $update2 = "update tbevaluate set eva_total_score = $total_eva_result where eva_id ='$eva_id'";
						 mssql_query($update2);
						}
			
			
			}
			
			if($status=='delete_eva'){
			$id = $_POST['id'];
			
			
			$update = "delete tbevaluate_detail  where  id=$id " ;
			mssql_query($update);
			
					$select = "select sum(eva_weight) as total from tbevaluate_detail where eva_id='$eva_id' ";
					$re = mssql_query($select);
					$row = mssql_fetch_array($re);
					echo $row['total'];
			
			}
			if($status=='delete_title'){
			$eva_group_id =$_POST['eva_group_id'];
			
			
			$update = "delete tbevaluate_detail  where  eva_group_id='$eva_group_id' " ;
			mssql_query($update);
			
			$update = "delete tbevaluate  where  eva_group_id='$eva_group_id' " ;
			mssql_query($update);
			
					
			
			}
			
			
			
?>