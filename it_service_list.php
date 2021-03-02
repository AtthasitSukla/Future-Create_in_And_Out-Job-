<?php  
session_start();
include("connect.php");
include("library.php"); 
$job_id = $_GET["job_id"];
$status = $_GET['status'];

$mmonth = $_REQUEST['mmonth'];
$yyear = $_REQUEST['yyear'];
$arr_month = array('','Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');
if($yyear==''){
$yyear = date('Y');
}
if($mmonth==''){
$mmonth = date('n');//'9';//
}


 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Hrs : IT SERVICE</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="I-Wis">
	<meta name="author" content="The Red Team">

    <link rel="stylesheet" href="assets/css/styles.css?=140">

    <link href='assets/demo/variations/default.css' rel='stylesheet' type='text/css' media='all' id='styleswitcher'> 
    <link href='assets/demo/variations/default.css' rel='stylesheet' type='text/css' media='all' id='headerswitcher'> 
     

    <link rel='stylesheet' type='text/css' href='assets/plugins/codeprettifier/prettify.css' /> 
    <link rel='stylesheet' type='text/css' href='assets/plugins/form-multiselect/css/multi-select.css' /> 
    <link rel='stylesheet' type='text/css' href='assets/plugins/form-toggle/toggles.css' /> 
    <link rel="stylesheet" type="text/css" href="assets/css/multi-select.css">

    <link rel='stylesheet' type='text/css' href='assets/css/bootstrap.min.css' /> 
    <link rel='stylesheet' type='text/css' href='assets/css/buttons.dataTables.min.css' />
    <link rel='stylesheet' type='text/css' href='assets/css/dataTables.bootstrap.min.css' /> 

    <script type="text/javascript" src="assets/js/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<!--<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.0/Chart.bundle.min.js"></script>

