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

if($status=="cost_accumulated"){
    $mmonth = $_POST["mmonth"];
    $yyear = $_POST["yyear"];
    for($i=1;$i<=$mmonth;$i++){
        include "connect_inv.php";
        $sql = "SELECT        SUM(total_grand) AS total_grand, MONTH(approve_date) AS month, YEAR(approve_date) AS years
        FROM            View_summary_po_approve_date
        WHERE MONTH(approve_date) =$i 
        AND YEAR(approve_date) ='$yyear'
        GROUP BY MONTH(approve_date), YEAR(approve_date)
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

       
    }
    echo "###";


}else if($status=="cost_accumulated_customer"){
    $mmonth = $_POST["mmonth"];
    $yyear = $_POST["yyear"];

    include "connect_inv.php";            
    $select_wk = "SELECT customer,sum(total_grand) as total_grand 
    from View_summary_po_approve_date 
    WHERE  YEAR(approve_date)=$yyear
    AND Month(approve_date)<=$mmonth
    group by customer
    order by total_grand desc ";
    // echo $select_wk;
    $re_wk = mssql_query($select_wk);
    $i=1;
    while($row_wk = mssql_fetch_array($re_wk)){
        if($i==1){
            echo number_format($row_wk['total_grand']/1000000,2);
        }else{
            echo "#".number_format($row_wk['total_grand']/1000000,2);
        }
        $i++;
    }
    echo "###";
    

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
                
                include "connect_inv.php";
                $sql = "SELECT        SUM(total_grand) AS total_grand, MONTH(approve_date) AS month, YEAR(approve_date) AS years
                FROM            View_summary_po_approve_date
                WHERE MONTH(approve_date) =$i_month AND YEAR(approve_date) ='$i_years'
                GROUP BY MONTH(approve_date), YEAR(approve_date)
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
        if($i_years==$yyear){
            
            $diff_years=$mmonth;

        }else{
            $diff_years=12;
        }
        echo "#".round(($avg_years/$diff_years)/1000000,2);
        echo "###";

    }

}else if($status=="chart_qty_ng"){
    $mmonth = $_POST["mmonth"];
    $yyear = $_POST["yyear"];
    
    include "connect_inv.php";
    for($i=1;$i<=$mmonth;$i++){
        $sql_ng = "SELECT sum(qty)  as sum_qty
        from  material_ng
        where MONTH(create_date)='$i'
        AND YEAR(create_date)='$yyear'
        ";
        $res_ng = mssql_query($sql_ng);
        $num_ng = mssql_num_rows($res_ng);
        $row_ng = mssql_fetch_array($res_ng);
        $sum_qty = $row_ng["sum_qty"];
        if($i==1){
            echo $sum_qty;
        }else{
            echo "#".$sum_qty;
        }
    }
}
?>