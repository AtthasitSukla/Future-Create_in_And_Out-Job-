<? include("connect.php");  
//error_reporting(0);
?>
<?
	 
	//echo cal_days_in_month(CAL_GREGORIAN, 11, 2009); 
	$status = $_REQUEST['status'];
	$paycodeyear = $_REQUEST['paycodeyear'];
	$empno = $_REQUEST['empno'];
	$tsite = $_REQUEST['tsite'];


		//$empno='59014';
		
		
	
	function DateDiff($strDate1,$strDate2)
	 {
				return (strtotime($strDate2) - strtotime($strDate1))/  ( 60 * 60 * 24 );  // 1 day = 60*60*24
	 }
	 function TimeDiff($strTime1,$strTime2)
	 {
				return (strtotime($strTime2) - strtotime($strTime1))/  ( 60 * 60 ); // 1 Hour =  60*60
	 }
	 function DateTimeDiff($strDateTime1,$strDateTime2)
	 {
				return (strtotime($strDateTime2) - strtotime($strDateTime1))/  ( 60 * 60  ); // 1 min =  60*60
	 }
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>I-Wis HQ : Update</title>
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

<link rel='stylesheet' type='text/css' href='assets/plugins/codeprettifier/prettify.css' /> 
<link rel='stylesheet' type='text/css' href='assets/plugins/form-multiselect/css/multi-select.css' /> 
<link rel='stylesheet' type='text/css' href='assets/plugins/form-toggle/toggles.css' /> 
<script type="text/javascript" src="assets/js/jquery-1.10.2.min.js"></script>
<!--<script type="text/javascript" src="assets/js/less.js"></script>-->

<script>

$(function() {

	
	});
	
	
function showpaycode(){
	var paycodeyear = $("#paycodeyear").val();
	var site = $("#site").val();
	var empno = $("#empno").val();
	window.location = 'ytd_summary.php?paycodeyear='+paycodeyear+'&empno='+empno+'&tsite='+site;
	}


	function showemponsite(){
		var site = $("#site").val();
		var paycode = $("#paycode").val();
		$.post( "getajax_ytd_summary.php", { 	
					status: "showemponsite", 
					tsite : site,
					paycode : paycode,
					sid: Math.random() 
					})
					.done(function( data ) {
					
				//	alert(data);
					
					var aa =data;
					var bb = aa.split("###",150);
					
					
					
					var select, i, option;

					select = document.getElementById( 'empno' );
					select.options.length = 0;
					for ( i = 0; i < bb.length-1; i ++ ) {
						
						 cc = bb[i].split("@@@",150);
						
						option = document.createElement( 'option' );
						option.value = cc[0];
						option.text = cc[1];
						select.add( option );
					}
				
				 });
		}
	
	
	function update_ytdsummary(fieldx,empno,paycode,id){
		var fieldx_value = $("#"+fieldx+id).val();
			$.post( "getajax_ytd_summary.php", { 	
					status: "update_ytdsummary", 
					fieldx : fieldx,
					fieldx_value:fieldx_value,
					empno:empno,
					paycode : paycode,
					sid: Math.random() 
					})
					.done(function( data ) {
				alert('Save Complete. '+data);
				//	var aa =data;
				//	var bb = aa.split("###",150);
					
					
					
				
				 });
		}
	function update_ytdsummary2(fieldx,empno,paycodeyear){
		var fieldx_value = $("#"+fieldx).val();
		$.post( "getajax_ytd_summary.php", { 	
					status: "update_ytdsummary2", 
					fieldx : fieldx,
					fieldx_value:fieldx_value,
					empno:empno,
					paycodeyear : paycodeyear,
					sid: Math.random() 
					})
					.done(function( data ) {
					alert(data);
					//var aa =data;
					//var bb = aa.split("###",150);
					
					
					
				
				 });
		}
	
</script>
</head>

