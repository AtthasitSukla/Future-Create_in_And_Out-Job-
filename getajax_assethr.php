<?php
include("connect_inv.php");
include("library.php");

$status = $_REQUEST['status'];
$date_time=date("m/d/Y H:i:s");

if($status=="show_asset"){
    $empno = $_POST["empno"];
    ?>
    <select id='asset_list' class="searchable" multiple='multiple' >
    <?php
    $sql = "select * from tbasset  order by asset_no";
    $res = mssql_query($sql);
    while($row =mssql_fetch_array($res)){
        $asset_no = $row["asset_no"];
        $asset_name = lang_thai_from_database($row["asset_name"]);
        $empno_query = $row["empno"];
        if($empno_query==$empno){
            $selected = "selected";
        }else{
            $selected="";
        }
        ?><option value="<?=$asset_no?>" <?=$selected?>><?=$asset_no?>[<?=$asset_name?>]</option><?
    }

 
    ?>
    </select>
    <?php
}
if($status=="add_asset"){
    $asset_no = $_REQUEST["asset_no"][0];
    $empno = $_REQUEST["empno"];
    $update = "UPDATE tbasset set empno='$empno' where asset_no='$asset_no'";
    mssql_query($update);
}
if($status=="del_asset"){
    $asset_no = $_REQUEST["asset_no"][0];
    $empno = $_REQUEST["empno"];
    $update = "UPDATE tbasset set empno=NULL where asset_no='$asset_no'";
    mssql_query($update);
}
?>