<style>
td {
    padding: 5px;
}
</style>
<script>
$(document).ready(function() {
    $('#example').DataTable({
        "order": [[ 0, "desc" ]]
    });
	 $('#tbdevelop').DataTable({
        "order": [[ 0, "desc" ]]
    });
	
	
	
    $(".start_date").datepicker({
    });
	 $("#end_date").datepicker({
        format:'dd/mm/yyyy'
    });
	 $(".due_date").datepicker({
    });
	 $("#due_date0").datepicker({
    });
	
	<?
	if($job_id==''){
	?>
	
	
	
	Chart.pluginService.register({
    beforeRender: function (chart) {
        if (chart.config.options.showAllTooltips) {
            // create an array of tooltips
            // we can't use the chart tooltip because there is only one tooltip per chart
            chart.pluginTooltips = [];
            chart.config.data.datasets.forEach(function (dataset, i) {
                chart.getDatasetMeta(i).data.forEach(function (sector, j) {
                    chart.pluginTooltips.push(new Chart.Tooltip({
                        _chart: chart.chart,
                        _chartInstance: chart,
                        _data: chart.data,
                        _options: chart.options,
                        _active: [sector]
                    }, chart));
                });
            });

            // turn off normal tooltips
            chart.options.tooltips.enabled = false;
        }
    },
    afterDraw: function (chart, easing) {
        if (chart.config.options.showAllTooltips) {
            // we don't want the permanent tooltips to animate, so don't do anything till the animation runs atleast once
            if (!chart.allTooltipsOnce) {
                if (easing !== 1)
                    return;
                chart.allTooltipsOnce = true;
            }

            // turn on tooltips
            chart.options.tooltips.enabled = true;
            Chart.helpers.each(chart.pluginTooltips, function (tooltip) {
                tooltip.initialize();
                tooltip.update();
                // we don't actually need this since we are not animating tooltips
                tooltip.pivot();
                tooltip.transition(easing).draw();
            });
            chart.options.tooltips.enabled = false;
        }
    }
});

	
	var ctx = document.getElementById('myChart').getContext('2d');
    var chart = new Chart(ctx, {
        // The type of chart we want to create
		
        type: 'bar',
		
        // The data for our dataset
        data: {
            
            labels: [<?
			for($i=1;$i<=sizeof($arr_month);$i++){
					
					echo "'".$arr_month[$i]."'";
					echo ", ";
				}
			?>],
            datasets: [{
                    label: 'Open Develop',
                    backgroundColor: 'rgb(255, 51, 51)',
                    borderColor: 'rgb(66, 254, 0)',
                    data:[ <?
				
				for($i=1;$i<=sizeof($arr_month);$i++){
						
						$select_month = "select count(id) as total_qty_count from tbitservice_list where problem_type='Develop' and 
MONTH(create_date) = $i AND YEAR(create_date) = $yyear and job_status not in('Cancel','Hold')";
				$re_month = mssql_query($select_month);
				 $row_month = mssql_fetch_array($re_month);
				echo $row_month['total_qty_count'];
				echo ", ";
						
					}
				
			
					
				
				
				
			?>]
               },
			   {
                    label: 'Close Develop',
                    backgroundColor: 'rgb(178, 255, 102)',
                    borderColor: 'rgb(66, 254, 0)',
                    data:[ <?
				
				for($i=1;$i<=sizeof($arr_month);$i++){
						
						$select_month = "select count(id) as total_qty_count from tbitservice_list where problem_type='Develop'  and MONTH(create_date) = $i AND YEAR(create_date) = $yyear and job_status='Close'";
				$re_month = mssql_query($select_month);
				 $row_month = mssql_fetch_array($re_month);
				echo $row_month['total_qty_count'];
				echo ", ";
						
					}
				
			
					
				
				
				
			?>]
               },
			   {
                    label: 'Open Other',
                    backgroundColor: 'rgb(255, 178, 102)',
                    borderColor: 'rgb(66, 254, 0)',
                    data:[ <?
				
				for($i=1;$i<=sizeof($arr_month);$i++){
						
						$select_month = "select count(id) as total_qty_count from tbitservice_list where problem_type<>'Develop' and 
MONTH(create_date) = $i AND YEAR(create_date) = $yyear  and job_status not in('Cancel','Hold')";
				$re_month = mssql_query($select_month);
				 $row_month = mssql_fetch_array($re_month);
				echo $row_month['total_qty_count'];
				echo ", ";
						
					}
				
			
					
				
				
				
			?>]
               },
			   {
                    label: 'Close Other',
                    backgroundColor: 'rgb(102, 255, 102)',
                    borderColor: 'rgb(66, 254, 0)',
                    data:[ <?
				
				for($i=1;$i<=sizeof($arr_month);$i++){
						
						$select_month = "select count(id) as total_qty_count from tbitservice_list where problem_type<>'Develop'  and MONTH(create_date) = $i AND YEAR(create_date) = $yyear and job_status='Close'";
				$re_month = mssql_query($select_month);
				 $row_month = mssql_fetch_array($re_month);
				echo $row_month['total_qty_count'];
				echo ", ";
						
					}
				
			
					
				
				
				
			?>]
               }]  
				
           
        },

        // Configuration options go here
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            },
			tooltips: {
                enabled: true
            },
            hover: {
                animationDuration: 0
            },
            animation: {
                duration: 1,
                onComplete: function () {
                    var chartInstance = this.chart,
                    ctx = chartInstance.ctx;

                    ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
                    ctx.textAlign = 'center';
                    ctx.textBaseline = 'bottom';

                    this.data.datasets.forEach(function (dataset, i) {
                        var meta = chartInstance.controller.getDatasetMeta(i);
                        //alert(i);
                        if(i==1){
                            ctx.fillStyle = '#000';
                        }
                        meta.data.forEach(function (bar, index) {
                            var data = dataset.data[index];                            
                            ctx.fillText(data, bar._model.x, bar._model.y - 5);
                        });
                    });
                }
            },
			title: {
            display: true,
            text: 'Jobs <?=$yyear?>'
        }
        }
    });
	
	var ctx = document.getElementById('myChart2').getContext('2d');
	var data ={
            
            labels: ['Develop','Software','Hardware','Network','Other'],
            datasets: [{
               
                
                   
                    backgroundColor: ['rgb(51, 153, 255)','rgb(153, 51, 255)','rgb(102, 255, 178)','rgb(255, 153, 51)','rgb(192, 192, 192)'],
                    borderColor: 'rgb(66, 254, 0)',
                    data:[<?
					$select_month = "select count(id) as total_qty_count from tbitservice_list where problem_type='Develop'  and YEAR(create_date) = $yyear ";
				$re_month = mssql_query($select_month);
				 $row_month = mssql_fetch_array($re_month);
				echo $row_month['total_qty_count'];
					?>,<?
					$select_month = "select count(id) as total_qty_count from tbitservice_list where problem_type='Software'  and YEAR(create_date) = $yyear ";
				$re_month = mssql_query($select_month);
				 $row_month = mssql_fetch_array($re_month);
				echo $row_month['total_qty_count'];
					?>,<?
					$select_month = "select count(id) as total_qty_count from tbitservice_list where problem_type='Hardware'  and YEAR(create_date) = $yyear ";
				$re_month = mssql_query($select_month);
				 $row_month = mssql_fetch_array($re_month);
				echo $row_month['total_qty_count'];
					?>,<?
					$select_month = "select count(id) as total_qty_count from tbitservice_list where problem_type='Network'  and YEAR(create_date) = $yyear ";
				$re_month = mssql_query($select_month);
				 $row_month = mssql_fetch_array($re_month);
				echo $row_month['total_qty_count'];
					?>,<?
					$select_month = "select count(id) as total_qty_count from tbitservice_list where problem_type='Other'  and YEAR(create_date) = $yyear ";
				$re_month = mssql_query($select_month);
				 $row_month = mssql_fetch_array($re_month);
				echo $row_month['total_qty_count'];
					?>]
               }]  
				
           
        };
    var chart = new Chart(ctx, {
        // The type of chart we want to create
        type: 'doughnut',
       data: data,
        // Configuration options go here
        options: {
			showAllTooltips: true,
			title: {
            display: true,
            text: 'Jobs <?=$yyear?>'
        }
			}
    });
	
	
	
	///// JOBS JAN-JUL
	var ctx = document.getElementById('myChart_itservice').getContext('2d');
	var data ={
            <?
			//YEAR(create_date) = $yyear
			$select_month0 = "select count(id) as total_qty_count0 from View_tbitservice_list where  cast(create_date as date) between '01/01/2020' and '07/31/2020' and problem_type <>'Develop' and job_status not in('Cancel','Hold')";
				$re_month0 = mssql_query($select_month0);
				 $row_month0 = mssql_fetch_array($re_month0);
				 
				 $select_month1 = "select count(id) as total_qty_count from View_tbitservice_list where  cast(create_date as date) between '01/01/2020' and '07/31/2020' and  empno_close='59011' and problem_type <>'Develop' and job_status not in('Cancel','Hold')";
				 $re_month1 = mssql_query($select_month1);
				 $row_month1 = mssql_fetch_array($re_month1);
				 
				 $select_month2 = "select count(id) as total_qty_count from View_tbitservice_list where  cast(create_date as date) between '01/01/2020' and '07/31/2020' and empno_close='61001' and problem_type <>'Develop' and job_status not in('Cancel','Hold')";
				$re_month2 = mssql_query($select_month2);
				 $row_month2 = mssql_fetch_array($re_month2);
				 
			?>
            labels: ['Thanatwat (<?=number_format(((int)$row_month1['total_qty_count']/(int)$row_month0['total_qty_count0'])*100, 2)?>%)','Atthasit (<?=number_format(((int)$row_month2['total_qty_count']/(int)$row_month0['total_qty_count0'])*100, 2)?>%)'],
            datasets: [{
               
                
                   
                    backgroundColor: ['rgb(51, 153, 255)','rgb(153, 51, 255)'],
                    borderColor: 'rgb(66, 254, 0)',
                    data:[<?
					
				
				echo $row_month1['total_qty_count'];
				?>,<?
				
				echo $row_month2['total_qty_count'];
					?>]
               }]  
				
           
        };
    var chart = new Chart(ctx, {
        // The type of chart we want to create
        type: 'doughnut',
       data: data,
        // Configuration options go here
        options: {
			showAllTooltips: true,
			title: {
            display: true,
            text: 'IT Support JAN - JUL <?=$yyear?>'
        }
			}
    });
	
	var ctx = document.getElementById('myChart_develop').getContext('2d');
	var data ={
            <?
			$select_month0 = "select count(id) as total_qty_count0 from tbitprogram_list where cast(create_date as date) between '01/01/2020' and '07/31/2020' ";
				$re_month0 = mssql_query($select_month0);
				 $row_month0 = mssql_fetch_array($re_month0);
			$select_month1 = "select count(id) as total_qty_count from tbitprogram_list where  cast(create_date as date) between '01/01/2020' and '07/31/2020' and   incharge='Thanatwat'";
				$re_month1 = mssql_query($select_month1);
				 $row_month1 = mssql_fetch_array($re_month1);
				 $select_month2 = "select count(id) as total_qty_count from tbitprogram_list where  cast(create_date as date) between '01/01/2020' and '07/31/2020'  and incharge='Atthasit'";
				$re_month2 = mssql_query($select_month2);
				 $row_month2 = mssql_fetch_array($re_month2);
				 
				// echo number_format(((int)$row_month1['total_qty_count']/(int)$row_month0['total_qty_count0'])*100, 2);
				//echo number_format(((int)$row_month2['total_qty_count']/(int)$row_month0['total_qty_count0'])*100, 2);
			?>
            labels: ['Thanatwat (<?=number_format(((int)$row_month1['total_qty_count']/(int)$row_month0['total_qty_count0'])*100, 2)?>%)','Atthasit (<?=number_format(((int)$row_month2['total_qty_count']/(int)$row_month0['total_qty_count0'])*100, 2)?>%)'],
            datasets: [{
               
                    backgroundColor: ['rgb(51, 153, 255)','rgb(153, 51, 255)'],
                    borderColor: 'rgb(66, 254, 0)',
                    data:[<?
					
				
				 
				 
				
				echo $row_month1['total_qty_count'];
				?>,<?
				echo $row_month2['total_qty_count'];
				 
				
					?>]
               }]  
				
           
        };
    var chart = new Chart(ctx, {
        // The type of chart we want to create
        type: 'doughnut',
       data: data,
        // Configuration options go here
        options: {
			showAllTooltips: true,
			title: {
            display: true,
            text: 'IT Develop JAN - JUL <?=$yyear?>'
        }
			}
    });
	///// JOBS JAN-JUL
	
	///// JOBS YEAR
	var ctx = document.getElementById('myChart_itservice2').getContext('2d');
	var data ={
            <?
			//YEAR(create_date) = $yyear
			$select_month0 = "select count(id) as total_qty_count0 from View_tbitservice_list where  YEAR(create_date) = $yyear and problem_type <>'Develop' and job_status not in('Cancel','Hold')";
				$re_month0 = mssql_query($select_month0);
				 $row_month0 = mssql_fetch_array($re_month0);
				 
				 $select_month1 = "select count(id) as total_qty_count from View_tbitservice_list where  YEAR(create_date) = $yyear and  empno_close='59011' and problem_type <>'Develop' and job_status not in('Cancel','Hold')";
				 $re_month1 = mssql_query($select_month1);
				 $row_month1 = mssql_fetch_array($re_month1);
				 
				 $select_month2 = "select count(id) as total_qty_count from View_tbitservice_list where  YEAR(create_date) = $yyear and empno_close='61001' and problem_type <>'Develop' and job_status not in('Cancel','Hold')";
				$re_month2 = mssql_query($select_month2);
				 $row_month2 = mssql_fetch_array($re_month2);
				 
			?>
            labels: ['Thanatwat (<?=number_format(((int)$row_month1['total_qty_count']/(int)$row_month0['total_qty_count0'])*100, 2)?>%)','Atthasit (<?=number_format(((int)$row_month2['total_qty_count']/(int)$row_month0['total_qty_count0'])*100, 2)?>%)'],
            datasets: [{
               
                
                   
                    backgroundColor: ['rgb(51, 153, 255)','rgb(153, 51, 255)'],
                    borderColor: 'rgb(66, 254, 0)',
                    data:[<?
					
				
				echo $row_month1['total_qty_count'];
				?>,<?
				
				echo $row_month2['total_qty_count'];
					?>]
               }]  
				
           
        };
    var chart = new Chart(ctx, {
        // The type of chart we want to create
        type: 'doughnut',
       data: data,
        // Configuration options go here
        options: {
			showAllTooltips: true,
			title: {
            display: true,
            text: 'IT Support <?=$yyear?>'
        }
			}
    });
	
	var ctx = document.getElementById('myChart_develop2').getContext('2d');
	var data ={
            <?
			$select_month0 = "select count(id) as total_qty_count0 from tbitprogram_list where YEAR(create_date) = $yyear ";
				$re_month0 = mssql_query($select_month0);
				 $row_month0 = mssql_fetch_array($re_month0);
			$select_month1 = "select count(id) as total_qty_count from tbitprogram_list where  YEAR(create_date) = $yyear and   incharge='Thanatwat'";
				$re_month1 = mssql_query($select_month1);
				 $row_month1 = mssql_fetch_array($re_month1);
				 $select_month2 = "select count(id) as total_qty_count from tbitprogram_list where  YEAR(create_date) = $yyear  and incharge='Atthasit'";
				$re_month2 = mssql_query($select_month2);
				 $row_month2 = mssql_fetch_array($re_month2);
				 
				// echo number_format(((int)$row_month1['total_qty_count']/(int)$row_month0['total_qty_count0'])*100, 2);
				//echo number_format(((int)$row_month2['total_qty_count']/(int)$row_month0['total_qty_count0'])*100, 2);
			?>
            labels: ['Thanatwat (<?=number_format(((int)$row_month1['total_qty_count']/(int)$row_month0['total_qty_count0'])*100, 2)?>%)','Atthasit (<?=number_format(((int)$row_month2['total_qty_count']/(int)$row_month0['total_qty_count0'])*100, 2)?>%)'],
            datasets: [{
               
                    backgroundColor: ['rgb(51, 153, 255)','rgb(153, 51, 255)'],
                    borderColor: 'rgb(66, 254, 0)',
                    data:[<?
					
				
				 
				 
				
				echo $row_month1['total_qty_count'];
				?>,<?
				echo $row_month2['total_qty_count'];
				 
				
					?>]
               }]  
				
           
        };
    var chart = new Chart(ctx, {
        // The type of chart we want to create
        type: 'doughnut',
       data: data,
        // Configuration options go here
        options: {
			showAllTooltips: true,
			title: {
            display: true,
            text: 'IT Develop <?=$yyear?>'
        }
			}
    });
	///// JOBS YEAR
	
	
	var ctx = document.getElementById('myChart5').getContext('2d');
    var chart = new Chart(ctx, {
        // The type of chart we want to create
		
        type: 'bar',
		
        // The data for our dataset
        data: { labels: [<?
			for($i=2016;$i<=(int)$yyear;$i++){
					
					echo "'".$i."'";
					echo ", ";
				}
			?>],
            datasets: [
			   {
                    label: 'HQ',
                    backgroundColor: 'rgb(117, 0, 255)',
                    borderColor: 'rgb(66, 254, 0)',
                    data:[ <?
				
	$db="dinvb";
	$sql=mssql_connect($host,$username,$password) or die("Cannot connect");
	mssql_select_db($db);
				
				for($i=2016;$i<=(int)$yyear;$i++){
						
						$select_month = "select sum(purchase_price) as total_qty_count from tbasset where asset_group not in('Tools','Software','Warehouse Equipment') and location in('HQ WH','HQ Office') and YEAR(purchase_date) = $i";
				$re_month = mssql_query($select_month);
				 $row_month = mssql_fetch_array($re_month);
				echo $row_month['total_qty_count'];
				echo ", ";
						
					}
				
			
					
				
				
				
			?>]
               },
			   {
                    label: 'TSC',
                    backgroundColor: 'rgb(66, 181, 210)',
                    borderColor: 'rgb(66, 254, 0)',
                    data:[ <?
				
				for($i=2016;$i<=(int)$yyear;$i++){
						
						$select_month = "select sum(purchase_price) as total_qty_count from tbasset where asset_group not in('Tools','Software','Warehouse Equipment') and location in('TSC','TSC_VMI') and YEAR(purchase_date) = $i";
				$re_month = mssql_query($select_month);
				 $row_month = mssql_fetch_array($re_month);
				echo $row_month['total_qty_count'];
				echo ", ";
						
					}
				
			
					
				
				
				
			?>]
               },
			   {
                    label: 'OSW',
                    backgroundColor: 'rgb(246, 167, 102)',
                    borderColor: 'rgb(66, 254, 0)',
                    data:[ <?
				
				for($i=2016;$i<=(int)$yyear;$i++){
						
						$select_month = "select sum(purchase_price) as total_qty_count from tbasset where asset_group not in('Tools','Software','Warehouse Equipment') and location in('OSW') and YEAR(purchase_date) = $i";
				$re_month = mssql_query($select_month);
				 $row_month = mssql_fetch_array($re_month);
				echo $row_month['total_qty_count'];
				echo ", ";
						
					}
				
			
					
	$db="dhrdb";
	$sql=mssql_connect($host,$username,$password) or die("Cannot connect");
	mssql_select_db($db);
				
				
			?>]
               }
			   ]  
				
           
        },

        // Configuration options go here
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            },
			tooltips: {
                enabled: true
            },
            hover: {
                animationDuration: 0
            },
            animation: {
                duration: 1,
                onComplete: function () {
                    var chartInstance = this.chart,
                    ctx = chartInstance.ctx;

                    ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
                    ctx.textAlign = 'center';
                    ctx.textBaseline = 'bottom';

                    this.data.datasets.forEach(function (dataset, i) {
                        var meta = chartInstance.controller.getDatasetMeta(i);
                        //alert(i);
                        if(i==1){
                            ctx.fillStyle = '#000';
                        }
                        meta.data.forEach(function (bar, index) {
                            var data = dataset.data[index];                            
                            ctx.fillText(data, bar._model.x, bar._model.y - 5);
                        });
                    });
                }
            },
			title: {
            display: true,
            text: 'IT Asset Purchase 2016 - <?=$yyear?>'
        }
        }
    });
	
	var ctx = document.getElementById('myChart6').getContext('2d');
    var chart = new Chart(ctx, {
        // The type of chart we want to create
		
        type: 'bar',
		
        // The data for our dataset
        data: { labels: [<?
			for($i=2016;$i<=(int)$yyear;$i++){
					
					echo "'".$i."'";
					echo ", ";
				}
			?>],
            datasets: [
			   {
                    label: 'HQ',
                    backgroundColor: 'rgb(117, 0, 255)',
                    borderColor: 'rgb(66, 254, 0)',
                    data:[ <?
				
	$db="dinvb";
	$sql=mssql_connect($host,$username,$password) or die("Cannot connect");
	mssql_select_db($db);
				
				for($i=2016;$i<=(int)$yyear;$i++){
						
						$select_month = "select count(id) as total_qty_count from tbasset where asset_group not in('Tools','Software','Warehouse Equipment') and location in('HQ WH','HQ Office') and YEAR(purchase_date) = $i and asset_status='abnormal'";
				$re_month = mssql_query($select_month);
				 $row_month = mssql_fetch_array($re_month);
				echo $row_month['total_qty_count'];
				echo ", ";
						
					}
				
			
					
				
				
				
			?>]
               },
			   {
                    label: 'TSC',
                    backgroundColor: 'rgb(66, 181, 210)',
                    borderColor: 'rgb(66, 254, 0)',
                    data:[ <?
				
				for($i=2016;$i<=(int)$yyear;$i++){
						
						$select_month = "select count(id) as total_qty_count from tbasset where asset_group not in('Tools','Software','Warehouse Equipment') and location in('TSC','TSC_VMI') and YEAR(purchase_date) = $i and asset_status='abnormal'";
				$re_month = mssql_query($select_month);
				 $row_month = mssql_fetch_array($re_month);
				echo $row_month['total_qty_count'];
				echo ", ";
						
					}
				
			
					
				
				
				
			?>]
               },
			   {
                    label: 'OSW',
                    backgroundColor: 'rgb(246, 167, 102)',
                    borderColor: 'rgb(66, 254, 0)',
                    data:[ <?
				
				for($i=2016;$i<=(int)$yyear;$i++){
						
						$select_month = "select count(id) as total_qty_count from tbasset where asset_group not in('Tools','Software','Warehouse Equipment') and location in('OSW') and YEAR(purchase_date) = $i and asset_status='abnormal'";
				$re_month = mssql_query($select_month);
				 $row_month = mssql_fetch_array($re_month);
				echo $row_month['total_qty_count'];
				echo ", ";
						
					}
				
			
					
	$db="dhrdb";
	$sql=mssql_connect($host,$username,$password) or die("Cannot connect");
	mssql_select_db($db);
				
				
			?>]
               }
			   ]  
				
           
        },

        // Configuration options go here
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            },
			tooltips: {
                enabled: true
            },
            hover: {
                animationDuration: 0
            },
            animation: {
                duration: 1,
                onComplete: function () {
                    var chartInstance = this.chart,
                    ctx = chartInstance.ctx;

                    ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
                    ctx.textAlign = 'center';
                    ctx.textBaseline = 'bottom';

                    this.data.datasets.forEach(function (dataset, i) {
                        var meta = chartInstance.controller.getDatasetMeta(i);
                        //alert(i);
                        if(i==1){
                            ctx.fillStyle = '#000';
                        }
                        meta.data.forEach(function (bar, index) {
                            var data = dataset.data[index];                            
                            ctx.fillText(data, bar._model.x, bar._model.y - 5);
                        });
                    });
                }
            },
			title: {
            display: true,
            text: 'Damage Asset'
        }
        }
    });
	var ctx = document.getElementById('myChart7').getContext('2d');
    var chart = new Chart(ctx, {
        // The type of chart we want to create
		
        type: 'bar',
		
        // The data for our dataset
        data: { labels: [<?
			for($i=1;$i<=12;$i++){
					
					echo "'".$arr_month[$i]."'";
					echo ", ";
				}
			?>],
            datasets: [
			   {
                    label: 'Work Day',
                    backgroundColor: 'rgb(178, 255, 102)',
                    borderColor: 'rgb(66, 254, 0)',
                    data:[ <?
				
	
				
				for($i=1;$i<=12;$i++){
						
						$select_month = "SELECT   COUNT(id) AS total_qty_count FROM  tbot_parameter
WHERE        (work_type = 'Normal working') and MONTH(workdate)=$i AND (workyear = '$yyear') AND (site = 'HQ')";
				$re_month = mssql_query($select_month);
				 $row_month = mssql_fetch_array($re_month);
				echo $row_month['total_qty_count']*2;
				echo ", ";
						
					}
				
			
					
				
				
				
			?>]
               },
			   {
                    label: 'Leave',
                    backgroundColor: 'rgb(255, 51, 51)',
                    borderColor: 'rgb(66, 254, 0)',
                    data:[ <?
				
				for($i=1;$i<=12;$i++){
						
						$select_month = "SELECT   sum(leavetotal) AS total_qty_count FROM    tbleave_transaction
WHERE        (statusapprove = 'Approve') and leavetypeid in('L0001','L0002','L0003','L0004','L0005','L0006') and MONTH(leavestartdate)=$i AND YEAR(leavestartdate)=$yyear AND (empno in('59011','61001'))";
				$re_month = mssql_query($select_month);
				 $row_month = mssql_fetch_array($re_month);
				echo $row_month['total_qty_count'];
				echo ", ";
						
					}
				
			
					
				
				
				
			?>]
               }
			   ]  
				
           
        },

        // Configuration options go here
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            },
			tooltips: {
                enabled: true
            },
            hover: {
                animationDuration: 0
            },
            animation: {
                duration: 1,
                onComplete: function () {
                    var chartInstance = this.chart,
                    ctx = chartInstance.ctx;

                    ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
                    ctx.textAlign = 'center';
                    ctx.textBaseline = 'bottom';

                    this.data.datasets.forEach(function (dataset, i) {
                        var meta = chartInstance.controller.getDatasetMeta(i);
                        //alert(i);
                        if(i==1){
                            ctx.fillStyle = '#000';
                        }
                        meta.data.forEach(function (bar, index) {
                            var data = dataset.data[index];                            
                            ctx.fillText(data, bar._model.x, bar._model.y - 5);
                        });
                    });
                }
            },
			title: {
            display: true,
            text: 'Attendance <?=$yyear?>'
        }
        }
    });
	
	var ctx = document.getElementById('myChart3').getContext('2d');
	var data ={
            
            labels: ['Thanatwat'],
            datasets: [{
               
                
                   
                    backgroundColor: ['rgb(51, 153, 255)','rgb(153, 51, 255)'],
                    borderColor: 'rgb(66, 254, 0)',
                    data:[<?
					$select_month = "select count(id) as total_qty_count from View_tbitservice_list where  YEAR(create_date) = $yyear and MONTH(create_date) = $mmonth and empno_close='59011' and problem_type <>'Develop' and job_status not in('Cancel','Hold')";
				$re_month = mssql_query($select_month);
				 $row_month = mssql_fetch_array($re_month);
				echo $row_month['total_qty_count'];
					?>]
               }]  
				
           
        };
    var chart = new Chart(ctx, {
        // The type of chart we want to create
        type: 'doughnut',
       data: data,
        // Configuration options go here
        options: {
			showAllTooltips: true,
			title: {
            display: true,
            text: 'IT Support <?=$arr_month[$mmonth]?> <?=$yyear?>'
        }
			}
    });
	
	
	
	
	var ctx = document.getElementById('myChart8').getContext('2d');
	var data ={
            
            labels: ['Thanatwat'],
            datasets: [{
               
                
                   
                    backgroundColor: ['rgb(51, 153, 255)','rgb(153, 51, 255)'],
                    borderColor: 'rgb(66, 254, 0)',
                    data:[<?
					$select_month = "select count(id) as total_qty_count from tbitprogram_list where  YEAR(start_date) = $yyear and MONTH(start_date) = $mmonth and incharge='Thanatwat'";
				$re_month = mssql_query($select_month);
				 $row_month = mssql_fetch_array($re_month);
				echo $row_month['total_qty_count'];
					?>]
               }]  
				
           
        };
    var chart = new Chart(ctx, {
        // The type of chart we want to create
        type: 'doughnut',
       data: data,
        // Configuration options go here
        options: {
			showAllTooltips: true,
			title: {
            display: true,
            text: 'IT Develop <?=$arr_month[$mmonth]?> <?=$yyear?>'
        }
			}
    });
	
	var ctx = document.getElementById('myChart4').getContext('2d');
	var data ={
            
            labels: ['Develop','Software','Hardware','Network','Other'],
            datasets: [{
               
                
                   
                    backgroundColor: ['rgb(51, 153, 255)','rgb(153, 51, 255)','rgb(102, 255, 178)','rgb(255, 153, 51)','rgb(192, 192, 192)'],
                    borderColor: 'rgb(66, 254, 0)',
                    data:[<?
					$select_month = "select count(id) as total_qty_count from tbitservice_list where problem_type='Develop'  and YEAR(create_date) = $yyear and MONTH(create_date) = $mmonth";
				$re_month = mssql_query($select_month);
				 $row_month = mssql_fetch_array($re_month);
				echo $row_month['total_qty_count'];
					?>,<?
					$select_month = "select count(id) as total_qty_count from tbitservice_list where problem_type='Software'  and YEAR(create_date) = $yyear and MONTH(create_date) = $mmonth";
				$re_month = mssql_query($select_month);
				 $row_month = mssql_fetch_array($re_month);
				echo $row_month['total_qty_count'];
					?>,<?
					$select_month = "select count(id) as total_qty_count from tbitservice_list where problem_type='Hardware'  and YEAR(create_date) = $yyear and MONTH(create_date) = $mmonth";
				$re_month = mssql_query($select_month);
				 $row_month = mssql_fetch_array($re_month);
				echo $row_month['total_qty_count'];
					?>,<?
					$select_month = "select count(id) as total_qty_count from tbitservice_list where problem_type='Network'  and YEAR(create_date) = $yyear and MONTH(create_date) = $mmonth";
				$re_month = mssql_query($select_month);
				 $row_month = mssql_fetch_array($re_month);
				echo $row_month['total_qty_count'];
					?>,<?
					$select_month = "select count(id) as total_qty_count from tbitservice_list where problem_type='Other'  and YEAR(create_date) = $yyear and MONTH(create_date) = $mmonth";
				$re_month = mssql_query($select_month);
				 $row_month = mssql_fetch_array($re_month);
				echo $row_month['total_qty_count'];
					?>]
               }]  
				
           
        };
    var chart = new Chart(ctx, {
        // The type of chart we want to create
        type: 'doughnut',
       data: data,
        // Configuration options go here
        options: {
			showAllTooltips: true,
			title: {
            display: true,
            text: 'Jobs <?=$arr_month[$mmonth]?> <?=$yyear?>'
        }
			}
    });
	
	<?
	}
	?>
	
});
function save_message(){
    var job_id = $("#job_id").val();
    var message = $("#message").val();
    var job_status = $("#job_status").val();
    if(job_status==null){
        job_status="user";
    }
    if(message==""){
        alert("กรุณาใส่ข้อความก่อน save");
    }else{
        $.post("getajax_it_service.php",{
            status:"save_message",
            job_id : job_id,
            message :  message,
            job_status : job_status
        }).done(function(data){	
            location.reload();		
            
        });
    }
   
   // alert(message+job_status);
}
function save_approve(approve_status){
	var job_id = $("#job_id").val();
	 $.post("getajax_it_service.php",{
        status:"save_approve",
        job_id : job_id,
        approve_status :  approve_status
    }).done(function(data){	
        location.reload();		
        
    });
}
function export_excel(){
    var start_date = $("#start_date").val();
    var end_date = $("#end_date").val();
	var mmonth = $("#mmonth").val();
    var yyear = $("#yyear").val();
    window.open("popreport.php?status=it_service_list&start_date="+start_date+"&end_date="+end_date+"&mmonth="+mmonth+"&yyear="+yyear);

}