<body class=" ">


    <div id="headerbar">
        <div class="container">
            <div class="row">
                <div class="col-xs-6 col-sm-2">
                    <a href="#" class="shortcut-tiles tiles-brown">
                        <div class="tiles-body">
                            <div class="pull-left"><i class="fa fa-pencil"></i></div>
                        </div>
                        <div class="tiles-footer">
                            Create Post
                        </div>
                    </a>
                </div>
                <div class="col-xs-6 col-sm-2">
                    <a href="#" class="shortcut-tiles tiles-grape">
                        <div class="tiles-body">
                            <div class="pull-left"><i class="fa fa-group"></i></div>
                            <div class="pull-right"><span class="badge">2</span></div>
                        </div>
                        <div class="tiles-footer">
                            Contacts
                        </div>
                    </a>
                </div>
                <div class="col-xs-6 col-sm-2">
                    <a href="#" class="shortcut-tiles tiles-primary">
                        <div class="tiles-body">
                            <div class="pull-left"><i class="fa fa-envelope-o"></i></div>
                            <div class="pull-right"><span class="badge">10</span></div>
                        </div>
                        <div class="tiles-footer">
                            Messages
                        </div>
                    </a>
                </div>
                <div class="col-xs-6 col-sm-2">
                    <a href="#" class="shortcut-tiles tiles-inverse">
                        <div class="tiles-body">
                            <div class="pull-left"><i class="fa fa-camera"></i></div>
                            <div class="pull-right"><span class="badge">3</span></div>
                        </div>
                        <div class="tiles-footer">
                            Gallery
                        </div>
                    </a>
                </div>

                <div class="col-xs-6 col-sm-2">
                    <a href="#" class="shortcut-tiles tiles-midnightblue">
                        <div class="tiles-body">
                            <div class="pull-left"><i class="fa fa-cog"></i></div>
                        </div>
                        <div class="tiles-footer">
                            Settings
                        </div>
                    </a>
                </div>
                <div class="col-xs-6 col-sm-2">
                    <a href="#" class="shortcut-tiles tiles-orange">
                        <div class="tiles-body">
                            <div class="pull-left"><i class="fa fa-wrench"></i></div>
                        </div>
                        <div class="tiles-footer">
                            Plugins
                        </div>
                    </a>
                </div>
                            
            </div>
        </div>
    </div>

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



			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-primary">
						
						<div class="panel-body">
                        



