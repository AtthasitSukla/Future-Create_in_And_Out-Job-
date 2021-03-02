<? 

include("connect_inv.php");
				
include("library.php"); ?>
<?

	$date_num=date("m/d/Y");
	$times=date("H:i:s",time());
	$date_time=date("m/d/Y H:i:s");
	$status = $_REQUEST['status'];
	
	
	
	if($status=='show_backup' ){
				$host2="WIN-GRCB1K9LF1N";
				$username2="sloxixa";
				$password2="eaotft139@%";
				$dbhr="dhrdb";
				$sqldb2=mssql_connect($host2,$username2,$password2) or die("Cannot connect");
				mssql_select_db($dbhr);
				
				
		
		$location = $_REQUEST['location'];
		$year= $_REQUEST['year'];
		?>
		<table width="100%" border="0" cellspacing="0" cellpadding="0" >
		  <tr>
		    <td align="center" bgcolor="#CCCCCC">
            
			<table width="100%" border="0" cellspacing="1" cellpadding="0" >
		 <thead >
		  <tr>
          <td align="center" width="50" height="20" style="border-right:1px solid; border-left:1px solid; border-top:1px solid; border-bottom:1px solid"><strong>Department</strong></td>
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
           
            </thead>
            <tbody >
          <?
		  if($_SESSION['departmentid']=='D002' ||$_SESSION['departmentid']= 'D006'){
			  $select="SELECT * from tbdepartment where 1=1 ";
			  }else{
			  $select="SELECT * from tbdepartment where departmentid='".$_SESSION['departmentid']."'  ";
			  }
			  $select.=" and department not in('Sale','HR','QMS','QMR','DCC') order by departmentid asc";
          	
				$re=mssql_query($select,$sqldb2);
				$num=mssql_num_rows($re);
				if($num>0){
					$iloop = 0;
					while($row=mssql_fetch_array($re)){
						$iloop++;
							$host="WIN-GRCB1K9LF1N";
							$username="sloxixa";
							$password="eaotft139@%";
							$db="dinvb";
							$sqldb=mssql_connect($host,$username,$password) or die("Cannot connect");
							mssql_select_db($db);
							
						?>
						
                         <tr bgcolor="#FFFFFF">
             <td align="center" width="50" height="40" style="border-right:1px solid; border-left:1px solid; border-bottom:1px solid"><?
			echo $row['department'];
			//echo "<BR>";
           // echo iconv("tis-620", "utf-8", $row['asset_name'] );
			?></td>
		    <td align="center" width="50" height="40" style="border-right:1px solid; border-left:1px solid; border-bottom:1px solid"><?
			$select3="SELECT asset_no,empno,asset_name from tbasset where asset_group='Storage' and asset_status ='normal_use'";
				$re3=mssql_query($select3,$sqldb);
				$num3=mssql_num_rows($re3);
				if($num3>0){
				while($row3=mssql_fetch_array($re3)){
					
				//if($row3['asset_no']==)
				$host2="WIN-GRCB1K9LF1N";
				$username2="sloxixa";
				$password2="eaotft139@%";
				$dbhr="dhrdb";
				$sqldb2=mssql_connect($host2,$username2,$password2) or die("Cannot connect");
				mssql_select_db($dbhr);
				
				$select4="SELECT empno from tbemployee where departmentid = '".$row['departmentid']."' and delstatus='0'";
				$re4=mssql_query($select4,$sqldb2);
				$num4=mssql_num_rows($re4);
				if($num4>0){
				while($row4=mssql_fetch_array($re4)){
						if($row3['empno']==$row4['empno']){
								echo $row3['asset_no'];
								echo "<BR>";
								echo $row3['asset_name'];
							}
					}}
					}
				}
			
			//echo $row['asset_no'];
		//	echo "<BR>";
          //  echo iconv("tis-620", "utf-8", $row['asset_name'] );
			?></td>
            <?
			
		
			$host="WIN-GRCB1K9LF1N";
							$username="sloxixa";
							$password="eaotft139@%";
							$db="dinvb";
							$sqldb=mssql_connect($host,$username,$password) or die("Cannot connect");
							mssql_select_db($db);
	
			for($i=1;$i<=12;$i++){
				
				$select5="SELECT departmentid,backupdetail from tbasset_backup where departmentid='".$row['departmentid']."' and backupmonth='".$month2[$i]."' and backupyear='".$year."'";
				$re5=mssql_query($select5,$sqldb);
				$num5=mssql_num_rows($re5);
				if($num5>0){
					$row5=mssql_fetch_array($re5);
					if($row5['backupdetail']=='' || $row5['backupdetail']==' '){
						$bg = "#FFFF66";
						}else{
							$bg = "#66FF33";
							}
					
				}else{
					$bg = "#FFFF66";
					}
				
				?><td  align="center" width="33" style="border-right:1px solid; border-bottom:1px solid">
                <input type="button" value="Update" style="background-color:<?=$bg?>" onclick="showupdate('<?=$month2[$i]?>','<?=$year?>','<?=$row['departmentid']?>');">
                </td><?
				
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
		
		if($status=='save_backup'){
				//$backupdetail = $_REQUEST['backupdetail'];
				$backupdetail = str_replace("\n", "<br />", $_REQUEST['backupdetail']);
				$backupdetail = lang_thai_into_database($backupdetail);
				$backupmonth = $_REQUEST['backupmonth'];
				$backupyear = $_REQUEST['backupyear'];
				$departmentid = $_REQUEST['departmentid'];
				
				$sql = "select * from tbasset_backup where departmentid='$departmentid' and backupmonth='$backupmonth' and backupyear='$backupyear'";
                                            $re = mssql_query($sql);
											$num = mssql_num_rows($re);
											if($num>0){
                                           		$update = "update tbasset_backup set backupdetail='$backupdetail',backupdate='$date_num' where departmentid='$departmentid' and backupmonth='$backupmonth' and backupyear='$backupyear'";
												 mssql_query($update);
												}else{
													$ins= "insert into tbasset_backup(departmentid, backupdetail, backupmonth, backupyear,backupdate) values('$departmentid', '$backupdetail', '$backupmonth',  '$backupyear','$date_num')";
													mssql_query($ins);
													}
			}

if($status=='showupdate'){
				//$backupdetail = $_REQUEST['backupdetail'];
				$backupmonth = $_REQUEST['backupmonth'];
				$backupyear = $_REQUEST['backupyear'];
				$departmentid = $_REQUEST['departmentidx'];
				
			$sql = "select backupdetail from tbasset_backup where departmentid='$departmentid' and backupmonth='$backupmonth' and backupyear='$backupyear' ";
			//echo $sql;
                                            $re = mssql_query($sql);
											$num = mssql_num_rows($re);
											if($num>0){
                                           $row = mssql_fetch_array($re);
										  // str_replace("<br />","\n", $row['backupdetail']);
										   echo lang_thai_from_database(str_replace("<br />","\n", $row['backupdetail']));
												}
	}
?>