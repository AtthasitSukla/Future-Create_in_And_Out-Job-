<?php
ob_start(); 
include("connect_inv.php"); 
include("library.php"); 
$date_time=date("m/d/Y H:i:s");

$status = $_REQUEST['status'];
?>
<html >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Export Report</title>

</head>

<body >
<?php
if($status=='asset_list'){
    $asset_group =$_REQUEST["asset_group"];
    $asset_status =$_REQUEST["asset_status"];
    $location =$_REQUEST["location"];
    if($asset_group!=''){
        $condition_asset_group= "AND asset_group='$asset_group'";
    }else{
        $condition_asset_group= "";
    }
    if($asset_status!=''){
        $condition_asset_status= "AND asset_status='$asset_status'";
    }else{
        $condition_asset_status= "";
    }
    if($location!=''){
        $condition_location= "AND location='$location'";
    }else{
        $condition_location= "";
    }
    $strExcelFileName="asset_list.xls";
    header("Content-Type: application/x-msexcel; name=\"$strExcelFileName\"");
    header("Content-Disposition: inline; filename=\"$strExcelFileName\"");
    header("Pragma:no-cache");
    //echo "$condition_asset_group $condition_asset_status $condition_location";
    ?>
    <table border="1" x:str>
                
        <tr>
            <td  align="center" ><strong>Asset No.</strong></td>
            <td  align="center" ><strong>Asset Name</strong></td>
            <td align="center" ><strong>Empno</strong></td>
            <td  align="center" ><strong>Owner</strong></td>
            <td  align="center" ><strong>Manufacturer</strong></td>
            <td  align="center" ><strong>Device Type</strong></td>
            <td  align="center" ><strong>Model </strong></td>
            <td  align="center" ><strong>Macaddress</strong></td>
            <td  align="center" ><strong>Ipaddress</strong></td>
            <td  align="center" ><strong>Serialnumber</strong></td>
            <td  align="center" ><strong>Location</strong></td>
            <td  align="center" ><strong>Asset Group</strong></td>
            <td  align="center" ><strong>Po No</strong></td>
            <td  align="center" ><strong>Open Po </strong></td>
            <td  align="center" ><strong>Purchase Date</strong></td>
            <td  align="center" ><strong>Purchase Price</strong></td>
            <td  align="center" ><strong>Warranty Start</strong></td>
            <td  align="center" ><strong>Warranty End</strong></td>
            <td  align="center" ><strong>Asset Status</strong></td>
        </tr>
    <?php
    $sql = "SELECT * FROM tbasset 
    WHERE asset_no IS NOT  NULL $condition_asset_group $condition_asset_status $condition_location";
    $res = mssql_query($sql);
    while($row = mssql_fetch_array($res)){
        $asset_no = $row["asset_no"];
        $asset_name = lang_thai_from_database($row["asset_name"]);
        $empno = $row["empno"];
        $owner = $row["owner"];
        $manufacturer = $row["manufacturer"];
        $device_type = $row["device_type"];
        $model = lang_thai_from_database($row["model"]);
        $macaddress = $row["macaddress"];
        $ipaddress = $row["ipaddress"];
        $serialnumber = lang_thai_from_database($row["serialnumber"]);
        $location = $row["location"];
        $asset_group = $row["asset_group"];
        $po_open_date = $row["po_open_date"];
        $po_no = $row["po_no"];
        $purchase_date = $row["purchase_date"];
        $purchase_price = $row["purchase_price"];
        $warranty_start = $row["warranty_start"];
        $warranty_end = $row["warranty_end"];
        $asset_status = $row["asset_status"];

        $sql_status = "SELECT * FROM tbasset_status WHERE asset_status='$asset_status'";
        $res_status = mssql_query($sql_status);
        $row_status = mssql_fetch_array($res_status);
        $asset_status_name = lang_thai_from_database($row_status["asset_status_name"]);

        include("connect.php"); 
        $sql_empno = "SELECT * FROM tbemployee WHERE empno='$empno'";
        $res_empno = mssql_query($sql_empno);
        $row_empno = mssql_fetch_array($res_empno);
        $firstname = lang_thai_from_database($row_empno["firstname"]);
        $lastname = lang_thai_from_database($row_empno["lastname"]);
        $full_name = $empno." ".$firstname." ".$lastname;
        
        include("connect_inv.php");
        ?>
        <tr>
            <td ><?=$asset_no?></td>
            <td ><?=$asset_name?></td>
            <td><?=$full_name?></td>
            <td ><?=$owner?></td>
            <td ><?=$manufacturer?></td>
            <td ><?=$device_type?></td>
            <td ><?=$model?></td>
            <td ><?=$macaddress?></td>
            <td ><?=$ipaddress?></td>
            <td ><?=$serialnumber?></td>
            <td ><?=$location?></td>
            <td ><?=$asset_group?></td>
            <td ><?=$po_no?></td>
            <td ><?=$po_open_date?></td>
            <td ><?=$purchase_date?></td>
            <td ><?=$purchase_price?></td>
            <td ><?=$warranty_start?></td>
            <td ><?=$warranty_end?></td>
            <td ><?=$asset_status_name?></td>
        </tr>
        <?

    }
    ?>
    </table>
<?
}
?>
</body>
</html>