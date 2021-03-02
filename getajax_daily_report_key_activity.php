<?php
session_start();
//echo $_SESSION['production_line'];
include("connect.php");
include("library.php");

$status = $_POST['status'];
$date_time = date("m/d/Y H:i:s");
$time = time();
$admin_userid = $_SESSION["admin_userid"];

if($status=="show_key_activity_proplem"){
    $report_date = date_format_uk_into_database($_POST["report_date"]);
    $site = ($_POST["site"]);
    $first_month = date("Y-m-1", strtotime($report_date));
    $last_month =  date("Y-m-t", strtotime($report_date));
    //echo $first_month;
    ?>
    <div class="panel panel-danger">
        <div class="panel-heading">
            <h4>Internal  quality Problem</h4>
        </div> 
        <div class="panel-body">
            <div class="form-horizontal">
                <!-- <div class="form-group " >
                    <label class="control-label col-sm-2" for="job_id_problem"><button onclick="gen_job_id_problem()">New job</button></label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" id="job_id_problem" name="job_id_problem" autocomplete="off"  readonly>
                    </div>
                </div> -->
                <div class="form-group " >
                    <label class="control-label col-sm-2" for="topic_problem">Problem</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" id="topic_problem" name="topic_problem" autocomplete="off"  >
                    </div>
                </div>
                <div class="form-group" >
                    <label class="control-label col-sm-2" for="customer_problem">From Customer</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" id="customer_problem" name="customer_problem" autocomplete="off"  >
                    </div>
                </div>
                <div class="form-group" >
                    <label class="control-label col-sm-2" for="pic_problem">PIC</label>
                    <div class="col-sm-3">
                        <select class="form-control" id="pic_problem" name="pic_problem">
                            <option value="">SELECT</option>
                            <?php
                            $sql_pic = "SELECT firstname,lastname FROM tbemployee WHERE site='$site' AND display_att='1' order by firstname";
                            $res_pic = mssql_query($sql_pic);
                            while($row_pic = mssql_fetch_array($res_pic)){
                                $firstname = lang_thai_from_database($row_pic["firstname"]);
                                $lastname = lang_thai_from_database($row_pic["lastname"]);
                                ?>
                                <option value="<?=$firstname?> <?=$lastname?>"><?=$firstname?> <?=$lastname?></option>
                                <?
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <!-- <div class="form-group" >
                    <label class="control-label col-sm-2" for="pic_problem">Picture </label>
                    <div class="col-sm-2" id="pic_problem_action" style="display:none">
                        <input type="hidden" id="idselect">
                        <div class="image-upload text-center" >
                            <label for="fileToUpload1">
                                <?
                                $filename = "images/cam.png?$time";
                                ?>
                                <img id="cam1" src="<?=$filename?>" width="100">
                            </label>

                            <input name="fileToUpload1" onchange="fileSelected('1','1');" accept="image/*" capture="camera" id="fileToUpload1" type="file">
                        </div>
                        <div class='text-center'><input type="button" value="view" onclick="showmodal2('1');"><input type="hidden" id="fn1" value="<?=$filename?>"></div>
                    </div>
                    <div class='col-sm-1'>
                        <span id="progress"></span>
                    </div>
                </div> -->
                <div class="form-group">
                    <label class="control-label col-sm-2" for="due_problem">Due Date</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" id="due_problem" name="due_problem" autocomplete="off"  >
                        
                    </div>
                </div>
                
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button  class="btn btn-success" onclick='save_problem()'>Save</button>
                </div>
            </div>
            <br><br><br>
            <div class='table table-responsive'>
                <table class='table table-bordered table-striped' id="">
                    <tr>
                        <th>Date</th>
                        <th>Problem</th>
                        <th>From Customer</th>
                        <th>PIC</th>
                        <th>Due date</th>
                        <th>Delete</th>
                    </tr>
                    <?
                    $sql_problem = "SELECT convert(varchar, date_problem,103)as date_problem_date,
                    convert(varchar, due_problem,103)as due_problem_date,*
                    FROM tbdaily_report_activity_external_problem 
                    WHERE (date_problem between '$first_month' AND '$last_month'
                    OR due_problem between '$first_month' AND '$last_month')
                    AND site='$site'
                    order by date_problem asc";
                    // echo $sql_problem;
                    $res_problem = mssql_query($sql_problem);
                    while($row_problem = mssql_fetch_array($res_problem)){
                        $id = $row_problem["id"];
                        $job_id_problem = $row_problem["job_id_problem"];
                        $date_problem = $row_problem["date_problem_date"];
                        $topic_problem = lang_thai_from_database($row_problem["topic_problem"]);
                        $customer_problem = lang_thai_from_database($row_problem["customer_problem"]);
                        $pic_problem = lang_thai_from_database($row_problem["pic_problem"]);
                        
                        $due_problem = $row_problem["due_problem_date"];

                        // $sql_pic_problem = "SELECT pic_problem  FROM tbdaily_report_activity_external_problem_picture WHERE job_id_problem='$job_id_problem'";
                        // $res_pic_problem = mssql_query($sql_pic_problem);
                        // $num_pic_problem = mssql_num_rows($res_pic_problem);
                        // if($num_pic_problem>0){
                        //     $row_pic_problem = mssql_fetch_array($res_pic_problem);
                        //     $pic_problem = $row_pic_problem["pic_problem"];
    
                        //     $pic = "<img src='daily_problem/$pic_problem' width='120px'>";
                            
                        // }else{
                        //     $pic = "";
                        // }
                        ?>
                        <tr>
                            <td><?=$date_problem?></td>
                            <td><?=$topic_problem?></td>
                            <td><?=$customer_problem?></td>
                            <td><?=$pic_problem?></td>
                            <td><?=$due_problem?></td>
                            <td><button class="btn btn-danger" onclick="delete_problem('<?=$id?>')">Delete</button></td>
                        </tr>
                        <?
                    }
                    ?>
                </table>
            </div>
        </div>
    </div>
    <?
}else if($status =="gen_job_id_problem"){
    $job_id_problem = "PBM".date("y").date("m");
    $sql_check = "SELECT top 1 job_id_problem from  tbdaily_report_activity_running where job_id_problem like '$job_id_problem%' order by job_id_problem desc";
    $res_check = mssql_query($sql_check);
    $num_check = mssql_num_rows($res_check);
    if ($num_check == 0) {
        $job_id_problem = "PBM".date("y").date("m")."0001";
    } else {
        $row = mssql_fetch_array($res_check);
        $job_id_problem2 = $row["job_id_problem"];
        $job_id_problem = $row["job_id_problem"];

        $tmp_newid = substr($job_id_problem, -4);
        $qid = (int) $tmp_newid + 1;
        $tmpid = "000000" . $qid;
        $qdno = substr($tmpid, -4);
        $job_id_problem = "PBM".date("y").date("m").$qdno;
    }
    $update = "UPDATE  tbdaily_report_activity_running set  job_id_problem='$job_id_problem'";
    mssql_query($update);

    echo $job_id_problem;

}else if($status=="save_problem"){
    
    $date_problem = date_format_uk_into_database($_POST["report_date"]);
    $job_id_problem = $_POST["job_id_problem"];
    $topic_problem = lang_thai_into_database($_POST["topic_problem"]);
    $customer_problem = lang_thai_into_database($_POST["customer_problem"]);
    $pic_problem = lang_thai_into_database($_POST["pic_problem"]);
    $due_problem = date_format_uk_into_database($_POST["due_problem"]);
    $site = $_POST["site"];

    $insert = "INSERT INTO tbdaily_report_activity_external_problem 
            (
                job_id_problem
                ,site
                ,date_problem
                ,topic_problem 
                ,customer_problem 
                ,pic_problem 
                ,due_problem 
                ,admin_userid 
                ,create_date 
            )
            Values
            (
                '$job_id_problem'
                ,'$site'
                ,'$date_problem'
                ,'$topic_problem'
                ,'$customer_problem'
                ,'$pic_problem'
                ,'$due_problem'
                ,'$admin_userid'
                ,'$date_time'
            )";
    mssql_query($insert);

}else if($status=="delete_problem"){
    $id = $_POST["id"];

    $delete = "DELETE FROM tbdaily_report_activity_external_problem 
            WHERE id='$id'";
    mssql_query($delete);

}else if($status=="show_key_activity_inventory_tsc"){
    $report_date = date_format_uk_into_database($_POST["report_date"]);
    $first_month = date("Y-m-1", strtotime($report_date));
    $last_month =  date("Y-m-t", strtotime($report_date));

    $month_inven =  date("m", strtotime($report_date));
    $year_inven =  date("Y", strtotime($report_date));
    //echo $first_month;
    ?>
    <div class="panel panel-green">
        <div class="panel-heading">
            <h4>Inventory</h4>
        </div> 
        <div class="panel-body">
            <div class="form-horizontal">
                <div class="form-group " >
                    <label class="control-label col-sm-2" for="plan_count_date">Plan count date</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" id="plan_count_date" name="plan_count_date" autocomplete="off"  >
                    </div>
                </div>
                <div class="form-group " >
                    <label class="control-label col-sm-2" for="item">item</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" id="item" name="item" autocomplete="off" value="<?= $item ?>" >
                    </div>
                </div>
                <div class="form-group " >
                    <label class="control-label col-sm-2" for="system">System</label>
                    <div class="col-sm-1">
                        <input type="number" class="form-control" id="system" name="system" autocomplete="off" onchange="inventory_cal()">
                    </div>
                </div>
                <div class="form-group " >
                    <label class="control-label col-sm-2" for="actual">Actual</label>
                    <div class="col-sm-1">
                        <input type="number" class="form-control" id="actual" name="actual" autocomplete="off" onchange="inventory_cal()">
                    </div>
                </div>
                <div class="form-group " >
                    <label class="control-label col-sm-2" for="diff">Diff</label>
                    <div class="col-sm-1">
                        <input type="number" class="form-control" id="diff" name="diff" autocomplete="off" readonly>
                    </div>
                </div>
                <div class="form-group " >
                    <label class="control-label col-sm-2" for="accuracy">% Accuracy</label>
                    <div class="col-sm-1">
                        <input type="number" class="form-control" id="accuracy" name="accuracy" autocomplete="off" readonly>
                    </div>
                </div>
                <div class="form-group " >
                    <label class="control-label col-sm-2" for="actual_date">Actual Date</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" id="actual_date" name="actual_date" autocomplete="off" >
                    </div>
                </div>  
                <div class="form-group " >
                    <label class="control-label col-sm-2" for="status_inventory">Status</label>
                    <div class="col-sm-2">
                        <select name="status_inventory" id="status_inventory" class="form-control">
                            <option value="">Select</option>
                            <option value="Ok">Ok</option>
                            <option value="Delay">Delay</option>
                            <option value="Fast">Fast</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button  class="btn btn-success" onclick='save_inventory()'>Save</button>
                    </div>
                </div>
            </div>
            <br>
            <div class='table table-responsive'>
                <table class='table table-bordered table-striped' id="">
                    <tr>
                        <th>Plan Date</th>
                        <th>Item</th>
                        <th>System</th>
                        <th>Actual</th>
                        <th>Diff</th>
                        <th>% Accuracy</th>
                        <th>Actual Date</th>
                        <th>Status</th>
                        <th>Delete</th>
                    </tr>
                    <?php 
                    $sql_inven = "SELECT * 
                    ,convert(varchar, plan_count_date,103)as plan_count_date_date
                    
                    ,convert(varchar, actual_date,103)as actual_date_date
                    
                    FROM tbdaily_report_tsc_inventory 
                    WHERE MONTH(plan_count_date) = '$month_inven' 
                    AND YEAR(plan_count_date)='$year_inven'
                    ";
                    // echo $sql_inven;
                    $res_inven = mssql_query($sql_inven);
                    while($row_inven = mssql_fetch_array($res_inven)){
                        $id = $row_inven["id"];
                        $plan_count_date = $row_inven["plan_count_date_date"];
                        $item = $row_inven["item"];
                        $system = $row_inven["system"];
                        $actual = $row_inven["actual"];
                        $diff = $row_inven["diff"];
                        $accuracy = $row_inven["accuracy"];
                        $actual_date = $row_inven["actual_date_date"];
                        $status_inventory = $row_inven["status_inventory"];
                        ?>
                        <tr>
                            <td><?=$plan_count_date?></td>
                            <td><?=$item?></td>
                            <td><?=$system?></td>
                            <td><?=$actual?></td>
                            <td><?=$diff?></td>
                            <td><?=$accuracy?></td>
                            <td><?=$actual_date?></td>
                            <td>
                                <select name="status_inventory_edit<?=$id?>" id="status_inventory_edit<?=$id?>" class="form-control" onchange="update_inventory_tsc('<?=$id?>')">
                                    <option value="">Select</option>
                                    <option value="Ok" <?php if($status_inventory=="Ok"){echo "selected";}?>>Ok</option>
                                    <option value="Delay" <?php if($status_inventory=="Delay"){echo "selected";}?>>Delay</option>
                                    <option value="Fast" <?php if($status_inventory=="Fast"){echo "selected";}?>>Fast</option>
                                </select>
                            </td>
                            <td><button class="btn btn-danger" onclick="delete_inventory_tsc('<?=$id?>')">Delete</button></td>
                        </tr>
                        <?
                    }
                    ?>
                </table>
            </div>
        </div>
    </div>
    <?
}else if($status=="save_inventory_tsc"){
    $plan_count_date = date_format_uk_into_database($_POST["plan_count_date"]);
    $item = $_POST["item"];
    $system = $_POST["system"];
    $actual = $_POST["actual"];
    $diff = $_POST["diff"];
    $accuracy = $_POST["accuracy"];
    $actual_date = date_format_uk_into_database($_POST["actual_date"]);
    $status_inventory = $_POST["status_inventory"];

    $admin_userid = $_SESSION["admin_userid"];

    $insert = "INSERT INTO tbdaily_report_tsc_inventory
    (
        plan_count_date
        ,item
        ,system
        ,actual
        ,diff
        ,accuracy
        ,actual_date
        ,status_inventory
        ,create_date
        ,admin_userid
    ) VALUES
    (
        '$plan_count_date'
        ,'$item'
        ,'$system'
        ,'$actual'
        ,'$diff'
        ,'$accuracy'
        ,'$actual_date'
        ,'$status_inventory'
        ,'$date_time'
        ,'$admin_userid'
    )";
    mssql_query($insert);


}else if($status=="update_inventory_tsc"){
    $id = $_POST["id"];
    $status_inventory_edit = $_POST["status_inventory_edit"];

    $update = "UPDATE  tbdaily_report_tsc_inventory  set status_inventory = '$status_inventory_edit'
            WHERE id='$id'";
    mssql_query($update);

}else if($status=="delete_inventory_tsc"){
    $id = $_POST["id"];

    $delete = "DELETE FROM tbdaily_report_tsc_inventory 
            WHERE id='$id'";
    mssql_query($delete);
    
}else if($status=="show_key_activity_improvement"){
    $report_date = date_format_uk_into_database($_POST["report_date"]);
    $site = ($_POST["site"]);
    $first_month = date("Y-m-1", strtotime($report_date));
    $last_month =  date("Y-m-t", strtotime($report_date));
    $month_improve =  date("m", strtotime($report_date));
    $year_improve =  date("Y", strtotime($report_date));
    $month_improve_show =  date("M", strtotime($report_date));
    // echo $month_improve_show;
    ?>
    <div class="panel panel-info">
        <div class="panel-heading">
            <h4>Improvement</h4>
        </div> 
        <div class="panel-body">
            <div class="form-horizontal">
                <!-- <div class="form-group " >
                    <label class="control-label col-sm-2" for="job_id_improve"><button onclick="gen_job_id_improve()">New job</button></label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" id="job_id_improve" name="job_id_improve" autocomplete="off"  readonly>
                    </div>
                </div> -->
                <div class="form-group " >
                    <label class="control-label col-sm-2" for="topic_improve">Topic</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" id="topic_improve" name="topic_improve" autocomplete="off"  >
                    </div>
                </div>
                <div class="form-group" >
                    <label class="control-label col-sm-2" for="status_improve">Status</label>
                    <div class="col-sm-2">
                        <select name="status_improve" id="status_improve" class="form-control">
                            <option value="">Select</option>
                            <option value="Delay">Delay</option>
                            <option value="On progress">On progress</option>
                            <option value="Complete">Complete</option>
                        </select>
                    </div>
                </div>
                <div class="form-group" >
                    <label class="control-label col-sm-2" for="pic_improve">PIC</label>
                    <div class="col-sm-3">
                        <select class="form-control" id="pic_improve" name="pic_improve">
                            <option value="">SELECT</option>
                            <?php
                            $sql_pic = "SELECT firstname,lastname FROM tbemployee WHERE site='$site' AND display_att='1' order by firstname";
                            $res_pic = mssql_query($sql_pic);
                            while($row_pic = mssql_fetch_array($res_pic)){
                                $firstname = lang_thai_from_database($row_pic["firstname"]);
                                $lastname = lang_thai_from_database($row_pic["lastname"]);
                                ?>
                                <option value="<?=$firstname?> <?=$lastname?>"><?=$firstname?> <?=$lastname?></option>
                                <?
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <!-- <div class="form-group" >
                    <label class="control-label col-sm-2" for="pic_improve">Picture </label>
                    <div class="col-sm-2" id="pic_improve_action" style="display:none">
                        <input type="hidden" id="idselect_improve">
                        <div class="image-upload text-center" >
                            <label for="fileToUpload_improve1">
                                <?
                            
                                $filename = "images/cam.png?$time";
                                ?>
                                <img id="cam_improve1" src="<?=$filename?>" width="100">
                            </label>

                            <input name="fileToUpload_improve1" onchange="fileSelected_improve('1','1');" accept="image/*" capture="camera" id="fileToUpload_improve1" type="file">
                        </div>
                        <div class='text-center'><input type="button" value="view" onclick="showmodal_improve('1');"><input type="hidden" id="fn_improve1" value="<?=$filename?>"></div>
                    </div>
                    <div class='col-sm-1'>
                        <span id="progress_improve"></span>
                    </div>
                </div> -->
                <div class="form-group">
                    <label class="control-label col-sm-2" for="due_improve">Due Date</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" id="due_improve" name="due_improve" autocomplete="off"  >
                        
                    </div>
                </div>
                
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button  class="btn btn-success" onclick='save_improve()'>Save</button>
                </div>
            </div>
            <br><br><br>
            <div class='table table-responsive'>
                <table class='table table-bordered table-striped' id="">
                    <tr>
                        <th>Month</th>
                        <th>Topic</th>
                        <th>Status</th>
                        <th>PIC</th>
                        <th>Due date</th>
                        <th>Delete</th>
                    </tr>
                    <?
                    $sql_improve = "SELECT 
                    convert(varchar, due_improve,103)as due_improve_date,*
                    FROM tbdaily_report_activity_improvement 
                    WHERE (MONTH(month_improve) = '$month_improve')
                    AND YEAR(month_improve) = '$year_improve'
                    AND site='$site'
                    order by due_improve asc";
                    // echo $sql_improve;
                    $res_improve = mssql_query($sql_improve);
                    while($row_improve = mssql_fetch_array($res_improve)){
                        $id = $row_improve["id"];
                        $job_id_improve = $row_improve["job_id_improve"];
                        $topic_improve = lang_thai_from_database($row_improve["topic_improve"]);
                        $status_improve = lang_thai_from_database($row_improve["status_improve"]);
                        $pic_improve = lang_thai_from_database($row_improve["pic_improve"]);
                        
                        $due_improve = $row_improve["due_improve_date"];

                        // $sql_pic_improve = "SELECT pic_improve  FROM tbdaily_report_activity_improvement_picture WHERE job_id_improve='$job_id_improve'";
                        // $res_pic_improve = mssql_query($sql_pic_improve);
                        // $num_pic_improve = mssql_num_rows($res_pic_improve);
                        // if($num_pic_improve>0){
                        //     $row_pic_improve = mssql_fetch_array($res_pic_improve);
                        //     $pic_improve = $row_pic_improve["pic_improve"];
    
                        //     $pic = "<img src='daily_improve/$pic_improve' width='120px'>";
                            
                        // }else{
                        //     $pic = "";
                        // }
                        ?>
                        <tr>
                            <td><?=$month_improve_show?></td>
                            <td><?=$topic_improve?></td>
                            <td>
                                <select name="status_improve_edit<?=$id?>" id="status_improve_edit<?=$id?>" class="form-control" onchange="update_improve('<?=$id?>')">
                                    <option value="">Select</option>
                                    <option value="Delay" <?php if($status_improve=="Delay"){echo "selected";}?>>Delay</option>
                                    <option value="On progress" <?php if($status_improve=="On progress"){echo "selected";}?>>On progress</option>
                                    <option value="Complete" <?php if($status_improve=="Complete"){echo "selected";}?>>Complete</option>
                                </select>
                            </td>
                            <td><?=$pic_improve?></td>
                            <td><?=$due_improve?></td>
                            <td><button class="btn btn-danger" onclick="delete_improve('<?=$id?>')">Delete</button></td>
                        </tr>
                        <?
                    }
                    ?>
                </table>
            </div>
        </div>
    </div>
    <?
}else if($status =="gen_job_id_improve"){
    $job_id_improve = "IPM".date("y").date("m");
    $sql_check = "SELECT top 1 job_id_improve from  tbdaily_report_activity_running where job_id_improve like '$job_id_improve%' order by job_id_improve desc";
    $res_check = mssql_query($sql_check);
    $num_check = mssql_num_rows($res_check);
    if ($num_check == 0) {
        $job_id_improve = "IPM".date("y").date("m")."0001";
    } else {
        $row = mssql_fetch_array($res_check);
        $job_id_improve2 = $row["job_id_improve"];
        $job_id_improve = $row["job_id_improve"];

        $tmp_newid = substr($job_id_improve, -4);
        $qid = (int) $tmp_newid + 1;
        $tmpid = "000000" . $qid;
        $qdno = substr($tmpid, -4);
        $job_id_improve = "IPM".date("y").date("m").$qdno;
    }
    $update = "UPDATE  tbdaily_report_activity_running set  job_id_improve='$job_id_improve'";
    mssql_query($update);

    echo $job_id_improve;

}else if($status=="save_improve"){
    $month_improve = date_format_uk_into_database($_POST["month_improve"]);
    $job_id_improve = $_POST["job_id_improve"];
    $topic_improve = lang_thai_into_database($_POST["topic_improve"]);
    $status_improve = $_POST["status_improve"];
    $pic_improve = lang_thai_into_database($_POST["pic_improve"]);
    $due_improve = date_format_uk_into_database($_POST["due_improve"]);
    $site = $_POST["site"];

    $admin_userid = $_SESSION["admin_userid"];

    $insert = "INSERT INTO tbdaily_report_activity_improvement
        (
            job_id_improve
            ,site
            ,month_improve
            ,topic_improve
            ,status_improve
            ,pic_improve
            ,due_improve
            ,create_date
            ,admin_userid
        ) VALUES 
        (
            '$job_id_improve'
            ,'$site'
            ,'$month_improve'
            ,'$topic_improve'
            ,'$status_improve'
            ,'$pic_improve'
            ,'$due_improve'
            ,'$date_time'
            ,'$admin_userid'
        )";
    mssql_query($insert);


}else if($status=="delete_improve"){
    $id = $_POST["id"];

    $delete = "DELETE FROM tbdaily_report_activity_improvement 
            WHERE id='$id'";
    mssql_query($delete);
}else if($status=="update_improve"){
    $id = $_POST["id"];
    $status_improve_edit = $_POST["status_improve_edit"];

    $update = "UPDATE  tbdaily_report_activity_improvement  set status_improve = '$status_improve_edit'
            WHERE id='$id'";
    mssql_query($update);


}else if($status=="show_key_activity_5s_audit"){
    $report_date = date_format_uk_into_database($_POST["report_date"]);
    $site = ($_POST["site"]);
    $first_month = date("Y-m-1", strtotime($report_date));
    $last_month =  date("Y-m-t", strtotime($report_date));
    $month_audit =  date("m", strtotime($report_date));
    $year_audit =  date("Y", strtotime($report_date));
    $month_audit_show =  date("M", strtotime($report_date));
    
    $last_month_audit =  date("m", strtotime($report_date.' -1 month'));
    $last_month_audit_show =  date("M", strtotime($report_date.' -1 month'));
    $last_year_audit =  date("Y", strtotime($report_date.' -1 month'));
    // echo $month_audit_show;
    ?>
    <div class="panel panel-success">
        <div class="panel-heading">
            <h4>5S. Monthly audit</h4>
        </div> 
        <div class="panel-body">
            <div class="form-horizontal">
                <div class="form-group">
                    <label class="control-label col-sm-2" for="date_audit">Audit Date</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" id="date_audit" name="date_audit" autocomplete="off"  >
                        
                    </div>
                </div>
                <div class="form-group " >
                    <label class="control-label col-sm-2" for="team_audit">Team</label>
                    <div class="col-sm-1">
                        <input type="text" class="form-control" id="team_audit" name="team_audit" autocomplete="off"  >
                    </div>
                </div>
                <div class="form-group " >
                    <label class="control-label col-sm-2" for="score_audit">Score</label>
                    <div class="col-sm-1">
                        <input type="number" class="form-control" id="score_audit" name="score_audit" autocomplete="off"  >
                    </div>
                </div>
                <div class="form-group " >
                    <label class="control-label col-sm-2" for="comment_audit">Comment</label>
                    <div class="col-sm-5" id="show_form_comment">
                        <input type="text" class="form-control" id="comment_audit[]" name="comment_audit[]" autocomplete="off"  >
                        
                    </div>
                    <div class="col-sm-3">
                        <button class="btn btn-info" onclick="add_comment()">เพิ่ม comment</button>
                    </div>
                </div>
                
                
            </div>

            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button  class="btn btn-success" onclick='save_audit()'>Save</button>
                </div>
            </div>

            <br><br><br>

            <div class='table table-responsive'>
                <table class='table table-bordered table-striped' id="">
                    <tr>
                        <th>Month</th>
                        <th>Audit date</th>
                        <th>Team</th>
                        <th>Score</th>
                        <th>Delete</th>
                    </tr>
                    <?
                    $sql_audit = "SELECT 
                    convert(varchar, date_audit,103)as date_audit_date,*
                    FROM tbdaily_report_activity_5s_audit 
                    WHERE (MONTH(date_audit) = '$month_audit')
                    AND YEAR(date_audit) = '$year_audit'
                    AND site='$site'
                    order by date_audit asc";
                    // echo $sql_audit;
                    $res_audit = mssql_query($sql_audit);
                    while($row_audit = mssql_fetch_array($res_audit)){
                        $id = $row_audit["id"];
                        $job_id_audit = $row_audit["job_id_audit"];
                        $score_audit = ($row_audit["score_audit"]);
                        $team_audit = lang_thai_from_database($row_audit["team_audit"]);
                        
                        $date_audit = $row_audit["date_audit_date"];

                        
                        ?>
                        <tr>
                            <td><?=$month_audit_show?></td>
                            <td><?=$date_audit?></td>
                            <td><?=$team_audit?></td>
                            <td><?=$score_audit?></td>
                            <td><button class="btn btn-danger" onclick="delete_audit('<?=$id?>')">Delete</button></td>
                        </tr>
                        <?
                    }
                    ?>
                    <tr>
                        <th colspan="5">Audit comment <?=$month_audit_show?></th>
                    </tr>
                    <?php 
                    $sql_last = "SELECT * FROM tbdaily_report_activity_5s_audit_comment 
                    WHERE MONTH(date_audit)='$month_audit'
                    AND YEAR(date_audit) = '$year_audit'
                    AND site='$site' 
                    ";
                    // echo $sql_last;
                    $res_last = mssql_query($sql_last);
                    $no = 0;
                    while($row_last = mssql_fetch_array($res_last)){
                        $comment_audit = lang_thai_from_database($row_last["comment_audit"]);
                        $no++;

                        ?>
                        <tr>
                            <td><?=$no?></td>
                            <td colspan='4'><?=$comment_audit?></td>
                        </tr>
                        <?

                    }
                    ?>
                    <tr>
                        <th colspan="5">Last audit comment <?=$last_month_audit_show?></th>
                    </tr>
                    <?php 
                    $sql_last = "SELECT * FROM tbdaily_report_activity_5s_audit_comment 
                    WHERE MONTH(date_audit)='$last_month_audit'
                    AND YEAR(date_audit) = '$last_year_audit'
                    AND date_audit IN (SELECT date_audit FROM tbdaily_report_activity_5s_audit WHERE site='$site')
                    ";
                    // echo $sql_last;
                    $res_last = mssql_query($sql_last);
                    $no = 0;
                    while($row_last = mssql_fetch_array($res_last)){
                        $comment_audit = lang_thai_from_database($row_last["comment_audit"]);
                        $no++;

                        ?>
                        <tr>
                            <td><?=$no?></td>
                            <td colspan='4'><?=$comment_audit?></td>
                        </tr>
                        <?

                    }
                    ?>
                </table>
            </div>
        </div>
    </div>
    <?
}else if($status=="save_audit"){
    $date_audit = date_format_uk_into_database($_POST["date_audit"]);
    $team_audit = $_POST["team_audit"];
    $score_audit = $_POST["score_audit"];
    $comment_audit = ($_POST["comment_audit"]);
    $month_audit = 
    $site = $_POST["site"];

    $sql = "SELECT * FROM tbdaily_report_activity_5s_audit WHERE site='$site' AND date_audit='$date_audit'";
    $res = mssql_query($sql);
    $num = mssql_num_rows($res);
    if($num > 0) {
        $update = "UPDATE tbdaily_report_activity_5s_audit set 
                    team_audit='$team_audit'
                    ,score_audit='$score_audit'
                    ,create_date='$date_time'
                    ,admin_userid='$admin_userid'
                    WHERE site='$site' AND date_audit='$date_audit'
                    ";
        mssql_query($update);
    }else{
        $insert = "INSERT INTO tbdaily_report_activity_5s_audit 
                    (site,date_audit,team_audit,score_audit,create_date,admin_userid)
                    VALUES
                    ('$site','$date_audit','$team_audit','$score_audit','$date_time','$admin_userid')";
        mssql_query($insert);
    }

    foreach($comment_audit as $comment_audit_list){
        if($comment_audit_list!=""){
            
            $comment_audit_list_utf = lang_thai_into_database($comment_audit_list);
            $insert_comment = "INSERT into tbdaily_report_activity_5s_audit_comment 
                                (site,date_audit,comment_audit)
                                VALUES 
                                ('$site','$date_audit','$comment_audit_list_utf')";
            mssql_query($insert_comment);
        }
    }

}else if($status=="delete_audit"){
    $id = $_POST["id"];
    $sql = "SELECT * FROM tbdaily_report_activity_5s_audit WHERE id='$id'";
    $res = mssql_query($sql);
    $row = mssql_fetch_array($res);
    $site = $row["site"];
    $date_audit = $row["date_audit"];

    $delete = "DELETE FROM tbdaily_report_activity_5s_audit WHERE id='$id'";
    mssql_query($delete);

    $delete_comment = "DELETE FROM tbdaily_report_activity_5s_audit_comment WHERE site='$site' AND date_audit='$date_audit'";
    mssql_query($delete_comment);



}else if($status=="show_key_activity_inventory_hq"){
    $report_date = date_format_uk_into_database($_POST["report_date"]);
    $first_month = date("m", strtotime($report_date));
    $last_month =  date("Y-m-t", strtotime($report_date));

    $month_inven =  date("m", strtotime($report_date));
    $year_inven =  date("Y", strtotime($report_date));
    $month_inven_show =  date("M", strtotime($report_date));
    //echo $first_month;
    ?>
    <div class="panel panel-green">
        <div class="panel-heading">
            <h4>Inventory</h4>
        </div> 
        <div class="panel-body">
            <div class="form-horizontal">
                <div class="form-group " >
                    <label class="control-label col-sm-2" for="plan_count_date">Plan count date</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" id="plan_count_date" name="plan_count_date" autocomplete="off"  >
                    </div>
                </div>
                
                <div class="form-group " >
                    <label class="control-label col-sm-2" for="focus_inven">ต้องโฟกัสอะไร</label>
                    <div class="col-sm-5" id="show_form_inven">
                        <input type="text" class="form-control" id="focus_inven[]" name="focus_inven[]" autocomplete="off"  >
                    </div>
                    <div class="col-sm-3">
                        <button class="btn btn-info" onclick="add_focus_inven()">เพิ่มสิ่งที่ต้องโฟกัส</button>
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button  class="btn btn-success" onclick='save_inventory()'>Save</button>
                    </div>
                </div>
            </div>
            <br>
            <div class='table table-responsive'>
                <table class='table table-bordered table-striped' id="">
                    <tr>
                        <th>Month</th>
                        <th colspan="2">Plan Date</th>
                    </tr>
                    <?php 
                    $sql_inven = "SELECT distinct convert(varchar, plan_count_date,103)as plan_count_date_date
                    
                    FROM tbdaily_report_hq_inventory 
                    WHERE MONTH(plan_count_date) = '$month_inven' 
                    AND YEAR(plan_count_date)='$year_inven'
                    ";
                    // echo $sql_inven;
                    $res_inven = mssql_query($sql_inven);
                    while($row_inven = mssql_fetch_array($res_inven)){
                        $id = $row_inven["id"];
                        $plan_count_date = $row_inven["plan_count_date_date"];
                        ?>
                        <tr>
                            <td><?=$month_inven_show?></td>
                            <td><?=$plan_count_date?></td>
                        </tr>
                        <?
                    }
                    ?>
                    <tr>
                        <th colspan="3">ต้องโฟกัส อะไร</th>
                    </tr>
                    <?php
                    $sql_inven = "SELECT * FROM tbdaily_report_hq_inventory WHERE MONTH(plan_count_date) = '$month_inven' 
                    AND YEAR(plan_count_date)='$year_inven' order by id";
                    $res_inven = mssql_query($sql_inven);
                    $no=0;
                    while($row_inven = mssql_fetch_array($res_inven)){
                        $id = $row_inven["id"];
                        $focus_inven = lang_thai_from_database($row_inven["focus_inven"]);
                        $no++;
                        ?>
                        <tr>
                            <td><?=$no?></td>
                            <td><?=$focus_inven?></td>
                            <td><button class="btn btn-danger" onclick="delete_inventory_hq('<?=$id?>');">Delete</button></td>
                        </tr>

                        <?
                    }
                    ?>
                </table>
            </div>
        </div>
    </div>
    <?

}else if($status=="save_inventory_hq"){
    $plan_count_date = date_format_uk_into_database($_POST["plan_count_date"]);
    $focus_inven = lang_thai_into_database($_POST["focus_inven"]);

    foreach($focus_inven as $focus_inven_list){

        $insert = "INSERT INTO tbdaily_report_hq_inventory (plan_count_date,focus_inven,create_date,admin_userid) 
                            VALUES ('$plan_count_date','$focus_inven_list','$date_time','$admin_userid')";
        mssql_query($insert);
    }

}else if($status=="delete_inventory_hq"){
    $id = $_POST["id"];
    $delete = "DELETE FROM tbdaily_report_hq_inventory WHERE id='$id'";
    mssql_query($delete);
}else if($status=="show_key_activity_inventory_osw"){
    $report_date = date_format_uk_into_database($_POST["report_date"]);
    $first_month = date("Y-m-1", strtotime($report_date));
    $last_month =  date("Y-m-t", strtotime($report_date));

    $month_inven_show =  date("M", strtotime($report_date));
    $month_inven =  date("m", strtotime($report_date));
    $year_inven =  date("Y", strtotime($report_date));
    //echo $first_month;
    ?>
    <div class="panel panel-green">
        <div class="panel-heading">
            <h4>Inventory</h4>
        </div> 
        <div class="panel-body">
            <div class="form-horizontal">
                <div class="form-group " >
                    <label class="control-label col-sm-2" for="plan_count_date">Plan count date</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" id="plan_count_date" name="plan_count_date" autocomplete="off"  >
                    </div>
                </div>
                
                <div class="form-group " >
                    <label class="control-label col-sm-2" for="pallet"><h4><strong>Pallet</strong></h4></label>
                    <div class="col-sm-1">
                        
                    </div>
                </div>
                <div class="form-group " >
                    <label class="control-label col-sm-2" for="system_pallet">System</label>
                    <div class="col-sm-1">
                        <input type="number" class="form-control" id="system_pallet" name="system_pallet" autocomplete="off" onchange="inventory_cal_pallet()">
                    </div>
                </div>
                <div class="form-group " >
                    <label class="control-label col-sm-2" for="actual_pallet">Actual</label>
                    <div class="col-sm-1">
                        <input type="number" class="form-control" id="actual_pallet" name="actual_pallet" autocomplete="off" onchange="inventory_cal_pallet()">
                    </div>
                </div>
                <div class="form-group " >
                    <label class="control-label col-sm-2" for="diff_pallet">Diff</label>
                    <div class="col-sm-1">
                        <input type="number" class="form-control" id="diff_pallet" name="diff_pallet" autocomplete="off" readonly>
                    </div>
                </div>
                <div class="form-group " >
                    <label class="control-label col-sm-2" for="accuracy_pallet">% Accuracy</label>
                    <div class="col-sm-1">
                        <input type="number" class="form-control" id="accuracy_pallet" name="accuracy_pallet" autocomplete="off" readonly>
                    </div>
                </div> 
                <div class="form-group " >
                    <label class="control-label col-sm-2" for="box"><h4><strong>Box remain pallet</strong></h4></label>
                    <div class="col-sm-1">
                        
                    </div>
                </div>
                <div class="form-group " >
                    <label class="control-label col-sm-2" for="system_box">System</label>
                    <div class="col-sm-1">
                        <input type="number" class="form-control" id="system_box" name="system_box" autocomplete="off" onchange="inventory_cal_box()">
                    </div>
                </div>
                <div class="form-group " >
                    <label class="control-label col-sm-2" for="actual_box">Actual</label>
                    <div class="col-sm-1">
                        <input type="number" class="form-control" id="actual_box" name="actual_box" autocomplete="off" onchange="inventory_cal_box()">
                    </div>
                </div>
                <div class="form-group " >
                    <label class="control-label col-sm-2" for="diff_box">Diff</label>
                    <div class="col-sm-1">
                        <input type="number" class="form-control" id="diff_box" name="diff_box" autocomplete="off" readonly>
                    </div>
                </div>
                <div class="form-group " >
                    <label class="control-label col-sm-2" for="accuracy_box">% Accuracy</label>
                    <div class="col-sm-1">
                        <input type="number" class="form-control" id="accuracy_box" name="accuracy_box" autocomplete="off" readonly>
                    </div>
                </div> 
               
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button  class="btn btn-success" onclick='save_inventory()'>Save</button>
                    </div>
                </div>
            </div>
            <br>
            <div class='table table-responsive'>
                <table class='table table-bordered table-striped' id="">
                    <tr>
                        <th>Plan Date</th>
                        <th>System</th>
                        <th>Delete</th>

                    </tr>
                    <?php 
                    $sql_inven = "SELECT * 
                    ,convert(varchar, plan_count_date,103)as plan_count_date_date
                    
                    FROM tbdaily_report_osw_inventory 
                    WHERE MONTH(plan_count_date) = '$month_inven' 
                    AND YEAR(plan_count_date)='$year_inven'
                    ";
                    // echo $sql_inven;
                    $res_inven = mssql_query($sql_inven);
                    while($row_inven = mssql_fetch_array($res_inven)){
                        $id = $row_inven["id"];
                        $plan_count_date = $row_inven["plan_count_date_date"];
                        $system_pallet = $row_inven["system_pallet"];
                        $actual_pallet = $row_inven["actual_pallet"];
                        $diff_pallet = $row_inven["diff_pallet"];
                        $accuracy_pallet = $row_inven["accuracy_pallet"];
                        $system_box = $row_inven["system_box"];
                        $actual_box = $row_inven["actual_box"];
                        $diff_box = $row_inven["diff_box"];
                        $accuracy_box = $row_inven["accuracy_box"];
                        
                        ?>
                        <tr>
                            <td><?=$month_inven_show?></td>
                            <td><?=$plan_count_date?></td>
                            <td><button class="btn btn-danger" onclick="delete_inventory_osw('<?=$id?>')">Delete</button></td>
                        </tr>
                        <tr>
                            <th colspan="3">Pallet</th>
                        </tr>
                        <tr>
                            <td>System</td>
                            <td colspan="2"><?=$system_pallet?></td>
                        </tr>
                        <tr>
                            <td>Actual</td>
                            <td colspan="2"><?=$actual_pallet?></td>
                        </tr>
                        <tr>
                            <td>Diff</td>
                            <td colspan="2"><?=$diff_pallet?></td>
                        </tr>
                        <tr>
                            <td>% Accuracy</td>
                            <td colspan="2"><?=$accuracy_pallet?></td>
                        </tr>
                        <tr>
                            <th colspan="3">Box remain pallet</th>
                        </tr>
                        <tr>
                            <td>System</td>
                            <td colspan="2"><?=$system_box?></td>
                        </tr>
                        <tr>
                            <td>Actual</td>
                            <td colspan="2"><?=$actual_box?></td>
                        </tr>
                        <tr>
                            <td>Diff</td>
                            <td colspan="2"><?=$diff_box?></td>
                        </tr>
                        <tr>
                            <td>% Accuracy</td>
                            <td colspan="2"><?=$accuracy_box?></td>
                        </tr>
                        <?
                    }
                    ?>
                </table>
            </div>
        </div>
    </div>
    <?
}else if($status=="save_inventory_osw"){
    $plan_count_date = date_format_uk_into_database($_POST["plan_count_date"]);
    $system_pallet = $_POST["system_pallet"];
    $actual_pallet = $_POST["actual_pallet"];
    $diff_pallet = $_POST["diff_pallet"];
    $accuracy_pallet = $_POST["accuracy_pallet"];
    $system_box = $_POST["system_box"];
    $actual_box = $_POST["actual_box"];
    $diff_box = $_POST["diff_box"];
    $accuracy_box = $_POST["accuracy_box"];

    $admin_userid = $_SESSION["admin_userid"];

    $insert = "INSERT INTO tbdaily_report_osw_inventory
    (
        plan_count_date
        ,system_pallet
        ,actual_pallet
        ,diff_pallet
        ,accuracy_pallet
        ,system_box
        ,actual_box
        ,diff_box
        ,accuracy_box
        ,create_date
        ,admin_userid
    ) VALUES
    (
        '$plan_count_date'
        ,'$system_pallet'
        ,'$actual_pallet'
        ,'$diff_pallet'
        ,'$accuracy_pallet'
        ,'$system_box'
        ,'$actual_box'
        ,'$diff_box'
        ,'$accuracy_box'
        ,'$date_time'
        ,'$admin_userid'
    )";
    mssql_query($insert);


}else if($status=="delete_inventory_osw"){
    $id = $_POST["id"];
    $delete = "DELETE FROM tbdaily_report_osw_inventory WHERE id='$id'";
    mssql_query($delete);
}
?>