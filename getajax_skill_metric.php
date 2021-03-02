<?php
include("connect.php");
include("library.php");
session_start();
$status = $_POST['status'];
$create_empno = $_SESSION['admin_userid'];
$date_time=date("m/d/Y H:i:s");

if($status=="show_skill_metric"){
    $empno= $_POST["empno"];
    $tra_id= $_POST["tra_id"];
    $sql = "SELECT * FROM tbskill_metric_munual WHERE empno='$empno' AND tra_id='$tra_id' AND type_skill='Manual'";
    $res = mssql_query($sql);
    $num =mssql_num_rows($res);
    if($num==0){
        $type_skill = "Auto";
        $number_skill = "0";
        echo $type_skill."###".$number_skill;
    }else{
        $row = mssql_fetch_array($res);
        $type_skill = $row["type_skill"];
        $number_skill = $row["number_skill"];
        echo $type_skill."###".$number_skill;
    }
}
if($status=="save_skill_metric"){
    $empno= $_POST["empno"];
    $tra_id= $_POST["tra_id"];
    $type_skill = $_POST["type_skill"];
    $number_skill = $_POST["number_skill"];
    $sql = "SELECT * FROM tbskill_metric_munual WHERE empno='$empno' AND tra_id='$tra_id' ";
    $res = mssql_query($sql);
    $num = mssql_num_rows($res);
    if($num==0){
        $insert = "INSERT INTO tbskill_metric_munual (tra_id,empno,number_skill,type_skill,last_update)
                                    VALUES ('$tra_id','$empno','$number_skill','$type_skill','$date_time')";
        mssql_query($insert);
    }else{
        $row = mssql_fetch_array($res);
        $id = $row["id"];
        $update = "UPDATE tbskill_metric_munual 
                    SET number_skill='$number_skill',type_skill='$type_skill',last_update='$date_time'
                    WHERE id='$id'
                    ";
        mssql_query($update);
    }
}

?>