function create_task(){
	
		var job_id = $("#job_id").val();
		var project_name = $("#project_name").val();
		var detail = $("#detail").val();
	//	var start_date = $("#start_date").val();
	//	var due_date = $("#due_date").val();
		var incharge = $("#incharge").val();
		
	 $.post("getajax_it_service.php",{
        status:"create_task",
        job_id : job_id,
		project_name:project_name,
		detail:detail,
	
	   incharge:incharge
    }).done(function(data){	
        location.reload();		
        
    });
	}
function edit_problem_type(job_id){
	var problem_type = $("#problem_type").val();
		 $.post("getajax_it_service.php",{
        status:"edit_problem_type",
        job_id : job_id,
		problem_type:problem_type
		
    }).done(function(data){	
        location.reload();		
        
    });
	}
function edit_piority_range(job_id){
	var piority_range = $("#piority_range").val();
		 $.post("getajax_it_service.php",{
        status:"edit_piority_range",
        job_id : job_id,
		piority_range:piority_range
		
    }).done(function(data){	
      //  location.reload();		
        
    });
}
function edit_level_range(job_id){
	var level_range = $("#level_range").val();
		 $.post("getajax_it_service.php",{
        status:"edit_level_range",
        job_id : job_id,
		level_range:level_range
		
    }).done(function(data){	
      //  location.reload();		
        
    });
}
function edit_job_type(job_id){
	var job_type = $("#job_type").val();
		 $.post("getajax_it_service.php",{
        status:"edit_job_type",
        job_id : job_id,
		job_type:job_type
		
    }).done(function(data){	
      //  location.reload();		
        
    });
}
function edit_due_date(job_id){
	var due_date0 = $("#due_date0").val();
	var remark = $("#remark").val();
	//alert(remark);
	if(remark!=''){
		 $.post("getajax_it_service.php",{
        status:"edit_due_date",
        job_id : job_id,
		remark:remark,
		due_date:due_date0
		
    }).done(function(data){	
      //  location.reload();		
        alert('Save Complete '+data);
    });
	}
}

