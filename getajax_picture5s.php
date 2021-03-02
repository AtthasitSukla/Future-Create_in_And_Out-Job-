<? 
$host="WIN-GRCB1K9LF1N";
	$username="sloxixa";
	$password="eaotft139@%";
	$db="dhrdb";
	
	$sql=mssql_connect($host,$username,$password) or die("Cannot connect");
	mssql_select_db($db);
	
	
	$status=  $_POST['status'];
	$site = $_POST["site"]; 

$select_date = $_POST["select_date"]==""?date('d/m/Y'):$_POST["select_date"];
$shift = $_POST["shift"]==""?"Day":$_POST["shift"];

$select_date_arr = explode("/",$select_date);
$select_date_sql = $select_date_arr[1]."/".$select_date_arr[0]."/".$select_date_arr[2];


if($status=='show_picture'){
	
    							$select1="SELECT * from   tb5s_picture 
											where createdate = '$select_date_sql' 
											and site='$site' and shift='$shift' order by id desc";
						//	echo $select1;
								$re1=mssql_query($select1);
								$num1 =mssql_num_rows($re1);
								$i = 0;
								if($num1>0){
									while($row1 = mssql_fetch_array($re1)){
										$i++;
										$picpic = "5spicture/".$row1['filename']."?T=".$time;
										
										?>
	<div class='row'>
     <div class='col-sm-12' style="text-align:center">
     <img  src="<?=$picpic;?>" width="200"/>
     <div  style="text-align:center"><input type="button" value="view" onClick="showmodal2('<?=$i?>');"><input type="hidden" id="fn<?=$i?>" value="<?=$picpic?>"></div>
      </div>
     </div>
										<?
										}
									
								}
	
	}
