<? include("connect.php");  ?>
<?
	 
	$status = $_REQUEST['status'];
	//$status = $_REQUEST['status'];
	//$yyear = $_REQUEST['yyear'];
	//$mmonth = $_REQUEST['mmonth'];

$yyear= $_GET['yyear'];	
$mmonth = $_GET['mmonth'];	
$ddate = $_GET['ddate'];
$tsite = "HQ";
	
	 
	
function get_minutes ( $start, $end ) {  

   while ( strtotime($start) <= strtotime($end) ) {  
       $minutes[] = date("H:i:s", strtotime( "$start" ) );  
       $start = date("H:i:s", strtotime( "$start + 30 mins")) ;      
   }  
   return $minutes;  
}  


	 
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>I-Wis HRS : Daily Report HQ</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="I-Wis">
	<meta name="author" content="The Red Team">

    <!-- <link href="assets/less/styles.less" rel="stylesheet/less" media="all">  -->
    <link rel="stylesheet" href="assets/css/styles.css?=140">
   <!-- <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600' rel='stylesheet' type='text/css'>-->

    <link href='assets/demo/variations/default.css' rel='stylesheet' type='text/css' media='all' id='styleswitcher'> 
    <link href='assets/demo/variations/default.css' rel='stylesheet' type='text/css' media='all' id='headerswitcher'> 
     
	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries. Placeholdr.js enables the placeholder attribute -->
	<!--[if lt IE 9]>
        <link rel="stylesheet" href="assets/css/ie8.css">
		<script type="text/javascript" src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/respond.js/1.1.0/respond.min.js"></script>
        <script type="text/javascript" src="assets/plugins/charts-flot/excanvas.min.js"></script>
	<![endif]-->

	<!-- The following CSS are included as plugins and can be removed if unused-->

<link rel='stylesheet' type='text/css' href='jquery-ui-timepicker-0.3.3/jquery.ui.timepicker.css' /> 
<link rel='stylesheet' type='text/css' href='assets/plugins/form-daterangepicker/daterangepicker-bs3.css' /> 
<link rel='stylesheet' type='text/css' href='assets/js/jqueryui.css' /> 
<link rel='stylesheet' type='text/css' href='assets/plugins/codeprettifier/prettify.css' /> 
<link rel='stylesheet' type='text/css' href='assets/plugins/form-toggle/toggles.css' /> 
<script type="text/javascript" src="assets/js/jquery-1.10.2.min.js"></script>
<!--<script type="text/javascript" src="assets/js/less.js"></script>-->
<style>


ul#main-container{
padding:0px;
margin:0px;
}
ul#main-container li{
list-style:none;
display:inline-block;
border-bottom:dotted 2px #000;
}
ul#main-container div.table{
float:left;
display:table;
background:url(bg.png) no-repeat;
width:35px;
height:27px;
margin:0px 0px;

}
ul#main-container div.row{
display:table-row;
}
ul#main-container div.cell{
clear:both;
font:12px Tahoma;
display:table-cell;

}
ul#main-container div.top{
text-align:left;
vertical-align:top;
padding-left:1px;

}
ul#main-container div.bottom{
text-align:right;
vertical-align:bottom;
padding-right:1px;
}
</style>
<style>
.loader {
  border: 16px solid #f3f3f3;
  border-radius: 50%;
  border-top: 16px solid #3498db;
  width: 60px;
  height: 60px;
  -webkit-animation: spin 2s linear infinite; /* Safari */
  animation: spin 2s linear infinite;
}

/* Safari */
@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>
<script>

$(function() {
    $(".loader").hide();
	<?
	if($mmonth!=''){
		?>
		showatt_month();
		<?
		}
	?>
	// requires jquery library
 jQuery(".main-table").clone(true).appendTo('#table-scroll').addClass('clone');   
	
	});
	


	
function showatt_month(){

    $("#xpane").html("");
    $(".loader").show();
	var tsite2 ='<?=$tsite?>';
	var mmonth ='<?=$mmonth?>';
	var yyear ='<?=$yyear?>';
	var ddate ='<?=$ddate?>';
	
	$.post("getajax_daily_report.php", { status:"show_daily_hq",tsite2:tsite2,ddate:ddate,mmonth:mmonth,yyear:yyear,
	sid: Math.random() },
   function(data) {
	 $("#xpane").html(data);
     $(".loader").hide();
	   });
      
}

