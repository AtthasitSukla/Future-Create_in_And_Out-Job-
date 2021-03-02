<?php
session_start();
//echo $_SESSION['production_line'];
include("connect.php");
include("library.php");

$status = $_POST['status'];
$date_time = date("m/d/Y H:i:s");
$time = time();
$admin_userid = $_SESSION["admin_userid"];

if($status=="show_morning_meeting"){
    $report_date = date_format_uk_into_database($_POST["report_date"]);
    $site = ($_POST["site"]);
    $day_name = array('','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday');
    $date_day = date("N", strtotime($report_date));

    if($date_day==1){
        $panel_txt = "panel-yellow";
    }else if($date_day==2){
        $panel_txt = "panel-pink";
    }else if($date_day==3){
        $panel_txt = "panel-green";
    }else if($date_day==4){
        $panel_txt = "panel-organge";
    }else if($date_day==5){
        $panel_txt = "panel-blue";
    }else if($date_day==6){
        $panel_txt = "panel-purple";
    }else if($date_day==7){
        $panel_txt = "panel-danger";

    }
    ?>
    <div class="panel <?=$panel_txt?>">
        <div class="panel-heading">
            <h4><?=$day_name[$date_day]?></h4>
        </div> 
        <div class="panel-body">
            <div class="form-horizontal">
                <div class="form-group " >
                    <label class="control-label col-sm-2" for="type_meeting">Type</label>
                    <div class="col-sm-2">
                        <select name="type_meeting" id="type_meeting" class="form-control">
                            <option value="">Select</option>
                            <option value="Information">Information</option>
                            <option value="Action">Action</option>
                        </select>
                    </div>
                </div>
                <div class="form-group " >
                    <label class="control-label col-sm-2" for="detail_meeting">Detail</label>
                    <div class="col-sm-5">
                        <input type="text" name="detail_meeting" id="detail_meeting" class="form-control">
                    </div>
                </div>
                <div class="form-group " >
                    <label class="control-label col-sm-2" for="status_meeting">Status</label>
                    <div class="col-sm-2">
                        <select name="status_meeting" id="status_meeting" class="form-control">
                            <option value="">Select</option>
                            <option value="Delay">Delay</option>
                            <option value="On progress">On progress</option>
                            <option value="Complete">Complete</option>
                        </select>
                    </div>
                </div>
                <div class="form-group " >
                    <div class="col-sm-offset-2 col-sm-10">
                        <button  class="btn btn-success" onclick='save_morning_meeting()'>Save</button>
                    </div>
                </div>
            </div>
            <br><br><br>
            <!-- <div class='table table-responsive'>
                <table class='table table-striped table-bordered' id="">
                    <tr>
                        <td colspan='4' bgcolor='#fb8888'>Last Week</td>
                    </tr>
                    <tr>
                        <th>Date</th>
                        <th>Type</th>
                        <th>Detail</th>
                        <th>Status</th>
                    </tr>
                    <?php
                    if($date_day==1){

                        $last_week = date("Y-m-d",strtotime($report_date.' last Monday'));
                    }else{
                        $last_week = date("Y-m-d",strtotime($report_date.' last Monday -7 days'));

                    }
                    $end_last_week = date("Y-m-d",strtotime($last_week.' + 6 days'));
                    // echo $last_week.$end_last_week;
                    while (strtotime($last_week) <= strtotime($end_last_week)) {
                        $day_point = date("m/d/Y",strtotime($last_week));
                        // echo $day_point." ";
                        $sql_last="SELECT *,convert(varchar, report_date,103)as report_date_date FROM tbdaily_report_morning_meeting WHERE report_date='$day_point' AND site='$site' order by create_date";
                        $res_last = mssql_query($sql_last);
                        while($row_last = mssql_fetch_array($res_last)){
                            $report_date = $row_last["report_date"];
                            $type_meeting = $row_last["type_meeting"];
                            $detail_meeting = lang_thai_from_database($row_last["detail_meeting"]);
                            $status_meeting = $row_last["status_meeting"];

                            $date_day_point = date("N", strtotime($day_point));
                            ?>
                            <tr>
                                <td><?=$day_name[$date_day_point]?> ( <?=$report_date?> )</td>
                                <td><?=$type_meeting?></td>
                                <td><?=$detail_meeting?></td>
                                <td><?=$status_meeting?></td>
                            </tr>
                            <?
                        }

                        $last_week = date ("Y-m-d", strtotime("+1 day", strtotime($last_week)));
                    }
                    ?>
                </table>
            </div> -->
            <!-- <div class='table table-responsive'>
                <table class='table table-striped table-bordered' id="">
                    <tr>
                        <td colspan='5' bgcolor='#05ffa1'>Month</td>
                    </tr>
                    <tr>
                        <th>Date</th>
                        <th>Type</th>
                        <th>Detail</th>
                        <th>Status</th>
                        <th>Delete</th>
                    </tr>
                    <?php
                    if($date_day==1){

                        $this_week = date("Y-m-d",strtotime($report_date));
                    }else{
                        $this_week = date("Y-m-d",strtotime($report_date.' last Monday'));
                        

                    }
                    $end_this_week = date("Y-m-d",strtotime($this_week.' + 6 days'));
                    // echo $this_week.$end_this_week;
                    while (strtotime($this_week) <= strtotime($end_this_week)) {
                        $day_point = date("m/d/Y",strtotime($this_week));
                        // echo $day_point." ";
                        $sql_last="SELECT *,convert(varchar, report_date,103)as report_date_date 
                        FROM tbdaily_report_morning_meeting 
                        WHERE report_date='$day_point' AND site='$site' 
                        order by create_date";
                        $res_last = mssql_query($sql_last);
                        while($row_last = mssql_fetch_array($res_last)){
                            $id = $row_last["id"];
                            $report_date = $row_last["report_date"];
                            $type_meeting = $row_last["type_meeting"];
                            $detail_meeting = lang_thai_from_database($row_last["detail_meeting"]);
                            $status_meeting = $row_last["status_meeting"];

                            $date_day_point = date("N", strtotime($day_point));
                            ?>
                            <tr>
                                <td><?=$day_name[$date_day_point]?> ( <?=$report_date?> )</td>
                                <td><?=$type_meeting?></td>
                                <td><?=$detail_meeting?></td>
                                <td>
                                    <select name="status_meeting_edit<?=$id?>" id="status_meeting_edit<?=$id?>" class="form-control" onchange="update_morning_meeting('<?=$id?>')">
                                        <option value="">Select</option>
                                        <option value="Delay" <?php if($status_meeting=="Delay"){echo "selected";}?>>Delay</option>
                                        <option value="On progress" <?php if($status_meeting=="On progress"){echo "selected";}?>>On progress</option>
                                        <option value="Complete" <?php if($status_meeting=="Complete"){echo "selected";}?>>Complete</option>
                                    </select>
                                </td>
                                <td><button class="btn btn-danger" onclick="delete_morning_meeting('<?=$id?>')">Delete</button></td>
                            </tr>
                            <?
                        }

                        $this_week = date ("Y-m-d", strtotime("+1 day", strtotime($this_week)));
                    }
                    ?>
                </table>
            </div> -->
            <div class='table table-responsive'>
                <table class='table table-striped table-bordered' id="">
                    <tr>
                        <td colspan='5' bgcolor='#05ffa1'>This Month</td>
                    </tr>
                    <tr>
                        <th>Date</th>
                        <th>Type</th>
                        <th>Detail</th>
                        <th width="120px">Status</th>
                        <th>Delete</th>
                    </tr>
                    <?php
                    $report_date = date_format_uk_into_database($_POST["report_date"]);
                    $this_month = date("m",strtotime($report_date));
                    $this_year = date("Y",strtotime($report_date));
                        // echo $day_point." ";
                    $sql_last="SELECT *,convert(varchar, report_date,103)as report_date_date 
                    FROM tbdaily_report_morning_meeting 
                    WHERE Month(report_date)='$this_month'
                    AND Year(report_date)='$this_year' 
                    AND site='$site' 
                    order by report_date desc,create_date desc";
                    // echo $sql_last;
                    $res_last = mssql_query($sql_last);
                    while($row_last = mssql_fetch_array($res_last)){
                        $id = $row_last["id"];
                        $report_date = $row_last["report_date"];
                        $type_meeting = $row_last["type_meeting"];
                        $detail_meeting = lang_thai_from_database($row_last["detail_meeting"]);
                        $status_meeting = $row_last["status_meeting"];

                        $date_day_point = date("N", strtotime($report_date));
                        ?>
                        <tr>
                            <td><?=$day_name[$date_day_point]?> ( <?=$report_date?> )</td>
                            <td><?=$type_meeting?></td>
                            <td><?=$detail_meeting?></td>
                            <td>
                                <select name="status_meeting_edit<?=$id?>" id="status_meeting_edit<?=$id?>" class="form-control" onchange="update_morning_meeting('<?=$id?>')">
                                    <option value="">Select</option>
                                    <option value="Delay" <?php if($status_meeting=="Delay"){echo "selected";}?>>Delay</option>
                                    <option value="On progress" <?php if($status_meeting=="On progress"){echo "selected";}?>>On progress</option>
                                    <option value="Complete" <?php if($status_meeting=="Complete"){echo "selected";}?>>Complete</option>
                                </select>
                            </td>
                            <td><button class="btn btn-danger" onclick="delete_morning_meeting('<?=$id?>')">Delete</button></td>
                        </tr>
                        <?
                    }
                    ?>
                </table>
            </div>
        </div>
    </div>

    <?

}else if($status=='save_morning_meeting'){
    $report_date = date_format_uk_into_database($_POST["report_date"]);
    $type_meeting = $_POST["type_meeting"];
    $detail_meeting = lang_thai_into_database($_POST["detail_meeting"]);
    $status_meeting = $_POST["status_meeting"];
    $site = $_POST["site"];

    $insert = "INSERT INTO tbdaily_report_morning_meeting
        (
            site
            ,report_date
            ,detail_meeting
            ,type_meeting
            ,status_meeting
            ,create_date
            ,admin_userid
        )
        VALUES
        (
            '$site'
            ,'$report_date'
            ,'$detail_meeting'
            ,'$type_meeting'
            ,'$status_meeting'
            ,'$date_time'
            ,'$admin_userid'
        )";
    mssql_query($insert);
}else if($status=="update_morning_meeting"){
    $id = $_POST["id"];
    $status_meeting_edit = $_POST["status_meeting_edit"];

    $update = "UPDATE  tbdaily_report_morning_meeting  set status_meeting = '$status_meeting_edit'
            WHERE id='$id'";
    mssql_query($update);
    echo $update;
    
}else if($status=="delete_morning_meeting"){
    $id = $_POST["id"];

    $delete = "DELETE FROM tbdaily_report_morning_meeting 
            WHERE id='$id'";
    mssql_query($delete);
}

?>