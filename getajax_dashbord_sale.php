<?php
//include("connect_inv.php"); 
include("library.php"); 

$date_time=date("m/d/Y H:i:s");
$current_month = date("m");
$current_year = date("Y");
$pre_month_year = date("m/d/Y", strtotime("-3 month"));
$deceased_month = date("m",strtotime($pre_month_year));
$deceased_year = date("Y",strtotime($pre_month_year));
$status = $_POST['status'];

if($status=="estimate_revenue_from_order"){
    $yyear = $_POST["yyear"];
    for($i=1;$i<=12;$i++){

        include "connect.php";
        $sql_db = "SELECT * FROM tbdashboard_sale_estimate_order where year='$yyear' AND month='$i' AND customer='SAB'";
        $res_db = mssql_query($sql_db);
        $num_db = mssql_num_rows($res_db);
        if($num_db > 0 ){
            $row_db = mssql_fetch_array($res_db);
            $data_display = $row_db["data_display"];
            if($i==1){
                echo round($data_display/1000000,2);
            }else{
                echo "#".round($data_display/1000000,2);
            }

        }else{
            include "connect_hq.php";
            $total_price_sab = 0;
            $sql = "SELECT  COUNT(Part_No) AS count_Part_No, Part_No,SNEP
            FROM tbsaborder 
            WHERE Delivery_order_date_Month='$i'
            AND Delivery_order_date_year='$yyear'
            GROUP BY Part_No,SNEP
            ";
            //echo $sql;
            $res = mssql_query($sql);
            while($row = mssql_fetch_array($res)){
                $count_Part_No = $row["count_Part_No"];
                $Part_No = $row["Part_No"];
                $SNEP = $row["SNEP"];
        
                include "connect_inv.php";
                $sql_price = "SELECT UNIT_PRICE 
                FROM tbpo_import
                WHERE REPLACE(PART_NO,' ','')='$Part_No'
                order by id desc";
                $res_price = mssql_query($sql_price);
                $num_price = mssql_num_rows($res_price);
                if($num_price>0){

                    $row_price = mssql_fetch_array($res_price);
                    $amount = round(($row_price["UNIT_PRICE"]*$SNEP)*$count_Part_No,2);
                }else{
                    $amount = 0;
                }
                $total_price_sab = $total_price_sab+($amount);
    
        
                
                include "connect_hq.php";
            }
            // $total_price_sab = 0;
            // $sql = "SELECT Issue_No FROM tbsaborder 
            // WHERE Delivery_order_date_Month='$i'
            // AND Delivery_order_date_year='$yyear'
            // ";
            // //echo $sql;
            // $res = mssql_query($sql);
            // while($row = mssql_fetch_array($res)){
            //     $Issue_No = $row["Issue_No"];
        
            //     include "connect_inv.php";
            //     $sql_price = "SELECT UNIT_PRICE,issue_no,scheduled_qty,UNIT_PRICE*scheduled_qty as amount 
            //     FROM tbpo_import as po 
            //     INNER JOIN tbpo_confirm as con 
            //         on po.PONO = con.purch_doc
            //         and po.part_no=con.PART_NO
            //     WHERE issue_no='$Issue_No'";
            //     $res_price = mssql_query($sql_price);
            //     $row_price = mssql_fetch_array($res_price);
            //     $amount = round($row_price["amount"],2);
            //     $total_price_sab = $total_price_sab+($amount);
    
        
                
            //     include "connect_hq.php";
            // }
            if($i==1){
                echo round($total_price_sab/1000000,2);
            }else{
                echo "#".round($total_price_sab/1000000,2);
            }
            if($i<=(int)$deceased_month && $yyear<=(int)$deceased_year){
                include "connect.php";
                $insert = "INSERT INTO tbdashboard_sale_estimate_order (year,month,customer,data_display,create_date)
                                                VALUES ('$yyear','$i','SAB','$total_price_sab','$date_time')";
                mssql_query($insert);
                include "connect_hq.php";

            }
        }
    }
    echo "###";
    for($i=1;$i<=12;$i++){

        include "connect.php";
        $sql_db = "SELECT * FROM tbdashboard_sale_estimate_order where year='$yyear' AND month='$i' AND customer='SAB_KD'";
        $res_db = mssql_query($sql_db);
        $num_db = mssql_num_rows($res_db);
        if($num_db > 0 ){
            $row_db = mssql_fetch_array($res_db);
            $data_display = $row_db["data_display"];
            if($i==1){
                echo round($data_display/1000000,2);
            }else{
                echo "#".round($data_display/1000000,2);
            }

        }else{
            include "connect_hq.php";
            $total_price_sab_kd = 0;
            $sql = "SELECT  COUNT(Part_No) AS count_Part_No, Part_No,SNEP
            FROM tbsaborder_kd 
            WHERE Delivery_order_date_Month='$i'
            AND Delivery_order_date_year='$yyear'
            GROUP BY Part_No,SNEP
            ";
            //echo $sql;
            $res = mssql_query($sql);
            while($row = mssql_fetch_array($res)){
                $count_Part_No = $row["count_Part_No"];
                $Part_No = $row["Part_No"];
                $SNEP = $row["SNEP"];
        
                include "connect_inv.php";
                $sql_price = "SELECT UNIT_PRICE 
                FROM tbpo_import_kd
                WHERE REPLACE(PART_NO,' ','')='$Part_No'
                order by id desc";
                $res_price = mssql_query($sql_price);
                $num_price = mssql_num_rows($res_price);
                if($num_price>0){

                    $row_price = mssql_fetch_array($res_price);
                    $amount = round(($row_price["UNIT_PRICE"]*$SNEP)*$count_Part_No,2);
                }else{
                    $amount = 0;
                }
                $total_price_sab_kd = $total_price_sab_kd+($amount);
    
        
                
                include "connect_hq.php";
            }
            if($i==1){
                echo round($total_price_sab_kd/1000000,2);
            }else{
                echo "#".round($total_price_sab_kd/1000000,2);
            }
            if($i<=(int)$deceased_month && $yyear<=(int)$deceased_year){
                include "connect.php";
                $insert = "INSERT INTO tbdashboard_sale_estimate_order (year,month,customer,data_display,create_date)
                                                VALUES ('$yyear','$i','SAB_KD','$total_price_sab_kd','$date_time')";
                mssql_query($insert);
                include "connect_hq.php";

            }
        }
    }
    echo "###";
    for($i=1;$i<=12;$i++){
        include "connect.php";
        $sql_db = "SELECT * FROM tbdashboard_sale_estimate_order where year='$yyear' AND month='$i' AND customer='Topre'";
        $res_db = mssql_query($sql_db);
        $num_db = mssql_num_rows($res_db);
        if($num_db > 0 ){
            $row_db = mssql_fetch_array($res_db);
            $data_display = $row_db["data_display"];
            if($i==1){
                echo round($data_display/1000000,2);
            }else{
                echo "#".round($data_display/1000000,2);
            }

        }else{
            include "connect_topre.php";
            $total_price_topre = 0;
            
            $sql = "SELECT  COUNT(Part_No) AS count_Part_No, Part_No
            FROM tbsaborder 
            WHERE Delivery_order_date_Month='$i'
            AND Delivery_order_date_year='$yyear'
            GROUP BY Part_No
            ";
            $res = mssql_query($sql);
            while($row = mssql_fetch_array($res)){
                $count_Part_No = $row["count_Part_No"];
                $Part_No = $row["Part_No"];
        
                include "connect_inv.php";
                $sql_price = "SELECT top 1 amount FROM  tbpo_confirm_topre WHERE Part_No='$Part_No' order by id desc";
                $res_price = mssql_query($sql_price);
                $num_price = mssql_num_rows($res_price);
                if($num_price > 0){

                    $row_price = mssql_fetch_array($res_price);
                    $amount = round($row_price["amount"]*$count_Part_No,2);
                }else{
                    $amount = 0;
                }
                $total_price_topre = $total_price_topre+($amount);
        
                
                include "connect_topre.php";
            }
            // $sql = "SELECT Issue_No FROM tbsaborder 
            // WHERE Delivery_order_date_Month='$i'
            // AND Delivery_order_date_year='$yyear'
            // ";
            // $res = mssql_query($sql);
            // while($row = mssql_fetch_array($res)){
            //     $Issue_No = $row["Issue_No"];
        
            //     include "connect_inv.php";
            //     $sql_price = "SELECT * FROM  tbpo_confirm_topre WHERE issue_no='$Issue_No'";
            //     $res_price = mssql_query($sql_price);
            //     $row_price = mssql_fetch_array($res_price);
            //     $amount = round($row_price["amount"],2);
            //     $total_price_topre = $total_price_topre+($amount);
        
                
            //     include "connect_topre.php";
            // }
            if($i==1){
                echo round($total_price_topre/1000000,2);
            }else{
                echo "#".round($total_price_topre/1000000,2);
            }
            if($i<=(int)$deceased_month && $yyear<=(int)$deceased_year){
                include "connect.php";
                $insert = "INSERT INTO tbdashboard_sale_estimate_order (year,month,customer,data_display,create_date)
                                                VALUES ('$yyear','$i','Topre','$total_price_topre','$date_time')";
                mssql_query($insert);
                include "connect_topre.php";

            }
        }
    }
}else if($status=="revenue_accumulated"){
    $mmonth = $_POST["mmonth"];
    $yyear = $_POST["yyear"];
    for($i=1;$i<=$mmonth;$i++){
        include "connect_inv.php";
        $sql = "SELECT        SUM(total_grand) AS total_grand, MONTH(create_date) AS month, YEAR(create_date) AS years
        FROM            View_summary_invoice_cn_create_date
        WHERE MONTH(create_date) =$i 
        AND YEAR(create_date) ='$yyear'
        GROUP BY MONTH(create_date), YEAR(create_date)
        ORDER BY month, years";
        $res = mssql_query($sql);
        while($row = mssql_fetch_array($res)){
            $total_grand = $row["total_grand"];
            if($i==1){
                echo round($total_grand/1000000,2);
            }else{
                echo "#".round($total_grand/1000000,2);
            }
        }

        // include "connect.php";
        // $sql_db = "SELECT * FROM tbdashboard_sale_revenue where year='$yyear' AND month='$i' ";
        // $res_db = mssql_query($sql_db);
        // $num_db = mssql_num_rows($res_db);
        // if($num_db > 0 ){
        //     $row_db = mssql_fetch_array($res_db);
        //     $data_display = $row_db["data_display"];
        //     if($i==1){
        //         echo round($data_display/1000000,2);
        //     }else{
        //         echo "#".round($data_display/1000000,2);
        //     }

        // }else{
        //     include "connect_inv.php";
        //     $total_revenue = 0;
        //     $sql = "SELECT        receipt.receipt_no, receipt.receipt_date, detail.inv_no
        //     FROM            tbpo_inv_receipt AS receipt INNER JOIN
        //                             tbpo_inv_receipt_detail AS detail ON receipt.receipt_no = detail.receipt_no
        //     WHERE        (MONTH(receipt.receipt_date) = '$i') AND (YEAR(receipt.receipt_date) = '$yyear')
        //     ";
        //     $res = mssql_query($sql);
        //     while($row = mssql_fetch_array($res)){
        //         $inv_no = $row["inv_no"];
    
        //         $sql_inv = "SELECT sum(amount) as sum_amount FROM tbpo_invoice_detial WHERE doc_no='$inv_no' ";
        //         $res_inv = mssql_query($sql_inv);
        //         $row_inv = mssql_fetch_array($res_inv);
        //         $sum_amount = $row_inv["sum_amount"];
    
        //         $total_revenue = $total_revenue+$sum_amount;
        //     }
        //     if($i==1){
        //         echo round($total_revenue/1000000,2);
        //     }else{
        //         echo "#".round($total_revenue/1000000,2);
        //     } 
            
        //     if($i<=(int)$deceased_month && $yyear<=(int)$deceased_year){
        //         include "connect.php";
        //         $insert = "INSERT INTO tbdashboard_sale_revenue (year,month,data_display,create_date)
        //                                         VALUES ('$yyear','$i','$total_revenue','$date_time')";
        //         mssql_query($insert);
        //         include "connect_inv.php";

        //     }
        // }

       
    }
    echo "###";

    // $total_accumulated = 0;
    // for($i=1;$i<=12;$i++){
    //     $sql = "SELECT        receipt.receipt_no, receipt.receipt_date, detail.inv_no
    //     FROM            tbpo_inv_receipt AS receipt INNER JOIN
    //                             tbpo_inv_receipt_detail AS detail ON receipt.receipt_no = detail.receipt_no
    //     WHERE        (MONTH(receipt.receipt_date) = '$i') AND (YEAR(receipt.receipt_date) = '$yyear')
    //     ";
    //     $res = mssql_query($sql);
    //     while($row = mssql_fetch_array($res)){
    //         $inv_no = $row["inv_no"];

    //         $sql_inv = "SELECT sum(amount) as sum_amount FROM tbpo_invoice_detial WHERE doc_no='$inv_no' ";
    //         $res_inv = mssql_query($sql_inv);
    //         $row_inv = mssql_fetch_array($res_inv);
    //         $sum_amount = $row_inv["sum_amount"];

    //         $total_accumulated = $total_accumulated+$sum_amount;
    //     }
    //     if($i==1){
    //         echo round($total_accumulated/1000000,2);
    //     }else{
    //         echo "#".round($total_accumulated/1000000,2);
    //     }
    // }

}else if($status=="revenue_target"){
    $yyear = $_POST["yyear"];

    include "connect.php";
    $sql_target = "SELECT data_display FROM tbdashboard_sale_revenue_target WHERE year='$yyear' ";
    $res_target = mssql_query($sql_target);
    $row_target = mssql_fetch_array($res_target);
    $data_display_target = $row_target["data_display"];


    $total_sales = 0;
    include "connect_inv.php";
    $sql = "SELECT        SUM(total_grand) AS total_sales
    FROM            View_summary_invoice_cn_create_date
    WHERE  YEAR(create_date) ='$yyear'";
    $res = mssql_query($sql);
    $row = mssql_fetch_array($res);
    $total_sales = $row["total_sales"];
    // for($i=1;$i<=12;$i++){

    //     include "connect.php";
    //     $sql_db = "SELECT * FROM tbdashboard_sale_revenue where year='$yyear' AND month='$i' ";
    //     $res_db = mssql_query($sql_db);
    //     $num_db = mssql_num_rows($res_db);
    //     if($num_db > 0 ){
    //         $row_db = mssql_fetch_array($res_db);
    //         $data_display = $row_db["data_display"];
    //         $total_sales = $total_sales+$data_display;
            

    //     }else{
    //         include "connect_inv.php";
    //         $sql = "SELECT        receipt.receipt_no, receipt.receipt_date, detail.inv_no
    //         FROM            tbpo_inv_receipt AS receipt INNER JOIN
    //                                 tbpo_inv_receipt_detail AS detail ON receipt.receipt_no = detail.receipt_no
    //         WHERE        (MONTH(receipt.receipt_date) = '$i') AND (YEAR(receipt.receipt_date) = '$yyear')
    //         ";
    //         $res = mssql_query($sql);
    //         while($row = mssql_fetch_array($res)){
    //             $inv_no = $row["inv_no"];
    
    //             $sql_inv = "SELECT sum(amount) as sum_amount FROM tbpo_invoice_detial WHERE doc_no='$inv_no' ";
    //             $res_inv = mssql_query($sql_inv);
    //             $row_inv = mssql_fetch_array($res_inv);
    //             $sum_amount = $row_inv["sum_amount"];
    
    //             $total_sales = $total_sales+$sum_amount;
    //         }
            
    //     }
    // }

    $percent_sales = round(($total_sales*100)/$data_display_target,2);
    $percent_target = round(100-$percent_sales,2);

    echo "$percent_target###$percent_sales";

}else if($status=="compare_three_years"){
    $mmonth = $_POST["mmonth"];
    $yyear = $_POST["yyear"];
    $previous_years = (int)$yyear-2;

    for($i_years=$previous_years;$i_years<=$yyear;$i_years++){
        $avg_years=0;
        $diff_years=0;

        

        for($i_month=1;$i_month<=12;$i_month++){

            if(($i_years==$yyear) && ($i_month>$mmonth)){

                echo "#".round(0,2);
                
            }else{
                include "connect.php";
                $sql_db = "SELECT * FROM tbdashboard_sale_revenue where year='$i_years' AND month='$i_month' ";
                $res_db = mssql_query($sql_db);
                $num_db = mssql_num_rows($res_db);
                if($num_db > 0 ){
                    $diff_years++;
                    $row_db = mssql_fetch_array($res_db);
                    $data_display = $row_db["data_display"];
                    $avg_years=$avg_years+$data_display;
                    if($i_month==1){
                        echo round($data_display/1000000,2);
                    }else{
                        echo "#".round($data_display/1000000,2);
                    }
    
                }else{
                    include "connect_inv.php";
                    $sql = "SELECT        SUM(total_grand) AS total_grand, MONTH(create_date) AS month, YEAR(create_date) AS years
                    FROM            View_summary_invoice_cn_create_date
                    WHERE MONTH(create_date) =$i_month AND YEAR(create_date) ='$i_years'
                    GROUP BY MONTH(create_date), YEAR(create_date)
                    ORDER BY month, years";
                    $res = mssql_query($sql);
                    $num = mssql_num_rows($res);
                    if($num > 0){
                        $diff_years++;
                        while($row = mssql_fetch_array($res)){
                            $total_grand = $row["total_grand"];
        
                            $avg_years=$avg_years+$total_grand;
        
                            if($i_month==1){
                                echo round($total_grand/1000000,2);
                            }else{
                                echo "#".round($total_grand/1000000,2);
                            }
                        }
                    }else{
                        echo "#".round(0,2);
                    }
                    
                }
            }
        }
        if($i_years==$yyear){
            
            $diff_years=$mmonth;

        }else{
            $diff_years=12;
        }
        echo "#".round(($avg_years/$diff_years)/1000000,2);
        echo "###";

    }

}
?>