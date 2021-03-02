<? include("connect_inv.php");
include("library.php"); ?>
<?

	$date_num=date("m/d/Y");
	$times=date("H:i:s",time());
	$date_time=date("m/d/Y H:i:s");
	$status = $_REQUEST['status'];
	
	
	if($status=='showpicture_asset'){
		$asset_no = $_REQUEST['asset_no'];
		
		?>
		<form id="form1" enctype="multipart/form-data" method="post" action="testcam_upload_asset.php">
 <input type="hidden" id="idselect">  <input type="hidden" id="hdissue" value="<?=$asset_no?>"> <span id="progress"></span>
					<div class="panel panel-primary">
						
						<div class="panel-body" style="border-top-color:#DDDDDD;background-color:#ffffff ">
                         <div class="form-group">
                         
                <label class="col-sm-12 control-label">
                <h4><strong><u>Take Picture : Asset</u></strong></h4></label>
               
           				 </div>
                        
                       <div class="form-group">
                    
               <?
               for($i=1;$i<=3;$i++){
	$select1="select * from  tbasset_picture where asset_no='$asset_no'  and pos = '".$i."'";
	//echo $select1;
	$re1=mssql_query($select1);
	$num1 =mssql_num_rows($re1);
	if($num1>0){
		$row1=mssql_fetch_array($re1);
			$picpic = "asset_picture/".$asset_no."_".$i.".jpg";
			//$picpic = "showpicture_asset.php?filename=".$picpic;
		//	$picpic = $picpic."&id=".$row1['id'];
		}else{
			$picpic = "images/cam.png";
			}
			//echo $picpic;
				   ?>
				   <div class="col-sm-4">
                 <div class="image-upload" style="text-align:center">
    <label for="fileToUpload<?=$i?>">
        <img id="cam<?=$i?>" src="<?=$picpic;?>"/>
    </label><span id="progress<?=$i?>"></span>

    <input name="fileToUpload<?=$i?>"  onchange="fileSelected('<?=$i?>','1');" accept="image/*" capture="camera" id="fileToUpload<?=$i?>" type="file"/>
</div><div  style="text-align:center"><input type="button" value="view" onClick="showmodal2('<?=$i?>');"><input type="hidden" id="fn<?=$i?>" value="<?=$picpic?>"></div>
                </div>
				   
				   <?
				   }
			   ?>
                
               
             
                
                
                
            </div>
             <div class="form-group">
                    
               <?
               for($i=4;$i<=6;$i++){
	$select1="select * from  tbasset_picture where asset_no='$asset_no'  and pos = '".$i."'";
	//echo $select1;
	$re1=mssql_query($select1);
	$num1 =mssql_num_rows($re1);
	if($num1>0){
		$row1=mssql_fetch_array($re1);
			$picpic = "asset_picture/".$asset_no."_".$i.".jpg";
			//$id = $row1['id'];
			//$picpic = "showpicture_asset.php?filename=".$picpic;
		//	$picpic = $picpic."&id=".$row1['id'];
		}else{
			$picpic = "images/cam.png";
			}
			//echo $picpic;
				   ?>
				   <div class="col-sm-4">
                 <div class="image-upload" style="text-align:center">
    <label for="fileToUpload<?=$i?>">
        <img id="cam<?=$i?>" src="<?=$picpic;?>"/>
    </label><span id="progress<?=$i?>"></span>

    <input name="fileToUpload<?=$i?>"  onchange="fileSelected('<?=$i?>','1');" accept="image/*" capture="camera" id="fileToUpload<?=$i?>" type="file"/>
</div><div  style="text-align:center"><input type="button" value="view" onClick="showmodal2('<?=$i?>');"><input type="hidden" id="fn<?=$i?>" value="<?=$picpic?>"></div>
                </div>
				   
				   <?
				   }
			   ?>
                
               
             
                
                
                
            </div>
            
            
            
            
            
            
              
             
                         
					  </div>
                      
					
						
						
                      
					</div>
                    
                   </form>
		<?
		
		}
		
		if($status=='show_asset'){ 
			$asset_no = $_REQUEST['asset_no'];
			$select="select convert(varchar, po_open_date, 103)as po_open_date2,
				convert(varchar, po_open_date, 108)as po_open_time,
				convert(varchar, purchase_date, 103)as purchase_date2,
				convert(varchar, purchase_date, 108)as purchase_time,
				convert(varchar, warranty_start, 103)as warranty_start_date,
				convert(varchar, warranty_start, 108)as warranty_start_time,
				convert(varchar, warranty_end, 103)as warranty_end_date,
				convert(varchar, warranty_end, 108)as warranty_end_time,*
				from  tbasset where  asset_no= '$asset_no' ";
			$re=mssql_query($select);
			$num=mssql_num_rows($re);
			if($num>0){
				$row=mssql_fetch_array($re);
				$id = $row['id'];
				$asset_no = $row['asset_no'];
				$asset_name = iconv("tis-620", "utf-8", $row['asset_name']);
				$empno = $row["empno"];
				$owner = iconv("tis-620", "utf-8", $row['owner']);
				$serialnumber = $row['serialnumber'];
				$location =$row['location'];
				$manufacturer = iconv("tis-620", "utf-8", $row['manufacturer']);
				
				$model = lang_thai_from_database($row['model']);
				$macaddress = lang_thai_from_database($row['macaddress']);
				$ipaddress = lang_thai_from_database($row['ipaddress']);
				$asset_group =iconv("tis-620", "utf-8", $row['asset_group']);
				$device_type =lang_thai_from_database($row['device_type']);
				$po_open_date = $row['po_open_date2'];//." ".$row['po_open_time'];
				$purchase_date = $row['purchase_date2'];//." ".$row['purchase_time'];
				$purchase_price = $row['purchase_price'];
				$warranty_start = $row['warranty_start_date'];//." ".$row['warranty_start_time'];
				$warranty_end = $row['warranty_end_date'];//." ".$row['warranty_end_time'];
				$asset_status = $row['asset_status'];
				$assetfile= $row['assetfile'];
				$asset_action = lang_thai_from_database($row['asset_action']);
				?>
				
				<div class="col-sm-6">

					<table cellpadding="10">
						<tr>
							<td  align="right"><strong>Asset No :</strong></td>
							<td ><?=$row['asset_no']?></td>
						</tr>
						<tr>
							<td  align="right"><strong>Location :</strong></td>
							<td ><select id="location"  class="form-control " disabled="disabled" onchange="change_location();">
    
					<?
						$select="select distinct location from tbasset order by location asc";
						$re=mssql_query($select);
						$num=mssql_num_rows($re);
						if($num>0){
							while($row=mssql_fetch_array($re)){  
							?> <option value="<?=$row['location']?>" <?
								if($location==$row['location']){
									?> selected<?
								}
								?>><?=$row['location']?></option><?
							}
						}
						?>
						</select></td>
						</tr>
                        <tr>
							<td  align="right"><strong>Reason to transfer location :</strong></td>
							<td ><input type="text" class="form-control" id="transfer_reason" onchange="enable_location();" style="background-color:#FFC" ></td>
						</tr>
						<tr>
							<td  align="right"><strong>Asset Name :</strong></td>
							<td ><input type="text" class="form-control" style='width:200px; ' id="asset_name" value="<?=$asset_name?>" ></td>
						</tr>
						<tr>
							<td  align="right"><strong>empno :</strong></td>
							<td ><div id='show_empno'></div></td>
						</tr>
					
						<tr>
							<td  align="right"><strong>Asset Group :</strong></td>
							<td ><select id="asset_group"  class="form-control " >
                            <option value="">Select</option> <?
						$select="select * from tbasset_group order by id asc";
						$re=mssql_query($select);
						$num=mssql_num_rows($re);
						if($num>0){
							while($row=mssql_fetch_array($re)){  
							?> <option value="<?=$row['asset_group']?>" <?
								if($asset_group==$row['asset_group']){
									?> selected<?
								}
								?>><?=$row['asset_group']?></option><?
							}
						}
						?></select></td>
						</tr>
                        
                        <tr>
							<td  align="right"><strong>Device Type :</strong></td>
							<td ><select id="device_type"  class="form-control " >
                            <option value="">Select</option> <?
						$select="select distinct device_type from tbasset where device_type is not null order by device_type asc";
						$re=mssql_query($select);
						$num=mssql_num_rows($re);
						if($num>0){
							while($row=mssql_fetch_array($re)){  
							?> <option value="<?=$row['device_type']?>" <?
								if($device_type==$row['device_type']){
									?> selected<?
								}
								?>><?=$row['device_type']?></option><?
							}
						}
						?></select></td>
						</tr>
						
						<tr>
							<td  align="right"><strong>Manufacturer :</strong></td>
							<td ><input type="text" class="form-control" style='width:200px;' id="manufacturer" value="<?=$manufacturer;?>" ></td>
						</tr>
						<tr>
							<td  align="right"><strong>Model :</strong></td>
							<td ><input type="text" class="form-control" style='width:200px;' id="model" value="<?=$model;?>" ></td>
						</tr>
                        <tr>
							<td  align="right"><strong>สถานะของอุปกรณ์ :</strong></td>
							<td ><select id="asset_status" class="form-control" style="background-color:#FF9">
                    <option value="">Select</option>
                    <option value="normal_use" <?
                    if($asset_status=='normal_use'){
						?> selected<?
						}
					?>>ปกติ ยังใช้งานอยู่</option>
                    
                    <option value="normal_nouse" <?
                    if($asset_status=='normal_nouse'){
						?> selected<?
						}
					?>>ปกติ ไม่ใช้งาน</option>
                    
                     <option value="abnormal" <?
                    if($asset_status=='abnormal'){
						?> selected<?
						}
					?>>ผิดปกติ ใช้งานไม่ได้ เสีย</option>
                    
                    <option value="disappear" <?
                    if($asset_status=='disappear'){
						?> selected<?
						}
					?>>สูญหาย</option>
                    
                    </select></td>
						</tr>
                         <tr>
							<td  align="right"><strong>Action :</strong></td>
							<td ><input type="text" class="form-control" style='width:200px;' id="asset_action" value="<?=$asset_action;?>" ></td>
						</tr>
                        <tr>
							<td  align="right"><strong>Upload File :</strong></td>
							<td ><form id="form2" enctype="multipart/form-data" method="post" action=""><input type="file" class="assetfile" style='width:250px;' id="assetfile" onchange="uploadfilea();"  ></form></td>
						</tr>
                         <tr>
							<td  align="right"><strong>View File :</strong></td>
							<td ><a href="assetfile/<?=$assetfile?>" target="_blank"><?=$assetfile?></a></td>
						</tr>
						
					</table>
				</div>
				<div class="col-sm-6">
					<table >
						<tr>
							<td  align="right">&nbsp;</td>
							<td >&nbsp;</td>
						</tr>
						<tr>
							<td  align="right"><strong>Serial :</strong></td>
							<td ><input type="text" class="form-control" style='width:200px;' id="serialnumber" value="<?=$serialnumber;?>" ></td>
						</tr>
						
						<tr>
							<td  align="right"><strong>Mac Address :</strong></td>
							<td ><input type="text" class="form-control" style='width:200px;' id="macaddress" value="<?=$macaddress?>"></td>
						</tr>
						<tr>
							<td  align="right"><strong>IP Address :</strong></td>
							<td ><input type="text" class="form-control" style='width:200px;' id="ipaddress" value="<?=$ipaddress?>"></td>
						</tr>
						<tr>
							<td  align="right"><strong>Po Open Date :</strong></td>
							<td ><input type="text" class="form-control" style='width:200px;' id="po_open_date" value="<?=$po_open_date;?>"></td>
						</tr>
						<tr>
							<td  align="right"><strong>Purchase Date :</strong></td>
							<td ><input type="text" class="form-control" style='width:200px;' id="purchase_date" value="<?=$purchase_date;?>"></td>
						</tr>
						<tr>
							<td  align="right"><strong>Purchase Price :</strong></td>
							<td ><input type="text" class="form-control" style='width:200px;' id="purchase_price" value="<?=$purchase_price;?>" ></td>
						</tr>
						<tr>
							<td  align="right"><strong>Warranty Start :</strong></td>
							<td ><input type="text" class="form-control" style='width:200px;' id="warranty_start" value="<?=$warranty_start;?>" ></td>
						</tr>
						<tr>
							<td  align="right"><strong>Warranty End :</strong></td>
							<td ><input type="text" class="form-control" style='width:200px;' id="warranty_end" value="<?=$warranty_end;?>" ></td>
						</tr>
						<tr>
							<td  align="right"></td>
							<td align="right" ><input type="button" value="กลับไปหน้าแรก" onclick="window.location='view_asset.php'">&nbsp;<button class='btn btn-warning' onclick="update_asset('<?=$asset_no?>')">update</button></td>
						</tr>
					</table>
				</div>
                
                <div class="col-sm-12">
                
                <HR>
                <table id="example" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th width="62">Date</th>
                                <th width='94'>Transfer From</th>
                                <th width='107'>Transfer To</th>
                                <th width='108'>Transfer Reason</th>
                            </tr>
                        </thead>
                        <tbody>
                        	
                        <?php 
                       
                        
                            $sql = "select convert(varchar, transfer_date, 103)as transfer_datedate,
                            convert(varchar, transfer_date, 108)as transfer_datetime,*
							
                            from  tbasset_transfer where asset_no='$asset_no'   "; 
                       
						$sql.=" order by transfer_date desc";
						
                        $res = mssql_query($sql);
                        while ($row = mssql_fetch_array($res)) {
                           
							
                            ?>

                            <tr>
                                <td><?=$row['transfer_datedate']?></a></td>
                                <td><?=$row['transfer_from']?></td>
                                <td><?=$row['transfer_to']?></td>
                                <td><?=lang_thai_from_database($row['transfer_reason'])?></td>
                            </tr>

                        <?php

                        }
                         
                        ?>  
                           
                            
                        </tbody>
                       
                  </table>
                </div>
                
                <?
				$db="dhrdb";
				$sqldb=mssql_connect($host,$username,$password) or die("Cannot connect");
				mssql_select_db($db);
				?>
				<div class="col-sm-12">
                
                <HR>
                <table id="example" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th width="62">JOB ID</th>
                                <th width='94'>CREATE</th>
                                <th width='107'>RESPONSE</th>
                                <th width='108'>CLOSE</th>
                                <th width='69'> STATUS</th>
                                <th width="95">TOPIC</th>
                                  <th width="66">Solution</th>
                                <th width="66">TYPE</th>
                                <th width="74"> NAME</th>
                              
                            </tr>
                        </thead>
                        <tbody>

                        <?php 
                       
                        
                            $sql = "select convert(varchar, create_date, 103)as create_date_date,
                            convert(varchar, create_date, 108)as create_date_time,
							convert(varchar, solution_date, 103)as solution_date_date,
                            convert(varchar, solution_date, 108)as solution_date_time,
							convert(varchar, due_date, 103)as due_datedate,
							 piority_range, level_range,
                            empno,job_id,problem_type,problem_topic,job_status,approve_status ,problem_detail 
                            from tbitservice_list where asset_no='$asset_no' 
							
							or asset_no2='$asset_no' or asset_no3='$asset_no' or asset_no4='$asset_no' or asset_no5='$asset_no'  "; 
                       
						$sql.=" order by create_date desc";
						
                        $res = mssql_query($sql);
                        while ($row = mssql_fetch_array($res)) {
                            $job_id = $row['job_id'];
                           // $empno = $row['empno'];
                            $full_name = get_full_name($row['empno']);
                            $problem_type = $row['problem_type'];
                            $job_status = $row['job_status'];
							 $approve_status = $row['approve_status'];
                            $problem_topic = lang_thai_from_database($row['problem_topic']);
							 $problem_detail = lang_thai_from_database($row['problem_detail']);
                            $create_date = $row['create_date_date']." ".$row['create_date_time'];
							$close_date  = $row['solution_date_date']." ".$row['solution_date_time'];
							$piority_range = $row['piority_range'];
							$level_range = $row['level_range'];
							$due_datedate = $row['due_datedate'];
							if($problem_type=='Develop'){
								$filename = "pop_it_program.php";
									}else{
								$filename = "pop_it_service.php";
								}
							
                            if($job_status=="New"){
                                $job_status_show = "<span class='label label-danger'>$job_status</span> | <a href='$filename?job_id=".$row['job_id']."' target='_blank'>Print</a>";
                            }else if($job_status=="In progress"){
                                $job_status_show = "<span class='label label-warning'>$job_status</span> | <a href='$filename?job_id=".$row['job_id']."' target='_blank'>Print</a>";
                            }else if($job_status=="Close"){
                                $job_status_show = "<span class='label label-success'>$job_status</span> | <a href='$filename?job_id=".$row['job_id']."' target='_blank'>Print</a>";
                            }
							if($job_status=="New" && empty($approve_status)){
									 $job_status_show = "<span class='label label-default'>wait approve</span>";
								}
							
                            ?>

                            <tr>
                                <td><a href="it_service_list.php?job_id=<?=$job_id?>&status=view" target='_blank'><?=$job_id?></a></td>
                                <td><?=$create_date?></td>
                                <td><?
                            $select1="select top 1 convert(varchar, create_date, 103)as res_create_date,
                            convert(varchar, create_date, 108)as res_create_time from  tbitservice_chat where job_id = '".$row['job_id']."' and job_status='In progress' order by id asc";
									$re1=mssql_query($select1);
									$num1=mssql_num_rows($re1);
									if($num1>0){
										$row1=mssql_fetch_array($re1);
										echo $row1['res_create_date']." ".$row1['res_create_time'];
										}
									?></td>
                                <td><?=$close_date?></td>
                                <td><center><?=$job_status_show?></center></td>
                                <td>-&nbsp;<?=$problem_topic?><BR>-&nbsp;<?=$problem_detail?></td>
                                <td><?
								
								$selectc = "select message from tbitservice_chat where job_id='$job_id' order by id asc";
								$rec = mssql_query($selectc);
								$numc=mssql_num_rows($rec);
								if($numc>0){
								 while($rowc = mssql_fetch_array($rec)){
										echo "-&nbsp;".lang_thai_from_database($rowc['message'])."<BR>";
									}
								}
								
								?></td>
                                <td <?
                                if($problem_type=='Develop'){
									echo "style='background-color:rgb(51, 153, 255)'";
									}
								if($problem_type=='Software'){
									echo "style='background-color:rgb(153, 51, 255)'";
									}
								if($problem_type=='Hardware'){
									echo "style='background-color:rgb(102, 255, 178)'";
									}
								if($problem_type=='Network'){
									echo "style='background-color:rgb(255, 153, 51)'";
									}
								if($problem_type=='Other'){
									echo "style='background-color:rgb(192, 192, 192)'";
									}
								?>><?=$problem_type?></td>
                                <td><?=$full_name?></td>
                            </tr>

                        <?php

                        }
                         
                        ?>  
                           
                            
                        </tbody>
                       
                  </table>
                </div>
				<?
				
                $db="dinvb";
				$sqldb=mssql_connect($host,$username,$password) or die("Cannot connect");
				mssql_select_db($db);
				?>
				
<?
				echo "###".$empno;
			}else{
				echo "No data";
			}
			
			
			
		}
		if($status=='show_asset_wh'){ 
			$asset_no = $_REQUEST['asset_no'];
			$select="select convert(varchar, po_open_date, 103)as po_open_date2,
				convert(varchar, po_open_date, 108)as po_open_time,
				convert(varchar, purchase_date, 103)as purchase_date2,
				convert(varchar, purchase_date, 108)as purchase_time,
				convert(varchar, warranty_start, 103)as warranty_start_date,
				convert(varchar, warranty_start, 108)as warranty_start_time,
				convert(varchar, warranty_end, 103)as warranty_end_date,
				convert(varchar, warranty_end, 108)as warranty_end_time,*
				from  tbasset where  asset_no= '$asset_no' ";
			$re=mssql_query($select);
			$num=mssql_num_rows($re);
			if($num>0){
				$row=mssql_fetch_array($re);
				$id = $row['id'];
				$asset_no = $row['asset_no'];
				$asset_name = iconv("tis-620", "utf-8", $row['asset_name']);
				$empno = $row["empno"];
				$owner = iconv("tis-620", "utf-8", $row['owner']);
				$serialnumber = $row['serialnumber'];
				$location =$row['location'];
				$manufacturer = iconv("tis-620", "utf-8", $row['manufacturer']);
				
				$model = lang_thai_from_database($row['model']);
				$macaddress = lang_thai_from_database($row['macaddress']);
				$ipaddress = lang_thai_from_database($row['ipaddress']);
				$asset_group =iconv("tis-620", "utf-8", $row['asset_group']);
				$device_type =lang_thai_from_database($row['device_type']);
				$po_open_date = $row['po_open_date2'];//." ".$row['po_open_time'];
				$purchase_date = $row['purchase_date2'];//." ".$row['purchase_time'];
				$purchase_price = $row['purchase_price'];
				$warranty_start = $row['warranty_start_date'];//." ".$row['warranty_start_time'];
				$warranty_end = $row['warranty_end_date'];//." ".$row['warranty_end_time'];
				$asset_status = $row['asset_status'];
				$assetfile= $row['assetfile'];
				$asset_action = lang_thai_from_database($row['asset_action']);
				?>
				
				<div class="col-sm-6">

					<table cellpadding="10">
						<tr>
							<td  align="right"><strong>Asset No :</strong></td>
							<td ><?=$row['asset_no']?></td>
						</tr>
						<tr>
							<td  align="right"><strong>Location :</strong></td>
							<td ><select id="location"  class="form-control ">
    
					<?
						$select="select distinct location from tbasset order by location asc";
						$re=mssql_query($select);
						$num=mssql_num_rows($re);
						if($num>0){
							while($row=mssql_fetch_array($re)){  
							?> <option value="<?=$row['location']?>" <?
								if($location==$row['location']){
									?> selected<?
								}
								?>><?=$row['location']?></option><?
							}
						}
						?>
						</select></td>
						</tr>
						<tr>
							<td  align="right"><strong>Asset Name :</strong></td>
							<td ><input type="text" class="form-control" style='width:200px;' id="asset_name" value="<?=$asset_name?>" ></td>
						</tr>
						<tr>
							<td  align="right"><strong>empno :</strong></td>
							<td ><div id='show_empno'></div></td>
						</tr>
					
						<tr>
							<td  align="right"><strong>Asset Group :</strong></td>
							<td ><select id="asset_group"  class="form-control " >
                            <option value="">Select</option> <?
						$select="select * from tbasset_group where asset_group='Warehouse Equipment' order by id asc";
						$re=mssql_query($select);
						$num=mssql_num_rows($re);
						if($num>0){
							while($row=mssql_fetch_array($re)){  
							?> <option value="<?=$row['asset_group']?>" <?
								if($asset_group==$row['asset_group']){
									?> selected<?
								}
								?>><?=$row['asset_group']?></option><?
							}
						}
						?></select></td>
						</tr>
                        
                        <tr>
							<td  align="right"><strong>Device Type :</strong></td>
							<td ><select id="device_type"  class="form-control " >
                            <option value="">Select</option> <?
						$select="select distinct device_type from tbasset where  asset_group='Warehouse Equipment' and device_type is not null order by device_type asc";
						$re=mssql_query($select);
						$num=mssql_num_rows($re);
						if($num>0){
							while($row=mssql_fetch_array($re)){  
							?> <option value="<?=$row['device_type']?>" <?
								if($device_type==$row['device_type']){
									?> selected<?
								}
								?>><?=$row['device_type']?></option><?
							}
						}
						?></select></td>
						</tr>
						
						<tr>
							<td  align="right"><strong>Manufacturer :</strong></td>
							<td ><input type="text" class="form-control" style='width:200px;' id="manufacturer" value="<?=$manufacturer;?>" ></td>
						</tr>
						<tr>
							<td  align="right"><strong>Model :</strong></td>
							<td ><input type="text" class="form-control" style='width:200px;' id="model" value="<?=$model;?>" ></td>
						</tr>
                        <tr>
							<td  align="right"><strong>สถานะของอุปกรณ์ :</strong></td>
							<td ><select id="asset_status" class="form-control" style="background-color:#FF9">
                    <option value="">Select</option>
                    <option value="normal_use" <?
                    if($asset_status=='normal_use'){
						?> selected<?
						}
					?>>ปกติ ยังใช้งานอยู่</option>
                    
                    <option value="normal_nouse" <?
                    if($asset_status=='normal_nouse'){
						?> selected<?
						}
					?>>ปกติ ไม่ใช้งาน</option>
                    
                     <option value="abnormal" <?
                    if($asset_status=='abnormal'){
						?> selected<?
						}
					?>>ผิดปกติ ใช้งานไม่ได้ เสีย</option>
                    
                    <option value="disappear" <?
                    if($asset_status=='disappear'){
						?> selected<?
						}
					?>>สูญหาย</option>
                    
                    </select></td>
						</tr>
                         <tr>
							<td  align="right"><strong>Action :</strong></td>
							<td ><input type="text" class="form-control" style='width:200px;' id="asset_action" value="<?=$asset_action;?>" ></td>
						</tr>
                        <tr>
							<td  align="right"><strong>Upload File :</strong></td>
							<td ><form id="form2" enctype="multipart/form-data" method="post" action=""><input type="file" class="assetfile" style='width:250px;' id="assetfile" onchange="uploadfilea();"  ></form></td>
						</tr>
                         <tr>
							<td  align="right"><strong>View File :</strong></td>
							<td ><a href="assetfile/<?=$assetfile?>" target="_blank"><?=$assetfile?></a></td>
						</tr>
						
					</table>
				</div>
				<div class="col-sm-6">
					<table >
						<tr>
							<td  align="right">&nbsp;</td>
							<td >&nbsp;</td>
						</tr>
						<tr>
							<td  align="right"><strong>Serial :</strong></td>
							<td ><input type="text" class="form-control" style='width:200px;' id="serialnumber" value="<?=$serialnumber;?>" ></td>
						</tr>
						
						<tr>
							<td  align="right"><strong>Mac Address :</strong></td>
							<td ><input type="text" class="form-control" style='width:200px;' id="macaddress" value="<?=$macaddress?>"></td>
						</tr>
						<tr>
							<td  align="right"><strong>IP Address :</strong></td>
							<td ><input type="text" class="form-control" style='width:200px;' id="ipaddress" value="<?=$ipaddress?>"></td>
						</tr>
						<tr>
							<td  align="right"><strong>Po Open Date :</strong></td>
							<td ><input type="text" class="form-control" style='width:200px;' id="po_open_date" value="<?=$po_open_date;?>"></td>
						</tr>
						<tr>
							<td  align="right"><strong>Purchase Date :</strong></td>
							<td ><input type="text" class="form-control" style='width:200px;' id="purchase_date" value="<?=$purchase_date;?>"></td>
						</tr>
						<tr>
							<td  align="right"><strong>Purchase Price :</strong></td>
							<td ><input type="text" class="form-control" style='width:200px;' id="purchase_price" value="<?=$purchase_price;?>" ></td>
						</tr>
						<tr>
							<td  align="right"><strong>Warranty Start :</strong></td>
							<td ><input type="text" class="form-control" style='width:200px;' id="warranty_start" value="<?=$warranty_start;?>" ></td>
						</tr>
						<tr>
							<td  align="right"><strong>Warranty End :</strong></td>
							<td ><input type="text" class="form-control" style='width:200px;' id="warranty_end" value="<?=$warranty_end;?>" ></td>
						</tr>
						<tr>
							<td  align="right"></td>
							<td align="right" ><input type="button" value="กลับไปหน้าแรก" onclick="window.location='view_asset.php'">&nbsp;<button class='btn btn-warning' onclick="update_asset('<?=$asset_no?>')">update</button></td>
						</tr>
					</table>
				</div>
                
                
                
                <?
				$db="dhrdb";
				$sqldb=mssql_connect($host,$username,$password) or die("Cannot connect");
				mssql_select_db($db);
				?>
				<div class="col-sm-12">
                
                <HR>
                <table id="example" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th width="62">JOB ID</th>
                                <th width='94'>CREATE</th>
                                <th width='107'>RESPONSE</th>
                                <th width='108'>CLOSE</th>
                                <th width='69'> STATUS</th>
                                <th width="95">TOPIC</th>
                                  <th width="66">Solution</th>
                                <th width="66">TYPE</th>
                                <th width="74"> NAME</th>
                              
                            </tr>
                        </thead>
                        <tbody>

                        <?php 
                       
                        
                            $sql = "select convert(varchar, create_date, 103)as create_date_date,
                            convert(varchar, create_date, 108)as create_date_time,
							convert(varchar, solution_date, 103)as solution_date_date,
                            convert(varchar, solution_date, 108)as solution_date_time,
							convert(varchar, due_date, 103)as due_datedate,
							 piority_range, level_range,
                            empno,job_id,problem_type,problem_topic,job_status,approve_status ,problem_detail 
                            from tbitservice_list where asset_no='$asset_no'   "; 
                       
						$sql.=" order by create_date desc";
						
                        $res = mssql_query($sql);
                        while ($row = mssql_fetch_array($res)) {
                            $job_id = $row['job_id'];
                            $empno = $row['empno'];
                            $full_name = get_full_name($empno);
                            $problem_type = $row['problem_type'];
                            $job_status = $row['job_status'];
							 $approve_status = $row['approve_status'];
                            $problem_topic = lang_thai_from_database($row['problem_topic']);
							 $problem_detail = lang_thai_from_database($row['problem_detail']);
                            $create_date = $row['create_date_date']." ".$row['create_date_time'];
							$close_date  = $row['solution_date_date']." ".$row['solution_date_time'];
							$piority_range = $row['piority_range'];
							$level_range = $row['level_range'];
							$due_datedate = $row['due_datedate'];
							if($problem_type=='Develop'){
								$filename = "pop_it_program.php";
									}else{
								$filename = "pop_it_service.php";
								}
							
                            if($job_status=="New"){
                                $job_status_show = "<span class='label label-danger'>$job_status</span> | <a href='$filename?job_id=".$row['job_id']."' target='_blank'>Print</a>";
                            }else if($job_status=="In progress"){
                                $job_status_show = "<span class='label label-warning'>$job_status</span> | <a href='$filename?job_id=".$row['job_id']."' target='_blank'>Print</a>";
                            }else if($job_status=="Close"){
                                $job_status_show = "<span class='label label-success'>$job_status</span> | <a href='$filename?job_id=".$row['job_id']."' target='_blank'>Print</a>";
                            }
							if($job_status=="New" && empty($approve_status)){
									 $job_status_show = "<span class='label label-default'>wait approve</span>";
								}
							
                            ?>

                            <tr>
                                <td><a href="it_service_list.php?job_id=<?=$job_id?>&status=view" target='_blank'><?=$job_id?></a></td>
                                <td><?=$create_date?></td>
                                <td><?
                            $select1="select top 1 convert(varchar, create_date, 103)as res_create_date,
                            convert(varchar, create_date, 108)as res_create_time from  tbitservice_chat where job_id = '".$row['job_id']."' and job_status='In progress' order by id asc";
									$re1=mssql_query($select1);
									$num1=mssql_num_rows($re1);
									if($num1>0){
										$row1=mssql_fetch_array($re1);
										echo $row1['res_create_date']." ".$row1['res_create_time'];
										}
									?></td>
                                <td><?=$close_date?></td>
                                <td><center><?=$job_status_show?></center></td>
                                <td>-&nbsp;<?=$problem_topic?><BR>-&nbsp;<?=$problem_detail?></td>
                                <td><?
								
								$selectc = "select message from tbitservice_chat where job_id='$job_id' order by id asc";
								$rec = mssql_query($selectc);
								$numc=mssql_num_rows($rec);
								if($numc>0){
								 while($rowc = mssql_fetch_array($rec)){
										echo "-&nbsp;".lang_thai_from_database($rowc['message'])."<BR>";
									}
								}
								
								?></td>
                                <td <?
                                if($problem_type=='Develop'){
									echo "style='background-color:rgb(51, 153, 255)'";
									}
								if($problem_type=='Software'){
									echo "style='background-color:rgb(153, 51, 255)'";
									}
								if($problem_type=='Hardware'){
									echo "style='background-color:rgb(102, 255, 178)'";
									}
								if($problem_type=='Network'){
									echo "style='background-color:rgb(255, 153, 51)'";
									}
								if($problem_type=='Other'){
									echo "style='background-color:rgb(192, 192, 192)'";
									}
								?>><?=$problem_type?></td>
                                <td><?=$full_name?></td>
                            </tr>

                        <?php

                        }
                         
                        ?>  
                           
                            
                        </tbody>
                       
                  </table>
                </div>
				<?
				
                $db="dinvb";
				$sqldb=mssql_connect($host,$username,$password) or die("Cannot connect");
				mssql_select_db($db);
				?>
				
<?
				echo "###".$empno;
			}else{
				echo "No data";
			}
			
			
			
		}
		if($status=='show_asset_old'){
			$asset_no = $_REQUEST['asset_no'];
			$select="select convert(varchar, po_open_date, 103)as po_open_date,* from  tbasset where  asset_no= '$asset_no' ";
			$re=mssql_query($select);
			$num=mssql_num_rows($re);
			if($num>0){
				$row=mssql_fetch_array($re);
				$manufacturer = $row['manufacturer'];
				$device_type =$row['device_type'];
				$model = $row['model'];
				$macaddress = $row['macaddress'];
				$ipaddress = $row['ipaddress'];
				$asset_group =$row['asset_group'];
				
				?>
				<table  cellpadding="0"  class="table table-striped table-bordered datatables"  cellspacing="1" >
					<tr>
						<td width="116" align="center"><strong>Asset No</strong></td>
						<td width="82" align="center"><strong>Asset Name</strong></td>
						<td width="84" align="center"><strong>Owner</strong></td>
						<td width="49" align="center"><strong>Serial</strong></td>
						<td width="75" align="center"><strong>Location</strong></td>
						<td width="75" align="center"><strong>Picture</strong></td>
					</tr>
					
					 <tr>
						<td width="116" align="center"><?=$row['asset_no']?></td>
						<td width="82" align="center"><input type="text" class="form-control" id="asset_name" value="<?=iconv("tis-620", "utf-8", $row['asset_name']);?>" onchange="update_asset('<?=$row['asset_no']?>');"></td>
						<td width="84" align="center"><input type="text" class="form-control" id="owner" value="<?=iconv("tis-620", "utf-8", $row['owner']);?>" onchange="update_asset('<?=$row['asset_no']?>');"></td>
						<td width="49" align="center"><input type="text" class="form-control" id="serialnumber" value="<?=iconv("tis-620", "utf-8", $row['serialnumber']);?>" onchange="update_asset('<?=$row['asset_no']?>');"></td>
						<td width="75" align="center"><?=$row['location']?></td>
						<td width="75" align="center"><i class="fa fa-camera fa-2x"  onclick="showpicture('<?=$row['asset_no']?>')"></i></td>
					</tr>
				</table>
				<?
			}else{
				echo "No data";
			}
			
		}
		
		
		if($status=='update_asset'){
			    //$location = $_REQUEST['location'];
				$asset_no = $_REQUEST['asset_no'];
				$asset_name = iconv("utf-8","tis-620", $_REQUEST['asset_name'] );
				$empno = $_POST["empno"];
				$owner =  iconv("utf-8","tis-620", $_REQUEST['owner'] );
				$asset_group = $_REQUEST['asset_group'];
				$device_type = iconv("utf-8","tis-620", $_REQUEST['device_type'] );
				$manufacturer = iconv("utf-8","tis-620", $_REQUEST['manufacturer'] );
				$model = iconv("utf-8","tis-620", $_REQUEST['model'] );
				$serialnumber = lang_thai_into_database($_REQUEST['serialnumber']);
				
				$macaddress = lang_thai_into_database($_REQUEST['macaddress']);
				$ipaddress = lang_thai_into_database($_REQUEST['ipaddress']);
				$po_open_date = date_format_uk_into_database($_REQUEST['po_open_date']);
				$purchase_date = date_format_uk_into_database($_REQUEST['purchase_date']);
				$purchase_price = $_REQUEST['purchase_price'];
				$warranty_start = date_format_uk_into_database($_REQUEST['warranty_start']);
				$warranty_end = date_format_uk_into_database($_REQUEST['warranty_end']);
				$asset_status = $_REQUEST['asset_status'];
				$asset_action = lang_thai_into_database($_REQUEST['asset_action']);
				
				
				
					//$target_dir = "assetfile/";
					//$target_file = $target_dir . basename($_FILES["assetfile"]["name"]);
					//$uploadOk = 1;
					//$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
					//$filename = $asset_no.".".$imageFileType;
					//$fileupload = $target_dir.$filename;
					// Check if image file is a actual image or fake image
						//move_uploaded_file($_FILES["assetfile"]["tmp_name"], $fileupload);
						//echo $_FILES["assetfile"]["name"];
				
				$select="select * from  tbasset where  asset_no= '$asset_no' ";
				$re=mssql_query($select);
				$num=mssql_num_rows($re);
				if($num>0){
					$update = "update tbasset 
					set asset_name='$asset_name',
						empno='$empno',
						owner='$owner',
						asset_group='$asset_group',
						device_type='$device_type',
						manufacturer='$manufacturer',
						model='$model',
						serialnumber='$serialnumber',
						macaddress='$macaddress',
						ipaddress='$ipaddress',
						po_open_date='$po_open_date',
						purchase_date='$purchase_date',
						purchase_price='$purchase_price',
						warranty_start='$warranty_start',
						warranty_end='$warranty_end',asset_status='$asset_status',asset_action='$asset_action',assetfile='$filename'
					where asset_no='$asset_no'";
					
					mssql_query($update);
					
					
					
					
				}
				
			}
	if($status=='show_from_add'){
		$asset_no = $_REQUEST['asset_no'];
		?>
		<div class="col-sm-6">

<table cellpadding="10">
				<tr>
					<td  align="right"><strong>Asset No :</strong></td>
					<td ><?=$asset_no?><!--<input type='hidden' id="asset_no" value="<?=$asset_no?>">--></td>
				</tr>
				<tr>
					<td  align="right"><strong>Location :</strong></td>
					<td > 
						<select id="location"  class="form-control " >
    
					<?
						$select="select distinct location from tbasset order by location asc";
						$re=mssql_query($select);
						$num=mssql_num_rows($re);
						if($num>0){
							while($row=mssql_fetch_array($re)){  
							?> <option value="<?=$row['location']?>" <?
								if($location==$row['location']){
									?> selected<?
								}
								?>><?=$row['location']?></option><?
							}
						}
						?>
						</select>
					</td>
				</tr>
				<tr>
					<td  align="right"><strong>Asset Name :</strong></td>
					<td ><input type="text" class="form-control" style='width:200px;' id="asset_name" value="" ></td>
				</tr>
				<tr>
					<td  align="right"><strong>empno :</strong></td>
					<td ><div id='show_empno'></div></td>
				</tr>
				
				<tr>
					<td  align="right"><strong>Asset Group :</strong></td>
					<td ><select id="asset_group"  class="form-control " >
					<option value="">Select</option>
					<?
						$select="select * from tbasset_group order by id asc";
						$re=mssql_query($select);
						$num=mssql_num_rows($re);
						if($num>0){
							while($row=mssql_fetch_array($re)){  
							?> <option value="<?=$row['asset_group']?>" <?
								if($asset_group==$row['asset_group']){
									?> selected<?
								}
								?>><?=$row['asset_group']?></option><?
							}
						}
						?></select>
                    </td>
				</tr>
                <tr>
							<td  align="right"><strong>Device Type :</strong></td>
							<td ><select id="device_type"  class="form-control " >
                            <option value="">Select</option> <?
						$select="select distinct device_type from tbasset where device_type is not null order by device_type asc";
						$re=mssql_query($select);
						$num=mssql_num_rows($re);
						if($num>0){
							while($row=mssql_fetch_array($re)){  
							?> <option value="<?=$row['device_type']?>" <?
								if($device_type==$row['device_type']){
									?> selected<?
								}
								?>><?=$row['device_type']?></option><?
							}
						}
						?></select></td>
						</tr>
				<!--<tr>
					<td  align="right"><strong>Device Type :</strong></td>
					<td ><input type="text" class="form-control" style='width:200px;' id="device_type" value="" ></td>
				</tr>-->
				<tr>
					<td  align="right"><strong>Manufacturer :</strong></td>
					<td ><input type="text" class="form-control" style='width:200px;' id="manufacturer" value="" ></td>
				</tr>
				<tr>
					<td  align="right"><strong>Model :</strong></td>
					<td ><input type="text" class="form-control" style='width:200px;' id="model" value="" ></td>
				</tr>
				
			</table>
		</div>
		<div class="col-sm-6">
			<table >
				<tr>
					<td  align="right">&nbsp;</td>
					<td >&nbsp;</td>
				</tr>
				<tr>
					<td  align="right"><strong>Serial :</strong></td>
					<td ><input type="text" class="form-control" style='width:200px;' id="serialnumber" value="" ></td>
				</tr>
				<tr>
					<td  align="right"><strong>Mac Address :</strong></td>
					<td ><input type="text" class="form-control" style='width:200px;' id="macaddress" value=""></td>
				</tr>
				<tr>
					<td  align="right"><strong>IP Address :</strong></td>
					<td ><input type="text" class="form-control" style='width:200px;' id="ipaddress" value=""></td>
				</tr>
				<tr>
					<td  align="right"><strong>Po Open Date :</strong></td>
					<td ><input type="text" class="form-control" style='width:200px;' id="po_open_date" value=""></td>
				</tr>
				<tr>
					<td  align="right"><strong>Purchase Date :</strong></td>
					<td ><input type="text" class="form-control" style='width:200px;' id="purchase_date" value=""></td>
				</tr>
				<tr>
					<td  align="right"><strong>Purchase Price :</strong></td>
					<td ><input type="text" class="form-control" style='width:200px;' id="purchase_price" value="" ></td>
				</tr>
				<tr>
					<td  align="right"><strong>Warranty Start :</strong></td>
					<td ><input type="text" class="form-control" style='width:200px;' id="warranty_start" value="" ></td>
				</tr>
				<tr>
					<td  align="right"><strong>Warranty End :</strong></td>
					<td ><input type="text" class="form-control" style='width:200px;' id="warranty_end" value="" ></td>
				</tr>
				<tr>
					<td  align="right"></td>
					<td align="right" ><button class='btn btn-warning' onclick="add_asset()">Add</button></td>
				</tr>
			</table>
		</div>
<?php
		
	}
	if($status=='show_from_add_wh'){
		$asset_no = $_REQUEST['asset_no'];
		?>
		<div class="col-sm-6">

<table cellpadding="10">
				<tr>
					<td  align="right"><strong>Asset No :</strong></td>
					<td ><?=$asset_no?><!--<input type='hidden' id="asset_no" value="<?=$asset_no?>">--></td>
				</tr>
				<tr>
					<td  align="right"><strong>Location :</strong></td>
					<td > 
						<select id="location"  class="form-control " >
    
					<?
						$select="select distinct location from tbasset order by location asc";
						$re=mssql_query($select);
						$num=mssql_num_rows($re);
						if($num>0){
							while($row=mssql_fetch_array($re)){  
							?> <option value="<?=$row['location']?>" <?
								if($location==$row['location']){
									?> selected<?
								}
								?>><?=$row['location']?></option><?
							}
						}
						?>
						</select>
					</td>
				</tr>
				<tr>
					<td  align="right"><strong>Asset Name :</strong></td>
					<td ><input type="text" class="form-control" style='width:200px;' id="asset_name" value="" ></td>
				</tr>
				<tr>
					<td  align="right"><strong>empno :</strong></td>
					<td ><div id='show_empno'></div></td>
				</tr>
				
				<tr>
					<td  align="right"><strong>Asset Group :</strong></td>
					<td ><select id="asset_group"  class="form-control " >
					<option value="">Select</option>
					<?
						$select="select * from tbasset_group where asset_group='Warehouse Equipment' order by id asc";
						$re=mssql_query($select);
						$num=mssql_num_rows($re);
						if($num>0){
							while($row=mssql_fetch_array($re)){  
							?> <option value="<?=$row['asset_group']?>" <?
								if($asset_group==$row['asset_group']){
									?> selected<?
								}
								?>><?=$row['asset_group']?></option><?
							}
						}
						?></select>
                    </td>
				</tr>
                <tr>
							<td  align="right"><strong>Device Type :</strong></td>
							<td ><select id="device_type"  class="form-control " >
                            <option value="">Select</option> <?
						$select="select distinct device_type from tbasset where asset_group='Warehouse Equipment' and device_type is not null order by device_type asc";
						$re=mssql_query($select);
						$num=mssql_num_rows($re);
						if($num>0){
							while($row=mssql_fetch_array($re)){  
							?> <option value="<?=$row['device_type']?>" <?
								if($device_type==$row['device_type']){
									?> selected<?
								}
								?>><?=$row['device_type']?></option><?
							}
						}
						?></select></td>
						</tr>
				<!--<tr>
					<td  align="right"><strong>Device Type :</strong></td>
					<td ><input type="text" class="form-control" style='width:200px;' id="device_type" value="" ></td>
				</tr>-->
				<tr>
					<td  align="right"><strong>Manufacturer :</strong></td>
					<td ><input type="text" class="form-control" style='width:200px;' id="manufacturer" value="" ></td>
				</tr>
				<tr>
					<td  align="right"><strong>Model :</strong></td>
					<td ><input type="text" class="form-control" style='width:200px;' id="model" value="" ></td>
				</tr>
				
			</table>
		</div>
		<div class="col-sm-6">
			<table >
				<tr>
					<td  align="right">&nbsp;</td>
					<td >&nbsp;</td>
				</tr>
				<tr>
					<td  align="right"><strong>Serial :</strong></td>
					<td ><input type="text" class="form-control" style='width:200px;' id="serialnumber" value="" ></td>
				</tr>
				<tr>
					<td  align="right"><strong>Mac Address :</strong></td>
					<td ><input type="text" class="form-control" style='width:200px;' id="macaddress" value=""></td>
				</tr>
				<tr>
					<td  align="right"><strong>IP Address :</strong></td>
					<td ><input type="text" class="form-control" style='width:200px;' id="ipaddress" value=""></td>
				</tr>
				<tr>
					<td  align="right"><strong>Po Open Date :</strong></td>
					<td ><input type="text" class="form-control" style='width:200px;' id="po_open_date" value=""></td>
				</tr>
				<tr>
					<td  align="right"><strong>Purchase Date :</strong></td>
					<td ><input type="text" class="form-control" style='width:200px;' id="purchase_date" value=""></td>
				</tr>
				<tr>
					<td  align="right"><strong>Purchase Price :</strong></td>
					<td ><input type="text" class="form-control" style='width:200px;' id="purchase_price" value="" ></td>
				</tr>
				<tr>
					<td  align="right"><strong>Warranty Start :</strong></td>
					<td ><input type="text" class="form-control" style='width:200px;' id="warranty_start" value="" ></td>
				</tr>
				<tr>
					<td  align="right"><strong>Warranty End :</strong></td>
					<td ><input type="text" class="form-control" style='width:200px;' id="warranty_end" value="" ></td>
				</tr>
				<tr>
					<td  align="right"></td>
					<td align="right" ><button class='btn btn-warning' onclick="add_asset()">Add</button></td>
				</tr>
			</table>
		</div>
<?php
		
	}
		
	if($status=='add_asset'){
		$asset_no = $_REQUEST['asset_no'];
		$location = $_REQUEST['location'];
		$asset_name = iconv("utf-8","tis-620", $_REQUEST['asset_name'] );
		$empno = $_POST["empno"];
		$owner =  iconv("utf-8","tis-620", $_REQUEST['owner'] );
		$asset_group = iconv("utf-8","tis-620", $_REQUEST['asset_group'] );
		$device_type = iconv("utf-8","tis-620", $_REQUEST['device_type'] );
		$manufacturer = iconv("utf-8","tis-620", $_REQUEST['manufacturer'] );
		$model = iconv("utf-8","tis-620", $_REQUEST['model'] );
		$serialnumber = lang_thai_into_database($_REQUEST['serialnumber']);
		
		$macaddress = lang_thai_into_database($_REQUEST['macaddress']);
		$ipaddress = lang_thai_into_database($_REQUEST['ipaddress']);
		$po_open_date = date_format_uk_into_database($_REQUEST['po_open_date']);
		$purchase_date = date_format_uk_into_database($_REQUEST['purchase_date']);
		$purchase_price = $_REQUEST['purchase_price'];
		$warranty_start = date_format_uk_into_database($_REQUEST['warranty_start']);
		$warranty_end = date_format_uk_into_database($_REQUEST['warranty_end']);
		//$asset_status = $_REQUEST['asset_status'];
		
		$sql = "insert into tbasset 
			(asset_no,base_location,location,asset_name,empno,owner,asset_group,device_type,manufacturer,model,serialnumber,macaddress,ipaddress,po_open_date,purchase_date,purchase_price,warranty_start,warranty_end,asset_status,pm_type)
			values
			('$asset_no','$location','$location','$asset_name','$empno','$owner','$asset_group','$device_type','$manufacturer','$model','$serialnumber','$macaddress','$ipaddress','$po_open_date','$purchase_date','$purchase_price','$warranty_start','$warranty_end','normal_use','NON PC')";
		mssql_query($sql);
	}
	
	
	
	
	
	if($status=='save_pm'){
		$week = $_REQUEST['week'];
		$month= $_REQUEST['month'];
		$year= $_REQUEST['year'];
		$txtstatus = $_REQUEST['txtstatus'];
		$asset_no= $_REQUEST['asset_no'];
		$location = $_REQUEST['location'];
		if($txtstatus=='delete'){
				
				$del = "delete from tbasset_pm where asset_no='$asset_no' and week='$week' and month='$month' and year ='$year'";
				mssql_query($del);
			//	echo $del;
				
			}else{
			
			
		$ins = "insert into tbasset_pm(asset_no, year, month, week, location) values('$asset_no', '$year', '$month', '$week', '$location')";
		mssql_query($ins);
		//echo $ins;
			
			}
		
					
					
		}
	if($status=='show_pm' ){
		$location = $_REQUEST['location'];
		$asset_group = $_REQUEST['asset_group'];
		$year= $_REQUEST['year'];
		?>
		<table width="100%" border="0" cellspacing="0" cellpadding="0" >
		  <tr>
		    <td align="center" bgcolor="#CCCCCC">
            
			<table width="100%" border="0" cellspacing="1" cellpadding="0" >
		 <thead >
		  <tr>
		    <td align="center" width="50" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid"><strong>Asset Name</strong></td>
            <?
			$month2 = array('','Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');
			for($i=1;$i<=12;$i++){
				?><td align="center" width="33" style="border-right:1px solid; border-bottom:1px solid"><strong><?
                echo $month2[$i]; 
				?></strong></td><?
			}
	
				?>
		    
	      </tr>
           <tr>
		    <td align="center" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid">&nbsp;</td>
            <?
			for($i=1;$i<=12;$i++){
				?><td align="center" width="33" style="border-right:1px solid; border-bottom:1px solid">
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    


				<?
            for($ii=1;$ii<=4;$ii++){
				?><td style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid">W<?=$ii?></td><?
               
			?><?	
			}
			?>  </tr></table>
</td><?
			}
			?>
		   
            
		    </tr>
            </thead>
            <tbody >
          <?
		  if($asset_group!=''){
			  	$select="SELECT * from tbasset where location='$location' and asset_group='$asset_group' ";
			  }else{
			  	$select="SELECT * from tbasset where location='$location' and asset_group<>'Software' ";
			  }
			  $select .= " and asset_status not in ('abnormal','disappear')";
			  
          
				$re=mssql_query($select);
				$num=mssql_num_rows($re);
				if($num>0){
					while($row=mssql_fetch_array($re)){
						?>
						
                         <tr bgcolor="#FFFFFF">
		    <td align="center" width="50" height="40" style="border-right:1px solid; border-left:1px solid; border-bottom:1px solid"><?
			echo $row['asset_no'];
			echo "<BR>";
            echo iconv("tis-620", "utf-8", $row['asset_name'] );
			?></td>
            <?
			
			
			
			
			for($i=1;$i<=12;$i++){
				?><td align="center" width="33" style="border-right:1px solid; border-bottom:1px solid"><?
               
			   ?>
			   <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    


				<?
            for($ii=1;$ii<=4;$ii++){
				?><td align="center" ><input class="<?=$row['asset_no']?>W<?=$ii?><?=$month2[$i]?>" type="checkbox" onClick="save_pm('W<?=$ii?>','<?=$month2[$i]?>','<?=$year?>','<?=$row['asset_no']?>');" <?
                $select2="select asset_no from tbasset_pm where asset_no = '".$row['asset_no']."' and year='$year' and week='W".$ii."'  and month='".$month2[$i]."' ";
				$re2=mssql_query($select2);
				$num2=mssql_num_rows($re2);
				if($num2>0){
					?> checked="checked"<?
					}
				?>></td><?
               
			?><?	
			}
			?>  </tr></table>
			   <?
			   
				?></td><?
			}
		  ?>
         
          </tr>
          <?
          
					}}
					
					
					
					?>
                    </tbody>
          </table>
          </td></tr>
          </table>
		<?
		}
	
		if($status=='show_asset_pm' ){
			$asset_no = $_REQUEST['asset_no'];
			?>
			<table id="table_pm" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Week PM</th>
                                        <th>Month PM</th>
                                        <th>Year PM</th>
                                        <th>PM Date</th>
                                        
                                       <th>Take Picture</th>
                                        <th>View & Update</th>
                                        
                                    </tr>
                                </thead>
			<?
			$select="select * from    tbasset_pm where asset_no = '$asset_no' order by id asc  ";
				$re=mssql_query($select);
				$num=mssql_num_rows($re);
				if($num>0){
					while($row=mssql_fetch_array($re)){
						
						$pmid=$row['asset_no'].$row['year'].$row['month'].$row['week'];
						
						?>
						 <tr>
                                        <td><?=$row['week']?></td>
                                        <th><?=$row['month']?></th>
                                        <th><?=$row['year']?></th>
                                        <th><?
                 $select2="select top 1 datepm from    tbasset_pm_result where asset_no = '$asset_no' and week='".$row['week']."' and month='".$row['month']."' and year='".$row['year']."' ";
				$re2=mssql_query($select2);
				$num2=mssql_num_rows($re2);
				if($num2>0){
					$row2=mssql_fetch_array($re2);
					echo $row2['datepm'];
					}
										?></th>
                                        <th><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                          <?
                                
                           $picpic = "pm_picture/" .$pmid. ".jpg";
                                            if (file_exists($picpic)) {
                                              $picpic = "showpicture_asset_pm.php?filename=".$picpic;
											   $picpic .= "&asset_no=".$asset_no;
											   $picpic .= "&wweek=".$row['week'];
											    $picpic .= "&mmonth=".$row['month'];
												  $picpic .= "&yyear=".$row['year'];
											  //$picpic .= "?" . rand(10, 100);
                                            } else {
                                              $picpic = "images/cam.png";
                                            }
                                           
                                            ?>
                                            <td align="center"><input type="hidden" id="pmid<?=$pmid?>" value="<?=$pmid?>">
                                              <div class="image-upload" style="text-align:center">
                                             
                                              <label for="fileToUpload<?=$pmid?>">
                                                  <img id="cam<?=$pmid?>" src="<?= $picpic; ?>" width="100" />
                                                </label>

                                                <input name="fileToUpload<?=$pmid?>" onchange="fileSelected_pm('<?=$pmid?>','1');" accept="image/*" capture="camera" id="fileToUpload<?=$pmid?>" type="file" />
                                                
                                                
                                                </div>
                                              <div style="text-align:center"><input type="button" value="view" onClick="showmodal2_pm('<?=$pmid?>');"><input type="hidden" id="fn<?=$pmid?>" value="<?= $picpic ?>"></div>
                                            </td>
                                          <?
                                       

                                        ?>
                                        </tr>
                                      </table></th>
                                        
                                        <th><input type="button" value="View & Update" onclick="location='asset_pm_update.php?asset_no=<?=$asset_no?>&week=<?=$row['week']?>&month=<?=$row['month']?>&year=<?=$row['year']?>'"></th>
                                    </tr>
						<?
						
						}
					}
			?>
			
                                
                               
                            </table>
			<?
			
			}
	
	
	if($status=='update_tbasset_pm_result'){
				$asset_no = $_REQUEST['asset_no'];
				$week = $_REQUEST['week'];
				$month = $_REQUEST['month'];
				$year = $_REQUEST['year'];
				$datepm = $_REQUEST['datepm'];
				$asset_status = $_REQUEST['asset_status'];
				
				
				for($i=0;$i<count($_POST['data_pm']);$i++){
				
				$select="select * from tbasset_pm_result where week = '$week' and month='$month' and year='$year' and asset_no='$asset_no' and pm_condition_id='".$_POST['data_pm'][$i]['pm_condition_id']."'"  ;
				$re=mssql_query($select);
				$num=mssql_num_rows($re);
				if($num>0){
						$update = "update tbasset_pm_result set asset_pm_result='".$_POST['data_pm'][$i]['asset_pm_result']."', asset_pm_solution='".lang_thai_into_database($_POST['data_pm'][$i]['asset_pm_solution'])."',asset_pm_detail='".lang_thai_into_database($_POST['data_pm'][$i]['asset_pm_detail'] )."',datepm='$datepm' where week = '$week' and month='$month' and year='$year' and asset_no='$asset_no' and pm_condition_id='".$_POST['data_pm'][$i]['pm_condition_id']."'";
						mssql_query($update);
					}else{
						$insert = "insert into tbasset_pm_result(asset_no, pm_condition_id, asset_pm_result, asset_pm_solution,asset_pm_detail, week, month, year, datepm) values('$asset_no', '".$_POST['data_pm'][$i]['pm_condition_id']."', '".$_POST['data_pm'][$i]['asset_pm_result']."', '".lang_thai_into_database($_POST['data_pm'][$i]['asset_pm_solution'])."','".lang_thai_into_database($_POST['data_pm'][$i]['asset_pm_detail'])."', '$week', '$month', '$year','$datepm')";
						mssql_query($insert);
						}
					}
					
				 
				$update1 = "update tbasset_pm set asset_status='$asset_status' where asset_no='$asset_no' and week='$week' and month='$month' and year='$year'";
				mssql_query($update1);
				$update2 = "update tbasset set asset_status='$asset_status' where asset_no='$asset_no'";
				mssql_query($update2);
				
				}
				
				
			if($status=='uploadfilea'){
				$asset_no = $_REQUEST['asset_no'];
					if($_FILES["assetfile"]["name"][$i] != ""){
						//echo $_FILES["$type_file[$r]"]["name"][$i];
					$type= strrchr($_FILES["assetfile"]["name"],".");
					$file_new = $asset_no."$type";
					if(move_uploaded_file($_FILES["assetfile"]["tmp_name"],"assetfile/".$file_new)){
						$update2 = "update tbasset set assetfile='$file_new' where asset_no='$asset_no'";
							mssql_query($update2);
					}
				}
				}
		
		if($status=='change_location'){
			$asset_no =$_POST['asset_no'];
			$transfer_to =$_POST['location'];
			$transfer_reason=lang_thai_into_database($_POST['transfer_reason']);
				
				
					$select = "select location from tbasset where asset_no ='$asset_no'";
					$re = mssql_query($select);
					$num=mssql_num_rows($re);
					if($num>0){
					$row = mssql_fetch_array($re);
						$transfer_from = $row['location'];
						
						$update = "insert into tbasset_transfer(asset_no, transfer_from, transfer_to, transfer_date, transfer_reason
) values('$asset_no', '$transfer_from', '$transfer_to', '$date_time', '$transfer_reason'
)";
						mssql_query($update);
						$update2 = "update tbasset set location='$transfer_to' where asset_no='$asset_no'";
						mssql_query($update2);
						
					}
					
					
			
			}
	
?>