function edit_asset_no(job_id){
	var asset_no = $("#asset_no").val();
	var asset_no2 = $("#asset_no2").val();
	var asset_no3 = $("#asset_no3").val();
	var asset_no4 = $("#asset_no4").val();
	var asset_no5 = $("#asset_no5").val();
	
	
		 $.post("getajax_it_service.php",{
        status:"edit_asset_no",
        job_id : job_id,
		asset_no:asset_no,
		asset_no2:asset_no2,
		asset_no3:asset_no3,
		asset_no4:asset_no4,
		asset_no5:asset_no5
    }).done(function(data){	
        alert('Save Complete '+data);
    });
	
	}






function update_programlist(id){
	var incharge = $("#incharge"+id).val();
	var start_date = $("#start_date"+id).val();
	var due_date = $("#due_date"+id).val();
	var job_status = $("#job_status"+id).val();
	$.post("getajax_it_service.php",{
        status:"update_programlist",
        id : id,
		incharge:incharge,
		start_date:start_date,
		due_date:due_date,
		job_status:job_status
		
		
    }).done(function(data){	
        location.reload();		
        
    });
	
		
	}
	
	
	
	
</script>
</head>

<body class=" ">


    <header class="navbar navbar-inverse navbar-fixed-top" role="banner">
        <a id="leftmenu-trigger" class="tooltips" data-toggle="tooltip" data-placement="right" title="Toggle Sidebar"></a>
       

        <div class="navbar-header pull-left">
           
        </div>

        <ul class="nav navbar-nav pull-right toolbar">
        	
        	
        	
         
            
		</ul>
    </header>

    <div id="page-container">
        <!-- BEGIN SIDEBAR -->
        <nav id="page-leftbar" role="navigation">
                <!-- BEGIN SIDEBAR MENU -->
             <? include("menu.php");  ?>
            <!-- END SIDEBAR MENU -->
        </nav>

        <!-- BEGIN RIGHTBAR -->
        <div id="page-rightbar">

            
        </div>
        <!-- END RIGHTBAR -->
