<?php
session_start();
include("connect.php");
include("library.php");
$status = $_REQUEST["status"];
$date_time=date("m/d/Y H:i:s");
$create_date=date("m/d/Y H:i:s");
$admin_user_id = $_SESSION['admin_userid'];


if($status=='save_dummy'){
				$customer_id = $_REQUEST['customer_id'];
				$create_date = $_REQUEST['create_date'];
				$create_date = date_format_uk_into_database($create_date);
	
				$dummy_number = "DUM".date("y").date("m");
				$select = "SELECT top 1 dummy_number FROM  sp_create_po WHERE  dummy_number like '$dummy_number%' ORDER BY dummy_number DESC";
				$re=mssql_query($select);
				$num=mssql_num_rows($re);
				$dummy_number = $dummy_number."0001";
				if($num > 0){
					//DUM18050001
					$row = mssql_fetch_array($re);
					$dummy_number = substr($row['dummy_number'],-4);
					
					$dummy_number = (int)$dummy_number + 1;
					$dummy_number = "0000".$dummy_number;
					$dummy_number = substr($dummy_number,-4);
					$dummy_number = "DUM".date("y").date("m").$dummy_number;
				}
				
				
				$job_id = "JOB".date("y").date("m");
				$select = "SELECT top 1 job_id FROM  sp_create_po WHERE  job_id like '$job_id%' ORDER BY job_id DESC";
				$re=mssql_query($select);
				$num=mssql_num_rows($re);
				$job_id = $job_id."0001";
				if($num > 0){
					$row = mssql_fetch_array($re);
					$job_id = substr($row['job_id'],-4);
					$job_id = (int)$job_id + 1;
					$job_id = "0000".$job_id;
					$job_id = substr($job_id,-4);
					$job_id = "JOB".date("y").date("m").$job_id;
				}
				//echo "/".$job_id;
				
				
				$insert = "insert into sp_create_po(job_id, customer_id, job_po,  dummy_number, status, create_date, admin_userid) values('$job_id', '$customer_id', '$dummy_number',  '$dummy_number', 'Dummy PO', '$create_date', '$admin_user_id')";
				mssql_query($insert);
				
				
				for($i=0;$i<count($_POST['data_po']);$i++){
					
					$part_po_id = "PPO".date("y").date("m");
					$select = "SELECT top 1 part_po_id FROM   sp_part_po WHERE  part_po_id like '$part_po_id%' ORDER BY part_po_id DESC";
					$re=mssql_query($select);
					$num=mssql_num_rows($re);
					$part_po_id = $part_po_id."0001";
					if($num > 0){
						$row = mssql_fetch_array($re);
						$part_po_id = substr($row['part_po_id'],-4);
						$part_po_id = (int)$part_po_id + 1;
						$part_po_id = "0000".$part_po_id;
						$part_po_id = substr($part_po_id,-4);
						$part_po_id = "PPO".date("y").date("m").$part_po_id;
					}
					
					
				$insert = "insert into sp_part_po(part_po_id, job_id, job_po, dummy_number, part_master_id, start_qty, po_qty_remain) values('$part_po_id','$job_id','$dummy_number','$dummy_number','".$_POST['data_po'][$i]['part_number']."',".$_POST['data_po'][$i]['qty'].",".$_POST['data_po'][$i]['qty'].")";
				//echo $insert;
				mssql_query($insert);
				
				
			}
				
				
	}