function exportatt_month(){

	var tsite =$("#tsite").val();
	var paycode =$("#paycode").val();
	var tsite2 =$("#tsite2").val();
	var month =$("#month").val();
	window.location='getajax_report_att.php?status=exportatt_month&tsite2='+tsite2+'&paycode='+paycode+'&month='+month;
      
	}
	
		function show_att(report_date){
            $("#show_detail_head").html("TIME ATTENDANCE.");
            $("#show_detail_body").html("Loading....");
            $("#myModal_show_detail").modal();
            

            $.post( "getajax_daily_report_hq.php", { 
                status: "show_att",
                report_date : report_date
            })
            .done(function( data ) { 
                $("#show_detail_body").html(data);
            });
        }
        function show_ot(report_date){
            $("#show_detail_head").html("OVERTIME Work.");
            $("#show_detail_body").html("Loading....");
            $("#myModal_show_detail").modal();
            

            $.post( "getajax_daily_report_hq.php", { 
                status: "show_ot",
                report_date : report_date
            })
            .done(function( data ) { 
                $("#show_detail_body").html(data);
            });
            
        }
        function show_receive_sab(report_date){
            $("#show_detail_head").html("SAB Receive");
            $("#show_detail_body").html("Loading....");
            $("#myModal_show_detail").modal();
            

            $.post( "getajax_daily_report_hq.php", { 
                status: "show_receive_sab",
                report_date : report_date
            })
            .done(function( data ) { 
                $("#show_detail_body").html(data);
            });
            
        }
        function show_packing_sab(report_date){
            $("#show_detail_head").html("SAB Packing");
            $("#show_detail_body").html("Loading....");
            $("#myModal_show_detail").modal();
            

            $.post( "getajax_daily_report_hq.php", { 
                status: "show_packing_sab",
                report_date : report_date
            })
            .done(function( data ) { 
                $("#show_detail_body").html(data);
            });
            
        }
        function show_loading_sab(report_date){
            $("#show_detail_head").html("SAB Loading");
            $("#show_detail_body").html("Loading....");
            $("#myModal_show_detail").modal();
            

            $.post( "getajax_daily_report_hq.php", { 
                status: "show_loading_sab",
                report_date : report_date
            })
            .done(function( data ) { 
                $("#show_detail_body").html(data);
            });
            
        }
        function show_receive_topre(report_date){
            $("#show_detail_head").html("Topre Receive");
            $("#show_detail_body").html("Loading....");
            $("#myModal_show_detail").modal();
            

            $.post( "getajax_daily_report_hq.php", { 
                status: "show_receive_topre",
                report_date : report_date
            })
            .done(function( data ) { 
                $("#show_detail_body").html(data);
            });
            
        }
        function show_packing_topre(report_date){
            $("#show_detail_head").html("Topre Packing");
            $("#show_detail_body").html("Loading....");
            $("#myModal_show_detail").modal();
            

            $.post( "getajax_daily_report_hq.php", { 
                status: "show_packing_topre",
                report_date : report_date
            })
            .done(function( data ) { 
                $("#show_detail_body").html(data);
            });
            
        }
        function show_loading_topre(report_date){
            $("#show_detail_head").html("Topre Loading");
            $("#show_detail_body").html("Loading....");
            $("#myModal_show_detail").modal();
            

            $.post( "getajax_daily_report_hq.php", { 
                status: "show_loading_topre",
                report_date : report_date
            })
            .done(function( data ) { 
                $("#show_detail_body").html(data);
            });
            
        }
        function show_receive_nhk(report_date){
            $("#show_detail_head").html("NHK Receive");
            $("#show_detail_body").html("Loading....");
            $("#myModal_show_detail").modal();
            

            $.post( "getajax_daily_report_hq.php", { 
                status: "show_receive_nhk",
                report_date : report_date
            })
            .done(function( data ) { 
                $("#show_detail_body").html(data);
            });
            
        }
        function show_packing_nhk(report_date){
            $("#show_detail_head").html("NHK Packing");
            $("#show_detail_body").html("Loading....");
            $("#myModal_show_detail").modal();
            

            $.post( "getajax_daily_report_hq.php", { 
                status: "show_packing_nhk",
                report_date : report_date
            })
            .done(function( data ) { 
                $("#show_detail_body").html(data);
            });
            
        }
        function show_loading_nhk(report_date){
            $("#show_detail_head").html("NHK Loading");
            $("#show_detail_body").html("Loading....");
            $("#myModal_show_detail").modal();
            

            $.post( "getajax_daily_report_hq.php", { 
                status: "show_loading_nhk",
                report_date : report_date
            })
            .done(function( data ) { 
                $("#show_detail_body").html(data);
            });
            
        }
        function show_receive_rack_sab(report_date){
            $("#show_detail_head").html("Rack Receive SAB");
            $("#show_detail_body").html("Loading....");
            $("#myModal_show_detail").modal();
            

            $.post( "getajax_daily_report_hq.php", { 
                status: "show_receive_rack_sab",
                report_date : report_date
            })
            .done(function( data ) { 
                $("#show_detail_body").html(data);
            });
            
        }
        function show_receive_rack_topre(report_date){
            $("#show_detail_head").html("Rack Receive Topre");
            $("#show_detail_body").html("Loading....");
            $("#myModal_show_detail").modal();
            

            $.post( "getajax_daily_report_hq.php", { 
                status: "show_receive_rack_topre",
                report_date : report_date
            })
            .done(function( data ) { 
                $("#show_detail_body").html(data);
            });
            
        }
        function show_trading_tts(report_date){
            $("#show_detail_head").html("Trading TTS");
            $("#show_detail_body").html("Loading....");
            $("#myModal_show_detail").modal();
            

            $.post( "getajax_daily_report_hq.php", { 
                status: "show_trading_tts",
                report_date : report_date
            })
            .done(function( data ) { 
                $("#show_detail_body").html(data);
            });
            
        }
        function show_trading_brose(report_date){
            $("#show_detail_head").html("Trading Brose");
            $("#show_detail_body").html("Loading....");
            $("#myModal_show_detail").modal();
            

            $.post( "getajax_daily_report_hq.php", { 
                status: "show_trading_brose",
                report_date : report_date
            })
            .done(function( data ) { 
                $("#show_detail_body").html(data);
            });
            
        }
        function show_trading_smrc(report_date){
            $("#show_detail_head").html("Trading SMRC");
            $("#show_detail_body").html("Loading....");
            $("#myModal_show_detail").modal();
            

            $.post( "getajax_daily_report_hq.php", { 
                status: "show_trading_smrc",
                report_date : report_date
            })
            .done(function( data ) { 
                $("#show_detail_body").html(data);
            });
            
        }
        function show_trading_gkn(report_date){
            $("#show_detail_head").html("Trading GKN");
            $("#show_detail_body").html("Loading....");
            $("#myModal_show_detail").modal();
            

            $.post( "getajax_daily_report_hq.php", { 
                status: "show_trading_gkn",
                report_date : report_date
            })
            .done(function( data ) { 
                $("#show_detail_body").html(data);
            });
            
        }
        function show_trading_sp(report_date){
            $("#show_detail_head").html("Trading Orther Special Job.");
            $("#show_detail_body").html("Loading....");
            $("#myModal_show_detail").modal();
            

            $.post( "getajax_daily_report_hq.php", { 
                status: "show_trading_sp",
                report_date : report_date
            })
            .done(function( data ) { 
                $("#show_detail_body").html(data);
            });
            
        }
        function show_qa_sab_ng(report_date){
            $("#show_detail_head").html("NG Internal SAB.");
            $("#show_detail_body").html("Loading....");
            $("#myModal_show_detail").modal();
            

            $.post( "getajax_daily_report_hq.php", { 
                status: "show_qa_sab_ng",
                report_date : report_date
            })
            .done(function( data ) { 
                $("#show_detail_body").html(data);
            });
            
        }
        function show_qa_topre_ng(report_date){
            $("#show_detail_head").html("NG Internal Topre.");
            $("#show_detail_body").html("Loading....");
            $("#myModal_show_detail").modal();
            

            $.post( "getajax_daily_report_hq.php", { 
                status: "show_qa_topre_ng",
                report_date : report_date
            })
            .done(function( data ) { 
                $("#show_detail_body").html(data);
            });
            
        }
        function show_return_rack_sab(report_date){
            $("#show_detail_head").html("Status Racks SAB NG Return");
            $("#show_detail_body").html("Loading....");
            $("#myModal_show_detail").modal();
            

            $.post( "getajax_daily_report_hq.php", { 
                status: "show_return_rack_sab",
                report_date : report_date
            })
            .done(function( data ) { 
                $("#show_detail_body").html(data);
            });
            
        }
        function show_return_rack_topre(report_date){
            $("#show_detail_head").html("Status Racks Topre NG Return");
            $("#show_detail_body").html("Loading....");
            $("#myModal_show_detail").modal();
            

            $.post( "getajax_daily_report_hq.php", { 
                status: "show_return_rack_topre",
                report_date : report_date
            })
            .done(function( data ) { 
                $("#show_detail_body").html(data);
            });
            
        }


	
	