<div id="page-content">
	<div id='wrap'>
		<div id="page-heading">
			

		
			
		</div>
		<div class="container">
        <?
        if($status==''){
		?>
		
        
        
        <?
		}
		?>
         
<?php if($job_id=="") { ?>
			
			<div class="row">
            <div class="col-md-12">
            Month <select id="mmonth">
            <?
            for($i=1;$i<=12;$i++){
				?><option value="<?=$i?>" <?
                if($mmonth==$i){
					?> selected<?
					}
				?>><?=$arr_month[$i]?></option><?
				}
			?>
            </select> Year <select id="yyear"><?
            for($i=2019;$i<=2024;$i++){
				?><option value="<?=$i?>" <?
                if($yyear==$i){
					?> selected<?
					}
				?>><?=$i?></option><?
				}
			?></select>&nbsp;<input type="button" value="Submit" onClick="location='it_service_list.php?mmonth='+document.getElementById('mmonth').value+'&yyear='+document.getElementById('yyear').value+''">&nbsp;<a href="Gantt_chart/index.php?mmonth=<?=$mmonth?>&yyear=<?=$yyear?>" target="_blank" >[Gantt chart]</a>
            </div>
				<div class="col-md-12">
					<div class="panel panel-primary">
						<div class="panel-heading">IT Service List</div>
						<div class="panel-body">

                        <table id="example" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th width="62">JOB ID</th>
                                <th width='94'>CREATE</th>
                                <th width='107'>RESPONSE</th>
                                <th width='65'>Piority</th>
                                <th width='55'>Level</th>
                                <th width='104'>DUE</th>
                                <th width='108'>CLOSE</th>
                                <th width='69'> STATUS</th>
                                <th width="95">TOPIC</th>
                                <th width="66">TYPE</th>
                                <th width="74"> NAME</th>
                              
                            </tr>
                        </thead>
                        <tbody>

                        <?php 
                        $empno = $_SESSION['admin_userid'];
                        if(access_it_service()){ //function is at library.php
                            $sql = "select 
							convert(varchar, create_date, 103)as create_date_date,
                            convert(varchar, create_date, 108)as create_date_time,
							convert(varchar, solution_date, 103)as solution_date_date,
                            convert(varchar, solution_date, 108)as solution_date_time,
							convert(varchar, due_date, 103)as due_datedate,
							 piority_range, level_range,
                            empno,job_id,problem_type,problem_topic,job_status,approve_status
							

                            from tbitservice_list where MONTH(create_date)='$mmonth' and YEAR(create_date)='$yyear'  or (job_status in ('In progress','New','Hold','Cancel')) ";
                        }else{
                            $sql = "select convert(varchar, create_date, 103)as create_date_date,
                            convert(varchar, create_date, 108)as create_date_time,
							convert(varchar, solution_date, 103)as solution_date_date,
                            convert(varchar, solution_date, 108)as solution_date_time,
							convert(varchar, due_date, 103)as due_datedate,
							 piority_range, level_range,
                            empno,job_id,problem_type,problem_topic,job_status,approve_status 
                            from tbitservice_list where empno in(select empno from tbemployee where site = '".$_SESSION['site']."') and MONTH(create_date)='$mmonth' and YEAR(create_date)='$yyear' or (job_status in ('In progress','New','Hold','Cancel'))  "; 
                        }
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
                            }else if($job_status=="Hold"){
                                $job_status_show = "<span class='label label-default'>$job_status</span> | <a href='$filename?job_id=".$row['job_id']."' target='_blank'>Print</a>";
                            }else if($job_status=="Cancel"){
                                $job_status_show = "<span class='label label-default'>$job_status</span> | <a href='$filename?job_id=".$row['job_id']."' target='_blank'>Print</a>";
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
                                <td><?=$piority_range?></td>
                                <td><?=$level_range?></td>
                                <td><?=$due_datedate?></td>
                                <td><?=$close_date?></td>
                                <td><center><?=$job_status_show?></center></td>
                                <td><?=$problem_topic?></td>
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
                       <!-- <tfoot>
                            <tr>
                                <th>JOB ID</th>
                                <th>CREATE DATE</th>
                                <th>JOB STATUS</th>
                                <th>TOPIC</th>
                                <th>TYPE</th>
                                <th>FULL NAME</th>
                              
                            </tr>
                        </tfoot>-->
                    </table>
                    
					     </div>
					</div>
				</div>
			</div>
            
            <div class="row">
				<div class="col-md-12">
					<div class="panel panel-primary">
						<div class="panel-heading">IT Develop Task&nbsp;<a href="Gantt_chart/index.php?mmonth=<?=$mmonth?>&yyear=<?=$yyear?>" target="_blank" style="color:#FFC">[Gantt chart]</a></div>
						<div class="panel-body">

                        <table id="tbdevelop" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                             <th width="77" align="center">JOB ID</th>
                              <th width="79" align="center">TASK ID</th>
                                <th width="88" align="center">Project</th>
                              <th width='344'>Detail</th>
                                <th width='73'>Status</th>
                                <th width='93'>Start Date</th>
                                <th width='88'>Due Date</th>
                                <th width='83'>Incharge</th>
                              	
                          </tr>
                        </thead>
                        <tbody>

                        <?php 
                        //$empno = $_SESSION['admin_userid'];
                        //if(access_it_service()){ //function is at library.php
//                            $sql = "select 
//							convert(varchar, create_date, 103)as create_date_date,
//                            convert(varchar, create_date, 108)as create_date_time,
//							convert(varchar, solution_date, 103)as solution_date_date,
//                            convert(varchar, solution_date, 108)as solution_date_time,
//                            empno,job_id,problem_type,problem_topic,job_status,approve_status 
//                            from tbitservice_list ";
//                        }else{
//                            $sql = "select convert(varchar, create_date, 103)as create_date_date,
//                            convert(varchar, create_date, 108)as create_date_time,
//							convert(varchar, solution_date, 103)as solution_date_date,
//                            convert(varchar, solution_date, 108)as solution_date_time,
//                            empno,job_id,problem_type,problem_topic,job_status,approve_status 
//                            from tbitservice_list where empno in(select empno from tbemployee where site = '".$_SESSION['site']."') "; 
//                        }
//where MONTH(start_date)='$mmonth' and YEAR(start_date)='$yyear'
						 $sql = "select 
					  CONVERT(varchar, start_date, 101) as start_datedate,
					  CONVERT(varchar, due_date, 101) as due_datedate,* 
					  from tbitprogram_list  where MONTH(start_date)='$mmonth' and YEAR(start_date)='$yyear'  or (job_status in ('In progress','New')) order by start_date asc";
                        $res = mssql_query($sql);
                        while ($row = mssql_fetch_array($res)) {
                            
							
                            ?>

                            <tr>
                             <td align="center"><a href="it_service_list.php?job_id=<?=$row['job_id']?>&status=view" target="_blank"><?=$row['job_id']?></a></td>
                              <td align="center"><?=$row['develop_id']?></td>
                                <td align="center"><?=$row['project_name']?></td>
                              <td><?=lang_thai_from_database($row['detail'])?></td>
                                <td><?=$row['job_status']?></td>
                                <td><?=$row['start_datedate']?></td>
                                <td><?=$row['due_datedate']?></td>
                                <td><?=$row['incharge']?></td>
    
                            </tr>

                        <?php

                        }
                         
                        ?>  
                           
                            
                        </tbody>
                       <!-- <tfoot>
                            <tr>
                                <th>JOB ID</th>
                                <th>CREATE DATE</th>
                                <th>JOB STATUS</th>
                                <th>TOPIC</th>
                                <th>TYPE</th>
                                <th>FULL NAME</th>
                              
                            </tr>
                        </tfoot>-->
                    </table>
					     </div>
					</div>
				</div>
			</div>
            
            
        <div class="col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12 clearfix">
                                    
                                    <div class="btn-group pull-right">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <canvas id="myChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
        </div>
        <div class="col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12 clearfix">
                                    
                                    <div class="btn-group pull-right">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <canvas id="myChart2"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
        </div>
        <div class="col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12 clearfix">
                                    
                                    <div class="btn-group pull-right">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <canvas id="myChart4"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
        </div>
        <div class="col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12 clearfix">
                                    
                                    <div class="btn-group pull-right">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <canvas id="myChart3"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
        </div>
        
        <div class="col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12 clearfix">
                                    
                                    <div class="btn-group pull-right">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <canvas id="myChart8"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
        </div>
        
        <div class="col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12 clearfix">
                                    
                                    <div class="btn-group pull-right">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <canvas id="myChart7"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
        </div>
        
        <div class="col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12 clearfix">
                                    
                                    <div class="btn-group pull-right">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <canvas id="myChart5"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
        </div>
        <div class="col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12 clearfix">
                                    
                                    <div class="btn-group pull-right">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <canvas id="myChart6"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
        </div>
         <div class="col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12 clearfix">
                                    
                                    <div class="btn-group pull-right">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <canvas id="myChart_itservice"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
        </div>
        <div class="col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12 clearfix">
                                    
                                    <div class="btn-group pull-right">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <canvas id="myChart_develop"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
        </div>
        
        
        
        <div class="col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12 clearfix">
                                    
                                    <div class="btn-group pull-right">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <canvas id="myChart_itservice2"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
        </div>
        <div class="col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12 clearfix">
                                    
                                    <div class="btn-group pull-right">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <canvas id="myChart_develop2"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
        </div>
        
        <div class="col-md-12">
                    <div class="panel panel-primary">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12 clearfix">
                                    
                                    <div class="btn-group pull-right">
                                    </div>
                                </div>
                                <div class="col-md-12">
                    <table  class="table table-striped table-bordered" style="width:100%">
                        
                        <tbody>
						
                        <?php 
						$db="dinvb";
						$sql=mssql_connect($host,$username,$password) or die("Cannot connect");
						mssql_select_db($db);
                   
					  	$sql = "select  * from tbasset_group where id_order_by is not null order by id_order_by asc";
                        $res = mssql_query($sql);
                        while ($row = mssql_fetch_array($res)) {
							
							
							?>
							<tr>
                                <td bgcolor="#E4E4E4"><strong><?=$row['asset_group']?></strong></td>
                                <td width='119' bgcolor="#E4E4E4"><strong>HQ Office</strong></td>
                              <td width='93' bgcolor="#E4E4E4"><strong>HQ WH</strong></td>
                              <td width='97' bgcolor="#E4E4E4"><strong>TSC</strong></td>
                                <td width='130' bgcolor="#E4E4E4"><strong>TSC VMI</strong></td>
                                 <td width='89' bgcolor="#E4E4E4"><strong>OSW</strong></td>
                                  <td width='92' bgcolor="#E4E4E4"><strong>Total</strong></td>
                            </tr>
							<?
							 $sql2 = "select   distinct device_type from  tbasset where asset_group='".$row['asset_group']."'";
                        $res2 = mssql_query($sql2);
                        while ($row2 = mssql_fetch_array($res2)) {
					 
					 
					 $total = 0;
					
							
								?>
					
                            
                            
					 			<tr>
                                <td width="237" ><?=$row2['device_type']?></td>
                              
                                
                              <td><?
								$sqla = "select  count(asset_no) as total from tbasset where location='HQ Office' and asset_group='".$row['asset_group']."' and device_type='".$row2['device_type']."' and asset_status not in('abnormal','disappear') ";
                    $resa = mssql_query($sqla);
                    $rowa = mssql_fetch_array($resa);
					echo $rowa['total'];
					 $total+=$rowa['total'];;
					
								?></td>
                                <td><?
								$sqla = "select  count(asset_no) as total from tbasset where location='HQ WH' and asset_group='".$row['asset_group']."' and device_type='".$row2['device_type']."' and asset_status not in('abnormal','disappear') ";
                    $resa = mssql_query($sqla);
                    $rowa = mssql_fetch_array($resa);
					echo $rowa['total'];
					 $total +=$rowa['total'];
					
								?></td>
                                <td><?
								$sqla = "select  count(asset_no) as total from tbasset where location='TSC' and asset_group='".$row['asset_group']."' and device_type='".$row2['device_type']."' and asset_status not in('abnormal','disappear') ";
                    $resa = mssql_query($sqla);
                    $rowa = mssql_fetch_array($resa);
					echo $rowa['total'];
					 $total += $rowa['total'];
					
								?></td>
                                <td><?
								$sqla = "select  count(asset_no) as total from tbasset where location='TSC_VMI' and asset_group='".$row['asset_group']."' and device_type='".$row2['device_type']."' and asset_status not in('abnormal','disappear') ";
                    $resa = mssql_query($sqla);
                    $rowa = mssql_fetch_array($resa);
					echo $rowa['total'];
					 $total +=$rowa['total'];
					
								?></td>
                                 <td><?
								$sqla = "select  count(asset_no) as total from tbasset where location='OSW' and asset_group='".$row['asset_group']."' and device_type='".$row2['device_type']."' and asset_status not in('abnormal','disappear') ";
                    $resa = mssql_query($sqla);
                    $rowa = mssql_fetch_array($resa);
					echo $rowa['total'];
					 $total += $rowa['total'];
								?></td>
                               <td><?
                               	echo $total;
							   ?></td>
                            </tr>
					
					
							
                            

                        <?php

                        
						}
						
						}
						
						$db="dhrdb";
						$sql=mssql_connect($host,$username,$password) or die("Cannot connect");
						mssql_select_db($db);
                         
                        ?>  
                           
                            
                        </tbody>
                       
                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
        </div>
             
        <div class="col-md-12">
             <iframe src=" https://stats.uptimerobot.com/vlQVnhYNj"  width="100%" height="400"></iframe>
             
       </div>
       
      
     
       
        <?php  if(access_it_service()){ ?>
           <div class="row">
				<div class="col-md-12">
					<div class="panel panel-primary">
						<div class="panel-heading">IT Service Export</div>
						<div class="panel-body">

                            <div class="form-horizontal" >
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="start_date">Start Date :</label>
                                    <div class="col-sm-3">
                                        <input type="text" class='form-control' id='start_date' name='start_date' autocomplete='off'>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="end_date">End Date :</label>
                                    <div class="col-sm-3">
                                        <input type="text" class='form-control' id='end_date' name='end_date' autocomplete='off'>
                                    </div>
                                </div>
                                <div class="form-group"> 
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <button  class="btn btn-success" onclick='export_excel()'>Export</button>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
       

<?php } ?>
			
<?php if($status =="view"){ ?>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">JOB ID #<?=$job_id?><input type="hidden" id="job_id" value="<?=$job_id?>"></div>
                <div class="panel-body">
                    <?php 
                    $sql ="select 
					
					convert(varchar, create_date, 103)as create_date_date,
                    convert(varchar, create_date, 108)as create_date_time,
					convert(varchar, due_date, 103)as due_datedate,
					convert(varchar, due_date, 101)as due_datedate2,
					
					* 
					
                     from tbitservice_list where job_id='$job_id'";
                    $res = mssql_query($sql);
                    $row = mssql_fetch_array($res);
                    $job_id = $row['job_id'];
                    $empno = $row['empno'];
                    $full_name = get_full_name($empno);
                    $problem_type = $row['problem_type'];
                    $problem_detail = lang_thai_from_database($row['problem_detail']);
					$job_type = $row['job_type'];
                    $job_status = $row['job_status'];
                    $problem_topic = lang_thai_from_database($row['problem_topic']);
                    $create_date = $row['create_date_date']." ".$row['create_date_time'];
					$approve_status = $row['approve_status'];
					$approve_empno = $row['approve_empno'];
					$approve_full_name = get_full_name($approve_empno);
                    //$problem_file = $row['problem_file'];
					$due_date= $row['due_datedate'];
					$due_date2= $row['due_datedate2'];
					$piority_range= $row['piority_range'];
					$level_range= $row['level_range'];
					$due_date= $row['due_datedate'];
					$asset_no = $row['asset_no'];
					
					$asset_no2 = $row['asset_no2'];
					$asset_no3 = $row['asset_no3'];
					$asset_no4 = $row['asset_no4'];
					$asset_no5 = $row['asset_no5'];
					
                    $sql_file = "select * from tbitservice_file where job_id='$job_id'";
                    $res_file = mssql_query($sql_file);
                    $num_file = mssql_num_rows($res_file);
					
					
                    if($num_file > 0){
                        while($row_file = mssql_fetch_array($res_file)){
                            $file_name = $row_file['file_name'];
                            $problem_file_show .= "<a href='service_pic/$file_name' target='$file_name'>$file_name</a><br>";
                        }

                    }

                    /*if($problem_file != " "){
                        $problem_file_show = "<a href='service_pic/$problem_file' target='$job_id'><i class='glyphicon glyphicon-file'></i></a>";

                    }else{
                        $problem_file_show = "";
                    }*/
                    if($job_status=="New"){
                        $job_status_show = "<span class='label label-danger'>$job_status</span>";
                    }else if($job_status=="In progress"){
                        $job_status_show = "<span class='label label-warning'>$job_status</span>";
                    }else if($job_status=="Close"){
                        $job_status_show = "<span class='label label-success'>$job_status</span>";
                    }
					 if($job_status=="New" && empty($approve_status)){
						  $job_status_show = "<span class='label label-default'>wait approve</span>";
						 }
                    
                    ?>
                    <table cellpadding="10" cellspacing="10" width="100%">
                        <tr>
                            <td align="right"><strong>สถานะ : </strong></td>
                            <td><?=$job_status_show?></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td align="right"><strong>สถานะ Approve: </strong></td>
                            <td><?
                            if(empty($approve_status)){
								$selectm = "select emp_control from tbleave_control where emp_control='".$_SESSION["admin_userid"]."' and emp_under='$empno'";
												$rem = mssql_query($selectm);
												$numm = mssql_num_rows($rem);
												if($numm>0){
								
								?><input type="button" value="Approve" onClick="save_approve('approved');">&nbsp;&nbsp;<input type="button" value="Reject" onClick="save_approve('rejected');"><?
								
												}
								}else{
									echo $approve_status;
									echo " ($approve_full_name)";
									}
							?></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td align="right"><strong>ชื่อผู้แจ้ง :</strong></td>
                            <td><?=$full_name?></td>
                            <td align="right"><strong>วันที่ : </strong></td>
                            <td><?=$create_date?></td>
                        </tr>
                        <tr>
                            <td align="right"><strong>ประเภท : </strong></td>
                            <td><select id="problem_type" onChange="edit_problem_type('<?=$job_id?>');">
                             				<option <?
                                            if($problem_type=='Hardware'){
												?> selected<?
												}
											?> value="Hardware">Hardware</option>
                                            <option <?
                                            if($problem_type=='Software'){
												?> selected<?
												}
											?> value="Software">Software</option>
                                            <option <?
                                            if($problem_type=='Network'){
												?> selected<?
												}
											?> value="Network">Network</option>
                                             <option <?
                                            if($problem_type=='Develop'){
												?> selected<?
												}
											?> value="Develop">Develop</option>
                                            <option <?
                                            if($problem_type=='Other'){
												?> selected<?
												}
											?> value="Other">Other</option>
                            </select></td>
                            <td align="right"><strong>ไฟล์แนบ : </strong></td>
                            <td><?=$problem_file_show?></td>
                        </tr>
                        <tr>
                            <td align="right"><strong>หัวข้อ : </strong></td>
                            <td><?=$problem_topic?></td>
                            <td align="right"><strong>Piority</strong></td>
                            <td><?
                            if(access_it_service()){
							?><select id="piority_range" onChange="edit_piority_range('<?=$job_id?>');">
                            <option value="">Select</option>
                             				<option <?
                                            if($piority_range=='Option'){
												?> selected<?
												}
											?> value="Option">Option</option>
                                            <option <?
                                            if($piority_range=='Mid'){
												?> selected<?
												}
											?> value="Mid">Mid</option>
                                            <option <?
                                            if($piority_range=='High'){
												?> selected<?
												}
											?> value="High">High</option>
                                            
                            </select><?
							}else{
								echo $piority_range;
								}
							?></td>
                        </tr>
                        <tr>
                            <td align="right"><strong>Level : </strong></td>
                            <td><?
                            if(access_it_service()){
								?><select id="level_range" onChange="edit_level_range('<?=$job_id?>');">
                                <option value="">Select</option>
                             				<option <?
                                            if($level_range=='Easy'){
												?> selected<?
												}
											?> value="Easy">Easy</option>
                                            <option <?
                                            if($level_range=='Normal'){
												?> selected<?
												}
											?> value="Normal">Normal</option>
                                            <option <?
                                            if($level_range=='Hard'){
												?> selected<?
												}
											?> value="Hard">Hard</option>
                                            
                            </select><?
									}else{
								echo $level_range;
								}
							?></td>
                            <td align="right"><strong>Due Date : </strong></td>
                            <td><?
                             if(access_it_service()){
								 ?><input type="text" id="due_date0" class="due_date0" value="<?=$due_date2?>"><?
								 	}else{
								 echo $due_date;
								 }
							?></td>
                        </tr>
                        <tr>
                           <td align="right"><strong>Type : </strong></td>
                            <td><?
                            if(access_it_service()){
								?><select id="job_type" onChange="edit_job_type('<?=$job_id?>');">
                                <option value="">Select</option>
                             				<option <?
                                            if($job_type=='Standard'){
												?> selected<?
												}
											?> value="Standard">Standard</option>
                                            <option <?
                                            if($job_type=='Improvement'){
												?> selected<?
												}
											?> value="Improvement">Improvement</option>
                                          
                                            
                            </select><?
									}else{
								echo $job_type;
								}
							?></td>
                            <td align="right"><strong>Remark : </strong></td>
                            <td><?
                             if(access_it_service()){
								 ?><input type="text" id="remark"><input type="button" value="Change Due Date" onClick="edit_due_date('<?=$job_id?>');"><?
								 	}
							?></td>
                        </tr>
                        
                        <tr>
                           <td align="right"><strong>Asset No 1 : </strong></td>
                            <td><input type="text" id="asset_no" value="<?=$asset_no?>" onChange="edit_asset_no('<?=$job_id?>');"></td>
                            <td align="right"></td>
                            <td></td>
                        </tr>
                        
                         <tr>
                           <td align="right"><strong>Asset No 2 : </strong></td>
                            <td><input type="text" id="asset_no2" value="<?=$asset_no2?>" onChange="edit_asset_no('<?=$job_id?>');"></td>
                            <td align="right"></td>
                            <td></td>
                        </tr>
                        
                         <tr>
                           <td align="right"><strong>Asset No 3 : </strong></td>
                            <td><input type="text" id="asset_no3" value="<?=$asset_no3?>" onChange="edit_asset_no('<?=$job_id?>');"></td>
                            <td align="right"></td>
                            <td></td>
                        </tr>
                         <tr>
                           <td align="right"><strong>Asset No 4 : </strong></td>
                            <td><input type="text" id="asset_no4" value="<?=$asset_no4?>" onChange="edit_asset_no('<?=$job_id?>');"></td>
                            <td align="right"></td>
                            <td></td>
                        </tr>
                        
                         <tr>
                           <td align="right"><strong>Asset No 5 : </strong></td>
                            <td><input type="text" id="asset_no5" value="<?=$asset_no5?>" onChange="edit_asset_no('<?=$job_id?>');"></td>
                            <td align="right"></td>
                            <td></td>
                        </tr>                        
                        
                    </table>
                    <br>
                    <div class="panel panel-info ">
                        <div class="panel-heading"><?=$create_date?></div>
                        <div class="panel-body">
                            <?=$problem_detail?>
                        </div>
                    </div>
                    <?php 
                    $sql_chat = "select convert(varchar, create_date, 103)as create_date_date,
                    convert(varchar, create_date, 108)as create_date_time,*
                     from tbitservice_chat where job_id='$job_id'";
                    $res_chat = mssql_query($sql_chat);
                    $num_chat = mssql_num_rows($res_chat);
                    if($num_chat>0){
                        while($row_chat =mssql_fetch_array($res_chat)){
                            $empno_chat = $row_chat['empno'];
                            $message = lang_thai_from_database($row_chat['message']);
                            $create_date_chat = $row_chat['create_date_date']." ".$row_chat['create_date_time'];
                            if($empno_chat == "61001" || $empno_chat=="59011"){
                                $panel_color="success";
                            }else{
                                $panel_color="info";
                            }
                            ?>
                            <div class="panel panel-<?=$panel_color?> ">
                                <div class="panel-heading"><?=$create_date_chat?></div>
                                <div class="panel-body">
                                    <?=$message?>
                                </div>
                            </div>   
                            <?php
                        }
                    }
                    
                    ?>
            <?php 
             if($job_status != "Close"){
                $empno_user_id = $_SESSION["admin_userid"];
                if($empno==$empno_user_id || access_it_service()){
               ?>  <b>message :</b>
                    <input type="hidden" id="job_id" name="job_id" value="<?=$job_id?>">
                    <div class='row'>
                        <div class='col-sm-12'>
                            <textarea name="message" id="message" cols="30" rows="10" class="form-control" autofocus></textarea>
                        </div>
                    </div>
                        <br>
               
                
                    <div class='row'>
                        <div class='col-sm-12'>
                            <div class="col-sm-10"> 
                            <? 
                            if(access_it_service()){
                            $selected_new = $job_status=="New" ? "selected" : "";
                            $selected_progress = $job_status=="In progress" ? "selected" : "";
                            $selected_hold = $job_status=="Hold" ? "selected" : ""; 
							$selected_cancel = $job_status=="Cancel" ? "selected" : ""; 
							$selected_close = $job_status=="Close" ? "selected" : "";   
                            ?>
                                
                                <div class="pull-right">
                                    <select name="job_status" id="job_status" class="form-control"> 
                                        <option value="New" <?=$selected_new?>>New</option>
                                        <option value="In progress" <?=$selected_progress?>>In progress</option>
                                         <option value="Hold" <?=$selected_hold?>>Hold</option>
                                         <option value="Cancel" <?=$selected_cancel?>>Cancel</option>
                                        <option value="Close" <?=$selected_close?>>Close</option>
                                    </select>
                                </div>
                                 
                                
                             <? } ?>
                            </div> 
                            <div class="col-sm-1"> 
                                <div class="pull-right">
                                    <button id="btn_svae" name="btn_save" class="btn btn-success" onclick="save_message()">Save</button>
                                </div>
                            </div>  

                        </div>
                        
                          

                  </div>

                    </div>
                    <?php }
             } ?>
             <div class="row">
				<div class='col-sm-12'>
                            
                            <? 
                            if(access_it_service()){
									?>
                                    <BR>
									<table width="80%" border="1" cellspacing="0" cellpadding="0">
                                     <tr>
    <td height="25" align="center" bgcolor="#CCCCCC"><strong>Project
    </strong></td>
    <td align="center" bgcolor="#CCCCCC"><strong>Detail</strong></td>
    <td align="center" bgcolor="#CCCCCC"><strong>Inchage</strong></td>
    <td align="center" bgcolor="#CCCCCC"><strong>Add</strong></td>
  </tr>
  <tr>
    <td height="25" align="center"><input type="hidden" id="job_id" value="<?=$job_id?>"><select id="project_name">
    <option value="">Select</option>
    <?
    	$select = "select * from    tbitproject order by project_name asc";
		$re = mssql_query($select);
		 while($row = mssql_fetch_array($re)){
			?><option value="<?=$row['project_name']?>"><?=$row['project_name']?></option><?
		}
	?>
    </select></td>
    <td align="center"><input type="text" id="detail" size="60"></td>
    <td align="center"><select id="incharge">
      <option value="">Select</option>
      <option value="Thanatwat">Thanatwat</option>
      <option value="Atthasit">Atthasit</option>
    </select></td>
    <td align="center"><input type="button" value="Add Task" onClick="create_task();"></td>
  </tr>
</table>
<BR>

<table id="tbprogram" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th width="137" align="center">Project</th>
                              <th width='201'>Detail</th>
                                <th width='201'>Status</th>
                                <th width='146'>Start Date</th>
                                <th width='164'>Due Date</th>
                                <th width='114'>Incharge</th>
                              	<th width='114'>Update</th>
                          </tr>
                        </thead>
                        <tbody>

                        <?php 
						
					  $sql = "select 
					  CONVERT(varchar, start_date, 101) as start_datedate,
					  CONVERT(varchar, due_date, 101) as due_datedate,* 
					  from tbitprogram_list where job_id='$job_id' order by create_date asc";
                        
                        $res = mssql_query($sql);
                        while ($row = mssql_fetch_array($res)) {
                            
							
							
							
                            ?>

                            <tr>
                                <td align="center"><?=$row['project_name']?></td>
                              <td><?=lang_thai_from_database($row['detail'])?></td>
                                <td><select id="job_status<?=$row['id']?>">
      <option <?
      	if($row['job_status']=='New'){
			?> selected<?
			}
	  ?> value="New">New</option>
      <option <?
      	if($row['job_status']=='Skipped'){
			?> selected<?
			}
	  ?> value="Skipped">Skipped</option>
      <option <?
      	if($row['job_status']=='In Progress'){
			?> selected<?
			}
	  ?> value="In Progress">In Progress</option>
      <option <?
      	if($row['job_status']=='Close'){
			?> selected<?
			}
	  ?> value="Close">Close</option>
    </select></td>
                                <td><input type="text" id="start_date<?=$row['id']?>" class="start_date" value="<?=$row['start_datedate']?>"></td>
                                <td><input type="text" id="due_date<?=$row['id']?>" class="due_date" value="<?=$row['due_datedate']?>"></td>
                                <td><select id="incharge<?=$row['id']?>">
      <option value="">Select</option>
      <option <?
      	if($row['incharge']=='Thanatwat'){
			?> selected<?
			}
	  ?> value="Thanatwat">Thanatwat</option>
      <option <?
      	if($row['incharge']=='Atthasit'){
			?> selected<?
			}
	  ?>  value="Atthasit">Atthasit</option>
    </select></td>
    <td><input type="button" value="Update" onClick="update_programlist('<?=$row['id']?>');"></td>
                            </tr>

                        <?php

                        }
						
						
                         
                        ?>  
                           
                            
                        </tbody>
                       
                    </table>

									<?
								} ?>
                           
                            
                            </div>
                </div>
               </div>
            </div>
        </div>
    </div>

<?php } ?>


		</div> <!-- container -->
	</div> <!--wrap -->
</div> <!-- page-content -->

    <footer role="contentinfo">
        <div class="clearfix">
            <ul class="list-unstyled list-inline">
                <li>I-Wis</li>
                <button class="pull-right btn btn-inverse-alt btn-xs hidden-print" id="back-to-top"><i class="fa fa-arrow-up"></i></button>
            </ul>
        </div>
    </footer>

</div> <!-- page-container -->

<!--
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>

<script>!window.jQuery && document.write(unescape('%3Cscript src="assets/js/jquery-1.10.2.min.js"%3E%3C/script%3E'))</script>
<script type="text/javascript">!window.jQuery.ui && document.write(unescape('%3Cscript src="assets/js/jqueryui-1.10.3.min.js'))</script>
-->

<script type='text/javascript' src='assets/js/jquery-1.10.2.min.js'></script> 
<script type='text/javascript' src='assets/js/jqueryui-1.10.3.min.js'></script> 
<script type='text/javascript' src='assets/js/bootstrap.min.js'></script> 

<script type='text/javascript' src='assets/js/enquire.js'></script> 
<script type='text/javascript' src='assets/js/jquery.cookie.js'></script> 
<script type='text/javascript' src='assets/js/jquery.nicescroll.min.js'></script> 
<script type='text/javascript' src='assets/plugins/codeprettifier/prettify.js'></script> 
<script type='text/javascript' src='assets/plugins/easypiechart/jquery.easypiechart.min.js'></script> 
<script type='text/javascript' src='assets/plugins/form-multiselect/js/jquery.multi-select.min.js'></script> 
<script type='text/javascript' src='assets/plugins/sparklines/jquery.sparklines.min.js'></script> 
<script type='text/javascript' src='assets/plugins/form-toggle/toggle.min.js'></script> 
<script type='text/javascript' src='assets/js/placeholdr.js'></script> 
<script type='text/javascript' src='assets/js/application.js'></script> 
<script type='text/javascript' src='assets/plugins/bootbox/bootbox.min.js'></script> 
<script type='text/javascript' src='assets/plugins/form-daterangepicker/daterangepicker.min.js'></script> 
<script type='text/javascript' src='assets/plugins/form-datepicker/js/bootstrap-datepicker.js'></script> 
<script type='text/javascript' src='assets/plugins/form-daterangepicker/moment.min.js'></script> 

<script type='text/javascript' src='assets/demo/demo.js'></script> 

<script type='text/javascript' src='assets/js/jquery.dataTables.min.js'></script> 
<script type='text/javascript' src='assets/js/dataTables.bootstrap.min.js'></script> 


</body>
</html>