if($status=='save_edit_dummy'){
				
				$job_id = $_REQUEST['job_id'];
				$customer_id = $_REQUEST['customer_id'];
				$dummy_number = $_REQUEST['dummy_number'];
				
				$select="select job_id from  sp_create_po where job_id = '$job_id' ";
				//echo $select;
				$re=mssql_query($select);
				$num=mssql_num_rows($re);
				if($num>0){
					
					$update = "update sp_create_po set customer_id='$customer_id',admin_userid='$admin_user_id' where job_id='$job_id'";
					mssql_query($update);
					
					
					for($i=0;$i<count($_POST['data_po']);$i++){
					//$part_po_id = "PPO".date("y").date("m");
			$select2 = "SELECT top 1 part_po_id FROM   sp_part_po WHERE  part_po_id ='".$_POST['data_po'][$i]['part_po_id']."'";
			//echo $select2;
					$re2=mssql_query($select2);
					$num2=mssql_num_rows($re2);
					if($num2 > 0){
						//$_POST['data_po'][$i]['part_number']
						//$_POST['data_po'][$i]['qty']
						$update2 = "update  sp_part_po set part_master_id='".$_POST['data_po'][$i]['part_number']."',start_qty=".$_POST['data_po'][$i]['qty'].",po_qty_remain=".$_POST['data_po'][$i]['qty']." where part_po_id='".$_POST['data_po'][$i]['part_po_id']."'";
						mssql_query($update2);
						
					}else{
						
				$part_po_id = create_part_po_id();
				
				$insert = "insert into sp_part_po(part_po_id, job_id, job_po, po_number, part_master_id, start_qty, po_qty_remain) values('$part_po_id','$job_id','$po_number','$po_number','".$_POST['data_po'][$i]['part_number']."',".$_POST['data_po'][$i]['qty'].",".$_POST['data_po'][$i]['qty'].")";
				
				mssql_query($insert);
						
						}
					
					
				
				
				
			}
					
					}
					
				
				
				
				
	
				
		
				
				
	}

if($status=='save_po'){
				$customer_id = $_REQUEST['customer_id'];
				$po_number = $_REQUEST['po_number'];
				$create_date = $_REQUEST['create_date'];
				$create_date = date_format_uk_into_database($create_date);
				$lock = 0;
											if($po_number!=''){
											$select0 = "select po_number from sp_create_po where po_number='$po_number'";
                                            $re0 = mssql_query($select0);
											$num0 = mssql_num_rows($re0);
											if($num0>0){
                                            //$row0 = mssql_fetch_array($re0);
											$lock =1;
											echo "dupplicatepo";
												}
												
												}
												
												
				if($lock==0){
				
				$job_id = "JOB".date("y").date("m");
				$select = "SELECT top 1 job_id FROM  sp_create_po WHERE  job_id like '$job_id%' ORDER BY job_id DESC";
				$re=mssql_query($select);
				$num=mssql_num_rows($re);
				$job_id = $job_id."0001";
				if($num > 0){
					$row = mssql_fetch_array($re);
					$job_id = substr($row['job_id'],-4);
					$job_id = (int)$job_id + 1;
					$job_id = "0000".$job_id;
					$job_id = substr($job_id,-4);
					$job_id = "JOB".date("y").date("m").$job_id;
				}
				//echo "/".$job_id;
				
				
				$insert = "insert into sp_create_po(job_id, customer_id, job_po,  po_number, status, create_date, admin_userid) values('$job_id', '$customer_id', '$po_number',  '$po_number', 'Remain PO', '$create_date', '$admin_user_id')";
				mssql_query($insert);
				
				
				for($i=0;$i<count($_POST['data_po']);$i++){
					
					$part_po_id = "PPO".date("y").date("m");
					$select = "SELECT top 1 part_po_id FROM   sp_part_po WHERE  part_po_id like '$part_po_id%' ORDER BY part_po_id DESC";
					$re=mssql_query($select);
					$num=mssql_num_rows($re);
					$part_po_id = $part_po_id."0001";
					if($num > 0){
						$row = mssql_fetch_array($re);
						$part_po_id = substr($row['part_po_id'],-4);
						$part_po_id = (int)$part_po_id + 1;
						$part_po_id = "0000".$part_po_id;
						$part_po_id = substr($part_po_id,-4);
						$part_po_id = "PPO".date("y").date("m").$part_po_id;
					}
					
					
				$insert = "insert into sp_part_po(part_po_id, job_id, job_po, po_number, part_master_id, start_qty, po_qty_remain) values('$part_po_id','$job_id','$po_number','$po_number','".$_POST['data_po'][$i]['part_number']."',".$_POST['data_po'][$i]['qty'].",".$_POST['data_po'][$i]['qty'].")";
				echo $insert;
				mssql_query($insert);
				
				
			}
}
				
	}