<?
if($status==''){
	
	?>
    <table align="center" width="100%" border="0" cellspacing="2" cellpadding="0" >
  <tr >
  <td width="6%" height="40" align="right"><strong>PayCode Year</strong></td>
  <td width="19%"><select id="paycodeyear" class="form-control"  name="paycodeyear"   style="width:200px;">
     <option value="">Select</option>
    <?
    	$select0="SELECT distinct paycodeyear from tbpaycode order by paycodeyear asc ";
	$re0=mssql_query($select0);
	while($row0=mssql_fetch_array($re0)){
		?>
		 <option value="<?=$row0['paycodeyear']?>" <?
         if($paycodeyear==$row0['paycodeyear']){
			 ?> selected<?
			 }
		 ?>><?=$row0['paycodeyear']?></option>
		<?
		}
	?>
     </select></td>
     <td width="3%" height="40" align="right"><strong>Site</strong></td>
     <td width="19%"><select id="site" class="form-control"  name="site"   style="width:200px;" onChange="showemponsite();">
     <option value="">Select</option>
    <?
    	$select0="SELECT site from  tbsite ";
	$re0=mssql_query($select0);
	while($row0=mssql_fetch_array($re0)){
		?>
		 <option value="<?=$row0['site']?>" <?
         if($tsite==$row0['site']){
			 ?> selected<?
			 }
		 ?>><?=$row0['site']?></option>
		<?
		}
	?>
     </select></td>
    <td width="7%" height="40" align="right"><strong>Employee Number</strong></td>
   <td width="27%"><select id="empno" class="form-control"  name="empno"   style="width:280px;">
     <option value="">Select</option>
   <?
	
	if($tsite!=''){
    $select0="SELECT empno,firstname,lastname from tbemployee where site='".$tsite."' and emp_level in('3','4','5','6','7') and delstatus='0' order by empno asc ";
	$re0=mssql_query($select0);
	while($row0=mssql_fetch_array($re0)){
		?>
		 <option value="<?=$row0['empno']?>" <?
         if($empno==$row0['empno']){
			 ?> selected<?
			 }
		 ?>><?=$site?> <?=$row0['empno']?> <?=iconv("tis-620", "utf-8", $row0['firstname'] );?> <?=iconv("tis-620", "utf-8", $row0['lastname']);?> <?
  
		 ?></option>
		<?
		
			}
		}
	?>
		
     </select></td>
     <td width="8%"><input type="button" value="Select" onClick="showpaycode();"></td>
     <td width="11%" align="right">
   
     
     </td>
    </tr></table>
    
	<table align="center" width="100%" border="0" cellspacing="2" cellpadding="0" class="table table-striped table-bordered datatables" id="example">
    <tr >
        <td width="96" align="center" bgcolor="#CCCCCC"><strong>Empno</strong></td>
        <td width="98"  align="center" bgcolor="#CCCCCC"><strong>PayCode</strong></td>
        <td width="129" align="center" bgcolor="#CCCCCC"><strong>ytd_income</strong></td>
        <td width="116" align="center" bgcolor="#CCCCCC"><strong>ytd_tax</strong></td>
         <td width="57" align="center" bgcolor="#CCCCCC"><strong>ytd_social_in </strong></td>
    <td width="53" align="center" bgcolor="#CCCCCC"><strong>ytd_provident</strong></td>
    <td width="84" align="center" bgcolor="#CCCCCC"><strong>paystatus</strong></td>
    
       
      </tr>
    <?
    										$sql = "select * from  tbsalary WHERE   (paycodeyear = '$paycodeyear') AND (empno = '$empno') order by id asc";
                                            $re = mssql_query($sql);
											$num = mssql_num_rows($re);
											if($num>0){
                                            while($row = mssql_fetch_array($re)){
													?>
													 <tr >
        <td width="96" align="center"><?=$row['empno']?></td>
        <td width="98"  align="center"><?=$row['paycode']?></td>
        <td width="129" align="center"><input type="text" id="ytd_income<?=$row['id']?>" value="<?=$row['ytd_income']?>" onChange="update_ytdsummary('ytd_income','<?=$empno?>','<?=$row['paycode']?>','<?=$row['id']?>');"></td>
        <td width="116" align="center"><input type="text" id="ytd_tax<?=$row['id']?>" value="<?=$row['ytd_tax']?>" onChange="update_ytdsummary('ytd_tax','<?=$empno?>','<?=$row['paycode']?>','<?=$row['id']?>');"></td>
         <td width="57" align="center" ><input type="text" id="ytd_social_in<?=$row['id']?>" value="<?=$row['ytd_social_in']?>" onChange="update_ytdsummary('ytd_social_in','<?=$empno?>','<?=$row['paycode']?>','<?=$row['id']?>');"></td>
    <td width="53" align="center"><input type="text" id="ytd_provident<?=$row['id']?>" value="<?=$row['ytd_provident']?>" onChange="update_ytdsummary('ytd_provident','<?=$empno?>','<?=$row['paycode']?>','<?=$row['id']?>');"></td>
    <td width="84" align="center"><?=$row['paystatus']?></td>
    
       
      </tr>
				  <?
												}
												}
	?>
    </table>
    
    
    
    <table width="70%" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center" bgcolor="#CCCCCC">paycode year</td>
    <td align="center" bgcolor="#CCCCCC">ytd_income</td>
    <td align="center" bgcolor="#CCCCCC">ytd_social_in</td>
    <td align="center" bgcolor="#CCCCCC">ytd_provident</td>
    <td align="center" bgcolor="#CCCCCC">ytd_tax</td>
    </tr>
    
    <?
    										$sql = "select * from  tbytdsummary where paycodeyear='$paycodeyear' and empno='$empno'";
                                            $re = mssql_query($sql);
											$num = mssql_num_rows($re);
											if($num>0){
                                         	  $row = mssql_fetch_array($re);
												
	?>
  <tr>
    <td align="center"><?=$paycodeyear?></td>
    <td align="center"><input type="text" id="ytd_income" value="<?=$row['ytd_income']?>" onChange="update_ytdsummary2('ytd_income','<?=$empno?>','<?=$paycodeyear?>');"></td>
    <td align="center"><input type="text" id="ytd_social_in" value="<?=$row['ytd_social_in']?>" onChange="update_ytdsummary2('ytd_social_in','<?=$empno?>','<?=$paycodeyear?>');"></td>
    <td align="center"><input type="text" id="ytd_provident" value="<?=$row['ytd_provident']?>" onChange="update_ytdsummary2('ytd_provident','<?=$empno?>','<?=$paycodeyear?>');"></td>
    <td align="center"><input type="text" id="ytd_tax" value="<?=$row['ytd_tax']?>"></td>
    </tr>
</table>
	<?
    }
	?>
    
  <?
}
  ?>
 
			


	  

					  </div>
					</div>
				</div>
			</div>



			



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

<script type='text/javascript' src='assets/demo/demo.js'></script> 


</body>
</html>