if($status=='show_picture_approve'){
								
								
								
								?>
								<div class='row'>
     <div class='col-sm-12' style="text-align:center">
								<?
								$select1="SELECT * from   tb5s_picture 
											where createdate = '$select_date_sql' 
											and site='$site' and shift='$shift' and jobstatus='Close' 
											";
						
								$re1=mssql_query($select1);
								$num1 =mssql_num_rows($re1);
								if($num1>0){
									echo "Closed";
								}else{
								$select2="SELECT * from   tb5s_picture 
											where createdate = '$select_date_sql' 
											and site='$site' and shift='$shift' and jobstatus='New' 
											and jobstatus_approve is null order by id desc";
						
								$re2=mssql_query($select2);
								$num2=mssql_num_rows($re2);
								if($num2>0){
									echo "Please Check NG or OK every picture.";
									}else{
										?><input type="button" value="Close Job" onclick="Closejob('<?=$select_date_sql?>');"><?
										}
									}
									
									?>
									
     	
     </div></div><HR>
									<?
				
								
								
    							$select1="SELECT * from   tb5s_picture 
											where createdate = '$select_date_sql' 
											and site='$site' and shift='$shift' order by id desc";
						
								$re1=mssql_query($select1);
								$num1 =mssql_num_rows($re1);
								$i = 0;
								if($num1>0){
									while($row1 = mssql_fetch_array($re1)){
										$i++;
										$picpic = "5spicture/".$row1['filename']."?T=".$time;
										
										?>
	<div class='row'>
     <div class='col-sm-12' style="text-align:center">
     <img  src="<?=$picpic;?>" width="200"/>
     <div  style="text-align:center"><input type="button" value="view" onClick="showmodal2('<?=$i?>');"><BR>
	 <?
     if($row1['jobstatus_approve']=='NG'){
		 $bgbg= "#FFC";
		 }else if($row1['jobstatus_approve']=='OK'){
			 $bgbg= "#6F9";
			 }
	 ?><span style="background-color:<?=$bgbg?>"><?=$row1['jobstatus_approve']?></span><?
	 ?><BR><input type="hidden" id="fn<?=$i?>" value="<?=$picpic?>">&nbsp;<input type="button" value="OK" onclick="edit_ok('<?=$row1['id']?>');">&nbsp;<input type="button" value="NG" onclick="edit_ng('<?=$row1['id']?>');"></div>
      </div>
     </div>
     <HR>
										<?
										}
									
								}
	
	}
	
	if($status=='edit_ng'){
		$id = $_POST['id'];
		$update = "update  tb5s_picture set jobstatus_approve='NG' where id=$id";
		mssql_query($update);
		}
	if($status=='edit_ok'){
		$id = $_POST['id'];
		$update = "update  tb5s_picture set jobstatus_approve='OK' where id=$id";
		mssql_query($update);
		}
	if($status=='Closejob'){
		$closedate = $_POST['closedate'];
		$update = "update  tb5s_picture set jobstatus='Close' where site='$site' and shift='$shift' AND createdate='$select_date_sql'";
		mssql_query($update);
		// echo $update;
		}
	
	if($status == "show_picture_ver2"){

		?>
		<div class='row'>
     		<!-- <div class='col-sm-3 text-center'>
			 	<strong><u>Example</u></strong>
			</div>
     		<div class='col-sm-3 text-center'>
			 	<strong><u>Photo</u></strong>
			</div>
     		<div class='col-sm-3 text-center'>
			 	<strong><u>Example</u></strong>
			</div>
     		<div class='col-sm-3 text-center'>
			 	<strong><u>Photo</u></strong>
			</div> -->
		</div>
		<div class='row'>
     		<div class='col-sm-12'>
     			<form id="form1" enctype="multipart/form-data" method="post" action="testcam_upload_5s.php">
 					<input type="hidden" id="idselect"> <span id="progress" style="text-align:center"></span> 
					<?php
						$sql_master = "SELECT * FROM  tb5s_picture_master WHERE site='$site' order by pos";
						$res_master = mssql_query($sql_master);
						while($row_master = mssql_fetch_array($res_master)){
							$filename = $row_master["filename"];
							$pos = $row_master["pos"];

							$pic_master = "ex_photo_wh/$site/$filename?T=".time();

							if($pos==1 || $pos%4==0){
								
								?><div class='row'><?
							}
							?>
							<!-- <div class='row'> -->
								
								<div class="col-sm-3 text-center">
									<div class="image-upload" style="text-align:center">
										<label for="filemaster<?=$pos?>">
											<img id="filemaster<?=$pos?>" src="<?=$pic_master?>" />
										</label>
									</div>
									<?php
									$sql_pic = "SELECT * FROM tb5s_picture WHERE shift='$shift' AND pos='$pos' AND site='$site' and createdate='$select_date_sql'";
									$res_pic = mssql_query($sql_pic);
									$num_pic = mssql_num_rows($res_pic);
									if($num_pic == 0){
										$picpic = "images/cam.png";
									}else{
										$row_pic = mssql_fetch_array($res_pic);
										$filename = $row_pic["filename"];
										$picpic = "5spicture/$filename?T=".time();


									}

									?>
									<div class="image-upload" style="text-align:center">
										<label for="fileToUpload<?=$pos?>">
											<img id="cam<?=$pos?>" src="<?=$picpic?>" />
										</label>
										<input name="fileToUpload<?=$pos?>"  onchange="fileSelected('<?=$pos?>');" accept="image/*" capture="camera" id="fileToUpload<?=$pos?>" type="file"/>
									</div>
									<input type="button" value="view" onClick="showmodal2('<?=$pos?>');">
									<input type="hidden" id="fn<?=$pos?>" value="<?=$picpic?>">
									<input type="hidden" id="master<?=$pos?>" value="<?=$pic_master?>">

								</div>
							<?
							if($pos!=1 && $pos%4==0){
								?></div><hr><?
							}
						}
						?>
				</form>                  
			</div>
	
		</div>

		<?
	}
	if($status == "show_picture_approve_ver2"){

		?>
		<div class='row'>
     		<div class='col-sm-12' style="text-align:center">
				<?
				$select1="SELECT * from   tb5s_picture 
							where createdate = '$select_date_sql' 
							and site='$site' and shift='$shift' and jobstatus='Close' 
							";
		
				$re1=mssql_query($select1);
				$num1 =mssql_num_rows($re1);
				if($num1>0){
					echo "Closed";
				}else{
				$select2="SELECT * from   tb5s_picture 
							where createdate = '$select_date_sql' 
							and site='$site' and shift='$shift' and jobstatus='New' 
							and jobstatus_approve is null order by id desc";
		
				$re2=mssql_query($select2);
				$num2=mssql_num_rows($re2);
				if($num2>0){
					echo "Please Check NG or OK every picture.";
					}else{
						?><input type="button" value="Close Job" onclick="Closejob('<?=$select_date_sql?>');"><?
						}
					}
					
					?>
									
     	
     		</div>
		</div>
		<HR>
		<div class='row'>
     		<div class='col-sm-12'>
     			<form id="form1" enctype="multipart/form-data" method="post" action="testcam_upload_5s.php">
 					<input type="hidden" id="idselect"> <span id="progress" style="text-align:center"></span> 
					<?php
						$sql_master = "SELECT * FROM  tb5s_picture_master WHERE site='$site' order by pos";
						$res_master = mssql_query($sql_master);
						while($row_master = mssql_fetch_array($res_master)){
							$filename = $row_master["filename"];
							$pos = $row_master["pos"];

							$pic_master = "ex_photo_wh/$site/$filename?T=".time();

							if($pos==1 || $pos%4==0){
								
								?><div class='row'><?
							}
							?>
							<!-- <div class='row'> -->
								
								<div class="col-sm-3 text-center">
									<div class="image-upload" style="text-align:center">
										<label for="filemaster<?=$pos?>">
											<img id="filemaster<?=$pos?>" src="<?=$pic_master?>" />
										</label>
									</div>
									<?php
									$sql_pic = "SELECT * FROM tb5s_picture WHERE shift='$shift' AND pos='$pos' AND site='$site' and createdate='$select_date_sql'";
									$res_pic = mssql_query($sql_pic);
									$num_pic = mssql_num_rows($res_pic);
									if($num_pic == 0){
										$picpic = "images/cam.png";
									}else{
										$row_pic = mssql_fetch_array($res_pic);
										$filename = $row_pic["filename"];
										$picpic = "5spicture/$filename?T=".time();


									}

									?>
									<div class="image-upload" style="text-align:center">
										<label for="fileToUpload<?=$pos?>">
											<img id="cam<?=$pos?>" src="<?=$picpic?>" />
										</label>
										<input name="fileToUpload<?=$pos?>"  onchange="fileSelected('<?=$pos?>');" accept="image/*" capture="camera" id="fileToUpload<?=$pos?>" type="file"/>
									</div>
									<input type="button" value="view" onClick="showmodal2('<?=$pos?>');">
									<input type="hidden" id="fn<?=$pos?>" value="<?=$picpic?>">
									<input type="hidden" id="master<?=$pos?>" value="<?=$pic_master?>">
									<BR>
									<?
									if($num_pic > 0){
										if($row_pic['jobstatus_approve']=='NG'){
											$bgbg= "#FFC";
										}else if($row_pic['jobstatus_approve']=='OK'){
											$bgbg= "#6F9";
										}
										?><span style="background-color:<?=$bgbg?>">
											<?=$row_pic['jobstatus_approve']?>
										</span><?
										?>
										<BR><input type="button" value="OK" onclick="edit_ok('<?=$row_pic['id']?>');">
										&nbsp;<input type="button" value="NG" onclick="edit_ng('<?=$row_pic['id']?>');">
									<?}?>

								</div>
							<?
							if($pos!=1 && $pos%4==0){
								?></div><hr><?
							}
						}
						?>
				</form>                  
			</div>
	
		</div>

		<?
	}
 ?>