if($status=='save_edit_po'){
				$job_id = $_REQUEST['job_id'];
				$customer_id = $_REQUEST['customer_id'];
				$po_number = $_REQUEST['po_number'];
				
				$select="select job_id from  sp_create_po where job_id = '$job_id' ";
				echo $select;
				$re=mssql_query($select);
				$num=mssql_num_rows($re);
				if($num>0){
					
					$update = "update sp_create_po set customer_id='$customer_id',job_po='$po_number',po_number='$po_number',admin_userid='$admin_user_id' where job_id='$job_id'";
					mssql_query($update);
					
					
					for($i=0;$i<count($_POST['data_po']);$i++){
					//$part_po_id = "PPO".date("y").date("m");
			$select2 = "SELECT top 1 part_po_id,start_qty, po_qty_remain FROM   sp_part_po WHERE  part_po_id ='".$_POST['data_po'][$i]['part_po_id']."'";
			
					$re2=mssql_query($select2);
					$num2=mssql_num_rows($re2);
					if($num2 > 0){
						$row2=mssql_fetch_array($re2);
						
						if($row2['start_qty']==$row2['po_qty_remain']){
							$update2 = "update  sp_part_po set part_master_id='".$_POST['data_po'][$i]['part_number']."',start_qty=".$_POST['data_po'][$i]['qty'].",po_qty_remain=".$_POST['data_po'][$i]['qty']." where part_po_id='".$_POST['data_po'][$i]['part_po_id']."'";
						mssql_query($update2);
							}
						
					}else{
						
				$part_po_id = create_part_po_id();
				
				$insert = "insert into sp_part_po(part_po_id, job_id, job_po, po_number, part_master_id, start_qty, po_qty_remain) values('$part_po_id','$job_id','$po_number','$po_number','".$_POST['data_po'][$i]['part_number']."',".$_POST['data_po'][$i]['qty'].",".$_POST['data_po'][$i]['qty'].")";
				
				mssql_query($insert);
						
						}
					
					
				
				
				
			}
					
					}
					
				
				
				
				
	}