</script>
</head>

<body bgcolor="#FFFFFF" style="padding-top: 10px;">

	<!-- Modal -->
			
	<div class="modal fade" id="myModal_show_detail" role="dialog">
        <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="show_detail_head">Header</h4>
                </div>
                <div class="modal-body" id="show_detail_body">
                    BODY
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>
    <!-- Modal -->
    

    

   
			

		
			
	
		



			
                        



<?
if($status==''){
	
	
		
					
	?>
    
     
   
    <div class="table-responsive">
        

    <div   id="xpane">
  	
     	</div> <!-- container -->
     </div>
     
    
     
     <center> <div class="loader"></div></center>
		<?
        }
		
		
		
		?>	


	  

					 



			



	
	

    



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
<script type='text/javascript' src='assets/plugins/sparklines/jquery.sparklines.min.js'></script> 
<script type='text/javascript' src='assets/plugins/form-toggle/toggle.min.js'></script> 
<script type='text/javascript' src='assets/js/placeholdr.js'></script> 
<script type='text/javascript' src='assets/js/application.js'></script> 
<script type='text/javascript' src='assets/plugins/bootbox/bootbox.min.js'></script> 
<script type='text/javascript' src='jquery-ui-timepicker-0.3.3/jquery.ui.timepicker.js'></script> 
<script type='text/javascript' src='assets/plugins/form-daterangepicker/daterangepicker.min.js'></script> 
<script type='text/javascript' src='assets/plugins/bootbox/bootbox.min.js'></script>
<script type='text/javascript' src='assets/plugins/form-datepicker/js/bootstrap-datepicker.js'></script> 
<script type='text/javascript' src='assets/plugins/form-typeahead/typeahead.min.js'></script> 




</body>
</html>