if($status=='show_job_po_list'){
		?>
		
                            <table id="table_po" class="table table-striped table-bordered" style="width:100%">
                               <thead>
                                    <tr>
                                        <th>Job number</th>
                                        <th>Crate date</th>
                                        <th>Customer</th>
                                        <th>PO Number</th>
                                        <th>Total Q'ty</th>
                                        <th>Issue Q'ty</th>
                                         <th>Issue Remain Q'ty<BR>(คงเหลือเปิด Job)</th>
                                         <th>Dummy Q'ty<br />(ดึง Dummy ขึ้นมา)</th>
                                          <th>Invoice</th>
                                         <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?
                $select="select *,convert(varchar, create_date, 103)as  create_date_date,
	convert(varchar, create_date, 108)as  create_date_time from   sp_create_po  where po_number is not null  ";
				$re=mssql_query($select);
				$num=mssql_num_rows($re);
				if($num>0){
					$start_qty = 0;
					$issue_qty = 0;
					$issue_remain_qty = 0;
					$pull_dummy_qty = 0;
					
					$bg= '';
					while($row=mssql_fetch_array($re)){
						$txtinvoice= '';
						//// DATA AREA
						 					$selectp="select sum(start_qty) as total from sp_part_po where job_id = '".$row['job_id']."' ";
											$rep=mssql_query($selectp);
											$nump=mssql_num_rows($rep);
											if($nump>0){
												$rowp=mssql_fetch_array($rep);
												//echo $rowp['total'];
												$start_qty = $rowp['total'];
												}
												
                                        	   $selectp="select sum(qty) as total from sp_part_issue where job_issue_id in(select  job_issue_id from sp_issue_job where job_id = '".$row['job_id']."' and status<>'Cancel' )   ";
											$rep=mssql_query($selectp);
											$nump=mssql_num_rows($rep);
											if($nump>0){
												$rowp=mssql_fetch_array($rep);
												//echo $rowp['total'];
												$issue_qty = $rowp['total'];
												}
											$selectp="select sum(po_qty_remain) as total from sp_part_po where job_id = '".$row['job_id']."' ";
											$rep=mssql_query($selectp);
											$nump=mssql_num_rows($rep);
											if($nump>0){
												$rowp=mssql_fetch_array($rep);
												//echo $rowp['total'];
												$issue_remain_qty = $rowp['total'];
												
												}
											$selectp="select sum(qty) as total from  sp_match_issue where part_po_id in(select part_po_id from  sp_part_po where  job_id = '".$row['job_id']."' ) ";
								  // echo  $selectp;
											$rep=mssql_query($selectp);
											$nump=mssql_num_rows($rep);
											if($nump>0){
												$rowp=mssql_fetch_array($rep);
												//echo $rowp['total'];
												$pull_dummy_qty =$rowp['total'];
												}
										
										$select_po="select doc_no from  tbpo_invoice where po_no = '".$row['po_number']."' ";
											$re_po=mssql_query($select_po);
											$num_po=mssql_num_rows($re_po);
											if($num_po>0){
												$total_invoiceall = 0;
												while($row_po=mssql_fetch_array($re_po)){
													$total_invoice=0;
										$select_po2="select sum(qty) as total from  tbpo_invoice_detial where doc_no = '".$row_po['doc_no']."' ";
											$re_po2=mssql_query($select_po2);
											$num_po2=mssql_num_rows($re_po2);
											if($num_po2>0){
											$row_po2=mssql_fetch_array($re_po2);
													$total_invoiceall = $total_invoiceall+$row_po2['total'];
													$total_invoice = $row_po2['total'];
											}
													$txtinvoice .=$row_po['doc_no']."(".$total_invoice.")<BR>";
													
													
													}
												}else{
													 $txtstatus =  $row['status'];
													}
									
									 if($total_invoiceall>=$start_qty){
															if($issue_remain_qty==0){
																	$txtstatus="Close";
																}else{
																	$txtstatus='Remain PO';
																	}
													
													}else{
														$txtstatus = 'Document';
														}
										 
										 
										
										
										 
                                         if($txtstatus=='Remain PO' || $txtstatus=='Document'){
											 $bg= "bgcolor='#FFFFCC'";
											 }
										 if($txtstatus=='Close'){
											 $bg= "bgcolor='#80FF80'";
											 }
						
						//// DATA AREA
						
						
						?>
						 <tr>
                                        <td><a href="?status=editpo&job_id=<?=$row['job_id']?>"><?=$row['job_id']?></a></td>
                                        <td><?=$row['create_date_date']?></td>
                                        <td><?
                                    		 $selectc="select nickname from   tbpo_inv_cus where custid = '".$row['customer_id']."' ";
											$rec=mssql_query($selectc);
											$numc=mssql_num_rows($rec);
											if($numc>0){
												$rowc=mssql_fetch_array($rec);
												echo $rowc['nickname'];
												}
										?></td>
                                        <td><?
                                        	echo "<a href='sp_adjust_po.php?po_no=".$row['po_number']."'>".$row['po_number']."</a>";
										?></td>
                                        <td><?
                                    		echo $start_qty;
										?></td>
                                        <td><?
									
												echo $issue_qty;
										?></td>
                                         <td><?
                                   
												echo $issue_remain_qty;
										?></td>
                                         <td><?
                                   
												echo $pull_dummy_qty;
										?></td>
                                         <td><?
                                         	echo $txtinvoice;
											
										 ?></td>
                                         <td <?
										           
											 echo $bg;
											 
										 ?>><?=$txtstatus?></td>
                                    </tr>
						<?
						}
					}
								?>
                               
                                </tbody>
                               
                            </table>
                       
		<?
		}
if($status=='show_job_dummy_list'){
		?>
		
                            <table id="table_dummy" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Job number</th>
                                        <th>Crate date</th>
                                        <th>Customer</th>
                                        <th>Dummy Number</th>
                                        <th>Total Q'ty</th>
                                        <th>Issue Q'ty</th>
                                         <th>Issue Remain Q'ty<BR>(คงเหลือเปิด Job)</th>
                                         <th>PO Remain Q'ty<BR>(ค้างจ่าย PO)</th>
                                         <th>Delivery Note</th>
                                         <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?
                $select="select *,convert(varchar, create_date, 103)as  create_date_date,
	convert(varchar, create_date, 108)as  create_date_time from   sp_create_po where po_number is null  ";
				$re=mssql_query($select);
				$num=mssql_num_rows($re);
				if($num>0){
					while($row=mssql_fetch_array($re)){
						?>
						 <tr>
                                        <td><a href="?status=editdummy&job_id=<?=$row['job_id']?>"><?=$row['job_id']?></a></td>
                                        <td><?=$row['create_date_date']?></td>
                                        <td><?
                                    		 $selectc="select nickname from   tbpo_inv_cus where custid = '".$row['customer_id']."' ";
											$rec=mssql_query($selectc);
											$numc=mssql_num_rows($rec);
											if($numc>0){
												$rowc=mssql_fetch_array($rec);
												echo $rowc['nickname'];
												}
										?></td>
                                        <td><?
                                        	echo $row['dummy_number'];
										?></td>
                                        <td><?
                                     $selectp="select sum(start_qty) as total from sp_part_po where job_id = '".$row['job_id']."' ";
											$rep=mssql_query($selectp);
											$nump=mssql_num_rows($rep);
											if($nump>0){
												$rowp=mssql_fetch_array($rep);
												echo $rowp['total'];
												$total_qty = $rowp['total'];
												}
										?></td>
                                        <td><?
                                         $selectp="select sum(qty) as total from sp_part_issue where job_issue_id in(select  job_issue_id from sp_issue_job where job_id = '".$row['job_id']."' and status<>'Cancel')   ";
											$rep=mssql_query($selectp);
											$nump=mssql_num_rows($rep);
											if($nump>0){
												$rowp=mssql_fetch_array($rep);
												echo $rowp['total'];
												$issue_qty = $rowp['total'];
												}
										?></td>
                                         <td><?
                                   $selectp="select sum(po_qty_remain) as total from sp_part_po where job_id = '".$row['job_id']."' ";
											$rep=mssql_query($selectp);
											$nump=mssql_num_rows($rep);
											
											if($nump>0){
												$rowp=mssql_fetch_array($rep);
												echo $rowp['total'];
												$issue_remain_qty = $rowp['total'];
												}else{
													$issue_remain_qty = '';
													}
										?></td>
                                         <td><?
                                   $selectp="select sum(qty_remain) as total from  sp_part_issue where job_issue_id in(select job_issue_id from  sp_issue_job where job_id = '".$row['job_id']."'   and status<>'Cancel')  ";
											$rep=mssql_query($selectp);
											$nump=mssql_num_rows($rep);
											if($nump>0){
												$rowp=mssql_fetch_array($rep);
												$po_remain_qty = $rowp['total'];
												echo $rowp['total'];
												}
										?></td>
                                         <td><?
                                         // if($issue_qty>0){
											//  $txtstatus = 'Document';
											// }
										 if($issue_qty>0){
			
											  $txtstatus = 'Document';
											 }else{
												 $txtstatus =  $row['status'];
												 }
										  
									 
											
											if( $txtstatus == 'Document'){
				$selectd="select distinct dn_no,job_issue_id from sp_create_dn where job_issue_id in(select job_issue_id from  sp_issue_job where job_id = '".$row['job_id']."' and status<>'Cancel' ) ";
				$red=mssql_query($selectd);
				$numd=mssql_num_rows($red);
				if($numd>0){
					$ixx = 0;
					$total_qtyload = 0;
					while($rowd=mssql_fetch_array($red)){
							echo "<a href='print_dn.php?dn_no=".$rowd['dn_no']."' target='_blank'>".$rowd['dn_no']."</a>";
							echo " | <a href='sp_create_po.php?status=create_dn&job_id=".$row['job_id']."&dn_no=".$rowd['dn_no']."'>Edit</a>";
							
				$selectd2="select status_loading from  sp_issue_job where job_issue_id = '".$rowd['job_issue_id']."' and status_loading='Close' and job_id='".$row['job_id']."'";
				//echo $selectd2;
				$red2=mssql_query($selectd2);
				$numd2=mssql_num_rows($red2);
				if($numd2>0){
					
				$selectd3="select sum(qty) as total from   sp_part_issue where job_issue_id = '".$rowd['job_issue_id']."' ";
				//echo $selectd2;
				$red3=mssql_query($selectd3);
				$numd3=mssql_num_rows($red3);
				if($numd3>0){
					$rowd3=mssql_fetch_array($red3);
					$qtyload =  $rowd3['total'];
					}
					$total_qtyload = $total_qtyload + $qtyload;
					
					//echo "(load)";
					echo '<span style="background-color:#80FF80">(load '.$qtyload.')</span> | ';
					
					
						}else{
							echo '<span style="background-color:#FFFFCC">(load)</span> | ';
							}
							//echo '<BR>';
							
							
							$ixx++;
					if($ixx>0){
						echo "<BR>";
						}
						}
					}
				//	echo $total_qty;
				//	echo "/".$total_qtyload;
				//	echo "/".$po_remain_qty;
					if($total_qty==$total_qtyload && $po_remain_qty==0){
						$txtstatus='Close';
						
						}else{
							?><a href="sp_create_po.php?status=create_dn&job_id=<?=$row['job_id']?>">Create DN</a><?
							}
					
						
										
												
												}
												
												
										 ?></td>
                                         <td <?
										 
                                         if($txtstatus=='Dummy PO' ){
											 echo "bgcolor='#FFCC66'";
											 }
										 if($txtstatus=='Document' ){
											 echo "bgcolor='#FFFFCC'";
											 } 
										 if($txtstatus=='Close'){
											 echo "bgcolor='#80FF80'";
											 }
										 ?>><?
                                         echo $txtstatus;
										 ?></td>
                                    </tr>
						<?
						}
					}
								?>
                               
                                </tbody>
                               
                            </table>
                       
		<?
		}
if($status=='remove_part_edit'){
				$part_po_id = $_REQUEST['part_po_id'];
				$del = "delete from sp_part_po where part_po_id='$part_po_id'";
				mssql_query($del);
			}
if($status=='save_dn'){
		$dn_no = $_REQUEST['dn_no'];
		$delivery_date = date_format_uk_into_database($_REQUEST['delivery_date']);
		//$delivery_date = $_REQUEST['delivery_date'];
		$job_id = $_REQUEST['job_id'];
		$person_in_charge = $_REQUEST['person_in_charge'];
		$job_issue_id = $_REQUEST['job_issue_id'];
		
		if($dn_no=='' || $dn_no==' '){
		
		$dn_no = "DN".date("y").date("m");
					$select = "SELECT top 1 dn_no FROM   sp_create_dn WHERE  dn_no like '$dn_no%' ORDER BY dn_no DESC";
					$re=mssql_query($select);
					$num=mssql_num_rows($re);
					$dn_no = $dn_no."0001";
					if($num > 0){
						$row = mssql_fetch_array($re);
						$dn_no = substr($row['dn_no'],-4);
						$dn_no = (int)$dn_no + 1;
						$dn_no = "0000".$dn_no;
						$dn_no = substr($dn_no,-4);
						$dn_no = "DN".date("y").date("m").$dn_no;
					}
			$insert = "insert into sp_create_dn(dn_no, job_id,job_issue_id, delivery_date, person_in_charge
) values('$dn_no', '$job_id','$job_issue_id', '$delivery_date', '$person_in_charge')";
echo $insert;
			mssql_query($insert);
		}else{
			$select="select * from  sp_create_dn where dn_no = '$dn_no' ";
				$re=mssql_query($select);
				$num=mssql_num_rows($re);
				if($num>0){
						$update = "update sp_create_dn set delivery_date='$delivery_date',person_in_charge='$person_in_charge' where dn_no='$dn_no'";
						//echo $update;
						mssql_query($update);
					}
		
			}
		
			}
if($status=='show_part_issue'){
		$job_issue_id = $_REQUEST['job_issue_id'];
		$select="select delivery_date from  sp_issue_job where job_issue_id = '$job_issue_id' ";
				$re=mssql_query($select);
				$num=mssql_num_rows($re);
				if($num>0){
					$row=mssql_fetch_array($re);
					//echo $row['delivery_date'];
					
					}
					echo "###";
		?>
		<table   class="table table-striped table-bordered" style="width:90%" align="center">
                                <thead>
                                    <tr>
                                        <th width="21%">Parts No.</th>
                                        <th width="42%">Part Name</th>
                                        <th width="22%" align="center">Q'ty</th>
                                      
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                <?
                                	$selectj="select * from  sp_part_issue where job_issue_id ='$job_issue_id' ";
									//echo $selectj;
									$rej=mssql_query($selectj);
									$numj=mssql_num_rows($rej);
									if($numj>0){
										while($rowj=mssql_fetch_array($rej)){
											
								$selectp="select part_name,part_number from sp_part_master where part_master_id = '".$rowj['part_master_id']."' ";
												$rep=mssql_query($selectp);
												$rowp=mssql_fetch_array($rep);
												$part_name=$rowp['part_name'];
												$part_number=$rowp['part_number'];
												
											
											
											?>
								 <tr>
                                        <td><?=$part_number?> (<?=$rowj['part_master_id']?>)</td>
                                        <td><?=$part_name?></td>
                                        <td align="center"><?=$rowj['qty']?></td>
                                      
                                        
                                    </tr>
											<?
											}
										}
								?>
                                   
                                </tbody>
                                
                             
                               
                            </table>
		<?
		}
?>